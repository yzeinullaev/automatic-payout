<?php

namespace App\Services;

use App\Repositories\ContractListRepository;

class ContractListService
{
    private $repository;

    public function __construct(ContractListRepository $repository) {
        $this->repository = $repository;
    }

    public function getById($contractListId)
    {
        return $this->repository->getById($contractListId);
    }
}
