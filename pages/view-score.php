<?php
if(isset($_GET["writer_id"])){
$writer_id = $_GET["writer_id"];
$sql = "SELECT * FROM writers where writer_id = '".$writer_id."'";
$qry = mysqli_query($link,$sql) or die(mysqli_error($link));
$rs = mysqli_fetch_array($qry);
$fname = $rs['fname'];
$lname = $rs['lname'];
$speciality = $rs['speciality'];

$qry_totalmarks = mysqli_query($link,"select sum(marks) as total_marks from test_questions where test_type = 'language_check' and essay = 0") or die(mysqli_error($link));
					$rs_totalmarks = mysqli_fetch_array($qry_totalmarks);
					$total_marks = $rs_totalmarks['total_marks'];
					
					$qry_totalmarks2 = mysqli_query($link,"select sum(marks) as total_marks from test_questions where test_type = 'speciality_check' and speciality = '".$speciality."'") or die(mysqli_error($link));
					$rs_totalmarks2 = mysqli_fetch_array($qry_totalmarks2);
					$total_marks2 = $rs_totalmarks2['total_marks'];
					
					
					$qry_marks = mysqli_query($link,"select sum(marks) as total_marks from writer_answers a, test_questions b where a.test_id = b.test_id and a.status = 1 and a.writer_id = '".$writer_id."' and b.test_type = 'language_check'") or die(mysqli_error($link));
					$rs_marks = mysqli_fetch_array($qry_marks);
					if($rs_marks['total_marks'] == NULL){
						$marks = 0;
					}else{
						$marks = $rs_marks['total_marks'];
					}
					
					$qry_marks2 = mysqli_query($link,"select sum(marks) as total_marks from writer_answers a, test_questions b where a.test_id = b.test_id and a.status = 1 and a.writer_id = '".$writer_id."' and b.test_type = 'speciality_check' and speciality = '".$speciality."'") or die(mysqli_error($link));
					$rs_marks2 = mysqli_fetch_array($qry_marks2);
					if($rs_marks2['total_marks'] == NULL){
						$marks2 = 0;
					}else{
						$marks2 = $rs_marks2['total_marks'];
					}
					
					$total = $marks + $marks2;
					$grand_total = $total_marks + $total_marks2;
?>
<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php echo $fname." ".$lname; ?> Test score sheet
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-files-o"></i> Home</a></li>
            <li class="active">View Score</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          
          <div class="row">
            <div class="col-xs-12">
          <div class="box">
                
                <div class="box-body">
                
                 
                 <table class="table table-striped">
                    <thead>
                    	<tr>
                        	<th></th>
                            <th>Marks</th>
                            <th>Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <td>Language Check</td>
                        <td><?php echo $marks."/".$total_marks; ?></td>
                        <td><?php echo number_format((float)($marks/$total_marks*100), 2, '.', '');	?>%</td>
                        </tr>
                        
                        <tr>
                        <td>Essay</td>
                        <td>Pending</td>
                        <td></td>
                        </tr>
                        
                        <tr>
                        <td>Speciality Check</td>
                        <td><?php echo $marks2."/".$total_marks2; ?></td>
                        <td><?php echo number_format((float)($marks2/$total_marks2*100), 2, '.', '');	?>%</td>
                        </tr>
                        
                        <tr>
                        <th>Total</th>
                        <th><?php echo $total."/".$grand_total; ?></th>
                        <th><?php echo number_format((float)($total/$grand_total*100), 2, '.', ''); ?>%</th>
                        </tr>
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