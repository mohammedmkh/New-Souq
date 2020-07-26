<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    public $table = 'cities';

    protected $fillable = ['name'] ;

    protected $hidden = [ 'created_at' , 'updated_at' , 'deleted_at'] ;

    public function states()
    {
        return $this->hasMany(States::class, 'city_id' ,'id');
    }


}
