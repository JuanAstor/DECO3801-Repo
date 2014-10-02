<?php
//get all courses that a user is enrolled in
function get_users_courses($user) {
    $query = MySQL::getInstance()->query("SELECT CourseID
                                          FROM `courseenrolment` 
                                          WHERE UserID = '" . $user . "'");
    return $query->fetchALL();
}
//get all courses that an admin is in charge of
function get_admins_courses($user) {
    $query = MySQL::getInstance()->query("SELECT * 
					  FROM `course` 
					  WHERE CourseCoordinator = '" . $user . "'");
    return $query->fetchALL();
}
//get all assessments that a 
function get_users_assessments($user) {
    $query = MySQL::getInstance()->query("SELECT * 
                                          FROM `assignment`,`courseenrolment`
                                          WHERE courseenrolment.CourseID = assignment.CourseID AND courseenrolment.UserID='" . $user . "'");
    return $query->fetchAll();
}

// get all when a user's submitted file has been commented on
function get_user_comments($user){
	$query = MySQL::getInstance()->query("SELECT *
										FROM `assignmentfile`, `comment`
										WHERE assignmentfile.FileID = comment.FileID AND assignmentfile.UserID = '".$user."'");
	return $query->fetchALL();
}

// get all data (names, etc) from the 'user' table about a certain user
function get_user_name($user) {
    $query = MySQL::getInstance()->query("SELECT * 
					  					FROM `user` 
					 	 				WHERE UserID = '" . $user . "'");
    return $query->fetchALL();
}

//check if the user that has logged in is an admin
function check_if_admin($user) { //returns 1 if an admin, 0 if student
    $query = MySQL::getInstance()->query("SELECT Privileges 
					  					  FROM `user` 
                                          WHERE UserID = '" . $user . "'");
    $result = $query->fetchALL();
    foreach ($result as $permission) {
        if (strcmp($permission['Privileges'], "Admin") == 0) { //strcmp will return 0 if the strings are equal
            return true; //is an admin
        } else {
            return false; //is a student
        }
    }
}

//if a file has been submitted by a user then it should return a value greater than 0
function check_if_file_exists($user, $assignmentID, $filename) {
    $query = MySQL::getInstance()->query("SELECT count(1)
                                          FROM `assignmentfile`
					  WHERE UserID = '" . $user . "' AND AssignmentID = '" . $assignmentID . "' AND FileName = '" . $filename . "'");
    return $query->fetchALL(); //return the count of the number of files matching the variables
}


//get all info on submitted assignment files
function get_submitted_info($user, $assignmentID){
	$query = MySQL::getInstance()->query("SELECT *
										FROM `assignmentfile`
										WHERE UserID = '".$user."' AND AssignmentID = '".$assignmentID."'");
	return $query->fetchALL(); 
}

//update the 'assignmnetfile' table in the database
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
    $query = MySQL::getInstance()->query("SELECT * 
					  FROM `assignmentfile` 
					  WHERE UserID = '" . $user . "' AND AssignmentID = '" . $assignmentID . "'");
    return $query->fetchALL();
}

//find out if a user exists in the database
function get_login_status($user) {
    $query = MySQL::getInstance()->query("SELECT count(1)
					  FROM `user`
					  WHERE UserID = '" . $user . "'");
    $result = $query->fetchALL();
    $count = $result[0];
    if ($count[0] > 0) {
        return true;
    } else {
        return false;
    }
}

//retrieve the file data that has been submitted by a user
function get_file_data($user, $assignmentID, $filename){
    $query = MySQL::getInstance()->query("SELECT *
                                          FROM `assignmentfile`
                                          WHERE UserID = '".$user."' AND AssignmentID = '".$assignmentID."' AND FileName = '".$filename."'"); 
    return $query->fetchALL();	
}

//select course ID
//function select_courses($id){
	//$query = MySQL::getInstance()->query("SELECT CourseID
	//									FROM `assignment`, `course`
	//									WHERE course.CourseCoordinator = '".$id."' AND assignment.CourseID = course.CourseID");
	//return $query->fetchALL();	
//}

function get_assignID($name, $course){
	$query = MySQL::getInstance()->query("SELECT *
										FROM `assignment`
										WHERE CourseID = '".$course."' AND AssignmentName = '".$name."'");
	return $query->fetchALL();	
}

function get_course_assessments($courseID){
	$query = MySQL::getInstance()->query("SELECT AssignmentName
										FROM `assignment`
										WHERE CourseID = '".$courseID."'");
	return $query->fetchALL();
}

//find out if an assignment name already exists for a course 
function find_assignmentName($courseID, $name, $semester){
	$query = MySQL::getInstance()->query("SELECT count(1)
										FROM `assignment`
										WHERE CourseID = '".$courseID."' AND Semester = '".$semester."' AND AssignmentName = '".$name."'");
	return $query->fetchALL();
}

//insert a new row into the assignment folder
function create_assignment($num, $cID, $sem, $decript, $name, $date, $time){
	return MySQL::getInstance()->query("INSERT INTO `assignment`
	(`AssignmentID`, `CourseID`, `Semester`, `AssignmentDescription`, `AssignmentName`, `DueDate`, `DueTime`) VALUES 								(	'".$num."','".$cID."','".$sem."','".$decript."','".$name."','".$date."','".$time."') ");
}

function check_semester($courseID, $semester){
	$query = MySQL::getInstance()->query("SELECT count(1)
										FROM `course`
										WHERE CourseID = '".$courseID."' AND Semester = '".$semester."'");
	return $query->fetchALL();	
}

//adds a new user if none exists and then updates the details of that user
function update_user($uID, $fName, $sName, $privileges){
	MySQL::getInstance()->query("INSERT INTO `user` (`UserID`) 
								VALUES ('".$uID."')");
	return MySQL::getInstance()->query("UPDATE `user` 
										SET `FName` = '".$fName."', `SName` = '".$sName."',`Privileges`='".$privileges."' 
										WHERE `UserID` = '".$uID."'");
}

//adds an enrolment record for a specified user and course if it doesn't yet exist.
function update_enrolment($uID, $cID, $semesterCode){
	return MySQL::getInstance()->query("INSERT INTO `courseenrolment` (`UserID`, `CourseID, `Semester`) 
										VALUES ('".$uID."','".$cID."','".$semesterCode."')");
}

?>