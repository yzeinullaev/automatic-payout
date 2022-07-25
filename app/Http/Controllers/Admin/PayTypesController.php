<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PayType\BulkDestroyPayType;
use App\Http\Requests\Admin\PayType\DestroyPayType;
use App\Http\Requests\Admin\PayType\IndexPayType;
use App\Http\Requests\Admin\PayType\StorePayType;
use App\Http\Requests\Admin\PayType\UpdatePayType;
use App\Models\PayType;
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

class PayTypesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexPayType $request
     * @return array|Factory|View
     */
    public function index(IndexPayType $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(PayType::class)->processRequestAndGet(
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

        return view('admin.pay-type.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.pay-type.create');

        return view('admin.pay-type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePayType $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StorePayType $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the PayType
        $payType = PayType::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/pay-types'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/pay-types');
    }

    /**
     * Display the specified resource.
     *
     * @param PayType $payType
     * @throws AuthorizationException
     * @return void
     */
    public function show(PayType $payType)
    {
        $this->authorize('admin.pay-type.show', $payType);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param PayType $payType
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(PayType $payType)
    {
        $this->authorize('admin.pay-type.edit', $payType);


        return view('admin.pay-type.edit', [
            'payType' => $payType,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePayType $request
     * @param PayType $payType
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdatePayType $request, PayType $payType)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values PayType
        $payType->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/pay-types'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'object' => $payType
            ];
        }

        return redirect('admin/pay-types');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyPayType $request
     * @param PayType $payType
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyPayType $request, PayType $payType)
    {
        $payType->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyPayType $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyPayType $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    PayType::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
