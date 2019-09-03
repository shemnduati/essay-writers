<?php session_start();

      $session_id=$_SESSION['writingSite_sessid'];
	  
	  $user_password = md5($_POST['password']);

include("connect.php");

global $link;

$query = mysqli_query($link,"select * from admin_login where admin_id = '$session_id' and password = '$user_password'");   

$count = mysqli_num_rows($query);
            
			   if($count > 0){
				   
				   mysqli_query($link,"UPDATE admin_login SET lock_screen = 0 where id = '$session_id'");
				   header("location: ../index.php");
				   exit();
			   }else{
				   						//Wrong password
$errmsg_arr[] = 'Unable to unlock: You entered a wrong password';
$errflag = true;
if($errflag) {
$_SESSION['ERRMSG_ARR2'] = $errmsg_arr;
				   header("location: ../lock.php");
				   exit();
}
			   }

?>