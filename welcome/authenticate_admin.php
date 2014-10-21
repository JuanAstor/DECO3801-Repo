<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    </head>


    <body>
        <?php
        session_start();
        require_once('../lib/mysql.php');
        require_once('../lib/queries.php');

        if ($_SESSION['validation']) {
            
            // Set up consumer key
            $key = keysplit($_SESSION['key']);
            
            // Set up secret
            $secret = randomPassword();
            create_institution($key, $secret);
            
            // Display credentials
            echo '<h2>Consumer Key</h2>'
                .'<p>'.$key.'</p>'
                .'<h2>Shared Secret</h2>'
                .'<p>'.$secret.'</p>';
            
            session_unset();
            session_destroy();
        } else {
            header('Location: signupAdmin.php?validation=false');
        }

        function randomPassword() {
            // Source: http://codepad.org/UL8k4aYK
            $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
            $pass = array();
            $alphaLength = strlen($alphabet) - 1;
            for ($i = 0; $i < 16; $i++) {
                $n = rand(0, $alphaLength);
                $pass[] = $alphabet[$n];
            }
            return implode($pass);
        }

        function keysplit($string) {
            //Lower case everything
            $string = strtolower($string);
            //Make alphanumeric (removes all other characters)
            $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
            //Clean up multiple dashes or whitespaces
            $string = preg_replace("/[\s-]+/", " ", $string);
            //Convert whitespaces and underscore to dash
            $string = preg_replace("/[\s_]/", "-", $string);
            return $string.rand(100, 999);
        }
        ?>
    </body>
</html>
