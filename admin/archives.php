<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/boutique/init.php';
    if (!is_logged_in()) {
    login_error_redirect();
  }
  include 'includes/navigation.php';
  include 'includes/head.php';

 $sql = "SELECT * FROM products WHERE deleted = 1";
$presults = $db->query($sql);

if (isset($_GET['edit'])) {
  $id = sanitize($_GET['edit']);
  $db->query("UPDATE products SET deleted = 0 WHERE id = '$id'");
  
  header('Location: archives.php');
}

if (isset($_GET['delete'])) {
	$id = (int)$_GET['delete'];
	$id = sanitize($id);
	$db->query("DELETE FROM products WHERE id = '$id'");
	header('Location: archives.php');
}

?>
<h2 class="text-center">Products</h2><hr>
<table class="table table-bordered table-condensed table-striped">
	<thead><th></th><th>Products</th><th>Price</th><th>Category</th></thead>
<tbody>
	<?php while($product = mysqli_fetch_assoc($presults)):
    $childID = $product['category'];
    $catsql = "SELECT * FROM categories WHERE id = '$childID'";
    $result= $db->query($catsql);
    $child = mysqli_fetch_assoc($result);
    $parentID = $child['parents'];
    $pSql = "SELECT * FROM categories WHERE id = '$parentID'";
    $presult = $db->query($pSql);
    $parent = mysqli_fetch_assoc($presult);
    $category = $parent['category'].'~'.$child['category'];

	?>
    <tr>
    	<td>
    		<a href="archives.php?edit=<?=$product['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-download-alt"></span>Add to products</a>
    		<a href="archives.php?delete=<?=$product['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove"></span>Delete permanently</a>
    	</td>
    	<td><?=$product['title'];?></td>
    	<td><?=money($product['price']);?></td>
    	<td><?=$category?></td>
    </tr>
	<?php endwhile;?>
</tbody>
</table><hr>
<?php 
include 'includes/footer.php';
?>