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
 
    $stmt = MySQL::getInstance()->prepare($sql); //query
    $stmt->execute(array(":id" => $id));
    $stmt->bindColumn(1, $data, PDO::PARAM_LOB); //data from specific file
 
    $stmt->fetch(PDO::FETCH_BOUND); //get the data
	
	return array('FileData' => $data);  //return the data
 
} 
$arr = array(); //create an array to store all the filenames(paths) that are created
$a = selectFile('11112222', 'file1.txt'); //call the query method, (won't be hardcoded when the necessary values are available)
 
//directory path where the temp files will be stored
$dir = "files/";
$fileName = "". $dir ."tempfile.txt"; //create a file name (will randomize the name later)

//check if the file already exists if it doesn't add it to an array, else generate a different filename and check again

while(check_if_file_exists($fileName) == 1){
	//file name exists so loop until it doesn't
	echo "file name exists, in loop forever";
}

	//add created file names to an array 
	array_push($arr, $fileName);
	$_SESSION['array_name'] = $arr; //store the array as a session variable
	//open the temp file and get it's content
	$tmpFile = fopen($fileName, "w") or die("unable to create a temp file"); 
	$txt = $a['FileData']; 
	fwrite($tmpFile, $txt);
	fclose($tmpFile); 

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
	//echo "values are: ". $_SESSION['array_name'][0]; //check that array holds a value
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
			<div class ="time"> <!-- get the current time of brisbane/Australia  -->
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
				$strConts = explode("/", $fullDir); //break into sections
				$fileVar = end($strConts); //get just the file name
			?> 
			
			<a class="filelinks" href='?file=<?php echo $fileVar ?>'>Temp1.txt</a>	
            <br>		
			<a class="filelinks" href='?file=File2.txt'>File2.txt</a>
			
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
    <?php //run this to delete all the temp files created to view the displayed files
		
		$fileName = $_SESSION['array_name'][0]; //get the filenames generated above
		//delete the file
		if(!unlink($fileName)){
			//error, unable to delete file
			echo "error deleting file";
		}else {
			//file has been deleted
			//echo "deleted";	
	}
	?>
    
</html>