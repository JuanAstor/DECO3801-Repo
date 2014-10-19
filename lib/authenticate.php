<?php

//Entered if oauth is detected

// Load up the Basic LTI Support code
require_once 'blti.php';

// Error report
$loginMessage = 'Institution not found';

// Check for existing institution
if (check_if_consumer_key($key)) {

    // Initialize
    $context = new BLTI(get_consumer_secret($key), false, false);

    // Gather LTI Post from linked users
    if ( $context->valid ) {
        $id = exlpode(":", $context->getUserKey());
        
        $_SESSION['isInstructor']= $context->isInstructor();
        $_SESSION['fullName']    = $context->getName();
        $_SESSION['userID']      = $id[1];
        $_SESSION['courseName']  = $context->courseName();
        $_SESSION['consumerKey'] = $context->consumerKey();
        
        include("view/login/_signup.php");
    }
}
else{
    // Admin Sign up page
}

if (isset($_POST['password'])) {
    
    $user = $_POST['userid'];
    $pass = $_POST['password'];
    
    // Register User from register page
    if($_POST['form'] == "signup") {
        $hash = password_hash($pass, PASSWORD_BCRYPT);
        // Store hash in db
        
    }
    // Authenticate user from login page
    else if($_POST['form'] == "login") {
        // Get Hash from db
        
        if(!password_verify($password, $hash)){
            session_unset();
            session_destroy();
            header('Location: index.php?attempt=invalid');
        }
        
    }
    unset($_POST);
}
?>