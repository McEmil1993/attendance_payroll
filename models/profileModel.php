

<?php
class profileModel{
    private $conn;

    public function __construct(){
        $db = new database();
        $this->conn = $db->connection();
    }

	public function profile($param = array())
	{
		$curr_password = $param['curr_password'];
		$username = $param['username'];
		$password = $param['password'];
		$firstname = $param['firstname'];
		$lastname = $param['lastname'];
		$photo = $param['photo'];

		$sql = "SELECT * FROM admin WHERE id = '".$_SESSION['admin']."'";
		$query =  $this->conn->query($sql);
		$user = $query->fetch_assoc();

		if(password_verify($curr_password, $user['password'])){
		
			if($password == $user['password']){
				$password = $user['password'];
			}
			else{
				$password = password_hash($password, PASSWORD_DEFAULT);
			}

			$sql = "UPDATE admin SET username = '$username', password = '$password', firstname = '$firstname', lastname = '$lastname', photo = '$photo' WHERE id = '".$user['id']."'";
			if( $this->conn->query($sql)){
				$_SESSION['success'] = 'Admin profile updated successfully';
			}
			else{
				$_SESSION['error'] =  $this->conn->error;
			}
			
		}
		else{
			$_SESSION['error'] = 'Incorrect password';
		}
	}


}