<?php session_start();
if (isset($_SESSION['user_detail']['is_authenticated']) && $_SESSION['user_detail']['is_authenticated']) {
  $is_authenticated = true;
  $role = $_SESSION['user_detail']['role'];
  $name = $_SESSION['user_detail']['user_name'];
  $name = explode(" ", $name);
  $display_name = $name[0];
  $cart_item = $_SESSION['cart_item'];
} else {
  $is_authenticated = false;
}

$category_list =
  [1 => 'Man', 2 => 'Woman', 3 => 'Kids', 4 => 'Food', 5 => 'Electronics'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>E-Commerce</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
</head>

<body>
  <div class="container">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        <a class="navbar-brand" href="../home/index.php">E-Commerce</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <?php
          if ($is_authenticated && $role == 1) { ?>
            <div class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="../product/product_list.php">Product</a>
              </li>
            </div>
          <?php }
          if ($is_authenticated && $role == 2) { ?>
            <div class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="../order/order_list.php">Order</a>
              </li>
            </div>
          <?php } ?>
          <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
            <?php
            if ($is_authenticated && $role == 2) { ?>
              <div class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="../cart/cart_list.php">Cart<?php if ($cart_item > 0) echo $cart_item ?></a>
                </li>
              </div>
            <?php }
            if ($is_authenticated) { ?>
              <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <?= $display_name ?>
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="../auth/logout.php">Logout</a></li>
                </ul>
              </div>
            <?php } else { ?>
              <div class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="../auth/login.php">Login</a>
                </li>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </nav>
  </div>
</body>

</html>