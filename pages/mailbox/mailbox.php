
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Mailbox
        <small id="count_unread_1"></small>
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
              <h3 class="box-title">Inbox</h3>

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
                <!-- Check all button -->
                
                <div class="btn-group">
                  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
                  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
                  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
                </div>
                <!-- /.btn-group -->
                <button type="button" class="btn btn-default btn-sm" onclick="refreshMailbox()"><i class="fa fa-refresh"></i></button>
                
              </div>
              <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped">
                  <tbody id="inbox_table">
                      
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
                <button type="button" class="btn btn-default btn-sm" onclick="refreshMailbox()"><i class="fa fa-refresh"></i></button>
                
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
	fetchInbox();
});

function refreshMailbox(){
	fetchUnread();
	fetchInbox();
}
function fetchInbox(){
	var table = $("#inbox_table");
	var tbl = "";
	table.empty();
	table.prepend($("<tr><td colspan='4' class='information'>LOADING ...</td></tr>"));
	
	$.ajax({
		url: "php/response.php",
		data: {
			'tag': 'fetch-inbox'
		},
		dataType: 'json',
		success: function(json) {
			table.empty();
			if(json.success == 1) {
				if(json.inbox.length == 0) {
					table.append('<tr><td colspan="4" class="information">No records found</td></tr>');
				} else {
					for(var i = 0; i < json.inbox.length; i++) {
						var email_id = json.inbox[i].email_id;
						var subject = json.inbox[i].subject;
						var message = json.inbox[i].message;
						var sent_on = json.inbox[i].sent_on;
						var sender_name = json.inbox[i].sender_name;
						var read_status = json.inbox[i].read_status;
						var count_unread = json.inbox[i].count_unread;
						
						tbl += '<tr>\
									<td><input type="checkbox" id="chk_'+email_id+'"></td>\
									<td class="mailbox-name"><a href="index.php?page=preview&email_id='+email_id+'&read_status='+read_status+'">'+sender_name+'</a></td>';
						
						if(read_status == '0'){
							tbl += '<td class="mailbox-subject"><b>'+subject+'</b> - '+message+'</td>';
						}else{
							tbl += '<td class="mailbox-subject">'+subject+' - '+message+'</td>';
						}
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