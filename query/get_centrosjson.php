<?php
/*
 * get_users funcion que se conecta al a base de datos para entregar la informacion de todos los centros
 * o uno especifico si hay una variable $_POST['$centro_id'] que indique id
 *
 */
include_once dirname(__FILE__).'/conexion.php'; // archivo de conexion local

function get_centrosjson($centro = null) {
	global $con;
	$result_row = array();
	$array = array();

	if($centro == null){
		$query = "SELECT centro.company_company_id AS Empresa, centro.centro_id AS id, centro.nombre AS Nombre, centro.direccion AS Direccion, centro.contacto AS Contacto, centro.telefono AS Telefono, centro.email AS Email
				  FROM centro
                  ORDER BY nombre ASC";
	}
	else{
		$query = "SELECT company_company_id AS Empresa, centro_id AS id, nombre AS Nombre, direccion AS Direccion, contacto AS Contacto, telefono AS Telefono, email AS Email
				  FROM centro
				  WHERE centro_id = $centro
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

echo json_encode(get_centrosjson());
//var_dump ( get_centros() );
