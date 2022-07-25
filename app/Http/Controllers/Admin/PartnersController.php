<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Partner\BulkDestroyPartner;
use App\Http\Requests\Admin\Partner\DestroyPartner;
use App\Http\Requests\Admin\Partner\IndexPartner;
use App\Http\Requests\Admin\Partner\StorePartner;
use App\Http\Requests\Admin\Partner\UpdatePartner;
use App\Models\Partner;
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

class PartnersController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexPartner $request
     * @return array|Factory|View
     */
    public function index(IndexPartner $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Partner::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'name', 'bin', 'branch_id', 'enabled'],

            // set columns to searchIn
            ['id', 'name', 'bin', 'perex'],

            function($query) use ($request){
                $query->select('partners.id', 'partners.name', 'partners.bin', 'branches.name as branch_id', 'partners.enabled')->leftJoin('branches', 'branches.id', '=', 'partners.branch_id')->get();
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

        return view('admin.partner.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.partner.create');

        return view('admin.partner.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePartner $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StorePartner $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Partner
        $partner = Partner::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/partners'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/partners');
    }

    /**
     * Display the specified resource.
     *
     * @param Partner $partner
     * @throws AuthorizationException
     * @return void
     */
    public function show(Partner $partner)
    {
        $this->authorize('admin.partner.show', $partner);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Partner $partner
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Partner $partner)
    {
        $this->authorize('admin.partner.edit', $partner);


        return view('admin.partner.edit', [
            'partner' => $partner,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePartner $request
     * @param Partner $partner
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdatePartner $request, Partner $partner)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Partner
        $partner->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/partners'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'object' => $partner
            ];
        }

        return redirect('admin/partners');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyPartner $request
     * @param Partner $partner
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyPartner $request, Partner $partner)
    {
        $partner->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyPartner $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyPartner $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Partner::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
