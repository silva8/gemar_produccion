<?php

require_once dirname(__FILE__) . '/conexion.php';

function insertCentro($nombre, $direccion, $contacto, $telefono, $email, $companyid) {
    global $con;

    $query = "INSERT INTO `cge30764_gemar`.`centro`  VALUES (NULL, '$companyid', '$nombre', '$direccion', '$contacto', '$telefono', '$email')";
  
    if ($result = $con->query($query)) {
        return $con->insert_id;
     } 
     else {
        return $query;
    }
}

echo insertCentro($_REQUEST['nombre'], $_REQUEST['direccion'], $_REQUEST['contacto'], $_REQUEST['telefono'], $_REQUEST['email'], $_REQUEST['empresa']);
?>
