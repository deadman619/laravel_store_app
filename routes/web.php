<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Authentication routes + CRUD
Auth::routes();
Route::resource('admin_panel', 'ProductController');
Route::get('/admin_panel', 'ProductController@admin');
Route::post('/admin_panel/{id}/update', 'ProductController@update');
Route::get('/admin_panel/{id}/delete', 'ProductController@destroy');
Route::get('/mass_delete', 'ProductController@massDestroy');


//User routes
Route::get('/', 'ProductController@index');
Route::get('/products', 'ProductController@products');
Route::get('/products/{id}', 'ProductController@show');


