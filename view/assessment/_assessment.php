<page>
    <heading>
    	Assignments
    </heading>

<?php
    
    if (isset($_GET['assessment'])) {
        $num = $_GET['assessment'] - 1;
        if (isset($assessments[$num]['AssignmentID'])) {
            echo "<p>Assignment: ".$assessments[$num]['AssignmentName']."</p>";
        }else{
            header("Location: Assessment.php");
        }
    }else{
        foreach ($assessments as $row) {
        echo "<p>Assignment: ".$row['AssignmentName']."<p>";
        }
    } 
?>

</table>    	
</page>
