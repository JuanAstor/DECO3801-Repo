<widget-container>
    <widget title="Upcoming Assessments">
        <panel>
            <div class="w-heading"><i class="fa fa-clipboard"></i>Upcoming Assessments</div>
            <div class="w-body">
            <?php // Loop through courses and display
			$count=0;
			$arr = array();
            foreach ($assessments as $assessment) {
				$count++;
				if(in_array($assessment['CourseID'], $arr)){
					echo "<p><a href='Assessment.php?assessment=".$count."'>".$assessment['AssignmentName']."</a></p>";	
				} else {
					$sem = substr($assessment['Semester'], -1);
					$year = substr($assessment['Semester'], 0, 4);
					echo "<b>".strtoupper($assessment['CourseID'])." : Semester ".$sem." ".$year."</b><br />";
					echo "<p><a href='Assessment.php?assessment=".$count."'>".$assessment['AssignmentName']."</a></p>";
					array_push($arr, $assessment['CourseID']);
				}
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
					$i = 0; $today = date("Y-m-d");
					$today_dt = new DateTime($today);
					$result = get_users_to_critique($user);
					if(count($result) > 0){ //if critiques has been assigned					
						foreach($result as $critique){
							$dd = get_previous_assign_info($critique['AssignmentID']);
							//if the current date is greater than the date of submission
							if($today_dt > (new DateTime($dd[0]['DueDate']))){
								//display the available critiques					
								$i++;
								if(in_array($critique['AssignmentID'],$arr)){
									echo "<a href='CodeCritique.php?aID=".$critique['AssignmentID']."&oID=".$i."'>Critique ".$i."</a><br />";
								} else {
									//get the assignment info
									$answer = get_previous_assign_info($critique['AssignmentID']);
									foreach($answer as $assignInfo){
										echo "<b>".strtoupper($assignInfo['CourseID'])."</b> : ".$assignInfo['AssignmentName']."<br />";
									}  
									echo "<a href='CodeCritique.php?aID=".$critique['AssignmentID']."&oID=".$i."'>Critique ".$i."</a><br />";
									//push the assignID so this will only occur when a new assignment is found
									array_push($arr, $critique['AssignmentID']); 
								}
							} else {
								//critiques are not open to view
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