<!DOCTYPE html>
<html>
    <head>
    <title>Code Review</title>
        <!-- CSS/LESS -->
        <link rel="stylesheet/less" href="css/main.less">
        <!-- JS -->
        <script src="http://code.jquery.com/jquery-1.8.0.min.js"></script>
        <script src="js/view.js"></script>
        <script src="js/less.js"></script>
    </head>
    <body>
    <header>
        <logo>Peer <span>{</span>Code Review<span>}</span></logo>
        <p><span class="welcome"><i class="fa fa-user"></i> Welcome 
            <?php foreach ($fullName as $name) {
                    echo $name['FName']." ".$name['SName'] ;
                }
            ?></span>
        <a href="view/logout/_logout.php">Log out</a></p>
    </header>
    <sidebar>
        <nav>
            <h4><i class="fa fa-tachometer"></i><span>Dashboard</span></h4>
            <h4><i class="fa fa-clipboard"></i><span>Edit Assessment</span></h4>
            <navgroup class="nav-assessment">
               
            <?php // Loop through courses and display
				
            ?>
            </navgroup>
            <h4><i class="fa fa-file-code-o"></i><span>Review Students</span></h4>
            <navgroup class="nav-review">
            <?php // Loop through courses and display
			
            ?>
            </navgroup>
            <h4><i class="fa fa-wrench"></i><span>Tools</span></h4>
            <navgroup class="nav-feedback">
            <?php // Loop through courses and display
			
            ?>
            </navgroup>
        </nav>
        <nav-handle><i class="fa fa-sort"></i></nav-handle>
    </sidebar>    
    <page>