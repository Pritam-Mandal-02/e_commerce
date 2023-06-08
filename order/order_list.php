<?php
$page_name = "My Orders";
require_once("../partials/navbar.php") ?>
<?php require_once("../helper.php");
with_user();
$user_id = $_SESSION['user_detail']['user_id'];
?>
<?php require_once("../database/db_connect.php") ?>
<?php
$limit = 6;
$page_num = 1;
$offset = 0;

if (isset($_GET['page_num'])) {
  $page_num = $_GET['page_num'];
  $offset = ($page_num * $limit) - $limit;
}

$connection = connect_with_mysql();

$order_length_query = "SELECT * FROM orders WHERE user_id='$user_id'";
$order_length = mysqli_query($connection, $order_length_query);

if (!$order_length) {
  die('Something went wrong' . mysqli_error($connection));
} else {
  $total_record = $order_length->num_rows;
  $page = ceil($total_record / $limit);

  $order_list_query = "SELECT * FROM products  
  JOIN orders ON orders.product_id = products.id
  WHERE user_id='$user_id' ORDER BY orders.id DESC LIMIT $limit OFFSET $offset";
  $order_list = mysqli_query($connection, $order_list_query);

  if (!$order_list) {
    die('Something went wrong' . mysqli_error($connection));
  } 
}
?>

<head>
  <script>
    function handle_receipt(id) {
      $.ajax({
        url: `download_receipt.php?id=${id}`,
        success: function() {
          // $('#result').html(response);
        }
      });
    }
  </script>
</head>

<body>
  <div class="container">
    <h4>My Orders</h4>
    <div class="row">
      <?php
      while ($row = mysqli_fetch_assoc($order_list)) {
        $image = "../uploads/" . $row['image'];
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
                    <i class="fa-solid fa-receipt" style="color:blue" onclick=" handle_receipt('<?= $row['id'] ?>')"></i>
                    <a href="../home/product_detail.php?id=<?= $row['product_id'] ?>" target="_blank" style="text-decoration:none;color:black;"><?= $row['name'] ?></a>
                  </h5>
                  <p class="card-text"><?= substr($row['description'], 0, 50) . "..." ?></p>
                  <?php if ($row['quantity'] > 1) { ?>
                    <p class="card-text"><small class="text-body-secondary">₹<?= $row['price'] ?>(<?= $row['price'] * $row['quantity'] ?>)/- <?= $row['quantity'] ?> Item</small></p>
                  <?php } else { ?>
                    <p class="card-text"><small class="text-body-secondary">₹<?= $row['price'] ?>/- <?= $row['quantity'] ?> Item</small></p>
                  <?php } ?>
                  <p class="card-text"><small class="text-body-secondary"><?= date_format(date_create($row['date']), "d M, Y") ?></small></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
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
    </div>
  </div>
  </div>
</body>

<?php require_once("../partials/footer.php") ?>