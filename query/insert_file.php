<?php

require_once dirname(__FILE__) . '/conexion.php';

function insertFile($file) {
	global $con;

	$filepath = $file['filepath'];
	$reporte = $file['reporte'];

	$query = "INSERT INTO `cge30764_gemar`.`files`  VALUES (NULL, '$filepath', '$reporte')";

	if ($result = $con->query($query)) {
		return $con->insert_id;
	}
	else {
		return $query;
	}
}

echo insertFile($_REQUEST['file']);
?>
