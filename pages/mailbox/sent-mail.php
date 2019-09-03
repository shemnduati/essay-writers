
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sent
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Sent</li>
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
        
         <?php
if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
echo '
<div style="margin:0 auto;" class="alert alert-success fade in" align="center">';
foreach($_SESSION['ERRMSG_ARR'] as $msg) {
echo '&nbsp;',$msg;
}
echo '</div><br />';
unset($_SESSION['ERRMSG_ARR']);
}
else if( isset($_SESSION['ERRMSG_ARR2']) && is_array($_SESSION['ERRMSG_ARR2']) && count($_SESSION['ERRMSG_ARR2']) >0 ) {
echo '
<div style="margin:0 auto;" class="alert alert-danger fade in" align="center"><i class="icon-remove-sign"></i>';
foreach($_SESSION['ERRMSG_ARR2'] as $msg) {
echo '&nbsp;',$msg;
}
echo '</div><br />';
unset($_SESSION['ERRMSG_ARR2']);
}
?>

          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Sent</h3>

              <div class="box-tools pull-right">
                <div class="has-feedback">
                  <input type="text" class="form-control input-sm" placeholder="Search Mail">
                  <span class="glyphicon glyphicon-search form-control-feedback"></span>
                </div>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="mailbox-controls">
                <div class="btn-group">
                  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
                  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
                  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
                </div>
                <!-- /.btn-group -->
                <button type="button" class="btn btn-default btn-sm" onclick="fetchSentMail()"><i class="fa fa-refresh"></i></button>
                
              </div>
              <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped">
                  <tbody id="sent_table">
                      
                  </tbody>
                </table>
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer no-padding">
              <div class="mailbox-controls">
                <div class="btn-group">
                  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
                  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
                  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
                </div>
                <!-- /.btn-group -->
                <button type="button" class="btn btn-default btn-sm" onclick="fetchSentMail()"><i class="fa fa-refresh"></i></button>
                
              </div>
            </div>
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
	fetchSentMail();
});
			
function fetchSentMail(){
	var table = $("#sent_table");
	var tbl = "";
	table.empty();
	table.prepend($("<tr><td colspan='4' class='information'>LOADING ...</td></tr>"));
	
	$.ajax({
		url: "php/response.php",
		data: {
			'tag': 'fetch-sent'
		},
		dataType: 'json',
		success: function(json) {
			table.empty();
			if(json.success == 1) {
				if(json.sent.length == 0) {
					table.append('<tr><td colspan="4" class="information">No records found</td></tr>');
				} else {
					for(var i = 0; i < json.sent.length; i++) {
						var email_id = json.sent[i].email_id;
						var subject = json.sent[i].subject;
						var message = json.sent[i].message;
						var sent_on = json.sent[i].sent_on;
						var sent_to_name = json.sent[i].sent_to_name;
						
						tbl += '<tr>\
									<td><input type="checkbox" id="chk_'+email_id+'"></td>\
									<td class="mailbox-name"><a href="index.php?page=preview&email_id='+email_id+'">'+sent_to_name+'</a></td>';
						tbl += '<td class="mailbox-subject">'+subject+' - '+message+'.</td>';
						tbl += '<td class="mailbox-date">'+sent_on+'</td>\
								  </tr>';
										
						table.append($(tbl));				
						tbl = '';
							
					}	
				}

						
			} else {
				table.append("<tr><td colspan='4' class='error'>"+json.message+"</td></tr>");
				
			}
		},
		error: function(error) {
			table.empty();
			table.append($("<tr><td colspan='4' class='error'>"+JSON.stringify(error)+"</td></tr>"));
		}
	});
}

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