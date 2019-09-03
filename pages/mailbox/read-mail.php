<?php
$sql = "SELECT * FROM email where email_id = '".$_GET['email_id']."'";
$qry = mysqli_query($link,$sql) or die(mysqli_error($link));
$rs = mysqli_fetch_array($qry);
$subject = $rs['subject'];
$message = $rs['message'];
$sent_on = $rs['sent_on'];
$sent_by_email = $rs['sent_by_email'];
$sent_by = $rs['sent_by'];
$sent_by_id = $rs['sent_by_id'];
	
$sent_to_name = array();
$sql_recep = "SELECT * FROM email_recepients WHERE email_id = '".$_GET['email_id']."'";
$qry_recep = mysqli_query($link,$sql_recep) or die(mysqli_error($link));
$count = mysqli_num_rows($qry_recep);
while($rs_recep = mysqli_fetch_array($qry_recep)){
	$sent_to = $rs_recep['sent_to'];
	$sent_to_id = $rs_recep['sent_to_id'];
	
	if($sent_to == 'writer'){
		$sql_name = "SELECT * FROM writers WHERE writer_id = '".$sent_to_id."'";
		$qry_name = mysqli_query($link,$sql_name) or die(mysqli_error($link));
		$rs_name = mysqli_fetch_array($qry_name);
		$sent_to_name[] = $rs_name['fname']." ".$rs_name['lname'];
	}else if($sent_to == 'client'){
		$sql_name = "SELECT * FROM prime_signup WHERE reg_id = '".$sent_to_id."'";
		$qry_name = mysqli_query($link,$sql_name) or die(mysqli_error($link));
		$rs_name = mysqli_fetch_array($qry_name);
		$sent_to_name[] = $rs_name['fname']." ".$rs_name['lname'];
	}else{
		$sql_name = "SELECT * FROM admin_login WHERE id = '".$sent_to_id."'";
		$qry_name = mysqli_query($link,$sql_name) or die(mysqli_error($link));
		$rs_name = mysqli_fetch_array($qry_name);
		$sent_to_name[] = $rs_name['fname']." ".$rs_name['sname']." (Admin ".$rs_name['admin_type'].")";
	}
}

$sent_to_names = implode(', ', $sent_to_name);

if($sent_by == 'client'){
	$sql_name = "SELECT * FROM prime_signup WHERE reg_id = '".$sent_by_id."'";
	$qry_name = mysqli_query($link,$sql_name) or die(mysqli_error($link));
	$rs_name = mysqli_fetch_array($qry_name);
	$sender_name = $rs_name['fname']." ".$rs_name['lname']." (Client)";
}else if($sent_by == 'writer'){
	$sql_name = "SELECT * FROM writers WHERE writer_id = '".$sent_by_id."'";
	$qry_name = mysqli_query($link,$sql_name) or die(mysqli_error($link));
	$rs_name = mysqli_fetch_array($qry_name);
	$sender_name = $rs_name['fname']." ".$rs_name['lname']." (Writer)";
}else{
	$sql_name = "SELECT * FROM admin_login WHERE id = '".$sent_by_id."'";
	$qry_name = mysqli_query($link,$sql_name) or die(mysqli_error($link));
	$rs_name = mysqli_fetch_array($qry_name);
	$sender_name = $rs_name['fname']." ".$rs_name['sname']." (Admin ".$rs_name['admin_type'].")";
}	
	
if(isset($_GET['read_status'])){
	if($_GET['read_status'] == 0){
		mysqli_query($link,"UPDATE email_recepients SET read_status = 1 WHERE email_id = '".$_GET['email_id']."' AND sent_to_id = '".$session_id."'");
	}
}
?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Read Mail
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Mailbox</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3">
          <a href="index.php?page=compose" class="btn btn-primary btn-block margin-bottom">Compose</a>

          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Folders</h3>

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body no-padding">
              <ul class="nav nav-pills nav-stacked">
                <li><a href="index.php?page=email"><i class="fa fa-inbox"></i> Inbox
                  <span class="label label-primary pull-right" id="count_unread"></span></a></li>
                <li><a href="index.php?page=sent-mail"><i class="fa fa-envelope-o"></i> Sent</a></li>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /. box -->
          
          
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Read Mail</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="mailbox-read-info">
                <h3 id="subject"><?php echo $subject; ?></h3>
                <table style="width:100%">
                    <tr>
                    	<td><h5>From: </h5></td>
                        <td><h5><?php echo $sender_name." < ".$sent_by_email." >"; ?></h5></td><td class="pull-right"><?php echo $sent_on; ?></td>
                    </tr>
                      
                    <tr>
                    	<td><h5>To: </h5></td>
                        <td colspan="2"><h5><span id="sent_by_email"><?php echo $sent_to_names; ?></span></h5></td>
                    </tr>
                </table>
              </div>
              <!-- /.mailbox-read-info -->
              
              <!-- /.mailbox-controls -->
              <div class="form-group">
                    <textarea id="compose-textarea" name="message" class="form-control" style="height: 330px" readonly="readonly"><?php echo $message; ?></textarea>
              </div>
              <!-- /.mailbox-read-message -->
            </div>
            <!-- /.box-body -->
            
            <div class="box-footer">
              
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
    
<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<script>
$(function () {
	fetchUnread();
});

function fetchUnread(){
	$.ajax({
		url: "php/response.php",
		data: {
			'tag': 'fetch-unread'
		},
		dataType: 'json',
		success: function(json) {
			if(json.success == 1) {
				$("#count_unread").html(json.count_unread);
				if(json.count_unread > 0){
					if(json.count_unread > 1){
						$("#count_unread_1").html(json.count_unread+" new messages");
					}else{
						$("#count_unread_1").html(json.count_unread+" new message");
					}
				}
			} else {
				alert(json.message);
			}
		},
		error: function(error) {
			alert(JSON.stringify(error));
		}
	});
}
</script>