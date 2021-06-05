<?php


namespace App\Api\Middleware;


use ApiCore\Exception\ExceptionCore;
use ApiCore\Response\JsonResponseCore;
use App\Entity\Action;
use App\Service\ActionTypeServiceInterface;
use App\Service\SituationServiceInterface;
use App\Utils\Validation\NotNull;
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

class PostActionMiddleware implements MiddlewareInterface
{
    private Throwable|null $exception = null;

    public function __construct(
        private DeserializationInterface $deserialization,
        private ValidationSymfonyInterface $validation,
        private ActionTypeServiceInterface $actionTypeServiceInterface,
        private SituationServiceInterface $situationServiceInterface
    ){}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $body = $request->getBody()->getContents();

            ValidationBody::emptyBody(body: $body);

            /** @var Action $actionRequest */
            $actionRequest = $this->deserialization->deserialize(
                body: $body,
                entityName: Action::class,
                format: "json",
                messageError: "erro ao tentar definir dados da requisição na entidade ação!"
            );

            $messageError = $this->validation->validateEntitySpecificFields(
                fieldsToValidate: ["description","actionType","situation"],
                entityOrObject: $actionRequest
            );

            if(!empty($messageError)) {
                throw new SymfonyValidationException(message: $messageError, statusCode: StatusHttp::EXPECTATION_FAILED);
            }

            $actionType = $this->actionTypeServiceInterface->findById(id: intval($actionRequest?->getActionType()?->getId()));
            NotNull::validate(value: $actionType, message: "Não existe nenhum tipo de ação com este identificador!");

            $situation = $this->situationServiceInterface->findById(id: intval($actionRequest?->getSituation()->getId()));
            NotNull::validate(value: $situation, message: "Não existe nenhuma situação com este identificador!");

            $actionRequest->setActionType(actionType: $actionType);
            $actionRequest->setSituation(situation: $situation);
            return $handler->handle($request->withAttribute("action", $actionRequest));
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
