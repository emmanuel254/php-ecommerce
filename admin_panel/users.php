<?php
   require_once $_SERVER['DOCUMENT_ROOT'].'/boutique/init.php';
   include '../accessories/heading/header.php';
   include 'head/navigation.php';
   $errors = [];
   
   if (!logged_in_admin()) {
     login_redirect('login.php');
   }
   if (!has_admin_permission('admin')) {
     redirect('index.php');
   }
   //deleting user information
   if (isset($_GET['delete_user'])) {
     $id = sanitize((int)$_GET['delete_user']);
     $db->query("DELETE FROM users_department WHERE id = '$id'");
     header('Location:users.php');
   }

   if (isset($_GET['add_user']) || isset($_GET['edit_user'])) {
   	  $sql = $db->query("SELECT * FROM users_department");
   	  $user_info = mysqli_fetch_assoc($sql);
   	  $name = ((isset($_POST['name']) && !empty($_POST['name']))?sanitize($_POST['name']):'');
   	  $email = ((isset($_POST['email']) && !empty($_POST['email']))?sanitize($_POST['email']):'');
   	  $dob = ((isset($_POST['dob']) && !empty($_POST['dob']))?sanitize($_POST['dob']):'');
   	  $reg_no = ((isset($_POST['reg_no']) && !empty($_POST['reg_no']))?sanitize($_POST['reg_no']):'');
   	  $phone = ((isset($_POST['phone']) && !empty($_POST['phone']))?sanitize($_POST['phone']):'');
   	  $department = ((isset($_POST['department']) && !empty($_POST['department']))?
   	  	sanitize($_POST['department']):'');
   	  $permission = ((isset($_POST['permission']) && !empty($_POST['permission']))?
   	  	sanitize($_POST['permission']):'');

   	  if (isset($_GET['edit_user'])) {
   	  $id = sanitize((int)$_GET['edit_user']);
   	  $sql = $db->query("SELECT * FROM users_department WHERE id = '$id'");
   	  $user_info = mysqli_fetch_assoc($sql);
   	  $name = ((isset($_POST['name']) && !empty($_POST['name']))?
   	  	sanitize($_POST['name']):$user_info['full_name']);
   	  $email = ((isset($_POST['email']) && !empty($_POST['email']))?
   	  	sanitize($_POST['email']):$user_info['email']);
   	  $dob = ((isset($_POST['dob']) && !empty($_POST['dob']))?
   	  	sanitize($_POST['dob']):$user_info['date_of_birth']);
   	  $reg_no = ((isset($_POST['reg_no']) && !empty($_POST['reg_no']))?
   	  	sanitize($_POST['reg_no']):$user_info['registration_no']);
   	  $phone = ((isset($_POST['phone']) && !empty($_POST['phone']))?
   	  	sanitize($_POST['phone']):$user_info['phone_no']);
   	  $department = ((isset($_POST['department']) && !empty($_POST['department']))?
   	  	sanitize($_POST['department']):$user_info['department']);
   	  $permission = ((isset($_POST['permission']) && !empty($_POST['permission']))?
   	  	sanitize($_POST['permission']):$user_info['permission']);
      $dbPath = $user_info['photo'];
   	  }
       if ($_POST) {
       $required = array(
        'name' => 'Name',
        'email' => 'Email address',
        'dob'  => 'Date Of Birth',
        'reg_no' => 'Registration Number',
        'department' => 'Department',
        'permission' => 'Permission'
       );

       foreach ($required as $fields => $f) {
       	if ($_POST[$fields] == '') {
       		$errors[] = $f.' field can\'t be left blank';
       	}
       }
       if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
       	$errors[] = 'Enter a valid email address';
       }
       if (!empty($errors)) {
       	$display = display_errors($errors);
       }else{
       	//update into database
       	$pass = password_hash($reg_no,PASSWORD_DEFAULT);
       	$insert = "INSERT INTO users_department
       	(full_name,email,department,registration_no,phone_no,permission,date_of_birth,photo,password)
       	VALUES ('$name','$email','$department','$reg_no','$phone','$permission','$dob','$permission','$pass')";

       	if (isset($_GET['edit_user'])) {
       		$insert = "UPDATE users_department SET full_name = '$name',email = '$email',department = '$department',registration_no = '$reg_no',phone_no = '$phone',permission = '$permission',date_of_birth = '$dob' WHERE id = '$id'";
       	}
          $db->query($insert) or die(mysqli_error($db));
          header('Location:users.php');
       }
      
       }
   	?>
      <h2 class="text-center text-primary">
      	<?=((isset($_GET['edit_user']))?'EDIT USER INFO':'ADD A NEW USER')?></h2>
      <div class="row" >
      	<div class="col-md-2"></div>
      	<div class="col-md-8" style="border-style: groove;">
      		<h3 class="text-center" style=" margin-bottom: 50px;"><?=((isset($_GET['edit_user']))?'Edit':'Fill');?> user details here</h3>
      		<?php echo display_errors($errors); ?>
      		<form class="form-group" action="users.php?<?=((isset($_GET['edit_user']))?'edit_user='.$id:'add_user=1')?>" method="post">
      			<div class="row">
      				<div class="col-md-4">
      				<label for="name">Full name: </label>
      			      <input type="text" name="name" class="form-control" 
      			      value="<?=$name;?>">	
      				</div>
      				<div class="col-md-4">
      				<label for="email">Email: </label>
      			      <input type="email" name="email" class="form-control" 
      			      value="<?=$email;?>">	
      				</div>
      				<div class="col-md-4">
      				<label for="dob">Date Of Birth: </label>
      			      <input type="text" name="dob" class="form-control" 
      			      value="<?=$dob;?>">	
      				</div>
      			</div>
      			<div class="row">
      				<div class="col-md-4">
      				<label for="reg_no">Registration No. : </label>
      			      <input type="number" name="reg_no" class="form-control" 
      			      value="<?=$reg_no;?>">	
      				</div>
      				<div class="col-md-4">
      				<label for="phone">Phone No. : </label>
      			      <input type="number" name="phone" class="form-control" 
      			      value="<?=$phone;?>">	
      				</div>
      				<div class="col-md-4">
      				<label for="department">Department: </label>
      			      <input type="text" name="department" class="form-control" 
      			      value="<?=$department;?>">	
      				</div>
      			</div>
      			<div class="row"> 
      				<div class="col-md-6"> 
      				  <label for="permission">Permission: </label>
                       <select name="permission" class="form-control" 
                       value="<?=$permission;?>">
                       	   <option value=""<?=(($permission == '')?' selected':'')?>></option>
                           <option value="editor"
                           <?=(($permission == 'editor')?' selected':'')?>>Editor</option>
                       	   <option value="admin,editor"
                           <?=(($permission == 'admin,editor')?' selected':'')?>>Admin</option>
                           <option value="master admin,admin,editor"
                           <?=(($permission == 'master admin')?' selected':'')?>>Master admin</option>
                       </select>
      				</div>
      				<div class="col-md-6" style="margin-top: 25px; margin-bottom: 50px;">
      					<input type="submit" class="btn btn-xs btn-primary pull-right" value="<?=((isset($_GET['edit_user']))?'Edit':'Add');?> User">
      					<a type="submit" style="margin-right: 5px;" class="btn btn-xs btn-warning pull-right" href="users.php" >Cancel</a>
      				</div>
      			</div>
      		</form>
      	</div>
      	<div class="col-md-2"></div>
      </div>
   	<?php

   }else{
   	$sql = $db->query("SELECT * FROM users_department ORDER BY full_name");
 ?>
 <h2 class="text-center">USERS</h2>
 <div class="row">
 <div class="col-md-2"></div>
 <div class="col-md-8">
 	<div class="row">
	 	<?php while($user = mysqli_fetch_assoc($sql)): 
          $date_of_birth = $user['date_of_birth'];
          $d = explode('-', $date_of_birth);
          $current_year = (date('Y'));

          $date_birth = $current_year - $d[0];
      ?>
	 		<div class="col-md-3">
	 			<img src="<?=$user['photo'];?>" class="image">
	 		</div>
	 		<dir class="col-md-1"></dir>
	 		<div class="col-md-6" style="margin-right: 15px;">
	 			<strong><i>Full Name: </i></strong><?=$user['full_name'] ;?><br>
	 			<strong><i>Date Of Birth: </i></strong><?=$user['date_of_birth'];?><br>
	 			<strong><i>Age: </i></strong><?=$date_birth;?><br>
	 			<strong><i>Email: </i></strong><?=$user['email'] ;?><br>
	 			<strong><i>Registration Number: </i></strong><?=$user['registration_no'] ;?><br>
	 			<strong><i>Phone Number: </i></strong><?=$user['phone_no'] ;?><br>
	 			<strong><i>Department: </i></strong><?=$user['department'] ;?><br>
	 			<strong><i>Join Date: </i></strong><?=$user['join_date'] ;?><br>
	 			<strong><i>Last Login: </i></strong><?=$user['last_login'] ;?><br>
	 			<a href="users.php?edit_user=<?=$user['id'];?>" class="btn btn-xs btn-info pull-right">
	 				<span class="glyphicon glyphicon-pencil"> edit</span></a>
	 			<a href="users.php?delete_user=<?=$user['id'];?>" style="margin-right: 5px;" class="btn btn-xs btn-danger pull-right"><span class="glyphicon glyphicon-remove"> delete</span></a>
	 		</div>
	 	<?php endwhile; ?>
 	</div><hr>
 </div>
 <div class="col-md-2"><a href="users.php?add_user=1" class="add-button">Add Users</a></div>
</div>
<?php } ?>