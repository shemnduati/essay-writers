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
                  <h3 class="box-title">List of writers earnings</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  
                  
                  <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
                            
                                <thead>
                                
                                <?php
								 $sql_yr = "SELECT DISTINCT YEAR(`payment_period`) FROM writers_jobs where client_complete = 1 order by job_id DESC";
		$qry_yr = mysqli_query($link,$sql_yr);
                                    while($rs_yr = mysqli_fetch_array($qry_yr))
			{ 
			$year = $rs_yr['YEAR(`payment_period`)'];
			?>
             <tr>
				<th colspan="3">
                      <?php echo $year; ?>
                </th>
             </tr>
            <?php
                                    $sql = "SELECT DISTINCT MONTHNAME(`payment_period`) FROM writers_jobs where client_complete = 1 order by payment_period DESC";
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
			$sql2 = mysqli_query($link,"SELECT sum(b.admin_setamount) as total_amount, a.paid_status FROM writers_jobs a, prime_order b WHERE a.order_id = b.order_id AND MONTH(`payment_period`) = '$mnth_id' and YEAR(`payment_period`) = '$year' and a.client_complete = 1 order by job_id DESC");
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

                        
			            <td width="100">
                          <input id="lnk1<?php echo $date; ?>" type="button" value="[+] Expand" onClick="toggle_visibility('tbl1<?php echo $date; ?>','lnk1<?php echo $date; ?>');">
                        </td>
                        
			            <th onClick="toggle_visibility('tbl1<?php echo $date; ?>','lnk1<?php echo $date; ?>');"><?php echo $date; ?></th>
                        
                        <th width="150" onClick="toggle_visibility('tbl1<?php echo $date; ?>','lnk1<?php echo $date; ?>');"><div align="right">Total Payable <?php echo formatMoney($total_amount, true);	 ?></div></th>           
                    </tr>
                    
                    <tr>
                    	<td colspan="3">
                        	<table id="tbl1<?php echo $date; ?>" width="100%" border="0" cellpadding="4" cellspacing="0" class="table table-striped table-bordered">
                                <tr>
                                    <td>Writer</td>
                                    <td>Amount Payable</td>
                                    <td>Payment Status</td>
                                    <td>Action</td>
                                </tr>
                        
							<?php
                            $sql3 = mysqli_query($link,"SELECT a.writer_id, a.fname, a.lname, c.admin_setamount as amount_payable, b.paid_status FROM writers a, writers_jobs b, prime_order c WHERE  a.writer_id = b.writer_id AND b.order_id = c.order_id AND MONTH(`payment_period`) = '$mnth_id' and YEAR(`payment_period`) = '$year' and b.client_complete = 1 order by job_id DESC");
                        while($row3 = mysqli_fetch_array($sql3))
                        {
                            $amount_payable = $row3['amount_payable'];
                            $bonus = 0;
                            $penalty = 0;
                            $earnings = $amount_payable + $bonus + $penalty;
                            $paid_status = $row3['paid_status'];
							$writer_id = $row3['writer_id'];
							$writer = $row3['fname']." ".$row3['lname'];
                            ?>
                            
                            
        <style type="text/css">
    #tbl1N<?php echo $referrer_id; ?> {display:none;}
    #lnk1N<?php echo $referrer_id; ?> {border:none;background:none;}
    td {FONT-SIZE: 90%; MARGIN: 0px; COLOR: #000000;}
    td {FONT-FAMILY: verdana,helvetica,arial,sans-serif}
    a {TEXT-DECORATION: none;}
    </style>
    
                
                            
                                <tr>
                                    <td><?php echo $writer; ?></td>
                                    <td><?php echo formatMoney($amount_payable, true); ?></td>
                                    <td><?php echo $paid_status; ?></td>
                                    <td><a href="?page=earnings-writer&writer_id=<?php echo $writer_id; ?>">View Earnings</a></td>
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