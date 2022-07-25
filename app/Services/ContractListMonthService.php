<?php

namespace App\Services;

use App\Repositories\ContractListMonthRepository;

class ContractListMonthService
{
    /**
     * @var ContractListMonthRepository
     */
    private $repository;

    public function __construct(ContractListMonthRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllById($id)
    {
        return $this->repository->getAllById($id);
    }

    public function create($contractListId): int
    {
        return $this->repository->create($contractListId);
    }
}
