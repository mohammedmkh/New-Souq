<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreProductCategoryRequest;
use App\Http\Requests\UpdateProductCategoryRequest;
use App\Http\Resources\Admin\ProductCategoryResource;
use App\MarketCategory;
use App\ProductCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;
class MarketCategoryApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {

        $message= __('api.success');
        $market_categories = MarketCategory::where('parent_id' , 0)->get();

        return jsonResponse(0 , $message  , $market_categories , 200 );

    }

    public function store(Request $request)
    {
        $user = Auth::guard('api')->user();
        if(!$user->is_admin()){
            $message= __('api.error_perm');
            return jsonResponse(1 , $message  ,   null , 100 );
        }
        $productCategory = MarketCategory::create($request->all());
        $message= __('api.success');
        return jsonResponse(0 , $message  ,    $productCategory , 200 );

    }

    public function show($id)
    {
        $message= __('api.success');
        $market_categories = MarketCategory::where('parent_id' , $id )->get();



        foreach ( $market_categories as $cat){
            $level_2 = MarketCategory::where('parent_id' , $cat->id)->get();
            if( count($level_2) > 0 ){
                $cat->children = $level_2 ;
            }


            foreach ( $level_2 as $level3){
                $level_3 = MarketCategory::where('parent_id' , $level3->id)->get();
                if( count($level_3) > 0 ){
                    $level3->children = $level_3 ;
                }

            }
        }

        return jsonResponse(0 , $message  , $market_categories , 200 );


    }


    public function delete(Request $request){
        $user = Auth::guard('api')->user();
        if(!$user->is_admin()){
            $message= __('api.error_perm');
            return jsonResponse(1 , $message  ,   null , 100 );
        }

        $message= __('api.success');
         MarketCategory::where('id' , $request->id)->delete();
        return jsonResponse(0 , $message  , null , 200 );

    }


    public function update(Request $request ,$id){

        $user = Auth::guard('api')->user();
        if(!$user->is_admin()){
            $message= __('api.error_perm');
            return jsonResponse(1 , $message  ,   null , 100 );
        }

        $message= __('api.success');
        $market_category = MarketCategory::where('id' , $id)->update($request->all());


        return jsonResponse(0 , $message  , null , 200 );

    }



}
