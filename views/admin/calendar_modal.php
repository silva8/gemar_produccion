<?php
	include_once dirname(__FILE__).'/../../include/lib.php'; // archivo de conexion local
?>

<div id="modal_calendario" class="modal bottom-sheet">
	<div class="modal-content">
		<div class="row">
			<div class="col s4">
				<h4>Centros</h4>
			</div>
			<div class="col s4 offset-s4 align-right">
				<div class="dataTables_filter">
				<label>Filtrar:<input type="search" id="centros-filter" placeholder=""></label>
				</div>
			</div>
		</div>
		
		<ul class="collection" id="centros-ul-filter">

			<?php
				$centros = get_centros("false", null, "true");
				foreach($centros as $centro){
					echo '<li class="collection-item avatar waves-effect waves-block waves-teal load-content" what="views/app_calendar.php?idcentro='.$centro->centro_id.'&centro='.urlencode($centro->nombre).'" where="content">
						  	<i class="mdi-editor-insert-emoticon circle"></i>
							<span class="title centros-name">'.$centro->nombre.'</span>
							<p>'.$centro->empresa.'</p> 
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
	$( "#centros-filter" ).on('keyup', function() {
		  $("#centros-ul-filter").find('.centros-name').parent().show();
		  var filter = $("#centros-filter").val();
		  if ( filter.length > 1 ){

				var lis = $("#centros-ul-filter").find('.centros-name');
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
		$('#centros-filter').focus();
	});

});
</script>