var verifyEvent = function(event) {
    /*
     * @param {obj} : event
     * @return {verificacion en la base de datos (si hay algun evento a la misma hora en el mismo lugar)}
     */
    //console.log(event._id);
    $.ajax({
        url: 'Include/verificaTM.php',
        async: true,
        data: {
            "idTM": event.idTM,
            "start": event.start.format(),
            "end": event.end.format(),
            "idCentro": $('#centro').attr('idCentro')
        },
        method: 'POST',
        success: function(output) {
            if (output) {
                output = $.parseJSON(output);

                //console.log(output);
                content = '';
                $.each(output, function(i, val) {
                    content += '<div class="alert alert-danger alert-sm">' + val.Centro + '</div>';
                });
                $("#myModal .modal-body").html('<div class="well well-sm">El TM ya se encuentra asignado en: ' + content + '</div>');
                
                //console.log(content);
                $("#myModal").modal('show');
            }
        }// success
    });//ajax

    //se hacen las verificaciones del evento
    //se actualiza en la bbdd el elemento o se guarda si no existe
};