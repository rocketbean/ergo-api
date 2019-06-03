<?php
namespace App\Services;

class ErgoService {
  public static function GetConfig ($conf) {
    
      $config = config('ergo.driver');
      $disk = config('ergo.default.driver');
      return $config[$disk][$conf];
  }

  public static function GetAll () {

      $config = config('ergo.driver');
      $disk = config('ergo.default.driver');
      return $config[$disk];
  }

  public static function GetUser () {
      return config('ergo.firstuser');
  }
}