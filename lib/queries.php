<?php

/**
 * Returns the assignments assigned to the student for reviewing.
 * Accesses table Reviewer and selects all FileID's where the
 * UserID equals to the student ID.
 *
 * @param 	$student : UserID of student to review
 * @return 	List<String> : List of FileID's to mark.
 */
function get_assigments_to_mark( $student ) {
	$query = MySQL::getInstance()->query("SELECT * FROM `reviewer` WHERE `UserID`='$student'");
	return $query->fetchALL();
}

?>