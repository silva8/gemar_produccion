<?php

require_once dirname(__FILE__) . '/conexion.php';
require_once dirname(__FILE__) . '/insert_notification.php';
require_once dirname(__FILE__) . '/get_admin_ids.php';

function insertReporte($reporte) {
    global $con;

    $rehacer = $reporte['rehacer'];
    $evento = $reporte['evento'];
    $resumen = $reporte['resumen'];
	$horario = $reporte['horario'];
    $inspeccion = $reporte['inspeccion'];
    $avance = $reporte['avance'];
    $fechacierre = $reporte['fechacierre'];
    $comentarios = $reporte['comentarios'];
    $alertas = $reporte['alertas'];
    $alcances = $reporte['alcances'];
    $conclusiones = $reporte['conclusiones'];
    $subcontratista = $reporte['subcontratista'];
    
    $number = 1;
    $numbersql = "SELECT max(numero_reporte) AS num
    			FROM reporte";
    if($numresult = $con->query($numbersql)){
    	$number = ($numresult->fetch_object()->num)+1;
    }

    $versionsql = "SELECT max(version) AS version
        FROM reporte
        WHERE evento_evento_id = $evento";
        
        // if returns something
        $lastversion = 1;
        if ($resultversion = $con->query($versionsql)) {
            $lastversion = ($resultversion->fetch_object()->version)+1;
        }
        else{
            $lastversion = 1;
        }
        $resultversion->close();
        
    $admin_ids = get_admin_ids();

    if($rehacer == 1){
        $reporteid = $reporte['reporteid'];
        
        $query = "UPDATE reporte SET status='0', 
        		version='$lastversion', 
		        horario_trabajado='$horario', 
		        tipo_inspeccion='$inspeccion', 
		        avance='$avance', 
		        fecha_estimada_cierre='$fechacierre',  
		        comentarios='$comentarios',
		        alertas='$alertas',
		        alcances='$alcances',
		        conclusiones='$conclusiones',
		        resumen='$resumen',
		        numero_reporte='$number'
		        WHERE reporte_id = '$reporteid'";

        if ($result = $con->query($query)) {
        	$notifiaction_info_sql =  "SELECT e.nombre_proyecto, e.HoraTermino, u.user_id, u.user_first_name, u.user_last_name 
        								FROM evento e 
        								INNER JOIN users u ON (u.user_id = e.users_user_id AND e.evento_id = '$evento')";
        	if ($info = $con->query($notifiaction_info_sql)) {
        		$notification_info = $info->fetch_object();
	        	$descripcion = $notification_info->user_first_name." ".$notification_info->user_last_name." actualizó un reporte para ".$notification_info->nombre_proyecto;
	        	if($reporte['admin']==0){
	        		foreach ($admin_ids as $admin_id)
	        			insertNotification('2', $admin_id->user_id, $descripcion);
	        	}
        	}
        	$eventosql =  "SELECT e.*, u.*, r.* FROM evento e INNER JOIN users u ON (u.user_id = e.users_user_id) INNER JOIN reporte r ON (r.evento_evento_id = e.evento_id AND r.reporte_id = $reporteid)";
        	if ($e = $con->query($eventosql)) {
        		$e = $e->fetch_object();
        		$nombre = $e->user_first_name." ".$e->user_last_name;
        		$logssql = "UPDATE logs SET inspector ='$nombre', 
        									comprador = '$e->comprador', 
        									proyecto = '$e->nombre_proyecto', 
        									po = '$e->orden_compra', 
        									descripcion = '$e->descripcion', 
        									proveedor = '$e->proveedor', 
        									avance = '$e->avance', 
        									comentario = '$e->comentarios'
        								WHERE reporte_reporte_id = '$reporteid'";
        		if($a = $con->query($logssql)){
        			//echo $con->insert_id;
        		}
        		else{
        			//echo $logssql;
        		}
        	}
        	return $reporteid;
        }
        else {
        	return $query;
        }
    }
	else{
    	$query = "INSERT INTO `cge30764_gemar`.`reporte`  VALUES (NULL, '$evento', '$lastversion', NOW(), '$horario', '$inspeccion', '$avance', '$fechacierre', '$comentarios', '$alertas', '$alcances', '$conclusiones', '$resumen', 0, '$subcontratista', '$number')";
    	if ($result = $con->query($query)) {
    		$reportid = $con->insert_id;
    		$notifiaction_info_sql =  "SELECT e.nombre_proyecto, e.HoraTermino, u.user_id, u.user_first_name, u.user_last_name
							    		FROM evento e
							    		INNER JOIN users u ON (u.user_id = e.users_user_id AND e.evento_id = '$evento')";
    		if ($info = $con->query($notifiaction_info_sql)) {
    			$notification_info = $info->fetch_object();
    			$descripcion = $notification_info->user_first_name." ".$notification_info->user_last_name." entregó un reporte para ".$notification_info->nombre_proyecto;
    			foreach ($admin_ids as $admin_id)
    				insertNotification('1', $admin_id->user_id, $descripcion);
    		}
    		$eventosql =  "SELECT e.*, u.*, r.* FROM evento e INNER JOIN users u ON (u.user_id = e.users_user_id) INNER JOIN reporte r ON (r.evento_evento_id = e.evento_id AND r.reporte_id = $reportid)";
    		if ($e = $con->query($eventosql)) {
    			$e = $e->fetch_object();
    			$nombre = $e->user_first_name." ".$e->user_last_name;
    			$logssql = "INSERT INTO `cge30764_gemar`.`logs`  VALUES (NULL, '-', '-', '$nombre', '$e->comprador', '$e->nombre_proyecto', '$e->orden_compra', '$e->descripcion', '$e->proveedor', '$e->HoraInicio', '0', '$e->HoraTermino', '2','$e->avance', '$e->fecha_estimada_cierre', '$e->comentarios', $reportid)";
    			if($a = $con->query($logssql)){
    				//echo $con->insert_id;
    			}
    			else{
    				//echo $logssql;
    			}
    		}
    		return $reportid;
    	}
    	else {
    		return $query;
    	}
	}

}

$reporteid = insertReporte($_REQUEST['reporte']);
echo $reporteid;
?>
