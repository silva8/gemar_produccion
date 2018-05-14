<?php

require_once dirname(__FILE__) . '/conexion.php';

function insertFechaInspeccion($inspeccion) {
	global $con;

	$inspeccionid = $inspeccion['inspeccionid'];
	$fecha = $inspeccion['fecha'];
	$reporte = $inspeccion['reporte'];
	$jornada = $inspeccion['jornada'];

	if(is_null($inspeccionid)){
		$query = "INSERT INTO `cge30764_gemar`.`inspeccion`  VALUES (NULL, '$fecha','$jornada','$reporte')";
	}
	else{
		$query = "UPDATE inspeccion SET
		fecha='$fecha',
		jornada='$jornada'
		WHERE inspeccion_id = '$inspeccionid'";
	}

	if ($result = $con->query($query)) {
		return $con->insert_id;
	}
	else {
		return $query;
	}
}

echo insertFechaInspeccion($_REQUEST['inspeccion']);
?>
