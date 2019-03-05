<?php
$db = mysqli_connect('127.0.0.1', 'root', '', 'tutorial');
$sql = "SELECT * FROM categories WHERE parents = 0";
$pquery = $db-> query($sql); 

include 'head.php';

?>
<nav class="navbar navbar-fixed-top navbar-expand-lg navbar-dark color">
<div class="container">
      <section><a href="index.php" class="navbar-brand active text-danger">Chesire's Boutique</a></section>
       <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigate" aria-controls="navigate" aria-expanded="false" aria-label="Toggle navigation">
       <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse trial" id="navigate">

             <ul class="navbar-nav mr-auto">
        <?php while ($parents = mysqli_fetch_assoc($pquery)) : ?>
        <?php
         $parent_id = $parents['id'];
         $sql2 = "SELECT * FROM categories WHERE parents = '$parent_id'";
         $cquery = $db->query($sql2);
         ?>
         <!-- Menu Items -->

           <li class="dropdown nav-item">
                <a href="#" class="nav-link dropdown-toggle" class="dropdown-toggle" data-toggle="dropdown" id="drop" aria-haspopup="true" aria-expanded="false"><?php echo $parents['category'];?></a>
                    <div class="dropdown-menu" aria-labelledby="drop">
                    <?php while ($child = mysqli_fetch_assoc($cquery)): ?>
                    <a class="dropdown-item true" href="category.php?cat=<?=$child['id']; ?>"><?php echo $child['category'];?></a>

                    <?php endwhile; ?>  
                   </div> 
         </li>
        <?php endwhile; ?>
            <li>
                <a href="cart.php" class="nav-item"><span class="glyphicon glyphicon-shopping-cart"></span> My Cart</a>
            </li>
        </ul>
    </div>
    </div> 
    </nav> 



    <script>window.jQuery || document.write('<script src="/boutique/javascript/jquery-slim.min.js"><\/script>')</script>
    <script src="/boutique/javascript/bootstrap.min.js"></script>