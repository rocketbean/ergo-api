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
Route::post('attempt','AuthController@login');
Route::post('register','RegistrationController@register');
Route::post('firstUser', 'CoreController@createFirstUser')->middleware('core.configure');
Route::post('photological', 'CoreController@assignPhotos')->middleware('core.configure');
Route::post('assigntags', 'CoreController@assignTags')->middleware('core.configure');

Route::group(['middleware' => 'jwt.auth'], function () {
  Route::group(['prefix' => 'ergo'], function () {
    Route::get('countries', 'CoreController@countries');
    Route::get('tags', 'CoreController@tags');
  });
  /*
    Photos
  */
  Route::group(['prefix' => 'photos'], function () {
    Route::post('store', 'PhotoController@store');
  });

  Route::group(['prefix' => 'uploads'], function () {
    Route::group(['prefix' => 'files'], function () {
      Route::post('store', 'FileController@store');
    });
  });

  /*
    jobrequests
  */
  Route::group(['prefix' => 'jobrequests'], function () {
    Route::group(['prefix' => '{jr}'], function () {
      Route::group(['prefix' => 'items/{item}'], function () {
        Route::group(['prefix' => 'photos/{photo}'], function () {
          Route::post('attach', 'JobRequestItemController@attachPhoto');
        });
      });
    });
  });

  /*
    properties
  */
  Route::group(['prefix' => 'properties'], function () {
    Route::post('', 'PropertyController@index');
    Route::post('store', 'PropertyController@store');
    Route::group(['prefix' => '{property}'], function () {
      Route::post('show', 'PropertyController@show');
      Route::group(['prefix' => 'tag'], function () {
        Route::post('{tag}/attach', 'PropertyController@attach');
      });
      Route::group(['prefix' => 'jobrequests'], function () {
        Route::post('store', 'JobRequestController@store');
        Route::group(['prefix' => '{jr}'], function () {
          Route::post('/', 'JobRequestController@index');
          Route::post('publish', 'JobRequestController@publish');
          Route::post('items/store', 'JobRequestItemController@store');
        });
      });
      Route::group(['prefix' => 'locations'], function () {
        Route::get('/', 'LocationController@index');
        Route::post('store', 'LocationController@store');
      });
    });
  });

  /*
    suppliers
  */
  Route::group(['prefix' => 'suppliers'], function () {
    Route::post('store', 'SupplierController@store');
    Route::group(['prefix' => '{supplier}'], function () {

      Route::group(['prefix' => 'tag'], function () {
        Route::post('{tag}/attach', 'SupplierController@attach');
      });

      Route::group(['prefix' => 'properties'], function () {
        Route::group(['prefix' => '{property}'], function () {
          Route::group(['prefix' => 'jobrequests'], function () {
            Route::group(['prefix' => '{jr}'], function () {
              Route::group(['prefix' => 'joborders'], function () {
                Route::post('store', 'JobOrderController@store');
                Route::group(['prefix' => '{jo}'], function () {
                  Route::post('publish', 'JobOrderController@publish');
                  Route::group(['prefix' => 'items'], function () {
                    Route::post('store', 'JobOrderItemController@store');
                  });
                });
              });
            });
          });
        });
      });

      Route::group(['prefix' => 'locations'], function () {
        Route::get('/', 'LocationController@index');
        Route::post('store', 'SupplierController@storeLocation');
      });
    });
  });

});
