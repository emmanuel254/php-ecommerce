 <?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/boutique/init.php';
    include '../accessories/heading/header.php';
    include 'head/navigation.php';

    if (!logged_in_admin()) {
     login_redirect('login.php');
   }

    $detailsQ = $db->query("
    	SELECT t.id,t.full_name,t.email,t.location,t.phone,t.town,t.constituency,t.location,t.payment_type,t.details,t.total_goods,t.grand_total,t.address,t.order_date,c.cart,c.shipped,c.checked_out
        FROM trans_accessories t
        LEFT JOIN cart_accessories c
        ON t.cart_id = c.id");
    $i = 1;

   if (isset($_GET['details'])) {
   	$id = (int)$_GET['details'];
   	$detailsQuery = $db->query("
    	SELECT t.id,t.full_name,t.email,t.location,t.phone,t.town,t.constituency,t.location,t.payment_type,t.details,t.total_goods,t.grand_total,t.address,t.order_date,c.cart,c.shipped,c.checked_out
        FROM trans_accessories t
        LEFT JOIN cart_accessories c
        ON t.cart_id = c.id
        WHERE t.id = '$id'");

    $details = mysqli_fetch_assoc($detailsQuery);
    $items = json_decode($details['cart'],true);
    $saved_image = '';
   ?>
    <div class="row">
      <div class="col-md-3">
      	<h4 class="text-center text-primary address">Order Details</h4>
      	<i><b>Client Name: </b></i><?=$details['full_name'];?><br>
      	<i><b>Total Goods: </b></i><?=$details['total_goods'];?><br>
      	<i><b>Grand Total: </b></i><?=money($details['grand_total']);?><br>
      	<i><b>Date Ordered: </b></i><?=$details['order_date'];?><br>

      </div>
      <div class="col-md-9">
      	<div class="row">
          <h3 class="text-center">You are required to deliver the following Items</h3>
      		<div class="col-md-8">
      			<div class="row">
      				<div class="col-md-3"><h4 class="text-center">Item</h4></div>
      				<div class="col-md-1"></div>
      				<div class="col-md-6"><h4 class="text-center">Description:</div>
      				<div class="col-md-2"><h4 class="text-center">Quantity:</div>
      			</div>
         	 	<?php
           foreach ($items as $item) {
           	$id = $item['id'];
              $quantity = $item['quantity'];

              $t = $db->query("SELECT * FROM accesories WHERE id = '$id'");
              $result = mysqli_fetch_assoc($t);
					    $cat = $result['category'];
					    $categoryQ = $db->query("SELECT * FROM accesoriestype WHERE id = '$cat'");
					    $category = mysqli_fetch_assoc($categoryQ);
					    $brands = $result['brand_type'];
					    $brandQ = $db->query("SELECT * FROM accesoriestype WHERE id = '$brands'");
					    $brand = mysqli_fetch_assoc($brandQ);
                    
                     ?>
         <div  class="row">
			<div class="col-md-3"><hr>
				<img src="<?=$result['image'];?>" class="responsive">
			</div>
			<div class="col-md-1"></div>
			<div class="col-md-6"></h4>
				<hr>
				<i>NAME:  </i><strong><?=$result['title'];?></strong><br>
				<i>CATEGORY:  </i><strong><?=$category['brand_name'];?></strong><br>
				<i>BRAND:  </i><strong><?=$brand['brand_name'];?></strong><br>
			</div>
			<div class="col-md-2"><hr>
				<i>ITEMS ORDERED: </i><strong><?=$quantity;?></strong>
			</div>
		</div>
   <?php  } ?>
      		</div>
      		<div class="col-md-4">
      			<h3 class="text-center text-primary address">Delivery Address</h3>
      			<address>
      				<i><b>Name: </b></i><?=$details['full_name'];?><br>
      				<i><b>Town: </b></i><?=$details['town'];?><br>
      				<i><b>Contituency: </b></i><?=$details['constituency'];?><br>
      				<i><b>Location: </b></i><?=$details['location'];?><br>
      				<i><b>Address: </b></i><?=$details['address'];?><br>
      				<i><b>Phone: </b></i><?=$details['phone'];?><br>
      				<?php if($details['details'] != ''):?>
      				 <i><b>Brief Details: </b></i><?=$details['details'];?>
      				<?php endif; ?>
      			</address>
      		</div>
      	</div>
      </div>
     </div>
   <?php
   }else { ?>
 <h2 class="text-center">MY DASHBOARD</h2>
 <div class="row">
 	<div class="col-md-2">
 		<h3 class="text-center">Contents</h3>
       <div class="dashboard">
 		<a href="index.php" class="link text-center"><p class="text-center sidebar">My dashboard</p></a><br>
 		<a href="inventory.php" class="link">
      <p class="text-center sidebar" style="margin-top: -35px;">Inventory</p></a><br>
 		<a href="sales.php" class="link">
      <p class="text-center sidebar" style="margin-top: -35px;">Sales</p></a><br>
 		<a href="#" class="link">
      <p class="text-center sidebar" style="margin-top: -35px;">Suppliers</p></a><br>
     </div>
 	</div>
 	<div class="col-md-8">
 		<table class="table table-bordered table-condensed table-striped">
 			<thead>
 				<th></th>
 				<th>Name</th>
 				<th>Number of items</th>
 				<th>Grand Total</th>
 				<th>Date Ordered</th>
 				<th>More</th>
 			</thead>
 			<tbody>
 			<?php while($details = mysqli_fetch_assoc($detailsQ)):?>
 			 <?php if($details['checked_out'] == 1):?>
 				<tr <?=(($details['grand_total'] > 5000)?'style="background-color:lime;"':'');
                    $name = $details['full_name']; 
 				?>>
 					<td><?=$i; ?></td>
 					<td><?=$name; ?></td>
 					<td><?=$details['total_goods'];?></td>
 					<td><?=$details['grand_total'];?></td>
 					<td><?=$details['order_date'];?></td>
 					<td>
 						<a href="index.php?details=<?=$details['id'];?>" class="btn btn-xs btn-info">Details</a>
 					</td>
 				</tr>
 			 <?php endif; ?>
 			<?php $i++; endwhile;?>
 			</tbody>
 		</table>
 	</div>
 	<div class="col-md-2">
    <i style="margin-left: 10px;">Hello: <?=$admins['first'];?></i><hr>
    <a href="" class="add-button" data-toggle="modal" data-target=".profile_form" class="add-button">profile</a>

      <!-- Modal for profile view-->
<div class="modal fade profile_form bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="profile_form_lable">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="profile_form_lable">My Profile</h4>
        <button type="button" class="btn btn-xs glyphicon glyphicon-remove" data-dismiss="modal"><span aria-hidden="true"></span></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
           <img src="<?=$admins['photo'];?>" width="100%" height="300px">
          </div>
          <div class="col-md-6">
            <i><strong>Name: </strong></i><?=$admins['full_name'];?><br><br>
            <i><strong>Email: </strong></i><?=$admins['email'];?><br>
            <i><strong>Phone: </strong></i><?=$admins['phone_no'];?><br>
            <i><strong>Registration no.: </strong></i><?=$admins['registration_no'];?><br>
            <i><strong>Department: </strong></i><?=$admins['department'];?><br>
            <i><strong>Date Of Birth: </strong></i><?=$admins['date_of_birth'];?><br>
            <i><strong>Age: </strong></i><?=$birth;?><br>
            <i><strong>Permission: </strong></i><?=$admins['permission'];?><br>
          </div>
          </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

    <div class="profile">
      <img src="<?=$admins['photo'];?>" height="200px" width="100%">
    </div>
    <i><b>NAME: </b></i><?=$admins['first']; ?><br>
    <i><b>PHONE: </b></i><?=$admins['phone_no'];?><br>
    <i><b>DEPARTMENT: </b></i><?=$admins['department'];?><br>
    <i><b>LAST LOGIN: </b></i><?=$admins['last_login'];?><br><hr>
    <a href="index.php?update_admin=<?=$admins['id'];?>" class="add-button"><span class="glyphicon glyphicon-pencil"></span>update</a>

    <?php
        if (isset($_GET['update_admin'])) {
          $name = ((isset($_POST['name']))?sanitize($_POST['name']):$admins['full_name']);
          $email = ((isset($_POST['email']))?sanitize($_POST['email']):$admins['email']);
          $phone = ((isset($_POST['phone']))?sanitize($_POST['phone']):$admins['phone_no']);
          $photo = ((isset($_POST['photo']))?sanitize($_POST['photo']):$admins['photo']);
          $saved_image = (($admins['photo'] != '')?$admins['photo']:'');
          $dbPath = $saved_image;

          if ($_POST) {
             $errors = [];
   
             $required = array(
              'name'    => 'Name',
              'email'    => 'Email',
              'phone' => 'Phone',
             );
             $allowed = array('jpg','png','jpeg','gif');
             foreach ($required as $field => $d) {
              if ($_POST[$field] == '') {
                 $errors[] = 'Please fill out the '.$d.' field';
              }
             }
             $tmpLoc = '';
             $uploadPath = '';
            if($_FILES['photo']['name'] != ''){
              var_dump($_FILES['photo']);

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
             $uploadPath = BASEURL.'admin_panel/users_profile_images/'.$uploadName;
             $dbPath = '/boutique/admin_panel/users_profile_images/'.$uploadName;

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
                  $sql = "UPDATE users_department SET full_name = '$name',phone_no = '$phone',email = '$email',photo = '$dbPath' WHERE id = '$admins_id'";
                  $db->query($sql) or die(mysqli_error($db));
                  ?><script>window.location='http://localhost/boutique/admin_panel/';</script><?php
                }
           }
          ?>
             <form class="form-group" method="post" action="index.php?update_admin=<?=$admins['id'];?>" enctype="multipart/form-data" width="80%">
               <label for="name">Name:</label>
               <input type="text" name="name" class="form-control"  value="<?=$admins['full_name'];?>">
               <label for="email">Email:</label>
               <input type="email" name="email" class="form-control" value="<?=$admins['email'];?>">
               <label for="phone">Phone:</label>
               <input type="number" name="phone" class="form-control" value="<?=$admins['phone_no'];?>">
               <label for="photo">Profile:</label>
               <input type="file" name="photo" class="form-control" value="<?=$admins['photo'];?>">
               <div class="row">
                <div class="col-md-6">
               <a href="index.php" class="cancel">Cancel</a>
                 </div>
                <div class="col-md-6">
               <button type="submit" class="update-button">Submit</button>
                </div>
               </div>
             </form>
          <?php
        }
    ?>
  </div>
 </div>

<?php }  include 'head/footer.php'; ?>