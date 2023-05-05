<?php include('../includes/header.php'); ?>

<?php 
    $_SESSION['page'] = 'orders';

    include('../../classes/CRUD.php');
    $crud = new CRUD;
    

    $orders = $crud->read('orders');


    if(isset($_SESSION['role'])) {
        if($_SESSION['role'] === 'client') {
            $orders = $crud->read('orders', ['column' => 'user_id', 'value' => $_SESSION['user_id']]);
        }
    }


    if(isset($_GET['action'])) {
        if($_GET['action'] === 'delete') {
            if($crud->delete('orders', ['column' => 'id', 'value' => $_GET['id']])) {
                header('Location: index.php');
            } else {
                $error = 'Cannot delete order with #'+$_GET['id'];
            }
        }
    }
?>

<div class="dashboard my-5">
    <div class="container">
        <h3 class="mb-4">Orders</h3>
        <div class="card">
            <div class="card-body">
                <?php if(isset($error)) echo '<p>'.$error.'</p>'; ?>
                <?php if(count($orders)) { ?>
                <div class="table-responsive">
                    <table class="table table-borderd">
                        <tr>
                            <th>#</th>
                            <th>Customer details</th>
                            <th>Notes</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                        <?php 
                        if(count($orders)) {
                            foreach($orders as $order) {
                            ?>
                            <tr>
                                <td><?= $order['id'] ?></td>
                                <td><?php
                                    echo $order['fullname'] .'<br />';
                                    echo $order['address'] .'<br />';
                                    echo $order['email'] .'<br />';
                                    echo $order['phone'];
                                ?></td>
                                <td><?= $order['notes'] ?></td>
                                <td><?= $order['total'] ?> EUR</td>
                                <td>
                                    <a href="?action=delete&id=<?= $order['id'] ?>">Delete</a>
                                </td>
                            </tr>
                            <?php
                            }
                        }
                        ?>
                    </table>
                </div>
                <?php } else { echo '0 orders'; } ?>
            </div>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>