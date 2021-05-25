<?php

namespace Infrastructure\Utils\Params;


use Doctrine\ORM\Query;
use DoctrinePagination\DTO\Params;
use Http\StatusHttp;
use Infrastructure\Domain\Exceptions\MapDtoParamsException;
use Throwable;

class MapperParamsDto
{
    public static function map(array $params, int $hydrationMode = Query::HYDRATE_OBJECT): Params
    {
        try {
            return (new Params())
                ->setCriteria(criteria: $params["queryParams"])
                ->setPage(page: intval(value: $params["page"]))
                ->setPerPage(per_page: intval(value: $params["limit"]))
                ->setHydrateMode(hydrateMode: $hydrationMode)
                ->setSearchField(search_field: $params["search_field"])
                ->setSearch(search: $params["search"])
                ->setOrder(order: $params["order"])
                ->setSort(sort: $params["sort"]);
        } catch (Throwable $e){
            throw new MapDtoParamsException(
                message: "Erro ao tentar mapear DTO de parâmetros",
                statusCode: StatusHttp::INTERNAL_SERVER_ERROR,
                internalMessageError: $e->getMessage()
            );
        }
    }
}
