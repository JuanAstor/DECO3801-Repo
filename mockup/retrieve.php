<?php 
	require("../lib/mysql.php");
	require("../lib/queries.php");
	
	$filename = $_POST['file'];
	$uID = $_POST['user'];
	$assignID = $_POST['assign'];
	
	$query = MySQL::getInstance()->query("SELECT *
										FROM `assignmentfile`
										WHERE UserID = '".$uID."' AND AssignmentID = '".$assignID."' AND FileName = '".$filename."'"); 
	$result = $query->fetchALL();
	return $result['FileData'];
?>