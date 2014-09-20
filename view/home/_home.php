<sidebar>
    <nav>
        <h4><i class="fa fa-graduation-cap"></i> Courses</h4>
        <navgroup>
        <?php // Loop through courses and display
            foreach ($courses as $course) {
                echo "<div><p><i class='fa fa-angle-right'></i> "
                   . $course['CourseID']
                   . "</p></div>";
            }
        ?>
        </navgroup>
        <h4><i class="fa fa-graduation-cap"></i> Courses</h4>
        <navgroup>
        <?php // Loop through courses and display
            foreach ($courses as $course) {
                echo "<div><p><i class='fa fa-angle-right'></i> "
                   . $course['CourseID']
                   . "</p></div>";
            }
        ?>
        </navgroup>
        <h4><i class="fa fa-graduation-cap"></i> Courses</h4>
        <navgroup>
        <?php // Loop through courses and display
            foreach ($courses as $course) {
                echo "<div><p><i class='fa fa-angle-right'></i> "
                   . $course['CourseID']
                   . "</p></div>";
            }
        ?>
        </navgroup>
    </nav>
    <nav-handle><i class="fa fa-sort"></i></nav-handle>
</sidebar>
<widget-container>
    <widget title="Upcoming Assessments">
        <panel>
            <div class="w-heading"><i class="fa fa-clipboard"></i>Upcoming Assessments</div>
            <div class="w-body">
            <?php // Loop through courses and display
            foreach ($assessments as $assessment) {
                echo "<p>"
                   . $assessment['CourseID']
                   . ": "
                   . $assessment['AssignmentName']
                   . "</p>";
            }
            ?>
            </div>
        </panel>
    </widget>
    <!-- End Upcoming Assessments -->
    <widget title="Tasks">
        <panel>
            <div class="w-heading"><i class="fa fa-file-code-o"></i>Tasks</div>
            <div class="w-body">Panel content goes here..</div>
        </panel>
    </widget>
    <!-- End Tasks -->
    <widget title="Reviews Received">
        <panel>
            <div class="w-heading"><i class="fa fa-comment"></i>Reviews Received</div>
            <div class="w-body">Panel content goes here..</div>
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
