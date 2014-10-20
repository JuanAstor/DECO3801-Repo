<?php
require_once("mysql.php");
require_once("queries.php");

// Load up the Basic LTI Support code
require_once 'blti.php';

// Error report
$loginMessage = 'Institution not found';

// Check for existing institution
if (isset($key) && check_if_consumer_key($key)) {
    
    // Assume firstrun
    $firstrun = true;

    // Get row associated to key from DB.Institution
    $institution = get_institution($key);
    
    // Initialize
    $context = new BLTI($institution[0]['Secret'], false, false);

    // Check if first user is admin
    if (!check_if_admin_assigned($key) && $context->isInstructor() == false) {
        $firstrun = false;
    }

    // Gather LTI Post from linked users
    if ( $context->valid && $firstrun) {

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
        if (check_if_admin_assigned($_SESSION['consumerKey'])
                && $_SESSION['isInstructor'] == 'Admin') {
            insert_adminuser($user, $_SESSION['institutionId']);
        }

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
            
            // Get Hash from db
            $hash = get_password_hash($user);

            // Check password is correct
            if(password_verify($pass, $hash[0]['Password'])){
                
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
?>