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
        <p><span class="welcome"><i class="fa fa-user"></i> Welcome <?php 			
    foreach ($fullName as $name) {
        echo $name['FName']." ".$name['SName'] ;
    }
 ?></span>
        <a href="view/logout/_logout.php">Log out</a></p>
    </header>
    <sidebar>
        <nav>
            <h4><i class="fa fa-tachometer"></i><span>Dashboard</span></h4>
            <h4><i class="fa fa-pencil"></i><span>Assessment</span></h4>
            <navgroup class="nav-assessment">
                <div>
                    <p><a href='Assessment.php'>Show All</a></p>
                </div>
            <?php // Loop through courses and display
			if(!check_if_admin($user)){//if not n admin
                $course = "";
                $count = 0;
                foreach ($assessments as $assessment) {
                    $count++;
                    echo "<div>";
                    if ($course != $assessment['CourseID']) {
                        echo "<p class='iscourse'><span>".$assessment['CourseID']."</span> ";
                        $course = $assessment['CourseID'];
                    }
                    echo "<p><i class='fa fa-angle-right'></i> "
                       . "<a href='Assessment.php?assessment=".$count."'>".$assessment['AssignmentName']."</a>"
                       . "</p></div>";
                }
			}
            ?>
            </navgroup>
            <h4><i class="fa fa-comments"></i><span>Review</span></h4>
            <navgroup class="nav-review">
            <?php // Loop through courses and display
			if(!check_if_admin($user)){ //if not an admin
                $arr = array();
				$x = 0; $today = date("Y-m-d");
				$today_dt = new DateTime($today);
				$res = get_users_to_critique($user);
				if(count($res) > 0){ //if critiques has been assigned
					foreach($res as $crit){
						$dd = get_previous_assign_info($crit['AssignmentID']);
						//if the current date is greater than the date of submission
						if($today_dt > (new DateTime($dd[0]['DueDate']))){
							//display the available critiques					
							$x++;
							if(in_array($crit['AssignmentID'],$arr)){
								//diplay the critique link
								echo "<p><i class='fa fa-angle-right'></i>"
								."<a href='CodeCritique.php?aID=".$crit['AssignmentID']."&oID=".$x."'>Critique ".$x."</a></p>";
							} else { //not in array so
								foreach($dd as $assInfo){
									//display Course ID and Assignment Name
									echo "<p class='iscourse'><span>" 
									."<b>".strtoupper($assInfo['CourseID'])."</b> : ".$assInfo['AssignmentName']."</span></p>";
								}  
								//display the critique link
								echo "<p><i class='fa fa-angle-right'></i>"
								."<a href='CodeCritique.php?aID=".$crit['AssignmentID']."&oID=".$x."'>Critique ".$x."</a></p>";
								//push the assignID so this will only occur when a new assignment is found
								array_push($arr, $crit['AssignmentID']); 
							}
							} else {
								//critiques are not open yet but have been assigned
							}
						}
					} else {
						echo "<p><span>No critiques found</span></p>";	
					}
			}
            ?>
            </navgroup>
            <h4><i class="fa fa-bullhorn"></i><span>Feedback</span></h4>
            <navgroup class="nav-feedback">
            <?php // Loop through courses and display
			if(!check_if_admin($user)){ //if not an admin
                $course = "";
                $count = 0;
                foreach ($assessments as $assessment) {
                    $count++;
                    echo "<div>";
                    if ($course != $assessment['CourseID']) {
                        echo "<p class='iscourse'><span>".$assessment['CourseID']."</span> ";
                        $course = $assessment['CourseID'];
                    }
                    echo "<p><i class='fa fa-angle-right'></i> "
                       . "<a href='CodeReview.php?assessment=".$count."'>".$assessment['AssignmentName']."</a>"
                       . "</p></div>";
                }
			}
            ?>
            </navgroup>
        </nav>
        <nav-handle><i class="fa fa-sort"></i></nav-handle>
    </sidebar>    
    <page>