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

Route::post('attempt', 'AuthController@grantToken');
Route::post('grant', 'AuthController@register');
Route::group(['middleware' => 'auth:api'], function () {
  Route::get('/test', function (Request $request) {
    return $request->user();
  });
});
