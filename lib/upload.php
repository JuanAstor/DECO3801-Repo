
<?php //upload a file to the database
	require("mysql.php");
	require("queries.php");
	$allowedExts = array("txt", "php", "html"); //the array holding all the allowed file extensions
	$temp = explode(".", $_FILES["userfile"]["name"]); //strip at '.'
	$extension = end($temp); //get the extension of the file
	
	//check if the uploaded file has size greater than 0 and is an allowed extension
	if($_FILES["userfile"]["size"] > 0 && in_array($extension, $allowedExts) ){
		if($_FILES["userfile"]["error"] > 0) { //check if any errors in the file
			echo "Error: ". $_FILES["userfile"]["error"]. "<br>";
			echo "Something happened here";
		}
		else { //no errors
			$fileName = $_FILES['userfile']['name']; //get the file name
			$tmpName = $_FILES['userfile']['tmp_name']; 
			$fileSize = $_FILES['userfile']['size']; //get the size of the file
			$fileType = $_FILES['userfile']['type']; //get the type of file
			
			//open the file and put the contents into '$content'
			$fp = fopen($tmpName, 'r'); 
			$content = fread($fp, filesize($tmpName));
			$content = mysql_real_escape_string($content); 
			fclose($fp); 
			
			$fileName = str_replace(' ', '', $fileName); //get rid of spaces
			$fileName = pathinfo($fileName, PATHINFO_FILENAME); //get rid of the '.ext' at the end of the file
			
			$fileName = addslashes($fileName); //not sure what this does...
			
			//set what the query will do
			$query = "INSERT INTO `assignmentfile`(`AssignmentID`, `UserID`, `FileID`, `FileName`, `FileData`) VALUES 
			(54,'12121454',,'$fileName','$content')";
			
			//call the query
			MySQL::getInstance()->query($query) or die('<br>Error, file upload failed '. mysql_error());
			echo "<br>File <i>$fileName</i> uploaded!</br>";
		}
	
	} else { //file doesn't exist or not allowed extension
		echo "in the else section <br></br>";
		if($_FILES["userfile"]["error"] > 0) {
			echo "Error: ". $_FILES["userfile"]["error"]. "<br>";
		}
	}
?>