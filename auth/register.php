<?php require_once "../partials/navbar.php" ?>
<?php require_once "../helpers/helper.php" ?>
<?php
if (isset($_POST['register'])) {
  if (empty($_POST['gender'])) {
    echo "<script>alert('Please fill all the field!')</script>";
  } else {
    $connection = connect_with_mysql();
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];

    $password = password_hash($password, PASSWORD_BCRYPT);

    $query = "INSERT INTO USERS (name,email,password,dob,gender) ";
    $query .= "VALUES ('$name','$email','$password','$dob','$gender')";

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

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col">
        <h4>User Registration</h4>
      </div>
      <div class="col d-flex justify-content-end">
        <a class="btn btn-secondary btn-lg px-5" href="./login.php">Back</a>
      </div>
    </div>
    <form method="post">
      <div class="mb-3">
        <div class="mb-3">
          <label for="name" class="form-label">Name</label>
          <input type="text" class="form-control" name="name">
        </div>
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" name="email">
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" name="password">
      </div>
      <div class="mb-3">
        <label for="dob" class="form-label">DOB</label>
        <input type="date" class="form-control" name="dob">
      </div>
      <div class="mb-3">
        <label for="gender" class="form-check-label">Gender</label>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="gender" value="male">
          <label class="form-check-label" for="male">Male</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="gender" value="female">
          <label class="form-check-label" for="female">Female</label>
        </div>
      </div>
      <button type="submit" name="register" class="btn btn-success btn-lg">Register</button>
    </form>
  </div>
</body>

</html>