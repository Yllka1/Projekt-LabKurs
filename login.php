<?php
    include('includes/header.php');
    $_SESSION['page'] = 'login';

    $error = '';
    $errors = [];
    
    // include('classes/CRUD.php');
    $crud = new CRUD;

    if(isset($_POST['login_btn'])) {
        if(strlen($_POST['username']) < 3)
            $errors[] = 'Username is empty or too short!';
            
        if(strlen($_POST['password']) < 6)
            $errors[] = 'Password is empty or too short!';
        
        $user = $crud->read('users', ['column' => 'username', 'value' => $_POST['username']], 1);

        
        if( (count($errors) === 0) && is_array($user) && (count($user) > 0) ) {
            $user = $user[0]; 

            if(password_verify($_POST['password'], $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['is_loggedin'] = true;

                // remember me 
                if(isset($_POST['rememberme'])) {
                    if($_POST['rememberme'] == 1) {
                        $expire = time() + 3600 * 24 * 30;
                        setcookie('user_id', $_SESSION['user_id'], $expire);
                        setcookie('username', $_SESSION['username'], $expire);
                        setcookie('role', $_SESSION['role'], $expire);
                        setcookie('is_loggedin', $_SESSION['is_loggedin'], $expire);
                    }
                }
                
                if($user['role'] === 'client') 
                    header('Location: dashboard/orders/index.php');
                else  
                    header('Location: dashboard/index.php');
            } else {
                $_SESSION['error'] = 'Credentials are incorrect!';
            }
        } else {
            $_SESSION['error'] = 'User does not exist!';
        }
    }
?>

<div class="auth my-5">
    <div class="container">
        <h2 class="text-center mb-4">Login</h2>
        <?php 
            if(isset($_SESSION['error'])) {
                echo '<p class="text-center">'.$_SESSION['error'].'</p>'; 
            }
        ?>
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
                <label for="username" class="form-label">Email address</label>
                <input type="email" name="username" class="form-control" id="username" aria-describedby="usernameHelp" />
                <div id="usernameHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" />
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="rememberme" value="1" class="form-check-input" id="rememberme" value="yes">
                <label class="form-check-label" for="rememberme">Remember me</label>
            </div>
            <button type="submit" name="login_btn" class="btn btn-primary">Login</button>
            <a href="register.php" class="btn btn-link">Let me register first</a>
        </form>
    </div>
</div>

<?php include('includes/footer.php') ?>