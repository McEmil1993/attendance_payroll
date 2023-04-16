<?php
require 'lib/controller.php';
require 'models/positionModel.php';
class positionController extends Controller{
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
        $model = new positionModel();
        $em = $model->all();
    
        return $this->controller->view()->render('position.php',$em);
    }

    public function store()
    {
        $data = array(
            'title' => $_POST['title'],
            'rate' => $_POST['rate']
         
        );
    
        $model = new positionModel();
		$result = $model->save($data);

        return $this->controller->view()->route('position');

    }

    public function edit()
    {
        $id = $_POST['id'];
        $model = new positionModel();
        $getId = $model->getId($id);
        echo json_encode($getId);
    }

    public function update()
    {
        $data = array(
            'id' => $_POST['id'],
            'title' => $_POST['title'],
            'rate'=> $_POST['rate']
        );
        $model = new positionModel();
		$result = $model->update($data);

        return $this->controller->view()->route('position');
    }

    public function destroy()
    {
        $id = $_POST['id'];
      
        $model = new positionModel();
		$result = $model->delete($id);

        return $this->controller->view()->route('position');
    }

}


?>