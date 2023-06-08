<?php
$page_name = "Logout";
require_once("../partials/navbar.php") ?>
<?php
session_destroy();
header("Location:../home/index.php");
exit;
?>
