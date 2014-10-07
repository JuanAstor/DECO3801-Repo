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
    	
	<widget-container>
		<widget title="Edit Assessment">
			<panel>
				<div class="w-heading"><i class="fa fa-clipboard"></i>Edit Assessment</div>
				
				<div class="w-body">
                	<?php 
						foreach($courses as $course){
							echo "<span>".$course['CourseID']."   |	   </span>";
							echo "<span>Semester ".substr($course['Semester'],-1)." ".substr($course['Semester'],0,4)."    </span>";
							echo "<br />"; 
							$result = get_course_assessments($course['CourseID'], $course['Semester']);
							foreach($result as $name){	
								echo "<span>--------------</span>";
								echo $name['AssignmentName'];
								echo "<a href='/EditAssessment.php?course=".$course['CourseID']."&sem=".$course['Semester']."&name=".$name['AssignmentName']."'><button type='button' class='btn btn-primary'>Go</button></a>";
								echo "<br />";
							}
							echo "<br />";
						}
					?>
                </div>
			</panel>
		</widget>
		<widget title="Review Students">
			<panel>
				<div class="w-heading"><i class="fa fa-file-code-o"></i>Review Students</div>
    
				<div class="w-body">
                	<?php 
						foreach($courses as $course){
							//echo $course['CourseID']." <button onclick='location.href = /studentReviews.php'; />";
							echo "<span>".$course['CourseID']."   |  </span>";
							echo "<span>Sem ".substr($course['Semester'], -1)."    ".substr($course['Semester'],0,4)."      </span>";
							echo "<a href='/StudentReviews.php?course=".$course['CourseID']."&sem=".$course['Semester']."'><button type='button' class='btn btn-primary'>Go</button></a>";
							echo "<br /> <br />";
						}
					?>
				</div>
			</panel>
		</widget>
        <widget title="Tools">
			<panel>
				<div class="w-heading"><i class="fa fa-wrench"></i>Tools</div>

				<div class="w-body">
                    <img src="img/cass2.png" class="img-circle" width="50px" height="auto" onclick="location.href = 'Assessment.php'">
                    <h3>Create Assignment</h3>
				</div>
			</panel>
		</widget>
	</widget-container>
	
	<widget-end>
		<div><panel-end></panel-end></div>
		<div><panel-end></panel-end></div>
    </widget-end>
    	
	</body>
</html>

