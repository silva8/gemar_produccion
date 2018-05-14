<?php

include_once dirname(__FILE__) . '/conexion.php'; // archivo de conexion local

function get_eventos($iduser = null, $month, $year) {
	global $con;
	$array = array();

    if  ($iduser != null) {
    	//solamente eventos de un usuario

        $query = "SELECT *
    			FROM evento
                LEFT JOIN reporte on (reporte.evento_evento_id = evento.evento_id)
    			INNER JOIN centro on (centro.centro_id = evento.centro_centro_id AND evento.users_user_id = $iduser)
                WHERE reporte.status IS NULL OR reporte.status = 1
                ORDER BY evento.criticidad DESC, evento.HoraInicio DESC";
    }
    else {
        //administrador
        $query = "SELECT *
            FROM evento
            INNER JOIN users on (users.user_id = evento.users_user_id) 
            INNER JOIN reporte on (evento.evento_id = reporte.evento_evento_id )
            INNER JOIN centro on (centro.centro_id = evento.centro_centro_id)
            WHERE reporte.status IN (0,2) AND MONTH(reporte.fecha) = $month AND YEAR(reporte.fecha) = $year 
            ORDER BY evento.criticidad DESC, evento.HoraInicio DESC, reporte.version DESC";
    }
        
    if ($result = $con->query($query)) {
		while ( $result_row = $result->fetch_object() ) {
			$array[] = $result_row;
		}
	}
	$result->close();

    return $array;
}

?>