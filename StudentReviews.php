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
        
    }else{ 
        
        // Admin:
        $fullName = get_user_name($user);
        $courses = get_admins_courses($user);
		$count = 0;
		
		if(isset($_GET['course'])){ //if the courseID has been passed through
			//if the courseID is related to the admin logged in
			foreach($courses as $list){
				if($_GET['course'] == $list['CourseID']){
					$count = 1; 
				} 
			}
			if($count == 1){ //the courseID matches a courseID the admin is in charge of
				$courseID = $_GET['course'];
				include("view/home/header.php");
				include("view/admin/studentReviews/_studentReview.php");	
			} else {
				header('Location: /index.php');	
			}
				
		} 
		else { //if no courseID is set, return the user back to the main page
			header('Location: /index.php');	
		}

		
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