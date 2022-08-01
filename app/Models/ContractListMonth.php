<?php

namespace App\Models;

use Brackets\Media\HasMedia\AutoProcessMediaTrait;
use Brackets\Media\HasMedia\HasMediaCollectionsTrait;
use Brackets\Media\HasMedia\ProcessMediaTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Brackets\Media\HasMedia\HasMediaThumbsTrait;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


class ContractListMonth extends Model implements HasMedia
{
    use ProcessMediaTrait;
    use AutoProcessMediaTrait;
    use HasMediaCollectionsTrait;
    use HasMediaThumbsTrait;

    protected $fillable = [
        'contract_list_id',
        'month',
        'pay_decode',
        'pay_act',
        'upload_decode_file',
        'download_akt_file',

    ];


    protected $dates = [
        'created_at',
        'updated_at',

    ];

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/contract-list-months/'.$this->getKey());
    }

    public function registerMediaCollections(): void {
        $this->addMediaCollection('decode_file')
            ->accepts('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel')
            ->disk('media') // Specify a disk where to store this collection
            ->private() // Alias to setting default private disk
            ->maxFilesize(2*1024*1024) // Set the file size limit
            ->canView('media.view') // Set the ability (Gate) which is required to view the medium (in most cases you would want to call private())
            ->canUpload('media.upload');
    }
    public function registerMediaConversions(Media $media = null): void
    {
        $this->autoRegisterThumb200();
    }
}
