<?php
require 'lib/controller.php';
require 'models/scheduleModel.php';
class scheduleController extends Controller{
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
        $model = new scheduleModel();
        $empSched = new scheduleModel();
        $em = $model->all();
        $sched =  $empSched->getAllEmSched();
        $data = array(
            'em'=> $em,
            'sched'=>$sched
        ); 
        // echo json_encode($em);
        return $this->controller->view()->render('schedule.php',$data);
    }

    public function store()
    {

       
        $data = array(
            'time_in' => $_POST['time_in'],
            'time_out' => $_POST['time_out']
        );
      
        $model = new scheduleModel();
		$result = $model->save($data);

        return $this->controller->view()->route('schedule');

    }

    public function edit()
    {
        $id = $_POST['id'];
        $model = new scheduleModel();
        $getId = $model->getId($id);

        echo json_encode($getId);
    }

    public function editSched()
    {
        $id = $_POST['id'];
        $model = new scheduleModel();
        $getId = $model->getIdSced($id);

        echo json_encode($getId);
    }

    public function update()
    {
        $data = array(
            'id' => $_POST['id'],
            'time_in' => $_POST['time_in'],
            'time_out'=> $_POST['time_out']
        );
      
        $model = new scheduleModel();
		$result = $model->update($data);

        return $this->controller->view()->route('schedule');
    }

    public function destroy()
    {
        $id = $_POST['id'];
      
        $model = new scheduleModel();
		$result = $model->delete($id);

        return $this->controller->view()->route('schedule');
    }


    public function employees()
    {
        if(!isset($_SESSION['admin']) || trim($_SESSION['admin']) == ''){
            
            header('location: /login');
        }
        $empSched = new scheduleModel();
        $sched =  $empSched->getAllEmSched();

        return $this->controller->view()->render('print_employee_sched.php',$sched);
    }

}


?>