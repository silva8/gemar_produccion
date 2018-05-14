<?php

$admin = $_REQUEST['admin'];
$userid = $_REQUEST['userid'];
$month = $_REQUEST['month'];
$year = $_REQUEST['year'];

include_once dirname(__FILE__) . '/../query/get_eventos.php';
include_once dirname(__FILE__) . '/../query/get_enviado.php';
include_once dirname(__FILE__) . '/../query/get_files.php';

  if($admin){
    //Admin ve todos los eventos
    $eventos = get_eventos(null, $month, $year);
    foreach($eventos as $evento){
	  
      $enviado = get_enviado($evento->reporte_id);
      $files_attached = (!empty(getFiles($evento->reporte_id))) ? "<span class='viewfiles' reportid='".$evento->reporte_id."'><i class='right mdi-editor-attach-file' style='color:grey'></i></span>" : "";
      if($evento->criticidad == 1){
        //Evento Critico
        echo '<li>
            <div class="collapsible-header red white-text"><input type="checkbox" class="filled-in enviado" id="'.$evento->reporte_id.'" '.$enviado.'/><label for="'.$evento->reporte_id.'">'.$evento->nombre_proyecto.' ('.$evento->orden_compra.') - '. $evento->user_first_name .' '. $evento->user_last_name . '</label>'.$files_attached.'</div>
            <div class="collapsible-body red lighten-5">';
      }
      else{
        //Evento No Critico
        echo '<li>
            <div class="collapsible-header"><input type="checkbox" class="filled-in enviado" id="'.$evento->reporte_id.'" '.$enviado.' /><label for="'.$evento->reporte_id.'">'.$evento->nombre_proyecto.' ('.$evento->orden_compra.') - '. $evento->user_first_name .' '. $evento->user_last_name .'</label>'.$files_attached.'</div>
            <div class="collapsible-body">';
      }

      //Cuerpo del Evento
      echo '<div class="row">
            <br>
            <div class="col s10 offset-s1 ">

            <table class="bordered responsive-table centered">
            <thead>
              <tr>
                <th data-field="version">Versión</th>
                <th data-field="centro">Centro</th>
                <th data-field="inicio">Inicio</th>
                <th data-field="termino">Término</th>
                <th data-field="descripcion">Descripción</th>
                <th data-field="visitas">Visitas Agendadas</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>'.$evento->version.'</td>
                <td>'.$evento->nombre.'</td>
                <td>'.date("d/m/Y", strtotime($evento->HoraInicio)).'</td>
                <td>'.date("d/m/Y", strtotime($evento->HoraTermino)).'</td>
                <td>'.$evento->descripcion.'</td>
                <td>'.$evento->visitas_agendadas.'</td>
              </tr>
            </tbody>
          </table>

        </div>
      </div>';

      //si es que tiene un reporte asociado
//              if($evento->reporte_id != null){
        echo '<br><br>
              <div class="row">
                <div class="col s4">
                  <a class="col s10 offset-s1 waves-effect waves-light btn editreport" rehacer="1" reportid="'.$evento->reporte_id.'" eventoid="'. $evento->evento_id .'"><i class="mdi-editor-mode-edit"></i>Ver/Editar Reporte</a>
                </div>
                <div class="col s4">
                  <a class="col s10 offset-s1 waves-effect waves-light btn generatepdf" reportid="'.$evento->reporte_id.'" eventoid="'. $evento->evento_id .'"><i class="mdi-editor-attach-file"></i>Generar PDF</a>
                </div>
                <div class="col s4">
                  <a class="col s10 offset-s1 waves-effect waves-light btn doreportagain" reportid="'.$evento->reporte_id.'" eventoid="'. $evento->evento_id .'"><i class="mdi-av-replay"></i>Enviar a Rehacer</a>
                </div>
              </div>';
//             }

      //end of evento
      echo '<br>
            </div>
            </li>';
    }
  }
  else{
    //Ingreso desde usuario básico, solo ve sus eventos
    $eventos = get_eventos($userid, $month, $year);
    foreach($eventos as $evento){

      if($evento->status == 1)
      {
      	$status = "Rehacer reporte";
      }
      else {
      	$status = "Reporte Inicial";
      }
	 
      if($evento->criticidad == 1){
        //Evento Critico
        echo '<li>
            <div class="collapsible-header red white-text"><i class="mdi-device-access-alarms"></i>'.$evento->nombre_proyecto.' ('.$evento->orden_compra.')</div>
            <div class="collapsible-body red lighten-5">';
      }
      elseif($evento->status == 1){
      	echo '<li>
            <div class="collapsible-header yellow lighten-1 white-text"><i class="mdi-av-replay"></i>'.$evento->nombre_proyecto.' ('.$evento->orden_compra.')</div>
            <div class="collapsible-body yellow lighten-4">';
      }
      else{
        //Evento No Critico
        echo '<li>
            <div class="collapsible-header"><i class="mdi-social-notifications-off"></i>'.$evento->nombre_proyecto.' ('.$evento->orden_compra.')</div>
            <div class="collapsible-body">';
      }

      //Cuerpo del Evento
      echo '<div class="row">
            <br>
            <div class="col s10 offset-s1 ">

            <table class="bordered responsive-table centered">
            <thead>
              <tr>
                <th data-field="estado">Estado</th>
                <th data-field="centro">Centro</th>
                <th data-field="inicio">Inicio</th>
                <th data-field="termino">Término</th>
                <th data-field="descripcion">Descripción</th>
                <th data-field="visitas">Visitas Agendadas</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>'.$status.'</td>
                <td>'.$evento->nombre.'</td>
                <td>'.date("d/m/Y", strtotime($evento->HoraInicio)).'</td>
                <td>'.date("d/m/Y", strtotime($evento->HoraTermino)).'</td>
                <td>'.$evento->descripcion.'</td>
                <td>'.$evento->visitas_agendadas.'</td>
              </tr>
            </tbody>
          </table>

        </div>
      </div>';

      //si es que tiene un reporte asociado
//              if($evento->reporte_id != null){
		if($evento->status == null){
	        echo '<br><br>
	              <div class="row">
	                <div class="col s6 offset-s3">
	                  <a class="col s10 offset-s1 waves-effect waves-light btn editreport" reportid="null" eventoid="'. $evento->evento_id .'" rehacer="0"><i class="mdi-editor-mode-edit"></i>Entregar Reporte</a>
	                </div>
	              </div>';
		}
		elseif($evento->status == 1){
	        echo '<br><br>
	              <div class="row">
	                <div class="col s6 offset-s3">
	                  <a class="col s10 offset-s1 waves-effect waves-light btn editreport" reportid="'.$evento->reporte_id.'" eventoid="'. $evento->evento_id .'" rehacer="'. $evento->status .'"><i class="mdi-editor-mode-edit"></i>Actualizar Reporte</a>
	                </div>
	              </div>';
		}
//             }

      //end of evento
      echo '<br>
            </div>
            </li>';
    }
  }
?>

<script>
  $(document).ready(function(){
	 $('.editreport').on('click', function(event){
      $('#reporte_modal_accion').attr("reporteid", $(this).attr("reportid"));
      $('#reporte_modal_accion').attr("eventoid", $(this).attr("eventoid"));
      $('#reporte_modal_accion').attr("rehacer", $(this).attr("rehacer"));
      $('#reportemodal').openModal();
      filldata($(this).attr("reportid"));
      //$( this ).off( event );
    });

	 $('.viewfiles').on('click', function(e){
      e.stopPropagation();
      $('#files_modal_accion').attr("reporteid", $(this).attr("reportid"));
      $('#filesmodal').openModal();
      fillfiles($(this).attr("reportid"));
    });

	//fill data if report is going to be updated
	function filldata(idreporte){
			if($('#reporte_modal_accion').attr("rehacer") == "1"){
				$.ajax({
					url: "query/get_reporte.php", 
					type: "POST",            
					data: {"idreporte": idreporte},
					success: function(response)   
					{
						response = JSON.parse(response);
						
						$("#reporte_inspeccion").val(response[0]["tipo_inspeccion"]);
						$('#reporte_subcontratista').val(response[0]["subcontratista"]);
						$('#reporte_avance').val(response[0]["avance"]); 
						$('#reporte_resumen').val(response[0]["resumen"]);
						$('#reporte_fechacierre').val(response[0]["fecha_estimada_cierre"]);
						$('#reporte_comentarios').val(response[0]["comentarios"]);	
						$('#reporte_alertas').val(response[0]["alertas"]);
						$('#reporte_alcances').val(response[0]["alcances"]);
						$('#reporte_conclusiones').val(response[0]["conclusiones"]);						
						$("label[for='reporte_subcontratista']").addClass('active');
						$("label[for='reporte_avance']").addClass('active');
						$("label[for='reporte_resumen']").addClass('active');
						$("label[for='fecha_cierre active']").addClass('active');
						$("label[for='reporte_comentarios']").addClass('active');
						$("label[for='reporte_alertas']").addClass('active');
						$("label[for='reporte_alcances']").addClass('active');
						$("label[for='reporte_conclusiones']").addClass('active');
					},
					error: function(e){
						alert("error");
					}
				});
				$.ajax({
					url: "query/get_extrasjson.php", 
					type: "POST",            
					data: {"idreporte": idreporte},
					success: function(response)   
					{
						response = JSON.parse(response);
						console.log(response);
						response["equipos"].forEach(function(element){
							fillEquipos(element);
						});
						response["asistentes"].forEach(function(element){
							fillAsistente(element);
						});
						response["documentos"].forEach(function(element){
							fillDocumento(element);
						});
						response["pendientes"].forEach(function(element){
							fillPendiente(element);
						});
						var countInsp = 0;
						response["inspeccion"].forEach(function(element){
							if(countInsp == 0){
								$('#reporte_fechainspeccion').val(element.fecha);
								$("#reporte_horario").val(element.jornada);
								$("label[for='fecha_inspeccion active']").addClass('active');
								$('.insertFecha').attr("inspeccionId",element.inspeccion_id);
								$('.insertFecha').attr("updateFecha","1");
							}
							else
								fillFecha(element);
							countInsp++;
						});
						response["fotografias"].forEach(function(element){
							fillFotos(element);
						});
					}
				});
			}
	};

	function fillfiles(idreporte){
		$.ajax({
			url: "query/get_files.php", 
			type: "POST",            
			data: {"idreporte": idreporte},
			success: function(response)   
			{
				response = JSON.parse(response);
				response.forEach(function(element){
					var link = "files/"+element.filepath;
					var html =  '<li class="file-item collection-item"><div>'+element.filepath+'<a href="'+link+'" download class="secondary-content"><i class="material-icons">file_download</i></a></div></li>';
					$.when($('#filesmodal').find('.filefill').append(html));
				});
			}
		});
	}
		
    $('.generatepdf').on('click', function(event){
      var idreporte = $(this).attr("reportid");
      var idevento = $(this).attr("eventoid");
      $('#downloadreport').attr("idreporte", idreporte);
      $('#generatepdfmodal').find('.modal-content').html('<iframe src="ajax/generate_pdf.php?idreporte='+ idreporte +'" style="width: 100%; height: 100%; border: none; margin: 0; padding: 0; display: block;"></iframe>');
      $('#generatepdfmodal').openModal();
    }); 

    $('.enviado').on('click', function(event){
        var here = $(this);
        var idreporte = here.attr('id');
		if(here.prop('checked') == true){
			$.ajax({
				url: "query/insert_send.php", 
				type: "POST",            
				data: {"idreporte": idreporte,
						"iduser": 1},
				success: function(response)   
				{
					console.log("Checked on"+idreporte);
				}
			});
		}
    });
	
    $('#downloadreport').on('click', function(e){
      e.preventDefault();  //stop the browser from following
      var idreporte = $(this).attr("idreporte");
      window.location.href = 'ajax/generate_pdf.php?idreporte='+ idreporte +'&download=true';
    });

    $('.doreportagain').on('click', function(event){
      var idreporte = $(this).attr("reportid");
      var idevento = $(this).attr("eventoid");
      var li = $(this).parent().parent().parent().parent();
      var quereporte = li.find('.collapsible-header').text();
      var r = confirm("Está seguro que quiere mandar a rehacer el reporte: "+ quereporte);
	  if (r == true) {
        jQuery.ajax({
	        method: "POST",
	        url: "query/rehacer_reporte.php",
	        data: {
	          'idreporte': idreporte,
	          'idevento': idevento
	        },
	        error: function(response) {
	          console.log(response);
	        },
	        success: function(response)
	        {
	          li.remove();
	          Materialize.toast("Reporte enviado a rehacer", 3000);
	        }
        });
	  }
    }); 

 // ADD EXTRA DATA
	function fillEquipos(equipo){
		var html =  '<div class="insertEquipo" updateEquipo="1" equipoId="'+equipo.equipos_id+'">' +
					'<div class="divider"></div><br><div class="row"><h4 class="col s8">Listado de Equipos</h4><a class="col s4 waves-effect waves-light btn deleteextra"><i class="mdi-action-delete right"></i>Eliminar</a></div>' +
					'<div class="input-field row">' +
            			'<input class="equipo_tag upper" type="text" maxlength="45" value="'+equipo.tag+'">' +
            			'<label class="active">Tag</label>' +
       				'</div>' +
       				'<div class="input-field row">' +
            			'<input class="equipo_descripcion upper" type="text" maxlength="45" value="'+equipo.descripcion+'">' +
            			'<label class="active">Descripción</label>' +
       				'</div>' +
       				'<div class="input-field row">' +
            			'<input class="equipo_proveedor upper" type="text" maxlength="45" value="'+equipo.proveedor+'">' +
            			'<label class="active">Proveedor</label>' +
       				'</div>' +
       				'<div class="input-field row">' +
			            '<textarea class="materialize-textarea equipo_comentario upper" maxlength="100">'+equipo.comentario+'</textarea>' +
			            '<label class="active">Comentarios</label>'+
			        '</div>' +
			        '</div>';

		
		$.when($('#reportemodal').find('.modal-content').append(html)).then(function( value ) {
    		$('#reportemodal').find('.modal-content').animate({scrollTop: $('#reportemodal').find('.modal-content').prop("scrollHeight")}, 'slow');
    	});


	}
	function fillAsistente(asistente){

		var html = 	'<div class="insertAsistente" updateAsistente="1" asistenteId="'+asistente.asistentes_id+'">' +
					'<div class="divider"></div><br><div class="row"><h4 class="col s8">Asistentes</h4><a class="col s4 waves-effect waves-light btn deleteextra"><i class="mdi-action-delete right"></i>Eliminar</a></div>' +
					'<div class="input-field row">' +
            			'<input class="asistente_nombre upper" type="text" maxlength="45" value="'+asistente.nombre+'">' +
            			'<label class="active">Nombre</label>' +
       				'</div>' +
       				'<div class="input-field row">' +
            			'<input class="asistente_company upper" type="text" maxlength="45" value="'+asistente.compa+'">' +
            			'<label class="active">Compañía</label>' +
       				'</div>' +
       				'<div class="input-field row">' +
            			'<input class="asistente_cargo upper" type="text" maxlength="45" value="'+asistente.cargo+'">' +
            			'<label class="active">Cargo</label>' +
       				'</div>' + 
       				'</div>';

		
		$.when($('#reportemodal').find('.modal-content').append(html)).then(function( value ) {
    		$('#reportemodal').find('.modal-content').animate({scrollTop: $('#reportemodal').find('.modal-content').prop("scrollHeight")}, 'slow');
    	});

	}
	function fillDocumento(documento){

		var html = 	'<div class="insertDocumento" updateDocumento="1" documentoId="'+documento.documentos_id+'">' +
					'<div class="divider"></div><br><div class="row"><h4 class="col s8">Documentos Utilizados</h4><a class="col s4 waves-effect waves-light btn deleteextra"><i class="mdi-action-delete right"></i>Eliminar</a></div>' +
					'<div class="input-field row">' +
            			'<input class="documento_numero upper" type="text" maxlength="45" value="'+documento.numero+'">' +
            			'<label class="active">N° del documento</label>' +
       				'</div>' +
       				'<div class="input-field row">' +
            			'<input class="documento_revision upper" type="text" maxlength="10" value="'+documento.revision+'">' +
            			'<label class="active">Revisión</label>' +
       				'</div>' +
					'<div class="input-field row">' +
            			'<input class="documento_nombre upper" type="text" maxlength="45" value="'+documento.nombre+'">' +
            			'<label class="active">Nombre</label>' +
       				'</div>' +
       				'<div class="input-field row">' +
            			'<input class="documento_status upper" type="text" maxlength="45" value="'+documento.status+'">' +
            			'<label class="active">Status de aprobación</label>' +
       				'</div>' +
       				'</div>';

		
		$.when($('#reportemodal').find('.modal-content').append(html)).then(function( value ) {
    		$('#reportemodal').find('.modal-content').animate({scrollTop: $('#reportemodal').find('.modal-content').prop("scrollHeight")}, 'slow');
    	});

	}
	function fillPendiente(pendiente){

		var html = 	'<div class="insertPendiente" updatePendiente="1" pendienteId="'+pendiente.pendientes_id+'">' +
					'<div class="divider"></div><br><div class="row"><h4 class="col s8">Listado de Pendientes</h4><a class="col s4 waves-effect waves-light btn deleteextra"><i class="mdi-action-delete right"></i>Eliminar</a></div>' +
					'<div class="input-field row">' +
            			'<input class="pendiente_numero upper" type="text" maxlength="45" value="'+pendiente.numero+'">' +
            			'<label class="active">N° de documento</label>' +
       				'</div>' +
       				'<div class="input-field row">' +
            			'<input class="pendiente_descripcion upper" type="text" maxlength="150" value="'+pendiente.descripcion+'">' +
            			'<label class="active">Descripción</label>' +
       				'</div>' +
       				'<div class="input-field row">' +
            			'<input class="pendiente_pendiente upper" type="text" maxlength="45" value="'+pendiente.pendientes+'">' +
            			'<label class="active">Pendientes-NCR-Deficiencias</label>' +
       				'</div>'+
       				'<div class="input-field row">' +
            			'<input class="pendiente_comentarios upper" type="text" maxlength="100" value="'+pendiente.comentarios+'">' +
            			'<label class="active">Comentarios</label>' +
       				'</div>' +
       				'</div>';

		
		$.when($('#reportemodal').find('.modal-content').append(html)).then(function( value ) {
    		$('#reportemodal').find('.modal-content').animate({scrollTop: $('#reportemodal').find('.modal-content').prop("scrollHeight")}, 'slow');
    	});

	}
	function fillFecha(inspeccion){

		var op1 = '<option value="1">Jornada Completa</option>';
		var op2 = '<option value="0.5">Media Jornada</option>';
		var op3 = '<option value="0">Residente</option>';
		
		if(inspeccion.jornada == 1){
			op1 = '<option value="1" selected>Jornada Completa</option>';
		}
		else if(inspeccion.jornada == 0.5){
			op2 = '<option value="0.5" selected>Media Jornada</option>';
		}
		else{
			op3 = '<option value="0" selected>Residente</option>';
		}

		var html = 	'<div class="insertFecha fechaExtra" updateFecha="1" inspeccionId="'+inspeccion.inspeccion_id+'">' +
					'<div class="divider"></div><br><div class="row"><h4 class="col s8">Fecha de inspección</h4><a class="col s4 waves-effect waves-light btn deleteextra"><i class="mdi-action-delete right"></i>Eliminar</a></div>' +
					'<div class="input-field row">'+
            			'<input type="text" class="datepicker active" id="reporte_fechainspeccion" value="'+inspeccion.fecha+'">'+
            			'<label class="active" for="fecha_inspeccion active">Fecha de inspección</label>'+
        			'</div>'+
        			'<div class="input-field row">' +
        			'<label class="active">Horario Trabajado</label>' +
                    '<select class="browser-default inspeccion_jornada active">' +
                        '<option value="" disabled>Elegir horario</option>' +
                       	op1 + op2 + op3 +
                    '</select>' +
   					'</div>'+
       				'</div>';

		
		$.when($('#reportemodal').find('.modal-content').append(html)).then(function( value ) {
    		$('#reportemodal').find('.modal-content').animate({scrollTop: $('#reportemodal').find('.modal-content').prop("scrollHeight")}, 'slow');
    	});
    	
		$('.datepicker').pickadate({
	        selectMonths: true, // Creates a dropdown to control month
	        selectYears: 4, // Creates a dropdown of 15 years to control year,
	        today: 'Today',
	        clear: 'Clear',
	        close: 'Ok',
	        closeOnSelect: true, // Close upon selecting a date,
	        autoclose: true
	    });

	}
	function fillFotos(foto){
		var path =  "/images/reportes/";
		console.log(path);
		var html = 	'<div class="insertFotos" updateFoto="1" fotoId="' + foto.fotografias_id + '" rehacer="1">' +
					'<div class="divider"></div><br><div class="row"><h4 class="col s8">Registro Fotográfico</h4><a class="col s4 waves-effect waves-light btn deleteextra"><i class="mdi-action-delete right"></i>Eliminar</a></div>' +
					'<form action="" method="post" enctype="multipart/form-data" class="imagesubmitform center">'+
        			'<div class="progress loadingbarform" style="display:none">' +
      				'<div class="indeterminate"></div>' +
  					'</div>' +
		    		'<input type="file" name="pictures" accept="image/*" id="file" class="dropify" data-default-file="'+path+foto.imagen_path+'"/>' +
		    		'<button class="center btn waves-effect waves-light submitpicture" type="submit" name="action" style="display:none">' +
		    		'Guardar' +
    				'<i class="mdi-file-cloud-upload right"></i>' +
  					'</button>' +
					'</form>' +
					'<div class="input-field row">' +
            			'<input class="fotografias_elemento upper" type="text" maxlength="45" value="'+foto.elemento+'">' +
            			'<label class="active">Elemento</label>' +
       				'</div>' +
       				'<div class="input-field row">' +
            			'<input class="fotografias_observaciones upper" type="text" maxlength="100" value="'+foto.observaciones+'">' +
            			'<label class="active">Observaciones</label>' +
       				'</div>' +
       				'</div>';

		
		$.when($('#reportemodal').find('.modal-content').append(html)).then(function( value ) {
			$('.dropify').dropify();
    		$('#reportemodal').find('.modal-content').animate({scrollTop: $('#reportemodal').find('.modal-content').prop("scrollHeight")}, 'slow');
    		//refreshfunctions();
    	});

	}

  });
</script>