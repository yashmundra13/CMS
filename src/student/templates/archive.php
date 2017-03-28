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
            <h1>All Assignments <small>Archive.</small></h1>
        </div>

  <div class="row">
    <div class="col-lg-8 col-lg-offset-2 col-md-10 ">
      <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>
                <tr>
                    <th>Due Date</th>
                    <th>Assignment Title</th>
                    <th>Teacher Name</th>
                    <th>Subject</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ( $results['assignments'] as $assignment ) { ?>
                    <tr class="odd gradeX" onclick="location='home.php?action=viewAssignment&amp;assignmentId=<?php echo $assignment->id?>'">
                        <td><?php echo date('j M Y', $assignment->dueDate)?></td>
                        <td><?php echo $assignment->title?></td>
                        <td><?php echo $assignment->teacherName?></td>
                        <td><?php echo $assignment->subject?></td>
                    </tr>
            <?php } ?>
            </tbody>
        </table>
    <p><?php echo $results['totalRows']?> assignment<?php echo ( $results['totalRows'] != 1 ) ? 's' : '' ?> in total.</p>
    <ul class="pager">
      <li class="next">
          <a href="./home.php">Return to Homepage &rarr;</a>
      </li>
    </ul>
    </div>
  </div>
</div>   



<?php include "templates/include/footer.php" ?>

