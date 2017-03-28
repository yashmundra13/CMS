<?php include "templates/include/header.php" ?>

<div id="wrapper">
  <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="home.php">Admin Panel</a>
            </div>
            <!-- /.navbar-header -->
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="home.php"><i class="fa fa-dashboard fa-fw"></i>Dashboard</a>
                        </li>
                        <li>
                            <a href="home.php?action=newAssignment"><i class="fa fa-edit fa-fw"></i>Add New Assignment</a>
                        </li>
                        <li>
                            <a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
  </nav>
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">All Assignments</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->


        <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            All Assignments
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Due Date</th>
                                        <th>Assignment</th>
                                        <th>Teacher Name</th>
                                        <th>Subject</th>
                                        <th>Class</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ( $results['assignments'] as $assignment ) { ?>
                                    <?php if( strcmp($assignment->teacherName,$row['tuserName']) == 0) { ?>
                                        <tr class="odd gradeX" onclick="location='home.php?action=editAssignment&amp;assignmentId=<?php echo $assignment->id?>'">
                                            <td><?php echo date('j M Y', $assignment->dueDate)?></td>
                                            <td><?php echo $assignment->title?></td>
                                            <td><?php echo $assignment->teacherName?></td>
                                            <td><?php echo $assignment->subject?></td>
                                            <td><?php echo $assignment->class?></td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

</div>
    <!-- /#wrapper -->      

<?php include "templates/include/footer.php" ?>

