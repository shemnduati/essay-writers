<?php
if(isset($_GET["orderid"])){
$orderid = $_GET["orderid"];
$query=mysqli_query($link,"SELECT * FROM prime_order WHERE order_id='".$orderid."'");
$data_order=mysqli_fetch_array($query);

$order_status = $data_order['order_status'];
$client_complete = $data_order['complete'];

if($order_status == 0){
	$order_state = '<span class="label label-default">Available</span>';
}else if($order_status == 1){
	$order_state = '<span class="label label-primary">Current</span>';
}

$sql_job = "SELECT * FROM writers_jobs a, prime_order b WHERE a.order_id = b.order_id and b.order_id  = '".$orderid."' and a.job_status = 'done'";
$qry_job = mysqli_query($link,$sql_job) or die(mysqli_error($link));
$count_order = mysqli_num_rows($qry_job);
if($count_order > 0){
	$rs_state = mysqli_fetch_array($qry_job);
	$revise = $rs_state['revise'];
	if($revise > 0){
		$order_state = '<span class="label label-warning">On Revision</span>';
	}else{
		$order_state = '<span class="label label-primary">Done</span>';
	}
}

if($client_complete == 1){
	$order_state = '<span class="label label-success">Completed</span>';
}

$sql_writer = "SELECT * FROM writers_jobs a, writers b WHERE a.writer_id = b.writer_id and a.order_id  = '".$orderid."' and a.job_status != 'canceled' and a.award_type != 'Assigned'";
$qry_writer = mysqli_query($link,$sql_writer) or die(mysqli_error($link));
$count_writer = mysqli_num_rows($qry_writer);

$paper_title = $data_order['paper_title'];
$res12 = mysqli_query($link,"SELECT * FROM subject where sub_id = '".$paper_title."' order by sub_name") or die(mysqli_query($link));
					if($row12 = mysqli_fetch_array($res12))
					{	
						$pt = $row12["sub_name"];
					}	
		
?>
<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            YOU ARE VIEWING ORDER: <?php echo $data_order['order_id']; ?> TITLED: <?php echo $data_order['title_topic'];?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-files-o"></i> Home</a></li>
            <li class="active">View Order</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          
          <div class="row">
            <div class="col-xs-6">
          <div class="box">
                <div class="box-header">
                  <h3 class="box-title">View Order</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                
                 <div class="table-responsive">
                 <table cellspacing="0" cellpadding="10px" class="table table-striped">
                 	<tr>
            			<th width="30%" valign="middle"> Order status&nbsp;</th>
            			<td valign="middle"><?php echo $order_state; ?></td>
            			</tr>
            		<tr>
            			<th width="30%" valign="middle"> Client Name&nbsp;</th>
            			<td valign="middle"><?php echo $data_order['fname']." ".$data_order['lname']; ?></td>
            			</tr>
            		<tr>
            			<th  valign="middle"> Client E-Mail </th>
            			
            			<td valign="middle"><?php echo $data_order['email']; ?></td>
            			</tr>
            		<tr>
            			<th  valign="middle"> Client Contact phone </th>
            			
            			<td valign="middle"><?php echo $data_order['phone']; ?></td>
            			</tr>
                    <?php
					$assigned = $data_order['assigned'];
					if($count_writer > 0){
						$rs_writer = mysqli_fetch_array($qry_writer);
						$writer_id = $rs_writer['writer_id'];
						echo '<tr>';
            			echo '<th width="30%" valign="middle"> Writer Name&nbsp;</th>';
            			echo '<td valign="middle" id="assign_td">'.$rs_writer['fname'].' '.$rs_writer['lname'].'</td>';
            			echo '</tr>';
					}else{
						echo '<tr>';
            			echo '<th width="30%" valign="middle"> Writer&nbsp;</th>';
						if($assigned > 0){
								$sql_assignee = "SELECT b.fname, b.lname, a.status FROM writers_assigned a, writers b WHERE a.writer_id = b.writer_id and a.order_id  = '".$orderid."' and a.status != 'canceled'";
								$qry_assignee = mysqli_query($link,$sql_assignee) or die(mysqli_error($link));
								$rs_assignee = mysqli_fetch_array($qry_assignee);
								if($rs_assignee['status'] == 'pending_confirmation'){
									$assign_status = '<span class="center-block label label-warning">Pending Confirmation</span>';
								}else{
									$assign_status = '<span class="center-block label label-primary">Confirmed</span>';
								}
            				echo '<td valign="middle" id="assign_td"><table><tr><td>Assigned to ['.$rs_assignee['fname'].' '.$rs_assignee['lname'].']</td><td>&nbsp;</td><td> '.$assign_status.'</td></tr></table></td>';
						}else{
							echo '<td valign="middle" id="assign_td"><a data-toggle="modal" href="#assignModal">Assign a writer</a></td>';
						}
            			echo '</tr>';
					}
					?>
            		<tr>
            			<th  valign="middle"> Order ID </th>
            			
            			<td valign="middle"><?php echo $data_order['order_id']; ?></td>
            			</tr>
            		<tr>
            			<th valign="middle"> Order Date </th>
            			
            			<td valign="middle"><?php echo $data_order['date']; ?></td>
            			</tr>
            		
            		<tr>
            			<th   valign="middle"> Pages </th>
            			
            			<td valign="middle"><?php echo $data_order['quantity'];?> Page(s)</td>
            			</tr>
            		
            		<tr>
            			<th   valign="middle"> Client Total Amount </th>
            			
            			<td valign="middle"><?php echo $data_order['total_amount']." ".$data_order['currency'];?></td>
            			</tr>
            		<tr>
            			<th   valign="middle"> Original Timeframe </th>
            			
            			<td valign="middle"><?php echo str_replace("_"," ",$data_order['timeframe']);?></td>
            			</tr>
						<tr>
            			<th   valign="middle"> Title </th>
            			
            			<td valign="middle">
							
							<?php echo $data_order['title_topic'];?></td>
            			</tr>
            		<tr>
            			<th   valign="middle"> Subject </th>
            			
            			<td valign="middle">
							
							<?php echo $pt;?></td>
            			</tr>
            		<tr>
            			<th   valign="middle"> Spacing </th>
            			
            			<td valign="middle"><?php echo $data_order['spacing']." Spaced";?></td>
            			</tr>
            		<tr>
            			<th   valign="middle"> Style </th>
            			
            			<td valign="middle"><?php echo $data_order['style'];?></td>
            			</tr>
            		
            		<tr>
            			<th   valign="middle"> References </th>
            			
            			<td valign="middle"><?php echo $data_order['refer'];?></td>
            			</tr>
            		<tr>
            			<th   valign="middle"> Paper Instruction </th>
            			
            			<td valign="middle">
							
						<?php echo $data_order['paper_instruction'];?></td>
            			</tr>
            		<tr>
            			<th   valign="middle"> Writer academic Level </th>
            			
            			<td valign="middle">
							<?php
							$reswl = mysqli_query($link,"SELECT * FROM academic_level where act_level_id = ".$data_order['writer_level']);
							if($rowwl = mysqli_fetch_array($reswl))
							{
								$wl = $rowwl["act_name"];
							}
							?>	
								<?php echo $wl;?></td>
            			</tr>
						<tr>
            			<th   valign="middle"> Type of paper needed </th>
            			
            			<td valign="middle">
							<?php
							$reswl = mysqli_query($link,"SELECT * FROM paper_need where pn_id = ".$data_order['assignment']);

							if($rowwl = mysqli_fetch_array($reswl))
							{
								$assignment = $rowwl["pn_name"];
							}
							?>	
						<?php echo $assignment;?></td>
            			</tr>
						<tr>
            			<th   valign="middle"> Topic </th>
            			
            			<td valign="middle"><?php echo $data_order['title_topic'];?></td>
            			</tr>
						<tr>
            			<th   valign="middle"> Category of writer </th>
            			
            			<td valign="middle">
							<?php
							$reswl = mysqli_query($link,"SELECT * FROM writer_category where wc_id = ".$data_order['pref_writerid']);
							if($rowwl = mysqli_fetch_array($reswl))
							{
								$wrcat = $rowwl["wc_title"];
							}
							?>	
						<?php echo $wrcat;?></td>
            			</tr>
						<tr>
            			<th   valign="middle"> Power Point slides </th>
            			
            			<td valign="middle"><?php echo $data_order['slides'];?></td>
            			</tr>
            					<tr>
            			
            			<td valign="middle">		
            					
            		<?php
            		//class for uploading files starts here
// set the maximum upload size in bytes
$max = 25000000;
$order_id=$orderid;
 $destination = 'order.instructions/';
  require_once('Upload.php');
  $upload = new Upload($destination);
 

            			
            			//the function for uploading files to the right direcotry
            			if (isset($_POST['upload'])) {
  // define the path to the upload folder
 
  try {
	
	$upload->setMaxSize($max);
	$upload->move($order_id);
	$result = $upload->getMessages();
  } catch (Exception $e) {
	echo $e->getMessage();
  }
}  
            			
            			
            			
            			
            			
            			
            			
            			  ?>
            			  <?php
if (isset($result)) {
  echo '<ul>';
  foreach ($result as $message) {
	echo "<li>$message</li>";
  }
  echo '</ul>';
}
?>
 
            			   </td>
            			

  

            			</tr>
            			
            			<tr>		
            					
            			<th   valign="middle"> Uploaded Files</th>
            			
            			<td valign="middle"><?php $upload->download_links($order_id); ?></td>
            			</tr>
            		</table>
                    
                 	</div><!-- /.table-responsive -->
                 
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
            
            
            
            <div class="col-xs-6">
            
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
<div id="notification"></div>

          <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Order Settings</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                
                
                 <div class="table-responsive">
                 <table class="table table-striped">
                 	<tr>
            			<th valign="middle"> Admin set timeframe</th>
            			<td valign="middle">
                        <?php
						if($data_order['admin_timeframe'] > 0){
							echo ($data_order['admin_timeframe']/3600)." hours";
						}else{
							echo '<a data-toggle="modal" href="#setTimeframeModal">SET </a>';
						}
						?>
                        </td>
                        <td style="text-align:right">
                        <?php
						if($data_order['admin_timeframe'] > 0){
                        	echo '<a data-toggle="modal" href="#adjustTimeframeModal">adjust </a>';
						}
						?>
						</td>
            		</tr>
                    <?php
					$qry_adjusted = mysqli_query($link,"select * from adjusted_timeframe a, admin_login b where a.adjusted_by = b.id and a.order_id = '".$order_id."'");
					$count_adjusted = mysqli_num_rows($qry_adjusted);
					if($count_adjusted > 0){
					?>
                    <tr>
            			<th  valign="middle">Adjusted timeframe</th>
            			<td>
                        <table class="table table-striped">
                        	<thead>
                            	<tr>
                                    <th>Time</th>
                                    <th>Reason</th>
                                    <th>Adjusted_on</th>
                                    <th>Adjusted_by</th>
                                	<th></th>
                                </tr>
                            </thead>
                            <tbody id="adjusted_response">
                        	<?php
								while($rs_adjusted = mysqli_fetch_array($qry_adjusted)){
									$adjusted_id = $rs_adjusted['adjusted_id'];
									$adjusted_on = $rs_adjusted['adjusted_on'];
									$reason = $rs_adjusted['reason'];
									$time_adjusted = ($rs_adjusted['adjusted_time']/3600)." hrs";
									echo '<tr id="item_'.$adjusted_id.'">';
									echo '<td>';
									echo $time_adjusted;
									echo '</td>';
									echo '<td>';
									echo $reason;
									echo '</td>';
									echo '<td>';
									echo $adjusted_on;
									echo '</td>';
									echo '<td>';
									echo $rs_adjusted['fname'] . " " . $rs_adjusted['sname'];
									echo '</td>';
									echo '<td>';
									echo '<a href="#" class="del_button" id="del-'.$adjusted_id.'">';
									echo '<img src="dist/img/icon_del.gif" border="0" />';
									echo '</a>';
									echo '</td>';
									echo '</tr>';
								}
							?>
                            </tbody>
                        </table>
                        </td>
            		</tr>
                    <?php
					$qry_ttladj = mysqli_query($link,"select sum(adjusted_time) from adjusted_timeframe where order_id = '".$order_id."'");
					$rs_ttladj = mysqli_fetch_array($qry_ttladj);
					$total_timeframe = ($rs_ttladj['sum(adjusted_time)'] + $data_order['admin_timeframe'])/3600;
					?>
                    <tr>
                        <th   valign="middle"> Total timeframe </th>
                        <td valign="middle" colspan="2"><span id="total_timeframe"><?php echo $total_timeframe; ?> hours</span></td>
                    </tr>
                        
                   <?php
					}
				   ?>
                    
                    <tr>
            			<th   valign="middle"> Payment method </th>
            			<td valign="middle" colspan="2"><?php echo $data_order['pay_method'];?></td>
            			</tr>
            		<tr>
            			<th  valign="middle"> Payment status </th>
                        <th  valign="middle"> 
                        <?php
						if($data_order['payment_status'] == 'not_paid'){
							echo '<span class="label label-danger">Not paid</span>';
						}else if($data_order['payment_status'] == 'paid'){
							echo '<span class="label label-success">Paid</span>';
						}else if($data_order['payment_status'] == 'pending'){
							echo '<span class="label label-default">Pending approval</span>';
						}
						?>
                        </th>
                        <?php
						if($data_order['payment_status'] == 'pending'){
						?>
            			<td style="text-align:right"><a href="#">approve</a></td>
                        <?php
						}else{
							echo '<th>&nbsp;</th>';
						}
						?>
                        
            		</tr>
            		<tr>
            			<th  valign="middle"> Can writers view this order? </th>
            			<td valign="middle">
                         <?php
						if($data_order['view_order'] > 0){
							echo "Yes";
						}else{
							echo "No";	
						}
						?>
                        </td>
                        <td style="text-align:right"><a data-toggle="modal" href="#editViewModal">edit </a></td>
            		</tr>
                    <?php
						if($data_order['view_order'] > 0){
							
						?>
                    <tr>
            			<th  valign="middle">Academic levels with view permission</th>
            			<td>
                        <table class="table table-striped">
                        	<?php
								$qry_views = mysqli_query($link,"select * from view_order a, academic_level b where order_id = '".$order_id."' and a.writer_level = b.act_level_id");
								while($rs_views = mysqli_fetch_array($qry_views)){
									$view_id = $rs_views['view_id'];
									$academic_level = $rs_views['act_name'];
									echo '<tr>';
									echo '<td>';
									echo $academic_level;
									echo '</td>';
									echo '</tr>';
								}
							?>
                        </table>
                        </td>
            		</tr>
                    
                    <tr>
            			<th valign="middle"> Admin set amount</th>
            			<td valign="middle">
                        <?php
						if($data_order['admin_setamount'] > 0){
							echo formatMoney($data_order['admin_setamount'], true);
						}else{
							echo '<a data-toggle="modal" href="#setamountModal">SET </a>';
						}
						?>
                        </td>
                        <td style="text-align:right">
                        <?php
						if($data_order['admin_setamount'] > 0){
                        	echo '<a data-toggle="modal" href="#editamountModal">edit </a>';
						}
						?>
						</td>
            		</tr>

                    <?php
						}
					?>
            		</table>
                     </div><!-- /.table-responsive -->
                    
                    
                    
                    <div class="modal fade" id="editViewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                <form role="form">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Can writers view this order?</h4>
                  </div>
                  <div class="modal-body">
                    
                    <label><input type="radio" name="view_order" onclick="yesView()" value="1"  <?php if($data_order['view_order'] > 0){ ?>checked<?php } ?>/>&nbsp; Yes</label>&nbsp;&nbsp;
                    <label><input type="radio" name="view_order" onclick="noView()" value="0" <?php if($data_order['view_order'] == 0){ ?>checked<?php } ?>/>&nbsp; No</label>
                    
                     <?php
						if($data_order['view_order'] > 0){
							
						?>
                    <div id="add_views">
                    <div class="form-group">
                      <label class="select"> Select academic level
                        <select name="level" class="form-control-select" id="level"  onChange="add_view(this.value)">
                        	<option></option>
                            <?php
                        $res = mysqli_query($link,"SELECT * FROM academic_level order by act_level_id");
                        while($row = mysqli_fetch_array($res))
                        {
                            
                        ?>
                          <option value="<?php echo $row["act_level_id"]?>"><?php echo $row["act_name"]?></option>
                   <?php } ?>
                         
                        </select>
                       </label>
                        <img src="dist/img/loading.gif" id="LoadingImage" style="display:none" />
                    </div>
                    
                    <table cellspacing="0" cellpadding="10px" class="table table-striped">
                    	<thead>
                            <tr>
                                <td colspan="2">
                                	List of writers academic levels with view permission
                                </td>
                            </tr>
                        </thead>
                        <tbody id="views_response">
                        	<?php
								$qry_views = mysqli_query($link,"select * from view_order a, academic_level b where order_id = '".$order_id."' and a.writer_level = b.act_level_id");
								while($rs_views = mysqli_fetch_array($qry_views)){
									$view_id = $rs_views['view_id'];
									$academic_level = $rs_views['act_name'];
									echo '<tr id="item_'.$view_id.'">';
									echo '<td>';
									echo '<a href="#" class="del_button" id="del-'.$view_id.'">';
									echo '<img src="dist/img/icon_del.gif" border="0" />';
									echo '</a>';
									echo '</td>';
									echo '<td>';
									echo $academic_level;
									echo '</td>';
									echo '</tr>';
								}
							?>
                        </tbody>
                    </table>
					</div>
                    
                    <?php
						}
					?>
                    
                    <div id="add_views" style="display:none">
                    <div class="form-group">
                      <label class="select"> Select academic level
                        <select name="level" class="form-control-select" id="level"  onChange="add_view(this.value)">
                        	<option></option>
                            <?php
                        $res = mysqli_query($link,"SELECT * FROM academic_level order by act_level_id");
                        while($row = mysqli_fetch_array($res))
                        {
                            
                        ?>
                          <option value="<?php echo $row["act_level_id"]?>"><?php echo $row["act_name"]?></option>
                   <?php } ?>
                         
                        </select>
                       </label>
                        <img src="dist/img/loading.gif" id="LoadingImage" style="display:none" />
                    </div>
                    
                    <table cellspacing="0" cellpadding="10px" class="table table-striped">
                    	<thead>
                            <tr>
                                <td colspan="2">
                                	List of writers academic levels with view permission
                                </td>
                            </tr>
                        </thead>
                        <tbody id="views_response">
                        	<?php
								$qry_views = mysqli_query($link,"select * from view_order a, academic_level b where order_id = '".$order_id."' and a.writer_level = b.act_level_id");
								while($rs_views = mysqli_fetch_array($qry_views)){
									$view_id = $rs_views['view_id'];
									$academic_level = $rs_views['act_name'];
									echo '<tr id="item_'.$view_id.'">';
									echo '<td>';
									echo '<a href="#" class="del_button" id="del-'.$view_id.'">';
									echo '<img src="dist/img/icon_del.gif" border="0" />';
									echo '</a>';
									echo '</td>';
									echo '<td>';
									echo $academic_level;
									echo '</td>';
									echo '</tr>';
								}
							?>
                        </tbody>
                    </table>
					</div>
                    
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <a class="btn btn-primary" href="index.php?page=vieworder&orderid=<?php echo $order_id; ?>">Submit</a>
                  </div>
                </form>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div> 
            
            
            <div class="modal fade" id="setTimeframeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                <form role="form" action="php/register-submit.php" method="post">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Set timeframe</h4>
                  </div>
                  <div class="modal-body">
                    
                    <div class="form-group">
                      <label for="timeframe">Time in hours</label>
                      <input class="form-control" id="timeframe_set" name="timeframe_set" type="text">
                      <input name="order_id" type="hidden" value="<?php echo $order_id; ?>">
                    </div>
                    
                    
                    
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                  </div>
                </form>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div> 
            
            
            <div class="modal fade" id="adjustTimeframeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                <form role="form" action="php/register-submit.php" method="post">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Adjust timeframe</h4>
                  </div>
                  <div class="modal-body">
                    
                    <div class="form-group">
                      <label for="timeframe">Time in hours</label>
                      <input class="form-control" id="timeframe_adjusted" name="timeframe_adjusted" type="text">
                      <input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />
                    </div>
                    
                    <div class="form-group">
                      <label for="timeframe">Reason</label>
                      <textarea class="form-control" id="reason" name="reason"></textarea>
                    </div>
                    
                    
                    
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                  </div>
                </form>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div> 
           
           
           
           <div class="modal fade" id="setamountModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                <form role="form" action="php/register-submit.php" method="post">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Set amount to pay writer</h4>
                  </div>
                  <div class="modal-body">
                    
                    <div class="form-group">
                      <label for="timeframe">Amount</label>
                      <input class="form-control" id="amount_set" name="amount_set" type="text">
                      <input name="order_id" type="hidden" value="<?php echo $order_id; ?>">
                      <input name="client_amount" type="hidden" value="<?php echo $data_order['total_amount']; ?>">
                    </div>
                    
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                  </div>
                </form>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div> 
            
            
            <div class="modal fade" id="editamountModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                <form role="form" action="php/register-submit.php" method="post">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Edit amount</h4>
                  </div>
                  <div class="modal-body">
                    
                    <div class="form-group">
                      <label for="timeframe">amount</label>
                      <input class="form-control" name="edit_amount" value="<?php echo $data_order['admin_setamount'] ?>" type="text">
                      <input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />
                      <input name="client_amount" type="hidden" value="<?php echo $data_order['total_amount']; ?>">
                    </div>
                    
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                  </div>
                </form>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div> 
            
                 
                 
                 
                </div><!-- /.box-body -->
              </div><!-- /.box -->
              
              <?php
			  if($order_status > 0){
			  ?>
              <div id="active_order_div">
              
                   <div class="box">
                        <div class="box-header">
                          <h3 class="box-title">Review Uploaded Files</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                        
                        <div class="table-responsive">
                        <table cellspacing="0" cellpadding="10px" class="table table-striped">
                        <thead>
                            <tr>
                                <th>File type</th>
                                <th>File</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql_writer = "SELECT * FROM writers_jobs a, writers b WHERE a.writer_id = b.writer_id and a.order_id  = '".$orderid."' and a.job_status != 'canceled'";
                            $qry_writer = mysqli_query($link,$sql_writer) or die(mysqli_error($link));
                            $rs_writer = mysqli_fetch_array($qry_writer);
                            $job_id = $rs_writer['job_id'];
                            $writer_id = $rs_writer['writer_id'];
                            $job_status = $rs_writer['job_status'];
                            $revise = $rs_writer['revise'];
                            $admin_complete = $rs_writer['admin_complete'];
                            $qry = mysqli_query($link,"select * from writers_files where order_id = '".$order_id."' and writer_id = '".$writer_id."'");
                            while($rs = mysqli_fetch_array($qry)){
                                $file_loc = substr($rs['file_loc'], 3);
                                echo '<tr>';
                                echo '<td>'.$rs['file_type'].'</td>';
                                echo '<td>'.substr($rs['file_loc'], 9).'</td>';
                                echo '<td><a href="../writersPortal/'.$file_loc.'">download</a></td>';
                                echo '</tr>';	
                            }
                            ?>
                        </tbody>
                        </table>
                        </div><!-- /.table-responsive -->
                        
                         </div><!-- /.box-body -->
                   </div><!-- /.box -->
                  
                   <div class="box">
                        <div class="box-header">
                          <h3 class="box-title">Review Action</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                        
                        <div class="table-responsive">
                        <table cellspacing="0" cellpadding="10px" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Select</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="2"><label><input name="review_action" id="cancelOrder" onclick="cancelOrder()" type="radio" value="cancel" <?php if($job_status == 'cancelled'){ ?> checked="checked"<?php } ?> /> &nbsp;Cancel Order (this action will withdraw the order from the writer)</label></td>
                            </tr>
                            <tr style="display:none" id="cancelreason_row">
                                <td></td>
                                <td>
                                    <table class="table">
                                        <tr>
                                            <td><label><input type="checkbox" id="chk_low_quality" onclick="lowQuality()" />&nbsp;&nbsp;Low quality </label></td>
                                        </tr>
                                        <tr>
                                            <td><label><input type="checkbox" id="chk_plagiarised" onclick="plagiarised()" />&nbsp;&nbsp;Plagiarised</label></td>
                                        </tr>
                                        <tr>
                                            <td><label><input type="checkbox" id="chk_fullmismatch" onclick="fullMismatch()" />&nbsp;&nbsp;Full mismatch</label></td>
                                        </tr>
                                        <tr>
                                            <td><textarea class="form-control" id="cancel_narrative" placeholder="Description"></textarea></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"><label><input name="review_action" onclick="sendBack()" id="sendBack" type="radio" value="revise" <?php if($revise == 1){ ?> checked="checked"<?php } ?> /> &nbsp;Send back to writer for revision</label></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <table cellspacing="0" cellpadding="10px" class="table table-striped">
                                            <thead>
                                                <th>Instruction</th>
                                                <th>Status</th>
                                                <th>Date Sent</th>
                                                <th>Sent By</th>
                                            </thead>
                                            <tbody id="revisions_instructions">
                                        <?php 
                                        
                                        $sql_revision = "SELECT * FROM writers_revision WHERE  job_id = '".$job_id."' order by revision_id desc";
                                        $qry_revision = mysqli_query($link,$sql_revision) or die(mysqli_error($link));
                                        while($rs_revision = mysqli_fetch_array($qry_revision)){
                                            $instructions = $rs_revision['instructions'];
                                            $sent_date = $rs_revision['datetime'];
                                            $sent_by = $rs_revision['sent_by'];
                                            if($rs_revision['revision_status'] == '0'){
                                                $revision_status = "Not done";
                                            }else{
                                                $revision_status = "Done";
                                            }
                                            echo "<tr><td>".$instructions."</td><td>".$revision_status."</td><td>".$sent_date."</td><td>".$sent_by."</td></tr>";
                                        }
                                        
                                         ?>
                                         </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr style="display:none" id="instruction_row">
                                <td></td>
                                <td><textarea class="form-control" id="instructions" placeholder="Instructions"></textarea></td>
                            </tr>
                            <tr>
                                <td colspan="2"><label><input name="review_action" id="markComplete" onclick="markComplete()" type="radio" value="complete" <?php if($admin_complete == '1'){ ?> checked="checked"<?php } ?> /> &nbsp;Mark as complete (this action will send the order to the client for review)</label></td>
                            </tr>
                        </tbody>
                        </table>
                        <table cellspacing="0" cellpadding="10px" class="table table-striped">
                            <tr>
                                <td id="notification"></td>
                                <td><button type="button" onclick="reviewAction()" class="btn btn-primary pull-right">Save & Send</button></td>
                            </tr>
                        </table>
                        </div><!-- /.table-responsive -->
                        
                         </div><!-- /.box-body -->
                   </div><!-- /.box -->
                  
              </div>
              <!-- /.active order div -->
              <?php
			  }
			  ?>
              
            </div><!-- /.col -->
            
            
          </div><!-- /.row -->
          

        </section><!-- /.content -->
        
       
       <div class="modal fade" id="sendbackModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Send order back to the writer for revision</h4>
              </div>
              <div class="modal-body" align="center">
                
                <label class="alert alert-warning">Are you certain you want to send this order back to the writer for revision?</label>
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">No</button>
                <button type="button" onclick="save_sendBack()" id="save_sendBack" class="btn btn-primary">Yes</button>
                <img src="dist/img/loading.gif" id="LoadingImage_sendback" style="display:none" />
              </div>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div> 
        
        <div class="modal fade" id="markCompleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Mark order as complete</h4>
              </div>
              <div class="modal-body" align="center">
                
                <label class="alert alert-info">Are you certain you want to mark order as complete?</label>
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">No</button>
                <button type="button" onclick="save_markComplete()" id="save_markComplete" class="btn btn-primary">Yes</button>
                <img src="dist/img/loading.gif" id="LoadingImage_complete" style="display:none" />
              </div>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
       </div> 
    
       <div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Cancel Order</h4>
              </div>
              <div class="modal-body" align="center">
                
                <label class="alert alert-info">Are you certain you want to cancel this order?</label>
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">No</button>
                <button type="button" onclick="save_cancelOrder()" id="save_cancelOrder" class="btn btn-primary">Yes</button>
                <img src="dist/img/loading.gif" id="LoadingImage_cancel" style="display:none" />
              </div>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
       </div> 
        
        <div class="modal fade" id="assignModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog" style="width:1100px;margin:30px auto">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Assign this order to a writer</h4>
              </div>
              
              <div class="row">
              <div class="col-xs-12">
                    <article class="col-sm-12 col-md-12 col-lg-3">
                        <div class="form-group">
                          <label for="sname">Writer First Name</label>
                          <input class="form-control" id="txtFname" type="text">
                        </div>
                   	</article>
                    <article class="col-sm-12 col-md-12 col-lg-3">
                        <div class="form-group">
                          <label for="sname">Writer Last Name</label>
                          <input class="form-control" id="txtLname" type="text">
                        </div>
                   	</article>
                    <article class="col-sm-12 col-md-12 col-lg-3">
                        <div class="form-group">
                          <label for="fname">Writer Email</label>
                          <input class="form-control" id="txtEmail" type="text">
                        </div>
                    </article>
                    <article class="col-sm-12 col-md-12 col-lg-3">
                		<a href="javascript:void(0)" class="btn btn-default" style="margin-top:22px;" onclick="searchWriter()">Search</a>
                    </article>
                </div>
                </div>
                
              <div class="row">
               <div class="col-xs-12">
          		<div class="box">
                    
                <div class="box-header">
                  <h3 class="box-title">List of writers</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                  <table class="table table-bordered table-striped">
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
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody id="writers-table">
                    
                      
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
              
            </div>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div>
        
        <div id="modal"></div>
                    
        <!-- jQuery 2.2.3 -->
    	<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
        <script type="application/javascript">
			var cancel_reason_arr = [];
			
			function lowQuality(){
				if(document.getElementById('chk_low_quality').checked) {
					cancel_reason_arr.push('low_quality');
					console.log(JSON.stringify(cancel_reason_arr));
				}else{
					var index = cancel_reason_arr.indexOf('low_quality');
					if (index > -1) {
						cancel_reason_arr.splice(index, 1);
					}
					console.log(JSON.stringify(cancel_reason_arr));
				}
			}
			
			function plagiarised(){
				if(document.getElementById('chk_plagiarised').checked) {
					cancel_reason_arr.push('plagiarised');
					console.log(JSON.stringify(cancel_reason_arr));
				}else{
					var index = cancel_reason_arr.indexOf('plagiarised');
					if (index > -1) {
						cancel_reason_arr.splice(index, 1);
					}
					console.log(JSON.stringify(cancel_reason_arr));
				}
			}
			
			function fullMismatch(){
				if(document.getElementById('chk_fullmismatch').checked) {
					cancel_reason_arr.push('full_mismatch');
					console.log(JSON.stringify(cancel_reason_arr));
				}else{
					var index = cancel_reason_arr.indexOf('full_mismatch');
					if (index > -1) {
						cancel_reason_arr.splice(index, 1);
					}
					console.log(JSON.stringify(cancel_reason_arr));
				}
			}
			
			function searchWriter(){
				var fname = $('#txtFname').val();
				var lname = $('#txtLname').val();
				var email = $('#txtEmail').val();
				var table = $("#writers-table");
				table.empty();
				table.prepend($("<tr><td colspan='9' class='information'>LOADING ...</td></tr>"));
				var modal = $("#modal");
				// send information to server
				$.ajax({
					url: "php/response.php",
					data: {
						'tag': 'fetch-assignee',
						'email': email,
						'fname': fname,
						'lname': lname
					},
					dataType: 'json',
					success: function(json) {
						table.empty();
						if(json.success == 1) {
							if(json.writers.length == 0) {
								table.append('<tr><td colspan="9" class="information">No records found</td></tr>');
							} else {
								for(var i = 0; i < json.writers.length; i++) {
									var writer_id = json.writers[i].id;
									var names = json.writers[i].names;
									var email = json.writers[i].email;
									table.append($("<tr><td>"+json.writers[i].writer_id+"</td>\
														<td>"+json.writers[i].names+"</td>\
														<td>"+json.writers[i].email+"</td>\
														<td>"+json.writers[i].address+"</td>\
														<td>"+json.writers[i].phone+"</td>\
														<td>"+json.writers[i].academic_level+"</td>\
														<td>"+json.writers[i].speciality+"</td>\
														<td>"+json.writers[i].test_score+"</td>\
														<td><a data-toggle='modal' href='#assignModal"+writer_id+"' class='btn btn-primary'>Assign order</a></td>\
														</tr>"));
									modal.append($('<div class="modal fade" id="assignModal'+writer_id+'" tabindex="-1" role="dialog"\ aria-labelledby="myModalLabel" aria-hidden="true">\
													  <div class="modal-dialog">\
														<div class="modal-content">\
														  <div class="modal-header">\
															<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span\ aria-hidden="true">×</span></button>\
															<h4 class="modal-title">Are you sure you want to assign '+names+' this order?\</h4>\
														  </div>\
														  \
														  <div class="modal-footer">\
															<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close\</button>\
															<button id="assign_btn'+writer_id+'" type="button" class="btn btn-primary" onclick="assignWriter('+writer_id+',\''+names+'\',\''+email+'\')">Yes</button>\
															<img src="dist/img/loading.gif" id="LoadingImage_assign'+writer_id+'" style="display:none" />\
														  </div>\
														  \
														</div>\
														</div><!-- /.modal-content -->\
													  </div><!-- /.modal-dialog -->\
        </div>'));
								}	
							}
			
									
						} else {
							table.append("<tr><td colspan='9' class='error'>"+json.message+"</td></tr>");
							
						}
					},
					error: function(error) {
						table.empty();
            			table.append($("<tr><td colspan='9' class='error'>"+JSON.stringify(error)+"</td></tr>"));
					}
				});
			}
			
			function assignWriter(writer_id,names,email){
				$("#LoadingImage_assign"+writer_id).show();
				$("#assign_btn"+writer_id).hide();
				$.ajax({
				type: 'POST',
				url: "php/response.php",
				data: {
						'tag': 'assign-writer',
						'writer_id': writer_id,
						'order_id': <?php echo $order_id; ?>,
						'order_title': '\"<?php echo $data_order['title_topic'];?>\"',
						'email': email,
						'name': names
					},
				dataType: 'json',
				success: function(response) {
					if(response.success == 1) {
						$('#notification').html('<div style="margin:0 auto;" class="alert alert-success fade in" align="center">'+response.message+'</div>');
						$('#assign_td').html("Assigned to ["+names+"] [not_confirmed]");
						$("#assignModal"+writer_id).modal("hide");
						$("#assignModal").modal("hide");
					}else{
						alert(response.message);
					}
						
					$("#assign_btn"+writer_id).show(); //show submit button
					$("#LoadingImage_assign"+writer_id).hide(); //hide loading image
				  },
				  xhrFields: {
					withCredentials: false
				  },
				  error: function(error) {
					alert(JSON.stringify(error));
					$("#assign_btn"+writer_id).show(); //show submit button
					$("#LoadingImage_assign"+writer_id).hide(); //hide loading image
				  }
				});	
			}
		
			<?php
			$qryjob =  mysqli_query($link,"SELECT * FROM writers_jobs a, writers b WHERE a.writer_id = b.writer_id and a.order_id  = '".$order_id."' and a.job_status != 'canceled'") or die(mysqli_error($link));
			$count_job = mysqli_num_rows($qryjob);
			if($count_job > 0){
				$rsjob = mysqli_fetch_array($qryjob);
				$job_id = $rsjob['job_id'];
				$writer_id = $rsjob['writer_id'];
				$writer_email = $rsjob['email'];
				$writer_name = $rsjob['fname']." ".$rsjob['lname'];
			?>
			function save_cancelOrder(){
				$("#LoadingImage_cancel").show();
				$("#save_cancelOrder").hide();
				var description = $("#cancel_narrative").val();
				
				var myData = 'cancelOrder=1&job_id=<?php echo $job_id; ?>&order_id=<?php echo $order_id; ?>&writer_id=<?php echo $writer_id; ?>&writer_name=<?php echo $writer_name; ?>&writer_email=<?php echo $writer_email; ?>&order_title=\"<?php echo $data_order['title_topic'];?>\"&description='+description+'&reason_arr='+cancel_reason_arr; //build a post data structure
				jQuery.ajax({
				type: "POST", // HTTP method POST or GET
				url: "php/response.php", //Where to make Ajax calls
				dataType:"text", // Data type, HTML, json etc.
				data:myData, //Form variables
				success:function(response){
					$("#assign_td").html('<a data-toggle="modal" href="#assignModal">Assign a writer</a>');
					$('#cancelModal').modal('hide')
					$("#active_order_div").html("");
					$("#notification").html("<label class='alert alert-success'>Order successfully cancelled</label>");
				},
				error:function (xhr, ajaxOptions, thrownError){
					alert(thrownError);
					$("#LoadingImage_cancel").hide();
					$("#save_cancelOrder").show();
				}
				});
			}
			
			function save_markComplete(){
				
				$("#LoadingImage_complete").show();
				$("#save_markComplete").hide();
				
				var myData = 'markComplete=1&job_id=<?php echo $job_id; ?>&writer_name=<?php echo $writer_name; ?>&writer_email=<?php echo $writer_email; ?>&order_id=<?php echo $order_id; ?>&order_title=\"<?php echo $data_order['title_topic'];?>\"'; //build a post data structure
				jQuery.ajax({
				type: "POST", // HTTP method POST or GET
				url: "php/response.php", //Where to make Ajax calls
				dataType:"text", // Data type, HTML, json etc.
				data:myData, //Form variables
				success:function(response){
					$("#LoadingImage_complete").hide();
					$("#save_markComplete").show();
					$("#notification").html("<label class='alert alert-success'>Order successfully marked as complete</label>");
					$('#markCompleteModal').modal('hide');
					setTimeout(function() {
						$('#notification').remove();
					}, 4000);
					return false;
				},
				error:function (xhr, ajaxOptions, thrownError){
					alert(thrownError);
				}
				});
			}
			
			function save_sendBack(){
				$("#LoadingImage_sendback").show();
				$("#save_sendBack").hide();
				
				var myData = 'sendBack=1&job_id=<?php echo $job_id; ?>&writer_name=<?php echo $writer_name; ?>&writer_email=<?php echo $writer_email; ?>&order_title=\"<?php echo $data_order['title_topic'];?>\"&order_id=<?php echo $order_id; ?>&instructions='+$("#instructions").val(); //build a post data structure
				jQuery.ajax({
				type: "POST", // HTTP method POST or GET
				url: "php/response.php", //Where to make Ajax calls
				dataType:"text", // Data type, HTML, json etc.
				data:myData, //Form variables
				success:function(response){
					$("#revisions_instructions").append(response)
					$("#LoadingImage_sendback").hide();
					$("#save_sendBack").show();
					$("#notification").html("<label class='alert alert-success'>Order successfully sent back for revision</label>");
					$('#sendbackModal').modal('hide')
					$("#instructions").val('');
					setTimeout(function() {
						$('#notification').remove();
					}, 4000);
					return false;
				},
				error:function (xhr, ajaxOptions, thrownError){
					alert(thrownError);
				}
				});
			}
			
			function reviewAction(){
				if (document.getElementById('sendBack').checked) {
					if($("#instructions").val() == ""){
						alert("Please enter revision instructions");
						return false;
					}
					$('#sendbackModal').modal('show');
				}else if (document.getElementById('markComplete').checked) {
					$('#markCompleteModal').modal('show');
				}else{
					var narrative = $("#cancel_narrative").val();
					if (cancel_reason_arr.length == 0) {
						alert("Please select a cancel reason");
						return false;
					}
					if (narrative == "") {
						alert("Please enter a description");
						return false;
					}
					$('#cancelModal').modal('show');
				}
			}
			
			function cancelOrder(){
				$("#cancelreason_row").show();
				$("#instruction_row").hide();
			}
			
			function sendBack(){
				$("#instruction_row").show();
				$("#cancelreason_row").hide();
			}
			
			function markComplete(){
				$("#instruction_row").hide();
				$("#cancelreason_row").hide();
			}
			
			$(function () {
        
				if (document.getElementById('sendBack').checked) {
					$("#instruction_row").show();
				}else{
					$("#instruction_row").hide();
				}
				
				if (document.getElementById('cancelOrder').checked) {
					$("#cancelreason_row").show();
				}else{
					$("#cancelreason_row").hide();
				}
				
			});
			
			<?php
			}
			?>
			
			
			function yesView(){
				var myData = 'yesView=1&order_id=<?php echo $order_id; ?>'; //build a post data structure
				jQuery.ajax({
				type: "POST", // HTTP method POST or GET
				url: "php/response.php", //Where to make Ajax calls
				dataType:"text", // Data type, HTML, json etc.
				data:myData, //Form variables
				success:function(response){
					$("#add_views").show();
			
				},
				error:function (xhr, ajaxOptions, thrownError){
					alert(thrownError);
				}
				});
			}
			
			function noView(){
				var myData = 'noView=1&order_id=<?php echo $order_id; ?>'; //build a post data structure
				jQuery.ajax({
				type: "POST", // HTTP method POST or GET
				url: "php/response.php", //Where to make Ajax calls
				dataType:"text", // Data type, HTML, json etc.
				data:myData, //Form variables
				success:function(response){
					$("#add_views").hide();
			
				},
				error:function (xhr, ajaxOptions, thrownError){
					alert(thrownError);
				}
				});
				
			}
			
			function add_view(val)
			{
				//alert(val);
				if($("#level").val()==='')
				{
					alert("Please academic level");
					return false;
				}
				
				$("#LoadingImage").show(); //show loading image
				
				var myData = 'level='+ val +'&order_id=<?php echo $order_id; ?>&add_view=1'; //build a post data structure
				jQuery.ajax({
				type: "POST", // HTTP method POST or GET
				url: "php/response.php", //Where to make Ajax calls
				dataType:"text", // Data type, HTML, json etc.
				data:myData, //Form variables
				success:function(response){
					$("#views_response").prepend(response);
					$("#level").val(''); //empty text field on successful
					$("#LoadingImage").hide(); //hide loading image
			
				},
				error:function (xhr, ajaxOptions, thrownError){
					$("#LoadingImage").hide(); //hide loading image
					alert(thrownError);
				}
				});
			}
			
		</script>
        
        <?php
}else{
	echo "Invalid request";	
}
		?>