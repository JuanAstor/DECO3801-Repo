
<?php //upload a file to the database
	require("mysql.php");
	require("queries.php");
	if($_FILES["userfile"]["type"] != "file/txt" && $_FILES["userfile"]["size"] < 0 ){
		echo "Error: ". $_FILES["userfile"]["error"]. "<br>";
	} else {
		$fileName = $_FILES['userfile']['name'];
		$tmpName = $_FILES['userfile']['tmp_name'];
		$fileSize = $_FILES['userfile']['size'];
		$fileType = $_FILES['userfile']['type'];
		
		$fp = fopen($tmpName, 'r');
		$content = fread($fp, filesize($tmpName));
		$content = mysql_real_escape_string($content); 
		fclose($fp); 
		
		$fileName = str_replace(' ', '', $fileName); 
		$fileName = pathinfo($fileName, PATHINFO_FILENAME);
		
		$fileName = addslashes($fileName); 
		
		$query = "INSERT INTO `assignmentfile`(`AssignmentID`, `UserID`, `FileID`, `FileName`, `FileData`) VALUES 
		('1','Bob','1','$fileName','$content')";
		
		MySQL::getInstance()->query($query) or die('<br>Error, file upload failed '. mysql_error());
		echo "<br>File <i>$fileName</i> uploaded!</br>";
	}
?>