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
        $courses = get_users_courses($user);
        $assessments = get_users_assessments($user);
        $fullName = get_user_name($user);

        // Show home
        include("view/home/header.php");
        include("view/assessment/_assessment.php");
        
    }else{ 
        
        // Admin:
        $fullName = get_user_name($user);
        $courses = get_admins_courses($user);	
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