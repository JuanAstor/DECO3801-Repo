<?php session_start(); ?>
<?php require("botdetect.php"); ?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <link type="text/css" rel="Stylesheet" href="<?php echo CaptchaUrls::LayoutStylesheetUrl() ?>" />
        <link href='../css/main.less' rel='stylesheet' type='text/css'>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    </head>

    <body>
        <login>
        <div class="container">
            <div class="formtitle"><h1>Sign Up - Admin</h1></div>
            </br>
            <form role="form" method="POST" action="">
                <div class="form-group">
                    <h6>Institution name</h6>
                    <input class="form-control" type="text" name="key" placeholder="e.g. University of Queensland" required /></br></br>
                    <?php
                    // Adding BotDetect Captcha to the page 
                    $SampleCaptcha = new Captcha("SampleCaptcha");
                    $SampleCaptcha->UserInputID = "CaptchaCode";
                    echo $SampleCaptcha->Html();
                    ?>
                    </br></br>
                    <h6>Please enter code above</h6>
                    <input class="form-control" name="CaptchaCode" id="CaptchaCode" type="text" />
                    <input type="hidden" name="form" value="admin">

                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="submit" class="btn btn-warning" onClick="parent.location = 'welcomeAdmin.html'">Cancel</button>
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
    </login>
    </body>
</html>
