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
					//for each file that a user has submitted
					foreach($submitted as $file) {
						//count the number of times a file has been commented on
						$count = get_number_of_feedback($file['FileID']); 
						if($count[0][0] > 0){ //if a file has been commented
							echo "AssignmentID: ".$file['AssignmentID'];  //display what assignmentID it's related to
							echo "<br>";
							//loop through all comments and display the file that was commented on
							for($i = 0; $i < $count[0][0]; $i++){
								echo " '".$file['FileName']."' has received feedback";
								echo "<br>";
							}
						}
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
