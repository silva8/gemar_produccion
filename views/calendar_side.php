<div class="col s12 m2 l2">
                 
 <!-- Header Centro Nombre -->
  <div id="card-alert" class="card light-blue darken-3  z-depth-1">
    <div class="card-content white-text">
      <p class="truncate" id="centro_id" centroid="<?php echo $idcentro; ?>"><?php echo $centro; ?></p>
    </div>
  </div>

  <div id="delete-dropzone" class="card center z-depth-1 pink">
    <div class="card-content waves-effect waves-light pink white-text"><i class="mdi-action-delete tiny right"></i>Borrar Evento</div>
  </div>

  <!-- Container -->
  <div class="center white z-depth-1 container"> 

    <div class="row">
      <div class="divider">
      </div>

      <!-- Select de Criticidad -->
      <div class="container">
        <h5 class="header"></h5>
        <select class="browser-default" id="criticidad" name="criticidad"> 
          <option value="0" event-color="#59f442" selected>No Crítico</option>
          <option value="1" event-color="#f4424e">Crítico</option>
        </select>
      </div>
      <!-- Fin Select de Criticidad -->
      
      <!-- Pills Inspectores -->
      <div id='external-events' class="container">    
        <!--<h5 class="header">Inspectores</h5>-->

      <!-- Filtro de Pills -->
      <div class="dataPills_filter">
        <input type="search" id="profile-filter" placeholder="Filtro Inspectores">
      </div>
      <!-- Fin Filtro de Pills -->

        <?php

        $users = get_users();
    
        foreach($users as $user){
          echo "<a class='label fc-event' role='button' data-toggle='collapse' href='#user ".$user->user_id."' aria-expanded='false' aria-controls='user" .$user->user_id . "' event-color='#59f442' userid='" . $user->user_id  . "' style='background-color: #59f442; border-color: #59f442;'>" . $user->nombre . "</a>";
        }

        ?>

      </div>
      <!-- Fin Pills Inspectores -->  
    </div>
  </div>
  <!-- Fin Container -->
</div>