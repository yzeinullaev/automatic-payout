<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreDocContractListMonth;
use App\Services\ContractListMonthService;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\Exception\CopyFileException;
use PhpOffice\PhpWord\Exception\CreateTemporaryFileException;
use PhpOffice\PhpWord\TemplateProcessor;

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

    /**
     * @throws CopyFileException
     * @throws CreateTemporaryFileException
     */
    public function downloadDocx(StoreDocContractListMonth $contractListMonthIds)
    {
        return response(['url' => $this->service->downloadDocx($contractListMonthIds->data)]);
    }


    public function downloadAndDelete(string $url)
    {
        return response()->download(storage_path('app/public/'. $url))->deleteFileAfterSend(true);
    }
}
