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

    <ol class="breadcrumb">
      <li><a href="./home.php">Home</a></li>
      <li class="active">View Assignment</li>
    </ol>
    <!-- Page Header -->
    <!-- Set your background image for this header on the line below. -->
    <div class="page-header">
        <div class="container">
            <h1><?php echo htmlspecialchars( $results['assignment']->title )?><small>  Posted by <?php echo htmlspecialchars( $results['assignment']->teacherName )?>. Due on <?php echo date('j F Y',$results['assignment']->dueDate )?></small></h1>
        </div>
    </div>

        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8 ">
                    <p><?php echo $results['assignment']->content?></p>
                </div>
                <div class="col-md-4 col-lg-4">
                    <form action="upload.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="userName" value="<?php echo $row['userName'] ?>">
                        <input type="hidden" name="assignmentId" value="<?php echo $results['assignment']->id ?>"/>
                        <input type="hidden" name="assignmentTitle" value="<?php echo $results['assignment']->title ?>"/>
                        Select submission file to upload:
                        <div class="form-group"><input type="file" name="fileToUpload" id="fileToUpload" class="form-control" required></div>
                        <div class="form-group"><input type="submit" value="Upload File" name="submit" class="form-control"></div>
                    </form>
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
                        <input type="hidden" name="userName" value="<?php echo $row['userName'] ?>">
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

<?php include "templates/include/footer.php" ?>

