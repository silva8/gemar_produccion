<?php
  session_start();
  require_once dirname(__FILE__) . "/../../include/lib.php";
  if($_SESSION['user_role'] == 1){
?>

<link href="js/plugins/monthpicker/MonthPicker.css" type="text/css" rel="stylesheet"
  media="screen,projection">
<link href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" />
<!--jsgrid css-->
  <link href="js/plugins/jsgrid/css/jsgrid.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="js/plugins/jsgrid/css/jsgrid-theme.min.css" type="text/css" rel="stylesheet" media="screen,projection">
 
<!--start container-->
<div class="container">
  <div class="section">
    <div class="col s12">
      <ul id="task-card" class="collection with-header">
          <li class="collection-header light-blue darken-3">
              <div class="row">
                <h4 class="col task-card-title">Reporte de Status Semanal</h4>

                <div class="header-search-wrapper white-text">
                  <i class="mdi-action-today"></i>
                  <input id="weekPicker" type="text" class="header-search-input"/>
                </div>

              </div>
          </li>
      </ul>
      <!-- Js Grid -->
      <div id="jsGrid-logs"></div>
      <div id="appendLogs">



      </div>

    </div>
  </div>
</div>
<?php   
  }
?> 
<!--jsgrid-->

  <script type="text/javascript" src="js/plugins/jquery-ui.js"></script>
  <script type="text/javascript" src="js/plugins/jsgrid/js/jsgrid.min.js"></script>
  <script type="text/javascript" src="js/plugins/jsgrid/js/i18n/jsgrid-es.js"></script>  
  <script type="text/javascript" src="js/plugins/jsgrid/js/jsgrid-script-logs.js" empresaid="<?php echo $_REQUEST['id'];?>"></script>

<script type="text/javascript" src="js/plugins/jquery-ui.js"></script> 
<script>
$( document ).ready(function() {

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
            startDate = new Date(datepickerValue.getFullYear(), datepickerValue.getMonth(), datepickerValue.getDate() - datepickerValue.getDay() +1).getTime();
            endDate = new Date(datepickerValue.getFullYear(), datepickerValue.getMonth(), datepickerValue.getDate() - datepickerValue.getDay() + 7).getTime();
            selectCurrentWeek();
            $(this).data('datepicker').inline = true;
            globalAdditionalFunction(globalTriggeringElement);
            //$('#ui-datepicker-div').hide();
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

  //populate hojas de tiempo
  var curr = new Date; // get current date
  var first = curr.getDate() - curr.getDay() +1; // First day is the day of the month - the day of the week
  var last = first + 6; // last day is the first day + 6


  var startDate = new Date(curr.setDate(first)).getTime();
  var endDate = new Date(curr.setDate(last)).getTime();

console.log(startDate);
console.log(endDate);

});
</script>