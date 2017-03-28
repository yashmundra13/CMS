<?php

/**
 * Class to handle assignments
 */

class Assignment
{
  // Properties
  /**
  * @var int The assignment ID from the database
  */
  public $id = null;

  /**
  * @var int When the assignment is due
  */
  public $dueDate = null;

  /**
  * @var string Full title of the assignment
  */
  public $title = null;

  /**
  * @var string A short teacherName of the assignment
  */
  public $teacherName = null;

  /**
  * @var string The HTML content of the assignment
  */
  public $content = null;

  public $subject = null;


  /**
  * Sets the object's properties using the values in the supplied array
  *
  * @param assoc The property values
  */

  public function __construct( $data=array() ) {
    if ( isset( $data['id'] ) ) $this->id = (int) $data['id'];
    if ( isset( $data['dueDate'] ) ) $this->dueDate = (int) $data['dueDate'];
    if ( isset( $data['title'] ) ) $this->title = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['title'] );
    if ( isset( $data['teacherName'] ) ) $this->teacherName = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['teacherName'] );
    if ( isset( $data['content'] ) ) $this->content = $data['content'];
    if ( isset( $data['subject'] ) ) $this->subject = $data['subject'];
    if ( isset( $data['class'] ) ) $this->class = (int) $data['class'];
  }


  /**
  * Sets the object's properties using the edit form post values in the supplied array
  *
  * @param assoc The form post values
  */

  public function storeFormValues ( $params ) {

    // Store all the parameters
    $this->__construct( $params );

    // Parse and store the publication date
    if ( isset($params['dueDate']) ) {
      $dueDate = explode ( '-', $params['dueDate'] );

      if ( count($dueDate) == 3 ) {
        list ( $y, $m, $d ) = $dueDate;
        $this->dueDate = mktime ( 0, 0, 0, $m, $d, $y );
      }
    }
  }


  /**
  * Returns an Assignment object matching the given assignment ID
  *
  * @param int The assignment ID
  * @return Assignment|false The assignment object, or false if the record was not found or there was a problem
  */

  public static function getById( $id ) {
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "SELECT *, UNIX_TIMESTAMP(dueDate) AS dueDate FROM assignments WHERE id = :id";
    $st = $conn->prepare( $sql );
    $st->bindValue( ":id", $id, PDO::PARAM_INT );
    $st->execute();
    $row = $st->fetch();
    $conn = null;
    if ( $row ) return new Assignment( $row );
  }


  /**
  * Returns all (or a range of) Assignment objects in the DB
  *
  * @param int Optional The number of rows to return (default=all)
  * @param string Optional column by which to order the assignments (default="dueDate DESC")
  * @return Array|false A two-element array : results => array, a list of Assignment objects; totalRows => Total number of assignments
  */

  public static function getList( $numRows=1000000, $order="dueDate DESC" ) {
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "SELECT SQL_CALC_FOUND_ROWS *, UNIX_TIMESTAMP(dueDate) AS dueDate FROM assignments
            ORDER BY " . $order . " LIMIT :numRows";

    $st = $conn->prepare( $sql );
    $st->bindValue( ":numRows", $numRows, PDO::PARAM_INT );
    $st->execute();
    $list = array();

    while ( $row = $st->fetch() ) {
      $assignment = new Assignment( $row );
      $list[] = $assignment;
    }

    // Now get the total number of assignments that matched the criteria
    $sql = "SELECT FOUND_ROWS() AS totalRows";
    $totalRows = $conn->query( $sql )->fetch();
    $conn = null;
    return ( array ( "results" => $list, "totalRows" => $totalRows[0] ) );
  }


  /**
  * Inserts the current Assignment object into the database, and sets its ID property.
  */

  public function insert() {

    // Does the Assignment object already have an ID?
    if ( !is_null( $this->id ) ) trigger_error ( "Assignment::insert(): Attempt to insert an Assignment object that already has its ID property set (to $this->id).", E_USER_ERROR );

    // Insert the Assignment
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "INSERT INTO assignments ( dueDate, title, teacherName, content, subject, class ) VALUES ( FROM_UNIXTIME(:dueDate), :title, :teacherName, :content, :subject, :class )";
    $st = $conn->prepare ( $sql );
    $st->bindValue( ":dueDate", $this->dueDate, PDO::PARAM_INT );
    $st->bindValue( ":title", $this->title, PDO::PARAM_STR );
    $st->bindValue( ":teacherName", $this->teacherName, PDO::PARAM_STR );
    $st->bindValue( ":content", $this->content, PDO::PARAM_STR );
    $st->bindValue( ":subject", $this->subject, PDO::PARAM_STR );   
    $st->bindValue( ":class", $this->class, PDO::PARAM_INT );
    $st->execute();
    $this->id = $conn->lastInsertId();
    $conn = null;
  }


  /**
  * Updates the current Assignment object in the database.
  */

  public function update() {

    // Does the Assignment object have an ID?
    if ( is_null( $this->id ) ) trigger_error ( "Assignment::update(): Attempt to update an Assignment object that does not have its ID property set.", E_USER_ERROR );
   
    // Update the Assignment
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $sql = "UPDATE assignments SET dueDate=FROM_UNIXTIME(:dueDate), title=:title, teacherName=:teacherName, content=:content, subject=:subject, class=:class WHERE id = :id";
    $st = $conn->prepare ( $sql );
    $st->bindValue( ":dueDate", $this->dueDate, PDO::PARAM_INT );
    $st->bindValue( ":title", $this->title, PDO::PARAM_STR );
    $st->bindValue( ":teacherName", $this->teacherName, PDO::PARAM_STR );
    $st->bindValue( ":content", $this->content, PDO::PARAM_STR );
    $st->bindValue( ":subject", $this->subject, PDO::PARAM_STR );
    $st->bindValue( ":id", $this->id, PDO::PARAM_INT );
    $st->bindValue( ":class", $this->class, PDO::PARAM_INT );
    $st->execute();
    $conn = null;
  }


  /**
  * Deletes the current Assignment object from the database.
  */

  public function delete() {

    // Does the Assignment object have an ID?
    if ( is_null( $this->id ) ) trigger_error ( "Assignment::delete(): Attempt to delete an Assignment object that does not have its ID property set.", E_USER_ERROR );

    // Delete the Assignment
    $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    $st = $conn->prepare ( "DELETE FROM assignments WHERE id = :id LIMIT 1" );
    $st->bindValue( ":id", $this->id, PDO::PARAM_INT );
    $st->execute();
    $conn = null;
  }

}

?>
