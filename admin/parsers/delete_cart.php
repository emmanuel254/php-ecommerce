<?php 
     require_once $_SERVER['DOCUMENT_ROOT'].'/boutique/init.php';
     
     $domain = (($_SERVER['HTTP_HOST'] != 'localhost')?'.'.$_SERVER['HTTP_HOST']:false);

    $id = sanitize($_POST['id']);
    $query = $db->query("SELECT * FROM cart_accessories WHERE id = '{$Acart_id}'");
    $cart_items = mysqli_fetch_assoc($query);
    $items = json_decode($cart_items['cart'],true);
    $new_items = array();
    $count = count($items) - 1;
     foreach ($items as $item) {
     	if ($item['id'] == $id) {
     	 $item['quantity'] = $item['quantity'] - $item['quantity'];
     	}
         if ($item['quantity'] > 0) {
             $new_items[] = $item;
         }
     }

   if (!empty($new_items)) {
    $cart_expire = date("Y-m-d H:i:s",strtotime("+30 days"));
    $json_updated = json_encode($new_items);
    var_dump($json_updated);
    $db->query("UPDATE cart_accessories SET cart = '$json_updated',cart_expire = '$cart_expire' 
    WHERE id = '{$Acart_id}'");
   }
   if(empty($new_items)){
   $db->query("DELETE FROM cart_accessories WHERE id = '{$Acart_id}'");
   setcookie(ACCESS_COOKIE,'',1,'/',$domain,false);
   }
?>