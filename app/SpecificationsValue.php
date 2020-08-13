<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecificationsValue extends Model
{
    protected $table = 'specifications_values';
    protected $fillable = ['value' , 'group_id'];
    protected $hidden = [ 'created_at' , 'updated_at' , 'deleted_at'] ;
}
