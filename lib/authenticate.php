<?php
session_start();
require_once("mysql.php");
require_once("queries.php");

if (isset($_POST['password'])) {
    
    // Password
    $pass = $_POST['password'];
    
    /*
     * REGISTER
     * Handle signing up of User from LTI Post 
     */
    if($_POST['form'] == "signup") {
        
        // Check for email change by user
        if ( isset($_POST['user'])) {
            $user = $_POST['user'];        
        }
        
        // Credentials
        $key   = $_SESSION['consumerKey'];
        $user  = $_SESSION['userEmail'];
        $hash  = password_hash($pass, PASSWORD_BCRYPT);
        $admin = $_SESSION['isInstructor'];
        $fName = $_SESSION['fName'];
        $sName = $_SESSION['sName'];
        $uniID = $_SESSION['institutionId'];
        
        session_unset();
        session_destroy();
        
        // Check if User exists
        if (get_login_status($user)) {
            header('Location: ../index.php?error=exists');
        }
        
        $adminCheck = mapAdminUser($key, $admin, $user, $uniID);
        
        if (!$adminCheck) {
            header('Location: index.php?error=admin+missing');
            die();
        }
        
        // Store User
        update_user($user, $fName, $sName, $admin ? 'Admin' : 'Student', $hash, $uniID);
        
        header('Location: ../index.php?m=signup+success');
    }
    
    
    /*
     * LOGIN
     * Handle authentication of User from lib/_login.php
     */
    if($_POST['form'] == "login") {
        
        // User
        $user = $_POST['user'];
        
        // Login existing User
        if (get_login_status($user)) {
            
            // Hash
            $hash = get_password_hash($user);

            // Password auth
            if(password_verify($pass, $hash[0]['Password'])){
                
                // Enrol
                if (isset($_SESSION['courseName'])) {
                    enrolCourse($user, $_SESSION['courseName'], $_SESSION['institutionId'],  $_SESSION['isInstructor']);
                }
                
                // Flush $_SESSION
                session_unset();

                // Auth $_SESSION
                $_SESSION['user'] = $user;
                
                // Homepage
                header('Location: ../index.php');
                die();
            }
        }
        
        header('Location: ../index.php?error=invalid');
        die();
    }
}

/**
 * Method to determine if an institute currently has a admin assigned and
 * returns true or false if the user trying to sign up is able to. This method
 * will return false for students that somehow register when an admin isn't
 * assigned to their institute. Postcondition is that the institute responsible
 * for the user has completed their first run.
 * If the user is an admin, the method checks if the institute has an already
 * assigned admin, if not, the current $user is set.
 * 
 * @returns false : if the student's institute doesn't have a current admin.
 * @returns true  :  if the student's institute has an admin.
 * @returns true  :  if the user is admin
 */
function mapAdminUser($key, $admin, $user, $uniID) {
    if ($admin) {
        if (!check_if_admin_assigned($key))
        {
            insert_adminuser($user, $uniID);
        }
    }else{
        if (!check_if_admin_assigned($key))
        {
            return false;
        }
    }
    
    return true;
}

function enrolCourse($user, $course, $institution, $admin){
    if ($admin && !check_if_course_exists($course, $institution)) {
        create_course($user, $course, $institution);
    }
    
    if (!$admin && !check_if_student_enrolled($user, $course)) {
        update_enrolment($user, $course);
    }
}