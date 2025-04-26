<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php if ( isset( $pageTitle ) ) { echo $pageTitle . ' - '; } ?>Skewer House</title>
  <!-- Blink rel="stylesheet" href="assets/css/style.css">ootstrap CSS for mobile-first responsive design -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="/index.php">Skewer House</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
    <span class="navbar-toggler-icon"></span>
  </button>
 
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item"><a class="nav-link" href="/index.php">Home</a></li>
      <li class="nav-item"><a class="nav-link" href="/menu/view_menu.php">Menu</a></li>
      <li class="nav-item"><a class="nav-link" href="/booking/book_table.php">Book a Table</a></li>
      <li class="nav-item"><a class="nav-link" href="/booking/order_takeaway.php">Take away order</a></li>
      <li class="nav-item"><a class="nav-link" href="/review/view_reviews.php">Reviews</a></li>
      </ul>
      <ul class="navbar-nav">
      <?php if ( isset( $_SESSION['loggedin'] ) && $_SESSION['loggedin'] === true ): ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" id="profileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Welcome, <?php echo htmlspecialchars( $_SESSION['username'] ); ?>!
          </a>
          <div class="dropdown-menu" aria-labelledby="profileDropdown">
              <a class="dropdown-item" href="/user/profile.php">Manage Profile</a>
              <a class="dropdown-item" href="/user/logout.php">Logout</a>
          </div>
        </li>
      <?php else: ?>
        <li class="nav-item"><a class="nav-link" href="/user/login.php">Login</a></li>
        <li class="nav-item"><a class="nav-link" href="/user/register.php">Register</a></li>
      <?php endif; ?>
    </ul>
  </div>
</nav>
