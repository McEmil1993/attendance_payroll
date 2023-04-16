<?php
require 'lib/view.php';

class controller{

	private $view;
	
	public function __construct(){
		date_default_timezone_set('Asia/Manila');
		session_start();
		$this->view = new view();
	}

	public function view(){
		return $this->view;
	}

}

?>