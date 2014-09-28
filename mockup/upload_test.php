<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
<title>Upload Test</title>
</head>

<script>
                    jQuery(function ($) {
                    $('.code').annotator();
                    });        </script>

<h1>Test File Upload</h1>
<div>
	
    <table>
    	<tr>
        	<td> Attach a File(s): You can select more than one </td> 
            <td>
            	<input type="hidden" name="MAX_FILE_SIZE" value="100000000" />
                <input name="userfile[]" id="ups" onchange="runThis()" type="file" multiple /> <!-- Need to include the '[]' at the end of name! -->					
				<script>
					function runThis(){
						var file_name = $('input[type="file"]');
						document.body.innerHTML = file_name;	
					}
				</script>
            </td>
        </tr>
        
        <tr>
        	<td width="175">
            	<p>
            	</p>
            </td>
            <td>
            	<input type="submit" class="aSubmit" value="Send"  />
                <input type="reset" value="Reset"  />
            </td>
        </tr>
    </table> 
    
     <div class="code">
            <pre class="prettyprint"> </pre>
        </div>
</div>

</body> 

<script>

jQuery(function ($) {
	

    $("#aForm").submit(function(event) {
    var files = $('input[type="file"]').val();
        // MAKE SURE THAT ASSIGNID AND USERID IS ALWAYS VALID.
        $.ajax({
            type:'POST',
            url:'../lib/upload1.php',
            data: {filename : files,
                   user : '<?php echo $uID ?>',
                   assign : '<?php echo $assignID ?>' },
			async: false,
			contentType: false,
			processData: false,
            success: function(data){
                $("pre").text(data);
                
            }
        });
		event.preventDefault();
    });
	
	$(".aSubmit").click(function()){
		$("#aForm").submit();
	});
	
    $('#code').annotator();

});
                    
</script>


</html>