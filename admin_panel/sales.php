<?php
   require_once $_SERVER['DOCUMENT_ROOT'].'/boutique/init.php';
   include '../accessories/heading/header.php';
   include 'head/navigation.php';

   if (!logged_in_admin()) {
     login_redirect('login.php');
   }

   $this_yr = date('Y');
   $last_yr = $this_yr - 1;
   $total_goods = 0;

   $sql = $db->query("SELECT total_goods,grand_total,order_date FROM trans_accessories 
   	       WHERE YEAR(order_date) = '$this_yr'");
   $sql2 = $db->query("SELECT total_goods,grand_total,order_date FROM trans_accessories 
   	       WHERE YEAR(order_date) = '$last_yr'");
   $quantity = [];
   $current = [];
   $last = [];
   $revenue = [];
   $sum_thisyr = 0;
   $sum_lastyr = 0;
   $lastR = [];
   
   error_reporting(0);
   while ($result = mysqli_fetch_assoc($sql)) {
   	$month = date('m',strtotime($result['order_date']));
   	if (!array_key_exists($month, $current)) {
   		$current[(int)$month] += $result['grand_total'];
   		$quantity[(int)$month] += $result['total_goods'];
   	}if (array_key_exists($month, $current)) {
   		$current[(int)$month] += $result['grand_total'];
   		$quantity[(int)$month] += $result['total_goods'];
   	}
     $sum_thisyr += $result['grand_total'];  
   }
   while ($results = mysqli_fetch_assoc($sql2)) {
   	$month = date('m',strtotime($results['order_date']));
   	if (!array_key_exists($month, $last)) {
   		$last[(int)$month] += $results['grand_total'];
   	}else{
       $last[(int)$month] += $results['grand_total'];
   	}
   	$sum_lastyr += $results['grand_total'];
   }
?>
<h2 class="text-center text-primary">GRAND SALES OF ITEMS EACH MONTH!</h2>
<div class="row">
<div class="col-md-1"></div>
<div class="col-md-10">
	<table class="table table-condensed table-bordered table-striped">
		<thead>
			<th>#</th>
			<th>Month</th>
			<th>Sold Items</th>
			<th><?=$last_yr; ?></th>
			<th><?=$this_yr; ?></th>
			<th>Total Revenue</th>
		</thead>
		<tbody>
         <?php for($i = 1;$i <= 12; $i++):
            $months = DateTime::CreateFromFormat('!m',$i);
           	?>
			<tr>
				<td></td>
				<td><?=$months->Format("F");?></td>
				<td><?=((array_key_exists($i, $quantity))?$quantity[$i]:'0');?></td>
				<td><?=((array_key_exists($i, $last))?money($last[$i]):money(0));
				   if (!empty($last[$i])) {
				   	$lastR[$i] = $last[$i];
				   }
				?></td>
				<td><?=((array_key_exists($i, $current))?money($current[$i]):money(0));?></td>
				<td><?=((!empty($lastR[$i]))?money($lastR[$i] + $current[$i]): ((!empty($current[$i]))?money($current[$i]):money(0)));?></td>
			</tr>
		 <?php endfor; ?>
		 <tr>
		 	<td></td>
		 	<td>Total</td>
		 	<td></td>
		 	<td><?=money($sum_lastyr); ?></td>
		 	<td><?=money($sum_thisyr); ?></td>
		 	<td><?=money($sum_lastyr + $sum_thisyr); ?></td>
		 </tr>
		</tbody>
	</table>
</div>
<div class="col-md-1"></div>
</div>