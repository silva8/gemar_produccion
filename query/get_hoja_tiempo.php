<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include_once dirname(__FILE__) . '/conexion.php'; // archivo de conexion local

function get_hoja_tiempo($fecha, $userid) {
	global $con;
	$array = array();
	
	$year = explode("-", $fecha)[0];
	$week = explode("-", $fecha)[1];
	$date = getStartAndEndDate($week, $year);

	$query = "SELECT reporte.*, evento.*, inspeccion.fecha as fecha_inspeccion, company.ciudad as sitio, users.user_first_name, users.user_last_name
			FROM evento
			INNER JOIN users on (users.user_id = evento.users_user_id AND users.user_id = '".$userid."')
			INNER JOIN reporte on (evento.evento_id = reporte.evento_evento_id )
			INNER JOIN centro on (centro.centro_id = evento.centro_centro_id)
			INNER JOIN company on (company.company_id = centro.company_company_id)
		    INNER JOIN inspeccion on (inspeccion.reporte_reporte_id = reporte.reporte_id)
			WHERE reporte.status IN (0,2) AND inspeccion.fecha >= '".$date["week_start"]."' AND inspeccion.fecha <= '".$date["week_end"]."'
			ORDER BY inspeccion.fecha ASC";

	if ($result = $con->query($query)) {
		while ( $result_row = $result->fetch_object() ) {
			$array[] = $result_row;
		}
		$result->close();
	}

	return $array;
}

function getStartAndEndDate($week, $year) {
	$dto = new DateTime();
	$dto->setISODate($year, $week);
	$ret['week_start'] = $dto->format('Y-m-d');
	$dto->modify('+6 days');
	$ret['week_end'] = $dto->format('Y-m-d');
	$ret["week"] = $week;
	$ret["year"] = $year;
	return $ret;
}

//var_dump(get_hoja_tiempo("2017-52", 14));

?>