<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Specialities
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-files-o"></i> Home</a></li>
            <li class="active">Specialities</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
        
        <?php
		if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
		echo '
		<div style="margin:0 auto;" class="alert alert-success" align="center">';
		foreach($_SESSION['ERRMSG_ARR'] as $msg) {
		echo '&nbsp;',$msg;
		}
		echo '</div><br>';
		unset($_SESSION['ERRMSG_ARR']);
		}
		else if( isset($_SESSION['ERRMSG_ARR2']) && is_array($_SESSION['ERRMSG_ARR2']) && count($_SESSION['ERRMSG_ARR2']) >0 ) {
		echo '
		<div style="margin:0 auto;" class="alert alert-danger" align="center"><i class="icon-remove-sign"></i>';
		foreach($_SESSION['ERRMSG_ARR2'] as $msg) {
		echo '&nbsp;',$msg;
		}
		echo '</div><br>';
		unset($_SESSION['ERRMSG_ARR2']);
		}
		?>
          <a data-toggle="modal" href="#titleModal" class="btn btn-primary pull-right" style="margin:10px">Add a title</a>
            
            <div class="modal fade" id="titleModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                <form role="form" action="php/register-submit.php" method="post">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Add a title</h4>
                  </div>
                  <div class="modal-body">
                    
                  <div class="box-body" id="title_div">
                  	<div class="form-group">
                      <label for="title">Title</label>
                      <input class="form-control" id="title" name="title" placeholder="Enter title" type="text">
                    </div>
                    
                    <div class="form-group">
                      <label for="speciality">Speciality</label>
                      <select name="speciality" id="speciality" class="form-control">
                      	<option></option>
                        <option value="essay_writer">Essay Writer</option>
                        <option value="technical_writer">Technical Writer</option>
                      </select>
                    </div>
                    
                  </div><!-- /.box-body -->
                  
                  <div class="box-body" id="subtitle_div" style="display:none">
                      <p class="lead">Title: <span id="print_title"></span></p>
                      <div class="form-group">
                          <label for="title">Sub title</label>
                          <input class="form-control" id="sub_title" name="sub_title" placeholder="Enter sub title" type="text">
                          <input type="hidden" name="title_id" id="title_id" />
                      </div>
                      <a onClick="add_subtitle()" class="btn btn-default" id="add_subtitle">Add subtitle</a>
                      <img src="dist/img/loading.gif" id="LoadingImage2" style="display:none" />
                     <ul id="response_subtitle" class="dd-list"></ul>
                  
                  </div>

                </div>
                  <div class="modal-footer" id="title_footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <a onClick="register_title()" class="btn btn-default" id="register_title">Save and add sub titles</a>
                     <img src="dist/img/loading.gif" id="LoadingImage" style="display:none" />
                    <button type="submit" class="btn btn-primary" name="register_title">Save and Close</button>
                  </div>
                  <div class="modal-footer" id="subtitle_footer" style="display:none">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <a onClick="save_subtitles()" class="btn btn-primary" id="register_title">Save and Close</a>
                  </div>
                </form>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div>
                 
          <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li <?php if(!isset($_GET['technical_writer'])){ ?>class="active"<?php } ?>><a aria-expanded="true" href="#tab_1" data-toggle="tab">Essay Writers</a></li>
                  <li <?php if(isset($_GET['technical_writer'])){ ?>class="active"<?php } ?>><a aria-expanded="false" href="#tab_2" data-toggle="tab">Technical Writers</a></li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane<?php if(!isset($_GET['technical_writer'])){ ?> active<?php } ?>" id="tab_1">
                    
                    
                    <div class="row">
            <div class="col-xs-12">
          <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Essay Writers Titles</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Title</th>
                        <th>Sub titles</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
$sql = "SELECT * FROM speciality_titles where speciality = 'essay_writer'";
$qry = mysqli_query($link,$sql) or die(mysqli_error($link));
while ($rs = mysqli_fetch_array($qry)) {
    $title_id = $rs['title_id'];
    $title = $rs['title'];
	
	$subtitles = array();
					$query_subtitles = mysqli_query($link, "select * from speciality_subtitles where title_id = '".$title_id."'") or die(mysqli_error($link));
					while ($row_subtitles = mysqli_fetch_array($query_subtitles)) {
						$subtitles[] = $row_subtitles['sub_title'];
					}
					
					?>
                    
                      <tr>
                        <td><?php echo $title; ?></td>
                        <td><?php echo implode(', ', $subtitles); ?></td>
                      </tr>
                      
                      <?php
}
					  ?>
                      
                    </tbody>
                    <tfoot>
                     <tr>
                        <th>Title</th>
                        <th>Sub titles</th>
                      </tr>
                    </tfoot>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
          
                    
                    
                  </div><!-- /.tab-pane -->
                  <div class="tab-pane<?php if(isset($_GET['technical_writer'])){ ?> active<?php } ?>" id="tab_2">
                    
                    
                    <div class="row">
            <div class="col-xs-12">
          <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Technical Writers Titles</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example2" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Title</th>
                        <th>Sub titles</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
$sql = "SELECT * FROM speciality_titles where speciality = 'technical_writer'";
$qry = mysqli_query($link,$sql) or die(mysqli_error($link));
while ($rs = mysqli_fetch_array($qry)) {
    $title_id = $rs['title_id'];
    $title = $rs['title'];
	
	$subtitles = array();
					$query_subtitles = mysqli_query($link, "select * from speciality_subtitles where title_id = '".$title_id."'") or die(mysqli_error($link));
					while ($row_subtitles = mysqli_fetch_array($query_subtitles)) {
						$subtitles[] = $row_subtitles['sub_title'];
					}
					
					?>
                    
                      <tr>
                        <td><?php echo $title; ?></td>
                        <td><?php echo implode(', ', $subtitles); ?></td>
                      </tr>
                      
                      <?php
}
					  ?>
                      
                    </tbody>
                    <tfoot>
                     <tr>
                        <th>Title</th>
                        <th>Sub titles</th>
                      </tr>
                    </tfoot>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
                    
                    
                  </div><!-- /.tab-pane -->
                  
                </div><!-- /.tab-content -->
              </div>
              
          

        </section><!-- /.content -->
    
<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<script type="application/javascript">
	
	$(function () {
		
		
	});

	function register_title(){
		
		if($("#title").val()==='')
		{
			alert("Please enter title");
			return false;
		}
		if($("#speciality").val()==='')
		{
			alert("Please select speciality");
			return false;
		}
		
		$("#register_title").hide(); //hide submit button
		$("#LoadingImage").show(); //show loading image
		var title = $("#title").val();
		var myData = 'title='+ title +'&speciality='+ $("#speciality").val()+'&register_title=1'; //build a post data structure
		jQuery.ajax({
		type: "POST", // HTTP method POST or GET
		url: "php/response.php", //Where to make Ajax calls
		dataType:"text", // Data type, HTML, json etc.
		data:myData, //Form variables
		success:function(response){
			$("#title_id").val(response);
			$("#print_title").append(title);
			$("#register_title").show(); //show submit button
			$("#LoadingImage").hide(); //hide loading image
			
			$("#title_div").hide(); //show submit button
			$("#subtitle_div").show(); //hide loading image
			
			$("#title_footer").hide(); //show submit button
			$("#subtitle_footer").show(); //hide loading image
			
		},
		error:function (xhr, ajaxOptions, thrownError){
			$("#register_title").show(); //show submit button
			$("#LoadingImage").hide(); //hide loading image
			alert(thrownError);
		}
		});
	}
	
	
	function add_subtitle(){
		
		if($("#sub_title").val()==='')
		{
			alert("Please enter sub title");
			return false;
		}
		
		$("#add_subtitle").hide(); //hide submit button
		$("#LoadingImage2").show(); //show loading image
		var sub_title = $("#sub_title").val();
		var myData = 'sub_title='+ sub_title +'&title_id='+ $("#title_id").val()+'&add_subtitle=1'; //build a post data structure
		jQuery.ajax({
		type: "POST", // HTTP method POST or GET
		url: "php/response.php", //Where to make Ajax calls
		dataType:"text", // Data type, HTML, json etc.
		data:myData, //Form variables
		success:function(response){
			$("#response").prepend(response);
			$("#sub_title").val('');
			$("#add_subtitle").show(); //show submit button
			$("#LoadingImage2").hide(); //hide loading image
			
		},
		error:function (xhr, ajaxOptions, thrownError){
			$("#add_subtitle").show(); //show submit button
			$("#LoadingImage2").hide(); //hide loading image
			alert(thrownError);
		}
		});
	}
	
	function save_subtitles(){
		var speciality = $("#speciality").val();
		window.location.assign("?page=specialities&"+speciality);
	}

</script>
