<?php
/**
 * 
 */
require 'lib/controller.php';
require 'models/loginModel.php';
class LoginController extends controller
{
	private $controller;
	function __construct()
	{
		$this->controller = new Controller();
	}


    public function index(){
        if(isset($_SESSION['admin'])){
			
			header('location: /home');
		}
		
		return $this->controller->view()->render('login.php');
    }
	public function userLogin()
	{
		$username = isset($_POST['username'])? $_POST['username'] : '';
		$password = isset($_POST['password'])? $_POST['password'] : '';

		$auth_obj = new LoginModel();

		$result = $auth_obj->login(array('username' => $username,'password' => $password));

		if($result == "1"){
            return $this->controller->view()->route('home');
        }else{
            return $this->controller->view()->route('login');
        }

	}

    public function logout(){
        session_start();
        session_destroy();
        return $this->controller->view()->route('login');
    }



}