<?php 
    session_start();

    if(!isset($_SESSION['is_loggedin'])) {
        header('Location: http://localhost/ecommerce/login.php');
    } else {
        if((boolean)$_SESSION['is_loggedin'] !== true) {
            header('Location: http://localhost/ecommerce/login.php');
        }
    }

    $path = $_SERVER['SCRIPT_NAME'];
    $pages = [
        '/ecommerce/dashboard/orders/index.php',
        '/ecommerce/dashboard/profile.php'
    ];

    // roles ----------------------
    if(isset($_SESSION['role'])) {
        if($_SESSION['role'] === 'client') {
            if(!in_array($path, $pages)) {
                die('<center>You doesnt have permission to view this page - <a href="http://localhost/ecommerce/">back</a>.</center>');
            }
        }
    }
    // roles ----------------------

    $page = (isset($_SESSION['page'])) ? ucfirst($_SESSION['page']) : 'Home';

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

            header('Location: http://localhost/ecommerce/login.php');
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page ?> | Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container">
            <a class="navbar-brand" href="http://localhost/ecommerce/dashboard/">Online Shop</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php if(isset($_SESSION['role']) && ($_SESSION['role'] === 'admin')) { ?>
                <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="http://localhost/ecommerce/dashboard/">Home</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="http://localhost/ecommerce/dashboard/slides/index.php">Slides</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="http://localhost/ecommerce/dashboard/categories/index.php">Categories</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="http://localhost/ecommerce/dashboard/products/index.php">Products</a>
                </li>
                <?php } ?>
                <li class="nav-item">
                <a class="nav-link" href="http://localhost/ecommerce/dashboard/orders/index.php">Orders</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?= isset($_SESSION['is_loggedin']) ? $_SESSION['username'] : 'Guest' ?>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="http://localhost/ecommerce/dashboard/profile.php">Profile</a></li>
                        <li><a class="dropdown-item" href="?action=sign_out">Sign out</a></li>
                    </ul>
                </li>
            </ul>
            </div>
        </div>
    </nav>