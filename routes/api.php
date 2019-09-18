<?php

use App\Models\Property;
use App\Models\Supplier;
use App\Notifications\newQuote;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------|
| API Routes                                                               |
|--------------------------------------------------------------------------|
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('testClass', 'CoreController@testClass');
Route::post('attempt','AuthController@login');
Route::post('register','RegistrationController@register');

Route::group(['middleware' => 'core.configure'], function () {
  Route::post('firstUser', 'CoreController@createFirstUser');
  Route::post('photological', 'CoreController@assignPhotos');
  Route::post('assigntags', 'CoreController@assignTags');
  Route::post('assignRoles', 'CoreController@assignRoles');
  Route::post('assignPermissions', 'CoreController@assignPermissions');
  Route::post('initial', 'CoreController@configure');
  Route::group(['prefix' => 'test'], function () {
    Route::post('roles', 'TestController@roles');
  });
});


Route::group(['middleware' => 'jwt.auth'], function () {
  Route::post('alerts', 'AlertController@index');
  Route::post('roles', 'RoleController@index');
  Route::group(['prefix' => 'ergo'], function () {
    Route::get('countries', 'CoreController@countries');
    Route::get('permissions', 'PermissionController@index');
    Route::get('tags', 'CoreController@tags');
  });

  Route::group(['prefix' => 'directions'], function () {
    Route::group(['prefix' => 'jobrequest/{jr}'], function () {
      Route::get('/', 'LocationController@JobRequestDirection');
      Route::get('item/{item}', 'LocationController@JobRequestItemDirection');
    });
  });

  /*
    activity
  */
  Route::group(['prefix' => 'activity'], function () {
    Route::group(['prefix' => 'property/{property}'], function () {
      Route::post('logs', 'PropertyController@testlog');
    });
  });

  /*
    settings
  */
  Route::group(['prefix' => 'settings'], function () {
    Route::group(['prefix' => 'user/{user}'], function () {
      Route::get('/', 'UserController@index');
      Route::post('primary/{photo}', 'UserController@primary');
    });
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
        Route::group(['prefix' => 'item/{item}'], function () {
          Route::post('confirm', 'JobOrderController@confirm');
          Route::post('rollback', 'JobOrderController@rollback');
          Route::post('complete', 'JobOrderController@complete');
          Route::post('done', 'JobOrderController@done');
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
      Route::get('permissions/get', 'PropertyController@permissions');
      Route::post('users/invite', 'PropertyController@invite')->middleware('PropertyUser.invite');
      Route::get('photos', 'PropertyController@photos');
      Route::get('users', 'PropertyController@users')->middleware('PropertyUser.view');
      Route::post('show', 'PropertyController@show');
      Route::post('update/primary/{photo}', 'PropertyController@primary');
      Route::group(['prefix' => 'tag'], function () {
        Route::post('{tag}/attach', 'PropertyController@attach');
      });
      Route::group(['prefix' => 'jobrequests'], function () {
        Route::post('store', 'JobRequestController@store');
        Route::group(['prefix' => '{jr}'], function () {
          Route::post('/', 'JobRequestController@index');
          Route::post('/destroy', 'JobRequestController@destroy')->middleware('PropertyJobRequest.delete');
          Route::post('publish', 'JobRequestController@publish')->middleware('PropertyJobRequest.publish');
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
      Route::post('users/invite', 'SupplierController@invite')->middleware('SupplierUser.invite');
      Route::post('update/primary/{photo}', 'SupplierController@primary');
      Route::get('photos', 'SupplierController@photos');
      Route::get('users', 'SupplierController@users');
      Route::post('show', 'SupplierController@show');
      Route::group(['prefix' => 'tag'], function () { 
        Route::post('{tag}/attach', 'SupplierController@attach');
      });
      Route::group(['prefix' => 'reviews'], function () { 
        Route::post('store', 'ReviewController@store');
        Route::post('get', 'ReviewController@index');
      });
      Route::group(['prefix' => 'joborders'], function () {
        Route::get('', 'SupplierController@joborders');
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