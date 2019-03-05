<?php
   require_once $_SERVER['DOCUMENT_ROOT'].'/boutique/init.php';
    include '../accessories/heading/header.php';
   include 'navigation.php';
   
   $id = $_GET['id'];
   $sqlQuery = $db->query("SELECT * FROM accesories WHERE category = '{$id}' AND featured = 1");
   $parent = $db->query("SELECT * FROM accesoriestype WHERE id = '{$id}'");
   $result = mysqli_fetch_assoc($parent);

   $child = $db->query("SELECT * FROM accesoriestype WHERE parent = '{$id}'");
   $count = mysqli_num_rows($child);
   $i = 1;
   $cid = '';

?>

<!-- THE MAIN CATEGORY PAGE -->

<?php
   if (isset($_GET['cid'])) {
   	$cid = $_GET['cid'];
    $cQuery = $db->query("SELECT * FROM accesoriestype WHERE id = '{$cid}'");
    $cresults = mysqli_fetch_assoc($cQuery); 
   }
 ?>
<h1 class="text-center"><?=((isset($_GET['cid']))?'<i>'.strtoupper($cresults['brand_name']).'</i>':'');?></h1>
<div class="container-fluid">
<div class="row">
	<div class="col-md-2"></div>
	<div class="col-md-8">
		<?php
            if (isset($_GET['cid'])) {
            	$cid = $_GET['cid'];
            	$sql = $db->query("SELECT * FROM accesories WHERE brand_type = '$cid'");
            ?>
               <div class="row">
		  <?php while($sub_items = mysqli_fetch_assoc($sql)):?>
			<div class="col-md-3">
			<div class="product">
				<h3 class="text-center"><?=$sub_items['title'];?></h3>
        <?php $photos = explode(',', $sub_items['image']); ?>
				<img src="<?=$photos[0];?>" width="100%" height="150px" class="">
        <div class="item">
        <p class="list-price text-danger"><s>Ksh <?=$sub_items['price']; ?></s></p>
				<p>Price: Ksh <?=$sub_items['price'];?></p>
        </div>
				<a href="index.php?add=<?=$sub_items['id'];?>" class="add-button" >
         <span class="glyphicon glyphicon-shopping-cart"></span> shop now!</a>
			</div>
			</div>
		<?php endwhile; ?>
		   </div>
            <?php } else {
            ?>
             <div class="row">
		  <?php while($products = mysqli_fetch_assoc($sqlQuery)):?>
			<div class="col-md-4">
			<div class="product">
				<h3 class="text-center"><?=$products['title'];?></h3>
				<img src="<?=$products['image'];?>" width="100%" height="250px" class="">
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
            <?php }
		?>
	</div>
	<div class="col-md-2">
		
	</div>
</div>
</div>