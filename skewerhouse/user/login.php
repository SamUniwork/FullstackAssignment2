<?php
include_once '../config/dbconfig.php';

if ( isset( $_SESSION['loggedin'] ) && $_SESSION['loggedin'] !== false ) {
  header( 'Location: profile.php?message=' . urlencode( base64_encode( 'error:You are already logged in.' ) ) );
  exit;
}

if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
  $username = trim( $_POST['username'] );
  $password = trim( $_POST['password'] );

  $sql = 'SELECT id, username, password FROM users WHERE username = ?';
  $stmt = $conn->prepare( $sql );
  $stmt->bind_param( 's', $username );
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows === 1) {
    $stmt->bind_result( $id, $db_username, $hashed_password );
    $stmt->fetch();

    if ( password_verify( $password, $hashed_password ) ) {
      // Password is correct; start a session.
      $_SESSION['loggedin'] = true;
      $_SESSION['id'] = $id;
      $_SESSION['username'] = $db_username;
      header( 'Location: profile.php?message=' . urlencode( base64_encode( "success:Welcome back, {$db_username}!" ) ) );
      exit;
    } else {
      header( 'Location: login.php?message=' . urlencode( base64_encode( 'error:Invalid password.') ) );
      exit;
    }
  } else {
    header( 'Location: login.php?message=' . urlencode( base64_encode( 'error:No account found with that username.') ) );
    exit;
  }
}
?>

<?php $pageTitle = 'Login'; include_once '../includes/header.php'; ?>
<div class="container mt-5">
  <h2>Login</h2>
  <?php include_once '../includes/notice.php'; ?>
  <form action="login.php" method="POST">
    <div class="form-group">
      <label>Username:</label>
      <input type="text" name="username" class="form-control" required>
    </div>
    <div class="form-group">
      <label>Password:</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Login</button>
  </form>
</div>
</body>
</html>
<?php include_once '../includes/footer.php'; ?>
