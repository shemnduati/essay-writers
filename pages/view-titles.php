<?php
if(isset($_GET["writer_id"])){
$writer_id = $_GET["writer_id"];
$query=mysqli_query($link,"SELECT * FROM writers WHERE writer_id='".$writer_id."'");
$data_writer=mysqli_fetch_array($query);
	
?>
<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            WRITER: <?php echo $data_writer['fname']." ".$data_writer['lname']; ?>; SPECIALITY: <?php echo $data_writer['speciality'];?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-files-o"></i> Writers</a></li>
            <li class="active">View speciality titles</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          
          <div class="row">
            <div class="col-xs-12">
          <div class="box">
                <div class="box-header">
                  <h3 class="box-title">View speciality titles</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                
                 
                 <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Title</th>
                        <th>Sub title</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
$sql = "SELECT * FROM writers_specialities where writer_id = '".$writer_id."'";
$qry = mysqli_query($link,$sql) or die(mysqli_error($link));
while ($rs = mysqli_fetch_array($qry)) {
    $title = $rs['title'];
	$sub_title = $rs['sub_title'];
					?>
                    
                      <tr>
                        <td><?php echo $title; ?></td>
                        <td><?php echo $sub_title; ?></td>
                      </tr>
                      
                      <?php
}
					  ?>
                      
                    </tbody>
                    <tfoot>
                     <tr>
                        <th>Title</th>
                        <th>Sub title</th>
                      </tr>
                    </tfoot>
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