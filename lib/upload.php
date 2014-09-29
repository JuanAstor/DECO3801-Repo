
<?php
	//NOTE: AssignmentID and UserID still need to be obtained (when other pages are complete), hard-coding it into the database at the moment
?>

<?php //upload a file to the database
	session_start();
	require("mysql.php");
	require("queries.php");
	$allowedExts = array("txt", "php", "html", "java", "c", "py", "js"); //the array holding all the allowed file extensions
	
	date_default_timezone_set('Australia/Brisbane'); //time zone of the user
	$dateTime = date('Y-m-d H:i:s'); //the current time and date
	$uID = $_SESSION["user"]; //the userID, to be replaced with the session var 
	$assignmentID = $_SESSION["assign"]; //the assignmentID, to be replaced with a session var
	
	//loop over each submitted file
	for($i=0; $i < count($_FILES['userfile']['name']); $i++)
	{		
		$temp = explode(".", $_FILES["userfile"]["name"][$i]); //strip at '.'
		$extension = end($temp); //get the extension of the file				
		$fileName = $_FILES['userfile']['name'][$i]; //get the file name
		$fileName = str_replace(' ', '', $fileName); //get rid of spaces
		
		//check that the file being uploaded has content and is of the allowed type
		if($_FILES["userfile"]["size"][$i] > 0 && in_array($extension, $allowedExts) ){
			//echo 'Upload start <br>';			
			//check if a file is already in the database
			$result =  check_if_file_exists($uID, $assignmentID, $fileName);
			$count = $result[0]; //get the value of the 'count(1)' query		
			
			//if the count is greater than 0, then that file has already been uploaded
			if($count[0] > 0){
				//echo 'file has previously been uploaded, updating file';
				$tmpName = $_FILES['userfile']['tmp_name'][$i]; 
				
				//open the file and put the contents into '$content'
				$fp = fopen($tmpName, 'r'); 
				$content = fread($fp, filesize($tmpName));
				$content = mysql_real_escape_string($content); 
				fclose($fp);
				
				//update the table, add new file content
				$update = update_file_contents($uID, $assignmentID, $fileName, $content, $dateTime);
				//echo "<br>File <i>$fileName</i> updated!</br>";
				$_SESSION['submit'] = 'submitted';
			} 			
			//no files with the same user and filename have previously been uploaded
			else { 	
				//check if the uploaded file has size greater than 0 and is an allowed extension
				if($_FILES["userfile"]["error"][$i] > 0) { //check if any errors in the file
					$_SESSION['submit'] = $_FILES["userfile"]["error"][$i];
				}
				else { //no errors and no previous version of file in database
					$tmpName = $_FILES['userfile']['tmp_name'][$i]; 
										
					//open the file and put the contents into '$content'
					$fp = fopen($tmpName, 'r'); 
					$content = fread($fp, filesize($tmpName));
					$content = mysql_real_escape_string($content); 
					fclose($fp); 
					//query the database and submit the necessary info
					insert_file_data($uID, $assignmentID, $fileName, $content, $dateTime);					
					//echo "<br>File <i>$fileName</i> uploaded!</br>";
					$_SESSION['submit'] = 'submitted';
				}
				
			} //end of else loop
		}//end of if file is greater than 0 etc
		else { //file will not be uploaded			
			if($_FILES["userfile"]["error"][$i] > 0) {
				$_SESSION['submit'] = $_FILES["userfile"]["error"][$i];
			}
			//file has size 0 or not allowed extension so the file will not be uploaded
			$_SESSION['submit'] = 'error'; 
			//return to the previous page if an error has been found
			break;
		}
	} //end of for loop
	
	//return to the previous page
	header('Location: ../assessment.php');
?>