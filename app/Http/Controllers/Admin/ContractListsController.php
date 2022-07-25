<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ContractList\BulkDestroyContractList;
use App\Http\Requests\Admin\ContractList\DestroyContractList;
use App\Http\Requests\Admin\ContractList\IndexContractList;
use App\Http\Requests\Admin\ContractList\StoreContractList;
use App\Http\Requests\Admin\ContractList\UpdateContractList;
use App\Models\ContractList;
use App\Services\ContractListMonthService;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ContractListsController extends Controller
{
    /**
     * @var ContractListMonthService
     */
    private $service;

    public function __construct(ContractListMonthService $service) {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @param IndexContractList $request
     * @return array|Factory|View
     */
    public function index(IndexContractList $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(ContractList::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'branch_id', 'contract_number', 'start_contract_date', 'end_contract_date', 'partner_id', 'partner_bin', 'agents', 'pay_status_id', 'pay_type_id', 'agent_fee', 'enabled'],

            // set columns to searchIn
            ['id', 'branch_id', 'contract_number', 'partner_bin'],

            function($query) use ($request){
                $query->select(
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
                    ->get();
            }
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.contract-list.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.contract-list.create');

        return view('admin.contract-list.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreContractList $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreContractList $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the ContractList
        $contractList = ContractList::create($sanitized);
        $this->service->create($contractList->id);

        if ($request->ajax()) {
            return ['redirect' => url('admin/contract-lists'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/contract-lists');
    }

    /**
     * Display the specified resource.
     *
     * @param ContractList $contractList
     * @throws AuthorizationException
     * @return void
     */
    public function show(ContractList $contractList)
    {
        $this->authorize('admin.contract-list.show', $contractList);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ContractList $contractList
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(ContractList $contractList)
    {
        $this->authorize('admin.contract-list.edit', $contractList);


        return view('admin.contract-list.edit', [
            'contractList' => $contractList,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateContractList $request
     * @param ContractList $contractList
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateContractList $request, ContractList $contractList)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values ContractList
        $contractList->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/contract-lists'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/contract-lists');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyContractList $request
     * @param ContractList $contractList
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyContractList $request, ContractList $contractList)
    {
        $contractList->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyContractList $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyContractList $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    ContractList::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
