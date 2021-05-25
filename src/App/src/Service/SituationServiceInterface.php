<?php


namespace App\Service;


use App\Entity\Situation;

interface SituationServiceInterface
{
    public function findById(int $id): Situation|null;
}
