<?php

/*
 * script que hara update a un evento via ajax
 */

$id = $_REQUEST['id'];
$nombre = $_REQUEST['nombre'];
$email = $_REQUEST['email'];
$direccion = $_REQUEST['direccion'];
$telefono = $_REQUEST['telefono'];
$cargo = $_REQUEST['cargo'];
$departamento = $_REQUEST['departamento'];
$companyid = $_REQUEST['empresa'];


include_once dirname(__FILE__) . '/conexion.php'; // archivo de conexion local

function updateContacto($id, $nombre, $email, $direccion, $telefono, $cargo, $departamento, $companyid) {
	global $con;

    $query = "UPDATE contacto SET nombre='$nombre', email='$email', direccion= '$direccion', telefono='$telefono', cargo='$cargo', departamento='$departamento', company_company_id='$companyid' WHERE contacto_id = '$id'";
  
    if ($result = $con->query($query)) {
        return 1;
     } 
     else {
        return $query;
    }

}

echo updateContacto($id, $nombre, $email, $direccion, $telefono, $cargo, $departamento, $companyid);
?>
