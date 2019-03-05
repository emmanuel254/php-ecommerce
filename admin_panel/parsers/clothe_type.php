<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/boutique/init.php';

  $id = (int)$_POST['categoryId'];
  $selected = sanitize($_POST['selected']);

  $clothe_type_query = $db->query("SELECT * FROM accesoriestype WHERE parent = '{$id}' ORDER BY brand_name");

  ob_start();  ?>

  <option value=""></option>
  	<?php while($brandType = mysqli_fetch_assoc($clothe_type_query)):?>
  	  <option
  	   value="<?=$brandType['id'];?>"<?=(($selected == $brandType['id'])?' selected' : '')?>><?=$brandType['brand_name'];?></option>
     <?php endwhile; ?>
  <?php echo ob_get_clean();?>