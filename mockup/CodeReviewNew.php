<!DOCTYPE html>
<html>
    <head>
    <title>Code Review</title>
	
        <link rel="stylesheet" type="text/css" href="main.css">
					
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
		
		<!-- Load the Prettify script, to use in highlighting our code.-->
		<script src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js"></script>	
		
		<!-- Load the Annotator script and css for commenting use on our code -->
		<script src="http://assets.annotateit.org/annotator/v1.2.5/annotator-full.min.js"></script>
		<link rel="stylesheet" href="http://assets.annotateit.org/annotator/v1.2.5/annotator.min.css">
		
		<?php date_default_timezone_set('Australia/Brisbane'); ?>
		
		<script>
		jQuery(function ($) {
			$('.code').annotator();
					
		});
		</script>
		
		
		
		
		
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
				
			<!-- IMPORTANT: pre opening tag and php code must be next
			to each other or unwanted indentation may happen. -->
			
			<pre class="prettyprint"><?php
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
			</pre>
						
		</div>
		
		
		</div>
		

    </body>	
	
		<script>
		jQuery(function ($) {
			$('#code').annotator();
		});
		</script>

	
    
</html>