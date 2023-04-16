
<?php require PATH_VIEW.'includes/header.php'; ?>
<body class="hold-transition sidebar-mini skin-black">
<div class="wrapper">
<?php
  
  $range_to = date('m/d/Y');
  $range_from = date('m/d/Y', strtotime('-30 day', strtotime($range_to)));
?>
  <?php require PATH_VIEW.'includes/navbar.php'; ?>
  <?php require PATH_VIEW.'includes/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Payroll
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Payroll</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <?php
        if(isset($_SESSION['error'])){
          echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              ".$_SESSION['error']."
            </div>
          ";
          unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
          echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              ".$_SESSION['success']."
            </div>
          ";
          unset($_SESSION['success']);
        }
      ?>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <div class="pull-right">
                <form method="POST" class="form-inline" id="payForm" target="_blank">
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right col-sm-8" id="reservation" name="date_range" value="<?php echo (isset($_GET['range'])) ? $_GET['range'] : $range_from.' - '.$range_to; ?>">
                  </div>
                  <a href="#" class="btn btn-success btn-sm btn-flat" id="payroll" ><span class="glyphicon glyphicon-print"></span> Payroll</a>
                  <a href="#" class="btn btn-warning btn-sm btn-flat" id="send_sms" ><span class="glyphicon glyphicon-envelope"></span> Send SMS</a>
                </form>
              </div>
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th>Employee Name</th>
                  <th>Employee ID</th>
                  <th>Gross</th>
                  <th>Deductions</th>
                  <th>Cash Advance</th>
                  <th>Net Pay</th>
                </thead>
                <tbody>
                  <?php
                    
                    foreach($data as $row){
                    
                      echo "
                        <tr>
                          <td>".$row['fullname']."</td>
                          <td>".$row['employee_id']."</td>
                          <td>".$row['gross']."</td>
                          <td>".$row['deduction']."</td>
                          <td>".$row['cashadvance']."</td>
                          <td>".$row['net']."</td>
                        </tr>
                      ";
                    }

                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>   
  </div>
    
  <?php require PATH_VIEW.'includes/footer.php'; ?>
  <?php require PATH_VIEW.'includes/overtime_modal.php'; ?>
</div>
<?php require PATH_VIEW.'includes/scripts.php'; ?>
<script>
$(function(){
  $('.edit').click(function(e){
    e.preventDefault();
    $('#edit').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $('.delete').click(function(e){
    e.preventDefault();
    $('#delete').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $("#reservation").on('change', function(){
    var range = encodeURI($(this).val());
    window.location = '/payroll?range='+range;
  });

  $('#payroll').click(function(e){
    e.preventDefault();
    $('#payForm').attr('action', 'payroll/print');
    $('#payForm').submit();
  });

  $('#send_sms').click(function(e){
    e.preventDefault();
    $('#payForm').removeAttr("target");
    $('#payForm').attr('action', 'payroll/send_sms');
    $('#payForm').submit();
  });

  
});

function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'position_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('#posid').val(response.id);
      $('#edit_title').val(response.description);
      $('#edit_rate').val(response.rate);
      $('#del_posid').val(response.id);
      $('#del_position').html(response.description);
    }
  });
}

</script>
</body>
</html>
