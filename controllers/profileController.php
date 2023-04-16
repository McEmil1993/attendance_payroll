<?php
require 'lib/controller.php';
require 'models/homeModel.php';
class profileController extends Controller{
    private $controller;
	function __construct()
	{
		$this->controller = new Controller();
	}


    public function index()
    {

        echo 'Ello';

    }

    public function store()
    {
        $curr_password = $_POST['curr_password'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$photo = $_FILES['photo']['name'];
        $filename = '';
        $home = new homeModel();
        $user = $home->userDisplay();
        if(!empty($photo)){
            move_uploaded_file($_FILES['photo']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/images/'.$photo);
            $filename .= $photo;	
        }
        else{
            $filename .= $user['photo'];
        }

        $data = array(
            'curr_password' => $_POST['curr_password'],
            'username' => $_POST['username'],
            'password'=> $_POST['password'],
            'firstname'=> $_POST['firstname'],
            'lastname' => $_POST['lastname'],
            'photo' => $filename
         
        );
      
        $model = new profileModel();
		$result = $model->profile($data);

        return $this->controller->view()->onBack();

		
    }

}