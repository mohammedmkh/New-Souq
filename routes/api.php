<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1', 'middleware' => ['auth:api']], function () {
    // Permissions

    Route::get('user' , 'UsersApiController@user');
    Route::post('logout' , 'UsersApiController@logout');
    Route::get('marketcategories' , 'MarketCategoryApiController@index');
    Route::get('marketcategories/{id}' , 'MarketCategoryApiController@show');
    Route::delete('marketcategory' , 'MarketCategoryApiController@delete');
    Route::post('marketcategory' , 'MarketCategoryApiController@store');
    Route::put('marketcategory/{id}' , 'MarketCategoryApiController@update');


    Route::resource('countries' , 'CountriesApiController');
    Route::resource('cities' , 'CitiesApiController');
    Route::resource('states' , 'StateApiController');
    Route::resource('currencies' , 'CurrenciesApiController');


});


Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1'], function () {



    Route::post('login' , 'UsersApiController@login');



});
