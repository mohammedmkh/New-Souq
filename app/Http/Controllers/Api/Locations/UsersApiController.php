<?php

namespace App\Http\Controllers\Api\Locations;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\Admin\UserResource;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class UsersApiController extends Controller
{


    public  function user(){
        $user = Auth::guard('api')->user();
        $message = __('api.success');
        return jsonResponse(0 , $message  , $user , 200 );
    }

    public function login(Request $request){


        //dd('mm');


        $req = Request::create('/oauth/token', 'POST', $request->all());
        $req->request->add([
            'grant_type'    => $request->grant_type,
            'client_id'     => $request->client_id,
            'client_secret' => $request->client_secret,
            'username'      => $request->username,
            'password'      => $request->password,
            'scope'         => null,
        ]);


        $res = app()->handle($req);

        $json =  (array) json_decode($res->getContent());



        if(isset($json['error'])){
            $message = __('api.wrong_login') ;
            return jsonResponse(1  ,  $message , null , 103);
        }

        //return response( $json );

        $user = User::where('email' ,$request->username)->first();

        /*
        Devicetoken::where('device_token',  $request->device_token )->delete();
        $device = Devicetoken::where('user_id' ,  $user->id)->first();
        if($device){
            // delete other device of that user  or  other users that have this device token
            Devicetoken::where('user_id', $user->id )->where('id' ,'<>' ,$device->id)->delete();
        }else{
            $device =new Devicetoken;
        }
        $device->device_type = $request->device_type ;
        $device->device_token = $request->device_token ;
        $device->user_id = $user->id ;
        $device->save(); */


        $message = __('api.success_login');

        $json['user'] =$user;



        return jsonResponse(0 , $message  , $json , 200 );




    }



    public function logout(Request $request){

        $user = Auth::guard('api')->user() ;

        if($user) {
            //  $divecs_revoke = Devicetoken::where('user_id', $user->id)->delete();
            $revoke = $user->token()->revoke();
        }

        return jsonResponse( 0  , __('api.success') , null,200 );

    }




}
