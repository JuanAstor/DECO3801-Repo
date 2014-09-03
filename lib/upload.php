
<?php //upload a file to the database
	require("mysql.php");
	require("queries.php");

	$fileName = $_FILES['userfile']['name'];
	$tmpName = $_FILES['userfile']['tmp_name'];
	$fileSize = $_FILES['userfile']['size'];
	$fileType = $_FILES['userfile']['type'];
	
	$fp = fopen($tmpName, 'r');
	$content = fread($fp, filesize($tmpName));
	$content = mysql_real_escape_string($content); 
	fclose($fp); 
	
	$fileName = str_replace(' ', '', $fileName); 
	
	$fileName = addslashes($fileName); 
	
	$query = "INSERT INTO `assignmentfile`(`AssignmentID`, `UserID`, `FileID`, `FileName`, `FileData`) VALUES 
	(00000001,Bob,00000010,$fileName,$content)";
	
	mysql_query($query) or die('<br>Error, file upload failed '. mysql_error());
	echo "<br>File <i>$fileName</i> uploaded!</br>";
	
?>