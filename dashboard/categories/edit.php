<?php include('../includes/header.php'); ?>

<?php 
    $_SESSION['page'] = 'update category';

    include('../../classes/CRUD.php');

    $crud = new CRUD;
    $category = $crud->read('categories', ['column' => 'id', 'value' => $_GET['id']]);
    $name = '';

    if($category) {
        $name = $category[0]['name'];
    }
    
    $errors = [];
    $error = '';

    if(isset($_POST['update_category_btn'])) {
        if(strlen($_POST['name']) < 3)
            $errors[] = 'Name is empty or too short!';

        
        if($crud->update('categories', [
            'name' => $_POST['name']
        ], ['column' => 'id', 'value' => $_POST['id']])) {
            header('Location: index.php');
        } else {
            $error = 'Something want wrong!';
        }
    }
?>

<div class="dashboard my-5">
    <div class="container">
        <h3 class="mb-4">Update category</h3>
        <div class="card">
            <div class="card-body">
                <?php if(isset($error)) echo '<p>'.$error.'</p>'; ?>
                <?php 
                    if(count($errors)) {
                        echo '<ul>';
                        foreach($errors as $error) {
                            echo '<li>'.$error.'</li>';
                        }
                        echo '</ul>';
                    }
                ?>
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                    <div class="form-group mb-4">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" value="<?= $name ?>" class="form-control" required />
                    </div>
                    <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                    <button type="submit" class="btn btn-primary" name="update_category_btn">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php include('../includes/footer.php'); ?>