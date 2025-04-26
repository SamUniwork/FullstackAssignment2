<?php
include_once '../config/dbconfig.php';

$sql = 'SELECT * FROM menus';
$result = $conn->query( $sql );
?>

<?php $pageTitle = 'Menu'; include_once '../includes/header.php'; ?>
<div class="container mt-5">
  <h2>Our Menu</h2>
  <?php include_once '../includes/notice.php'; ?>
  <div class="row">
    <?php if( $result->num_rows > 0 ): ?>
      <?php while( $row = $result->fetch_assoc() ): ?>
        <div class="col-md-4">
          <div class="card mb-4">
            <?php if( !empty($row['image']) ): ?>
              <img src="../assets/images/<?php echo htmlspecialchars( $row['image'] ); ?>" class="card-img-top" alt="<?php echo htmlspecialchars( $row['item_name'] ); ?>">
            <?php endif; ?>

            <div class="card-body">
              <h5 class="card-title"><?php echo htmlspecialchars( $row['item_name'] ); ?></h5>
              <?php if( !empty( $row['description'] ) ): ?>
                <p class="card-text"><?php echo htmlspecialchars( $row['description'] ); ?></p>
              <?php endif; ?>
              <p class="card-text"><strong>Price: £<?php echo number_format( $row['price'], 2 ); ?></strong></p>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p>No menu items found.</p>
    <?php endif; ?>
  </div>
</div>
<?php include_once '../includes/footer.php'; ?>
