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
    return $query->fetchAll();	
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
?>