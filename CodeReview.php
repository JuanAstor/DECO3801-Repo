<?php

session_start();
require("lib/mysql.php");
require("lib/queries.php"); //query functions to get database results

if (!isset($_SESSION['user']) && isset($_POST['user'])) {
    $_SESSION['user'] = $_POST['user'];
}

if (isset($_SESSION["user"]) && (get_login_status($_SESSION["user"]) == true)) {

    $user = $_SESSION["user"];
    $institution = get_user_institution($user);
    $fullName = get_user_name($user);
    $courses = get_admins_courses($user);

    if (!check_if_admin($user)) {

        // Student: allow students to view their received feedback
        $assessments = get_users_assessments($user);
        $submitted = get_user_comments($user);

        // Show home
        include("view/home/header.php");
        include("view/codereview/_view.php");
    } else {
        //Admin:
        header('Location: index.php');
    }
} else {
    //if not a student or admin then display the login field
    $_SESSION = array();
    session_destroy();

    // Show login
    include("view/login/_login.php");
}

//Footer
include("view/home/footer.php");
?>
