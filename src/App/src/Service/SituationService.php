<?php


namespace App\Service;


use App\Entity\Situation;
use App\Repository\SituationRepositoryInterface;

class SituationService implements SituationServiceInterface
{
    public function __construct(
        private SituationRepositoryInterface $situationRepositoryInterface
    ){}

    public function findById(int $id): Situation|null
    {
        return $this->situationRepositoryInterface->findById(id: $id);
    }

}
