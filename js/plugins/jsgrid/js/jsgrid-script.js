$(function() {
            jsGrid.locale("es");
            
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
                    return "La Empresa \"" + item.Nombre + "\" será eliminada. ¿Está seguro de esta acción?";
                },
                onItemDeleted: function(args) {
                    deleteEmpresa(args.item);
                },
                onItemUpdated: function(args) {
                    updateEmpresa(args.item);
                },
                controller: {
                    loadData: function() {
                        var d = $.Deferred();

                        $.ajax({
                            url: "query/get_empresas.php",
                            dataType: "json"
                        }).done(function(response) {
                            //console.log(response);
                            d.resolve(response);
                        });

                        return d.promise();
                    }
                },
                fields: [
                    { name: "id", type: "number"},
                    { name: "Nombre", type: "text", align: "center", width: "auto" },
                    { name: "Rut", type: "text", align: "center", width: "auto" },
                    { name: "Giro", type: "text", align: "center", width: "auto" },
                    { name: "Direccion", type: "text", align: "center", width: "auto" },
                    { name: "Comuna", type: "text", align: "center", width: "auto" },
                    { name: "Ciudad", type: "text", align: "center", width: "auto" },
                    { name: "RazonSocial", type: "text", align: "center", width: "auto" },
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

            var deleteEmpresa = function(item) {
                //console.log(item);
                $.ajax({
                    url: 'query/delete_company.php',
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

            var updateEmpresa = function(item) {
                //console.log(item);
                $.ajax({
                    url: 'query/update_company.php',
                    async: true,
                    data: {"id":item.id, "nombre": item.Nombre, "rut": item.Rut, "giro": item.Giro, "direccion": item.Direccion, "comuna": item.Comuna, "ciudad": item.Ciudad, "razonsocial": item.RazonSocial, "mail": item.Email},
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
                $("#empresa_modal_accion").html("Añadir Empresa");
                
                $("#detailsForm").find(".error").removeClass("error");
                
                $("#detailsDialog").openModal();

                $("#saveCompany").on('click', function(){
                    saveClient(client);
                });
            };
         
            var saveClient = function(client) {
                $.extend(client, {
                    Nombre: $("#empresa_nombre").val(),
                    Rut: $("#empresa_rut").val(),
                    Giro: $("#empresa_giro").val(),
                    Direccion: $("#empresa_direccion").val(),
                    Comuna: $("#empresa_comuna").val(),
                    Ciudad: $("#empresa_ciudad").val(),
                    RazonSocial: $("#empresa_razonsocial").val(),
                    Email: $("#empresa_mail").val()
                });
                
                if($('.fotoEmpresa').find('.dropify')[0].files[0] != null){
        			send = new FormData();
        			send.append( 'pictures', $('.fotoEmpresa').find('.dropify')[0].files[0] );
        			send.append( 'folder', "empresas" );
        			
        			$.ajax({
        				url: "ajax/save_img.php", // Url to which the request is send
        				type: "POST",             // Type of request to be send, called as method
        				data: send, 			  // Data sent to server, a set of key/value pairs (i.e. form fields and values)
        				contentType: false,       // The content type used when sending data to the server.
        				cache: false,             // To unable request pages to be cached
        				processData:false,        // To send DOMDocument or non processed data file it is set to false
        				success: function(imgpath)   // A function to be called if request succeeds
        				{
        			  		imagenpath: imgpath

        			  		$.ajax({
        	                    url: 'query/insert_company.php',
        	                    async: true,
        	                    data: {"nombre": client.Nombre, "rut": client.Rut, "giro": client.Giro, "direccion": client.Direccion, "comuna": client.Comuna, "ciudad": client.Ciudad, "razonsocial": client.RazonSocial, "mail": client.Email, "logo": imgpath},
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

        				}
        			});
        			
        		}
         
            };

            
        });