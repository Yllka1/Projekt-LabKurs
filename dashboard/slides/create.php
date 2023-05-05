<?php include('../includes/header.php'); ?>

<?php 
    $_SESSION['page'] = 'create slide';

    include('../../classes/CRUD.php');
    $crud = new CRUD;
    $stypes = ['image/png', 'image/jpg', 'image/jpeg', 'image/webp'];
    $errors = [];

    if(isset($_POST['create_slide_btn'])) {
        //validation
        if(!in_array($_FILES['image']['type'], $stypes)) 
            $errors[] = 'Image file type is not supported!';
        
        if(strlen($_POST['title']) < 3)
            $errors[] = 'Title is empty or too short!';

        if(strlen($_POST['description']) < 3)
            $errors[] = 'Description is empty or too short!';

        // proccess form data
        if(count($errors) === 0) {
            $filename = time().$_FILES['image']['name'];

            if($crud->create('sliders', [
                'image' => $filename,
                'title' => $_POST['title'],
                'content' => $_POST['description']
            ])) {
                // upload
                move_uploaded_file($_FILES['image']['tmp_name'], 'images/'.$filename);
                header('Location: index.php');
            } else {
                $error = 'Something want wrong!';
            }
        }
    }
?>

<div class="dashboard my-5">
    <div class="container">
        <h3 class="mb-4">Create slide</h3>
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
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                    <div class="form-group mb-4">
                        <label for="image">Image</label>
                        <input type="file" name="image" id="image" class="form-control" required accept="image/png, image/jpg, image/jpeg, image/webp" />
                    </div>
                    <div class="form-group mb-4">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" class="form-control" required />
                    </div>
                    <div class="form-group mb-4">
                        <label for="description">Description</label>
                        <input type="text" name="description" id="description" class="form-control" required />
                    </div>
                    <button type="submit" class="btn btn-primary" name="create_slide_btn">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>
