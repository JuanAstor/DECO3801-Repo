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
		//conver the date into the format required by the database
		$dateFormat = $_POST['date'];
		$newdate = DateTime::createFromFormat('d/m/Y', $dateFormat);
		$date = $newdate->format('Y-m-d');
		
		//hidden variables that will always be sent with the form
		$cID = $_POST['cID'];//courseID 
		$sem = $_POST['sem'];//semester 
		
		//first check that the update assignment name doesn't already exist
		$count = find_assignmentName($cID, $aName, $sem); 
		$previous = get_previous_assign_info($assignID);
		
		//check that the entered date is a valid date
		
		
		echo $count;
		if(($count > 0) && ($aName != $previous[0]['AssignmentName'])){
			//assignment name exists and isn't the same as the orignal name		
			
			//set a message to display			
			$_SESSION['message'] = 'name error';
			
			
			//header('Location: /EditAssessment.php?course='.$previous[0]['CourseID'].'&sem='.$previous[0]['Semester'].'&name='.$previous[0]['AssignmentName']);
		
		} else { //assignment name doesn't exist or is the same name as the origial
		
			//since this is an edit, we know that the assignment already exists so just update the db
			//find out if it was a success or failure
			$result = update_assign_info($assignID, $aName, $desc, $time, $date);
			 if($result == 'success'){
				 $_SESSION['message'] = 'completed';
			 } else {
				$_SESSION['message'] = 'error'; 
			 }
			 //return to the page with the updated information
			//header('Location: /EditAssessment.php?course='.$cID.'&sem='.$sem.'&name='.$aName);
		}
		
		
		
		//return to the page with the updated information
		//header('Location: /EditAssessment.php?course='.$cID.'&sem='.$sem.'&name='.$aName);
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
	
	//if the delete button was pressed by a student
	else if(isset($_POST['fileID'])){
		//delete any potential comments
		$result = delete_student_files($_POST['fileID']);
		if($result){
			//file was deleted
			echo "Assignment file successfully deleted";
		} else {
			//error
			echo "Error: file was unable to be deleted";	
		}
	}
?>