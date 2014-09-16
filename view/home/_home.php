<sidebar>
    <nav>
        <h5>Courses</h5>
        <?php // Query db for courses assigned to user ?>
    </nav>
</sidebar>
<widget-container>
    <widget title="Upcoming Assessments">
        <panel>
            <div title="heading"><i class="fa fa-clipboard"></i>Upcoming Assessments</div>
            <div title="body">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            </div>
        </panel>
    </widget>
    <!-- End Upcoming Assessments -->
    <widget title="Tasks">
        <panel>
            <div title="heading"><i class="fa fa-file-code-o"></i>Tasks</div>
            <div title="body">Panel content goes here..</div>
        </panel>
    </widget>
    <!-- End Tasks -->
    <widget title="Reviews Received">
        <panel>
            <div title="heading"><i class="fa fa-comment"></i>Reviews Received</div>
            <div title="body">Panel content goes here..</div>
        </panel>
    </widget>
    <!-- End Reviews Received -->
</widget-container>
<widget-end>
    <div><panel-end></panel-end></div>
    <div><panel-end></panel-end></div>
    <div><panel-end></panel-end></div>
</widget-end>

<div class="dashboard-content">
        <p> Welcome <?php echo $_SESSION["email"]; ?> </p>
</div>
