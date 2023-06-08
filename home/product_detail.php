<?php
$page_name = "Product Detail";
require_once("../partials/navbar.php") ?>
<?php require_once("../helper.php");
except_admin();
?>
<?php require_once("../database/db_connect.php") ?>
<?php

if (isset($_GET['id'])) {
  $id = $_GET['id'];
}

$connection = connect_with_mysql();
$product_detail_query = "SELECT * FROM products WHERE id='$id'";
$product_detail = mysqli_query($connection, $product_detail_query);

if (!$product_detail) {
  die('Something went wrong' . mysqli_error($connection));
} else {
  $row = mysqli_fetch_assoc($product_detail);
  $name = $row['name'];
  $category_id = $row['category_id'];
  $description = $row['description'];
  $image_url = "../uploads/" . $row['image'];
  $price = $row['price'];
}
?>

<head>
  <script>
    function handleAddToCart(id) {
      $.ajax({
        url: `../cart/add_to_cart.php?id=${id}`,
        success: function(response) {
          // $('#result').html(response);
        }
      });
    }
  </script>
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col">
        <h4>Product Detail</h4>
      </div>
      <div class="col d-flex justify-content-end">
        <button class="btn btn-primary btn-lg" onclick="handleAddToCart(<?= $row['id'] ?>)">Add to cart</button>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-4">
        <label for="name" class="form-label">Name :</label>
      </div>
      <div class="col-sm-8">
        <label for="name_value" class="form-label"><?php echo $name ?></label>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-4">
        <label for="category" class="form-label">Category :</label>
      </div>
      <div class="col-sm-8">
        <label for="category_value" class="form-label">
          <?php foreach ($category_list as $id => $name) {
            if ($category_id == $id) echo $name;
          } ?>
        </label>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-4">
        <label for="description" class="form-label">Description :</label>
      </div>
      <div class="col-sm-8">
        <label for="description_value" class="form-label"><?php echo $description ?></label>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-4">
        <label for="image" class="form-label">Image :</label>
      </div>
      <div class="col-sm-8">
        <image src="<?php echo $image_url ?>" width='200' height='200' />
      </div>
    </div>
    <div class="row">
      <div class="col-sm-4">
        <label for="price" class="form-label">Price :</label>
      </div>
      <div class="col-sm-8">
        <label for="price_value" class="form-label">₹ <?php echo $price ?>/-</label>
      </div>
    </div>
  </div>
</body>

<?php require_once("../partials/footer.php") ?>