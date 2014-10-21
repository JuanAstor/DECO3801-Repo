<?php 
session_start();
require("lib/mysql.php");
require("lib/queries.php"); // query functions to get database results

if (!isset($_SESSION['user']) && isset($_POST['user'])) {
    $_SESSION['user'] = $_POST['user'];
    
} else { 
    if (isset($_POST['oauth_consumer_key'])) {
        $key = $_POST['oauth_consumer_key'];
        require_once 'lib/authenticate.php';
    }
}

/**
 *  Show the home dashboard if student has authenticated.
 *  Otherwise show the login prompt.
 */
if (isset($_SESSION["user"]) && (get_login_status($_SESSION["user"]) == true)) {
    
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
}
else{
    session_unset();
    session_destroy();
    
    // Show login
    include("view/login/_login.php"); 
}

//Footer
include("view/home/footer.php"); 
?>