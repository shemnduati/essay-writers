<?php session_start();

	//Array to store validation errors
	$errmsg_arr = array();
	
	//Validation error flag
	$errflag = false;
	
	//Connect to mysql server
	include('connect.php');
	
	global $link;
	
	//Function to sanitize values received from the form. Prevents SQL injection
function clean($str) {
$str = @trim($str);
if(get_magic_quotes_gpc()) {
$str = stripslashes($str);
}
return mysql_real_escape_string($str);
}
 
 
	//Sanitize the POST values
	// Generate Guid 
	$password=md5($_POST['password']);
	$email =$_POST['email'];
				
			 $query = mysqli_query($link, "select * from admin_login where email='$email' and password='$password'") or die(mysqli_error($link));
                $count = mysqli_num_rows($query);
                $row = mysqli_fetch_array($query);
				$admin_id = $row['id'];
				
                if ($count > 0) {
					
					$account_status = $row['status'];
                   
					if($account_status == 'P'){
						
						
						//Login failed
$errmsg_arr[] = 'Unable to login: Your account status is pending approval by management';
$errflag = true;
if($errflag) {
$_SESSION['ERRMSG_ARR2'] = $errmsg_arr;
session_write_close();
header("location: ../login.php");
exit();
}
			
					}
					
					
					else if($account_status == 'S'){
						
						
						//Login failed
$errmsg_arr[] = 'Unable to login: Your account has been suspended, please contact management';
$errflag = true;
if($errflag) {
$_SESSION['ERRMSG_ARR2'] = $errmsg_arr;
session_write_close();
header("location: login.php");
exit();
}
			
					}
					
					
					else if($account_status == 'B'){
						
						
						//Login failed
$errmsg_arr[] = 'Unable to login: Your account has been blocked, please contact management';
$errflag = true;
if($errflag) {
$_SESSION['ERRMSG_ARR2'] = $errmsg_arr;
session_write_close();
header("location: ../login.php");
exit();
}
			
					}
					
					else{
					
					
					
                    session_regenerate_id();
                    $_SESSION['writingSite_sessid'] = $row['id'];
					
					mysqli_query($link,"UPDATE admin_users SET lock_screen = 0 where id = '$admin_id'");
					
					session_write_close();
					header("location: ../index.php?page=dashboard");
					exit();
					
				}
					
				}
				else {
//Login failed
$errmsg_arr[] = 'wrong email address or password';
$errflag = true;
if($errflag) {
$_SESSION['ERRMSG_ARR2'] = $errmsg_arr;
session_write_close();
header("location: ../login.php");
exit();
}

		 
	}
?>