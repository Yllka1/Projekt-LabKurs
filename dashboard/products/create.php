<?php include('../includes/header.php'); ?>

<?php 
    $_SESSION['page'] = 'create product';

    include('../../classes/CRUD.php');
    $crud = new CRUD;
    $stypes = ['image/png', 'image/jpg', 'image/jpeg', 'image/webp'];

    $error = '';
    $errors = [];

    $categories = $crud->read('categories');

    if(isset($_POST['create_product_btn'])) {
        //validation
        if(!in_array($_FILES['image']['type'], $stypes)) 
            $errors[] = 'Image file type is not supported!';
        
        if(strlen($_POST['name']) < 3)
            $errors[] = 'Name is empty or too short!';

        if($_POST['qty'] <= 0)
            $errors[] = 'Qty is not valid!';

        if($_POST['price'] <= 0.0)
            $errors[] = 'Price is not valid!';

        // proccess form data
        if(count($errors) === 0) {
            $filename = time().$_FILES['image']['name'];

            if($crud->create('products', [
                'category_id' => $_POST['category'],
                'name' => $_POST['name'],
                'qty' => $_POST['qty'],
                'price' => $_POST['price'],
                'description' => $_POST['description'],
                'image' => $filename
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
        <h3 class="mb-4">Create product</h3>
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
                        <label for="category">Category</label>
                        <select name="category" id="category" class="form-control">
                            <option value="">Select category</option>
                            <?php
                            if(is_array($categories)) {
                                foreach($categories as $category) {
                            ?>
                                <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" required />
                    </div>
                    <div class="form-group mb-4">
                        <label for="qty">Qty</label>
                        <input type="number" name="qty" id="qty" class="form-control" required />
                    </div>
                    <div class="form-group mb-4">
                        <label for="price">Price</label>
                        <input type="text" name="price" id="price" class="form-control" required pattern="\d+\.\d{2}" />
                    </div>
                    <div class="form-group mb-4">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control"></textarea>
                    </div>
                    <div class="form-group mb-4">
                        <label for="image">Image</label>
                        <input type="file" name="image" id="image" class="form-control" required required accept="image/png, image/jpg, image/jpeg, image/webp" />
                    </div>
                    <button type="submit" class="btn btn-primary" name="create_product_btn">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php include('../includes/footer.php'); ?>