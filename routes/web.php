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
Route::get('/admin_panel', 'HomeController@index');
Route::get('/create', 'ProductController@create');
Route::post('/store', 'ProductController@store');
Route::get('/edit/{product}', 'ProductController@edit');
Route::post('/update/{product}', 'ProductController@update');
Route::get('/delete/{product}', 'HomeController@delete');

//User routes
Route::get('/', 'ProductController@index');
Route::get('/products', 'ProductController@products');


