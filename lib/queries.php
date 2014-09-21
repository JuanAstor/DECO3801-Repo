<?php

/**
 * Returns the assignments assigned to the student as string data
 * for reviewing. Using student ID, uses FileID's assigned to find 
 * FileData in table Assignmentfile and converts FileData blobs to
 * string. Returns as List of all FileData blob text as string.
 *
 * @param	$student : UserID of student to review
 * @return	List<String> : List of FileData as string to mark.
 * @author	Lachlan du Preez
 */
function get_assigment_data_to_mark( $student ) {
    $query = MySQL::getInstance()->query("SELECT CONVERT(`FileData` using utf8) "
                                        ."FROM `reviewer`,`assignmentfile` "
                                        ."WHERE reviewer.FileID = assignmentfile.FileID AND reviewer.UserID='.$student.'");
    return $query->fetchALL();
}

function get_users_courses( $student ) {
    $query = MySQL::getInstance()->query("SELECT CourseID "
                                        ."FROM `courseenrolment` "
                                        ."WHERE UserID = '".$student."'");
    return $query->fetchALL();	
}

function get_admin_courses( $id ) {
	$query = MySQL::getInstance()->query("SELECT CourseID 
										FROM `course` 
										WHERE CourseCoordinator = '".$id."'");
	return $query->fetchALL();
}

function get_users_assessments( $student ) {
    $query = MySQL::getInstance()->query("SELECT * "
                                        ."FROM `assignment`,`courseenrolment` "
                                        ."WHERE courseenrolment.CourseID = assignment.CourseID AND courseenrolment.UserID='".$student."'");
    return $query->fetchAll();
}

function get_user_name( $student ) {
	$query = MySQL::getInstance()->query("SELECT * 
										FROM `user` 
										WHERE UserID = '".$student."'") ;
	return $query->fetchALL();
}

function check_if_admin( $id ) { //returns 1 if an admin, 0 if student
	$query = MySQL::getInstance()->query("SELECT Priveleges 
										FROM `user` 
										WHERE UserID = '".$id."'");
	$result = $query->fetchALL();	
	foreach ($result as $permission) {
		if(strcmp($permission['Priveleges'], "Admin") == 0){ //strcmp will return 0 if the strings are equal
			return 1; //is an admin
		} else {
			return 0; //is a student
		}
	}
} 

function check_if_file_exists($userID, $assignmentID, $filename){
	$query = MySQL::getInstance()->query("SELECT count(1)
										FROM `assignmentfile`
										WHERE UserID = '".$userID."' AND AssignmentID = '".$assignmentID."' AND FileName = '".$filename."'");
	return $query->fetchALL(); //return the count of the number of files matching the variables
}

function update_file_contents($userID, $assignmentID, $filename, $content, $dateTime){
	$query = MySQL::getInstance()->query("UPDATE `assignmentfile`
										SET FileData =	'".$content."', SubmissionTime = '".$dateTime."' 
										WHERE UserID = '".$userID."' AND AssignmentID = '".$assignmentID."' AND FileName = '".$filename."'");
}

function insert_file_data($userID, $assignmentID, $filename, $content, $dateTime){
	$query = MySQL::getInstance()->query("INSERT INTO `assignmentfile`
										(`AssignmentID`, `UserID`, `FileName`, `FileData`, `SubmissionTime`) VALUES
										('".$assignmentID."', '".$userID."', '".$filename."', '".$content."', '".$dateTime."')");
}

function get_files_to_comment( $userID, $assignmentID ){
	$query = MySQL::getInstance()->query("SELECT * 
										FROM `assignmentfile` 
										WHERE UserID = '".$userID."' AND AssignmentID = '".$assignmentID."'");
	return $query->fetchALL();
}
?>