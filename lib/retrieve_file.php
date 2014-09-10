<?php
session_start();
require("mysql.php");
require("queries.php");
//include("../view/codereview/header.php");


function selectFile($id, $file) {
	//sql query to get the required file content
	 $sql = "SELECT FileData
        FROM `assignmentfile`
        WHERE UserID = '". $id ."' AND FileName = '". $file ."'"; 
 
    $stmt = MySQL::getInstance()->prepare($sql);
    $stmt->execute(array(":id" => $id));
   // $stmt->bindColumn(1, $mime);
    $stmt->bindColumn(1, $data, PDO::PARAM_LOB);
 
    $stmt->fetch(PDO::FETCH_BOUND);
	
	return array('FileData' => $data);  
 
} 
$arr = array(); //an array to store all the filenames(paths) that are created

$a = selectFile('11112222', 'file1'); 
echo $a['FileData']; //use $a['FileData'][0] to get the 1st file and so on if multiple files
echo "<br>";
 
//$fileName = "../mockup/files/tempfile.txt";
$dir = "../mockup/files/";
$fileName = "". $dir ."tempfile.txt";

//check if the file already exists 

while(check_if_file_exists($fileName) == 1){
	//file name exists so loop until it doesn't
	echo "file name exists, in loop";
	$fileName =  "". $dir ."tempfile1.txt";
}

	//add file names to an array 
	array_push($arr, $fileName);
	$_SESSION['array_name'] = $arr;
	
	$tmpFile = fopen($fileName, "w") or die("unable to create a temp file"); 
	$txt = $a['FileData']; 
	fwrite($tmpFile, $txt);
	fclose($tmpFile); 
	
	echo "<br>";
	echo readfile($fileName); 
	echo "<br>";
	
	//delete the tempfile when finished with it
	if(!unlink($fileName)){
		//error, unable to delete file
		echo "error deleting file";
	}else {
		//file has been deleted
		echo "deleted";	
	}
//end of else 

//checks the existance of a given file name
function check_if_file_exists($fileName){
	if(file_exists($fileName)){
		//file does
		return 1;
	} else {
		//file doesn't
		return 0;
	}
}
?>

<?php 
	$var = check_if_file_exists("file.txt");
	echo "<br>";
	echo "values are: ". $_SESSION['array_name'][0];
?>
