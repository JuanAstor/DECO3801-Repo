<?php
//display all assignments available in the course
$result = get_course_assessments($courseID, $semester, $institution);
$showThis = false; //display the file viewer and comment system		
$output = NULL; //the message to be displayed upon form submission
$assignID = NULL; // to hold the assignment ID

/////// search for files submitted \\\\\\\\\\\\\\\\
if (isset($_POST['btnFile'])) {
    if (isset($_POST['search']) && (strcmp($_POST['search'], "") !== 0) && isset($_POST['AssignName']) && (strcmp($_POST['AssignName'], "") !== 0)) {
	if(strcmp($_POST['AssignName'], "Select...")==0){
		$info = 0;
		$output = "Error: Please select an Assignment";
	} else{
        $search = $_POST['search'];
		$search = strip_tags($search);
        $name = $_POST['AssignName'];

		//get the AssignmentID for the Selected Assignment
        $ans = get_assignID($name, $courseID);
        foreach ($ans as $id) {
		//only one assign id should ever be returned (since AssignID's are unique in the DB)
		//now search for all submissions by a student for that assignmentid
            $assignID = $id['AssignmentID'];
            $info = get_submitted_info($search, $id['AssignmentID']);
        }
		if(isset($info)){
			if (count($info) > 0) { //if a user has submitted a file for the assigment
				$output = "File(s) submitted by student " . $search . " for " . $name . " : <br />";
				$showThis = true;
			} else { //no files submitted
				$output = "No files have been submitted by student " . $search . " for " . $name;
				$showThis = false;
			}
		} else {
			//info is null
			$output = "Select an assignment first";
			$showThis = false;	
		}
	}
} 

/////////// search for comments \\\\\\\\\\\\\
} else if (isset($_POST['btnComment'])) { //comments button selected
    if (isset($_POST['search']) && (strcmp($_POST['search'], "") !== 0) && isset($_POST['AssignName']) && (strcmp($_POST['AssignName'], "") !== 0)) {
		
	if(strcmp($_POST['AssignName'], "Select...")==0){
		$info2 = 0;
		$output = "Error: Please select an Assignment";	
	} else {
        $search = $_POST['search']; //the student
		$search = strip_tags($search);
        $name = $_POST['AssignName']; // name of the assignment to search
		//get the AssignmentID for the Selected Assignment
        $ans = get_assignID($name, $courseID);
        foreach ($ans as $id) {
			//only one AssignID should be returned, now search for any
			//comments made by the searched user on the assignmentID
            $assignID = $id['AssignmentID'];
            $comment = find_user_comments($search, $id['AssignmentID']);

			//if a comment was made
            if ($comment != NULL) {
                $output = "Comments made by student " . $search . " for <i>" . $name . "</i> : <br />";
                $showThis = true; //display the file viewing window
                $info2 = array();
                foreach ($comment as $comments) {
					//use the fileid to get the files commented on
                    $fileIn = get_file_info($comments['FileID']);
                    if (!in_array($fileIn, $info2)) {
                        array_push($info2, $fileIn);
                    }
                    $fileIn = NULL;
                }

			//no comments found
            } else {
                $output = "No comments have been made by student " . $search . " for <i>" . $name . "</i>";
                $showThis = false; //don't display the file viewing window	
            }
        }
	}
	}

///////// Search for Assigned Critiques \\\\\\\\\\\\\\\\\		
} else if (isset($_POST['btnCritiques'])) {

    if (isset($_POST['search']) && (strcmp($_POST['search'], "") !== 0) && isset($_POST['AssignName']) && (strcmp($_POST['AssignName'], "") !== 0)) {
	if(strcmp($_POST['AssignName'], "Select...")==0){
		$info3 = 0;
		$output = "Error: Please select an Assignment";	
	} else {
		
        $search = $_POST['search']; //searched student
		$search = strip_tags($search);
        $AssignName = $_POST['AssignName'];
        $showThis = false; //don't need to display the file viewing window if searching for critique assigns

        $ans = get_assignID($AssignName, $courseID); //get the assignment id
     
		foreach ($ans as $id) {
			//should only be one assignmentID returned
			$assignID = $id['AssignmentID'];
			
			//find the number of ciritiques assigned to the assignment
			$count = check_if_critiques_assigned($assignID);
			
			//find all critiques that the searched student must critique
			$info3 = get_single_assignment_critiques($search, $assignID);
			
			if($count > 0){			
				if(!empty($info3)){
					$output = "The Students that <i>" . $search . "</i> will be critiquing is :<br />";
				} else {
					$output = "No critiques have been assigned to student <i>".$search."</i>";
				}
			} else {
				$output = "No critiques have been assigned to ".$_POST['AssignName'];	
			}
		}
    }
	}
}
?>
<?php date_default_timezone_set('Australia/Brisbane'); ?>

        <div class="formtitle"><h3>Review Submisssions for <?php echo strtoupper($courseID) ?></h3></div>

        <br />
        <div class="formcenter">
            <form action="StudentReviews.php?course=<?php echo $courseID ?>&sem=<?php echo $semester ?>" method="post">  
                <div class="form-group">
                    <label>Select Assignment  </label>
                    <!--<select name="AssignName"> -->
                    <?php
                    echo "<select name='AssignName'>";
                    echo "<option >Select...</option>";
                    foreach ($result as $na) {
                        $name = $na['AssignmentName'];
                        echo "<option value='" . $name . "' >" . $name . "</option>"; //display all assignment options
                    }
                    echo "</select>";
                    ?>

                    </br>
                    <label for="search">Student Search</label>
                    <input class="form-control" type="text" name="search" placeholder="Enter Student email" required>
                    <br />
                    </br>
                    <label for="btnFile">Search for  </label>
                    <input type="submit" name="btnFile" value="Files Submitted" class="btn btn-primary" 
                    	title="View all files submitted by this student"/>
                    <input type="submit" name="btnComment" value="Comments Made" class="btn btn-primary" 
                    	title="View all comments made by this student" />
                    <input type="submit" name="btnCritiques" value="Assigned Critiques" class="btn btn-primary" 
                    	title="View all students to be critiqued by this student" />
            </form>
            </br>
            </br>

			<?php
            if ($output == NULL) {
                //display nothing
            } else {
                 echo "<div class='alert alert-warning alert-dismissable'>"
                . " <a href='#' class='close' data-dismiss='alert' aria-hidden='true'>&times;</a>"
                . $output;
                if (isset($info)) { //files submitted search
					if($info != 0){
						foreach ($info as $fileName) {
							echo "<a class='showFile' style='cursor:pointer;'>" . $fileName['FileName'] . "</a><br />";
						}
					}
                } else if (isset($info2)) { //comments made search
					if($info2 != 0){
					$userArr = array();
                    foreach ($info2 as $fileName) {
						if(!(in_array($fileName[0]['UserID'],$userArr))){
							echo $fileName[0]['UserID']." : <br />";
							array_push($userArr, $fileName[0]['UserID']);
						}
                        echo "-<a class='commentlist' data-fileID=" . $fileName[0]['FileID'] . " data-user="
                        . $fileName[0]['UserID'] . " data-comUser=" . $search . " style='cursor:pointer;'>" 
						. $fileName[0]['FileName'] . "</a><br/>";
                    }
					}
                } else if (isset($info3)) { //critique assignment search
					if($info3 != 0){ //will be 0 if the assignment name wasn't set
                    	foreach ($info3 as $crit) {
                        	echo $crit['OwnerID'] . "<br />";
                    	}
					}
                }
                echo "</div>";
            }
            ?>
            <?php
            //if set to true then display the code viewing window, else none of the html below will be visible 
            	if ($showThis) :
            ?>
                </br>
                <div id="comSys">
                    <div id="revSelect">
                        <ul id="tabs">

                        </ul>
                    </div>
                    <!-- file data code added here -->
                    <?prettify?>
                    <pre class="prettyprint linenums">Nothing Selected</pre>

                    <div id="coms">

                    </div>
                    <div id="clearComs"></div>
                </div>
            <?php endif; ?>
        </div>
    </div>
<script>

    jQuery(function ($) {
        $(".showFile").click(function () {
            var file = $(this).text();
            //alert(file);
            $.ajax({
                type: 'POST',
                url: 'lib/retrieve.php',
                data: {filename: file,
                    user: '<?php
            if (isset($search)) {
                echo $search;
            }
            ?>',
                    assign: '<?php
            if (isset($assignID)) {
                echo $assignID;
            }
            ?>'},
                success: function (data) {
                    $('.prettyprinted').removeClass('prettyprinted');
                    $("ul#tabs").html("");
                    //dump the file data into the pre tag
                    $("pre.prettyprint.linenums").text(data);
                    //load google prettify to style text
                    prettyPrint();
                    //$("head")
                }
            });
        });
        $(".commentlist").click(function () {
            var file = $(this).text();
            var fID = $(this).data("fileid"); //file id of the commented file
            var uID = $(this).data("user"); //user id of the owner of the file
            var comUID = $(this).data("comuser"); //user id of the owner of the file
            $.ajax({
                type: 'POST',
                url: 'lib/retrieve.php',
                data: {filename: file,
                    user: uID,
                    assign: '<?php
            if (isset($assignID)) {
                echo $assignID;
            }
            ?>'},
                success: function (data) {
                    //$("pre").text(data);
                    //$("head")
                    $('.prettyprinted').removeClass('prettyprinted');
                    $("ul#tabs").html("");
                    $("pre.prettyprint.linenums").text(data);
                    //load google prettify to style text
                    prettyPrint();

                    //load the comment system from commentDB.js											
                    loadCommentSystem(comUID, fID, true);
                }
            });
        });

    });
</script>
<script>
    $('navgroup:not(.nav-reviewStudents)').hide();
</script>

<style>
    .prettyprint { width:95%;  }

</style>
