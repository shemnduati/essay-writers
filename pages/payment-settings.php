<?php
	$row = mysqli_fetch_array(mysqli_query($link,"select * from prime_paypalset"));
	$paypalemail = $row["paypal_email"];
?>

<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Update Paypal Email
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-files-o"></i> Home</a></li>
            <li class="active">Paypal Email</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          
          <div class="row">
            <div class="col-xs-12">
          <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Update Paypal Email</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                
                
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
                      <label for="exampleInputEmail1">Paypal email</label>
                      <input class="form-control" placeholder="Enter email" name="paypalemail" type="email" value="<?php echo $paypalemail; ?>">
                    </div>
                   
                   <div class="box-footer">
                    <button type="submit" class="btn btn-primary" name="update_paypal_email">Update</button>
                  </div>
                </form>
                 
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
          

        </section><!-- /.content -->