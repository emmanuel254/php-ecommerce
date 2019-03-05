<?php
require_once 'init.php';

$id = $_POST['id'];
$id = (int)$id;
$sql = "SELECT * FROM products WHERE id = '$id'";
$result = $db->query($sql);
$product = mysqli_fetch_assoc($result);

$brand_id = $product['brand'];
$sql = "SELECT brand FROM brand WHERE id = '$brand_id'";
$brand_query = $db->query($sql);
$brand = mysqli_fetch_assoc($brand_query);

$sizestring = $product['sizes'];
$size_array = explode(',', $sizestring);

?>

<!--details modalls-->
<?php ob_start(); ?>


<div class="modal fade details-1" id="details-modal" tabindex="-1" role="dialog" aria-labelledby="details-1" aria-hidden="true">
<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<div class="modal-header">
          <h4 class="modal-title"><?=$product['title'];?></h4>
			<button class="close" type="button" onclick="closeModal()" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>

		</div>
<div class="modal-body">
	<div class="container-fluid">
		<div class="row">	
			<div class="col-sm-6 fotorama">
				<div class="center-block">
					<?php 
					$photos = explode(',', $product['image']);
					foreach($photos as $photo):
					?>
					<img src="<?=$photo; ?>" alt="<?=$product['title'];?>" class="details img-responsive" style="width: 90%; margin: 15px auto;">
	                <?php endforeach; ?>
				</div>
			</div>
			<div class="col-sm-6">
				<span id="modal_errors" class="bg-danger"></span>
				<h4>Details</h4>
				<p><?=$product['description']; ?></p><hr>
				<p>Price: $<?=$product['price']; ?></p>
				<p>Brand: <?=$brand['brand']; ?></p>
				<form action="add_cart.php" method="post" id="add_product_form">
				<div class="form-group">
				<input type="hidden" name="product_id" value="<?=$id; ?>">
				<input type="hidden" name="available" id="available" value="">
					
						<div class="col-md-4">
							<label for="quantity">Quantity: </label>
							<input type="number" class="form-control" id="quantity" name="quantity" min="0"><div class="col-xs-3">&nbsp;</div>
					</div>
						<label for="size">Size: </label>
						<select name="size" id="size" class="form-control">
							<option value=""></option>
						<?php  foreach ($size_array as $string) {
						  $string_array = explode(':', $string);
						  $size = $string_array[0];
						  $available = $string_array[1];
						  if ($available > 0) {
						  echo '<option value="'.$size.'" data-available="'.$available.'">'.(($size != '')?$size:'Size').' ('.(($available != '')?$available:'Not').' Available)</option>';
						  }
						}

						?>
						</select>
					</div>
					
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal-footer">
	<button class="btn btn-default" onclick="closeModal()">Close</button>
	<button class="btn btn-warning" onclick="add_to_cart();return false;"><span class="glyphicon glyphicon-shopping-cart"> Add to Cart</span></button>
</div>
</div>
</div>
</div>
<script>
   jQuery('#size').change(function(){
   	var available = jQuery('#size option:selected').data("available");
   	jQuery('#available').val(available);
   });

   // $(function(){
   //   $('.fotorama').fotorama({'loop':true,'autoplay':true});
   // });

	function closeModal(){
     jQuery('#details-modal').modal('hide');
     setTimeout(function(){
      
      jQuery('#details-modal').remove();
      jQuery('.modal-bacdrop').remove();
     },500);
	}
</script>

<?php echo ob_get_clean(); ?>