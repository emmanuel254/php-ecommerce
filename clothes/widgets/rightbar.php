<?php
      $cartQuery = $db->query("SELECT * FROM cart_accessories WHERE id = '{$Acart_id}'");
      $result = mysqli_fetch_assoc($cartQuery);
      $cart = json_decode($result['cart'],true);
      $i = 1;
      $count = 0;
      $grand_total = 0;
      $sub_total = 0;
      $total_goods = 0;

      if ($Acart_id != '') {
        foreach($cart as $item){
         $count++;
      }
?>

        <div class="order-md-2 mb-4" style="background-color: gold;">
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted">My cart</span>
            <span class="badge badge-secondary badge-pill bg-danger"><?=$count;?></span>
          </h4>
          <ul class="list-group mb-3">
            <?php foreach($cart as $items){
                 $id = $items['id'];
                 $quantity = $items['quantity'];
                 $sql = $db->query("SELECT * FROM accesories WHERE id = '{$id}'");
                 $cartItems = mysqli_fetch_assoc($sql);
                 $Total = $quantity * $cartItems['price'];
                 
               ?>
            <li class="list-group-item d-flex justify-content-between lh-condensed">
              <div>
                <h6 class="my-0"><?=$cartItems['title'];?></h6>
                <small class="text-muted">Quantity: <?=$items['quantity'];?></small>
              </div>
              <span class="text-muted"><?=money($Total);?></span>
            </li>
             <?php
                $i++;
                $total_goods += $items['quantity'];
                $grand_total += $Total;
              } 
              ?>
            <li class="list-group-item d-flex justify-content-between">
              <span>Total (KSH)</span>
              <strong><?=money($grand_total);?></strong>
            </li>
          </ul>
          <a href="../accessories/cart.php" class="btn btn-xs btn-secondary pull-right">view cart</a>
        </div>
<?php } else {

  ?>
      <h4 style="background-color: gold;" class="d-flex justify-content-between align-items-center mb-3">
        <span class="text-muted">My cart</span>
        <span class="badge badge-secondary badge-pill bg-danger"><?=$count;?></span>
      </h4>
      <p class="text-center text-danger"><b>Your shopping cart is empty</b></p>
   <?php

} ?>