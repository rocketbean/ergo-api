<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Photo;
class UserController extends Controller
{
    public function index(User $user) {
      return $user;
    }
    
    public function primary(User $user, Photo $photo) {
      $user->update(['primary' => $photo->id]);
      return $user;
    }

}
