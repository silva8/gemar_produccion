<?php
/*
 * get_users funcion que se conecta al a base de datos para entregar la informacion de todos los usuarios
* o uno especifico si hay una variable $_POST['$user_id'] que indique id
*
*/
include_once dirname(__FILE__).'/conexion.php'; // archivo de conexion local

function get_usersjson($user_id = null) {
	global $con;


	$query = "SELECT user_id, user_name, user_email, user_role, user_phone, user_region, user_title, user_discipline, user_image_path, user_color_tag, concat(user_first_name,' ', user_last_name) as nombre, user_first_name, user_last_name
		FROM users
		WHERE user_role = 0 AND user_id = $user_id
		ORDER BY user_last_name ASC";

	// if returns something
	if ($result = $con->query($query)) {
		while ( $result_row = $result->fetch_object() ) {
			$r = $result_row;
		}
	}
	$result->close();
	return $r;
}

if (isset ( $_REQUEST ['iduser'] )) {

	echo json_encode(get_usersjson($_REQUEST['iduser']));
}
