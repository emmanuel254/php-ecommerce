<?php
 require_once 'init.php';
 include 'navigation.php';
 include 'head.php';

if (isset($_GET['cat'])) {
   $cat_id = sanitize($_GET['cat']);

}else{
   $cat_id = '';
}
 $sql = "SELECT * FROM products WHERE category = '$cat_id'";
 $productQ = $db->query($sql);

 $category = get_category($cat_id);

?>

<!DOCTYPE html>
<html>
<head>
	<title> Chesire's Boutique</title>
</head>
<body>

<!-- main content -->
<br><br><br><br><br><br>
<?php include '../boutique/includes/success.php';?>
<h2 class="text-center"><?=$category['parents'].' '.$category['child']; ?></h2><br>
    <div class="container-fluid">
    <div class="row">
	<?php include 'includes/leftbar.php';?>
	<div class="col-md-8">
		<div class="row">
			<?php while ($product = mysqli_fetch_assoc($productQ)) : ?>
			<div class="col-md-4">
				<div class="products">
				<h4><?=$product['title']; ?></h4><br>
				<?php $photos = explode(',', $product['image']) ?>
				<img src="<?=$photos[0]; ?>" alt="<?=$product['title']; ?>" class="img-thumb img-responsive"/>
				<p class="list-price text-danger">List Price:  <s>Ksh <?=$product['list_price']; ?></s></p>
				<p class="Price">Our Price:  Ksh <?=$product['price']; ?></p>
				<div class="row">
					<div class="col-md-6">
				Quantity:
				<input type="text" name="quantity" class="form-control" value="1" />
				  </div>
				  <div class="col-md-6">
				 Size:
				  <input type="text" name="quantity" class="form-control" value="1" />
				</div>
				</div>
				<button type="button" style="margin-top: 5px;" class="btn btn-sm btn-success" onclick="detailsmodal(<?=$product['id']; ?>)">Details</button>
				<button style="margin-top: 5px;" class="btn btn-sm btn-info pull-right" onclick="add_to_cart();return false;">Add to Cart</button>
			</div>
			</div>
		<?php endwhile; ?>
		</div>
	</div>
	<?php include 'includes/rightbar.php';?>
    </div>
   </div>

<?php 
include 'footer.php';

?>