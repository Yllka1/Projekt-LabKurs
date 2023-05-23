<?php include('../includes/header.php'); ?>

<?php 
    $_SESSION['page'] = 'create category';

    include('../../classes/CRUD.php');

    $crud = new CRUD;
    
    $errors = [];
    $error = '';

    if(isset($_POST['create_category_btn'])) {
        if(strlen($_POST['name']) < 3)
            $errors[] = 'Name is empty or too short!';
        
        if($crud->create('categories', [
            'name' => $_POST['name']
        ])) {
            header('Location: index.php');
        } else {
            $error = 'Something want wrong!';
        }
    }
?>

<div class="dashboard my-5">
    <div class="container">
        <h3 class="mb-4">Create category</h3>
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
                        <input type="text" name="name" id="name" class="form-control" required />
                    </div>
                    <button type="submit" class="btn btn-primary" name="create_category_btn">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>



<?php include('../includes/footer.php'); ?>