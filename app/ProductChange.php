<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class ProductChange extends Model implements HasMedia
{
    use SoftDeletes , HasMediaTrait;

    public $table = 'product_changes';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'product_id',
        'change-type',
        'new-title',
        'new-photos',
        'new-description',
        'new-price',
        'new-currency_id',
        'new-status',
        'new-category_id',
        'new-specifications',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
