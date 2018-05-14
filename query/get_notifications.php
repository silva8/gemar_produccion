<?php

include_once dirname(__FILE__) . '/conexion.php'; // archivo de conexion local

function getNotifications($iduser = null) {
	global $con;
	$array = array();
	
	if($iduser == null){
		$query = "SELECT *
		FROM notificaciones
		WHERE users_user_id = 1 AND leido = 0
		ORDER BY fecha DESC
		LIMIT 10";
	}
	else{
		$query = "SELECT *
		FROM notificaciones
		WHERE users_user_id = $iduser AND leido = 0
		ORDER BY notificacion_id DESC
		LIMIT 10";
	}

	if ($result = $con->query($query)) {
		while ( $result_row = $result->fetch_object() ) {
			$array[] = $result_row;
		}
	}
	$result->close();

	return $array;
}



?>