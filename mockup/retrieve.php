<?php 
    require("../lib/mysql.php");
    require("../lib/queries.php");
	
    $filename = $_POST['filename'];
    $uID = $_POST['user'];
    $assignID = $_POST['assign'];
	
    $query = MySQL::getInstance()->query("SELECT *
                                          FROM `assignmentfile`
                                          WHERE UserID = '".$uID."' AND AssignmentID = '".$assignID."' AND FileName = '".$filename."'"); 
    $result = $query->fetchALL();
    $txt = $result[0]['FileData'];
    $temp = tmpfile();
    fwrite($temp, $txt);
    fseek($temp, 0); 
    $content = fread($temp, 1024); 
    fclose($temp);
    echo $content;
?>