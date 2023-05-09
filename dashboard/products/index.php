<?php include('../includes/header.php'); ?>

<?php 
    $_SESSION['page'] = 'products';

    include('../../classes/CRUD.php');
    $crud = new CRUD;
    $products = $crud->read('products');

    if(isset($_GET['action'])) {
        if($_GET['action'] === 'delete') {
            if($crud->delete('products', ['column' => 'id', 'value' => $_GET['id']])) {
                header('Location: index.php');
            } else {
                $error = 'Cannot delete product with #'+$_GET['id'];
            }
        }
    }
?>

<div class="dashboard my-5">
    <div class="container">
        <h3 class="mb-4">Products</h3>
        <a href="create.php" class="btn btn-primary mb-4">Create product</a>
        <div class="card">
            <div class="card-body">
                <?php if(isset($error)) echo '<p>'.$error.'</p>'; ?>
                <?php if(count($products)) { ?>
                <div class="table-responsive">
                    <table class="table table-bproductd">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th></th>
                        </tr>
                        <?php 
                        if(count($products)) {
                            foreach($products as $product) {
                            ?>
                            <tr>
                                <td><?= $product['id'] ?></td>
                                <td><?= $product['name'] ?></td>
                                <td><?= $product['price'] ?> EUR</td>
                                <td><?= $product['qty'] ?></td>
                                <td>
                                    <a href="edit.php?id=<?= $product['id'] ?>">Edit</a>
                                    <a href="?action=delete&id=<?= $product['id'] ?>">Delete</a>
                                </td>
                            </tr>
                            <?php
                            }
                        }
                        ?>
                    </table>
                </div>
                <?php } else { echo '0 products'; } ?>
            </div>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
