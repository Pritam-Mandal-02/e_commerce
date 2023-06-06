<?php
$page_name = "Logout";
require_once("../partials/navbar.php") ?>
<?php
if (!isset($_SESSION['user_detail']) || !$_SESSION['user_detail']['is_authenticated']) {
  header("Location:../home/index.php");
  exit;
}
?>
<?php
session_destroy();
header("Location:../home/index.php");
exit;
?>
