<?php include "templates/include/header.php" ?>

    <nav class="navbar navbar-default navbar-custom navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    Menu <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="home.php">Assignment Manager</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="./home.php">Home</a>
                    </li>
                    <li>
                        <a href="./home.php?action=archive">Archive</a>
                    </li>
                    <li>
                        <a href="./logout.php">Logout</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Header -->
        <div class="page-header">
        <div class="container">
            <h1><?php echo $row['userName']; ?>'s Assignments <small>Recent Assignments.</small></h1>
        </div>
        </div>

<div class="container">
  <div class="row">
    <div class="col-lg-12  col-md-12 ">
        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>
                <tr>
                    <th>Due Date</th>
                    <th>Assignment Title</th>
                    <th>Teacher Name</th>
                    <th>Subject</th>
                    <th>Class</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ( $results['assignments'] as $assignment ) { ?>
                <?php if($assignment->class == $row['class']) { ?>
                        <tr class="odd gradeX" onclick="location='home.php?action=viewAssignment&amp;assignmentId=<?php echo $assignment->id?>'">
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

<?php include "templates/include/footer.php" ?>

