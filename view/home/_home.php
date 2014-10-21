<widget-container>
    <widget title="Upcoming Assessments">
        <panel>
            <div class="w-heading"><i class="fa fa-clipboard"></i>Upcoming Assessments</div>
            <div class="w-body">
            <?php // Loop through courses and display
			$count=0;
            foreach ($assessments as $assessment) {
				$count++;
                echo "<p><a href='Assessment.php?assessment=".$count."'><b>".strtoupper($assessment['CourseID'])."</b>: ".$assessment['AssignmentName']."</a></p>";
            }
            ?>
            </div>
        </panel>
    </widget>
    <!-- End Upcoming Assessments -->
    <widget title="Tasks">
        <panel>
            <div class="w-heading"><i class="fa fa-list-ol"></i>Tasks</div>
            <div class="w-body">
            	<?php 
					$arr = array();
					$i = 0;
					$result = get_users_to_critique($user);
					if(count($result) > 0){
						foreach($result as $critique){
							$i++;
							if(in_array($critique['AssignmentID'],$arr)){
								echo "Critique ".$i."<br />";
							} else {
								//get the assignment info
								$answer = get_previous_assign_info($critique['AssignmentID']);
								foreach($answer as $assignInfo){
									echo "<b>".strtoupper($assignInfo['CourseID'])."</b> : ".$assignInfo['AssignmentName']."<br />";
								}  
								echo "Critique ".$i."<br />";
								//push the assignID so this will only occur when a new assignment is found
								array_push($arr, $critique['AssignmentID']); 
							}
						}
					} else {
						echo "No critiques have been assigned yet";	
					}
				?>
            </div>
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

<script>
	$('navgroup').hide();
</script>