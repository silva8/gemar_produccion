  <?php 
    require_once dirname(__FILE__) . "/../../include/lib.php";
  ?>
  <div id="login-page" class="row center center-align">
  
      <div class="">
        
        <!-- Header -->
        <div class="row">
          <div class="input-field col s12 center">
            <h4>Registrar Nuevo Usuario</h4>

            <!-- Informacion -->
            <div id="card-alert" class="card light-blue">
              <div class="card-content white-text">
               <p class="center">Al usuario le llegará un correo con sus datos de ingreso al portal</p>
              </div>
            </div>

          </div>
        </div>

        <!-- FORM -->
        
        <form id="formValidate" name="register" action="#">
        <div class="row">
          <!-- LEFT -->
          <div class="col s4 offset-s1">
              <!-- Username -->
              <div class="row margin input-field">
                <div class="input-field col s12">
                  <i class="mdi-social-person-outline prefix"></i>
                  <input id="username" name="username" type="text" autocomplete="off">
                  <label for="username" class="center-align">Username</label>
                </div>
              </div>
              <!-- Password -->
              <div class="row margin input-field">
                <div class="input-field col s12">
                  <i class="mdi-action-lock-outline prefix"></i>
                  <input id="password" name="password" type="text" autocomplete="off" disabled value="<?php echo generatePass(); ?>">
                  <label class="active" for="password">Password</label>
                </div>
              </div>  
              <!-- Email -->
              <div class="row margin input-field">
                <div class="input-field col s12">
                  <i class="mdi-communication-email prefix"></i>
                  <input id="email" name="email" type="email" autocomplete="off">
                  <label for="email" class="center-align">Email</label>
                </div>
              </div>                        
              <!-- Titulo -->
              <div class="row margin input-field">
                <div class="input-field col s12">
                  <i class="mdi-social-school prefix"></i>
                  <input id="titulo" name="titulo" type="text" autocomplete="off">
                  <label for="titulo" class="center-align">Título</label>
                </div>
              </div>
              <!-- Rol -->
              <div class="row margin">
                <div class="col s12">
                  <div class="divider"></div>
                  <select class="browser-default" id="role" name="role">
                    <option value="" disabled selected>Elegir Rol</option>
                    <option value="0">Usuario</option>
                    <option value="1">Administrador</option>
                  </select>
                  <div class="divider"></div>
                </div>
              </div> 
          </div>
          <!-- RIGHT -->
          <div class="col s4 offset-s1">
              <!-- Nombre -->
              <div class="row margin input-field">
                <div class="input-field col s12">
                  <i class="mdi-social-person-outline prefix"></i>
                  <input id="firstname" name="firstname" type="text" autocomplete="off">
                  <label for="firstname" class="center-align">Nombres</label>
                </div>
              </div>
              <!-- Apellido -->
              <div class="row margin input-field">
                <div class="input-field col s12">
                  <i class="mdi-social-person-outline prefix"></i>
                  <input id="lastname" name="lastname" type="text" autocomplete="off">
                  <label for="lastname" class="center-align">Apellidos</label>
                </div>
              </div>
              <!-- Telefono -->
              <div class="row margin input-field">
                <div class="input-field col s12">
                  <i class="mdi-communication-phone prefix"></i>
                  <input id="phone" name="phone" type="text" autocomplete="off">
                  <label for="phone" class="center-align">Teléfono</label>
                </div>
              </div>
              <!-- Region -->
              <div class="row margin input-field">
                <div class="input-field col s12">
                  <i class="mdi-communication-location-on prefix"></i>
                  <input id="region" name="region" type="text" autocomplete="off">
                  <label for="region" class="center-align">Región</label>
                </div>
              </div>
              <!-- Disciplina -->
              <div class="row margin input-field">
                <div class="input-field col s12">
                  <i class="mdi-action-info-outline prefix"></i>
                  <input id="disciplina" name="disciplina" type="text" autocomplete="off">
                  <label for="disciplina" class="center-align">Disciplina</label>
                </div>
              </div>
          </div>
        </div>

        <!-- Submit Button -->
        <div class="row">
          <div class="col s12">
            <a class="col s9 offset-s1 btn z-depth-3 waves-effect waves-light" name="register" id="register-user">Guardar
              <i class="mdi-content-send right"></i>
            </a>      
          </div>
        </div>

      </div>
    </form>
  </div>
  
  <script>
$( document ).ready(function() {
  $( "#register-user" ).on('click', function() {
    var username = $('#username').val();
    var password = $('#password').val();
    var email = $('#email').val();
    var titulo = $('#titulo').val();
    var role = $('#role').val();
    var firstname = $('#firstname').val();
    var lastname = $('#lastname').val();
    var phone = $('#phone').val();
    var region = $('#region').val();
    var disciplina = $('#disciplina').val();

    jQuery.ajax({
      method: "POST",
      url: "query/insert_user.php",
      data: {
        'username': username,
        'password': password,
        'email': email,
        'titulo': titulo,
        'role': role,
        'firstname': firstname,
        'lastname': lastname,
        'phone': phone,
        'region': region,
        'disciplina': disciplina 
      },
      error: function(response) {
        console.log(response);
      },
      success: function(response)
      {
          if($.isNumeric( response )){
            Materialize.toast("Usuario registrado con éxito.", 1500);
            $('#formValidate').trigger("reset");  
            $('#password').val("<?php echo generatePass(); ?>"); 
          }
          else{
            Materialize.toast(response, 1500);
          }
      }
    });//ajax

  });
});
  </script>