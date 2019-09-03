<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Site A Orders
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-files-o"></i> Home</a></li>
            <li class="active">Orders</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          
          
          <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a aria-expanded="true" href="#tab_1" data-toggle="tab">Available orders</a></li>
                  <li><a aria-expanded="false" href="#tab_6" data-toggle="tab">Bids/Requests</a></li>
                  <li><a aria-expanded="false" href="#tab_2" data-toggle="tab">Current orders</a></li>
                  <li><a aria-expanded="false" href="#tab_3" data-toggle="tab">Done orders</a></li>
                  <li><a aria-expanded="false" href="#tab_4" data-toggle="tab">On revision</a></li>
                  <li><a aria-expanded="false" href="#tab_5" data-toggle="tab">Completed orders</a></li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">
                  	
                    <div class="row">
            		<div class="col-xs-12">
                    <div class="table-responsive">
                      <table id="example1" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                          	<th>Action</th>
                            <th>Order ID</th>
                            <th>Client</th>
                            <th>Date</th>
                            <th>Title topic</th>
                            <th>Original timeframe</th>
                            <th>Writer academic level</th>
                            <th>Spacing</th>
                            <th>Paper format</th>
                            <th>Total amount</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
			$sql = "SELECT * FROM prime_order a, academic_level b where a.writer_level = b.act_level_id and a.order_status = 0 and a.site = 'A'";
			$qry = mysqli_query($link,$sql) or die(mysqli_error($link));
			while ($rs = mysqli_fetch_array($qry)) {
				$order_id = $rs['order_id'];
				$client_name = $rs['fname']." ".$rs['lname'];
				$title_topic = $rs['title_topic'];
				$date = $rs['date'];
				$total_amount = $rs['total_amount'];
				
				$timeframe = $rs['timeframe'];
				$writer_level = $rs['act_name'];
				
				$spacing = $rs['spacing'];
				$style = $rs['style'];
								?>
								
								  <tr>
                                  	<td><a href="?page=vieworder&orderid=<?php echo $order_id; ?>">View Order</a></td>
									<td><?php echo $order_id; ?></td>
									<td><?php echo $client_name; ?></td>
									<td><?php echo $date; ?></td>
									<td><?php echo $title_topic; ?></td>
									<td><?php echo $timeframe; ?></td>
									<td><?php echo $writer_level; ?></td>
									<td><?php echo $spacing; ?></td>
									<td><?php echo $style; ?></td>
									<td><?php echo formatMoney($total_amount, true); ?></td>
								  </tr>
								  
								  <?php
			}
								  ?>
								  
								</tbody>
								<tfoot>
								 <tr>
									<th>Order ID</th>
									<th>Client</th>
									<th>Date</th>
									<th>Title topic</th>
									<th>Time frame</th>
									<th>Writer academic level</th>
									<th>Spacing</th>
									<th>Paper format</th>
									<th>Total amount</th>
									<th>Action</th>
								  </tr>
								</tfoot>
							  </table>
						</div><!-- /.table-responsive -->
						</div><!-- /.col -->
					  </div><!-- /.row -->
                        
                    
                  </div>
                  
                  <div class="tab-pane" id="tab_6">
                  	
                    <div class="row">
            		<div class="col-xs-12">
                    <div class="table-responsive">
                      <table id="example2" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                          	<th>Action</th>
                          	<th>No of Bids</th>
                            <th>No of Requests</th>
                            <th>Order ID</th>
                            <th>Client</th>
                            <th>Date</th>
                            <th>Title topic</th>
                            <th>Original timeframe</th>
                            <th>Writer academic level</th>
                            <th>Spacing</th>
                            <th>Paper format</th>
                            <th>Total amount</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
			$sql = "SELECT * FROM prime_order a, academic_level b where a.writer_level = b.act_level_id and a.order_status = 0 and a.site = 'A'";
			$qry = mysqli_query($link,$sql) or die(mysqli_error($link));
			while ($rs = mysqli_fetch_array($qry)) {
				$order_id = $rs['order_id'];
				$client_name = $rs['fname']." ".$rs['lname'];
				$title_topic = $rs['title_topic'];
				$date = $rs['date'];
				$total_amount = $rs['total_amount'];
				
				$timeframe = $rs['timeframe'];
				$writer_level = $rs['act_name'];
				
				$spacing = $rs['spacing'];
				$style = $rs['style'];
				
				$qry_bids = mysqli_query($link,"select * from writers_bids where order_id = '".$order_id."'");
				$count_bids = mysqli_num_rows($qry_bids);
				
				$qry_req = mysqli_query($link,"select * from writers_requests where order_id = '".$order_id."'");
				$count_req = mysqli_num_rows($qry_req);
								?>
								
								  <tr>
                                  	<td><table><tr><td><a href="?page=viewbids&order_id=<?php echo $order_id; ?>">View Bid(s)</a></td></tr><tr><td><a href="?page=viewrequests&order_id=<?php echo $order_id; ?>">View Request(s)</a></td></tr></table></td>
									<td><?php echo $count_bids; ?></td>
                                    <td><?php echo $count_req; ?></td>
                                    <td><?php echo $order_id; ?></td>
									<td><?php echo $client_name; ?></td>
									<td><?php echo $date; ?></td>
									<td><?php echo $title_topic; ?></td>
									<td><?php echo $timeframe; ?></td>
									<td><?php echo $writer_level; ?></td>
									<td><?php echo $spacing; ?></td>
									<td><?php echo $style; ?></td>
									<td><?php echo formatMoney($total_amount, true); ?></td>
								  </tr>
								  
								  <?php
			}
								  ?>
								  
								</tbody>
								<tfoot>
								 <tr>
                                 	<th>Action</th>
									<th>No of Bids</th>
                                    <th>No of Requests</th>
                                    <th>Order ID</th>
                                    <th>Client</th>
                                    <th>Date</th>
                                    <th>Title topic</th>
                                    <th>Original timeframe</th>
                                    <th>Writer academic level</th>
                                    <th>Spacing</th>
                                    <th>Paper format</th>
                                    <th>Total amount</th>
								  </tr>
								</tfoot>
							  </table>
                              </div><!-- /.table-responsive -->
						</div><!-- /.col -->
					  </div><!-- /.row -->
                      
                  </div>
                  
                  
                  <div class="tab-pane" id="tab_2">
                  	
                    <div class="row">
            		<div class="col-xs-12">
                    <div class="table-responsive">
                      <table id="example3" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                          	<th>Action</th>
                            <th>Order ID</th>
                            <th>Client</th>
                            <th>Writer</th>
                            <th>Date</th>
                            <th>Title topic</th>
                            <th>Original timeframe</th>
                            <th>Writer academic level</th>
                            <th>Spacing</th>
                            <th>Paper format</th>
                            <th>Total amount</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
			$sql = "SELECT a.assigned, a.order_id, a.fname as client_fname, a.lname as client_lname, a.title_topic, a.date, a.total_amount, a.timeframe, b.act_name, a.spacing, a.style, d.fname as writer_fname, d.lname as writer_lname FROM prime_order a, academic_level b, writers_jobs c, writers d where a.writer_level = b.act_level_id and a.order_id = c.order_id and c.writer_id = d.writer_id and a.order_status = 1 and a.complete = 0 and c.job_status = 'pending' and a.site = 'A'";
			$qry = mysqli_query($link,$sql) or die(mysqli_error($link));
			while ($rs = mysqli_fetch_array($qry)) {
				$order_id = $rs['order_id'];
				$client_name = $rs['client_fname']." ".$rs['client_lname'];
				$title_topic = $rs['title_topic'];
				$date = $rs['date'];
				$total_amount = $rs['total_amount'];
				
				$timeframe = $rs['timeframe'];
				$writer_level = $rs['act_name'];
				
				$spacing = $rs['spacing'];
				$style = $rs['style'];
				
				$assigned = $rs['assigned'];
				
				if($assigned > 0){
					$sql_assignee = "SELECT b.fname, b.lname, a.status FROM writers_assigned a, writers b WHERE a.writer_id = b.writer_id and a.order_id  = '".$order_id."'";
					$qry_assignee = mysqli_query($link,$sql_assignee) or die(mysqli_error($link));
					$rs_assignee = mysqli_fetch_array($qry_assignee);
					if($rs_assignee['status'] == 'pending_confirmation'){
						$assign_status = '<span class="center-block label label-warning">Pending Confirmation</span>';
					}else{
						$assign_status = '<span class="center-block label label-primary">Confirmed</span>';
					}
					$writer_name = 'Assigned to ['.$rs_assignee['fname'].' '.$rs_assignee['lname'].'] '.$assign_status;
				}else{
					$writer_name = $rs['writer_fname']." ".$rs['writer_lname'];
				}
								?>
                               
								  <tr>
                                  	<td><a href="?page=vieworder&orderid=<?php echo $order_id; ?>">View Order</a></td>
									<td><?php echo $order_id; ?></td>
									<td><?php echo $client_name; ?></td>
                                    <td><?php echo $writer_name; ?></td>
									<td><?php echo $date; ?></td>
									<td><?php echo $title_topic; ?></td>
									<td><?php echo $timeframe; ?></td>
									<td><?php echo $writer_level; ?></td>
									<td><?php echo $spacing; ?></td>
									<td><?php echo $style; ?></td>
									<td><?php echo formatMoney($total_amount, true); ?></td>
								  </tr>
								  
								  <?php
			}
								  ?>
								  
								</tbody>
								<tfoot>
								 <tr>
                                 	<th>Action</th>
									<th>Order ID</th>
                                    <th>Client</th>
                                    <th>Writer</th>
                                    <th>Date</th>
                                    <th>Title topic</th>
                                    <th>Original timeframe</th>
                                    <th>Writer academic level</th>
                                    <th>Spacing</th>
                                    <th>Paper format</th>
                                    <th>Total amount</th>
								  </tr>
								</tfoot>
							  </table>
						</div><!-- /.table-responsive -->
						</div><!-- /.col -->
					  </div><!-- /.row -->
                    
                  </div>
                  
                  
                  <div class="tab-pane" id="tab_3">
                  
                  		<div class="row">
            		<div class="col-xs-12">
                    <div class="table-responsive">
                    
                    <?php
					$sql = "SELECT a.order_id, a.fname as client_fname, a.lname as client_lname, a.title_topic, a.date, a.total_amount, a.timeframe, b.act_name, a.spacing, a.style, d.fname as writer_fname, d.lname as writer_lname FROM prime_order a, academic_level b, writers_jobs c, writers d where a.writer_level = b.act_level_id and a.order_id = c.order_id and c.writer_id = d.writer_id and a.order_status = 1 and a.complete = 0 and c.job_status = 'done' and c.revise = 0 and a.site = 'A'";
			$qry = mysqli_query($link,$sql) or die(mysqli_error($link));
			$count_complete = mysqli_num_rows($qry);
			if($count_complete == 0){
				echo "NO ORDER IS DONE";	
			}else{
					?>
                      <table id="example4" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                          	<th>Action</th>
                            <th>Order ID</th>
                            <th>Client</th>
                            <th>Writer</th>
                            <th>Date</th>
                            <th>Title topic</th>
                            <th>Original timeframe</th>
                            <th>Writer academic level</th>
                            <th>Spacing</th>
                            <th>Paper format</th>
                            <th>Total amount</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
			while ($rs = mysqli_fetch_array($qry)) {
				$order_id = $rs['order_id'];
				$client_name = $rs['client_fname']." ".$rs['client_lname'];
				$title_topic = $rs['title_topic'];
				$date = $rs['date'];
				$total_amount = $rs['total_amount'];
				
				$timeframe = $rs['timeframe'];
				$writer_level = $rs['act_name'];
				
				$spacing = $rs['spacing'];
				$style = $rs['style'];
				
				$writer_name = $rs['writer_fname']." ".$rs['writer_lname'];
								?>
								
								  <tr>
                                  	<td><a href="?page=vieworder&orderid=<?php echo $order_id; ?>">View Order</a></td>
									<td><?php echo $order_id; ?></td>
									<td><?php echo $client_name; ?></td>
                                    <td><?php echo $writer_name; ?></td>
									<td><?php echo $date; ?></td>
									<td><?php echo $title_topic; ?></td>
									<td><?php echo $timeframe; ?></td>
									<td><?php echo $writer_level; ?></td>
									<td><?php echo $spacing; ?></td>
									<td><?php echo $style; ?></td>
									<td><?php echo formatMoney($total_amount, true); ?></td>
								  </tr>
								  
								  <?php
			}
								  ?>
								  
								</tbody>
								<tfoot>
								 <tr>
                                 	<th>Action</th>
									<th>Order ID</th>
                                    <th>Client</th>
                                    <th>Writer</th>
                                    <th>Date</th>
                                    <th>Title topic</th>
                                    <th>Original timeframe</th>
                                    <th>Writer academic level</th>
                                    <th>Spacing</th>
                                    <th>Paper format</th>
                                    <th>Total amount</th>
								  </tr>
								</tfoot>
							  </table>
                              <?php
			}
							  ?>
						</div><!-- /.table-responsive -->
						</div><!-- /.col -->
					  </div><!-- /.row -->
                      
                  </div>
                  
                  <div class="tab-pane" id="tab_4">
                  
                  		<div class="row">
            		<div class="col-xs-12">
                    <div class="table-responsive">
                    
                    <?php
					$sql = "SELECT a.order_id, a.fname as client_fname, a.lname as client_lname, a.title_topic, a.date, a.total_amount, a.timeframe, b.act_name, a.spacing, a.style, d.fname as writer_fname, d.lname as writer_lname FROM prime_order a, academic_level b, writers_jobs c, writers d where a.writer_level = b.act_level_id and a.order_id = c.order_id and c.writer_id = d.writer_id and a.order_status = 1 and a.complete = 0 and c.job_status = 'done' and c.revise = 1 and a.site = 'A'";
			$qry = mysqli_query($link,$sql) or die(mysqli_error($link));
			$count_complete = mysqli_num_rows($qry);
			if($count_complete == 0){
				echo "NO ORDER IS ON REVISION";	
			}else{
					?>
                      <table id="example5" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                          	<th>Action</th>
                            <th>Order ID</th>
                            <th>Client</th>
                            <th>Writer</th>
                            <th>Date</th>
                            <th>Title topic</th>
                            <th>Original timeframe</th>
                            <th>Writer academic level</th>
                            <th>Spacing</th>
                            <th>Paper format</th>
                            <th>Total amount</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
			while ($rs = mysqli_fetch_array($qry)) {
				$order_id = $rs['order_id'];
				$client_name = $rs['client_fname']." ".$rs['client_lname'];
				$title_topic = $rs['title_topic'];
				$date = $rs['date'];
				$total_amount = $rs['total_amount'];
				
				$timeframe = $rs['timeframe'];
				$writer_level = $rs['act_name'];
				
				$spacing = $rs['spacing'];
				$style = $rs['style'];
				
				$writer_name = $rs['writer_fname']." ".$rs['writer_lname'];
								?>
								
								  <tr>
                                  	<td><a href="?page=vieworder&orderid=<?php echo $order_id; ?>">View Order</a></td>
									<td><?php echo $order_id; ?></td>
									<td><?php echo $client_name; ?></td>
                                    <td><?php echo $writer_name; ?></td>
									<td><?php echo $date; ?></td>
									<td><?php echo $title_topic; ?></td>
									<td><?php echo $timeframe; ?></td>
									<td><?php echo $writer_level; ?></td>
									<td><?php echo $spacing; ?></td>
									<td><?php echo $style; ?></td>
									<td><?php echo formatMoney($total_amount, true); ?></td>
								  </tr>
								  
								  <?php
			}
								  ?>
								  
								</tbody>
								<tfoot>
								 <tr>
                                 	<th>Action</th>
									<th>Order ID</th>
                                    <th>Client</th>
                                    <th>Writer</th>
                                    <th>Date</th>
                                    <th>Title topic</th>
                                    <th>Original timeframe</th>
                                    <th>Writer academic level</th>
                                    <th>Spacing</th>
                                    <th>Paper format</th>
                                    <th>Total amount</th>
								  </tr>
								</tfoot>
							  </table>
                              <?php
			}
							  ?>
						</div><!-- /.table-responsive -->
						</div><!-- /.col -->
					  </div><!-- /.row -->
                      
                  </div>
                  
                  <div class="tab-pane" id="tab_5">
                  
                  		<div class="row">
            		<div class="col-xs-12">
                    <div class="table-responsive">
                    
                    <?php
					$sql = "SELECT a.order_id, a.fname as client_fname, a.lname as client_lname, a.title_topic, a.date, a.total_amount, a.timeframe, b.act_name, a.spacing, a.style, d.fname as writer_fname, d.lname as writer_lname FROM prime_order a, academic_level b, writers_jobs c, writers d where a.writer_level = b.act_level_id and a.order_id = c.order_id and c.writer_id = d.writer_id and a.order_status = 1 and a.complete = 1 and a.site = 'A'";
			$qry = mysqli_query($link,$sql) or die(mysqli_error($link));
			$count_complete = mysqli_num_rows($qry);
			if($count_complete == 0){
				echo "NO ORDER IS COMPLETED";	
			}else{
					?>
                      <table id="example6" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                          	<th>Action</th>
                            <th>Order ID</th>
                            <th>Client</th>
                            <th>Writer</th>
                            <th>Date</th>
                            <th>Title topic</th>
                            <th>Original timeframe</th>
                            <th>Writer academic level</th>
                            <th>Spacing</th>
                            <th>Paper format</th>
                            <th>Total amount</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
			while ($rs = mysqli_fetch_array($qry)) {
				$order_id = $rs['order_id'];
				$client_name = $rs['client_fname']." ".$rs['client_lname'];
				$title_topic = $rs['title_topic'];
				$date = $rs['date'];
				$total_amount = $rs['total_amount'];
				
				$timeframe = $rs['timeframe'];
				$writer_level = $rs['act_name'];
				
				$spacing = $rs['spacing'];
				$style = $rs['style'];
				
				$writer_name = $rs['writer_fname']." ".$rs['writer_lname'];
								?>
								
								  <tr>
                                  	<td><a href="?page=vieworder&orderid=<?php echo $order_id; ?>">View Order</a></td>
									<td><?php echo $order_id; ?></td>
									<td><?php echo $client_name; ?></td>
                                    <td><?php echo $writer_name; ?></td>
									<td><?php echo $date; ?></td>
									<td><?php echo $title_topic; ?></td>
									<td><?php echo $timeframe; ?></td>
									<td><?php echo $writer_level; ?></td>
									<td><?php echo $spacing; ?></td>
									<td><?php echo $style; ?></td>
									<td><?php echo formatMoney($total_amount, true); ?></td>
								  </tr>
								  
								  <?php
			}
								  ?>
								  
								</tbody>
								<tfoot>
								 <tr>
                                 	<th>Action</th>
									<th>Order ID</th>
                                    <th>Client</th>
                                    <th>Writer</th>
                                    <th>Date</th>
                                    <th>Title topic</th>
                                    <th>Original timeframe</th>
                                    <th>Writer academic level</th>
                                    <th>Spacing</th>
                                    <th>Paper format</th>
                                    <th>Total amount</th>
								  </tr>
								</tfoot>
							  </table>
                              <?php
			}
							  ?>
						</div><!-- /.table-responsive -->
						</div><!-- /.col -->
					  </div><!-- /.row -->
                      
                  </div>
                  
                  
                </div>
          </div>
          

        </section><!-- /.content -->