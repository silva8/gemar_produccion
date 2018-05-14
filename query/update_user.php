<?php

require_once dirname(__FILE__) . '/conexion.php';

function updateUser($user) {
	global $con;
	
	$userid = $user['userid'];
	$first_name = $user['user_first_name'];
	$last_name = $user['user_last_name'];
	$email = $user['user_email'];
	$phone = $user['user_phone'];
	$title = $user['user_title'];
	$discipline = $user['user_discipline'];
	if(isset($user['user_image_path'])){
		$path = $user['user_image_path'];

		$query = "UPDATE users SET
				user_first_name ='$first_name',
				user_last_name ='$last_name',
				user_email='$email',
				user_phone='$phone',
				user_title='$title',
				user_discipline='$discipline',
				user_image_path='$path'
				WHERE user_id = '$userid'";
	}
	else{
		$query = "UPDATE users SET
		user_first_name ='$first_name',
		user_last_name ='$last_name',
		user_email='$email',
		user_phone='$phone',
		user_title='$title',
		user_discipline='$discipline'
		WHERE user_id = '$userid'";
	}

	if ($result = $con->query($query)) {
		return $reporteid;
	}
	else {
		return $query;
	}
	
}

echo updateUser($_REQUEST['user']);
?>
