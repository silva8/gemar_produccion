<?php
include_once dirname(__FILE__).'/../../include/lib.php'; // archivo de conexion local
?>

<div id="modal_logs" class="modal bottom-sheet">
	<div class="modal-content">
		<div class="row">
			<div class="col s4">
				<h4>Empresas</h4>
			</div>
			<div class="col s4 offset-s4 align-right">
				<div class="dataTables_filter">
				<label>Filtrar:<input type="search" id="company-filter" placeholder=""></label>
				</div>
			</div>
		</div>
		
		<ul class="collection" id="company-ul-filter">
			<!-- <img src="images/avatar.jpg" alt=""	class="circle"> -->
			<?php
				$empresas = get_empresas();
				foreach($empresas as $empresa){
					echo '<li class="collection-item avatar waves-effect waves-block waves-teal load-content" what="views/admin/logs.php?id='.$empresa->id.'&name='.$empresa->nombre.'" where="content">
						  	<i class="mdi-editor-insert-emoticon circle"></i>
							<span class="title company-name">'.$empresa->Nombre.'</span>
							<p>'.$empresa->Email.'</p> 
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
	$( "#company-filter" ).on('keyup', function() {
		  $("#company-ul-filter").find('.company-name').parent().show();
		  var filter = $("#company-filter").val();
		  if ( filter.length > 1 ){

				var lis = $("#company-ul-filter").find('.company-name');
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

	$( ".modal-company-trigger" ).on('click', function() {
		$('#company-filter').focus();
	});

});
</script>