<?php
$page_name = "Product List";
require_once("../partials/navbar.php") ?>
<?php
if (!isset($_SESSION['user_detail']) || !$_SESSION['user_detail']['is_authenticated'] || $_SESSION['user_detail']['role'] != 1) {
  header("Location:../home/index.php");
  exit;
}
?>
<?php require_once "../database/db_connect.php" ?>
<?php
$limit = 3;
if (isset($_GET['page_num'])) {
  $page_num = $_GET['page_num'];
  $offset = ($page_num * $limit) - $limit;
} else {
  $page_num = 1;
  $offset = 0;
}

$connection = connect_with_mysql();

$product_length_query = "SELECT * FROM PRODUCTS";
$product_length_result = mysqli_query($connection, $product_length_query);

if (!$product_length_result) {
  die('Something went wrong' . mysqli_error($connection));
} else {
  $total_record = $product_length_result->num_rows;
  $page = ceil($total_record / $limit);

  $product_data_query = "SELECT * FROM PRODUCTS ORDER BY id DESC LIMIT $limit OFFSET $offset";
  $product_data_result = mysqli_query($connection, $product_data_query);

  if (!$product_data_result) {
    die('Something went wrong' . mysqli_error($connection));
  }
}
?>

<head>
  <script>
    function handle_destroy(id, image) {
      if (confirm("Are you sure?")) {
        $.ajax({
          url: `delete_product.php?id=${id}&image=${image}`,
          success: function() {
            location.reload();
          }
        });
      }
    }
  </script>
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col">
        <h4>Product List</h4>
      </div>
      <div class="col d-flex justify-content-end">
        <a class="btn btn-primary btn-lg" href="./add_product.php">Add Product</a>
      </div>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">Description</th>
          <th scope="col">Image</th>
          <th scope="col">Price(₹)</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $i = $offset + 1;
        while ($row = mysqli_fetch_assoc($product_data_result)) {
          $image = "../uploads/" . $row['image'];
        ?>
          <tr>
            <th scope='row'><?= $i ?></th>
            <td><?= $row['name'] ?></td>
            <td><?= $row['description'] ?></td>
            <td>
              <image src='<?= $image ?>' width='100' height='100' />
            </td>
            <td><?= $row['price'] ?></td>
            <td><a class='btn btn-warning' href="./edit_product.php?id=<?= $row['id'] ?>">Edit</a></td>
            <td><button id="d" class='btn btn-danger' onclick="handle_destroy('<?= $row['id'] ?>','<?= $image ?>')">Delete</button></td>
          </tr>
        <?php $i++;
        } ?>
      </tbody>
    </table>
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
</body>

</html>