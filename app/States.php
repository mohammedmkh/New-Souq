<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class States extends Model
{
    public $table = 'states';

    protected $fillable = ['name'] ;

    protected $hidden = [ 'created_at' , 'updated_at' , 'deleted_at'] ;
}
