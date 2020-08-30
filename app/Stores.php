<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stores extends Model
{
    public $table = 'stores';

    protected $fillable = ['name' , 'creator_id' , 'description' , 'city_id' ,'phone' , 'mobile' ,
        'payment_info_id' , 'working_times_info_id' , 'shipping_info_id' , 'location_info_id' , 'default-currency-id'] ;

    protected $hidden = [ 'created_at' , 'updated_at' , 'deleted_at'] ;

    public function city()
    {
        return $this->belongsTo(Cities::class, 'id' ,'city_id');
    }


}
