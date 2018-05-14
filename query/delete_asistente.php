<?php

require_once dirname(__FILE__) . '/conexion.php';

function deleteAsistente($id) {
	global $con;
	$query = "DELETE FROM asistentes WHERE asistentes_id = '$id'";

	if ($result = $con->query($query)) {
		return 1;
	}
	else {
		return $query;
	}
}

echo deleteAsistente($_REQUEST['asistenteid']);
?>
