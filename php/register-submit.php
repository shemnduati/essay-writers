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

$qry_admin = mysqli_query($link,"select * from admin_login where id = '".$session_id."'");
$rs_admin = mysqli_fetch_array($qry_admin);

if( isset($_POST['send_email']) )
{
	
	$sent_to = $_POST['sent_to'];
	$subject = filter_var($_POST["subject"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	$message = filter_var($_POST["message"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	
	
	$sqlinsert = "INSERT INTO email (`subject`, `message`,`sent_on`, `sent_by`, `sent_by_id`, `sent_by_email`) VALUES ('".$subject."', '".$message."', NOW(), '".$rs_admin['admin_type']."', '".$session_id."', '".$editor_email."')";
					
	$query_insert = mysqli_query($link,$sqlinsert) or die(mysqli_error($link));
	
	if($query_insert){
		$email_id = mysqli_insert_id($link);
		foreach ($_POST['sent_to_id'] as $sent_to_id)
		{
			if($sent_to_id == 0){
			
				if($sent_to == 'writer'){
					$sql_email = "SELECT * FROM writers";
					$qry_email = mysqli_query($link,$sql_email) or die(mysqli_error($link));
					while($rs_email = mysqli_fetch_array($qry_email)){
						$sent_to_id = $rs_email['writer_id'];
						$sent_to_email = $rs_email['email'];
						
						$sqlinsert2 = "INSERT INTO email_recepients (`email_id`,`sent_to`, `sent_to_id`, `sent_to_email`, `sent_status`, `read_status`) VALUES ('".$email_id."', '".$sent_to."', '".$sent_to_id."', '".$sent_to_email."', '0', '0')";
						
						$query_insert2 = mysqli_query($link,$sqlinsert2) or die(mysqli_error($link));
						
						if($query_insert2){
							$recepient_id = mysqli_insert_id($link);
							
							$mail = new PHPMailer(); // defaults to using php "mail()"
				
							$mail->IsSendmail(); // telling the class to use SendMail transport
							
							$body = $message;
							
							$mail->SetFrom($editor_email, 'Galaxy Admin');
							
							$mail->AddAddress($sent_to_email);
										
							$mail->Subject = $subject;
							
							$mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
							
							$mail->MsgHTML($body);
							
							if($mail->Send()){
								mysqli_query($link,"UPDATE email_recepients SET sent_status = '1' WHERE recepient_id=".$recepient_id);
							}
						}
				
					}
					
				}else{
					if($sent_to == 'client_a'){
						$sql_email = "SELECT * FROM prime_signup WHERE site = 'A'";
					}else if($sent_to == 'client_b'){
						$sql_email = "SELECT * FROM prime_signup WHERE site = 'B'";
					}else{
						$sql_email = "SELECT * FROM prime_signup WHERE site = 'C'";
					}
					$qry_email = mysqli_query($link,$sql_email) or die(mysqli_error($link));
					while($rs_email = mysqli_fetch_array($qry_email)){
						$sent_to_id = $rs_email['reg_id'];
						$sent_to_email = $rs_email['email'];
						
						$sqlinsert2 = "INSERT INTO email_recepients (`email_id`,`sent_to`, `sent_to_id`, `sent_to_email`, `sent_status`, `read_status`) VALUES ('".$email_id."', '".$sent_to."', '".$sent_to_id."', '".$sent_to_email."', '0', '0')";
						
						$query_insert2 = mysqli_query($link,$sqlinsert2) or die(mysqli_error($link));
						
						if($query_insert2){
							$recepient_id = mysqli_insert_id($link);
							
							$mail = new PHPMailer(); // defaults to using php "mail()"
				
							$mail->IsSendmail(); // telling the class to use SendMail transport
							
							$body = $message;
							
							$mail->SetFrom($editor_email, 'Galaxy Admin');
							
							$mail->AddAddress($sent_to_email);
										
							$mail->Subject = $subject;
							
							$mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
							
							$mail->MsgHTML($body);
							
							if($mail->Send()){
								mysqli_query($link,"UPDATE email_recepients SET sent_status = '1' WHERE recepient_id=".$recepient_id);
							}
						}
					}
					
				}
				
				mysqli_query($link,"UPDATE email SET sent_to_all = 'Writers' WHERE email_id=".$email_id);
				
			}else{
				if($sent_to == 'writer'){
					$sql_email = "SELECT * FROM writers WHERE writer_id = '".$sent_to_id."'";
					$qry_email = mysqli_query($link,$sql_email) or die(mysqli_error($link));
					$rs_email = mysqli_fetch_array($qry_email);
					$sent_to_email = $rs_email['email'];
				}else{
					$sql_email = "SELECT * FROM prime_signup WHERE reg_id = '".$sent_to_id."'";
					$qry_email = mysqli_query($link,$sql_email) or die(mysqli_error($link));
					$rs_email = mysqli_fetch_array($qry_email);
					$sent_to_email = $rs_email['email'];
				}
				
				$sqlinsert2 = "INSERT INTO email_recepients (`email_id`,`sent_to`, `sent_to_id`, `sent_to_email`, `sent_status`, `read_status`) VALUES ('".$email_id."', '".$sent_to."', '".$sent_to_id."', '".$sent_to_email."', '0', '0')";
						
				$query_insert2 = mysqli_query($link,$sqlinsert2) or die(mysqli_error($link));
				
				if($query_insert2){
					$recepient_id = mysqli_insert_id($link);
					
					$mail = new PHPMailer(); // defaults to using php "mail()"
		
					$mail->IsSendmail(); // telling the class to use SendMail transport
					
					$body = $message;
					
					$mail->SetFrom($editor_email, 'Galaxy Admin');
					
					$mail->AddAddress($sent_to_email);
								
					$mail->Subject = $subject;
					
					$mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
					
					$mail->MsgHTML($body);
					
					if($mail->Send()){
						mysqli_query($link,"UPDATE email_recepients SET sent_status = '1' WHERE recepient_id=".$recepient_id);
					}
				}
			}
		}
	}
	
	$errmsg_arr[] = 'Email Successfully Sent';
	$errflag = true;
	if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		header('location:../index.php?page=sent-mail');
	}
	
}

else if( isset($_POST['deny_login']) )
{
	// Your PHP code here

			$admin_id = $_POST['admin_id'];
			
			$sqlupdate = "UPDATE admin_login SET status = 'B' where id = '".$admin_id."'";
					
			//mysqli_query($link,$sqlinsert);
			mysqli_query($link,$sqlupdate) or die(mysqli_error($link));
			
			$errmsg_arr[] = 'Admin successfully denied to login';
$errflag = true;
if($errflag) {
$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		header('location:../index.php?page=users');
			 }
}


//start of deny login
else if( isset($_POST['allow_login']) )
{
	// Your PHP code here

			$admin_id = $_POST['admin_id'];
			
			$sqlupdate = "UPDATE admin_login SET status = 'A' where id = '".$admin_id."'";
					
			//mysqli_query($link,$sqlinsert);
			mysqli_query($link,$sqlupdate) or die(mysqli_error($link));
		
			
			$errmsg_arr[] = 'Admin successfully allowed to login';
$errflag = true;
if($errflag) {
$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		header('location:../index.php?page=users');
			 }
}


		// Start of register user
  else if( isset($_POST['register_user']) )
{
	// Your PHP code here
			
			$fname = $_POST['fname'];
			$sname = $_POST['sname'];
			$username = $_POST['username'];
			$email = $_POST['email'];
			$password = md5($_POST['password']);
			$date = date("Y-m-d");
			
			$sql = mysqli_query($link,"select * from admin_login where email = '$email'");
	
			$count = mysqli_num_rows($sql);
			
			if($count > 0)
			{
				
						$errmsg_arr[] = 'Error! Email already taken';
		$errflag = true;
		if($errflag) {
		$_SESSION['ERRMSG_ARR2'] = $errmsg_arr;
				?>
				<script>
					window.location.assign("../index.php?page=users")
				</script>
		<?php
					exit();
					 }
		
			
			
			}else{
					
					$sqlinsert = "INSERT INTO admin_login (`fname`,`sname`, `username`, `email`, `regDate`, `status`, `password`) VALUES ('".$fname."', '".$sname."', '".$username."', '".$email."', '".$date."', 'A', '".$password."')";
					
							
					//mysqli_query($link,$sqlinsert);
					$query_insert = mysqli_query($link,$sqlinsert) or die(mysqli_error($link));
					
					if($query_insert){
						
						$errmsg_arr[] = 'User account has been successfully added';
					$errflag = true;
					if($errflag) {
					$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
							?>
					<script>
                        window.location.assign("../index.php?page=users")
                    </script>
            <?php
                        exit();
                         }
			 
					}
		 	 
		}

}



else if( isset($_POST['register_title']) )
{
	// Your PHP code here
			
			$title = $_POST['title'];
			$speciality = $_POST['speciality'];
			
					$sqlinsert = "INSERT INTO speciality_titles (`title`,`speciality`) VALUES ('".$title."', '".$speciality."')";
					
							
					//mysqli_query($link,$sqlinsert);
					$query_insert = mysqli_query($link,$sqlinsert) or die(mysqli_error($link));
					
					if($query_insert){
						
						$errmsg_arr[] = 'Title added successfully';
						$errflag = true;
						if($errflag) {
						$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
						
						header("location: ../index.php?page=specialities&".$speciality);
						exit();
                         }
			 
					}

}

else if( isset($_POST['register_payment']) )
{
	// Your PHP code here
			
	$transaction_no = filter_var($_POST["transaction_no"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	$writer_id = $_POST['writer_id'];
	$year = $_POST['year'];
	$mnth_id = $_POST['mnth_id'];
	$paid_account = $_POST['paid_account'];
	
	
	$sql = mysqli_query($link,"SELECT a.job_id, c.fname, c.lname, b.admin_setamount as amount_payable, a.payment_period, b.order_id, b.title_topic, a.paid_status FROM writers_jobs a, prime_order b, writers c WHERE a.order_id = b.order_id AND a.writer_id = c.writer_id AND MONTH(`payment_period`) = '$mnth_id' and YEAR(`payment_period`) = '$year' and a.client_complete = 1 and a.writer_id = '".$writer_id."' order by job_id DESC");
	while($row = mysqli_fetch_array($sql))
	{
		$job_id = $row['job_id'];
		$amount_payable = $row['amount_payable'];
		$bonus = 0;
		$penalty = 0;
		$earnings = $amount_payable + $bonus + $penalty;
		
		$sqlinsert = "INSERT INTO writers_payments (`transaction_no`,`amount_paid`,`paid_account`,`paid_by`,`date_paid`,`job_id`) VALUES ('".$transaction_no."', '".$earnings."', '".$paid_account."', '".$session_id."', NOW(), '".$job_id."')";
		mysqli_query($link,$sqlinsert) or die(mysqli_error($link));
		
		$sqlupdate = "UPDATE writers_jobs SET paid_status = 'paid' where job_id = '".$job_id."'";
		mysqli_query($link,$sqlupdate) or die(mysqli_error($link));
		
	}
	
	
	
	$errmsg_arr[] = 'Payment successfully saved';
	$errflag = true;
	if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		
		header("location: ../index.php?page=earnings-writer&writer_id=".$writer_id);
		exit();
	 }

}


else if( isset($_POST['register_movement']) )
{
	// Your PHP code here
			
	$writer_id = $_POST['writer_id'];
	$year = $_POST['year'];
	$mnth_id = $_POST['mnth_id'];
	
	$sql_te = mysqli_query($link,"SELECT sum(b.admin_setamount) as total_earnings, a.payment_period FROM writers_jobs a, prime_order b, writers c WHERE a.order_id = b.order_id AND a.writer_id = c.writer_id AND MONTH(`payment_period`) = '$mnth_id' and YEAR(`payment_period`) = '$year' and a.client_complete = 1 and a.writer_id = '".$writer_id."'");
	$rs_te = mysqli_fetch_array($sql_te);
	$payment_period = $rs_te['payment_period'];
	
	$sql = mysqli_query($link,"SELECT a.job_id, c.fname, c.lname, b.admin_setamount as amount_payable, a.payment_period, b.order_id, b.title_topic, a.paid_status FROM writers_jobs a, prime_order b, writers c WHERE a.order_id = b.order_id AND a.writer_id = c.writer_id AND MONTH(`payment_period`) = '$mnth_id' and YEAR(`payment_period`) = '$year' and a.client_complete = 1 and a.writer_id = '".$writer_id."' order by job_id DESC");
	while($row = mysqli_fetch_array($sql))
	{
		$job_id = $row['job_id'];
		$new_date = strtotime(date("Y-m-d", strtotime($payment_period)) . " +1 month");
		$new_date = date("Y-m-d",$new_date);
		$sqlupdate = "UPDATE writers_jobs SET payment_period = '".$new_date."' where job_id = '".$job_id."'";
		mysqli_query($link,$sqlupdate) or die(mysqli_error($link));
	}
	
	$errmsg_arr[] = 'Earnings payments has successfully been moved to the next month';
	$errflag = true;
	if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		
		header("location: ../index.php?page=earnings-writer&writer_id=".$writer_id);
		exit();
	 }

}



else if( isset($_POST['register_question']) )
{
	// Your PHP code here
			$test_type = $_POST['test_type'];
			if($test_type == 'language_check'){
				$speciality = "";
				$title_id = "";
				$subtitle_id = "";
				$check = 'language_check';
			}else{
				$speciality = $_POST['speciality'];
				$title_id = $_POST['title_id'];
				$subtitle_id = $_POST['subtitle_id'];
				if($speciality == 'essay_writer'){
					$check = 'essay_check';	
				}else{
					$check = 'technical_check';
				}
			}
			if(isset($_POST['include_passage'])){
				$passage_content = filter_var($_POST["passage_content"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			}else{
				$passage_content = "";
			}
			
			if(isset($_POST['essay'])){
				$essay = 1;
			}else{
				$essay = 0;
			}
			
			$question_no = $_POST['question_no'];
			$question = filter_var($_POST["question"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$marks = filter_var($_POST["marks"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			
			$test_id = $_POST['test_id'];
			
			$sqlupdate = "UPDATE test_questions SET test_type = '".$test_type."', speciality = '".$speciality."', title_id = '".$title_id."', subtitle_id = '".$subtitle_id."', passage = '".$passage_content."', question_no = '".$question_no."', question = '".$question."', marks = '".$marks."', essay = '".$essay."', status = 1 where test_id = '".$test_id."'";
					
			//mysqli_query($link,$sqlinsert);
			$query_question = mysqli_query($link,$sqlupdate) or die(mysqli_error($link));
			if($query_question){
				
				$errmsg_arr[] = 'Question successfully added';
				$errflag = true;
				if($errflag) {
					$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
					if($check == 'language_check'){
						header('location:../index.php?page=questions&l_qn='.$question_no.'&'.$check);
					}else if($check == 'essay_check'){
						header('location:../index.php?page=questions&e_qn='.$question_no.'&'.$check);
					}else{
						header('location:../index.php?page=questions&t_qn='.$question_no.'&'.$check);
					}
				 }
			}
			
			

}



else if( isset($_POST['update_paypal_email']) )
{
	// Your PHP code here

			$paypalemail = $_POST['paypalemail'];
			
			$sqlupdate = "UPDATE prime_paypalset SET paypal_email = '".$paypalemail."'";
					
			//mysqli_query($link,$sqlinsert);
			$query = mysqli_query($link,$sqlupdate) or die(mysqli_error($link));
			
			if($query){
				
				$errmsg_arr[] = 'Successfully updated';
	$errflag = true;
	if($errflag) {
	$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
			header('location:../index.php?page=payment_setting');
				 }
				 
			}else{
				
				$errmsg_arr[] = 'Update failed';
	$errflag = true;
	if($errflag) {
	$_SESSION['ERRMSG_ARR2'] = $errmsg_arr;
			header('location:../index.php?page=payment_setting');
				 }
				
			}

}


else if( isset($_POST['block_writer']) )
{
	// Your PHP code here

			$writer_id = $_POST['writer_id'];
			
			$sqlupdate = "UPDATE writers SET status = 'B' where writer_id = '".$writer_id."'";
					
			//mysqli_query($link,$sqlinsert);
			mysqli_query($link,$sqlupdate) or die(mysqli_error($link));
			
			$errmsg_arr[] = 'Writer successfully blocked';
$errflag = true;
if($errflag) {
$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		header('location:../index.php?page=writers');
			 }

}


else if( isset($_POST['suspend_writer']) )
{
	// Your PHP code here

			$writer_id = $_POST['writer_id'];
			
			$sqlupdate = "UPDATE writers SET status = 'S' where writer_id = '".$writer_id."'";
					
			//mysqli_query($link,$sqlinsert);
			mysqli_query($link,$sqlupdate) or die(mysqli_error($link));
			
			$errmsg_arr[] = 'Writer successfully suspended';
$errflag = true;
if($errflag) {
$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		header('location:../index.php?page=writers');
			 }

}


else if( isset($_POST['activate_writer']) )
{
	// Your PHP code here

			$writer_id = $_POST['writer_id'];
			
			$sqlupdate = "UPDATE writers SET status = 'A' where writer_id = '".$writer_id."'";
					
			//mysqli_query($link,$sqlinsert);
			mysqli_query($link,$sqlupdate) or die(mysqli_error($link));
			
			$errmsg_arr[] = 'Writer successfully activated';
$errflag = true;
if($errflag) {
$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		header('location:../index.php?page=writers');
			 }

}


else if( isset($_POST['timeframe_set']) )
{
	// Your PHP code here

			$timeframe_set = $_POST['timeframe_set']*60*60;
			$order_id = $_POST['order_id'];
			
			$sqlupdate = "UPDATE prime_order SET admin_timeframe = '".$timeframe_set."' where order_id = '".$order_id."'";
					
			//mysqli_query($link,$sqlinsert);
			mysqli_query($link,$sqlupdate) or die(mysqli_error($link));
		
			
			$errmsg_arr[] = 'Timeframe set successfully';
$errflag = true;
if($errflag) {
$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		header('location:../index.php?page=vieworder&orderid='.$order_id);
			 }
}

else if( isset($_POST['timeframe_adjusted']) )
{
	// Your PHP code here

			$timeframe_adjusted = $_POST['timeframe_adjusted']*60*60;
			$order_id = $_POST['order_id'];
			$reason = filter_var($_POST["reason"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH); 
			$datetime = date("Y-m-d H:i:s");
			
			$insert_row = mysqli_query($link,"INSERT INTO adjusted_timeframe(order_id, adjusted_time, reason, adjusted_on, adjusted_by) VALUES('".$order_id."', '".$timeframe_adjusted."', '".$reason."', '".$datetime."', '".$session_id."')")  or die(mysqli_error($link));
			
			if($insert_row){
				
				$errmsg_arr[] = 'Timeframe adjusted successfully';
				$errflag = true;
				if($errflag) {
				$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
						header('location:../index.php?page=vieworder&orderid='.$order_id);
							 }
			
			}
}



else if( isset($_POST['amount_set']) )
{
	// Your PHP code here

			$amount_set = $_POST['amount_set'];
			$order_id = $_POST['order_id'];
			$client_amount = $_POST['client_amount'];
			
			if($amount_set >= $client_amount){
				$errmsg_arr[] = 'Admin set amount cannot be more or equal to client\'s set amount';
	$errflag = true;
	if($errflag) {
	$_SESSION['ERRMSG_ARR2'] = $errmsg_arr;
			header('location:../index.php?page=vieworder&orderid='.$order_id);
				 }
			}else{
				$sqlupdate = "UPDATE prime_order SET admin_setamount = '".$amount_set."' where order_id = '".$order_id."'";
						
				//mysqli_query($link,$sqlinsert);
				mysqli_query($link,$sqlupdate) or die(mysqli_error($link));
			
				
				$errmsg_arr[] = 'Amount set successfully';
	$errflag = true;
	if($errflag) {
	$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
			header('location:../index.php?page=vieworder&orderid='.$order_id);
				 }
			}
}

else if( isset($_POST['edit_amount']) )
{
	// Your PHP code here

			$edit_amount = $_POST['edit_amount'];
			$order_id = $_POST['order_id'];
			$client_amount = $_POST['client_amount'];
			
			if($edit_amount >= $client_amount){
				$errmsg_arr[] = 'Admin set amount cannot be more or equal to client\'s set amount';
	$errflag = true;
	if($errflag) {
	$_SESSION['ERRMSG_ARR2'] = $errmsg_arr;
			header('location:../index.php?page=vieworder&orderid='.$order_id);
				 }
			}else{
				$sqlupdate = "UPDATE prime_order SET admin_setamount = '".$edit_amount."' where order_id = '".$order_id."'";
						
				//mysqli_query($link,$sqlinsert);
				mysqli_query($link,$sqlupdate) or die(mysqli_error($link));
			
				
				$errmsg_arr[] = 'Amount edited successfully';
	$errflag = true;
	if($errflag) {
	$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
			header('location:../index.php?page=vieworder&orderid='.$order_id);
				 }
			}
}

else if( isset($_POST['register_award']) )
{
	// Your PHP code here

	$writer_id = $_POST['writer_id'];
	$order_id = $_POST['order_id'];
	$bid_id = $_POST['bid_id'];
		
	$sqlupdate = "UPDATE writers_bids SET status = '1' where bid_id = '".$bid_id."'";
	
	$update_qry = mysqli_query($link,$sqlupdate) or die(mysqli_error($link));
	if($update_qry){
		$date = date("Y-m-d");
		$query = mysqli_query($link,"INSERT INTO writers_jobs (`writer_id`,`order_id`,`award_type`,`award_dt`,`acceptance_date`,`acceptance_time`,`job_status`) VALUES ('".$writer_id."', '".$order_id."', 'Awarded', NOW(), '".$date."', CURTIME(), 'pending')") or die(mysqli_error($link));
		if($query){
			mysqli_query($link,"UPDATE prime_order SET order_status = '1' where order_id = '".$order_id."'");
			$errmsg_arr[] = 'Writer has been successfully awarded the order';
			$errflag = true;
			if($errflag) {
				$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
				header('location:../index.php?page=viewbids&order_id='.$order_id);
			 }
			
		}
		
		
	}
}

else if( isset($_POST['request_acceptance']) )
{
	// Your PHP code here

	$writer_id = $_POST['writer_id'];
	$order_id = $_POST['order_id'];
	$request_id = $_POST['request_id'];
		
	$sqlupdate = "UPDATE writers_requests SET status = '1' where request_id = '".$request_id."'";
	
	$update_qry = mysqli_query($link,$sqlupdate) or die(mysqli_error($link));
	if($update_qry){
		$date = date("Y-m-d");
		$query = mysqli_query($link,"INSERT INTO writers_jobs (`writer_id`,`order_id`,`award_type`,`award_dt`,`acceptance_date`,`acceptance_time`,`job_status`) VALUES ('".$writer_id."', '".$order_id."', 'Request_Accepted', NOW(), '".$date."', CURTIME(), 'pending')") or die(mysqli_error($link));
		if($query){
			mysqli_query($link,"UPDATE prime_order SET order_status = '1' where order_id = '".$order_id."'");
			$errmsg_arr[] = 'Writer\'s request has been successfully accepted and order awarded';
			$errflag = true;
			if($errflag) {
				$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
				header('location:../index.php?page=viewrequests&order_id='.$order_id);
			 }
			
		}
		
		
	}
}

else if( isset($_POST['update_threshold']) )
{
	// Your PHP code here

	$threshold_amount = $_POST['threshold_amount'];
	$date = date("Y-m-d");
	
	$sqlupdate = "UPDATE writers_threshold SET amount = '".$threshold_amount."', updated_on = NOW(), updated_by = '".$session_id."'";
	
	$update_qry = mysqli_query($link,$sqlupdate) or die(mysqli_error($link));
	if($update_qry){
		$errmsg_arr[] = 'Payment threshold successfully updated';
		$errflag = true;
		if($errflag) {
			$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
			header('location:../index.php?page=settings&subpage=payment_threshold');
		 }
	}
}

else if( isset($_POST['update_percentage']) )
{
	// Your PHP code here

			$item_id = $_POST['item_id'];
			$description = filter_var($_POST["description"],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$percentage = filter_var($_POST["percentage"],FILTER_SANITIZE_NUMBER_INT); 
			
			$sqlupdate = "UPDATE default_percentages SET percentage = '".$percentage."', description = '".$description."' WHERE item_id = '".$item_id."'";
			mysqli_query($link,$sqlupdate) or die(mysqli_error($link));
			
			$errmsg_arr[] = 'Item successfully updated';
			$errflag = true;
			if($errflag) {
				$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
				header('location:../index.php?page=settings&subpage=default_percentage');
			 }
}

else{
	
	echo "ACCESS DENIED!";
}
?>