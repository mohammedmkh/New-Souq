<?php

namespace App\Http\Controllers\Api\V1;

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

class CitiesApiController extends Controller
{


    public function index()
    {

       // dd('mm');
        $message= __('api.success');
        $cities = Cities::get();

        return jsonResponse(0 , $message  , $cities , 200 );

    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'country_id' => 'required',

        ]);


        if ($validator->fails()) {
            return jsonResponse( 1  , __('api.item_not_exist'),null , 105 , null ,null , $validator);
        }

        $city = new Cities();
        $city->name = $request->name ;
        $city->country_id = $request->country_id ;
        $city->save();

        $message = __('api.success');
        return jsonResponse( 0  , $message, $city , 200);


    }

    public function show($id)
    {

       // dd($id);
        $cities = Cities::where('country_id' ,$id)->get();


        $message = __('api.success');
        return jsonResponse( 0  , $message, $cities  , 200);
    }

    public function update(Request $request ,$id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);


        if ($validator->fails()) {
            return jsonResponse( 1  , __('api.item_not_exist'),null , 105 , null ,null , $validator);
        }

        $city = Cities::where('id',$id)->first();
        if( $city){
            $city->name = $request->name ;
            $city->save();

            $message = __('api.success');
            return jsonResponse( 0  , $message,$city , 200);
        }
        $message = __('api.error');
        return jsonResponse( 2 , $message, null , 200);

    }


    public function destroy(Request $request ,$id)
    {

       // dd($id);
        $citiy = Cities::where('id' , $id)->delete();
        $message = __('api.success');
        return jsonResponse( 0  , $message, null  , 200);

    }


}
