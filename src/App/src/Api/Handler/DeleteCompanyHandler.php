<?php


namespace App\Api\Handler;


use ApiCore\Exception\ExceptionCore;
use ApiCore\Response\JsonResponseCore;
use App\Entity\Company;
use App\Service\CompanyServiceInterface;
use App\Utils\Validation\NotNull;
use Http\StatusHttp;
use Infrastructure\Service\Logs\Sentry\SentryService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

class DeleteCompanyHandler implements RequestHandlerInterface
{
    private Throwable|null $exception = null;
    
    public function __construct(
        private CompanyServiceInterface $companyServiceInterface
    ){}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $idcompany = intval($request->getAttribute("id"));

            $company = $this->companyServiceInterface->findById(id: $idcompany);
            NotNull::validate(
                value: $company,
                statusCode: StatusHttp::NOT_FOUND,
                message:"Não existe nenhuma empresa com este identificador"
            );

            $this->companyServiceInterface->delete(company: $company);

            return new JsonResponseCore(data: null, statusCode: StatusHttp::NO_CONTENT);
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
