    <widget-container>
        <widget title="Edit Assessment">
            <panel>
                <div class="w-heading"><i class="fa fa-clipboard"></i>Edit Assessment</div>

                <div class="w-body">
                    <?php
                    foreach ($courses as $course) {
						//display the course id, semester and year
                        echo "<span>" . strtoupper($course['CourseID']) . " | </span>";
                        echo "<span>Semester " . substr($course['Semester'], -1) . " " . substr($course['Semester'], 0, 4) ."</span>";
                        echo "<br />";
                        $result = get_course_assessments($course['CourseID'], $course['Semester'], $institution);
                        foreach ($result as $names) {
							//display each assignment related to the above course id
                            echo "<a href='EditAssessment.php?course=" . $course['CourseID'] . "&sem=" . $course['Semester'] . "&assignmentName=" . $names['AssignmentName'] . "'>" . $names['AssignmentName'] . "</a>";
                            echo "<br />";
                        }
                        echo "<br />";
                    }
                    ?>
                </div>
            </panel>
        </widget>
        <widget title="Review Students">
            <panel>
                <div class="w-heading"><i class="fa fa-file-code-o"></i>Review Students</div>

                <div class="w-body">
                    <?php
                    foreach ($courses as $course) {
                        //display all courses that the admin is in charge of
                        echo "<span>" . strtoupper($course['CourseID']) . "   |  </span>";
                        echo "<span>Semester " . substr($course['Semester'], -1) . "    " . substr($course['Semester'], 0, 4) . "      </span><br />";
                        echo "<a href='StudentReviews.php?course=" . $course['CourseID'] . "&sem=" . $course['Semester'] . "'>
							Review
							</a>";
                        echo "<br /> <br />";
                    }
                    ?>
                </div>
            </panel>
        </widget>
        <widget title="Tools">
            <panel>
                <div class="w-heading"><i class="fa fa-wrench"></i>Tools</div>

                <div class="w-body">
                    <div class="toolpanel1">
                        <img src="img/cass2.png" class="img-circle" width="50px" height="auto" onclick="location.href =
                                        'Assessment.php'" >
                        <h6><a href="Assessment.php">Create Assessment</a></h6>
                    </div>
                    <div class="toolpanel2">
                        <img src="img/crit1.png" class="img-circle" width="50px" height="auto" onClick="location.href =
                                        'Critiques.php'" >
                        <h6><a href="Critiques.php">Assign Critiques</a></h6>
                    </div>
                </div>
            </panel>
        </widget>
    </widget-container>

    <widget-end>
        <div><panel-end></panel-end></div>
        <div><panel-end></panel-end></div>
        <div><panel-end></panel-end></div>
    </widget-end>


