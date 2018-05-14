<?php

/*
 * script que hara update a un evento via ajax
 */

$id = $_REQUEST['id'];
$nombre = $_REQUEST['nombre'];
$rut = $_REQUEST['rut'];
$giro = $_REQUEST['giro'];
$direccion = $_REQUEST['direccion'];
$comuna = $_REQUEST['comuna'];
$ciudad = $_REQUEST['ciudad'];
$razonsocial = $_REQUEST['razonsocial'];
$mail = $_REQUEST['mail'];


include_once dirname(__FILE__) . '/conexion.php'; // archivo de conexion local

function updateEmpresa($id, $nombre, $rut, $giro, $direccion, $comuna, $ciudad, $razonsocial, $mail) {
	global $con;

    $query = "UPDATE company SET nombre='$nombre', rut='$rut', giro= '$giro', direccion='$direccion', comuna='$comuna', ciudad='$ciudad', razonsocial='$razonsocial', mail='$mail' WHERE company_id = '$id'";
  
    if ($result = $con->query($query)) {
        return 1;
     } 
     else {
        return $query;
    }

}

echo updateEmpresa($id, $nombre, $rut, $giro, $direccion, $comuna, $ciudad, $razonsocial, $mail);
?>
