<?php

require_once dirname(__FILE__) . '/conexion.php';

function deletePendiente($id) {
	global $con;
	$query = "DELETE FROM pendientes WHERE pendientes_id = '$id'";

	if ($result = $con->query($query)) {
		return 1;
	}
	else {
		return $query;
	}
}

echo deletePendiente($_REQUEST['pendienteid']);
?>
