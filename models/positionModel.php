<?php
class positionModel {
    private $conn;

    public function __construct(){
        $db = new database();
        $this->conn = $db->connection();
    }

    public function all()
    {
        

        $arr = array();
        $sql = "SELECT * FROM position";
        $query = $this->conn->query($sql);
        while($row = $query->fetch_assoc()){
            $arr[] = $row;
        }
        $this->conn->close();
        return $arr;
    }

    public function save($param = array())
    {
        $title = $param['title'];
		    $rate = $param['rate'];

		$sql = "INSERT INTO position (description, rate) VALUES ('$title', '$rate')";
		if($this->conn->query($sql)){
			$_SESSION['success'] = 'Position added successfully';
		}
		else{
			$_SESSION['error'] = $this->conn->error;
		}
    }

    public function getId($id)
    {
       
        $sql = "SELECT * FROM position WHERE id = '$id'";
        $query = $this->conn->query($sql);
        $row = $query->fetch_assoc();

        return ($row);
    }
    public function update($param = array())
    {
        $id = $param['id'];
		$title = $param['title'];
		$rate = $param['rate'];

		$sql = "UPDATE position SET description = '$title', rate = '$rate' WHERE id = '$id'";
		if($this->conn->query($sql)){
			$_SESSION['success'] = 'Position updated successfully';
		}
		else{
			$_SESSION['error'] = $this->conn->error;
		}
    }

    public function delete($id)
    {
		$sql = "DELETE FROM position WHERE id = '$id'";
		if($this->conn->query($sql)){
			$_SESSION['success'] = 'Position deleted successfully';
		}
		else{
			$_SESSION['error'] = $this->conn->error;
		}
    }

}

?>