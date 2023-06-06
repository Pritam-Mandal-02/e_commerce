<?php
  $env_file = "../.env";

  if (file_exists($env_file)) {
    $lines = file($env_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
      list($name, $value) = explode('=', $line, 2);
      $_ENV[$name] = $value;
    }
  }
