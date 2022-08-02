<?php

namespace App\Exports;

use App\Models\ContractListMonth;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\RichText\RichText;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ManyContractListMonthsExport implements FromQuery,
    WithStrictNullComparison,
    WithColumnWidths,
    WithMapping,
    WithStyles
{

    use Exportable;

    /**
     * @var int
     */
    private int $contractListId;
    /**
     * @var array
     */
    private array $contractListMonthIds;

    /**
     * @param array $contractListMonthIds
     */
    public function __construct(array $contractListMonthIds)
    {
        $this->contractListMonthIds = $contractListMonthIds;
    }

    public function query()
    {
        return ContractListMonth::query()->select(
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
        )
            ->leftJoin('contract_lists', 'contract_list_months.contract_list_id', '=', 'contract_lists.id')
            ->leftJoin('branches', 'branches.id', '=', 'contract_lists.branch_id')
            ->leftJoin('partners', 'partners.id', '=', 'contract_lists.partner_id')
            ->leftJoin('agents', 'agents.id', '=', 'contract_lists.agent_id')
            ->leftJoin('pay_statuses', 'pay_statuses.id', '=', 'contract_lists.pay_status_id')
            ->leftJoin('pay_types', 'pay_types.id', '=', 'contract_lists.pay_type_id')
            ->where('contract_list_months.id', (int)$this->contractListMonthIds[0]);
    }

    /**
     * @throws Exception
     */
    public function styles(Worksheet $sheet)
    {
        $border_style = [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN
            ]
        ];

        $sheet->getStyle('A1:H40')->getFont()->setName('Times New Roman');
        $sheet->getStyle('A1:H40')->getFont()->setSize(10);

        $sheet->getStyle('B8')->getFont()->setSize(9);
        $sheet->getStyle('A7:A12')->getFont()->setSize(9);
        $sheet->getStyle('B11')->getFont()->setSize(9);
        $sheet->getStyle('C8')->getFont()->setSize(9);
        $sheet->getStyle('C11')->getFont()->setSize(9);
        $sheet->getStyle('B13')->getFont()->setSize(11);

        $sheet->getStyle('B7')->getFont()->setBold(true)->setUnderline(true);
        $sheet->getStyle('B9')->getFont()->setBold(true)->setUnderline(true);
        $sheet->getStyle('B10')->getFont()->setBold(true)->setUnderline(true);
        $sheet->getStyle('B12')->getFont()->setBold(true)->setUnderline(true);
        $sheet->getStyle('B13')->getFont()->setBold(true);

        $sheet->getStyle('G7:G9')->getNumberFormat()->setFormatCode( NumberFormat::FORMAT_TEXT );

        $sheet->getStyle('G7')->getBorders()->applyFromArray($border_style);
        $sheet->getStyle('G9')->getBorders()->applyFromArray($border_style);
        $sheet->getStyle('G13:H14')->getBorders()->applyFromArray($border_style);
        $sheet->getRowDimension('8')->setRowHeight(9.8);
        $sheet->getRowDimension('7')->setRowHeight(15.6);
        $sheet->getRowDimension('9')->setRowHeight(18);
        $sheet->getRowDimension('10')->setRowHeight(14.3);
        $sheet->getRowDimension('11')->setRowHeight(9.8);
        $sheet->getRowDimension('13')->setRowHeight(27);
        $sheet->getRowDimension('16')->setRowHeight(33);
        $sheet->getRowDimension('17')->setRowHeight(39.8);

        $sheet->getStyle('H1:H5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('C8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT)->setVertical(Alignment::VERTICAL_BOTTOM);
        $sheet->getStyle('C11')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT)->setVertical(Alignment::VERTICAL_BOTTOM);
        $sheet->getStyle('G13:H13')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setWrapText(true);
        $sheet->getStyle('A16:E16')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_TOP)->setWrapText(true);
        $sheet->getStyle('B7')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $sheet->getStyle('F16:H17')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_TOP);
        $sheet->getStyle('A18:H18')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_TOP);
        $sheet->getStyle('G7:G9')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        $sheet->mergeCells('A16:A17');
        $sheet->mergeCells('B16:B17');
        $sheet->mergeCells('C16:C17');
        $sheet->mergeCells('D16:D17');
        $sheet->mergeCells('E16:E17');
        $sheet->mergeCells('F16:H16');

        // after 18

        $count = count($this->contractListMonthIds) - 1;

        $sheet->getStyle('A16:H'.(19 + $count))->getBorders()->applyFromArray($border_style);

        for ($i=0; $i<=$count; $i++) {

            $sheet->getStyle('A'.(19 + $i).':F'.(19 + $i))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_TOP);
            $sheet->getStyle('G'.(19 + $i).':H'.(19 + $i))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT)->setVertical(Alignment::VERTICAL_TOP);

        }

        $sheet->getStyle('G19:H'.(20 + $count))->getNumberFormat()->setFormatCode( NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $sheet->getStyle('E'.(20 + $count))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('E'.(20 + $count).':H'.(20 + $count))->getFont()->setBold(true);
        $sheet->getStyle('F'.(20 + $count).':H'.(20 + $count))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT)->setVertical(Alignment::VERTICAL_TOP);
        $sheet->getStyle('F'.(20 + $count).':H'.(20 + $count))->getBorders()->applyFromArray($border_style);

        $sheet->getStyle('C'.(23 + $count))->getFont()->setSize(9);
        $sheet->getStyle('D'.(23 + $count))->getFont()->setSize(9);
        $sheet->getStyle('A'.(25 + $count))->getFont()->setSize(9);
        $sheet->getStyle('E'.(25 + $count))->getFont()->setSize(9);
        $sheet->getStyle('A'.(28 + $count).':H'.(29 + $count))->getFont()->setSize(9);
        $sheet->getStyle('A'.(33 + $count).':A'.(36 + $count))->getFont()->setSize(9);

        $sheet->getRowDimension(23 + $count)->setRowHeight(10.5);
        $sheet->getRowDimension(28 + $count)->setRowHeight(11.3);

        $sheet->getStyle('D'.(23 + $count))->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('F'.(28 + $count).':H'.(28 + $count))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);



    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 30,
            'C' => 20,
            'D' => 27,
            'E' => 11,
            'F' => 16,
            'G' => 13,
            'H' => 13,
        ];
    }

    public function map($row): array
    {
        $startMonth = Carbon::now()->month($row->month)->day(1)->format("d.m.Y");
        $endMonth = Carbon::now()->month($row->month)->endOfMonth()->format("d.m.Y");
        $filial_B7 = "Филиал №" . $row->number ." АО «Евразийский банк», " . $row->address;
        $agent_B9 = $row->agent_name .", ". $row->agent_address;
        $contract_B12 = $row->contract_number . ' от ' . date('d.m.Y', strtotime($row->start_contract_date)) . 'г.';

        $data = [
            0 => [
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                'Приложение 50',
            ],
            1 => [
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                'к приказу Министра финансов',
            ],
            2 => [
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                'Республики Казахстан',
            ],
            3 => [
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                'от 20 декабря 2012 года № 562',
            ],
            4 => [
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                'Форма Р-1',
            ],
            5 => [
                null,
                null,
                null,
                null,
                null,
                null,
                'БИН/ИИН',
                null,
            ],
            6 => [
                'Заказчик:',
                $filial_B7,
                null,
                null,
                null,
                null,
                $row->branch_bin,
                null,
            ],
            7 => [
                null,
                null,
                'полное наименование, адрес, данные о средствах связи',
                null,
                null,
                null,
                null,
                null,
            ],
            8 => [
                'Исполнитель:',
                $agent_B9,
                null,
                null,
                null,
                null,
                $row->iin,
                null,
            ],
            9 => [
                null,
                $row->requisite,
                null,
                null,
                null,
                null,
                null,
                null,
            ],
            //11
            10 => [
                null,
                null,
                'полное наименование, адрес, данные о средствах связи',
                null,
                null,
                null,
                null,
                null,
            ],
            //12
            11 => [
                'Договор (контракт):',
                $contract_B12,
                null,
                null,
                null,
                null,
                null,
                null,
            ],
            //13
            12 => [
                null,
                'АКТ ВЫПОЛНЕННЫХ РАБОТ (ОКАЗАННЫХ УСЛУГ)*',
                null,
                null,
                null,
                null,
                'Номер документа',
                'Дата составления',
            ],
            //14
            13 => [
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
            ],
            //15
            14 => [
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
            ],
            //16
            15 => [
                'Номер по порядку',
                'Наименование работ (услуг) (в разрезе их подвидов в соответствии с технической спецификацией, заданием, графиком выполнения работ (услуг) при их наличии)',
                'Дата выполнения работ (оказания услуг)**',
                'Сведения об отчете о научных исследованиях, маркетинговых, консультационных и прочих услугах (дата, номер, количество страниц) (при их наличии)***',
                'Единица измерения',
                'Выполнено работ (оказано услуг)',
            ],
            //17
            16 => [
                null,
                null,
                null,
                null,
                null,
                'количество',
                'цена за единицу',
                'стоимость',
            ],
            //18
            17 => [
                1,
                2,
                3,
                4,
                5,
                6,
                7,
                8,
            ]
        ];

        $all_pay_decode = 0;
        $all_pay_act = 0;
        $line_Start = 18;
        $put[$line_Start] = [
            1,
            'Агентские услуги',
            $startMonth . '-' . $endMonth,
            null,
            'тенге',
            null,
            $row->pay_decode,
            $row->pay_act,
        ];

        $i = 1;

        foreach ($row->whereIn('id', $this->contractListMonthIds)->get() as $items) {

            $startMonth = Carbon::now()->month($items->month)->day(1)->format("d.m.Y");
            $endMonth = Carbon::now()->month($items->month)->endOfMonth()->format("d.m.Y");
            $all_pay_decode += $items->pay_decode;
            $all_pay_act += $items->pay_act;
            //19+
            $put[$line_Start] = [
                $i++,
                'Агентские услуги',
                $startMonth . '-' . $endMonth,
                null,
                'тенге',
                null,
                $items->pay_decode,
                $items->pay_act,
            ];
            $line_Start++;
        }

        $fee_F20 = $row->agent_fee . '% от суммы';

        $string_price_A22 = new RichText();
        $string_price_A22->createText('Сведения об использовании запасов, полученных от заказчика: ');
        $price_num = $string_price_A22->createTextRun(number_format($all_pay_act, 2, ',', ' ') . ' ');
        $price_num->getFont()->setName('Times New Roman')->setSize(10)->setBold(true);
        $price_str = $string_price_A22->createTextRun('(' . $this->numToStr($all_pay_act) .').');
        $price_str->getFont()->setBold(true);
        $price_str->getFont()->setName('Times New Roman')->setSize(10)->setUnderline(true);

        $string_A27 = new RichText();
        $string_A27->createText('Сдал(Исполнитель)');
        $string_agent = $string_A27->createTextRun('   Агент   ');
        $string_agent->getFont()->setName('Times New Roman')->setSize(10)->setUnderline(true);
        $string_A27->createText('   /_________________/    ');;
        $string_A27->createText('   ');
        $string_agent_name = $string_A27->createTextRun($row->initials);
        $string_agent_name->getFont()->setName('Times New Roman')->setSize(10)->setUnderline(true);

        //Принял (Заказчик)Заместитель директора Филиала №6  /___________/

        $string_D27 = new RichText();
        $string_branch = $string_D27->createTextRun('Принял (Заказчик)Заместитель директора Филиала №' . $row->number);
        $string_branch->getFont()->setName('Times New Roman')->setSize(10)->setUnderline(true);
        $string_D27->createText('  /_________________/');

            //20
        $data3 = [
            $line_Start++ => [
                null,
                null,
                null,
                null,
                'Итого:',
                $fee_F20,
                $all_pay_decode,
                $all_pay_act,
            ],
            //21
            $line_Start++ => [
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
            ],
            //22
            $line_Start++ => [
                $string_price_A22,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
            ],
            //23
            $line_Start++ => [
                null,
                null,
                'наименование, количество, стоимость',
                null,
                null,
                null,
                null,
                null,
            ],
            //24
            $line_Start++ => [
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
            ],
            //25
            $line_Start++ => [
                'Приложение: Перечень документации, в том числе отчет(ы) о маркетинговых, научных исследованиях, консультационных и прочих услугах (обязательны при его (их) наличии) на ______  страниц',
                null,
                null,
                null,
                null,
                null,
                null,
                null,
            ],
            //26
            $line_Start++ => [
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
            ],
            //27
            $line_Start++ => [
                $string_A27,
                null,
                null,
                $string_D27,
                null,
                null,
                null,
                null,
            ],
            //28
            $line_Start++ => [
                null,
                'должность                подпись',
                'расшифровка подписи',
                null,
                'должность',
                'подпись',
                null,
                'расшифровка подписи',
            ],
            //29
            $line_Start++ => [
                'М.П.',
                null,
                null,
                null,
                'М.П.',
                null,
                null,
                null,
            ],
            //30
            $line_Start++ => [
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
            ],
            //31
            $line_Start++ => [
                null,
                null,
                null,
                null,
                'Дата подписания (принятия) работ (услуг) ____________',
                null,
                null,
                null,
            ],
            //32
            $line_Start++ => [
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
            ],
            //32
            $line_Start++ => [
                '*Применяется для приемки-передачи выполненных работ (оказанных услуг), за исключением строительно-монтажных работ.',
            ],
            //33
            $line_Start++ => [
                '**Заполняется в случае, если даты выполненных работ (оказанных услуг) приходятся на различные периоды, а также в случае, если даты выполнения работ (оказания услуг) и даты подписания',
            ],
            //34
            $line_Start++ => [
                ' (принятия) работ (услуг) различны.',
            ],
            //35
            $line_Start++ => [
                '***Заполняется в случае наличия отчета о научных исследованиях, маркетинговых, консультационных и прочих услугах',
            ]
        ];

        return Arr::collapse([$data, $put, $data3]);

    }

    public function numToStr($num): string
    {
        $nul = 'ноль';
        $ten = array(
            array('', 'один', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'),
            array('', 'одна', 'две', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять')
        );
        $a20 = array('десять', 'одиннадцать', 'двенадцать', 'тринадцать', 'четырнадцать', 'пятнадцать', 'шестнадцать', 'семнадцать', 'восемнадцать', 'девятнадцать');
        $tens = array(2 => 'двадцать', 'тридцать', 'сорок', 'пятьдесят', 'шестьдесят', 'семьдесят', 'восемьдесят', 'девяносто');
        $hundred = array('', 'сто', 'двести', 'триста', 'четыреста', 'пятьсот', 'шестьсот', 'семьсот', 'восемьсот', 'девятьсот');
        $unit = array(
            array('тиын' , 'тиын',   'тиын',     1),
            array('тенге',    'тенге',     'тенге',     0),
            array('тысяча',   'тысячи',    'тысяч',      1),
            array('миллион',  'миллиона',  'миллионов',  0),
            array('миллиард', 'миллиарда', 'миллиардов', 0),
        );

        [$rub, $kop] = explode('.', sprintf("%015.2f", floatval($num)));
        $out = array();
        if (intval($rub) > 0) {
            foreach (str_split($rub, 3) as $uk => $v) {
                if (!intval($v)) continue;
                $uk = sizeof($unit) - $uk - 1;
                $gender = $unit[$uk][3];
                [$i1, $i2, $i3] = array_map('intval', str_split($v, 1));
                // mega-logic
                $out[] = $hundred[$i1]; // 1xx-9xx
                if ($i2 > 1) $out[] = $tens[$i2] . ' ' . $ten[$gender][$i3]; // 20-99
                else $out[] = $i2 > 0 ? $a20[$i3] : $ten[$gender][$i3]; // 10-19 | 1-9
                // units without rub & kop
                if ($uk > 1) $out[] = self::morph($v, $unit[$uk][0], $unit[$uk][1], $unit[$uk][2]);
            }
        } else {
            $out[] = $nul;
        }
        $out[] = self::morph(intval($rub), $unit[1][0], $unit[1][1], $unit[1][2]); // rub
        $out[] = $kop . ' ' . self::morph($kop, $unit[0][0], $unit[0][1], $unit[0][2]); // kop
        return trim(preg_replace('/ {2,}/', ' ', join(' ', $out)));
    }

    /**
     * Склоняем словоформу
     * @author runcore
     */
    private function morph($n, $f1, $f2, $f5)
    {
        $n = abs(intval($n)) % 100;
        if ($n > 10 && $n < 20) return $f5;
        $n = $n % 10;
        if ($n > 1 && $n < 5) return $f2;
        if ($n == 1) return $f1;
        return $f5;
    }
}
