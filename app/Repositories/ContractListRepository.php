<?php

namespace App\Repositories;

use App\Models\ContractList;
use Illuminate\Support\Collection;

class ContractListRepository
{
    private $model;

    public function __construct(ContractList $model) {
        $this->model = $model;
    }

    public function getAll(): Collection
    {
        return $this->model::query()->select(
            'contract_lists.id',
            'branches.name as branch_id',
            'contract_lists.contract_number',
            'contract_lists.start_contract_date',
            'contract_lists.end_contract_date',
            'partners.name as partner_id',
            'contract_lists.partner_bin',
            'agents.name as agent_id',
            'pay_statuses.name as pay_status_id',
            'pay_types.name as pay_type_id',
            'contract_lists.agent_fee',
            'contract_lists.enabled'
        )
            ->leftJoin('branches', 'branches.id', '=', 'contract_lists.branch_id')
            ->leftJoin('partners', 'partners.id', '=', 'contract_lists.partner_id')
            ->leftJoin('agents', 'agents.id', '=', 'contract_lists.agent_id')
            ->leftJoin('pay_statuses', 'pay_statuses.id', '=', 'contract_lists.pay_status_id')
            ->leftJoin('pay_types', 'pay_types.id', '=', 'contract_lists.pay_type_id')
            ->get()->collect();
    }

    public function getById($contractListId)
    {
        return $this->model::query()->select(
                'contract_lists.id',
                'branches.name as branch_id',
                'contract_lists.contract_number',
                'contract_lists.start_contract_date',
                'contract_lists.end_contract_date',
                'partners.name as partner_id',
                'contract_lists.partner_bin',
                'agents.name as agent_id',
                'pay_statuses.name as pay_status_id',
                'pay_types.name as pay_type_id',
                'contract_lists.agent_fee',
                'contract_lists.enabled'
            )
            ->leftJoin('branches', 'branches.id', '=', 'contract_lists.branch_id')
            ->leftJoin('partners', 'partners.id', '=', 'contract_lists.partner_id')
            ->leftJoin('agents', 'agents.id', '=', 'contract_lists.agent_id')
            ->leftJoin('pay_statuses', 'pay_statuses.id', '=', 'contract_lists.pay_status_id')
            ->leftJoin('pay_types', 'pay_types.id', '=', 'contract_lists.pay_type_id')
            ->where('contract_lists.id', $contractListId)
            ->first();
    }
}
