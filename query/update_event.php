<?php

/*
 * script que hara update a un evento via ajax
 */

$idEvento = $_POST['idEvento'];
$start = $_POST['start'];
$end = $_POST['end'];

include_once dirname(__FILE__) . '/conexion.php'; // archivo de conexion local

function updateEvento($idEvento, $start, $end) {
	global $con;

    $start = explode('T', $start);
    $start = $start[0] . ' ' . $start[1];
    $end = explode('T', $end);
    $end = $end[0] . ' ' . $end[1];


    $query = "UPDATE evento SET HoraInicio='$start', HoraTermino='$end', Lastmodified=NOW() WHERE evento_id=$idEvento";
  
    if ($result = $con->query($query)) {
        return 1;  
     } 
     else {
        return $query;
    }

}

echo updateEvento($idEvento, $start, $end);
?>
