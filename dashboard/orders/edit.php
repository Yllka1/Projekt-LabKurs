<?php include('../includes/header.php'); ?>

<?php 
    $_SESSION['page'] = 'update slide';

    include('../../classes/CRUD.php');
    $crud = new CRUD;
    $stypes = ['image/png', 'image/jpg', 'image/jpeg', 'image/webp'];

    $error = '';
    $errors = [];

    $_SESSION['id'] = null;

    $title = '';
    $description = '';
    $image = '';

    if(isset($_GET['id'])) {
        $_SESSION['id'] = $_GET['id'];
    }

    if(!is_null($_SESSION['id'])) {
        // load slide data from db
        $slide = $crud->read('sliders', ['column' => 'id', 'value' => $_SESSION['id']]);

        if(is_array($slide)) {
            $slide = $slide[0];

            $title = $slide['title'];
            $description = $slide['content'];
            $image = 'images/'.$slide['image'];
        } 
    } else {
        $error = 'Slide does not exist!';
    }


    if(isset($_POST['update_slide_btn'])) {
        //validation
        if(!empty($_FILES['image']['name'])) {
            if(!in_array($_FILES['image']['type'], $stypes)) 
                $errors[] = 'Image file type is not supported!';
        }
        
        if(strlen($_POST['title']) < 3)
            $errors[] = 'Title is empty or too short!';

        if(strlen($_POST['description']) < 3)
            $errors[] = 'Description is empty or too short!';

        // proccess form data
        if(count($errors) === 0) {
            if(!empty($_FILES['image']['name'])) {
                // delete old image
                unlink($_POST['image']);

                $filename = time().$_FILES['image']['name'];

                if($crud->update('sliders', [
                    'image' => $filename,
                    'title' => $_POST['title'],
                    'content' => $_POST['description']
                ], ['column' => 'id', 'value' => $_POST['id']])) {
                    // upload
                    move_uploaded_file($_FILES['image']['tmp_name'], 'images/'.$filename);
                    header('Location: index.php');
                } else {
                    $error = 'Something want wrong!';
                }
            } else {
                if($crud->update('sliders', [
                    'title' => $_POST['title'],
                    'content' => $_POST['description']
                ], ['column' => 'id', 'value' => $_POST['id']])) {
                    header('Location: index.php');
                } else {
                    $error = 'Something want wrong!';
                }
            }
        }
    }

?>

<div class="dashboard my-5">
    <div class="container">
        <h3 class="mb-4">Update slide</h3>
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
                        <input type="file" name="image" id="image" class="form-control" accept="image/png, image/jpg, image/jpeg, image/webp" />
                        <br>
                        <?php if(!empty($image)): ?>
                        <input type="image" src="<?= $image ?>" height="60" />
                        <input type="hidden" name="image" value="<?= $image ?>" />
                        <?php endif; ?>
                    </div>
                    <div class="form-group mb-4">
                        <label for="title">Title</label>
                        <input type="text" name="title" value="<?= $title ?>" id="title" class="form-control" required />
                    </div>
                    <div class="form-group mb-4">
                        <label for="description">Description</label>
                        <input type="text" name="description" value="<?= $description ?>" id="description" class="form-control" required />
                    </div>
                    <?php if(!is_null($_SESSION['id'])): ?>
                    <input type="hidden" name="id" value="<?= $_SESSION['id'] ?>" />
                    <?php endif; ?>
                    <button type="submit" class="btn btn-primary" name="update_slide_btn">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
