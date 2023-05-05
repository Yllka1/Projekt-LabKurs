<?php include('includes/header.php'); ?>

<?php 
    $_SESSION['page'] = 'home';

    include('../classes/CRUD.php');
    $crud = new CRUD;

    $slides = count($crud->read('sliders'));
    $products = count($crud->read('products'));
    $categories = count($crud->read('categories'));
    $orders = count($crud->read('orders'));
?>

<div class="dashboard my-5">
    <div class="container">
        <h3 class="mb-4">Dashboard</h3>
        <div class="row">
            <div class="col-sm-12 col-md-3 col-lg-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h4><?= $slides ?></h4>
                        <p>Slides</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-3 col-lg-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h4><?= $categories ?></h4>
                        <p>Categories</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-3 col-lg-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h4><?= $products ?></h4>
                        <p>Products</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-3 col-lg-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h4><?= $orders ?></h4>
                        <p>Orders</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php include('includes/footer.php'); ?>