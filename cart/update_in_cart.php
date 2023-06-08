<?php
$page_name = "Update in Cart";
require_once("../partials/navbar.php") ?>
<?php require_once("../helper.php");
with_user();
?>
<?php require_once("../database/db_connect.php") ?>
<?php
$connection = connect_with_mysql();

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $quantity = $_GET['quantity'];
}

$query = "UPDATE CART SET quantity='$quantity' WHERE id='$id'";
$result = mysqli_query($connection, $query);

if (!$result) {
  die('Something went wrong' . mysqli_error($connection));
}
?>
