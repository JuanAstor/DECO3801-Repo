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
            .    "<div class='a-footer'>"
            .        "<p>".$row['AssignmentDescription']."</p>"
            .    "</div>"
            .    "</assessment>";
			
            $_SESSION["assign"] = $assessments[$num]['AssignmentID']; //set the assignID to the id of the selected assessment
            
			echo "<assessment>"
			.	 "<div class='a-content'>";
			
			include("view/assessment/_fileUpload.php");
			
			echo	 "</div>"	
			.	 "</assessment>";
			; //display the file upload option
			
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
            .    "<div class='a-footer'>"
            .        "<p>".$row['AssignmentDescription']."</p>"
            .    "</div>"
            .    "</assessment>";
        }
    } 
?>

<script>
	$('navgroup:not(.nav-assessment)').hide();
</script>