<?php 
include("resources/db.php")
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Will Code Review</title>
</head>

<body>
<h1>It Works!</h1>
<?php echo @mysql_ping() ? 'true' : 'false'; ?>
</body>
</html>