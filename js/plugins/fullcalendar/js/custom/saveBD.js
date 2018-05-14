/*
 * @param {type} event
 * @param {type} element
 * @returns {guarda el evento en la bbdd}
 */
var saveBD = function(event) {
    start = event.start.format();
    end = event.end.format();
    userid = event.userid;
    centroid = event.centroid;
    nombreproyecto = event.nombre_proyecto;
    ordencompra = event.orden_compra;
    contactoproyecto = event.contacto_proyecto;
    descripcionproyecto = event.descripcion_proyecto;
    visitasagendadas = event.visitas_agendadas;
    criticidad = event.criticidad;
    color = event.color;
    proveedor = event.proveedor;
    comprador = event.comprador;
    componente = event.componente

    //verifyEvent(event);
    if (event.fromBD === 0) {
        if (event.saved === 0) {
            //si el evento no se encuentra guardado en la bbdd
            //armado de JSON para envio de datos
            $.ajax({
                url: 'query/insert_event.php',
                async: true,
                data: {
                    "userid": userid,
                    "centroid": centroid, 
                    "start": start, 
                    "end": end, 
                    "nombreproyecto": nombreproyecto, 
                    "ordencompra": ordencompra, 
                    "contactoproyecto": contactoproyecto,
                    "descripcionproyecto": descripcionproyecto,
                    "visitasagendadas": visitasagendadas,
                    "criticidad": criticidad,
                    "color": color,
                    "proveedor": proveedor,
                    "comprador": comprador,
                    "componente": componente
                },
                method: 'POST',
                beforeSend: function() {
                    $('.calendar-loading-gif').slideDown();
                },
                success: function(output) {
                    if (output !== '0') {
                        //console.log(output);
                        event.saved = 1; //cambia el estado del evento a "guardado (1)"
                        event.id = output; //asigna el output devuelto como el id del evento
                        view = $('#calendar').fullCalendar('getView');
                        //console.log(view.name);
                        if (view.name === 'month') {
                            $('#calendar').fullCalendar('refetchEvents');
                            $('#undoEvent').attr('idEvent', event.id);
                        } else {
                            $('#calendar').fullCalendar('updateEvent', event);
                            $('#undoEvent').attr('idEvent', event.id);
                        }

                        $('.calendar-loading-gif').slideUp();

                    }
                }//success
            });//ajax
        }//si ya se guardo previamente
    }// si el evento viene de la bbdd
};//function saveBD