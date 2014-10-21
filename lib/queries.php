<?php

//find out if a user exists in the database
function get_login_status($user) {
    $sql = "SELECT * FROM `user` WHERE UserID=?";
    $query = MySQL::getInstance()->prepare($sql);
    $query->execute(array($user));
    $count = $query->rowCount();
    return $count > 0;
}

//get all courses that a user is enrolled in. COURSE ID IS NOT UNIQUE
function get_users_courses($user) {
    $sql = "SELECT CourseID FROM `courseenrolment` WHERE UserID=?";
    $query = MySQL::getInstance()->prepare($sql);
    $query->execute(array($user));
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

//get all courses that an admin is in charge of
function get_admins_courses($user) {
    $sql = "SELECT * FROM `course` WHERE CourseCoordinator=?";
    $query = MySQL::getInstance()->prepare($sql);
    $query->execute(array($user));
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

//get all assessments that a student has
function get_users_assessments($user) {
    $sql = "SELECT * FROM `assignment` as A, `courseenrolment` as B WHERE A.CourseID=B.CourseID AND 
			A.Semester=B.Semester AND A.InstitutionID=B.InstitutionID AND B.UserID=?";
    $query = MySQL::getInstance()->prepare($sql);
    $query->execute(array($user));
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

// get all when a user's submitted file has been commented on
function get_user_comments($user) {
    $sql = "SELECT * FROM `assignmentfile`, `comment` WHERE assignmentfile.FileID=comment.FileID AND assignmentfile.UserID=?";
    $query = MySQL::getInstance()->prepare($sql);
    $query->execute(array($user));
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

// get User name from User
function get_user_name($user) {
    $sql = "SELECT FName, SName FROM `user` WHERE UserID=?";
    $query = MySQL::getInstance()->prepare($sql);
    $query->execute(array($user));
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    return $result[0]['FName'] . ' ' . $result[0]['SName'];
}

// get a User's Institution from User
function get_user_institution($user) {
    $sql = "SELECT InstitutionID FROM `user` WHERE UserID=?";
    $query = MySQL::getInstance()->prepare($sql);
    $query->execute(array($user));
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    return $result[0]['InstitutionID'];
}

//check if the user that has logged in is an admin
function check_if_admin($user) { //returns 1 if an admin, 0 if student
    $sql = "SELECT Privileges FROM `user` WHERE UserID = ?";
    $query = MySQL::getInstance()->prepare($sql);
    $query->execute(array($user));
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $output) {
        if ((strcmp($output['Privileges'], 'Admin') == 0) or ( strcmp($output['Privileges'], 'SuperAdmin') == 0)) {
            return true; //is an admin
        } else {
            return false; //is a student
        }
    }
}

//if a file has been submitted by a user then it should return a value greater than 0
function check_if_file_exists($user, $assignmentID, $filename) {
    $sql = "SELECT * FROM `assignmentfile` WHERE UserID=? AND AssignmentID=? AND FileName=?";
    $query = MySQL::getInstance()->prepare($sql);
    $query->execute(array($user, $assignmentID, $filename));
    $count = $query->rowCount();
    return $count;
}

//get all info on submitted assignment files
function get_submitted_info($user, $assignmentID) {
    $sql = "SELECT * FROM `assignmentfile` WHERE UserID=? AND AssignmentID=?";
    $query = MySQL::getInstance()->prepare($sql);
    $query->execute(array($user, $assignmentID));
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

//update the 'assignmentfile' table in the database
function update_file_contents($user, $assignmentID, $filename, $content, $dateTime) {
    return MySQL::getInstance()->query("UPDATE `assignmentfile`
					SET FileData = '" . $content . "', SubmissionTime = '" . $dateTime . "' 
					WHERE UserID = '" . $user . "' AND AssignmentID = '" . $assignmentID . "' AND FileName = '" . $filename . "'");
}

//insert a new row into the 'assignmentfile' table 
function insert_file_data($user, $assignmentID, $filename, $content, $dateTime) {
    return MySQL::getInstance()->query("INSERT INTO `assignmentfile` (`AssignmentID`, `UserID`, `FileName`, `FileData`, `SubmissionTime`)
                                        VALUES ('" . $assignmentID . "', '" . $user . "', '" . $filename . "', '" . $content . "', '" . $dateTime . "')");
}

//retrieve all the files that a user has submitted for a certain assignment
function get_files_to_comment($user, $assignmentID) {
    $sql = "SELECT * FROM `assignmentfile` WHERE UserID=? AND AssignmentID=?";
    $query = MySQL::getInstance()->prepare($sql);
    $query->execute(array($user, $assignmentID));
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

//if any files have been submitted for a certain assignmentID, delete them
function delete_submissions($assignID) {
    $sql = "SELECT * FROM `assignmentfile` WHERE AssignmentID=?";
    $query1 = MySQL::getInstance()->prepare($sql);
    $query1->execute(array($assignID));
    $count = $query1->rowCount();

    if ($count > 0) {
        //if any assignment files have been submitted 
        //first delete any possible reviews on these files (so no violations in the db)
        $query2 = MySQL::getInstance()->prepare("DELETE FROM `reviewer`
                                                         WHERE FileID IN (SELECT FileID
                                                         FROM `assignmentfile`
                                                         WHERE AssignmentID=?)");
        $query2->execute(array($assignID));

        $query3 = MySQL::getInstance()->prepare("DELETE FROM `assignmentfile`
                                                         WHERE AssignmentID=?");
        return $query3->execute(array($assignID));
    } else {
        //no files were submitted, so return that deleting is possible
        return true;
    }
}

//find out if a user has commented on any files for an assignment
function find_user_comments($userID, $assignID) {
    $sql = "SELECT * FROM `comment` WHERE UserID=? AND FileID IN (SELECT FileID FROM `assignmentfile` WHERE AssignmentID=?)";
    $query = MySQL::getInstance()->prepare($sql);
    $query->execute(array($userID, $assignID));
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

//retrieve the file data that has been submitted by a user NOT A UNIQUE FILE
function get_file_data($user, $assignmentID, $filename) {
    $sql = "SELECT * FROM `assignmentfile` WHERE UserID=? AND AssignmentID=? AND FileName=?";
    $query = MySQL::getInstance()->prepare($sql);
    $query->execute(array($user, $assignmentID, $filename));
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

//from the student reviews pages (admin) will find and return the assignmentID(s) for a course/assignment
function get_assignID($name, $course) {
    $sql = "SELECT * FROM `assignment` WHERE CourseID=? AND AssignmentName=?";
    $query = MySQL::getInstance()->prepare($sql);
    $query->execute(array($course, $name));
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

//for the edit assessment page: get the assignment names available
function get_course_assessments($courseID, $semester, $InstitutionID = 1) {
    $sql = "SELECT AssignmentName FROM `assignment` WHERE CourseID=? AND Semester=? AND InstitutionID=?";
    $query = MySQL::getInstance()->prepare($sql);
    $query->execute(array($courseID, $semester, $InstitutionID));
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

//return all the assignmnet info for a given assignment. NOT A UNIQUE ASSIGNMENT
function get_assign_info($courseID, $semester, $name, $InstitutionID = 1) {
    $sql = "SELECT * FROM `assignment` WHERE CourseID=? AND Semester=? AND AssignmentName=? AND InstitutionID=?";
    $query = MySQL::getInstance()->prepare($sql);
    $query->execute(array($courseID, $semester, $name, $InstitutionID));
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

//edit an assignment: update the assignment info
function update_assign_info($assignID, $name, $description, $time, $date) {
    $sql = "UPDATE `assignment` SET AssignmentDescription=?, AssignmentName=?, DueDate=?, DueTime=? WHERE AssignmentID=?";
    $query = MySQL::getInstance()->prepare($sql);
    $query->execute(array($description, $name, $date, $time, $assignID));
    if (!$query) {
        return 'error';
    } else {
        return 'success';
    }
}

//delete assignment from table
function delete_assignment($assignID) {
    $sql = "DELETE FROM `assignment` WHERE AssignmentID=?";
    $query = MySQL::getInstance()->prepare($sql);
    $query->execute(array($assignID));
    if (!$query) {
        return 'error';
    } else {
        return 'success';
    }
}

//get the info of the assignment before it is updated
function get_previous_assign_info($assignID) {
    $sql = "SELECT * FROM `assignment` WHERE AssignmentID=?";
    $query = MySQL::getInstance()->prepare($sql);
    $query->execute(array($assignID));
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

//find out if an assignment name already exists for a course 
function find_assignmentName($courseID, $name, $semester, $InstitutionID = 1) {
    $sql = "SELECT * FROM `assignment` WHERE CourseID=? AND Semester=? AND AssignmentName=? AND InstitutionID=?";
    $query = MySQL::getInstance()->prepare($sql);
    $query->execute(array($courseID, $semester, $name, $InstitutionID));
    $count = $query->rowCount();
    return $count;
}

//insert a new row into the assignment folder
function create_assignment($cID, $sem, $decript, $name, $date, $time, $InstitutionID = 1) {
    $sql = "INSERT INTO `assignment` (`CourseID`, `Semester`, `InstitutionID`, `AssignmentDescription`, `AssignmentName`, `DueDate`, `DueTime`)
			VALUES (?,?,?,?,?,?,?)";
    $query = MySQL::getInstance()->prepare($sql);
    return $query->execute(array($cID, $sem, $InstitutionID, $decript, $name, $date, $time));
}

//check that the semester value exists for the selected course
function check_semester($courseID, $semester, $InstitutionID = 1) {
    $sql = "SELECT * FROM `course` WHERE CourseID=? AND Semester=? AND InstitutionID=?";
    $query = MySQL::getInstance()->prepare($sql);
    $query->execute(array($courseID, $semester, $InstitutionID));
    $count = $query->rowCount();
    return $count;
    /* $query = MySQL::getInstance()->query("SELECT count(1)
      FROM `course`
      WHERE CourseID = '".$courseID."' AND Semester = '".$semester."'");
      return $query->fetchALL(); */
}

//deletes any files selected by a user (and comments attached to the file)
function delete_student_files($fileID) {
    $sql = "DELETE FROM `comment` WHERE FileID=?";
    $query = MySQL::getInstance()->prepare($sql);
    $query->execute(array($fileID));

    $sql2 = "DELETE FROM `assignmentfile` WHERE FileID=?";
    $query2 = MySQL::getInstance()->prepare($sql2);
    return $query2->execute(array($fileID));
}

//adds a new user if none exists and then updates the details of that user
function update_user($uID, $fName, $sName, $privileges, $pass, $institutionID) {
    $sql = "INSERT INTO `user` (`UserID`, `InstitutionID`) VALUES (?,?)";
    $query = MySQL::getInstance()->prepare($sql);
    $query->execute(array($uID, $institutionID));

    $sql1 = "UPDATE `user` SET FName=?, SName=?, Privileges=?, Password=? WHERE UserID=?";
    $query1 = MySQL::getInstance()->prepare($sql1);
    return $query1->execute(array($fName, $sName, $privileges, $pass, $uID));
}

//adds an enrolment record for a specified user and course if it doesn't yet exist.
function update_enrolment($user, $course, $institution) {
    $semester = date("Y") . ((date("n") > 6) ? 2 : 1);
    $sql = "INSERT INTO `courseenrolment` (`UserID`, `CourseID`, `Semester`, `InstitutionID`) VALUES (?,?,?,?)";
    $query = MySQL::getInstance()->prepare($sql);
    $query->execute(array($user, $course, $semester,  $institution));
    
    $sql1 = "UPDATE `courseenrolment` SET CourseID=?, Semester=? WHERE UserID=?";
    $query1 = MySQL::getInstance()->prepare($sql1);
    return $query1->execute(array($course, $semester, $user));
}

// Creates course
function create_course($user, $course, $institution) {
    $semester = date("Y") . ((date("n") > 6) ? 2 : 1);
    $sql = "INSERT INTO `course` (`CourseCoordinator`, `CourseID`, `InstitutionID`, `Semester`) VALUES (?,?,?,?)";
    $query = MySQL::getInstance()->prepare($sql);
    return $query->execute(array($user, $course, $institution, $semester));
}

/* Check if consumerkey exists
 *
 * precondition: consumerkey is unique && * consumerkeys != ''
 */

function check_if_consumer_key($key) {
    $sql = "SELECT consumerKey FROM `institution` WHERE consumerKey=?";
    $query = MySQL::getInstance()->prepare($sql);
    $query->execute(array($key));
    $count = $query->rowCount();
    return $count > 0;
}

// Return true if AdminUser in institution is null
function check_if_admin_assigned($key) {
    $sql = "SELECT AdminUser FROM `institution` WHERE consumerKey=?";
    $query = MySQL::getInstance()->prepare($sql);
    $query->execute(array($key));
    $count = $query->fetchAll(PDO::FETCH_ASSOC);
    return !empty($count[0]['AdminUser']); // returns true if admin assigned
}

// Update AdminUser in institution with UserID on first run
function insert_adminuser($user, $institution) {
    $sql = "UPDATE `institution` SET AdminUser=? WHERE InstitutionID=?";
    $query = MySQL::getInstance()->prepare($sql);
    $query->execute(array($user, $institution));
    return;
}

// Using the consumerkey, return the institution row
function get_institution($key) {
    $sql = "SELECT * FROM `institution` WHERE ConsumerKey=?";
    $query = MySQL::getInstance()->prepare($sql);
    $query->execute(array($key));
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

// get password encrypted hash
function get_password_hash($user) {
    $sql = "SELECT Password FROM `user` WHERE UserID=?";
    $query = MySQL::getInstance()->prepare($sql);
    $query->execute(array($user));
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

// Searches list of courses from course using institution ID
function check_if_course_exists($course, $institution) {
    $sql = "SELECT CourseID FROM `course` WHERE CourseID=? AND InstitutionID=?";
    $query = MySQL::getInstance()->prepare($sql);
    $query->execute(array($course, $institution));
    $count = $query->rowCount();
    return $count > 0;
}

// Checks if a student is enrolled
function check_if_student_enrolled($user, $course) {
    $sql = "SELECT CourseID FROM `courseenrolment` WHERE UserID=? AND CourseID=?";
    $query = MySQL::getInstance()->prepare($sql);
    $query->execute(array($user, $course));
    $count = $query->rowCount();
    return $count > 0;
}

function get_users_to_critique($user){
	$sql = "SELECT * FROM `reviewer` WHERE ReviewerID=?";
	$query = MySQL::getInstance()->prepare($sql);
	$query->execute(array($user));
	return $query->fetchAll(PDO::FETCH_ASSOC);
}
?>
