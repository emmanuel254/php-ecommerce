<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/boutique/init.php';
  $name = sanitize($_POST['full_name']);
  $email = sanitize($_POST['email']);
  $address1 = sanitize($_POST['address1']);
  $address2 = sanitize($_POST['address2']);
  $town = sanitize($_POST['town']);
  $location = sanitize($_POST['location']);
  $constituency = sanitize($_POST['constituency']);
  $phone = sanitize($_POST['num']);
  $i = 5;
  $errors = array();
  $required = array(
     'full_name' => 'Full Name',
     'email'     => 'Email',
     'address1'    => 'Adress',
     'town'      => 'Town',
     'location'     => 'Location',
     'constituency'  => 'Constituency',
     'num'   => 'Phone Number',
  );

 // check if all required fields are filled out
  foreach ($required as $f => $d) {
  	if (empty($_POST[$f]) || $_POST[$f] == '') {
  	  $errors[] = $d.' is required';
  	}
  }

  //check if valid email adress is entered
  if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'please enter a valid email adress';
  }
  if (!empty($errors)) {
  	echo display_errors($errors);
  }else{
  	echo $i;
  }
?>