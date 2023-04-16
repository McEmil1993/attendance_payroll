<?php
require 'lib/controller.php';
require 'models/payrollModel.php';
require 'models/deductionModel.php';
class payrollController extends Controller{
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
        $range = isset($_GET['range'])?$_GET['range'] : '';
        $model = new payrollModel();
        $data = [
            'range'=>$range
        ];
        $em = $model->all($data);

        
    
        return $this->controller->view()->render('payroll.php',$em);
    }

    public function print()
    {
        
        $range = $_POST['date_range'];
        $ex = explode(' - ', $range);
        $from = date('Y-m-d', strtotime($ex[0]));
        $to = date('Y-m-d', strtotime($ex[1]));


        $from_title = date('M d, Y', strtotime($ex[0]));
        $to_title = date('M d, Y', strtotime($ex[1]));

        $data = array(
            'from' => $from,
            'to' => $to
        );
    
        $model = new payrollModel();
		$result = $model->payroll($data);

    
        $modelde = new deductionModel();
        $em = $modelde->all();

        return $this->controller->view()->render('print_payroll.php',array('result' =>$result,'dec'=>$em , 'from_title'=>$from_title, 'to_title'=>$to_title));

    }

    public function sample()
    {

     return $this->controller->view()->render('sample_print.php');
    }

    public function payslip()
    {
        $id = $_POST['id'];
        $model = new payrollModel();
        $getId = $model->getId($id);
        echo json_encode($getId);
    }


    public function send_sms(){
        $range = $_POST['date_range'];
        $ex = explode(' - ', $range);
        $from = date('Y-m-d', strtotime($ex[0]));
        $to = date('Y-m-d', strtotime($ex[1]));


        $from_title = date('M d, Y', strtotime($ex[0]));
        $to_title = date('M d, Y', strtotime($ex[1]));

        $data = array(
            'from' => $from,
            'to' => $to
        );
    
        $model = new payrollModel();
		$result = $model->payroll($data);


        foreach($result as $row){
          

            $message = "Dalikyat 24Hours Convenience Store%0ADate: ".$from." to ".$to."%0ACash advance: P ".$row['cashadvance']."%0ANet pay: P ".$row['total']."%0ABasic salary: P ".$row['gross']."%0ATotal deductions: P ".$row['total_deduction'];
            $abc= 'https://sms.teamssprogram.com/api/send?key=4a12a2f82e7e7306a0bd8967eaf8edc5bfba73a2&phone='.$row['cont'].'&message='.$message;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $abc);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $output = curl_exec($ch);
            curl_close($ch);

            $_SESSION['success'] = 'Send message successfully';

        }

        return $this->controller->view()->route('payroll');
    }

   

}


?>