<link href="js/plugins/dropify/css/dropify.min.css" type="text/css" rel="stylesheet" media="screen,projection">

<div id="detailsDialog" class="modal modal-fixed-footer">
    <div class="modal-content">

        <!-- Accion -->
        <div id="card-alert" class="card light-blue darken-3">
            <div class="card-content white-text">
                <p id="empresa_modal_accion"></p>
            </div>
        </div>

         <!-- Nombre Empresa -->
        <div class="input-field row">
            <input id="empresa_nombre" type="text">
            <label for="orden-compra">Nombre Empresa</label>
        </div>

        <!-- Rut Empresa -->
        <div class="input-field row">
            <input id="empresa_rut" type="text">
            <label for="orden-compra">Rut Empresa</label>
        </div>

        <!-- Giro Empresa -->
        <div class="input-field row">
            <input id="empresa_giro" type="text">
            <label for="orden-compra">Giro Empresa</label>
        </div>

        <!-- Direccion Empresa -->
        <div class="input-field row">
            <input id="empresa_direccion" type="text">
            <label for="orden-compra">Dirección Empresa</label>
        </div>

        <!-- Comuna Empresa -->
        <div class="input-field row">
            <input id="empresa_comuna" type="text">
            <label for="empresa_comuna">Comuna Empresa</label>
        </div>

        <!-- Ciudad Empresa -->
        <div class="input-field row">
            <input id="empresa_ciudad" type="text">
            <label for="empresa_ciudad">Ciudad Empresa</label>
        </div>

        <!-- Razon Social Empresa -->
        <div class="input-field row">
            <input id="empresa_razonsocial" type="text">
            <label for="empresa_razonsocial">Razón Social Empresa</label>
        </div>

        <!-- Email Empresa -->
        <div class="input-field row">
            <input id="empresa_mail" type="text">
            <label for="empresa_mail">Email Empresa</label>
        </div>
        
        <!--  Foto Empresa -->
		<div class="fotoEmpresa">
		 	<div class="row"><h6 class="left-align">Logo empresa</h6></div>
			<input type="file" name="pictures" accept="image/*" id="file" class="dropify"/>
		</div>
 	</div>

    <!-- Footer -->
    <div class="modal-footer">
        <div id="evento"></div>
        <a href="#" class="waves-effect waves-red btn-flat modal-action modal-close" id="cancelCompany">Cancelar</a>
        <a href="#" class="waves-effect waves-green btn-flat modal-action modal-close light-blue" id="saveCompany">Aceptar</a>
    </div>

</div>
<!-- dropify -->
<script type="text/javascript" src="js/plugins/dropify/js/dropify.js"></script>
<script type="text/javascript">
	$('.dropify').dropify();
</script>

