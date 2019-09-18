<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class TestController extends Controller
{
  public function roles (Request $request) {
    return Role::where('id', 5)->first();
  }

}
