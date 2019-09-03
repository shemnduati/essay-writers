<?php include("php/session.php"); 

$query = mysqli_query($link,"select * from admin_login where id='$session_id'")or die(mysqli_error($link));
$row=  mysqli_fetch_array($query);

$name = $row['fname'] . " " . $row['sname'];
$result2 = mysqli_query($link,"SELECT * FROM pic_user WHERE user_id = '$session_id'");

$row2 = mysqli_fetch_array($result2);
$ploc = substr($row2['ploc'], 3);
$count_pic = mysqli_num_rows($result2);

function formatMoney($number, $fractional=false) {
						if ($fractional) {
							$number = sprintf('%.2f', $number);
						}
						while (true) {
							$replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
							if ($replaced != $number) {
								$number = $replaced;
							} else {
								break;
							}
						}
						return $number;
					}
					
					
if((isset($_GET['page']))){
			if(($_GET['page']=='dashboard')){
				$page = 'dashboard';
				$subpage = '';
			}
			if(($_GET['page']=='orders')){
				$page = 'orders';
				if(($_GET['subpage']=='orders-site-a')){
					$subpage = 'orders-site-a';
				}
				if(($_GET['subpage']=='orders-site-b')){
					$subpage = 'orders-site-b';
				}
				if(($_GET['subpage']=='orders-site-c')){
					$subpage = 'orders-site-c';
				}
			}
			if(($_GET['page']=='earnings')){
			    $page = 'earnings';
				$subpage = '';
			}
			if(($_GET['page']=='earnings-writer')){
			    $page = 'earnings-writer';
				$subpage = '';
			}
			if(($_GET['page']=='clients')){
				$page = 'clients';
				if(($_GET['subpage']=='clients-site-a')){
					$subpage = 'clients-site-a';
				}
				if(($_GET['subpage']=='clients-site-b')){
					$subpage = 'clients-site-b';
				}
				if(($_GET['subpage']=='clients-site-c')){
					$subpage = 'clients-site-c';
				}
			}
			if(($_GET['page']=='writers')){
				$page = 'writers';
				$subpage = '';
			}
			if(($_GET['page']=='email')){
				$page = 'email';
				$subpage = '';
			}
			if(($_GET['page']=='sent-mail')){
				$page = 'sent-mail';
				$subpage = '';
			}
			if(($_GET['page']=='compose')){
				$page = 'compose';
				$subpage = '';
			}
			if(($_GET['page']=='preview')){
				$page = 'preview';
				$subpage = '';
			}
			if(($_GET['page']=='viewscore')){
				$page = 'writers';
				$subpage = '';
			}
			if(($_GET['page']=='vieworder')){
				$page = 'vieworder';
				$subpage = '';
			}
			if(($_GET['page']=='viewbids')){
			    $page = 'viewbids';
				$subpage = '';
			}
			if(($_GET['page']=='viewrequests')){
			    $page = 'viewrequests';
				$subpage = '';
			}
			if(($_GET['page']=='viewtitles')){
				$page = 'viewtitles';
				$subpage = '';
			}
			if(($_GET['page']=='specialities')){
				$page = 'specialities';
				$subpage = '';
			}
			if(($_GET['page']=='viewsubtitles')){
				$page = 'viewsubtitles';
				$subpage = '';
			}
			if(($_GET['page']=='questions')){
				$page = 'questions';
				$subpage = '';
			}
			if(($_GET['page']=='settings')){
				$page = 'settings';
				if(($_GET['subpage']=='users')){
					$subpage = 'users';
				}
				if(($_GET['subpage']=='payment_setting')){
					$subpage = 'payment_setting';
				}
				if(($_GET['subpage']=='payment_threshold')){
					$subpage = 'payment_threshold';
				}
				if(($_GET['subpage']=='default_percentage')){
					$subpage = 'default_percentage';
				}
			}
		}else{
			$page = 'dashboard';
			$subpage = '';
		}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>writingSite | Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <link rel="stylesheet" type="text/css" media="screen" href="dist/css/font-awesome.min.css">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
    
    <link rel="stylesheet" href="dist/css/style.css">
	
    <link rel="stylesheet" href="plugins/select2/select2.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
		.dd-list {
			list-style: outside none none;
		}
		.dd-empty, .dd-item, .dd-placeholder {
			display: block;
			position: relative;
			margin: 0px;
			padding: 0px;
			min-height: 20px;
			font-size: 13px;
			line-height: 20px;
		}
		.dd-handle:hover, .dd-handle:hover + .dd-list .dd-handle {
			background: #FDDFB3 none repeat scroll 0% 0% !important;
			border: 1px solid #FAA937;
			color: #333 !important;
		}
		.dd-handle {
			display: block;
			font-size: 15px;
			margin: 5px 0px;
			padding: 7px 15px;
			color: #333;
			text-decoration: none;
			border: 1px solid #CFCFCF;
			background: #FBFBFB none repeat scroll 0% 0%;
		}
		table { white-space: nowrap; }

               .dropdown {
                        background:#acde;
               		color:#fff;
               		height:4%;
               		text-decoration:none;
               		padding:7px 10px;
               		margin-top:2%;
               		text-align:center;
                         }
               .dropdown:hover{
  		background:#122377;
                color:#fff; 
               	height:6%;
		}
    .o{##########}
	#editor{
		overflow:scroll;
		max-height:300px;
	}
    		/* The side navigation menu */
.sidenav {
    height: 100%;
    width: 0; 
    position: fixed; 
    z-index: 1;
    top: 0;
    left: 0;
    background-color: #111; 
    overflow-x: hidden; 
    padding-top: 60px; 
    transition: 0.5s; 
}

/* The navigation menu links */
.sidenav a {
    padding: 8px 8px 8px 32px;
    text-decoration: none;
    font-size: 14px;
    color: #818181;
    display: block;
    transition: 0.3s
}


.sidenav a:hover, .offcanvas a:focus{
    color: #f1f1f1;
}


.sidenav .closebtn {
    position: absolute;
    top: 0;
    right: 25px;
    font-size: 25px;
    margin-left: 50px;
}


#main {
    transition: margin-left .5s;
    padding: 20px;
}

@media screen and (max-height: 450px) {
    .sidenav {padding-top: 10px;}
    .sidenav a {font-size: 14px;}
}
    .o{#######}   
	</style>
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <header class="main-header">
       <?php include("include/header.php"); ?>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          
          <?php include("include/user-panel.php"); ?>
          
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <?php include("include/menu.php"); ?>
          
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
      
      	<?php 
		if((isset($_GET['page']))){
			if(($_GET['page']=='dashboard')){
				$page = 'dashboard';
				include("pages/dashboard.php");
			}
			if(($_GET['page']=='orders')){
				$page = 'orders';
				if(($_GET['subpage']=='orders-site-a')){
					$subpage = 'orders-site-a';
					include("pages/orders-site-a.php");
				}
				if(($_GET['subpage']=='orders-site-b')){
					$subpage = 'orders-site-b';
					include("pages/orders-site-b.php");
				}
				if(($_GET['subpage']=='orders-site-c')){
					$subpage = 'orders-site-c';
					include("pages/orders-site-c.php");
				}
			}
			if(($_GET['page']=='earnings')){
			    $page = 'earnings';
				include("pages/earnings.php");
			}
			if(($_GET['page']=='earnings-writer')){
			    $page = 'earnings-writer';
				include("pages/earnings-writer.php");
			}
			if(($_GET['page']=='clients')){
				$page = 'clients';
				if(($_GET['subpage']=='clients-site-a')){
					$subpage = 'clients-site-a';
					include("pages/clients-site-a.php");
				}
				if(($_GET['subpage']=='clients-site-b')){
					$subpage = 'clients-site-b';
					include("pages/clients-site-b.php");
				}
				if(($_GET['subpage']=='clients-site-c')){
					$subpage = 'clients-site-c';
					include("pages/clients-site-c.php");
				}
				
				
				
				
			}
			if(($_GET['page']=='writers')){
				$page = 'writers';
				include("pages/writers.php");
			}
			if(($_GET['page']=='email')){
				$page = 'email';
				include("pages/mailbox/mailbox.php");
			}
			if(($_GET['page']=='sent-mail')){
				$page = 'sent-mail';
				include("pages/mailbox/sent-mail.php");
			}
			if(($_GET['page']=='compose')){
				$page = 'compose';
				include("pages/mailbox/compose.php");
			}
			if(($_GET['page']=='preview')){
				$page = 'preview';
				include("pages/mailbox/read-mail.php");
			}
			if(($_GET['page']=='viewscore')){
				$page = 'writers';
				include("pages/view-score.php");
			}
			if(($_GET['page']=='vieworder')){
				$page = 'vieworder';
				include("pages/view-order.php");
			}
			if(($_GET['page']=='viewbids')){
				$page = 'viewbids';
				include("pages/view-bids.php");
			}
			if(($_GET['page']=='viewrequests')){
				$page = 'viewrequests';
				include("pages/view-requests.php");
			}
			if(($_GET['page']=='viewtitles')){
				$page = 'viewtitles';
				include("pages/view-titles.php");
			}
			if(($_GET['page']=='specialities')){
				$page = 'specialities';
				include("pages/specialities.php");
			}
			if(($_GET['page']=='viewsubtitles')){
				$page = 'viewsubtitles';
				include("pages/view-subtitles.php");
			}
			if(($_GET['page']=='questions')){
				$page = 'questions';
				include("pages/questions.php");
			}
			if(($_GET['page']=='settings')){
				$page = 'settings';
				if(($_GET['subpage']=='users')){
					$subpage = 'users';
					include("pages/users.php");
				}
				if(($_GET['subpage']=='payment_setting')){
					$subpage = 'payment_setting';
					include("pages/payment-settings.php");
				}
				if(($_GET['subpage']=='payment_threshold')){
					$subpage = 'payment_threshold';
					include("pages/earnings-threshold.php");
				}
				if(($_GET['subpage']=='default_percentage')){
					$subpage = 'default_percentage';
					include("pages/default-percentage.php");
				}
				
			}
			if(($_GET['page']=='content')){
				$page = 'content';
				if(($_GET['subpage']=='home')){
					$subpage = 'home';
					include("pages/home.php");
				}
				if(($_GET['subpage']=='home2')){
					$subpage = 'home2';
					include("pages/home2.php");
				}
				if(($_GET['subpage']=='about_us')){
					$subpage = 'about_us';
					include("pages/about_us.php");
				}
				if(($_GET['subpage']=='about_us2')){
					$subpage = 'about_us2';
					include("pages/about_us2.php");
				}
				if(($_GET['subpage']=='contact_us')){
					$subpage = 'contant_us';
					include("pages/contact_us.php");
				}
				if(($_GET['subpage']=='contact_us2')){
					$subpage = 'contant_us2';
					include("pages/contact_us2.php");
				}
				if(($_GET['subpage']=='our_services')){
					$subpage = 'our_services';
					include("pages/our_services.php");
				}
				if(($_GET['subpage']=='our_services2')){
					$subpage = 'our_services2';
					include("pages/our_services2.php");
				}
				if(($_GET['subpage']=='pricing')){
					$subpage = 'pricing';
					include("pages/pricing.php");
				}
				if(($_GET['subpage']=='pricing2')){
					$subpage = 'pricing2';
					include("pages/pricing2.php");
				}
				if(($_GET['subpage']=='our_writers')){
					$subpage = 'our_writers';
					include("pages/our_writers.php");
				}
				if(($_GET['subpage']=='our_writers2')){
					$subpage = 'our_writers2';
					include("pages/our_writers2.php");
				}
				if(($_GET['subpage']=='guarantees')){
					$subpage = 'guarantees';
					include("pages/guarantees.php");
				}
				if(($_GET['subpage']=='guarantees2')){
					$subpage = 'guarantees2';
					include("pages/guarantees2.php");
				}
				if(($_GET['subpage']=='faq')){
					$subpage = 'faq';
					include("pages/faq.php");
				}
				if(($_GET['subpage']=='faq2')){
					$subpage = 'faq2';
					include("pages/faq2.php");
				}
				if(($_GET['subpage']=='testimonials')){
					$subpage = 'testimonials';
					include("pages/testimonials.php");
				}
				if(($_GET['subpage']=='testimonials2')){
					$subpage = 'testimonials2';
					include("pages/testimonials2.php");
				}
				if(($_GET['subpage']=='samples')){
					$subpage = 'samples';
					include("pages/samples.php");
				}
				if(($_GET['subpage']=='samples2')){
					$subpage = 'samples2';
					include("pages/samples2.php");
				}
				
				
			}
		}else{
			$page = 'dashboard';
			include("pages/dashboard.php"); 
		}
		
		?>
        <div style="background:#fff; margin-left:35px;" class="row">
			<img class="img-thumbnail" src="cancelled_orders.php" width="30%" height="30%" style="float:left; margin-top:35px;"/>
			<img class="img-thumbnail" src="writersgraph.php" width="30%" height="40%"style="float:right; margin-top:35px;"/>
			
		</div>
		<div style="background:#fff;margin-left:35px;" class="row jumbotron">
		<img class="img-thumbnail" src="users_countrygraph.php" width="50%" height="50%"/>
		</div>
		
      </div><!-- /.content-wrapper -->
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 1.0
        </div>
        <strong>Copyright &copy; 2016 <a href="http://stretchgo.com">StretchGO</a>.</strong> All rights reserved.
      </footer>

      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
          <!-- Home tab content -->
          <div class="tab-pane" id="control-sidebar-home-tab">
            

          </div><!-- /.tab-pane -->
          <!-- Stats tab content -->
          <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div><!-- /.tab-pane -->
          <!-- Settings tab content -->
          <div class="tab-pane" id="control-sidebar-settings-tab">
            
          </div><!-- /.tab-pane -->
        </div>
      </aside><!-- /.control-sidebar -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    
    <script src="plugins/select2/select2.full.min.js"></script>
    <!-- page script -->
    <script>
      $(function () {
		//Initialize Select2 Elements
   		$(".select2").select2();
	
        $("#example1").DataTable();
		
        $('#example2').DataTable();
		
		$('#example3').DataTable();
		
		$('#example4').DataTable();
		
		$('#example5').DataTable();
		
		$('#example6').DataTable();
		
		$("#language_time").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
			if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
				 // Allow: Ctrl+A
				(e.keyCode == 65 && e.ctrlKey === true) ||
				 // Allow: Ctrl+C
				(e.keyCode == 67 && e.ctrlKey === true) ||
				 // Allow: Ctrl+X
				(e.keyCode == 88 && e.ctrlKey === true) ||
				 // Allow: home, end, left, right
				(e.keyCode >= 35 && e.keyCode <= 39)) {
					 // let it happen, don't do anything
					 return;
			}
			// Ensure that it is a number and stop the keypress
			if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
				e.preventDefault();
			}
		});
		
		$("#essay_time").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
			if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
				 // Allow: Ctrl+A
				(e.keyCode == 65 && e.ctrlKey === true) ||
				 // Allow: Ctrl+C
				(e.keyCode == 67 && e.ctrlKey === true) ||
				 // Allow: Ctrl+X
				(e.keyCode == 88 && e.ctrlKey === true) ||
				 // Allow: home, end, left, right
				(e.keyCode >= 35 && e.keyCode <= 39)) {
					 // let it happen, don't do anything
					 return;
			}
			// Ensure that it is a number and stop the keypress
			if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
				e.preventDefault();
			}
		});
		
		$("#technical_time").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
			if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
				 // Allow: Ctrl+A
				(e.keyCode == 65 && e.ctrlKey === true) ||
				 // Allow: Ctrl+C
				(e.keyCode == 67 && e.ctrlKey === true) ||
				 // Allow: Ctrl+X
				(e.keyCode == 88 && e.ctrlKey === true) ||
				 // Allow: home, end, left, right
				(e.keyCode >= 35 && e.keyCode <= 39)) {
					 // let it happen, don't do anything
					 return;
			}
			// Ensure that it is a number and stop the keypress
			if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
				e.preventDefault();
			}
		});
		
		$("#marks").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
			if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
				 // Allow: Ctrl+A
				(e.keyCode == 65 && e.ctrlKey === true) ||
				 // Allow: Ctrl+C
				(e.keyCode == 67 && e.ctrlKey === true) ||
				 // Allow: Ctrl+X
				(e.keyCode == 88 && e.ctrlKey === true) ||
				 // Allow: home, end, left, right
				(e.keyCode >= 35 && e.keyCode <= 39)) {
					 // let it happen, don't do anything
					 return;
			}
			// Ensure that it is a number and stop the keypress
			if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
				e.preventDefault();
			}
		});
		
		$("#timeframe_adjusted").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
			if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
				 // Allow: Ctrl+A
				(e.keyCode == 65 && e.ctrlKey === true) ||
				 // Allow: Ctrl+C
				(e.keyCode == 67 && e.ctrlKey === true) ||
				 // Allow: Ctrl+X
				(e.keyCode == 88 && e.ctrlKey === true) ||
				 // Allow: home, end, left, right
				(e.keyCode >= 35 && e.keyCode <= 39)) {
					 // let it happen, don't do anything
					 return;
			}
			// Ensure that it is a number and stop the keypress
			if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
				e.preventDefault();
			}
		});
		
		$("#timeframe_set").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
			if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
				 // Allow: Ctrl+A
				(e.keyCode == 65 && e.ctrlKey === true) ||
				 // Allow: Ctrl+C
				(e.keyCode == 67 && e.ctrlKey === true) ||
				 // Allow: Ctrl+X
				(e.keyCode == 88 && e.ctrlKey === true) ||
				 // Allow: home, end, left, right
				(e.keyCode >= 35 && e.keyCode <= 39)) {
					 // let it happen, don't do anything
					 return;
			}
			// Ensure that it is a number and stop the keypress
			if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
				e.preventDefault();
			}
		});
		
		
      });
	  
	  
	  
	//##### Send delete Ajax request to response.php #########
	$("body").on("click", "#adjusted_response .del_button", function(e) {
		 e.preventDefault();
		 var clickedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
		 var DbNumberID = clickedID[1]; //and get number from array
		 var myData = 'delete_adjusted='+ DbNumberID; //build a post data structure
		 
		$('#item_'+DbNumberID).addClass( "sel" ); //change background of this element by adding class
		$(this).hide(); //hide currently clicked delete button
		 
			jQuery.ajax({
			type: "POST", // HTTP method POST or GET
			url: "php/response.php", //Where to make Ajax calls
			dataType:"text", // Data type, HTML, json etc.
			data:myData, //Form variables
			success:function(response){
				//on success, hide  element user wants to delete.
				$('#item_'+DbNumberID).fadeOut();
				$("#total_timeframe").html(response);
			},
			error:function (xhr, ajaxOptions, thrownError){
				//On error, we alert user
				alert(thrownError);
			}
			});
	});
	  
	  //##### Send delete Ajax request to response.php #########
	$("body").on("click", "#response_answer .del_button", function(e) {
		 e.preventDefault();
		 var clickedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
		 var DbNumberID = clickedID[1]; //and get number from array
		 var myData = 'delete_answer='+ DbNumberID; //build a post data structure
		 
		$('#item_'+DbNumberID).addClass( "sel" ); //change background of this element by adding class
		$(this).hide(); //hide currently clicked delete button
		 
			jQuery.ajax({
			type: "POST", // HTTP method POST or GET
			url: "php/response.php", //Where to make Ajax calls
			dataType:"text", // Data type, HTML, json etc.
			data:myData, //Form variables
			success:function(response){
				//on success, hide  element user wants to delete.
				$('#item_'+DbNumberID).fadeOut();
			},
			error:function (xhr, ajaxOptions, thrownError){
				//On error, we alert user
				alert(thrownError);
			}
			});
	});
	
	
	//##### Send delete Ajax request to response.php #########
	$("body").on("click", "#views_response .del_button", function(e) {
		 e.preventDefault();
		 var clickedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
		 var DbNumberID = clickedID[1]; //and get number from array
		 var myData = 'deleteView='+ DbNumberID; //build a post data structure
		 
		$('#item_'+DbNumberID).addClass( "sel" ); //change background of this element by adding class
		$(this).hide(); //hide currently clicked delete button
		 
			jQuery.ajax({
			type: "POST", // HTTP method POST or GET
			url: "php/response.php", //Where to make Ajax calls
			dataType:"text", // Data type, HTML, json etc.
			data:myData, //Form variables
			success:function(response){
				//on success, hide  element user wants to delete.
				$('#item_'+DbNumberID).fadeOut();
			},
			error:function (xhr, ajaxOptions, thrownError){
				//On error, we alert user
				alert(thrownError);
			}
			});
	});

    </script>
    
  </body>
</html>