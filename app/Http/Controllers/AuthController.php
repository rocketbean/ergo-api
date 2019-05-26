<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\JWT;

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

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
      public function getAuthenticatedUser(Request $request)
      {
        try {
          if (! $user = JWTAuth::parseToken()->authenticate()) {
                  return response()->json(['user_not_found'], 404);
          }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
          return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
          return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
          return response()->json(['token_absent'], $e->getStatusCode());
        }
        // return $user;
        return $this->grantToken($user, $request);
      }

    /**
     * Get the guard to be used during authentication.
     * User $user, Request $request
     * @return \Illuminate\Contracts\Auth\Guard
     */ 
      public function grantToken()
      {
        $guzzle = new Client();
        $response = $guzzle->post('http://localhost/oauth/token', [
          'form_params' => [
              'grant_type' => 'client_credentials',
              'client_id' => '2',
              'client_secret' => '3jusaFS94qp3x8rzgJCfzktvq94Es7wTdhlBz10y',
              'scope' => '',
          ],
      ]);
        // return (string) var_dump($response->getBody());
        return json_decode((string) $response->getBody(), true);
      }
}

