<?php include('../includes/header.php'); ?>

<?php 
    $_SESSION['page'] = 'categories';

    include('../../classes/CRUD.php');
    $crud = new CRUD;
    $categories = $crud->read('categories');

    if(isset($_GET['action'])) {
        if($_GET['action'] === 'delete') {
            if($crud->delete('categories', ['column' => 'id', 'value' => $_GET['id']])) {
                header('Location: index.php');
            } else {
                $error = 'Cannot delete category with #'+$_GET['id'];
            }
        }
    }
?>

<div class="dashboard my-5">
    <div class="container">
        <h3 class="mb-4">Categories</h3>
        <a href="create.php" class="btn btn-primary mb-4">Create category</a>
        <div class="card">
            <div class="card-body">
                <?php if(isset($error)) echo '<p>'.$error.'</p>'; ?>
                <?php if(count($categories)) { ?>
                <div class="table-responsive">
                    <table class="table table-borderd">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th></th>
                        </tr>
                        <?php 
                        if(count($categories)) {
                            foreach($categories as $category) {
                            ?>
                            <tr>
                                <td><?= $category['id'] ?></td>
                                <td><?= $category['name'] ?></td>
                                <td>
                                    <a href="edit.php?id=<?= $category['id'] ?>">Edit</a>
                                    <a href="?action=delete&id=<?= $category['id'] ?>">Delete</a>
                                </td>
                            </tr>
                            <?php
                            }
                        }
                        ?>
                    </table>
                </div>
                <?php } else { echo '<p>0 categories</p>'; } ?>
            </div>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>