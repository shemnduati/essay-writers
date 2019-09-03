<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Writers
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-files-o"></i> Home</a></li>
            <li class="active">Writers</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          
          <div class="row">
            <div class="col-xs-12">
          <div class="box">
                <div class="box-header">
                  <h3 class="box-title">List of writers</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                <div class="table-responsive">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Writer ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Academic level</th>
                        <th>Speciality</th>
                        <th>Test Score</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
$sql = "SELECT * FROM writers a, academic_level b where a.academic_level = b.act_level_id";
$qry = mysqli_query($link,$sql) or die(mysqli_error($link));
while ($rs = mysqli_fetch_array($qry)) {
    $writer_id = $rs['writer_id'];
    $title = $rs['title'];
	$fname = $rs['fname'];
    $lname = $rs['lname'];
	$email = $rs['email'];
	$address = $rs['address'];
	$postal_code = $rs['postal_code'];
	$city = $rs['city'];
	$country = $rs['country'];
	$phone = $rs['phone'];
	$speciality = $rs['speciality'];
	$status = $rs['status'];
	$academic_level = $rs['act_name'];
	
	if($speciality == 'essay_writer'){
		$sp = 'technical_writer';
	}else{
		$sp = 'essay_writer';
	}
	
	$qry_totalmarks = mysqli_query($link,"select sum(marks) as total_marks from test_questions where essay = 0 and speciality != '".$sp."'") or die(mysqli_error($link));
	$rs_totalmarks = mysqli_fetch_array($qry_totalmarks);
	$total_marks = $rs_totalmarks['total_marks'];
	
	
	$qry_marks = mysqli_query($link,"select sum(marks) as total_marks from writer_answers a, test_questions b where a.test_id = b.test_id and a.status = 1 and a.writer_id = '".$writer_id."'  and b.speciality != '".$sp."'") or die(mysqli_error($link));
	$rs_marks = mysqli_fetch_array($qry_marks);
	if($rs_marks['total_marks'] == NULL){
		$marks = 0;
	}else{
		$marks = $rs_marks['total_marks'];
	}
	
					
					?>
                    
                      <tr>
                        <td>WS16<?php echo str_pad($writer_id,4,0,STR_PAD_LEFT); ?></td>
                        <td><?php echo $title.". ".$fname." ".$lname; ?></td>
                        <td><?php echo $email; ?></td>
                        <td><?php echo $address."-".$postal_code." ".$city.", ".$country; ?></td>
                        <td><?php echo $phone; ?></td>
                        <td><?php echo $academic_level; ?></td>
                        <td><a href="?page=viewtitles&writer_id=<?php echo $writer_id; ?>" title="View titles" rel="tooltip"><?php echo $speciality; ?></a></td>
                        <td><a href="?page=viewscore&writer_id=<?php echo $writer_id; ?>" title="View titles" rel="tooltip"><?php echo number_format((float)($marks/$total_marks*100), 2, '.', ''); ?>%</a></td>
                        <td>
						<?php
                        if ($status == "A") {
                            ?>
                            <span class="label label-primary">Active</span>
                            <?php
                        } else if ($status == "S") {
                            ?>
                            <span class="label label-warning">Suspended</span>
                            <?php
                        } else if ($status == "B") {
                            ?>
                            <span class="label label-danger">Blocked</span>
                            <?php
                        } else if ($status == "P") {
                            ?>
                            <span class="label label-default">Pending</span>
                            <?php
                        } 
                        ?>
                        </td>
                        <td>
                        <select id="status<?php echo $writer_id; ?>" onchange="setStatus(<?php echo $writer_id; ?>)">
                        	<option></option>
                            <option value="A">Activate</option>
                            <option value="S">Suspend</option>
                            <option value="B">Block</option>
                        </select>
                        
                         <div class="modal fade" id="blockModal<?php echo $writer_id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                <form role="form" action="php/register-submit.php" method="post">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Are you certain you want to block <?php echo $fname." ".$lname; ?>?</h4>
                  </div>
                  <div class="modal-body">
                    
                    <input type="hidden" name="writer_id" value="<?php echo $writer_id; ?>" />
					
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" name="block_writer">Block</button>
                  </div>
                </form>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div> 
            
            
            <div class="modal fade" id="suspendModal<?php echo $writer_id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                <form role="form" action="php/register-submit.php" method="post">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Are you certain you want to suspend <?php echo $fname." ".$lname; ?>?</h4>
                  </div>
                  <div class="modal-body">
                    
                    <input type="hidden" name="writer_id" value="<?php echo $writer_id; ?>" />
					
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" name="suspend_writer">Suspend</button>
                  </div>
                </form>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div> 
            
            
            <div class="modal fade" id="activateModal<?php echo $writer_id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                <form role="form" action="php/register-submit.php" method="post">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Are you certain you want to activate <?php echo $fname." ".$lname; ?> login access?</h4>
                  </div>
                  <div class="modal-body">
                    
                    <input type="hidden" name="writer_id" value="<?php echo $writer_id; ?>" />
					
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="activate_writer">Activate</button>
                  </div>
                </form>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div> 
                        </td>
                      </tr>
                      
                      <?php
}
					  ?>
                      
                    </tbody>
                    <tfoot>
                     <tr>
                     	<th>Writer ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Academic level</th>
                        <th>Speciality</th>
                        <th>Test Score</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </tfoot>
                  </table>
                  </div><!-- /.table-responsive -->
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
          

        </section><!-- /.content -->
        
        
        <script type="application/javascript">
		
		function setStatus(writer_id){
			var status = $("#status"+writer_id).val();
			if(status == 'A'){
				$("#activateModal"+writer_id).modal();
			}else if(status == 'S'){
				$("#suspendModal"+writer_id).modal();
			}else if(status == 'B'){
				$("#blockModal"+writer_id).modal();
			}
			$("#status"+writer_id).val('');
		}
		</script>