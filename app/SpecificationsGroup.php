<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecificationsGroup extends Model
{
    protected $table = 'specifications_groups';
    protected $fillable = ['name' , 'marketCategory_id'];
    protected $hidden = [ 'created_at' , 'updated_at' , 'deleted_at'] ;
}
