<?php
require 'lib/controller.php';
require 'models/leaveModel.php';
require 'models/employeeModel.php';
class leaveController extends Controller{
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
        $model = new leaveModel();
        $em = $model->all();
        $modelE = new employeeModel();
        $eml = $modelE->all();
        $arr = array('all'=>$eml ,'leave'=> $em);
    
        return $this->controller->view()->render('leave.php',$arr);
    }

    public function store()
    {
        $range = $_POST['date_range'];
        $ex = explode(' - ', $range);
        $from = date('Y-m-d', strtotime($ex[0]));
        $to = date('Y-m-d', strtotime($ex[1]));

        $data = array(
            'from' => $from ,
            'to' => $to,
            'emp_id'=> $_POST['emp_id'],
            'desctiption'=>$_POST['desctiption'],
            'type'=>$_POST['type']
        );
    
        $model = new leaveModel();
		$result = $model->save($data);

        return $this->controller->view()->route('leave');

    }

    public function edit()
    {
        $id = $_POST['id'];
        $model = new leaveModel();
        $getId = $model->getId($id);
        echo json_encode($getId);
    }

    public function approved()
    {
        $id = $_GET['id'];
        $model = new leaveModel();
        $getId = $model->approved($id);

        return $this->controller->view()->route('leave');

    }

    public function disapproved()
    {
        $id = $_GET['id'];
        $model = new leaveModel();
        $getId = $model->disapproved($id);

        return $this->controller->view()->route('leave');
    }

    public function update()
    {
        
        $range = $_POST['date_range'];
        $ex = explode(' - ', $range);
        $from = date('Y-m-d', strtotime($ex[0]));
        $to = date('Y-m-d', strtotime($ex[1]));

        $data = array(
            'id' => $_POST['id'],
            'from' => $from ,
            'to' => $to,
            'emp_id'=> $_POST['emp_id'],
            'desctiption'=>$_POST['desctiption'],
            'type'=>$_POST['type']
        );
        $model = new leaveModel();
		$result = $model->update($data);

        return $this->controller->view()->route('leave');
    }

    public function destroy()
    {
        $id = $_POST['id'];
      
        $model = new leaveModel();
		$result = $model->delete($id);

        return $this->controller->view()->route('leave');
    }

}


?>