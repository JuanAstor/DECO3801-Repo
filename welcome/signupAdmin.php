<?php session_start(); ?>
<?php require("botdetect.php"); ?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <link type="text/css" rel="Stylesheet" href="<?php echo CaptchaUrls::LayoutStylesheetUrl() ?>" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    </head>

    <body>
        <div class="container">
            <h2>Sign Up - Admin</h2>
            <form role="form" method="POST" action="">
                <div class="form-group">
                    <input type="text" name="key" value="Institution name" required>
                    <?php
                    // Adding BotDetect Captcha to the page 
                    $SampleCaptcha = new Captcha("SampleCaptcha");
                    $SampleCaptcha->UserInputID = "CaptchaCode";
                    echo $SampleCaptcha->Html();
                    ?>
                    <input name="CaptchaCode" id="CaptchaCode" type="text" />
                    <input type="hidden" name="form" value="admin">

                </div>
                <button type="submit" class="btn btn-default">Submit</button>
                <button type="submit" class="btn btn-default" onClick="parent.location = 'welcomeAdmin.html'">Cancel</button>
            </form>
        </div>
        <?php
        if ($_POST) {
            // validate the Captcha to check we're not dealing with a bot
            $isHuman = $SampleCaptcha->Validate();

            if (!$isHuman) {
                header('Location: signupAdmin.php?validation=false');
            } else {
                $_SESSION['validation'] = true;
                $_SESSION['key'] = $_POST['key'];
                header('Location: authenticate_admin.php');
            }
        }
        ?>
    </body>
</html>
