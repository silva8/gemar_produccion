<div id="detailsDialog" class="modal modal-fixed-footer">
    <div class="modal-content">

        <!-- Accion -->
        <div id="card-alert" class="card light-blue darken-4">
            <div class="card-content white-text">
                <p id="centro_modal_accion"></p>
            </div>
        </div>

        <!-- Nombre Centro -->
        <div class="input-field row">
            <label class="active" for="centro_empresa">Empresa</label> 
            <select class="browser-default active" id="centro_empresa">
                <option value="" disabled selected>Elegir Empresa</option>
                <?php 
                $empresas = get_empresas();
                foreach ($empresas as $empresa){
                    echo '<option value="'. $empresa->id .'">'. $empresa->Nombre .'</option>';
                }
                ?>
            </select>
        </div>

         <!-- Nombre Centro -->
        <div class="input-field row">
            <input id="centro_nombre" type="text">
            <label for="centro_nombre">Nombre Centro</label>
        </div>

        <!-- Direccion Centro -->
        <div class="input-field row">
            <input id="centro_direccion" type="text">
            <label for="centro_direccion">Dirección Centro</label>
        </div>

        <!-- Contacto Centro -->
        <div class="input-field row">
            <input id="centro_contacto" type="text">
            <label for="centro_contacto">Contacto Centro</label>
        </div>

        <!-- Telefono Centro -->
        <div class="input-field row">
            <input id="centro_telefono" type="text">
            <label for="centro_telefono">Telefono Centro</label>
        </div>

        <!-- Email Centro -->
        <div class="input-field row">
            <input id="centro_email" type="text">
            <label for="centro_email">Email Centro</label>
        </div>

    </div>

    <!-- Footer -->
    <div class="modal-footer">
        <div id="evento"></div>
        <a href="#" class="waves-effect waves-red btn-flat modal-action modal-close" id="cancelCentro">Cancelar</a>
        <a href="#" class="waves-effect waves-green btn-flat modal-action modal-close light-blue" id="saveCentro">Aceptar</a>
    </div>

</div>
