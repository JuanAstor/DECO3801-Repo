<?php 
include("resources/db.php")
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="/public_html/css/main.css">
<script src="/public_html/js/jquery.min.2.1.1.js"></script>
<script src="/public_html/js/view.js"></script>
<title>Will Code Review</title>
</head>

<body>
    <header>
    <h1>It Works!</h1>
    </header>
    <footer>
    <?php echo @mysql_ping()?'':'Database Not Connected';?>
    </footer>
</body>
</html>