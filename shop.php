<?php
    include('includes/header.php');
    $_SESSION['page'] = 'shop';

    // include('classes/CRUD.php');
    $crud = new CRUD;
  
    $error = '';
    $errors = [];
  
    $products = $crud->read('products');

    if(isset($_GET['search'])) {
        $products = $crud->search('products', 'name', $_GET['search']);
    }

    if(isset($_GET['sort'])) {
        $order_parts = explode("_", $_GET['sort']);
        $order = ['column' => $order_parts[0], 'order' => $order_parts[1]];
        $products = $crud->read('products', [], null, $order);
    }
?>

<div class="search-sort my-4">
    <div class="container">
       <div class="row">
        <div class="col-sm-12 col-md-8 col-lg-8">
                <form action="<?= $_SERVER['PHP_SELF'] ?>">
                    <input type="search" name="search" id="search" class="form-control" placeholder="Search product by name" value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>" />
                </form>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <form action="<?= $_SERVER['PHP_SELF'] ?>">
                    <select name="sort" id="sort" class="form-control">
                        <option value="">Sort</option>
                        <option value="name_asc">Name ASC</option>
                        <option value="name_desc">Name DESC</option>
                        <option value="price_asc">Price ASC</option>
                        <option value="price_desc">Price DESC</option>
                    </select>
                </form>
            </div>
       </div>
    </div>
</div>

<div class="products py-5">
    <div class="container">
        <div class="row">
        <?php 
            if(count($products) > 0) {
              foreach($products as $product) {
            ?>
            <div class="col-sm-12 col-md-3 col-lg-3 mb-4">
                <div class="card py-4">
                    <img src="dashboard/products/images/<?= $product['image'] ?>" class="product-image" alt="<?= $product['name'] ?>" />
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                          <h5 class="card-title"><?= $product['name'] ?></h5>
                          <p class="card-text"><?= $product['price'] ?> EUR</p>
                        </div>
                        <a href="view-product.php?id=<?= $product['id'] ?>" class="btn btn-outline-secondary d-flex align-items-center">
                          <img src="./assets/img/eye.svg" alt="" />
                        </a>
                    </div>
                </div>
            </div>
            <?php 
              }
            } else {
            ?>
            <div class="col-sm-12 col-md-12 col-lg-12">
              <p>0 products</p>
            </div>
            <?php } ?>
        </div>
    </div>
</div>



<script>
    document.querySelector('select#sort').addEventListener('change', (e) => {
        if(e.target.value.length > 0) {
            window.location.href = `http://localhost/ecommerce/shop.php?sort=${e.target.value}`
        }
    })
</script>
<?php include('includes/footer.php') ?>