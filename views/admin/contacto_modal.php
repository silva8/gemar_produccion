<div id="detailsDialog" class="modal modal-fixed-footer">
    <div class="modal-content">

        <!-- Accion -->
        <div id="card-alert" class="card light-blue darken-3">
            <div class="card-content white-text">
                <p id="contacto_modal_accion"></p>
            </div>
        </div>

        <!-- Nombre Centro -->
        <div class="input-field row">
            <label class="active" for="contacto_empresa">Empresa</label> 
            <select class="browser-default active" id="contacto_empresa">
                <option value="" disabled selected>Elegir Empresa</option>
                <?php 
                $empresas = get_empresas();
                foreach ($empresas as $empresa){
                    echo '<option value="'. $empresa->id .'">'. $empresa->Nombre .'</option>';
                }
                ?>
            </select>
        </div>

         <!-- Nombre Contacto -->
        <div class="input-field row">
            <input id="contacto_nombre" type="text">
            <label for="contacto_nombre">Nombre Contacto</label>
        </div>

        <!-- Email Contacto -->
        <div class="input-field row">
            <input id="contacto_email" type="text">
            <label for="contacto_email">Email Contacto</label>
        </div>

        <!-- Direccion Contacto -->
        <div class="input-field row">
            <input id="contacto_direccion" type="text">
            <label for="contacto_direccion">Dirección Contacto</label>
        </div>

        <!-- Telefono Contacto -->
        <div class="input-field row">
            <input id="contacto_telefono" type="text">
            <label for="contacto_telefono">Telefono Contacto</label>
        </div>

        <!-- Cargo Contacto -->
        <div class="input-field row">
            <input id="contacto_cargo" type="text">
            <label for="contacto_cargo">Cargo Contacto</label>
        </div>

        <!-- Departamento Contacto -->
        <div class="input-field row">
            <input id="contacto_departamento" type="text">
            <label for="contacto_departamento">Departamento Contacto</label>
        </div>

    </div>

    <!-- Footer -->
    <div class="modal-footer">
        <div id="evento"></div>
        <a href="#" class="waves-effect waves-red btn-flat modal-action modal-close" id="cancelContacto">Cancelar</a>
        <a href="#" class="waves-effect waves-green btn-flat modal-action modal-close light-blue" id="saveContacto">Aceptar</a>
    </div>

</div>
