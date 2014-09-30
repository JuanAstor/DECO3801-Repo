<!DOCTYPE html>
<html>
    <head>
    <title>Code Review</title>
        <!-- CSS/LESS -->
        <link rel="stylesheet/less" href="../css/main.less">
        <!-- JS -->
        <script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
        <script src='../js/view.js'></script>
        <script src="../js/less.js"></script>
    </head>
	<body>
    	
	<widget-container>
		<widget title="Created Assessment">
			<panel>
				<div class="w-heading"><i class="fa fa-clipboard"></i>Created Assessment</div>
				
				<div class="w-body">DECO3500 <button onclick="location.href = '';" id="Button1" class="btn btn-primary" submit-button">></button></div>
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
							echo "<a href='/StudentReviews.php?course=".$course['CourseID']."'><button type='button' class='btn btn-primary'>Go</button></a>";
							echo "<br /> <br />";
						}
					?>
				</div>
			</panel>
		</widget> 
        <!-- the create assessment image, on click it -->
		<img src="/img/cass3.png" class="img-circle" onclick="location.href = '/Assessment.php'">
	</widget-container>
	
	<widget-end>
		<div><panel-end></panel-end></div>
		<div><panel-end></panel-end></div>
    </widget-end>
    	
	</body>
</html>

