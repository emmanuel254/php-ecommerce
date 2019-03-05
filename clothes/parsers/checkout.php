<?php
     require_once $_SERVER['DOCUMENT_ROOT'].'/boutique/init.php';

    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $location = sanitize($_POST['location']);
    $phone = sanitize($_POST['phone']);
    $town = sanitize($_POST['town']);
    $constituency = sanitize($_POST['constituency']);
    $address = sanitize($_POST['address']);
    $payment = sanitize($_POST['payment']);
    $details = sanitize($_POST['details']);
    $total_goods = sanitize($_POST['total_goods']);
    $grand_total = sanitize($_POST['grand_total']);

    $db->query("INSERT INTO trans_accessories
    (full_name,cart_id,email,location,phone,town,constituency,payment_type,details,total_goods,grand_total,address)
    VALUES 
    ('$name','$Acart_id','$email','$location','$phone','$town','$constituency','$payment','$details',
    '$total_goods','$grand_total','$address')")
    or die(mysqli_error($db));
     $db->query("UPDATE cart_accessories SET checked_out = 1 WHERE id = '${Acart_id}'");
    setcookie(ACCESS_COOKIE,$Acart_id,UPDATE_DETAILS,'/',$domain,false);
?>