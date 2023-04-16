<?php
class homeModel {
    private $conn;

    public function __construct(){
        $db = new database();
        $this->conn = $db->connection();
    }

    public function userDisplay()
    {
        $sql = "SELECT * FROM admin WHERE id = '".$_SESSION['admin']."'";
        $query = $this->conn->query($sql);
        $user = $query->fetch_assoc();

        return $user;
    }



}


?>