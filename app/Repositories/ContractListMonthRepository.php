<?php

namespace App\Repositories;

use App\Enums\ContractListMonthEnum;
use App\Models\ContractListMonth;
use Illuminate\Database\Eloquent\Builder;

class ContractListMonthRepository
{
    /**
     * @var ContractListMonth
     */
    private $model;

    public function __construct(ContractListMonth $model) {
        $this->model = $model;
    }

    public function getAllByIds(array $ids)
    {
        return $this->model::query()->select(
            'branches.name as branch_name',
            'branches.number',
            'branches.address',
            'branches.bin as branch_bin',
            'contract_lists.contract_number',
            'contract_lists.start_contract_date',
            'contract_lists.end_contract_date',
            'contract_lists.agent_fee',
            'partners.name as partner_name',
            'partners.bin as partner_bin',
            'agents.name as agent_name',
            'agents.initials',
            'agents.iin',
            'agents.address as agent_address',
            'agents.requisite',
            'pay_statuses.name as pay_status_name',
            'pay_types.name as pay_type_name',
            'contract_list_months.month',
            'contract_list_months.pay_decode',
            'contract_list_months.pay_act',
            'contract_list_months.id',
        )
            ->leftJoin('contract_lists', 'contract_list_months.contract_list_id', '=', 'contract_lists.id')
            ->leftJoin('branches', 'branches.id', '=', 'contract_lists.branch_id')
            ->leftJoin('partners', 'partners.id', '=', 'contract_lists.partner_id')
            ->leftJoin('agents', 'agents.id', '=', 'contract_lists.agent_id')
            ->leftJoin('pay_statuses', 'pay_statuses.id', '=', 'contract_lists.pay_status_id')
            ->leftJoin('pay_types', 'pay_types.id', '=', 'contract_lists.pay_type_id')
            ->whereIn('contract_list_months.id', $ids)
            ->get();
    }

    public function create($contractListId): int
    {
        $data = [];
        foreach (ContractListMonthEnum::MONTHS as $item) {
            $data[] = ['contract_list_id' => $contractListId, 'month' => $item];
        }
        return $this->model::query()->insertOrIgnore($data);
    }
}
