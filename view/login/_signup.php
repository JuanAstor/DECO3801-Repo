<!DOCTYPE html>
<html>
    <head>
    <title>Code Review</title>
        <!-- CSS/LESS -->
        <link rel="stylesheet/less" href="css/main.less">
        <!-- JS -->
        <script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
        <script src='js/view.js'></script>
        <script src="js/less.js"></script>
    </head>
<body>
    <login>
    <div>
        <logo>Peer <span>{</span>Code Review<span>}</span></logo>
    </div>
    <form action="" method="POST" class="validateForm"> <!-- LEAVE ACTION BLANK -->
	    <heading>Please register</heading>
            <input type="hidden" name="isinstructor"               value="<?php echo $_SESSION['isInstructor']?>">
            <input type="text" name="fullname" disabled="disabled" value="<?php echo $_SESSION['fullName']?>">
            <input type="text" name="userid" disabled="disabled"   value="<?php echo $_SESSION['userID']?>">
	    <input type="password" name="password" placeholder="Password" required>
	    <button type="submit">Register</button>
    </form>
    </login>
</body>
</html>