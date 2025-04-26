<?php
include_once '../config/dbconfig.php';

$sql = 'SELECT reviews.review_text, reviews.rating, reviews.created_at, users.username 
        FROM reviews 
        INNER JOIN users ON reviews.user_id = users.id 
        ORDER BY reviews.created_at DESC';
$result = $conn->query( $sql );
?>

<?php $pageTitle = 'Reviews'; include_once '../includes/header.php'; ?>
<div class="container mt-5">
  <h2>Customer Reviews</h2>
  <?php include_once '../includes/notice.php'; ?>
  <?php if ( $result->num_rows > 0 ): ?>
    <?php while ( $row = $result->fetch_assoc() ): ?>
      <div class="card mb-3">
        <div class="card-body">
          <h5 class="card-title"><?php echo htmlspecialchars( $row['username'] ); ?> (Rating: <?php echo $row['rating']; ?>/5)</h5>
          <p class="card-text"><?php echo htmlspecialchars( $row['review_text'] ); ?></p>
          <small class="text-muted"><?php echo $row['created_at']; ?></small>
        </div>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p>No reviews available.</p>
  <?php endif; ?>
  <a class="btn btn-primary" href="add_review.php">Add a Review</a>
</div>
<?php include_once '../includes/footer.php'; ?>