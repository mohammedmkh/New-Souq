<?php

namespace App\Motors;

use Illuminate\Database\Eloquent\Model;

use \DateTimeInterface;

class Exam extends Model
{


    public $table = 'exam_marks';
    protected $connection = 'mysql_motors';
    public $timestamps = false ;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'student_id',
        'school_id',
        'mark',
        'answers' ,
        'exam_type',
        'created_at',
        'updated_at',
        'deleted_at',
        'total',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');

    }



    public  function getAnswersAttribute($value){
        if($value == null){
            return '' ;
        }

        return $value;
    }





    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');

    }

}
