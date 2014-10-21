<heading>
    <h1>Assessment</h1>
</heading>
<?php
    
    if (isset($_GET['assessment'])) {
        $num = $_GET['assessment'] - 1;
        if (isset($assessments[$num]['AssignmentID'])) {
            $row = $assessments[$num];
            echo "<assessment>"
            .    "<div class='a-content'>"
            .        "<h3>".$row['AssignmentName']."</h3>"
            .        "<p><span class='iscourse'>".$row['CourseID']."</span>, Semester ".substr($row['Semester'], -1)
            .        "<p>Due ".date('g:ia, F jS', strtotime($row['DueTime']." ".$row['DueDate']))." ".substr($row['Semester'], 0, -1)."</p>"
            .    "</div>"
            .    "<div class='a-footer'"
            .        "<p>".$row['AssignmentDescription']."</p>"
            .        "<p><a>Submit</a><a>View Feedback</a></p>"
            .    "</div>"
            .    "</assessment>";
			
            $_SESSION["assign"] = $assessments[$num]['AssignmentID']; //set the assignID to the id of the selected assessment
            include("view/assessment/_fileUpload.php"); //display the file upload option
			
        }else{
            header("Location: Assessment.php");
        }
    }else{
        foreach ($assessments as $row) {
            echo "<assessment>"
            .    "<div class='a-content'>"
            .        "<h4>".$row['AssignmentName']."</h4>"
            .        "<p>".$row['CourseID'].", Semester ".substr($row['Semester'], -1)
            .        "<p>Due ".date('g:ia, F jS', strtotime($row['DueTime']." ".$row['DueDate']))." ".substr($row['Semester'], 0, -1)."</p>"
            .    "</div>"
            .    "<div class='a-footer'"
            .        "<p>".$row['AssignmentDescription']."</p>"
            .        "<p><a>Submit</a><a>View Feedback</a></p>"
            .    "</div>"
            .    "</assessment>";
        }
    } 
?>
<content>
<?php //let the user know what has happened to the files submitted
    if(isset($_SESSION['submit'])){
        if(strcmp($_SESSION['submit'], 'submitted') == 0){ //has been submitted
            echo "<span> The file(s) have been submitted successfully </span>";
        }		
        else if(strcmp($_SESSION['submit'], 'error') == 0){ //file has size 0 or not allowed extension
            echo "<span> Error uploading previous files: File type (extension) is not supported or the File size is zero </span>";
			echo "<span> File upload has been canceled </span>";	
        }
		else { //some other file error has occured so display the file 
			echo "<span> Error uploading files: '".$_SESSION['submit']."' </span>";	
			echo "<span> File upload has been canceled </span>";
		}
		unset($_SESSION['submit']); //unset so the message doesn't reappear
    } else {
        //no files have been submitted this session
    }
?>
</content>

<script>
	$('navgroup:not(.nav-assessment)').hide();
</script>