<?php

require_once dirname(__FILE__) . '/conexion.php';

function insertEquipo($equipo) {
    global $con;
	
    $equipoid = $equipo['equipoid'];
    $tag = $equipo['tag'];
    $descripcion = $equipo['descripcion'];
    $proveedor = $equipo['proveedor'];
    $comentario = $equipo['comentario'];
    $reporte = $equipo['reporte'];
	
    if(is_null($equipoid)){
    	$query = "INSERT INTO `cge30764_gemar`.`equipos`  VALUES (NULL, '$tag', '$descripcion', '$proveedor', '$comentario', '$reporte')";
    }
    else{
    	$query = "UPDATE equipos SET
		    	tag='$tag',
		    	descripcion='$descripcion',
		    	proveedor='$proveedor',
		    	comentario='$comentario'
		    	WHERE equipos_id = '$equipoid'";
    }
    if ($result = $con->query($query)) {
        return $con->insert_id;
     } 
     else {
        return $query;
    }
}

echo insertEquipo($_REQUEST['equipo']);
?>
