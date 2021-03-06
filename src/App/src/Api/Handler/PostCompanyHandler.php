<?php


namespace App\Api\Handler;


use ApiCore\Exception\ExceptionCore;
use ApiCore\Response\JsonResponseCore;
use App\Entity\Company;
use App\Service\CompanyServiceInterface;
use Http\StatusHttp;
use Infrastructure\Domain\Exceptions\ValidationException;
use Infrastructure\Service\Logs\Sentry\SentryService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

class PostCompanyHandler implements RequestHandlerInterface
{
    private Throwable|null $exception = null;

    public function __construct(
        private CompanyServiceInterface $companyServiceInterface
    ){}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            /** @var Company $company */
            $company = $request->getAttribute("company");

            if(!is_null($this->companyServiceInterface->findByCnpj(cnpj: $company->getCnpj()))) {
                throw new ValidationException(
                    message: "Já existe uma empresa com este cnpj cadastrado!",
                    statusCode: StatusHttp::CONFLICT
                );
            }

            $this->companyServiceInterface->save(company: $company);

            return new JsonResponseCore(
                data: [
                    "message"=>"Empresa cadastrada com sucesso!"
                ],
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
