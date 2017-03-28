
<?php include "templates/include/header.php" ?>
<script src='//cdn.tinymce.com/4/tinymce.min.js'></script>
<script>
  tinymce.init({
    selector: '#content'
    });
  </script>
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

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">New Assignment</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Insert new assignment
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                     <form action="home.php?action=<?php echo $results['formAction']?>" method="post">
                                    <input type="hidden" name="assignmentId" value="<?php echo $results['assignment']->id ?>"/>
                                    <input type="hidden" class="form-control" name="teacherName" id="teacherName" placeholder="Uploader Name" required maxlength="255" value="<?php echo htmlspecialchars($row['tuserName'])?>"></input>


                            <?php if ( isset( $results['errorMessage'] ) ) { ?>
                                    <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
                            <?php } ?>

                                    

                                      <div class="form-group">
                                        <label for="title">Assignments Title</label>
                                        <input class="form-control" type="text" name="title" id="title" placeholder="Name of the assignment" required autofocus maxlength="255" value="<?php echo htmlspecialchars( $results['assignment']->title )?>" />
                                      </div>

                                      <div class="form-group">
                                        <label for="subject">Subject</label>
                                        <input  class="form-control" name="subject" id="subject" placeholder="Subject Name" required maxlength="255" ></input>
                                      </div>
                                      <div class="radio">
                                          <label>
                                            <input type="radio" name="class" id="class" value="9" checked>
                                            Class 9
                                          </label>
                                        </div>
                                        <div class="radio">
                                          <label>
                                            <input type="radio" name="class" id="class" value="10">
                                            Class 10
                                          </label>
                                        </div>

                                      <div class="form-group">
                                        <label for="content">Assignments Content</label>
                                        <textarea class="form-control" name="content" id="content" placeholder="The HTML content of the assignment" maxlength="100000" style="height: 30em;"><?php echo htmlspecialchars( $results['assignment']->content )?></textarea>
                                      </div>
                                      <?php  $date = date('Y-m-d'); ?>
                                      <div class="form-group">
                                        <label for="dueDate">Due Date</label>
                                        <input class="form-control" type="date" min="<?php echo $date ?>" name="dueDate" id="dueDate" placeholder="YYYY-MM-DD" required maxlength="10" value="<?php echo $results['assignment']->dueDate ? date( "Y-m-d", $results['assignment']->dueDate ) : "" ?>" />
                                      </div>

                                    

                                    <div class="buttons">
                                      <input type="submit" name="saveChanges" value="Save Changes" />
                                    </div>

                                  </form>
                                  </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
</div>



    <!-- /.container-fluid -->
<?php include "templates/include/footer.php" ?>

