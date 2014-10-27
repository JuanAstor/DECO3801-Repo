<!DOCTYPE html>
<html>
    <head>
        <title>Peer Code Review</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSS/LESS -->
        <link rel="stylesheet/less" href="css/main.less">
        <link rel="stylesheet" href="css/comments.css">
        <link rel="stylesheet" href="css/prettify.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <!-- JS -->
        <script src="js/jquery-1.11.1.min.js"></script>
        <script src="js/commentDB.js"></script>
        <script src="js/prettyprint/prettify.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/view.js"></script>
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