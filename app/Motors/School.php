<?php

namespace App\Motors;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class School extends Model
{
    use SoftDeletes;

    public $table = 'schools';
    protected $connection = 'mysql_motors';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'phone',
        'expire_date',
        'mobile',
        'is_trial',
        'created_at',
        'updated_at',
        'deleted_at',
        'school_name',
        'expire_date_oral',
        'city',
        'background' ,
        'address' ,
        'messenger' ,
        'youtube' ,
        'whatsapp'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');

    }



    protected $appends = [ 'status_name'];

    public function getStatusNameAttribute()
    {
        $now = Carbon::now()->toDateString() ;
        if($this->is_trial == 1 )
            return 'غير مشترك';

        if($this->is_trial == 2 ){
            if($this->expire_date != '' && $this->expire_date_oral != '' ){

                return 'مشترك تحريري وشفوي ';

            }


            if($this->expire_date != ''  ){

                return 'مشترك تحريري  ';

            }

            if($this->expire_date_oral != ''  ){

                return 'مشترك شفوي  ';

            }
        }


            return trans('auth.subscription') ;




    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');

    }

}
