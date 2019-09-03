<?php
if(!isset($_GET['l_qn'])){
	$l_qn = 1;	
}else{
	$l_qn = $_GET['l_qn'];
}

if(!isset($_GET['e_qn'])){
	$e_qn = 1;	
}else{
	$e_qn = $_GET['e_qn'];
}

if(!isset($_GET['t_qn'])){
	$t_qn = 1;	
}else{
	$t_qn = $_GET['t_qn'];
}
?>
<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Questions
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-files-o"></i> Home</a></li>
            <li class="active">Questions</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
        
        <?php
		if(isset($_GET['add'])){
		$test_id = $_GET['add'];
		$sql_tq = "SELECT * FROM test_questions where test_id = '".$test_id."'";
		$qry_tq = mysqli_query($link,$sql_tq) or die(mysqli_error($link));
		$rs_tq = mysqli_fetch_array($qry_tq);
			$title_id = $rs_tq['title_id'];
			$subtitle_id = $rs_tq['subtitle_id'];
			$passage = $rs_tq['passage'];
			$question_no = $rs_tq['question_no'];
			$question = $rs_tq['question'];
			$marks = $rs_tq['marks'];
			$answer_id = $rs_tq['answer_id'];
			$test_type = $rs_tq['test_type'];
			$speciality = $rs_tq['speciality'];
			$essay = $rs_tq['essay'];
			
			if($test_type == 'speciality_check'){
				$sql_title = "SELECT * FROM speciality_titles where title_id = '".$title_id."'";
				$qry_title = mysqli_query($link,$sql_title) or die(mysqli_error($link));
				$rs_title = mysqli_fetch_array($qry_title);
				$title = $rs_title['title'];
		
				$sql_subtitle = "SELECT * FROM speciality_subtitles where subtitle_id = '".$subtitle_id."'";
				$qry_subtitle = mysqli_query($link,$sql_subtitle) or die(mysqli_error($link));
		
				$count_subtitle = mysqli_num_rows($qry_subtitle);
				if($count_subtitle > 0){
					$rs_subtitle = mysqli_fetch_array($qry_subtitle);
					$subtitle = $rs_subtitle['sub_title'];
				}
			}
		?>
        
        
        <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Add a question</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" id="applicationForm" action="php/register-submit.php" method="post">
                  <div class="box-body">
                  	<div class="form-group">
                      <label for="test_type">Test type</label>
                      <select class="form-control" name="test_type" id="test_type" onchange="showSpeciality()">
                      <?php
					  if($test_type == 'language_check'){
						echo '<option value="'.$test_type.'">Language check</option>';
					  }else if($test_type == 'speciality_check'){
					  	echo '<option value="'.$test_type.'">Speciality check</option>';
					  }else{
						echo '<option></option>';  
					  }
					  ?>
                        <option value="language_check">Language check</option>
                        <option value="speciality_check">Speciality check</option>
                      </select>
                      <input type="hidden" name="test_id" id="test_id" value="<?php echo $_GET['add']; ?>" />
                    </div>
                    <div id="speciality_div" <?php if($test_type == 'language_check' || $test_type == ''){ ?> style="display:none"<?php } ?>>
                    <div class="form-group">
                      <label for="test_type">Speciality</label>
                      <select class="form-control" name="speciality" id="speciality" onchange="changeSpeciality()">
						  <?php
                          if($speciality == 'essay_writer'){
                            echo '<option value="'.$speciality.'">Essay writer</option>';
                          }else if($speciality == 'technical_writer'){
                            echo '<option value="'.$speciality.'">Technical writer</option>';
                          }else{
                            echo '<option></option>';  
                          }
                          ?>
                      	<?php
						$query_speciality = mysqli_query($link, "select * from specialities order by speciality_id asc") or die(mysqli_error($link));
						while ($row_speciality = mysqli_fetch_array($query_speciality)) {
							?>
							<option value="<?php echo $row_speciality['speciality']; ?>"><?php echo $row_speciality['speciality']; ?></option>
							<?php
						}
						?>
                                                                    
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="title">Title</label>
                      <select class="form-control" name="title_id" id="title_id">
                      	<?php
                          if($title_id > 0){
                            echo '<option value="'.$title_id.'">'.$title.'</option>';
                          }else{
                            echo '<option></option>';  
                          }
                          ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="subtitle">Sub title</label>
                      <select class="form-control" name="subtitle_id" id="subtitle_id">
                      	<?php
                          if($subtitle_id > 0){
                            echo '<option value="'.$subtitle_id.'">'.$subtitle.'</option>';
                          }else{
                            echo '<option></option>';  
                          }
                          ?>
                      </select>
                    </div>
                    </div>
                  	<div class="checkbox">
                      <label>
                        <input type="checkbox" id="include_passage" name="include_passage" onclick="includePassage()" <?php if($passage != ''){ ?>checked<?php } ?>> <strong>Include passage</strong>
                      </label>
                    </div>
                    
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" id="essay" name="essay" onclick="includeEssay()" <?php if($essay > 0){ ?>checked<?php } ?>> <strong>Essay</strong>
                      </label>
                    </div>
                    
                    <div id="passage_div" <?php if($passage == ''){ ?> style="display:none"<?php } ?>>
                    <textarea class="textarea" name="passage_content" placeholder="Place your passage here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $passage; ?></textarea>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Question number</label>
                      <input class="form-control" id="question_no" name="question_no" placeholder="Enter number" type="text" value="<?php echo $question_no; ?>">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Question</label>
                    <textarea class="textarea" name="question" placeholder="Place your question here" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $question; ?></textarea>
					</div>
                    <div class="form-group">
                      <label for="marks">Marks</label>
                      <input class="form-control" id="marks" name="marks" placeholder="Enter marks" type="text" value="<?php echo $marks; ?>">
                    </div>
                    
                    <fieldset id="answers_list">
                    
                    <div class="form-group">
                          <label for="title">Answer</label>
                          <input class="form-control" id="answer" name="answer" placeholder="Enter answer" type="text">
                      </div>
                      <a onClick="add_answer()" class="btn btn-default" id="add_answer">Add answer</a>
                      <img src="dist/img/loading.gif" id="LoadingImage" style="display:none" />
          
                    
                    <legend>
                    List of answers
                    </legend>
                    
                    <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th></th>
                        <th>Answer</th>
                        <th>Select correct answer</th>
                      </tr>
                    </thead>
                    <tbody id="response_answer">
                    <?php
					$query_answers = mysqli_query($link, "select * from test_answers where test_id = '".$_GET['add']."'") or die(mysqli_error($link));
                    while ($row_answers = mysqli_fetch_array($query_answers)) 
					{
					  $answer_id = $row_answers['answer_id'];
					  $answer = $row_answers['answer'];
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
					  //echo '<input name="correct_answer" type="radio" onClick="correctAnswer('.$answer_id.')">';
					  if($rs_tq['answer_id'] == $answer_id){
						  echo '<input id="del-'.$answer_id.'" class="correct_answer" name="correct_answer" type="radio" value="'.$answer_id.'" checked="checked">';  
					  }else{
						  echo '<input id="del-'.$answer_id.'" class="correct_answer" name="correct_answer" type="radio" value="'.$answer_id.'">';
					  }
					  echo '</td>';
					  echo '</tr>';
					}
					?>
                    </tbody>
                    </table>
                    </fieldset>
                    
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" name="register_question" class="btn btn-primary">Submit</button>
                  </div>
                </form>
              </div>
        
        
        <?php
		}else{
		?>
        <?php
		if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
		echo '
		<div style="margin:0 auto;" class="alert alert-success" align="center">';
		foreach($_SESSION['ERRMSG_ARR'] as $msg) {
		echo '&nbsp;',$msg;
		}
		echo '</div><br>';
		unset($_SESSION['ERRMSG_ARR']);
		}
		else if( isset($_SESSION['ERRMSG_ARR2']) && is_array($_SESSION['ERRMSG_ARR2']) && count($_SESSION['ERRMSG_ARR2']) >0 ) {
		echo '
		<div style="margin:0 auto;" class="alert alert-danger" align="center"><i class="icon-remove-sign"></i>';
		foreach($_SESSION['ERRMSG_ARR2'] as $msg) {
		echo '&nbsp;',$msg;
		}
		echo '</div><br>';
		unset($_SESSION['ERRMSG_ARR2']);
		}
		?>
        
        <?php
		
		$sql_marks_l = "SELECT sum(marks) FROM test_questions where test_type = 'language_check'";
		$qry_marks_l = mysqli_query($link,$sql_marks_l) or die(mysqli_error($link));
		$rs_marks_l = mysqli_fetch_array($qry_marks_l);
		$total_marks_l = $rs_marks_l['sum(marks)'];
		
		$sql_marks_e = "SELECT sum(marks) FROM test_questions where speciality = 'essay_writer'";
		$qry_marks_e = mysqli_query($link,$sql_marks_e) or die(mysqli_error($link));
		$rs_marks_e = mysqli_fetch_array($qry_marks_e);
		$total_marks_e = $rs_marks_e['sum(marks)'];
		
		$sql_marks_t = "SELECT sum(marks) FROM test_questions where speciality = 'technical_writer'";
		$qry_marks_t = mysqli_query($link,$sql_marks_t) or die(mysqli_error($link));
		$rs_marks_t = mysqli_fetch_array($qry_marks_t);
		$total_marks_t = $rs_marks_t['sum(marks)'];
		
		$sql_time_l = "SELECT time FROM test_time where test_type = 'language_check'";
		$qry_time_l = mysqli_query($link,$sql_time_l) or die(mysqli_error($link));
		$rs_time_l = mysqli_fetch_array($qry_time_l);
		$language_time = $rs_time_l['time']/60;
		
		$sql_time_e = "SELECT time FROM test_time where test_type = 'essay_check'";
		$qry_time_e = mysqli_query($link,$sql_time_e) or die(mysqli_error($link));
		$rs_time_e = mysqli_fetch_array($qry_time_e);
		$essay_time = $rs_time_e['time']/60;
		
		$sql_time_t = "SELECT time FROM test_time where test_type = 'technical_check'";
		$qry_time_t = mysqli_query($link,$sql_time_t) or die(mysqli_error($link));
		$rs_time_t = mysqli_fetch_array($qry_time_t);
		$technical_time = $rs_time_t['time']/60;
		
		?>
        
          <a onclick="addQuestion()" id="addQuestion" href="javascript:void()" class="btn btn-primary pull-right" style="margin:10px">Add a question</a>
          <img src="dist/img/loading.gif" id="LoadingImage2" class="pull-right" style="display:none; margin:10px" />
                 
          <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li <?php if(isset($_GET['language_check'])){ ?>class="active"<?php }else if(!isset($_GET['essay_check']) and !isset($_GET['technical_check'])){ ?>class="active"<?php } ?>><a aria-expanded="true" href="#tab_1" data-toggle="tab">Language check</a></li>
                  <li <?php if(isset($_GET['essay_check'])){ ?>class="active"<?php } ?>><a aria-expanded="false" href="#tab_2" data-toggle="tab">Essay check</a></li>
                  <li <?php if(isset($_GET['technical_check'])){ ?>class="active"<?php } ?>><a aria-expanded="false" href="#tab_3" data-toggle="tab">Technical check</a></li>
                </ul>
                <div class="tab-content">
                
                  <div class="tab-pane<?php if(isset($_GET['language_check'])){ ?> active<?php }else if(!isset($_GET['essay_check']) and !isset($_GET['technical_check'])){ ?> active<?php } ?>" id="tab_1">
                  
                  <p><strong>Total:</strong> <?php echo $total_marks_l." marks"; ?> <span class="pull-right"><strong>Time:</strong> <a data-toggle='modal' href='#timeModal'><?php if($language_time > 0){ echo '<span id="time_set">'.$language_time." mins</span>"; }else{ echo "<span id='time_set'>Set time</span>"; } ?></a></span></p>
                  
                  <div class="modal fade" id="timeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                <form role="form" action="php/register-submit.php" method="post">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Set time to complete the language check</h4>
                  </div>
                  <div class="modal-body">
                    
                  <div class="box-body">
                  	<div class="form-group">
                      <label for="title">Time in minutes</label>
                      <input class="form-control" id="language_time" name="language_time" placeholder="Enter time in minutes" type="text" value="<?php echo $language_time; ?>" />
                    </div>
                  </div>
                    
                </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <a onClick="set_language_time()" class="btn btn-primary" id="set_language_time">Save</a>
                    <img src="dist/img/loading.gif" id="LoadingImage_time_l" style="display:none" />
                  </div>
                </form>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div>
                  
                    <?php
$sql = "SELECT * FROM test_questions where test_type = 'language_check'";
$qry = mysqli_query($link,$sql) or die(mysqli_error($link));
$count = mysqli_num_rows($qry);
if($count > 0){
while ($rs = mysqli_fetch_array($qry)) {
    $test_id = $rs['test_id'];
    $title_id = $rs['title_id'];
	$subtitle_id = $rs['subtitle_id'];
	$passage = $rs['passage'];
	$question_no = $rs['question_no'];
	$question = $rs['question'];
	$marks = $rs['marks'];
	$answer_id = $rs['answer_id'];
	$test_type = $rs['test_type'];
	?>
    <div <?php if($question_no != $l_qn){ ?>style="display:none"<?php } ?>>
    
    <h4 class="page-header">Question No. <?php echo $question_no; ?> 
    
    <a href="?page=questions&add=<?php echo $test_id; ?>" class="pull-right"><i class="fa fa-edit"></i> Edit</a></h4>
    <?php
	if($test_type == 'speciality_check'){
		$sql_title = "SELECT * FROM speciality_titles where title_id = '".$title_id."'";
		$qry_title = mysqli_query($link,$sql_title) or die(mysqli_error($link));
		$rs_title = mysqli_fetch_array($qry_title);
		$title = $rs_title['title'];
		
		$sql_subtitle = "SELECT * FROM speciality_subtitles where title_id = '".$title_id."'";
		$qry_subtitle = mysqli_query($link,$sql_subtitle) or die(mysqli_error($link));
	?>
	<h2 class="page-header">
        <i class="fa fa-circle-o text-red"></i> <?php echo $title; ?>
        <?php  
		$count_subtitle = mysqli_num_rows($qry_subtitle);
		if($count_subtitle > 0){
			$rs_subtitle = mysqli_fetch_array($qry_subtitle);
			$subtitle = $rs_subtitle['sub_title'];
		?>
        <small class="pull-right"><?php echo $subtitle; ?></small>
        <?php
		}
		?>
      </h2>
	<?php
	}
	
	//QUESTION BEGINS HERE	
	
	if($passage != ''){
		echo '<textarea class="textarea" name="passage_content" id="content" placeholder="Place your passage here" style="width: 100%; height: 300px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" readonly="readonly">'.$passage.'</textarea>';
		echo '<hr />';
	}
	
	//QUESTION
	?>
    <p><strong><?php echo $question." (".$marks." marks)"; ?></strong></p>
    
    <table class="table table-bordered table-striped">
        <?php
        $query_ta = mysqli_query($link, "select * from test_answers where test_id = '".$test_id."'") or die(mysqli_error($link));
        while ($row_ta = mysqli_fetch_array($query_ta)) 
        {
          $answer = $row_ta['answer'];
          echo '<tr>';
		  echo '<td>';
          //echo '<input name="correct_answer" type="radio" onClick="correctAnswer('.$answer_id.')">';
          if($row_ta['answer_id'] == $rs['answer_id']){
              echo '<input type="radio" checked="checked">';  
          }else{
              echo '<input type="radio">';
          }
          echo '</td>';
          echo '<td>';
          echo $answer;
          echo '</td>';
          echo '</tr>';
        }
        ?>
    </table>
    
    <hr />
    
    <div align="center">
         <ul class="pagination">
         <?php
        $query_pg = mysqli_query($link, "select * from test_questions where test_type = 'language_check' order by question_no asc") or die(mysqli_error($link));
        while ($row_pg = mysqli_fetch_array($query_pg)) 
        {
          $question_no = $row_pg['question_no'];
		  ?>
          <li <?php if($row_pg['question_no'] == $rs['question_no']){ ?>class="active"<?php } ?>><a href="?page=questions&l_qn=<?php echo $question_no; ?>"><?php echo $question_no; ?></a></li>
          <?php
		}
		 ?>
         </ul>
    </div>
    
    </div>
                    
    <?php
}
}else{
	
	echo "<p>No questions submitted</p>";	
}
					?>
          
                    
                    
                  </div><!-- /.tab-pane -->
                  
                  
                  
                  
                  <!-- START OF TAB 2 -->
                  
                  <div class="tab-pane<?php if(isset($_GET['essay_check'])){ ?> active<?php } ?>" id="tab_2">
                 
                 <p><strong>Total:</strong> <?php echo $total_marks_e." marks"; ?> <span class="pull-right"><strong>Time:</strong> <a data-toggle='modal' href='#timeModal_e'><?php if($essay_time > 0){ echo '<span id="time_set_e">'.$essay_time." mins</span>"; }else{ echo "<span id='time_set_e'>Set time</span>"; } ?></a></span></p>
                  
                  <div class="modal fade" id="timeModal_e" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                <form role="form" action="php/register-submit.php" method="post">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Set time to complete the language check</h4>
                  </div>
                  <div class="modal-body">
                    
                  <div class="box-body">
                  	<div class="form-group">
                      <label for="title">Time in minutes</label>
                      <input class="form-control" id="essay_time" name="essay_time" placeholder="Enter time in minutes" type="text" value="<?php echo $essay_time; ?>" />
                    </div>
                  </div>
                    
                </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <a onClick="set_essay_time()" class="btn btn-primary" id="set_essay_time">Save</a>
                    <img src="dist/img/loading.gif" id="LoadingImage_time_e" style="display:none" />
                  </div>
                </form>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div>
            
 <?php
$sql = "SELECT * FROM test_questions where test_type = 'speciality_check' and speciality = 'essay_writer'";
$qry = mysqli_query($link,$sql) or die(mysqli_error($link));
$count = mysqli_num_rows($qry);
if($count > 0){
while ($rs = mysqli_fetch_array($qry)) {
    $test_id = $rs['test_id'];
    $title_id = $rs['title_id'];
	$subtitle_id = $rs['subtitle_id'];
	$passage = $rs['passage'];
	$question_no = $rs['question_no'];
	$question = $rs['question'];
	$marks = $rs['marks'];
	$answer_id = $rs['answer_id'];
	$test_type = $rs['test_type'];
	?>
    <div <?php if($question_no != $e_qn){ ?>style="display:none"<?php } ?>>
    
    <h4 class="page-header">Question No. <?php echo $question_no; ?> 
    
    <a href="?page=questions&add=<?php echo $test_id; ?>" class="pull-right"><i class="fa fa-edit"></i> Edit</a></h4>
    <?php
	if($test_type == 'speciality_check'){
		$sql_title = "SELECT * FROM speciality_titles where title_id = '".$title_id."'";
		$qry_title = mysqli_query($link,$sql_title) or die(mysqli_error($link));
		$rs_title = mysqli_fetch_array($qry_title);
		$title = $rs_title['title'];
		
		$sql_subtitle = "SELECT * FROM speciality_subtitles where title_id = '".$title_id."'";
		$qry_subtitle = mysqli_query($link,$sql_subtitle) or die(mysqli_error($link));
	?>
	<h2 class="page-header">
        <i class="fa fa-circle-o text-red"></i> <?php echo $title; ?>
        <?php  
		$count_subtitle = mysqli_num_rows($qry_subtitle);
		if($count_subtitle > 0){
			$rs_subtitle = mysqli_fetch_array($qry_subtitle);
			$subtitle = $rs_subtitle['sub_title'];
		?>
        <small class="pull-right"><?php echo $subtitle; ?></small>
        <?php
		}
		?>
      </h2>
	<?php
	}
	
	//QUESTION BEGINS HERE	
	
	if($passage != ''){
		echo '<textarea class="textarea" name="passage_content" id="content" placeholder="Place your passage here" style="width: 100%; height: 300px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" readonly="readonly">'.$passage.'</textarea>';
		echo '<hr />';
	}
	
	//QUESTION
	?>
    <p><strong><?php echo $question." (".$marks." marks)"; ?></strong></p>
    
    <table class="table table-bordered table-striped">
        <?php
        $query_ta = mysqli_query($link, "select * from test_answers where test_id = '".$test_id."'") or die(mysqli_error($link));
        while ($row_ta = mysqli_fetch_array($query_ta)) 
        {
          $answer = $row_ta['answer'];
          echo '<tr>';
		  echo '<td>';
          //echo '<input name="correct_answer" type="radio" onClick="correctAnswer('.$answer_id.')">';
          if($row_ta['answer_id'] == $rs['answer_id']){
              echo '<input type="radio" checked="checked">';  
          }else{
              echo '<input type="radio">';
          }
          echo '</td>';
          echo '<td>';
          echo $answer;
          echo '</td>';
          echo '</tr>';
        }
        ?>
    </table>
    
    <hr />
    
    <div align="center">
         <ul class="pagination">
         <?php
        $query_pg = mysqli_query($link, "select * from test_questions where speciality = 'essay_writer' order by question_no asc") or die(mysqli_error($link));
        while ($row_pg = mysqli_fetch_array($query_pg)) 
        {
          $question_no = $row_pg['question_no'];
		  ?>
          <li <?php if($row_pg['question_no'] == $rs['question_no']){ ?>class="active"<?php } ?>><a href="?page=questions&e_qn=<?php echo $question_no; ?>"><?php echo $question_no; ?></a></li>
          <?php
		}
		 ?>
         </ul>
    </div>
    
    </div>
                    
    <?php
}
}else{
	
	echo "<p>No questions submitted</p>";	
}
					?>
                    
                    
                  </div><!-- /.tab2-pane -->
                  
                  
                  
                  
                  <!-- START OF TAB 3 -->
                  
                  <div class="tab-pane<?php if(isset($_GET['technical_check'])){ ?> active<?php } ?>" id="tab_3">
                  
                  <p><strong>Total:</strong> <?php echo $total_marks_t." marks"; ?> <span class="pull-right"><strong>Time:</strong> <a data-toggle='modal' href='#timeModal_t'><?php if($technical_time > 0){ echo '<span id="time_set_t">'.$technical_time." mins</span>"; }else{ echo "<span id='time_set_t'>Set time</span>"; } ?></a></span></p>
                  
                  <div class="modal fade" id="timeModal_t" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                <form role="form" action="php/register-submit.php" method="post">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Set time to complete the language check</h4>
                  </div>
                  <div class="modal-body">
                    
                  <div class="box-body">
                  	<div class="form-group">
                      <label for="title">Time in minutes</label>
                      <input class="form-control" id="technical_time" name="technical_time" placeholder="Enter time in minutes" type="text" value="<?php echo $technical_time; ?>" />
                    </div>
                  </div>
                    
                </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <a onClick="set_technical_time()" class="btn btn-primary" id="set_technical_time">Save</a>
                    <img src="dist/img/loading.gif" id="LoadingImage_time_t" style="display:none" />
                  </div>
                </form>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div>
                    
                    <?php
$sql = "SELECT * FROM test_questions where test_type = 'speciality_check' and speciality = 'technical_writer'";
$qry = mysqli_query($link,$sql) or die(mysqli_error($link));
$count = mysqli_num_rows($qry);
if($count > 0){
while ($rs = mysqli_fetch_array($qry)) {
    $test_id = $rs['test_id'];
    $title_id = $rs['title_id'];
	$subtitle_id = $rs['subtitle_id'];
	$passage = $rs['passage'];
	$question_no = $rs['question_no'];
	$question = $rs['question'];
	$marks = $rs['marks'];
	$answer_id = $rs['answer_id'];
	$test_type = $rs['test_type'];
	
	?>
	
<div <?php if($question_no != $t_qn){ ?>style="display:none"<?php } ?>>
    
    <h4 class="page-header">Question No. <?php echo $question_no; ?> 
    
    <a href="?page=questions&add=<?php echo $test_id; ?>" class="pull-right"><i class="fa fa-edit"></i> Edit</a></h4>
    <?php
	if($test_type == 'speciality_check'){
		$sql_title = "SELECT * FROM speciality_titles where title_id = '".$title_id."'";
		$qry_title = mysqli_query($link,$sql_title) or die(mysqli_error($link));
		$rs_title = mysqli_fetch_array($qry_title);
		$title = $rs_title['title'];
		
		$sql_subtitle = "SELECT * FROM speciality_subtitles where title_id = '".$title_id."'";
		$qry_subtitle = mysqli_query($link,$sql_subtitle) or die(mysqli_error($link));
	?>
	<h2 class="page-header">
        <i class="fa fa-circle-o text-red"></i> <?php echo $title; ?>
        <?php  
		$count_subtitle = mysqli_num_rows($qry_subtitle);
		if($count_subtitle > 0){
			$rs_subtitle = mysqli_fetch_array($qry_subtitle);
			$subtitle = $rs_subtitle['sub_title'];
		?>
        <small class="pull-right"><?php echo $subtitle; ?></small>
        <?php
		}
		?>
      </h2>
	<?php
	}
	
	//QUESTION BEGINS HERE	
	
	if($passage != ''){
		echo '<textarea class="textarea" name="passage_content" id="content" placeholder="Place your passage here" style="width: 100%; height: 300px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" readonly="readonly">'.$passage.'</textarea>';
		echo '<hr />';
	}
	
	//QUESTION
	?>
    <p><strong><?php echo $question." (".$marks." marks)"; ?></strong></p>
    
    <table class="table table-bordered table-striped">
        <?php
        $query_ta = mysqli_query($link, "select * from test_answers where test_id = '".$test_id."'") or die(mysqli_error($link));
        while ($row_ta = mysqli_fetch_array($query_ta)) 
        {
          $answer = $row_ta['answer'];
          echo '<tr>';
		  echo '<td>';
          //echo '<input name="correct_answer" type="radio" onClick="correctAnswer('.$answer_id.')">';
          if($row_ta['answer_id'] == $rs['answer_id']){
              echo '<input type="radio" checked="checked">';  
          }else{
              echo '<input type="radio">';
          }
          echo '</td>';
          echo '<td>';
          echo $answer;
          echo '</td>';
          echo '</tr>';
        }
        ?>
    </table>
    
    <hr />
    
    <div align="center">
         <ul class="pagination">
         <?php
        $query_pg = mysqli_query($link, "select * from test_questions where speciality = 'technical_writer' order by question_no asc") or die(mysqli_error($link));
        while ($row_pg = mysqli_fetch_array($query_pg)) 
        {
          $question_no = $row_pg['question_no'];
		  ?>
          <li <?php if($row_pg['question_no'] == $rs['question_no']){ ?>class="active"<?php } ?>><a href="?page=questions&t_qn=<?php echo $question_no; ?>"><?php echo $question_no; ?></a></li>
          <?php
		}
		 ?>
         </ul>
    </div>
    
    </div>
                    
    <?php
}
}else{
	echo "<p>No questions submitted</p>";	
}
					?>
                    
                    
                  </div><!-- /.tab3-pane -->
                  
                  
                  
                  
                  
                </div><!-- /.tab-content -->
              </div>
              
              <?php
		}
			  ?>
          

        </section><!-- /.content -->

<script src="plugins/jQuery/jquery-2.2.3.min.js"></script> 
<script type="text/javascript">
	
	$(function () {
		
		<?php
		if(isset($_GET['add'])){
			$test_id = $_GET['add'];
		?>
		  //##### Send delete Ajax request to response.php #########
		$("body").on("click", "#response_answer .correct_answer", function() {
			 var clickedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
			 var DbNumberID = clickedID[1]; //and get number from array
			 var myData = 'correct_answer='+ DbNumberID + '&test_id=<?php echo $test_id; ?>'; //build a post data structure
			
				jQuery.ajax({
				type: "POST", // HTTP method POST or GET
				url: "php/response.php", //Where to make Ajax calls
				dataType:"text", // Data type, HTML, json etc.
				data:myData, //Form variables
				success:function(response){
					//success
				},
				error:function (xhr, ajaxOptions, thrownError){
					//On error, we alert user
					alert(thrownError);
				}
				});
		});
		
		//##### Send delete Ajax request to response.php #########
		$("body").on("click", "#response_subtitle .del_button", function(e) {
			 e.preventDefault();
			 var clickedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
			 var DbNumberID = clickedID[1]; //and get number from array
			 var myData = 'delete_subtitle='+ DbNumberID; //build a post data structure
			 
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
		
		
	
		// anonymous function assigned to onchange event of controlling select box
		document.forms['applicationForm'].elements['title_id'].onchange = function(e) {
			// name of associated select box
			var relName = 'subtitle_id';
			
			// reference to associated select box 
			var relList = this.form.elements[ relName ];
			
			// get data from object literal based on selection in controlling select box (this.value)
			var obj = Select_List_Data[ relName ][ this.value ];
			
			// remove current option elements
			removeAllOptions(relList, true);
			
			// call function to add optgroup/option elements
			// pass reference to associated select box and data for new options
			appendDataToSelect(relList, obj);
		};
		
		
		// populate associated select box as page loads
		(function() { // immediate function to avoid globals
			
			var form = document.forms['applicationForm'];
			
			// reference to controlling select box
			var sel = form.elements['title_id'];
			sel.selectedIndex = 0;
			
			// name of associated select box
			var relName = 'subtitle_id';
			// reference to associated select box
			var rel = form.elements[ relName ];
			
			// get data for associated select box passing its name
			// and value of selected in controlling select box
			var data = Select_List_Data[ relName ][ sel.value ];
			
			// add options to associated select box
			appendDataToSelect(rel, data);
			
		}());
		
		<?php
		}
		?>
		
	});
	
	function set_language_time(){
		
		if($("#language_time").val()==='')
		{
			alert("Please enter time");
			return false;
		}
		
		$("#set_language_time").hide(); //hide submit button
		$("#LoadingImage_time_l").show(); //show loading image
		var language_time = $("#language_time").val();
		var myData = 'language_time='+ language_time; //build a post data structure
		jQuery.ajax({
		type: "POST", // HTTP method POST or GET
		url: "php/response.php", //Where to make Ajax calls
		dataType:"text", // Data type, HTML, json etc.
		data:myData, //Form variables
		success:function(response){
			$("#time_set").html(response);
			$("#set_language_time").show(); //show submit button
			$("#LoadingImage_time_l").hide(); //hide loading image
			$("#timeModal").modal('hide'); //hide modal
			
		},
		error:function (xhr, ajaxOptions, thrownError){
			$("#set_language_time").show(); //show submit button
			$("#LoadingImage_time_l").hide(); //hide loading image
			alert(thrownError);
		}
		});
	}	
	
	
	function set_essay_time(){
		
		if($("#essay_time").val()==='')
		{
			alert("Please enter time");
			return false;
		}
		
		$("#set_essay_time").hide(); //hide submit button
		$("#LoadingImage_time_e").show(); //show loading image
		var essay_time = $("#essay_time").val();
		var myData = 'essay_time='+ essay_time; //build a post data structure
		jQuery.ajax({
		type: "POST", // HTTP method POST or GET
		url: "php/response.php", //Where to make Ajax calls
		dataType:"text", // Data type, HTML, json etc.
		data:myData, //Form variables
		success:function(response){
			$("#time_set_e").html(response);
			$("#set_essay_time").show(); //show submit button
			$("#LoadingImage_time_e").hide(); //hide loading image
			$("#timeModal_e").modal('hide'); //hide modal
			
		},
		error:function (xhr, ajaxOptions, thrownError){
			$("#set_essay_time").show(); //show submit button
			$("#LoadingImage_time_e").hide(); //hide loading image
			alert(thrownError);
		}
		});
	}	
	
	
	function set_technical_time(){
		
		if($("#technical_time").val()==='')
		{
			alert("Please enter time");
			return false;
		}
		
		$("#set_technical_time").hide(); //hide submit button
		$("#LoadingImage_time_t").show(); //show loading image
		var technical_time = $("#technical_time").val();
		var myData = 'technical_time='+ technical_time; //build a post data structure
		jQuery.ajax({
		type: "POST", // HTTP method POST or GET
		url: "php/response.php", //Where to make Ajax calls
		dataType:"text", // Data type, HTML, json etc.
		data:myData, //Form variables
		success:function(response){
			$("#time_set_t").html(response);
			$("#set_technical_time").show(); //show submit button
			$("#LoadingImage_time_t").hide(); //hide loading image
			$("#timeModal_t").modal('hide'); //hide modal
			
		},
		error:function (xhr, ajaxOptions, thrownError){
			$("#set_technical_time").show(); //show submit button
			$("#LoadingImage_time_t").hide(); //hide loading image
			alert(thrownError);
		}
		});
	}	
	
	
	function addQuestion(){
		$("#addQuestion").hide(); //hide submit button
		$("#LoadingImage2").show(); //show loading image
		var myData = 'add_question=1'; //build a post data structure
		jQuery.ajax({
		type: "POST", // HTTP method POST or GET
		url: "php/response.php", //Where to make Ajax calls
		dataType:"text", // Data type, HTML, json etc.
		data:myData, //Form variables
		success:function(response){
			window.location.assign("?page=questions&add="+response);
		},
		error:function (xhr, ajaxOptions, thrownError){
			$("#addQuestion").show(); //show submit button
			$("#LoadingImage2").hide(); //hide loading image
			alert(thrownError);
		}
		});
	}
	
	function includePassage() {
		if(document.getElementById('include_passage').checked) {
			$("#passage_div").show();
		}else {
			$("#passage_div").hide();
		}
	}
	function includeEssay() {
		if(document.getElementById('essay').checked) {
			$("#answers_list").hide();
		}else {
			$("#answers_list").show();
		}
	}
	function showSpeciality() {
		var test_type = $("#test_type").val();
		if(test_type === 'speciality_check') {
			$("#speciality_div").show();
		}else {
			$("#speciality_div").hide();
		}
	}
	
	<?php
	if(isset($_GET['add'])){
		$test_id = $_GET['add'];
	?>
	function add_answer(){
		
		if($("#answer").val()==='')
		{
			alert("Please enter answer");
			return false;
		}
		
		$("#add_answer").hide(); //hide submit button
		$("#LoadingImage").show(); //show loading image
		var answer = $("#answer").val();
		var myData = 'answer='+ answer +'&test_id=<?php echo $_GET['add']; ?>&add_answer=1'; //build a post data structure
		jQuery.ajax({
		type: "POST", // HTTP method POST or GET
		url: "php/response.php", //Where to make Ajax calls
		dataType:"text", // Data type, HTML, json etc.
		data:myData, //Form variables
		success:function(response){
			$("#response_answer").append(response);
			$("#answer").val('');
			$("#add_answer").show(); //show submit button
			$("#LoadingImage").hide(); //hide loading image
			
		},
		error:function (xhr, ajaxOptions, thrownError){
			$("#add_answer").show(); //show submit button
			$("#LoadingImage").hide(); //hide loading image
			alert(thrownError);
		}
		});
	}	
	<?php
	}
	?>
			
// object literal holding data for option elements
var Select_List_Data = {
    
    'title_id': { // name of associated select box
        
        // names match option values in controlling select box
        <?php
		$query_speciality = mysqli_query($link, "select * from specialities order by speciality_id asc") or die(mysqli_error($link));
        while ($row_speciality = mysqli_fetch_array($query_speciality)) {
			$speciality = $row_speciality['speciality'];
		
		echo $speciality;  ?>: {
            text: [<?php
					$title = array();
					$query_title = mysqli_query($link, "select title from speciality_titles where speciality = '".$speciality."'") or die(mysqli_error($link));
					while ($row_title = mysqli_fetch_array($query_title)) {
						$title[] = "'".$row_title['title']."'";
					}
					echo implode(', ', $title);
					?>],
            value: [<?php
					$title_id = array();
					$query_title = mysqli_query($link, "select title_id from speciality_titles where speciality = '".$speciality."'") or die(mysqli_error($link));
					while ($row_title = mysqli_fetch_array($query_title)) {
						$title_id[] = "'".$row_title['title_id']."'";
					}
					echo implode(', ', $title_id);
					?>]
        },
       <?php
		}
	   ?>
    
    },
	
	 'subtitle_id': { // name of associated select box
        
        // names match option values in controlling select box
        <?php
		$query_title = mysqli_query($link, "select title_id from speciality_titles") or die(mysqli_error($link));
		while ($row_title = mysqli_fetch_array($query_title)) {
			$title_id = $row_title['title_id'];
		
		echo $title_id;  ?>: {
            text: [<?php
					$sub_title = array();
					$query_subtitle = mysqli_query($link, "select sub_title from speciality_subtitles where title_id = '".$title_id."'") or die(mysqli_error($link));
					while ($row_subtitle = mysqli_fetch_array($query_subtitle)) {
						$sub_title[] = "'".$row_subtitle['sub_title']."'";
					}
					echo implode(', ', $sub_title);
					?>],
            value: [<?php
					$subtitle_id = array();
					$query_subtitle = mysqli_query($link, "select subtitle_id from speciality_subtitles where title_id = '".$title_id."'") or die(mysqli_error($link));
					while ($row_subtitle = mysqli_fetch_array($query_subtitle)) {
						$subtitle_id[] = "'".$row_subtitle['subtitle_id']."'";
					}
					echo implode(', ', $subtitle_id);
					?>]
        },
		
       <?php
		}
	   ?>
    
    }    
};


// removes all option elements in select box 
// removeGrp (optional) boolean to remove optgroups
function removeAllOptions(sel, removeGrp) {
    var len, groups, par;
    if (removeGrp) {
        groups = sel.getElementsByTagName('optgroup');
        len = groups.length;
        for (var i=len; i; i--) {
            sel.removeChild( groups[i-1] );
        }
    }
    
    len = sel.options.length;
    for (var i=len; i; i--) {
        par = sel.options[i-1].parentNode;
        par.removeChild( sel.options[i-1] );
    }
}

function appendDataToSelect(sel, obj) {
    var f = document.createDocumentFragment();
    var labels = [], group, opts;
    
    function addOptions(obj) {
        var f = document.createDocumentFragment();
        var o;
        
        for (var i=0, len=obj.text.length; i<len; i++) {
            o = document.createElement('option');
            o.appendChild( document.createTextNode( obj.text[i] ) );
            
            if ( obj.value ) {
                o.value = obj.value[i];
            }
            
            f.appendChild(o);
        }
        return f;
    }
    
    if ( obj.text ) {
        opts = addOptions(obj);
        f.appendChild(opts);
    } else {
        for ( var prop in obj ) {
            if ( obj.hasOwnProperty(prop) ) {
                labels.push(prop);
            }
        }
        
        for (var i=0, len=labels.length; i<len; i++) {
            group = document.createElement('optgroup');
            group.label = labels[i];
            f.appendChild(group);
            opts = addOptions(obj[ labels[i] ] );
            group.appendChild(opts);
        }
    }
    sel.appendChild(f);
}




// anonymous function assigned to onchange event of controlling select box
document.forms['applicationForm'].elements['speciality'].onchange = function(e) {
    // name of associated select box
    var relName = 'title_id';
	
	//var relName2 = 'subtitle_id';
    
    // reference to associated select box 
    var relList = this.form.elements[ relName ];
	
	//var relList2 = this.form.elements[ relName2 ];
    
    // get data from object literal based on selection in controlling select box (this.value)
    var obj = Select_List_Data[ relName ][ this.value ];
    
    // remove current option elements
    removeAllOptions(relList, true);
	//removeAllOptions(relList2, true);
    
    // call function to add optgroup/option elements
    // pass reference to associated select box and data for new options
    appendDataToSelect(relList, obj);
};


// populate associated select box as page loads
(function() { // immediate function to avoid globals
    
    var form = document.forms['applicationForm'];
    
    // reference to controlling select box
    var sel = form.elements['speciality'];
    sel.selectedIndex = 0;
    
    // name of associated select box
    var relName = 'title_id';
    // reference to associated select box
    var rel = form.elements[ relName ];
    
    // get data for associated select box passing its name
    // and value of selected in controlling select box
    var data = Select_List_Data[ relName ][ sel.value ];
    
    // add options to associated select box
    appendDataToSelect(rel, data);
    
}());

		</script>
       