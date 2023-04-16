<?php
class overtimeModel {
    private $conn;

    public function __construct(){
        $db = new database();
        $this->conn = $db->connection();
    }

    public function all()
    {
        

        $arr = array();
        $sql = "SELECT *, overtime.id AS otid, employees.employee_id AS empid FROM overtime LEFT JOIN employees ON employees.id=overtime.employee_id ORDER BY date_overtime DESC";
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
		$hours = $param['hours'] + ($param['mins']/60);
		$rate = $param['rate'];
		$sql = "SELECT * FROM employees WHERE employee_id = '$employee'";
		$query = $this->conn->query($sql);
		if($query->num_rows < 1){
			$_SESSION['error'] = 'Employee not found';
		}
		else{
			$row = $query->fetch_assoc();
			$employee_id = $row['id'];
			$sql = "INSERT INTO overtime (employee_id, date_overtime, hours, rate) VALUES ('$employee_id', '$date', '$hours', '$rate')";
			if($this->conn->query($sql)){
				$_SESSION['success'] = 'Overtime added successfully';
			}
			else{
				$_SESSION['error'] = $this->conn->error;
			}
		}
    }

    public function getId($id)
    {
       
		$sql = "SELECT *, overtime.id AS otid FROM overtime LEFT JOIN employees on employees.id=overtime.employee_id WHERE overtime.id='$id'";
		$query = $this->conn->query($sql);
		$row = $query->fetch_assoc();

    
		return ($row);
    }
    public function update($param = array())
    {
        $id = $param['id'];
		$date = $param['date'];
		$hours = $param['hours'] + ($param['mins']/60);
		$rate = $param['rate'];

		$sql = "UPDATE overtime SET hours = '$hours', rate = '$rate', date_overtime = '$date' WHERE id = '$id'";
		if($this->conn->query($sql)){
			$_SESSION['success'] = 'Overtime updated successfully';
		}
		else{
			$_SESSION['error'] = $this->conn->error;
		}
    }

    public function delete($id)
    {
		$sql = "DELETE FROM overtime WHERE id = '$id'";
		if($this->conn->query($sql)){
			$_SESSION['success'] = 'Overtime deleted successfully';
		}
		else{
			$_SESSION['error'] = $this->conn->error;
		}
    }

}

?>