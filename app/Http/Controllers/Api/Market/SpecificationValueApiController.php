<?php

namespace App\Http\Controllers\Api\Market;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\SpecificationsValue;
use Validator;

class SpecificationValueApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $message = __('api.success');
        $specificationValues = SpecificationsValue::get();

        return jsonResponse(0 , $message  , $specificationValues , 200 );
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'value' => 'required',
        ]);


        if ($validator->fails()) {
            return jsonResponse( 1  , __('api.item_not_exist'),null , 105 , null ,null , $validator);
        }

        $specificationValues = new SpecificationsValue;
        $specificationValues->value = $request->value ;
        $specificationValues->group_id = $request->group_id ;
        $specificationValues->save();

        $message = __('api.success');
        return jsonResponse( 0  , $message, $specificationValues , 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $specificationValues = SpecificationsValue::where('group_id' , $id)->get();


        $message = __('api.success');
        return jsonResponse( 0  , $message, $specificationValues  , 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        $specificationValues = SpecificationsValue::where('id',$id)->first();
        if($specificationValues){
            if(isset($request->value))
                $specificationValues->value = $request->value ;

            $specificationValues->save();

            $message = __('api.success');
            return jsonResponse( 0  , $message,$specificationValues , 200);
        }
        $message = __('api.error');
        return jsonResponse( 2 , $message, null , 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $specificationValues = SpecificationsValue::where('id' , $id)->delete();
        $message = __('api.success');
        return jsonResponse( 0  , $message, null  , 200);

    }

}

