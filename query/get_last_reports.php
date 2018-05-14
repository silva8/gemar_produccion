<?php

include_once dirname(__FILE__) . '/conexion.php'; // archivo de conexion local

function getLastReports() {
	global $con;
	$array = array();
	$date = date('Y-m-00');
	
	$query = "SELECT evento.nombre_proyecto, reporte.avance, reporte.fecha, users.user_first_name, users.user_last_name, company.nombre
				FROM reporte
				INNER JOIN evento ON (reporte.evento_evento_id = evento.evento_id)
				INNER JOIN users ON (evento.users_user_id = users.user_id)
				INNER JOIN centro ON (evento.centro_centro_id = centro.centro_id)
				INNER JOIN company ON (centro.company_company_id = company.company_id)
				WHERE reporte.fecha >= $date
				LIMIT 5";

	if ($result = $con->query($query)) {
		while ( $result_row = $result->fetch_object() ) {
			$array[] = $result_row;
		}
	}
	$result->close();

	return $array;
}



?>