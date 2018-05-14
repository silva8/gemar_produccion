<?php

include_once dirname(__FILE__) . '/conexion.php'; // archivo de conexion local

function getExtras($idreporte = null) {
	global $con;
	$array = array("equipos"=>array(), "asistentes"=>array(), "documentos"=>array(),"pendientes"=>array(), "inspeccion"=>array(),"fotografias"=>array());

	$query_equipos = "SELECT r.reporte_id, e.*
	FROM reporte r
	INNER JOIN equipos e ON (r.reporte_id = e.reporte_reporte_id)
	WHERE r.reporte_id = $idreporte";
	$query_asistentes = "SELECT r.reporte_id, a.*
	FROM reporte r
	INNER JOIN asistentes a ON (r.reporte_id = a.reporte_reporte_id)
	WHERE r.reporte_id = $idreporte";
	$query_documentos = "SELECT r.reporte_id, d.*
	FROM reporte r
	INNER JOIN documentos d ON (r.reporte_id = d.reporte_reporte_id)
	WHERE r.reporte_id = $idreporte";
	$query_pendientes = "SELECT r.reporte_id, p.*
	FROM reporte r
	INNER JOIN pendientes p ON (r.reporte_id = p.reporte_reporte_id)
	WHERE r.reporte_id = $idreporte";
	$query_inspeccion = "SELECT r.reporte_id, i.*
	FROM reporte r
	INNER JOIN inspeccion i ON (r.reporte_id = i.reporte_reporte_id)
	WHERE r.reporte_id = $idreporte";
	$query_fotografias = "SELECT r.reporte_id, f.*
	FROM reporte r
	INNER JOIN fotografias f ON (r.reporte_id = f.reporte_reporte_id)
	WHERE r.reporte_id = $idreporte";

	if ($result = $con->query($query_equipos)) {
		while ( $result_row = $result->fetch_object() ) {
			$array["equipos"][] = $result_row;
		}
	}
	if ($result = $con->query($query_asistentes)) {
		while ( $result_row = $result->fetch_object() ) {
			$array["asistentes"][] = $result_row;
		}
	}
	if ($result = $con->query($query_documentos)) {
		while ( $result_row = $result->fetch_object() ) {
			$array["documentos"][] = $result_row;
		}
	}
	if ($result = $con->query($query_pendientes)) {
		while ( $result_row = $result->fetch_object() ) {
			$array["pendientes"][] = $result_row;
		}
	}
	if ($result = $con->query($query_inspeccion)) {
		while ( $result_row = $result->fetch_object() ) {
			$array["inspeccion"][] = $result_row;
		}
	}
	if ($result = $con->query($query_fotografias)) {
		while ( $result_row = $result->fetch_object() ) {
			$array["fotografias"][] = $result_row;
		}
	}
	$result->close();

	return $array;
}

if (isset ( $_REQUEST ['idreporte'] )) {

	echo json_encode(getExtras($_REQUEST['idreporte']));
}


?>