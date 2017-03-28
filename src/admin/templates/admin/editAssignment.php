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
                    <h1 class="page-header">Edit Assignment</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                    <div class="col-lg-8">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Insert new assignment
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                         <form action="home.php?action=<?php echo $results['formAction']?>" method="post">
                                        <input type="hidden" name="assignmentId" value="<?php echo $results['assignment']->id ?>"/>
                                        <input type="hidden" class="form-control" name="teacherName" id="teacherName" placeholder="Uploader Name" required maxlength="255" value="<?php echo htmlspecialchars( $results['assignment']->teacherName )?>"></input>

                                <?php if ( isset( $results['errorMessage'] ) ) { ?>
                                        <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
                                <?php } ?>

                                        

                                          <div class="form-group">
                                            <label for="title">Assignments Title</label>
                                            <input class="form-control" type="text" name="title" id="title" placeholder="Name of the assignment" required autofocus maxlength="255" value="<?php echo htmlspecialchars( $results['assignment']->title )?>" />
                                          </div>
                                          <div class="form-group">
                                            <label for="subject">Assignment Subject</label>
                                            <input class="form-control" type="text" name="subject" id="subject" placeholder="Name of the assignment" required autofocus maxlength="255" value="<?php echo htmlspecialchars( $results['assignment']->subject )?>" />
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
                                            <textarea class="form-control" name="content" id="content" placeholder="The HTML content of the assignment" required maxlength="100000" style="height: 30em;"><?php echo htmlspecialchars( $results['assignment']->content )?></textarea>
                                          </div>
                                        <?php  $date = date('Y-m-d'); ?>
                                          <div class="form-group">
                                            <label for="dueDate">Due Date</label>
                                            <input class="form-control" type="date" min="<?php echo $date ?>" name="dueDate" id="dueDate" placeholder="YYYY-MM-DD" required maxlength="10" value="<?php echo $results['assignment']->dueDate ? date( "Y-m-d", $results['assignment']->dueDate ) : "" ?>" />
                                          </div>


                                        

                                        <div class="buttons">
                                          <input type="submit" name="saveChanges" value="Save Changes" />
                                          <input type="submit" formnovalidate name="cancel" value="Cancel" />
                                          <a href="home.php?action=deleteAssignment&assignmentId=<?php echo $results['assignment']->id?>" class="btn btn-info" role="button">Delete</a>
                                        </div>

                                      </form>
                                      </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">Uploaded Files</div>
                        </div>
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>File Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $directory = "../student/uploads/".$results['assignment']->title.$results['assignment']->id."/";
                                if (!file_exists($directory)) {
                                    mkdir($directory, 0777, true);
                                }
                                $phpfiles = glob($directory . "*.*");
                                ?>

                                <?php foreach ( $phpfiles as $phpfile ) { ?>
                                    <tr class="odd gradeX">
                                        <td><?php echo "<a href='$phpfile'>".basename($phpfile)."</a>"?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
            </div>
        </div>
     

        <div class="row">
                <div class="col-md-12">
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="content">Post your Comments</label>
                            <textarea class="form-control" name="content" id="content" placeholder="Post your thoughts." required maxlength="100000""></textarea>
                        </div>
                        <div class="form-group"><input type="submit" value="Comment" name="submit" class="form-control"></div>
                        <input type="hidden" name="userName" value="<?php echo $row['tuserName'] ?>">
                        <input type="hidden" name="assignmentId" value="<?php echo $results['assignment']->id ?>"/>
                    </form>
                </div>       
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php foreach ( $com as $com ) { ?>
                        <div class="well">
                            <h4><?php echo $com['user']; ?></h4><hr>
                            <p><?php echo $com['content']; ?></p>
                        </div>
                    <?php } ?>   
                </div>
            </div>
    </div>
</div>
<?php     
    if(isset($_POST['content'])){
        $content = $_POST['content'];
        $userName = $_POST['userName'];
        $postID = $_POST['assignmentId'];
        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "INSERT INTO comments (user, content, postID) VALUES( :user, :content, :postID)";
        $st = $conn->prepare ( $sql );
        $st->bindValue( ":postID", $postID, PDO::PARAM_INT );
        $st->bindValue( ":user", $userName, PDO::PARAM_STR );
        $st->bindValue( ":content", $content, PDO::PARAM_STR );
        $st->execute();
        $conn = null;
        echo '<meta http-equiv="refresh" content="0; URL=home.php?action=comment&assignmentId='.$results['assignment']->id.'">';
    }
?>



    <!-- /.container-fluid -->
<?php include "templates/include/footer.php" ?>

