<?php

require_once dirname(__FILE__) . '/conexion.php';

function insertAsistentes($asistentes) {
    global $con;
	
    $asistenteid = $asistentes['asistenteid'];
    $nombre = $asistentes['nombre'];
    $company = $asistentes['company'];
    $cargo = $asistentes['cargo'];
    $reporte = $asistentes['reporte'];
	
    if(is_null($asistenteid)){
    	$query = "INSERT INTO `cge30764_gemar`.`asistentes`  VALUES (NULL, '$nombre', '$company', '$cargo', '$reporte')";
    }
    else{
    	$query = "UPDATE asistentes SET
    	nombre='$nombre',
    	compa='$company',
    	cargo='$cargo'
    	WHERE asistentes_id = '$asistenteid'";
    }
    
    if ($result = $con->query($query)) {
        return $con->insert_id;
     } 
     else {
        return $query;
    }
}

echo insertAsistentes($_REQUEST['asistentes']);
?>
