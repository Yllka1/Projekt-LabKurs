<?php 
  include('includes/header.php');
  
  // include('classes/CRUD.php');
  $crud = new CRUD;

  $error = '';
  $errors = [];

  if(!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
  } else {
    $_SESSION['cart'] = [];
  }

  $slides = $crud->read('sliders', [], 3, ['column' => 'id', 'order' => 'desc']);
  $products = $crud->read('products', [], 4, ['column' => 'id', 'order' => 'desc']);
?>

<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="false">
  <div class="carousel-indicators">
    <?php 
    if(count($slides) > 0) {
      for($i = 0; $i < count($slides); $i++) {
    ?>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="<?= $i ?>" <?php if($i === 0) echo 'class="active"'; else echo ''; ?> aria-current="true" aria-label="Slide <?= $i ?>"></button>
    <?php
      }
    }
    ?>
  </div>
  <div class="carousel-inner">
    <?php
    if(count($slides) > 0) {
      foreach($slides as $ind => $slide) {
    ?>
    <div class="carousel-item <?php if($ind === 0) echo 'active'; else echo ''; ?>" data-bs-interval="3000">
      <img src="dashboard/slides/images/<?= $slide['image'] ?>" class="d-block w-100" alt="<?= $slide['title'] ?>" />
      <div class="carousel-caption d-none d-md-block">
        <h5><?= $slide['title'] ?></h5>
        <p><?= $slide['content'] ?></p>
      </div>
    </div>
    <?php
      }
    }
    ?>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>


<div class="latest-products py-5">
    <div class="container">
        <h2 class="pb-4 text-center">Latest products</h2>
        <div class="row">
            <?php 
            if(count($products) > 0) {
              foreach($products as $product) {
            ?>
            <div class="col-sm-12 col-md-3 col-lg-3">
                <div class="card py-4">
                    <img src="dashboard/products/images/<?= $product['image'] ?>" class="product-image" alt="<?= $product['name'] ?>" />
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                          <h5 class="card-title"><?= $product['name'] ?></h5>
                          <p class="card-text"><?= $product['price'] ?> EUR</p>
                        </div>
                        <a href="view-product.php?id=<?= $product['id'] ?>" class="btn btn-outline-secondary d-flex align-items-center">
                          <img src="./assets/img/eye.svg" alt="" />
                        </a>
                    </div>
                </div>
            </div>
            <?php 
              }
            } else {
            ?>
            <div class="col-sm-12 col-md-12 col-lg-12">
              <p>0 products</p>
            </div>
            <?php } ?>
        </div>
        <div class="row my-5">
          <div class="col-lg-12 col-md-12 col-sm-12 d-flex justify-content-center">
            <a href="shop.php" class="btn btn-outline-primary">Shop now</a>
          </div>
        </div>
    </div>
</div>


<div class="about my-5">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-4 col-lg-4">
                <img src="./assets/img/aboutus.jpg" class="img-fluid" alt="Online Shop" />
            </div>
            <div class="col-sm-12 col-md-8 col-lg-8">
                <h3>Online Shop</h3>
                <p>
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Asperiores veritatis, veniam blanditiis et facere odio tempora non sequi, iure tempore vitae dolorem quo rem soluta laborum dolor unde reiciendis officia?
                </p>
                <p>
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Asperiores veritatis, veniam blanditiis et facere odio tempora non sequi, iure tempore vitae dolorem quo rem soluta laborum dolor unde reiciendis officia?
                </p>
                <p>
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Asperiores veritatis, veniam blanditiis et facere odio tempora non sequi, iure tempore vitae dolorem quo rem soluta laborum dolor unde reiciendis officia?
                </p>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php') ?>