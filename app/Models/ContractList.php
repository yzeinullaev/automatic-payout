<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractList extends Model
{
    protected $fillable = [
        'branch_id',
        'contract_number',
        'start_contract_date',
        'end_contract_date',
        'partner_id',
        'partner_bin',
        'agent_id',
        'pay_status_id',
        'pay_type_id',
        'agent_fee',
        'enabled',

    ];


    protected $dates = [
        'created_at',
        'updated_at',

    ];

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/contract-lists/'.$this->getKey());
    }

    /* ************************ RELATIONS ************************* */

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function payStatus()
    {
        return $this->belongsTo(PayStatus::class);
    }

    public function payType()
    {
        return $this->belongsTo(PayType::class);
    }
}
