<?php
include_once '../config/dbconfig.php';

// Ensure user is logged in
if ( !isset( $_SESSION['loggedin'] ) || $_SESSION['loggedin'] !== true ) {
  header( 'Location: ../user/login.php' );
  exit;
}

if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
  $bookingDate = trim( $_POST['booking_date'] );
  $details = trim( $_POST['details'] );
  $userId = $_SESSION['id'];
  // 'table' indicates a table booking
  $bookingType = 'table';

  $sql = 'INSERT INTO bookings (user_id, booking_date, booking_type, details) VALUES (?, ?, ?, ?)';
  $stmt = $conn->prepare( $sql );
  $stmt->bind_param( 'isss', $userId, $bookingDate, $bookingType, $details );
  $stmt->execute();
  header( 'Location: book_table.php?message=' . urlencode( base64_encode( 'success:Table booking successful!' ) ) );
  exit;
}
?>

<?php $pageTitle = "Book a Table"; include_once '../includes/header.php'; ?>
<div class="container mt-5">
  <h2>Book a Table</h2>
  <?php include_once '../includes/notice.php'; ?>
  <form method="POST" action="book_table.php">
    <div class="form-group">
      <label>Booking Date & Time:</label>
      <input type="datetime-local" name="booking_date" class="form-control" required>
    </div>
    <div class="form-group">
      <label>Additional Details (if any):</label>
      <textarea name="details" class="form-control"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Book Table</button>
  </form>
</div>
<?php include_once '../includes/footer.php'; ?>