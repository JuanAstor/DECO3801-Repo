<head>
	 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
     <?php 
	 	$uID = '12123434'; //userID
		$assignID = '5'; //assignmentID
	 ?>
</head>

<body>
	<div>
    <form id="aForm" action="" enctype="multipart/form-data"> 
    	<a>Browse<input type="file" name="userfiles" /></a>
    </form>
    	<br />
        <a><input type="button" id="getFile" name="attach" value="Attach File" /></a>
        <a><input type="button" id="send" name="submit" value="Submit" /></a>
        <a><input type="button" id="delete" name="remove" value="Clear Files" /></a>
        <br />
    	<span>Files to be submitted: </span><span class="filename"></span>
    </div>
    <div>
    	<br />
        <span class="sendText"></span>
    </div>
</body>

<script>
	name_list = []; //will hold the file name
	filepath_list = []; //will hold the file paths
	//when a user clicks the attach file button
	$('#getFile').on('click', function(event, files, label) {
		var filepath = $('input[type="file"]').val(); //get the filepath
		filepath_list[filepath_list.length] = filepath;
		var file_name = filepath.replace(/\\/g,'/').replace(/.*\//,''); //get the filename
		name_list[name_list.length] = file_name; 
		$(".filename").text(name_list); //display the files to be submitted
	});
	
	//when a user clicks the submit button
	$('#send').on('click', function(event, files, label) {
		$.ajax({
			type: "POST",
			url: "../lib/upload1.php",
			data: {filepath: filepath_list, 
					user: '<?php echo $uID ?>',
					assign: '<?php echo $assignID ?>' },
			success: function(data){
				$('.sendText').text('success(but i doubt it)');	
				$('.sendText').text(data);
			}
		});
	});
	
	//remove all files from the array and update the display text
	$('#delete').on('click', function(event, files, label) {
		filepath_list = [];
		name_list = [];
		$(".filename").text(name_list);
	});
	
</script>