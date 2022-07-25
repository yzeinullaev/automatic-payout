<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiBranchesController extends Controller
{

    public function index(Request $request)
    {
        // create and AdminListing instance for a specific model and
        $term = '';
        if ($request->term) {
            $term = $request->term;
        }

        return Response([
            'results' =>
                Branch::query()->select([
                    'branches.id',
                    'branches.name as text',
                    DB::raw('case when partners.id is null then false else true end as selected'),
                    DB::raw('case when contract_lists.id is null then false else true end as contract_selected'),
                ])
                ->leftJoin('partners', 'partners.branch_id', '=', 'branches.id')
                ->leftJoin('contract_lists', 'contract_lists.branch_id', '=', 'branches.id')
                ->where('branches.name', 'like', '%'. $term . '%')
                ->groupBy('branches.id', 'branches.name')
                ->get()
        ]);
    }
}
