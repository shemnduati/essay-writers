<?php
if(isset($_GET["order_id"])){
$order_id = $_GET["order_id"];

$qry_a = mysqli_query($link,"SELECT * FROM writers_bids where order_id = '".$order_id."' and status = 1");
$count_a = mysqli_num_rows($qry_a);
?>
<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Order's Bids
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-files-o"></i> Home</a></li>
            <li class="active">Order's Bids</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          
          <div class="row">
            <div class="col-xs-12">
          <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Order Details</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Order ID</th>
                        <th>Client</th>
                        <th>Date</th>
                        <th>Title topic</th>
                        <th>Original timeframe</th>
                        <th>Admin timeframe</th>
                        <th>Writer academic level</th>
                        <th>Spacing</th>
                        <th>Paper format</th>
                        <th>Client amount</th>
                        <th>Admin amount</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
			$sql = "SELECT * FROM prime_order a, academic_level b where a.writer_level = b.act_level_id and a.order_id = '".$order_id."'";
			$qry = mysqli_query($link,$sql) or die(mysqli_error($link));
			if ($rs = mysqli_fetch_array($qry)) {
				$client_name = $rs['fname']." ".$rs['lname'];
				$title_topic = $rs['title_topic'];
				$date = $rs['date'];
				$total_amount = $rs['total_amount'];
				
				$timeframe = $rs['timeframe'];
				$admin_timeframe = $rs['admin_timeframe']/3600;
				$writer_level = $rs['act_name'];
				
				$spacing = $rs['spacing'];
				$style = $rs['style'];
				$admin_setamount = $rs['admin_setamount'];
				      ?>
                      <tr>
                        <td><?php echo $order_id; ?></td>
                        <td><?php echo $client_name; ?></td>
                        <td><?php echo $date; ?></td>
                        <td><?php echo $title_topic; ?></td>
                        <td><?php echo $timeframe; ?></td>
                        <td><?php echo $admin_timeframe; ?> hour(s)</td>
                        <td><?php echo $writer_level; ?></td>
                        <td><?php echo $spacing; ?></td>
                        <td><?php echo $style; ?></td>
                        <td><?php echo formatMoney($total_amount, true); ?></td>
                        <td><?php echo formatMoney($admin_setamount, true); ?></td>
                      </tr>
                      <?php
}
					  ?>
                      
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
          <?php
if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
echo '
<div style="margin:0 auto;" class="alert alert-success fade in" align="center">';
foreach($_SESSION['ERRMSG_ARR'] as $msg) {
echo '&nbsp;',$msg;
}
echo '</div>';
unset($_SESSION['ERRMSG_ARR']);
}
else if( isset($_SESSION['ERRMSG_ARR2']) && is_array($_SESSION['ERRMSG_ARR2']) && count($_SESSION['ERRMSG_ARR2']) >0 ) {
echo '
<div style="margin:0 auto;" class="alert alert-danger fade in" align="center"><i class="icon-remove-sign"></i>';
foreach($_SESSION['ERRMSG_ARR2'] as $msg) {
echo '&nbsp;',$msg;
}
echo '</div>';
unset($_SESSION['ERRMSG_ARR2']);
}
?>
          <div class="row">
            <div class="col-xs-12">
          <div class="box">
                <div class="box-header">
                  <h3 class="box-title">List of bidders</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                      	<th>Bidding Amount</th>
                        <th>Time to Complete</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Academic level</th>
                        <th>Speciality</th>
                        <th>Test Score</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
					if($count_a > 0){
						$sql = "SELECT * FROM writers_bids a, writers b, academic_level c where a.writer_id = b.writer_id and b.academic_level = c.act_level_id and a.order_id = '".$order_id."' and a.status = 1";
					}else{
						$sql = "SELECT * FROM writers_bids a, writers b, academic_level c where a.writer_id = b.writer_id and b.academic_level = c.act_level_id and a.order_id = '".$order_id."'";
					}
$qry = mysqli_query($link,$sql) or die(mysqli_error($link));
					
while ($rs = mysqli_fetch_array($qry)) {
    $bid_id = $rs['bid_id'];
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
	$bidding_amount = $rs['amount'];
	$timeframe = $rs['timeframe']/3600;
	
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
                      	<td><?php echo formatMoney($bidding_amount, true); ?></td>
                        <td><?php echo $timeframe; ?> hour(s)</td>
                        <td><?php echo $title.". ".$fname." ".$lname; ?></td>
                        <td><?php echo $email; ?></td>
                        <td><?php echo $address."-".$postal_code." ".$city.", ".$country; ?></td>
                        <td><?php echo $phone; ?></td>
                        <td><?php echo $academic_level; ?></td>
                        <td><a href="?page=viewtitles&writer_id=<?php echo $writer_id; ?>" title="View titles" rel="tooltip"><?php echo $speciality; ?></a></td>
                        <td><a href="?page=viewscore&writer_id=<?php echo $writer_id; ?>" title="View titles" rel="tooltip"><?php echo number_format((float)($marks/$total_marks*100), 2, '.', ''); ?>%</a></td>
                        <td>
                        <?php
						if($count_a > 0){
						?>
                        <a href="#" class="btn btn-default">Awarded</a>
                        <?php
						}else{
						?>
                        <a data-toggle="modal" href="#awardModal<?php echo $writer_id; ?>" class="btn btn-primary">Award order</a>
                        <?php
						}
						?>
                        </td>
                      </tr>
                      
                      <div class="modal fade" id="awardModal<?php echo $writer_id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                        <form role="form" action="php/register-submit.php" method="post">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title">Are you sure you want to award this writer this order?</h4>
                          </div>
                          
                          <div class="modal-footer">
                          	<input type="hidden" name="writer_id" value="<?php echo $writer_id; ?>" />
                            <input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />
                            <input type="hidden" name="bid_id" value="<?php echo $bid_id; ?>" />
                          	<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="register_award">Yes</button>
                          </div>
                          
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
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
          

        </section><!-- /.content -->
 <?php
}else{
	echo "Invalid request";	
}
 ?>