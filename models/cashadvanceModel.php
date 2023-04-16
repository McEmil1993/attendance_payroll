<?php

class cashadvanceModel {
    private $conn;

    public function __construct(){
        $db = new database();
        $this->conn = $db->connection();
    }

    public function all()
    {
    
        $arr = array();
        $sql = "SELECT *, cashadvance.id AS caid, employees.employee_id AS empid FROM cashadvance LEFT JOIN employees ON employees.id=cashadvance.employee_id ORDER BY date_advance DESC";
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
		$amount = $param['amount'];
		
		$sql = "SELECT * FROM employees WHERE employee_id = '$employee'";
		$query = $this->conn->query($sql);
		if($query->num_rows < 1){
			$_SESSION['error'] = 'Employee not found';
		}
		else{
			$row = $query->fetch_assoc();
			$employee_id = $row['id'];
			$sql = "INSERT INTO cashadvance (employee_id, date_advance, amount) VALUES ('$employee_id', NOW(), '$amount')";
			if($this->conn->query($sql)){
				$_SESSION['success'] = 'Cash Advance added successfully';
			}
			else{
				$_SESSION['error'] = $this->conn->error;
			}
		}
    }

    public function getId($id)
    {
       
		$sql = "SELECT *, cashadvance.id AS caid FROM cashadvance LEFT JOIN employees on employees.id=cashadvance.employee_id WHERE cashadvance.id='$id'";
		$query = $this->conn->query($sql);
		$row = $query->fetch_assoc();

    
		return ($row);
    }
    public function update($param = array())
    {
        $id = $param['id'];
		$amount = $param['amount'];
		
		$sql = "UPDATE cashadvance SET amount = '$amount' WHERE id = '$id'";
		if($this->conn->query($sql)){
			$_SESSION['success'] = 'Cash advance updated successfully';
		}
		else{
			$_SESSION['error'] = $this->conn->error;
		}
    }

    public function delete($id)
    {
		$sql = "DELETE FROM cashadvance WHERE id = '$id'";
		if($this->conn->query($sql)){
			$_SESSION['success'] = ' Cash advance deleted successfully';
		}
		else{
			$_SESSION['error'] = $this->conn->error;
		}
    }

}

?>