<?php
namespace App\Services;
use App\Models\Client as ServiceSupplier;
use App\Models\Supplier;
use App\Models\User;
use App\Services\SessionService;
use App\Services\UserTempStorage;
use Auth;
use GuzzleHttp\Client;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Http\Request;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Http\Controllers\ClientController;
use Laravel\Passport\Http\Rules\RedirectRule;

class AuthDriverService {

  protected $guzzle, $grantType;

  public function __construct() {
    $this->grantType = 'client_credentials';
    $this->guzzle = new Client([
      'base_uri'  => ErgoService::GetConfig('auth_url'),
    ]);
    $this->userTempStorage = app(UserTempStorage::class);
  }

  /**
   * [@request] guzzles token request on auth server.
   * User $user, Request $request
   * @return \Illuminate\Contracts\Auth\Guard
   */ 
  public function token($supplier, $client,Request $request)
  {
    $client = $this->getClientCredentials($client);
    $response = $this->guzzle->post('oauth/token', [
      'token'       => $request->token,
      'form_params' => [
          'grant_type'    => 'password',
          'client_id'     => $client->id, //$client,
          'client_secret' => $client->secret,//$client->secret,
          'username'      => Auth::user()->email,
          'password'      => $this->userTempStorage->get((new ErgoService)->GetConfig('userkey')),
          'scope'         => '*',
      ],
    ]);
    return (json_decode((string) $response->getBody(), true));
  }

  /**
   * grants a passport token to the user.
   * User $user, Request $request
   * @return \Illuminate\Contracts\Auth\Guard
   */ 
  public function grant($request, Supplier $supplier)
  {
    $response = $this->guzzle->post('oauth/clients',[
      'form_params' => [
        'name'            => $supplier->name,
        'redirect'        => 'http://localhost/',
        'token'           => $request->token,
      ]
    ]);

    $data = json_decode((string) $response->getBody(), true);
    ServiceSupplier::where('id', $data['id'])->update(['password_client' => 1]);
    return $data;
  }

  public function getClientCredentials($client) {
    return ServiceSupplier::find($client);
  }
}