<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/boutique/init.php';
  include '../accessories/heading/header.php';
  include 'head/navigation.php';

  $branchQ = $db->query("SELECT * FROM accesoriestype WHERE branch = 0");
  $i = 1;//for numbering items
  
  if (!logged_in_admin()) {
     login_redirect('login.php');
   }

  if (isset($_GET['inventory'])) {
  	$branch = (int)$_GET['inventory'];
  	$sql = $db->query("SELECT * FROM accesories WHERE branch = '$branch' AND deleted = 0 ORDER BY available DESC");
  	$sql2 = mysqli_fetch_assoc($db->query("SELECT * FROM accesoriestype WHERE id = '$branch'"));

  }else{
    $sql = $db->query("SELECT * FROM accesories WHERE deleted = 0 ORDER BY available DESC");
}
  
?>
<h2 class="text-center text-primary">KEEP TRACK OF ITEMS HERE</h2>
<div class="row">
	<div class="col-md-12">
		<h3 class="text-center text-success"><?=((isset($_GET['inventory']))?
		strtoupper($sql2['brand_name']):'ALL PRODUCTS')?></h3>
		<table class="table table-bordered table-condensed table-striped">
			
			<thead>
				<th>#</th>
				<th>Item</th>
				<th>Title</th>
				<th>Category</th>
				<th>Brand</th>
				<th>Available</th>
				<th>Sold</th>
				<th>Threshold</th>
				<th>Status</th>
			</thead>
			<tbody>
			 <?php while($item = mysqli_fetch_assoc($sql)):
                  $id = $item['brand_type'];
                  $category = $item['category'];
                $brandQ = $db->query("SELECT * FROM accesoriestype WHERE id = '$id'");
                  $categoryQ = $db->query("SELECT * FROM accesoriestype WHERE id = '$category'");
                  $brand = mysqli_fetch_assoc($brandQ);
                  $category = mysqli_fetch_assoc($categoryQ);
			 	?>
				<tr <?php if ($item['available'] == 0) {
					echo(' style="background-color:#f2dede;"');
				} 
				if ($item['available'] <= $item['threshold'] && $item['available'] > 0) {
					echo(' class="bg-warning"');
				}
				if ($item['available'] > $item['threshold']) {
					echo(' style="background-color:lime;"');
				}
				     ?>>
					<td><?=$i;?></td>
					<td>
 				<button type="button" class="btn btn-xs btn-info" onclick="image_modal(<?=$item['id'];?>)">image</button>
					</td>
					<td><?=$item['title'];?></td>
					<td><?=$category['brand_name'];?></td>
					<td><?=$brand['brand_name'];?></td>
					<td><?=$item['available'];?></td>
					<td><?=$item['sold'];?></td>
					<td><?=$item['threshold'];?></td>
					<td><?php if ($item['available'] == 0) {
					echo('OUT OF STOCK');
				} 
				if ($item['available'] <= $item['threshold'] && $item['available'] > 0) {
					echo('AT THRESHOLD');
				}
				if ($item['available'] > $item['threshold']) {
					echo('GOOD');
				}
				     ?></td>
				</tr>
			 <?php $i++; endwhile; ?>
			</tbody>
		  
		</table>
	</div>
</div>


<div class="row">
	<div class="col-md-2"></div>
	<div class="col-md-8">
		
		<div class="row">
			<?php while($branch = mysqli_fetch_assoc($branchQ)):?>
			<div class="col-md-4">
			<a href="inventory.php?inventory=<?=$branch['id'];?>" class="inventory-btn">
				VIEW <?=strtoupper($branch['brand_name']);?> ONLY</a>	
			</div>
			<?php endwhile; ?>
		</div>
		
	</div>
	<div class="col-md-2">
		<a href="inventory.php" class="inventory-btn">ALL PRODUCTS</a>
	</div>
</div>

<script>
	function image_modal(id){
		var data = {"id" : id};

		jQuery.ajax({
			url : '../admin_panel/image_modal.php',
			method : 'post',
			data : data,
			success : function(data){
              jQuery('body').append(data);
              jQuery('#details-modal').modal('toggle');
           },
            error :function(){
            alert("something went wrong!");
        }
		});
	}
</script>