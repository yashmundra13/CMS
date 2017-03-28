<?php
session_start();
require_once 'classes/class.tuser.php';
require_once 'config.php';
$tuser_home = new TUSER();
$action = isset( $_GET['action'] ) ? $_GET['action'] : "";

if(!$tuser_home->is_logged_in())
{
	$tuser_home->redirect('index.php');
}

$stmt = $tuser_home->runQuery("SELECT * FROM tbl_tusers WHERE tuserID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['tuserSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

switch ( $action ){
  case 'newAssignment':
    newAssignment();
    break;
  case 'editAssignment':
    editAssignment();
    break;
  case 'deleteAssignment':
    deleteAssignment();
    break;
  case 'comment':
    echo '<meta http-equiv="refresh" content="0; URL=home.php?action=editAssignment&assignmentId='.$_GET['assignmentId'].'">';
  default:
    listAssignments();
}

function newAssignment() {
  require_once 'classes/class.tuser.php';
  require_once 'config.php';
  $tuser_home = new TUSER();
  $stmt = $tuser_home->runQuery("SELECT * FROM tbl_tusers WHERE tuserID=:uid");
  $stmt->execute(array(":uid"=>$_SESSION['tuserSession']));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  $results = array();
  $results['pageTitle'] = "New Assignment";
  $results['formAction'] = "newAssignment";

  if ( isset( $_POST['saveChanges'] ) ) {

    // User has posted the assignment edit form: save the new assignment
    $assignment = new Assignment;
    $assignment->storeFormValues( $_POST );
    $assignment->insert();
    header( "Location: home.php?status=changesSaved" );

  } elseif ( isset( $_POST['cancel'] ) ) {

    // User has cancelled their edits: return to the assignment list
    header( "Location: home.php" );
  } else {
    $tuser_home = new TUSER();
    $stmt = $tuser_home->runQuery("SELECT * FROM tbl_tusers WHERE tuserID=:uid");
    $stmt->execute(array(":uid"=>$_SESSION['tuserSession']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // User has not posted the assignment edit form yet: display the form
    $results['assignment'] = new Assignment;
    require( TEMPLATE_PATH . "/admin/newAssignment.php" );
  }
}
function editAssignment() {
  require_once 'classes/class.tuser.php';
  require_once 'config.php';
  $tuser_home = new TUSER();
  $stmt = $tuser_home->runQuery("SELECT * FROM tbl_tusers WHERE tuserID=:uid");
  $stmt->execute(array(":uid"=>$_SESSION['tuserSession']));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  $results = array();
  $results['pageTitle'] = "Edit Assignment";
  $results['formAction'] = "editAssignment";

  $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
  $sql = "SELECT * FROM comments WHERE postID = :postID";
  $st = $conn->prepare ( $sql );
  $st->bindValue( ":postID", $_GET["assignmentId"], PDO::PARAM_INT );
  $st->execute();
  $com = $st->fetchAll();

  if ( isset( $_POST['saveChanges'] ) ) {

    // User has posted the assignment edit form: save the assignment changes

    if ( !$assignment = Assignment::getById( (int)$_POST['assignmentId'] ) ) {
      header( "Location: home.php?error=assignmentNotFound" );
      return;
    }

    $assignment->storeFormValues( $_POST );
    $assignment->update();
    header( "Location: home.php?status=changesSaved" );

  } elseif ( isset( $_POST['cancel'] ) ) {

    // User has cancelled their edits: return to the assignment list
    header( "Location: home.php" );
  } else {

    // User has not posted the assignment edit form yet: display the form
    $results['assignment'] = Assignment::getById( (int)$_GET['assignmentId'] );
    require( TEMPLATE_PATH . "/admin/editAssignment.php" );
  }
}
function deleteAssignment() {
  require_once 'classes/class.tuser.php';
  require_once 'config.php';
  $tuser_home = new TUSER();
  $stmt = $tuser_home->runQuery("SELECT * FROM tbl_tusers WHERE tuserID=:uid");
  $stmt->execute(array(":uid"=>$_SESSION['tuserSession']));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  if ( !$assignment = Assignment::getById( (int)$_GET['assignmentId'] ) ) {
    header( "Location: home.php?error=assignmentNotFound" );
    return;
  }

  $assignment->delete();
  header( "Location: home.php?status=assignmentDeleted" );
}
function listAssignments() {
  require_once 'classes/class.tuser.php';
  require_once 'config.php';
  $tuser_home = new TUSER();
  $stmt = $tuser_home->runQuery("SELECT * FROM tbl_tusers WHERE tuserID=:uid");
  $stmt->execute(array(":uid"=>$_SESSION['tuserSession']));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $results = array();
  $data = Assignment::getList();
  $results['assignments'] = $data['results'];
  $results['totalRows'] = $data['totalRows'];
  $results['pageTitle'] = "All Assignments";

  if ( isset( $_GET['error'] ) ) {
    if ( $_GET['error'] == "assignmentNotFound" ) $results['errorMessage'] = "Error: Assignment not found.";
  }

  if ( isset( $_GET['status'] ) ) {
    if ( $_GET['status'] == "changesSaved" ) $results['statusMessage'] = "Your changes have been saved.";
    if ( $_GET['status'] == "assignmentDeleted" ) $results['statusMessage'] = "Assignment deleted.";
  }

  require( TEMPLATE_PATH . "/admin/listAssignments.php" );
}

