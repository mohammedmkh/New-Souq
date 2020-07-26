<?php

namespace App\Http\Controllers\Api\Market;

use App\Currencies;
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

class CurrenciesApiController extends Controller
{


    public function index()
    {

        // dd('mm');
        $message = __('api.success');
        $currencies = Currencies::get();

        return jsonResponse(0 , $message  , $currencies , 200 );

    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'abbreviation' => 'required' ,
            'symbol' => 'required' ,
        ]);


        if ($validator->fails()) {
            return jsonResponse( 1  , __('api.item_not_exist'),null , 105 , null ,null , $validator);
        }

        $currencies = new Currencies;
        $currencies->name = $request->name ;
        $currencies->abbreviation = $request->abbreviation ;
        $currencies->symbol = $request->symbol ;
        $currencies->save();

        $message = __('api.success');
        return jsonResponse( 0  , $message, $currencies , 200);


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


        $currencies = Currencies::where('id',$id)->first();
        if($currencies){
            if(isset($request->name))
                $currencies->name = $request->name ;
            if(isset($request->abbreviation))
               $currencies->abbreviation = $request->abbreviation ;

            if(isset($request->abbreviation))
                $currencies->symbol = $request->symbol ;

            $currencies->save();

            $message = __('api.success');
            return jsonResponse( 0  , $message,$currencies , 200);
        }
        $message = __('api.error');
        return jsonResponse( 2 , $message, null , 200);

    }


    public function destroy(Request $request ,$id)
    {


        $currencies = Currencies::where('id' , $id)->delete();
        $message = __('api.success');
        return jsonResponse( 0  , $message, null  , 200);

    }


}
