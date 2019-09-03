<?php
if(isset($_GET["writer_id"])){
$writer_id = $_GET["writer_id"];
$query=mysqli_query($link,"SELECT * FROM writers WHERE writer_id='".$writer_id."'");
$data=mysqli_fetch_array($query);
$writer_name = $data['fname']." ".$data['lname'];

$qry_p = mysqli_query($link,"select * from payment_settings where writer_id = '".$writer_id."'");
$rs_p = mysqli_fetch_array($qry_p);
$mpesa_phone = $rs_p['mpesa_phone'];
$paypal_email = $rs_p['paypal_email'];
?>
<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Writers Earnings
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-files-o"></i> Home</a></li>
            <li class="active">Writers Earnings</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          
          <div class="row">
            <div class="col-xs-12">
          <div class="box">
                <div class="box-header">
                	<h3 class="box-title">
                		Writer:&nbsp;<?php echo $writer_name; ?>
                    </h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                 <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" style="width:30%">
                    <thead>
                    	<tr><th colspan="2">Payment Details</th></tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Mpesa Phone number:</td><td>&nbsp;<?php echo $mpesa_phone; ?></td>
                        </tr>
                        <tr>
                            <td>Paypal email:</td><td>&nbsp;<?php echo $paypal_email; ?></td>
                        </tr>
                    </tbody>
                  </table><br />
                  
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
                  <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
                            
                                <thead>
                                
                                <?php
								 $sql_yr = "SELECT DISTINCT YEAR(`payment_period`) FROM writers_jobs where client_complete = 1 and writer_id = '".$writer_id."' order by job_id DESC";
		$qry_yr = mysqli_query($link,$sql_yr);
                                    while($rs_yr = mysqli_fetch_array($qry_yr))
			{ 
			$year = $rs_yr['YEAR(`payment_period`)'];
			?>
             <tr>
				<th colspan="5">
                      <?php echo $year; ?>
                </th>
             </tr>
            <?php
                                    $sql = "SELECT DISTINCT MONTHNAME(`payment_period`) FROM writers_jobs where client_complete = 1 and writer_id = '".$writer_id."' order by payment_period DESC";
		$qry = mysqli_query($link,$sql);
                                    while($rs = mysqli_fetch_array($qry))
			{ 
			$date = $rs['MONTHNAME(`payment_period`)'];
			if($date=='January'){
				$mnth_id = 1;
			}
			else if($date=='February'){
				$mnth_id = 2;
			}
			else if($date=='March'){
				$mnth_id = 3;
			}
			else if($date=='April'){
				$mnth_id = 4;
			}
			else if($date=='May'){
				$mnth_id = 5;
			}
			else if($date=='June'){
				$mnth_id = 6;
			}
			else if($date=='July'){
				$mnth_id = 7;
			}
			else if($date=='August'){
				$mnth_id = 8;
			}
			else if($date=='September'){
				$mnth_id = 9;
			}
			else if($date=='October'){
				$mnth_id = 10;
			}
			else if($date=='November'){
				$mnth_id = 11;
			}
			else if($date=='December'){
				$mnth_id = 12;
			}
			$sql2 = mysqli_query($link,"SELECT sum(b.admin_setamount) as total_amount, a.paid_status FROM writers_jobs a, prime_order b WHERE a.order_id = b.order_id AND MONTH(`payment_period`) = '$mnth_id' and YEAR(`payment_period`) = '$year' and a.client_complete = 1 and a.writer_id = '".$writer_id."' order by job_id DESC");
			$rs2 = mysqli_fetch_array($sql2);
				
			$total_amount = $rs2['total_amount'];
			
			$paid_status = $rs2['paid_status'];
				                             
                                        ?>
                                        
  <style type="text/css">
#tbl1<?php echo $date; ?> {display:none;}
#lnk1<?php echo $date; ?> {border:none;background:none;}
td {FONT-SIZE: 90%; MARGIN: 0px; COLOR: #000000;}
td {FONT-FAMILY: verdana,helvetica,arial,sans-serif}
a {TEXT-DECORATION: none;}
</style>

<style type="text/css">
<!--
.style1 {font-weight:bold}
-->
  </style>
                     <tr>

                        
			            <td width="100" style="vertical-align:bottom">
                          <input id="lnk1<?php echo $date; ?>" type="button" value="[+] Expand" onClick="toggle_visibility('tbl1<?php echo $date; ?>','lnk1<?php echo $date; ?>');">
                        </td>
                        
			            <th onClick="toggle_visibility('tbl1<?php echo $date; ?>','lnk1<?php echo $date; ?>');"><?php echo $date; ?></th>
                        
                        <th width="150"><?php echo $paid_status; ?></th> 
                        
                        <th width="150" onClick="toggle_visibility('tbl1<?php echo $date; ?>','lnk1<?php echo $date; ?>');"><div align="right">Total Payable <?php echo formatMoney($total_amount, true);	 ?></div></th>    
                        <th width="150" style="text-align:center">
                        <?php
						if($paid_status == 'paid'){
						?>
                        <a href="#" class="btn btn-default">Paid</a>
                        <?php
						}else{
							$qry_threshold = mysqli_query($link,"select * from writers_threshold where amount <= '".$total_amount."'");
							$qry_threshold2 = mysqli_query($link,"select * from writers_threshold");
							$rs_threshold = mysqli_fetch_array($qry_threshold2);
							$count_threshold = mysqli_num_rows($qry_threshold);
							if($count_threshold > 0){
								?>
								<a data-toggle="modal" href="#payModal<?php echo $date; ?>" class="btn btn-primary">Pay</a>
								<?php
							}else{
								?>
                                <a data-toggle="modal" href="#moveModal<?php echo $date; ?>" class="btn btn-default">Below Threshold of (<?php echo formatMoney($rs_threshold['amount'], true); ?>), Move to next month</a>
                                <?php
							}
						}
						?>
                        </th>       
                    </tr>
                    <div class="modal fade" id="moveModal<?php echo $date; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                        <form role="form" action="php/register-submit.php" method="post">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title">Are you sure you want to move payment of earnings to next month?</i></h4>
                          </div>
                          <div class="modal-body">
                            
        
                          </div>
                          <div class="modal-footer">
                          	<input type="hidden" name="writer_id" value="<?php echo $writer_id; ?>" />
                            <input type="hidden" name="year" value="<?php echo $year; ?>" />
                            <input type="hidden" name="mnth_id" value="<?php echo $mnth_id; ?>" />
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="register_movement">Yes, Move</button>
                          </div>
                        </form>
                        </div><!-- /.modal-content -->
                      </div><!-- /.modal-dialog -->
                    </div>
                    
                    <div class="modal fade" id="payModal<?php echo $date; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                        <form role="form" action="php/register-submit.php" method="post">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title">Payment <i>(Only Mpesa available for now)</i></h4>
                          </div>
                          <div class="modal-body">
                            
                            
                            
                            
                          <div class="box-body">
                            <div class="form-group">
                              <label for="fname">Amount to pay</label>
                              <input class="form-control" type="text" value="kes <?php echo formatMoney($total_amount, true); ?>" disabled="disabled">
                            </div>
                            <div class="form-group">
                              <label for="fname">Writer Mpesa Phone Number</label>
                              <input class="form-control" type="text" value="<?php echo $mpesa_phone; ?>" disabled="disabled">
                            </div>
                            <div class="form-group">
                              <label for="sname">Transaction Number</label>
                              <input class="form-control" name="transaction_no" type="text">
                            </div>
                            
                          </div><!-- /.box-body -->
        
                        </div>
                          <div class="modal-footer">
                          	<input type="hidden" name="writer_id" value="<?php echo $writer_id; ?>" />
                            <input type="hidden" name="year" value="<?php echo $year; ?>" />
                            <input type="hidden" name="mnth_id" value="<?php echo $mnth_id; ?>" />
                            <input type="hidden" name="paid_account" value="<?php echo $mpesa_phone; ?>" />
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="register_payment">Save</button>
                          </div>
                        </form>
                        </div><!-- /.modal-content -->
                      </div><!-- /.modal-dialog -->
                    </div>
                    <tr>
                    	<td colspan="5">
                        	<table id="tbl1<?php echo $date; ?>" width="100%" border="0" cellpadding="4" cellspacing="0" class="table table-striped table-bordered">
                                <tr>
                                    <td>Completion Date</td>
                                    <td>Order ID</td>
                                    <td>Topic</td>
                                    <td>Amount Payable</td>
                                    <td>Bonus</td>
                                    <td>Penalty</td>
                                    <td>Earnings</td>
                                    <td>Payment Status</td>
                                </tr>
                        
							<?php
                            $sql3 = mysqli_query($link,"SELECT a.job_id, c.fname, c.lname, b.admin_setamount as amount_payable, a.payment_period, b.order_id, b.title_topic, a.paid_status FROM writers_jobs a, prime_order b, writers c WHERE a.order_id = b.order_id AND a.writer_id = c.writer_id AND MONTH(`payment_period`) = '$mnth_id' and YEAR(`payment_period`) = '$year' and a.client_complete = 1 and a.writer_id = '".$writer_id."' order by job_id DESC");
                        while($row3 = mysqli_fetch_array($sql3))
                        {
							$job_id = $row3['job_id'];
                            $payment_period = $row3['payment_period'];
                            $order_id = $row3['order_id'];
                            $topic = $row3['title_topic'];
                            $amount_payable = $row3['amount_payable'];
                            $bonus = 0;
                            $penalty = 0;
                            $earnings = $amount_payable + $bonus + $penalty;
                            $paid_status = $row3['paid_status'];
                            ?>
                            
                            
        <style type="text/css">
    #tbl1N<?php echo $referrer_id; ?> {display:none;}
    #lnk1N<?php echo $referrer_id; ?> {border:none;background:none;}
    td {FONT-SIZE: 90%; MARGIN: 0px; COLOR: #000000;}
    td {FONT-FAMILY: verdana,helvetica,arial,sans-serif}
    a {TEXT-DECORATION: none;}
    </style>
    
                
                            
                                <tr>
                                    <td><?php echo $payment_period; ?></td>
                                    <td><?php echo $order_id; ?></td>
                                    <td><?php echo $topic; ?></td>
                                    <td><?php echo formatMoney($amount_payable, true); ?></td>
                                    <td><?php echo formatMoney($bonus, true); ?></td>
                                    <td><?php echo formatMoney($penalty, true); ?></td>
                                    <td><?php echo formatMoney($earnings, true); ?></td>
                                    <td><?php echo $paid_status; ?></td>
                                </tr>
                                
                            <?php
                        }
                            ?>
                            </table>
                        </td>
                    </tr>
                                    
                                    <?php
			}
			}
									?>
                                </thead>
                                                           </table>
                  
                  
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
          

        </section><!-- /.content -->
        
<script type="text/javascript">
function toggle_visibility(tbid,lnkid)
{
	
  if(document.all){document.getElementById(tbid).style.display = document.getElementById(tbid).style.display == "block" ? "none" : "block";
  }
  else{document.getElementById(tbid).style.display = document.getElementById(tbid).style.display == "table" ? "none" : "table";
  
  }
  document.getElementById(lnkid).value = document.getElementById(lnkid).value == "[-] Collapse" ? "[+] Expand" : "[-] Collapse";
}
</script>
<?php
}else{
	echo "Invalid request";	
}
?>