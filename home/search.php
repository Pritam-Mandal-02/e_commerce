<?php require_once("../helper.php");
except_admin();
?>
<?php require_once("../database/db_connect.php") ?>
<?php
$limit = 6;
$page_num = 1;
$offset = 0;

if (!empty($_GET['limit'])) {
  $limit = $_GET['limit'];
}
if (!empty($_GET['page_num'])) {
  $page_num = $_GET['page_num'];
  $offset = ($page_num * $limit) - $limit;
}

if (!empty($_GET['name'])) {
  $name = $_GET['name'];
}
if (!empty($_GET['category'])) {
  $category = $_GET['category'];
}
if (!empty($_GET['sort'])) {
  $data = $_GET['sort'];
  $data = explode(",", $data);

  $field = $data[0];
  $sort_by = $data[1];
}

$connection = connect_with_mysql();
$query_prefix = "SELECT * FROM PRODUCTS ";

$query_body = "";
if (!empty($_GET['name']) && !empty($_GET['category'])) {
  $query_body = "WHERE name LIKE '%$name%' AND category_id='$category' ";
} else if (!empty($_GET['name'])) {
  $query_body = "WHERE name LIKE '%$name%' ";
} else if (!empty($_GET['category'])) {
  $query_body = "WHERE category_id='$category' ";
}

if (!empty($_GET['sort'])) {
  $query_suffix = "ORDER BY $field $sort_by LIMIT $limit OFFSET $offset";
} else {
  $query_suffix = "ORDER BY id DESC LIMIT $limit OFFSET $offset";
}

$product_length_query = $query_prefix . $query_body;
$product_length = mysqli_query($connection, $product_length_query);

if (!$product_length) {
  die('Something went wrong' . mysqli_error($connection));
} else {
  $total_record = $product_length->num_rows;
  $page = ceil($total_record / $limit);

  $product_list_query = $query_prefix . $query_body . $query_suffix;
  $product_list = mysqli_query($connection, $product_list_query);

  if (!$product_list) {
    die('Something went wrong' . mysqli_error($connection));
  }
}
?>

<div class="row">
  <?php
  while ($row = mysqli_fetch_assoc($product_list)) {
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
              <h5 class="card-title"><a href="product_detail.php?id=<?= $row['id'] ?>" target="_blank" style="text-decoration:none;color:black;"><?= $row['name'] ?></a></h5>
              <p class="card-text"><?= substr($row['description'], 0, 50) . "..." ?></p>
              <p class="card-text"><small class="text-body-secondary">₹<?= $row['price'] ?>/-</small></p>
              <button class="btn btn-outline-primary" onclick="handleAddToCart(<?= $row['id'] ?>)">Add to cart</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>
</div>

<?php if ($page > 1) { ?>
  <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
      <li class="page-item <?php if ($page_num <= 1) { ?>disabled<?php } ?>">
        <button class="page-link" onclick="handleSearch(<?= $page_num - 1 ?>)">Previous</button>
      </li>
      <?php $i = 1;
      while ($i <= $page) { ?>
        <li class="page-item <?php if ($page_num == $i) { ?>active<?php } ?>"><button class="page-link" onclick="handleSearch(<?= $i ?>)"><?= $i ?></button></li>
      <?php $i++;
      } ?>
      <li class="page-item <?php if ($page_num >= $page) { ?>disabled<?php } ?>">
        <button class="page-link" onclick="handleSearch(<?= $page_num + 1 ?>)">Next</button>
      </li>
    </ul>
  </nav>
<?php } ?>