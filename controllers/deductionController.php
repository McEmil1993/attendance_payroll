<?php
require 'lib/controller.php';
require 'models/deductionModel.php';
class deductionController extends Controller{
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
        $model = new deductionModel();
        $em = $model->all();
        
        return $this->controller->view()->render('deduction.php',$em);
    }

    public function store()
    {

       
        $data = array(
            'description' => $_POST['description'],
            'amount' => $_POST['amount']
        );
      
        $model = new deductionModel();
		$result = $model->save($data);

        return $this->controller->view()->route('deduction');

    }

    public function edit()
    {
        $id = $_POST['id'];
        $model = new deductionModel();
        $getId = $model->getId($id);

        echo json_encode($getId);
    }

    public function update()
    {
        $data = array(
            'id' => $_POST['id'],
            'description' => $_POST['description'],
            'amount'=> $_POST['amount']
        );
      
        $model = new deductionModel();
		$result = $model->update($data);

        return $this->controller->view()->route('deduction');
    }

    public function destroy()
    {
        $id = $_POST['id'];
      
        $model = new deductionModel();
		$result = $model->delete($id);

        return $this->controller->view()->route('deduction');
    }

}


?>