<?php

include_once dirname(__FILE__) . '/conexion.php'; // archivo de conexion local

function updateNotification($idnotification) {
	global $con;

	$query = "UPDATE notificaciones SET leido='1' WHERE notificacion_id=$idnotification";

	if ($result = $con->query($query)) {
		return 1;
	}
	else {
		return $query;
	}

}

echo updateNotification($_REQUEST['notificacion_id']);

?>
