<?php
session_start();
if(isset($_REQUEST['id'])) {
  $userid = $_REQUEST['id'];
}
else {
  $userid = $_SESSION['user_id'];
}
include_once dirname(__FILE__).'/../include/lib.php'; // archivo de conexion local
?>
<link href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" />
<!--start container-->
<div class="container">
	<div id="profile-page" class="section">
            <!-- profile-page-header -->
            <?php 
            $user = get_users($userid);
            echo '<div class="row">
			    	<div class="col s12">
			  			<div class="card white"> 
			  				<div class="card-content black-text">                  
								<figure class="card-profile-image center-align">
							    	<img src="images/users/'.$user[0]->user_image_path.'" style="width:250px; height:250px;" alt="profile image" class="circle z-depth-2 responsive-img activator">
							    </figure>   
			  					<div class="col s6 offset-s3 center-align">                        
					            	<h1 class="card-title title-text text-darken-4" style="font-size:250%">'.$user[0]->nombre.'</h1>
					                <p class="medium grey-text">'.$user[0]->user_discipline.'</p>                        
				            	</div>
				                <div class="col s1 right-align offset-s2">
				                	<a class="btn-floating waves-effect waves-light darken-2 right modal-trigger" href="#editUserModal">
				                    	<i class="mdi-editor-mode-edit edit_user" userid="'.$user[0]->user_id.'"></i>
				                   	</a>
				             	</div>
							</div>
				 		</div>
					</div>
				</div>
				<div class="row">
					<div class="col s12 ">
					    <div class="card white">
					    	<div class="card-content black-text valign-wrapper">
					            <div class="col s2 offset-s2 center-align">
					            	<h4 class="card-title grey-text text-darken-4" style="font-size:150%">Teléfono</h4>
					               	<p class="medium-small grey-text"><i class="mdi-action-perm-phone-msg cyan-text text-darken-2"></i>  '.$user[0]->user_phone.'</p>
					            </div>
				           		<div class="col s2 offset-s1 center-align">
					              	<h4 class="card-title grey-text text-darken-4" style="font-size:150%">Email</h4>
					             	<p class="medium-small grey-text"><i class="mdi-communication-email cyan-text text-darken-2"></i>  '.$user[0]->user_email.'</p>	                  
					            </div>
					            <div class="col s2 offset-s1 center-align">
					              	<h4 class="card-title grey-text text-darken-4" style="font-size:150%">Título</h4>
					             	<p class="medium-small grey-text"><i class="mdi-action-work cyan-text text-darken-2"></i>  '.$user[0]->user_title.'</p>	                  
					            </div>
					        </div>
             			</div>
				  	</div>
				</div>';
			    include_once dirname(__FILE__).'/admin/edit_profile_modal.php';
				?>
          </div>
        </div>
        
<script type="text/javascript" src="js/plugins/jquery-ui.js"></script> 
<script type="text/javascript" src="js/materialize.min.js"></script>
<script>
$( document ).ready(function() {
	$( ".edit_user" ).on('click', function(event) {
		$('#editUserModal').attr("userid", $(this).attr("userid"));
		fillUser($(this).attr("userid"));
		$('#editUserModal').openModal();
	});

	function fillUser(userid){
		$.ajax({
			url: "query/get_usersjson.php", 
			type: "POST",            
			data: {"iduser": userid},
			success: function(response)   
			{	
				response = JSON.parse(response);
				$('#usuario_nombre').val(response["user_first_name"]);
				$('#usuario_apellido').val(response["user_last_name"]);
				$('#usuario_email').val(response["user_email"]);
				$('#usuario_telefono').val(response["user_phone"]);
				$('#usuario_titulo').val(response["user_title"]);
				$('#usuario_disciplina').val(response["user_discipline"]);
				fillFotos(response["user_image_path"]);
				$("label[for='usuario_nombre']").addClass('active');
				$("label[for='usuario_apellido']").addClass('active');
				$("label[for='usuario_email']").addClass('active');
				$("label[for='usuario_telefono']").addClass('active');
				$("label[for='usuario_titulo']").addClass('active');
				$("label[for='usuario_disciplina']").addClass('active');
			},
			error: function(e){
				alert("error");
			}
		});
	};

	function fillFotos(foto){
		var path =  "/gemar/images/users/";
		console.log(path);
		var html = 	'<div class="userFoto">'+
		 				'<div class="row"><h6 class="left-align">Fotografía</h6></div>'+
						'<input type="file" name="pictures" accept="image/*" id="file" class="dropify" data-default-file="'+path+foto+'"/>' +
					'</div>';
		
		$.when($('#editUserModal').find('.modal-content').append(html)).then(function( value ) {
			$('.dropify').dropify();
    		$('#editUserModal').find('.modal-content').animate({scrollTop: $('#reportemodal').find('.modal-content').prop("scrollHeight")}, 'slow');
    	});

	}
});

</script>