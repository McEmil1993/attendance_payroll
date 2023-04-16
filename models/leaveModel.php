<?php
class leaveModel {
    private $conn;

    public function __construct(){
        $db = new database();
        $this->conn = $db->connection();
    }

    public function all()
    {
        

        $arr = array();
        $sql = "SELECT *, `leave`.id as lid,CONCAT(`employees`.`lastname`,', ',`employees`.`firstname`) as fullname FROM `leave` INNER JOIN employees ON employees.id = `leave`.emp_id";
        $query = $this->conn->query($sql);
        while($row = $query->fetch_assoc()){
            $arr[] = $row;
        }
        $this->conn->close();
        return $arr;
    }

    public function save($param = array())
    {

        $from = $param['from'];
        $to = $param['to'];
		$emp_id = $param['emp_id'];
        $desctiption = $param['desctiption'];
		$type = $param['type'];

		$sql = "INSERT INTO `leave`(`type`, `from_date`, `to_date`, `emp_id`, `status`, `description`) VALUES ('$type','$from','$to','$emp_id','0','$desctiption')";
		if($this->conn->query($sql)){
			$_SESSION['success'] = 'Leave added successfully';
		}
		else{
			$_SESSION['error'] = $this->conn->error;
		}
    }

    public function approved($id)
    {
        
		$sql = "UPDATE `leave` SET `status`='1' WHERE `id`= '$id'";
		if($this->conn->query($sql)){
			$_SESSION['success'] = 'Leave approved successfully';
		}
		else{
			$_SESSION['error'] = $this->conn->error;
		}

    }

    public function disapproved($id)
    {
        $sql = "UPDATE `leave` SET `status`='2' WHERE `id`= '$id'";
		if($this->conn->query($sql)){
			$_SESSION['success'] = 'Leave disapproved successfully';
		}
		else{
			$_SESSION['error'] = $this->conn->error;
		}

    }

    public function getId($id)
    {
       
		$sql = "SELECT * FROM `leave` WHERE id = '$id'";
		$query = $this->conn->query($sql);
		$row = $query->fetch_assoc();

    
		return ($row);
    }
    public function update($param = array())
    {
        $id = $param['id'];
		$from = $param['from'];
        $to = $param['to'];
		$emp_id = $param['emp_id'];
        $desctiption = $param['desctiption'];
		$type = $param['type'];
        
		$sql = "UPDATE `leave` SET `type`='$type',`from_date`='$from',`to_date`='$to',`emp_id`='$emp_id',`status`='0',`description`='$desctiption' WHERE `id`= '$id'";
		if($this->conn->query($sql)){
			$_SESSION['success'] = 'Leave update successfully';
		}
		else{
			$_SESSION['error'] = $this->conn->error;
		}
    }

    public function delete($id)
    {
		$sql = "DELETE FROM `leave` WHERE id = '$id'";
		if($this->conn->query($sql)){
			$_SESSION['success'] = 'leave deleted successfully';
		}
		else{
			$_SESSION['error'] = $this->conn->error;
		}
    }

}

?>