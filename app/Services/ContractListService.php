<?php

namespace App\Services;

use App\Repositories\ContractListRepository;
use Illuminate\Support\Collection;

class ContractListService
{
    private ContractListRepository $repository;

    public function __construct(ContractListRepository $repository) {
        $this->repository = $repository;
    }

    public function getById($contractListId)
    {
        return $this->repository->getById($contractListId);
    }

    public function getAll(): Collection
    {
        return $this->repository->getAll();
    }
}
