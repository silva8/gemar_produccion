<?php

include_once dirname(__FILE__).'/conexion.php'; // archivo de conexion local

function get_admin_ids() {
	global $con;

	$array = array();

	
	$query = "SELECT user_id
			  FROM users
			  WHERE user_role = 1";
	
	// if returns something
	if ($result = $con->query($query)) {
		while ( $result_row = $result->fetch_object() ) {
			$array[] = $result_row;
		}
	}
	$result->close();
	return $array;
}

//var_dump ( get_admin_ids() );
