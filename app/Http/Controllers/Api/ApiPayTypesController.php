<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Models\PayType;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ApiPayTypesController extends Controller
{

    public function index(Request $request)
    {
        $term = '';
        if ($request->term) {
            $term = $request->term;
        }

        return Response([
            'results' =>
                PayType::query()->select([
                    'pay_types.id',
                    'pay_types.name as text',
                    DB::raw('case when contract_lists.id is null then false else true end as contract_selected'),
                ])
                ->leftJoin('contract_lists', 'contract_lists.pay_type_id', '=', 'pay_types.id')
                ->where('pay_types.name', 'like', '%'. $term . '%')
                ->groupBy('pay_types.id', 'pay_types.name')
                ->get()
        ]);
    }
}
