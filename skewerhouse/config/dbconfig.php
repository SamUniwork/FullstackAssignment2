<?php
// Start the session if it hasn't been started already.
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Error handling!
error_reporting( E_ALL );
function exceptionHandler( $e ) {
  error_log( $e );
  if ( filter_var( ini_get( 'display_errors' ), FILTER_VALIDATE_BOOLEAN ) ) {
    echo $e;
  } else {
    echo '<h1>500 Internal Server Error</h1>';
    echo '<p>An error occurred. Please try again later.</p>';
    http_response_code( 500 );
  }
}
set_exception_handler( 'exceptionHandler' );

set_error_handler( function( $level, $message, $file = '', $lineno = 0 ) {
  if ( !error_reporting() & $level ) {
      // This error code is not included in error_reporting.
      return;
  }

  if ( $level === E_DEPRECATED || $level === E_USER_DEPRECATED ) {
    // Do not throw an exception for deprecation warnings as new or unexpected
    // deprecations would break applications.
    return;
  }

  throw new \ErrorException( $message, 0, $level, $file, $lineno );
} );

register_shutdown_function( function() {
  $error = error_get_last();
  if ( $error !== null ) {
    $e = new ErrorException(
      $error['message'], 0, $error['type'], $error['file'], $error['line']
    );
    exceptionHandler( $e );
  }
} );

// Database connection settings
$servername = 'localhost';
$username = 'root';
$password = ''; // Adjust if using a different password
$dbname = 'skewer_house';

// Create connection using MySQLi
$conn = new mysqli( $servername, $username, $password, $dbname );

// Check connection
if ( $conn->connect_error ) {
    die( 'Connection failed: ' . $conn->connect_error );
}
?>
