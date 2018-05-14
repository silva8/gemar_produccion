<?php

require_once dirname(__FILE__) . '/conexion.php';

function deleteEquipo($id) {
	global $con;
	$query = "DELETE FROM equipos WHERE equipos_id = '$id'";

	if ($result = $con->query($query)) {
		return 1;
	}
	else {
		return $query;
	}
}

echo deleteEquipo($_REQUEST['equipoid']);
?>
