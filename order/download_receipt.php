<?php
$page_name = "Download Receipt";
require_once("../partials/navbar.php") ?>
<?php require_once("../helper.php");
with_user();
?>
<?php require_once("../database/db_connect.php") ?>
<?php require_once("../vendor/autoload.php");

use Dompdf\Dompdf;
?>
<?php
$connection = connect_with_mysql();

if (isset($_GET['id'])) {
  $id = $_GET['id'];
}

$query = "SELECT * FROM products JOIN orders ON orders.product_id = products.id
WHERE orders.id='$id'";
$result = mysqli_query($connection, $query);

if ($result) {
  $row = mysqli_fetch_assoc($result);
  $file_name = $row['name'] . ".pdf";

  ob_start();
  require_once("../order/sample_receipt.php");
  $html = ob_get_contents();
  ob_get_clean();

  $dompdf = new Dompdf();
  $dompdf->loadHtml($html);
  $dompdf->setPaper('A4', 'landscape');

  $dompdf->render();
  $pdf = $dompdf->output();
  file_put_contents($file_name, $pdf);

  // $dompdf->stream("new file", array('Attachment' => 0));
} else {
  die('Something went wrong' . mysqli_error($connection));
}
?>
