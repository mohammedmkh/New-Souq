<?php

namespace App\Http\Controllers\Api\V1;

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

class CountriesApiController extends Controller
{


    public function index()
    {


        $message = __('api.success');
        $countries = Countries::get();

        return jsonResponse(0 , $message  , $countries , 200 );

    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);


        if ($validator->fails()) {
            return jsonResponse( 1  , __('api.item_not_exist'),null , 105 , null ,null , $validator);
        }

        $country = new Countries;
        $country->name = $request->name ;
        $country->save();

        $message = __('api.success');
        return jsonResponse( 0  , $message, $country , 200);


    }

    public function show(Product $product)
    {
        abort_if(Gate::denies('product_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProductResource($product->load(['categories', 'tags']));
    }

    public function update(Request $request ,$id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',

        ]);


        if ($validator->fails()) {
            return jsonResponse( 1  , __('api.item_not_exist'),null , 105 , null ,null , $validator);
        }

        $country = Countries::where('id',$id)->first();
        if( $country){
            $country->name = $request->name ;
            $country->save();

            $message = __('api.success');
            return jsonResponse( 0  , $message,$country , 200);
        }
        $message = __('api.error');
        return jsonResponse( 2 , $message, null , 200);

    }

    public function destroy($id)
    {

        $country = Countries::where('id' , $id)->delete();
        $message = __('api.success');
        return jsonResponse( 0  , $message, null  , 200);

    }


}
