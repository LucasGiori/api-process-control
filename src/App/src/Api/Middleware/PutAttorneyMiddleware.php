<?php


namespace App\Api\Middleware;


use ApiCore\Exception\ExceptionCore;
use ApiCore\Response\JsonResponseCore;
use App\Entity\Attorney;
use App\Service\AttorneyServiceInterface;
use App\Service\CityServiceInterface;
use App\Service\CompanyServiceInterface;
use App\Service\SituationServiceInterface;
use App\Utils\Validation\NotNull;
use Http\StatusHttp;
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

class PutAttorneyMiddleware implements MiddlewareInterface
{
    private Throwable|null $exception = null;

    public function __construct(
        private DeserializationInterface $deserialization,
        private ValidationSymfonyInterface $validation,
        private CityServiceInterface $cityServiceInteface,
        private SituationServiceInterface $situationServiceInterface,
        private CompanyServiceInterface $companyServiceInterface,
        private AttorneyServiceInterface $attorneyServiceInterface
    ){}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $id = intval($request->getAttribute("id"));
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
                fieldsToValidate: ValidationArrayKeys::validJsonAndReturnArrayKeys(json: $body),
                entityOrObject: $attorneyRequest
            );

            if (!empty($messageError)) {
                throw new SymfonyValidationException(
                    message: $messageError,
                    statusCode: StatusHttp::EXPECTATION_FAILED,
                );
            }

            $attorneyEntity = $this->attorneyServiceInterface->findById(id: $id);
            NotNull::validate(
                value: $attorneyEntity,
                statusCode: StatusHttp::NOT_FOUND,
                message: "Não existe nenhum advogado com este identificador!"
            );

            if(!is_null($attorneyRequest?->getSituation()?->getId())){
                $situation = $this->situationServiceInterface->findById(id: $attorneyRequest->getSituation()->getId());
                NotNull::validate(value: $situation, message: "Não existe situação com este identificador");

                $attorneyEntity->setSituation(situation: $situation);
            }

            if(!is_null($attorneyRequest?->getOffice()?->getId())) {
                $office = $this->companyServiceInterface->findById(id: $attorneyRequest->getOffice()->getId());
                NotNull::validate(value: $office, message: "Nao existe escritório com esse identificador");

                $attorneyEntity->setOffice(office: $office);
            }

            if(!is_null($attorneyRequest?->getCity()?->getId())) {
                $city = $this->cityServiceInteface->findById(id: $attorneyRequest->getCity()->getId());
                NotNull::validate(value: $city, message: "Não existe cidade com esse identificador!");

                $attorneyEntity->setCity(city: $city);
            }

            $attorneyEntity->setEmail(email:$attorneyRequest?->getEmail() ?? $attorneyEntity->getEmail());
            $attorneyEntity->setName(name: $attorneyRequest?->getName() ?? $attorneyEntity->getEmail());
            $attorneyEntity->setOab(oab: $attorneyRequest?->getOab() ?? $attorneyEntity->getOab());
            $attorneyEntity->setPhone(phone: $attorneyRequest?->getPhone() ?? $attorneyEntity->getPhone());

            return $handler->handle($request->withAttribute("attorney", $attorneyEntity));
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
