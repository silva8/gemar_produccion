<?php

/**
* @param {int} : $userid [mandatory]
* @param {int} : $centroid [mandatory]
* @param {string} : $start [mandatory] ('YYYY-MM-DDTHH:mm:ss')
* @param {string} : $end [mandatory] ('YYYY-MM-DDTHH:mm:ss')
* @return {int} : numero del evento ingresado
* Funcion recibe los datos de un evento para ingresarlo en la base de datos, retorna
* 1 si success o 0 si fail
*/
require_once dirname(__FILE__) . '/conexion.php';

function insertNotification($tipo, $userid, $descripcion, $fecha = null) {
	global $con;
	
	if(is_null($fecha)){
		$query = "INSERT INTO `cge30764_gemar`.`notificaciones` (`tipo`, `users_user_id`, `descripcion`, `leido`, `fecha`) VALUES ('$tipo', '$userid', '$descripcion', '0', NOW())";
	}
	else{
		$query = "INSERT INTO `cge30764_gemar`.`notificaciones` (`tipo`, `users_user_id`, `descripcion`, `leido`, `fecha`) VALUES ('$tipo', '$userid', '$descripcion', '0', '$fecha')";
	}
	


	if ($result = $con->query($query)) {
		return $con->insert_id;
	}
	else {
		return $query;
	}
}
?>
