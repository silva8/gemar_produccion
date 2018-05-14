<!--dropify-->
<link href="js/plugins/dropify/css/dropify.min.css" type="text/css" rel="stylesheet" media="screen,projection">

<div id="filesmodal" class="modal modal-fixed-footer" style="overflow-y: hidden; overflow-x: hidden; ">
<div class="modal-content">
	<!-- Accion -->
	<div id="card-alert" class="card cyan">
		<div class="card-content white-text">
		<p id="files_modal_accion" reporteid="">Archivos adjuntos</p>
		</div>
	</div>
	<div id="files-list">
		<ul class="collection with-header filefill">
	        <li class="collection-header"><h4>Archivos</h4></li>
        </ul>
	</div>      
</div>

    <!-- Footer -->
    <div class="modal-footer">
        <div class="row">
	        <!-- Acciones -->
	        <a href="#" class="waves-effect waves-green btn-flat modal-action modal-close cyan" id="closeFileModal">Cerrar</a>
        </div>
    </div>

</div>

<!-- dropify -->
<script type="text/javascript" src="js/plugins/dropify/js/dropify.js"></script>

<script>
$(document).ready(function (e) {

	$(document).on('click', '#closeFileModal', function(){
		$('.file-item').remove();
	});

});	
</script>