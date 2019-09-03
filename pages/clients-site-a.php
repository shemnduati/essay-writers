<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Site A Clients
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-files-o"></i> Home</a></li>
            <li class="active">Clients</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          
          <div class="row">
            <div class="col-xs-12">
          <div class="box">
                <div class="box-header">
                  <h3 class="box-title">List of clients</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="table-responsive">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>First name</th>
                        <th>Last name</th>
                        <th>email</th>
                        <th>Country</th>
                        <th>Phone</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
$sql = "SELECT * FROM prime_signup WHERE site = 'A'";
$qry = mysqli_query($link,$sql) or die(mysqli_error($link));
while ($rs = mysqli_fetch_array($qry)) {
    $reg_id = $rs['reg_id'];
    $fname = $rs['fname'];
    $lname = $rs['lname'];
	$email = $rs['email'];
	$ccode = $rs['ccode'];
	$phone = $rs['phone'];
					?>
                    
                      <tr>
                        <td><?php echo $fname; ?></td>
                        <td><?php echo $lname; ?></td>
                        <td><?php echo $email; ?></td>
                        <td><?php echo $ccode; ?></td>
                        <td><?php echo $phone; ?></td>
                      </tr>
                      
                      <?php
}
					  ?>
                      
                    </tbody>
                    <tfoot>
                     <tr>
                        <th>First name</th>
                        <th>Last name</th>
                        <th>email</th>
                        <th>Country</th>
                        <th>Phone</th>
                      </tr>
                    </tfoot>
                  </table>
                  </div><!-- /.table-responsive -->
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
          

        </section><!-- /.content -->