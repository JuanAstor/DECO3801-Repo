<?php
	//display all assignments available in the course
	$result = get_course_assessments($courseID, $semester);
	
$output = NULL; //the message to be displayed upon form submission
$assignID = NULL; // to hold the assignment ID
if(isset($_POST['btnFile'])){ //search for files submitted
	if(isset($_POST['search']) && isset($_POST['AssignName'])){
		$search = $_POST['search'];
		$name = $_POST['AssignName'];
		 
		//get the AssignmentID for the Selected Assignment
		$ans = get_assignID($name, $courseID);
		foreach($ans as $id){
			//only one assign id should ever be returned (since AssignID's are unique in the DB)
			//now search for all submissions by a student for that assignmentid
			$assignID = $id['AssignmentID'];
			$info = get_submitted_info($search, $id['AssignmentID']);
		}
		if($info != NULL){ //if a user has submitted a file for the assigment
			$output = "File(s) submitted by student ".$search.": <br />";
			
		} else { //no files submitted
			$output = "No files have been submitted by student ".$search;	
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
			
			$comment = find_user_comments($search, $id['AssignmentID']);
			
			//if a comment was made
			if($comment != NULL){
				$output = "Comments made by student ".$search.": <br />";
				foreach($comment as $comments){
					$output.= "A comment was made on File ".$comments['FileID']."<br />";
				}
			//no comments found
			} else {
				$output = "No comments have been made by student ".$search." for the '".$name."' Assignment"; 	
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
        <!-- <link rel="stylesheet/less" href="/css/main.less">
        <link rel="stylesheet" type="text/css" href="/mockup/main.css">
        <!-- JS -->
      
      <title>Code Review</title>
		<link rel="stylesheet/less" href="/css/main.less">
        <!--<link rel="stylesheet" type="text/css" href="../mockup/main.css">-->
		
       
        
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
        
         <script src='/js/view.js'></script>
        <script src="/js/less.js"></script>

        <!-- Load the Prettify script, to use in highlighting our code.-->
        <script src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js"></script>	

        <?php date_default_timezone_set('Australia/Brisbane'); ?>
       
       		

    </head>
	<body>
       
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
					if($output == NULL){
						echo "No Files Found";
					} else {
						echo $output;
						if(isset($info)){
							foreach($info as $fileName){
								echo "<a class='filelist'>".$fileName['FileName']. "</a><br>";	
							}
						}
					}
					
                ?>
        </div>
        <div >
            <pre class="prettyprint">Nothing selected</pre>
        </div>
	</body>
	<script>
			
		jQuery(function ($) {
						
			$(".filelist").click(function() {
				
				var file = $(this).text();
				//alert(file);
				$.ajax({
					type: 'POST', 
					url: '../lib/retrieve.php', 
					data: {filename: file, 
							user: '<?php echo $search ?>', 
							assign: '<?php echo $assignID ?>'},
					success: function(data){
						$("pre").text(data);
						$("head")
					}
				});
			});
		});
	</script>
    

</html>