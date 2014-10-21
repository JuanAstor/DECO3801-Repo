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
<h1>File Upload</h1></br>
<div>
    <!-- On submit contact the upload.php file which will handle everything -->
    <form method="post" action="../lib/upload.php" enctype="multipart/form-data">
    <div> Attach a File(s): You can select more than one </div></br>
    <table>
    	<tr>
            <td class="btn btn-default">
            	<input type="hidden" name="MAX_FILE_SIZE" value="2048000" />
               <input type="hidden" name="AssignNum" value="<?php echo $num+1 ?>" />
                <input name="userfile[]" type="file" id="files" multiple /> <!-- Need to include the '[]' at the end of name! -->
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
    if( $result != NULL){
        echo "<span>File(s) submitted: </span>";
        foreach($result as $file){
                $val = $file['SubmissionTime'];
                $dateTime = new DateTime($val);
                $date = $dateTime->format('d/m/Y');
                $time = $dateTime->format('H:i:s');
                echo "<br /><span>------<i>".$file['FileName']."</i> submitted on ".$date." at ".$time."</span>";	
                echo "<a class='del' href='#' data-value=".$file['FileID']."><span>____(delete?)____</span></a>";
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
                url: '../lib/_update.php',
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