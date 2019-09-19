<?php

Route::group(['namespace' => 'daxter1987\Framework\Controllers', 'middleware' => ['api']], function(){
    Route::resource('framework', 'FrameworkController');
});
