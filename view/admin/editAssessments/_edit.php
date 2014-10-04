<?php
	//get all the info about the assignment accessed
	$output = NULL;
	$result = get_assign_info($courseID, $semester, $name);
	foreach($result as $info){ //should only be one assignment result for a CourseID, Semester and Name
		$assignID = $info['AssignmentID']; //need this to update or delete table entries
		$assDesc = $info['AssignmentDescription'];
		$dueTime = $info['DueTime'];
		$dueDate = $info['DueDate'];
	}
	//session will be set on update 
	if(isset($_SESSION['message'])){
		if($_SESSION['message'] == 'completed'){ 
			$output = 'The assignment has been updated, as can be seen below';
			unset($_SESSION['message']); //unset so the message will dissapear on page return
		}
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
    	<h2>Edit Assessment For <?php echo $courseID. " Semester " .substr($semester, -1) ?> </h2>
		<widget-container>
        	<!-- '/EditAssessment.php?course="<?php echo $courseID ?>"&sem="<?php echo $semester ?>"&name="<?php echo $name ?>'-->
			<form action="../lib/_update.php" method="post">
            	<div>
                	<?php 
						if($output != NULL){
							print($output);	
						}
					?>
                </div>
				<div class="form-group">
                	<input type="hidden" name="AssignID" value="<?php echo $assignID ?>" />
                    <input type="hidden" name="cID" value="<?php echo $courseID ?>" />
                    <input type="hidden" name="sem" value="<?php echo $semester ?>" />
                </div>
				<div class="form-group">
					<label for="aName">Assignment Name</label>
					<input class="form-control" id="aName" name="AName" value="<?php echo $name ?>" placeholder="Enter Assignment name here">
				</div>
				<div class="form-group">
					<label for="description">Assignment Description</label>
					<textarea class="form-control" name="desc"id="description"rows="2"><?php echo $assDesc ?></textarea>
				</div>
				
				<div class="form-group">
					<label for="time">Time Due</label>
					<input class="form-control" id="time" name="time" value="<?php echo $dueTime ?>" placeholder="Time Format: 24hour - HH:MM">
				</div>
				
				
 
				<div class="form-group">
					<label for="date">Date Due</label>
					<input class="form-control" id="date" name="date" value="<?php echo $dueDate ?>" placeholder="Format: YYYY/MM/DD">
				</div>
				
				<label>Please make sure that every field has been completed</label>
				<button type="submit" class="btn btn-primary" >Update</button>
                <button type="reset" id="delete" class="btn btn-primary">Delete</button>
			</form>
		</widget-container>
        <div class="delMessage">
        	
        </div>
	</body>
</html>

<script>
jQuery(function ($) {
	//when the delete button is clicked
    $("#delete").click(function() {
		if(confirm('Are you sure you want to delete this assignment?\n\nAny submissions for this Assignment will also be deleted')){
        // post to the _update.php file the info necessary to delete the assignment
			$.ajax({
				type:'POST',
				url:'../lib/_update.php',
				data: {assignID : <?php echo $assignID ?>,
					   del : "delete" },
				success: function(data){
					//once the assignment has been deleted
					//alert the user it has been successful and then return to the homepage.
					alert(data);
					var url = "/index.php";
					$(location).attr('href',url);				
					
				}
			});
		}
    });
});
                    
</script>