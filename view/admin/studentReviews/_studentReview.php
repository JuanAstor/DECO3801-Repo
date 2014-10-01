<?php
	//display all assignments available in the course
	$result = get_course_assessments($courseID);
	
$output = NULL;
if(isset($_POST['search']) && isset($_POST['AssignName'])){
	$search = $_POST['search'];
	$name = $_POST['AssignName'];
	 
	//get the AssignmentID for the Selected Assignment
	$ans = get_assignID($name, $courseID);
	foreach($ans as $id){
		//only one assign id should ever be returned (since AssignID's are unique in the DB)
		//now search for all submissions by a student for that assignmentid
		$info = get_submitted_info($search, $id['AssignmentID']);
	}
	if($info != NULL){ //if a user has submitted a file for the assigment
		$output = "File(s) submitted by ".$search.": <br />";
		foreach($info as $files){
			//add to the output string, the data you wish to display
			$str = "'".$files['FileName']."'";
			$str2 = "  was submitted at  ".$files['SubmissionTime'];
			$str3 = "<br />";
			$output.= $str.$str2.$str3;
		}
	} else { //no files submitted
		$output = "No files have been submitted by ".$search;	
	}
}
?>
<!DOCTYPE html>
<html>
    <head>
    <title>Code Review</title>
        <!-- CSS/LESS -->
        <link rel="stylesheet/less" href="/css/main.less">
        <!-- JS -->
        <script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
       <script src='/js/view.js'></script>
        <script src="/js/less.js"></script>
    </head>
	<body>
        <mcontain>
            <h2>Review Student Submissions for <?php echo $courseID?></h2>
        
            <button type="button" class="btn btn-primary">Show all Students</button>
            <button type="button" class="btn btn-primary">Clear</button>
            <br></br>
            
            <form action="/StudentReviews.php?course=<?php echo $courseID ?>" method="post" >
            	<label>Select Assignment</label>
                <!--<select name="AssignName"> -->
                <?php 
					echo "<select name='AssignName'>";
					echo "<option value=''>Select...</option>";
					foreach($result as $na) {
						$name = $na['AssignmentName'];
						echo "<option value='".$name."' >".$name."</option>"; //display all assignment options
					}
					echo "</select>";
				?>
           		<!--<option value="0">Select...<?//=$options?>
            	</option> 
            	</select> -->
                <label for="search">Search</label>
                <input type="text" name="search" placeholder="Enter Student Number">
                <input type="submit" value="submit" class="btn btn-primary">
            </form>
        
            <?php 
				//display the search results
				if($output != NULL){
            		print("$output"); 
				}
            ?>
        </mcontain>
	</body>
</html>