<!DOCTYPE html>
<html>
<head>
	<title>Employee DTR</title>
<style>
table {
  border-collapse: collapse;
  width: 100%;
}

th, td {
  padding: 8px;
  text-align: left;
  border-bottom: 1px solid #DDD;
}
</style>
</head>
<body>
<center>
	<h2>Employee DTR</h2>
</center>


<table style="width:100%">
  	<tr>
  		<th>No. #</th>
		<th>Employee ID</th>
		<th>Name</th>
        <th>Date</th>
		<th>Time-in</th>
        <th>Time-out</th>
  	</tr>

  	 <?php
  	 	$i = 1;
        foreach($data as $row){
          echo "
            <tr>
              <td>".$i++."</td>
              <td>".$row['employee_id']."</td>
              <td>".$row['fullname']."</td>
              <td>".$row['date_att']."</td>
              <td>".date('h:i A', strtotime($row['time_in']))."</td>
              <td>".date('h:i A', strtotime($row['time_out']))."</td>
              
            </tr>
          ";
        }
      ?>
 
</table>
<script type="text/javascript">
	window.print();
</script>
</body>
</html>