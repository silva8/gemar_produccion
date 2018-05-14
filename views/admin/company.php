  <!--jsgrid css-->
  <link href="js/plugins/jsgrid/css/jsgrid.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="js/plugins/jsgrid/css/jsgrid-theme.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <?php 
    require_once dirname(__FILE__) . "/../../include/lib.php";
  ?>
  <style>
    input.error, select.error {
        border: 1px solid #ff9999;
        background: #ffeeee;
    }

    label.error {
        float: right;
        margin-left: 100px;
        font-size: .8em;
        color: #ff6666;
    }
  </style>  

  <!--content-->
  <div id="company-page" class="row center center-align">
    <h4>Agregar / Editar Empresas</h4>
    <div class="center col s12 m10 offset-m1 l10 offset-l1 ">
      <div class="divider"></div>
      <!-- Js Grid -->
      <div id="jsGrid-custom"></div>
      <!-- Add modal -->
      <?php 
        require_once dirname(__FILE__) . "/empresa_modal.php";
      ?>
    </div> 
  </div>
  
  <!--jsgrid-->
  <script type="text/javascript" src="js/plugins/jsgrid/js/jsgrid.min.js"></script>
  <script type="text/javascript" src="js/plugins/jsgrid/js/i18n/jsgrid-es.js"></script>  
  <script type="text/javascript" src="js/plugins/jsgrid/js/jsgrid-script.js"></script>
