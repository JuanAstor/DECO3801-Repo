<?php
session_start();
require("lib/mysql.php");
require("lib/queries.php"); //query functions to get database results

if (!isset($_SESSION['user']) && isset($_POST['user'])) {
    $_SESSION['user'] = $_POST['user'];
}

?>
<?php
        /**
         *  Show the home dashboard if student has authenticated.
         *  Otherwise show the login prompt.
         */
        if (isset($_SESSION["user"]) && (get_login_status($_SESSION["user"]) == true)) 
        {
            $student = $_SESSION["user"];
			//$result = get_login_status($student);
			//echo $result; 
			//check the login priveleges of the user 
			if(check_if_admin($student) == 0){ 
				
				//user is a student, get info on who they are and what courses they do
				$courses = get_users_courses($student);
				$assessments = get_users_assessments($student);
				$fullName = get_user_name($student);

				// Show home dashboard
    			include("view/home/header.php");
				include("view/home/_home.php");
			} 
			else { 
				//user is an admin
				echo "this is admin time"; 
				$fullName = get_user_name($student);
				$courses = get_admin_courses($student); //will get the courses that an admin coordinates/tutes 	
			}
            
        }
        else
        {
			//remove any set userID session variable on the login screen
			if(isset($_SESSION["user"])){
				unset($_SESSION["user"]);	
			}
            // Show login prompt
            include("view/login/_login.php"); 
        }
    
    //Footer
    include("view/home/footer.php"); 
?>