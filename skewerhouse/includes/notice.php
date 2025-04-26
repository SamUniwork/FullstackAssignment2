<?php
if ( isset( $_GET['message'] ) && !empty( $_GET['message'] ) ) {
  $message = base64_decode( urldecode( $_GET['message'] ) );
  $message = explode( ':', $message );
  if ( $message[0] === 'success' ) {
    echo "<div class='alert alert-success'>{$message[1]}</div>";
  } else if( $message[0] === 'error' ) {
    echo "<div class='alert alert-danger'>{$message[1]}</div>";
  }
}
?>