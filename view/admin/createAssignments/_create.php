<html>
    <head>
    <title>Code Review</title>
        <!-- CSS/LESS -->
        <link rel="stylesheet/less" href="/css/main.less">
        <!-- JS -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src='/js/view.js'></script>
        <script src="/js/less.js"></script>
		<!--<script src="../js/moment.js"></script> -->
        <link rel="stylesheet" type="text/css" href="/css/bootstrap-datetimepicker.min.css">
		
		<!-- <script src="../js/bootstrap.min.js"></script>
		<script src="../js/bootstrap-datetimepicker.min.js"></script> -->
    </head>
	<body>
		<widget-container>
			<form role="form">
				<div class="form-group">
					<label for="cID">Course ID</label>
					<input class="form-control" id="cID" placeholder="Enter Course ID here">
				</div>
				<div class="form-group">
					<label for="aName">Assignment Name</label>
					<input class="form-control" id="aName" placeholder="Enter Assignment name here">
				</div>
				<div class="form-group">
					<label for="description">Assignment Description</label>
					<textarea class="form-control" id="description"rows="2"></textarea>
				</div>
				
				<div class="form-group">
					<label for="time">Time Due</label>
					<input class="form-control" id="time" placeholder="Enter time here">
				</div>
				
				
 
				<div class="form-group">
					<label for="date">Date Due</label>
					<input class="form-control" id="date" placeholder="Enter date here">
				</div>
							
				<div class="form-group">
					<label for="critAss">Number of critiques assigned per assignment</label>
					<input class="form-control" id="critAss" placeholder="Enter # of critiques to be completed">
				</div>
				<button type="submit" class="btn btn-primary">Submit</button>
			</form>
		</widget-container>
	</body>
</html>