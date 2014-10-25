<?php
session_cache_limiter('none');
session_start();
require("lib/mysql.php");
require("lib/queries.php"); // query functions to get database results

if (!isset($_SESSION['user']) && isset($_POST['user'])) {
    $_SESSION['user'] = $_POST['user'];
}

if (isset($_SESSION["user"]) && (get_login_status($_SESSION["user"]) == true)) {
	
	 $user = $_SESSION["user"];
    
    if(!check_if_admin($user)){ 
		//is a student
		header('Location: index.php');
		
	} else {		
		//is an admin
		$fullName = get_user_name($user);
        $courses = get_admins_courses($user);
		$institution = get_user_institution($user);
		
		include("view/home/adminheader.php");
		include("view/admin/critiques/_critiques.php");	
	}
		
}else{
	
	 $_SESSION = array();
    session_destroy();
    
    // Show login
    include("view/login/_login.php"); 
	
}
//Footer
include("view/home/footer.php"); 
?>