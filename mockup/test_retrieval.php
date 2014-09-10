<?php
session_start();
require("../lib/mysql.php");
require("../lib/queries.php");
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
//echo $a['FileData']; //use $a['FileData'][0] to get the 1st file and so on if multiple files
echo "<br>";
 
//$fileName = "../mockup/files/tempfile.txt"; 
//directory path where the temp files will be stored
$dir = "files/";
$fileName = "". $dir ."tempfile.txt"; //create a file name (will randomize the name later)

//check if the file already exists 

while(check_if_file_exists($fileName) == 1){
	//file name exists so loop until it doesn't
	echo "file name exists, in loop";
	$fileName =  "". $dir ."tempfile1.txt";
}

	//add file names to an array 
	array_push($arr, $fileName);
	$_SESSION['array_name'] = $arr;
	//open the temp file and get it's content
	$tmpFile = fopen($fileName, "w") or die("unable to create a temp file"); 
	$txt = $a['FileData']; 
	fwrite($tmpFile, $txt);
	fclose($tmpFile); 
	
	echo "<br>";
	echo readfile($fileName); 
	echo "<br>";
	
	//delete the tempfile when finished with it
	//if(!unlink($fileName)){
		//error, unable to delete file
		//echo "error deleting file";
	//}else {
		//file has been deleted
		//echo "deleted";	
	//}


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
	//$var = check_if_file_exists("file.txt");
	echo "<br>";
	echo "values are: ". $_SESSION['array_name'][0]; //check that array holds a value
?>

<!DOCTYPE html>
<html>
    <head>
    <title>Code Review</title>
        <link rel="stylesheet" type="text/css" href="main.css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
		
		<script src="http://assets.annotateit.org/annotator/v1.2.5/annotator-full.min.js"></script>
		<link rel="stylesheet" href="http://assets.annotateit.org/annotator/v1.2.5/annotator.min.css">
		<script type="text/javascript" src="js/syntaxh/shCore.js"></script>
		
		<!-- Only java brush enabled -->
		<script type="text/javascript" src="js/syntaxh/shBrushJava.js"></script>
		
		<link href="css/syntaxh/shCore.css" rel="stylesheet" type="text/css" />
		<link href="css/syntaxh/shThemeDefault.css" rel="stylesheet" type="text/css" />
		
		<?php date_default_timezone_set('Australia/Brisbane'); ?>
		
		
		
    </head>
    <body>

        <div class="topbox">
            <div class="toplogo">
                <img border="0" src="CPRS Logo.png" height="100px">
            </div>
            <div class="navbar">
                <ul>
                    <li><a href="index.php">Assignments</a></li>
                    <li><a href="CodeReview.php">Code Review</a></li>
                    <li><a href="ReviewsReceived.php">Reviews Received</a></li>
                </ul>
            </div>
        </div>
		
		<div class="titlebox">
			<div class ="time">
				<h2> <?php echo date("l") ?> </h2>
				<h4 class = "time-display"> <?php echo date("d/m/y"); ?> </h4>
				<h4 class = "time-display"> <?php echo date("g:i:s A"); ?></h4>
			</div>
		
			<div>
				<h1 class="title">
				Code Review
				</h1>
			</div>
		</div>
		
		<div class = "fileselect">
        	<?php 
				$fullDir = $_SESSION['array_name'][0]; // get the file path 
				$strConts = explode("/", $fullDir); 
				$fileVar = end($strConts); //get just the file name
			?> 
			
			<a class="filelinks" href='?file=<?php echo $fileVar ?>'>Temp1.txt</a>			
			<a class="filelinks" href='?file=File2.txt'>File2.txt</a>
			<a class="filelinks" href='?file=File3.txt'>File3.txt</a>
			<a class="filelinks" href='?file=File4.txt'>File4.txt</a>
			
		</div>
        
        <div class="code">
			<script type="syntaxhighlighter" class="brush: java"><![CDATA[
			<?php
				if (isset($_GET['file']) == NULL){
					echo "No file selected.";
				} else {
					
					if(!file_exists("files/".$_GET['file'])){
						echo("File not found");
						
					} else {
						$fileToOpen = "files/".$_GET['file'];
						$fh = fopen($fileToOpen, 'r');
						$selectedFileData = fread($fh, filesize($fileToOpen));
						fclose($fh);
						echo $selectedFileData;
					}
				}
				
				
				
				
			?>
			]]></script>
		</div>
		
		<div id="comments">
			<h2 class="commenth"> Comments </h2>
			
			<p > You can annotate stuff in here. </p>
			
		</div>
        

    </body>
	
	<!-- Run this for syntax highlighter -->
	<script type="text/javascript">
		SyntaxHighlighter.all()
	</script>
    <?php 
		//this will need to be a loop
		$fileName = $_SESSION['array_name'][0];
		if(!unlink($fileName)){
			//error, unable to delete file
			echo "error deleting file";
		}else {
			//file has been deleted
			echo "deleted";	
	}
	?>
    
</html>