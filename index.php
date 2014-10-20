<?php 
session_start();
require_once("lib/mysql.php");
require_once("lib/queries.php"); // query functions to get database results

// Redirected from LTI ONLY
if (isset($_POST['oauth_consumer_key'])) {
    $key = $_POST['oauth_consumer_key'];
    include 'lib/authenticate.php';
}

// Code to run after LTI Post Parameters have been placed in session data
if (isset($_SESSION['consumerKey'])) {
    
    if (isset($_SESSION['userEmail'])) {
        
        if (!get_login_status($_SESSION['userEmail'])) {
            
            include('view/login/_signup.php');
            die();
        }
        else {
            
            include('view/login/_login.php');
            die();
        }
    }
}

/**
 *  Show the home dashboard if student has authenticated.
 *  Otherwise show the login prompt.
 */
if (isset($_SESSION["user"])) {
    
    $user = $_SESSION["user"];
    
    if(!check_if_admin($user)){ 

        // Student:
        $courses = get_users_courses($user);
        $assessments = get_users_assessments($user);
        $fullName = get_user_name($user);
	    $submitted = get_user_comments($user);

        // Show home
        include("view/home/header.php");
        include("view/home/_home.php");
        
    }else{ 
        
        // Admin:
        $fullName = get_user_name($user);
        $courses = get_admins_courses($user);
		
        include("view/home/header.php");
        include("view/admin/home/_home.php");
    }
} else {
    include('view/login/_login.php');
}

//Footer
include("view/home/footer.php"); 
?>