<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PayStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ApiPayStatusesController extends Controller
{

    public function index(Request $request)
    {
        $term = '';
        if ($request->term) {
            $term = $request->term;
        }

        return Response([
            'results' =>
                PayStatus::query()->select([
                    'pay_statuses.id',
                    'pay_statuses.name as text',
                    DB::raw('case when contract_lists.id is null then false else true end as contract_selected'),
                ])
                ->leftJoin('contract_lists', 'contract_lists.pay_status_id', '=', 'pay_statuses.id')
                ->where('pay_statuses.name', 'like', '%'. $term . '%')
                ->groupBy('pay_statuses.id', 'pay_statuses.name')
                ->get()
        ]);
    }
}
