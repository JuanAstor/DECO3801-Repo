<!DOCTYPE html>
<html>
    <?php
    if (isset($_POST['oauth_consumer_key'])) {
        require_once 'lib/mysql.php';
        require_once 'lib/queries.php'; // query functions to get database results
        require_once 'lib/ltisession.php';
        enrolCourse($user, $_SESSION['courseName'], $_SESSION['institutionId'],  $_SESSION['isInstructor']);
        header('Location: index.php');
    }
    ?>
    <head>
        <title>Code Review</title>
        <!-- CSS/LESS -->
        <link rel="stylesheet/less" href="css/main.less">
        <!-- JS -->
        <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
        <script src="js/view.js"></script>
        <script src="js/less.js"></script>
    </head>
    <body>
        <header>
            <logo>Peer <span>{</span>Code Review<span>}</span></logo>
            <p><span class="welcome"><i class="fa fa-user"></i> Welcome <?php echo $fullName; ?></span>
                <a href="view/logout/_logout.php">Log out</a></p>
        </header>
    <sidebar>
        <nav>
            <h4><i class="fa fa-tachometer"></i><span>Dashboard</span></h4>
            <h4><i class="fa fa-clipboard"></i><span>Edit Assessment</span></h4>
            <div class="navgroup nav-editAssessment">

                <?php
                // Loop through courses and display
                foreach ($courses as $course) {
                    echo "<p class='iscourse'><span>" . $course['CourseID'] . " | "
                    . "<span>Semester " . substr($course['Semester'], -1) . " " . substr($course['Semester'], 0, 4) . "</span></p>";

                    $result = get_course_assessments($course['CourseID'], $course['Semester'], $institution);
                    foreach ($result as $names) {
                        echo "<p><i class='fa fa-angle-right'></i> "
                        . "<a href='EditAssessment.php?course=" . $course['CourseID'] . "&sem="
                        . $course['Semester'] . "&assignmentName=" . $names['AssignmentName'] . "'>"
                        . $names['AssignmentName'] . "</a></p>";
                    }
                }
                ?>
            </div>
            <h4><i class="fa fa-file-code-o"></i><span>Review Students</span></h4>
            <div class="navgroup nav-reviewStudents">
                <?php
                foreach ($courses as $course) {
                    //display all courses that the admin is in charge of
                    echo "<p class='iscourse'><span>" . $course['CourseID'] . "   |  "
                    . "Semester " . substr($course['Semester'], -1) . "    " . substr($course['Semester'], 0, 4) . "</span></p>";
                    echo "<p><i class='fa fa-angle-right'></i> "
                    . "<a href='StudentReviews.php?course=" . $course['CourseID'] . "&sem=" .
                    $course['Semester'] . "'>Review</a></p>";
                }
                ?>
            </div>
            <h4><i class="fa fa-wrench"></i><span>Tools</span></h4>
            <div class="navgroup nav-tools">
                <?php
                // Loop through courses and display
                echo "<p><i class='fa fa-angle-right'></i> "
                . "<a href='Assessment.php'>Create Assessment</a></p>";
                echo "<p><i class='fa fa-angle-right'></i> "
                . "<a href='Critiques.php'>Assign Critiques</a></p>";
                ?>
            </div>
        </nav>
        <nav-handle><i class="fa fa-sort"></i></nav-handle>
    </sidebar>    
    <page>