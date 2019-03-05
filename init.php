<?php
$db = mysqli_connect('127.0.0.1', 'root', '', 'tutorial');

if (mysqli_connect_errno()) {
	echo 'Database connection failed with the following errors'.mysql_connect_errno();
	die();
}
session_start();

require_once $_SERVER['DOCUMENT_ROOT'].'/boutique/config.php';
require_once BASEURL.'helpers/helpers.php';
require_once BASEURL.'admin_panel/parsers/helpers.php';

$cart_id = '';
if (isset($_COOKIE[CART_COOKIE])) {
	$cart_id = sanitize($_COOKIE[CART_COOKIE]);
}
$Acart_id = '';
if (isset($_COOKIE[ACCESS_COOKIE])) {
	$Acart_id = sanitize($_COOKIE[ACCESS_COOKIE]);
}

if (isset($_SESSION['SBUser'])) {
	$user_id = $_SESSION['SBUser'];
	$query = $db->query("SELECT * FROM users WHERE id = '$user_id'");
	$user_data = mysqli_fetch_assoc($query);
	$fn = explode(' ', $user_data['full_name']);
	$user_data['first'] = $fn[0];
	$user_data['last'] = $fn[1];
}
if (isset($_SESSION['DASHboard'])) {
	$admins_id = $_SESSION['DASHboard'];
	$sql = $db->query("SELECT * FROM users_department WHERE id = '$admins_id'");
	$admins = mysqli_fetch_assoc($sql);
	$name = explode(' ', $admins['full_name']);
	$admins['first'] = $name[0];
	$admins['last']  = $name[1];
	$date_of_birth = $admins['date_of_birth'];
    $d = explode('-', $date_of_birth);
    $current_year = (date('Y'));

    $birth = $current_year - $d[0];
}
