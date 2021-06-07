<?php


namespace App\Api\Middleware;


use ApiCore\Exception\ExceptionCore;
use ApiCore\Response\JsonResponseCore;
use App\Entity\Attorney;
use App\Service\CityServiceInterface;
use App\Service\CompanyServiceInterface;
use App\Service\SituationServiceInterface;
use App\Utils\Constants;
use App\Utils\Validation\Cpf;
use App\Utils\Validation\NotNull;
use DateTime;
use Http\StatusHttp;
use Infrastructure\Domain\Exceptions\SymfonyValidationException;
use Infrastructure\Service\Logs\Sentry\SentryService;
use Infrastructure\Utils\Serializer\DeserializationInterface;
use Infrastructure\Utils\Validation\ValidationBody;
use Infrastructure\Utils\Validation\ValidationSymfonyInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

class PostAttorneyMiddleware implements MiddlewareInterface
{
    private Throwable|null $exception = null;

    public function __construct(
        private DeserializationInterface $deserialization,
        private ValidationSymfonyInterface $validation,
        private CityServiceInterface $cityServiceInterface,
        private SituationServiceInterface $situationServiceInterface,
        private CompanyServiceInterface $companyServiceInterface
    ){}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $body = $request->getBody()->getContents();

            ValidationBody::emptyBody(body: $body);

            /** @var Attorney $attorneyRequest */
            $attorneyRequest = $this->deserialization->deserialize(
                body: $body,
                entityName: Attorney::class,
                format: "json",
                messageError: "erro ao tentar definir dados da requisição na entidade attorney!"
            );

            $messageError = $this->validation->validateEntitySpecificFields(
                fieldsToValidate: ["name", "cpf", "oab", "telefone", "email", "office", "city"],
                entityOrObject: $attorneyRequest
            );

            if (!empty($messageError)) {
                throw new SymfonyValidationException(
                    message: $messageError,
                    statusCode: StatusHttp::EXPECTATION_FAILED,
                );
            }

            $situation = $this->situationServiceInterface->findById(id: Constants::SITUATION_ACTIVE);

            $office = $this->companyServiceInterface->findById(id: $attorneyRequest->getOffice()->getId());
            NotNull::validate(value: $office, message: "Não existe nenhum escritório com este identificador!");

            $city = $this->cityServiceInterface->findById(id: $attorneyRequest->getCity()->getId());
            NotNull::validate(value: $city,message: "Não existe nenhuma cidade com este identificador!");

            //Validate Cpf is Valid:
            new Cpf(cpf: $attorneyRequest->getCpf());

            $attorneyRequest->setCreatedAt(createdAt: new DateTime());
            $attorneyRequest->setSituation(situation: $situation);
            $attorneyRequest->setOffice(office: $office);
            $attorneyRequest->setCity(city: $city);

            return $handler->handle($request->withAttribute("attorney", $attorneyRequest));
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
