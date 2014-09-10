<?php
session_start();
require("lib/mysql.php");
require("lib/queries.php");

if (!isset($_SESSION['email']) && isset($_POST['email'])) {
    $_SESSION['email'] = $_POST['email'];
}

?>
<?php 
    include("view/codereview/header.php");

<<<<<<< HEAD
    if (isset($_POST["email"]) && isset($_POST["password"])) { 
        include("view/assignments/_abody.php");
=======
    if (isset($_SESSION["email"])) { 
        include("view/home/_home.php");
>>>>>>> FETCH_HEAD
    }
    else {
        include("view/login/_login.php"); 
    }
    
    include("view/codereview/footer.php"); 
<<<<<<< HEAD
?>

=======
?>
>>>>>>> FETCH_HEAD
