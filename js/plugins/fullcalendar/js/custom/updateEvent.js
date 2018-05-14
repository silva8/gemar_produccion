/*
 *
 * @param {obj} event
 * @param {type} element
 * @returns {update del event en la bbdd}
 */
var updateEvent = function(event, element) {
    idEvento = event.id;
    $('#calendar').fullCalendar('updateEvent', event);

    end = event.end.format();
    start = event.start.format();
    //alert(idEvento);

    //verifyEvent(event);

    $.ajax({
        url: 'query/update_event.php',
        async: true,
        data: {"idEvento": idEvento, "start": start, "end": end},
        method: 'POST',
        beforeSend: function() {
            $('.calendar-loading-gif').slideDown();
        },
        success: function(output) {
            if (output === '1') {
                //console.log(output);
                $('.calendar-loading-gif').slideUp();
            }
        }//success
    });//ajax
};//ready