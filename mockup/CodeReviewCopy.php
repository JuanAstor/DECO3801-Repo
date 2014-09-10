<!DOCTYPE html>
<html>
    <head>
    <title>Code Review</title>
        <link rel="stylesheet" type="text/css" href="main.css">
		<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/themes/ui-darkness/jquery-ui.css" rel="stylesheet">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
		<script src="js/addComment.js" type="text/javascript"></script>
		
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
			
			<a class="filelinks" href='?file=File1.txt'>File1.txt</a>			
			<a class="filelinks" href='?file=File2.txt'>File2.txt</a>
			<a class="filelinks" href='?file=File3.txt'>File3.txt</a>
			<a class="filelinks" href='?file=File4.txt'>File4.txt</a>
			
		</div>
		
		
        
        <div class="code">
			<script type="syntaxhighlighter" class="brush: java" id ="annotate"><![CDATA[
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
			<button id="addButton" >Add Comment</button>
			
		</div>
		
		<div id="comments">
			<h2 class="commenth"> Comments </h2>
			<div id="comSec">
			
			</div>
			
			<div id="dialog" title="Dialog Form">
			<form action="" method="post">
			<label>Line Number:</label>
			<input id="lineNum" name="lineNum" type="text"></br>
			<label>Comment:</label>
			<textarea name="comments" id="comSec" rows="8"></textarea>
			</br>
			</br>
			</br>
			<input id="submit" type="submit" value="Submit">
			
			</form>
			</div>
			
			
		</div>
		

    </body>
	
	<!-- Run this for syntax highlighter -->
	<script type="text/javascript">
		SyntaxHighlighter.all()
	</script>
	
	
    
</html>