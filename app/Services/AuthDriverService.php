<?php
namespace App\Services;

use GuzzleHttp\Client;
use Auth;
use App\Models\User;
use Illuminate\Http\Request;


class AuthDriverService {

  protected $guzzle, $grantType;

  public function __construct() {
    $this->guzzle = new Client([
      'base_uri' => ErgoService::GetConfig('auth_url'),
      'headers'  => ['Accept' => 'application/json']
    ]);
    $this->grantType = 'client_credentials';
  }
  /**
   * grants a passport token to the user.
   * User $user, Request $request
   * @return \Illuminate\Contracts\Auth\Guard
   */ 
  public function token()
  {
    $response = $this->guzzle->post('oauth/token', [
      'form_params' => [
          'grant_type' => $this->grantType,
          'client_id' => '2',
          'client_secret' => 'rx8RMVv3n6dna0rozZtf2wj1nGr6fTbe6US6dbjn',
          'scope' => '*',
      ],
    ]);
    return json_decode((string) $response->getBody(), true);
  }

  /**
   * grants a passport token to the user.
   * User $user, Request $request
   * @return \Illuminate\Contracts\Auth\Guard
   */ 
  public function grant()
  {
    $response = $this->guzzle->post('oauth/clients',[
      'name' => 'test',
      'redirect' => 'http://localhost/'
    ]);
    return json_decode((string) $response->getBody(), true);
  }
}