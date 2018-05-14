<?php

require_once dirname(__FILE__) . '/conexion.php';

function deleteFechas($id) {
	global $con;
	$query = "DELETE FROM inspeccion WHERE inspeccion_id = '$id'";

	if ($result = $con->query($query)) {
		return 1;
	}
	else {
		return $query;
	}
}

echo deleteFechas($_REQUEST['inspeccionid']);
?>
