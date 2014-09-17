<?php
session_start();
require("lib/mysql.php");
require("lib/queries.php");

if (!isset($_SESSION['user']) && isset($_POST['user'])) {
    $_SESSION['user'] = $_POST['user'];
}

?>
<?php
    // Header
    include("view/home/header2.php");

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
				include("view/home/_home.php");
			} 
			else { 
				//user is an admin
				echo "this is admin time";	
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

