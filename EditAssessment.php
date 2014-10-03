<?php
session_start();
require("lib/mysql.php");
require("lib/queries.php"); //query functions to get database results

if (!isset($_SESSION['user']) && isset($_POST['user'])) {
    $_SESSION['user'] = $_POST['user'];
}

/**
 *  Show the Assignment page if student has authenticated.
 *  Otherwise show the login prompt.
 */
if (isset($_SESSION["user"]) && (get_login_status($_SESSION["user"]) == true)) {
    
    $user = $_SESSION["user"];
    
    if(!check_if_admin($user)){ 

        // Student:
		header('Location: /index.php');
        
    }else{ 
        if(isset($_GET['course']) && isset($_GET['sem'])){
			// Admin:
			$fullName = get_user_name($user);
			$courses = get_admins_courses($user);
			
			$courseID = $_GET['course'];
			$semester = $_GET['sem'];
			$name = $_GET['name'];
			
			include("view/home/header.php");
			include("view/admin/editAssessments/_edit.php");
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