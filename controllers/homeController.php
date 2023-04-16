<?php

/**
 * 
 */

require 'lib/controller.php';


class homeController extends Controller
{
	private $controller;
	function __construct()
	{
		$this->controller = new Controller();
	}

	public function index()
	{
		if(!isset($_SESSION['admin']) || trim($_SESSION['admin']) == ''){
			
			header('location: /login');
		}
		

		return $this->controller->view()->render('home.php');
	}
	

}
?>