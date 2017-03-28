<?php
session_start();
require_once 'classes/class.user.php';
require_once 'config.php';
$user_home = new USER();
$action = isset( $_GET['action'] ) ? $_GET['action'] : "";

if(!$user_home->is_logged_in())
{
	$user_home->redirect('index.php');
}

$stmt = $user_home->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);


switch ( $action ) {
  case 'archive':
    archive();
    break;
  case 'viewAssignment':
    viewAssignment();
    break;
  case 'comment':
    echo '<meta http-equiv="refresh" content="0; URL=home.php?action=viewAssignment&assignmentId='.$_GET['assignmentId'].'">';
  default:
    homepage();
}

function archive() {
  require_once 'classes/class.user.php';
  require_once 'config.php';
  $user_home = new USER();
  $stmt = $user_home->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
  $stmt->execute(array(":uid"=>$_SESSION['userSession']));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);  
  $results = array();
  $data = Assignment::getList();
  $results['assignments'] = $data['results'];
  $results['totalRows'] = $data['totalRows'];
  require( TEMPLATE_PATH . "/archive.php" );
}

function viewAssignment() {
  require_once 'classes/class.user.php';
  require_once 'config.php';
  $user_home = new USER();
  $stmt = $user_home->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
  $stmt->execute(array(":uid"=>$_SESSION['userSession']));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  if ( !isset($_GET["assignmentId"]) || !$_GET["assignmentId"] ) {
    homepage();
    return;
  }
  $results = array();
  $results['assignment'] = Assignment::getById( (int)$_GET["assignmentId"] );
  
  $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
  $sql = "SELECT * FROM comments WHERE postID = :postID";
  $st = $conn->prepare ( $sql );
  $st->bindValue( ":postID", $_GET["assignmentId"], PDO::PARAM_INT );
  $st->execute();
  $com = $st->fetchAll();


  require( TEMPLATE_PATH . "/viewAssignment.php" );
}

function homepage() {
  require_once 'classes/class.user.php';
  require_once 'config.php';
  $user_home = new USER();
  $stmt = $user_home->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
  $stmt->execute(array(":uid"=>$_SESSION['userSession']));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);  
  $results = array();
  $data = Assignment::getList();
  $results['assignments'] = $data['results'];
  $results['totalRows'] = $data['totalRows'];
  $results['pageTitle'] = "Assignment Manager";
  require( TEMPLATE_PATH . "/homepage.php" );
}
?>
