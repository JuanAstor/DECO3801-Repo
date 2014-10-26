<widget-container>
    <widget title="Upcoming Assessments">
        <panel>
            <div class="w-heading"><i class="fa fa-clipboard"></i>Upcoming Assessments</div>
            <div class="w-body">
                <?php
                // Loop through courses and display
                $count = 0;
                $arr = array();
                foreach ($assessments as $assessment) {
                    $count++;
                    if (in_array($assessment['CourseID'], $arr)) {
                        echo "<p><a href='Assessment.php?assessment=" . $count . "'>" . $assessment['AssignmentName'] . "</a></p>";
                    } else {
                        $sem = substr($assessment['Semester'], -1);
                        $year = substr($assessment['Semester'], 0, 4);
                        echo "<b>" . strtoupper($assessment['CourseID']) . " | Semester " . $sem . " " . $year . "</b><br />";
                        echo "<p><a href='Assessment.php?assessment=" . $count . "'>" . $assessment['AssignmentName'] . "</a></p>";
                        array_push($arr, $assessment['CourseID']);
                    }
                }
                ?>
            </div>
        </panel>
    </widget>
    <!-- End Upcoming Assessments -->
    <widget title="Critique another student's work">
        <panel>
            <div class="w-heading"><i class="fa fa-bullhorn"></i>Provide Feedback</div>
            <div class="w-body">
                <?php
                $arr = array();
                $i = 0;
                $today = date("Y-m-d");
                $today_dt = new DateTime($today);
                $result = get_users_to_critique($user);
                if (count($result) > 0) { //if critiques has been assigned					
                    foreach ($result as $critique) {
                        $dd = get_previous_assign_info($critique['AssignmentID']);
                        //if the current date is greater than the date of submission
                        if ($today_dt > (new DateTime($dd[0]['DueDate']))) {
                            //display the available critiques					
                            $i++;
                            if (in_array($critique['AssignmentID'], $arr)) {
                                echo "<a href='CodeCritique.php?aID=" . $critique['AssignmentID'] . "&oID=" . $i . "'>Critique " . $i . "</a><br />";
                            } else {
                                //get the assignment info
                                $answer = get_previous_assign_info($critique['AssignmentID']);
                                foreach ($answer as $assignInfo) {
                                    echo "<b>" . strtoupper($assignInfo['CourseID']) . "</b> | " . $assignInfo['AssignmentName'] . "<br />";
                                }
                                echo "<a href='CodeCritique.php?aID=" . $critique['AssignmentID'] . "&oID=" . $i . "'>Critique " . $i . "</a><br />";
                                //push the assignID so this will only occur when a new assignment is found
                                array_push($arr, $critique['AssignmentID']);
                            }
                        } else {
                            //critiques are not open to view
                        }
                    }
                } else {
                    echo "<p>No critiques have been assigned yet</p>";
                }
                ?>
            </div>
        </panel>
    </widget>
    <!-- End Tasks -->
    <widget title="Review received comments on submitted work">
        <panel>
            <div class="w-heading"><i class="fa fa-comments"></i>Reviews Received</div>
            <div class="w-body">
                <?php
                $uniqueArr = array(); //hold file id's
					$assignCount = 0;
					foreach ($assessments as $assessment) {
						$assignCount++;
						foreach($submitted as $file){
							if($file['AssignmentID'] == $assessment['AssignmentID']){
								//the assignment id's match then the current assessment is correct
								if(!(in_array($file['FileID'],$uniqueArr))){
									//check that the assignment hasn't already been listed
									if(!(in_array($assessment['AssignmentName'],$uniqueArr))){
										echo "<p><b>".strtoupper($assessment['CourseID'])."</b>  |  "
											.$assessment['AssignmentName']."</p>";
										array_push($uniqueArr, $assessment['AssignmentName']);
									}
									//display the file and a link to the feedback page
									echo "<p><a href='CodeReview.php?assessment=".$assignCount."'>"
									.$file['FileName']."</a> has received new feedback </p>";										
									array_push($uniqueArr, $file['FileID']);
								}
							}
						}
					}
					if(count($uniqueArr) == 0){
						echo "<p>No feedback has been provided yet</p>";	
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