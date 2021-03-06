<?php 
session_cache_limiter('none');
session_start();
require_once("lib/mysql.php");
require_once("lib/queries.php"); // query functions to get database results

// Redirected from LTI ONLY
if (isset($_POST['oauth_consumer_key'])) {
    $key = $_POST['oauth_consumer_key'];
    require_once 'lib/ltisession.php';
}

/**
 *  Show the home dashboard if student has authenticated.
 *  Otherwise show the login prompt.
 */
if (isset($_SESSION["user"])) {
    
    $user = $_SESSION["user"];
    $institution = get_user_institution($user);
    $fullName = get_user_name($user);
    $courses = get_admins_courses($user);
    
    if(!check_if_admin($user)){

        // Student
        $assessments = get_users_assessments($user);
	$submitted = get_user_comments($user);

        // Show home
        include("view/home/header.php");
        include("view/home/_home.php");
        
    }else{ 
        // Show Admin
        include("view/home/adminheader.php");
        include("view/admin/home/_home.php");
    }
}else{
    if (isset($_SESSION['userEmail'])) {
        if (!get_login_status($_SESSION['userEmail'])) {
            include('view/login/_signup.php');
        }else{
        include('view/login/_login.php');
        }
    }else{
        include('view/login/_login.php');
    }
}

//Footer
include("view/home/footer.php"); 
?>