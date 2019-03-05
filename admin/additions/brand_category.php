<?php
     // $sql = "SELECT b.id AS 'brand id', b.brand_name AS 'brand',c.id AS 'cat id',c.brand_name AS 'brand category'
     //         FROM accesoriestype c
     //         INNER JOIN accesoriestype b
     //         ON c.parent = b.id
     //         WHERE c.id = 6";
?>
<style>
	.tbrand{
		background-color: lime;
		font-size:24px;
	}
	.cbrand{
		font-size: 19px;
		background-color: aqua;
	}
</style>
<h2 class="text-center">Brand Category</h2>
<table class="table table-bordered table-condensed table-striped">
	<thead>
		<th>#</th>
		<th><h3>Brands & its categories</h3></th>
		<th width="105px"></th>
	</thead>
	<tbody>
	  <?php
         $sql = "SELECT * FROM accesoriestype WHERE parent = 0 ORDER BY brand_name";
         $pQuery = $db->query($sql);
         $i = 1;
	   while($presult = mysqli_fetch_assoc($pQuery)):
	   	?>
		<tr>
		   <td class="tbrand"><?=$i; ?></td>
		   <td class="tbrand"><?=$presult['brand_name'];?></td>
		   <td>
		   </td>	
		</tr>
        <tr>
       <?php
             $parentId = $presult['id'];
	         $sql2 = "SELECT * FROM accesoriestype WHERE parent = '$parentId'";
	         $cQuery = $db->query($sql2);
	         
	         while($cresult = mysqli_fetch_assoc($cQuery)):
        ?>
        	<td class="text-center">.</td>
        	<td class="cbrand"><?=$cresult['brand_name'];?></td>
        	<td>
        	<a href="accessories.php?delete_category&id=<?=$cresult['id'];?>" class="btn btn-xs pull-right"><span class="glyphicon glyphicon-remove"></span></a>
		    <a href="accessories.php?edit_category&id=<?=$cresult['id'];?>" class="btn btn-xs pull-right"><span class="glyphicon glyphicon-pencil"></span></a>
        	</td>
        </tr>
      <?php endwhile; ?>
	  <?php $i++; endwhile; ?>
	</tbody>
</table>
<!-- Form of adding accessories -->
<?php

if (isset($_GET['delete_category'])) {
	$deleteId = (int)$_GET['id'];
	$deleteId = sanitize($deleteId);

	$sql = "SELECT * FROM accesoriestype WHERE id = '$deleteId'";
	$result = $db->query($sql);
	$category = mysqli_fetch_assoc($result);

	if ($category['parent'] == 0) {
		$db->query("DELETE FROM accesoriestype WHERE parent = '$deleteId'");
	}
	$db->query("DELETE FROM accesoriestype WHERE id = '$deleteId'");
	//header('location: accessories.php');
	
}

 if (isset($_GET['edit_category'])) {
	 	$edit_id = (int)$_GET['id'];
	 	$edit_id = sanitize($edit_id);
        $e_query = $db->query("SELECT * FROM accesoriestype WHERE id = '$edit_id'");
        $e_result = mysqli_fetch_assoc($e_query);
	 }

if ($_POST && !empty($_POST)) {
		$brand = sanitize($_POST['brand']);
		$category = sanitize($_POST['category']);

		//echo($brand.','.$category);
     $sql = $db->query("SELECT * FROM accesoriestype WHERE parent = '$brand' AND brand_name = '$category'");
	  if (isset($_GET['edit_category'])) {
	 $id = $e_result['id'];
	 $sql = $db->query("SELECT * FROM accesoriestype WHERE parent = '$brand' AND brand_name = '$category'");	
		  }
      $row = mysqli_num_rows($sql);
      if ($category == '') {
      	$errors[] = 'Fill out the category field';
      }
      if ($row > 0) {
      	$errors[] = $category.' category already exists';
      }
      if ($brand == 0) {
      	$errors[] = 'main brand is added in the <i><b>BRAND</b></i> section';
      }
      if (!empty($errors)) {
      	echo display_errors($errors);
      }
      else{
      	// add to database or edit database
      	  $sql2 = ("INSERT INTO accesoriestype(parent,brand_name) VALUES ('$brand','$category')");
      	if (isset($_GET['edit_category'])) {
     $sql2 = ("UPDATE accesoriestype SET parent = '$brand', brand_name = '$category' WHERE id='$edit_id'");
      	}
      	$db->query($sql2);
      	?><script> window.location.reload('http://localhost/boutique/admin/accessories.php');</script><?php
      }

	}
  $parent_value = 0;
  $category_value = '';
  if (isset($_GET['edit_category'])) {
  	$category_value = $e_result['brand_name'];
  	$parent_value = $e_result['parent'];
  }
?>
<?php if(isset($_GET['edit_category']) || isset($_GET['add_category'])):?>
<div class="row">
	<div class="col-md-4">
	<form action="accessories.php?<?=((isset($_GET['edit_category']))?'edit_category&id='.$edit_id:'add_category=1');?>" method="post" class="form">
	
		<legend for="brand">Brand:</legend>
		<?php 
            $brandQ = $db->query("SELECT * FROM accesoriestype WHERE parent = 0");
		?>
		<select class="form-control" name="brand" id="brand">
			<option value="0"<?=($parent_value == 0)?' selected="selected"':'';?>>Parent</option>
			<?php while($brand = mysqli_fetch_assoc($brandQ)):?>
				<option value="<?=$brand['id'];?>"<?=(($parent_value == $brand['id'])?' selected="selected"':'');?>><?=$brand['brand_name'];?></option>
			<?php endwhile; ?>
		</select>
	</div>
	<div class="col-md-4">
		<legend for="category">Category:</legend>
   	<input type="text" name="category" id="category" class="form-control" value="<?=$category_value;?>">
   </div>
     <div class="col-md-4" style="margin-top: 40px;">
   <a href="accessories.php" class="btn btn-xs btn-warning">Cancel</a>
   <input type="submit" name="add_category" value="<?=(isset($_GET['edit_category']))?'edit':'add';?>" class="btn btn-xs btn-success">
   </form>
</div>
<?php endif; ?>
<div class="row" style="margin-top: 10px;">
<div class="col-md-3">
	<a href="accessories.php?add_category=1" style="display: <?=(isset($_GET['edit_category']) || isset($_GET['add_category']))?'none;':'';?>" class="btn btn-xs btn-primary">add category</a>
</div>
<div class="col-md-9">
<?php if(isset($_GET['edit_category']) || isset($_GET['add_category'])):?>
  
<?php endif; ?>
</div>
</div>