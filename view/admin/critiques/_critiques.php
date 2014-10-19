<?php
	

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
        
		
		<!-- <script src="../js/bootstrap.min.js"></script>
		<script src="../js/bootstrap-datetimepicker.min.js"></script> -->
    </head>
	<body>
    	<h4>Assign Critiques</h4>
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
					
					//if(!in_array($cID, $arr)){
						//array_push($arr, $cID); 
						echo "<option value=".$course['CourseID'].",".$course['Semester'].">".$cID." Semester ".$sem." ".$year."</option>";
					//} else {
						//value already in the array so do nothing	
					//}
				}
				//echo "</select>";
				//$arr = NULL;
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
            </select>
        </div>
    </body>
</html>

<script>
	
	//will popullate the second select tag with data once the first select tag has been set
	jQuery(function ($) {
		$('#cID').on('change', function() {
			//get the data in value attr
			var make = $(this).val();
			alert(make);
			$.ajax({
				type: 'POST',
				url: '../lib/_update.php',
				data: {make : make}, 
				success: function(data){
					$('#assName').html(data);	
				}
			});
		});
	});
</script>