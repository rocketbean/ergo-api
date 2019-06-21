<?php 
namespace App\Services;

use App\Models\JobRequest;

class ActionModal {
	protected $action, $subject, $data;
	public function __construct (Array $data) {
		$this->action 	= 'dispatch';
		$this->subject 	= '_modals';
		$this->data   	= $data;
	}
	private function constructModule ($data) {
		return $data['value'];
	}
	public function process () {
		$actions = [];
		return [
			'action' => $this->action,
			'subject' => $this->subject,
			'data'	=> $this->constructModule($this->data),
		];
	}
}