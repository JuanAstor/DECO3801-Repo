<?php
session_start();
require("lib/mysql.php");
require("lib/queries.php"); //query functions to get database results

if (!isset($_SESSION['user']) && isset($_POST['user'])) {
    $_SESSION['user'] = $_POST['user'];
}

/**
 *  Show the edit assessment page to an admin, return to the homepage if a student somehow accesses this page
 * 
 */
if (isset($_SESSION["user"]) && (get_login_status($_SESSION["user"]) == true)) {
    
    $user = $_SESSION["user"];
    
    if(!check_if_admin($user)){ 

        // Student:
		//students shouldn't have access to this page, is they somehow do then return them to the homepage
		header('Location: index.php');
        
    }else{ 
		// Admin:
		$fullName = get_user_name($user);
		$courses = get_admins_courses($user);
		$count = 0; 
		//check that the entered href info is correct and that the admin is allowed to be
		//accessing this assignment info
        if(isset($_GET['course']) && isset($_GET['sem']) && isset($_GET['assignmentName'])){	
			foreach($courses as $list){
				if($_GET['course'] == $list['CourseID'] && $_GET['sem'] == $list['Semester']){
					//check if the name relates to these in the database
					$result = get_course_assessments($_GET['course'], $_GET['sem']);
					foreach($result as $assignName){
						if($_GET['assignmentName'] == $assignName['AssignmentName']){
							$count = 1;	
						}
					}
				}
			}
			if($count == 1){ //if they can access this info then display it to them
				$courseID = $_GET['course'];
				$semester = $_GET['sem'];
				$assignmentName = $_GET['assignmentName'];
				
				include("view/admin/home/header.php");
				include("view/admin/editAssessments/_edit.php"); 
				
			} else { //they are not allowed to access this info so return to the homepage
				header('Location: index.php');	
			}
		}
    }
}
else{
    $_SESSION = array();
    session_destroy();
    
    // Show login
    include("view/login/_login.php"); 
}

//Footer
include("view/home/footer.php"); 
?>