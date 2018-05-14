var eventReceive = function(event) {
    if (event.start.hasTime()) {
        //se verifica si el evento es dropped desde la vista mesual
        //no tiene hora asignada sino que es solo fecha
        saveBD(event);
    }
    else {
        //console.log(event);
        $('#fecha-inicio').val(event.start.format('DD MMM, YYYY'));
        $('#fecha-fin').val(event.start.add(1, 'days').format('DD MMM, YYYY'));
        Materialize.updateTextFields();
        $('#modalEvento').openModal();
        $('#eventDate').html('<div class="alert alert-sm alert-info">' + event.start.format() + '</div>');
        $('#inspector-modal-evento').html('<div class="alert alert-sm alert-info">' + event.description + ' <strong>(' + event.title + ')</strong></div>');
        $('#evento')
            .attr('start', event.start.format())
            .attr('end', event.end.format())
            .attr('userid', event.userid)
            .attr('centroid', event.centroid)
            .attr('color', event.color)
            .attr('title', event.title)
            .attr('description', event.description);
    }
};


