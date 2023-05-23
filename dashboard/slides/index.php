<?php include('../includes/header.php'); ?>

<?php 
    $_SESSION['page'] = 'slides';

    
    include('../../classes/CRUD.php');
    $crud = new CRUD;
    $slides = $crud->read('sliders');

    if(isset($_GET['action'])) {
        if($_GET['action'] === 'delete') {
            if($crud->delete('sliders', ['column' => 'id', 'value' => $_GET['id']])) {
                header('Location: index.php');
            } else {
                $error = 'Cannot delete slide with #'+$_GET['id'];
            }
        }
    }

?>

<div class="dashboard my-5">
    <div class="container">
        <h3 class="mb-4">Slides</h3>
        <a href="create.php" class="btn btn-primary mb-4">Create slide</a>
        <div class="card">
            <div class="card-body">
                <?php if(isset($error)) echo '<p>'.$error.'</p>'; ?>
                <?php if(count($slides)) { ?>
                <div class="table-responsive">
                    <table class="table table-borderd">
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th></th>
                        </tr>
                        <?php 
                        if(count($slides)) {
                            foreach($slides as $slide) {
                            ?>
                            <tr>
                                <td><?= $slide['id'] ?></td>
                                <td>
                                    <img src="images/<?= $slide['image'] ?>" height="80" />
                                </td>
                                <td><?= $slide['title'] ?></td>
                                <td><?= $slide['content'] ?></td>
                                <td>
                                    <a href="edit.php?id=<?= $slide['id'] ?>">Edit</a>
                                    <a href="?action=delete&id=<?= $slide['id'] ?>">Delete</a>
                                </td>
                            </tr>
                            <?php
                            }
                        }
                        ?>
                    </table>
                </div>
                <?php } else { echo '<p>0 slides</p>'; } ?>
            </div>
        </div>
    </div>
</div>