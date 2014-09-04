<?php
require("lib/mysql.php");
require("lib/queries.php");
?>

<?php 
    include("view/codereview/header.php");

    if (isset($_POST["email"]) && isset($_POST["password"])) { 
        include("view/home/_home.php");
    }
    else {
        include("view/login/_login.php"); 
    }
    
    include("view/codereview/footer.php"); 
?>



<!DOCTYPE html>
<html>
    <head>
    <title>Assignments</title>
        <!-- CSS/LESS -->
        <link rel="stylesheet/less" href="css/main.less">
        <!-- JS -->
        <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
        <script src="js/less.js"></script>
    </head>
    <body>
    	<div>
    		
    	</div>
	</body>