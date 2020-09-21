<?php
  
Route::group(['namespace' => 'Aman5537jains\SeoManager\Http\controllers','domain' => '{prefix_url}.jiunge.com/'], function(){
    Route::get('/sds', 'SeoManager2Controller@show');
  
    
    // Route::post('contact', 'ContactFormController@sendMail')->name('contact');
});
Route::group(['namespace' => 'Aman5537jains\SeoManager\Http\controllers'], function(){
    Route::get('seo-manager', 'SeoManager2Controller@show');
    Route::get('seo-manager/add', 'SeoManager2Controller@add');
    Route::get('seo-manager/edit/{id}', 'SeoManager2Controller@add');
    Route::get('seo-manager/suggestions', 'SeoManager2Controller@suggestions');
    
    Route::post('seo-manager/add-post', 'SeoManager2Controller@addPost');
    Route::get('w/{w}/{p?}', 'SeoManager2Controller@checkurl');
    Route::get('s/{w}/{p}', 'SeoManager2Controller@checkurl');
    Route::get('pages/{page}', 'SeoManager2Controller@checkurl');
    Route::get('pages/{page}', 'SeoManager2Controller@checkurl');
    
    // Route::post('contact', 'ContactFormController@sendMail')->name('contact');
});