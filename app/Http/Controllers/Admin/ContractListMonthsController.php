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
use App\Services\ContractListService;
use Brackets\AdminListing\Facades\AdminListing;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Maatwebsite\Excel\Excel;

class ContractListMonthsController extends Controller
{
    private $service;

    public function __construct(ContractListService $service) {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     * @param IndexContractListMonth $request
     * @return array|Factory|View
     */
    public function index(IndexContractListMonth $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(ContractListMonth::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'month', 'pay_decode', 'pay_act', 'upload_decode_file', 'download_akt_file'],

            // set columns to searchIn
            ['id', 'month', 'pay_decode', 'pay_act']
        );

        $contractList = $this->service->getById($request->contractList);

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.contract-list-month.index', [
            'data' => $data,
            'contract_list_id' => $request->contractList,
            'contract_list_data' => $contractList,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.contract-list-month.create');

        return view('admin.contract-list-month.create');
    }

    /**
     * Store a newly created resource in storage.
     *
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

        return redirect('admin/contract-list-months'  . $request->contract_list_id . '/month');
    }

    /**
     * Display the specified resource.
     *
     * @param ContractListMonth $contractListMonth
     * @throws AuthorizationException
     * @return void
     */
    public function show(ContractListMonth $contractListMonth)
    {
        $this->authorize('admin.contract-list-month.show', $contractListMonth);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ContractListMonth $contractListMonth
     * @throws AuthorizationException
     * @return Factory|View
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
     *
     * @param UpdateContractListMonth $request
     * @param ContractListMonth $contractListMonth
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateContractListMonth $request, ContractListMonth $contractListMonth)
    {
//        dd($request, $contractListMonth);
        // Sanitize input
        $sanitized = $request->getSanitized();

        $mediaItems = $contractListMonth->getMedia('decode_file');
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
     *
     * @param DestroyContractListMonth $request
     * @param ContractListMonth $contractListMonth
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
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
        $data = $this->service->getById($contractListMonth->contract_list_id);
        $startMonth = Carbon::now()->month($contractListMonth->month)->day(1)->format("d.m.Y");
        $endMonth = Carbon::now()->month($contractListMonth->month)->endOfMonth()->format("d.m.Y");
        $fileName = 'АКТ-' .$startMonth . '-' . $endMonth.'-'.$data->agent_id.'.xlsx';
        return (new ContractListMonthsExport($contractListMonth->id))->download($fileName, Excel::XLSX);
    }
}
