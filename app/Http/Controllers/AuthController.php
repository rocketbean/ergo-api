<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\User;
use App\Services\AuthDriverService;
use App\Services\ErgoService;
use App\Services\UserTempStorage;
use Auth;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\JWT as JAT;
use Illuminate\Contracts\Cache\Repository;

class AuthController extends Controller
{
  protected function login(Request $request) {
      $credentials = $request->only('email', 'password');
      $user = User::where('email', $request->email)->first();

      if ($token = JWTAuth::attempt($credentials)) {
        $userTempStorage = new UserTempStorage(app(Repository::class), app(Auth::class));
        $userTempStorage->put((new ErgoService)->GetConfig('userkey'), $request->password);
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
      public function getAuthenticatedUser(Supplier $supplier, Request $request)
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
        return $this->grantToken($user, $supplier, $request);
      }

    /**
     * Get the guard to be used during authentication.
     * User $user, Request $request
     * @return \Illuminate\Contracts\Auth\Guard
     */ 
      public function grantToken(User $user, Supplier $supplier, $request)
      {
        $gate = Supplier::AuthenticateRelations($user, $supplier);
        if( $gate['guard'] ) {
          return (new AuthDriverService)->token($supplier, $gate['client'], $request);
        }

        return;
      }

      public function register(Request $request, Supplier $supplier)
      {
        return (new AuthDriverService)->grant($request);
        return json_decode((string) $response->getBody(), true);
      }

}

