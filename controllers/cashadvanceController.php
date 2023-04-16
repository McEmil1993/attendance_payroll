<?php
require 'lib/controller.php';
require 'models/cashadvanceModel.php';
class cashadvanceController extends Controller{
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
        $model = new cashadvanceModel();
        $em = $model->all();
        
        return $this->controller->view()->render('cashadvance.php',$em);
    }

    public function store()
    {
        $data = array(
            'employee' => $_POST['employee'],
            'amount' => $_POST['amount']
            
        );
      
        $model = new cashadvanceModel();
		$result = $model->save($data);

        return $this->controller->view()->route('cashadvance');

    }

    public function edit()
    {
        $id = $_POST['id'];
        $model = new cashadvanceModel();
        $getId = $model->getId($id);

        echo json_encode($getId);
    }

    public function update()
    {
        $data = array(
            'id' => $_POST['id'],
           
            'amount' => $_POST['amount']
         
        );
      
        $model = new cashadvanceModel();
		$result = $model->update($data);

        return $this->controller->view()->route('cashadvance');
    }

    public function destroy()
    {
        $id = $_POST['id'];
      
        $model = new cashadvanceModel();
		$result = $model->delete($id);

        return $this->controller->view()->route('cashadvance');
    }

}


?>