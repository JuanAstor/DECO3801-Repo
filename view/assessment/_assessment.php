<page>
    <heading>
    	Assignments
    </heading>

<?php
    
    if (isset($_GET['assessment'])) {
        $num = $_GET['assessment'] - 1;
        echo "<p>Assignment: ".$assessments[$num]['AssignmentName']."</p>";
    }else{
        foreach ($assessments as $row) {
        echo "<p>Assignment: ".$row['AssignmentName']."<p>";
        }
    } 
?>

</table>    	
</page>
