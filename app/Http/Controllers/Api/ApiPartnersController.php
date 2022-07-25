<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ApiPartnersController extends Controller
{

    public function index(Request $request)
    {
        $term = '';
        if ($request->term) {
            $term = $request->term;
        }

        return Response([
            'results' =>
                Partner::query()->select([
                    'partners.id',
                    'partners.name as text',
                    DB::raw('case when agents.id is null then false else true end as selected'),
                    DB::raw('case when contract_lists.id is null then false else true end as contract_selected'),
                ])
                ->leftJoin('agents', 'agents.partner_id', '=', 'partners.id')
                ->leftJoin('contract_lists', 'contract_lists.partner_id', '=', 'partners.id')
                ->where('partners.name', 'like', '%'. $term . '%')
                ->groupBy('partners.id', 'partners.name')
                ->get()
        ]);
    }

    public function getBin($partnerId)
    {
        return Response(
            Partner::query()->select([
                'partners.id',
                'partners.bin'
            ])
                ->where('partners.id', $partnerId)
                ->first()
        );
    }

    public function getAllBin()
    {
        return Response(
            Partner::query()->select([
                'partners.id',
                'partners.bin'
            ])->get()
        );
    }
}
