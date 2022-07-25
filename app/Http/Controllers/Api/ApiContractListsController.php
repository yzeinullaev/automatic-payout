<?php

namespace App\Http\Controllers\Api;

use App\Exports\ContractListsExport;
use App\Http\Controllers\Controller;
use App\Repositories\ContractListRepository;
use Maatwebsite\Excel\Facades\Excel;

class ApiContractListsController extends Controller
{

    public function export()
    {
        return (new ContractListsExport)->download('contract_list.xlsx');
    }

    public function store()
    {
        return (new ContractListsExport)->store('contract_list.xlsx', 'local');
    }
}
