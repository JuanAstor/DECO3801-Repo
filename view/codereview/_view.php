<?php
if (isset($_GET['assessment'])) {
    $num = $_GET['assessment'] - 1;
    if (isset($assessments[$num]['AssignmentID'])) {
        $row = $assessments[$num];
        $_SESSION["assign"] = $assessments[$num]['AssignmentID']; //set the assignID to the id of the selected assessment
    } else {
        header('Location: index.php');
    }
} else {
    header('Location: index.php');
}


//Need a session varibale containing the userID and the assignmentID
$uID = $_SESSION["user"]; //userID
$assignID = $_SESSION["assign"]; //assignmentID
?><head>
    <link rel="stylesheet" type="text/css" href="css/comments.css">

    <link rel="stylesheet" type="text/css" href="css/prettyprint/prettify.css" />
    <script type="text/javascript" src="css/prettyprint/prettify.js"></script>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

<?php date_default_timezone_set('Australia/Brisbane'); ?>
    <!-- change this -->
    <script src="js/commentDB.js" type="text/javascript"></script>

</head>
<content>


    <h3>Review Feedback On <?php echo $assessments[$num]['AssignmentName'] ?> </h3	>


    <!-- this is where the file data and comments will appear -->

    <div class="code">

        <div class = "fileselect">
<?php
$files = get_files_to_comment($uID, $assignID); //query the database
if (sizeof($files) == 0) {
    echo "No files found";
} else {
    echo "<span class=\"filebut\">File Select</span><ul class =\"filelist\">";
    foreach ($files as $fileName) {

        $fileNameStr = $fileName['FileName'];

        if (strlen($fileNameStr) > 20) {

            $fileNameStr = substr($fileNameStr, 0, 17) . "...";
        }
        //display all filenames as an anchor
        echo "<li><a class='filelinks' data-fileID=" . $fileName['FileID'] . " data-user=" . $uID . " 
				title=".$fileName['FileName'].">" . $fileNameStr . "</a></li>";
    }
    echo "</ul>";
}
?>
        </div>  

        <div id="revSelect">
            <ul id="tabs">

            </ul>
        </div>
        <!-- file data code added here -->
        <?prettify?>
        <pre class="prettyprint linenums">Nothing Selected</pre>

        <div id="coms">

        </div>

    </div>     

</content>

<script>
    jQuery(function ($) {
        $(".filelinks").click(function () {
            //get the filename from the anchor tag clicked
            var file = $(this).attr("title"); //filename
            var fID = $(this).data("fileid"); //fileID
            var uID = $(this).data("user"); //userID 

            console.log(uID);
            console.log(fID);
            $.ajax({
                type: 'POST',
                url: 'lib/retrieve.php',
                data: {filename: file,
                    user: '<?php echo $uID ?>',
                    assign: '<?php echo $assignID ?>'},
                success: function (data) {
                    $('.prettyprinted').removeClass('prettyprinted');
                    $("ul#tabs").html("");
                    //dump the file data into the pre tag
                    $("pre.prettyprint.linenums").text(data);
                    //load google prettify to style text
                    prettyPrint();
                    //load the comment system from commentDB.js											
                    loadCommentSystem(uID, fID, false);
                }
            });
        });

    });

</script>

<script>
    //everything but the feedback bar, hide
    $('navgroup:not(.nav-feedback)').hide();

    $(".fileselect").on("click", ".filebut", function () {
        $(".filelist").toggle(300);


    });
</script>