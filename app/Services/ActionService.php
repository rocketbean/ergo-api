<?php 
namespace App\Services;

class ActionService {
	protected $action, $subject, $data;
	public function __construct ($subject, $data) {
		$this->action 	= 'getters';
		$this->data   	= $data;
		$this->subject 	= $subject;
	}
	public function process () {
		return [
			
		];
	}
}