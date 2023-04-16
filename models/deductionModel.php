<?php
class deductionModel {
    private $conn;

    public function __construct(){
        $db = new database();
        $this->conn = $db->connection();
    }

    public function all()
    {
        

        $arr = array();
        $sql = "SELECT * FROM deductions";
        $query = $this->conn->query($sql);
        while($row = $query->fetch_assoc()){
            $arr[] = $row;
        }
        $this->conn->close();
        return $arr;
    }

    public function save($param = array())
    {
        $description = $param['description'];
		$amount = $param['amount'];

		$sql = "INSERT INTO deductions (description, amount) VALUES ('$description', '$amount')";
		if($this->conn->query($sql)){
			$_SESSION['success'] = 'Deduction added successfully';
		}
		else{
			$_SESSION['error'] = $this->conn->error;
		}
    }

    public function getId($id)
    {
       
		$sql = "SELECT * FROM deductions WHERE id = '$id'";
		$query = $this->conn->query($sql);
		$row = $query->fetch_assoc();

    
		return ($row);
    }
    public function update($param = array())
    {
        $id = $param['id'];
		$description = $param['description'];
		$amount = $param['amount'];

		$sql = "UPDATE deductions SET description = '$description', amount = '$amount' WHERE id = '$id'";
		if($this->conn->query($sql)){
			$_SESSION['success'] = 'Deduction updated successfully';
		}
		else{
			$_SESSION['error'] = $this->conn->error;
		}
    }

    public function delete($id)
    {
		$sql = "DELETE FROM deductions WHERE id = '$id'";
		if($this->conn->query($sql)){
			$_SESSION['success'] = 'Deduction deleted successfully';
		}
		else{
			$_SESSION['error'] = $this->conn->error;
		}
    }

}

?>