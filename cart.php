<?php
  require_once 'init.php';
  include 'navigation.php';
  include 'head.php';

  if ($cart_id != '') {
  	$cartQ = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
  	$result = mysqli_fetch_assoc($cartQ);
  	$items = json_decode($result['items'],true);//true forses json_decode to return  an associative array instead of an object
  	$i = 1;
  	$sub_total = 0;
  	$item_count = 0;
  }

?>
<div class="col-md-12">
  <br><br><br><br><br><br>
  <?php include '../boutique/includes/success.php';?>
		<h2 class="text-center">My Shopping Cart</h2><hr>
		<?php if($cart_id == ''): ?>
		<div style="background-color: #f2dede;">
		<p class="text-center text-danger">
			Your Shopping cart is empty
		</p>
        </div>
       <?php else: ?><hr>
       	<table class="table table-bordered table-condensed table-striped">
       		<thead><th>#</th><th>Item</th><th>Price</th><th>Quantity</th><th>Size</th><th>Sub Total</th></thead>
       		<tbody>
       			<?php
                  foreach($items as $item){
                  	$product_id = $item['id'];
                  	$productQ = $db->query("SELECT * FROM products WHERE id = '{$product_id}'");
                  	$product = mysqli_fetch_assoc($productQ);
                  	$sArray = explode(',', $product['sizes']);
                  	foreach ($sArray as $sizeString) {
                  		$s = explode(':', $sizeString);
                  		if ($s[0] == $item['size']) {
                  		  $available = $s[1];
                  		}
                  	}

                  	?>
                     <tr>
                     	<td><?=$i; ?></td>
                     	<td><?=$product['title']; ?>
                          <img src="<?=$product['image']?>" width="35px" height="25px">
                      </td>
                     	<td><?=money($product['price']); ?></td>
                     	<td>
                        <button class="btn btn-xs btn-default" onclick="update_cart('removeone','<?=$product_id; ?>','<?=$item['size']?>')">-</button>
                        <?=$item['quantity']; ?>
                        <?php if($item['quantity'] < $available): ?>
                        <button class="btn btn-xs btn-default" onclick="update_cart('addone','<?=$product_id; ?>','<?=$item['size']?>')">+</button>
                        <?php else: ?>
                           <span class="text-center text-danger">Max</span>
                        <?php endif; ?>
                        </td>
                     	<td><?=$item['size']; ?></td>
                     	<td><?=money($item['quantity'] * $product['price']); ?></td>
                     </tr>
                  	<?php 
                       $i++;
                       $item_count += $item['quantity'];
                       $sub_total += ($product['price'] * $item['quantity']);
                     } 
                      $tax = TAXRATE * $sub_total;
                      $tax = number_format($tax,2);
                      $grand_total = $tax + $sub_total;
                     ?>
       		</tbody>
       	</table>
       	<table class="table table-bordered table-condensed text-right">
       		<legend>Totals</legend>
       		<thead class="totals-table-header"><th>Total Items</th><th>Sub Total</th><th>Tax</th><th>Grand Total</th></thead>
       		<tbody>
       			<tr>
       				<td><?=$item_count; ?></td>
       				<td><?=money($sub_total); ?></td>
       				<td><?=money($tax); ?></td>
       				<td style="background-color: aqua;"><?=money($grand_total);?></td>
       			</tr>
       		</tbody>
       	</table>
        <!-- Checkout button -->
<button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#checkoutmodal">
  <span class="glyphicon glyphicon-shopping-cart"></span> Check Out >>
</button>
<!-- modal -->
   
      <div class="modal fade" id="checkoutmodal" tabindex="-1" role="dialog" aria-labelledby="checkoutmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h3 class="modal-title text-center" id="checkoutModalLabel">Shipping Adress</h3>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              
            </div>
            <div class="modal-body">

            <form action="thankYou.php" method="post" id="payment-form">
              <span style="background-color: #f2dede;" id="payment-errors"></span>
              <input type="hidden" name="tax" value="<?=$tax; ?>">
              <input type="hidden" name="sub_total" value="<?=$sub_total; ?>">
              <input type="hidden" name="grand_total" value="<?=$grand_total; ?>">
              <input type="hidden" name="cart_id" value="<?=$cart_id; ?>">
              <input type="hidden" name="description" value="<?=$item_count.' item'.(($item_count>1)?'s':'').'from Chesires Boutique'; ?>">
              <div id="step1" style="display: block;">
                <div class="row">
                <div class="form-group col-md-6">
                  <label for="full_name">Full Name: </label>
                  <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Emmanuel">
                </div>
                <div class="form-group col-md-6">
                  <label for="email">Email: </label>
                  <input type="text" class="form-control" id="email" name="email" placeholder="example@gmail.com">
                </div>
              </div>
                <div class="row">
                <div class="form-group col-md-6">
                  <label for="address1">Address: </label>
                  <input type="text" class="form-control" id="address1" name="address1" placeholder="123 Moisbridge">
                </div>
                <div class="form-group col-md-6">
                  <label for="address2">Address 2: </label>
                  <input type="text" class="form-control" id="address2" name="address2" placeholder="additional address(optional)">
                </div>
              </div>
                <div class="row">
                <div class="form-group col-md-6">
                  <label for="town">Town: </label>
                  <input name="town" type="text" class="form-control" id="town" placeholder="Eldoret">
                </div>
                <div class="form-group col-md-6">
                  <label for="constituency">Constituency: </label>
                  <input type="text" class="form-control" id="constituency" name="constituency" placeholder="Soy">
                </div>
              </div>
                <div class="row">
                <div class="form-group col-md-6">
                  <label for="location">Location: </label>
                  <input type="text" class="form-control" id="location" name="location" placeholder="Moisbridge">
                </div>
                <div class="form-group col-md-6">
                  <label for="num">Phone number: </label>
                  <input type="text" class="form-control" id="num" name="num" placeholder="+254712345678">
                </div>
              </div>
              </div>
              
              <div id="step2" style="display: none;">
                <div class="row">
                <div class="form-group col-md-3">
                  <label for="transaction">Transaction Type: </label>
                  <input type="text" name="transaction" class="form-control" id="transaction" placeholder="M~PESA">
                </div>
                <div class="form-group col-md-3">
                  <label for="number">Card Number</label>
                  <input type="text" class="form-control" id="number">
                </div>
                <div class="form-group col-md-2">
                  <label for="cvc">CVC: </label>
                  <input type="text" class="form-control" id="cvc">
                </div>
                <div class="form-group col-md-2">
                  <label for="name">Expire Month: </label>
                  <select id="exp-month" class="form-control">
                    <option value=""></option>
                    <?php for($i=1; $i<13; $i++): ?>
                      <option value="<?=$i?>"><?=$i; ?></option>
                    <?php endfor; ?>
                  </select>
                </div>
                <div class="form-group col-md-2">
                  <label for="exp-year">Expire Year: </label>
                  <select id="exp-year" class="form-control">
                    <option value=""></option>
                    <?php $yr = date("Y");?>
                    <?php for($i=0; $i<10; $i++): ?>
                      <option value="<?=$yr+$i?>"><?=$yr+$i; ?></option>
                    <?php endfor; ?>
                  </select>
                </div>
              </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>              
              <button type="button" class="btn btn-primary" onclick="check_adress()" id="next_button">Next >></button>
              <button type="button" class="btn btn-primary" onclick="back_adress()" id="back_button" style="display: none;"><< Back</button>
              <button type="submit" class="btn btn-primary" id="checkout_button" style="display: none;">Check Out >></button>
              </form>
            </div>
          </div>
        </div>
      </div>
       <?php endif; ?>
	</div>
</div>

<script>
  function back_adress(){
      jQuery('#payment-errors').html("");
      jQuery('#step1').css("display","block");
      jQuery('#step2').css("display","none");
      jQuery('#next_button').css("display","inline-block");
      jQuery('#back_button').css("display","none");
      jQuery('#checkout_button').css("display","none");
      jQuery('#checkoutModalLabel').html("Shipping Address");
  }

  function check_adress(){
    var data = {
      'full_name' : jQuery('#full_name').val(),
      'email'     : jQuery('#email').val(),
      'address1'    : jQuery('#address1').val(),
      'address2'   : jQuery('#address2').val(),
      'town'      : jQuery('#town').val(),
      'constituency'     : jQuery('#constituency').val(),
      'location'  : jQuery('#location').val(),
      'num'   : jQuery('#num').val(),
      'transaction' : jQuery('#transaction').val(),
    };
    jQuery.ajax({
      url : '/boutique/admin/parsers/check_adress.php',
      method : 'POST',
      data : data,
      success : function(data){
        if (data!=5) {
          jQuery('#payment-errors').html(data);
        }
        if (data==5) {
          jQuery('#payment-errors').html("");
          jQuery('#step1').css("display","none");
          jQuery('#step2').css("display","block");
          jQuery('#next_button').css("display","none");
          jQuery('#back_button').css("display","inline-block");
          jQuery('#checkout_button').css("display","inline-block");
          jQuery('#checkoutModalLabel').html("Enter Your Card Details");
        }
      },
      error : function(){alert("Something went wrong");}
    });
  }
</script>

<?php include 'footer.php'; ?>