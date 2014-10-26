<?php 
	date_default_timezone_set('Australia/Brisbane');
	
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
	//set if a user can submit (enable/diable the submit option)
	$showThis = true; //default to enable	
	$today = date("Y-m-d"); //current date 
	$currTime = date("H:i:s"); //current time
    $today_dt = new DateTime($today); //convert to proper format

	$subInfo = 	get_previous_assign_info($_SESSION["assign"]);
	if($today_dt > (new DateTime($subInfo[0]['DueDate']))){
		$showThis = false;
	} else if($today_dt == (new DateTIme($subInfo[0]['DueDate']))){
		if(strtotime($currTime) > (strtotime($subInfo[0]['DueTime']))){
			$showThis = false; //time and date is greater than the submit, set to disable
		}	
	}

?><head>
	 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</head>
<content>

<div id ="formID">
<?php if($showThis) : ?>
	<h3> File Upload </h3>
    <!-- On submit contact the upload.php file which will handle everything -->
    <form method="post" action="lib/upload.php" enctype="multipart/form-data">
	</br></br>
    <table>
    	<tr>
            <td class="btn btn-default">
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
 <?php endif; ?>
</div> 
<?php
    //if a submission has been made	
    if( isset($_SESSION['submit']) || $result != NULL){
		        		
		//let the user know what has happened to the files submitted
		if(isset($_SESSION['submit'])){
			echo "<div class='alert alert-warning alert-dismissable'>"
                . " <a href='#' class='close' data-dismiss='alert' aria-hidden='true'>&times;</a>";
				
			if(strcmp($_SESSION['submit'], 'submitted') == 0){ //has been submitted
				echo "<p>The file(s) have been submitted successfully </p>";
			}		
			else if(strcmp($_SESSION['submit'], 'error') == 0){ //file has size 0 or not allowed extension
				echo "<p>Error uploading file: File type (extension) is not supported or the File size is zero </p>";
				echo "<p>File upload has been canceled </p>";	
			}
			else if(strcmp($_SESSION['submit'], 'size error') == 0){//file size is too large
				echo "<p>Error uploading file: The File size is too large, max size is 1MB </p>";
				echo "<p>File upload has been canceled </p>";
			}
			else { //some other file error has occured so display the file 
				echo "<p>Error uploading files: '".$_SESSION['submit']."'</p>";	
				echo "<p>File upload has been canceled </p>";
			}
			unset($_SESSION['submit']); //unset so the message doesn't reappear
			echo "<br />";
			echo "</div>"; //close the div of the viewing window
		} 
		
		//if files have been submitted then a list of info will be displayed about the files
		if($result != NULL){
			echo "<p>File(s) currently submitted: </p><br />";
			foreach($result as $file){
				$val = $file['SubmissionTime'];
				$dateTime = new DateTime($val);
				$subDate = $dateTime->format('d/m/Y');
				$subTime = $dateTime->format('H:i:s');
				echo "<span>-<i>".$file['FileName']."</i> submitted on ".$subDate." at ".$subTime."</span>";
				
				//$today = date("Y-m-d"); //current date 
				//$currTime = date("H:i:s"); //current time
                //$today_dt = new DateTime($today); //convert to proper format
				
				//if the current date/time is less than the due date and time then show it, else don't	
				$info1 = get_previous_assign_info($file['AssignmentID']);
				if($today_dt <= (new DateTime($info1[0]['DueDate']))){
					if(strtotime($currTime) < (strtotime($info1[0]['DueTime']))){
						echo "<a class='del' href='#' data-value=".$file['FileID']."><span> (delete?) </span></a>";
					}
				}
				echo "<br />";
			}
		}		
		
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