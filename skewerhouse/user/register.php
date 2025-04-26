<?php
include_once '../config/dbconfig.php';

if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
  // Sanitize and validate input (further validation is recommended)
  $username = trim( $_POST['username'] );
  $email = trim( $_POST['email'] );

  // Check if email already exists?
  $sql = 'SELECT COUNT(1) AS total FROM users WHERE email = ?';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param( 's', $email );
  $stmt->execute();
  $stmt->bind_result($total);
  $stmt->fetch();
  $stmt->close();

  if ($total > 0) {
    header( 'Location: register.php?message=' . urlencode( base64_encode( 'error:Email already exists, please use a different one.') ) );
    exit;
  }

  // Hash password & insert user into database.
  $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

  $sql = 'INSERT INTO users (username, email, password) VALUES (?, ?, ?)';
  $stmt = $conn->prepare( $sql );
  $stmt->bind_param( 'sss', $username, $email, $password );
  $stmt->execute();
  header( 'Location: login.php?message=' . urlencode( base64_encode( 'success:Registration successful, please login.') ) );
  exit;
}
?>

<?php $pageTitle = 'Register'; include_once '../includes/header.php'; ?>
<div class="container mt-5">
  <h2>Create an Account</h2>
  <?php include_once '../includes/notice.php'; ?>
  <form action="register.php" method="POST">
    <div class="form-group">
      <label>Username:</label>
      <input type="text" name="username" class="form-control" required>
    </div>
    <div class="form-group">
      <label>Email:</label>
      <input type="email" name="email" class="form-control" required>
    </div>
    <div class="form-group">
      <label>Password:</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Register</button>
  </form>
</div>
<?php include_once '../includes/footer.php'; ?>
