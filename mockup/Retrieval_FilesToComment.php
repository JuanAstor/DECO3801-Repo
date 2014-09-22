<?php
session_start();
require("../lib/mysql.php");
require("../lib/queries.php");
//Need a session varibale containing the userID and the assignmentID
$uID = '12123434';
$assignID = '5';
?>
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
                    });        </script>		


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
				$data = array();
				$files = get_files_to_comment($uID, $assignID); //query the database
				foreach($files as $fileName){ 
					$data[] = array($uID,$assignID,$fileName['FileName']); //multi-dem array to hold values needed to query the db
					echo "<a class='filelinks'>".$fileName['FileName']. "</a><br>";//display all filenames
				}
				
			
        ?>

        </div>

        <div class="code">

            <!-- IMPORTANT pre opening tag and php code must be next
            to each other or unwanted indentation may happen. -->

            <pre class="prettyprint"><?php
            if (isset($_GET['file']) == NULL) {
                echo "No file selected.";
            } else {

                if (!file_exists("files/" . $_GET['file'])) {
                    echo("File not found");
                } else {
                    $fileToOpen = "files/" . $_GET['file'];
                    $fh = fopen($fileToOpen, 'r');
                    $selectedFileData = fread($fh, filesize($fileToOpen));
                    fclose($fh);
                    echo $selectedFileData;
                }
            }
?>
            </pre>

        </div>

        <div><p class="test">asdas</p></div><div><p class="test2">asdas</p></div>
    </div>


</body>	

<script>
            jQuery(function ($) {

            $(".filelinks").click(function() {
            var file = $(this).text().toString();
            $('.test2').text(file);
                    // MAKE SURE THAT ASSIGNID AND USERID IS ALWAYS VALID.
                    $.ajax({
                            type:'POST',
                            url:'retrieve.php',
                            data: {filename : file,
                                   user : '<?php echo $uID ?>',
                                   assign : '<?php echo $assignID ?>' },
                            cache: false,
                            success: function(html){
                            $(".test").html(html);
                            }
                    });
            });
                    $('#code').annotator();
                    });
</script>



</html>
