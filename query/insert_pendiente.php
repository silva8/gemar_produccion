<?php

require_once dirname(__FILE__) . '/conexion.php';

function insertPendientes($pendientes) {
    global $con;
	
    $pendienteid = $pendientes['pendienteid'];
    $numero = $pendientes['numero'];
    $descripcion = $pendientes['descripcion'];
    $pendiente = $pendientes['pendiente'];
    $comentarios = $pendientes['comentarios'];
    $reporte = $pendientes['reporte'];

    if(is_null($pendienteid)){
    	$query = "INSERT INTO `cge30764_gemar`.`pendientes`  VALUES (NULL, '$numero', '$descripcion', '$pendiente', '$comentarios', '$reporte')";
    }
    else{
    	$query = "UPDATE pendientes SET
    	numero='$numero',
    	descripcion='$descripcion',
    	pendientes='$pendiente',
    	comentarios='$comentarios'
    	WHERE pendientes_id = '$pendienteid'";
    }
    
    if ($result = $con->query($query)) {
        return $con->insert_id;
     } 
     else {
        return $query;
    }
}

echo insertPendientes($_REQUEST['pendientes']);
?>
