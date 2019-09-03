<?php session_start();

include("connect.php");

global $link;

$timeout = 30; // Set timeout minutes
$logout_redirect_url = "lock.php"; // Set logout URL


	 
$timeout_sec = $timeout * 60; // Converts minutes to seconds
if (isset($_SESSION['start_time'])) {
    $elapsed_time = time() - $_SESSION['start_time'];
    if ($elapsed_time >= $timeout_sec) {
        
        header("Location: $logout_redirect_url");
    }
}
$_SESSION['start_time'] = time();

$session_id=$_SESSION['writingSite_sessid'];

$sql_lock = mysqli_query($link,"select * from admin_login where id = '$session_id'");

$row_lock = mysqli_fetch_array($sql_lock);

$lock_status = $row_lock['lock_screen'];

if($lock_status > 0){
	
	header("location: lock.php");
		exit();
}

	//Check whether the session variable SESS_MEMBER_ID is present or not
	if(!isset($_SESSION['writingSite_sessid']) || (trim($_SESSION['writingSite_sessid']) == '')) {
		header("location: login.php");
		exit();
	}
        
		
		
		
		$sql_logduser = "SELECT * FROM admin_login where id = '$session_id'";
		$qry_logduser = mysqli_query($link,$sql_logduser);
                     $rs_logduser = mysqli_fetch_array($qry_logduser);
			
					 $username = $rs_logduser['username'];
					 $logduser = $rs_logduser['fname']." ".$rs_logduser['sname'];
					 
			
										
?>