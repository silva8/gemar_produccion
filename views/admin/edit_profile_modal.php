<link href="js/plugins/dropify/css/dropify.min.css" type="text/css" rel="stylesheet" media="screen,projection">

<div id="editUserModal" class="modal">
    <div class="modal-content">

        <!-- Accion -->
        <div id="card-alert" class="card light-blue darken-3">
            <div class="card-content white-text">
                <p id="user_modal_accion">Editar usuario</p>
            </div>
        </div>

         <!-- Nombre usuario -->
        <div class="input-field row">
            <input id="usuario_nombre" type="text">
            <label for="usuario_nombre">Nombre</label>
        </div>

        <!-- Apellido usuario -->
        <div class="input-field row">
            <input id="usuario_apellido" type="text">
            <label for="usuario_apellido">Apellido</label>
        </div>

        <!-- Email usuario -->
        <div class="input-field row">
            <input id="usuario_email" type="text">
            <label for="usuario_email">Email</label>
        </div>

        <!-- Telefono usuario -->
        <div class="input-field row">
            <input id="usuario_telefono" type="text">
            <label for="usuario_telefono">Teléfono</label>
        </div>
        
        <!-- Titulo usuario -->
        <div class="input-field row">
            <input id="usuario_titulo" type="text">
            <label for="usuario_titulo">Título</label>
        </div>
        
        <!-- disciplina usuario -->
        <div class="input-field row">
            <input id="usuario_disciplina" type="text">
            <label for="usuario_disciplina">Disciplina</label>
        </div>
 	</div>

    <!-- Footer -->
    <div class="modal-footer">
        <div id="evento"></div>
        <a href="#" class="waves-effect waves-red btn-flat modal-action modal-close" id="cancelUser">Cancelar</a>
        <a href="#" class="waves-effect waves-green btn-flat modal-action modal-close light-blue" id="saveUser">Aceptar</a>
    </div>

</div>
<!-- dropify -->
<script type="text/javascript" src="js/plugins/dropify/js/dropify.js"></script>
<script type="text/javascript">
$( document ).ready(function() {
	$('.dropify').dropify();
	$('#cancelUser').click( function(e){
		$('.userFoto').remove();
	});
	$('#saveUser').click( function(e){
		e.preventDefault();

		//save img first, so you can save the full path to db too
		if($('.dropify-render').is(':empty') == false){
			if($('.userFoto').find('.dropify')[0].files[0] != null){
				send = new FormData();
				send.append( 'pictures', $('.userFoto').find('.dropify')[0].files[0] );
				send.append( 'folder', "users" );
				
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
	
				  		var user = {
								userid: $('#editUserModal').attr("userid"),
								user_first_name: $('#usuario_nombre').val(),
								user_last_name: $('#usuario_apellido').val(),
								user_email: $('#usuario_email').val(),
								user_phone: $('#usuario_telefono').val(),
								user_title: $('#usuario_titulo').val(),
								user_discipline: $('#usuario_disciplina').val(),
								user_image_path: imgpath
							};
						
						$.ajax({
							url: "query/update_user.php", 
							type: "POST",            
							data: {"user": user}
						}).done(function() {
							$('#content').load('views/user_profile_page.php?id="'+user["userid"]+'"');
						});
	
					}
				});
				
			}
			else{
				var user = {
						userid: $('#editUserModal').attr("userid"),
						user_first_name: $('#usuario_nombre').val(),
						user_last_name: $('#usuario_apellido').val(),
						user_email: $('#usuario_email').val(),
						user_phone: $('#usuario_telefono').val(),
						user_title: $('#usuario_titulo').val(),
						user_discipline: $('#usuario_disciplina').val()
					};
				
				$.ajax({
					url: "query/update_user.php", 
					type: "POST",            
					data: {"user": user}
				}).done(function() {
					$('#content').load('views/user_profile_page.php?id="'+user["userid"]+'"');
				});
			}
		}
		else{
			var user = {
					userid: $('#editUserModal').attr("userid"),
					user_first_name: $('#usuario_nombre').val(),
					user_last_name: $('#usuario_apellido').val(),
					user_email: $('#usuario_email').val(),
					user_phone: $('#usuario_telefono').val(),
					user_title: $('#usuario_titulo').val(),
					user_discipline: $('#usuario_disciplina').val(),
					user_image_path: "default.jpg"
				};
			
			$.ajax({
				url: "query/update_user.php", 
				type: "POST",            
				data: {"user": user}
			}).done(function() {
				$('#content').load('views/user_profile_page.php?id="'+user["userid"]+'"');
			});
		}
		
	});
	
});
</script>

