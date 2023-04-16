<?php
require 'lib/controller.php';
require 'models/attendanceModel.php';
require 'Classes/PHPExcel.php';
class attendanceController extends Controller{
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
        $model = new attendanceModel();
        $em = $model->all();
        return $this->controller->view()->render('attendance.php',$em);
    }

    public function store()
    {
        $employee = $_POST['employee'];
		$date = $_POST['date'];
		$time_in = $_POST['time_in'];
		$time_out = $_POST['time_out'];

        $model = new attendanceModel();
		$result = $model->save(array('employee' => $employee,'date' => $date,'time_in'=> $time_in, 'time_out'=> $time_out));

        return $this->controller->view()->route('attendance');

    }

    public function edit()
    {
        $id = $_POST['id'];
        $model = new attendanceModel();
        $getId = $model->getId($id);

        echo json_encode($getId);
    }

    public function update()
    {
        $id = $_POST['id'];
		$date = $_POST['edit_date'];
		$time_in = $_POST['edit_time_in'];
		$time_out = $_POST['edit_time_out'];

      
        $model = new attendanceModel();
		$result = $model->update(array('id' => $id,'edit_date' => $date,'edit_time_in'=> $time_in, 'edit_time_out'=> $time_out));

        return $this->controller->view()->route('attendance');
    }

    public function destroy()
    {
        $id = $_POST['id'];
      
        $model = new attendanceModel();
		$result = $model->delete($id);

        return $this->controller->view()->route('attendance');
    }


    public function update_file()
    {
        $file = $_FILES["file"];
        $file_name = $file["name"];
        $file_tmp = $file["tmp_name"];
        $file_type = $file["type"];

       
        
        $allowed_types = ["application/vnd.ms-excel", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"];
        $model = new attendanceModel();

        if(in_array($file_type, $allowed_types)) {
            $destination = $_SERVER['DOCUMENT_ROOT'].'/images/' . $file_name;
            move_uploaded_file($file_tmp, $destination);

            $excel = PHPExcel_IOFactory::load($_SERVER['DOCUMENT_ROOT'].'/images/' . $file_name);

            $sheet = $excel->getSheet(2);
      
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            for ($row = 6; $row <= $highestRow; $row++) {
             
                $column1 = $sheet->getCell('A'.$row)->getValue();
                $column2 = $sheet->getCell('D'.$row)->getValue();
                $column3 = $sheet->getCell('E'.$row)->getValue();
                $column4 = $sheet->getCell('H'.$row)->getValue();

                 // gives you a number like 44444, which is days since 1900
                $stringDate = \PHPExcel_Style_NumberFormat::toFormattedString($column2, 'YYYY-MM-DD');

                $timein = \PHPExcel_Style_NumberFormat::toFormattedString($column3, 'H:i:s');
                $timeout = \PHPExcel_Style_NumberFormat::toFormattedString($column4, 'H:i:s');

                $result = $model->update_file(array('employee'=>$column1,'date'=>$stringDate,'time_in'=>$timein,'time_out'=> $timeout));

               



                // echo $column1."<br>".$column2."<br>".$column3."<br>".$column4."<br>";

            }


            // $_SESSION['success'] = 'Attendance upload successfully.';
        }
        else{

            $_SESSION['error'] = "Please check your file.";
        }

        // $data = array(
           
        //     'filename' => $filename
         
        // );
        // $model = new attendanceModel();
		// $result = $model->update_file($data);

        return $this->controller->view()->route('attendance');
    }

    public function send_sms()
    {

        

        try {

            $model = new attendanceModel();
            $em = $model->getContact();

            // echo json_encode($em);
            foreach($em as $contact){
                

                $message = "this is sample 2!";
                $abc= 'https://sms.teamssprogram.com/api/send?key=4a12a2f82e7e7306a0bd8967eaf8edc5bfba73a2&phone='.$contact['contact_info'].'&message='.$message;

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $abc);

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                $output = curl_exec($ch);
                curl_close($ch);

            }
         
            echo "Success Send!"; 
        } catch (Exception $e) {
            echo $e;

        }
    }

    public function employee_attend()
    {
        if(!isset($_SESSION['admin']) || trim($_SESSION['admin']) == ''){
			
			header('location: /login');
		}
        $employee_id = $_POST['employee'];
        $range = $_POST['date_range'];
        $ex = explode(' - ', $range);
        $from = date('Y-m-d', strtotime($ex[0]));
        $to = date('Y-m-d', strtotime($ex[1]));


        $from_title = date('M d, Y', strtotime($ex[0]));
        $to_title = date('M d, Y', strtotime($ex[1]));

        $data = array(
            'from' => $from,
            'to' => $to,
            'employee_id' => $employee_id
        );
    
        $model = new attendanceModel();
		$result = $model->employee_attend($data);

        // echo json_encode($result);attend_print.php

        return $this->controller->view()->render('attend_print.php',$result);
        
    }




}


?>