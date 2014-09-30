<?php
 
		//Load the file
		$contents = file_get_contents('files/user1.json');
 
		//Decode the JSON data into a PHP array.
		$contentsDecoded = json_decode($contents, true);
 
		
 
		//Modify the comments
		$contentsDecoded['comments'] = $_POST['mydata'];
 
		//Encode the array back into a JSON string.
		$json = json_encode($contentsDecoded);
 
		//Save the file.
		file_put_contents('files/user1.json', $json);


?>