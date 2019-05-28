<?php
namespace App\Services;
use Auth;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

use Laravel\Passport\Http\Controllers\ClientController;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Http\Rules\RedirectRule;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;

class AuthDriverService {

  protected $guzzle, $grantType;

  public function __construct() {
    $token = $this->token();
    $this->grantType = 'client_credentials';
    $this->guzzle = new Client([
      'base_uri'  => 'http://localhost/',
    ]);
  }
  /**
   * grants a passport token to the user.
   * User $user, Request $request
   * @return \Illuminate\Contracts\Auth\Guard
   */ 
  public function token()
  {
    $guzzle = new Client;
    $response = $guzzle->post('http://localhost/oauth/token', [
      'form_params' => [
          'grant_type' => 'client_credentials',
          'client_id' => '2',
          'client_secret' => 'rx8RMVv3n6dna0rozZtf2wj1nGr6fTbe6US6dbjn',
          'scope' => '',
      ],
    ]);
    return json_decode((string) $response->getBody(), true);
  }

  /**
   * grants a passport token to the user.
   * User $user, Request $request
   * @return \Illuminate\Contracts\Auth\Guard
   */ 
  public function grant($request)
  {
    $response = $this->guzzle->post('oauth/clients',[
      'form_params' => [
        'name' => '1111',
        'redirect' => 'http://localhost/',
        'token' => $request->token,
      ]
    ]);
    return json_decode((string) $response->getBody(), true);
  }
}