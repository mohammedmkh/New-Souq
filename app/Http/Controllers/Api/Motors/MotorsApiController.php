<?php

namespace App\Http\Controllers\Api\Motors;

use App\Cities;
use App\Countries;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\Admin\ProductResource;
use App\Motors\School;
use App\Product;
use Carbon\Carbon;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use \Validator;
use DB;
class MotorsApiController extends Controller
{


    public function allSchools()
    {

        $message= __('api.success');
        $schools = DB::connection('mysql_motors')->select('select * from schools where deleted_at is null and id != 14');

        return jsonResponse(0 , $message  ,  $schools , 200 );

    }

    public function statistic(Request $request){

        $now = Carbon::now()->toDateString() ;
        $total_schools = DB::connection('mysql_motors')->table('schools')->where('id' ,'<>',14)->whereNull('deleted_at')->count();

       // dd( $total_schools);
        $active_schools = DB::connection('mysql_motors')->table('schools')->where('id' ,'<>',14)->whereNull('deleted_at')->where('is_trial',2)->where('expire_date' , '>' , $now)->count();
        
        $trial_active = DB::connection('mysql_motors')->table('schools')->where('id' ,'<>',14)->whereNull('deleted_at')->where('is_trial',1)->where('expire_date' , '>' , $now)->count();
        
        $expired_schools = DB::connection('mysql_motors')->table('schools')->whereNull('deleted_at')->where('id' ,'<>',14)->where('expire_date' , '<' , $now)->count();


            $total_students = DB::connection('mysql_motors')->table('students')->whereNull('deleted_at')->count();
            $total_students_app_1 = DB::connection('mysql_motors')->table('students')->whereNull('deleted_at')->where('type_app' ,1) ->count();
            $total_students_app_2 = DB::connection('mysql_motors')->table('students')->whereNull('deleted_at')->where('type_app' ,2) ->count();

             

            $total_exams = DB::connection('mysql_motors')->table('exam_marks')->where('school_id' ,'<>',14)->count();
            $total_exams_today  = DB::connection('mysql_motors')->table('exam_marks')->whereDate('datetime', $now)->where('school_id' ,'<>',14)->count();



        $total_students_today = DB::connection('mysql_motors')->table('students')->whereDate('created_at' , $now)->count();

        $data = [
            
            'total_schools' =>$total_schools ,
            'active_schools' => $active_schools ,
            'trial_active' => $trial_active ,
            'expired_schools' => $expired_schools ,
            'total_students' => $total_students ,
            'total_students_app_1' => $total_students_app_1 ,
            'total_students_app_2' => $total_students_app_2 ,
            'total_exams'  => $total_exams ,
            'total_exams_today' => $total_exams_today ,
            'total_students_today' => $total_students_today


        ];

        $message= __('api.success');
        return jsonResponse(0 , $message  ,  $data , 200 );
    }
    
    
      public  function getAllStudents(Request $request){

        $students = \App\Motors\Student::with('school');
        $students = $students->get();

        $message= __('api.success');
        return jsonResponse(0 , $message  ,  $students , 200 );


     }
     
     
    public function getStudentsAfter( Request $request ){


                  if($request->has('after')){
                             $time = Carbon::parse((integer)$request->after)->toDateTimeString();
                             $students = \App\Motors\Student::with('school')->where('updated_at' , '>=' , $time)->get();


                        $message= __('api.success');
                        return jsonResponse(0 , $message  ,  $students  , 200 );


                    }



        $message = __('api.error');
        return jsonResponse(1 , $message  ,  null , 200 );

    }


    public function getExamResults($studentid){


        $total_exams  = DB::connection('mysql_motors')
            ->table('exam_marks')->where('student_id' , $studentid)->orderBy('id' , 'desc')->get();



        $message= __('api.success');
        return jsonResponse(0 , $message  , $total_exams   , 200 );
    }



    public function updateSchool(Request $request){
        $school = School::where('id' , $request->school_id)->first();
        if($school){
            $school->update($request->all());

            if($request->is_oral_app == 1){
                $school->expire_date_oral	= null ;
                $school->save();
            }

            if($request->is_oral_app == 2){
                $school->expire_date_oral	= $request->expire_date_oral ;
                $school->expire_date = null ;
                $school->save();
            }

            if($request->is_oral_app == 3){
                $school->expire_date_oral	= $request->expire_date_oral ;
                $school->expire_date = $request->expire_date ;
                $school->save();
            }


            $message= __('api.success');
            return jsonResponse(0 , $message  , $school   , 200 );
        }


        $message = __('api.error');
        return jsonResponse(1 , $message  ,  null , 200 );

    }




}
