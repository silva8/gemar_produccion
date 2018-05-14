<div id="modalEvento" class="modal modal-fixed-footer">
    <div class="modal-content">
        <!-- Nombre Inspector -->
        <div id="card-alert" class="card light-blue darken-3">
            <div class="card-content white-text">
                <p id="inspector-modal-evento"></p>
                <p id="centro-modal-evento"></p>
                <p id="criticidad-modal-evento"></p>
            </div>
        </div>

        <div class="row">
            <!-- Fecha inicio -->
            <div class="input-field col s6 m6 l6">
                <input type="text" class="datepicker active" id="fecha-inicio">
                <label for="input_text">Fecha Inicio</label>
            </div>
            <!-- Fecha fin -->
            <div class="input-field col s6 m6 l6">
                <input type="text" class="datepicker active" id="fecha-fin">
                <label for="input_text">Fecha Fin</label>
            </div>
        </div>

         <!-- Orden de Compra -->
        <div class="input-field row">
            <i class="mdi-action-shopping-cart prefix"></i>
            <input id="orden-compra" class="upper" type="text">
            <label for="orden-compra">Orden de Compra</label>
        </div>

        <!-- Nombre Proyecto -->
        <div class="input-field row">
            <i class="mdi-action-info-outline prefix"></i>
            <input id="nombre-proyecto" class="upper" type="text">
            <label for="nombre-proyecto">Nombre Proyecto</label>
        </div>

        <!-- Comprador - Activador -->
        <div class="input-field row">
            <i class="mdi-action-info-outline prefix"></i>
            <input id="comprador-proyecto" class="upper" type="text">
            <label for="comprador-proyecto">Comprador - Activador</label>
        </div>

        <!-- Proveedor -->
        <div class="input-field row">
            <i class="mdi-action-info-outline prefix"></i>
            <input id="proveedor-proyecto" class="upper" type="text">
            <label for="proveedor-proyecto">Proveedor</label>
        </div>

        <!-- Componente -->
        <div class="input-field row">
            <i class="mdi-action-info-outline prefix"></i>
            <input id="componente-proyecto" class="upper" type="text">
            <label for="componente-proyecto">Componente</label>
        </div>

         <!-- Select de Contactos -->
        <div class="row">
            <i class="mdi-action-perm-contact-cal prefix"></i>
            <label for="contacto-proyecto">Contacto</label>
            <select class="browser-default" id="contacto-proyecto" name="contacto"> 
                <option value="" disabled selected>Elegir Contacto</option>
                <?php
                $contactos = get_contactos(null, null, $idcentro);
                    
                foreach($contactos as $contacto){
                  echo '<option value="'.$contacto->contacto_id.'" >'.$contacto->nombre.'</option>';
                }

                ?>
            </select>
        </div>

        <!-- Descripcion Proyecto -->
        <div class="input-field row">
            <i class="mdi-action-list prefix"></i>
            <textarea id="descripcion-proyecto" class="materialize-textarea upper"></textarea>
            <label for="descripcion-proyecto">Descripción Proyecto</label>
        </div>

        <!-- Visitas Agendadas -->
        <div class="input-field row">
            <i class="mdi-action-today prefix"></i>
            <input id="visitas-agendadas" type="number">
            <label for="visitas-agendadas">Visitas Agendadas</label>
        </div>
    </div>
    <div class="modal-footer">
        <div id="evento"></div>
        <a href="#" class="waves-effect waves-red btn-flat modal-action modal-close red">Cancelar</a>
        <a href="#" class="waves-effect waves-green btn-flat modal-action modal-close green" id="asignTime">Aceptar</a>
    </div>
</div>



<script>
    $(document).ready(function() {
        //$('#modalEvento').modal();

        $('.modal-close').on('click', function(){
            $('.lean-overlay').hide();
        });

        $('#asignTime').click(function() {
            /*
             * Funcion que se ejecuta la hacer click al boton aceptar del selector
             * de hora del modalEvento
             * recopila la informacion del evento que se arrojo y que no tenia hora
             * para generar un nuevo evento y renderearlo, guardarlo en la DB
             * y hacer las verificaciones pertinentes
             */
            var start = moment($('#fecha-inicio').val());
            var end = moment($('#fecha-fin').val());
            var nombreproyecto = $('#nombre-proyecto').val();
            var proveedor = $('#proveedor-proyecto').val();
            var comprador = $('#comprador-proyecto').val();
            var ordencompra = $('#orden-compra').val();
            var componente = $('#componente-proyecto').val();
            var contactoproyecto = $('#contacto-proyecto option:selected').val();
            var descripcionproyecto = $('#descripcion-proyecto').val();
            var visitasagendadas = $('#visitas-agendadas').val();
            var userid = $('#evento').attr('userid');
            var centroid = $('#evento').attr('centroid');
            var color = $('#evento').attr('color');
            var title = $('#evento').attr('title');
            var description = $('#evento').attr('description');
            var criticidadevento = $('#criticidad option:selected').val();
            // se crea el evento con los elementos recopilados
            // el paso anteriro se puede reemplazar por la composicion del JSON inmediatamente
            var event = {
                "id": 0,
                "title": title,
                "userid": userid,
                "centroid": centroid,
                "color": color,
                "description": description,
                "fromBD": 0,
                "saved": 0,
                "start": start,
                "end": end,
                "nombre_proyecto": nombreproyecto,
                "proveedor": proveedor,
                "comprador": comprador,
                "orden_compra": ordencompra,
                "contacto_proyecto": contactoproyecto,
                "descripcion_proyecto": descripcionproyecto,
                "visitas_agendadas": visitasagendadas,
                "criticidad": criticidadevento,
                "color": color,
                "componente": componente
                 
            };
            //se renderea el evento y se guarda en la bbdd
            $('#calendar').fullCalendar('renderEvent', event);
            saveBD(event);
            //$('#modalEvento').modal('hide');
            //console.log(event);
        });//click de aceptar el modal

        $('.datepicker').pickadate({
            selectMonths: true, // Creates a dropdown to control month
            selectYears: 4, // Creates a dropdown of 15 years to control year,
            today: 'Today',
            clear: 'Clear',
            close: 'Ok',
            closeOnSelect: true, // Close upon selecting a date,
            autoclose: true
        });

        function jsUcfirst(string) 
        {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }

        $('.upper').keyup(function(){
			$(this).val(jsUcfirst($(this).val()));
        });

        
    });
</script>