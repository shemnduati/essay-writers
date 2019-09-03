<?php
	$row = mysqli_fetch_array(mysqli_query($link,"select * from writers_threshold a, admin_login b where a.updated_by = b.id"));
	$threshold_amount = $row["amount"];
	$updated_by = $row["fname"]." ".$row["sname"];
	$updated_on = $row["updated_on"];
?>

<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Writers Payment Threshold
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-files-o"></i> Home</a></li>
            <li class="active">Payment Payment Threshold</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          
          <div class="row">
            <div class="col-xs-12">
          <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Update Payment Threshold</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                
                <div class="row">
            		<div class="col-xs-6">
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
                            <thead>
                                <tr><th colspan="2">Threshold Details</th></tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Threshold Amount:</td><td>&nbsp;<?php echo formatMoney($threshold_amount, true); ?></td>
                                </tr>
                                <tr>
                                    <td>Update by:</td><td>&nbsp;<?php echo $updated_by;  ?></td>
                                </tr>
                                <tr>
                                    <td>Update on:</td><td>&nbsp;<?php echo $updated_on;  ?></td>
                                </tr>
                            </tbody>
                          </table>
                      </div>
                      <div class="col-xs-6">
                		<?php
						if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
						echo '
						<div style="margin:0 auto;" class="alert alert-success fade in" align="center">';
						foreach($_SESSION['ERRMSG_ARR'] as $msg) {
						echo '&nbsp;',$msg;
						}
						echo '</div><br>';
						unset($_SESSION['ERRMSG_ARR']);
						}
						else if( isset($_SESSION['ERRMSG_ARR2']) && is_array($_SESSION['ERRMSG_ARR2']) && count($_SESSION['ERRMSG_ARR2']) >0 ) {
						echo '
						<div style="margin:0 auto;" class="alert alert-danger fade in" align="center"><i class="icon-remove-sign"></i>';
						foreach($_SESSION['ERRMSG_ARR2'] as $msg) {
						echo '&nbsp;',$msg;
						}
						echo '</div><br>';
						unset($_SESSION['ERRMSG_ARR2']);
						}
						?>
						
                         <form role="form" method="post" action="php/register-submit.php">
                            <div class="form-group">
                              <label for="exampleInputEmail1">Threshold Amount</label>
                              <input class="form-control" name="threshold_amount" type="text" value="<?php echo $threshold_amount; ?>" required>
                            </div>
                           
                           <div class="box-footer">
                            <button type="submit" class="btn btn-primary" name="update_threshold">Update</button>
                          </div>
                        </form>
                	</div>
                </div>
                 
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
          

        </section><!-- /.content -->