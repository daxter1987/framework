<?php

Route::group(['namespace' => 'daxter1987\Framework\Controllers', 'middleware' => ['api'], 'prefix' => 'api'], function(){
    Route::get('framework', 'FrameworkController@showAvailableModels');
    Route::get('framework/view/{model}', 'FrameworkController@paginate');
    Route::get('framework/edit/{model}/{id}', 'FrameworkController@edit');
    Route::get('framework/create/{model}', 'FrameworkController@create');
    Route::post('framework/submit/{model}', 'FrameworkController@submit');
    Route::post('framework/patch/{model}/{id}', 'FrameworkController@patch');
    Route::get('framework/delete/{model}/{id}', 'FrameworkController@delete_form');
    Route::post('framework/delete/{model}/{id}', 'FrameworkController@delete');
    Route::get('framework/{model}/{id}', 'FrameworkController@show');
    Route::get('framework/{model}', 'FrameworkController@index');
    Route::post('framework/{model}/{id}', 'FrameworkController@update');
    Route::post('framework/{model}', 'FrameworkController@store');
    Route::delete('framework/{model}/{id}', 'FrameworkController@destroy');
});
