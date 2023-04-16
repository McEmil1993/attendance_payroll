<?php
	$conn = new mysqli('localhost', 'root', '', 'attend_payroll_db');

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	
?>