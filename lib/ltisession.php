<?php

/*
 * Process to retrieve necessary LTI post parameters for PCR and place them
 * into Session variables for authentication.
 */

// Load up the Basic LTI Support code
require_once 'blti.php';
// Check for existing institution
if (check_if_consumer_key($key)) {
    
    // Get row associated to key from DB.Institution
    $institution = get_institution($key);
    
    // Initialize
    $context = new BLTI($institution[0]['Secret'], false, false);

    // Gather LTI Post from linked users
    if ( $context->valid) {

        // Place Key into Session
        $_SESSION['consumerKey'] = $key;
        
        // Values to keep until login is achieved
        $_SESSION['isInstructor']= $context->isInstructor();
        $_SESSION['fullName']    = $context->getUserName();
        $_SESSION['fName']       = explode(' ',$context->getUserName(), 2)[0];
        $_SESSION['sName']       = explode(' ',$context->getUserName(), 2)[1];
        $_SESSION['userEmail']   = $context->getUserEmail();
        $_SESSION['courseName']  = $context->getCourseName();
        $_SESSION['institutionId'] = $institution[0]['InstitutionID'];
        
        // Default to Login
        include('view/login/_login.php');
    }
}