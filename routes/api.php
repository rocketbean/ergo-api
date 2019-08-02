<?php

use App\Models\Property;
use App\Models\Supplier;
use App\Notifications\newQuote;
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

Route::post('testClass', 'CoreController@testClass');
Route::post('attempt','AuthController@login');
Route::post('register','RegistrationController@register');
Route::post('firstUser', 'CoreController@createFirstUser')->middleware('core.configure');
Route::post('photological', 'CoreController@assignPhotos')->middleware('core.configure');
Route::post('assigntags', 'CoreController@assignTags')->middleware('core.configure');
Route::post('assignRoles', 'CoreController@assignRoles')->middleware('core.configure');
Route::post('initial', 'CoreController@configure')->middleware('core.configure');

Route::post('alerts/create', function () {
  $user = Auth::user();
  $jr = \App\Models\JobRequest::find(1)->load(['property']);
  $jo = \App\Models\JobOrder::find(1)->load(['property']);
  $property = Supplier::findorfail(1);
  return $user->notify(new newQuote($jr, $jo, $property));
});

Route::group(['middleware' => 'jwt.auth'], function () {
  Route::post('alerts', 'AlertController@index');
  Route::post('roles', 'RoleController@index');
  
  Route::group(['prefix' => 'ergo'], function () {
    Route::get('countries', 'CoreController@countries');
    Route::get('tags', 'CoreController@tags');
  });

  Route::group(['prefix' => 'directions'], function () {
    Route::get('jobrequest/{jr}', 'LocationController@JobRequestDirection');
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
    Attachment
  */
  Route::group(['prefix' => 'attachments'], function () {
    Route::get('/', 'AttachmentController@index');
    Route::post('store', 'AttachmentController@store');
  });

  /*
    jobrequests
  */
  Route::group(['prefix' => 'jobrequests'], function () {
    Route::group(['prefix' => '{jr}'], function () {
      Route::post('/', 'JobRequestController@index');
      Route::group(['prefix' => 'items/{item}'], function () {
        Route::post('destroy', 'JobRequestItemController@destroy');
        Route::group(['prefix' => 'photos/{photo}'], function () {
          Route::post('attach', 'JobRequestItemController@attachPhoto');
        });
      });
    });
  });

  /*
    joborders
  */
  Route::group(['prefix' => 'joborders'], function () {
    Route::group(['prefix' => '{jo}'], function () {
      Route::post('/', 'JobOrderController@index');
      Route::post('viewed', 'JobOrderController@viewed');
      Route::group(['prefix' => 'jobrequests/{jr}'], function () {
        Route::post('approve', 'JobOrderController@approve');
        Route::post('confirm', 'JobOrderController@confirm');
        Route::post('rollback', 'JobOrderController@rollback');
        Route::post('complete', 'JobOrderController@complete');
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

      Route::post('users/invite', 'PropertyController@invite');
      Route::get('photos', 'PropertyController@photos');
      Route::get('users', 'PropertyController@users');
      Route::post('show', 'PropertyController@show');
      Route::post('update/primary/{photo}', 'PropertyController@primary');
      Route::group(['prefix' => 'tag'], function () {
        Route::post('{tag}/attach', 'PropertyController@attach');
      });
      Route::group(['prefix' => 'jobrequests'], function () {
        Route::post('store', 'JobRequestController@store');
        Route::group(['prefix' => '{jr}'], function () {
          Route::post('/', 'JobRequestController@index');
          Route::post('/destroy', 'JobRequestController@destroy');
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
    Route::post('', 'SupplierController@index');
    Route::post('store', 'SupplierController@store');
    Route::group(['prefix' => '{supplier}'], function () {
      Route::post('update/primary/{photo}', 'SupplierController@primary');
      Route::post('show', 'SupplierController@show');
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
        Route::post('store', 'LocationController@storeSuplierLocation');
      });
    });
  });

});