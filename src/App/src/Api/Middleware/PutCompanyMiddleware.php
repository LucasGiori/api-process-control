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
use Infrastructure\Domain\Exceptions\BaseException;
use Infrastructure\Domain\Exceptions\SymfonyValidationException;
use Infrastructure\Service\Logs\Sentry\SentryService;
use Infrastructure\Utils\Serializer\DeserializationInterface;
use Infrastructure\Utils\Validation\ValidationArrayKeys;
use Infrastructure\Utils\Validation\ValidationBody;
use Infrastructure\Utils\Validation\ValidationSymfonyInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

class PutCompanyMiddleware implements MiddlewareInterface
{
    private Throwable|null $exception = null;

    public function __construct(
        private DeserializationInterface $deserialization,
        private ValidationSymfonyInterface $validation,
        private CityServiceInterface $cityServiceInteface,
        private SituationServiceInterface $situationServiceInterface,
        private CompanyTypeServiceInterface $companyTypeServiceInterface,
        private CompanyServiceInterface $companyServiceInterface
    ){}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $id = intval($request->getAttribute("id"));

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
                fieldsToValidate: ValidationArrayKeys::validJsonAndReturnArrayKeys(json: $body),
                entityOrObject: $companyRequest
            );

            if (!empty($messageError)) {
                throw new SymfonyValidationException(message: $messageError, statusCode: StatusHttp::EXPECTATION_FAILED);
            }

            $companyEntity = $this->companyServiceInterface->findById(id: $id);
            NotNull::validate(
                value: $companyEntity,
                statusCode: StatusHttp::NOT_FOUND,
                message: "Não existe nenhuma emrpesa com o identificador informado"
            );

            if(!is_null($companyRequest?->getSituation()?->getId())){
                $situation = $this->situationServiceInterface->findById(id: $companyRequest->getSituation()->getId());
                NotNull::validate(value: $situation, message: "Não existe situação com este identificador");

                $companyEntity->setSituation(situation: $situation);
            }

            if(!is_null($companyRequest?->getCompanyType()?->getId())) {
                $companyType = $this->companyTypeServiceInterface->findById(id: $companyRequest->getCompanyType()->getId());
                NotNull::validate(value: $companyType, message: "Nao existe tipo de empresa com esse identificador");

                $companyEntity->setCompanyType(companyType: $companyType);
            }

            if(!is_null($companyRequest?->getCity()?->getId())) {
                $city = $this->cityServiceInteface->findById(id: $companyRequest->getCity()->getId());
                NotNull::validate(value: $city, message: "Não existe cidade com esse identificador!");

                $companyEntity->setCity(city: $city);
            }

            $companyEntity->setUpdatedAt(updatedAt: new DateTime());
            $companyEntity->setCompanyName(companyName: $companyRequest?->getCompanyName() ?? $companyEntity->getCompanyName());
            $companyEntity->setNameFantasy(nameFantasy: $companyRequest?->getNameFantasy() ?? $companyEntity->getNameFantasy());

            return $handler->handle($request->withAttribute("company", $companyEntity));
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
