<?php
	include_once dirname(__FILE__).'/../../include/lib.php'; // archivo de conexion local
?>

<div id="modal_hojas" class="modal bottom-sheet">
	<div class="modal-content">
		<div class="row">
			<div class="col s4">
				<h4>Inspectores</h4>
			</div>
			<div class="col s4 offset-s4 align-right">
				<div class="dataTables_filter">
				<label>Filtrar:<input type="search" id="profile-filter" placeholder=""></label>
				</div>
			</div>
		</div>
		
		<ul class="collection" id="profle-ul-filter">
			<!-- <img src="images/avatar.jpg" alt=""	class="circle"> -->
			<?php
				$users = get_users();
				foreach($users as $user){
					echo '<li class="collection-item avatar waves-effect waves-block waves-teal load-content" what="views/admin/hojas_tiempo.php?id='.$user->user_id.'&name='.$user->user_first_name.'&lastname='.$user->user_last_name.'" where="content">
						  	<i class="mdi-editor-insert-emoticon circle"></i>
							<span class="title profile-name">'.$user->user_first_name.' '.$user->user_last_name.'</span>
							<p>'.$user->user_name.'</p> 
							<a href="#!" class="secondary-content">
								<i class="mdi-action-open-in-browser"></i>
							</a>
						</li>';
				}
			?>

		</ul>
	</div>
</div>

<script>
$( document ).ready(function() {
	$( "#profile-filter" ).on('keyup', function() {
		  $("#profle-ul-filter").find('.profile-name').parent().show();
		  var filter = $("#profile-filter").val();
		  if ( filter.length > 1 ){

				var lis = $("#profle-ul-filter").find('.profile-name');
				$.each( lis, function( key, value ) {
					 var here = $(this);
					 var text = here.text().toLowerCase();
					 var index = text.indexOf(filter.toLowerCase());

					 if( parseFloat(index) == -1){
						 here.parent().hide();
					 }
				});
		  }
	});

	$( ".modal-profile-trigger" ).on('click', function() {
		$('#profile-filter').focus();
	});

});
</script>