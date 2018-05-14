<?php

require_once dirname(__FILE__) . '/conexion.php';

function insertDocumento($documento) {
    global $con;
	
    $documentoid = $documento['documentoid'];
    $numero = $documento['numero'];
    $revision = $documento['revision'];
    $nombre = $documento['nombre'];
    $status = $documento['status'];
    $reporte = $documento['reporte'];

    if(is_null($documentoid)){
    	$query = "INSERT INTO `cge30764_gemar`.`documentos`  VALUES (NULL, '$numero', '$revision', '$nombre', '$status', '$reporte')";
    }
    else{
    	$query = "UPDATE documentos SET
		    	numero='$numero',
		    	revision='$revision',
		    	nombre='$nombre',
		    	status='$status'
		    	WHERE documentos_id = '$documentoid'";
    }
    
    if ($result = $con->query($query)) {
        return $con->insert_id;
     } 
     else {
        return $query;
    }
}

echo insertDocumento($_REQUEST['documento']);
?>
