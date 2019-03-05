<?php
  $cartQuery = $db->query("SELECT * FROM cart_accessories WHERE id = '{$Acart_id}'");
  $result = mysqli_fetch_assoc($cartQuery);
  $cart = json_decode($result['cart'],true);
   $sql = $db->query("SELECT * FROM accesoriestype WHERE parent = 0 AND branch = 43;");
   $count = 0;
   if ($Acart_id != '') {
        foreach($cart as $item){
         $count++;
      }
    }
?>
     <style>
    .nav{
      background-color: mediumpurple;;
    }
  </style>
    <nav class="navbar navbar-expand-md fixed-top navbar-dark nav">
      <a class="navbar-brand" href="/boutique/clothes">Chesire's Boutique</a>
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
          <?php while($parent = mysqli_fetch_assoc($sql)):
             $id = $parent['id']; 
             $child = $db->query("SELECT * FROM accesoriestype WHERE parent = '{$id}'");
          ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="accessories.php?id=<?=$parent['id'];?>"><?=$parent['brand_name'];?></a>
            <div class="dropdown-menu" aria-labelledby="dropdown01">
              <?php while($cresult = mysqli_fetch_assoc($child)): ?>
              <a class="dropdown-item" href="accessories.php?id=<?=$cresult['id'];?>&cid=<?=$cresult['id'];?>"><?=ucfirst($cresult['brand_name']);?></a>
              <?php endwhile; ?>
            </div>
          </li>
        <?php endwhile;?>
        <li class="nav-item">
            <a class="nav-link" href="../accessories/cart.php">
              <span class="glyphicon glyphicon-shopping-cart"></span> Cart <span class="badge badge-secondary badge-pill bg-danger"><?=$count;?></span></a>
          </li>
          <li class="nav-item">
            <a href="../admin_panel/login.php" class="btn btn-xs btn-primary" style="margin-left: 7px;">Staff Login</a>
          </li>
        </ul>
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
