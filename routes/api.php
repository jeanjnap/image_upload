<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('photos/400x400', 'PhotoController@store');
Route::get('photos', 'PhotoController@index');
Route::get('photos/{id}', 'PhotoController@show');