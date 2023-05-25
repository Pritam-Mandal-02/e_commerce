<?php
function connect_with_mysql()
{
  $connection = mysqli_connect('localhost', 'root', '', 'e_commerce');

  if (!$connection) {
    die('Database Connection Failed!' . mysqli_error($connection));
  }

  return $connection;
}
