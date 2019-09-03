<?php session_start();

$session_id=$_SESSION['writingSite_sessid'];

include('connect.php');

global $link;

require_once('../../PHPMailer-master/class.phpmailer.php');

$editor_email = 'info@stretchgo.com';

//Array to store validation errors
$errmsg_arr = array();
//Validation error flag
$errflag = false;



//start of update content
if( isset($_POST['update_content']) )
{
	// Your PHP code here

			$content_id = $_POST['content_id'];
			
                        $title = $_POST['title'];
                        $meta_description = $_POST['meta_description'];
	                $meta_words = $_POST['meta_words'];
	                $description_top = $_POST['description_top'];
	                $description_mid = $_POST['description_mid'];
	                $description_bottom = $_POST['description_bottom'];
			
			$sqliupdate = "UPDATE blog SET title = '".$title."', meta_description = '".$meta_description."', meta_words = '".$meta_words."', description_top = '".$description_top."', description_mid = '".$descripton_mid."', description_bottom = '".$description_bottom."' where content_id = '".$content_id."'";
					
			//mysqli_query($link,$sqlinsert);
			mysqli_query($link,$sqliupdate) or die(mysqli_error($link));
		
			
			$errmsg_arr[] = 'Excellent. You have updated your content';
$errflag = true;
if($errflag) {
$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		header('location:../index.php?page=content&subpage=about_us');
			 }
}

else{
	
	echo "ACCESS DENIED!";
}
?>