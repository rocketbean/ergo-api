<?php

namespace App\Http\Controllers;

use App\Services\ErgoService;
use App\Services\SessionService;
use App\Services\UserTempStorage;
use Illuminate\Http\Request;
class SessionController extends Controller
{
    
    public function index (Request $request) {
      
      $userTempStorage = app(UserTempStorage::class);
      // $_s = new SessionService;
      return $userTempStorage->put('test', ['key' => 'mapping']);
    }

    public function get (Request $request) {
      $userTempStorage = app(UserTempStorage::class);
      return $userTempStorage->get('test');
    }
}
