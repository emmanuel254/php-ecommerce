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
 	<div class="col-md-3"></div>
 	<div class="col-md-6 border">
 		<h1 class="text-center title"><?=$product['title'];?></h1>

     <!-- start -->
 	   <div id="myCarousel" class="carousel slide" data-ride="carousel" height="300px">
        <div class="carousel-inner">
          <div class="carousel-item active">
          	<?php $photos = explode(',', $product['image']); ?>
                <img class="first-slide" src="<?=$photos[0];?>" alt="First slide">
          </div>
          <?php  
            $photos = explode(',', $product['image']);
 		    foreach($photos as $photo): ?>
	          <div class="carousel-item">
	            <img class="product" src="<?=$photo;?>" alt="Second slide">
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
 		<!-- end -->
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
			<div class="col-md-3">
			<div class="product">
				<h3 class="text-center"><?=$products['title'];?></h3>
				<?php $photos = explode(',', $products['image']); ?>
				<img src="<?=$photos[0];?>" width="100%" height="150px" class=""><a href="index.php?add=<?=$products['id'];?>"></a>
				<div class="item">
				<p class="list-price text-danger"><s>Ksh <?=$products['list_price']; ?></s></p>
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
