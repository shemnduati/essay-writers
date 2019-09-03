<?php

class Upload {
	
  protected $_uploaded = array();
  protected $_destination;
  protected $_max = 51200;
  protected $_messages = array();
  protected $_permitted = array('image/gif',
								'image/jpeg',
								'image/pjpeg',
								'image/png',
          'application/msword','application/mspowerpoint','application/vnd.ms-powerpoint','application/mspowerpoint',
      'application/powerpoint','application/vnd.ms-powerpoint','application/x-mspowerpoint','application/vnd.ms-excel',
      'application/x-excel','application/x-msexcel','application/excel','image/gif','application/msword','application/pdf','application/rtf','text/plain',
      'application/vnd.openxmlformats-officedocument.word'
      
      
      
      );
  protected $_renamed = false;

  public function __construct($path) {
	if (!is_dir($path) || !is_writable($path)) {
	  throw new Exception("$path must be a valid, writable directory.");
	}
	$this->_destination = $path;
	$this->_uploaded = $_FILES;
  }

  public function getMaxSize() {
	return number_format($this->_max/1024, 1) . 'kB';
  }

  public function setMaxSize($num) {
	if (!is_numeric($num)) {
	  throw new Exception("Maximum size must be a number.");
	}
	$this->_max = (int) $num;
  }

  public function move($id,$overwrite = false) {
	$field = current($this->_uploaded);
	if (is_array($field['name'])) {
	  foreach ($field['name'] as $number => $filename) {
		// process multiple upload
		$this->_renamed = false;
		$name=$this->processFile($id,$filename, $field['error'][$number], $field['size'][$number], $field['type'][$number], $field['tmp_name'][$number], $overwrite);	
                                     $data="download.php?filename=".$name; 
                                    if($name){
                                    $this->save_to_db($id, $name, $data, $field['type'][$number]);
                                    }  else {
                                    $this->_messages[] = "Error uploading $filename. Please try again.";    
                                    }
                
                
                
          }
	} else {
	 $name= $this->processFile($id,$field['name'], $field['error'], $field['size'], $field['type'], $field['tmp_name'], $overwrite);
                                  $data="download.php?filename=".$name; 
                   if($name){
                                    $this->save_to_db($id, $name, $data,$field['type']);
                                    }  else {
                                    $this->_messages[] = "Error uploading $filename. Please try again.";    
                                    }
         
	}
  }

  public function getMessages() {
	return $this->_messages;
  }
  
  protected function checkError($filename, $error) {
	switch ($error) {
	  case 0:
		return true;
	  case 1:
	  case 2:
	    $this->_messages[] = "$filename exceeds maximum size: " . $this->getMaxSize();
		return true;
	  case 3:
		$this->_messages[] = "Error uploading $filename. Please try again.";
		return false;
	  case 4:
		$this->_messages[] = 'No file selected.';
		return false;
	  default:
		$this->_messages[] = "System error uploading $filename. Contact webmaster.";
		return false;
	}
  }

  protected function checkSize($filename, $size) {
	if ($size == 0) {
	  return false;
	} elseif ($size > $this->_max) {
	  $this->_messages[] = "$filename exceeds maximum size: " . $this->getMaxSize();
	  return false;
	} else {
	  return true;
	}
  }
  
  protected function checkType($filename, $type) {
	if (empty($type)) {
	  return false;
	} elseif (!in_array($type, $this->_permitted)) {
	  $this->_messages[] = "$filename is not a permitted type of file.";
	  return false;
	} else {
	  return true;
	}
  }

  public function addPermittedTypes($types) {
	$types = (array) $types;
    $this->isValidMime($types);
	$this->_permitted = array_merge($this->_permitted, $types);
  }

  protected function isValidMime($types) {
    $alsoValid = array('image/tiff',
				       'application/pdf',
				       'text/plain',
				       'text/rtf');
  	$valid = array_merge($this->_permitted, $alsoValid);
	foreach ($types as $type) {
	  if (!in_array($type, $valid)) {
		throw new Exception("$type is not a permitted MIME type");
	  }
	}
  }

  protected function checkName($id,$name, $overwrite) {
	$nospaces = str_replace(' ', '_', $id.'_'.$name);
	if ($nospaces != $name) {
	  $this->_renamed = true;
	}
	if (!$overwrite) {
	  $existing = scandir($this->_destination);
	  if (in_array($nospaces, $existing)) {
		$dot = strrpos($nospaces, '.');
		if ($dot) {
		  $base = substr($nospaces, 0, $dot);
		  $extension = substr($nospaces, $dot);
		} else {
		  $base = $nospaces;
		  $extension = '';
		}
		$i = 1;
		do {
		  $nospaces = $base . '_' . $i++ . $extension;
		} while (in_array($nospaces, $existing));
		$this->_renamed = true;
	  }
	}
	return $nospaces;
  }

  protected function processFile($id,$filename, $error, $size, $type, $tmp_name, $overwrite) {
	$OK = $this->checkError($filename, $error);
	if ($OK) {
	  $sizeOK = $this->checkSize($filename, $size);
	  $typeOK = $this->checkType($filename, $type);
	  if ($sizeOK && $typeOK) {
		$name = $this->checkName($id,$filename, $overwrite);
		$success = move_uploaded_file($tmp_name, $this->_destination . $name);
		if ($success) {
			
			if ($this->_renamed) {
          
			  $message=  $name;
                                                       }else{
                                                    $message=  $filename;
                                                }
                                                return $message;
		} 
	  }
	}
  }
  
    private function save_to_db($order_id,$name,$mime,$data){
      $dbLink = new mysqli('localhost','root','','writingsite');
        if(mysqli_connect_errno()) {
         die("MySQL connection failed: ". mysqli_connect_error());
        }
         $clean_order=$dbLink->real_escape_string($order_id);
        $clean_name = $dbLink->real_escape_string($name);
        $clean_link = $dbLink->real_escape_string($data);
        $clean_mime = $dbLink->real_escape_string($mime);
          $query = "
            INSERT INTO `file` (
             `order_id`, `name`, `download_link`, `mime`, `created`
            )
            VALUES (
                '{$clean_order}', '{$clean_name}','{$clean_link}','{$clean_mime}', NOW()
            )";
         $result = $dbLink->query($query);   
           if($result) {
           $this->_messages[] = 'Success! Your file was successfully added!';
        }
        else {
            $this->_messages[] = 'Error! Failed to insert the file'
               . "<pre>{$dbLink->error}</pre>";
        }
           $dbLink->close();
  }
   public function download_links($order_id){
      // Connect to the database
 $dbLink = new mysqli('localhost','galaxy_writing','munywa1234$$','galaxy_writing');
if(mysqli_connect_errno()) {
    die("MySQL connection failed: ". mysqli_connect_error());
}
 
// Query for a list of all existing files
$sql = 'SELECT `id`, `order_id`, `name`, `download_link`, `mime`, `created` FROM `file` WHERE `order_id`='."$order_id";
$result = $dbLink->query($sql);
 
// Check if it was successfull
if($result) {
    // Make sure there are some files in there
    if($result->num_rows == 0) {
        echo '<p>There are no files available </p>';
    }
    else {
        // Print the top of a table
        echo '<table width="100%">
                <tr>
                    <td><b>Order ID</b></td>
                    <td><b>Name</b></td>                    
                    <td><b>Created</b></td>
                    <td><b>&nbsp;</b></td>
                </tr>';
 
        // Print each file
        while($row = $result->fetch_assoc()) {
            $name=trim($row['name']);
            echo "
                <tr>
                   <td>{$row['order_id']}</td>
                       
                   <td><a href='get_files.php?filename={$name}' style='color:#333'>{$name}</a></td>                    
                    <td>{$row['created']}</td>
                    
                </tr>";
        }
 
        // Close table
        echo '</table>';
    }
 
    // Free the result
    $result->free();
}
else
{
    echo 'Error! SQL query failed:';
    echo "<pre>{$dbLink->error}</pre>";
}
 
// Close the mysql connection
$dbLink->close();
      
      
  } 
  
  
  
  

}