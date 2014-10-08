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
<content>
<h2>File Upload</h2>
<div>
	<!-- On submit contact the upload.php file which will handle everything -->
	<form method="post" action="../lib/upload.php" enctype="multipart/form-data">
    <table>
    	<tr>
        	<td> Attach a File(s): You can select more than one </td> 
            <td>
            	<input type="hidden" name="MAX_FILE_SIZE" value="4194304000" />
                <input name="userfile[]" type="file" id="files" multiple /> <!-- Need to include the '[]' at the end of name! -->
            </td>
        </tr>
        
        <tr>
        	<td width="175">
            	<p>
            	</p>
            </td>
            <td>
               	<input type="submit" value=<?php echo $submissionState ?>  />
                <input type="reset" value="Reset"  />
            </td>
        </tr>
    </table> 
    </form>
</div> 
<?php
    //if a submission has been made	
    if( $result != NULL){
		echo "<span>File(s) submitted: </span>";
		foreach($result as $file){
			$val = $file['SubmissionTime'];
			$dateTime = new DateTime($val);
			$date = $dateTime->format('d/m/Y');
			$time = $dateTime->format('H:i:s');
			echo "<br /><span>------".$file['FileName']." submitted on ".$date." at ".$time."</span>";	
			echo "<a><span>____(delete?)____</span></a>";
		}
    } else {
        echo "<span>You have not made any submissions yet</span>";
    } 
?>

</content>
