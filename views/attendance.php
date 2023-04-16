
<?php require PATH_VIEW.'includes/header.php'; ?>
<body class="hold-transition sidebar-mini skin-black">
<div class="wrapper">

  <?php require PATH_VIEW.'includes/navbar.php'; ?>
  <?php require PATH_VIEW.'includes/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Attendance
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Attendance</li>
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
            <div style="width: 100%">
              <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat" style="float: left;"><i class="fa fa-plus"></i> New</a>
             
              <div class="form-group" style="float: left;margin-left: 5px ">
              <a href="#" data-toggle="modal" class="btn btn-success btn-sm btn-flat upload_file" style="float: left;"><i class="fa fa-plus"></i> Upload Attendance</a>
              </div>
              <div class="form-group" style="float: left;margin-left: 5px ">
              <a href="#" data-toggle="modal" class="btn btn-info btn-sm btn-flat employee_attend_e" style="float: left;"><i class="fa fa-plus"></i> Select Employee</a>
              </div>
    
            </div>
            </div>

            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th class="hidden"></th>
                  <th>Date</th>
                  <th>Employee ID</th>
                  <th>Name</th>
                  <th>Time In</th>
                  <th>Time Out</th>
                  <th>Tools</th>
                </thead>
                <tbody>
                  <?php
                    foreach($data as $empl){
                        $status = ($empl['status'])?'<span class="label label-warning pull-right">ontime</span>':'<span class="label label-danger pull-right">late</span>';
                        echo "<tr>
                        <td class='hidden'></td>
                        <td>".date('M d, Y', strtotime($empl['date']))."</td>
                        <td>".$empl['empid']."</td>
                        <td>".$empl['firstname'].' '.$empl['lastname']."</td>
                        <td>".date('h:i A', strtotime($empl['time_in'])).$status."</td>
                        <td>".date('h:i A', strtotime($empl['time_out']))."</td>
                        <td>
                          <button class='btn btn-success btn-sm btn-flat edit' data-id='".$empl['attid']."'><i class='fa fa-edit'></i> Edit</button>
                          <button class='btn btn-danger btn-sm btn-flat delete' data-id='".$empl['attid']."'><i class='fa fa-trash'></i> Delete</button>
                        </td>
                      </tr>";
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
  <?php require PATH_VIEW.'includes/attendance_modal.php'; ?>
</div>
<?php require PATH_VIEW.'includes/scripts.php'; ?>
<script>
 $(document).ready(function(){

$('#sample_form').on('submit', function(event){
 $('#message').html('');
 event.preventDefault();
 $.ajax({
  url:"import.php",
  method:"POST",
  data: new FormData(this),
  dataType:"json",
  contentType:false,
  cache:false,
  processData:false,
  success:function(data)
  {
   $('#message').html('<div class="alert alert-success">'+data.success+'</div>');
   $('#sample_form')[0].reset();
   location.reload();
  }
 })
});

});
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
  $('.upload_file').click(function(e){
    e.preventDefault();
    $('#upload_file').modal('show');
    // var id = $(this).data('id');
    // getRow(id); employee_attend
  });


  $('.employee_attend_e').click(function(e){
    e.preventDefault();
    $('#employee_attend').modal('show');
    // var id = $(this).data('id');
    // getRow(id);
  });


function getRow(id){
  $.ajax({
    type: 'POST',
    url: '/attendance/edit',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('#datepicker_edit').val(response.date);
      $('#attendance_date').html(response.date);
      $('#edit_time_in').val(response.time_in);
      $('#edit_time_out').val(response.time_out);
      $('#attid').val(response.attid);
      $('#employee_name').html(response.firstname+' '+response.lastname);
      $('#del_attid').val(response.attid);
      $('#del_employee_name').html(response.firstname+' '+response.lastname);
      console.log(response);
    },
    error: function(error){
        console.log(error);

    }
  });
}
</script>
</body>
</html>
