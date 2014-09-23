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
        <p><span class="welcome"><i class="fa fa-user"></i> Welcome <?php echo $user;?></span>
        <a href="view/logout/_logout.php">Log out</a></p>
    </header>
    <sidebar>
        <nav>
            <h4><i class="fa fa-pencil"></i><span>Assessment</span></h4>
            <navgroup>
            <?php // Loop through courses and display
                foreach ($courses as $course) {
                    echo "<div><p><i class='fa fa-angle-right'></i> "
                       . $course['CourseID']
                       . "</p></div>";
                }
            ?>
            </navgroup>
            <h4><i class="fa fa-comments"></i><span>Review</span></h4>
            <navgroup>
            <?php // Loop through courses and display
                foreach ($courses as $course) {
                    echo "<div><p><i class='fa fa-angle-right'></i> "
                       . $course['CourseID']
                       . "</p></div>";
                }
            ?>
            </navgroup>
            <h4><i class="fa fa-bullhorn"></i><span>Feedback</span></h4>
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
