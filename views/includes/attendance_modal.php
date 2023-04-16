<!-- Add -->

<?php
  
  $range_to = date('m/d/Y');
  $range_from = date('m/d/Y', strtotime('-30 day', strtotime($range_to)));
?>
<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Add Attendance</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="/attendance/store">
          		  <div class="form-group">
                  	<label for="employee" class="col-sm-3 control-label">Employee ID</label>

                  	<div class="col-sm-9">
                    	<input type="text" class="form-control" id="employee" name="employee" required>
                  	</div>
                </div>
                <div class="form-group">
                    <label for="datepicker_add" class="col-sm-3 control-label">Date</label>

                    <div class="col-sm-9"> 
                      <div class="date">
                        <input type="text" class="form-control" id="datepicker_add" name="date" required>
                      </div>
                    </div>
                </div>
                <div class="form-group">
                  	<label for="time_in" class="col-sm-3 control-label">Time In</label>

                  	<div class="col-sm-9">
                  		<div class="bootstrap-timepicker">
                    		<input type="text" class="form-control timepicker" id="time_in" name="time_in">
                    	</div>
                  	</div>
                </div>
                <div class="form-group">
                  	<label for="time_out" class="col-sm-3 control-label">Time Out</label>

                  	<div class="col-sm-9">
                  		<div class="bootstrap-timepicker">
                    		<input type="text" class="form-control timepicker" id="time_out" name="time_out">
                    	</div>
                  	</div>
                </div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            	<button type="submit" class="btn btn-primary btn-flat" name="add"><i class="fa fa-save"></i> Save</button>
            	</form>
          	</div>
        </div>
    </div>
</div>

<!-- Edit -->
<div class="modal fade" id="edit">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b><span id="employee_name"></span></b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="/attendance/update">
            		<input type="hidden" id="attid" name="id">
                <div class="form-group">
                    <label for="datepicker_edit" class="col-sm-3 control-label">Date</label>

                    <div class="col-sm-9"> 
                      <div class="date">
                        <input type="text" class="form-control" id="datepicker_edit" name="edit_date">
                      </div>
                    </div>
                </div>
                <div class="form-group">
                  	<label for="edit_time_in" class="col-sm-3 control-label">Time In</label>

                  	<div class="col-sm-9">
                  		<div class="bootstrap-timepicker">
                    		<input type="text" class="form-control timepicker" id="edit_time_in" name="edit_time_in">
                    	</div>
                  	</div>
                </div>
                <div class="form-group">
                  	<label for="edit_time_out" class="col-sm-3 control-label">Time Out</label>

                  	<div class="col-sm-9">
                  		<div class="bootstrap-timepicker">
                    		<input type="text" class="form-control timepicker" id="edit_time_out" name="edit_time_out">
                    	</div>
                  	</div>
                </div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            	<button type="submit" class="btn btn-success btn-flat" name="edit"><i class="fa fa-check-square-o"></i> Update</button>
            	</form>
          	</div>
        </div>
    </div>
</div>

<!-- Delete -->
<div class="modal fade" id="delete">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b><span id="attendance_date"></span></b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="/attendance/destroy">
            		<input type="hidden" id="del_attid" name="id">
            		<div class="text-center">
	                	<p>DELETE ATTENDANCE</p>
	                	<h2 id="del_employee_name" class="bold"></h2>
	            	</div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            	<button type="submit" class="btn btn-danger btn-flat" name="delete"><i class="fa fa-trash"></i> Delete</button>
            	</form>
          	</div>
        </div>
    </div>
</div>

<!-- Delete -->
<div class="modal fade" id="upload_file">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
			  <label for="file">Choose Excel file to upload</label>
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b><span id="attendance_date"></span></b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="/attendance/update_file" enctype="multipart/form-data">
					
            		<input type="file" name="file" id="file" require>
    			
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            	<button type="submit" class="btn btn-primary btn-flat" name="submit"><i class="fa fa-trash"></i> Save</button>
            	</form>
          	</div>
        </div>
    </div>
</div>



<!-- Delete -->
<div class="modal fade" id="employee_attend">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Select Employee</span></b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="/attendance/employee_attend" target="_blank">
            		<input type="hidden" id="s_em_id" name="id">
					<div class="form-group">
						<label for="employee" class="col-sm-3 control-label">Employee ID</label>

						<div class="col-sm-9">
							<input type="text" class="form-control" id="empl" name="employee" placeholder="Input Employee id" required>
						</div>
					</div>


					<div class="form-group">
						<label for="employee" class="col-sm-3 control-label">Date (From/to) </label>
						<div class="col-sm-9">
							<div class="input-group">
								<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
								</div>
								<input type="text" class="form-control pull-right col-sm-8" id="reservation" name="date_range" value="<?php echo (isset($_GET['range'])) ? $_GET['range'] : $range_from.' - '.$range_to; ?>">
							</div>
						</div>
					</div>

				
            		<!-- <div class="text-center">
	                	<p>DELETE ATTENDANCE</p>
	                	<h2 id="del_employee_name" class="bold"></h2>
	            	</div> -->
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            	<button type="submit" class="btn btn-primary btn-flat" name="save"><i class="fa fa-trash"></i> Submit</button>
            	</form>
          	</div>
        </div>
    </div>
</div>


     