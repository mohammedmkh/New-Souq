<?php

namespace App\Http\Controllers\Api\Market;

use App\Http\Controllers\Controller;
use App\SpecificationsGroup;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use \Validator;

class SpecificationGroupApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $message = __('api.success');
        $specificationGroups = SpecificationsGroup::get();

        return jsonResponse(0 , $message  , $specificationGroups , 200 );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);


        if ($validator->fails()) {
            return jsonResponse( 1  , __('api.item_not_exist'),null , 105 , null ,null , $validator);
        }

        $specificationGroups = new SpecificationsGroup;
        $specificationGroups->name = $request->name ;
        $specificationGroups->marketCategory_id = $request->marketCategory_id ;
        $specificationGroups->save();

        $message = __('api.success');
        return jsonResponse( 0  , $message, $specificationGroups , 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $specificationGroups = SpecificationsGroup::where('marketCategory_id' , $id)->get();


        $message = __('api.success');
        return jsonResponse( 0  , $message, $specificationGroups  , 200);
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


        $specificationGroups = SpecificationsGroup::where('id',$id)->first();
        if($specificationGroups){
            if(isset($request->name))
                $specificationGroups->name = $request->name ;

            $specificationGroups->save();

            $message = __('api.success');
            return jsonResponse( 0  , $message,$specificationGroups , 200);
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
        $specificationGroups = SpecificationsGroup::where('id' , $id)->delete();
        $message = __('api.success');
        return jsonResponse( 0  , $message, null  , 200);

    }

}
