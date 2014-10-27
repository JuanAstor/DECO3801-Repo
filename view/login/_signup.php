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
    <login>
        <div>
            <logo>Peer <span>{</span>Code Review<span>}</span></logo>
        </div>
        <form action="lib/authenticate.php" method="POST" class="validateForm"> <!-- LEAVE ACTION BLANK -->
            <heading>Please register</heading>
            <input type="hidden" name="form" value="signup">
            <input type="text" name="fullname" disabled="disabled" value="<?php echo $_SESSION['fullName'] ?>">
            <input type="email" name="user" disabled="disabled" value="<?php echo $_SESSION['userEmail'] ?>">
            <input type="checkbox" id="disableEmail" checked="checked"><span> Use student email</span>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Register</button>
        </form>
    </login>
</body>

<script type="text/javascript">
    $('#disableEmail').change(function () {
        input = $('input[name="user"]');
        if ($(this).prop('checked')) {
            input.prop('disabled', true);
        } else {
            input.prop('disabled', false);
        }
        ;
    })
</script>

</html>