<?php 
    require("../lib/mysql.php");
    require("../lib/queries.php");
	
    $filename = $_POST['filename'];
    $uID = $_POST['user'];
    $assignID = $_POST['assign'];
	
	//query the database and get the file associated with the userID, assignmentID, and filenmae
    $result = get_file_data($uID,$assignID,$filename);
	
    $txt = $result[0]['FileData']; //string of file data
    $temp = tmpfile(); //create a php temp file
    fwrite($temp, $txt); //write the file data to the temp file
    fseek($temp, 0); //reset the position of the file to the beginnning
    $content = fread($temp, strlen($txt)); //copy the file data to a variable
    fclose($temp); //close and delete the temp file
    echo $content; //return the contents
?>