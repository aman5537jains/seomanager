<?php
 
Route::group(['namespace' => 'Aman\SeoManager\Http\controllers'], function(){
    Route::get('seo-manager', 'SeoManager2Controller@show');
    Route::get('seo-manager/add', 'SeoManager2Controller@add');
    Route::get('seo-manager/edit/{id}', 'SeoManager2Controller@add');
    
    Route::post('seo-manager/add-post', 'SeoManager2Controller@addPost');
    Route::get('w/{w}/{p}', 'SeoManager2Controller@checkurl');
    Route::get('s/{w}/{p}', 'SeoManager2Controller@checkurl');
    Route::get('pages/{page}', 'SeoManager2Controller@checkurl');
    Route::get('pages/{page}', 'SeoManager2Controller@checkurl');
    
    // Route::post('contact', 'ContactFormController@sendMail')->name('contact');
});