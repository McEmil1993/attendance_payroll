<?php
require 'lib/controller.php';
require 'models/employeeModel.php';
require 'models/positionModel.php';
require 'models/scheduleModel.php';
class employeeController extends Controller{
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
        $model = new employeeModel();
        $em = $model->all();
        $modelP = new positionModel();
        $emP = $modelP->all();
        $modelS = new scheduleModel();
        $emS = $modelS->all();
        $arr = array('all'=>$em ,'positions'=> $emP, 'schedules'=> $emS);
        return $this->controller->view()->render('employee.php',$arr);
    }

    public function store()
    {
        
        $firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$address = $_POST['address'];
		$birthdate = $_POST['birthdate'];
		$contact = $_POST['contact'];
		$gender = $_POST['gender'];
		$position = $_POST['position'];
		$schedule = $_POST['schedule'];
		$filename = $_FILES['photo']['name'];
		if(!empty($filename)){
			move_uploaded_file($_FILES['photo']['tmp_name'],  $_SERVER['DOCUMENT_ROOT'].'/images/'.$filename);	
		}

        $data = array(
            'firstname' => $firstname,
            'lastname' => $lastname,
            'address'=> $address,
            'birthdate'=> $birthdate,
            'contact' => $contact,
            'gender' => $gender,
            'position'=> $position,
            'schedule'=> $schedule,
            'filename'=> $filename
        );

        $model = new employeeModel();
		$result = $model->save($data);

        return $this->controller->view()->route('employee');

    }

    public function edit()
    {
        $id = $_POST['id'];
        $model = new employeeModel();
        $getId = $model->getId($id);

        echo json_encode($getId);
    }

    public function update()
    {
        $empid = $_POST['id'];
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$address = $_POST['address'];
		$birthdate = $_POST['birthdate'];
		$contact = $_POST['contact'];
		$gender = $_POST['gender'];
		$position = $_POST['position'];
		$schedule = $_POST['schedule'];

        $data = array(
            'firstname' => $firstname,
            'lastname' => $lastname,
            'address'=> $address,
            'birthdate'=> $birthdate,
            'contact' => $contact,
            'gender' => $gender,
            'position'=> $position,
            'schedule'=> $schedule,
            'id'=> $empid
        );

        $model = new employeeModel();
		$result = $model->update($data);

        return $this->controller->view()->route('employee');
       
    }

    public function destroy()
    {
        $id = $_POST['id'];
        $model = new employeeModel();
		$result = $model->delete($id);

        return $this->controller->view()->route('employee');
    }

    public function update_photo()
    {
        $empid = $_POST['id'];
		$filename = $_FILES['photo']['name'];
		if(!empty($filename)){
			move_uploaded_file($_FILES['photo']['tmp_name'],  $_SERVER['DOCUMENT_ROOT'].'/images/'.$filename);	
		}

        $data = array(
            'id' => $empid,
            'filename' => $filename
         
        );

        $model = new employeeModel();
		$result = $model->update_photo($data);

        return $this->controller->view()->route('employee');
    }

}


?>