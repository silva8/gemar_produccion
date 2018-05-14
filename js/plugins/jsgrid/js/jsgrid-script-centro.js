$(function() {
    
    jsGrid.locale("es");

    $.ajax({
        type: "GET",
        url: "query/get_empresas.php"
        }).done(function(empresas) {
            empresas = $.parseJSON(empresas);
            

            
            // OData Service
            $("#jsGrid-custom").jsGrid({
                height: "auto",
                width: "100%",
                sorting: true,
                paging: true,
                autoload: true,
                editing: true,
                pageSize: 20,
                pageButtonCount: 5,
                filtering: false,    
                deleteConfirm: function(item) {
                    return "El Centro \"" + item.Nombre + "\" será eliminado. ¿Está seguro de esta acción?";
                },
                onItemDeleted: function(args) {
                    deleteCentro(args.item);
                },
                onItemUpdated: function(args) {
                    updateCentro(args.item);
                },
                controller:  {
                    loadData: function() {
                        var d = $.Deferred();

                        $.ajax({
                            url: "query/get_centrosjson.php",
                            dataType: "json"
                        }).done(function(response) {
                                console.log(response);
                                d.resolve(response);
                        });

                        return d.promise();
                    }
                },
                fields: [
                    { name: "id", type: "number"},
                    { name: "Empresa", type: "select", items: empresas, valueField: "id", textField: "Nombre" },
                    { name: "Nombre", type: "text", align: "center", width: "auto" },
                    { name: "Direccion", type: "text", align: "center", width: "auto" },
                    { name: "Contacto", type: "text", align: "center", width: "auto" },
                    { name: "Telefono", type: "text", align: "center", width: "auto" },
                    { name: "Email", type: "text", align: "center", width: "auto" },
                    {
                        type: "control",
                        modeSwitchButton: true,
                        editButton: true,
                        headerTemplate: function() {
                            return $("<a>").addClass("waves-effect waves-light btn green").append("<i class='mdi-content-add'></i>")   
                                    .on("click", function () {
                                        showDetailsDialog("Add", {});
                                    });
                        },
                        width: "auto"
                    }
                ]
            });
            
            
            $("#jsGrid-custom").jsGrid("fieldOption", "id", "visible", false);

            var deleteCentro = function(item) {
                //console.log(item);
                $.ajax({
                    url: 'query/delete_centro.php',
                    async: true,
                    data: {"id": item.id},
                    method: 'POST',
                    success: function(output) {
                        if (output === '1') {
                            //console.log(output);
                        }
                    }//success
                });//ajax
            };

            var updateCentro = function(client) {
                //console.log(item);
                $.ajax({
                    url: 'query/update_centro.php',
                    async: true,
                    data: {"id":client.id, "nombre": client.Nombre, "empresa": client.Empresa, "direccion": client.Direccion, "contacto": client.Contacto, "telefono": client.Telefono, "email": client.Email},
                    method: 'POST',
                    success: function(output) {
                        if (output === '1') {
                            //console.log(output);
                        }
                    }//success
                });//ajax
            };

            var showDetailsDialog = function(dialogType, client) {
                //$("#detailsForm").reset();
                $("#centro_modal_accion").html("Añadir Centro");
                
                Materialize.updateTextFields();
                $("#detailsDialog").openModal();

                $("#saveCentro").on('click', function(){
                    saveClient(client);
                });
            };
         
            var saveClient = function(client) {
                $.extend(client, {
                    Nombre: $("#centro_nombre").val(),
                    Direccion: $("#centro_direccion").val(),
                    Contacto: $("#centro_contacto").val(),
                    Telefono: $("#centro_telefono").val(),
                    Email: $("#centro_email").val(),
                    Empresa: $("#centro_empresa").val()
                });

                $.ajax({
                    url: 'query/insert_centro.php',
                    async: true,
                    data: {"nombre": client.Nombre, "empresa": client.Empresa, "direccion": client.Direccion, "contacto": client.Contacto, "telefono": client.Telefono, "email": client.Email},
                    method: 'POST',
                    success: function(output) {
                        if($.isNumeric(output)){
                            client.id = output;
                            $("#jsGrid-custom").jsGrid("insertItem", client).done(function() {
                                $("#jsGrid-custom").jsGrid("refresh");
                            });
                        }
                        else {       
                            Materialize.toast(output, 3000);
                        }
                    }//success
                });//ajax
            };
    });
});