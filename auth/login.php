<?php require_once "../partials/navbar.php" ?>
<?php require_once "../helpers/helper.php" ?>
<?php
if (isset($_POST['submit'])) {
  $connection = connect_with_mysql();
  $email = $_POST['email'];
  $password = $_POST['password'];

  $query = "SELECT * FROM USERS ";
  $query .= "WHERE email='$email'";

  $result = mysqli_query($connection, $query);

  if ($result->num_rows) {
    $row = mysqli_fetch_assoc($result);
    $role = $row['role'];
    $id = $row['id'];
    $name = $row['name'];
    $hashed_password = $row['password'];

    $verify = password_verify($password, $hashed_password);

    if ($verify) {
      $_SESSION['user_detail'] = ['is_authenticated' => true, 'user_id' => $id, 'user_name' => $name, 'role' => $role];
      $_SESSION['cart_item'] = 0;

      if ($role == 1) {
        header("Location:../product/product_list.php");
        exit;
      } else if ($role == 2) {
        header("Location:../home/index.php");
        exit;
      }
    } else {
      echo '<script>alert("Invalid email or password!")</script>';
    }
  } else {
    echo '<script>alert("Invalid email or password!")</script>';
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
</head>

<body>
  <div class="container">
    <h4>Welcome Back</h4>
    <form action="login.php" method="post">
      <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" name="email">
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" name="password">
      </div>
      <div class="row">
        <div class="col">
          <button type="submit" name="submit" class="btn btn-success btn-lg">Login</button>
        </div>
        <div class="col d-flex justify-content-end">
          If you don't have account?<a href="./register.php">register now</a>
        </div>
      </div>
    </form>
  </div>
</body>

</html>