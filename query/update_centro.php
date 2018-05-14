<?php

/*
 * script que hara update a un evento via ajax
 */

$id = $_REQUEST['id'];
$nombre = $_REQUEST['nombre'];
$direccion = $_REQUEST['direccion'];
$contacto = $_REQUEST['contacto'];
$telefono = $_REQUEST['telefono'];
$email = $_REQUEST['email'];
$companyid = $_REQUEST['empresa'];


include_once dirname(__FILE__) . '/conexion.php'; // archivo de conexion local

function updateCentro($id, $nombre, $direccion, $contacto, $telefono, $email, $companyid) {
	global $con;

    $query = "UPDATE centro SET nombre='$nombre', direccion='$direccion', contacto= '$contacto', telefono='$telefono', email='$email', company_company_id='$companyid' WHERE centro_id = '$id'";
  
    if ($result = $con->query($query)) {
        return 1;  
     } 
     else {
        return $query;
    }

}

echo updateCentro($id, $nombre, $direccion, $contacto, $telefono, $email, $companyid);
?>
