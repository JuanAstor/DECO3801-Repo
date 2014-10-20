<?php
require_once("mysql.php");
require_once("queries.php");

// Load up the Basic LTI Support code
require_once 'blti.php';

// Check for existing institution
if (isset($key)) {
    
    if (!check_if_consumer_key($key)) {
        // Send to index with error if institution does not exist
        session_unset();
        session_destroy();
        header('Location: index.php?error=institution+missing');
        die();
    }

    // Get row associated to key from DB.Institution
    $institution = get_institution($key);
    
    // Initialize
    $context = new BLTI($institution[0]['Secret'], false, false);

    // Gather LTI Post from linked users
    if ( $context->valid) {

        // Determine if student can signup to institution
        if (!$context->isInstructor() && !check_if_admin_assigned($key)) {
            // Send to index with error if institution has no admin
            session_unset();
            session_destroy();
            header('Location: index.php?error=admin+missing');
            die();        
        }

        // Place Key into Session
        $_SESSION['consumerKey'] = $key;
        
        // Values to keep until login is achieved
        $_SESSION['isInstructor']= $context->isInstructor() ? "Admin" : "Student";
        $_SESSION['fullName']    = $context->getUserName();
        $_SESSION['fName']       = explode(' ',$context->getUserName(), 2)[0];
        $_SESSION['sName']       = explode(' ',$context->getUserName(), 2)[1];
        $_SESSION['userEmail']   = $context->getUserEmail();
        $_SESSION['courseName']  = $context->getCourseName();
        $_SESSION['institutionId'] = $institution[0]['InstitutionID'];
        

        header('Location: index.php');
        die();
    }
    
    // Send to index with error if secret is invalid
    session_unset();
    session_destroy();
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
            header('Location: ../index.php?error=exists');
        }

        // Store User
        update_user($user,
                    $_SESSION['fName'],
                    $_SESSION['sName'],
                    $_SESSION['isInstructor'],
                    $hash,
                    $_SESSION['institutionId']);
        
        // Store AdminUser in Institution
        if (!check_if_admin_assigned($_SESSION['consumerKey'])
                && $_SESSION['isInstructor'] == 'Admin') {
            error_log("ENTERED!");
            insert_adminuser($user, $_SESSION['institutionId']);
        }

        // Remove sensitive session variables before redirecting
        unset($_SESSION['consumerKey']);
        header('Location: ../index.php?m=signup+success');
    }
    
    // LOGIN AUTHENTICATE
    else if($_POST['form'] == "login") {
        $user = $_POST['user'];
        // Check if User exists
        if (get_login_status($user)) {
            
            // Get Hash from db
            $hash = get_password_hash($user);

            // Check password is correct
            if(password_verify($pass, $hash[0]['Password'])){
                
                // Course to enrol
                $course = $_SESSION['courseName'];

                // Remove session variables before redirecting
                session_unset();

                // Store user variable for authentication
                $_SESSION['user'] = $user;
                header('Location: ../index.php');
                die();
            }
        }
        
        // Redirect when incorrect
        header('Location: ../index.php?error=invalid');
        die();
    }
}