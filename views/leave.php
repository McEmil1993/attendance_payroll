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
        Leave
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Leave</li>
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
              <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> New</a>
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th>Employee ID</th>
                  <th>Fullname</th>
                  <th>From - To</th>
                  <th>Type</th>
                  <th>Description</th>
                  <th>Status</th>
                  <th>Tool</th>
                </thead>
                <tbody>
                  <?php
                    foreach($data['leave'] as $row){
                        $st = '';
                        if($row['status'] == '0'){
                            $st = 'Pending';
                        }elseif($row['status'] == '2'){
                            $st = 'Not Approved';
                        }else{
                            $st = 'Approved';
                        }
                      echo "
                        <tr>
                            <td>".$row['employee_id']."</td>
                            <td>".$row['fullname']."</td>
                            <td>".$row['from_date']. ' - '.$row['to_date']."</td>
                            <td>".$row['type']."</td>
                            <td>".$row['description']."</td>
                            <td>".$st."</td>
                          <td>
                            <div class='btn-group'>
                                <button type='button' class='btn btn-success edit' data-id='".$row['lid']."'><i class='fa fa-edit'></i> </button>
                                <a href='/leave/approved?id=".$row['lid']."' class='btn btn-warning' data-id='".$row['lid']."'><i class='fa fa-thumbs-up'></i> </a>
                                <a href='/leave/disapproved?id=".$row['lid']."'  class='btn btn-danger' data-id='".$row['lid']."'><i class='fa  fa-thumbs-down'></i> </a>
                            </div>
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
  <?php require PATH_VIEW.'includes/leave_modal.php'; ?>
</div>
<?php require PATH_VIEW.'includes/scripts.php'; ?>
<script>
  
  $('.edit').click(function(e){
    e.preventDefault();
    $('#edit').modal('show');
    var id = $(this).data('id');
    // console.log(id);
   
    $.ajax({
        type: 'POST',
        url: '/leave/edit',
        data: {id:id},
        dataType: 'json',
        success: function(response){
           
           
        $('#leaveid').val(response.id);
          $('#e_desctiption').val(response.description);
          $('#e_emp_id').val(response.emp_id);
          $('#e_type').val(response.type);
          $('#reservation2').val(response.from_date+' - '+  response.to_date);
        }
    });
  });

//   $('.delete').click(function(e){
//     e.preventDefault();
//     $('#delete').modal('show');
//     var id = $(this).data('id');
//     getRow(id);
//   });



</script>
</body>
</html>
