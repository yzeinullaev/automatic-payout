<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayType extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'perex',
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
        return url('/admin/pay-types/'.$this->getKey());
    }
}
