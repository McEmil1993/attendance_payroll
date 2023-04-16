<?php
class scheduleModel {
    private $conn;

    public function __construct(){
        $db = new database();
        $this->conn = $db->connection();
    }

    public function all()
    {
        $arr = array();
        $sql = "SELECT * FROM schedules";
        $query = $this->conn->query($sql);
        while($row = $query->fetch_assoc()){
            $arr[] = $row;
        }
        $this->conn->close();
        return $arr;
    }

	public function getAllEmSched()
	{
		$arr = array();
		$sql = "SELECT *, employees.id AS empid FROM employees LEFT JOIN schedules ON schedules.id=employees.schedule_id";
		$query = $this->conn->query($sql);
		while($row = $query->fetch_assoc()){
			$arr[] = $row;
		}
		$this->conn->close();
		return $arr;
	}

    public function save($param = array())
    {
        $time_in = $param['time_in'];
		$time_in = date('H:i:s', strtotime($time_in));
		$time_out = $param['time_out'];
		$time_out = date('H:i:s', strtotime($time_out));

		$sql = "INSERT INTO schedules (time_in, time_out) VALUES ('$time_in', '$time_out')";
		if($this->conn->query($sql)){
			$_SESSION['success'] = 'Schedule added successfully';
		}
		else{
			$_SESSION['error'] = $this->conn->error;
		}
    }

    public function getId($id)
    {
       
		$sql = "SELECT * FROM schedules WHERE id = '$id'";
		$query = $this->conn->query($sql);
		$row = $query->fetch_assoc();

    
		return ($row);
    }

	public function getIdSced($id)
	{
		$sql = "SELECT *, employees.id AS empid FROM employees LEFT JOIN schedules ON schedules.id=employees.schedule_id WHERE employees.id = '$id'";
		$query = $this->conn->query($sql);
		$row = $query->fetch_assoc();
		return ($row);
	}
    public function update($param = array())
    {
        $id = $param['id'];
		$time_in = $param['time_in'];
		$time_in = date('H:i:s', strtotime($time_in));
		$time_out = $param['time_out'];
		$time_out = date('H:i:s', strtotime($time_out));

		$sql = "UPDATE schedules SET time_in = '$time_in', time_out = '$time_out' WHERE id = '$id'";
		if($this->conn->query($sql)){
			$_SESSION['success'] = 'Schedule updated successfully';
		}
		else{
			$_SESSION['error'] = $this->conn->error;
		}
    }

    public function delete($id)
    {
		
		$sql = "DELETE FROM schedules WHERE id = '$id'";
		if($this->conn->query($sql)){
			$_SESSION['success'] = 'Schedule deleted successfully';
		}
		else{
			$_SESSION['error'] = $this->conn->error;
		}
    }

}

?>