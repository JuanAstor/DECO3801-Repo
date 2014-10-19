<?php

$output = '';
if(isset($_POST['search'])){
	$searchit = $_POST['search'];
	$query = mysql_query("SELECT * FROM user WHERE UserID LIKE '%$searchit%'") or die("could not search");
	$count = mysql_num_rows($query);
	if($count == 0){
		$output = 'No search results found';
	}else{
		while($row = mysql_fetch_array($query)){
			$fname = $row['FName'];
			$id = $row['UserID'];
			$output .= '<div>'.$fname.'</div>';
		}
	}
}

?>
<!DOCTYPE html>
<html>
    <head>
    <title>Code Review</title>
        <!-- CSS/LESS -->
        <link rel="stylesheet/less" href="../css/main.less">
        <!-- JS -->
        <script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
        <script src='../js/view.js'></script>
        <script src="../js/less.js"></script>
    </head>
	<body>
        <mcontain>
            <h2>Student Review</h2>
        
            <button type="button" class="btn btn-primary">Show all Students</button>
            <button type="button" class="btn btn-primary">Clear</button>
            <br></br>
            <form action="Studentr.php" method="post" >
                <label for="search">Search</label>
                <input type="text" name="search" placeholder="Enter Student Number">
                <input type="submit" value="submit" class="btn btn-primary">
            </form>
        
            <?php 
            	print("$output");
            ?>
        </mcontain>
	</body>
</html>