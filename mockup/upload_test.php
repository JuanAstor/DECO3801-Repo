<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Upload Test</title>
</head>

<?php
	session_start();
	$_SESSION["user"] = '12123434';
	$_SESSION["assign"] = '5';
?>

<h1>Test File Upload</h1>
<div>
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
            	<input type="submit" class="box" value="Send"  />
                <input type="reset" value="Reset"  />
            </td>
        </tr>
    </table> 
    </form>
</div> 

</body>
</html>