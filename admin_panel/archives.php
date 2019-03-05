 <?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/boutique/init.php';
    include '../accessories/heading/header.php';
    include 'head/navigation.php';

    if (!logged_in_admin()) {
     login_redirect('login.php');
   }
  
  $sql = $db->query("SELECT * FROM accesories WHERE deleted = 1");
  $i = 1;

  if (isset($_GET['delete'])) {
  	$id = sanitize((int)$_GET['delete']);
  	echo($id);
  	$db->query("DELETE FROM accesories WHERE id = '$id'") or die(mysqli_error($db));
  	header('Location: archives.php');
  }
  if (isset($_GET['restore'])) {
  	$id = sanitize((int)$_GET['restore']);
  	$db->query("UPDATE accesories SET deleted = 0 WHERE id = '$id'") or die(mysqli_error($db));
  	header('Location: archives.php');
  }
 ?>
 <div class="row">
 	<div class="col-md-2"></div>
 	<div class="col-md-8">
 		<h2 class="text-center">ARCHIVED GOODS</h2>
 		<table class="table table-condensed table-striped table-bordered">
 			<thead>
 				<th>#</th>
 				<th>Title</th>
 				<th>Category</th>
 				<th>Brand</th>
 				<th>Sold</th>
 				<th>Available</th>
 				<th>Image</th>
 				<th width="150px">Action</th>
 		</thead>
 		<tbody>
 			<?php while($deleted = mysqli_fetch_assoc($sql)):
             $id = $deleted['brand_type'];
	          $category = $deleted['category'];
	        $brandQ = $db->query("SELECT * FROM accesoriestype WHERE id = '$id'");
	          $categoryQ = $db->query("SELECT * FROM accesoriestype WHERE id = '$category'");
	          $brand = mysqli_fetch_assoc($brandQ);
	          $category = mysqli_fetch_assoc($categoryQ);
 				?>
 			<tr>
	 			<td><?=$i ;?></td>
	 			<td><?=$deleted['title'] ;?></td>
	 			<td><?=$category['brand_name'];?></td>
	 			<td><?=$brand['brand_name'];?></td>
	 			<td><?=$deleted['sold'] ;?></td>
	 			<td><?=$deleted['available'];?></td>
	 			<td><button type="button" class="btn btn-xs btn-info"
	 			 onclick="image_modal(<?=$deleted['id'];?>)">view</button></td>
	 			<td>
	 				<a href="archives.php?delete=<?=$deleted['id'];?>" class="btn btn-danger" >
	 				<span class="glyphicon glyphicon-remove"></span></a>
	 				<a href="archives.php?restore=<?=$deleted['id'];?>" class="btn btn-primary pull-right">
	 				<span class="glyphicon glyphicon-refresh"></span></a>
	 			</td>
 			</tr>
 		  <?php $i++; endwhile; ?>
 		</tbody>
 		</table>
 	</div>
 	<div class="col-md-2"></div>
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