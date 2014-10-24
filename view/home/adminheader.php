<!DOCTYPE html>
<html>
    <head>
    <title>Code Review</title>
        <!-- CSS/LESS -->
        <link rel="stylesheet/less" href="css/main.less">
        <!-- JS -->
        <script src="http://code.jquery.com/jquery-1.8.0.min.js"></script>
        <script src="js/view.js"></script>
        <script src="js/less.js"></script>
    </head>
    <body>
    <header>
        <logo>Peer <span>{</span>Code Review<span>}</span></logo>
        <p><span class="welcome"><i class="fa fa-user"></i> Welcome 
            <?php foreach ($fullName as $name) {
                    echo $name['FName']." ".$name['SName'] ;
                }
            ?></span>
        <a href="view/logout/_logout.php">Log out</a></p>
    </header>
    <sidebar>
        <nav>
            <h4><i class="fa fa-tachometer"></i><span>Dashboard</span></h4>
            <h4><i class="fa fa-clipboard"></i><span>Edit Assessment</span></h4>
            <navgroup class="nav-editAssessment">
               
            <?php // Loop through courses and display
				foreach($courses as $course){
					echo "<p class='iscourse'><span>".$course['CourseID']."   |	   "
					 	."<span>Semester ".substr($course['Semester'],-1)." ".substr($course['Semester'],0,4)."</span>";
						 
					$result = get_course_assessments($course['CourseID'], $course['Semester']);
					foreach($result as $names){	
						echo "<p><i class='fa fa-angle-right'></i>"
						."<a href='EditAssessment.php?course=".$course['CourseID']."&sem="
						.$course['Semester']."&assignmentName=".$names['AssignmentName']."'>"
						.$names['AssignmentName']."</a></p>";
					}
				}
            ?>
            </navgroup>
            <h4><i class="fa fa-file-code-o"></i><span>Review Students</span></h4>
            <navgroup class="nav-reviewStudents">
            <?php 
			foreach($courses as $course){
				//display all courses that the admin is in charge of
				echo "<p class='iscourse'><span>".$course['CourseID']."   |  "
					."Semester ".substr($course['Semester'], -1)."    ".substr($course['Semester'],0,4)."</span>";
				echo "<p><i class='fa fa-angle-right'></i>" 
				."<a href='StudentReviews.php?course=".$course['CourseID']."&sem=".
				$course['Semester']."'>Review</a></p>";
			}
            ?>
            </navgroup>
            <h4><i class="fa fa-wrench"></i><span>Tools</span></h4>
            <navgroup class="nav-tools">
            <?php // Loop through courses and display
				echo "<p><i class='fa fa-angle-right'></i>"
				."<a href='Assessment.php'>Create Assessment</a></p>";
				echo "<p><i class='fa fa-angle-right'></i>"
				."<a href='Critiques.php'>Assign Critiques</a></p>";
				?>
            </navgroup>
        </nav>
        <nav-handle><i class="fa fa-sort"></i></nav-handle>
    </sidebar>    
    <page>