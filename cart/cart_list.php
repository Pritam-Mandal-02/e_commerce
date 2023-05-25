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
$limit = 6;
$page_num = 1;
$offset = 0;

if (isset($_GET['page_num'])) {
  $page_num = $_GET['page_num'];
  $offset = ($page_num * $limit) - $limit;
}

$cart_item = 0;
$connection = connect_with_mysql();

$cart_length_query = "SELECT * FROM cart WHERE user_id='$user_id'";
$cart_length = mysqli_query($connection, $cart_length_query);

if (!$cart_length) {
  die('Something went wrong' . mysqli_error($connection));
} else {
  $total_record = $cart_length->num_rows;
  $page = ceil($total_record / $limit);

  $cart_list_query = "SELECT * FROM products  
  JOIN cart ON cart.product_id = products.id
  WHERE user_id='$user_id' ORDER BY cart.id DESC LIMIT $limit OFFSET $offset";
  $cart_list = mysqli_query($connection, $cart_list_query);

  if (!$cart_list) {
    die('Something went wrong' . mysqli_error($connection));
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Cart</title>
  <script>
    function handle_destroy(id) {
      if (confirm("Are you sure?")) {
        $.ajax({
          url: `delete_from_cart.php?id=${id}`,
          success: function() {
            location.reload();
            // $('#result').html(response);
          }
        });
      }
    }

    function handle_update(id, quantity) {
      if (quantity <= 0) {
        handle_destroy(id);
        return;
      }

      $.ajax({
        url: `update_in_cart.php?id=${id}&quantity=${quantity}`,
        success: function() {
          location.reload();
          // $('#result').html(response);
        }
      });
    }
  </script>
</head>

<body>
  <div class="container">
    <h4>My Cart</h4>
    <div class="row">
      <?php
      while ($row = mysqli_fetch_assoc($cart_list)) {
        $image = "../uploads/" . $row['image'];
        $cart_item += $row['quantity'];
      ?>
        <div class="col">
          <div class="card mb-3" style="width: 300px;">
            <div class="row g-0">
              <div class="col-md-4">
                <img src=<?= $image ?> class="img-fluid rounded-start" alt=<?= $row['name'] ?>>
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h5 class="card-title">
                    <button class="btn btn-outline-danger" onclick=" handle_destroy('<?= $row['id'] ?>')">Delete</button>
                    <?= $row['name'] ?>
                  </h5>
                  <p class="card-text"><?= substr($row['description'], 0, 50) . "..." ?></p>
                  <p class="card-text"><small class="text-body-secondary">₹<?= $row['price'] ?>/-</small></p>
                  <p class="card-text">
                    <button class="btn btn-outline-primary" onclick="handle_update('<?= $row['id'] ?>','<?= $row['quantity'] - 1 ?>')">-</button>
                    <?= $row['quantity'] ?>
                    <button class="btn btn-outline-primary" onclick="handle_update('<?= $row['id'] ?>','<?= $row['quantity'] + 1 ?>')">+</button>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php }
      $_SESSION['cart_item'] = $cart_item;
      // echo $cart_item;
      ?>
      <?php if ($page > 1) { ?>
        <nav aria-label="Page navigation example">
          <ul class="pagination justify-content-center">
            <li class="page-item <?php if ($page_num <= 1) { ?>disabled<?php } ?>">
              <a class="page-link" href="?page_num=<?= $page_num - 1 ?>">Previous</a>
            </li>
            <?php $i = 1;
            while ($i <= $page) { ?>
              <li class="page-item <?php if ($page_num == $i) { ?>active<?php } ?>"><a class="page-link" href="?page_num=<?= $i ?>"><?= $i ?></a></li>
            <?php $i++;
            } ?>
            <li class="page-item <?php if ($page_num >= $page) { ?>disabled<?php } ?>">
              <a class="page-link" href="?page_num=<?= $page_num + 1 ?>">Next</a>
            </li>
          </ul>
        </nav>
      <?php } ?>
      <?php
      if ($cart_length->num_rows) { ?>
        <a class="btn btn-primary" href="../order/checkout.php">Place order</a>
      <?php } ?>
    </div>
  </div>
  </div>

</body>

</html>