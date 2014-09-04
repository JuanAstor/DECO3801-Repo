<?php
require("lib/mysql.php");
require("lib/queries.php");
?>

<?php 
    include("view/codereview/header.php");

    if (isset($_POST["email"]) && isset($_POST["password"])) { 
        include("view/assignments/_abody.php");
    }
    else {
        include("view/login/_login.php"); 
    }
    
    include("view/codereview/footer.php"); 
?>

