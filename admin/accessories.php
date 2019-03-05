<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/boutique/init.php';
  include 'includes/head.php';
  include '../admin/includes/navigation.php';

   $parentQ = $db->query("SELECT * FROM accesoriestype WHERE parent = 0");
if (isset($_GET['delete'])) {
	$id = (int)$_GET['id'];
    
    $db->query("UPDATE accesories SET deleted = 1 WHERE id = '{$id}'") or die(mysqli_error($db));
    header('Location: accessories.php');
}

//adding a product to the website using featured button
if (isset($_GET['featured'])) {
  $id = (int)$_GET['id'];
  $featured = (int)$_GET['featured'];
  $sql = $db->query("SELECT * FROM accesories WHERE id = '$id'");
  $items = mysqli_fetch_assoc($sql);
  //check if the goods are enough in stock before featuring it
  if ($items['available'] == 0) {
    $_SESSION['error_flash']='Their are 0 '.$items['title'].' available. Restock first before featuring';
    header('location: accessories.php');
  }else{
  $db->query("UPDATE accesories SET featured = '$featured' WHERE id = '{$id}'") or die(mysqli_error($db));
    }
}

if(isset($_GET['add']) || isset($_GET['edit'])){
//initialization of the values to be entered in the database
	$title = ((isset($_POST['title']) && $_POST['title'] != '')?sanitize($_POST['title']):'');
	$price = ((isset($_POST['price']) && $_POST['price'] != '')?sanitize($_POST['price']):'');
  $available = ((isset($_POST['available']) && $_POST['available'] != '')?sanitize($_POST['available']):'');
	$description = ((isset($_POST['description']) && $_POST['description'] != '')?sanitize($_POST['description']):'');
	$category = ((isset($_POST['category']) && $_POST['category'] != '')?sanitize($_POST['category']):'');
  $threshold = ((isset($_POST['threshold']) && $_POST['threshold'] != '')?sanitize($_POST['threshold']): '');
  $brandType = ((isset($_POST['brand']) && $_POST['brand'] != '')?sanitize($_POST['brand']) :'');
  $parentQ = $db->query("SELECT * FROM accesoriestype WHERE parent = 0");
  $saved_image = '';

   if (isset($_GET['edit'])) {
    $edit_id = sanitize($_GET['id']);
    $products = $db->query("SELECT * FROM accesories WHERE id = '{$edit_id}'");
    $product = mysqli_fetch_assoc($products);

   	$title = ((isset($_POST['title']) && $_POST['title'] != '')?sanitize($_POST['title']):$product['title']);
   	$price = ((isset($_POST['price']) && $_POST['price'] != '')?sanitize($_POST['price']):$product['price']);
    $available = ((isset($_POST['available']) && $_POST['available'] != '')?
      sanitize($_POST['available']):$product['available']);
    $threshold = ((isset($_POST['threshold']) && $_POST['threshold'] != '')?
      sanitize($_POST['threshold']):$product['threshold']);
   	$description = ((isset($_POST['description']) && $_POST['description'] != '')?
      sanitize($_POST['description']):$product['description']);
   	$category = ((isset($_POST['category']) && $_POST['category'] != '')?
      sanitize($_POST['category']):$product['category']);
   	 $brand_id = $product['brand_type'];
   	 $brandQ = $db->query("SELECT * FROM accesoriestype WHERE id = '{$brand_id}'");
   	 $result = mysqli_fetch_assoc($brandQ);
   	$brandType = ((isset($_POST['brand']) && $_POST['brand'] != '')?sanitize($_POST['brand']) : $product['brand_type']);
   	$saved_image = (($product['image'] != '')?$product['image']:'');
   	$dbPath = $saved_image;
   }

  if ($_POST) {
  //	 var_dump($_FILES['photo']);
  	 $errors = [];
   
     $required = array(
      'title'    => 'Title',
      'price'    => 'Price',
      'category' => 'Category',
      'available'=> 'Available',
      'threshold' => 'Threshold'
     );
     $allowed = array('jpg','png','jpeg','gif');
     foreach ($required as $field => $d) {
     	if ($_POST[$field] == '') {
     	   $errors[] = 'Please fill out the '.$d.' field';
     	}
     }
     $tmpLoc = '';
     $uploadPath = '';
    if($saved_image == '' && $_FILES['photo']['name'] != ''){

  	 $photo_name = $_FILES['photo']['name'];
  	 $nameArray = explode('.', $photo_name);
  	 $file_name = $nameArray[0];
  	 $file_ext = $nameArray[1];
  	 $type = $_FILES['photo']['type'];
  	 $mime = explode('/', $type);
  	 $mimeType = $mime[0];
  	 $mimeExt = $mime[1];
  	 $tmpLoc = $_FILES['photo']['tmp_name'];
  	 $fileSize = $_FILES['photo']['size'];
  	 $uploadName = md5(microtime()).'.'.$file_ext;
  	 $uploadPath = BASEURL.'images/products/'.$uploadName;
  	 $dbPath = '/boutique/images/products/'.$uploadName;

  	 //filtering errors out
  	 if ($mimeType != 'image') {
  	 	$errors[] = 'File must be an image';
  	 }
  	 if (!in_array($file_ext, $allowed)) {
  	   $errors[] = 'The file must be a png,jpeg,jpg or a gif';
  	 }
  	 if ($fileSize > 1500000) {
  	 	$errors[] = 'Only files bellow 15MB is allowed';
  	 }
  	 }

  	 if (!empty($errors)) {
  	 	echo display_errors($errors);
  	 }else{
  	 	//move file to the specified folder
  	 	move_uploaded_file($tmpLoc, $uploadPath);
  	 	//insert accessory into database
      $sql = ("
        INSERT INTO  accesories (title,price,category,brand_type,image,available,threshold,description)
        VALUES ('$title','$price','$category','$brandType','$dbPath','$available','$threshold','$description')") 
        or die(mysqli_error($db));
        $_SESSION['success_flash'] = 'One product added to stock successfully';


  	 	if (isset($_GET['edit'])) {
  	 	 $sql = ("
          UPDATE `accesories` SET `title`='$title',`category`='$category',`brand_type`='$brandType',`price`='$price',`image`='$dbPath',`available` = $available,`threshold` = '$threshold',`description`='$description'
          WHERE id= '$edit_id'
  	 	   ") or die(mysqli_error($db));
       $_SESSION['success_flash'] = 'Product details updated';
  	 	}
        $db->query($sql);
        header('location: accessories.php');
  	 }

  }
  
?>
  <div class="row">
  	<div class="col-md-1"></div>
  	<div class="col-md-10">
  		<h2 class="text-center">Add Accessories</h2>
  		<form action="accessories.php?<?=((isset($_GET['edit']))?'edit&id='.$edit_id:'add=1')?>" method="POST" enctype="multipart/form-data">
  			<div class="row">
  				<div class="col-md-3">
  					<label for="title">Title:</label>
  					<input type="text" id="title" name="title" class="form-control" value="<?=$title;?>">
  				</div>
  				<div class="col-md-3">
  					<label for="price">Price:</label>
  					<input type="text" id="price" name="price" class="form-control" value="<?=$price;?>">
  				</div>
  				<div class="col-md-3">
  				<label for="category">Category:</label>
  				<select class="form-control" id="category" name="category">
  					<option value=""<?=(($category == '')?' selected':'')?>></option>
  					<?php while($result = mysqli_fetch_assoc($parentQ)):?>
  					<option value="<?=$result['id'];?>"<?=(($category == $result['id'])?' selected':'')?>><?=$result['brand_name'];?></option>
  				    <?php endwhile;?>
  				</select>
  				</div>
  				<div class="col-md-3">
  					<label for="brand">Brand Type:</label>
  					<select id="brand" name="brand" class="form-control"></select>
  				</div>
  		</div>
  			<div class="row" style="margin-top: 30px;">
          <div class="col-md-6">
            <label for="description">Description:</label>
            <textarea type="text" id="description" name="description" class="form-control" rows="4"><?=$description;?></textarea>
          </div>
          <div class="col-md-3">
            <label for="available">Available:</label>
            <input type="number" id="available" name="available" class="form-control" min="1"
             value="<?=$available;?>">
          </div>
          <div class="col-md-3">
            <label for="threshold">Threshold:</label>
            <input type="text" name="threshold" class="form-control" value="<?=$threshold?>">
          </div>
        </div>
  			   <div class="row">
            <div class="col-md-6">
        <?php if($saved_image != ''):?>
          <div class="col-md-3">
          <img src="<?=$saved_image;?>" alt=" saved image">
            </div>
        <?php else: ?>
          <label for="photo">Image:</label>
          <input type="file" name="photo" id="photo" class="form-control">
        <?php endif; ?>
           </div>
            <div class="col-md-6">
  			   	<button  type="submit" class="btn btn-xs btn-primary pull-right"><?=((isset($_GET['edit']))?'Edit':'Add');?></button>
  			   	<a href="accessories.php" style="margin-right: 15px;" class="btn btn-xs btn-warning pull-right">Cancel</a>
           </div>
  			</div>
  		</form>

  	</div>
  	<div class="col-md-1"></div>
  </div>
<?php }else{
 $productQ = $db->query("SELECT * FROM accesories WHERE deleted = 0");
  $i = 1;
?>
<h1 class="text-center">Accessories</h1>
<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-10">
<table class="table table-condensed table-striped table-bordered">
	<thead>
		<th>#</th>
		<th>Title</th>
		<th>Price</th>
		<th>Category</th>
		<th>Featured</th>
		<th>Sold</th>
		<th></th>
	</thead>
	<tbody>
		<tr>
		<?php while($result = mysqli_fetch_assoc($productQ)):?>
		<td><?=$i;?></td>
		<td><?=$result['title'];?></td>
		<td><?=$result['price'];?></td>
		<td></td>
		<td width="200px">
			<a href="accessories.php?featured=<?=(($result['featured']==0)?'1':'0'); ?>&id=<?=$result['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-<?=(($result['featured'] == 1)?'minus':'plus');?>"></span></a>
    	&nbsp <?=(($result['featured']==1)?'Featured Product':'');?>
       </td>
		<td>0</td>
		<td style="width: 150px;">
            <a href="accessories.php?delete&id=<?=$result['id'];?>" class="btn btn-xs pull-right"><span class="glyphicon glyphicon-remove"></span></a>
		    <a href="accessories.php?edit&id=<?=$result['id'];?>" class="btn btn-xs pull-right"><span class="glyphicon glyphicon-pencil"></span></a>
		</td>
		</tr>
		<?php $i++;?>
		<?php endwhile;?>	
	</tbody>
 </table>
   	  <a class="btn btn-xs btn-primary pull-right" href="accessories.php?add=1">Add Accessory</a>
   </div>
   <div class="col-md-1"></div>
</div>
<div class="container-fluid">
<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-5">
		<?php include 'additions/brands_available.php'; ?>
     </div>
	<div class="col-md-5">
		<?php include 'additions/brand_category.php';?>
	</div>
	<div class="col-md-1"></div>
</div>
</div>


<?php }
  include 'includes/footer.php';
?>
<script>
	jQuery('document').ready(function(){
    get_brand_type('<?=$brandType; ?>');
  });
</script>
