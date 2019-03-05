<?php
      require_once $_SERVER['DOCUMENT_ROOT'].'/boutique/init.php';

      $id = sanitize($_POST['id']);
      $quantity = sanitize($_POST['quantity']);
      $available = sanitize($_POST['available']);
      $title = sanitize($_POST['title']);
      $items[] = array(
        'id' => $id,
        'quantity' => $quantity,
      );

	 $domain = ($_SERVER['HTTP_HOST'] != 'localhost')?'.'.$_SERVER['HTTP_HOST']:false;
	 $productQ = "SELECT * FROM accesories WHERE id = '$id'";
	 $product = mysqli_fetch_assoc($productQ);
	 $_SESSION['success_flash'] = $title.' successfully added to your cart';

	 if ($Acart_id != '') {
	 	$sqlQ = $db->query("SELECT * FROM cart_accessories WHERE id = '{$Acart_id}'");
	 	$item = mysqli_fetch_assoc($sqlQ);
    var_dump($item);
	 	$previous_items = json_decode($item['cart'],true);
    var_dump($previous_items);
	 	$new_items = array();
	 	$similar_items = 0;
        
        foreach ($previous_items as $pItems) {
          if ($items[0]['id'] == $pItems['id']) {
          	$pItems['quantity'] = $pItems['quantity'] + $items[0]['quantity'];
          	if ($pItems['quantity'] > $available) {
          		$pItems['quantity'] = $available;
          	}
          	$similar_items = 1;
          }
          $new_items[] = $pItems;
        }
        if ($similar_items != 1) {
        	$new_items = array_merge($items,$previous_items);
        }

        $cart = json_encode($new_items);
        $cart_expire = date("Y-m-d H:i:s",strtotime("+30 days") );

        echo($cart);
        
       $db->query("UPDATE cart_accessories SET cart = '{$cart}',cart_expire = '$cart_expire' WHERE id = '{$Acart_id}'")
       or die(mysqli_error($db));
        
        //after updating, reset cookie to a new value
       setcookie(ACCESS_COOKIE,'',1,'/',$domain,false);
       setcookie(ACCESS_COOKIE,$Acart_id,ACCESS_COOKIE_EXPIRE,'/',$domain,false);

	 
	 }else{
     
	     $cart = json_encode($items);
	     $cart_expire = date("Y-m-d H:i:s",strtotime("+30 days") );

	     $db->query("INSERT INTO cart_accessories(cart,cart_expire) VALUES ('$cart','$cart_expire')")
	      or die(mysqli_error($db));

	      $Acart_id = $db->insert_id;
	      setcookie(ACCESS_COOKIE,$Acart_id,ACCESS_COOKIE_EXPIRE,'/',$domain,false);
  }
?>