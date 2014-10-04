<?php
	//display all assignments available in the course
	$result = get_course_assessments($courseID, $semester);
	
$output = NULL; //the message to be displayed upon form submission

if(isset($_POST['btnFile'])){ //search for files submitted
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
	} else { //not all fields were filled in
		$output = "All fields must be filled out first";	
	}
	
//search for comments
} else if (isset($_POST['btnComment'])){ //comments button selected
	if(isset($_POST['search']) && isset($_POST['AssignName'])){
		$search = $_POST['search'];//the student
		$name = $_POST['AssignName'];// name of the assignment to search
			
		//get the AssignmentID for the Selected Assignment
		$ans = get_assignID($name, $courseID);
		foreach($ans as $id){
			//only one AssignID should be returned, now search for any
			//comments made by the searched user on the assignmentID
			
			$info = find_user_comments($search, $id['AssignmentID']);
			
			//if a comment was made
			if($info != NULL){
				$output = "Comments made by ".$search.": <br />";
				foreach($info as $comments){
					$output.= "A comment was made on File ".$comments['FileID']."<br />";
				}
			//no comments found
			} else {
				$output = "No comments have been made by ".$search." for the '".$name."' Assignment"; 	
			}
		}
		
	} else { //not all fields were filled in
		$output = "Error: All fields must be filled out first";	
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
        
            <br />
            
            <form action="/StudentReviews.php?course=<?php echo $courseID ?>&sem=<?php echo $semester ?>" method="post" >
            	 
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
                <br />
                <label for="btnFile">Search for </label>
                <input type="submit" name="btnFile" value="Files Submitted" class="btn btn-primary" />
                <input type="submit" name="btnComment" value="Comments Made" class="btn btn-primary" />
            </form>
        	<div>
				<?php 
                    //display the search results
                    if($output != NULL){
                        print("$output"); 
                    }
                ?>
            </div>
        </mcontain>
	</body>
</html>