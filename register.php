<?php
    include('includes/header.php');
    $_SESSION['page'] = 'register';

    $error = '';
    $errors = [];

    
    // include('classes/CRUD.php');
    $crud = new CRUD;

    if(isset($_POST['register_btn'])) {
        if(strlen($_POST['fullname']) < 3)
            $errors[] = 'Fullname is empty or too short!';
        
        if(strlen($_POST['username']) < 3)
            $errors[] = 'Username is empty or too short!';
            
        if(strlen($_POST['password1']) < 6)
            $errors[] = 'Password is empty or too short!';
            
        if(strlen($_POST['password2']) < 6)
            $errors[] = 'Repeat password is empty or too short!';

        if($_POST['password1'] !== $_POST['password2'])
            $errors[] = 'Password has to be same as Repeat password!';

        
        if(count($errors) === 0) {
            $fullname = explode(" ", $_POST['fullname']);
            $password = password_hash($_POST['password1'], PASSWORD_BCRYPT);

            if($crud->create('users', [
                'name' => $fullname[0],
                'surname' => $fullname[1],
                'username' => $_POST['username'],
                'password' => $password,
            ])) {
                header('Location: login.php');
            } else {
                $error = 'Something want wrong!';
            }
        }
    }
?>

<div class="auth my-5">
    <div class="container">
        <h2 class="text-center mb-4">Register</h2>
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
        <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
            <div class="mb-3">
                <label for="fullname" class="form-label">Fullname</label>
                <input type="text" name="fullname" class="form-control" id="fullname" />
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Email address</label>
                <input type="email" name="username" class="form-control" id="username" aria-describedby="usernameHelp" />
                <div id="usernameHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="password1" class="form-label">Password</label>
                <input type="password" name="password1" class="form-control" id="password1" />
            </div>
            <div class="mb-3">
                <label for="password2" class="form-label">Repeat Password</label>
                <input type="password" name="password2" class="form-control" id="password2" />
            </div>
            <button type="submit" name="register_btn" class="btn btn-primary">Register</button>
            <a href="login.php" class="btn btn-link">I already have an account</a>
        </form>
    </div>
</div>

<?php include('includes/footer.php') ?>