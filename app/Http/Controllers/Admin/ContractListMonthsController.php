<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ContractListMonthsExport;
use App\Exports\ManyContractListMonthsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ContractListMonth\BulkDestroyContractListMonth;
use App\Http\Requests\Admin\ContractListMonth\DestroyContractListMonth;
use App\Http\Requests\Admin\ContractListMonth\IndexContractListMonth;
use App\Http\Requests\Admin\ContractListMonth\StoreContractListMonth;
use App\Http\Requests\Admin\ContractListMonth\UpdateContractListMonth;
use App\Models\ContractListMonth;
use App\Services\ContractListMonthService;
use App\Services\ContractListService;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Support\Facades\Storage;
use Google\Service\Storage as GoogleStorage;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Maatwebsite\Excel\Excel;
use PhpOffice\PhpWord\Exception\CopyFileException;
use PhpOffice\PhpWord\Exception\CreateTemporaryFileException;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as ReaderXlsx;

class ContractListMonthsController extends Controller
{
    private ContractListService $service;
    private ContractListMonthService $monthService;

    public function __construct(ContractListService $service, ContractListMonthService $monthService)
    {
        $this->service = $service;
        $this->monthService = $monthService;
    }

    /**
     * Display a listing of the resource.
     * @param $contractListId
     * @param IndexContractListMonth $request
     * @return array|Factory|View
     */
    public function index($contractListId, IndexContractListMonth $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(ContractListMonth::class)->processRequestAndGet(
        // pass the request with params
            $request,

            // set columns to query
            ['id', 'month', 'pay_decode', 'pay_act', 'upload_decode_file', 'download_akt_file'],

            // set columns to searchIn
            ['id', 'month', 'pay_decode', 'pay_act'],

            function ($query) use ($contractListId, $request) {

                $query->select(
                    'contract_list_months.id',
                    'month_description.month',
                    'contract_list_months.pay_decode',
                    'contract_list_months.pay_act',
                    'contract_list_months.upload_decode_file',
                    'contract_list_months.download_akt_file'
                )
                    ->leftJoin('month_description', 'month_description.id', '=', 'contract_list_months.month')
                    ->where('contract_list_id', $contractListId)->get();
            }
        );

        $contractList = $this->service->getById($contractListId);

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id'),
                ];
            }
            return ['data' => $data];
        }

        return view('admin.contract-list-month.index', [
            'data' => $data,
            'contract_list_id' => $contractListId,
            'contract_list_data' => $contractList,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('admin.contract-list-month.create');

        return view('admin.contract-list-month.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreContractListMonth $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreContractListMonth $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();
        // Store the ContractListMonth
        $contractListMonth = ContractListMonth::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/contract-list-months/') . '/' . $request->contract_list_id . '/month', 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/contract-list-months' . $request->contract_list_id . '/month');
    }

    /**
     * Display the specified resource.
     * @param ContractListMonth $contractListMonth
     * @return void
     * @throws AuthorizationException
     */
    public function show(ContractListMonth $contractListMonth)
    {
        $this->authorize('admin.contract-list-month.show', $contractListMonth);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     * @param ContractListMonth $contractListMonth
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function edit(ContractListMonth $contractListMonth)
    {
        $this->authorize('admin.contract-list-month.edit', $contractListMonth);
        $contractList = $this->service->getById($contractListMonth->contract_list_id);

        return view('admin.contract-list-month.edit', [
            'contractListMonth' => $contractListMonth,
            'contractList' => $contractList,
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateContractListMonth $request
     * @param ContractListMonth $contractListMonth
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateContractListMonth $request, ContractListMonth $contractListMonth)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        $contractList = $this->service->getById($request->contract_list_id);

        $mediaItems = $contractListMonth->getMedia('decode_file');

        foreach ($request->decode_file as $decode_file) {
            if (isset($decode_file['path'])) {
                $r = new ReaderXlsx();
                $sp = $r->load(storage_path('uploads/' . $decode_file['path']));
                $s = $sp->getActiveSheet();

                $info = $r->listWorksheetInfo(storage_path('uploads/' . $decode_file['path']));
                $totalRows = $info[0]['totalRows'];
                $sum = 0;
                for ($row = 2; $row <= $totalRows; $row++) {
                    if (Str::contains($s->getCell("B{$row}")->getValue(), $contractList->partner_bin)) {
                        $sum += round(floatval($s->getCell("D{$row}")->getValue()), 2);
                    }
                }

                $sanitized['pay_decode'] = $sum;
                $sanitized['pay_act'] = round(($sum * $contractList->agent_fee) / 100, 2);
            }

        }

        if (isset($mediaItems[0])) {
            $sanitized['upload_decode_file'] = $mediaItems[0]->getUrl();
        }


        // Update changed values ContractListMonth
        $contractListMonth->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/contract-list-months') . '/' . $request->contract_list_id . '/month',
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/contract-list-months/' . $request->contract_list_id . '/month');
    }

    /**
     * Remove the specified resource from storage.
     * @param DestroyContractListMonth $request
     * @param ContractListMonth $contractListMonth
     * @return ResponseFactory|RedirectResponse|Response
     * @throws Exception
     */
    public function destroy(DestroyContractListMonth $request, ContractListMonth $contractListMonth)
    {
        $contractListMonth->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     * @param BulkDestroyContractListMonth $contractListMonthIds
     * @return Application|Response|ResponseFactory
     */
    public function bulkDestroy(BulkDestroyContractListMonth $contractListMonthIds)
    {
        (new ManyContractListMonthsExport($contractListMonthIds->data['ids']))->store('get_local.xlsx', 'public', Excel::XLSX);

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

    public function download(ContractListMonth $contractListMonth)
    {
        return (new ContractListMonthsExport($contractListMonth->id))->download(
            $this->monthService->getFileName([
                'ids' => [$contractListMonth->id],
                'type' => 'АКТ',
                'file_type' => 'xlsx',
                'agent' => ''
            ]), Excel::XLSX);
    }

    public function downloadDoc(ContractListMonth $contractListMonth)
    {
        try {
            return Response()->download(storage_path('app/public/'. $this->monthService->downloadDocx(['ids' => [$contractListMonth->id]])))->deleteFileAfterSend(true);
        } catch (CopyFileException|CreateTemporaryFileException $e) {
            return Response()->json($e->getMessage(), 500);
        }
    }

}
