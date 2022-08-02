<?php

namespace App\Services;

use App\Http\Requests\Api\StoreDocContractListMonth;
use App\Repositories\ContractListMonthRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\Exception\CopyFileException;
use PhpOffice\PhpWord\Exception\CreateTemporaryFileException;
use PhpOffice\PhpWord\TemplateProcessor;

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

    public function getAllByIds(array $ids)
    {
        return $this->repository->getAllByIds($ids);
    }

    public function create($contractListId): int
    {
        return $this->repository->create($contractListId);
    }

    /**
     * @param array $items
     * @return string
     */
    public function getFileName(array $items)
    {
        $fields = [
            'ids', 'type', 'file_type', 'agent'
        ];

        foreach ($fields as $field) {
            if (!isset($items[$field]) && !is_array($items['ids'])) {
                return false;
            }
        }

        $startMonthId = min($items['ids']);
        $endMonthId = max($items['ids']);
        $startMonth = 0;
        $endMonth = 0;
        $data = $this->getAllByIds($items['ids'])->map(function ($contract) use ($items, $startMonthId, $endMonthId, &$startMonth, &$endMonth) {
            if (in_array($contract->id, $items['ids'])) {
                if ($startMonthId == $contract->id) {
                    $startMonth = Carbon::now()->month($contract['month'])->day(1)->format("d.m.Y");
                }

                if ($endMonthId == $contract->id) {
                    $endMonth = Carbon::now()->month($contract['month'])->endOfMonth()->format("d.m.Y");
                }
            }
        });


        return $items['type'] . $startMonth . '-' . $endMonth . '-' . $items['agent'] . '.' . $items['file_type'];
    }

    public function downloadAndDelete($url): bool
    {
        if(Storage::exists($url)){
            Storage::delete($url);

            return true;
        }

        return false;
    }

    /**
     * @throws CopyFileException
     * @throws CreateTemporaryFileException
     */
    public function downloadDocx(array $contractListMonthIds): string
    {
        $data = $this->getAllByIds($contractListMonthIds['ids'])->toArray();

        $fileName = $this->getFileName([
            'ids' => $contractListMonthIds['ids'],
            'type' => 'Приложение №3 ',
            'file_type' => 'docx',
            'agent' => $data[0]['initials']
        ]);

        $TemplateFileUrl = 'storage/Application#3.docx';

        $payDecodeSum = 0;
        $payActSum = 0;

        foreach ($data as $item) {
            $payDecodeSum += $item['pay_decode'];
            $payActSum += $item['pay_act'];
        }

        $template = new TemplateProcessor($TemplateFileUrl);
        $template->setValues([
            'partner-name' => $data[0]['partner_name'],
            'partner-bin' => $data[0]['partner_bin'],
            'pay-type-name' => $data[0]['pay_type_name'],
            'agent-fee' => $data[0]['agent_fee'],
            'pay-decode-amount' => $payDecodeSum,
            'pay-act-amount' => $payActSum,
        ]);

        $template->saveAs('/storage/'.$fileName);

        return $fileName;
    }
}
