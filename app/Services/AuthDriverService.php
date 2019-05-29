<?php
namespace App\Services;
use Auth;
use App\Models\User;
use App\Models\Supplier;
use App\Models\Client as ServiceSupplier;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

use Laravel\Passport\Http\Controllers\ClientController;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Http\Rules\RedirectRule;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;

class AuthDriverService {

  protected $guzzle, $grantType;

  public function __construct() {
    $this->grantType = 'client_credentials';
    $this->guzzle = new Client([
      'base_uri'  => ErgoService::GetConfig('auth_url'),
    ]);
  }
  /**
   * grants a passport token to the user.
   * User $user, Request $request
   * @return \Illuminate\Contracts\Auth\Guard
   */ 
  public function token($supplier, $client, $token)
  {
    $client = $this->getClientCredentials($client);
    $response = $this->guzzle->post('oauth/token', [
      'form_params' => [
          'grant_type' => 'client_credentials',
          'client_id' => $client->id, //$client,
          'client_secret' => $client->secret,//$client->secret,
          'scope' => '',
      ],
    ]);
    return (json_decode((string) $response->getBody(), true));
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

  public function getClientCredentials($client) {
    return ServiceSupplier::find($client);
  }
}