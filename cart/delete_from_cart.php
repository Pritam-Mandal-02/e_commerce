<?php
$page_name = "Delete from Cart";
require_once("../partials/navbar.php") ?>
<?php
if (!isset($_SESSION['user_detail']) || !$_SESSION['user_detail']['is_authenticated']) {
  header("Location:../home/index.php");
  exit;
} else if (isset($_SESSION['user_detail']) && $_SESSION['user_detail']['is_authenticated'] && $_SESSION['user_detail']['role'] == 1) {
  header("Location:../product/product_list.php");
  exit;
}
?>
<?php require_once "../database/db_connect.php" ?>
<?php
$connection = connect_with_mysql();
$query_prefix = "DELETE FROM cart ";

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $query_body = "WHERE id='$id'";
} else if (isset($_GET['user_id'])) {
  $user_id = $_GET['user_id'];
  $query_body = "WHERE user_id='$user_id'";
}

$query = $query_prefix . $query_body;
$result = mysqli_query($connection, $query);

if (!$result) {
  die('Something went wrong' . mysqli_error($connection));
}
?>
