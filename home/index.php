<?php
$page_name = "Home";
require_once("../partials/navbar.php") ?>
<?php
if (isset($_SESSION['user_detail']) && $_SESSION['user_detail']['is_authenticated'] && $_SESSION['user_detail']['role'] == 1) {
  header("Location:../product/product_list.php");
  exit;
}
?>

<head>
  <script>
    function handleSearch(pageNum) {
      let name = document.getElementById("search").value;
      let category = document.getElementById("category").value;
      let sort = document.getElementById("sort").value;
      let limit = document.getElementById("limit").value;

      if (!pageNum) pageNum = 1;
      if (limit === 'limit') limit = 6;
      else limit = parseInt(limit);
      if (category === 'category') category = "";
      if (sort === 'sort') sort = "";

      let qs = `?page_num=${pageNum}&limit=${limit}`;
      if (name) qs += `&name=${name}`;
      if (category) qs += `&category=${category}`;
      if (sort) qs += `&sort=${sort}`;

      handleFind(qs);
    }

    function handleFind(qs) {
      if (!qs) qs = "";

      $.ajax({
        url: `search.php${qs}`,
        success: function(response) {
          $('#result').html(response);
        }
      });
    }

    function handleAddToCart(id) {
      $.ajax({
        url: `../cart/add_to_cart.php?id=${id}`,
        success: function(response) {
          // $('#result').html(response);
        }
      });
    }
  </script>
</head>

<body onload="handleFind()">
  <div class="container">
    <div class="row mb-2 mt-1">
      <div class="col col-sm-2">
        <h4>Product List</h4>
      </div>
      <div class="col col-sm-4">
        <input type="search" class="form-control" placeholder="Search" id="search" onchange="handleSearch()">
      </div>
      <div class="col col-sm-2">
        <select class="form-select" id="category" onchange="handleSearch()">
          <option value="category" selected disabled>Category</option>
          <option value="0">All</option>
          <?php foreach ($category_list as $id => $name) { ?>
            <option value="<?= $id ?>"><?= $name ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="col col-sm-2">
        <select class="form-select" id="sort" onchange="handleSearch()">
          <option value="sort" selected disabled>Sort</option>
          <option value="id,desc">Default</option>
          <option value="name,asc">A-Z</option>
          <option value="name,desc">Z-A</option>
          <option value="price,asc">Low to High</option>
          <option value="price,desc">High to Low</option>
        </select>
      </div>
      <div class="col col-sm-2">
        <select class="form-select" id="limit" onchange="handleSearch()">
          <option value="limit" selected disabled>Page Limit</option>
          <option value="6">Default</option>
          <option value="1">1</option>
          <option value="10">10</option>
          <option value="25">25</option>
          <option value="50">50</option>
        </select>
      </div>
    </div>
    <div id="result">
    </div>
  </div>
  </div>
</body>

</html>