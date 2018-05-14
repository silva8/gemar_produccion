<?php
/*
 * Script que genera los eventos desde la base de datos indicandole el id del centro
 * en formato json para cargarlos en el calendario
 *
 * el formato de los eventos sera
 *
 *
 * evento = {
 * "title" : "Evento prueba",
 * "start" : "2017-09-27T10:00:00",
 * "end" : "2017-09-27T12:00:00",
 * "id" : "7",
 * "userID" : "1",
 * "color" : "#ff0000",
 * "className" : "ticketSrc_1",
 * "custom" : "test text here",
 * "eventDurationEditable" : true
 * };
 *
 *
 *
 *
 *
 */

/*
 * getEventos funcion que se conecta al a base de datos para entregar los Eventos de un Centro
 * se le debe entregar un idCentro
 * @param: {int} $idcentro = null
 * @param: {int} $iduser = null
 * @return: {array} // listado eventos
 *
 */
include_once dirname(__FILE__) . '/conexion.php'; // archivo de conexion local

function getEventos($idcentro = null, $iduser = null) {
	global $con;
	$array = array();

    if ($idcentro != null) {
 
        $query = "SELECT evento.nombre_proyecto as title, concat(users.user_first_name,' ',users.user_last_name) as description, evento.evento_id as id, evento.HoraInicio as start, evento.HoraTermino as end, evento.color as color, centro.centro_id as idcentro, users.user_id as userid, centro.direccion as direccion, centro.nombre as centro, evento.orden_compra as ordencompra, evento.visitas_agendadas as visitasagendadas, evento.descripcion as descripcionproyecto, evento.descripcion as descripcionproyecto, contacto.nombre as contacto
			FROM evento
			INNER JOIN users on (users.user_id = evento.users_user_id)
			INNER JOIN contacto on (evento.contacto_contacto_id = contacto.contacto_id)
			INNER JOIN centro on (centro.centro_id = evento.centro_centro_id AND centro.centro_id = $idcentro)";
    }
    else if  ($iduser != null) {

        $query = "SELECT evento.descripcion as title, concat(users.user_first_name,' ',users.user_last_name) as description, evento.evento_id as id, evento.HoraInicio as start, evento.HoraTermino as end, evento.color as color, centro.centro_id as idcentro, users.user_id as userid, centro.direccion as direccion, centro.nombre as centro, evento.orden_compra as ordencompra, evento.visitas_agendadas as visitasagendadas, evento.descripcion as descripcionproyecto, evento.descripcion as descripcionproyecto, contacto.nombre as contacto
			FROM evento
			INNER JOIN users on (users.user_id = evento.users_user_id AND users.user_id = $iduser)
			INNER JOIN contacto on (evento.contacto_contacto_id = contacto.contacto_id)
			INNER JOIN centro on (centro.centro_id = evento.centro_centro_id)";
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