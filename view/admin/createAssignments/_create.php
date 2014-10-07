<?php

	$output = NULL; //what is to be displayed to the admin on form submit
	//if all the form values have been set, assign variables, error check and then send to database
	if(isset($_POST['cID']) && isset($_POST['semester']) && isset($_POST['AName']) && isset($_POST['desc']) && 
	isset($_POST['time']) && isset($_POST['date'])){
		$courseID = $_POST['cID'];
		$sem = $_POST['semester'];
		$name = $_POST['AName'];
		$description = $_POST['desc'];
		$time = $_POST['time'];
		$date = $_POST['date'];
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
				create_assignment($courseID, $semester, $description, $name, $date, $time);
				$output = "The Assignment has successfully been created <br />";
			} else {
				$output = "Error: Semester value doesn't match the selected course";	
			}
		}		
		
	} else {
		//$output = "Error: One or more fields were not completed";
	}
?>
<html>
    <head>
    <title>Code Review</title>
        <!-- CSS/LESS -->
        <link rel="stylesheet/less" href="/css/main.less">
        <!-- JS -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src='/js/view.js'></script>
        <script src="/js/less.js"></script>
		<!--<script src="../js/moment.js"></script> -->
        <link rel="stylesheet" type="text/css" href="/css/bootstrap-datetimepicker.min.css">
		
		<!-- <script src="../js/bootstrap.min.js"></script>
		<script src="../js/bootstrap-datetimepicker.min.js"></script> -->
    </head>
	<body>
    	<h4>Create Assessment</h4>
		<widget-container>
			<form action="/Assessment.php" method="post">
				<div class="form-group">
					<label for="cID">Course ID</label>
					<?php //display all courseID's that an admin can create an assignment in
					echo "<select name='cID' id='cID'>";
					echo "<option value=''>Select...</option>";
					foreach($courses as $course){
						$cID = $course['CourseID'];
						echo "<option value='".$cID."' >".$cID."</option>";
					}
					echo "</select>";
					?>
				</div>
                <div> <!-- display all semester choices -->
                	<label for="sem">Semester</label>
                    <select name="semester" id="sem">
                    	<option value="">Select...</option>
                    	<option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
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
					<input class="form-control" id="date" name="date" placeholder="Format: YYYY/MM/DD">
				</div>
				
				<label>Please make sure that every field has been completed</label>
				<button type="submit" class="btn btn-primary">Submit</button>
			</form>
		</widget-container>
        
        <div> 
        	<?php //display the error or success messages after form submit
				if($output != NULL){
					print($output);	
				}
			?>
        </div>
        
	</body>
</html>