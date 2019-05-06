<?php

namespace App\Http\Controllers;

use Auth;
use JWTAuth;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
  protected function login(Request $request) {
      $credentials = $request->only('email', 'password');
      $user = User::where('email', $request->email)->first();
      if ($token = JWTAuth::attempt($credentials)) {
        return $this->returnToken($token,$user);
      } else {
        return response()->json(['error' => 'Unauthorized'], 401);
      }
  }
  
  public function returnToken ($token, User $user) {
      return response()->json([
          'token' => $token,
          'user' => $user,
          'expires' => auth('api')->factory()->getTTL() * 60,
      ]);
  }
    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json($this->guard()->user());
    }
    
    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }
}

