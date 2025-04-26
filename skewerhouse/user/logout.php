<?php
session_start();
$_SESSION = array();
session_destroy();
header( 'Location: login.php?message=' . urlencode( base64_encode( 'success:You have logged out!' ) ) );
exit;
?>
