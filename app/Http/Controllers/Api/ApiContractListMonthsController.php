<?php

namespace App\Http\Controllers\Api;

use App\Exports\ContractListMonthsExport;
use App\Http\Controllers\Controller;
use App\Repositories\ContractListMonthRepository;
use App\Services\ContractListMonthService;

class ApiContractListMonthsController extends Controller
{
    /**
     * @var ContractListMonthService
     */
    private $service;

    public function __construct(ContractListMonthService $service)
    {
        $this->service = $service;
    }

    public function download($id)
    {
        return (new ContractListMonthsExport($id))->download('contract_list.xlsx');
    }
}
