<?php
/*
 * get_users funcion que se conecta al a base de datos para entregar la informacion de todos los usuarios
 * o uno especifico si hay una variable $_POST['$user_id'] que indique id
 *
 */
include_once dirname(__FILE__).'/conexion.php'; // archivo de conexion local

function get_contactos($contacto_id = null, $company_id = null, $centro_id = null) {
	global $con;
	$array = array();

	if ($contacto_id != null) { // si se utilizo la funcion con un id especifico
		$query = "SELECT *
				  FROM contacto
				  WHERE contacto_id = $contacto_id
                  ORDER BY nombre ASC";
	} 

	else if($company_id != null){ // si se indico un id para buscar solo los datos de empresa
		$query = "SELECT *
				  FROM contacto
				  WHERE company_company_id = $contacto_id
                  ORDER BY nombre ASC";
    }

	else if($centro_id != null){ // si se indico un id para buscar solo los datos de centro
		//primero hacer query para sacar de que company pertenece el centro
		$sql = "SELECT * FROM centro WHERE centro_id = $centro_id";

    	if ($res = $con->query($sql)) {
			$rescompany = $res->fetch_object(); 
			$companyid = $rescompany ->company_company_id;
			$res->close();
		}

		$query = "SELECT *
				  FROM contacto
				  WHERE company_company_id = $companyid
                  ORDER BY nombre ASC";
    }

    else {
    	$query = "SELECT contacto_id AS id, company_company_id AS Empresa, nombre AS Nombre, email AS Email, direccion AS Direccion, telefono AS Telefono, cargo AS Cargo, departamento AS Departamento
				  FROM contacto
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

if(isset($_REQUEST['ajax'])){
	echo json_encode(get_contactos());
}

//var_dump ( get_users() );
