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
                    return "El Contacto \"" + item.Nombre + "\" será eliminado. ¿Está seguro de esta acción?";
                },
                onItemDeleted: function(args) {
                    deleteContacto(args.item);
                },
                onItemUpdated: function(args) {
                    updateContacto(args.item);
                },
                controller:  {
                    loadData: function() {
                        var d = $.Deferred();

                        $.ajax({
                            url: "query/get_contactos.php",
                            dataType: "json",
                            data: {
                                "ajax":true
                            }
                        }).done(function(response) {
                                
                                d.resolve(response);
                        });

                        return d.promise();
                    }
                },
                fields: [
                    { name: "id", type: "number"},
                    { name: "Empresa", type: "select", items: empresas, valueField: "id", textField: "Nombre" },
                    { name: "Nombre", type: "text", align: "center", width: "auto" },
                    { name: "Email", type: "text", align: "center", width: "auto" },
                    { name: "Direccion", type: "text", align: "center", width: "auto" },
                    { name: "Telefono", type: "text", align: "center", width: "auto" },
                    { name: "Cargo", type: "text", align: "center", width: "auto" },
                    { name: "Departamento", type: "text", align: "center", width: "auto" },
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

            var deleteContacto = function(item) {
                //console.log(item);
                $.ajax({
                    url: 'query/delete_contacto.php',
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

            var updateContacto = function(client) {
                //console.log(item);
                $.ajax({
                    url: 'query/update_contacto.php',
                    async: true,
                    data: {"id":client.id, "nombre": client.Nombre, "empresa": client.Empresa, "direccion": client.Direccion, "telefono": client.Telefono, "email": client.Email, "cargo": client.Cargo, "departamento": client.Departamento},
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
                $("#contacto_modal_accion").html("Añadir Contacto");
                
                Materialize.updateTextFields();
                $("#detailsDialog").openModal();

                $("#saveContacto").on('click', function(){
                    saveClient(client);
                });
            };
         
            var saveClient = function(client) {
                $.extend(client, {
                    Nombre: $("#contacto_nombre").val(),
                    Email: $("#contacto_email").val(),
                    Direccion: $("#contacto_direccion").val(),
                    Telefono: $("#contacto_telefono").val(),
                    Cargo: $("#contacto_cargo").val(),
                    Departamento: $("#contacto_departamento").val(),
                    Empresa: $("#contacto_empresa").val()
                });

                $.ajax({
                    url: 'query/insert_contacto.php',
                    async: true,
                    data: {"nombre": client.Nombre, "empresa": client.Empresa, "email": client.Email, "direccion": client.Direccion, "telefono": client.Telefono, "cargo": client.Cargo, "departamento": client.Departamento},
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