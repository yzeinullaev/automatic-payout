<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Partner;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ApiAgentsController extends Controller
{

    public function index(Request $request)
    {
        $term = '';
        if ($request->term) {
            $term = $request->term;
        }

        return Response([
            'results' =>
                Agent::query()->select([
                    'agents.id',
                    'agents.name as text',
                    DB::raw('case when agents.id is null then false else true end as selected'),
                    DB::raw('case when contract_lists.id is null then false else true end as contract_selected'),
                ])
                ->leftJoin('partners', 'agents.partner_id', '=', 'partners.id')
                ->leftJoin('contract_lists', 'contract_lists.agent_id', '=', 'agents.id')
                ->where('agents.name', 'like', '%'. $term . '%')
                ->groupBy('agents.id', 'agents.name')
                ->get()
        ]);
    }
}
