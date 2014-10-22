<?php
	//display all assignments available in the course
	$result = get_course_assessments($courseID, $semester);
	
$output = NULL; //the message to be displayed upon form submission
$assignID = NULL; // to hold the assignment ID
if(isset($_POST['btnFile'])){ //search for files submitted
	if(isset($_POST['search']) && (strcmp($_POST['search'],"")!==0) && isset($_POST['AssignName']) && (strcmp($_POST['AssignName'],"")!==0)){
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
		if(count($info) > 0){ //if a user has submitted a file for the assigment
			$output = "File(s) submitted by student ".$search.": <br />";
			
		} else { //no files submitted
			$output = "No files have been submitted by student ".$search;	
		}
	} else { //not all fields were filled in
		$output = "Error: All fields must be filled out first";	
	}
	
//search for comments
} else if (isset($_POST['btnComment'])){ //comments button selected
	if(isset($_POST['search']) && (strcmp($_POST['search'],"")!==0) && isset($_POST['AssignName']) && (strcmp($_POST['AssignName'],"")!==0)){
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
     
    <link rel="stylesheet/less" href="/css/main.less">
    <!--<link rel="stylesheet" type="text/css" href="../mockup/main.css">-->
        
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
           
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
    
    <!-- Load the Prettify script, to use in highlighting our code.-->
    <script src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js"></script>	

    <?php date_default_timezone_set('Australia/Brisbane'); ?>      		

    </head>
	<body>
       
        <div class="formtitle"><h3>Review Submisssions for <?php echo $courseID?></h3></div>
    
        <br />
        <div class="formcenter">
        <form action="/StudentReviews.php?course=<?php echo $courseID ?>&sem=<?php echo $semester ?>" method="post">  
            <div class="form-group">
            <label>Select Assignment  </label>
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
            </br>
            <label for="search">Student Number  </label>
            <input class="form-control" type="text" name="search" placeholder="Enter Student Number">
            <br />
            </br>
            <label for="btnFile">Search for  </label>
            <input type="submit" name="btnFile" value="Files Submitted" class="btn btn-primary" />
            <input type="submit" name="btnComment" value="Comments Made" class="btn btn-primary" />
        </form>
        </br>
        </br>
                
        <div class="alert alert-warning alert-dismissable"> 
            <a href="#" class="close" data-dismiss="alert" aria-hidden="true">&times;</a>
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
            </br>
            <div >
                <pre class="prettyprint">Nothing selected</pre>
            </div>
        </div>
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