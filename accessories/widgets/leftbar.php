<?php
  $i = 0;
  $sqlQ = $db->query("SELECT * FROM cart_accessories WHERE checked_out = 1 ORDER BY id DESC LIMIT 7");
  $result = [];

  while ($row = mysqli_fetch_assoc($sqlQ)) {
    $result[] = $row;
  }
  $count = $sqlQ->num_rows;
  $viewed_id = array();

  for ($i=0; $i < $count; $i++) { 
    $json_items = $result[$i]['cart'];
    $items = json_decode($json_items,true);
    foreach ($items as $item) {
      if(!in_array($item['id'], $viewed_id)){
          $viewed_id[] = $item['id'];
      }
    }
  }
?>
         <form>
            <div class="input-group" style="margin-bottom: 5px">
              <input type="text" class="form-control" placeholder="search">
              <div class="input-group-append">
                <button type="submit" class="btn btn-secondary"><span class="glyphicon glyphicon-search"></span></button>
              </div>
            </div>
          </form>

      <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          <?php foreach($viewed_id as $id):?>
            <li data-target="#myCarousel" data-slide-to="<?=$i;?>"></li>
          <?php endforeach; ?>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img class="first-slide" src="../images/products/0adb795c9801f68529343ca7f0fa5b21.png" alt="First slide">
            <div class="container">
              <div class="carousel-caption text-center">
                <h1 class="corousel-title">Most Popular Items</h1>
              <a href="../accessories/popular_items.php" class="add-button" style="margin-bottom: -2rem;">
                <span class="glyphicon glyphicon-shopping-cart"></span>View All</a>
              </div>
            </div>
          </div>
          <?php foreach($viewed_id as $id):
             $products = $db->query("SELECT id,title,image FROM accesories WHERE id = '{$id}'");
             $product = mysqli_fetch_assoc($products);
          ?>
          <div class="carousel-item">
            <img class="second-slide" src="<?=$product['image'];?>" alt="Second slide">
            <div class="container">
              <div class="carousel-caption">
              <h4 class="corousel-subtitle"><?=substr($product['title'],0,15);?></h4><br><br><br><br><br>
            <a href="index.php?add=<?=$product['id'];?>" class="carousel-button" style="margin-bottom: -2rem;">
               <span class="glyphicon glyphicon-heart"></span> view item</a>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
        <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>