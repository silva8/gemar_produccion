$(function() {
    
    jsGrid.locale("es");
	// OData Service
    $("#jsGrid-logs").jsGrid({
        height: "auto",
        width: "150%",
        sorting: true,
        paging: true,
        autoload: true,
        editing: true,
        pageSize: 20,
        pageButtonCount: 5,
        filtering: false,
        onItemUpdated: function(args) {
            updateLogs(args.item);
        },
        controller:  {
            loadData: function() {
            	var this_js_script = $('script[src*=jsgrid-script-logs]'); // or better regexp to get the file name..

            	var empresaid = this_js_script.attr('empresaid');
            	
                var d = $.Deferred();

                $.ajax({
                    url: "query/get_logs.php",
                    dataType: "json",
                    data: {"json": 1,
                    		"id": empresaid
                    }
                }).done(function(response) {
                        //console.log(response);
                        d.resolve(response);
                });

                return d.promise();
            }
        },
        fields: [
            { name: "id",type: "number"},
            { name: "n", title: "Nº", type: "text", align: "center", width: "auto" },
            { name: "activador", title: "Activador", type: "text", align: "center", width: "auto" },
            { name: "informe", title: "Informe", type: "text", align: "center", width: "auto" },
            { name: "inspector", title: "Inspector Gemar", type: "text", align: "center", width: "auto" },
            { name: "comprador", title: "Activador/ Comprador", type: "text", align: "center", width: "auto" },
            { name: "proyecto", title: "Proyecto", type: "text", align: "center", width: "auto" },
            { name: "po", title: "PO", type: "text", align: "center", width: "auto" },
            { name: "descripcion", title: "Descripcion", type: "text", align: "center", width: "auto" },
            { name: "proveedor", title: "Proveedor", type: "text", align: "center", width: "auto" },
            { name: "inicio", title: "Fecha de inicio según PO", type: "text", align: "center", width: "auto" },
            { name: "termino", title: "Fecha término orden de compra", type: "text", align: "center", width: "auto" },
            { name: "dias", title: "Dias en fabricación", type: "text", align: "center", width: "auto" },
            { name: "nivel", title: "Nivel verificación de calidad", type: "text", align: "center", width: "auto" },
            { name: "avance", title: "Avance", type: "text", align: "center", width: "auto" },
            { name: "fecha", title: "Fecha", type: "text", align: "center", width: "auto" },
            { name: "comentario", title: "Comentario", type: "text", align: "center", width: "auto" },
            {
                type: "control",
                modeSwitchButton: true,
                editButton: true,
                deleteButton: false,
                headerTemplate: function() {
                    return "Edit";
                },
                width: "auto"
            }
        ]
    });
    
    
    $("#jsGrid-logs").jsGrid("fieldOption", "id", "visible", false);

    var updateLogs = function(log) {
        //console.log(log);
        $.ajax({
            url: 'query/update_log.php',
            async: true,
            data: {"id":log.logs_id, "activador": log.activador, "informe": log.informe, "inspector": log.inspector, "comprador": log.comprador, "proyecto": log.proyecto, "po": log.po, "descripcion": log.descripcion, "proveedor": log.proveedor, "inicio": log.inicio, "termino": log.termino, "dias": log.dias, "nivel": log.nivel, "avance": log.avance, "fecha": log.fecha, "comentario": log.comentario},
            method: 'POST',
            success: function(output) {
                if (output === '1') {
                    console.log(output);
                }
            }//success
        });//ajax
    };
});