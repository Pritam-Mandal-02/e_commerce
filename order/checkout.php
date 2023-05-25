<?php require_once "../partials/navbar.php" ?>
<?php
if (!isset($_SESSION['user_detail']) || !$_SESSION['user_detail']['is_authenticated']) {
  header("Location:../home/index.php");
  exit;
} else if (isset($_SESSION['user_detail']) && $_SESSION['user_detail']['is_authenticated'] && $_SESSION['user_detail']['role'] == 1) {
  header("Location:../product/product_list.php");
  exit;
} else {
  $user_id = $_SESSION['user_detail']['user_id'];
}
?>
<?php require_once "../helpers/helper.php" ?>
<?php
$connection = connect_with_mysql();

$cart_list_query = "SELECT * FROM products JOIN cart ON cart.product_id = products.id WHERE user_id='$user_id'";
$cart_list = mysqli_query($connection, $cart_list_query);

if (!$cart_list) {
  die('Something went wrong' . mysqli_error($connection));
} else {
  $query_prefix = "INSERT INTO orders (user_id,product_id,quantity,price) VALUES ";

  $query_body = "";
  while ($row = mysqli_fetch_assoc($cart_list)) {
    $product_id = $row['product_id'];
    $quantity = $row['quantity'];
    $price = $row['price'];
    $query_body .= "('$user_id','$product_id','$quantity','$price'),";
  }

  $order_query = $query_prefix . rtrim($query_body, ",");
  $order_result = mysqli_query($connection, $order_query);

  if (!$order_result) {
    die('Something went wrong' . mysqli_error($connection));
  } else {
    $cart_clear_query = "DELETE FROM cart WHERE user_id='$user_id'";
    $cart_result = mysqli_query($connection, $cart_clear_query);

    if (!$cart_result) {
      die('Something went wrong' . mysqli_error($connection));
    } else {
      header("Location: ./order_list.php");
      exit;
    }
  }
}
?>
