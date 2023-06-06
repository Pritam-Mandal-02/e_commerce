<?php
$page_name = "Login";
require_once("../partials/navbar.php") ?>
<?php require_once "../database/db_connect.php" ?>
<?php require_once "../vendor/autoload.php" ?>
<?php
$connection = connect_with_mysql();
$google_client_id = $_ENV['GOOGLE_CLIENT_ID'];
$google_client_secret = $_ENV['GOOGLE_CLIENT_SECRET'];
$redirect_uri = "http://localhost/e_commerce/auth/login.php";

$client = new Google_Client();
$client->setClientId($google_client_id);
$client->setClientSecret($google_client_secret);
$client->setRedirectUri($redirect_uri);
$client->addScope('profile');
$client->addScope('email');

if (isset($_GET['code'])) {
  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  $google_auth = new Google_Service_Oauth2($client);
  $google_info = $google_auth->userinfo->get();

  $name = $google_info->name;
  $email = $google_info->email;
  $google_id = $google_info->id;

  $user_detail_query = "SELECT * FROM users WHERE email='$email'";
  $user_detail = mysqli_query($connection, $user_detail_query);

  if (!$user_detail->num_rows) {
    $hashed_google_id = password_hash($google_id, PASSWORD_BCRYPT);

    $user_register_query = "INSERT INTO users (name,email,login_type,google_id) VALUES ('$name','$email','G','$hashed_google_id')";
    $user_register = mysqli_query($connection, $user_register_query);

    if ($user_register) {
      $user_detail = mysqli_query($connection, $user_detail_query);
    } else {
      echo '<script>alert("Something went wrong!")</script>';
      exit;
    }
  }

  $row = mysqli_fetch_assoc($user_detail);
  $role = $row['role'];
  $id = $row['id'];
  $name = $row['name'];
  $hashed_google_id = $row['google_id'];

  $verify = password_verify($google_id, $hashed_google_id);

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
}

if (isset($_POST['submit'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $query = "SELECT * FROM users WHERE email='$email'";
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

<body>
  <div class="container">
    <h4>Welcome Back</h4>
    <form method="post">
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
          <a class='btn btn-danger btn-lg' href="<?= $client->createAuthUrl() ?>"><i class="fa-brands fa-google"></i> Login</a>
        </div>
        <div class="col d-flex justify-content-end">
          If you don't have account?<a href="./register.php">register now</a>
        </div>
      </div>
    </form>
  </div>
</body>

</html>