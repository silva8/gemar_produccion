<?php
$idreporte = $_REQUEST['idreporte'];
$iduser = $_REQUEST['iduser'];

include_once dirname(__FILE__) . '/conexion.php'; // archivo de conexion local

function insertSend($idreporte, $iduser) {
	global $con;
	
	$fecha = date("Y-m-d H:i:s");
	
	$query = "INSERT INTO enviado (`users_user_id`, `fecha`, `reporte_reporte_id`) VALUES ('$iduser','$fecha','$idreporte')";
			
	if ($result = $con->query($query)) {
		return $con->insert_id;
	}
	else {
		return $query;
	}

}

echo insertSend($idreporte, $iduser);
?>
