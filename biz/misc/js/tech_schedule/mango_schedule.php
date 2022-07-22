<script>
var search = 'false';
var scheduled_schedule_chk = 'true';
var actual_schedule_chk = 'true';
var confirmation_schedule_chk = 'true';
var duple_sch_chk = 'false';
var isloaded = 'false'; // 미완료 일정 보달 두번 작동하는 것 방지

function company_schedule_check(target) {
  var chk = $('#company_schedule_' + target).prop("checked");
  if (chk) {
    if(target == 'scheduled') {
      scheduled_schedule_chk = 'true';
    } else if (target == 'actual') {
      actual_schedule_chk = 'true';
    } else if (target == 'confirmation') {
      confirmation_schedule_chk = 'true';
    }
    calendarRefresh();
  } else {
    if(target == 'scheduled') {
      scheduled_schedule_chk = 'false';
    } else if (target == 'actual') {
      actual_schedule_chk = 'false';
    } else if (target == 'confirmation') {
      confirmation_schedule_chk = 'false';
    }
    calendarRefresh();
  }
}

// function datepicker_fun(id,date){
//   $('#'+id).datepicker("destroy");
//   // $('#'+id).datepicker({clearBtn : false});
//   var year = date.split('-')[0];
//   var month = date.split('-')[1];
//   var day = date.split('-')[2];
//   var set_date = new Date(year, month-1, day);
//   $('#'+id).datepicker('setDate',set_date);
// }

$(function(){
  $('.timepicker').timepicker({
      minuteStep: 10,
      showMeridian: false
  });
  $('.datepicker').datepicker();
  $('.monthPicker').datepicker({
    format: "yyyy-mm",
    viewMode: "months",
    minViewMode: "months"
  });
})

function openStartDate(e) {
  if (e === 'de') {
    $("#de_startDay").focus();
  } else {
    // $("#startDay").datepicker();
    $("#startDay").focus();
  }
}

function openEndDate(e) {
  if (e === 'de') {
    $("#de_endDay").focus();
  } else {
    // $("#endDay").datepicker();
    $("#endDay").focus();
  }
}

document.addEventListener("DOMContentLoaded", function () {
  var checked_name = [];
  // var checked_name = new Array();
  var events = new Array();
  var jsonEvents = '';
  // var reload = '';

  // 조직도 트리 생성
  $('#tree').jstree({
    "checkbox": {
      "keep_selected_style": false
    },
    'plugins': ["wholerow", "checkbox"],
    'core': {
      'themes': {
        'name': 'proton',
        "icons": false
      }
    },
  }).on('ready.jstree', function () {
    $(this).jstree('open_all');
    // $(this).jstree('check_all');
  });

  $("#tree").bind("changed.jstree", function (e, data) {
    checked_name = [];
    var reg = /^[가-힣]*$/;

    $.each($("#tree").jstree("get_checked", true), function () {
      if (reg.test(this.id)) {
        checked_name.push(this.id);
      }
    })
  });

  $('#j2_1_anchor').trigger('click');

  var initialView_val = '';

   var calendarEl = document.getElementById('calendar');
   var calendar = new FullCalendar.Calendar(calendarEl, {
     googleCalendarApiKey:'AIzaSyBLpSLtCDQOB3mG0eAK1YrAqDjzQIjfeI0',
     locale: 'ko', //언어 설정
     selectable: true,
     editable: true, // 일정 드래그 가능 여부
     eventOverlap: true, //동일 날짜 시간 중복등록 가능
     scrollTime: '08:00', // 포커스 되는 시간
     navLinks: true, //날짜 클릭시 그날 일정으로 가는 거
     dayMaxEvents: 4,
     displayEventTime: false,
     initialView: 'dayGridMonth',
     //버튼 만들기
     customButtons: {
       //일정 추가 버튼
       addSchedule: {
         text: '일정추가',
         click: function() {
            // 초기화 추가!!
            $('#schedule_type').val('');
            $('#startDay').val('');
            $('#endDay').val('');
            // $('#title').val('');
            $('#contents').val('');
            $('#participant').val('');
            $('.user_select').html(option);
            $('#scheduled_batch_month').val('');

            $(".user_select").select2({
               placeholder: '검색어 입력'
            });

            $('#addpopup').bPopup({
              //스크롤 안따라가도록 고정
              follow: [false, false]
            });
            $('#schedule_type').change();
        }
      }
    },
    headerToolbar: {
      left: 'title', //왼쪽버튼
      center: '', //중앙 버튼
      right: 'prev today next addSchedule' //dayGridWeek//오른쪽 버튼
    },
    titleFormat: function(date) {
    	return date.date.year + '년 ' + (date.date.month + 1) + '월';
    },
    eventSources: [{
        googleCalendarId: 'qansohiecib58ga9k1bmppvt5oi65b1q@import.calendar.google.com',
        className: 'koHolidays',
        color: '#ffe3e3',
        // background_color : '#FFF7F7',
        // color : '#ffffff',
        daycolor: 'red',
        textColor: 'red',
        editable: false,
        display: "background",
        eventClick: false
      },
      {
        events: function (info, successCallback, failureCallback) {
          $.ajax({
            url: "<?php echo site_url(); ?>/schedule/events_maker",
            type: "POST",
            dataType: "json",
            data: {
              userArr: checked_name,
              select_start: info.startStr,
              select_end: info.endStr,
              scheduled_schedule_chk: scheduled_schedule_chk,
              actual_schedule_chk: actual_schedule_chk,
              confirmation_schedule_chk: confirmation_schedule_chk,
            },
            success: function (data) {
              successCallback(data);
            }
          });
        }
      }
    ],
    eventDidMount: function (info) { //일정 마우스 오버시 툴팁 창
      var elClass = $(info.el).attr("class");
      if (elClass.indexOf('koHolidays') == -1) {
        var startDay = moment(info.event.start).format('YY-MM-DD');
        var endDay = moment(info.event.end).format('YY-MM-DD');
        var startTime = moment(info.event.start).format('HH:mm');
        var endTime = moment(info.event.end).format('HH:mm');
        var tilde = " ~ ";
        var allDay = "";
        if (endDay == "0000:00:00" || endDay == "Invalid date") {
          endDay = "";
        }
        if (startTime == "Invalid date") {
          startTime = "";
        }
        if (endTime == "Invalid date") {
          endTime = "";
        }
        var icon = 'event_class_type';
        var term = allDay + startDay + " " + startTime + tilde + endDay + " " + endTime;
        var participant = info.event.extendedProps.participant;
        var title_participant = info.event.extendedProps.participant;
        // var sch_title = info.event.extendedProps.title;
        var userName = info.event.extendedProps.user_name + " (" + info.event.extendedProps.insert_date + ")";
        var modifierName = info.event.extendedProps.modifier_name + " (" + info.event.extendedProps.modify_date + ")";
        var schedule_type = info.event.extendedProps.schedule_type;
        if(schedule_type == 'scheduled') {
          schedule_type = '예정';
        } else if (schedule_type == 'actual') {
          schedule_type = '자동';
        } else if (schedule_type == 'confirmation') {
          schedule_type = '확정';
        } else {
          schedule_type = '';
        }

        title_participant = participant.split(',');

        var tooltipTitle = '<h3><span class="event_color_button ' + icon + info.event.extendedProps.work_color_seq + '"></span>&nbsp;[' + schedule_type + '] ' + participant + ' 근무</h3><div>' + term + '</div>';

        tooltipTitle += '<div><span class="text-point">[구&nbsp;&nbsp;&nbsp;&nbsp;분]<span>&nbsp;<span class="text-normal">' + schedule_type + '</span></div>';

        tooltipTitle += '<div><span class="text-point">[참석자]<span>&nbsp;<span class="text-normal">' + participant + '</span></div>';
        tooltipTitle += '<div><span class="text-point">[등록자]<span>&nbsp;<span class="text-normal">' + userName + '</span></div>';
        if(info.event.extendedProps.modifier_id != null){
          tooltipTitle += '<div><span class="text-point">[최종수정자]<span>&nbsp;<span class="text-normal">' + modifierName + '</span></div>';
        }

        var tooltip = new Tooltip(info.el, {
          title: tooltipTitle,
          placement: 'right',
          trigger: 'hover',
          delay: {
            show: 800
          },
          html: true,
          template: '<div class="tooltip tooltip-inner scheduleHint" role="tooltip"></div>',
        });
      }
    },
    //드래그 드랍시 날짜 업데이트
    eventDrop: function (info) {
      var sessionId = '<?php echo $session_id; ?>';
      var sessionName = '<?php echo $session_name; ?>';
      var sessionAdmin = '<?php echo $session_admin; ?>';

      if ((sessionId == info.event.extendedProps.user_id) || (sessionAdmin == 'Y') || (info.event.extendedProps.participant.indexOf(sessionName) > -1)) {
        var seq = info.event.id;
        var startDay = moment(info.event.start).format('YY-MM-DD');
        var startTime = moment(info.event.start).format('HH:mm');
        var endDay = moment(info.event.end).format('YY-MM-DD');
        var endTime = moment(info.event.end).format('HH:mm');
        var participant = info.event.extendedProps.participant;
        var schedule_type = info.event.extendedProps.schedule_type;

        if(schedule_type == 'actual') {
          alert('자동 일정은 수정이 불가능합니다.');
          info.revert();
          return false;
        }

        $.ajax({
          type: 'POST',
          url: "<?php echo site_url(); ?>/schedule/drop_update",
          data: {
            seq: seq,
            start_day: startDay,
            start_time: startTime,
            end_day: endDay,
            end_time: endTime,
            participant: participant
          },
          cache: false,
          async: false,
          success: function (data) {
            if (data == 'OK') {
              calendar.refetchEvents();
            }
          }
        });

      } else {
        alert("권한이 없습니다.");
        info.revert();
        return false;
      }
    },
    //이벤트 리사이즈시 날짜 시간 업데이트
    eventResize: function (info) {
      var sessionId = '<?php echo $session_id; ?>';
      var sessionName = '<?php echo $session_name; ?>';
      var sessionAdmin = '<?php echo $session_admin; ?>';

      if ((sessionId == info.event.extendedProps.user_id) || (sessionAdmin == 'Y') || (info.event.extendedProps.participant.indexOf(sessionName) > -1)) {
        var seq = info.event.id;
        var startDay = moment(info.event.start).format('YY-MM-DD');
        var startTime = moment(info.event.start).format('HH:mm');
        var endDay = moment(info.event.end).format('YY-MM-DD');
        // var endDay = moment(info.event.end).subtract(1, 'days').format('YY-MM-DD');
        var endTime = moment(info.event.end).format('HH:mm');
        var participant = info.event.extendedProps.participant;

        var schedule_type = info.event.extendedProps.schedule_type;

        if(schedule_type == 'actual') {
          alert('자동 일정은 수정이 불가능합니다.');
          info.revert();
          return false;
        }

        $.ajax({
          type: 'POST',
          url: "<?php echo site_url(); ?>/schedule/drop_update",
          data: {
            seq: seq,
            start_day: startDay,
            start_time: startTime,
            end_day: endDay,
            end_time: endTime,
            participant: participant
          },
          cache: false,
          success: function (data) {
            if (data == 'OK') {
              calendar.refetchEvents();
            }
          }
        });

      } else {
        alert("권한이 없습니다.");
        info.revert();
        return false;
      }
    },
    select: function(info) {
      // 날짜 클릭해서 일정 등록

      $('#schedule_type').val('');
      $('#startDay').val('');
      $('#endDay').val('');
      // $('#title').val('');
      $('#contents').val('');
      $('#participant').val('');
      $('.user_select').html(option);

      $(".user_select").select2({
         placeholder: '검색어 입력'
      });

      var startStr = moment(info.startStr).format('YYYY-MM-DD');
      var startTime = moment(info.startStr).format('HH:mm');
      if (startTime == "00:00") {
        startTime = moment().format('HH:mm');
      }

      var endStr = moment(info.endStr).subtract(1, 'days').format('YYYY-MM-DD');
      var endTime = moment(info.endStr).format('HH:mm');
      if (endTime == "00:00") {
        endTime = moment().add(1, 'h').format('HH:mm');
      }
      if (moment(endStr).diff(moment(startStr), 'days') < 0) {
        endStr = startStr;
      }
      // datepicker_fun('startDay',startStr)
      $('#startDay').val(startStr);
      $('#startTime').val(startTime);
      // datepicker_fun('endDay',endStr);
      $('#endDay').val(endStr);
      $('#endTime').val(endTime);

      $('#contents').val('');
      // $('#title').val('');

      $('#scheduled_batch_month').val('');

      $('#addpopup').bPopup({
        //스크롤 안따라가도록 고정
        follow: [false, false]
      });
      $('#schedule_type').change();
    },
    eventClick: function(info) { //일정 클릭시 이벤트 상세페이지 이동
      $('#de_startDay').val('');
      $('#de_endDay').val('');
      // $('#de_title').val('');
      $('#de_contents').val('');
      $('#de_participant').val('');
      // $('#de_startTime, #de_endTime').timepicker({
      //     minuteStep: 10,
      //     showMeridian: false
      // });

      var seq = info.event.id;
      $.ajax({
        type: 'GET',
        dataType : "json",
        url: "<?php echo site_url(); ?>/schedule/schedule_detail",
        data:{
          seq: seq
        },
        cache:false,
        }).done(function(result){
          if(result){
            $('#updateSchedule').bPopup({
              //스크롤 안따라가도록 고정
               follow : [false, false]
            });
            console.log(result);
            $('#de_startTime').show();
            $('#de_endTime').show();
            //내용분할2
            // console.log(result);
            var details = result.details;
            var contents = result.contents;

            var seq = details.seq;

            var start_day = details.start_day;
            var start_time = moment(details.start_time, 'HH:mm').format('HH:mm');
            // var start_time = details.start_time;
            var end_day = details.end_day;
            var end_time = moment(details.end_time, 'HH:mm').format('HH:mm');
            // var end_time = details.end_time;
            var schedule_type = details.schedule_type;
            // var title = details.title;
            var user_id = details.user_id;
            var user_name = details.user_name;
            var contents = details.contents;

          $('#de_seq').val(seq);
          $('#de_schedule_type').val(schedule_type);
          $('#de_startDay').val(start_day);
          // datepicker_fun('de_startDay',start_day);
          $('#de_startTime').val(start_time);
          $('#de_endDay').val(end_day);
          // datepicker_fun('de_endDay',end_day);
          $('#de_endTime').val(end_time);
          $('#de_contents').val(contents);
          // $('#de_title').val(title);

          var participant = details.participant;
          var participant_seq = details.participant_seq;
          var select_val = [];

          participant_arr = participant.split(',');
          participant_seq_arr = participant_seq.split(',');

          var participant_val = '';
// console.log(participant_arr);
// console.log(participant_seq_arr);
          for(j=0; j<participant_arr.length; j++) {
            if(j>0) {
              participant_val += ',';
            }
            participant_val += participant_arr[j] + ' ' + participant_seq_arr[j];
            select_val.push(participant_arr[j] + ' ' + participant_seq_arr[j]);
          }

          $('#de_participant_select').val(select_val).trigger('change');
          $('#de_participant').val(participant_val);
        }

        var session_admin = $('#session_admin').val();

        if(session_admin == 'Y' && schedule_type == 'actual') {
          $('#confirmSubmit').show();
          $('#updateSubmit').hide();
          $('#de_startDay').attr('readonly', true);
          $('#de_endDay').attr('readonly', true);
          $("#de_participant_select").attr("readonly", 'readonly');
        } else {
          $('#confirmSubmit').hide();
          $('#updateSubmit').show();
          $('#de_startDay').attr('readonly', false);
          $('#de_endDay').attr('readonly', false);
          $("#de_participant_select").removeAttr('readonly');
        }
      });
    },
  });
  calendar.render();

  calendarRefresh = function () {
    calendar.refetchEvents();
  }
  calendarChangeView = function () {
    calendar.changeView('listYear');
  }
  $("#tree").click(function () {
    calendarRefresh();
  })

  sch_insert = function (mode, type) {

    if ($('#'+mode+'schedule_type').val() == '') {
      alert('일정 구분을 선택해주세요.');
      $('#'+mode+'schedule_type').focus();
      return false;
    }

    if ($('#'+mode+'schedule_type').val() != 'scheduled_batch') {

      if ($('#'+mode+'startDay').val() == '') {
        alert('시작날짜를 입력해주세요.');
        $('#'+mode+'startDay').focus();
        return false;
      }
      if ($('#'+mode+'endDay').val() == '') {
        alert('종료날짜를 입력해주세요.');
        $('#'+mode+'endDay').focus();
        return false;
      }
      if ($('#'+mode+'startTime').val() == '') {
        alert('시작시간을 입력해주세요.');
        $('#'+mode+'startTime').focus();
        return false;
      }
      if ($('#'+mode+'endTime').val() == '') {
        alert('종료시간을 입력해주세요.');
        $('#'+mode+'endTime').focus();
        return false;
      }
      // if ($('#'+mode+'title').val() == '') {
      //   alert('제목을 입력해주세요.');
      //   $('#'+mode+'title').focus();
      //   return false;
      // }
      if(($('#'+mode+'participant').val() == '')){
        alert('참석자를 선택해주세요.');
        $('#'+mode+'participant').focus();
        return false;
      }

      var seq = $('#'+mode+'seq').val();
      var schedule_type = $('#'+mode+'schedule_type').val();
      var startDay = $('#'+mode+'startDay').val();
      var startTime = $('#'+mode+'startTime').val();
      var endDay = $('#'+mode+'endDay').val();
      var endTime = $('#'+mode+'endTime').val();
      // var title = $('#'+mode+'title').val();
      var contents = $('#'+mode+'contents').val();
      var participant_val = $('#'+mode+'participant').val();
      var participant = '';
      var participant_seq = '';

      var participant_arr = participant_val.split(',');
      for(i=0; i<participant_arr.length; i++) {
        if(i>0) {
          participant += ',';
          participant_seq += ',';
        }
        participant += participant_arr[i].split(' ')[0];
        participant_seq += participant_arr[i].split(' ')[1];
      }

      var startTime_2 = moment(startTime, 'HH:mm').format('HH:mm');
      var endTime_2 = moment(endTime, 'HH:mm').format('HH:mm');
      if (startTime_2 == '' && endTime_2 != '') {
        alert("시작시간을 먼저 작성해 주세요.");
        $('#'+mode+'endTime').val('');
        return false;
      }
      if ((startDay == endDay) && (startTime_2 > endTime_2)) {
        alert("종료시간이 시작시간보다 이전입니다.");
        $('#'+mode+'endTime').val('');
        return false;
        stopPropagation();
      }

      if(type == 'confirm') {
        seq = '';
        schedule_type = 'confirmation';
      }

      $.ajax({
        type: "POST",
        url: "<?php echo site_url(); ?>/schedule/add_schedule",
        dataType: "json",
        data: {
          seq: seq,
          schedule_type: schedule_type,
          startDay: startDay,
          startTime: startTime,
          endDay: endDay,
          endTime: endTime,
          participant: participant,
          participant_seq: participant_seq,
          // title: title,
          contents: contents,
        },
        cache: false,
        async: false,
        success: function (data) {
          if (data == 'false') {
            result = 'false';
          }
          alert("등록되었습니다.");
          if(mode == ''){
            $('#addpopup').bPopup().close();
          }else{
            $('#updateSchedule').bPopup().close();
          }
          duple_sch_chk = 'false';
          calendarRefresh();
        },
        error: function (request, status, error) {
          alert("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);
        }
      });

    } else {

      if($('#scheduled_batch_month').val() == '') {
        alert('일괄 등록할 월을 선택해주세요.');
        $('#scheduled_batch_month').focus();
        return false;
      }
      if(($('#'+mode+'participant').val() == '')) {
        alert('참석자를 선택해주세요.');
        $('#'+mode+'participant').focus();
        return false;
      }

      for(i = 0; i < 5; i++) {
        var stime = $('#user_work_start_' + i).val();
        var etime = $('#user_work_end_' + i).val();

        if($.trim(stime) == '' && $.trim(etime) != '') {
          alert('근무 시작시간을 입력해주세요.');
          $('#user_work_start_' + i).focus();
          return false;
        }
        if($.trim(etime) == '' && $.trim(stime) != '') {
          alert('근무 종료시간을 입력해주세요.');
          $('#user_work_end_' + i).focus();
          return false;
        }
      }

      var seq = $('#'+mode+'seq').val();
      var schedule_type = $('#'+mode+'schedule_type').val();
      var contents = $('#'+mode+'contents').val();
      var participant_val = $('#'+mode+'participant').val();
      var participant = '';
      var participant_seq = '';
      var scheduled_batch_month = $('#scheduled_batch_month').val();
      var start_time = [];
      var end_time = [];

      for(i = 0; i < 5; i++) {
        var stime = $('#user_work_start_' + i).val();
        var etime = $('#user_work_end_' + i).val();

        start_time.push(stime);
        end_time.push(etime);
      }

      var participant_arr = participant_val.split(',');
      for(i=0; i<participant_arr.length; i++) {
        if(i>0) {
          participant += ',';
          participant_seq += ',';
        }
        participant += participant_arr[i].split(' ')[0];
        participant_seq += participant_arr[i].split(' ')[1];
      }

      $.ajax({
        type: "POST",
        url: "<?php echo site_url(); ?>/schedule/add_scheduled_batch",
        dataType: "json",
        data: {
          seq: seq,
          schedule_type: schedule_type,
          participant: participant,
          participant_seq: participant_seq,
          contents: contents,
          scheduled_batch_month: scheduled_batch_month,
          start_time: start_time,
          end_time: end_time
        },
        cache: false,
        async: false,
        success: function (data) {
          if (data == 'false') {
            result = 'false';
          }
          alert("등록되었습니다.");
          if(mode == ''){
            $('#addpopup').bPopup().close();
          }else{
            $('#updateSchedule').bPopup().close();
          }
          duple_sch_chk = 'false';
          calendarRefresh();
        },
        error: function (request, status, error) {
          alert("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);
        }
      });

    }

  };

});

// 엑셀 다운로드
function excelExport() {
  $(".fc-listYear-button").trigger("click");
  var date = $(".fc-toolbar-title").text();
  var title = "일정 리스트_" + date;

  var tab_text = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
  tab_text = tab_text + '<head><meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">';
  tab_text = tab_text + '<xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>'
  tab_text = tab_text + '<x:Name>Test Sheet</x:Name>';
  tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:Panes></x:WorksheetOptions></x:ExcelWorksheet>';
  tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>';
  tab_text = tab_text + "<table border='1px'>";

  var exportTable = $(".fc-list-table").clone();
  exportTable.find(".tooltip").remove();
  exportTable.find('.fc-list-event-graphic').remove();
  exportTable.find('.fc-list-day-cushion').css("text-align", "left");
  exportTable.find("th").attr("colspan", 2);
  exportTable.find(".fc-list-day-text").each(function () {
    $(this).text($(this).text() + " ");
  })
  exportTable.find('input').each(function (index, elem) {
    $(elem).remove();
  });

  tab_text = tab_text + exportTable.html();
  tab_text = tab_text + '</table></body></html>';

  var data_type = 'data:application/vnd.ms-excel';
  var ua = window.navigator.userAgent;
  var msie = ua.indexOf("MSIE ");
  var fileName = title + '.xls';
  //Explorer 환경에서 다운로드
  if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
    if (window.navigator.msSaveBlob) {
      var blob = new Blob([tab_text], {
        type: "application/csv;charset=utf-8;"
      });
      navigator.msSaveBlob(blob, fileName);
    }
  } else {
    var blob2 = new Blob([tab_text], {
      type: "application/csv;charset=utf-8;"
    });
    var filename = fileName;
    var elem = window.document.createElement('a');
    elem.href = window.URL.createObjectURL(blob2);
    elem.download = filename;
    document.body.appendChild(elem);
    elem.click();
    document.body.removeChild(elem);
  }
}

function addUser_Btn() {
  $('#addUserpopup').bPopup({
    follow: [false, false]
  });
}

function closeBtn() {
  $('#addUserpopup').bPopup().close();
}

function tooltip(el) {
  var tdClass = $(el).attr('class');
  if (tdClass == "reserved") {
    var tooltip = $(el).find(".tooltip-content");
    tooltip.css('visibility', 'visible');
  }
}

function tooltip_remove(el) {
  var tdClass = $(el).attr('class');
  if (tdClass == "reserved") {
    var tooltip = $(el).find(".tooltip-content");
    tooltip.css('visibility', 'hidden');
  }
}

// 참석자 조직도 트리 생성
var checked_text = [];
$(function () {
  $('#usertree').jstree({
    "checkbox": {
      "keep_selected_style": false
    },
    'plugins': ["wholerow", "checkbox"],
    'core': {
      'themes': {
        'name': 'proton',
        "icons": false
      }
    }
  });
  $("#usertree").bind("changed.jstree", function (e, data) {
    var reg = /^[가-힣]*$/;
    checked_text.length = 0;
    $.each($("#usertree").jstree("get_checked", true), function () {
      if (reg.test(this.id)) {
        // checked_text.push(this.text); //$$
        //조직도 선택자 안에 li_arrt요소에 넣어놓은 id와 seq 값을 가져온다(view파일 jstree생성하는 부분에서 만들어놓음)
        checked_text.push({'name':this.li_attr.id, 'seq':this.li_attr.seq}); //$$
        // console.log(this);
      }
    })
  });
});

//참석자 중복제거 함수
function unique(array) {
  var result = [];
  $.each(array, function (index, element) {
    if ($.inArray(element, result) == -1) {
      result.push(element);
    }
  });
  return result;
}

// 참석자 추가
function addUser(idVal) {
  if (idVal == 'searchChosenBtn') {
    var noneOverlapArr = unique(checked_text_select);
    var searchAdduser = noneOverlapArr.join(",");
    $('#searchText').val('');
    $('#searchText').val(searchAdduser);
    $('#searchAddUserpopup').bPopup().close(); //모달 닫기
  } else {
    var noneOverlapArr = multiDimensionalUnique(checked_text); //$$

    $('#participant_box').html('');
    $('#participant').val('');
    $('#de_participant_box').html('');
    $('#de_participant').val('');
    insert_span_user_name(noneOverlapArr, 'participant')
    insert_span_user_name(noneOverlapArr, 'de_participant')

    $('#addUserpopup').bPopup().close(); //모달 닫기
  }
}

//엔터키로 검색
function onFoc(objId) {
  $("#" + objId).keydown(function (event) {
    if (event.keyCode == 13) {
      $("#searchBtn").click();
      return false;
    }
  });
}

function searchAddUserBtn() {
  $('#searchAddUserpopup').bPopup({
    follow: [false, false]
  });
}

function searchCloseBtn() {
  $('#searchAddUserpopup').bPopup().close();
}

// 참석자 검색 시 조직도 트리 생성
var checked_text_select = [];
$(function () {
  $('#search-usertree').jstree({
    "checkbox": {
      "keep_selected_style": false
    },
    'plugins': ["wholerow", "checkbox"],
    'core': {
      'themes': {
        'name': 'proton',
        'icons': false
      }
    }
  });
  $("#search-usertree").bind("changed.jstree", function (e, data) {
    var reg = /^[가-힣]*$/;
    checked_text_select.length = 0;
    $.each($("#search-usertree").jstree("get_checked", true), function () {
      if (reg.test(this.id)) {
        checked_text_select.push(this.id);
        // checked_text_select.push(this.text);
      }
    })
  });
});

$(document).ready(function () {
  // $(".koHolidays").css({'background-color' : 'black'});
  var agent = navigator.userAgent.toLowerCase();

  if ((navigator.appName == 'Netscape' && navigator.userAgent.search('Trident') != -1) || (agent.indexOf("msie") != -1)) {
    $("#body_contain").css("height", "1050px");
  }

});

function date_compare(type) {
  var startDate = $('#' + type + 'startDay').val();
  var endDate = $('#' + type + 'endDay').val();

  if (startDate == '' && endDate != '') {
    alert("시작일자를 먼저 작성해 주세요.");
    $('#' + type + 'endDay').val('');
    return false;
  }

  var startArray = startDate.split('-');
  var endArray = endDate.split('-');
  var start_date = new Date(startArray[0], startArray[1], startArray[2]);
  var end_date = new Date(endArray[0], endArray[1], endArray[2]);
  if (start_date > end_date) {
    alert("종료일자가 시작일자보다 이전입니다.");
    $('#' + type + 'endDay').val('');
    return false;
  }
}

//검색으로 참석자 찾아서 추가
function keypress(event, value, id) {
  // console.log(event);
  if (event.keyCode == 13 || event == 13) {
    // if(event.keyCode == 13){
    if (value == '' || value == null) {
      alert("검색어가 없습니다.");
      return false;
    }
    // alert(13);
    $.ajax({
      type: 'post',
      dataType: "json",
      url: "/index.php/biz/schedule/search_entered_participant",
      data: {
        val: value
      },
      cache: false,
      // async:false
      success: function (data) {
        if (data === 'false') {
          alert("검색된 사용자가 없습니다.");
          $('#' + id + '_input').val('');
        } else {
          var user_name_arr = [];
          for (var i = 0; i < data.length; i++) {
            user_name_arr.push({'name':data[i].user_name, 'seq':data[i].seq}); //$$
          }
          insert_span_user_name(user_name_arr, id)
          user_name_arr = [];
        }
      }
    });
  }
}

//검색한 참석자 이름 span으로 보이게 추가하기
function insert_span_user_name(data, id) {
  if (data === 'false') {
    alert("검색된 사용자가 없습니다.");
    $('#' + id + '_input').val('');
    // }else if(data === 'too many participant'){
    //   $('#addUserpopup').bPopup();
  } else {

    var old_hidden_val = '';
    // var old_hidden_val = $('#'+id).val();
    var new_hidden_val = '';
    var old_val = $('#' + id + '_box').html();
    var new_val = '';

    for (var i = 0; i < data.length; i++) {
      // console.log(data);
      old_hidden_val = $('#' + id).val();
      var indexOf_val = old_hidden_val.indexOf(data[i]['name'] + '_' + data[i]['seq'])
      if (indexOf_val >= 0) {
        $('#' + id + '_input').val('');
        // return false;
        continue;
      }
      // if(indexOf_val  > -1){
      //
      new_val += '<span class="tag participant-box"><span>';
      new_val += data[i]["name"];
      new_val += '</span>&nbsp;<a id="a' + data[i]["name"] + '" seq="' + data[i]["seq"] + '" onclick="delete_this_user_name(this.id,' + "'" + id + "'" + ')" class="participant-box-close" style="cursor:pointer;" value="' + data[i]["name"] + '"><img src="<?php echo $misc; ?>/img/participant-x.svg"style="height:14px;"></a></span>';

      if (old_hidden_val == '') {
        new_hidden_val += data[i]['name'] + '_' + data[i]['seq'];
      } else {
        new_hidden_val += old_hidden_val;
        new_hidden_val += ',';
        new_hidden_val += data[i]['name'] + '_' + data[i]['seq'];
      }
      // total_hidden_val = old_hidden_val+new_hidden_val;
      // $('#'+id).val(total_hidden_val);

      $('#' + id).val(new_hidden_val);
      new_hidden_val = '';
      $('#usertree').jstree('select_node', data[i]['name']);
    }

    var total_val = old_val + new_val;
    // var total_hidden_val = old_hidden_val+new_hidden_val;

    $('#' + id + '_box').html(total_val);
    // $('#'+id).val(total_hidden_val);
    $('#' + id + '_input').val('');
    // console.log("new "+new_hidden_val);
    // console.log("total "+$('#'+id).val());
    // alert($('#'+id).val());
  }
}

//참석자 x로 삭제
function delete_this_user_name(this_id, input_id) {
  var p_span = $('#' + this_id).parent('span');
  //a태그에는 value값이 없어서 .value로 받아올 수 없기에 임의의 'value'를 지정해 해당 값을 받아온다.
  var name = $('#' + this_id).attr('value'); //$$
  var seq = $('#' + this_id).attr('seq'); //$$
  var n_span = name + '_' + seq; //$$

  var participant = $('#' + input_id).val();
  // var participant = $('#'+input_id.id).val();
  // split(explode)로 문자열을 ','로 나눠서 배열로 만들기
  var split_participant = participant.split(',');
  // var ex_participant = explode(',',participant);
  // 필터함수로 participant에서 삭제할 이름을 제거
  var filter_participant = split_participant.filter(function (element) {
    return element !== n_span
  });
  // var filter_participant = split_participant.filter((element) => element !== n_span);
  // join(implode)로 배열을 다시 ','로 구분한 문자열로 만들기
  var join_participant = filter_participant.join(',');
  // console.log(join_participant);

  $('#' + input_id).val(join_participant);
  // console.log($('#'+input_id.id).val());
  $('#usertree').jstree('deselect_node', n_span);
  p_span.remove();
}

//이중배열 중복제거 함수
function multiDimensionalUnique(arr) {
    var uniques = [];
    var itemsFound = {};
    for(var i = 0, l = arr.length; i < l; i++) {
        var stringified = JSON.stringify(arr[i]);
        if(itemsFound[stringified]) { continue; }
        uniques.push(arr[i]);
        itemsFound[stringified] = true;
    }
    return uniques;
}

let first = 10;
let second = 20;
let result = 0;

function add (x, y) {
  return x + y
}

function getResult(callback) {
  setTimeout(function(){
    result = add(first, second);
    // console.log(result);
    callback()
  },500)
}

getResult(function(){
  first = 20;
  result = add(first,second);
})

function delete_schedule() {
  if(confirm("해당 일정을 삭제하시겠습니까?")) {
    $.ajax({
      url: "<?php echo site_url(); ?>/schedule/delete_schedule",
      type: "POST",
      dataType: "json",
      data: {
        seq: $('#de_seq').val(),
      },
      success: function (data) {
        if(data) {
          alert('삭제되었습니다.');
          calendarRefresh();
          $('#updateSchedule').bPopup().close();
        }
      }
    });
  }
}

function change_schedule_type(el) {
  var val = $(el).val();

  if(val == 'scheduled_batch') {
    $('.scheduled_batch').show();
    $('.add_common').hide();
    $('#participant_select').change();
  } else {
    $('.add_common').show();
    $('.scheduled_batch').hide();
  }

}

function make_timeTable(el) {
  var val = $(el).val();

  var user_seq = val.split(' ')[1];

  if($('#schedule_type').val() == 'scheduled_batch') {
    $('.time_table').show();

    for(i=0; i<5; i++) {
      $('#user_work_start_' + i).val('');
      $('#user_work_end_' + i).val('');
    }

    $.ajax({
      url: "<?php echo site_url(); ?>/schedule/make_timeTable",
      type: "POST",
      dataType: "json",
      data: {
        user_seq: user_seq
      },
      success:function(data) {
        if(data) {
          var work_start = data.work_start;
          var work_end = data.work_end;
          work_start = work_start.split('*/*');
          work_end = work_end.split('*/*');
          for(i=0; i<5; i++) {
            if(work_start[i] != '' && work_end[i] != '') {
              $('#user_work_start_' + i).val(work_start[i]);
              $('#user_work_end_' + i).val(work_end[i]);
            }
          }
        }
      }
    })
  } else {
    $('.time_table').hide();
  }
}

</script>
