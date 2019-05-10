<?php

namespace App\Http\Controllers;

use Auth;
use JWTAuth;
use Illuminate\Http\Request;
use App\Models\User;
class RegistrationController extends Controller
{
    public function register (Request $request) {
      User::validate($request);
      $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
      ]);
    }
}
