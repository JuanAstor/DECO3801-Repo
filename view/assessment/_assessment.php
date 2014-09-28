<page>
    <heading>
    	Assignments
    </heading>

<?php
    
    if (isset($_GET['assessment'])) {
        $num = $_GET['assessment'] - 1;
        if (isset($assessments[$num]['AssignmentID'])) {
            echo "<p>Assignment: ".$assessments[$num]['AssignmentName']."</p>";
			
			$_SESSION["assign"] = $assessments[$num]['AssignmentID']; //set the assignID to the id of the selected assessment
			echo "Assignment ID is: ".$_SESSION["assign"]; //display the id
			
			include("view/assessment/_fileUpload.php"); //display the file upload option
			
        }else{
            header("Location: Assessment.php");
        }
    }else{
        foreach ($assessments as $row) {
        echo "<p>Assignment: ".$row['AssignmentName']."<p>";
        }
		if(isset($_SESSION["assign"])){ //check if the session var is set
				echo "Assignment ID is still: ".$_SESSION["assign"];
		}
    } 
?>

<div>
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
</div>

</page>
