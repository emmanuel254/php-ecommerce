<?php
  require_once '../init.php';

  if (!is_logged_in()) {
  	login_error_redirect();
  }

  if (!has_permission('admin')) {
  	permission_error_redirect('index.php');
  }
  include 'includes/navigation.php';
  include 'includes/head.php';
   $edit_id = '';
  
  //delete user
  if (isset($_GET['delete'])) {
  	$delete_id = sanitize($_GET['delete']);
  	$db->query("DELETE FROM users WHERE id = '$delete_id'");
  	$_SESSION['success_flash'] = 'User has been deleted successfully';
  	header('Location: users.php');
  }
   if (isset($_GET['add']) || isset($_GET['edit'])) {
   	$name = ((isset($_POST['name']))?sanitize($_POST['name']):'');
   	$email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
   	$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
   	$confirm = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
   	$permissions = ((isset($_POST['permissions']))?sanitize($_POST['permissions']):'');
   	$errors = array();

   if (isset($_GET['edit'])) {
     $edit_id = (int)$_GET['edit'];
     $userQ = $db->query("SELECT * FROM users WHERE id = '$edit_id'");
     $result = mysqli_fetch_assoc($userQ);

     $name = ((isset($_POST['name']) && $_POST['name'] != '')?sanitize($_POST['name']):$result['full_name']);
     $email = ((isset($_POST['email']) && $_POST['email'] != '')?sanitize($_POST['email']):$result['email']);
     $permissions = ((isset($_POST['permissions']) && $_POST['permissions'] != '')?sanitize($_POST['permissions']):$result['permissions']);

   }
   	//form validation and check of errors
   	if ($_POST) {
        $emailQuery = $db->query("SELECT * FROM users WHERE email = '$email'");
        $emailCount = mysqli_num_rows($emailQuery);
        
        if ($emailCount != 0) {
        	$errors[] = 'Email already exists.';
        }

   		$required = array('name', 'email', 'password', 'confirm', 'permissions');
   		foreach ($required as $f) {
   		  if (empty($_POST[$f])) {
   		  	$errors[] = 'All fields are required.';
   		  	break;
   		  }
   		}
   		if (strlen($password) < 6) {
   			$errors[] = 'password must be atleast 6 characters.';
   		}
   		if ($password != $confirm) {
   			$errors[] = 'Your passwords do not match.';
   		}

   		if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
   			$errors[] = 'invalid email adress.';
   		}
   		if (!empty($errors)) {
   			echo display_errors($errors);
   		}
   		else{
   			//add user to database
   			$hashed = password_hash($password,PASSWORD_DEFAULT);
   			$updateSql = "INSERT INTO users (full_name,email,password,permissions) VALUES ('$name','$email','$hashed','$permissions')" or die(mysqli_error($db));
        $db->query($updateSql);
   			$_SESSION['success_flash'] = 'User has been added successfully';
   			header('Location: users.php');
   		}
   	}
   ?>
     <h2 class="text-center"><?=((isset($_GET['edit']))?'Update Info':'Add New User')?></h2><hr>
     <form action="users.php?add=1" method="post">
        <input type="hidden" name="id" id="id" value="<?=$edit_id; ?>">
      <div class="row">
     	<div class="form-group col-md-6">
     		<label for="name">Full Name: </label>
     		<input type="text" name="name" id="name" class="form-control" value="<?=$name; ?>">
     	</div>
     	<div class="form-group col-md-6">
     		<label for="email">Email: </label>
     		<input type="text" name="email" id="email" class="form-control" value="<?=$email; ?>">
     	</div>
     </div>
      <?php if(isset($_GET['add'])):?>
        <div class="row">
     	<div class="form-group col-md-6">
     		<label for="password">Password: </label>
     		<input type="password" name="password" id="password" class="form-control" value="<?=$password; ?>">
     	</div>
     	<div class="form-group col-md-6">
     		<label for="confirm">Confirm Password: </label>
     		<input type="password" name="confirm" id="confirm" class="form-control" value="<?=$confirm; ?>">
     	</div>
     </div>
     <?php endif; ?>
     <div class="row">
        <div class="form-group col-md-6">
     		<label for="name">Permissions: </label>
     		<select class="form-control" name="permissions" id="permissions">
     			<option value=""<?=(($permissions == '')?' selected':'');?>></option>
     			<option value="editor"<?=(($permissions == 'editor')?' selected':'');?>>Editor</option>
     			<option value="admin,editor"<?=(($permissions == 'admin,editor')?' selected':'');?>>Admin</option>
     		</select>
     	</div>
     	<div class="form-group col-md-6 text-right" style="margin-top: 25px;"> 
     		<a href="users.php" class="btn btn-default">Cancel</a>
        <?php if(isset($_GET['edit'])):?>
     		<button type="button" onclick="update_info(<?=$edit_id?>)" class="btn btn-primary">Update info</button>
      <?php else: ?>
        <input type="submit" value="Add New User" class="btn btn-primary">
      <?php endif;?>
     	</div>
     </div>
     </form> 	 
  
   	<?php
   }else{
  $userQuery = $db->query("SELECT * FROM users ORDER BY full_name");

?>
<h2 class="text-center">Users</h2>
<a href="users.php?add=1" class="btn btn-success pull-right" id="add-product-btn">Add User</a>
<hr>
<table class="table table-bordered table-striped table-condensed">
	<thead><th></th><th>Name</th><th>Email</th><th>Join Date</th><th>Last Login</th><th>Permissions</th></thead>
	<tbody>
	  <?php while($user = mysqli_fetch_assoc($userQuery)):?>
		<tr>
			<td>
        <a href="users.php?edit=<?=$user['id'];?>" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>

				<?php if($user['id'] != $user_data['id']):?>
                  <a href="users.php?delete=<?=$user['id']; ?>" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-remove-sign"></span></a>
				<?php endif; ?>
			</td>
			<td><?=$user['full_name']; ?></td>
			<td><?=$user['email']; ?></td>
			<td><?=pretty_date($user['join_date']); ?></td>
			<td><?=pretty_date($user['last_login']); ?></td>
			<td><?=$user['permissions']; ?></td>
		</tr>
	<?php endwhile; ?>
	</tbody>
</table>

<?php } include 'includes/footer.php';?>