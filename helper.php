<?php
function except_admin()
{
  if (isset($_SESSION['user_detail']) && $_SESSION['user_detail']['is_authenticated'] && $_SESSION['user_detail']['role'] == 1) {
    header("Location:../product/product_list.php");
    exit;
  }
}

function with_user()
{
  if (!isset($_SESSION['user_detail']) || !$_SESSION['user_detail']['is_authenticated']) {
    header("Location:../auth/login.php");
    exit;
  } else if (isset($_SESSION['user_detail']) && $_SESSION['user_detail']['is_authenticated'] && $_SESSION['user_detail']['role'] == 1) {
    header("Location:../product/product_list.php");
    exit;
  }
}

function with_admin()
{
  if (!isset($_SESSION['user_detail']) || !$_SESSION['user_detail']['is_authenticated'] || $_SESSION['user_detail']['role'] != 1) {
    header("Location:../home/index.php");
    exit;
  }
}
