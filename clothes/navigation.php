<?php
   $sql = $db->query("SELECT * FROM accesoriestype WHERE parent = 0;")
?>
     <style>
    .nav{
      background-color: mediumpurple;;
    }
  </style>
    <nav class="navbar navbar-expand-md fixed-top navbar-dark nav">
      <a class="navbar-brand" href="/boutique/">Chesire's Boutique</a>
      <button class="navbar-toggler p-0 border-0" type="button" data-toggle="offcanvas">
        <span class="navbar-toggler-icon"></span>
      </button>

    <div class="navbar-collapse offcanvas-collapse nav" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active  navigation">
          <a class="nav-link" href="/boutique/accessories">Accessories <span class="sr-only">(current)</span></a>
          <div class="dropdown-menu" aria-labelledby="dropdown01">
              <a class="dropdown-item" href="#">Log Out</a>
              <a class="dropdown-item" href="change_password.php">Change Password</a>
            </div>
          </li>
          <?php while($parent = mysqli_fetch_assoc($sql)): ?>
          <li class="nav-item">
            <a class="nav-link" href="accessories.php?id=<?=$parent['id'];?>"><?=$parent['brand_name'];?></a>
          </li>
        <?php endwhile;?>
        <li class="nav-item">
            <a class="nav-link pull-right" href="../accessories/cart.php">
              <span class="glyphicon glyphicon-shopping-cart"></span> Cart</a>
          </li>
        </ul>
        <form>
            <div class="input-group">
              <input type="text" class="form-control" placeholder="search">
              <div class="input-group-append">
                <button type="submit" class="btn btn-secondary"><span class="glyphicon glyphicon-search"></span></button>
              </div>
            </div>
          </form>
        <a href="../admin_panel/login.php" class="btn btn-xs btn-primary" style="margin-left: 7px;">Staff Login</a>
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
    <script src="/boutique/accessories/css/offcanvas.js"></script>
