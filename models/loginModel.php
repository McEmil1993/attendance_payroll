<?php
/**
 * 
 */
class LoginModel
{
	
	private $conn;

    public function __construct(){
        $db = new database();
        $this->conn = $db->connection();
    }

    public function login($param= array())
    {
        $username = $param['username'];
    	$password = $param['password'];

        $data = "";

        $sql = "SELECT * FROM admin WHERE username = '$username'";
		$query = $this->conn->query($sql);

		if($query->num_rows < 1){
			$_SESSION['error'] = 'Cannot find account with the username';
            $data = '0';
		}
		else{
			$row = $query->fetch_assoc();
			if(password_verify($password, $row['password'])){
				$_SESSION['admin'] = $row['id'];
                $data = '1';

                

			}
			else{
				$_SESSION['error'] = 'Incorrect password';
                $data = '2';
			}
		}
        $this->conn->close();

        return $data;

    }

   

}

?>