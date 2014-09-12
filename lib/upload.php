
<?php
	//NOTE: AssignmentID and UserID still need to be obtained (when other pages are complete), hard-coding it into the database at the moment
?>

<?php //upload a file to the database
	require("mysql.php");
	require("queries.php");
	$allowedExts = array("txt", "php", "html", "java", "c", "py"); //the array holding all the allowed file extensions
	echo "Number of files submitted: ".count($_FILES['userfile']['name']) . "<br>";
	
	//loop over each submitted file
	for($i=0; $i < count($_FILES['userfile']['name']); $i++)
	{		
		$temp = explode(".", $_FILES["userfile"]["name"][$i]); //strip at '.'
		$extension = end($temp); //get the extension of the file
				
		$fileName = $_FILES['userfile']['name'][$i]; //get the file name
		$fileName = str_replace(' ', '', $fileName); //get rid of spaces
		//$fileName = pathinfo($fileName, PATHINFO_FILENAME); //get rid of the '.ext' at the end of the file
		
		echo 'the file being uploaded is '.$fileName; echo '<br></br>';
		
		//check if a file is already in the database
		$path = "SELECT count(1) FROM `assignmentfile` WHERE UserId = '11112222' AND FileName = '". $fileName ."' "; 
		$ans = MySQL::getInstance()->query($path) or die('<br>Error, file check failed '. mysql_error());
		$result = $ans->fetch(); //need to call fetch to get the resut of the query
		$count = $result[0]; //get the value of the 'count(1)' query 
		
		//if the count is greater than 1, then that file has already been uploaded
		if($count > 0){
			echo 'file has previously been uploaded, updating file';
			//echo ' '.$count;
			$tmpName = $_FILES['userfile']['tmp_name'][$i]; 
			$fileSize = $_FILES['userfile']['size'][$i]; //get the size of the file
			$fileType = $_FILES['userfile']['type'][$i]; //get the type of file
			
			//open the file and put the contents into '$content'
			$fp = fopen($tmpName, 'r'); 
			$content = fread($fp, filesize($tmpName));
			$content = mysql_real_escape_string($content); 
			fclose($fp);
			
			//update the table, add new file content
			$query = "UPDATE `assignmentfile` 
					SET FileData = '". $content ."' 
					WHERE UserId = '11112222' AND FileName = '". $fileName."' ";
			MySQL::getInstance()->query($query) or die('<br>Error, file update failed '. mysql_error());
			echo "<br>File <i>$fileName</i> updated!</br>";
			
		} 
		
		//no files with the same user and filename have previously been uploaded
		else { 			
			//check if the uploaded file has size greater than 0 and is an allowed extension
			if($_FILES["userfile"]["size"][$i] > 0 && in_array($extension, $allowedExts) ){
				if($_FILES["userfile"]["error"][$i] > 0) { //check if any errors in the file
					echo "Error: ". $_FILES["userfile"]["error"][$i]. "<br>";
				}
				else { //no errors
					echo 'no previous version, uploading file'; echo '<br></br>';
					//$fileName = $_FILES['userfile']['name']; //get the file name
					$tmpName = $_FILES['userfile']['tmp_name'][$i]; 
					$fileSize = $_FILES['userfile']['size'][$i]; //get the size of the file
					$fileType = $_FILES['userfile']['type'][$i]; //get the type of file
					
					//open the file and put the contents into '$content'
					$fp = fopen($tmpName, 'r'); 
					$content = fread($fp, filesize($tmpName));
					$content = mysql_real_escape_string($content); 
					fclose($fp); 
					
					//$fileName = str_replace(' ', '', $fileName); //get rid of spaces
					//$fileName = pathinfo($fileName, PATHINFO_FILENAME); //get rid of the '.ext' at the end of the file
					
					$fileName = addslashes($fileName); //not sure what this does...
					//set what the query will do
					$query = "INSERT INTO `assignmentfile`(`AssignmentID`, `UserID`, `FileName`, `FileData`) VALUES 
					(5,'11112222','$fileName','$content')";
					
					//call the query
					MySQL::getInstance()->query($query) or die('<br>Error, file upload failed '. mysql_error());
					echo "<br>File <i>$fileName</i> uploaded!</br>";
				}
			
			} else { //file has size 0 or not allowed extension
				echo "WAIT the file is empty or not of the allowed extension type <br>";
				echo "Upload has been cancelled <br>";
				if($_FILES["userfile"]["error"][$i] > 0) {
					echo "Error: ". $_FILES["userfile"]["error"][$i]. "<br>";
				}
			}
		} //end of else loop
	} //end of for loop
?>