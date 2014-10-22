<?php

	$output = NULL; //what is to be displayed to the admin on form submit
	//if all the form values have been set, assign variables, error check and then send to database
	if(isset($_POST['cID']) && isset($_POST['AName']) && isset($_POST['desc']) && isset($_POST['time']) 
	&& isset($_POST['date'])){
		$val = explode(",", $_POST['cID']);
		$courseID = $val[0]; //course ID
		$fullsem = $val[1]; //format = YYYYS eg 20141, semester = 1 of year 2014
		$sem = substr($fullsem,-1); //get the semester value
		$name = $_POST['AName'];
		$description = $_POST['desc'];
		$time = $_POST['time'];
		$dateFormat = $_POST['date'];
		
		//check if the date is valid
		if(!check_valid_date($dateFormat)){
			$output = "Error: The date was invalid or not of the correct format (dd/mm/yyyy)";
		} else {
			//convert the date into the format stored in the database
			$newdate = DateTime::createFromFormat('d/m/Y', $dateFormat);
			$finalDate = $newdate->format('Y-m-d');
			//covert the semester to the yyyy-s format used in the database
			//check that the assigment name doesn't already exist for that courseID
			
			$semester = date('Y').$sem; 
			$count = find_assignmentName($courseID, $name, $semester);
			
			if($count > 0){
				//then an assigment name already exists for this courseID and semester
				$output = "Error: The assignment name entered already exists for this course and semester";	
			} else { 
				$semCount = check_semester($courseID, $semester); //check that the semester value is correct
				if($semCount > 0) {
					//the assignment name for the courseID and semester is unique, so continue.
					//add the values to the database return a success message
					create_assignment($courseID, $semester, $description, $name, $finalDate, $time);
					$output = "The Assignment has successfully been created";
				} else {
					$output = "Error: Semester value doesn't match the selected course";	
				}
			}
		}
		
	}
	
	//check the validity of the entered date
	function check_valid_date($date){
		if(substr_count($date, "/") == 2){
			$fullDate = explode("/", $date);
			$day = 	(int)$fullDate[0];
			$month = (int)$fullDate[1];
			$year = (int)$fullDate[2];
			
			if(checkdate($month, $day, $year)){
				return true;	
			}			
		} else {
			return false;
		}
		return false;
	}
?>
<html>
    <head>
    <title>Code Review</title>
        <!-- CSS/LESS -->
        <link rel="stylesheet/less" href="/css/main.less">
        <!-- JS -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		<!--<script src="../js/moment.js"></script> -->
        
		
		<!-- <script src="../js/bootstrap.min.js"></script>
		<script src="../js/bootstrap-datetimepicker.min.js"></script> -->
    </head>
	<body>
        <div class="formtitle"><h3>Create Assessment</h3></div>
		<widget-container>
            <div class="formcenter">
			<form action="/Assessment.php" method="post">
				<div class="form-group">
					<label for="cID">Course ID</label>
					<?php //display all courseID's that an admin can create an assignment in
					echo "<select name='cID' id='cID'>";
					echo "<option value=''>Select...</option>";
					foreach($courses as $course){
						//check that the course to be displayed doesn't already exist
						$cID = strtoupper($course['CourseID']);
						$full = $course['Semester'];
						$sem = substr($course['Semester'],-1);
						$year = substr($course['Semester'],0,4);
						
						echo "<option value=".$course['CourseID'].",".$course['Semester'].">".$cID." Semester ".$sem." ".$year."</option>";
					}
					echo "</select>";
					?>
				</div>

				<div class="form-group">
					<label for="aName">Assignment Name</label>
					<input class="form-control" id="aName" name="AName" placeholder="Enter Assignment name here">
				</div>
				<div class="form-group">
					<label for="description">Assignment Description</label>
					<textarea class="form-control" name="desc"id="description"rows="2"></textarea>
				</div>
				
				<div class="form-group">
					<label for="time">Time Due</label>
					<input class="form-control" id="time" name="time" placeholder="Time Format: 24hour - HH:MM">
				</div>
				
				
 
				<div class="form-group">
					<label for="date">Date Due</label>
					<input class="form-control" id="date" name="date" placeholder="Format: DD/MM/YYYY">
				</div>
                </br>
				
                <label>Please make sure that every field has been completed</label></br>
				<button type="submit" class="btn btn-primary">Submit</button></br></br>
                
                <div class="alert alert-warning alert-dismissable"> 
                    <a href="#" class="close" data-dismiss="alert" aria-hidden="true">&times;</a>
        	           <?php //display the error or success messages after form submit
				            if($output != NULL){
					           print($output);	
				            }
			             ?>
                </div>
 
			</form>
            </div>
		</widget-container>
        
	</body>
</html>