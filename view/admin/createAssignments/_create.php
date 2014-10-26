<?php
$output = NULL; //what is to be displayed to the admin on form submit
//if all the form values have been set, assign variables, error check and then send to database
if (isset($_POST['AName']) && isset($_POST['desc']) && isset($_POST['time']) && isset($_POST['date'])) {
    
    if(empty($_POST['cID'])) {
        $output = "Error: Please select a Course ID";
    }else{
        $val = explode(",", $_POST['cID']);
        $courseID = $val[0]; //course ID
        $fullsem = $val[1]; //format = YYYYS eg 20141, semester = 1 of year 2014
        $sem = substr($fullsem, -1); //get the semester value
        $name = $_POST['AName'];
		//preg_replace $name 
		$name = preg_replace("/[^a-zA-Z0-9 -]/", "", $name);
		$description = $_POST['desc'];
		$description = preg_replace("/[^a-zA-Z0-9 -]/", "", $description);
        $time = $_POST['time'];
        $dateFormat = $_POST['date'];

        //if the time is valid
        if (check_valid_time($time)) {
            //check that the date is valid			
            if (!check_valid_date($dateFormat)) {
                //Please make sure that every field has been completed
                $output = "Error: The entered date was invalid. The format is (dd/mm/yyyy)";
            } else {
                //convert the date into the format stored in the database
                $newdate = DateTime::createFromFormat('d/m/Y', $dateFormat);
                $finalDate = $newdate->format('Y-m-d');
                //check that the assigment name doesn't already exist for that courseID
                $semester = date('Y') . $sem;
                $count = find_assignmentName($courseID, $name, $semester, $institution);

                if ($count > 0) {
                    //then an assigment name already exists for this courseID and semester
                    $output = "Error: The assignment name entered already exists for this course and semester";
                } else {
                    $semCount = check_semester($courseID, $semester, $institution); //check that the semester value is correct
                    if ($semCount > 0) {
                        //the assignment name for the courseID and semester is unique, so continue.
                        //add the values to the database return a success message
                        create_assignment($courseID, $semester, $description, $name, $finalDate, $time, $institution);
                        $output = "The Assignment has successfully been created";
                    } else {
                        $output = "Error: Semester value doesn't match the selected course";
                    }
                }
            }
        } else {
            //the time isn't valid
            $output = "Error: The time entered was not valid. The correct format is (HH:mm)";
        }
    }
}


//check the validity of the entered date
function check_valid_date($date) {
    if (substr_count($date, "/") == 2) {
        $fullDate = explode("/", $date);
        $day = (int) $fullDate[0];
        $month = (int) $fullDate[1];
        $year = (int) $fullDate[2];

        if (checkdate($month, $day, $year)) {
            return true;
        }
    } else {
        return false;
    }
    return false;
}

//check that the entered time is valid 
function check_valid_time($time) {
    if (substr_count($time, ":") == 2) {
        if (preg_match("/(2[0-3]|[01][0-9]):[0-5][0-9]:[0-5][0-9]/", $time)) {
            return true;
        } else {
            return false;
        }
    } else if (substr_count($time, ":") == 1) {
        if (preg_match("/(2[0-3]|[01][0-9]):[0-5][0-9]/", $time)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}
?>
<html>
    <head>
        <title>Code Review</title>
        <!-- CSS/LESS -->
        <link rel="stylesheet/less" href="css/main.less">
        <!--<link rel="stylesheet" href="css/sidebarChange.css">
        <!-- JS -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
                <!--<script src="../js/moment.js"></script> -->

    </head>
    <body>
        <div class="formtitle"><h3>Create Assessment</h3></div>
    <widget-container>
        <div class="formcenter">
            <form action="Assessment.php" method="post">
                <div class="form-group">
                    <label for="cID">Course ID</label>
                    <?php
//display all courseID's that an admin can create an assignment in
                    echo "<select name='cID' id='cID'>";
                    echo "<option disabled selected>Select...</option>";
                    foreach ($courses as $course) {
                        //check that the course to be displayed doesn't already exist
                        $cID = strtoupper($course['CourseID']);
                        $full = $course['Semester'];
                        $sem = substr($course['Semester'], -1);
                        $year = substr($course['Semester'], 0, 4);

                        echo "<option value=" . $course['CourseID'] . "," . $course['Semester'] . ">" . $cID . " Semester " . $sem . " " . $year . "</option>";
                    }
                    echo "</select>";
                    ?>
                </div>

                <div class="form-group">
                    <label for="aName">Assignment Name</label>
                    <input class="form-control" id="aName" name="AName" placeholder="Enter Assignment name here" required>
                </div>
                <div class="form-group">
                    <label for="description">Assignment Description</label>
                    <textarea class="form-control" name="desc"id="description"rows="2" required></textarea>
                </div>

                <div class="form-group">
                    <label for="time">Time Due</label>
                    <input class="form-control" id="time" name="time" placeholder="Time Format: 24hour - HH:MM" required>
                </div>



                <div class="form-group">
                    <label for="date">Date Due</label>
                    <input class="form-control" id="date" name="date" placeholder="Format: DD/MM/YYYY" required>
                </div>
                </br>

                <button type="submit" class="btn btn-primary">Submit</button></br></br>



                <?php
                //display the error or success messages after form submit
                if (!empty($output)) {
                    echo "<div class='alert alert-warning alert-dismissable'>"
                    . " <a href='#' class='close' data-dismiss='alert' aria-hidden='true'>&times;</a>"
                    . $output
                    . "</div>";
                }
                ?>


            </form>
        </div>
    </widget-container>

</body>
</html>
<script>
    $('navgroup:not(.nav-tools)').hide();
</script>