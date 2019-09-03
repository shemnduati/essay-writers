<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Manage Users
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-files-o"></i> Home</a></li>
            <li class="active">Manage Users</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          
          <div class="row">
            <div class="col-xs-12">
            <a data-toggle="modal" href="#userModal" class="btn btn-primary">Add a user</a>
            
            <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                <form role="form" action="php/register-submit.php" method="post">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Add a user</h4>
                  </div>
                  <div class="modal-body">
                    
                    
                    
                    
                  <div class="box-body">
                  	<div class="form-group">
                      <label for="fname">First Name</label>
                      <input class="form-control" id="fname" name="fname" placeholder="Enter first name" type="text">
                    </div>
                    <div class="form-group">
                      <label for="sname">Second Name</label>
                      <input class="form-control" id="sname" name="sname" placeholder="Enter email" type="text">
                    </div>
                    <div class="form-group">
                      <label for="username">Username</label>
                      <input class="form-control" id="username" name="username" placeholder="Enter email" type="text">
                    </div>
                    <div class="form-group">
                      <label for="email">Email address</label>
                      <input class="form-control" id="email" name="email" placeholder="Enter email" type="email">
                    </div>
                    <div class="form-group">
                      <label for="password">Password</label>
                      <input class="form-control" id="password" name="password" placeholder="Password" type="password">
                    </div>
                    <div class="form-group">
                      <label for="cpassword">Confirm Password</label>
                      <input class="form-control" id="cpassword" placeholder="Confirm Password" type="password">
                    </div>
                    
                  </div><!-- /.box-body -->

                </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="register_user">Save</button>
                  </div>
                </form>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div>
                 
        
          <div class="box">
                <div class="box-header">
                  <h3 class="box-title">List of users</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="table-responsive">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Date registered</th>
                        <th>Status</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      
                      <?php
$sql = "SELECT * FROM admin_login where id != '".$session_id."'";
$qry = mysqli_query($link,$sql);
while ($rs = mysqli_fetch_array($qry)) {
    $admin_id = $rs['id'];
	$fname = $rs['fname'];
    $sname = $rs['sname'];
	$email = $rs['email'];
	$status = $rs['status'];
	$regDate = $rs['regDate'];

?>
                            <tr class="odd gradeX">



                              
                                <td>

                                    <a rel="tooltip" title="User overview" href="index.php?page=user-details&user_id=<?php echo $admin_id; ?>"><?php echo $fname . " " . $sname; ?></a>

                                </td>

                               
                                <td>

                                    <?php echo $email; ?>

                                </td>
                                
                                <td>

                                    <?php echo $regDate; ?>

                                </td>
                                
                                <td>

    <?php
    if ($status == "A") {
        ?>
                                        <span class="label label-primary">Active</span>
        <?php
    } else if ($status == "P") {
        ?>
                                        <span class="label label-default">Pending</span>
                                        <?php
                                    } else if ($status == "S") {
                                        ?>
                                        <span class="label label-warning">Suspended</span>
                                        <?php
                                    } else if ($status == "B") {
                                        ?>
                                        <span class="label label-danger">Blocked</span>
                                        <?php
                                    } else if ($status == "I") {
                                        ?>
                                        <span class="label label-default">Profile incomplete</span>
                                        <?php
                                    }
                                    ?>

                                </td>


                                <td>
                    <?php
					if($status == 'A' || $status == 'I'){
				?><a data-toggle="modal" href="#denyModal<?php echo $admin_id; ?>">
                <span class="label label-warning">Deny login</span>
                </a>
                
                <?php	
				}
				else if($status == 'B'){
				?><a data-toggle="modal" href="#allowModal<?php echo $admin_id; ?>">
                <span class="label label-success">Allow login</span>
                </a>
                <?php	
				}
				else{
				?><a href="#ajax/user-allow.php?user_id=<?php echo $admin_id ?>">
                <span class="label label-success">Allow login</span>
                </a>
                <?php	
				}
					?>   
                   
             <div class="modal fade" id="denyModal<?php echo $admin_id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                <form role="form" action="php/register-submit.php" method="post">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Are you certain you want to deny <?php echo $fname." ".$sname; ?> login access?</h4>
                  </div>
                  <div class="modal-body">
                    
                    <input type="hidden" name="admin_id" value="<?php echo $admin_id; ?>" />
					
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" name="deny_login">Deny</button>
                  </div>
                </form>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div> 
            
            
            <div class="modal fade" id="allowModal<?php echo $admin_id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                <form role="form" action="php/register-submit.php" method="post">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Are you certain you want to allow <?php echo $fname." ".$sname; ?> login access?</h4>
                  </div>
                  <div class="modal-body">
                    
                    <input type="hidden" name="admin_id" value="<?php echo $admin_id; ?>" />
					
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="allow_login">Allow</button>
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
                        <th>Name</th>
                        <th>Email</th>
                        <th>Date registered</th>
                        <th>Status</th>
                        <th></th>
                      </tr>
                    </tfoot>
                  </table>
                  </div><!-- /.table-responsive -->
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
          

        </section><!-- /.content -->