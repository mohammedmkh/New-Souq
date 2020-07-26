<?php

namespace App\Motors;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class Studentsteacher extends Model
{
    use SoftDeletes;

    public $table = 'students_teacher';
    protected $connection = 'mysql_motors';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [

    ];


}
