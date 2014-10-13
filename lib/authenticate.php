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

