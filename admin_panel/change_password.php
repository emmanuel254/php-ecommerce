<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/boutique/init.php';
  include '../accessories/heading/header.php';
  
  $errors = [];
  $email = $admins['email'];
  $my_pass = $admins['password'];
  $current_pass = ((isset($_POST['current_pass']))?sanitize($_POST['current_pass']):'');
  $current_pass = trim($current_pass);
  $reg = ((isset($_POST['reg']))?sanitize($_POST['reg']):'');
  $password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
  $password = trim($password);
  $confirm = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
  $confirm = trim($confirm);
  $required = array(
  	'password' => 'Password',
  	'current_pass' => 'Old password',
    );
  if ($_POST) {
  foreach ($required as $fields => $f) {
  	if ($_POST[$fields] == '') {
  		$errors[] = $f.' is required';
  	}
  }
  $sql = $db->query("SELECT * FROM users_department WHERE email = '$email' AND registration_no = '$reg'");
  $user_info = mysqli_fetch_assoc($sql);
  $user_count = mysqli_num_rows($sql);

  if ($user_count < 1) {
    $errors[] = 'User Registration number is not recognised';
  }
  if ($password < 6 && !empty($password)) {
    $errors[] = 'Password too short';
  }
  if (!password_verify($current_pass,$user_info['password'])) {
    $errors[] = 'You entered wrong password';
  }
  if ($password != $confirm) {
    $errors[] = 'new password doesn\'t match with confirm password';
  }
  if (!empty($errors)) {
    
  }else{
    $pass = password_hash($confirm,PASSWORD_DEFAULT);
     $_SESSION['success_flash'] = 'Password change successfull';
     $db->query("UPDATE users_department SET password = '$pass' WHERE id = '$admins_id'");
     header('Location:index.php');
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
	<h3 class="text-center text-primary">CHANGE PASSWORD</h3>
	<form method="post" action="change_password.php">
		<?php echo display_errors($errors); ?>
	  <div class="form-group">
		<label for="reg"><strong>Registration no: </strong></label>
		<input type="text" name="reg" value="" class="form-control" value="">
	  </div>
	  <div class="form-group">
		<label for="current_pass"><strong>Current Password: </strong></label>
		<input type="password" name="current_pass" value="" class="form-control">
	  </div>
	  <div class="form-group" style="margin-bottom: 15px;">
		<label for="password"><strong>New Password: </strong></label>
		<input type="password" name="password" value="" class="form-control">
	  </div>
    <div class="form-group" style="margin-bottom: 15px;">
    <label for="confirm"><strong>Confirm Password: </strong></label>
    <input type="password" name="confirm" value="" class="form-control">
    </div>
	  <div class="form-group">
        <input type="submit" class="btn btn-xs btn-primary pull-right" value="Login">
	  </div>
	</form>
</div>
</div>
</body>