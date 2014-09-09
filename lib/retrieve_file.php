<?php
require("mysql.php");
require("queries.php");
include("../view/codereview/header.php");


function selectFile($id) {

	 $sql = "SELECT FileData
        FROM `assignmentfile`
        WHERE UserID = 'Bob'"; //userId will need to match the vlue in the database (bob is not in the master branch)
 
    $stmt = MySQL::getInstance()->prepare($sql);
    $stmt->execute(array(":id" => $id));
   // $stmt->bindColumn(1, $mime);
    $stmt->bindColumn(1, $data, PDO::PARAM_LOB);
 
    $stmt->fetch(PDO::FETCH_BOUND);
	
	return array('FileData' => $data);  
 
}

$a = selectFile('Bob'); //the parameter 'bob' is essentially useless, function selectFile isn't using $id
echo $a['FileData'];

?>