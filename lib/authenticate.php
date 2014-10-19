<?php
require_once("mysql.php");
require_once("queries.php");

// Load up the Basic LTI Support code
require_once 'blti.php';

// Error report
$loginMessage = 'Institution not found';

// Check for existing institution
if (isset($key) && check_if_consumer_key($key)) {
    
    // Get Secret from DB
    $secret = get_consumer_secret($key);
    
    // Initialize
    $context = new BLTI($secret[0]['Secret'], false, false);

    // Gather LTI Post from linked users
    if ( $context->valid ) {

        // Place Key into Session
        $_SESSION['consumerKey'] = $key;
        
        // Values to keep until login is achieved
        $_SESSION['isInstructor']= $context->isInstructor() ? "Admin" : "Student";
        $_SESSION['fullName']    = $context->getUserName();
        $_SESSION['fName']       = explode(' ',$context->getUserName(), 2);
        //$_SESSION['sName']       = explode(' ',$context->getUserName(), 2);
        $_SESSION['userEmail']   = $context->getUserEmail();
        $_SESSION['courseName']  = $context->getCourseName();
        
        header('Location: index.php?user=exists');
        die();
    }
    
    // Send to index with error if secret is invalid
    header('Location: index.php?error=fatal');
    die();
}

if (isset($_POST['password'])) {
    
    session_start();
    
    // Credentials
    $pass = $_POST['password'];
    
    
    // SIGN UP USER
    if($_POST['form'] == "signup") {
        
        // User Email from Session
        $user = $_SESSION['userEmail'];
        
        // Overwrite UserEmail if email specfied in POST
        if ( isset($_POST['user'])) {
            $user = $_POST['user'];        
        }
        // Save password as encrytped hash
        $hash = password_hash($pass, PASSWORD_BCRYPT);
        
        // Check if User exists
        if (get_login_status($user)) {
            header('Location: ../index.php?error=user');
        }
        
        // Store User
        update_user($user,
                    $_SESSION['fName'],
                    $_SESSION['sName'],
                    $_SESSION['isInstructor'],
                    $hash,
                    $_SESSION['consumerKey']);
        
        // Remove session variables before redirecting
        session_unset();
        session_destroy();
        header('Location: ../index.php?m=signup+success');
    }
    
    // LOGIN AUTHENTICATE
    else if($_POST['form'] == "login") {
        $user = $_POST['user'];
        // Check if User exists
        if (get_login_status($user)) {
            error_log('Entered, BITCH!');
            // Get Hash from db
            $hash = get_password_hash($user);

            // Check password is correct
            if(password_verify($password, $hash)){
                
                // Remove session variables before redirecting
                session_unset();
                session_destroy();
                
                // Store user variable for authentication
                $_SESSION['user'] = $user;
                header('Location: ../index.php?m=login+success');
            }
        }
        
        // Redirect when incorrect
        header('Location: ../index.php?error=invalid');
    }
    unset($_POST);
}
?>