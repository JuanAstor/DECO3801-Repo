<?php
	session_start();
	require("mysql.php");
	require("queries.php"); //query functions to get database results
	
	// if update button was pressed and the form was sent with all fields filled in
	if(isset($_POST['AName']) && isset($_POST['desc']) && isset($_POST['time']) && isset($_POST['date'])){
		$assignID = $_POST['AssignID']; //hidden assignmentID passed through the form
		$aName = $_POST['AName'];
		$desc = $_POST['desc'];
		$time = $_POST['time'];
		$date = $_POST['date']; 
		
		//since this is an edit, we know that the assignment already exists so just update the db
		//find out if it was a success or failure
		$result = update_assign_info($assignID, $aName, $desc, $time, $date);
		 if($result == 'success'){
			 $_SESSION['message'] = 'completed';
		 } else {
			$_SESSION['message'] = 'error'; 
		 }
		
		$cID = $_POST['cID'];//courseID
		$sem = $_POST['sem'];//semester
		
		//return to the page with the updated information
		header('Location: /EditAssessment.php?course='.$cID.'&sem='.$sem.'&name='.$aName);
	} 
	//else if the reset button was pressed
	else if (isset($_POST['assignID']) && isset($_POST['del'])){		
		//first check that no previous file submissions exist for the to be deleted assignment
		$del = delete_submissions($_POST['assignID']);
		//if an error deleteing submissions then stop and output the error
		if(!$del){
			echo "Error: Unable to delete assignment files so the Assignment will not be deleted";	
		} else { //file submissions have been deleted so..
			//delete the assignment
			$result = delete_assignment($_POST['assignID']);
			//check that the delete was successful and output message
			if($result == 'success'){
				echo "Assignment successfully deleted";	
			} else {
				echo "Error: Assignment unable to be deleted";	
			}
		}
	}
?>