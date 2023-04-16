<!DOCTYPE html>
<html>
<head>
	<title>Employee Schedule</title>
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
	<h2>Employee Schedule</h2>
</center>


<table style="width:100%">
  	<tr>
  		<th>No. #</th>
		<th>Employee ID</th>
		<th>Name</th>
		<th>Schedule</th>
  	</tr>

  	 <?php
  	 	$i = 1;
        foreach($data as $row){
          echo "
            <tr>
              <td>".$i++."</td>
              <td>".$row['employee_id']."</td>
              <td>".$row['firstname'].' '.$row['lastname']."</td>
              <td>".date('h:i A', strtotime($row['time_in'])).' - '.date('h:i A', strtotime($row['time_out']))."</td>
             
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