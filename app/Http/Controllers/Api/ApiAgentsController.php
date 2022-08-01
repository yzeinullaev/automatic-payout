<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Partner;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ApiAgentsController extends Controller
{

    public function getByContractId($contractId, Request $request)
    {
        return Response([
            'results' =>
                Agent::query()->select([
                    'agents.id',
                    'agents.name as text',
                ])
                ->leftJoin('contract_lists', 'contract_lists.agent_id', '=', 'agents.id')
                ->where('contract_lists.id', $contractId)
                ->get()
        ]);
    }

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
                ])
                    ->leftJoin('contract_lists', 'contract_lists.agent_id', '=', 'agents.id')
                    ->where('agents.name', 'like', '%'. $term . '%')
                    ->groupBy('agents.id', 'agents.name')
                    ->get()
        ]);
    }
}
