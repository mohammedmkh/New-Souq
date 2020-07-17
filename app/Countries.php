<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    public $table = 'countries';

    protected $fillable = ['name'] ;

    protected $hidden = [ 'created_at' , 'updated_at' , 'deleted_at'] ;
}
