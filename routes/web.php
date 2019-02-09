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
Route::get('/admin_panel', 'ProductController@admin');
Route::get('/admin_panel/create', 'ProductController@create');
Route::post('/admin_panel', 'ProductController@store');
Route::get('/admin_panel/show/{id}', 'ProductController@show');
Route::get('/admin_panel/edit/{id}', 'ProductController@edit');
Route::post('/admin_panel/update/{id}', 'ProductController@update');
Route::get('/admin_panel/delete/{id}', 'ProductController@destroy');
Route::get('/admin_panel/mass_delete', 'ProductController@massDestroy');
Route::get('/admin_panel/taxes', 'TaxController@index');
Route::post('/admin_panel/taxes/create', 'TaxController@store');
Route::post('/admin_panel/taxes/update', 'TaxController@update');

//User routes
Route::view('/','front_end.products.products');


