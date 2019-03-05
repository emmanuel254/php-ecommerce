<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/boutique/init.php';
  include 'heading/header.php';
  include 'navigation.php';
  
  $cartQuery = $db->query("SELECT * FROM cart_accessories WHERE id = '{$Acart_id}'");
  $result = mysqli_fetch_assoc($cartQuery);
  $cart = json_decode($result['cart'],true);
  $i = 1;
  $grand_total = 0;
  $sub_total = 0;
  $total_goods = 0;
?>
<?php if($Acart_id != ''):?>
<div class="row">
<div class="col-md-1"></div>
<div class="col-md-10">
  <h3 class="text-center">My Shopping Cart</h3>
	<table class="table table-condensed table-bordered table-striped">
		<thead>
			<th>#</th>
			<th></th>
			<th>Item</th>
			<th>Quantity</th>
			<th>Unit price</th>
			<th>Total</th>
			<th></th>
	</thead>
	<tbody>
	<?php foreach($cart as $items){
	   $id = $items['id'];
       $quantity = $items['quantity'];
       $sql = $db->query("SELECT * FROM accesories WHERE id = '{$id}'");
       $cartItems = mysqli_fetch_assoc($sql);
       $Total = $quantity * $cartItems['price'];
       
     ?>
       <tr class="items">
			<td><?=$i; ?></td>
			<td><img src="<?=$cartItems['image'];?>" alt="<?=$cartItems['title'];?>" class="images"></td>
			<td><?=$cartItems['title'];?></td>
			<td class="text-center"><?=$items['quantity'];?></td>
			<td><?=money($cartItems['price']);?></td>
			<td><?=money($Total);?></td>
			<td><button class="btn btn-danger remove_btn" onclick="delete_cart(<?=$id; ?>)">Remove</button>
			</td>
		</tr>
     <?php
        $i++;
        $total_goods += $items['quantity'];
        $grand_total += $Total;
      } 
      ?>
	</tbody>
	</table>
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-6">
	<table class="table table-striped table-bordered table-condensed">
		<thead>
			<th>VAT</th>
      <th>No.of goods</th>
			<th>Grand Total</th>
		</thead>
		<tbody>
			<tr>
				<td><?=money(0.00)?></td>
        <td><?=$total_goods;?></td>
				<td><?=money($grand_total);?></td>
			</tr>
		</tbody>
	</table>
  </div>
      <div class="col-md-2">
      	<button class="btn btn-xs btn-primary pull-right" data-toggle="modal" data-target=".checkout_form" onclick="">Checkout <span class="glyphicon glyphicon-ok"></span></button>
      </div>
</div>
</div>
<div class="col-md-1"></div>
</div>

<!-- Modal -->
<div class="modal fade checkout_form bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="checkout_form_lable">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="checkout_form_lable">Delivery Details</h4>
        <button type="button" class="btn btn-xs glyphicon glyphicon-remove" data-dismiss="modal"><span aria-hidden="true"></span></button>
      </div>
      <div class="modal-body">
        <span class="bg-danger" id="errors"></span>
        <form class="form-group" method="post" action="cart.php" id="checkout_form">
        <div class="row">
          <div class="col-md-4">
          	<label for="name">Name:</label>
          	<input type="text" class="form-control" id="name" name="name" placeholder="Full name">
          </div>
          <input type="hidden" name="grand_total" value="<?=$grand_total;?>">
          <input type="hidden" name="total_goods" value="<?=$total_goods;?>">
          <div class="col-md-4">
          	<label for="email">Email:</label>
          	<input type="email" class="form-control" id="email" name="email" placeholder="email adress">
          </div>
          <div class="col-md-4">
          	<label for="phone_no">Phone:</label>
          	<input type="text" class="form-control" id="phone" name="phone" 
            placeholder="+254(Kenya)">
          </div>
        </div>
         <div class="row">
          <div class="col-md-4">
            <label for="town">Town:</label>
            <input type="text" class="form-control" id="town" name="town" placeholder="Nearest towm">
          </div>
          <div class="col-md-4">
            <label for="constituency">Constituency:</label>
            <input type="text" class="form-control" id="constituency" name="constituency" placeholder="">
          </div>
          <div class="col-md-4">
            <label for="location">Location:</label>
            <input type="text" class="form-control" id="location" name="location" placeholder="">
          </div>
        </div>
         <div class="row">
          <div class="col-md-3">
            <label for="address">Address:</label>
            <input type="text" class="form-control" id="address" name="address" placeholder="Permanent address">
          </div>
          <div class="col-md-3">
            <label for="payment">Payment Type:</label>
            <select class="form-control" name="payment" id="payment">
              <option value="M~PESA">M~PESA</option>
              <option value="AIRTEL MONEY">AIRTEL MONEY</option>
              <option value="T~KASH">T~KASH</option>
            </select>
          </div>
          <div class="col-md-6">
            <label for="details">Brief details:</label>
            <textarea class="form-control" id="details" rows="4" name="details" placeholder="Enter hear a brief description about where you want to find your goods for example: Eldoret town near Naivas Supermarket"></textarea>
          </div>
        </div>
      </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="finish_purchase()">Finish</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Obtaining modal form details -->
<script>
  function finish_purchase(){
    jQuery('#errors').html("")
    var name = jQuery('#name').val();
    var email = jQuery('#email').val();
    var location = jQuery('#location').val();
    var phone = jQuery('#phone').val();
    var town = jQuery('#town').val();
    var address = jQuery('#address').val();
    var payment = jQuery('#payment').val();
    var error = [];

    if (name == '' || payment == '') {
        error += '<p class = "text-center text-danger">All details except <i>BRIEF DETAILS</i> are required</p>';
        jQuery('#errors').html(error);
        return;
       }
    if (email == '') {
        error += '<p class = "text-center text-danger">Email is required</p>';
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
    if (payment == '') {
        error += '<p class = "text-center text-danger">Please input a payment option</p>';
        jQuery('#errors').html(error);
        return;
       }

    var data = jQuery('#checkout_form').serialize();
    jQuery.ajax({
      url : '../accessories/parsers/checkout.php',
      method : 'post',
      data : data,

      success : function(){
        window.location = 'http://localhost/boutique/accessories/thanks.php';
      },
      error : function(){alert('Something went wrong')}
    })
  }
</script>


<?php else:?>
	<div class="text-center text-danger empty-cart">Your shopping cart is empty 
		<a href="index.php" class="link">Add Items?</a></div>
<?php endif;
  include '../footer.php';
 ?>
