<?php
 include 'head.php';
?>
      <nav class="navbar navbar-fixed-top navbar-expand-lg navbar-dark color">
      <div class="container">
      <a href="index.php" class="navbar-brand active text-danger">Chesire's Boutique Admin</a>
       <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigate" aria-controls="navigate" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse trial" id="navigate">
        <ul class="navbar-nav mr-auto">
           
           <!-- Menu Items -->
        <li class="nav-item"><a class="nav-link" href="brands.php">Brands</a></li>
        <li class="nav-item"><a class="nav-link" href="categories.php">Categories</a></li>
        <li class="nav-item"><a class="nav-link" href="products.php">Products</a></li>
        <li class="nav-item"><a class="nav-link" href="archives.php">Archives</a></li>
        <?php if(has_permission('admin')): ?>
        <li class="nav-item"><a class="nav-link" href="users.php">Users</a></li>
        <?php endif;?>
        <li class="nav-item"><a class="nav-link" href="accessories.php">Accessories</a></li>
        <li class="dropdown nav-item">
             <a class="nav-link dropdown-toggle" href="#" class="dropdown-toggle" id="drop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Hello <?=$user_data['first'];?>!</a>
             <div class="dropdown-menu" aria-labelledby="drop">
                 <a class="dropdown-item" href="change_password.php">Change Password</a>
                 <a class="dropdown-item" href="logout.php">Log Out</a>
             </div>
        </li>
        </ul>
  </div>
  </div>
    </nav>
    <script>window.jQuery || document.write('<script src="/boutique/javascript/jquery-slim.min.js"><\/script>')</script>
    <script src="/boutique/javascript/bootstrap.min.js"></script>
          <?php 

 if (isset($_SESSION['success_flash'])) {
        echo '<div class ="bg-success"><p class="text-center" style="background-color:springgreen;">'.$_SESSION['success_flash'].'</p></div>';
        unset($_SESSION['success_flash']);
}
if (isset($_SESSION['error_flash'])) {
        echo '<div class style="background-color: #f2dede;"><p class = "text-danger text-center">'.$_SESSION['error_flash'].'</p></div>';
        unset($_SESSION['error_flash']);
}
       ?>
