<?php
      function login_user($users_id){
      	$_SESSION['DASHboard'] = $users_id;

      	global $db;
      	$date = date('Y-m-d H:i:s');

      	$db->query("UPDATE users_department SET last_login = '$date' WHERE id = '$users_id'");

      	$_SESSION['success_flash'] = 'You are succesfully logged in to admin page';
      	header('Location: index.php');
      }

      function logged_in_admin(){
      	if (isset($_SESSION['DASHboard']) && $_SESSION['DASHboard'] > 0) {
      	  return true;
      	}
      	return false;
      }

	    function has_admin_permission($permission = 'admin'){
		global $admins;
		$permissions = explode(',', $admins['permission']);
		if (in_array($permission, $permissions, true)) {
			return true;
		}
		return false;
	   }
	   function redirect($url = 'index.php'){
	   	$_SESSION['error_flash'] = 'You are not authorised to access that page';
	   	header('Location: '.$url);
	   }
       function login_redirect($url='login.php'){
       	$_SESSION['error_flash'] = 'You must be logged in to access that page';
	   	header('Location: '.$url);
       }
?>