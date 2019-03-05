<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/boutique/init.php';
  include '../accessories/navigation.php';
  include '../accessories/heading/header.php';
  //domain  for unsetting cookie
  $domain = ($_SERVER['HTTP_HOST'] != 'localhost')?'.'.$_SERVER['HTTP_HOST']:false;
  if ($Acart_id != '') {
  $sql = $db->query("SELECT * FROM cart_accessories WHERE id = '$Acart_id'");
 
  $items_ordered = mysqli_fetch_assoc($sql);
  $json_items = json_decode($items_ordered['cart'],true);

  //client details adress fetching
  $info = $db->query("SELECT * FROM trans_accessories WHERE cart_id = '$Acart_id'");
  $address = mysqli_fetch_assoc($info);

  if (!empty($address['full_name'])) {
  
?>

<h1 class="text-center title">Great for the purchase!!</h1>
<div class="row">
	<div class="col-md-3"><h2 class="text-center">HERE IS YOUR DELIVERY ADDRESS</h2><hr>
      <address>
      	  <b>Name: </b><i><?=$address['full_name'];?></i><br>
          <b>Town: </b><i><?=$address['town'];?></i><br>
          <b>Constituency: </b><i><?=$address['constituency'];?></i><br>
          <b>Location: </b><i><?=$address['location'];?></i><br>
          <b>Address: </b><i><?=$address['address'];?></i><br>
          <b>Phone: </b><i><?=$address['phone'];?></i><br>
          <?php if($address['details'] != ''):?>
          	<b>Phone: </b><i><?=$address['details'];?></i><br>
          <?php endif; ?>
      </address>
      <p class="text-center">Wrong details?</p>
      <a class="button" data-toggle="modal" data-target=".checkout_form" onclick="">Change <span class="glyphicon glyphicon-pencil"></span></a>
	</div>
	<div class="col-md-7">
		<h4>The following products will be deliverd to you as soon as possible</h4>
		<?php foreach ($json_items as $item) {
			  $id = $item['id'];
        $quantity = $item['quantity'];
		    $productQ = $db->query("SELECT * FROM accesories WHERE id = '$id'");
		    $products = mysqli_fetch_assoc($productQ);
		    $cat = $products['category'];
        $available = $products['available'];
        $sold = $products['sold'];
		    $categoryQ = $db->query("SELECT * FROM accesoriestype WHERE id = '$cat'");
		    $category = mysqli_fetch_assoc($categoryQ);
		    $brands = $products['brand_type'];
		    $brandQ = $db->query("SELECT * FROM accesoriestype WHERE id = '$brands'");
		    $brand = mysqli_fetch_assoc($brandQ);

        $new_available = ($available - $quantity);
        $new_sold = ($sold + $quantity);
        if ($new_available <= 0) {
          $update = ("UPDATE accesories SET available = 0,featured = 0,sold = '$new_sold' 
                    WHERE id = '{$id}'");
        }else{
        $update = ("UPDATE accesories SET available = '$new_available',sold = '$new_sold' 
                    WHERE id = '{$id}'");
          }
        $db->query($update) or die(mysqli_error($db));
		   ?>
         <div  class="row">
			<div class="col-md-3"><hr>
				<img src="<?=$products['image'];?>" class="responsive">
			</div>
			<div class="col-md-1"></div>
			<div class="col-md-6"><hr>
				<i>ITEM NAME:  </i><strong><?=$products['title'];?></strong><br>
				<i>CATEGORY:  </i><strong><?=$category['brand_name'];?></strong><br>
				<i>BRAND:  </i><strong><?=$brand['brand_name'];?></strong><br>
        <i>QUANTITY: </i><strong><?=$quantity;?></strong>
			</div>
			<div class="col-md-3">
			</div>
		</div>
		   <?php
		} ?>
	</div>
	<div class="col-md-2">
		<h4 class="text-center">Worth of Goods Ordered</h4>
		<strong>Grand Total: </strong><br>
		<i><b><?=money($address['grand_total']);?></b></i>
	</div>
</div>

<!-- Modal -->
<div class="modal fade checkout_form bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="checkout_form_lable">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="checkout_form_lable">Update Delivery Details</h4>
        <button type="button" class="btn btn-xs glyphicon glyphicon-remove" data-dismiss="modal"><span aria-hidden="true"></span></button>
      </div>
      <div class="modal-body">
        <span class="bg-danger" id="errors"></span>
      <form class="form-group" method="post" action="thanks.php" id="checkout_form">
        <div class="row">
          <div class="col-md-3">
          	<label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" 
            value="<?=$address['full_name'];?>">
          </div>
          <div class="col-md-3">
          	<label for="phone_no">Phone:</label>
          	<input type="text" class="form-control" id="phone" name="phone" 
            value="<?=$address['phone'];?>" ">
          </div>
          <div class="col-md-3">
            <label for="town">Town:</label>
            <input type="text" class="form-control" id="town" name="town" value="<?=$address['town'];?>">
          </div>
          <div class="col-md-3">
            <label for="constituency">Constituency:</label>
            <input type="text" class="form-control" id="constituency" name="constituency" 
            value="<?=$address['constituency'];?>">
          </div>
          </div>
          <div class="row">
          <div class="col-md-3">
            <label for="location">Location:</label>
            <input type="text" class="form-control" id="location" name="location" 
            value="<?=$address['location'];?>">
          </div>
          <div class="col-md-3">
            <label for="address">Address:</label>
            <input type="text" class="form-control" id="address" name="address" 
            value="<?=$address['address'];?>">
          </div>
          <div class="col-md-6">
            <label for="details">Brief details:</label>
            <textarea class="form-control" id="details" rows="4" name="details" 
            value="<?=$address['details'];?>"></textarea>
          </div>
        </div>
      </form>
      </div>
      <div class="modal-footer">
      <a type="submit" onclick="update_details()" class="btn btn-xs btn-primary" ">Update</a>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
	function update_details(){
		jQuery('#errors').html("")
    var name = jQuery('#name').val();
    var location = jQuery('#location').val();
    var phone = jQuery('#phone').val();
    var town = jQuery('#town').val();
    var address = jQuery('#address').val();
    var error = [];
	var data = jQuery('#checkout_form').serialize();

	    if (name == '') {
        error += '<p class = "text-center text-danger">All details except <i>BRIEF DETAILS</i> are required</p>';
        jQuery('#errors').html(error);
        return;
       }
    if (location == '' || town == '' || constituency == '') {
        error += '<p class = "text-center text-danger">Enter your Town, Constituency and Location</p>';
        jQuery('#errors').html(error);
        return;
       }
    if (phone == '') {
        error += '<p class = "text-center text-danger">Input Phone number</p>';
        jQuery('#errors').html(error);
        return;
       }
    if (address == '') {
        error += '<p class = "text-center text-danger">Check your address before submitting</p>';
        jQuery('#errors').html(error);
        return;
       }
		jQuery.ajax({
           url :  '../accessories/parsers/update_details.php',
           method : 'post',
           data : data,
           success : function(){
           	window.location = 'http://localhost/boutique/accessories/thanks.php';
           },
           error : function(){alert("something went wrong")}
		});
	}
</script>

<?php
     }else{
      ?>
       <script>
        window.location = 'http://localhost/boutique/accessories/';
       </script>
    <?php
     }
  }

  if ($Acart_id == '') {
  	?>
       <script>
       	window.location = 'http://localhost/boutique/accessories/';
       </script>
  	<?php
  }
?>
