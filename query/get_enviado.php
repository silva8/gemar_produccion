<?php

include_once dirname(__FILE__) . '/conexion.php'; // archivo de conexion local

function get_enviado($idreporte) {
	global $con;
	$array = array();

	$query = "SELECT *
	FROM enviado
	WHERE reporte_reporte_id = $idreporte";
	
	if ($result = $con->query($query)) {
			$result_row = $result->fetch_object();
			if($result_row != null){
				return 'checked="checked" disabled';
			}
			else{
				return "";
			}
	}
	else{
		return "";
	}
	$result->close();

}

//var_dump(get_enviado(26));

?>