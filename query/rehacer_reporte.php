<?php

/*
 * script que hara update a un evento via ajax
 */

$idreporte = $_REQUEST['idreporte'];
$idevento = $_REQUEST['idevento'];

include_once dirname(__FILE__) . '/conexion.php'; // archivo de conexion local
require_once dirname(__FILE__) . '/insert_notification.php';

function rehacerReporte($idreporte, $idevento) {
	global $con;

    $query = "UPDATE reporte SET status='1' WHERE reporte_id = '$idreporte'";
  
    if ($result = $con->query($query)) {
    	$notifiaction_info_sql =  "SELECT e.nombre_proyecto, e.HoraTermino, u.user_id, u.user_first_name, u.user_last_name
							    	FROM evento e
							    	INNER JOIN users u ON (u.user_id = e.users_user_id AND e.evento_id = '$idevento')";
    	if ($info = $con->query($notifiaction_info_sql)) {
    		$notification_info = $info->fetch_object();
    		$descripcion = "Se te ha enviado a rehacer el reporte para el proyecto ".$notification_info->nombre_proyecto." con fecha para:";
    		echo insertNotification('4', $notification_info->user_id, $descripcion, $notification_info->HoraTermino);
    	}
        return 1;  
     } 
     else {
        return $query;
    }

}

echo rehacerReporte($idreporte, $idevento);
?>
