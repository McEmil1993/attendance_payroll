<?php
require 'lib/controller.php';
require 'models/overtimeModel.php';
class overtimeController extends Controller{
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
        $model = new overtimeModel();
        $em = $model->all();
        
        return $this->controller->view()->render('overtime.php',$em);
    }

    public function store()
    {

       
        $data = array(
            'employee' => $_POST['employee'],
            'date' => $_POST['date'],
            'hours'=> $_POST['hours'],
            'mins'=> ($_POST['mins']/60),
            'rate' => $_POST['rate']
         
        );
      
        $model = new overtimeModel();
		$result = $model->save($data);

        return $this->controller->view()->route('overtime');

    }

    public function edit()
    {
        $id = $_POST['id'];
        $model = new overtimeModel();
        $getId = $model->getId($id);

        echo json_encode($getId);
    }

    public function update()
    {
        $data = array(
            'id' => $_POST['id'],
            'date' => $_POST['date'],
            'hours'=> $_POST['hours'],
            'mins'=> ($_POST['mins']/60),
            'rate' => $_POST['rate']
         
        );
      
        $model = new overtimeModel();
		$result = $model->update($data);

        return $this->controller->view()->route('overtime');
    }

    public function destroy()
    {
        $id = $_POST['id'];
      
        $model = new overtimeModel();
		$result = $model->delete($id);

        return $this->controller->view()->route('overtime');
    }

}


?>