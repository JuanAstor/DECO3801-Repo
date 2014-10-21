<!DOCTYPE html>
<html>
    <head>
    <title>Code Review</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
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
        <p><span class="welcome"><i class="fa fa-user"></i> Welcome <?php echo $fullName;?></span>
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
                foreach ($assessments as $assessment) {
                    echo "<div><p><i class='fa fa-angle-right'></i> <a>".$assessment['AssignmentID'] . "</a></p></div>";
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