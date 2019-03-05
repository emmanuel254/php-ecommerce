<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/boutique/init.php';
unset($_SESSION['SBUser']);

header('Location: login.php');
?>