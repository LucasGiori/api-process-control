<?php


namespace App\Service;


use App\Entity\CompanyType;

interface CompanyTypeServiceInterface
{
    public function findById(int $id): CompanyType|null;
}
