<?php
session_start();
require("../lib/mysql.php");
require("../lib/queries.php");
//Need a session varibale containing the userID and the assignmentID
$uID = '12123434'; //userID
$assignID = '514636'; //assignmentID
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Code Review</title>

        <link rel="stylesheet" type="text/css" href="main.css">
        <link rel="stylesheet" type="text/css" href="comments.css">

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

        <!-- Load the Prettify script, to use in highlighting our code.-->
        <script src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js"></script>	

        <!-- Load the Annotator script and css for commenting use on our code -->
       

        <?php date_default_timezone_set('Australia/Brisbane'); ?>
        
		<script src="js/commentDB.js" type="text/javascript"></script>	


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
				$files = get_files_to_comment($uID, $assignID); //query the database
				if(sizeof($files) == 0){
					echo "No files found";	
				} else {
					foreach($files as $fileName){ 
						echo "<a class='filelinks' data-value=".$fileName['FileID'].">".$fileName['FileName']. "</a><br>";//display all filenames as an anchor
					}
				}		
        ?>

        </div>

        <div class="code">
        
        	<div id="revSelect">
				<ul id="tabs">
					
				</ul>
			</div>
            <!-- code added here -->
            <pre class="prettyprint">Nothing Selected</pre>
            
            <div id="coms">
				
			</div>
            
        </div>        
    </div>


</body>	

<script>
jQuery(function ($) {
    $(".filelinks").click(function() {
    var file = $(this).text();
        // MAKE SURE THAT ASSIGNID AND USERID IS ALWAYS VALID.
        $.ajax({
            type:'POST',
            url:'../lib/retrieve.php',
            data: {filename : file,
                   user : '<?php echo $uID ?>',
                   assign : '<?php echo $assignID ?>' },
            success: function(data){
                $("pre").text(data);
				//re run comments
				
				
				
                
            }
        });
    });
	
  

});
                    
</script>



</html>
