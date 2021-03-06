<?php
	$InstitValue = $institution;
	$output = NULL;
	if(isset($_POST['btnSubmit'])){
		//if the submit button was pressed, set the default message to be an error
		//if nothing is set, then this will be the only message to display, otherwise something else will
		$output = "Error: One or more fields were not set<br />Please complete the form";	
	}
	if(isset($_POST['cID']) && isset($_POST['assName']) && isset($_POST['numCrits']) ){
		//if one of the fields is empty (left on 'select...' option)
		if((strcmp($_POST['numCrits'],"") == 0) || (strcmp($_POST['assName'],"")== 0) || (strcmp($_POST['numCrits'],"")==0) ){
			//do nothing
			$output = "Error: One or more fields were not set<br />Please complete the form";
		} else {
			$val = explode(",", $_POST['cID']);
			$cID = $val[0]; //course ID
			$sem = $val[1]; //the semester
			$assName = $_POST['assName']; //assignment name
			$numCrits = $_POST['numCrits']; //number of critiques to assign
			$studentArr = array(); //array to hold all student id's
			
			$assignIDResult = get_assignID($assName, $cID);
			$assID = $assignIDResult[0]['AssignmentID']; //the assignment id
			remove_previous_assigned_critiques($assID);
			//get an array list of all students in that course, semester
			$result = get_all_students_in_course($cID, $sem);			
			//add all users to the array		
			foreach($result as $student){
				array_push($studentArr, $student['UserID']);	
			}
			shuffle($studentArr); //randomise the position of all userIDs
			//print_r($studentArr); //display the array of students
			$nextCount = 0;
			$loopCount = 0;
			
			//loop over every element in the array and assign critiques
			while((list($var,$val) = each($studentArr)) && $loopCount < (count($studentArr))){
				$loopCount++; //keep track of the number of times looped
				//print "Value is: $val <br />";
				for($i = 0; $i < $numCrits; $i++){ //assign critiques to this array position
					//if the first element on the for loop and not the last element in array
					if($i == 0 && $loopCount < (count($studentArr))){
						$nextVal = current($studentArr); 
					} else { 
						//get the next user in the array and check if false (at end of array)
						if(next($studentArr) === false){
							$nextVal = reset($studentArr); //at the end of array so loop back to start
							$nextCount++; //position has changed so increment counter
						} else {
							$nextVal = current($studentArr); //not at the end so get the current position
							$nextCount++; //position has changed (from the if check) so increment
						}
					}
					//print "next value is: $nextVal <br />";
					//update the reviewer table with the found ownerID
					add_user_to_critique($val, $assID, $nextVal);
				}
				//return the array to the (original + 1) position 
				for($j=0; $j < $nextCount; $j++){
					if(prev($studentArr) === false){
						end($studentArr);	
					} else {
						current($studentArr);	
					}
				}
				$nextCount = 0; //reset the array pointer counter
			}//end of while loop
			$output = "Success! Critiques have been assigned ";
		}
		
	} 
	//get a list of all students in the selected course
	function get_all_students_in_course($courseID, $semester){
		$sql = "SELECT UserID FROM `courseenrolment` WHERE CourseID=? AND Semester=?";
		$query = MySQL::getInstance()->prepare($sql);
		$query->execute(array($courseID, $semester));
		return $query->fetchAll(PDO::FETCH_ASSOC);
	} 
	//insert into the reviewer table
	function add_user_to_critique($reviewerID, $assignID, $revieweeID){
		$sql = "INSERT INTO `reviewer` (`ReviewerID`, `AssignmentID`, `OwnerID`) VALUES(?,?,?)";
		$query = MySQL::getInstance()->prepare($sql);
		return $query->execute(array($reviewerID, $assignID, $revieweeID));		
	}
	//delete any previous entiries in the table 
	function remove_previous_assigned_critiques($assignID){
		$sql = "DELETE FROM `reviewer` WHERE AssignmentID=?";
		$query = MySQL::getInstance()->prepare($sql);
		return $query->execute(array($assignID));	
	}

?>

        <div class="formtitle"><h3>Assign Critiques</h3></div>
        <widget-container>
        <div class="formcenter">
        <form action="Critiques.php" method="post">
        <div>
        	<label for="cID">Course ID</label>
            <select id="cID" name="cID">
           <?php //display all courseID's that an admin can create an assignment in
				//$arr = array();
				echo "<option value=''>Select...</option>";
				foreach($courses as $course){
					//check that the course to be displayed doesn't already exist
					$cID = strtoupper($course['CourseID']);
					$full = $course['Semester'];
					$sem = substr($course['Semester'],-1);
					$year = substr($course['Semester'],0,4);
					
					
					echo "<option value=".$course['CourseID'].",".$course['Semester'].">".$cID." Semester ".$sem." ".$year."</option>";
				}
			?>
            </select>
        </div>
        <div>
        	<label for="assName">Assignment Name</label>
            <select id="assName" name="assName">
            
            </select>
        </div>
        <div>
        	<label for="numCrits">Set Number of Critiques</label>
            <select id="numCrits" name="numCrits">
                <option value="">Select...</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>
        </div>
        </br>
        
		<input type="submit" name="btnSubmit" value="Submit" class="btn btn-primary" /></br></br>
        
        
		<?php //display the error or success messages after form submit
            if(!empty($output)){
				 echo "<div class='alert alert-warning alert-dismissable'>"
                    . " <a href='#' class='close' data-dismiss='alert' aria-hidden='true'>&times;</a>"
                    . $output
                    . "</div>";
            }
        ?>
    
            
        </form>
        </div>
        </widget-container>

<script>	
	//will popullate the second select tag with data once the first select tag has been set
	jQuery(function ($) {
		$('#cID').on('change', function() {
			//get the data in value attr
			var make = $(this).val();
			$.ajax({
				type: 'POST',
				url: 'lib/_update.php',
				data: {make : make,
						instit: '<?php if(isset($InstitValue)){echo $InstitValue;} ?>'
					}, 
				success: function(data){
					$('#assName').html(data);
				}
			});
		});
	});
</script>
<script>
	$('navgroup:not(.nav-tools)').hide();
</script>

<style>
	.formcenter {width:auto;}
</style>