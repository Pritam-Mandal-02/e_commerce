<?php
$page_name = "Delete Product";
require_once("../partials/navbar.php") ?>
<?php
if (!isset($_SESSION['user_detail']) || !$_SESSION['user_detail']['is_authenticated'] || $_SESSION['user_detail']['role'] != 1) {
  header("Location:../home/index.php");
  exit;
}
?>
<?php require_once "../database/db_connect.php" ?>
<?php
$connection = connect_with_mysql();

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $image = $_GET['image'];
}

$query = "DELETE FROM PRODUCTS ";
$query .= "WHERE id='$id'";

$result = mysqli_query($connection, $query);

if (!$result) {
  die('Something went wrong' . mysqli_error($connection));
} else {
  unlink($image);
}
?>
