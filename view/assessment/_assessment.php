<page>
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
            .        "<h4>".$row['AssignmentName']."</h4>"
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
    if(isset($_SESSION['submitted'])){
        if(strcmp($_SESSION['submitted'], 'submitted') == 0){ //has been submitted
            echo "<span> The Files have been submitted </span>";
        }
        else if(strcmp($_SESSION['submitted'], 'error') == 0){ //an error occured
            echo "<span> Error uploading files </span>";	
            }
    } else {
        echo "<span> Nothing has been submitted </span>"; //nothing has happened
    }
?>
</content>
</page>
