<?php include('../includes/header.php'); ?>

<?php 
    $_SESSION['page'] = 'update product';

    include('../../classes/CRUD.php');
    $crud = new CRUD;
    $stypes = ['image/png', 'image/jpg', 'image/jpeg', 'image/webp'];

    $error = '';
    $errors = [];

    $categories = $crud->read('categories');
    $product = null;
    
    // product
    if(isset($_GET['id'])) {
        $product = $crud->read('products', ['column' => 'id', 'value' => $_GET['id']]);
        if(is_array($product)) $product = $product[0];
    }


    if(isset($_POST['update_product_btn'])) {
        //validation
        if(!empty($_FILES['image']['name'])) {
            if(!in_array($_FILES['image']['type'], $stypes)) 
                $errors[] = 'Image file type is not supported!';
        }
        
        if(strlen($_POST['name']) < 3)
            $errors[] = 'Name is empty or too short!';

        if($_POST['qty'] <= 0)
            $errors[] = 'Qty is not valid!';

        if($_POST['price'] <= 0.0)
            $errors[] = 'Price is not valid!';

        // proccess form data
        if(count($errors) === 0) {
            if(!empty($_FILES['image']['name'])) {
                // delete old image
                unlink($_POST['image']);

                $filename = time().$_FILES['image']['name'];

                if($crud->update('products', [
                    'category_id' => $_POST['category'],
                    'name' => $_POST['name'],
                    'qty' => $_POST['qty'],
                    'price' => $_POST['price'],
                    'description' => $_POST['description'],
                    'image' => $filename
                ], ['column' => 'id', 'value' => $_POST['id']])) {
                    // upload
                    move_uploaded_file($_FILES['image']['tmp_name'], 'images/'.$filename);
                    header('Location: index.php');
                } else {
                    $error = 'Something want wrong!';
                }
            } else {
                if($crud->update('products', [
                    'category_id' => $_POST['category'],
                    'name' => $_POST['name'],
                    'qty' => $_POST['qty'],
                    'price' => $_POST['price'],
                    'description' => $_POST['description']
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
        <h3 class="mb-4">Update product</h3>
        <div class="card">
            <div class="card-body">
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                    <div class="form-group mb-4">
                        <label for="category">Category</label>
                        <select name="category" id="category" class="form-control">
                            <option value="">Select category</option>
                            <?php
                            if(is_array($categories)) {
                                foreach($categories as $category) {
                            ?>
                                <option value="<?= $category['id'] ?>" <?php if($product['category_id'] === $category['id']): ?> selected <?php endif; ?>><?= $category['name'] ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" required <?php if(!is_null($product)): ?> value='<?= $product['name'] ?>' <?php endif; ?> />
                    </div>
                    <div class="form-group mb-4">
                        <label for="qty">Qty</label>
                        <input type="number" name="qty" id="qty" class="form-control" required <?php if(!is_null($product)): ?> value='<?= $product['qty'] ?>' <?php endif; ?> />
                    </div>
                    <div class="form-group mb-4">
                        <label for="price">Price</label>
                        <input type="text" name="price" id="price" class="form-control" required pattern="\d+\.\d{2}" <?php if(!is_null($product)): ?> value='<?= $product['price'] ?>' <?php endif; ?> />
                    </div>
                    <div class="form-group mb-4">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control"><?php if(!is_null($product) && !empty($product['description'])) echo $product['description']; ?></textarea>
                    </div>
                    <div class="form-group mb-4">
                        <label for="image">Image</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/png, image/jpg, image/jpeg, image/webp" />
                        <?php if(!is_null($product) && ($product['image'] !== 'noimage.jpg')): ?> 
                            <br />
                            <input type="image" src="images/<?= $product['image'] ?>" height="80" />
                        <?php endif; ?>
                    </div>
                    <input type="hidden" name="id" value="<?= $_GET['id'] ?>" />
                    <button type="submit" class="btn btn-primary" name="update_product_btn">update</button>
                </form>
            </div>
        </div>
    </div>
</div>
