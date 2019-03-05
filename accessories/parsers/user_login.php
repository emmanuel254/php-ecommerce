<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/boutique/init.php';
 $i = 5;
 $errors = [];
 $password = sanitize($_POST['password']);
 $reg_no = sanitize($_POST['reg_no']);
 $email = sanitize($_POST['email']);
 $required = array(
       'password' => 'Password',
       'reg_no' => 'Registration No.',
       'email' => 'Email',
     );

 $sql=$db->query("SELECT * FROM users_department WHERE email = '$email' AND registration_no = '$reg_no'");
 $user = mysqli_num_rows($sql);

 foreach ($required as $fields => $f) {
 	if ($_POST[$fields] == '') {
 	  $errors[] = $f.' field is required';
 	}
 }

 if ($user < 1) {
 	$errors[] ='Sorry, user with that email and reg. no. doesn\'t exist. Visit our offices for more info';
 }

 if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
 	$errors[] = 'Enter a valid email address';
 }

 if (!empty($errors)) {
 	echo display_errors($errors);
 }else{
 	echo $i;
 }
?>