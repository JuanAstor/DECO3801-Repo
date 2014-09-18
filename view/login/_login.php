<!DOCTYPE html>
<html>
    <head>
    <title>Code Review</title>
        <!-- Fonts -->
        <link href='http://fonts.googleapis.com/css?family=Patua+One' rel='stylesheet' type='text/css'>
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
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
        <brand>Peer <span>{</span>Code Review<span>}</span></brand>
    </div>
    <form action="" method="POST"> <!-- LEAVE ACTION BLANK -->
	    <heading>Please sign in</heading>
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