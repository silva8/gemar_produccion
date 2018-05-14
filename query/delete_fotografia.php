<?php

require_once dirname(__FILE__) . '/conexion.php';

function deleteFotografia($id) {
	global $con;
	$query1 = "SELECT * FROM fotografias WHERE fotografias_id = '$id'";
	if ($result = $con->query($query1)) {
		unlink(dirname(dirname(__FILE__)).'/images/reportes/'.$result->imagen_path);
	}
	$query = "DELETE FROM fotografias WHERE fotografias_id = '$id'";

	if ($result = $con->query($query)) {
		return 1;
	}
	else {
		return $query;
	}
}

echo deleteFotografia($_REQUEST['fotografiaid']);
?>
