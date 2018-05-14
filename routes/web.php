<?php


Route::group(['prefix' => 'api/v1'], function(){
    Route::resource('products','ProductsController',[
    'expect' => ['edit','create']
    ]);
    
});


