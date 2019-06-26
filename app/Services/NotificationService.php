<?php

namespace App\Services;

use App\Interfaces\Notification;

class NotificationService {

	public function process(Notification $notif) {
		return $notif->process();
	}
}