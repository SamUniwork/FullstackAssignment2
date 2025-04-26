<?php
include_once '../config/dbconfig.php';

// Ensure user is logged in
if ( !isset( $_SESSION['loggedin'] ) || $_SESSION['loggedin'] !== true ) {
  header( 'Location: ../user/login.php' );
  exit;
}

if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
  // Use current date-time as order time
  $booking_date = date( 'Y-m-d H:i:s' );
  $details = trim( $_POST['details'] );   // Order details (e.g., list of items)
  $user_id = $_SESSION['id'];
  // 'takeaway' indicates a takeaway order
  $booking_type = 'takeaway';

  $sql = 'INSERT INTO bookings (user_id, booking_date, booking_type, details) VALUES (?, ?, ?, ?)';
  $stmt = $conn->prepare( $sql );
  $stmt->bind_param( 'isss', $user_id, $booking_date, $booking_type, $details );
  $stmt->execute();

  header( 'Location: order_takeaway.php?message=' . urlencode( base64_encode( 'success:Your takeaway order has been placed!' ) ) );
  exit;
}
?>

<?php $pageTitle = 'Order Takeaway'; include_once '../includes/header.php'; ?>
<div class="container mt-5">
  <h2>Order Takeaway</h2>
  <?php include_once '../includes/notice.php'; ?>
  <form method="POST" action="order_takeaway.php">
    <div class="form-group">
      <label>Order Details:</label>
      <textarea name="details" class="form-control" placeholder="List your items here" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Place Order</button>
  </form>
</div>
<?php include_once '../includes/footer.php'; ?>