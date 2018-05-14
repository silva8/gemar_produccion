<?php

include_once dirname(__FILE__) . '/conexion.php'; // archivo de conexion local

function getFiles($idreporte = null) {
	global $con;
	$array = array();

	$query = "SELECT r.reporte_id, f.*
	FROM reporte r
	INNER JOIN files f ON (r.reporte_id = f.reporte_reporte_id)
	WHERE r.reporte_id = $idreporte";

	if ($result = $con->query($query)) {
		while ( $result_row = $result->fetch_object() ) {
			$array[] = $result_row;
		}
	}
	
	$result->close();

	return $array;
}

if (isset ( $_REQUEST ['idreporte'] )) {

	echo json_encode(getFiles($_REQUEST['idreporte']));
}



?>