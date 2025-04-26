<?php
include_once '../config/dbconfig.php';

// Ensure only logged in users can submit reviews
if ( !isset( $_SESSION['loggedin'] ) || $_SESSION[ 'loggedin' ] !== true ) {
  header( 'Location: ../user/login.php' );
  exit;
}

if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
  $reviewText = trim( $_POST['review_text'] );
  $rating = intval( $_POST['rating'] );
  $userId = $_SESSION["id"];

  // Safe-guard against the form being modified in the browser.
  if ($rating === 0) {
    header( 'Location: add_review.php?message=' . urlencode( base64_encode( 'error:Invalid rating.' ) ) );
    exit;
  }

  $sql = 'INSERT INTO reviews (user_id, review_text, rating) VALUES (?, ?, ?)';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("isi", $userId, $reviewText, $rating);
  $stmt->execute();
  header( 'Location: view_reviews.php?message=' . urlencode( base64_encode( 'success:Review submitted successfully.' ) ) );
  exit;
}
?>

<?php $pageTitle = 'Add Review'; include_once '../includes/header.php'; ?>
<div class="container mt-5">
  <h2>Submit Your Review</h2>
  <?php include_once '../includes/notice.php'; ?>
  <form method="POST" action="add_review.php">
    <div class="form-group">
      <label>Your Review:</label>
      <textarea name="review_text" class="form-control" required></textarea>
    </div>
    <div class="form-group">
      <label>Rating (1-5):</label>
      <input type="number" name="rating" class="form-control" min="1" max="5" required>
    </div>
    <button type="submit" class="btn btn-primary">Submit Review</button>
  </form>
</div>
<?php include_once '../includes/footer.php'; ?>
