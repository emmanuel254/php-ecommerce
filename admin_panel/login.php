<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/boutique/init.php';
  include '../accessories/heading/header.php';
  
  $errors = [];
  $email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
  $email = trim($email);
  $password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
  $password = trim($password);
  $reg_no = ((isset($_POST['reg_no']))?sanitize($_POST['reg_no']):'');
  $required = array(
  	'email' => 'Email',
  	'password' => 'Password',
  	'reg_no' => 'Registration Number',
    );
  if ($_POST) {
  foreach ($required as $fields => $f) {
  	if ($_POST[$fields] == '') {
  		$errors[] = $f.' is required';
  	}
  }

  $sql = $db->query("SELECT * FROM users_department WHERE email = '$email' AND registration_no = '$reg_no'");
  $user_info = mysqli_fetch_assoc($sql);
  $user_count = mysqli_num_rows($sql);

  if ($user_count < 1) {
  	$errors[] = 'User details is not recognised';
  }
  if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
  	$errors[] = 'Enter a valid email address';
  }
  if ($password < 6 && !empty($password)) {
  	$errors[] = 'Password too short';
  }
  if (!password_verify($password,$user_info['password'])) {
  	$errors[] = 'You entered wrong password';
  }
  if (!empty($errors)) {
  	
  }else{
     $users_id = $user_info['id'];
     login_user($users_id);
  }
  }
  
?>
<style>
	body{
    background-image: url('/boutique/images/products/c5dc5aec7fc0d162ddb20989c72d72f0.jpg');
	background-repeat: no-repeat;
	background-size: 100vw 100vh;
	background-attachment: fixed;
}
</style>
<body>
<div class="login">
	<h3 class="text-center text-primary">ADMIN LOGIN</h3>
	<form method="post" action="login.php">
		<?php echo display_errors($errors); ?>
	  <div class="form-group">
		<label for="email"><strong>Email: </strong></label>
		<input type="email" name="email" value="" class="form-control">
	  </div>
	  <div class="form-group">
		<label for="reg_no"><strong>Registration Number: </strong></label>
		<input type="text" name="reg_no" value="" class="form-control">
	  </div>
	  <div class="form-group" style="margin-bottom: 15px;">
		<label for="password"><strong>Password: </strong></label>
		<input type="password" name="password" value="" class="form-control">
	  </div>
	  <div class="form-group">
        <input type="submit" class="btn btn-xs btn-primary pull-right" value="Login">
	  </div>
	</form>
</div>
</div>
</body>