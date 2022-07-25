<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PayStatus\BulkDestroyPayStatus;
use App\Http\Requests\Admin\PayStatus\DestroyPayStatus;
use App\Http\Requests\Admin\PayStatus\IndexPayStatus;
use App\Http\Requests\Admin\PayStatus\StorePayStatus;
use App\Http\Requests\Admin\PayStatus\UpdatePayStatus;
use App\Models\PayStatus;
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

class PayStatusesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexPayStatus $request
     * @return array|Factory|View
     */
    public function index(IndexPayStatus $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(PayStatus::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'name', 'enabled'],

            // set columns to searchIn
            ['id', 'name']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.pay-status.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.pay-status.create');

        return view('admin.pay-status.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePayStatus $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StorePayStatus $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the PayStatus
        $payStatus = PayStatus::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/pay-statuses'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/pay-statuses');
    }

    /**
     * Display the specified resource.
     *
     * @param PayStatus $payStatus
     * @throws AuthorizationException
     * @return void
     */
    public function show(PayStatus $payStatus)
    {
        $this->authorize('admin.pay-status.show', $payStatus);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param PayStatus $payStatus
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(PayStatus $payStatus)
    {
        $this->authorize('admin.pay-status.edit', $payStatus);


        return view('admin.pay-status.edit', [
            'payStatus' => $payStatus,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePayStatus $request
     * @param PayStatus $payStatus
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdatePayStatus $request, PayStatus $payStatus)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values PayStatus
        $payStatus->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/pay-statuses'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'object' => $payStatus
            ];
        }

        return redirect('admin/pay-statuses');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyPayStatus $request
     * @param PayStatus $payStatus
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyPayStatus $request, PayStatus $payStatus)
    {
        $payStatus->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyPayStatus $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyPayStatus $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    PayStatus::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
