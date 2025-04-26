<?php
include_once '../config/dbconfig.php';

$search_term = '';
if( isset( $_GET['search'] ) ) {
  $search_term = trim( $_GET['search'] );

  $stmt = $conn->prepare( 'SELECT * FROM menus WHERE item_name LIKE CONCAT('%', ?, '%') OR description LIKE CONCAT('%', ?, '%')' );
  $stmt->bind_param( 'ss', $search_term, $search_term );
  $stmt->execute();
  $result = $stmt->get_result();
} else {
  $result = $conn->query( 'SELECT * FROM menus' );
}
?>

<?php $pageTitle = 'Search Menu'; include_once '../includes/header.php'; ?>
<div class="container mt-5">
  <h2>Search Our Menu</h2>
  <?php include_once '../includes/notice.php'; ?>
  <form method="GET" action="search_menu.php" class="form-inline mb-4">
    <input type="text" name="search" value="<?php echo htmlspecialchars( $search_term ); ?>" class="form-control mr-2" placeholder="Search menu...">
    <button type="submit" class="btn btn-primary">Search</button>
  </form>
  <div class="row">
    <?php if( $result && $result->num_rows > 0 ): ?>
      <?php while( $row = $result->fetch_assoc() ): ?>
        <div class="col-md-4">
          <div class="card mb-4">
            <?php if( !empty( $row['image'] ) ): ?>
              <img src="../assets/images/<?php echo htmlspecialchars( $row['image'] ); ?>" class="card-img-top" alt="<?php echo htmlspecialchars( $row['item_name'] ); ?>">
            <?php endif; ?>
            <div class="card-body">
              <h5 class="card-title"><?php echo htmlspecialchars( $row['item_name'] ); ?></h5>
              <p class="card-text"><?php echo htmlspecialchars( $row['description'] ); ?></p>
              <p class="card-text"><strong>Price: £<?php echo number_format( $row['price'], 2 ); ?></strong></p>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p>No results found for your search.</p>
    <?php endif; ?>
  </div>
</div>
<?php include_once '../includes/footer.php'; ?>