 <?php 
    require_once $_SERVER['DOCUMENT_ROOT'].'/boutique/init.php';
    $branchQ = $db->query("SELECT * FROM accesoriestype WHERE branch = 0");
 ?>
 <style>
    .brands{
      background-color: lime;
      width: 200px;
      text-align: center;
    }
    .nav{
      background-color: mediumslateblue;
    }
  </style>
    <nav class="navbar navbar-expand-md fixed-top navbar-dark nav">
      <a class="brands navbar-brand" href="/boutique/accessories/">WEBPAGE</a>
      <button class="navbar-toggler p-0 border-0" type="button" data-toggle="offcanvas">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="navbar-collapse offcanvas-collapse nav" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="/boutique/admin_panel/index.php">Dashboard <span class="sr-only">(current)</span></a>
          </li>
          <?php while($branch = mysqli_fetch_assoc($branchQ)):?>
          <li class="nav-item">
        <a class="nav-link" href="/boutique/admin_panel/products/products.php?branch=<?=$branch['id'];?>"><?=$branch['brand_name'];?></a>
          </li>
        <?php endwhile; ?>
          <li class="nav-item">
            <a class="nav-link" href="/boutique/admin_panel/archives.php">Archives</a>
          </li>
        <?php if(has_admin_permission('admin')):?>
          <li class="nav-item">
            <a class="nav-link" href="/boutique/admin_panel/users.php">Users</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Settings</a>
            <div class="dropdown-menu" aria-labelledby="dropdown01">
              <a class="dropdown-item" href="logout.php">Log Out</a>
              <a class="dropdown-item" href="change_password.php">Change Password</a>
            </div>
          </li>
        </ul>
        <?php endif;?>
        <form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
      </div>
    </nav>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="/boutique/javascript/jquery-slim.min.js"><\/script>')</script>
    <script src="/boutique/javascript/popper.min.js"></script>
    <script src="/boutique/javascript/bootstrap.min.js"></script>
    <script src="/boutique/javascript/holder.min.js"></script>
    <script src="/boutique/accessories/css/offcanvas.js"></script><br>
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
