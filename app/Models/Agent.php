<?php

namespace App\Models;

use Brackets\Translatable\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasTranslations;

    public $translatable = ['ru'];

    protected $fillable = [
        'name',
        'initials',
        'iin',
        'address',
        'requisite',
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
        return url('/admin/agents/'.$this->getKey());
    }
}
