<?php
$page_name = "Edit Product";
require_once("../partials/navbar.php") ?>
<?php require_once("../helper.php");
with_admin();
?>
<?php require_once("../database/db_connect.php") ?>
<?php
$connection = connect_with_mysql();

if (isset($_GET['id'])) {
  $id = $_GET['id'];
}

$product_detail_query = "SELECT * FROM PRODUCTS ";
$product_detail_query .= "WHERE id='$id'";

$product_detail_result = mysqli_query($connection, $product_detail_query);

if ($product_detail_result) {
  $data = mysqli_fetch_assoc($product_detail_result);
  $name = $data['name'];
  $category_id = $data['category_id'];
  $description = $data['description'];
  $old_image_url = "../uploads/" . $data['image'];
  $old_image_name = $data['image'];
  $price = $data['price'];
} else {
  die("Something went wrong!");
}

if (isset($_POST['edit_product'])) {

  $name = $_POST['name'];
  $category_id = $_POST['category_id'];
  $description = $_POST['description'];
  $price = $_POST['price'];

  $new_image = $_FILES['image'];
  $file_name = $new_image['name'];
  $tmp_file_path = $new_image['tmp_name'];
  $upload_dir = '../uploads/';
  $file_ext = explode(".", $file_name);
  $unique_file_name = uniqid() . '.' . end($file_ext);
  $file_path = $upload_dir . $unique_file_name;

  // var_dump($tmp_file_path,$file_path);
  if (!move_uploaded_file($tmp_file_path, $file_path)) {
    $unique_file_name = $old_image_name;
    $old_image_url = "";
  }

  $product_update_query = "UPDATE PRODUCTS SET name='$name',category_id='$category_id',description='$description',image='$unique_file_name',price='$price' WHERE id='$id'";

  $product_update_result = mysqli_query($connection, $product_update_query);

  if ($product_update_result) {
    unlink($old_image_url);
    echo '<script>alert("Product updated successfully.")</script>';
    header("Location:./product_list.php");
    exit;
  } else {
    echo "<script>alert('Something went wrong!')</script>";
  }
}
?>

<body>
  <div class="container">
    <div class="row">
      <div class="col">
        <h4>Edit Product</h4>
      </div>
      <div class="col d-flex justify-content-end">
        <a class="btn btn-secondary btn-lg px-5" href="./product_list.php">Back</a>
      </div>
    </div>
    <form method="post" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" name="name" value="<?php echo $name ?>">
      </div>
      <div class="mb-3">
        <label for="category_id" class="form-label">Category</label>
        <select class="form-select" name="category_id">
          <option selected disabled>Please select</option>
          <?php foreach ($category_list as $id => $name) { ?>
            <option value="<?= $id ?>" <?php if ($category_id == $id) echo "selected" ?>><?= $name ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" rows="5" name="description"><?php echo $description ?></textarea>
      </div>
      <div class="mb-3">
        <label for="image" class="form-label">Image</label>
        <div>
          <image src="<?php echo $old_image_url ?>" width='100' height='100' />
        </div>
        <input type="file" class="form-control" name="image" accept="image/*">
      </div>
      <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="text" class="form-control" name="price" value="<?php echo $price ?>">
      </div>
      <button type="submit" name="edit_product" class="btn btn-warning btn-lg">Edit Product</button>
    </form>
  </div>
</body>

<?php require_once("../partials/footer.php") ?>