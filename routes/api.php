<?php




Route::group(['prefix' => 'users', 'as' => 'api.', 'namespace' => 'Api\Users'], function () {

    Route::post('login' , 'UsersApiController@login');
    Route::post('signup' , 'UsersApiController@signUp');

});

Route::group(['prefix' => 'users', 'as' => 'api.', 'namespace' => 'Api\Users', 'middleware' => ['auth:api']], function () {
    // Permissions

    Route::get('user' , 'UsersApiController@user');
    Route::post('logout' , 'UsersApiController@logout');


});




Route::group(['prefix' => 'locations', 'as' => 'api.', 'namespace' => 'Api\Locations', 'middleware' => ['auth:api']], function () {

    Route::resource('countries' , 'CountriesApiController');
    Route::resource('cities' , 'CitiesApiController');
    Route::resource('states' , 'StateApiController');
    Route::resource('currencies' , 'CurrenciesApiController');

    Route::get('get_alllocations' , 'CountriesApiController@getAlllocations');

});

Route::group(['prefix' => 'market', 'as' => 'api.', 'namespace' => 'Api\Market', 'middleware' => ['auth:api']], function () {

    Route::resource('currencies' , 'CurrenciesApiController');

    Route::get('marketcategories' , 'MarketCategoryApiController@index');
    Route::get('marketcategories/{id}' , 'MarketCategoryApiController@show');
    Route::delete('marketcategory/{id}' , 'MarketCategoryApiController@delete');
    Route::post('marketcategory' , 'MarketCategoryApiController@store');
    Route::put('marketcategory/{id}' , 'MarketCategoryApiController@update');


    Route::resource('specificationGroup' , 'SpecificationGroupApiController');
    Route::resource('specificationValue' , 'SpecificationValueApiController');

    Route::resource('stores' , 'StoresApiController');

});


Route::group(['prefix' => 'motors', 'as' => 'api.', 'namespace' => 'Api\Motors', 'middleware' => ['auth:api']], function () {


      Route::get('schools' , 'MotorsApiController@allSchools');
      Route::get('statistic' , 'MotorsApiController@statistic');
      Route::get('allstudents' , 'MotorsApiController@getAllStudents');
      Route::post('getstudentsafter', 'MotorsApiController@getStudentsAfter');
      Route::get('getexamresults/{studentid}', 'MotorsApiController@getExamResults');

    Route::post('updateSchool', 'MotorsApiController@updateSchool');


});



