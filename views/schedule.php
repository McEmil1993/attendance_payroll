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
        Schedules
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Employees</li>
        <li class="active">Schedules</li>
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
        <div class="col-sm-6">
          <div class="box">
            <div class="box-header with-border">
            
              <!-- <div class="btn-group">
                <a href="#addnew" data-toggle="modal" class="btn btn-primary">New</a>
                <a href="#addnew" data-toggle="modal" class="btn btn-primary">Employee Schedules</a>
              </div> -->
              <!-- <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> New</a> -->
              <div class="row">
                <div class="col-sm-6">
                  <h4>
                    Employees Schedule
                  </h4>
                </div>
                <div class="col-sm-6">
                  <a href="/schedule/employees" target="new" class="btn btn-success btn-sm btn-flat" style="float:right"><span class="glyphicon glyphicon-print"></span> Print</a>
                </div>
              </div>
              
             
            </div>
            <div class="box-body">
              <table id="table_schedule" class="table table-bordered">
                <thead>
                  <th>Employee ID</th>
                  <th>Name</th>
                  <th>Schedule</th>
                 
                </thead>
                <tbody>
                  <?php
                    foreach($data['sched'] as $row){
                      echo "
                        <tr>
                          <td>".$row['employee_id']."</td>
                          <td>".$row['firstname'].' '.$row['lastname']."</td>
                          <td>".date('h:i A', strtotime($row['time_in'])).' - '.date('h:i A', strtotime($row['time_out']))."</td>
                         
                        </tr>
                      ";
                    }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="box">
            <div class="box-header with-border">
            
              <!-- <div class="btn-group">
                <a href="#addnew" data-toggle="modal" class="btn btn-primary">New</a>
                <a href="#addnew" data-toggle="modal" class="btn btn-primary">Employee Schedules</a>
              </div> -->
              <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> New</a>
            
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th>Time In</th>
                  <th>Time Out</th>
                  <th>Tools</th>
                </thead>
                <tbody>
                  <?php
                    foreach($data['em'] as $row){
                      echo "
                        <tr>
                          <td>".date('h:i A', strtotime($row['time_in']))."</td>
                          <td>".date('h:i A', strtotime($row['time_out']))."</td>
                          <td>
                            <button class='btn btn-success btn-sm edit btn-flat' data-id='".$row['id']."'><i class='fa fa-edit'></i> Edit</button>
                            <button class='btn btn-danger btn-sm delete btn-flat' data-id='".$row['id']."'><i class='fa fa-trash'></i> Delete</button>
                          </td>
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
  <?php require PATH_VIEW.'includes/schedule_modal.php'; ?>
  <?php require PATH_VIEW.'includes/employee_schedule_modal.php'; ?>
</div>

<?php require PATH_VIEW.'includes/scripts.php'; ?>
<script>
 

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


function getRow(id){
  $.ajax({
    type: 'POST',
    url: '/schedule/edit',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('#timeid').val(response.id);
      $('#edit_time_in').val(response.time_in);
      $('#edit_time_out').val(response.time_out);
      $('#del_timeid').val(response.id);
      $('#del_schedule').html(response.time_in+' - '+response.time_out);
    }
  });
}

  $('.edit_sched').click(function(e){
    e.preventDefault();
    $('#edit_sched').modal('show');
    var id = $(this).data('id');
    getRowSc(id);
  });


function getRowSc(id){
  $.ajax({
    type: 'POST',
    url: '/schedule/editSched',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('.employee_name').html(response.firstname+' '+response.lastname);
      $('#schedule_val').val(response.schedule_id);
      $('#schedule_val').html(response.time_in+' '+response.time_out);
      $('#empid').val(response.empid);
    }
  });
}


</script>

<script type="text/javascript">   
    function imprimir() {
      var divToPrint=document.getElementById("table_schedule");
        newWin= window.open("");
        newWin.document.write(divToPrint.outerHTML);
        newWin.document.close();
        newWin.print();
    }
</script>
</body>
</html>
