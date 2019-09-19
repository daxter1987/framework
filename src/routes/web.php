<?php

Route::group(['namespace' => 'daxter1987\Framework\Controllers', 'middleware' => ['api'], 'prefix' => 'api'], function(){
    Route::get('framework/{model}/{id}', 'FrameworkController@show');
    Route::get('framework/{model}', 'FrameworkController@index');
    Route::post('framework/{model}/{id}', 'FrameworkController@update');
    Route::post('framework/{model}', 'FrameworkController@store');
    Route::delete('framework/{model}/{id}', 'FrameworkController@destroy');
});
