<?php

namespace App\Http\Controllers\Api\V1;

use App\States;
use App\Cities;
use App\Countries;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\Admin\ProductResource;
use App\Product;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use \Validator;

class StateApiController extends Controller
{


    public function index()
    {

        //dd('mm');
        $message = __('api.success');
        $states = States::get();

        return jsonResponse(0 , $message  , $states , 200 );

    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'city_id' => 'required',

        ]);


        if ($validator->fails()) {
            return jsonResponse( 1  , __('api.item_not_exist'),null , 105 , null ,null , $validator);
        }

        $state = new States();
        $state->name = $request->name ;
        $state->city_id = $request->city_id ;
        $state->save();

        $message = __('api.success');
        return jsonResponse( 0  , $message, $state , 200);


    }

    public function show($id)
    {

       // dd($id);
        $states = States::where('city_id' ,$id)->get();


        $message = __('api.success');
        return jsonResponse( 0  , $message, $states  , 200);
    }

    public function update(Request $request ,$id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',

        ]);


        if ($validator->fails()) {
            return jsonResponse( 1  , __('api.item_not_exist'),null , 105 , null ,null , $validator);
        }

        $state = States::where('id',$id)->first();
        if( $state){
            $state->name = $request->name ;
            $state->save();

            $message = __('api.success');
            return jsonResponse( 0  , $message,$state , 200);
        }
        $message = __('api.error');
        return jsonResponse( 2 , $message, null , 200);

    }


    public function destroy(Request $request ,$id)
    {

       // dd($id);
        $state = States::where('id' , $id)->delete();
        $message = __('api.success');
        return jsonResponse( 0  , $message, null  , 200);

    }


}
