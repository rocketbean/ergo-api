<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Service Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Service API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "Service" middleware group. Enjoy building your API!
|
*/

Route::post('attempt/{supplier}', 'AuthController@getAuthenticatedUser');
Route::post('grant', 'AuthController@register');
Route::post('sess', 'SessionController@index');
Route::post('sessget', 'SessionController@get');
Route::group(['prefix' => '{supplier}','middleware' => ['auth:service']], function () {
  Route::get('fetch', 'ServiceController@index');
  Route::group(['prefix' => 'stream'], function () {
    Route::get('', 'StreamController@index');
  });
}); 
