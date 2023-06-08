<?php
$page_name = "Add to Cart";
require_once("../partials/navbar.php") ?>
<?php require_once("../helper.php");
with_user();
$user_id = $_SESSION['user_detail']['user_id'];
?>
<?php require_once("../database/db_connect.php") ?>
<?php
if (isset($_GET['id'])) {
  $connection = connect_with_mysql();
  $product_id = $_GET['id'];

  $cart_detail_query = "SELECT * FROM CART WHERE user_id='$user_id' and product_id='$product_id'";
  $cart_detail_result = mysqli_query($connection, $cart_detail_query);

  if (!$cart_detail_result->num_rows) {
    $quantity = 1;
    $add_to_cart_query = "INSERT INTO CART (user_id,product_id,quantity) VALUES ('$user_id','$product_id','$quantity')";
    $add_to_cart_result = mysqli_query($connection, $add_to_cart_query);

    if ($add_to_cart_result) {
      echo '<script>alert("Product added to cart.")</script>';
      header("Location:../home/index.php");
      exit;
    } else {
      die('Something went wrong!' . mysqli_error($connection));
    }
  } else {
    $cart_detail_result = mysqli_fetch_assoc($cart_detail_result);
    $quantity = $cart_detail_result['quantity'] + 1;

    $update_to_cart_query = "UPDATE CART SET quantity='$quantity' WHERE user_id='$user_id' and product_id='$product_id'";
    $update_to_cart_result = mysqli_query($connection, $update_to_cart_query);

    if ($update_to_cart_result) {
      echo '<script>alert("Product added to cart.")</script>';
      header("Location:../home/index.php");
      exit;
    } else {
      die('Something went wrong!' . mysqli_error($connection));
    }
  }
}
?>
