<!-- Add -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Add Leave</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="/leave/store">
          		  <div class="form-group">
                  	<label for="title" class="col-sm-3 control-label">Employee</label>

                  	<div class="col-sm-9">
                      <select class="form-control" name="emp_id" id="emp_id" required>
                        <option value="" selected>- Select -</option>
                        <?php
                          
                          foreach($data['all'] as $prow){
                            echo "
                              <option value='".$prow['empid']."'>".$prow['lastname'].', '.$prow['firstname']."</option>
                            ";
                          }
                        ?>
                      </select>
                  	</div>
                </div>
                <div class="form-group">
                    <label for="rate" class="col-sm-3 control-label">Leave date</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control pull-right col-sm-8" id="reservation1" name="date_range" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="rate" class="col-sm-3 control-label">Description</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control " name="desctiption" value="" placeholder="Input Description">
                    </div>
                </div>
                <div class="form-group">
                    <label for="rate" class="col-sm-3 control-label">Leave type</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="type" id="type" required>
                            <option selected disabled > - Select type - </option>
                            <option value="Maternity" > Maternity Leave</option>
                            <option value="Paternity" > Paternity Leave</option>
                            <option value="Sick" > Sick Leave</option>
                            <option value="Unpaid" > Unpaid Leave</option>
                            <option value="Bereavement" > Bereavement Leave</option>
                        </select>
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
            	<h4 class="modal-title"><b>Update Leave</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="/leave/update">
            		<input type="hidden" id="leaveid" name="id">
                <div class="form-group">
                  	<label for="title" class="col-sm-3 control-label">Employee</label>

                  	<div class="col-sm-9">
                      <select class="form-control" name="emp_id" id="e_emp_id" required>
                        <option value="" selected>- Select -</option>
                        <?php
                          
                          foreach($data['all'] as $prow){
                            echo "
                              <option value='".$prow['empid']."'>".$prow['lastname'].', '.$prow['firstname']."</option>
                            ";
                          }
                        ?>
                      </select>
                  	</div>
                </div>
                <div class="form-group">
                    <label for="rate" class="col-sm-3 control-label">Leave date</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control pull-right col-sm-8" id="reservation2" name="date_range" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="rate" class="col-sm-3 control-label">Description</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control " id="e_desctiption" name="desctiption" value="" placeholder="Input Description">
                    </div>
                </div>
                <div class="form-group">
                    <label for="rate" class="col-sm-3 control-label">Leave type</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="type" id="e_type" required>
                            <option selected disabled > - Select type - </option>
                            <option value="Maternity" > Maternity Leave</option>
                            <option value="Paternity" > Paternity Leave</option>
                            <option value="Sick" > Sick Leave</option>
                            <option value="Unpaid" > Unpaid Leave</option>
                            <option value="Bereavement" > Bereavement Leave</option>
                        </select>
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
            	<h4 class="modal-title"><b>Deleting...</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="/position/destroy">
            		<input type="hidden" id="del_posid" name="id">
            		<div class="text-center">
	                	<p>DELETE POSITION</p>
	                	<h2 id="del_position" class="bold"></h2>
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


     