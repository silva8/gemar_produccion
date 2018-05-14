<?php

require_once dirname(__FILE__) . '/conexion.php';

function insertContacto($nombre, $email, $direccion, $telefono, $cargo, $departamento, $companyid) {
    global $con;

    $query = "INSERT INTO `cge30764_gemar`.`contacto`  VALUES (NULL, '$companyid', '$nombre', '$email', '$direccion', '$telefono', '$cargo', '$departamento')";
  
    if ($result = $con->query($query)) {
        return $con->insert_id;
     } 
     else {
        return $query;
    }
}

echo insertContacto($_REQUEST['nombre'], $_REQUEST['email'], $_REQUEST['direccion'], $_REQUEST['telefono'], $_REQUEST['cargo'], $_REQUEST['departamento'], $_REQUEST['empresa']);
?>
