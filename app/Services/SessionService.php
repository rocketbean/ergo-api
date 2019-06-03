<?php
namespace App\Services;

use Illuminate\Http\Request;

class SessionService {

  public function setSession (Request $request, Array $data) {
    $_s = [];
    foreach ($data as $key => $value) {
      if(!$this->checkSession($request, $key)) {
        return $request->session()->put($this->encodeSession($key), $this->encodeSession($value));
      } else {
        return ['error' => true, 'message' => 'failed to set session'];
      }
    }
    return $_s;
  }

  public function getSession (Request $request, $key) {
      return $this->decodeSession($request->session()->get($this->encodeSession($key)));
  }

  public function checkSession ($request, $key) {

      return $request->session()->has($key);
  }

  public function encodeSession ($data) {
      return base64_encode($data);
  }

  public function decodeSession ($data) {
      return base64_decode($data);
  }
}