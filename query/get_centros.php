<?php
/*
 * get_users funcion que se conecta al a base de datos para entregar la informacion de todos los centros
 * o uno especifico si hay una variable $_POST['$centro_id'] que indique id
 *
 */
include_once dirname(__FILE__).'/conexion.php'; // archivo de conexion local

function get_centros($company = null, $centro_id = null, $centroyempresa = null) {
	global $con;
	$array = array();

	if($company == null){

		if ($centro_id == null) { // si se utilizo la funcion sin un id especifico
			$query = "SELECT centro_id, nombre, direccion, contacto, telefono, email
					  FROM centro
	                  ORDER BY nombre ASC";
		} 
		else { // si se indico un id para buscar solo los datos de dicho centro
			$query = "SELECT centro_id, nombre, direccion, contacto, telefono, email
					  FROM centro
					  WHERE centro_id = $centro_id
	                  ORDER BY nombre ASC";
	    }
	}
	else if($centroyempresa != null){
			$query = "SELECT centro.centro_id, centro.nombre, centro.direccion, centro.contacto, centro.telefono, centro.email, company.nombre AS empresa
					  FROM centro
					  INNER JOIN company on (company.company_id = centro.company_company_id)
	                  ORDER BY centro.nombre ASC";
	}
	else{
		$query = "SELECT centro_id, nombre, direccion, contacto, telefono, email
				  FROM centro
				  WHERE company_company_id = $company
	              ORDER BY nombre ASC";
	}
    // if returns something
    if ($result = $con->query($query)) {
		while ( $result_row = $result->fetch_object() ) {
			$array[] = $result_row;
		}
	}
	$result->close();
	return $array;
}

//var_dump ( get_centros() );
