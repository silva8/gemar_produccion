<?php

include_once dirname(__FILE__) . '/conexion.php'; // archivo de conexion local

function get_logs($companyid) {
	global $con;
	$array = array();

  
        $query = "SELECT l.*
        		FROM logs l
        		INNER JOIN reporte r ON (l.reporte_reporte_id = r.reporte_id)
        		INNER JOIN evento e ON (r.evento_evento_id = e.evento_id)
        		INNER JOIN centro c ON (e.centro_centro_id = c.centro_id)
        		INNER JOIN company co ON (c.company_company_id = co.company_id AND co.company_id = $companyid)
                ORDER BY fecha DESC";

    if ($result = $con->query($query)) {
    	$count = 1;
		while ( $result_row = $result->fetch_object() ) {			
			$array[] = (object) array_merge((array) $result_row, array("n" => $count));
			$count++;
		}
	}
	$result->close();

    return $array;
}

if($_REQUEST['json'] == 1)
	echo json_encode(get_logs($_REQUEST['id']));

?>