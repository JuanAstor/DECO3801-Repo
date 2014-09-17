<sidebar>
    <nav>
        <h5><i class="fa fa-graduation-cap"></i> Courses</h5>
        <?php // Loop through courses and display
            foreach ($courses as $course) {
                echo "<p><i class='fa fa-angle-right'></i> "
                    . $course['CourseID'] 
                    ."</p>";
            }
        ?>
    </nav>
</sidebar>
<widget-container>
    <widget title="Upcoming Assessments">
        <panel>
            <div title="heading"><i class="fa fa-clipboard"></i>Upcoming Assessments</div>
            <div title="body">
            <?php // Loop through courses and display
            foreach ($assessments as $assessment) {
                echo "<p>"
                    . $assessment['CourseID']
                    . ": "
                    . $assessment['AssignmentID'] 
                    ."</p>";
            }
            ?>
            </div>
        </panel>
    </widget>
    <!-- End Upcoming Assessments -->
    <widget title="Tasks">
        <panel>
            <div title="heading"><i class="fa fa-file-code-o"></i>Tasks</div>
            <div title="body">Panel content goes here..</div>
        </panel>
    </widget>
    <!-- End Tasks -->
    <widget title="Reviews Received">
        <panel>
            <div title="heading"><i class="fa fa-comment"></i>Reviews Received</div>
            <div title="body">Panel content goes here..</div>
        </panel>
    </widget>
    <!-- End Reviews Received -->
</widget-container>
<widget-end>
    <div><panel-end></panel-end></div>
    <div><panel-end></panel-end></div>
    <div><panel-end></panel-end></div>
</widget-end>

<div class="dashboard-content">
		<?php 
			
			foreach ($fullName as $name) {
				echo "<p> Welcome "
						. $name['FName']
						. " " 
						. $name['SName']
						. "</p>" ;
			}
		 ?>
</div>
