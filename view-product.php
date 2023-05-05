<?php
    include('includes/header.php');
    $_SESSION['page'] = 'shop';

    // include('classes/CRUD.php');
    $crud = new CRUD;
  
    $error = '';
    $errors = [];

    if(isset($_GET['id'])) {
        $product = $crud->read('products', ['column' => 'id', 'value' => $_GET['id']], 1);
        $product = count($product) > 0 ? $product[0] : null;
    }

    if(isset($_GET['add-to-cart'])) {
        $id = $_GET['id'];
        $qty = $_GET['qty'];

        if($qty > $product['qty']) {
            $errors[] = 'Qty must be from 1 - '.$product['qty'];
        } else {
            if(array_key_exists($id, $_SESSION['cart'])) {
                $ecproduct = $_SESSION['cart'][$id];
                $ecproduct['qty'] = $ecproduct['qty'] + $qty;
                $_SESSION['cart'][$id] = $ecproduct;
            } else {
                $cproduct = $product;
                $cproduct['qty'] = $qty;
                $_SESSION['cart'][$id] = $cproduct;
            }
        }
    }
?>

<div class="product py-5">
    <div class="container">
        <div class="row">
        <?php 
            if(!is_null($product)) {
            ?>
            <div class="col-sm-12 col-md-4 col-lg-4 mb-4">
                <img src="dashboard/products/images/<?= $product['image'] ?>" class="img-fluid" alt="<?= $product['name'] ?>" />
            </div>
            <div class="col-sm-12 col-md-8 col-lg-8 mb-4">
                <h3><?= $product['name'] ?></h3>
                <p><?= $product['price'] ?> EUR</p>
                <p><?= $product['description'] ?></p>
                <?php 
                    if(count($errors)) {
                        echo '<ul>';
                        foreach($errors as $error) {
                            echo '<li>'.$error.'</li>';
                        }
                        echo '</ul>';
                    }
                ?>
                <form action="<?= $_SERVER['PHP_SELF'] ?>">
                    <input type="number" name="qty" id="qty" min="0" max="<?= $product['qty'] ?>" value="1" />
                    <input type="hidden" name="id" value="<?= $_GET['id'] ?>" />
                    <button type="submit" name="add-to-cart" class="btn btn-sm btn-outline-primary">Add to cart</button>
                </form>
            </div>
            <?php 
            } else {
            ?>
            <div class="col-sm-12 col-md-12 col-lg-12">
              <p>Product with id <?= $_GET['id'] ?> doesn't exist!</p>
            </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php include('includes/footer.php') ?>