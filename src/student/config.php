<?php
ini_set( "display_errors", true );
date_default_timezone_set( "Asia/Kolkata" );  // http://www.php.net/manual/en/timezones.php
define( "DB_DSN", "" );
define( "DB_USERNAME", "" );
define( "DB_PASSWORD", "" );
define( "CLASS_PATH", "classes" );
define( "TEMPLATE_PATH", "templates" );
define( "HOMEPAGE_NUM_ASSIGNMENTSS", 5 );
require( CLASS_PATH . "/Assignment.php" );

function handleException( $exception ) {
  echo "Sorry, a problem occurred. Please try later.";
  error_log( $exception->getMessage() );
}

set_exception_handler( 'handleException' );
?>
