<?php
$fecha = $_REQUEST['fecha'];
$userid = $_REQUEST['userid'];
$dias = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"];

include_once dirname(__FILE__) . '/../query/get_hoja_tiempo.php';

echo '<div class="row">
		<br>
		<div class="col s10 offset-s1 ">
			<table class="bordered responsive-table centered">
				<thead>
					<tr>
						<th data-field="dia">Día</th>
	                    <th data-field="item">Item</th>
	                    <th data-field="fecha_inspeccion">Fecha inspección</th>
						<th data-field="orden_compra">Orden de compra</th>
	                    <th data-field="proyecto">Proyecto</th>
	                    <th data-field="provedor">Proveedor</th>
	                    <th data-field="documento">Documento</th>
	                    <th data-field="componente">Componente</th>
	                    <th data-field="sitio">Sitio</th>
	                    <th data-field="jornada">Jornada</th>
	                    <th data-field="inspector">Inspector</th>
					</tr>
				</thead>
				<tbody>';

$rows = get_hoja_tiempo($fecha, $userid);
$count = 1;
$lastday = 0;
foreach($rows as $row){
	$d = date("N",strtotime($row->fecha_inspeccion))-1;
	while($d-$lastday > 0){
		echo '<tr>
				<td>'.$dias[$lastday].'</td>
	            <td>'.$count++.'</td>
	            <td>-</td>
	            <td>-</td>
	            <td>-</td>
	            <td>-</td>
	            <td>-</td>
	            <td>-</td>
	            <td>-</td>
	            <td>-</td>
	            <td>-</td>
           	</tr>';
		$lastday++;
	}
	$lastday = $d+1;
	if($row->horario_trabajado == 1){
		$jornada = "1 Jornada";
	}
	else if($row->horario_trabajado == 0.5){
		$jornada = "1/2 Jornada";
	}
	else{
		$jornada = "Residente";
	}
	
	echo '<tr>
				<td>'.$dias[$d].'</td>
	            <td>'.$count.'</td>
	            <td>'.$dias[$d].", ".date("F d, Y",strtotime($row->fecha_inspeccion)).'</td>
	            <td>'.$row->orden_compra.'</td>
	            <td>'.$row->nombre_proyecto.'</td>
	            <td>'.$row->proveedor.'</td>
	            <td>'."Documento".'</td>
	            <td>'.$row->componente.'</td>
	            <td>'.$row->sitio.'</td>
	            <td>'.$jornada.'</td>
	            <td>'.$row->user_first_name." ".$row->user_last_name.'</td>
           	</tr>';
	$count++;
}
while($lastday<=6){
	echo '<tr>
				<td>'.$dias[$lastday].'</td>
	            <td>'.$count++.'</td>
	            <td>-</td>
	            <td>-</td>
	            <td>-</td>
	            <td>-</td>
	            <td>-</td>
	            <td>-</td>
	            <td>-</td>
	            <td>-</td>
	            <td>-</td>
           	</tr>';
	$lastday++;
}
	echo '			</tbody>
   				</table>
		  	</div>
          </div>';
?>

<script>
  $(document).ready(function(){
	  
  });
</script>