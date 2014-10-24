<!DOCTYPE html>
<html>
    <head>
        <title>Code Review</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSS/LESS -->
        <link rel="stylesheet/less" href="css/main.less">
        <!-- JS -->
        <script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
        <script src='js/view.js'></script>
        <script src="js/less.js"></script>
    </head>
    <body>
    <div class="login-bg"></div>
    <login>
        <div>
            <logo>Peer <span>{</span>Code Review<span>}</span></logo>
        </div>
        <form action="lib/authenticate.php" method="POST">
            <heading>Please sign in</heading>
            <input type="hidden" name="form" value="login">
            <input type="email" name="user" placeholder="Email" required autofocus>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Sign in</button>
            <!-- ERROR HANDLING -->
        </form>
    </login>
</body>
</html>