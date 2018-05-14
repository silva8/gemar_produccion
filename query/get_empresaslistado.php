<?php
/*
 * get_users funcion que se conecta al a base de datos para entregar la informacion de todos los centros
 * o uno especifico si hay una variable $_POST['$centro_id'] que indique id
 *
 */
include_once dirname(__FILE__).'/conexion.php'; // archivo de conexion local

function get_empresas($company = null) {
	global $con;
	$result_row = array();

	if($company == null){
		$query = "SELECT company_id AS id, nombre AS Nombre, rut AS Rut, giro AS Giro, direccion AS Direccion, comuna AS Comuna, ciudad AS Ciudad, razonsocial AS RazonSocial, mail AS Email
				  FROM company
                  ORDER BY nombre ASC";
	}
	else{
		$query = "SELECT company_id AS id, nombre AS Nombre, rut AS Rut, giro AS Giro, direccion AS Direccion, comuna AS Comuna, ciudad AS Ciudad, razonsocial AS RazonSocial, mail AS Email
				  FROM company
				  WHERE company_id = $company
	              ORDER BY nombre ASC";
	}
    if ($result = $con->query($query)) {
		while ( $result_row = $result->fetch_object() ) {
			$array[] = $result_row;
		}
	}
	$result->close();
	return $array;
}

