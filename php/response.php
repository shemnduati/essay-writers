<?php session_start();

$session_id=$_SESSION['writingSite_sessid'];

include('connect.php');

require_once 'common.php';
require_once('../../PHPMailer-master/class.phpmailer.php');

global $link;

function fetchUnread(){
	global $link;
	$session_id=$_SESSION['writingSite_sessid'];
	$sql_unread = "SELECT * FROM email a, email_recepients b WHERE a.email_id = b.email_id AND b.sent_to_id = '".$session_id."' AND b.sent_status = 1 AND b.read_status = 0";
	$qry_unread = mysqli_query($link,$sql_unread) or die(mysqli_error($link));
	if($qry_unread) {
		$count_unread = mysqli_num_rows($qry_unread);
		$response['count_unread'] = $count_unread;
		$response['message'] = '';
		$response['success'] = 1;
		$response['error'] = 0;
	} else {
		$response['error'] = 1;
		$response['success'] = 0;
		$response['message'] = 'An Error has occured. Contact system administrator';
	}
	generateOutput($response);	
	
}

function fetchSent() {
	global $link;
	
	$session_id=$_SESSION['writingSite_sessid'];
	$qry_admin = mysqli_query($link,"select * from admin_login where id = '".$session_id."'");
$rs_admin = mysqli_fetch_array($qry_admin);

	$sql = "SELECT * FROM email WHERE sent_by_id = '".$session_id."' AND sent_by = '".$rs_admin['admin_type']."'";
	
	$result = mysqli_query($link,$sql) or die(mysqli_error($link));
	$sentCounter = 0;
	
	if($result) {
		$response['sent'] = array();
		while($rs = mysqli_fetch_array($result)) {
			$sent = array();
			$sent['email_id'] = $rs['email_id'];
			
			$subject  = $rs['subject'];
			if(strlen($subject) > 22){
				$subject = substr($subject ,0, 22) . " ...";
			}
			$sent['subject'] = $subject;
			
			$sent['sent_on'] = $rs['sent_on'];
			
			$message = $rs['message'];
			if(strlen($message) > 50){
				$message = substr($message ,0, 50) . " ...";
			}
			$sent['message'] = $message;
			
			$sent_to_all = $rs['sent_to_all'];
			if($sent_to_all != NULL){
				
				$sent_to_names = "All ".$sent_to_all;
				
			}else{
				$sent_to_name = array();
				
				$sql_recep = "SELECT * FROM email_recepients WHERE email_id = '".$rs['email_id']."'";
				$qry_recep = mysqli_query($link,$sql_recep) or die(mysqli_error($link));
				$count = mysqli_num_rows($qry_recep);
				while($rs_recep = mysqli_fetch_array($qry_recep)){
					$sent_to = $rs_recep['sent_to'];
					$sent_to_id = $rs_recep['sent_to_id'];
					
					if($sent_to == 'writer'){
						$sql_name = "SELECT * FROM writers WHERE writer_id = '".$sent_to_id."'";
						$qry_name = mysqli_query($link,$sql_name) or die(mysqli_error($link));
						$rs_name = mysqli_fetch_array($qry_name);
						if($count > 1){
							$sent_to_name[] = $rs_name['fname'];
						}else{
							$sent_to_name[] = $rs_name['fname']." ".$rs_name['lname'];
						}
					}else{
						$sql_name = "SELECT * FROM prime_signup WHERE reg_id = '".$sent_to_id."'";
						$qry_name = mysqli_query($link,$sql_name) or die(mysqli_error($link));
						$rs_name = mysqli_fetch_array($qry_name);
						if($count > 1){
							$sent_to_name[] = $rs_name['fname'];
						}else{
							$sent_to_name[] = $rs_name['fname']." ".$rs_name['lname'];
						}
					}
				}
				
				$sent_to_names = implode(', ', $sent_to_name);	
				if(strlen($sent_to_names) > 20){
					$sent_to_names = substr($sent_to_names ,0, 20) . " ...";
				}
				
			}
			
			$sent['sent_to_name'] = $sent_to_names;
			array_push($response['sent'], $sent);
			$sentCounter++;
		}
			
		$response['message'] = $sentCounter." Message(s)";
		$response['success'] = 1;
	} else {
		$response['error'] = 1;
		$response['message'] = "There was an error connecting to DB";
	}
	generateOutput($response);
}

function fetchInbox() {
	global $link;
	
	$session_id=$_SESSION['writingSite_sessid'];
	$qry_admin = mysqli_query($link,"select * from admin_login where id = '".$session_id."'");
$rs_admin = mysqli_fetch_array($qry_admin);

	$sql = "SELECT * FROM email a, email_recepients b WHERE a.email_id = b.email_id AND b.sent_to_id = '".$session_id."' AND  b.sent_to = '".$rs_admin['admin_type']."' AND b.sent_status = 1";
	
	$result = mysqli_query($link,$sql) or die(mysqli_error($link));
	$inboxCounter = 0;
	
	if($result) {
		$response['inbox'] = array();
		while($rs = mysqli_fetch_array($result)) {
			$inbox = array();
			$inbox['email_id'] = $rs['email_id'];
			$subject  = $rs['subject'];
			if(strlen($subject) > 22){
				$subject = substr($subject ,0, 22) . " ...";
			}
			$inbox['subject'] = $subject;
			
			$message = $rs['message'];
			if(strlen($message) > 50){
				$message = substr($message ,0, 50) . " ...";
			}
			$inbox['message'] = $message;
			
			$inbox['sent_on'] = $rs['sent_on'];
			$inbox['read_status'] = $rs['read_status'];
			
			$sent_by = $rs['sent_by'];
			$sent_by_id = $rs['sent_by_id'];
			
			if($sent_by == 'client'){
				$sql_name = "SELECT * FROM prime_signup WHERE reg_id = '".$sent_by_id."'";
				$qry_name = mysqli_query($link,$sql_name) or die(mysqli_error($link));
				$rs_name = mysqli_fetch_array($qry_name);
				$inbox['sender_name'] = $rs_name['fname']." ".$rs_name['lname']." (Client)";
			}else{
				$sql_name = "SELECT * FROM writers WHERE writer_id = '".$sent_by_id."'";
				$qry_name = mysqli_query($link,$sql_name) or die(mysqli_error($link));
				$rs_name = mysqli_fetch_array($qry_name);
				$inbox['sender_name'] = $rs_name['fname']." ".$rs_name['lname']." (Writer)";
			}
			
			array_push($response['inbox'], $inbox);
			$inboxCounter++;
		}
			
		$response['message'] = $inboxCounter." Message(s)";
		$response['success'] = 1;
	} else {
		$response['error'] = 1;
		$response['message'] = "There was an error connecting to DB";
	}
	generateOutput($response);
}

function fetchRecipient($sent_to){
	global $link;
	
	if($sent_to == 'writer'){
		$sql = "SELECT * FROM writers";
		$result = mysqli_query($link,$sql) or die(mysqli_error($link));
		$writersCounter = 0;
		
		if($result) {
			$response['writers'] = array();
			while($rs = mysqli_fetch_array($result)) {
				$writers = array();
				$writers['writer_id'] = $rs['writer_id'];
				$writers['writer_name'] = $rs['fname']." ".$rs['lname'];
				
				array_push($response['writers'], $writers);
				$writersCounter++;
			}
				
			$response['message'] = $writersCounter." Record(s) on DB (".$sql.")";
			$response['success'] = 1;
		} else {
			$response['error'] = 1;
			$response['message'] = "There was an error connecting to DB";
		}
	}else {
		if($sent_to == 'client_a'){
			$sql = "SELECT * FROM prime_signup WHERE site = 'A'";
		}else if($sent_to == 'client_b'){
			$sql = "SELECT * FROM prime_signup WHERE site = 'B'";
		}else if($sent_to == 'client_c'){
			$sql = "SELECT * FROM prime_signup WHERE site = 'C'";
		}
		$result = mysqli_query($link,$sql) or die(mysqli_error($link));
		$clientsCounter = 0;
		
		if($result) {
			$response['clients'] = array();
			while($rs = mysqli_fetch_array($result)) {
				$tracker = array();
				$clients['client_id'] = $rs['reg_id'];
				$clients['client_name'] = $rs['fname']." ".$rs['lname'];
				
				array_push($response['clients'], $clients);
				$clientsCounter++;
			}
				
			$response['message'] = $clientsCounter." Record(s) on DB (".$sql.")";
			$response['success'] = 1;
		} else {
			$response['error'] = 1;
			$response['message'] = "There was an error connecting to DB";
		}
	}
	generateOutput($response);
}

function fixWhere_assignee($email, $fname, $lname) {
	$str = "";
	if($email != ""){
		$str = $str."AND a.email like '%".$email."%' ";
	}
	if($fname != ""){
		$str = $str."AND a.fname like '%".$fname."%' ";
	}
	if($lname != ""){
		$str = $str."AND a.lname like '%".$lname."%' ";
	}
	return($str);
}

function fetchAssignee($email, $fname, $lname) {
	
	$sql = "SELECT * FROM writers a, academic_level b WHERE a.academic_level = b.act_level_id AND a.status = 'A' ".fixWhere_assignee($email, $fname, $lname);
	global $link;
	$result = mysqli_query($link,$sql) or die(mysqli_error($link));
	$writersCounter = 0;
	
	if($result) {
		$response['writers'] = array();
		while($rs = mysqli_fetch_array($result)) {
			$writers = array();
			$writers['id'] = $rs['writer_id'];
			$writers['writer_id'] = "WS16".str_pad($rs['writer_id'],4,0,STR_PAD_LEFT);
			$writers['names'] = $rs['fname']." ".$rs['lname'];
			$writers['email'] = $rs['email'];
			$writers['address'] = $rs['address'];
			$writers['phone'] = $rs['phone'];
			$writers['academic_level'] = $rs['act_name'];
			
			if($rs['speciality'] == 'essay_writer'){
				$writers['speciality'] = 'technical_writer';
			}else{
				$writers['speciality'] = 'essay_writer';
			}
			
			$qry_totalmarks = mysqli_query($link,"select sum(marks) as total_marks from test_questions where essay = 0 and speciality != '".$rs['speciality']."'") or die(mysqli_error($link));
			$rs_totalmarks = mysqli_fetch_array($qry_totalmarks);
			$total_marks = $rs_totalmarks['total_marks'];
			
			
			$qry_marks = mysqli_query($link,"select sum(marks) as total_marks from writer_answers a, test_questions b where a.test_id = b.test_id and a.status = 1 and a.writer_id = '".$rs['writer_id']."'  and b.speciality != '".$rs['speciality']."'") or die(mysqli_error($link));
			$rs_marks = mysqli_fetch_array($qry_marks);
			if($rs_marks['total_marks'] == NULL){
				$marks = 0;
			}else{
				$marks = $rs_marks['total_marks'];
			}
			
			$writers['test_score'] = number_format((float)($marks/$total_marks*100), 2, '.', '');
			
			array_push($response['writers'], $writers);
			$writersCounter++;
		}
			
		$response['message'] = $writersCounter." Record(s) on DB (".$sql.")";
		$response['success'] = 1;
	} else {
		$response['error'] = 1;
		$response['message'] = "There was an error connecting to DB";
	}
	generateOutput($response);
}

function assignWriter($writer_id, $order_id, $order_title, $email, $name) {
	
	global $link; 
	
	$mail = new PHPMailer(); // defaults to using php "mail()"
	
	$mail->IsSendmail(); // telling the class to use SendMail transport
	
	$body = "Dear ".$name.",<br/><br/>You have been assigned an order.<br/><br/> Order title ".$order_title."<br/><br/>Login to your Galaxy portal to confirm or refuse the assignment";
	
	
	$mail->SetFrom('info@stretchgo.com', 'Galaxy Notification');
	
	
	$address = $email;
	$mail->AddAddress($address);
	
	$mail->Subject = "Order Number ".$order_id." has been assigned to you";
	
	$mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
	
	$mail->MsgHTML($body);
	
	$mail->Send();
	
	$session_id=$_SESSION['writingSite_sessid'];
	$sql = "INSERT INTO `writers_assigned` (`order_id`, `writer_id`, `assigned_on`, `assigned_by`) VALUES ('".$order_id."', '".$writer_id."', NOW(), '".$session_id."')";
	$result = mysqli_query($link,$sql) or die(mysqli_error($link));
	if($result) {
		$date = date("Y-m-d");
		$query = mysqli_query($link,"INSERT INTO writers_jobs (`writer_id`,`order_id`,`award_type`,`award_dt`,`acceptance_date`,`acceptance_time`,`job_status`) VALUES ('".$writer_id."', '".$order_id."', 'Assigned', NOW(), '".$date."', CURTIME(), 'pending')") or die(mysqli_error($link));
		if($query){
			mysqli_query($link,"UPDATE prime_order SET order_status = '1' where order_id = '".$order_id."'");
			mysqli_query($link,"UPDATE prime_order SET assigned = '1' where order_id = '".$order_id."'");
			# send user confirmation code*/
			$response['message'] = 'Order successfully assigned to writer';
			$response['success'] = 1;
			$response['error'] = 0;
		}
	} else {
		$response['error'] = 1;
		$response['success'] = 0;
		$response['message'] = 'An Error has occured. Contact system administrator';
	}
	generateOutput($response);
}

if (isset($_REQUEST['tag']) && $_REQUEST['tag'] != '') {

    $tag = $_REQUEST['tag'];

    $response = array("tag" => $tag, "success" => 0, "error" => 0);

   if($tag == 'fetch-assignee') {

		$email = $_REQUEST['email'];
		$fname = $_REQUEST['fname'];
		$lname = $_REQUEST['lname'];

		fetchAssignee($email, $fname, $lname);


	}else if($tag == 'assign-writer') {

		$writer_id = $_REQUEST['writer_id'];
		$order_id = $_REQUEST['order_id'];
		$order_title = $_REQUEST['order_title'];
		$email = $_REQUEST['email'];
		$name = $_REQUEST['name'];

		assignWriter($writer_id, $order_id, $order_title, $email, $name);


	}else if($tag == 'fetch-recipient') {

		$sent_to = $_REQUEST['sent_to'];

		fetchRecipient($sent_to);


	}else if($tag == 'fetch-inbox') {

		fetchInbox();

	}else if($tag == 'fetch-sent') {

		fetchSent();
	}else if($tag == 'fetch-unread') {

		fetchUnread();

	}
	
}

else if(isset($_POST["cancelOrder"])) 
{	
	$description = filter_var($_POST["description"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH); 
	$reason = $_POST['reason_arr'];
	$job_id = $_POST['job_id'];
	$order_id = $_POST['order_id'];
	$writer_id = $_POST['writer_id'];
	$order_title = filter_var($_POST["order_title"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH); 
	$name = $_POST['writer_name'];
	$email = $_POST['writer_email'];
	
    $reason_arr=explode(',',$reason);
    foreach($reason_arr as $row)
    {
		$sqlinsert = "INSERT INTO orders_canceled (`job_id`,`canceled_by`,`canceled_on`,`reason`,`description`) VALUES ('".$job_id."','".$session_id."',NOW(),'".$row."','".$description."')";
		mysqli_query($link,$sqlinsert) or die(mysqli_error($link));    
	}
	$update_row = mysqli_query($link,"UPDATE writers_jobs SET job_status = 'canceled' WHERE job_id=".$job_id);
	
	if($update_row)
	{    
		mysqli_query($link,"UPDATE writers_assigned SET status = 'canceled' WHERE order_id=".$order_id." and writer_id = '".$writer_id."'");
		mysqli_query($link,"UPDATE prime_order SET order_status = '0', assigned = '0' WHERE order_id=".$order_id);
		
		$mail = new PHPMailer(); // defaults to using php "mail()"
	
		$mail->IsSendmail(); // telling the class to use SendMail transport
		
		$body = "Dear ".$name.",<br/><br/>Your order titled: ".$order_title." has been cancelled<br/><br/>Reason: ".$reason."<br/><br/>Description: ".$description;
		
		
		$mail->SetFrom('info@stretchgo.com', 'Galaxy Notification');
		
		
		$address = $email;
		$mail->AddAddress($address);
		
		$mail->Subject = "Your order number ".$order_id." has been cancelled";
		
		$mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
		
		$mail->MsgHTML($body);
		
		$mail->Send();
	
	}
}

else if(isset($_POST["register_title"]) && strlen($_POST["register_title"])>0) 
{	//check $_POST["content_txt"] is not empty

	
	//sanitize post value, PHP filter FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH Strip tags, encode special characters.
	$title = filter_var($_POST["title"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH); 
	$speciality = $_POST['speciality'];
	
	// Insert sanitize string in record
	$sqlinsert = "INSERT INTO speciality_titles (`title`,`speciality`) VALUES ('".$title."', '".$speciality."')";
	//mysqli_query($link,$sqlinsert);
	$query_insert = mysqli_query($link,$sqlinsert) or die(mysqli_error($link));
	
	if($query_insert){
						
		 //Record was successfully inserted, respond result back to index page
		  $title_id = mysqli_insert_id($link); //Get ID of last inserted row from MySQL
		  
		  echo $title_id;
	  
	}else{
		
		//header('HTTP/1.1 500 '.mysql_error()); //display sql errors.. must not output sql errors in live mode.
		header('HTTP/1.1 500 Looks like mysql error, could not insert record!');
		exit();
	}

}
	
else if(isset($_POST["add_subtitle"]) && strlen($_POST["add_subtitle"])>0) 
{	//check $_POST["content_txt"] is not empty

	
	//sanitize post value, PHP filter FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH Strip tags, encode special characters.
	$sub_title = filter_var($_POST["sub_title"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH); 
	$title_id = $_POST['title_id'];
	
	// Insert sanitize string in record
	$sqlinsert = "INSERT INTO speciality_subtitles (`sub_title`,`title_id`) VALUES ('".$sub_title."', '".$title_id."')";
	//mysqli_query($link,$sqlinsert);
	$query_insert = mysqli_query($link,$sqlinsert) or die(mysqli_error($link));
	
	if($query_insert){
						
		 //Record was successfully inserted, respond result back to index page
		  $subtitle_id = mysqli_insert_id($link); //Get ID of last inserted row from MySQL
		  
		  echo '<li class="dd-item" data-id="13" id="item_'.$subtitle_id.'">';
		  echo '<div class="del_wrapper dd-handle"><a href="#" class="del_button" id="del-'.$subtitle_id.'">';
		  echo '<img src="dist/img/icon_del.gif" border="0" />';
		  echo '</a>&nbsp;&nbsp;';
		  
		  echo $sub_title;
		  
		  '</div></li>';
	  
	}else{
		//header('HTTP/1.1 500 '.mysql_error()); //display sql errors.. must not output sql errors in live mode.
		header('HTTP/1.1 500 Looks like mysql error, could not insert record!');
		exit();
	}

}


else if(isset($_POST["delete_subtitle"]) && strlen($_POST["delete_subtitle"])>0 && is_numeric($_POST["delete_subtitle"]))
{	//do we have a delete request? $_POST["recordToDelete"]

	//sanitize post value, PHP filter FILTER_SANITIZE_NUMBER_INT removes all characters except digits, plus and minus sign.
	$idToDelete = filter_var($_POST["delete_subtitle"],FILTER_SANITIZE_NUMBER_INT); 
	
	//try deleting record using the record ID we received from POST
	$delete_row = mysqli_query($link,"DELETE FROM speciality_subtitles WHERE subtitle_id=".$idToDelete);
	
	if(!$delete_row)
	{    
		//If mysql delete query was unsuccessful, output error 
		header('HTTP/1.1 500 Could not delete record!');
		exit();
	}
	mysqli_close(); //close db connection
}//Invite users to event


else if(isset($_POST["add_question"]) && strlen($_POST["add_question"])>0) 
{	//check $_POST["content_txt"] is not empty

	
	//sanitize post value, PHP filter FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH Strip tags, encode special characters.
	
	// Insert sanitize string in record
	$sqlinsert = "INSERT INTO test_questions (`status`) VALUES (0)";
	//mysqli_query($link,$sqlinsert);
	$query_insert = mysqli_query($link,$sqlinsert) or die(mysqli_error($link));
	
	if($query_insert){
						
		 //Record was successfully inserted, respond result back to index page
		  $test_id = mysqli_insert_id($link); //Get ID of last inserted row from MySQL
		  
		  echo $test_id;
		  
	  
	}else{
		//header('HTTP/1.1 500 '.mysql_error()); //display sql errors.. must not output sql errors in live mode.
		header('HTTP/1.1 500 Looks like mysql error, could not insert record!');
		exit();
	}

}

else if(isset($_POST["add_answer"]) && strlen($_POST["add_answer"])>0) 
{	//check $_POST["content_txt"] is not empty

	
	//sanitize post value, PHP filter FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH Strip tags, encode special characters.
	$answer = filter_var($_POST["answer"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH); 
	$test_id = $_POST['test_id'];
	
	// Insert sanitize string in record
	$sqlinsert = "INSERT INTO test_answers (`answer`,`test_id`) VALUES ('".$answer."', '".$test_id."')";
	//mysqli_query($link,$sqlinsert);
	$query_insert = mysqli_query($link,$sqlinsert) or die(mysqli_error($link));
	
	if($query_insert){
						
		 //Record was successfully inserted, respond result back to index page
		  $answer_id = mysqli_insert_id($link); //Get ID of last inserted row from MySQL
		 
		  echo '<tr id="item_'.$answer_id.'">';
		  echo '<td>';
		  echo '<a href="#" class="del_button" id="del-'.$answer_id.'">';
		  echo '<img src="dist/img/icon_del.gif" border="0" />';
		  echo '</a>';
		  echo '</td>';
		  echo '<td>';
		  echo $answer;
		  echo '</td>';
		  echo '<td>';
		  echo '<input id="del-'.$answer_id.'" class="correct_answer" name="correct_answer" type="radio" value="'.$answer_id.'">';
		  echo '</td>';
		  echo '</tr>';
	  
	}else{
		//header('HTTP/1.1 500 '.mysql_error()); //display sql errors.. must not output sql errors in live mode.
		header('HTTP/1.1 500 Looks like mysql error, could not insert record!');
		exit();
	}

}

else if(isset($_POST["delete_answer"]) && strlen($_POST["delete_answer"])>0 && is_numeric($_POST["delete_answer"]))
{	//do we have a delete request? $_POST["recordToDelete"]

	//sanitize post value, PHP filter FILTER_SANITIZE_NUMBER_INT removes all characters except digits, plus and minus sign.
	$idToDelete = filter_var($_POST["delete_answer"],FILTER_SANITIZE_NUMBER_INT); 
	
	//try deleting record using the record ID we received from POST
	$delete_row = mysqli_query($link,"DELETE FROM test_answers WHERE answer_id=".$idToDelete);
	
	if(!$delete_row)
	{    
		//If mysql delete query was unsuccessful, output error 
		header('HTTP/1.1 500 Could not delete record!');
		exit();
	}
}


else if(isset($_POST["correct_answer"]) && strlen($_POST["correct_answer"])>0 && is_numeric($_POST["correct_answer"]))
{	//do we have a delete request? $_POST["recordToDelete"]

	//sanitize post value, PHP filter FILTER_SANITIZE_NUMBER_INT removes all characters except digits, plus and minus sign.
	$answer_id = filter_var($_POST["correct_answer"],FILTER_SANITIZE_NUMBER_INT); 
	$test_id = $_POST['test_id'];
	
	//try deleting record using the record ID we received from POST
	$update_row = mysqli_query($link,"UPDATE test_questions SET answer_id = '".$answer_id."' WHERE test_id=".$test_id);
	
	if(!$update_row)
	{    
		//If mysql delete query was unsuccessful, output error 
		header('HTTP/1.1 500 Could not update record!');
		exit();
	}
}



else if(isset($_POST["language_time"]) && strlen($_POST["language_time"])>0 && is_numeric($_POST["language_time"]))
{	//do we have a delete request? $_POST["recordToDelete"]

	//sanitize post value, PHP filter FILTER_SANITIZE_NUMBER_INT removes all characters except digits, plus and minus sign.
	$language_time = filter_var($_POST["language_time"],FILTER_SANITIZE_NUMBER_INT); 
	$time_sec = $language_time * 60;
	
	//try deleting record using the record ID we received from POST
	$update_row = mysqli_query($link,"UPDATE test_time SET time = '".$time_sec."' WHERE test_type = 'language_check'");
	
	if($update_row)
	{    
		echo $language_time." mins";
	}
}


else if(isset($_POST["essay_time"]) && strlen($_POST["essay_time"])>0 && is_numeric($_POST["essay_time"]))
{	//do we have a delete request? $_POST["recordToDelete"]

	//sanitize post value, PHP filter FILTER_SANITIZE_NUMBER_INT removes all characters except digits, plus and minus sign.
	$essay_time = filter_var($_POST["essay_time"],FILTER_SANITIZE_NUMBER_INT); 
	$time_sec = $essay_time * 60;
	
	//try deleting record using the record ID we received from POST
	$update_row = mysqli_query($link,"UPDATE test_time SET time = '".$time_sec."' WHERE test_type = 'essay_check'");
	
	if($update_row)
	{    
		echo $essay_time." mins";
	}
}

else if(isset($_POST["technical_time"]) && strlen($_POST["technical_time"])>0 && is_numeric($_POST["technical_time"]))
{	//do we have a delete request? $_POST["recordToDelete"]

	//sanitize post value, PHP filter FILTER_SANITIZE_NUMBER_INT removes all characters except digits, plus and minus sign.
	$technical_time = filter_var($_POST["technical_time"],FILTER_SANITIZE_NUMBER_INT); 
	$time_sec = $technical_time * 60;
	
	//try deleting record using the record ID we received from POST
	$update_row = mysqli_query($link,"UPDATE test_time SET time = '".$time_sec."' WHERE test_type = 'technical_check'");
	
	if($update_row)
	{    
		echo $technical_time." mins";
	}
}

else if(isset($_POST["add_view"]) && strlen($_POST["add_view"])>0) 
{	//check $_POST["content_txt"] is not empty

	//sanitize post value, PHP filter FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH Strip tags, encode special characters.
	$level = $_POST['level'];
	$order_id = $_POST['order_id']; 
	
	// Insert sanitize string in record
	$insert_row = mysqli_query($link,"INSERT INTO view_order(order_id, writer_level) VALUES('".$order_id."', '".$level."')");
	
	if($insert_row)
	{
		 //Record was successfully inserted, respond result back to index page
		 $view_id = mysqli_insert_id($link); //Get ID of last inserted row from MySQL
		  
		 $res = mysqli_query($link,"SELECT * FROM academic_level WHERE act_level_id = '".$level."'");
         $row = mysqli_fetch_array($res);
		  echo '<tr id="item_'.$view_id.'">';
			echo '<td>';
			echo '<a href="#" class="del_button" id="del-'.$view_id.'">';
			echo '<img src="dist/img/icon_del.gif" border="0" />';
			echo '</a>';
			echo '</td>';
			echo '<td>';
			echo $row['act_name'];
			echo '</td>';
			echo '</tr>';
		  mysqli_close($link); //close db connection

	}else{
		
		//header('HTTP/1.1 500 '.mysql_error()); //display sql errors.. must not output sql errors in live mode.
		header('HTTP/1.1 500 Looks like mysql error, could not insert record!');
		exit();
	}

}


else if(isset($_POST["deleteView"]) && strlen($_POST["deleteView"])>0 && is_numeric($_POST["deleteView"]))
{	//do we have a delete request? $_POST["recordToDelete"]

	//sanitize post value, PHP filter FILTER_SANITIZE_NUMBER_INT removes all characters except digits, plus and minus sign.
	$idToDelete = filter_var($_POST["deleteView"],FILTER_SANITIZE_NUMBER_INT); 
	
	//try deleting record using the record ID we received from POST
	$delete_row = mysqli_query($link,"DELETE FROM view_order WHERE view_id=".$idToDelete);

	if(!$delete_row)
	{    
		//If mysql delete query was unsuccessful, output error 
		header('HTTP/1.1 500 Could not delete record!');
		exit();
	}
	mysqli_close($link); //close db connection
}


else if(isset($_POST["yesView"]) && strlen($_POST["yesView"])>0 && is_numeric($_POST["yesView"]))
{	//do we have a delete request? $_POST["recordToDelete"]

	//sanitize post value, PHP filter FILTER_SANITIZE_NUMBER_INT removes all characters except digits, plus and minus sign.
	$order_id = filter_var($_POST["order_id"],FILTER_SANITIZE_NUMBER_INT); 
	
	//try deleting record using the record ID we received from POST
	$update_row = mysqli_query($link,"UPDATE prime_order SET view_order = 1 WHERE order_id=".$order_id);

	if(!$update_row)
	{    
		//If mysql delete query was unsuccessful, output error 
		header('HTTP/1.1 500 Could not delete record!');
		exit();
	}
	mysqli_close($link); //close db connection
}

else if(isset($_POST["noView"]) && strlen($_POST["noView"])>0 && is_numeric($_POST["noView"]))
{	//do we have a delete request? $_POST["recordToDelete"]

	//sanitize post value, PHP filter FILTER_SANITIZE_NUMBER_INT removes all characters except digits, plus and minus sign.
	$order_id = filter_var($_POST["order_id"],FILTER_SANITIZE_NUMBER_INT); 
	
	//try deleting record using the record ID we received from POST
	$update_row = mysqli_query($link,"UPDATE prime_order SET view_order = 0 WHERE order_id=".$order_id);

	if(!$update_row)
	{    
		//If mysql delete query was unsuccessful, output error 
		header('HTTP/1.1 500 Could not delete record!');
		exit();
	}
	mysqli_close($link); //close db connection
}


else if(isset($_POST["delete_adjusted"]) && strlen($_POST["delete_adjusted"])>0 && is_numeric($_POST["delete_adjusted"]))
{	//do we have a delete request? $_POST["recordToDelete"]
	
	//sanitize post value, PHP filter FILTER_SANITIZE_NUMBER_INT removes all characters except digits, plus and minus sign.
	$idToDelete = filter_var($_POST["delete_adjusted"],FILTER_SANITIZE_NUMBER_INT); 
	
	$qry_orderid = mysqli_query($link,"select order_id from adjusted_timeframe where adjusted_id = '".$idToDelete."'");
	$rs_orderid=mysqli_fetch_array($qry_orderid);
	$order_id = $rs_orderid['order_id'];
	
	//try deleting record using the record ID we received from POST
	$delete_row = mysqli_query($link,"DELETE FROM adjusted_timeframe WHERE adjusted_id=".$idToDelete);

	if($delete_row)
	{    
		$qry_settime=mysqli_query($link,"SELECT * FROM prime_order WHERE order_id='".$order_id."'");
		$rs_settime=mysqli_fetch_array($qry_settime);
		$admin_timeframe = $rs_settime['admin_timeframe'];
		
		$qry_ttladj = mysqli_query($link,"select sum(adjusted_time) from adjusted_timeframe where order_id = '".$order_id."'");
					$rs_ttladj = mysqli_fetch_array($qry_ttladj);
					$total_timeframe = ($rs_ttladj['sum(adjusted_time)'] + $admin_timeframe)/3600;
					
		echo $total_timeframe." hours";
		
	}else{
		//If mysql delete query was unsuccessful, output error 
		header('HTTP/1.1 500 Could not delete record!');
		exit();
	}
	mysqli_close($link); //close db connection
}

else if(isset($_POST["sendBack"]))
{	//do we have a delete request? $_POST["recordToDelete"]

	//sanitize post value, PHP filter FILTER_SANITIZE_NUMBER_INT removes all characters except digits, plus and minus sign.
	$job_id = filter_var($_POST["job_id"],FILTER_SANITIZE_NUMBER_INT); 
	$instructions = filter_var($_POST["instructions"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH); 
	$writer_name = filter_var($_POST["writer_name"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH); 
	$order_title = filter_var($_POST["order_title"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH); 
	$writer_email = $_POST['writer_email'];
	$order_id = $_POST['order_id'];
	
	//try deleting record using the record ID we received from POST
	$update_row = mysqli_query($link,"UPDATE writers_jobs SET revise = 1 WHERE job_id=".$job_id);

	if($update_row)
	{   
		$insert_row = mysqli_query($link,"INSERT INTO writers_revision(job_id, instructions, datetime, revision_status, sent_by) VALUES('".$job_id."', '".$instructions."', NOW(), 0, 'admin')");
		if($insert_row)
		{ 
			$mail = new PHPMailer(); // defaults to using php "mail()"
	
			$mail->IsSendmail(); // telling the class to use SendMail transport
			
			$body = "Dear ".$writer_name.",<br/><br/>Your order titled: ".$order_title." has been sent back for revision with the following instructions:<br/><br/>".$instructions;
			
			
			$mail->SetFrom('info@stretchgo.com', 'Galaxy Notification');
			
			
			$address = $writer_email;
			$mail->AddAddress($address);
			
			$mail->Subject = "Revision instructions for order number ".$order_id;
			
			$mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
			
			$mail->MsgHTML($body);
			
			$mail->Send();
		
			echo '<tr><td>'.$instructions.'</td><td>Not done</td><td>'.date("Y-m-d H:i:s").'</td><td>admin</td></tr>';
		}
	}
	mysqli_close($link); //close db connection
}

else if(isset($_POST["markComplete"]))
{	//do we have a delete request? $_POST["recordToDelete"]

	//sanitize post value, PHP filter FILTER_SANITIZE_NUMBER_INT removes all characters except digits, plus and minus sign.
	$job_id = filter_var($_POST["job_id"],FILTER_SANITIZE_NUMBER_INT); 
	$writer_name = filter_var($_POST["writer_name"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH); 
	$order_title = filter_var($_POST["order_title"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH); 
	$writer_email = $_POST['writer_email'];
	$order_id = $_POST['order_id'];
	
	//try deleting record using the record ID we received from POST
	$update_row = mysqli_query($link,"UPDATE writers_jobs SET revise = 0, admin_complete = '1' WHERE job_id=".$job_id);

	if($update_row)
	{  
		$update_row2 = mysqli_query($link,"UPDATE writers_revision SET revision_status = 1 WHERE job_id=".$job_id);
		if($update_row2)
		{ 
			$mail = new PHPMailer(); // defaults to using php "mail()"
	
			$mail->IsSendmail(); // telling the class to use SendMail transport
			
			$body = "Dear ".$writer_name.",<br/><br/>Your order titled: ".$order_title." has been sent to the client for review";
			
			
			$mail->SetFrom('info@stretchgo.com', 'Galaxy Notification');
			
			
			$address = $writer_email;
			$mail->AddAddress($address);
			
			$mail->Subject = "Your order number ".$order_id." has been sent to the client for review";
			
			$mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
			
			$mail->MsgHTML($body);
			
			$mail->Send();
		}
	}
	mysqli_close($link); //close db connection
}

else{

	echo "Function not found";	
	
}

?>