<?php
$db = mysqli_connect('127.0.0.1', 'root', '', 'tutorial');
$sql = "SELECT * FROM categories WHERE parents = 0";
$pquery = $db-> query($sql); 


?>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <link rel="stylesheet" href="/boutique/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="/boutique/css/main.css">
</head>
<body>
  <div class="fixed-top">
<header>
  <div class="head text-center" style=""><a href="index.php"><i>Chesire's Boutique</i></a></div>
  <div class="menu"><span class="glyphicon glyphicon-menu-hamburger modify"></span></div>
</header>
<nav class="nave">
  <ul>
    <li>
      <form class="form-inlinepull-right">
          <input class="form-control" type="text" placeholder="Search">
        </form>
     </li>
    <?php while ($parents = mysqli_fetch_assoc($pquery)) : ?>
        <?php
         $parent_id = $parents['id'];
         $sql2 = "SELECT * FROM categories WHERE parents = '$parent_id'";
         $cquery = $db->query($sql2);
         ?>
    <li><a href="#"><span class="glyphicon glyphicon-play"></span><?=$parents['category']; ?></a>
      <ul>
        <?php while($child = mysqli_fetch_assoc($cquery)): ?>
        <li><a href="category.php?cat=<?=$child['id']; ?>"><?=$child['category'];?></a></li>
        <?php endwhile; ?>
      </ul>
    </li>
    <?php endwhile; ?>
    <li>
      <a href="cart.php" class="nav-item"><span class="glyphicon glyphicon-shopping-cart"></span> My Cart</a>
     </li>
  </ul>
</nav>
</div>

<script src="/boutique/javascript/jquery-3.3.1.min.js"></script>
<script>
  var menu = false;
  $(".glyphicon-menu-hamburger.modify").click(function(){
    if (menu == false) {
      $(".nave").fadeIn();
      menu = true;
    }else{
      $(".nave").fadeOut();
      menu = false;
    }
  })
</script>
</body>
</html>