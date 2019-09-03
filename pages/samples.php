<?php
include("connn.php");
if(isset($_POST['Submit'])){
	echo "hello";
	echo "<br>";
	$title=$_POST['title'];
	$meta_description=$_POST['metadescr'];
	$meta_words=$_POST['words'];
	$description_top=$_POST['top'];
	$description_mid=$_POST['mid'];
	$description_bottom=$_POST['bottom'];
		$sql = "UPDATE blog SET title='$title',meta_description='$meta_description',meta_words='$meta_words',description_top='$description_top',description_bottom='$description_bottom',description_mid='$description_mid' WHERE content_id=1653";

		if (mysqli_query($conn, $sql)) {
			echo "Record updated successfully";
		} else {
			echo "Error updating record: " . mysqli_error($conn);
		}
}
mysqli_close($conn);
?>
<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Samples (content page). 
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-files-o"></i> Home</a></li>
            <li class="active">Content</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
         <form method="post" action="#"> 
          <div class="row">
            <div class="col-xs-12">
          <div class="box">
                <div class="box-header">
                 <h3 class="box-title">You can edit content for the subject page here</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="table-responsive">
                  <form action="php/update_content.php" method="post" name="update_content">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Position</th>
                        <th>Content</th>
                        
                      </tr>
                    </thead>
                    <tbody>
                    <?php
$sql = "SELECT * FROM blog WHERE content_id = 1653";
$qry = mysqli_query($link,$sql) or die(mysqli_error($link));
while ($rs = mysqli_fetch_array($qry)) {
    $content_id = $rs['content_id'];
    $title = $rs['title'];
    $meta_description = $rs['meta_description'];
	$meta_words = $rs['meta_words'];
	$description_top = $rs['description_top'];
	$description_mid = $rs['description_mid'];
	$description_bottom = $rs['description_bottom'];
					?>
                    
                      <tr>
                      
                      
                      <td><?php echo "Content code"; ?></td>
                        
                        <td> <textarea rows="1" cols="10" name="code">
<?php echo $content_id; ?></textarea></td>
                      </tr>
                      </tr>
                      
                        <td><?php echo "Meta Title"; ?></td>
                        
                        <td> <textarea class="ckeditor" rows="1" cols="50" name="title" value="<?php echo $title; ?>">
<?php echo $title; ?></textarea></td>
                        
                        
                        </tr>
                        <tr>
                        <td><?php echo "Meta description"; ?></td>
                        <td> <textarea class="ckeditor" rows="1" cols="50" name="metadescr" value="<?php echo $meta_description; ?>">
<?php echo $meta_description; ?></textarea></td>
                        
                        
                        </tr>
                      <tr>
                        <td><?php echo "Meta Keywords"; ?></td>
                        <td> <textarea class="ckeditor" rows="1" cols="50" name="words" value="<?php echo $meta_words; ?>">
<?php echo $meta_words; ?></textarea></td>
                        
                        </tr>
                        
                        <tr>
                        <td><?php echo "Top content"; ?></td>
                        <td> <textarea class="ckeditor" rows="1" cols="50" name="top" value="<?php echo $description_top; ?>">
<?php echo $description_top; ?></textarea></td>
                        
                        </tr>
                        <tr>
                        <td><?php echo "Mid content"; ?></td>
                        <td> <textarea class="ckeditor" rows="1" cols="50" name="mid" value="<?php echo $description_mid; ?>">
<?php echo $description_mid; ?></textarea></td>
                        
                        </tr>
                        <tr>
                        <td><?php echo "Bottom content"; ?></td>
                        <td> <textarea class="ckeditor" rows="1" cols="50" name="bottom" value="<?php echo $description_bottom; ?>">
<?php echo $description_bottom; ?></textarea></td>
                        
                        </tr>
                      
                      <?php
}
					  ?>
                      
                    </tbody>
                    <tfoot>
                     
                       
                    <td><input value="Save" id="update_content" name="update_content" type="submit"> </td>
                    <td><button class="btn btn-success" name="Submit" type="Submit">Update</button></td>
                        </form>
                      </tr>
                    </tfoot>
                  </table>
                  </div><!-- /.table-responsive -->
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
		  
		</form>
          

        </section><!-- /.content -->
<script src="ckeditor/ckeditor.js"></script>		