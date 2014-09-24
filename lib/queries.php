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
    $query = MySQL::getInstance()->query("SELECT CourseID 
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

function get_user_comments($user){
	$query = MySQL::getInstance()->query("SELECT *
										FROM `assignmentfile`, `comment`
										WHERE assignmentfile.FileID = comment.FileID AND assignmentfile.UserID = '".$user."'");
	return $query->fetchALL();
}

//get all file ids that the user has submitted
function get_users_files($user) {
	$query = MySQL::getInstance()->query("SELECT *
										FROM `assignmentfile`
										WHERE UserID = '". $user ."'");
	return $query->fetchALL();
}
//get the users who commented on your files
function get_number_of_feedback($fileID) {
	$query = MySQL::getInstance()->query("SELECT count(1)
										FROM `comment`
										WHERE FileID = '". $fileID ."'");
	return $query->fetchALL();
}

function get_user_name($user) {
    $query = MySQL::getInstance()->query("SELECT * 
					  					FROM `user` 
					 	 				WHERE UserID = '" . $user . "'");
    return $query->fetchALL();
}

function check_if_admin($user) { //returns 1 if an admin, 0 if student
    $query = MySQL::getInstance()->query("SELECT Priveleges 
					  					  FROM `user` 
                                          WHERE UserID = '" . $user . "'");
    $result = $query->fetchALL();
    foreach ($result as $permission) {
        if (strcmp($permission['Priveleges'], "Admin") == 0) { //strcmp will return 0 if the strings are equal
            return true; //is an admin
        } else {
            return false; //is a student
        }
    }
}

function check_if_file_exists($user, $assignmentID, $filename) {
    $query = MySQL::getInstance()->query("SELECT count(1)
                                          FROM `assignmentfile`
					  WHERE UserID = '" . $user . "' AND AssignmentID = '" . $assignmentID . "' AND FileName = '" . $filename . "'");
    return $query->fetchALL(); //return the count of the number of files matching the variables
}

function update_file_contents($user, $assignmentID, $filename, $content, $dateTime) {
    return MySQL::getInstance()->query("UPDATE `assignmentfile`
					SET FileData = '" . $content . "', SubmissionTime = '" . $dateTime . "' 
					WHERE UserID = '" . $user . "' AND AssignmentID = '" . $assignmentID . "' AND FileName = '" . $filename . "'");
}

function insert_file_data($user, $assignmentID, $filename, $content, $dateTime) {
    return MySQL::getInstance()->query("INSERT INTO `assignmentfile` (`AssignmentID`, `UserID`, `FileName`, `FileData`, `SubmissionTime`)
                                        VALUES ('" . $assignmentID . "', '" . $user . "', '" . $filename . "', '" . $content . "', '" . $dateTime . "')");
}

function get_files_to_comment($user, $assignmentID) {
    $query = MySQL::getInstance()->query("SELECT * 
					  FROM `assignmentfile` 
					  WHERE UserID = '" . $user . "' AND AssignmentID = '" . $assignmentID . "'");
    return $query->fetchALL();
}

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

function get_file_data($user, $assignmentID, $filename){
    $query = MySQL::getInstance()->query("SELECT *
                                          FROM `assignmentfile`
                                          WHERE UserID = '".$user."' AND AssignmentID = '".$assignmentID."' AND FileName = '".$filename."'"); 
    return $query->fetchALL();	
}

?>