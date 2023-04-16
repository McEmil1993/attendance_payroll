<?php
class payrollModel {
    private $conn;

    public function __construct(){
        $db = new database();
        $this->conn = $db->connection();
    }

    public function all($param=array())
    {
        
        $arr = array();

        $sql = "SELECT *, SUM(amount) as total_amount FROM deductions";
        $query = $this->conn->query($sql);
        $drow = $query->fetch_assoc();
        $deduction = $drow['total_amount'];

        
        $to = date('Y-m-d');
        $from = date('Y-m-d', strtotime('-30 day', strtotime($to)));

        if($param['range'] != ''){
          $range = $param['range'];
          $ex = explode(' - ', $range);
          $from = date('Y-m-d', strtotime($ex[0]));
          $to = date('Y-m-d', strtotime($ex[1]));
        }

        $sql = "SELECT *, SUM(num_hr) AS total_hr, attendance.employee_id AS empid FROM attendance LEFT JOIN employees ON employees.id=attendance.employee_id LEFT JOIN position ON position.id=employees.position_id WHERE date BETWEEN '$from' AND '$to' GROUP BY attendance.employee_id ORDER BY employees.lastname ASC, employees.firstname ASC";

        $query = $this->conn->query($sql);
        $total = 0;
        while($row = $query->fetch_assoc()){
          $empid = $row['empid'];
          
          $casql = "SELECT *, SUM(amount) AS cashamount FROM cashadvance WHERE employee_id='$empid' AND date_advance BETWEEN '$from' AND '$to'";
          
          $caquery = $this->conn->query($casql);
          $carow = $caquery->fetch_assoc();
          $cashadvance = $carow['cashamount'];

          $gross = $row['rate'] * $row['total_hr'];
          $total_deduction = $deduction + $cashadvance;
          $net = $gross - $total_deduction;

          $arr[] = array(
            'fullname'=> $row['lastname'].", ".$row['firstname'],
            'employee_id'=>$row['employee_id'],
            'gross'=>number_format($gross, 2),
            'deduction'=>number_format($deduction, 2),
            'cashadvance'=>number_format($cashadvance, 2),
            'net'=>number_format($net, 2)
          ); 

        }
        $this->conn->close();
        return $arr;
    }

    public function payroll($param = array())
    {
        $from = $param['from'];
        $to = $param['to'];

        $arr = array();

        $query = $this->conn->query("SELECT *, SUM(amount) as total_amount FROM deductions");
        $drow = $query->fetch_assoc();
        $deduction = $drow['total_amount'];

        $prquery = $this->conn->query("SELECT *, sum(num_hr) AS total_hr, attendance.employee_id AS empid FROM attendance LEFT JOIN employees ON employees.id=attendance.employee_id LEFT JOIN position ON position.id=employees.position_id WHERE date BETWEEN '$from' AND '$to' GROUP BY attendance.employee_id ORDER BY employees.lastname ASC, employees.firstname ASC");
        $total = 0;
        $arrdec  = [];
       
        while($row = $prquery->fetch_assoc()){
          $empid = $row['empid'];
                          
          $casql = "SELECT *, SUM(amount) AS cashamount FROM cashadvance WHERE employee_id='$empid' AND date_advance BETWEEN '$from' AND '$to'";
        
          $caquery = $this->conn->query($casql);
          $carow = $caquery->fetch_assoc();
          $cashadvance = $carow['cashamount'];

          $gross = $row['rate'] * $row['total_hr'];
          $total_deduction = $deduction + $cashadvance;
          $net = $gross - $total_deduction;

          $total += $net;


          $cs = ($cashadvance != '0')? $cashadvance : '0';
          


            $arr[] = array(
              
              'fullname'=>$row['lastname'].', '.$row['firstname'],
              'employee_id'=>$row['employee_id'],
              'cont'=>$row['contact_info'],
              'net'=>number_format($net, 2),
              'gross'=> number_format($gross, 2),
              'total'=>number_format($total, 2),
              'cashadvance'=>number_format($cs, 2),
              'total_deduction'=>$total_deduction
            );

          
          
          
        }
        
        $this->conn->close();
        return $arr;

    }

    public function save($param = array())
    {
        $title = $param['title'];
		$rate = $param['rate'];

		$sql = "INSERT INTO payroll (description, rate) VALUES ('$title', '$rate')";
		if($this->conn->query($sql)){
			$_SESSION['success'] = 'payroll added successfully';
		}
		else{
			$_SESSION['error'] = $this->conn->error;
		}
    }

    public function getId($id)
    {
       
		$sql = "SELECT * FROM payroll WHERE id = '$id'";
		$query = $this->conn->query($sql);
		$row = $query->fetch_assoc();

    
		return ($row);
    }
    public function update($param = array())
    {
        $id = $param['id'];
		$title = $param['title'];
		$rate = $param['rate'];

		$sql = "UPDATE payroll SET description = '$title', rate = '$rate' WHERE id = '$id'";
		if($this->conn->query($sql)){
			$_SESSION['success'] = 'payroll updated successfully';
		}
		else{
			$_SESSION['error'] = $this->conn->error;
		}
    }

    public function delete($id)
    {
		$sql = "DELETE FROM payroll WHERE id = '$id'";
		if($this->conn->query($sql)){
			$_SESSION['success'] = 'payroll deleted successfully';
		}
		else{
			$_SESSION['error'] = $this->conn->error;
		}
    }

}

?>