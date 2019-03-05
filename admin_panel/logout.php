<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/boutique/init.php';
unset($_SESSION['DASHboard']);

header('Location: login.php');
?>