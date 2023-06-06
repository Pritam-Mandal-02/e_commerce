<?php
$page_name = "Register";
require_once("../partials/navbar.php") ?>
<?php require_once "../database/db_connect.php" ?>
<?php
if (isset($_POST['register'])) {
  $connection = connect_with_mysql();
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];

  if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['confirm_password'])) {
    echo "<script>alert('Please fill all the fields!')</script>";
  } else if ($password != $confirm_password) {
    echo "<script>alert('Password and confirm password should be same!')</script>";
  } else {
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $query = "INSERT INTO users (name,email,login_type,password) VALUES ('$name','$email','M','$hashed_password')";
    $result = mysqli_query($connection, $query);

    if ($result) {
      echo '<script>alert("User registerd successfully.")</script>';
      header("Location:login.php");
      exit;
    } else {
      echo '<script>alert("Something went wrong!")</script>';
    }
  }
}
?>

<body>
  <div class="container">
    <h4>User Registration</h4>
    <form method="post">
      <div class="mb-3">
        <div class="mb-3">
          <label for="name" class="form-label">Name</label>
          <input type="text" class="form-control" name="name">
        </div>
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" name="email">
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" name="password">
      </div>
      <div class="mb-3">
        <label for="confirm_password" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" name="confirm_password">
      </div>
      <div class="row">
        <div class="col">
          <button type="submit" name="register" class="btn btn-success btn-lg">Register</button>
        </div>
        <div class="col d-flex justify-content-end">
          If you already have account?<a href="./login.php">login now</a>
        </div>
      </div>
    </form>
  </div>
</body>

</html>