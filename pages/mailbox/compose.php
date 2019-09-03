
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
          <a href="index.php?page=email" class="btn btn-primary btn-block margin-bottom">Back to Inbox</a>

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
              <h3 class="box-title">Compose New Message</h3>
            </div>
            <!-- /.box-header -->
            
            <form action="php/register-submit.php" method="POST">
            
            <div class="box-body">
              <div class="form-group">
                <label>To: <input type="radio" name="sent_to" value="writer" onclick="searchWriter()" />&nbsp;Writer</label>&nbsp;<img src="dist/img/loading.gif" id="LoadingImage_writer" style="display:none" />&nbsp;
                <label><input type="radio" name="sent_to" value="client_a" onclick="searchClient_A()" />&nbsp;Site A Client</label>&nbsp;<img src="dist/img/loading.gif" id="LoadingImage_client_a" style="display:none" />&nbsp;
                <label><input type="radio" name="sent_to" value="client_b" onclick="searchClient_B()" />&nbsp;Site B Client</label>&nbsp;<img src="dist/img/loading.gif" id="LoadingImage_client_b" style="display:none" />&nbsp;
                <label><input type="radio" name="sent_to" value="client_c" onclick="searchClient_C()" />&nbsp;Site C Client</label>&nbsp;<img src="dist/img/loading.gif" id="LoadingImage_client_c" style="display:none" />
                
                <select id="sent_to_id" name="sent_to_id[]" class="form-control select2" multiple="multiple" data-placeholder="Select a Recipient" style="width: 100%;" disabled="disabled" required></select>
              </div>
              <div class="form-group">
                <input class="form-control" name="subject" placeholder="Subject:" required>
              </div>
              <div class="form-group">
                    <textarea id="compose-textarea" name="message" class="form-control" style="height: 200px" required></textarea>
              </div>
              
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <div class="pull-right">
                <button type="submit" name="send_email" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Send</button>
              </div>
            </div>
            <!-- /.box-footer -->
            
            </form>
            
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

function searchClient_A(){
	$("#LoadingImage_client_a").show(); //show loading image
	var dropdown = document.getElementById("sent_to_id");
	// send information to server
	$.ajax({
		url: "php/response.php",
		data: {
			'tag': 'fetch-recipient',
			'sent_to': 'client_a'
		},
		dataType: 'json',
		success: function(json) {
			$("#sent_to_id").empty();
			if(json.success == 1) {
				if(json.clients.length == 0) {
					addOption(dropdown, 'No client found', '');
				} else {
					addOption(dropdown, '', '');
					addOption(dropdown, 'All Site A Clients', '0');
									
					for(var i = 0; i < json.clients.length; i++) {
						var client_id = json.clients[i].client_id;
						var client_name = json.clients[i].client_name;
						addOption(dropdown, client_name, client_id);
					}
				} 
			} else {
				alert(json.message);
			}
			document.getElementById("sent_to_id").disabled=false;
			$("#LoadingImage_client_a").hide(); //hide loading image
		},
		error: function(error) {
			alert("Unable to list site a clients: "+JSON.stringify(error));
			$("#LoadingImage_client_a").hide(); //hide loading image
		}
	});
}

function searchClient_B(){
	$("#LoadingImage_client_b").show(); //show loading image
	var dropdown = document.getElementById("sent_to_id");
	// send information to server
	$.ajax({
		url: "php/response.php",
		data: {
			'tag': 'fetch-recipient',
			'sent_to': 'client_b'
		},
		dataType: 'json',
		success: function(json) {
			$("#sent_to_id").empty();
			if(json.success == 1) {
				if(json.clients.length == 0) {
					addOption(dropdown, 'No client found', '');
				} else {
					addOption(dropdown, '', '');
					addOption(dropdown, 'All Site B Clients', '0');
									
					for(var i = 0; i < json.clients.length; i++) {
						var client_id = json.clients[i].client_id;
						var client_name = json.clients[i].client_name;
						addOption(dropdown, client_name, client_id);
					}
				} 
			} else {
				alert(json.message);
			}
			document.getElementById("sent_to_id").disabled=false;
			$("#LoadingImage_client_b").hide(); //hide loading image
		},
		error: function(error) {
			alert("Unable to list site b clients: "+JSON.stringify(error));
			$("#LoadingImage_client_b").hide(); //hide loading image
		}
	});
}

function searchClient_C(){
	$("#LoadingImage_client_c").show(); //show loading image
	var dropdown = document.getElementById("sent_to_id");
	// send information to server
	$.ajax({
		url: "php/response.php",
		data: {
			'tag': 'fetch-recipient',
			'sent_to': 'client_c'
		},
		dataType: 'json',
		success: function(json) {
			$("#sent_to_id").empty();
			if(json.success == 1) {
				if(json.clients.length == 0) {
					addOption(dropdown, 'No client found', '');
				} else {
					addOption(dropdown, '', '');
					addOption(dropdown, 'All Site C Clients', '0');
									
					for(var i = 0; i < json.clients.length; i++) {
						var client_id = json.clients[i].client_id;
						var client_name = json.clients[i].client_name;
						addOption(dropdown, client_name, client_id);
					}
				} 
			} else {
				alert(json.message);
			}
			document.getElementById("sent_to_id").disabled=false;
			$("#LoadingImage_client_c").hide(); //hide loading image
		},
		error: function(error) {
			alert("Unable to list site c clients: "+JSON.stringify(error));
			$("#LoadingImage_client_c").hide(); //hide loading image
		}
	});
}

function searchWriter(){
	$("#LoadingImage_writer").show(); //show loading image
	var dropdown = document.getElementById("sent_to_id");
	// send information to server
	$.ajax({
		url: "php/response.php",
		data: {
			'tag': 'fetch-recipient',
			'sent_to': 'writer'
		},
		dataType: 'json',
		success: function(json) {
			$("#sent_to_id").empty();
			if(json.success == 1) {
				if(json.writers.length == 0) {
					addOption(dropdown, 'No writer found', '');
				} else {
					addOption(dropdown, '', '');
					addOption(dropdown, 'All Writers', '0');
									
					for(var i = 0; i < json.writers.length; i++) {
						var writer_id = json.writers[i].writer_id;
						var writer_name = json.writers[i].writer_name;
						addOption(dropdown, writer_name, writer_id);
					}
				} 
			} else {
				alert(json.message);
			}
			document.getElementById("sent_to_id").disabled=false;
			$("#LoadingImage_writer").hide(); //hide loading image
		},
		error: function(error) {
			alert("Unable to list writers: "+JSON.stringify(error));
			$("#LoadingImage_writer").hide(); //hide loading image
		}
	});
}

addOption = function(selectbox, text, value) {
    var optn = document.createElement("OPTION");
    optn.text = text;
    optn.value = value;
    selectbox.options.add(optn);  
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