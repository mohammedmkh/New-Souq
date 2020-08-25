<?php

namespace App\Http\Controllers\Api\Market;

use App\Currencies;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\Admin\ProductResource;
use App\Product;
use App\Stores;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use \Validator;
use Auth;

class StoresApiController extends Controller
{


    public function index()
    {

        // dd('mm');
        $message = __('api.success');
        $currencies = Stores::get();

        return jsonResponse(0 , $message  , $currencies , 200 );

    }

    public function store(Request $request)
    {

        $user = Auth::guard('api')->user();
        $validator = Validator::make($request->all(), [
            'name' => 'required',

        ]);


        if ($validator->fails()) {
            return jsonResponse( 1  , __('api.item_not_exist'),null , 105 , null ,null , $validator);
        }

        $Stores = Stores::create($request->all());
        $Stores->creator_id = $user->id ;

        $Stores->save();

        $message = __('api.success');
        return jsonResponse( 0  , $message,   $Stores, 200);


    }

    public function show($id)
    {

        // dd($id);
//        $states = States::where('city_id' ,$id)->first();
//
//
//        $message = __('api.success');
//        return jsonResponse( 0  , $message, $states  , 200);
    }

    public function update(Request $request ,$id)
    {


        $store = Stores::where('id' ,$id)->first();
        if($store){
            $store->update($request->all());
            $message = __('api.success');
              return jsonResponse( 0  , $message, $store  , 200);
        }

        $message = __('api.error');
        return jsonResponse( 2 , $message, null , 200);

    }


    public function destroy(Request $request ,$id)
    {


        $stores = Stores::where('id' , $id)->delete();
        $message = __('api.success');
        return jsonResponse( 0  , $message, null  , 200);

    }


}
