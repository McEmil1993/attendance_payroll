<?php

class database{

	private $hostname = DB_HOST;
	private $username = DB_USERNAME;
	private $password = DB_PASSWORD;
	private $database_name = DB_NAME;
	private $conn;

	
	public function connection(){
		$this->conn = new mysqli($this->hostname, $this->username, $this->password, $this->database_name);

		if ($this->conn->connect_error){
			echo 'Failed to connect to MySQL '. mysqli_connect_error();
		}
		else{
			mysqli_select_db($this->conn, $this->database_name);
			$this->conn = new mysqli($this->hostname, $this->username, $this->password, $this->database_name);
			return $this->conn;
		}
	}

}
	
?>