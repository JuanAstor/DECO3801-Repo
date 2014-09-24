<page>
    <heading>
    	Assignments
    </heading>

<?php
    
    if (isset($_GET['assessment'])) {
        $num = $_GET['assessment'] - 1;
        if (isset($assessments[$num]['AssignmentID'])) {
            echo "<p>Assignment: ".$assessments[$num]['AssignmentName']."</p>";
			
			$_SESSION["assign"] = $assessments[$num]['AssignmentID']; //set the assignID to the id of the selected assessment
			echo "Assignment ID is: ".$_SESSION["assign"]; //display the id
        }else{
            header("Location: Assessment.php");
        }
    }else{
        foreach ($assessments as $row) {
        echo "<p>Assignment: ".$row['AssignmentName']."<p>";
        }
		if(isset($_SESSION["assign"])){ //check if the session var is set
				echo "Assignment ID is still: ".$_SESSION["assign"];
		}
    } 
?>
<html>

<h2>File Upload</h2>
<div>
	<!-- On submit contact the upload.php file which will handle everything -->
	<form method="post" action="../lib/upload.php" enctype="multipart/form-data">
    <table>
    	<tr>
        	<td> Attach a File(s): You can select more than one </td> 
            <td>
            	<input type="hidden" name="MAX_FILE_SIZE" value="100000000" />
                <input name="userfile[]" type="file" multiple /> <!-- Need to include the '[]' at the end of name! -->
            </td>
        </tr>
        
        <tr>
        	<td width="175">
            	<p>
            	</p>
            </td>
            <td>
            	<input type="submit" value="Send"  />
                <input type="reset" value="Reset"  />
            </td>
        </tr>
    </table> 
    </form>
</div> 


</html>

</table>    	
</page>
