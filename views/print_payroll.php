<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}

th, td {
  padding: 4px;
  text-align: top-left;
 
}

</style>
</head>
<body>
<center>
  <h2>Employee Payroll</h2>
</center>
<?php
$i = 1;
  foreach($data['result'] as $row){
?>
<table style="width:100%; margin-bottom: 20px;">
  <tr>
    <td rowspan="4">Employee ID: <br><br>&emsp;<strong><?=$row['employee_id'] ?></strong></td>
    <td rowspan="4">Fullname:  <br><br>&emsp;<strong><?=$row['fullname'] ?></strong></td> 
    <td rowspan="4">Pay Run Period:  <br><br>&emsp;<strong><?=$data['from_title'].' - '. $data['to_title'] ?></strong></td>
      
 
   
  </tr> 
  <tr>
   <?php foreach ($data['dec'] as $drow) { ?>
  
      <td><?= $drow['description']. ':<br>P '. number_format($drow['amount'],2) ?></td>


  <?php } ?> 

  <td>Cash advance: <br>&emsp;P <?=$row['cashadvance']?></td>
 </tr>
 
   <tr>
    <td colspan="2">
      Net pay:<br> &emsp;<strong>P <?=$row['total'] ?></strong>
    </td>
     <td>
      Basic salary:<br> &emsp;<strong>P <?=$row['gross'] ?></strong>
    </td>

     <td>
      Total deductions:<br> &emsp;<strong>P <?=$row['total_deduction'] ?></strong>
    </td>
   </tr>

</table>
<?php
  }
?>

<script type="text/javascript">
  window.print();
</script>
</body>
</html>




