<?php

namespace App\Exports;

use App\Models\ContractList;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ContractListsExport implements FromCollection,
    WithStrictNullComparison,
    WithCustomStartCell,
    WithHeadings,
    ShouldAutoSize,
    WithStyles,
    WithColumnFormatting
{

    use Exportable;

    /**
     * @return Collection
     */
    public function collection(): Collection
    {
        return ContractList::query()->select(
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

    public function startCell(): string
    {
        return 'A1';
    }

    public function headings(): array
    {
        return [
            '#',
            'Филиал',
            'Номер договора',
            'Срок заключения',
            'Срок окончания',
            'Партнер',
            'БИН',
            'агент',
            'Статус оплаты',
            'Тип оплаты',
            '% агентского вознаграждения',
            'Статус',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function columnFormats(): array
    {
        return [
            'G' => NumberFormat::FORMAT_TEXT,
        ];
    }
}
