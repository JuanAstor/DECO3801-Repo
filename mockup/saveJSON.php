<?php
 
		//Load the file
		$contents = file_get_contents($_POST['url']);
 
		//Decode the JSON data into a PHP array.
		$contentsDecoded = json_decode($contents, true);
 
		
 
		//Modify the comments
		$contentsDecoded['comments'] = $_POST['data'];
 
		//Encode the array back into a JSON string.
		$json = json_encode($contentsDecoded);
 
		//Save the file.
		file_put_contents($_POST['url'], $json);


?>