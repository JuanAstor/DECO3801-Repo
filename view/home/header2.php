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
    <header>
        <a href="index.php"><brand>Peer <span>{</span>Code Review<span>}</span></brand></a>
        
        <logged>
            <div title="heading"><h5><i class="fa fa-user"></i> Welcome <?php echo $_SESSION["user"];?></h5></div> 
            <div><a href="view/logout/_logout.php">log out</a></div>
        </logged>
        
        
            
    </header>
        
