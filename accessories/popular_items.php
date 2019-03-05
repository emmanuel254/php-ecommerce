<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/boutique/init.php';
  include '../accessories/heading/header.php';
  include 'navigation.php';
  include '../includes/success.php';
  $i = 0;
  $sqlQ = $db->query("SELECT * FROM cart_accessories WHERE checked_out = 1 ORDER BY id DESC LIMIT 12");
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
<h1 class="text-center"><i>POPULAR ITEMS</i></h1>
<div class="container-fluid">
<div class="row">
	<div class="col-md-2"><?php include 'widgets/leftbar.php'; ?></div>
	<div class="col-md-8">
		<div class="row">
		<?php foreach($viewed_id as $id):
             $products = $db->query("SELECT * FROM accesories WHERE id = '{$id}'");
             $product = mysqli_fetch_assoc($products);
          ?>
			<div class="col-md-3">
			<div class="product">
				<h3 class="text-center"><?=$product['title'];?></h3>
				<img src="<?=$product['image'];?>" width="100%" height="150px" class=""><a href="index.php?add=<?=$product['id'];?>"></a>
				<div class="item">
				<p class="list-price text-danger"><s>Ksh <?=$product['price']; ?></s></p>
				<p>Price: Ksh <?=$product['price'];?></p>
			    </div>
				<a href="index.php?add=<?=$product['id'];?>" class="add-button" >
				 <span class="glyphicon glyphicon-shopping-cart"></span> shop now!</a>
			</div>
			</div>
		<?php endforeach; ?>
		 
		</div>
	</div>
	<div class="col-md-2"><?php include 'widgets/rightbar.php'; ?></div>
</div>
</div>

<?php include '../footer.php'; ?>