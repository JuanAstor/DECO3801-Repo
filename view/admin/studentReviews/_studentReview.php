<?php
	//display all assignments available in the course
	$result = get_course_assessments($courseID);
	
$output = NULL;
if(isset($_POST['search']) && isset($_POST['AssignName'])){
	$search = $_POST['search'];
	$name = $_POST['AssignName'];
	echo $name;
	//use student# plus courseID to return all students who've submitted. 
	
	echo "<br />";
	$ans = get_assignID($name, $courseID);
	foreach($ans as $id){
		echo $id['AssignmentID'];
		echo "<br />";	
	}
	echo $ans[0]['AssignmentID'];
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
            	print("$output");
            ?>
        </mcontain>
	</body>
</html>