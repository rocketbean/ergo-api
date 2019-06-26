<?php

namespace App\Services;

use App\Interfaces\Notification;
use App\Models\User;
use App\Models\Supplier;
class SupplierNotification implements Notification {

  protected $module;
  protected $model;
  protected $action;
  protected $validActions = ['dispatch', 'getters', 'linkTo', 'text'];

  public function __construct (Supplier $supplier, $actions = [], $data = null) {
    $this->module = 'supplier';
    $this->model = $supplier;
    $this->action = $actions;
  }

  /*
    validates the notification
  */
  private function validate ($action) {
    return in_array($action, $this->validActions);
  }

  /*
    creates the notification
  */
  private function assign(Supplier $supplier, $action) {
    $data = [
      'action'  => $action,
      'subject' => 'active',
      'data'    => $this->module
    ];
    return json_encode( $data);
  }

  /*
    process the notification
  */
  public function process() {
    if(!$this->validate($this->action))
      throw new \Exception("Action is not valid");

    return $this->assign($this->model, $this->action);
  }
}