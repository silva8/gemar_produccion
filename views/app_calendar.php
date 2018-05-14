<?php
  session_start();
  require_once dirname(__FILE__) . "/../include/lib.php";
  if($_SESSION['user_role'] == 1){
    $centro = $_REQUEST['centro'];
    $idcentro = $_REQUEST['idcentro'];
  }
  else{
    $userid = $_SESSION['user_id'];
  }
?>

<link href="js/plugins/fullcalendar/css/fullcalendar.min.css" type="text/css" rel="stylesheet" media="screen,projection">
      
<!--start container-->
<div class="container">
  <div class="section">
    <div id="full-calendar">              
      <div class="row">
        <?php if ($_SESSION['user_role'] == 1){
          require_once dirname(__FILE__) . "/calendar_side.php";
          echo '<div class="col s12 m8 l9">';
        }
        else{
          echo '<div class="col s12 m12 l12">';
        }
        ?>
          <div class="calendar-loading-gif"  style="display : none; background-image : url('images/loading.gif'); opacity : 0.4; background-repeat : no-repeat; background-position : center; position : absolute; z-index : 101; width : 57vw; height : 65vh;">
          </div>
          <div id='calendar'></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--end container-->

<!-- Calendar Script -->
<script type="text/javascript" src="js/plugins/fullcalendar/lib/jquery-ui.custom.min.js"></script>
<script type="text/javascript" src="js/plugins/fullcalendar/lib/moment.min.js"></script>
<script type="text/javascript" src="js/plugins/fullcalendar/js/fullcalendar.min.js"></script>
<script type="text/javascript" src="js/plugins/fullcalendar/fullcalendar-script.js"></script>

<!-- CUSTOM -->
<script src="js/plugins/fullcalendar/js/custom/saveBD.js"></script><!-- SAVE Event to BD -->
<script src="js/plugins/fullcalendar/js/custom/eventReceive.js"></script><!-- eventReceive -->
<script src="js/plugins/fullcalendar/js/custom/updateEvent.js"></script><!-- updateEvent -->
<script src="js/plugins/fullcalendar/js/custom/verifyEvent.js"></script><!-- verifyEvent -->
<script src="js/plugins/fullcalendar/js/custom/deleteEvent.js"></script><!-- deleteEvent -->
<script src="js/plugins/fullcalendar/js/custom/renderEvent.js"></script><!-- renderEvent -->

<?php //include_once dirname(__FILE__) . '/admin/verificacion_modal.php'; //modal para los mensajes de verificacion   ?>
<?php   if($_SESSION['user_role'] == 1){ include_once dirname(__FILE__) . '/admin/evento_modal.php';  } ?> 

<!-- filter script -->
<script>
  $( document ).ready(function() {
    $('#profile-filter').keyup(function () {
    $('.fc-event').hide();
    var txt = $('#profile-filter').val();
    $('.fc-event').each(function () {
        if ($(this).text().toUpperCase().indexOf(txt.toUpperCase()) != -1) {
            $(this).show();
        }
    });
    });
  });
</script>
<script>
  var loading = function (isLoading, view) {
    if (isLoading) {
        $('.calendar-loading-gif').show();
    } else {
        $('.calendar-loading-gif').hide();
    }
  };
</script><!-- loading del calendario!-->

<script>
      
  $(document).ready(function() {

    /* initialize the external events
    -----------------------------------------------------------------*/

    /*cuando se cambia la criticidad se "instancia" nuevamente los pills pero con el color de la ésta
     */
    $('#criticidad').change(function () {
        color = $('#criticidad option:selected').attr('event-color');
        centroid = $('#centro_id').attr("centroid");

        $('#external-events .fc-event, .medico').each(function () {
            $(this).css('background', color).css('border', color).css("line-height", "1.45");
            $(this).attr('event-color', color); // se asigna el color de la criticidad correspondiente a cada elemento
            centrotext = $('#centro_id').text();

            userid = $(this).attr('userid');
            $(this).data('event', {
                title: centrotext, // use the element's text as the event title
                description: $.trim($(this).text()),
                //stick: true, // maintain when user navigates (see docs on the renderEvent method)
                color: color, //cambia el color al color asignado
                editable: true,
                centroid: centroid,
                userid: userid,
                fromBD: 0,
                saved: 0
            });
        });// each
    });


    $('#external-events .fc-event').each(function () {
      /*
       * funcion que asigna el event a un pill de usuarios la primera vez
       * que se crean los pills
       */
      color = $(this).attr('event-color');
      centroid = $('#centro_id').attr("centroid");
      centrotext = $('#centro_id').text();
      userid = $(this).attr('userid');
      // store data so the calendar knows to render an event upon drop
      $(this).data('event', {
          title: centrotext, // use the element's text as the event title
          description: $.trim($(this).text()),
          //stick: true, // maintain when user navigates (see docs on the renderEvent method)
          color: color, //cambia el color al color asignado
          editable: true,
          centroid: centroid,  
          userid: userid,
          fromBD: 0,
          saved: 0
      });

      // make the event draggable using jQuery UI
      $(this).draggable({
          zIndex: 999,
          revert: true, // will cause the event to go back to its original position after the drag
          revertDuration: 0
      });
    });//each


    /* initialize the calendar
    -----------------------------------------------------------------*/
    $('#calendar').fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,basicWeek,basicDay'
      },
  //      defaultDate: '2015-05-12',
      editable: <?php if($_SESSION['user_role'] == 1){  echo "true"; } else{ echo "false";}?> ,
      droppable: true, // this allows things to be dropped onto the calendar
      eventLimit: true, // allow "more" link when too many events
      //defaultTimedEventDuration: '03:00:00',
      forceEventDuration: true,
      displayEventEnd: true,
      allDaySlot: true,
      allDay: true,
      timeFormat: 'H:mm',
      eventSources: [
                {"url": "query/feed_eventos_centro.php?<?php if($_SESSION['user_role'] == 1){  echo 'idcentro='.$idcentro; } else { echo 'iduser='.$_SESSION['user_id'];  } ?>"
                }
            ], //eventSources
      eventRender: renderEvent,
      eventDrop: updateEvent,
      eventResize: updateEvent,
      eventDragStop: deleteEvent,
      eventReceive: eventReceive,
      loading: loading,
      lazyFetch: true,
    });

  });
</script>