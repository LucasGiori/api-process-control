<?php


namespace App\Api\Handler;


use ApiCore\Exception\ExceptionCore;
use ApiCore\Response\JsonResponseCore;
use App\Entity\Attorney;
use App\Service\AttorneyServiceInterface;
use Http\StatusHttp;
use Infrastructure\Domain\Exceptions\ValidationException;
use Infrastructure\Service\Logs\Sentry\SentryService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

class PostAttorneyHandler implements RequestHandlerInterface
{
    private Throwable|null $exception = null;

    public function __construct(
        private AttorneyServiceInterface $attorneyServiceInterface
    ){}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            /** @var Attorney $attorney */
            $attorney = $request->getAttribute("attorney");

            if(!is_null($this->attorneyServiceInterface->findByCpf(cpf: $attorney->getCpf()))) {
                throw new ValidationException(
                    message: "Já existe um advogado com este cpf cadastrado!",
                    statusCode: StatusHttp::CONFLICT
                );
            }

            $this->attorneyServiceInterface->save(attorney: $attorney);

            return new JsonResponseCore(
                data: ["message"=>"Advogado cadastrado com sucesso!"],
                statusCode: StatusHttp::CREATED
            );
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
