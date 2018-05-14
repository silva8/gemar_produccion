<?php

include_once dirname(__FILE__) . '/conexion.php'; // archivo de conexion local

function getReportes($iduser = null) {
	global $con;
	$array = array();

    if  ($iduser != null) {
    	//solamente eventos de un usuario

        $query = "SELECT *
        			FROM eventos
        			INNER JOIN centro on (centro.centro_id = evento.centro_centro_id)
        			INNER JOIN contacto on (contacto.contacto_id = evento.contacto_contacto_id)
        			INNER JOIN 

        ";
    }
    else {
    	//admin ve todos los eventos
    }
        
    if ($result = $con->query($query)) {
		while ( $result_row = $result->fetch_object() ) {
			$array[] = $result_row;
		}
	}
	$result->close();

    return $array;
}


if (isset ( $_REQUEST ['idcentro'] )) {
	
	echo json_encode ( getEventos ( $_REQUEST ['idcentro'], null ) );
}
else if (isset ( $_REQUEST ['iduser'] )) {
	
	echo json_encode ( getEventos ( null, $_REQUEST ['iduser'] ) );
}

?>