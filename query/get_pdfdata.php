<?php

include_once dirname(__FILE__) . '/conexion.php'; // archivo de conexion local

function getPdfData($idreporte = null, $idevento = null) {
	global $con;
	$array = array();
	if($idreporte != null){
		$query = "SELECT r.*, e.*, c.nombre as nombre_contacto, c.email as email_contacto,
				c.direccion as direccion_contacto, c.telefono as telefono_contacto, c.cargo as cargo_contacto,
				c.departamento as departamento_contacto, ce.nombre as nombre_centro, ce.direccion as direccion_centro,
				ce.contacto as contacto_centro, ce.telefono as telefono_centro, ce.email as email_centro, co.*, s.*
				FROM reporte r
				INNER JOIN evento e ON (e.evento_id = r.evento_evento_id)
				INNER JOIN contacto c ON (c.contacto_id = e.contacto_contacto_id)
				INNER JOIN centro ce ON (ce.centro_id = e.centro_centro_id)
				INNER JOIN company co ON (co.company_id = ce.company_company_id)
				INNER JOIN users s ON (s.user_id = e.users_user_id)
				WHERE reporte_id = $idreporte";
	}
	else{
		$query = "SELECT e.*, c.nombre as nombre_contacto, c.email as email_contacto,
			c.direccion as direccion_contacto, c.telefono as telefono_contacto, c.cargo as cargo_contacto,
			c.departamento as departamento_contacto, ce.nombre as nombre_centro, ce.direccion as direccion_centro,
			ce.contacto as contacto_centro, ce.telefono as telefono_centro, ce.email as email_centro, co.*, s.*
			FROM evento e
			INNER JOIN contacto c ON (c.contacto_id = e.contacto_contacto_id)
			INNER JOIN centro ce ON (ce.centro_id = e.centro_centro_id)
			INNER JOIN company co ON (co.company_id = ce.company_company_id)
			INNER JOIN users s ON (s.user_id = e.users_user_id)
			WHERE e.evento_id = $idevento";
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