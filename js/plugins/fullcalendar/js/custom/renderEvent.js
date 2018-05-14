/*
 * @param obj event
 * @param obj element
 * @return {setea el popover para eventos}
 **/
var renderEvent = function (event, element) {
	    //console.log(element);
    if (event.start.hasTime()) {//si el evento tiene hora asignada
        //se agrega la descripcion al evento
        element.find('.fc-title').append("<br/>" + event.description);
        element.attr("userid", event.userid);

        var content = "<span><p><span class='yellow-text'>Proyecto:</span> "+ event.title +"</p><span>"+
                      "<p><span class='yellow-text'>Inspector:</span> "+ event.description +"</p><span>"+
                      "<p><span class='yellow-text'>Orden:</span> "+ event.ordencompra +"</p><span>"+
                      "<p><span class='yellow-text'>Componente:</span> "+ event.componente +"</p><span>"+
                      "<p><span class='yellow-text'>Comprador:</span> "+ event.comprador +"</p><span>"+
                      "<p><span class='yellow-text'>Proveedor:</span> "+ event.proveedor +"</p><span>"+
                      "<p><span class='yellow-text'>Inicio:</span> "+ event.start.format("YYYY-MM-DD, HH:mm") +"</p><span>"+
                      "<p><span class='yellow-text'>Termino:</span> "+ event.end.format("YYYY-MM-DD, HH:mm") +"</p><span>"+
                      "<p><span class='yellow-text'>Centro:</span> "+ event.centro +"</p><span>"+
                      "<p><span class='yellow-text'>Direccion:</span> "+ event.direccion +"</p><span>"+
                      "<p><span class='yellow-text'>Visitas:</span> "+ event.visitasagendadas +"</p><span>"+
                      "<p><span class='yellow-text'>Descripción:</span> "+ event.descripcionproyecto +"</p><span>"+
                      "<p><span class='yellow-text'>Contacto:</span> "+ event.contacto +"</p><span>";
                    
                     
        element.on('click', function(){
            Materialize.toast(content, 5000);
        });

    } else {
       // if (!event.feriado) {
        return false;// si el evento no tiene hora que no se incluya en el calendar
        //}
    }
};