<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/boutique/init.php';

$id = (int)$_POST['id'];
$name = sanitize($_POST['name']);
$email = sanitize($_POST['email']);
$permissions = sanitize($_POST['permissions']);

$db->query("UPDATE `users` SET `full_name` = '$name',`email` = '$email',`permissions` = '$permissions' WHERE id = '$id'");
$_SESSION['success_flash'] = 'user details updated.';

?>