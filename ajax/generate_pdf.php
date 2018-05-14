<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
if(isset($_REQUEST["vista_previa"])){
	$vp = $_REQUEST["vista_previa"];
	$reporte = $_REQUEST["reporte"];
}
else{
	$idreporte = $_REQUEST["idreporte"];
	$vp = 0;
}
//265
use setasign\Fpdi;

// setup the autoload function
require_once dirname(__FILE__) . "/fpdi/src/autoload.php";
require_once dirname(__FILE__) . "/fpdf/fpdf.php";
require_once dirname(dirname(__FILE__)) . "/query/get_pdfdata.php";
require_once dirname(dirname(__FILE__)) . "/query/get_extras.php";
require_once dirname(__FILE__) . "/table.php";

if($vp == 0){
	$data = getPdfData($idreporte)[0]; //$data[0]->resumen
	$extras = getExtras($idreporte);
}
else{
	$rawdata = json_decode($reporte);
	$data1 = $rawdata->data;
	$data2 = getPdfData(null, $data1->evento)[0];
	$data = (object) array_merge((array) $data1, (array) $data2);
	$extras = (array) $rawdata->extras;
	//var_dump($extras);
	//die();
}
$fechaInicio = explode("-",explode(" ",$data->HoraInicio)[0]);
$fechaTermino = explode("-", explode(" ",$data->HoraTermino)[0]);
$fechaReporte = explode("-", explode(" ",$data->fecha)[0]);
//$horarioTrabajado = (($data->horario_trabajado == 1) ? "Jornada Completa" : ($data->horario_trabajado == 0.5 ? "Media jornada" : "Residente"));
$tipoVisita = ["","","",""];
$tipoVisita[$data->tipo_inspeccion-1] = "X";
$fechaEstimadaCierre = explode("-", explode(" ",$data->fecha_estimada_cierre)[0]);
$logo = dirname(dirname(__FILE__)) . "/images/login-logo.png";
$logo2 = dirname(dirname(__FILE__)) . "/images/empresas/".$data->logopath;
$firma = dirname(dirname(__FILE__)) . "/images/firma.png";
$fotos_path = dirname(dirname(__FILE__)) . "/images/reportes/";

$horarioTrabajado = "";
foreach ($extras["inspeccion"] as $inspeccion){
	$f = explode("-",explode(" ",$inspeccion->fecha)[0]);
	$jornada = (($inspeccion->jornada == 1) ? "Jornada Completa" : ($inspeccion->jornada == 0.5 ? "Media jornada" : "Residente"));
	$horarioTrabajado.= $f[2]."/".$f[1]."/".$f[0]."-".$jornada."\n";
}

$pdf = new PDF_MC_Table();
$heigth = $pdf->GetPageHeight();
$width = $pdf->GetPageWidth();
$pdf->AddFont('Arial_Narrow','','Arial_Narrow.php');
$pdf->AddFont('Arial_Narrow','B','Arial_Narrow_Bold.php');
$row = array();
//Page 1
newPage($pdf, $data, $logo, $logo2, $vp);

//Tabla inicial - cabeceras
$row[1] = array("Comprador Activador", $data->comprador, "Fecha", $fechaReporte[2]."/".$fechaReporte[1]."/".$fechaReporte[0]); //Aca va la fecha de la inspección
$row[2] = array("Cliente Final", $data->nombre, "Proveedor", $data->proveedor);
$row[3] = array("Orden de Compra", $data->orden_compra,"Proyecto", $data->nombre_proyecto, "Tipo de inspección");
$row[4] = array("Dirección", $data->direccion.", ".$data->comuna.", ".$data->ciudad, "Visita Semanal", $tipoVisita[0]);
$row[5] = array("Contacto",$data->contacto_centro,"Visita Spot",$tipoVisita[1]);
$row[6] = array("Teléfono",$data->telefono_contacto, "Cargo",$data->cargo_contacto,"Inspección Residente",$tipoVisita[2]);
$row[7] = array("Subcontratista del proveedor",$data->subcontratista,"Final y despacho",$tipoVisita[3]);
$row[8] = array("Inspector", $data->user_first_name." ".$data->user_last_name, "Resumen");
$row[9] = array("Fecha Inicio", $fechaInicio[2]."/".$fechaInicio[1]."/".$fechaInicio[0],"Fecha Término",$fechaTermino[2]."/".$fechaTermino[1]."/".$fechaTermino[0]);
$row[10] = array("Horario de Trabajo", $horarioTrabajado);
//$data->resumen
$y = $pdf->tableRow(10, 50, ($width-20), $row[1], array(0.2,0.35,0.2,0.25), array("B","","B",""), 11);
$y = $pdf->tableRow(10, $y, ($width-20), $row[2], array(0.2,0.35,0.2,0.25), array("B","","B",""), 11);
$y = $pdf->tableRow(10, $y, ($width-20), $row[3], array(0.2,0.2,0.15,0.2,0.25), array("B","","B","","B"), 11);
$y = $pdf->tableRow(10, $y, ($width-20), $row[4], array(0.2,0.55,0.2,0.05), array("B","","","B"), 11);
$y = $pdf->tableRow(10, $y, ($width-20), $row[5], array(0.2,0.55,0.2,0.05), array("B","","","B"), 11);
$y = $pdf->tableRow(10, $y, ($width-20), $row[6], array(0.2,0.2,0.15,0.2,0.2,0.05), array("B","","B","","","B"), 11);
$y = $pdf->tableRow(10, $y, ($width-20), $row[7], array(0.2,0.55,0.2,0.05), array("B","","","B"), 11);
$y = $pdf->tableRow(10, $y, ($width-20), $row[8], array(0.2,0.4,0.4), array("B","","B"), 11);
$y1 = $y;
$y = $pdf->tableRow(10, $y, ($width-20)*0.6, $row[9], array(0.335,0.1825,0.3,0.1825), array("B","","B",""), 11);
$y = $pdf->tableRow(10, $y, ($width-20)*0.6, $row[10], array(0.335,0.665), array("B",""), 11);
$h = $y - $y1;
$y = $pdf->summaryCell($y1, ($width-20), $data->resumen, $h, 0.4);
//Indice
$y+=20;
$pdf->SetFont('Arial_Narrow','B',12);
$pdf->SetXY(($width/2)-25,$y);
$y+=10;
$pdf->Cell(0,10,utf8_decode("TABLA DE CONTENIDOS"),0,0,"L");
$pdf->SetXY(20,$y);
$pdf->MultiCell(($width-40),10,utf8_decode("1.\n2.\n3.\n4.\n5.\n6.\n7.\n8."),0,"L");
$pdf->SetXY(30,$y);
$pdf->MultiCell(($width-40),10,utf8_decode("Resumen: ................................................................................................................................................\nAlertas: ....................................................................................................................................................\nAlcances de la inspección: ...................................................................................................................\nAsistentes: ..............................................................................................................................................\nDocumentos utilizados: .........................................................................................................................\nListado de pendientes, deficiencias notadas - No comformidades: .................................................\nResultados finales/Conclusiones: ........................................................................................................\nRegistro fotográfico: .............................................................................................................................."),0,"L");
$pdf->SetXY(190,$y);
$pdf->MultiCell(($width-40)/6,10,utf8_decode("2\n2\n2\n3\n3\n4\n4\n4"),0,"L");

//Pagina 2
$y = 0;
newPage($pdf, $data, $logo, $logo2, $vp);
$pdf->SetFont('Arial_Narrow','B',12);
$pdf->SetTextColor(0);
$y=50;
$pdf->SetXY(20,$y);
$pdf->MultiCell(($width-40),10,utf8_decode("1.      RESUMEN."),0,"L");
$pdf->SetFont('Arial_Narrow','',11);
$pdf->SetXY(20,60);
$pdf->MultiCell($width-40,5,utf8_decode("En este cuadro deben indicar el porcentaje de avance del proyecto de acuerdo a vuestra evaluación. Fecha de término de orden de compra estimada por ustedes y comentarios generales resumen de actividades de esta orden de compra."),0,"J");
$pdf->SetFillColor(60,135,200);
$pdf->SetTextColor(255);
$y+=30;
$dat = array("Avance Fabricación","Fecha estimada \n de cierre","Comentarios");
$y = $pdf->tableRow(20, $y, ($width-40), $dat, array(0.2,0.25,0.55), array("B","B","B"), 11);
$pdf->SetFillColor(235);
$pdf->SetTextColor(0);
$pdf->SetXY(20,90);
$dat = array($data->avance."%", $fechaEstimadaCierre[2]."/".$fechaEstimadaCierre[1]."/".$fechaEstimadaCierre[0], $data->comentarios);
$y = $pdf->tableRow(20, $y, ($width-40), $dat, array(0.2,0.25,0.55), array("","",""), 11);
$pdf->SetXY(20,$y+=11);
$pdf->SetFont('Arial_Narrow','B',12);
$pdf->MultiCell(($width-40),10,utf8_decode("2.      ALERTAS."),0,"L");
$pdf->SetXY(20,$y+=11);
$pdf->SetFont('Arial_Narrow','',11);
$y = $y+7*$pdf->NbLines($width-40,utf8_decode($data->alertas));
$pdf->MultiCell($width-40,10,utf8_decode($data->alertas),0,"J");
$pdf->SetXY(20,$y+=15);
$pdf->SetFont('Arial_Narrow','B',12);
$pdf->MultiCell(($width-40),10,utf8_decode("3.      ALCANCES."),0,"L");
$pdf->SetXY(20,$y+=11);
$pdf->SetFont('Arial_Narrow','',11);
$pdf->MultiCell($width-40,10,utf8_decode($data->alcances),0,"J");

//Pagina 3
newPage($pdf, $data, $logo, $logo2, $vp);
$pdf->SetFont('Arial_Narrow','B',12);
$pdf->SetTextColor(0);
$y=50;
$pdf->SetXY(20,$y);
$pdf->MultiCell(($width-40),5,utf8_decode("2.1.-    SUMINISTRO INTEGRACIÓN EQUIPO / AVANCE DE FABRICACIÓN: DE ACUERDO AL ITEMNIZADO DE LA,PO."),0,"L");
$pdf->SetFillColor(60,135,200);
$pdf->SetTextColor(255);
$y+=15;
$y = $pdf->tableRow(20, $y, ($width-40), array("Listado de equipos"), array(1), array("B"), 11);
$dat = array("Nº", "Tag", "Descripción", "Proveedor", "Comentarios");
$y = $pdf->tableRow(20, $y, ($width-40), $dat, array(0.1,0.15,0.25,0.2,0.3), array("B","B","B","B","B"), 11);
$count = 1;
$pdf->SetFillColor(235);
$pdf->SetTextColor(0);
foreach($extras["equipos"] as $equipo){
	if($y>$heigth-50){
		newPage($pdf, $data, $logo, $logo2, $vp);
		$pdf->SetFillColor(235);
		$pdf->SetTextColor(0);
		$y = 50;
	}
	$dat = array($count, $equipo->tag, $equipo->descripcion, $equipo->proveedor, $equipo->comentario);
	$y = $y = $pdf->tableRow(20, $y, ($width-40), $dat, array(0.1,0.15,0.25,0.2,0.3), array("","","","",""), 11);
	$count++;
}
//Asistente
if($y>$heigth-80){
	newPage($pdf, $data, $logo, $logo2, $vp);
	$y=40;
}
$pdf->SetFont('Arial_Narrow','B',12);
$pdf->SetTextColor(0);
$y+=10;
$pdf->SetXY(20,$y);
$pdf->MultiCell(($width-40),5,utf8_decode("4.      ASISTENTES."),0,"L");
$pdf->SetFillColor(60,135,200);
$pdf->SetTextColor(255);
$y+=10;
$dat = array("Nombre", "Compañía", "Cargo");
$y = $pdf->tableRow(20, $y, ($width-40), $dat, array(0.3,0.4,0.3), array("B","B","B"), 11);
$pdf->SetFillColor(235);
$pdf->SetTextColor(0);
foreach($extras["asistentes"] as $asistente){
	if($y>$heigth-50){
		newPage($pdf, $data, $logo, $logo2, $vp);
		$pdf->SetFillColor(235);
		$pdf->SetTextColor(0);
		$y = 50;
	}
	$dat = array($asistente->nombre, $asistente->compa, $asistente->cargo);
	$y = $y = $pdf->tableRow(20, $y, ($width-40), $dat, array(0.3,0.4,0.3), array("","","",""), 11);
}
//Documentos utilizados
if($y>$heigth-80){
	newPage($pdf, $data, $logo, $logo2, $vp);
	$y=40;
}
$pdf->SetFont('Arial_Narrow','B',12);
$pdf->SetTextColor(0);
$y+=10;
$pdf->SetXY(20,$y);
$pdf->MultiCell(($width-40),5,utf8_decode("5.      DOCUMENTOS UTILIZADOS."),0,"L");
$pdf->SetFillColor(60,135,200);
$pdf->SetTextColor(255);
$y+=10;
$dat = array("Nº de documento", "Revisión", "Nombre del documento", "Status de aprobación");
$y = $pdf->tableRow(20, $y, ($width-40), $dat, array(0.3,0.2,0.25,0.25), array("B","B","B","B"), 11);
$pdf->SetFillColor(235);
$pdf->SetTextColor(0);
foreach($extras["documentos"] as $documento){
	if($y>$heigth-50){
		newPage($pdf, $data, $logo, $logo2, $vp);
		$pdf->SetFillColor(235);
		$pdf->SetTextColor(0);
		$y = 50;
	}
	$dat = array($documento->numero, $documento->revision, $documento->nombre, $documento->status);
	$y = $y = $pdf->tableRow(20, $y, ($width-40), $dat, array(0.3,0.2,0.25,0.25), array("","","",""), 11);
}
//Listado de pendientes
if($y>$heigth-80){
	newPage($pdf, $data, $logo, $logo2, $vp);
	$y=40;
}
$pdf->SetFont('Arial_Narrow','B',12);
$pdf->SetTextColor(0);
$y+=10;
$pdf->SetXY(20,$y);
$pdf->MultiCell(($width-40),5,utf8_decode("6.      LISTADO DE PENDIENTES, DEFICIENCIAS NOTADAS - NO CONFORMIDADES."),0,"L");
$pdf->SetFillColor(60,135,200);
$pdf->SetTextColor(255);
$y+=10;
$dat = array("Nº", "Nº documento", "Descripción", "Pendientes NCR-Deficiencias", "Comentarios/status/fechas");
$y = $pdf->tableRow(20, $y, ($width-40), $dat, array(0.1,0.2,0.2,0.2,0.3), array("B","B","B","B", "B"), 11);
$pdf->SetFillColor(235);
$pdf->SetTextColor(0);
$count = 1;
foreach($extras["pendientes"] as $pendiente){
	if($y>$heigth-50){
		newPage($pdf, $data, $logo, $logo2, $vp);
		$pdf->SetFillColor(235);
		$pdf->SetTextColor(0);
		$y = 50;
	}
	$dat = array($count, $pendiente->numero,$pendiente->descripcion,$pendiente->pendientes,$pendiente->comentarios);
	$y = $y = $pdf->tableRow(20, $y, ($width-40), $dat, array(0.1,0.2,0.2,0.2,0.3), array("","","","", ""), 11);
	$count++;
}
$y+=10;
//Resultados finales y conclusiones
if($y>$heigth-70){
	newPage($pdf, $data, $logo, $logo2, $vp);
	$y=50;
}
$pdf->SetFont('Arial_Narrow','B',12);
$pdf->SetTextColor(0);
$y+=10;
$pdf->SetXY(20,$y);
$pdf->MultiCell(($width-40),5,utf8_decode("7.      RESULTADOS FINALES Y CONCLUSIONES."),0,"L");
$y+=10;
$pdf->SetFont('Arial_Narrow','',11);
$pdf->SetXY(20,$y);
$pdf->MultiCell($width-40,10,utf8_decode($data->conclusiones),0,"J");
//Calculating photos space
$photo_row_heigth = array(array("elemento"=>0,"observaciones"=>0,"total"=>0));
$row_num = 1;
$count=1;
foreach($extras["fotografias"] as $foto){
	//if the picture is higher than page
	$h1 = $pdf->NbLines(((20+($width-40)/2)-25)*0.65,utf8_decode($foto->elemento));
	$h2 = $pdf->NbLines(((20+($width-40)/2)-25)*0.65,utf8_decode($foto->observaciones));
	
	if(5*$h1 > $photo_row_heigth[$row_num-1]["elemento"]){
		$photo_row_heigth[$row_num-1]["elemento"] = 5*$h1;
	}
	
	if(5*$h2 > $photo_row_heigth[$row_num-1]["observaciones"]){
		$photo_row_heigth[$row_num-1]["observaciones"] = 5*$h2;
	}
	$total = 70+($photo_row_heigth[$row_num-1]["elemento"] + $photo_row_heigth[$row_num-1]["observaciones"]);
	
	if($total > $photo_row_heigth[$row_num-1]["total"]){
		$photo_row_heigth[$row_num-1]["total"] = $total;
	}
	$count++;
	
	if($count == 3){
		$count = 1;
		$row_num++;
		$photo_row_heigth[] = array("elemento"=>0,"observaciones"=>0,"total"=>0);
	}
	
}
//var_dump($photo_row_heigth);
//Registro fotografico
$y+=20;
if($y>$heigth-$photo_row_heigth[0]["total"]-40){
	newPage($pdf, $data, $logo, $logo2, $vp);
	$y=50;
}
$pdf->SetFont('Arial_Narrow','B',12);
$pdf->SetTextColor(0);
$pdf->SetXY(20,$y);
$pdf->MultiCell(($width-40),5,utf8_decode("8.      REGISTRO FOTOGRÁFICO."),0,"L");
$y+=15;
$n_fotos = count($extras["fotografias"]);

$count=1;
$row_num = 1;
foreach($extras["fotografias"] as $foto){
	list($foto_width, $foto_height) = getimagesize($fotos_path.$foto->imagen_path);
	$w = ($width-80)/2;
	$h=round(($foto_height*$w)/$foto_width);
	if($h > 60){
		$w = $w*60/$h;
		$h = 60;	
	}
	$margin_up = (70 - $h)/2;
	$margin_left = (((20+($width-40)/2)-25)-$w)/2;
	
	$maxImageHeigth = $heigth - $photo_row_heigth[$row_num-1]["total"] - 30;
	if($y>$maxImageHeigth){
		newPage($pdf, $data, $logo, $logo2, $vp);
		$y = 50;
	}
	$pdf->SetFont('Arial_Narrow','',11);
	$pdf->SetTextColor(0);
	$pdf->SetXY(20,$y);
	$align = ($count%2 == 0) ? 1 : 0;
	$pdf->Rect(20+$align*((20+($width-40)/2)-15),$y,(20+($width-40)/2)-25, 70);
	$pdf->Image($fotos_path.$foto->imagen_path, ($margin_left+20+$align*((20+($width-40)/2)-15)),$margin_up+$y, $w, $h);
	$y+=70;
	$dat = array("Elemento", $foto->elemento);
	$y_nb = $pdf->cellWithDefinedHeight(20+$align*((20+($width-40)/2)-15), $y, $photo_row_heigth[$row_num-1]["elemento"], ((20+($width-40)/2)-25), array(0.35,0.65), $dat) - $y;
	//$y_nb = $pdf->tableRow(20+$align*((20+($width-40)/2)-15), $y, ((20+($width-40)/2)-25), $dat, array(0.35,0.65), array("",""), 11)-$y;
	$nb = $y_nb/5;
	$y=$y+$y_nb;
	$dat = array("Observaciones", $foto->observaciones);
	$pdf->cellWithDefinedHeight(20+$align*((20+($width-40)/2)-15), $y, $photo_row_heigth[$row_num-1]["observaciones"], ((20+($width-40)/2)-25), array(0.35,0.65), $dat);
	//$pdf->tableRow(20+$align*((20+($width-40)/2)-15), $y, ((20+($width-40)/2)-25), $dat, array(0.35,0.65), array("",""), 11);
	$y=$y-70-$y_nb;
	if($align == 1 && $count!= $n_fotos){
		$y=$y+$photo_row_heigth[$row_num-1]["total"]+10;
		$row_num++;
	}
	$count++;
}
//firma
if($y>$heigth-80){
	newPage($pdf, $data, $logo, $logo2, $vp);
	$y=55;
}
else{
	$y=$heigth-80;
}
//$pdf->Image($firma, 20, $y, 80);
$y+=35;
//$pdf->Text(($width/2)-20, $y, "FIN DEL DOCUMENTO");
$pdf->Output();

function newPage($pdf, $data, $logo, $logo2, $vp){
	$heigth = $pdf->GetPageHeight();
	$width = $pdf->GetPageWidth();
	$pdf->AddPage();
	$pdf->Rect(4,4,$width-8,$heigth-8);
	$pdf->Rect(4.7,4.7,$width-9.4,$heigth-9.4);
	$x = 10;
	//Header
	$pdf->SetFont('Arial_Narrow','B',11);
	$pdf->SetFillColor(204,204,255);
	$pdf->SetXY($x,10);
	if($vp == 0){
		$header = "Reporte de inspección RI-".sprintf('%02d', $data->numero_reporte)."\n"."Orden de compra ".$data->orden_compra." ".$data->componente." - ".$data->proveedor;
	}
	else{
		$header = "Reporte de inspección RI-00\n"."Orden de compra ".$data->orden_compra." ".$data->componente." - ".$data->proveedor;
	}
	list($foto_width, $foto_height) = getimagesize($logo2);
	if($foto_width>$foto_height){
		$w = 35;
		$h = round(($foto_height*$w)/$foto_width);
		$w2 = 37;
		$up_margin = (30-$h)/2-2;
	}
	else{
		$h = 26;
		$w=round(($foto_width*$h)/$foto_height);
		$w2 = round(($foto_width*30)/$foto_height);
		$up_margin = 0;
	}
	$pdf->Rect(38, 10, $width-12-$w-38-2, 30, "DF");
	$pdf->SetXY(40,18);
	$pdf->MultiCell($width-$w-58,5,utf8_decode($header),0,"C");
	$pdf->SetFillColor(255,255,255);
	$pdf->Rect($x,10, 30, 30, "DF");
	$pdf->Image($logo, 12, 12, 26);
	$pdf->Rect($width-12-$w2,10, $w2+2, 30, "DF");
	$pdf->Image($logo2, $width-12-$w, 12+$up_margin, $w, $h);
	$pdf->Rect($x-0.7,9.3, $width-18.7, 31.3);
	//Footer
	$pdf->SetFont('Arial_Narrow','',8);
	$pdf->Image($logo, 9, $heigth-30, 12);
	$pdf->SetXY($x+5,$heigth-30);
	$pdf->MultiCell(0,3,utf8_decode("La emisión del Reporte de inspección, no libera al Proveedor de sus responsabilidades y obligaciones bajo contrato o la ley, con respecto a los materiales \ny equipo descritos en este reporte de inspección. Esto no implica la aceptación de estos materiales y equipos por el comprador o Dueño."),0,"C");
	$pdf->SetFont('Arial_Narrow','B',8);
	$pdf->SetTextColor(0,0,110);
	$pdf->SetXY($x+5,$heigth-23);
	$pdf->MultiCell(0,2,utf8_decode("GEMAR Ingeniería y asesorías técnicas. Vespucio Sur 1117 Las Condes Celular: +56 989210647 www.gemaringenieria.cl"),0,"C");
	$pdf->SetTextColor(0);
}


