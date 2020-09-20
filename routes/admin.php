<?php 


Route::prefix('/admin')->group(function () {
    Route::get('/','Admin\DashboardController@getDashboard');
    Route::get('/users','Admin\UsersController@getUsers');
    
    //modelo de productos
    
    Route::get('/products','Admin\ProductController@getHome');
    Route::get('/products/add','Admin\ProductController@getProductAdd');
    Route::post('/product/add','Admin\ProductController@postProductAdd');
    //categories
    Route::get('/categories/{module}','Admin\CategoriesController@getHome');
    Route::post('/category/add','Admin\CategoriesController@postCategoriesAdd');
    Route::get('/category/{id}/edit','Admin\CategoriesController@getCategoriesEdit');
    Route::post('/category/{id}/edit','Admin\CategoriesController@postCategoriesEdit');
    Route::get('/category/{id}/delete','Admin\CategoriesController@getCategoriesDelete');
});