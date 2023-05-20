<?php include('includes/header.php'); ?>

<?php 
    $_SESSION['page'] = 'profile';

    include('../classes/CRUD.php');
    $crud = new CRUD;

    $error = '';
    $errors = [];

    $user = $crud->read('users', ['column' => 'id', 'value' => $_SESSION['user_id']]);
    $user = (is_array($user) && count($user) > 0) ? $user[0] : null;


    if(isset($_POST['update_user_data_btn'])) {
        if(strlen($_POST['name']) < 3)
            $errors[] = 'Name is empty or too short!';
            
        if(strlen($_POST['surname']) < 3)
            $errors[] = 'Surname password is empty or too short!';
            
        if(strlen($_POST['address']) < 3)
            $errors[] = 'Address password is empty or too short!';
            
        if(strlen($_POST['phone']) < 3)
            $errors[] = 'Phone password is empty or too short!';
        
        if(count($errors) === 0) {
            if(!empty($_FILES['image']['name'])) {
                $filename = time().$_FILES['image']['name'];

                if($crud->update('users', [
                    'name' => $_POST['name'],
                    'surname' => $_POST['surname'],
                    'address' => $_POST['address'],
                    'phone' => $_POST['phone'],
                    'avatar' => $filename
                ], ['column' => 'id', 'value' => $user['id']])) {
                    // upload
                     move_uploaded_file($_FILES['image']['tmp_name'], '../assets/img/avatars/'.$filename);
                    header('Location: profile.php?status=success');
                } else {
                    header('Location: profile.php?status=error');
                }
            } else { 
                if($crud->update('users', [
                    'name' => $_POST['name'],
                    'surname' => $_POST['surname'],
                    'address' => $_POST['address'],
                    'phone' => $_POST['phone']
                ], ['column' => 'id', 'value' => $user['id']])) {
                    header('Location: profile.php?status=success');
                } else {
                    header('Location: profile.php?status=error');
                }
            }
        }
    }
    

    if(isset($_POST['update_password_btn'])) {
        if(strlen($_POST['password1']) < 6)
            $errors[] = 'Password is empty or too short!';
            
        if(strlen($_POST['password2']) < 6)
            $errors[] = 'Repeat password is empty or too short!';

        if($_POST['password1'] !== $_POST['password2'])
            $errors[] = 'Password has to be same as Repeat password!';

        
        if(count($errors) === 0) {
            $password = password_hash($_POST['password1'], PASSWORD_BCRYPT);

            if($crud->update('users', [
                'password' => $password
            ], ['column' => 'id', 'value' => $user['id']])) {
                header('Location: profile.php?status=success');
            } else {
                header('Location: profile.php?status=error');
            }
        }
    }
?>

<div class="profile my-5">
    <div class="container">
        <h3 class="mb-4">Profile</h3>
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
        <?php 
        if(isset($_GET['status'])) {
            switch($_GET['status']) {
                case 'success':
                    echo 'Action was performed successfully';
                    break;
                case 'error':
                    echo 'Something want wrong!';
                    break;
            }
        }
        ?>
        <div class="card mb-4">
            <div class="card-header">
                <h5>Update</h5>
            </div>
            <div class="card-body">
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="name" required <?php if(!is_null($user)): ?> value='<?= $user['name'] ?>' <?php endif; ?> />
                    </div>
                    <div class="mb-3">
                        <label for="surname" class="form-label">Surname</label>
                        <input type="text" name="surname" class="form-control" id="surname" required <?php if(!is_null($user)): ?> value='<?= $user['surname'] ?>' <?php endif; ?> />
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" name="address" class="form-control" id="address" required <?php if(!is_null($user) && !empty($user['address'])): ?> value='<?= $user['address'] ?>' <?php endif; ?> />
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="tel" name="phone" class="form-control" id="phone" required <?php if(!is_null($user) && !empty($user['phone'])): ?> value='<?= $user['phone'] ?>' <?php endif; ?> />
                    </div>
                    <div class="form-group mb-4">
                        <label for="image">Image</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/png, image/jpg, image/jpeg, image/webp" />
                    </div>
                    <button type="submit" name="update_user_data_btn" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <h5>Change password</h5>
            </div>
            <div class="card-body">
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                    <div class="mb-3">
                        <label for="password1" class="form-label">Password</label>
                        <input type="password" name="password1" class="form-control" id="password1" required />
                    </div>
                    <div class="mb-3">
                        <label for="password2" class="form-label">Repeat Password</label>
                        <input type="password" name="password2" class="form-control" id="password2" required />
                    </div>
                    <button type="submit" name="update_password_btn" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>