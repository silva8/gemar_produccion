<?php

require_once dirname(__FILE__) . '/conexion.php';

function deleteDocumento($id) {
	global $con;
	$query = "DELETE FROM documentos WHERE documentos_id = '$id'";

	if ($result = $con->query($query)) {
		return 1;
	}
	else {
		return $query;
	}
}

echo deleteDocumento($_REQUEST['documentoid']);
?>
