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

Route::get('/', 'ExampleController@index')->name('index');
Route::get('/new', 'ExampleController@create')->name('new');
Route::get('/account/{id}', 'ExampleController@view')->name('view');
Route::post('/account/{id}/buy', 'ExampleController@buy')->name('buy');

