<?php

/*
 * script que hara update a un log via ajax
*/

$id = $_REQUEST['id'];
$activador = $_REQUEST['activador'];
$informe = $_REQUEST['informe'];
$inspector = $_REQUEST['inspector'];
$comprador = $_REQUEST['comprador'];
$proyecto = $_REQUEST['proyecto'];
$po = $_REQUEST['po'];
$descripcion = $_REQUEST['descripcion'];
$proveedor = $_REQUEST['proveedor'];
$inicio = $_REQUEST['inicio'];
$dias = $_REQUEST['dias'];
$termino = $_REQUEST['termino'];
$nivel = $_REQUEST['nivel'];
$avance = $_REQUEST['avance'];
$fecha = $_REQUEST['fecha'];
$comentario = $_REQUEST['comentario'];

include_once dirname(__FILE__) . '/conexion.php'; // archivo de conexion local

function updateLog($id, $activador, $informe, $inspector, $comprador, $proyecto, $po, $descripcion, $proveedor, $inicio, $dias, $termino, $nivel, $avance, $fecha, $comentario) {
	global $con;

	$query = "UPDATE logs SET activador='$activador', informe='$informe', inspector= '$inspector', comprador='$comprador', proyecto='$proyecto', po='$po', descripcion = '$descripcion', proveedor='$proveedor', nivel='$inicio', avance='$avance', fecha='$fecha', comentario='$comentario' WHERE logs_id = '$id'";

	if ($result = $con->query($query)) {
		return 1;
	}
	else {
		return $query;
	}

}

echo updateLog($id, $activador, $informe, $inspector, $comprador, $proyecto, $po, $descripcion, $proveedor, $inicio, $dias, $termino, $nivel, $avance, $fecha, $comentario);
?>
