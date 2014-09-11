<sidebar>
	<nav>
	<p>Courses</p>
		<?php // Query db for courses assigned to user ?>
	</nav>
</sidebar>

<container>
	<widget title="Upcoming Assessments">
		<p>Upcoming Assessments</p>
	</widget>
	<!-- End Upcoming Assessments -->
	<widget title="Tasks">
		<p>Tasks</p>
	</widget>
	<!-- End Tasks -->
	<widget title="Reviews Received">
		<p>Reviews Received</p>
	</widget>
	<!-- End Reviews Received -->
	<p> Welcome <?php echo $_SESSION["email"]; ?> </p>
</container>

<clearfix></clearfix>