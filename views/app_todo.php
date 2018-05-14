<?php
  session_start();
  require_once dirname(__FILE__) . "/../include/lib.php";
  if($_SESSION['user_role'] == 1){
    $admin = true;
    $userid = false;

  }
  else{
    $admin = false;
    $userid = $_SESSION['user_id'];
  }
?>

<link href="js/plugins/monthpicker/MonthPicker.css" type="text/css" rel="stylesheet"
  media="screen,projection">
<link href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" />

<!--start container-->
<div class="container">
  <div class="section">
    <div class="col s12">
      <ul id="task-card" class="collection with-header">
          <li class="collection-header light-blue darken-3">
              <div class="row">
                <h4 class="col task-card-title">Reportes</h4>

                <div class="header-search-wrapper white-text">
                  <i class="mdi-action-today"></i>
                  <input id="month" type="text" class="header-search-input"/>
                </div>

                <div class="header-search-wrapper white-text">
                  <i class="mdi-action-search"></i>
                  <input id="report-filter" placeholder="Filtro de Reportes" type="text" class="header-search-input"/>
                </div>

              </div>
          </li>
      </ul>
      <ul class="collapsible collapsible-accordion" data-collapsible="accordion" id="appendReportes">



      </ul>

    </div>
  </div>
</div>
<?php   
  include_once dirname(__FILE__) . '/admin/generatepdf_modal.php';
  include_once dirname(__FILE__) . '/admin/reporte_modal.php';
  include_once dirname(__FILE__) . '/admin/files_modal.php';
?> 


    <script type="text/javascript" src="js/plugins/jquery-ui.js"></script> 
    <script type="text/javascript" src="js/plugins/monthpicker/MonthPicker.js"></script>
<!--end container-->
  
<script>
  $(document).ready(function(){

    var populatereportes = function (month, year){
      jQuery.ajax({
        method: "POST",
        url: "ajax/populate_reportes.php",
        data: {
          'month': month,
          'year': year,
          'admin':"<?php echo $admin; ?>",
          'userid': "<?php echo $userid; ?>"
        },
        error: function(response) {
          console.log(response);
        },
        success: function(response)
        {
          $('#appendReportes').html(response);
          $('.collapsible').collapsible();
        }
      });
    };

    var month = new Date().getMonth()+1;
    var year = new Date().getFullYear();
    populatereportes(month, year);

    $('#month').MonthPicker({ 
      Button: false,
      SelectedMonth: (new Date().getMonth()+1) +'/' + new Date().getFullYear(),
      OnAfterChooseMonth: function(selectedDate) {
        console.log((selectedDate.getMonth()+1));
        var month = (selectedDate.getMonth()+1);
        var year = selectedDate.getFullYear();
        populatereportes(month, year);
      },
      IsRTL: true,
      i18n: {
         year: 'Año',
         buttonText: 'Siguiente',
         prevYear: "Anterior",
         nextYear: "Siguiente",
         next12Years: 'Siguientes 12 años',
         prev12Years: 'Anteriores 12 años',
         nextLabel: "siguiente",  
         prevLabel: "previo",
         jumpYears: "Saltar a Años",
         backTo: "Volver al",
         months: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sept", "Oct", "Nov", "Dic"]
      }
    });

    $( "#report-filter" ).on('keyup', function() {
      $("#appendReportes").find('.collapsible-header').parent().show();
      var filter = $("#report-filter").val();
      if ( filter.length > 1 ){

        var lis = $("#appendReportes").find('.collapsible-header');
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

  });
</script>