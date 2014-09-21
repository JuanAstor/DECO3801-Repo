
<?php
	//NOTE: AssignmentID and UserID still need to be obtained (when other pages are complete), hard-coding it into the database at the moment
?>

<?php //upload a file to the database
	require("mysql.php");
	require("queries.php");
	$allowedExts = array("txt", "php", "html", "java", "c", "py"); //the array holding all the allowed file extensions
	date_default_timezone_set('Australia/Brisbane'); 
	$dateTime = date('Y-m-d H:i:s');
	echo "Number of files submitted: ".count($_FILES['userfile']['name']) . "<br>";
	
	//loop over each submitted file
	for($i=0; $i < count($_FILES['userfile']['name']); $i++)
	{		
		$temp = explode(".", $_FILES["userfile"]["name"][$i]); //strip at '.'
		$extension = end($temp); //get the extension of the file
				
		$fileName = $_FILES['userfile']['name'][$i]; //get the file name
		$fileName = str_replace(' ', '', $fileName); //get rid of spaces
		echo 'the file to be uploaded is '.$fileName; echo '<br>';
		//$fileName = pathinfo($fileName, PATHINFO_FILENAME); //get rid of the '.ext' at the end of the file
		//check that the file being uploaded has content and is of the allowed type
		if($_FILES["userfile"]["size"][$i] > 0 && in_array($extension, $allowedExts) ){
			echo 'Upload start <br>';
			
			//check if a file is already in the database
			$result =  check_if_file_exists('12123434', '5', $fileName);
			$count = $result[0]; //get the value of the 'count(1)' query		
			
			//if the count is greater than 0, then that file has already been uploaded
			if($count[0] > 0){
				echo 'file has previously been uploaded, updating file';
				$tmpName = $_FILES['userfile']['tmp_name'][$i]; 
				$fileSize = $_FILES['userfile']['size'][$i]; //get the size of the file
				
				//open the file and put the contents into '$content'
				$fp = fopen($tmpName, 'r'); 
				$content = fread($fp, filesize($tmpName));
				$content = mysql_real_escape_string($content); 
				fclose($fp);
				
				//update the table, add new file content
				$update = update_file_contents('12123434','5',$fileName, $content, $dateTime);
				echo "<br>File <i>$fileName</i> updated!</br>";
				
			} 			
			//no files with the same user and filename have previously been uploaded
			else { 			
				//check if the uploaded file has size greater than 0 and is an allowed extension
				if($_FILES["userfile"]["error"][$i] > 0) { //check if any errors in the file
					echo "Error: ". $_FILES["userfile"]["error"][$i]. "<br>";
				}
				else { //no errors
					echo 'no previous version, uploading file'; echo '<br></br>';
					$tmpName = $_FILES['userfile']['tmp_name'][$i]; 
					$fileSize = $_FILES['userfile']['size'][$i]; //get the size of the file
					
					//open the file and put the contents into '$content'
					$fp = fopen($tmpName, 'r'); 
					$content = fread($fp, filesize($tmpName));
					$content = mysql_real_escape_string($content); 
					fclose($fp); 
					insert_file_data('12123434','5', $fileName, $content, $dateTime);					
					echo "<br>File <i>$fileName</i> uploaded!</br>";
				}
				
			} //end of else loop
		}//end of if file is greater than 0 etc
		else { //file has size 0 or not allowed extension
			echo "WAIT the file is empty or not of the allowed extension type <br>";
				echo "This file will not be uploaded <br>";
				if($_FILES["userfile"]["error"][$i] > 0) {
					echo "Error: ". $_FILES["userfile"]["error"][$i]. "<br>";
				}
		}
	} //end of for loop
?>