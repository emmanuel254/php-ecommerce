<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/boutique/init.php';
  include '../accessories/heading/header.php';
  include 'navigation.php';
   include '../includes/success.php';

  if (isset($_GET['add'])) {
  	$id = $_GET['add'];
  	$sql = $db->query("SELECT * FROM accesories WHERE id = '{$id}'");
  	$product = mysqli_fetch_assoc($sql);
  	$cat = $product['category'];
  	$brand = $product['brand_type'];
  	$catQ = $db->query("SELECT * FROM accesoriestype WHERE id = '$cat'");
  	$brandQ = $db->query("SELECT * FROM accesoriestype WHERE id = '$brand'");
  	$brands = mysqli_fetch_assoc($brandQ);
  	$category = mysqli_fetch_assoc($catQ);
    
 ?>

 <div class="row">
 	<div class="col-md-3"><?php include 'widgets/leftbar.php'; ?></div>
 	<div class="col-md-6 border">
 		<h1 class="text-center title"><?=$product['title'];?></h1>
 		 <img src="<?=$product['image'];?>" alt="<?=$product['title'];?>" class="add-cart-images"><hr>
 		 <span class="bg-danger" id="errors"></span>
 		 <p><b>Brand Name:</b> <?=$category['brand_name']; ?></p>
 		 <p><b>Category:</b> <?=$brands['brand_name'];?></p>
 		 <p><b>Price:</b> <?=money($product['price']);?></p>
 		 <p><b>Description:</b> <?=$product['description'];?></p><hr>
 		 
 		 <form action="access_cart.php" method="post" id="accessories_form">
 		 <div class="row">
 		 <div class="col-md-6">
 		 	 <input type="number" value="" name="quantity" id="quantity" class="form-control check" min="0" placeholder="Quantity">
 		 	<input type="hidden" name="available" id="available" value="<?=$product['available'];?>">
 		 	<input type="hidden" name="id" id="id" value="<?=$id;?>">
 		 	<input type="hidden" name="title" id="title" value="<?=$product['title'];?>">
 		 </div>
 		 <div class="col-md-3"><a href="index.php" class="cancel-add" style="margin-top: 5px;">Cancel</a></div>
 		 <div class="col-md-3">
 		 	<button class="btn btn-xs btn-info pull-right check" onclick="add_cart();return false;"><span class="glyphicon glyphicon-shopping-cart"></span>
 		 	Add to cart</button>
 		 </div>
 		 </div>
 		 </form>
 		
  	</div>
 	<div class="col-md-3"><?php include 'widgets/rightbar.php'; ?></div>
 </div>

 <?php }else{
  $sqlQuery = $db->query("SELECT * FROM accesories WHERE featured = 1");

 ?>
<h1 class="text-center"><i>ACCESSORIES</i></h1>
<div class="container-fluid">
<div class="row">
	<div class="col-md-2"><?php include 'widgets/leftbar.php'; ?></div>
	<div class="col-md-8">
		<div class="row">
		<?php while($products = mysqli_fetch_assoc($sqlQuery)):	?>
			<div class="col-md-4">
			<div class="product">
				<h3 class="text-center"><?=$products['title'];?></h3>
				<img src="<?=$products['image'];?>" width="100%" height="250px" class=""><a href="index.php?add=<?=$products['id'];?>"></a>
				<div class="item">
				<p class="list-price text-danger"><s>Ksh <?=$products['price']; ?></s></p>
				<p>Price: Ksh <?=$products['price'];?></p>
			    </div>
				<a href="index.php?add=<?=$products['id'];?>" class="add-button" >
				 <span class="glyphicon glyphicon-shopping-cart"></span> shop now!</a>
			</div>
			</div>
		<?php endwhile; ?>
		 
		</div>
	</div>
	<div class="col-md-2"><?php include 'widgets/rightbar.php'; ?></div>
</div>
</div>

<?php } include '../footer.php'; ?>
