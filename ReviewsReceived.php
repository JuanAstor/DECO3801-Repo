<?php
session_start();
require("lib/mysql.php");
require("lib/queries.php");

if (!isset($_SESSION['email']) && isset($_POST['email'])) {
    $_SESSION['email'] = $_POST['email'];
}

?>
<?php 
    include("view/home/header.php");

    if (isset($_SESSION["email"])) {
        include("view/review/_review.php");
    }
    else {
        include("view/login/_Login.php"); 
    }
    
    include("view/home/footer.php"); 
?>

