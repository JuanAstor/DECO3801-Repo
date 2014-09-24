<?php

?>
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
            <div class="w-heading"><i class="fa fa-list-ol"></i>Tasks</div>
            <div class="w-body">Panel content goes here..</div>
        </panel>
    </widget>
    <!-- End Tasks -->
    <widget title="Reviews Received">
        <panel>
            <div class="w-heading"><i class="fa fa-comment"></i>Reviews Received</div>
            <div class="w-body">
            	<?php 
					foreach($submitted as $file){
						echo $file['AssignmentID']. " : '". $file['FileName'] ."' new feedback";
						echo "<br>";
					}
				?>
            </div>
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
