<?php
   require_once $_SERVER['DOCUMENT_ROOT'].'/boutique/init.php';
    $name = sanitize($_POST['name']);
    $location = sanitize($_POST['location']);
    $phone = sanitize($_POST['phone']);
    $town = sanitize($_POST['town']);
    $constituency = sanitize($_POST['constituency']);
    $address = sanitize($_POST['address']);
    $details = sanitize($_POST['details']);

    $db->query("UPDATE trans_accessories SET full_name = '$name',location = '$location', phone = '$phone', town = '$town', constituency = '$constituency', address = '$address', details = '$details' WHERE cart_id = '$Acart_id'") or die(mysqli_error($db));
?>