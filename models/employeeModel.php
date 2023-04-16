<?php
class employeeModel {
    private $conn;

    public function __construct(){
        $db = new database();
        $this->conn = $db->connection();
    }

    public function all()
    {
        $arr = array();
        $sql = "SELECT *, employees.id AS empid FROM employees LEFT JOIN position ON position.id=employees.position_id LEFT JOIN schedules ON schedules.id=employees.schedule_id";
        $query = $this->conn->query($sql);
        while($row = $query->fetch_assoc()){
            $arr[] = $row;
        }
        $this->conn->close();
        return $arr;
    }

    public function save($param = array())
    {
        $firstname = $param['firstname'];
		$lastname = $param['lastname'];
		$address = $param['address'];
		$birthdate = $param['birthdate'];
		$contact = $param['contact'];
		$gender = $param['gender'];
		$position = $param['position'];
		$schedule = $param['schedule'];
		$filename = $param['filename'];
		
		$letters = '';
		$numbers = '';
		foreach (range('A', 'Z') as $char) {
		    $letters .= $char;
		}
		for($i = 0; $i < 10; $i++){
			$numbers .= $i;
		}
		$employee_id = substr(str_shuffle($letters), 0, 3).substr(str_shuffle($numbers), 0, 9);
		//
		$sql = "INSERT INTO employees (employee_id, firstname, lastname, address, birthdate, contact_info, gender, position_id, schedule_id, photo, created_on) VALUES ('$employee_id', '$firstname', '$lastname', '$address', '$birthdate', '$contact', '$gender', '$position', '$schedule', '$filename', NOW())";
		if($this->conn->query($sql)){
			$_SESSION['success'] = 'Employee added successfully';
		}
		else{
			$_SESSION['error'] = $this->conn->error;
		}
    }

    public function getId($param)
    {
       
		$id = $param;
		$sql = "SELECT *, employees.id as empid FROM employees LEFT JOIN position ON position.id=employees.position_id LEFT JOIN schedules ON schedules.id=employees.schedule_id WHERE employees.id = '$id'";
		$query = $this->conn->query($sql);
		$row = $query->fetch_assoc();



    
		return ($row);
    }
    public function update($param = array())
    {
        $empid = $param['id'];
		$firstname = $param['firstname'];
		$lastname = $param['lastname'];
		$address = $param['address'];
		$birthdate = $param['birthdate'];
		$contact = $param['contact'];
		$gender = $param['gender'];
		$position = $param['position'];
		$schedule = $param['schedule'];
		
		$sql = "UPDATE employees SET firstname = '$firstname', lastname = '$lastname', address = '$address', birthdate = '$birthdate', contact_info = '$contact', gender = '$gender', position_id = '$position', schedule_id = '$schedule' WHERE id = '$empid'";
		if($this->conn->query($sql)){
			$_SESSION['success'] = 'Employee updated successfully';
		}
		else{
			$_SESSION['error'] = $this->conn->error;
		}
    }

    public function delete($id)
    {
       
		$sql = "DELETE FROM employees WHERE id = '$id'";
		if($this->conn->query($sql)){
			$_SESSION['success'] = 'Employee deleted successfully';
		}
		else{
			$_SESSION['error'] = $this->conn->error;
		}
    }

    public function update_photo($param = array())
    {
        $empid = $param['id'];
		$filename = $param['filename'];
		
		$sql = "UPDATE employees SET photo = '$filename' WHERE id = '$empid'";
		if($this->conn->query($sql)){
			$_SESSION['success'] = 'Employee photo updated successfully';
		}
		else{
			$_SESSION['error'] = $this->conn->error;
		}
    }

    

}

?>