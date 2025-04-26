<?php
include_once '../config/dbconfig.php';

// Redirect to login page if not logged in
if ( !isset( $_SESSION['loggedin'] ) || $_SESSION['loggedin'] !== true ) {
  header( 'Location: login.php' );
  exit;
}

$userId = $_SESSION['id'];

// Process profile updates if submitted
if ( $_SERVER[ 'REQUEST_METHOD'] === 'POST' ) {
  $newEmail = trim( $_POST['email'] );
  $newUsername = trim( $_POST['username'] );

  // Update user details
  $sql = "UPDATE users SET username = ?, email = ? WHERE id = ?";
  $conn->prepare( $sql );
  $stmt->bind_param( 'ssi', $newUsername, $newEmail, $userId );
  $stmt->execute();

  $_SESSION[ 'username' ] = $newUsername;
  header( 'Location: profile.php?message=' . urlencode( base64_encode( 'success:Profile was updated successfully.') ) );
  exit;
}

// Retrieve the current user details
$sql = 'SELECT username, email FROM users WHERE id = ?';
$stmt = $conn->prepare( $sql );
$stmt->bind_param( 'i', $userId );
$stmt->execute();
$stmt->bind_result( $username, $email );
$stmt->fetch();
?>

<?php $pageTitle = 'Profile'; include_once '../includes/header.php'; ?>
<div class="container mt-5">
  <h2>Your Profile</h2>
  <?php include_once '../includes/notice.php'; ?>
  <form method="POST" action="profile.php">
    <div class="form-group">
      <label>Username:</label>
      <input type="text" name="username" value="<?php echo htmlspecialchars( $username ); ?>" class="form-control" required>
    </div>
    <div class="form-group">
      <label>Email:</label>
      <input type="email" name="email" value="<?php echo htmlspecialchars( $email ); ?>" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Update Profile</button>
  </form>
  <br>
  <a href="logout.php" class="btn btn-secondary">Logout</a>
</div>
<?php include_once '../includes/footer.php'; ?>
