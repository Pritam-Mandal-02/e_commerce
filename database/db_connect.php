<?php require_once "config.php" ?>
<?php
function connect_with_mysql()
{
  $db_host = $_ENV['DB_HOST'];
  $db_username = $_ENV['DB_USERNAME'];
  $db_password = $_ENV['DB_PASSWORD'];
  $db_name = $_ENV['DB_NAME'];
  $connection = mysqli_connect($db_host, $db_username, $db_password, $db_name);

  if (!$connection) {
    die('Database Connection Failed!' . mysqli_error($connection));
  }

  return $connection;
}
