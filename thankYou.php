<?php
require_once 'init.php';
  $name = sanitize($_POST['full_name']);
  $email = sanitize($_POST['email']);
  $address1 = sanitize($_POST['address1']);
  $address2 = sanitize($_POST['address2']);
  $town = sanitize($_POST['town']);
  $location = sanitize($_POST['location']);
  $constituency = sanitize($_POST['constituency']);
  $phone = sanitize($_POST['num']);
  $tax = sanitize($_POST['tax']);
  $sub_total = sanitize($_POST['sub_total']);
  $grand_total = sanitize($_POST['grand_total']);
  $cart_id = sanitize($_POST['cart_id']);
  $description = sanitize($_POST['description']);
  $transaction = sanitize($_POST['transaction']);
  $charge_amount = number_format($grand_total,2) * 100;

  //adjust the inventory
  $itemQ = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
  $iresults = mysqli_fetch_assoc($itemQ);
  $items = json_decode($iresults['items'],true);
  foreach ($items as $item) {
    $newSizes = array();
    $item_id = $item['id'];
    $productQ = $db->query("SELECT sizes FROM products WHERE id = '{$item_id}'");
    $product = mysqli_fetch_assoc($productQ);
    $sizes = sizesToArray($product['sizes']);
    foreach ($sizes as $size) {
      if ($size['size'] == $item['size']) {
        $q = $size['quantity'] - $item['quantity'];
        $newSizes[] = array('size' => $size['size'],'quantity' => $q);
      }else{
        $newSizes[] = array('size' => $size['size'],'quantity' => $size['quantity']);
      }
    }
    $sizeString = sizesToString($newSizes);
    $db->query("UPDATE products SET sizes = '{$sizeString}' WHERE id = '{$item_id}'");
  }

//update cart query
  $db->query("UPDATE cart SET paid = 1 WHERE id = '{$cart_id}'");
  $db->query("INSERT INTO transactions
  	(charge_id,cart_id,full_name,email,address1,address2,town,constituency,location,phone,sub_total,tax,grand_total,description,txn_type) 
  	VALUES('1','$cart_id','$name','$email','$address1','$address2','$town','$constituency','$location','$phone','$sub_total','$tax','$grand_total','$description','$transaction')");
  
  $domain = (($_SERVER['HTTP_HOST'] != 'localhost')?'.'.$_SERVER['HTTP_HOST']:false);
  setcookie(CART_COOKIE,'',1,"/",$domain,false);

  include 'head.php';
  include 'navigation.php';
  ?>
  <h1 class="text-center text-success">Thank You!</h1>
  <p>You have successfully ordered goods worth <?=money($grand_total); ?></p>
  <p>Continue shopping for more exciting deals and offers!</p>
  <p>Your receipt number is. <?=$cart_id; ?></p>
  <p>Kindly pick up your goods from the adress below: </p>
  <address>
  	<?=$name; ?><br>
  	<?=$address1; ?><br>
  	<?=(($address2 != '')?$address2.'<br>':'')?>
  	<?=$town.', '.$constituency.' constituency, '.$location.' location.';?><br>
  	<?=$phone; ?><br>
  </address>
  <?php
  include 'footer.php';
?>