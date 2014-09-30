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
    <header>
        <logo>Peer <span>{</span>Code Review<span>}</span></logo>
        <p><span class="welcome"><i class="fa fa-user"></i> Welcome <?php echo $user;?></span>
        <a href="view/logout/_logout.php">Log out</a></p>
    </header>
	
	<sidebar>
		<nav>
			
		</nav>
		<nav-handle><i class="fa fa-sort"></i></nav-handle>
	</sidebar>
	
	<widget-container>
		<widget title="Created Assessment">
			<panel>
				<div class="w-heading"><i class="fa fa-clipboard"></i>Created Assessment</div>
				
				<div class="w-body">DECO3500 <button onclick="location.href = '';" id="Button1" class="btn btn-primary" submit-button">></button></div>
			</panel>
		</widget>
		<widget title="Review Students">
			<panel>
				<div class="w-heading"><i class="fa fa-file-code-o"></i>Review Students</div>
				<div class="w-body">DECO3500 <button onclick="location.href = 'Studentr.php';" id="Button1" class="btn btn-primary" submit-button">></button>
				</div>
			</panel>
		</widget>
		<img src="cass3.png" class="img-circle" onclick="location.href = 'cass.php'">
	</widget-container>
	
	<widget-end>
		<div><panel-end></panel-end></div>
		<div><panel-end></panel-end></div>
    </widget-end>
	
	</body>
</html>