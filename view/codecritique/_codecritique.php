<?php
//get the ownerID of the person assigned to the user based on the link 'oID' value
if (isset($_GET['oID'])) {
        $num = $_GET['oID'] - 1;
        if (isset($critique[$num]['OwnerID'])) {
            $row = $critique[$num];		
            $_SESSION["revieweeID"] = $critique[$num]['OwnerID']; //set the assignID to the id of the selected assessment
		} else{
			header('Location: index.php');	
		}
} else {
	header('Location: index.php');	
}

//Need a session varibale containing the userID and the assignmentID
$rID = $_SESSION["revieweeID"]; //ID of the person being reviewed
$assignID = $assignmentID; //assignmentID

$currAssignmet = get_previous_assign_info($assignID);

?><?php date_default_timezone_set('Australia/Brisbane'); ?>

    <content>
    

    <h3>Review Other Students For <?php echo $currAssignmet[0]['AssignmentName'] ?></h3	>
    
    
    <!-- this is where the file data and comments will appear -->
    
    <div class="code">
       <div class = "fileselect">
        <?php
			$files = get_files_to_comment($rID, $assignID); //query the database
			if(sizeof($files) == 0){
				echo "No files found";	
			} else {
				echo "<span class=\"filebut\">File Select</span><ul class =\"filelist\">";
				foreach($files as $fileName){

					$fileNameStr = $fileName['FileName'];
					
			
					
					//display all filenames as an anchor
					echo "<li><a class='filelinks' data-fileID=".$fileName['FileID']." data-user=".$rID." title= ".$fileName['FileName'].
					">".$fileNameStr. "</a></li>";
				}
				echo "</ul>";
			}
        ?>
	</div>   
        <div id="revSelect">
            <ul id="tabs">
                
            </ul>
        </div>
        <!-- file data code added here -->
        <?prettify?>
        <pre class="prettyprint linenums">Nothing Selected</pre>
        
        <div id="coms">
            
        </div>
                    
	</div>     
    
    </content>

<script>
jQuery(function ($) {
    $(".filelinks").click(function() {
    //get the filename from the anchor tag clicked
	var file = $(this).attr("title"); //filename
	var fID = $(this).data("fileid"); //fileID
	
	var uID = '<?php if(isset($user)){echo $user;} ?>'; //user reviewing the file
	
	console.log(uID);
	console.log(fID);
        $.ajax({
            type:'POST',
            url:'lib/retrieve.php',
            data: {filename : file,
                   user : '<?php if(isset($rID)){ echo $rID;} ?>',
                   assign : '<?php if(isset($assignID)){ echo $assignID;} ?>' },
				   success: function(data){
						$('.prettyprinted').removeClass('prettyprinted');
						$("ul#tabs").html("");
					    //dump the file data into the pre tag
						$("pre.prettyprint.linenums").text(data);
						//load google prettify to style text
						prettyPrint();
						//load the comment system from commentDB.js											
						loadCommentSystem(uID, fID, false);			                
            }
        });
    });

});
                    
</script>

<script>
	//everything but the review bar, hide
	$('navgroup:not(.nav-review)').hide();
	
	$(".fileselect").on("click", ".filebut", function(){
		$(".filelist").toggle(300);	
	});
</script>