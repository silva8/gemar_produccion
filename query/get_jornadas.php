<?php

include_once dirname(__FILE__) . '/conexion.php'; // archivo de conexion local

function get_jornadas() {
	global $con;
	$array = array();
	$date = date('Y-m-00');
	
	$query = "SELECT COUNT(i.inspeccion_id) AS media_jornada
			FROM inspeccion i
			WHERE i.jornada='0.5' AND i.fecha >= $date";

	if ($result = $con->query($query)) {
		while ( $result_row = $result->fetch_object() ) {
			$array[] = $result_row;
		}
	}
	
	$query = "SELECT COUNT(i.inspeccion_id) AS jornada_completa
	FROM inspeccion i
	WHERE i.jornada='1' AND  i.fecha >= $date";
	
	if ($result = $con->query($query)) {
		while ( $result_row = $result->fetch_object() ) {
			$array[] = $result_row;
		}
	}
	
	$query = "SELECT COUNT(i.inspeccion_id) AS jornada_residente
	FROM inspeccion i
	WHERE i.jornada='0' AND i.fecha >= $date";
	
	if ($result = $con->query($query)) {
		while ( $result_row = $result->fetch_object() ) {
			$array[] = $result_row;
		}
	}
	
	$result->close();

	return $array;
}

?>