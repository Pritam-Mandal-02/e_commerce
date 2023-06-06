<?php
$page_name = "Add Product";
require_once("../partials/navbar.php") ?>
<?php
if (!isset($_SESSION['user_detail']) || !$_SESSION['user_detail']['is_authenticated'] || $_SESSION['user_detail']['role'] != 1) {
  header("Location:../home/index.php");
  exit;
}
?>
<?php require_once "../database/db_connect.php" ?>
<?php
if (isset($_POST['add_product'])) {
  if (!empty($_POST['category_id'])) {
    $connection = connect_with_mysql();
    $name = $_POST['name'];
    $category_id = $_POST['category_id'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $image = $_FILES['image'];
    $file_name = $image['name'];
    $tmp_file_path = $image['tmp_name'];
    $upload_dir = '../uploads/';
    $file_ext = explode(".", $file_name);
    $unique_file_name = uniqid() . '.' . end($file_ext);
    $file_path = $upload_dir . $unique_file_name;

    // var_dump($tmp_file_path,$file_path);
    if (move_uploaded_file($tmp_file_path, $file_path)) {
      $query = "INSERT INTO PRODUCTS (name,category_id,description,image,price)";
      $query .= "VALUES ('$name','$category_id','$description','$unique_file_name','$price')";
      $result = mysqli_query($connection, $query);

      if ($result) {
        echo '<script>alert("Product added successfully.")</script>';
        header("Location:./product_list.php");
        exit;
      } else {
        echo "<script>alert('Something went wrong!')</script>";
      }
    } else {
      echo "<script>alert('Image is required!')</script>";
    }
  } else {
    echo '<script>alert("Category is required!")</script>';
  }
}
?>

<body>
  <div class="container">
    <div class="row">
      <div class="col">
        <h4>Add Product</h4>
      </div>
      <div class="col d-flex justify-content-end">
        <a class="btn btn-secondary btn-lg px-5" href="./product_list.php">Back</a>
      </div>
    </div>
    <form method="post" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" name="name">
      </div>
      <div class="mb-3">
        <label for="category_id" class="form-label">Category</label>
        <select class="form-select" name="category_id">
          <option selected disabled>Please select</option>
          <?php foreach ($category_list as $id => $name) { ?>
            <option value="<?= $id ?>"><?= $name ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" rows="5" name="description"></textarea>
      </div>
      <div class="mb-3">
        <label for="image" class="form-label">Image</label>
        <input type="file" class="form-control" name="image" accept="image/*">
      </div>
      <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="text" class="form-control" name="price">
      </div>
      <button type="submit" name="add_product" class="btn btn-success btn-lg">Add Product</button>
    </form>
  </div>
</body>

</html>