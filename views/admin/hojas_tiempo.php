<?php
  session_start();
  require_once dirname(__FILE__) . "/../../include/lib.php";
  if(isset($_REQUEST['id'])){
    $userid = $_REQUEST['id'];
    $name = $_REQUEST['name'];
    $lastname = $_REQUEST['lastname'];
  }
  else{
    $userid = $_SESSION['user_id'];
    $name = $_SESSION['user_name'];
    $lastname = $_SESSION['user_lastname'];
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
	          	<div class="col s12 left-align">
	                <h4 class="col task-card-title">Hoja de Tiempo - <?php echo $name.' '.$lastname;?></h4>
                </div>
                <div class="col s2 left-align">
					<h5 class="col task-card-title">Semana</h5>
				</div>
                <div class="header-search-wrapper white-text">
                  <i class="mdi-action-today"></i>
                  <input id="weekPicker" type="text" class="header-search-input"/>
                </div>

              </div>
          </li>
      </ul>
      <div class="row">
      	<div class="col s12">
      	</div>
      </div>
      <div id="appendHojas">



      </div>

    </div>
  </div>
</div>


<script type="text/javascript" src="js/plugins/jquery-ui.js"></script>
<script>
$( document ).ready(function() {

  var userid = <?php echo $userid;?>;
  
  function weekchange(fecha, userid){
	
    jQuery.ajax({
      method: "POST",
      url: "ajax/populate_hojas.php",
      data: {
        'fecha': fecha,
        'userid': userid
      },
      error: function(response) {
        //console.log(response);
      },
      success: function(response)
      {
        $('#appendHojas').html(response);
      }
    });
  };

  var globalTriggeringElement;
  var globalAdditionalFunction = function() { null; };

  var getDateFromISOWeek = function(ywString, separator) {
      try {
          //console.log(ywString);
          var ywArray = ywString.split(separator);
          var y = ywArray[0];
          var w = ywArray[1];
          var simple = new Date(y, 0, 1 + (w - 1) * 7);
          var dow = simple.getDay();
          var ISOweekStart = simple;
          if (dow <= 4)
              ISOweekStart.setDate(simple.getDate() - simple.getDay() + 1);
          else
              ISOweekStart.setDate(simple.getDate() + 8 - simple.getDay());
          return ISOweekStart;
      } catch (err) {
          console.error("Cannot convert Week into date");
          return new Date();
      }
  };

  var showWeekCalendar = function(triggeringElement, additionalFunction) {
      globalTriggeringElement = triggeringElement;
      globalAdditionalFunction = additionalFunction;
      var prevItem = $(triggeringElement).prev();
      var weekValue = prevItem.val();
      prevItem.datepicker("option", "defaultDate", getDateFromISOWeek(weekValue, '-'));
      prevItem.val(weekValue);
      prevItem.datepicker("show");
  };

  var setWeekCalendar = function(settingElement) {
      var startDate;
      var endDate;
      var selectCurrentWeek = function() {
          window.setTimeout(function() {
              var activeElement = $("#ui-datepicker-div .ui-state-active");
              var tdElement = activeElement.parent();
              var trElement = tdElement.parent();

              trElement.find("a").addClass("ui-state-active")

          }, 1);
      };

      $(settingElement).datepicker({
          showOtherMonths: true,
          selectOtherMonths: true,
          showWeek: true,
          firstDay: 1,
          onSelect: function(dateText, inst) {
              var datepickerValue = $(this).datepicker('getDate');
              var dateObj = new Date(datepickerValue.getFullYear(), datepickerValue.getMonth(), datepickerValue.getDate());
              var weekNum = $.datepicker.iso8601Week(dateObj);
              if (weekNum < 10) {
                  weekNum = "0" + weekNum;
              }
              var ywString = datepickerValue.getFullYear() + '-' + weekNum;
              $(this).val(ywString);
              $(this).prev().html(ywString);
              startDate = new Date(datepickerValue.getFullYear(), datepickerValue.getMonth(), datepickerValue.getDate() - datepickerValue.getDay());
              endDate = new Date(datepickerValue.getFullYear(), datepickerValue.getMonth(), datepickerValue.getDate() - datepickerValue.getDay() + 6);
              selectCurrentWeek();
              $(this).data('datepicker').inline = true;
              globalAdditionalFunction(globalTriggeringElement);
              weekchange($('#weekPicker').val(),userid);
          },
          onClose: function() {
              $(this).data('datepicker').inline = false;
          },
          beforeShow: function() {
              selectCurrentWeek();
          },
          beforeShowDay: function(datepickerValue) {
              var cssClass = '';
              if (datepickerValue >= startDate && datepickerValue <= endDate)
                  cssClass = 'ui-datepicker-current-day';
              selectCurrentWeek();
              return [true, cssClass];
          },
          onChangeMonthYear: function(year, month, inst) {
              selectCurrentWeek();
          }
      }).datepicker('widget').addClass('ui-weekpicker');

      $('body').on('mousemove', '.ui-weekpicker .ui-datepicker-calendar tr', function() { $(this).find('td a').addClass('ui-state-hover'); });
      $('body').on('mouseleave', '.ui-weekpicker .ui-datepicker-calendar tr', function() { $(this).find('td a').removeClass('ui-state-hover'); });

      // function for doing something more

  };

  var convertToWeekPicker = function(targetElement) {
      if (targetElement.prop("tagName") == "INPUT" && (targetElement.attr("type") == "text" || targetElement.attr("type") == "hidden")) {
          var week = targetElement.val();
          $('<span class="displayDate" style="display:none">' + week + '</span>').insertBefore(targetElement);
          $('<i class="fa fa-calendar showCalendar" aria-hidden="true" style="cursor:pointer;margin-left: 10px;margin-top: 3px;" onclick="javascript:showWeekCalendar(this)"></i>').insertAfter(targetElement);
          setWeekCalendar(targetElement);
      } else {
          targetElement.replaceWith("<span>ERROR: please control js console</span>");
          console.error("convertToWeekPicker() - ERROR: The target element is not compatible with this conversion, try to use an <input type=\"text\" /> or an <input type=\"hidden\" />");
      }
  };
  
  convertToWeekPicker($("#weekPicker"));

  function getWeekNumber(d) {
    d = new Date(Date.UTC(d.getFullYear(), d.getMonth(), d.getDate()));
    d.setUTCDate(d.getUTCDate() + 4 - (d.getUTCDay()||7));
    var yearStart = new Date(Date.UTC(d.getUTCFullYear(),0,1));
    var weekNo = Math.ceil(( ( (d - yearStart) / 86400000) + 1)/7);
    return [d.getUTCFullYear(), weekNo];
  }

  var result = getWeekNumber(new Date());

  $('#weekPicker').val(result[0]+'-'+result[1]);
  var fecha = $('#weekPicker').val();
  weekchange(fecha, userid);

 
});
</script>