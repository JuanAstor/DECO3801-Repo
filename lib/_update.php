<?php
session_cache_limiter('none');
session_start();
require("mysql.php");
require("queries.php"); //query functions to get database results
// if update button was pressed and the form was sent with all fields filled in
if (isset($_POST['AName']) && isset($_POST['desc']) && isset($_POST['time']) && isset($_POST['date'])) {
    $assignID = $_POST['AssignID']; //hidden assignmentID passed through the form
    $institution = $_POST['institution'];
    $aName = $_POST['AName'];
	$aName = preg_replace("/[^a-zA-Z0-9]/", "", $aName);
	
    $desc = $_POST['desc'];
	$desc = preg_replace("/[^a-zA-Z0-9]/", " ", $desc);
    $time = $_POST['time'];
    //conver the date into the format required by the database
    $dateFormat = $_POST['date'];

    //hidden variables that will always be sent with the form
    $cID = $_POST['cID']; //courseID 
    $sem = $_POST['sem']; //semester 
    //get the previous assignment information (before it is updated)
    $previous = get_previous_assign_info($assignID);
    //if the time is invalid then set the sesssion message to display and return to the page with the old info
    if (!check_valid_time($time)) {
        $_SESSION['message'] = 'time error';
        header('Location: ../EditAssessment.php?course=' . $previous[0]['CourseID'] . '&sem=' . $previous[0]['Semester'] . '&assignmentName=' . $previous[0]['AssignmentName']);
    } else { //the time is valid so check the date now
        if (!check_valid_date($dateFormat)) {
            //error, invalid date - return with the orignal info
            $_SESSION['message'] = 'date error';
            header('Location: ../EditAssessment.php?course=' . $previous[0]['CourseID'] . '&sem=' . $previous[0]['Semester'] . '&assignmentName=' . $previous[0]['AssignmentName']);
        } else { //the date is valid 
            $newdate = DateTime::createFromFormat('d/m/Y', $dateFormat);
            $date = $newdate->format('Y-m-d');
            //first check that the update assignment name doesn't already exist
            $count = find_assignmentName($cID, $aName, $sem, $institution);

            if (($count > 0) && ($aName != $previous[0]['AssignmentName'])) {
                //assignment name exists and isn't the same as the orignal name, this is an error			
                $_SESSION['message'] = 'name error';
                //return with the original info, nothing is updated				
                header('Location: ../EditAssessment.php?course=' . $previous[0]['CourseID'] . '&sem=' . $previous[0]['Semester'] . '&assignmentName=' . $previous[0]['AssignmentName']);
            } else { //assignment name doesn't exist or is the same name as the origial
                //since this is an edit, we know that the assignment already exists so just update the db
                //find out if it was a success or failure
                $result = update_assign_info($assignID, $aName, $desc, $time, $date);
                if ($result == 'success') {
                    $_SESSION['message'] = 'completed';
                } else {
                    $_SESSION['message'] = 'error';
                }
                //return to the page with the updated information
                header('Location: ../EditAssessment.php?course=' . $cID . '&sem=' . $sem . '&assignmentName=' . $aName);
            }
        }
    }
}


////// if the delete assessment button (in _edit.php) was pressed \\\\\\\\\\\\\\\
else if (isset($_POST['assignID']) && isset($_POST['del'])) {
    //first check that no previous file submissions exist for the to be deleted assignment
    $del = delete_submissions($_POST['assignID']);
    //if an error deleteing submissions then stop and output the error
    if (!$del) {
        echo "Error: Unable to delete assignment files so the Assignment will not be deleted";
    } else { //file submissions have been deleted so..
        //delete the assignment
        $result = delete_assignment($_POST['assignID']);
        //check that the delete was successful and output message
        if ($result == 'success') {
            echo "Assignment successfully deleted";
        } else {
            echo "Error: Assignment unable to be deleted";
        }
    }
}


/////////if the delete button was pressed by a student. called in _fileUpload.php \\\\\\\\\\\\\\\\\
else if (isset($_POST['fileID'])) {
    //delete any potential comments
    $result = delete_student_files($_POST['fileID']);
    if ($result) {
        //file was deleted
        echo "Assignment file successfully deleted";
    } else {
        //error
        echo "Error: file was unable to be deleted";
    }
}


//////////the assign critiques select box changed. called by _critiques.php \\\\\\\\\\\\\\\\\

if (isset($_POST['make']) && isset($_POST['instit'])) {
    $val = explode(",", $_POST['make']);
    $cID = $val[0]; //course ID
    $sem = $val[1]; //semester
	$instit = $_POST['instit']; //institution
    echo"<option value=''>Select...</option>";
    $result = get_course_assessments($cID, $sem, $instit);
    foreach ($result as $name) {
        echo "<option value='" . $name['AssignmentName'] . "'>" . $name['AssignmentName'] . "</option>";
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
    if (preg_match("/(2[0-3]|[01][0-9]):[0-5][0-9]/", $time)) {
        return true;
    } else {
        return false;
    }
}

?>