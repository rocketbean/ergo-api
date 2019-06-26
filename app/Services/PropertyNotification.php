<?php

namespace App\Services;

use App\Interfaces\Notification;
use App\Models\Property;

class PropertyNotification implements Notification {

	protected $model;

	public function __construct () {
		$this->model = Property::class;
	}

	public function process() {
		return $this->model::first();
	}
}