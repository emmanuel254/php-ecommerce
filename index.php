 <?php
 require_once 'init.php';
 include 'navigation.php';
 include 'head.php';

 $sql = "SELECT * FROM products WHERE featured = 1";
 $featured = $db->query($sql);

?>
<!-- main content -->
<section>
<br><br><br><br><br><br>
<?php include '../boutique/includes/success.php';?>
<h2 class="text-center">Feature Products</h2><br>
	<div class="fotorama photo" data-width="700" data-ratio="700/467" data-max-width="100%">
	<img src="/boutique/images/products/9068f37d5eeb1b83156712cc7d981e65.png">
	<img src="/boutique/images/products/926d9307f4963666fcef7b1eab218e1b.png">
	<img src="/boutique/images/products/4dd553b8afe53cb5491756f4710d7a7d.png">
	<img src="/boutique/images/products/24aab51a0baf8ade9a00add64bf8002c.png">
	</div>
    <div class="container-fluid">
    <div class="row">
	<?php include 'includes/leftbar.php';?>
	<div class="col-md-8">
		<div class="row">
			<?php while ($product = mysqli_fetch_assoc($featured)) : ?>
			<?php
			$sizestring = $product['sizes'];
            $size_array = explode(',', $sizestring);

			?>
			<div class="col-md-4">
				<div class="products">
				<h4><?=$product['title']; ?></h4><br>
				<?php $photos = explode(',', $product['image']) ?>
				<img src="<?=$photos[0]; ?>" alt="<?=$product['title']; ?>" class="img-thumb img-responsive"/>
				<p class="list-price text-danger">List Price: <s>Ksh <?=$product['list_price']; ?></s></p>
				<p class="Price">Our Price: Ksh <?=$product['price']; ?></p>
				<button type="button" style="margin-top: 5px;" class="btn btn-sm btn-success" onclick="detailsmodal(<?=$product['id']; ?>)">Details</button>
				<button style="margin-top: 5px;" class="btn btn-sm btn-info pull-right" onclick="add_cart();return false;">Add to Cart</button>
			</div>
			</div>
		<?php endwhile; ?>
		</div>
	</div>
		<?php include 'includes/rightbar.php';?>
		</div>
	</div>
	</section>

<?php 
include 'footer.php';

?>
