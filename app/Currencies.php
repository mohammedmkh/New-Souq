<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currencies extends Model
{
    public $table = 'currencies';

    protected $fillable = ['name' , 'abbreviation' , 'symbol'] ;

    protected $hidden = [ 'created_at' , 'updated_at' , 'deleted_at'] ;
}
