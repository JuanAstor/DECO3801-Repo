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
        if (isset($_SESSION["user"])) 
        {
            $student = $_SESSION["user"];
			//check the login priveleges of the user 
			if(check_if_admin($student) == 0){ 
				//user is a student
				$courses = get_users_courses($student);
				$assessments = get_users_assessments($student);
				$fullName = get_user_name($student);
				// Show home dashboard
    			include("view/home/header2.php");
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
            // Show login prompt
            include("view/login/_login.php"); 
        }
    
    //Footer
    include("view/home/footer.php"); 
?>

