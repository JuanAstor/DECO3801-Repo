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
    <form action="" method="POST"> <!-- LEAVE ACTION BLANK -->
	    <heading>Please sign in</heading>
            <input type="hidden" name="form" value="login">
	    <input type="text" name="user" placeholder="Student number" required autofocus>
	    <input type="password" name="password" placeholder="Password" required>
	    <label>
	        <input type="checkbox" value="remember-me"> Remember me
	    </label>
	    <button type="submit">Sign in</button>
    </form>
	</login>
</body>
</html>