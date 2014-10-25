<?php 
    //destroy the session variable on the start of a new upload
    if(isset($_SESSION['submitted'])){
        unset($_SESSION['submitted']);	
    } 
    //check if any submissions have been made for the current assignment
    $result = get_submitted_info($_SESSION["user"], $_SESSION["assign"]);
    if($result == NULL){
        $submissionState = "Submit"; //no files have been submitted
    } else{
        $submissionState = "Resubmit"; //file(s) have been submitted
    }

?>
<head>
	 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</head>
<content>
<h1>File Upload</h1></br>
<div>
    <!-- On submit contact the upload.php file which will handle everything -->
    <form method="post" action="lib/upload.php" enctype="multipart/form-data">
    <h7> Attach a File to be uploaded for this assessment: </h7></br></br>
    <table>
    	<tr>
            <td class="btn btn-default">
            	<input type="hidden" name="MAX_FILE_SIZE" value="2048000" />
               <input type="hidden" name="AssignNum" value="<?php echo $num+1 ?>" />
                <input name="userfile[]" type="file" id="files" /> <!-- Need to include the '[]' at the end of name! -->
            </td>
        </tr>
        <tr>    
        </tr>
        <tr>
            <td>
                </br>
               	<input type="submit" class="btn btn-primary" value=<?php echo $submissionState ?>  />
                <input type="reset" class="btn btn-primary" value="Reset"  />
            </td>
        </tr>
    </table> 
    </form>
</div> 
<?php
    //if a submission has been made	
    if( isset($_SESSION['submit']) || $result != NULL){
		echo "<div class='alert alert-warning alert-dismissable'>"
                . " <a href='#' class='close' data-dismiss='alert' aria-hidden='true'>&times;</a>";
        		
			//let the user know what has happened to the files submitted
		if(isset($_SESSION['submit'])){
			if(strcmp($_SESSION['submit'], 'submitted') == 0){ //has been submitted
				echo "<p>The file(s) have been submitted successfully </p>";
			}		
			else if(strcmp($_SESSION['submit'], 'error') == 0){ //file has size 0 or not allowed extension
				echo "<p>Error uploading file: File type (extension) is not supported or the File size is zero </p>";
				echo "<p>File upload has been canceled </p>";	
			}
			else { //some other file error has occured so display the file 
				echo "<p>Error uploading files: '".$_SESSION['submit']."'</p>";	
				echo "<p>File upload has been canceled </p>";
			}
			unset($_SESSION['submit']); //unset so the message doesn't reappear
			echo "<br />";
		} 
		if($result != NULL){
			echo "<p>File(s) currently submitted: </p>";
			foreach($result as $file){
				$val = $file['SubmissionTime'];
				$dateTime = new DateTime($val);
				$date = $dateTime->format('d/m/Y');
				$time = $dateTime->format('H:i:s');
				echo "<span>-<i>".$file['FileName']."</i> submitted on ".$date." at ".$time."</span>";
				
				//if the current date/time < assignment due date and time then show else don't
				echo "<a class='del' href='#' data-value=".$file['FileID']."><span>_(delete?)_</span></a>";
			}
		}		
		echo "</div>"; //close the div of the viewing window
    } else {
        echo "</br>"."<h7>"."<span>You have not made any submissions yet</span>"."</h7>";
    } 
?>

</content>

<script>
jQuery(function ($) {
$("a.del").click(function() {
    var id = $(this).data("value");
        if(confirm("Are you sure you want to delete this file?")){ 
            $.ajax({
                type:'POST',
                url: 'lib/_update.php',
                data:{fileID : id }, 
                success: function(data){
                    //display the message from the delete query then reload the page
                    alert(data);
                    window.location.reload();	
                }
            });
        }
    });
});
</script>