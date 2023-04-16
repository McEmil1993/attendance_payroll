<?php

class attendanceModel{
    private $conn;

    public function __construct(){
        $db = new database();
        $this->conn = $db->connection();
    }

    public function all()
    {
        $arr = array();
        $sql = "SELECT *, employees.employee_id AS empid, attendance.id AS attid FROM attendance LEFT JOIN employees ON employees.id=attendance.employee_id ORDER BY attendance.date DESC, attendance.time_in DESC";
        $query = $this->conn->query($sql);
        while($row = $query->fetch_assoc()){
            $arr[] = $row;
        }
        $this->conn->close();
        return $arr;
    }

    public function save($param = array())
    {
        $employee = $param['employee'];
		$date = $param['date'];
		$time_in = $param['time_in'];
		$time_in = date('H:i:s', strtotime($time_in));
		$time_out = $param['time_out'];
		$time_out = date('H:i:s', strtotime($time_out));

		$sql = "SELECT * FROM employees WHERE employee_id = '$employee'";
		$query = $this->conn->query($sql);

		if($query->num_rows < 1){
			$_SESSION['error'] = 'Employee not found';
		}
		else{
			$row = $query->fetch_assoc();
			$emp = $row['id'];

			$sql = "SELECT * FROM attendance WHERE employee_id = '$emp' AND date = '$date'";
			$query = $this->conn->query($sql);

			if($query->num_rows > 0){
				$_SESSION['error'] = 'Employee attendance for the day exist';
			}
			else{
				//updates
				$sched = $row['schedule_id'];
				$sql = "SELECT * FROM schedules WHERE id = '$sched'";
				$squery = $this->conn->query($sql);
				$scherow = $squery->fetch_assoc();
				$logstatus = ($time_in > $scherow['time_in']) ? 0 : 1;
				//
				$sql = "INSERT INTO attendance (employee_id, date, time_in, time_out, num_hr, status) VALUES ('$emp', '$date', '$time_in', '$time_out','0', '$logstatus')";
				if($this->conn->query($sql)){
					$_SESSION['success'] = 'Attendance added successfully';
					$id = $this->conn->insert_id;

					$sql = "SELECT * FROM employees LEFT JOIN schedules ON schedules.id=employees.schedule_id WHERE employees.id = '$emp'";
					$query = $this->conn->query($sql);
					$srow = $query->fetch_assoc();

					if($srow['time_in'] > $time_in){
						$time_in = $srow['time_in'];
					}

					if($srow['time_out'] < $time_out){
						$time_out = $srow['time_out'];
					}

					$time_in = new DateTime($time_in);
					$time_out = new DateTime($time_out);
					$interval = $time_in->diff($time_out);
					$hrs = $interval->format('%h');
					$mins = $interval->format('%i');
					$mins = $mins/60;
					$int = $hrs + $mins;
					if($int > 4){
						$int = $int - 1;
					}

					$sql = "UPDATE attendance SET num_hr = '$int' WHERE id = '$id'";
					$this->conn->query($sql);

				}
				else{
					$_SESSION['error'] = $this->conn->error;
				}
			}
		}
    }

    public function getId($param)
    {
       
		$sql = "SELECT *, attendance.id as attid FROM attendance LEFT JOIN employees ON employees.id=attendance.employee_id WHERE attendance.id = '$param'";
		$query = $this->conn->query($sql);
		$row = $query->fetch_assoc();

    
		return ($row);
    }
    public function update($param = array())
    {
        $id = $param['id'];
		$date = $param['edit_date'];
		$time_in = $param['edit_time_in'];
		$time_in = date('H:i:s', strtotime($time_in));
		$time_out = $param['edit_time_out'];
		$time_out = date('H:i:s', strtotime($time_out));

		$sql = "UPDATE attendance SET date = '$date', time_in = '$time_in', time_out = '$time_out' WHERE id = '$id'";
		if($this->conn->query($sql)){
			$_SESSION['success'] = 'Attendance updated successfully';

			$sql = "SELECT * FROM attendance WHERE id = '$id'";
			$query = $this->conn->query($sql);
			$row = $query->fetch_assoc();
			$emp = $row['employee_id'];

			$sql = "SELECT * FROM employees LEFT JOIN schedules ON schedules.id=employees.schedule_id WHERE employees.id = '$emp'";
			$query = $this->conn->query($sql);
			$srow = $query->fetch_assoc();

			//updates
			$logstatus = ($time_in > $srow['time_in']) ? 0 : 1;
			//

			if($srow['time_in'] > $time_in){
				$time_in = $srow['time_in'];
			}

			if($srow['time_out'] < $time_out){
				$time_out = $srow['time_out'];
			}

			$time_in = new DateTime($time_in);
			$time_out = new DateTime($time_out);
			$interval = $time_in->diff($time_out);
			$hrs = $interval->format('%h');
			$mins = $interval->format('%i');
			$mins = $mins/60;
			$int = $hrs + $mins;
			if($int > 4){
				$int = $int - 1;
			}

			$sql = "UPDATE attendance SET num_hr = '$int', status = '$logstatus' WHERE id = '$id'";
			$this->conn->query($sql);
		}
		else{
			$_SESSION['error'] = $this->conn->error;
		}
    }

    public function delete($id)
    {
       
		$sql = "DELETE FROM attendance WHERE id = '$id'";
		if($this->conn->query($sql)){
			$_SESSION['success'] = 'Attendance deleted successfully';
		}
		else{
			$_SESSION['error'] = $this->conn->error;
		}
    }

	public function update_file($param = array())
    {
		$employee = $param['employee'];
		$date = $param['date'];
		$time_in = $param['time_in'];
		$time_in = date('H:i:s', strtotime($time_in));
		$time_out = $param['time_out'];
		$time_out = date('H:i:s', strtotime($time_out));


		$time_in_1 = date('H:i:s', strtotime($time_in));
		$time_out_1 = date('H:i:s', strtotime($time_out));

		$sql = "SELECT * FROM employees WHERE id = '$employee'";
		$query = $this->conn->query($sql);
		

		if($query->num_rows < 1){
			// $_SESSION['error'] = 'Employee not found';
		}
		else{
			$row = $query->fetch_assoc();
			$emp = $row['id'];

			$pos_id = $row['position_id'];

			$sql = "SELECT * FROM attendance WHERE employee_id = '$emp' AND date = '$date'";
			


			$query = $this->conn->query($sql);

			if($query->num_rows > 0){
				// $_SESSION['error'] = 'Employee attendance for the day exist';
			}
			else{
				//updates
				
				$sched = $row['schedule_id'];
				$sql = "SELECT * FROM schedules WHERE id = '$sched'";
				$squery = $this->conn->query($sql);
				$scherow = $squery->fetch_assoc();
				// $time_in2 = date('H:i:s', strtotime($scherow['time_in']));

				$logstatus = ($time_in > $scherow['time_in']) ? 0 : 1;
				//
				$sql = "INSERT INTO attendance (employee_id, date, time_in, time_out, num_hr, status) VALUES ('$emp', '$date', '$time_in', '$time_out','0', '$logstatus')";
				if($this->conn->query($sql)){
					
					$id = $this->conn->insert_id;

					$sql = "SELECT * FROM employees LEFT JOIN schedules ON schedules.id=employees.schedule_id WHERE employees.id = '$emp'";
					$query = $this->conn->query($sql);
					$srow = $query->fetch_assoc();

					if($srow['time_in'] > $time_in){
						$time_in = $srow['time_in'];
					}

					if($srow['time_out'] < $time_out){
						$time_out = $srow['time_out'];
					}

				

					$datetime_in = new DateTime($time_in_1);
					$datetime_out = new DateTime($time_out_1);

					$interval = $datetime_in->diff($datetime_out);
					$hours = $interval->h + ($interval->days * 24); 
					$hours1 = $hours - 1;
					
					$sql = "UPDATE attendance SET num_hr = '$hours1' WHERE id = '$id'";
					$this->conn->query($sql);
					// INSERT INTO `overtime`(`id`, `employee_id`, `hours`, `rate`, `date_overtime`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]')
					// $_SESSION['error'] = $sqlPo;

					

					// if($hours1 > 8){

						$total = $hours1 - 8; 

						$sqlPo = "SELECT * FROM position WHERE id = '$pos_id'";
						$sqlPos = $this->conn->query($sqlPo);
						$sqlPosi = $sqlPos->fetch_assoc();

						$rate_ot = $total * $sqlPosi['rate']; 


						$sql = "INSERT INTO `overtime`(`employee_id`, `hours`, `rate`, `date_overtime`) VALUES ('$emp','$total','".$rate_ot."','$date')'";

						$st = $this->conn->query($sql);

					// }
					$_SESSION['success'] = 'Attendance added successfully.'.$st;
					

				}
				else{
					$_SESSION['error'] = $this->conn->error;
				}
			}
		}
    }


	public function getContact()
    {
        $arr = array();
        $sql = "SELECT contact_info FROM employees";
        $query = $this->conn->query($sql);
        while($row = $query->fetch_assoc()){
            $arr[] = $row;
        }
        $this->conn->close();
        return $arr;
    }


	public function employee_attend($param = array())
    {
        $from = $param['from'];
        $to = $param['to'];
		$employee_id = $param['employee_id'];

        $arr = array();

        $prquery = $this->conn->query("SELECT *, attendance.employee_id AS empid FROM attendance LEFT JOIN employees ON employees.id=attendance.employee_id WHERE date BETWEEN '$from' AND '$to' AND employees.employee_id = '$employee_id' ");
        
       
        while($row = $prquery->fetch_assoc()){
          $empid = $row['empid'];
                          

            $arr[] = array(
              
              'fullname'=>$row['lastname'].', '.$row['firstname'],
              'employee_id'=>$row['employee_id'],
			  'time_in' => $row['time_in'],
			  'time_out' => $row['time_out'],
			  'date_att' => $row['date']
               
              
            );

          
        }
        
        $this->conn->close();
        return $arr;

    }

}

?>