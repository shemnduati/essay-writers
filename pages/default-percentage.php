<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Order Default Percentages
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-files-o"></i> Home</a></li>
            <li class="active">Order Default Percentages</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <?php
if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
echo '
<div style="margin:0 auto;" class="alert alert-success fade in" align="center">';
foreach($_SESSION['ERRMSG_ARR'] as $msg) {
echo '&nbsp;',$msg;
}
echo '</div><br/>';
unset($_SESSION['ERRMSG_ARR']);
}
else if( isset($_SESSION['ERRMSG_ARR2']) && is_array($_SESSION['ERRMSG_ARR2']) && count($_SESSION['ERRMSG_ARR2']) >0 ) {
echo '
<div style="margin:0 auto;" class="alert alert-danger fade in" align="center"><i class="icon-remove-sign"></i>';
foreach($_SESSION['ERRMSG_ARR2'] as $msg) {
echo '&nbsp;',$msg;
}
echo '</div><br/>';
unset($_SESSION['ERRMSG_ARR2']);
}
?>
          <div class="row">
            <div class="col-xs-12">
          <div class="box">
               <div class="box-body">
                
                <div class="row">
            		<div class="col-xs-12">
                    <div class="table-responsive">
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
                        	<thead>
                                <tr>
                                	<th>Action</th>
                                	<th>Item</th>
                                    <th>Percentage</th>
                                    <th>Description</th>
                                    <th>Updated by</th>
                                    <th>Updated on</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
							$sql = "SELECT * FROM default_percentages a, admin_login b WHERE a.updated_by = b.id";
							$qry = mysqli_query($link,$sql) or die(mysqli_error($link));
							while ($rs = mysqli_fetch_array($qry)) {
								$item_id = $rs['item_id'];
								$item = $rs['item'];
								$description = $rs['description'];
								$percentage = $rs['percentage'];
								$updated_by = $rs['fname']." ".$rs['sname'];
								$updated_on = $rs['updated_on'];
								
								?>
                                <tr>
                                	<td><a data-toggle="modal" href="#editModal<?php echo $item_id; ?>">edit</a></td>
                                    <td><?php echo $item; ?></td>
                                    <td><?php echo $percentage." %"; ?></td>
                                    <td><?php echo $description; ?></td>
                                    <td><?php echo $updated_by; ?></td>
                                    <td><?php echo $updated_on; ?></td>
                                </tr>
                                
                                <div class="modal fade" id="editModal<?php echo $item_id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                    <form role="form" action="php/register-submit.php" method="post">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        <h4 class="modal-title"><?php echo $item; ?></h4>
                                      </div>
                                      <div class="modal-body">
                                        
                                        <div class="box-body">
                                            <div class="form-group">
                                              <label>Percentage</label>
                                              <input class="form-control" name="percentage" type="number" value="<?php echo $percentage; ?>" style="width:40%" />
                                            </div>
                                            <div class="form-group">
                                              <label>Description</label>
                                              <textarea class="form-control" name="description"><?php echo $description; ?></textarea>
                                            </div>
                                          </div><!-- /.box-body -->
                                        
                                      </div>
                                      <div class="modal-footer">
                                      	<input type="hidden" name="item_id" value="<?php echo $item_id ?>" />
                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" name="update_percentage">Update</button>
                                      </div>
                                    </form>
                                    </div><!-- /.modal-content -->
                                  </div><!-- /.modal-dialog -->
                                </div> 
                                <?php
}
								?>
                            </tbody>
                          </table>
                          </div><!-- /.table-responsive -->
                      </div>
                </div>
                 
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
          

        </section><!-- /.content -->