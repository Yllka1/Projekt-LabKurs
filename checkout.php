<?php
    include('includes/header.php');
    $_SESSION['page'] = 'checkout';

    // include('classes/CRUD.php');
    $crud = new CRUD;
  
    $error = '';
    $errors = [];
    
    if(isset($_POST['checkout_btn'])) {
        // validate 
        $total = 0.0;
        foreach($_SESSION['cart'] as $p_id => $product) {
            $total += ($product['qty'] + $product['price']);
        }

        
        // create order
        $data = [
            'user_id' => $_SESSION['user_id'],
            'fullname' => $_POST['fullname'],
            'address' => $_POST['address'],
            'email' => $_POST['email'],
            'phone' => $_POST['phone'],
            'notes' => $_POST['notes'],
            'total' => $total
        ];
        
        $crud->create('orders', $data);


        // foreach cart product update order_product
        $o_id = $crud->read('orders', [], 1, ['column' => 'id', 'order' => 'DESC'])[0]['id'];
        foreach($_SESSION['cart'] as $p_id => $product) {
            $crud->create('ordere_product', ['order_id' => $o_id, 'product_id' => $p_id]);
        }

        $_SESSION['cart'] = [];

        header('Location: index.php');
    }
?>

<div class="cart my-5">
    <div class="container">
        <?php if(count($_SESSION['cart']) > 0) {
        ?>
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th></th>
                </tr>
                <tr>
                    <?php 
                    $total = 0.00;
                    foreach($_SESSION['cart'] as $product) {
                        $total += ($product['qty'] * $product['price']);
                    ?>
                    <tr>
                        <td><?= $product['name'] ?></td>
                        <td>
                            <span class="d-inline-block mx-2"><?= $product['qty'] ?></span>
                        </td>
                        <td><?= $product['price'] ?> EUR</td>
                        <td><?= $product['qty'] * $product['price'] ?> EUR</td>
                    </tr>
                    <?php
                    }
                    ?>
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <td><b><?= $total ?> EUR</b></td>
                </tr>
            </table>
        </div>
        <?php
        } else {
        ?>
        <p>Cart is empty!</p>
        <?php
        }
        ?>
    </div>
</div>  


<div class="checkout my-5">
    <div class="container">
        <?php 
        if(!isset($_SESSION['is_loggedin'])) {
        ?>
        <p>Please login first - <a href="login.php">login here</a>.</p>
        <?php
        } else {
        ?>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
            <div class="form-group mb-2">
                <label for="fullname">Fullname</label>
                <input type="text" name="fullname" id="fullname" class="form-control" />
            </div>
            <div class="form-group mb-2">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" />
            </div>
            <div class="form-group mb-2">
                <label for="phone">Phone</label>
                <input type="text" name="phone" id="phone" class="form-control" />
            </div>
            <div class="form-group mb-2">
                <label for="address">Address</label>
                <textarea name="address" id="address" class="form-control"></textarea>
            </div>
            <hr />
            <div class="form-group mb-4">
                <textarea name="notes" id="notes" class="form-control" placeholder="Enter your notes here"></textarea>
            </div>
            <button type="submit" name="checkout_btn" class="btn btn-sm btn-primary">Submit</button>
        </form>
        <?php } ?>
    </div>
</div>  

<?php include('includes/footer.php') ?>