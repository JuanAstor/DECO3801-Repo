<?php
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
function get_user_comments($user){
	$sql = "SELECT * FROM `assignmentfile`, `comment` WHERE assignmentfile.FileID=comment.FileID AND assignmentfile.UserID=?";
	$query = MySQL::getInstance()->prepare($sql);
	$query->execute(array($user));
	return $query->fetchAll(PDO::FETCH_ASSOC);
}

// get all data (names, etc) from the 'user' table about a certain user
function get_user_name($user) {
	$sql = "SELECT * FROM `user` WHERE UserID=?";
	$query = MySQL::getInstance()->prepare($sql);
	$query->execute(array($user));
	return $query->fetchAll(PDO::FETCH_ASSOC);
    /*$query = MySQL::getInstance()->query("SELECT * 
                                          FROM `user` 
                                          WHERE UserID = '" . $user . "'");
    return $query->fetchALL();*/
}

//check if the user that has logged in is an admin
function check_if_admin($user) { //returns 1 if an admin, 0 if student
	$sql = "SELECT Privileges FROM `user` WHERE UserID = ?";
	$query = MySQL::getInstance()->prepare($sql);
	$query->execute(array($user));
	$result = $query->fetchAll(PDO::FETCH_ASSOC);
	foreach($result as $output){
		if((strcmp($output['Privileges'], 'Admin')==0) or (strcmp($output['Privileges'], 'SuperAdmin')==0)){ 
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
function get_submitted_info($user, $assignmentID){
	$sql = "SELECT * FROM `assignmentfile` WHERE UserID=? AND AssignmentID=?";
	$query = MySQL::getInstance()->prepare($sql);
	$query->execute(array($user, $assignmentID));
	return $query->fetchAll(PDO::FETCH_ASSOC);
} 

//get all info on submitted assignment files, given a fileID
function get_file_info($fileID){
	$sql = "SELECT * FROM `assignmentfile` WHERE FileID=?";
	$query = MySQL::getInstance()->prepare($sql);
	$query->execute(array($fileID));
	return $query->fetchALL(PDO::FETCH_ASSOC);	
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

//find out if a user exists in the database
function get_login_status($user) {
	$sql = "SELECT * FROM `user` WHERE UserID=?";
	$query = MySQL::getInstance()->prepare($sql);
	$query->execute(array($user));
	$count = $query->rowCount();
	if($count > 0){
		return true; //user exists
	} else {
		return false; //user doesn't
	}
}

//if any files have been submitted for a certain assignmentID, delete them
function delete_submissions($assignID){
	$sql = "SELECT * FROM `assignmentfile` WHERE AssignmentID=?";
	$query1 = MySQL::getInstance()->prepare($sql);
	$query1->execute(array($assignID));
	$count = $query1->rowCount();
	
	if($count > 0){ 
		//if any assignment files have been submitted 
		//first delete any possible reviews on these files (so no violations in the db)
		$query2 = MySQL::getInstance()->prepare("DELETE FROM `reviewer`
                                                         WHERE AssignmentID IN (SELECT AssignmentID
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
function find_user_comments($userID, $assignID){
	$sql = "SELECT * FROM `comment` WHERE UserID=? AND FileID IN (SELECT FileID FROM `assignmentfile` WHERE AssignmentID=?)";
	$query = MySQL::getInstance()->prepare($sql);
	$query->execute(array($userID, $assignID));
	return $query->fetchAll(PDO::FETCH_ASSOC);	
}

//retrieve the file data that has been submitted by a user NOT A UNIQUE FILE
function get_file_data($user, $assignmentID, $filename){
	$sql = "SELECT * FROM `assignmentfile` WHERE UserID=? AND AssignmentID=? AND FileName=?";
	$query = MySQL::getInstance()->prepare($sql);
	$query->execute(array($user, $assignmentID, $filename));
	return $query->fetchAll(PDO::FETCH_ASSOC);
}

//from the student reviews pages (admin) will find and return the assignmentID(s) for a course/assignment
function get_assignID($name, $course){
	$sql = "SELECT * FROM `assignment` WHERE CourseID=? AND AssignmentName=?";
	$query = MySQL::getInstance()->prepare($sql);
	$query->execute(array($course, $name));
	return $query->fetchAll(PDO::FETCH_ASSOC);
}

//for the edit assessment page: get the assignment names available
function get_course_assessments($courseID, $semester, $InstitutionID = 1){
	$sql = "SELECT AssignmentName FROM `assignment` WHERE CourseID=? AND Semester=? AND InstitutionID=?";
	$query = MySQL::getInstance()->prepare($sql);
	$query->execute(array($courseID, $semester, $InstitutionID));
	return $query->fetchAll(PDO::FETCH_ASSOC);
}

//return all the assignmnet info for a given assignment. NOT A UNIQUE ASSIGNMENT
function get_assign_info($courseID, $semester, $name, $InstitutionID = 1){
	$sql = "SELECT * FROM `assignment` WHERE CourseID=? AND Semester=? AND AssignmentName=? AND InstitutionID=?";
	$query = MySQL::getInstance()->prepare($sql);
	$query->execute(array($courseID, $semester, $name, $InstitutionID));
	return $query->fetchAll(PDO::FETCH_ASSOC); 
}

//edit an assignment: update the assignment info
function update_assign_info($assignID, $name, $description, $time, $date){
	$sql = "UPDATE `assignment` SET AssignmentDescription=?, AssignmentName=?, DueDate=?, DueTime=? WHERE AssignmentID=?";
	$query = MySQL::getInstance()->prepare($sql);
	$query->execute(array($description, $name, $date, $time, $assignID));
	if(!$query){
		return 'error';	
	}else {
		return 'success';
	}
}

//delete assignment from table
function delete_assignment($assignID){
	$sql = "DELETE FROM `assignment` WHERE AssignmentID=?";
	$query = MySQL::getInstance()->prepare($sql);
	$query->execute(array($assignID)); 
	if(!$query){
		return 'error';	
	}else{
		return 'success';		
	}
}

//get the info of the assignment before it is updated
function get_previous_assign_info($assignID){
	$sql = "SELECT * FROM `assignment` WHERE AssignmentID=?";
	$query = MySQL::getInstance()->prepare($sql);
	$query->execute(array($assignID)); 
	return $query->fetchAll(PDO::FETCH_ASSOC);	
}

//find out if an assignment name already exists for a course 
function find_assignmentName($courseID, $name, $semester, $InstitutionID = 1){
	$sql = "SELECT * FROM `assignment` WHERE CourseID=? AND Semester=? AND AssignmentName=? AND InstitutionID=?";
	$query = MySQL::getInstance()->prepare($sql);
	$query->execute(array($courseID, $semester, $name, $InstitutionID));
	$count = $query->rowCount();
	return $count;
}

//insert a new row into the assignment folder
function create_assignment($cID, $sem, $decript, $name, $date, $time, $InstitutionID = 1){
	$sql = "INSERT INTO `assignment` (`CourseID`, `Semester`, `InstitutionID`, `AssignmentDescription`, `AssignmentName`, `DueDate`, `DueTime`)
			VALUES (?,?,?,?,?,?,?)";
	$query = MySQL::getInstance()->prepare($sql);
	return $query->execute(array($cID, $sem, $InstitutionID, $decript, $name, $date, $time));
}

//check that the semester value exists for the selected course
function check_semester($courseID, $semester, $InstitutionID = 1){
	$sql = "SELECT * FROM `course` WHERE CourseID=? AND Semester=? AND InstitutionID=?";
	$query = MySQL::getInstance()->prepare($sql);
	$query->execute(array($courseID, $semester, $InstitutionID));
	$count = $query->rowCount();
	return $count;
	/*$query = MySQL::getInstance()->query("SELECT count(1)
                                                FROM `course`
                                                WHERE CourseID = '".$courseID."' AND Semester = '".$semester."'");
	return $query->fetchALL();*/
}

//deletes any files selected by a user (and comments attached to the file)
function delete_student_files($fileID){
	$sql = "DELETE FROM `comment` WHERE FileID=?";
	$query = MySQL::getInstance()->prepare($sql);
	$query->execute(array($fileID));
	
	$sql2 = "DELETE FROM `assignmentfile` WHERE FileID=?";
	$query2 = MySQL::getInstance()->prepare($sql2);
	return $query2->execute(array($fileID));	
}


//adds a new user if none exists and then updates the details of that user
function update_user($uID, $fName, $sName, $privileges, $InstitutionID = 1){
	$sql = "INSERT INTO `user` (`UserID`) VALUES (?)";
	$query = MySQL::getInstance()->prepare($sql); 
	$query->execute(array($uID));
	
	$sql2 = "UPDATE `user` SET `FName=?, SName=?, Privileges=?, InstitutionID=? WHERE UserID=?";
	$query1 = MySQL::getInstance()->prepare($sql2);
	return $query1->execute(array($fName, $sName, $privileges, $InstitutionID, $uID));
	
	//MySQL::getInstance()->query("INSERT INTO `user` (`UserID`) 
	//							VALUES ('".$uID."')");
	//return MySQL::getInstance()->query("UPDATE `user` 
	//									SET `FName` = '".$fName."', `SName` = '".$sName."',`Privileges`='".$privileges."' 
	//									WHERE `UserID` = '".$uID."'");
}

//adds an enrolment record for a specified user and course if it doesn't yet exist.
function update_enrolment($uID, $cID, $semesterCode, $InstitutionID = 1){
	$sql = "INSERT INTO `courseenrolment` (`UserID`, `CourseID`, `Semester`, `InstitutionID`) VALUES (?,?,?,?)";
	$query = MySQL::getInstance()->prepare($sql);
	return $query->execute(array($uID, $cID, $semesterCode, $InstitutionID));
	
	//return MySQL::getInstance()->query("INSERT INTO `courseenrolment` (`UserID`, `CourseID, `Semester`) 
	//									VALUES ('".$uID."','".$cID."','".$semesterCode."')");
}

/* Check if consumerkey exists
 *
 * precondition: consumerkey is unique && * admin.consumerkeys != ''
 */
function check_if_consumer_key($key) {
    $sql = "SELECT ConsumerKey FROM `institution` WHERE ConsumerKey=?";
    $query = MySQL::getInstance()->prepare($sql);
    $query->execute(array($key));
    $count = $query->rowCount();
    return $count ? 1 : 0;
}

// Using the consumerkey, return the consumer secret
function get_consumer_secret($key) {
    $sql = "SELECT Secret FROM `institution` WHERE ConsumerKey=?";
    $query = MySQL::getInstance()->prepare($sql);
    return $query->execute(array($key));
}

/* User password has authentication queries.
 * 
 */
function store_password($user, $pass) {
    
}

function verify_password($user, $pass) {
    
}

function get_users_to_critique($user){
	$sql = "SELECT * FROM `reviewer` WHERE ReviewerID=?";
	$query = MySQL::getInstance()->prepare($sql);
	$query->execute(array($user));
	return $query->fetchAll(PDO::FETCH_ASSOC);
}

function get_single_assignment_critiques($user, $assignment){
	$sql = "SELECT * FROM `reviewer` WHERE ReviewerID=? AND AssignmentID=?";
	$query = MySQL::getInstance()->prepare($sql);
	$query->execute(array($user, $assignment));
	return $query->fetchAll(PDO::FETCH_ASSOC);	
}
?>
