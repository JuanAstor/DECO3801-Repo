<?php
require("lib/mysql.php");
require("lib/queries.php");
?>

<?php include("view/codereview/header.php"); ?>
<!-- Body -->
    <h1>Title of the Page</h1>
    <?php 
    	// Display all UserID's in table User
    	foreach (MySQL::getInstance()->query("SELECT * FROM `user`") as $row) {
    		echo $row['UserID'];
    	}
    ?>
<!-- TODO: Welcome message using OAUTH -->

<?php include("view/codereview/footer.php"); ?>