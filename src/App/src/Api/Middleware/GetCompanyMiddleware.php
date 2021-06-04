<?php


namespace App\Api\Middleware;


use ApiCore\Exception\ExceptionCore;
use ApiCore\Response\JsonResponseCore;
use App\Entity\Company;
use Http\StatusHttp;
use Infrastructure\Service\Logs\Sentry\SentryService;
use Infrastructure\Utils\QueryParams\QueryParamsValidationInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

class GetCompanyMiddleware implements MiddlewareInterface
{
    private Throwable|null $exception = null;

    public function __construct(
        private QueryParamsValidationInterface $queryParamsValidator
    ){}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $queryParams = $request->getQueryParams();

            $params = $this->queryParamsValidator->validate(
                queryParams: $queryParams,
                entityName: Company::class,
                validateWithSymfony: false
            );

            return $handler->handle($request->withAttribute("params", $params));
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
