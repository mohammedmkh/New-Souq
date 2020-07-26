<?php

namespace App\Motors;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class Student extends Model
{
    use SoftDeletes;

    public $table = 'students';
    protected $connection = 'mysql_motors';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    protected $appends = ['teacher_id'] ;

    public function getTeacherIdAttribute()
    {

         $st_t = Studentsteacher::where('student_id' , $this->id)->first();
         if(  $st_t )
              return (int) $st_t->teacher_id ;

         return 0 ;




    }


    protected $fillable = [
        'name',
         'second_name',
        'third_name',
        'family_name',
        'mobile',
        'identity',
        'license_type' ,
        'deviceid',
        'school_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'type_app' ,
        'exam_count'
    ];



    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');

    }

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');

    }

    public function exam()
    {
        return $this->hasMany(Exam::class, 'student_di' , 'id');

    }
}
