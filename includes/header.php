<?php 
    session_start();
    $page = (isset($_SESSION['page'])) ? ucfirst($_SESSION['page']) : 'Home';

    include('./classes/CRUD.php');
    $crud = new CRUD;

    // regenrate auth sessions from cookies
    if(count($_COOKIE) > 0) {
        $auth_sessions = ['user_id', 'username', 'role', 'is_loggedin'];

        foreach($_COOKIE as $ckey => $cvalue) {
            if(in_array($ckey, $auth_sessions)) {
                $_SESSION[$ckey] = $cvalue;
            }
        }
    }

    if(isset($_GET['action'])) {
        if($_GET['action'] === 'sign_out') {
            unset($_SESSION['user_id']);
            unset($_SESSION['username']);
            unset($_SESSION['role']);
            unset($_SESSION['is_loggedin']);

            $expire = -1;

            unset($_COOKIE['user_id']);
            unset($_COOKIE['username']);
            unset($_COOKIE['role']);
            unset($_COOKIE['user_id']);

            setcookie('user_id', null, $expire);
            setcookie('username', null, $expire);
            setcookie('role', null, $expire);
            setcookie('is_loggedin', null, $expire);

            header('Location: login.php');
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page ?> | e-commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/style.css" />
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">Online Shop</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="shop.php">Shop</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="cart.php">Cart 
                    <?php if(isset($_SESSION['cart'])) { ?>
                        (<?= count($_SESSION['cart']) ?>)
                    <?php } else { ?>
                        (0)
                    <?php } ?>
                </a>
                </li>
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php
                    if(isset($_SESSION['is_loggedin'])) {
                        if($_SESSION['is_loggedin'] == 1) {
                            $user = $crud->read('users', ['column' => 'id', 'value' => $_SESSION['user_id']]);

                            if(!is_null($user)) {
                                $user = $user[0];
                    ?>
                        <img src="assets/img/avatars/<?= $user['avatar'] ?>" alt="<?= $user['name'] ." " .$user['surname'] ?>" height="24" class="rounded-circle" />
                    <?php
                            }
                        }
                    }
                    ?>
                    <?= isset($_SESSION['is_loggedin']) ? $_SESSION['username'] : 'Guest' ?>
                </a>
                <ul class="dropdown-menu">
                    <?php if(!isset($_SESSION['is_loggedin'])): ?>
                    <li><a class="dropdown-item" href="login.php">Login</a></li>
                    <li><a class="dropdown-item" href="register.php">Register</a></li>
                    <?php else: ?>
                    <?php if(isset($_SESSION['role']) && ($_SESSION['role'] === 'admin')) { ?>
                    <li><a class="dropdown-item" href="dashboard/index.php">Dashboard</a></li>
                    <?php } else { ?>
                    <li><a class="dropdown-item" href="dashboard/orders/index.php">Dashboard</a></li>
                    <?php } ?>
                    <li><a class="dropdown-item" href="?action=sign_out">Sign out</a></li>
                    <?php endif; ?>
                </ul>
                </li>
            </ul>
            <input class="form-control w-25 me-2" type="search" placeholder="Search" id="search" aria-label="Search">
            </div>
        </div>
    </nav>