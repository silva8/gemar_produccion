<?php

/*
 * @param {string/array} : $idEvento -> {userid, start, end}
 * @param {bool} : $param
 * @return {bit}  Funcion recibe el id de un evento para eliminarlo de la base de datos, retorna
 * 1 si success o 0 si fail
 */
require_once dirname(__FILE__) . '/conexion.php';

function deleteEvento($idEvento) {
	global $con;
    $query = "DELETE FROM evento WHERE evento_id = $idEvento";

    if ($result = $con->query($query)) {
    	return 1; 
     } 
    else {
        return $query;
    }
}

echo deleteEvento($_REQUEST['idEvento']);

?>