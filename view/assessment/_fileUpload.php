<?php 
	//destroy the session variable on the start of a new upload
	if(isset($_SESSION['submitted'])){
		unset($_SESSION['submitted']);	
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