<page>
    <heading>
    	Assignments
    </heading>

<?php
    if(isset($_GET['assessment'])) {
        // Assessment GET retreives AssessmentID
        foreach ($assessments as $row) {
            if ($row['AssignmentID'] == $_GET['assessment']) {
                echo "<p>Display Assignment from GET</p>";
            }
        }
    }else{
        echo "<p>Display all the assignments<p>";
    } 
?>

</table>    	
</page>
