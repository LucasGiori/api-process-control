<?php


namespace App\Api\Middleware;


use ApiCore\Exception\ExceptionCore;
use ApiCore\Response\JsonResponseCore;
use App\Entity\Company;
use App\Service\CityServiceInterface;
use App\Service\CompanyServiceInterface;
use App\Service\CompanyTypeServiceInterface;
use App\Service\SituationServiceInterface;
use App\Utils\Constants;
use App\Utils\Validation\NotNull;
use DateTime;
use Http\StatusHttp;
use Infrastructure\Domain\Exceptions\SymfonyValidationException;
use Infrastructure\Domain\Exceptions\ValidationException;
use Infrastructure\Service\Logs\Sentry\SentryService;
use Infrastructure\Utils\Serializer\DeserializationInterface;
use Infrastructure\Utils\Validation\ValidationBody;
use Infrastructure\Utils\Validation\ValidationSymfonyInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

class PostCompanyMiddleware implements MiddlewareInterface
{
    private Throwable|null $exception = null;

    public function __construct(
        private DeserializationInterface $deserialization,
        private ValidationSymfonyInterface $validation,
        private CityServiceInterface $cityServiceInteface,
        private SituationServiceInterface $situationServiceInterface,
        private CompanyTypeServiceInterface $companyTypeServiceInterface
    ){}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $body = $request->getBody()->getContents();

            ValidationBody::emptyBody(body: $body);

            /** @var Company $companyRequest */
            $companyRequest = $this->deserialization->deserialize(
                body: $body,
                entityName: Company::class,
                format: "json",
                messageError: "erro ao tentar definir dados da requisição na entidade company!"
            );

            $messageError = $this->validation->validateEntitySpecificFields(
                fieldsToValidate: ["nameFantasy", "companyName", "city","companyType","cnpj"],
                entityOrObject: $companyRequest
            );

            if (!empty($messageError)) {
                throw new SymfonyValidationException(
                    message: $messageError,
                    statusCode: StatusHttp::EXPECTATION_FAILED,
                );
            }

            $situation = $this->situationServiceInterface->findById(id: Constants::SITUATION_ACTIVE);

            $companyType = $this->companyTypeServiceInterface->findById(id: $companyRequest->getCompanyType()->getId());
            NotNull::validate(value: $companyType,message: "Não existe nenhum tipo de empresa com este identificador!");

            $city = $this->cityServiceInteface->findById(id: $companyRequest->getCity()->getId());
            NotNull::validate(value: $city,message: "Não existe nenhuma cidade com este identificador!");

            $now = new DateTime();
            $companyRequest->setCreatedAt(createdAt: $now);
            $companyRequest->setUpdatedAt(updatedAt: $now);
            $companyRequest->setSituation(situation: $situation);
            $companyRequest->setCompanyType(companyType: $companyType);
            $companyRequest->setCity(city: $city);

            return $handler->handle($request->withAttribute("company", $companyRequest));
        } catch (Throwable $e) {
            $this->exception = $e;
            $code = $e->getCode() != 0 ? $e->getCode() : StatusHttp::INTERNAL_SERVER_ERROR;
            $error = $e instanceof ExceptionCore ? $e->getCustomError() : $e->getMessage();

            return new JsonResponseCore(data: $error, statusCode: $code);
        } finally {
            (new SentryService())->executeSendLogException(exception: $this->exception);
        }
    }
}
