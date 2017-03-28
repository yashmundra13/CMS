<?php
session_start();
require_once 'classes/class.user.php';

$reg_user = new USER();

if($reg_user->is_logged_in()!="")
{
  $reg_user->redirect('home.php');
}


if(isset($_POST['btn-signup']))
{
  $uname = trim($_POST['txtuname']);
  $email = trim($_POST['txtemail']);
  $upass = trim($_POST['txtpass']);
  $class = trim($_POST['class']);
  $code = md5(uniqid(rand()));
  
  $stmt = $reg_user->runQuery("SELECT * FROM tbl_users WHERE userEmail=:email_id");
  $stmt->execute(array(":email_id"=>$email));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  
  if($stmt->rowCount() > 0)
  {
    $msg = "
          <div class='alert alert-error'>
        <button class='close' data-dismiss='alert'>&times;</button>
          <strong>Sorry!</strong>  email allready exists , Please Try another one
        </div>
        ";
  }
  else
  {
    if($reg_user->register($uname,$email,$upass,$code,$class))
    {     
      $id = $reg_user->lasdID();    
      $key = base64_encode($id);
      $id = $key;
      
      $message = "          
            Hello $uname,
            
            Welcome to your Assignment Manager!<br/>
            To complete your registration  please , just click following link
            'http://mundra.net.in/am/student/verify.php?id=$id&code=$code'
            Thanks,";
            
      $subject = "Confirm Registration";
            
      $reg_user->send_mail($email,$message,$subject); 
      $msg = "
          <div class='alert alert-success'>
            <button class='close' data-dismiss='alert'>&times;</button>
            <strong>Success!</strong>  We've sent an email to $email.
                    Please click on the confirmation link in the email to create your account. 
            </div>
          ";
    }
    else
    {
      echo "<div class='alert alert-success'>sorry , Query could no execute...</div>";
    }   
  }
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Signup</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    <link href="css/stylesheet.css" rel="stylesheet" media="screen">
     <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
  </head>
  <body id="login">
    <div class="container">
				<?php if(isset($msg)) echo $msg;  ?>
      <form class="form-signin" method="post">
        <h2 class="form-signin-heading">Sign Up</h2><hr />
        <input type="text" class="input-block-level" placeholder="Username" name="txtuname" required />
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
        <input type="email" class="input-block-level" placeholder="Jpischool Email address:" name="txtemail" pattern="[a-z0-9._%+-]+@jpischool+\.com" required  />
        <input type="password" class="input-block-level" placeholder="Password" name="txtpass" required />
     	<hr />
        <button class="btn btn-large btn-primary" type="submit" name="btn-signup">Sign Up</button>
        <a href="index.php"  class="btn btn-large btn-primary">Sign In</a>
        <a href="../" class="btn btn-large btn-primary">Go Back</a>
      </form>

    </div> <!-- /container -->
    <script src="vendors/jquery-1.9.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>