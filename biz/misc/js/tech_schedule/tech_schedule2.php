<script>
var search = 'false';
var company_schedule_chk = 'true';
var duple_sch_chk = 'false';
var isloaded = 'false'; // 미완료 일정 보달 두번 작동하는 것 방지

var mobile = "<?php echo $this->agent->is_mobile(); ?>";

//날짜선택 달력으로 표시
// $(function(){
//   $("#startDay, #endDay, #de_startDay, #de_endDay").datepicker({
//     clearBtn : false
//   });
// });

//달력 클릭했을 때 해당 날짜가 datepicker에서 자동으로 선택되어 있도록 하는 함수
//(val()로 값만 주는게 아니라 datepicker에서 선택되는 것)
function datepicker_fun(id,date){
  $('#'+id).datepicker("destroy");
  // $('#'+id).datepicker({clearBtn : false});
  var year = date.split('-')[0];
  var month = date.split('-')[1];
  var day = date.split('-')[2];
  var set_date = new Date(year, month-1, day);
  $('#'+id).datepicker('setDate',set_date);
}

<?php if(!$this->agent->is_mobile()){?>
$(function(){
  $('#startTime, #endTime, #de_startTime, #de_endTime').timepicker({
      minuteStep: 10,
      // template: 'modal',
      // appendWidgetTo: 'body',
      // showSeconds: true,
      showMeridian: false
      // defaultTime: false
  });
})


function openStartDate(e) {
  if (e === 'de') {
    $("#de_startDay").focus();
  } else {
    $("#startDay").datepicker();
    $("#startDay").focus();
  }
}

function openEndDate(e) {
  if (e === 'de') {
    $("#de_endDay").focus();
  } else {
    $("#endDay").datepicker();
    $("#endDay").focus();
  }
}
<?php } ?>
// 종일 버튼 누를시 시간선택 숨기기
function hideTime() {
  // var oldStartTime =
  if ($("input:checkbox[name='alldayCheck']").is(":checked") == true) {

    $("#startTime, #startTimeBtn, #endTime, #endTimeBtn").hide();
    $("#startTime, #endTime").val("00:00");

  } else {
    $("#startTime, #startTimeBtn, #endTime, #endTimeBtn").show();
  }
}

function de_hideTime() {
  // var oldStartTime =
  if ($("input:checkbox[name='de_alldayCheck']").is(":checked") == true) {

    $("#de_startTime, #de_startTimeBtn, #de_endTime, #de_endTimeBtn").hide();
    $("#de_startTime, #de_endTime").val("00:00");

  } else {
    $("#de_startTime, #de_startTimeBtn, #de_endTime, #de_endTimeBtn").show();
  }
}


document.addEventListener("DOMContentLoaded", function () {
  var session_name = $('#session_name').val();
  var checked_name = [session_name];
  // var checked_name = new Array();
  var events = new Array();
  var jsonEvents = '';
  // var reload = '';

  // 조직도 트리 생성
  var session_name = $('#session_name').val();
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
    $(this).jstree('close_all');
    var pgroup = $(this).jstree(true).get_node(session_name).parent;

    $(this).jstree('open_node', pgroup);
    $(this).jstree('select_node', session_name);
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

  var initialView_val = '';

   var calendarEl = document.getElementById('calendar');
   var calendar = new FullCalendar.Calendar(calendarEl, {
     // googleCalendarApiKey:'AIzaSyBLpSLtCDQOB3mG0eAK1YrAqDjzQIjfeI0',
     locale: 'ko', //언어 설정
     selectable: true,
     // selectHelper: true,
     editable: true, // 일정 드래그 가능 여부
     // aspectRatio: 1.8,
     eventOverlap: true, //동일 날짜 시간 중복등록 가능
     scrollTime: '08:00', // 포커스 되는 시간
     navLinks: true, //날짜 클릭시 그날 일정으로 가는 거
     // dayMaxEventRows: true,
     // dayMaxEvent: true,
     // dayMaxEventRows: 5,
     dayMaxEvents: 4,
     displayEventTime: false,
     initialView: 'dayGridMonth',
     // initialView: initialView_val,
     // dayMaxEvent: true,
     //버튼 만들기
     customButtons: {
       //일정 추가 버튼
       addSchedule: {
         text: '일정추가',
         click: function() {
           //KI1 20210125 새로 일정을 불렀을 때 이전 입력내용 삭제
          //  $('#startDay').val('');
           $('#startTime').val('');
          //  $('#endDay').val('');
           $('#endTime').val('');
           $('#workname').val('');
           $('#customerName').val('');
           $('#customerName2').val('');
           //KI1 20210208
           $('#customerName').css('border-color','#00ff0000');
           $('#customerName').attr('readonly',true);
           // $('#tech_report').val('');
           //KI1 20210208
           $('#project').val('');
           $('#customer').val('');
           $('#supportMethod').val('');
           $('#participant').val('');
           $('#contents').val('');
           $('#customer_manager').val('');
           $('#customer').val('');
           $('#visitCompany').val('');
           $('#forcasting_seq').val('');
           $('#maintain_seq').val('');
           // $('#insertDirect').val(''); //직접입력부분(포캐스팅 고객사형으로 변경되어서 사용하지 않음)
           $('#room_name').val('')
           $('#car_name').val('')
           $('#title').val('');
           $('#place').val('');
           $('.tech_div').hide();
           $('.sales_div').hide();
           $('.general_div').show();
           $('.except_nondisclosure_div').show();
           $('.report_div').hide();
           $('.explanation_div').hide();
           $('#dev_type').val('');
           $('#dev_page').val('');
           $('#dev_requester').val('');
           $('#dev_develop').val('');
           $('.lab_contents_tr').hide();
           $('#dev_complete').prop('checked',false);
           $("#contents_tr_0").show();
           $('.except_company_div').show();
           $('input:checkbox[name=add_weekly_report]').prop('checked',false);
           $('#nondisclosure_sch').prop('checked',false);
           if($("#myDropdown").is(':visible')){ //드롭박스가 열려있을 경우(true)
            $("#myDropdown").toggle();
          }

          //참여자에 본인 자동으로 입력
          $('#participant_box').html('');
          $('#usertree').jstree("deselect_all");
          $('#usertree').jstree("close_all");
          keypress(13, session_name, 'participant')

          //반복일정 recurring
          $("#recurring_select option:eq(0)").prop("selected", true);
          $("#recurring_select_ex option:eq(0)").prop("selected", true);
          $('#recurring_check').prop('checked',false);
          change_recurring_select_ex('');
          // change_recurring_check('');
          var startDay = $('#startDay').val()
          var startStr =  moment(startDay).format('YYYY-MM-DD');
          recurring_form('', startStr);

          //KI2 20210125
          contents_split_type('1');
          $("#contents_0").val('');
          var contents_length = $("textarea[name=contents]").length;
          for (i = 1; i < contents_length; i++) {
            $("#contents_tr_" + i).remove();
          }
          // if (!mobile) {
            $('#addpopup').bPopup({
              //스크롤 안따라가도록 고정
              follow: [false, false]
            });
          // } else {
          //   return false;
          // }
        }
      }
    },
    headerToolbar: {
      left: 'today prev,next', //왼쪽버튼
      center: 'title', //중앙 버튼
      right: 'addSchedule dayGridMonth,listMonth timeGridWeek,listWeek timeGridDay,listDay' //dayGridWeek//오른쪽 버튼
    },
    eventSources: [
      {
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
          // console.log(info);
          if (search == 'true') {
            var searchOpt = $('#searchSelect').val();
            if ($('#searchText').val() != '') {
              var segment = $('#searchText').val();
              var spanceKey = /^\s+|\s+$/g;
              sement = segment.replace(spanceKey, '');

              if (searchOpt == 'participant') {
                $('#search-usertree').jstree('deselect_all');
                var split_segment = segment.split(',');
                for (var i = 0; i < split_segment.length; i++) {
                  $('#search-usertree').jstree('select_node', split_segment[i]);
                }
              }
            } else if ($('#work_nameSelect').val() != '') {
              var segment = $('#work_nameSelect').val();
            } else if ($('#support_methodSelect').val() != '') {
              var segment = $('#support_methodSelect').val();
            } else if ($('#customerSelect').val() != '') {
              var segment = $('#customerSelect').val();
            }


            $.ajax({
              type: "POST",
              dataType: 'json',
              url: "/index.php/biz/schedule/events_maker",
              data: {
                searchOpt: searchOpt,
                segment: segment,
                search: search
              },
              success: function (data, textStatus) {

                successCallback(data);
              },
              error: function (jqXHR, textStatus, errorThrown) {
                alert("something went wrong");
              }
            })
          } else {
            $.ajax({
              url: "/index.php/biz/schedule/events_maker",
              type: "POST",
              dataType: "json",
              data: {
                userArr: checked_name,
                search: search,
                select_start: info.startStr,
                select_end: info.endStr
              },
              success: function (data) {
                successCallback(data);
              }
            });
          }
        }
      },
      {
        events: function (info, successCallback, failureCallback) {
          $.ajax({
            url: "/index.php/biz/schedule/events_maker_company_schedule",
            type: "POST",
            dataType: "json",
            data: {
              // search: search,
              csc: company_schedule_chk
            },
            cache: false,
            async: false,
            success: function (data) {
              successCallback(data);
            }
          });
        }
      }
      // ,{
      //   events: function (info, successCallback, failureCallback) {
      //     $.ajax({
      //       url: "/index.php/biz/schedule/events_maker_recurring_schedule",
      //       type: "POST",
      //       dataType: "json",
      //       data: {
      //         userArr: checked_name,
      //         search: search
      //       },
      //       cache: false,
      //       async: false,
      //       success: function (data) {
      //         successCallback(data);
      //       }
      //     });
      //   }
      // }
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
        var work_type = info.event.extendedProps.work_type;
        var sch_title = info.event.extendedProps.title;
        var customer = info.event.extendedProps.customer;
        var work_name = info.event.extendedProps.work_name;
        var support_method = info.event.extendedProps.support_method;
        var outside_work = info.event.extendedProps.outside_work;
        var userName = info.event.extendedProps.user_name + " (" + info.event.extendedProps.insert_date + ")";
        var modifierName = info.event.extendedProps.modifier_name + " (" + info.event.extendedProps.modify_date + ")";

        title_participant = participant.split(',');

        if (outside_work == 'Y') {
          var outside_work = '[직출] ';
        } else {
          var outside_work = ' ';
        }

        if (work_type == "tech") {
          if (participant.indexOf(",") != -1) {
            var title = "[" + title_participant[0] + " 외 " + (title_participant.length - 1) + "명" + "]";
          } else {
            var title = "[" + participant + "]";
          }


          title += outside_work + customer + '/' + work_name + '/' + support_method;

          var tooltipTitle = '<h3><span class="event_color_button ' + icon + info.event.extendedProps.work_color_seq + '"></span>&nbsp;' + title + '</h3><div>' + term + '</div>';
        } else {
          var tooltipTitle = '<h3><span class="event_color_button ' + icon + info.event.extendedProps.work_color_seq + '"></span>&nbsp;' + outside_work + sch_title + '</h3><div>' + term + '</div>';
        }

        if (info.event.extendedProps.customer != '') {
          tooltipTitle += '<div><span class="text-point">[고객사]<span>&nbsp;<span class="text-normal">' + info.event.extendedProps.customer + '</span></div>';
        }
        tooltipTitle += '<div><span class="text-point">[구&nbsp;&nbsp;&nbsp;&nbsp;분]<span>&nbsp;<span class="text-normal">' + info.event.extendedProps.work_name + '</span></div>';

        if ((info.event.extendedProps.room_name != null) && (info.event.extendedProps.room_name != '')) {
          tooltipTitle += '<div><span class="text-point">[회의실]<span>&nbsp;<span class="text-normal">' + info.event.extendedProps.room_name + '</span></div>';
        }

        if ((info.event.extendedProps.car_name != null) && (info.event.extendedProps.car_name != '')) {
          tooltipTitle += '<div><span class="text-point">[차량]<span>&nbsp;<span class="text-normal">' + info.event.extendedProps.car_name + '</span></div>';
        }

        if (info.event.extendedProps.support_method != '') {
          tooltipTitle += '<div><span class="text-point">[지원방법]<span>&nbsp;<span class="text-normal">' + info.event.extendedProps.support_method + '</span></div>';
        }

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
      var sessionId = $('#session_id').val();
      var sessionName = $('#session_name').val();
      var loginDuty = $('#login_user_duty').val();
      var login_group = $('#login_group').val();
      var login_pgroup = $('#login_pgroup').val();

      if ((sessionId == info.event.extendedProps.user_id) || (loginDuty == '팀장' && login_group == info.event.extendedProps.group) || (loginDuty == '이사' && login_pgroup == info.event.extendedProps.p_group) || (info.event.extendedProps.participant.indexOf(sessionName) > -1)) {
        var seq = info.event.id;
        var startDay = moment(info.event.start).format('YY-MM-DD');
        var startTime = moment(info.event.start).format('HH:mm');
        var endDay = moment(info.event.end).format('YY-MM-DD');
        var endTime = moment(info.event.end).format('HH:mm');
        var participant = info.event.extendedProps.participant;
        //console.log(info.event.extendedProps.room_name);
        if (info.event.extendedProps.s_file_changename != null || info.event.extendedProps.e_file_changename != null || info.event.extendedProps.start_reason != null || info.event.extendedProps.end_reason != null) {
          alert('사진이 등록된 일정은 날짜 변경이 불가합니다.');
          info.revert();
          return false;
        }

        if (info.event.extendedProps.car_name != '' && (info.event.extendedProps.room_name == '' || info.event.extendedProps.room_name == null)) {
          var name = info.event.extendedProps.car_name;
          var type = 'car_name';
        } else {
          var name = info.event.extendedProps.room_name;
          var type = 'room_name';
        }
        var work_name = info.event.extendedProps.work_name;
        var recurring_seq = info.event.extendedProps.recurring_seq;
        var recurring_count = info.event.extendedProps.recurring_count;
        var recurring_setting = info.event.extendedProps.recurring_setting;


        $.ajax({
          type: "POST",
          url: "/index.php/biz/schedule/sch_report_approval",
          dataType: "json",
          data: {
            schedule_seq: seq,
            work_name: work_name
          },
          cache: false,
          async: false,
          success: function (data) {
            // console.log(data);
            // alert(data);
            // alert(data['approval_yn']);
            if (data === 'Y') {
              alert('주간업무보고 결제가 완료된 일정은 수정할 수 없습니다.');
              // stopPropagation();
              info.revert();
              return false;
            } else {


              $.ajax({
                type: "POST",
                url: "/index.php/biz/schedule/duplicate_check",
                // url:"<?php echo site_url();?>/biz/schedule/duplicate_checkcar",
                dataType: "json",
                data: {
                  schedule_seq: seq,
                  select_day: startDay,
                  start: startTime,
                  end: endTime,
                  name: name,
                  type: type
                },
                cache: false,
                async: false,
                success: function (data) {
                  // console.log(data);
                  if (data == 'dupl') {
                    alert('중복되는 차량 혹은 회의실 일정이 있습니다.');
                    // stopPropagation();
                    info.revert();
                    return false;
                  } else {

                    if(recurring_seq != null){
                      if($('#recurring_modify_choose').val() == ''){
                        var recurring_drop_key_val = {
                            seq: seq,
                            start_day: moment(info.event.start).format('YYYY-MM-DD'),
                            start_time: moment(info.event.start).format('HH:mm:ss'),
                            end_day: moment(info.event.end).format('YYYY-MM-DD'),
                            end_time: moment(info.event.end).format('HH:mm:ss'),
                            participant: participant
                          };

                        recurring_setting_change('2', recurring_drop_key_val);
                        return;
                      }
                    }else{

                      $.ajax({
                        type: 'POST',
                        url: "/index.php/biz/schedule/drop_update",
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
                          if (data == "report_written") {
                            alert('보고서가 작성된 일정은 수정할 수 없습니다.');
                            calendar.refetchEvents();
                          }
                          // console.log(data);
                          if (data == 'OK') {
                            // console.log('refetch');
                            calendar.refetchEvents();
                          }
                        }
                      });
                    }
                  }
                }
              });

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
      console.log(info);
      var sessionId = $('#session_id').val();
      var sessionName = $('#session_name').val();
      // console.log(sessionId);
      var loginDuty = $('#login_user_duty').val();
      var login_group = $('#login_group').val();
      var login_pgroup = $('#login_pgroup').val();

      if ((sessionId == info.event.extendedProps.user_id) || (loginDuty == '팀장' && login_group == info.event.extendedProps.group) || (loginDuty == '이사' && login_pgroup == info.event.extendedProps.p_group) || (info.event.extendedProps.participant.indexOf(sessionName) > -1)) {
        var seq = info.event.id;
        var startDay = moment(info.event.start).format('YY-MM-DD');
        var startTime = moment(info.event.start).format('HH:mm');
        var endDay = moment(info.event.end).format('YY-MM-DD');
        // var endDay = moment(info.event.end).subtract(1, 'days').format('YY-MM-DD');
        var endTime = moment(info.event.end).format('HH:mm');
        var participant = info.event.extendedProps.participant;
        if (info.event.extendedProps.s_file_changename != null || info.event.extendedProps.e_file_changename != null || info.event.extendedProps.start_reason != null || info.event.extendedProps.end_reason != null) {
          alert('사진이 등록된 일정은 날짜 길이 변경이 불가합니다.');
          info.revert();
          return false;
        }
        if (info.event.extendedProps.car_name != null && info.event.extendedProps.car_name != '') {
          alert('차량 혹은 회의실 이용이 등록된 일정은 날짜 길이 변경이 불가합니다.\n설비를 이용하는 일정은 하루씩만 등록할 수 있습니다.');
          info.revert();
          return false;
        }
        if (info.event.extendedProps.room_name != null && info.event.extendedProps.room_name != '') {
          alert('차량 혹은 회의실 이용이 등록된 일정은 날짜 길이 변경이 불가합니다.\n설비를 이용하는 일정은 하루씩만 등록할 수 있습니다.');
          info.revert();
          return false;
        }
        // alert(seq+"/////"+startDay +"////"+startTime+"///"+endDay+"//"+endTime);
        var recurring_seq = info.event.extendedProps.recurring_seq;



        $.ajax({
          type: "POST",
          url: "/index.php/biz/schedule/sch_report_approval",
          dataType: "json",
          data: {
            schedule_seq: seq
          },
          cache: false,
          async: false,
          success: function (data) {
            // console.log(data);
            // alert(data['approval_yn']);
            if (data === 'Y') {
              alert('주간업무보고 결제가 완료된 일정은 수정할 수 없습니다.');
              // stopPropagation();
              info.revert();
              return false;
              // calendar.refetchEvents();
            } else {

              if(recurring_seq != null){
                if($('#recurring_modify_choose').val() == ''){
                  var recurring_drop_arr = {
                      seq: seq,
                      start_day: moment(info.event.start).format('YYYY-MM-DD'),
                      start_time: moment(info.event.start).format('HH:mm:ss'),
                      end_day: moment(info.event.end).format('YYYY-MM-DD'),
                      end_time: moment(info.event.end).format('HH:mm:ss'),
                      participant: participant
                    };

                  recurring_setting_change('2', recurring_drop_arr);
                  return;
                }
              }else{

                $.ajax({
                  type: 'POST',
                  url: "/index.php/biz/schedule/drop_update",
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
                    // console.log(data);
                    if (data == "report_written") {
                      alert('보고서가 작성된 일정은 수정할 수 없습니다.');
                      calendar.refetchEvents();
                    }
                    if (data == 'OK') {
                      calendar.refetchEvents();
                    }
                  }
                });
              }


            }
          }
        });


        // $.ajax({
        //   type: 'POST',
        //   url:"/index.php/biz/schedule/drop_update",
        //   data:{
        //     seq: seq,
        //     start_day : startDay,
        //     start_time : startTime,
        //     end_day : endDay,
        //     end_time : endTime
        //   },
        //   cache:false,
        //   success: function(data) {
        //     // console.log(data);
        //     if (data == "report_written"){
        //       alert('보고서가 작성된 일정은 수정할 수 없습니다.');
        //       calendar.refetchEvents();
        //     }
        //     if(data == 'OK'){
        //       calendar.refetchEvents();
        //     }
        //   }
        // });


      } else {
        alert("권한이 없습니다.");
        info.revert();
        return false;
      }
    },
    select: function(info) {
      //datepciker_fun을 사용할 때 이전에 클릭한 날짜보다 더 지난 날짜를 다시 클릭하면 새로 값을 주기 전에 endDay에 이전 값이 남아있어 date_compare 함수가 실행되어 종료일자가 시작일자보다 빠르다는 안내가 나오게 된다. 이를 방지하기 위해 날짜를 클릭하고 datepicker_fun으로 값을 줘서 onchange로 date_compare함수가 실행되기 전에 미리 값을 비워놓고 실행하는 것
      $('#startDay').val('');
      $('#endDay').val('');
      $('#de_recurring_seq').val('');
      $('#recurring_mode').val('');
      $('#recurring_modify_choose').val('');

      var startStr = moment(info.startStr).format('YYYY-MM-DD');
      var startTime = moment(info.startStr).format('HH:mm');
      if (startTime == "00:00") {
        startTime = moment().format('HH:mm');
      }
      //반복일정 recurring
      $("#recurring_select option:eq(0)").prop("selected", true);
      $("#recurring_select_ex option:eq(0)").prop("selected", true);
      $('#recurring_check').prop('checked',false);
      change_recurring_select_ex('');
      // $('#recurring_endDay_opt').change();
      // change_recurring_check('');
      recurring_form('', startStr);

      var endStr = moment(info.endStr).subtract(1, 'days').format('YYYY-MM-DD');
      var endTime = moment(info.endStr).format('HH:mm');
      if (endTime == "00:00") {
        endTime = moment().add(1, 'h').format('HH:mm');
      }
      if (moment(endStr).diff(moment(startStr), 'days') < 0) {
        endStr = startStr;
      }
      <?php if(!$this->agent->is_mobile()){?>
      datepicker_fun('startDay',startStr)
      <?php } ?>
      // $('#startDay').val(startStr);
      $('#startTime').val(startTime);
      <?php if(!$this->agent->is_mobile()){?>
      datepicker_fun('endDay',endStr)
      <?php } ?>
      // $('#endDay').val(endStr);
      $('#endTime').val(endTime);


      //KI1 20210125 새로 일정을 불렀을 때 이전 입력내용 삭제
      $('#workname').val('');
      $('#customerName').val('');
      $('#customerName2').val('');
      //KI1 20210208
      $('#customerName').css('border-color', '#00ff0000');
      $('#customerName').attr('readonly', true);
      $('input:checkbox[name=add_weekly_report]').attr('checked', false);
      $('#nondisclosure_sch').attr('checked', false);
      // $('#tech_report').val('');
      //KI1 20210208
      $('#project').val('');
      $('#customer').val('');
      $('#supportMethod').val('');
      $('#participant').val('');
      $('#contents').val('');
      $('#customer_manager').val('');
      $('#customer_tmp').val('');
      $('#customer').val('');
      $('#visitCompany').val('');
      $('#forcasting_seq').val('');
      $('#maintain_seq').val('');
      $('#room_name').val('')
      $('#car_name').val('')
      $('#title').val('');
      $('#place').val('');
      $('.tech_div').hide();
      $('.sales_div').hide();
      $('.general_div').show();
      $('.except_nondisclosure_div').show();
      $('.report_div').hide();
      $('.explanation_div').hide();
      $('#dev_type').val('');
      $('#dev_page').val('');
      $('#dev_requester').val('');
      $('#dev_develop').val('');
      $('.lab_contents_tr').hide();
      $('#dev_complete').prop('checked',false);
      $("#contents_tr_0").show();
      $('.except_company_div').show();

      if ($("#myDropdown").is(':visible')) { //드롭박스가 열려있을 경우(true)
        $("#myDropdown").toggle();
      }

      //참여자에 본인 자동으로 입력
      $('#participant_box').html('');
      $('#usertree').jstree("deselect_all");
      $('#usertree').jstree("close_all");
      keypress(13, session_name, 'participant')

      contents_split_type('1');
      $("#contents_0").val('');
      var contents_length = $("textarea[name=contents]").length;
      for (i = 1; i < contents_length; i++) {
        $("#contents_tr_" + i).remove();
      }
      if (!mobile) {
        $('#addpopup').bPopup({
          //스크롤 안따라가도록 고정
          follow: [false, false]
        });
      } else {
        return false;
      }
    },
    // dateClick: function(info) {
    //   $('#startDay').val(info.dateStr);
    //   $('#endDay').val(info.dateStr);
    //   //KI1 20210125 새로 일정을 불렀을 때 이전 입력내용 삭제
    //   $('#workname').val('');
    //   $('#customerName').val('');
    //   $('#customerName2').val('');
    //   //KI1 20210208
    //   $('#customerName').css('border-color','#00ff0000');
    //   $('#customerName').attr('readonly',true);
    //   // $('#tech_report').val('');
    //   //KI1 20210208
    //   $('#project').val('');
    //   $('#customer').val('');
    //   $('#supportMethod').val('');
    //   $('#participant').val('');
    //   $('#participant_box').html('');
    //   $('#contents').val('');
    //   $('#customer_manager').val('');
    //   $('#customer_tmp').val('');
    //   $('#customer').val('');
    //   $('#forcasting_seq').val('');
    //   $('#maintain_seq').val('');
    //   $('#title').val('');
    //   $('#place').val('');
    //   $('#room_name').val('')
    //   $('#car_name').val('')
    //   $('.except_nondisclosure_div').show();
    //   if($("#myDropdown").is(':visible')){ //드롭박스가 열려있을 경우(true)
    //     $("#myDropdown").toggle();
    //   }
    //   $('#usertree').jstree("deselect_all");
    //   $('#usertree').jstree("close_all");
    //   //KI2 20210125
    //   $('#addpopup').bPopup({
    //     //스크롤 안따라가도록 고정
    //      follow : [false, false]
    //   });
    //   },
    eventClick: function(info) { //일정 클릭시 이벤트 상세페이지 이동
      // function detail_modal 같이 수정!!!!
      //datepciker_fun을 사용할 때 이전에 클릭한 날짜보다 더 지난 날짜를 다시 클릭하면 새로 값을 주기 전에 endDay에 이전 값이 남아있어 date_compare 함수가 실행되어 종료일자가 시작일자보다 빠르다는 안내가 나오게 된다. 이를 방지하기 위해 날짜를 클릭하고 datepicker_fun으로 값을 줘서 onchange로 date_compare함수가 실행되기 전에 미리 값을 비워놓고 실행하는 것
      $('#de_startDay').val('');
      $('#de_endDay').val('');
      $('#de_startDay').css('background-color','#FFFFF2');
      $('#de_endDay').css('background-color','#FFFFF2');
      $('#de_startTime').css('background-color','#FFFFF2');
      $('#de_endTime').css('background-color','#FFFFF2');
      $('#de_start_img').val('');
      $('#de_start_img').change();
      $('#de_end_img').val('');
      $('#de_end_img').change();
      $('#de_recurring_seq').val('');
      $('#recurring_mode').val('');
      $('#recurring_modify_choose').val('');
      <?php if(!$this->agent->is_mobile()){?>
      $('#de_startTime, #de_endTime').timepicker({
          minuteStep: 10,
          // template: 'modal',
          // appendWidgetTo: 'body',
          // showSeconds: true,
          showMeridian: false
          // defaultTime: false
      });
      <?php } ?>

      var seq = info.event.id;
      $.ajax({
        type: 'GET',
        dataType : "json",
        url:"/index.php/biz/schedule/tech_schedule_detail",
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
            $('#techReportInsert, #techReportModify').hide();
            $('#de_startTime').show();
            $('#de_endTime').show();
            $('#usertree').jstree("deselect_all");
            $('#usertree').jstree("close_all");
            //내용분할1
            //해당 seq의 일정 texrarea의 개수 확인
            var before_textarea = $('textarea[name=de_contents]').length;
            //1 이상일 경우 이전 textarea의 흔적이 남은 것이므로 for문을 돌면서 삭제할 예정
            if(before_textarea > 1){
              for(i=0; i<before_textarea; i++){
                //아래 함수를 사용하면 자동으로 순번이 재정렬 되기에(1,2,3,4에서 1삭제 -> 1,2,3) 계속 1번을 삭제해도 for문으로 돌면서 전부 삭제된다.
                contents_del(1,"de_contents");
              }
            }
            //내용분할2
            // console.log(result);
            var details = result.details;
            var contents = result.contents;

            var seq = details.seq;
            var customer_manager = details.customer_manager;
            var forcasting_seq = details.forcasting_seq;
            var maintain_seq = details.maintain_seq;

            var start_day = details.start_day;
            var start_time = moment(details.start_time, 'HH:mm').format('HH:mm');
            // var start_time = details.start_time;
            var end_day = details.end_day;
            var end_time = moment(details.end_time, 'HH:mm').format('HH:mm');
            // var end_time = details.end_time;

            // //야간품의서 작성
            // var c_end_time = moment(details.end_time, 'HH').format('HH');
            //
            // $('#c_night').hide();
            // if((c_end_time >= 18 || start_day != end_day) && $("#night").is(":checked") == false) { //결재안돼있을때만
            //   $('#c_night').show();
            // }
            //
            // //주말품의서 작성
            // var week = ['일', '월', '화', '수', '목', '금', '토'];
            // var is_weekend = false;
            // var c_start_day = new Date(start_day);
            // var c_end_day = new Date(end_day);
            //
            // while(c_start_day <= c_end_day) {
            // var strDate = moment(c_start_day).format('YYYY-MM-DD');
            //
            // var dayOfWeek = week[new Date(strDate).getDay()];
            //
            // if(dayOfWeek == '토' || dayOfWeek == '일') {
            //   is_weekend = true;
            // }
            //
            // c_start_day.setDate(c_start_day.getDate() + 1);
            // }
            //
            // if(is_weekend == true && $("#weekend").is(":checked") == false) { //결재안돼있을때만
            //   $('#c_weekend').show();
            // } else {
            //   $('#c_weekend').hide();
            // } / 20220622 주석처리 / 문제없을시 삭제

            var work_name = details.work_name;
            var title = details.title;
            var place = details.place;
            var support_method = details.support_method;
            var customer = details.customer;
            var visitCompany = details.visit_company;
            var project = details.project;
            var tech_report = details.tech_report;
            var user_id = details.user_id;
            var user_name = details.user_name;
            var work_type = details.work_type;
            var room_name = details.room_name;
            var car_name = details.car_name;
            var nondisclosure = details.nondisclosure;
            // var weekly_report = details.weekly_report;
            // var contents = details.contents;
            var recurring_seq = details.recurring_seq;
            var recurring_setting = details.recurring_setting;

            var participant_val = details.participant;
            var participant = '';

            var start_reason = details.start_reason;
            var end_reason = details.end_reason;

            var s_file_changename = details.s_file_changename;
            var s_file_realname = details.s_file_realname;
            var e_file_changename = details.e_file_changename;
            var e_file_realname = details.e_file_realname;

            var outside_work = details.outside_work;

            //참석자seq 받아오기
            $.ajax({
              type: "POST",
              dataType : "json",
              url: "<?php echo site_url();?>/biz/schedule/find_participant_seq",
              data: {
                participant: participant_val,
              },
              cache:false,
              async:false,
              success: function(result) {
                participant = result;
              }
            });

              //내용분할1
              //해당 seq일정의 내용이 몇 개로 분할되어 있는지 개수 확인
              var contents_length = contents.length;
              //내용이 분할되지 않은 이전 일정일 경우 tech_schedule_list에 저장된 내용을 불러온다.
              // if(contents_length <= 0){
              //   if(details.weekly_report == "Y"){
              //     $('#de_add_weekly_report_0').attr('checked',true);
              //   }else{
              //     $('#de_add_weekly_report_0').attr('checked',false);
              //   }
              //   $('#de_contents_0').val(details.contents);
              // }else{
              //내용이 분할된 일정일 경우 for문을 돌면서 전부 불러온다.
              for (var i = 0; i < contents_length; i++) {
                // if(contents[i].contents_num == i){
                //불러온 분할 일정을 담을 tr이 존재하지 않을 경우 강제로 클릭시켜서 tr을 생성한다.
                if (work_type!='lab'){
                  if ($('#de_contents_' + i).length <= 0) {
                    contents_add_action('de_contents')
                    // $('#de_contents_0').parent('td').find('img').trigger('click');
                  }
                  //불러온 분할 일정을 이중 for문으로 num과 tr번호와 일치시켜 담는다.

                // var contents_val = contents[i].contents;
                  for (j = 0; j < contents_length; j++) {
                    var contents_val = contents[j].contents;
                    var contents_num_val = contents[j].contents_num;
                    var weekly_report_val = contents[j].weekly_report;

                    if (i == contents_num_val) {
                      // console.log('i:'+i+' num:'+contents_num_val+' val:'+contents_val);
                      $('#de_contents_' + i).val(contents_val);
                      // var weekly_report_val = contents[i].weekly_report;
                      if (weekly_report_val == 'Y') {
                        $('#de_add_weekly_report_' + i).attr('checked', true);
                      } else {
                        $('#de_add_weekly_report_' + i).attr('checked', false);
                      }
                    }

                  }
                  $('#de_workname > option[value="기술연구소"]').remove();
                } else {
                  if($('#de_workname > option[value="기술연구소"]').length == 0){
                    var lab_option = "<option value='기술연구소'>기술연구소</option>";
                    $('#de_workname').append(lab_option);
                  }
                  var content = contents[0].contents;
                  content = content.split(',,,');
                  // console.log(content);
                  for(var i=0;i<content.length;i++){
                    var content2 = content[i].split(':::');
                    // console.log(content2[0]);
                    // console.log(content2[1]);
                    if (content2[0]=='dev_type') {
                      $("#de_dev_type > option[value="+content2[1]+"]").attr("selected","true");
                    } else if (content2[0]=='dev_complete'){
                      if(content2[1]=="Y"){
                        $("#de_dev_complete").attr("checked","true");
                      }
                    } else {
                      // $(`#de_${content2[0]}`).val(content2[1]);
                      $('#de_'+content2[0]).val(content2[1]);
                    }
                  }
                }
              // }
              }
            // }
            //내용분할2

            $('#c_weekend').hide();
            if (work_type == 'tech') {
              $('#de_work_type').val("tech");
              $('.de_except_company_div').show();
              $('.de_tech_div').show();
              if(support_method=="원격지원"){
                $('.de_tech_img_div').hide();
              } else if (support_method=='현장지원'){
                $('.de_tech_img_div').show();
                if($("#weekend").is(":checked") == false) { //결재안돼있을때만
                $('#c_weekend').show();
              }
              }
              $('#de_contents_tr_0').show();
              $('.de_general_div').hide();
              $('.de_report_div').hide();
              $('.de_lab_contents_tr').hide();
              contents_split_type('1');

              //회사 공지사항 일정 참석자 제거 or 생성
            } else if (work_type == 'company') {
              $('#de_work_type').val("company");
              $('.de_except_company_div').hide();
              $('.de_tech_div, .de_tech_img_div').hide();
              $('.de_general_div').show();
              $('.de_report_div').hide();
              $('.de_lab_contents_tr').hide();
              $('#de_contents_tr_0').show();
              contents_split_type('1');
            } else if (work_type=='lab') {
              $('#de_work_type').val("lab");
              $('.de_except_company_div, .de_tech_div, .de_tech_img_div, .de_general_div, #de_contents_tr_0, .de_report_div').hide();
              $(".de_sch_title_div").show();
              $('.de_lab_contents_tr').show();
            } else {
              $('#de_work_type').val("general");
              $('.de_except_company_div').show();
              $('.de_tech_div, .de_tech_img_div').hide();
              $('.de_general_div').show();
              $('.de_report_div').show();
              $('.de_lab_contents_tr').hide();
              $('#de_contents_tr_0').show();
              contents_split_type('2');
            }
            if (work_name == '영업활동') {
              $(".de_sales_div").show();
            } else {
              $('.de_sales_div').hide();
            }
          // if(weekly_report == "Y"){
          //   $('#de_add_weekly_report').attr('checked',true);
          // }else{
          //   $('#de_add_weekly_report').attr('checked',false);
          // }
          if (nondisclosure == "Y") {
            $('#de_nondisclosure_sch').attr('checked', true);
            $('.de_except_nondisclosure_div').hide();
          } else {
            $('#de_nondisclosure_sch').attr('checked', false);
            $('.de_except_nondisclosure_div').show();
          }

          // 직출 체크되면 값 가져오기
          if(outside_work == "Y") {
            $('#de_outside_work').attr('checked', true);
          } else {
            $('#de_outside_work').attr('checked', false);
          }

          $('#de_seq').val(seq);
          $('#de_work_type').val(work_type);
          $('#de_customer_manager').val(customer_manager);
          $('#de_forcasting_seq').val(forcasting_seq);
          $('#de_maintain_seq').val(maintain_seq);
          $('#de_room_name').val(room_name);
          $('#de_car_name').val(car_name);
          $('#de_startDay').val(start_day);
          <?php if(!$this->agent->is_mobile()){?>
          datepicker_fun('de_startDay',start_day)
          <?php }?>
          $('#de_startTime').val(start_time);
          $('#de_endDay').val(end_day);
          <?php if(!$this->agent->is_mobile()){?>
          datepicker_fun('de_endDay',end_day)
          <?php } ?>
          $('#de_endTime').val(end_time);
          $('#de_title').val(title);
          $('#de_place').val(place);
          $('#de_customerName').val(customer);
          $('#de_customerName2').val(customer);
          $('#de_visitCompany').val(visitCompany);
          $('#de_project').val(project);
          $('#de_start_reason').val(start_reason);
          $('#de_end_reason').val(end_reason);

          //반복일정 recurring

          if(recurring_seq == null){
            $('#de_recurring_check').prop('checked', false);
            $("#de_recurring_select option:eq(0)").prop("selected", true);
            $("#de_recurring_select_ex option:eq(0)").prop("selected", true);
            $('#de_recurring_count').val('');
            $('#de_recurring_endDay').val('');
            change_recurring_select_ex('de_');
            recurring_form('de_', start_day);
            // recurring_form('', start_day);
            $('#de_recurring_seq').val('');
          }else{
            $('#de_recurring_check').prop('checked', true);
            recurring_form('de_', start_day);
            $('#de_recurring_seq').val(recurring_seq);

            var recurring_split = recurring_setting.split(';;;');
            var recurring_split_arr = [];
            // if(Array.isArray(recurring_split) == true){
            //   alert(1);
            // }else{
            //   alert(2);
            // }
            // console.log(recurring_split[0]);
            //IE에서 =>안먹히기 때문에 아래 each문을 써줘야한다.
            // recurring_split.forEach((item, i) => {
            //   var recurring_split2 = item.split(':');
            //   // recurring_split_arr.recurring_split2[0] = recurring_split2[1];
            //   recurring_split_arr[recurring_split2[0]] = recurring_split2[1];
            // });

            recurring_split.forEach(function(item, index){
              // a.push(jQuery(item).text());
              var recurring_split2 = item.split(':');
              recurring_split_arr[recurring_split2[0]] = recurring_split2[1];
            });
            var sel_opt_length = $('#de_recurring_select option').length;
            for(i = 0; i < sel_opt_length; i++){
              var sel_opt_num = $('#de_recurring_select option:eq('+i+')').attr('num'); //옵션에 num요소로 지정해놓은 값과 db 값이 일치하는 옵션을 selected
              if(sel_opt_num == recurring_split_arr.cycle){
                $('#de_recurring_select option:eq('+i+')').prop('selected', true);
                $('#de_recurring_select_before_val').val(recurring_split_arr.cycle);
              }
            }

            // $('#de_recurring_endDay_opt').change();
            // $('#de_recurring_select option:eq('+recurring_split_arr.cycle+')').prop('selected', true);
            var sel_opt_length = $('#de_recurring_select_ex option').length;
            for(i = 0; i < sel_opt_length; i++){
              var sel_opt_num = $('#de_recurring_select_ex option:eq('+i+')').attr('num'); //옵션에 num요소로 지정해놓은 값과 db 값이 일치하는 옵션을 selected
              if(sel_opt_num == recurring_split_arr.cycle_ex){
                $('#de_recurring_select_ex option:eq('+i+')').prop('selected', true);
                $('#de_recurring_select_ex_before_val').val(recurring_split_arr.cycle_ex);
              }
            }
            change_recurring_select_ex('de_'); //change작동시켜서 de_recurring_endDay, de_recurring_count display:none 해제하기

            if(recurring_split_arr.count != undefined){
              $('#de_recurring_count').val(recurring_split_arr.count);
              $('#de_recurring_input_before_val').val(recurring_split_arr.count);
            }else if(recurring_split_arr.endday != undefined){
              datepicker_fun('de_recurring_endDay',recurring_split_arr.endday);
              $('#de_recurring_input_before_val').val(recurring_split_arr.endday);
            }

          }
          // dayOfTheWeek_in_week(start_day);
          // dayOfTheWeek_num_in_month(start_day);
          // var recurring_month = moment(start_day).format('MM');
          // var recurring_day = moment(start_day).format('DD');
          // $('#de_recurring_month_day').text('매월 '+recurring_day+'일');
          // $('#de_recurring_month_day').val('FREQ=MONTHLY');
          // $('#de_recurring_year').text('매년 '+recurring_month+'월 '+recurring_day+'일');
          // $('#de_recurring_year').val('FREQ=YEARLY');
          // if(recurring_rrule != null){
          //   $('#de_recurring_check').prop('checked',true);
          // }
          <?php //if(!$this->agent->is_mobile()){?>
          // var recurring_split1 = recurring_rrule.split(':')[1];
          // var recurring_split2 = recurring_split1.split(';');
          // var recurring_split_key_value = [];
          // for(i = 0; i < recurring_split2.length; i++){
          //   var recurring_split3 = recurring_split2[i].split('=');
          //   var key = recurring_split3[0];
          //   var value = recurring_split3[1];
          //   // array에 key value로 넣으려는데 아래와 같은 방식이면 key값은 무조건 문자열로 들어가고 동적으로 변경이 안되어 모든 key가 'key'로 들어가게 된다.
          //   //recurring_split_key_value.push({key: value})
          //   //그래서 동적인 key값을 주려면 아래처럼 key value를 매칭시켜서 넣어주여야 한다.
          //   recurring_split_key_value[key] = value;
          // }
          // if(recurring_split_key_value['UNTIL'] != null){
          //   var de_recurring_endStr = moment(recurring_split_key_value['UNTIL']).format('YYYY-MM-DD');
          //   datepicker_fun('de_recurring_endDay',de_recurring_endStr)
          //   $('#de_recurring_endDay_opt').prop('selected',true);
          // }else if(recurring_split_key_value['COUNT'] != null){
          //   $('#de_recurring_count_opt').prop('selected',true);
          // }
          //
          // if(recurring_split_key_value['FREQ'] == 'DAILY'){
          //   $('#de_recurring_day').prop('selected',true);
          // }else if(recurring_split_key_value['FREQ'] == 'WEEKLY'){
          //   $('#de_recurring_week').prop('selected',true);
          // }else if(recurring_split_key_value['FREQ'] == 'MONTHLY' && recurring_split_key_value['BYDAY'] == null){
          //   $('#de_recurring_month_day').prop('selected',true);
          // }else if(recurring_split_key_value['FREQ'] == 'MONTHLY' && recurring_split_key_value['BYDAY'] != null){
          //   $('#de_recurring_month').prop('selected',true);
          // }else if(recurring_split_key_value['FREQ'] == 'YEARLY'){
          //   $('#de_recurring_year').prop('selected',true);
          // }
          // change_recurring_select_ex('de_');
          <?php //} ?>


          // $('#de_participant').val(participant);
          $('#de_participant').val('');
          $('#de_participant_box').html('');
          // var split_de_participant = participant.split(','); //$$
          // //console.log(split_de_participant);
          // insert_span_user_name(split_de_participant, 'de_participant'); //$$

          var de_participant_arr = []; //$$
          var split_de_participant = participant.split(','); //$$
          // console.log(participant);
          for(i = 0; i < split_de_participant.length; i++){ //$$
            var split_de_participant2 = split_de_participant[i].split('_'); //$$
            var name = split_de_participant2[0]; //$$
            var seq = split_de_participant2[1]; //$$
            de_participant_arr.push({'name':name, 'seq':seq}); //$$
          }
          insert_span_user_name(de_participant_arr, 'de_participant'); //$$

          // $('#de_contents').val(contents);
          $("#de_supportMethod").val(support_method).prop("selected", true);
          $("#de_workname").val(work_name).prop("selected", true);
          if (work_name == '납품설치' || work_name == '미팅' || work_name == '데모(BMT)지원') {
            $('#de_customer').val(forcasting_seq);
          } else {
            //포캐스팅+유지보수
            if(maintain_seq == null){
              $('#de_customer').val(forcasting_seq);
            }else{
              $('#de_customer').val(maintain_seq);
            }
          }

          if (start_time == '00:00:00' && end_time == '00:00:00') {
            $("#de_startTime, #de_startTimeBtn, #de_endTime, #de_endTimeBtn").hide();
            $("input:checkbox[id='de_alldayCheck']").prop("checked", true);
          }

          if ($('#de_forcasting_seq').val() != "" && $('#de_maintain_seq').val()) {
            $('#de_customerName').attr('readonly', true);
            $('#de_project').attr('readonly', true);
          }

          var register = details.user_id;
          var regGroup = details.group;
          var regPgruop = details.p_group;
          //KI1 20210125
          var regParticipant = details.participant;
          var session_name = result.session_name;
          var session_id = result.session_id;
          var login_gruop = result.login_gruop;
          var login_pgroup = result.login_pgroup;
          var login_user_duty = result.login_user_duty;

          //선영추가 20210326
          var approval_yn = details.approval_yn;

          //@@@
          if (((register == session_id) || (login_user_duty == '팀장' && login_gruop == regGroup) || (login_user_duty == '이사' && login_pgroup == regPgruop) || (regParticipant.indexOf(session_name) > -1)) && approval_yn != "Y") { //indexOf값이 -1이 아니면 regParticipant 안에 본인이 들어가 있다는 것
            $("#updateSchedule").find("input, select, button, textarea").prop("disabled", false);
            $("#schdule_contoller_btn").show();
            $("#schdule_contoller_btn2").hide();
          } else { //
            $("#updateSchedule").find("input, select, button, textarea").prop("disabled", true);
            $("#updateSubmit").prop("disabled", false);
            $("#de_participant_input").prop("disabled", false);
            $("#de_participant").prop("disabled", false);
            // $("#updateSchedule").find("button[name=updateSubmit], input[name=de_participant_input], input[name=de_participant]").prop("disabled",false);
            $("#schdule_contoller_btn").hide();
            $("#schdule_contoller_btn2").show();
          }

          var sday = details.start_day;
          sday = new Date(sday);
          var eday = details.end_day;
          eday = new Date(eday);
          var today = new Date();

          var dateDiff = Math.ceil((eday.getTime() - sday.getTime()) / (1000 * 3600 * 24)) + 1;

          $('#de_startTime, #de_endTime, #de_startDay, #de_endDay').attr('disabled',false);

          if (work_type == 'tech') {
            if ((start_reason != null || s_file_changename != null)) {
              var workDate = $("#de_startDay");
              var workTime = $("#de_startTime");

              workDate.attr('readonly',true);
              workDate.css('background-color','rgb(199, 199, 199)');
              workTime.attr('readonly',true);
              workTime.css('background-color','rgb(199, 199, 199)');
              workDate.datepicker("destroy");
              var clone = workTime.clone();
              var parent = workTime.parent();
              <?php if($this->agent->is_mobile()){?>
                workDate.attr('disabled', true);
                clone.attr('disabled', true);
                <?php } ?>
              workTime.remove();
              parent.append(clone);
            }
            if ((end_reason != null || e_file_changename != null)) {
              var workDate = $("#de_endDay");
              var workTime = $("#de_endTime");

              workDate.attr('readonly',true);
              workDate.css('background-color','rgb(199, 199, 199)');
              workTime.attr('readonly',true);
              workTime.css('background-color','rgb(199, 199, 199)');
              workDate.datepicker("destroy");
              var clone = workTime.clone();
              var parent = workTime.parent();
            <?php if($this->agent->is_mobile()){?>
              workDate.attr('disabled', true);
              clone.attr('disabled', true);
              <?php } ?>
              workTime.remove();
              parent.append(clone);
            }
            if (s_file_realname != '') {
              $('.s_file_input_box').hide();
              $('.s_file_view_box').show();
              $('.s_file_img').text(s_file_realname);
              // $('#s_img_down').attr('href', '<?php echo $misc; ?>upload/biz/schedule/'+s_file_changename);
              // $('#s_img_down').attr('download', s_file_realname);
              $('#s_img_detail').attr('onclick',"img_detail('"+s_file_changename+"')");
              $('#s_img_del').attr('onclick', 'del_img("'+s_file_changename+'", "s")');
            }
            if (s_file_realname == null) {
              $('.s_file_input_box').show();
              $('.s_file_view_box').hide();
            }
            if (e_file_realname != '') {
              $('.e_file_input_box').hide();
              $('.e_file_view_box').show();
              $('.e_file_img').text(e_file_realname);
              // $('#e_img_down').attr('href', '<?php echo $misc; ?>upload/biz/schedule/'+e_file_changename);
              // $('#e_img_down').attr('download', e_file_realname);
              $('#e_img_detail').attr('onclick',"img_detail('"+e_file_changename+"')");
              $('#e_img_del').attr('onclick', 'del_img("'+e_file_changename+'", "e")');
            }
            if (e_file_realname == null) {
              $('.e_file_input_box').show();
              $('.e_file_view_box').hide();
            }
          }

          var outside_eday = details.end_day;
          var outside_today = '<?php echo date('Y-m-d'); ?>';
          outside_eday = outside_eday.replace(/-/g, '');
          outside_today = outside_today.replace(/-/g, '');

          if (outside_eday < outside_today) {
            $('#de_outside_work').prop('disabled', true);
          } else {
            $('#de_outside_work').prop('disabled', false);
          }

          if(!mobile){
            if ( (start_reason != null || s_file_changename != null) && (end_reason != null || e_file_changename != null) || support_method == '원격지원' ) {
              if (tech_report == 0 && work_type == 'tech' && sday <= today) {
                $('#techReportModify').show();
              } else if (tech_report > 0 && work_type == 'tech' && sday <= today && dateDiff < 3) {
                $('#techReportInsert').show();
                // if (dateDiff > details.tech_report) {
                //   $('#techReportModify').show();
                // }
              }
            }
          }
          //다른사람 일정 내용 추가클릭 못하게
          if(regParticipant.indexOf(session_name) != -1 || user_name.indexOf(session_name) != -1){
            $('#updateSchedule').find('#contents_add').attr('onclick',"contents_add_action('de_contents');");
          } else {
            $('#updateSchedule').find('#contents_add').attr('onclick','').unbind('click');
            $('#updateSchedule').find('.de_contents_remove').attr('onclick','').unbind('click');
          }

        }
      });

      // $('#trip').prop('checked', false); //품의서체크박스 초기화
      // $('#night').prop('checked', false);
      // $("#trip_status").val(''); //진행알림창 초기화
      // $("#night_status").val(''); / 20220622 주석처리 / 문제없을시 삭제
      $('#weekend').prop('checked', false);
      $("#weekend_status").val('');

      $.ajax({
        type: 'POST',
        dataType: 'json',
        url: "<?php echo site_url();?>/biz/schedule/create_document",
        data: {
          seq: seq
        },
        cache: false,
        async: false,
        success: function(data) {
          if(data) {
            // if(data['trip'].approval_doc_status == 002) {
            //   $('#trip').prop('checked', true);
            // }
            // $("#trip_status").val(data['trip'].approval_doc_status);
            // if(data['night'].approval_doc_status == 002) {
            //   $('#night').prop('checked', true);
            // }
            // $("#night_status").val(data['night'].approval_doc_status);
            // 20220622 주석처리 / 문제없을시 삭제
            if(data['weekend'].approval_doc_status == 002) {
              $('#weekend').prop('checked', true);
            }
            $("#weekend_status").val(data['weekend'].approval_doc_status);
          }
        }
      })

    },
    // views: {
    //   timeGrid: {
    //     dayMaxEventRows: 3 // adjust to 6 only for timeGridWeek/timeGridDay
    //   }
    // }
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


  //내용분할1
  contents_split_type = function (mode) {
    //구조가 변경된 DOM에서 onclick등으로 실행되는 함수는 작동이 되지 않는다. 그래서 위처럼 함수를 써줘야한다.
    // function contents_split_type(mode){

    if (mode == '1') {
      //tech와 company는 기존 내용 형식 쓰기
      $('.explanation_div, .de_explanation_div').hide();
      $('textarea[name=contents], textarea[name=de_contents]').prop({
        'rows': '5',
        'cols': '52'
      });
      $('textarea[name=contents], textarea[name=de_contents]').closest('tr').not('#contents_tr_0, #de_contents_tr_0').find('img, textarea, input:checkbox').prop('disabled', true);
      $('textarea[name=contents], textarea[name=de_contents]').closest('tr').not('#contents_tr_0, #de_contents_tr_0').css('display', 'none');
      $('img[name=contents_add], img[name=de_contents_add], img[name=contents_remove], img[name=de_contents_remove], input:checkbox[name=add_weekly_report], input:checkbox[name=de_add_weekly_report]').hide();
      // $('input:checkbox[name=add_weekly_report], input:checkbox[name=de_add_weekly_report]').css('display','none');
    } else if (mode = '2') {
      //general은 내용분할 형식 쓰기
      $('textarea[name=contents], textarea[name=de_contents]').prop({
        'rows': '2',
        'cols': '41'
      });
      $('.explanation_div, .de_explanation_div').show();
      $('textarea[name=contents], textarea[name=de_contents]').closest('tr').not('#contents_tr_0, #de_contents_tr_0').find('img, textarea, input:checkbox').prop('disabled', false);
      $('textarea[name=contents], textarea[name=de_contents]').closest('tr').not('#contents_tr_0, #de_contents_tr_0').css('display', '');
      $('img[name=contents_add], img[name=de_contents_add], img[name=contents_remove], img[name=de_contents_remove], input:checkbox[name=add_weekly_report], input:checkbox[name=de_add_weekly_report]').show();
      // $('input:checkbox[name=add_weekly_report], input:checkbox[name=de_add_weekly_report]').css('display','');
    }

  }
  //내용분할2


  $('#workname, #de_workname').change(function () {
    var work = $(this).val();
    var check_work = ['납품설치', '설치지원', '장애지원', '기술지원', '정기점검', '데모(BMT)지원', '교육지원', '미팅', '정기점검2', '교육참석', '기술연구소'];

    if (check_work.indexOf(work) < 0) {
      //general
      $('.tech_div, .de_tech_div, .de_tech_img_div, .lab_contents_tr').hide();
      $(".sales_div, .de_sales_div").hide();
      $('.general_div, .de_general_div, #contents_tr_0').show();
      $('#work_type, #de_work_type').val('general');
      $('#supportMethod, #customerName, #customerName2, #customer, #searchInput, #project, #de_supportMethod, #de_customerName, #de_customerName2, #de_customer, #de_searchInput, #de_project, #customer_manager, #de_customer_manager, #customer_tmp, #de_customer_tmp, #forcasting_seq, #de_forcasting_seq, #maintain_seq, #de_maintain_seq').val("");
      //주간보고 체크값 유지안하기(구분 바뀔때마다 비워주기)
      // $('#add_weekly_report, #de_add_weekly_report').prop('checked',false)
      //비공개 체크값 유지안하기(구분 바뀔때마다 비워주기)
      // $('#nondisclosure_sch, #de_nondisclosure_sch').prop('checked', false)

      // $('#tech_report, #de_tech_report').val("Y");

      //회사 공지사항 일정 참석자 제거 or 생성
      //company
      if (work == '공지일정') {
        $('.except_company_div, .de_except_company_div').hide();
        $('.lab_contents_tr, .de_lab_contents_tr').hide();
        $('.report_div, .de_report_div').hide();
        $('#contents_tr_0, #de_contents_tr_0').show();
        $('#work_type, #de_work_type').val('company');
        //비공개 체크값 유지안하기(구분 바뀔때마다 비워주기)
        $('#nondisclosure_sch, #de_nondisclosure_sch').prop('checked', false)
        //반복일정 체크값 유지안하기(구분 바뀔때마다 비워주기)
        // $('#recurring_check, #de_recurring_check').prop('checked', false)
        // change_recurring_check('');
        // change_recurring_check('de_');
        contents_split_type('1');
      } else {
        $('.lab_contents_tr, .de_lab_contents_tr').hide();
        $('.except_company_div, .de_except_company_div').show();
        $('#contents_tr_0, #de_contents_tr_0').show()
        $('.report_div, .de_report_div').show();
        contents_split_type('2');
      }
      if (work == '영업활동') {
        $(".sales_div, .de_sales_div").show();
      } else {
        $(".sales_div, .de_sales_div").hide();
      }
    } else if (work == '기술연구소') {
      $('.except_company_div, .de_except_company_div').hide();
      $('.explanation_div, .de_explanation_div').hide();
      $('.report_div, .de_report_div').hide();
      $('#contents_tr_0, #de_contents_tr_0').hide();
      $('.sch_loc_div, .de_sch_loc_div').hide();
      $('.sch_title_div, .de_sch_title_div').show();
      $('.tech_div, .de_tech_div, .de_tech_img_div').hide();
      $(".sales_div, .de_sales_div").hide();
      $('.lab_contents_tr, .de_lab_contents_tr').show();
      $('.except_nondisclosure_div, .de_except_nondisclosure_div').show();
      //비공개 체크값 유지안하기(구분 바뀔때마다 비워주기)
      $('#nondisclosure_sch, #de_nondisclosure_sch').prop('checked', false)
      //반복일정 체크값 유지안하기(구분 바뀔때마다 비워주기)
      // $('#recurring_check, #de_recurring_check').prop('checked', false)
      // change_recurring_check('');
      // change_recurring_check('de_');
      $('#work_type, #de_work_type').val("lab");
    } else {
      //tech
      $('.except_company_div, .de_except_company_div').show();
      $('#contents_tr_0, #contents_tr_0').show();
      $('.general_div, .de_general_div').hide();
      $('.lab_contents_tr, .de_lab_contents_tr').hide();
      $('.report_div, .de_report_div').hide();
      $('.tech_div, .de_tech_div').show();
      $(".sales_div, .de_sales_div").hide();
      $('#work_type, #de_work_type').val("tech");
      $('#title, #place, #de_title, #de_place').val("");
      //비공개 체크값 유지안하기(구분 바뀔때마다 비워주기)
      $('#nondisclosure_sch, #de_nondisclosure_sch').prop('checked', false)
      //반복일정 체크값 유지안하기(구분 바뀔때마다 비워주기)
      // $('#recurring_check, #de_recurring_check').prop('checked', false)
      // change_recurring_check('');
      // change_recurring_check('de_');
      contents_split_type('1');
    }
  })

  // $('#scheduleAdd').click(function () {
  // function sch_insert(mode){
  sch_insert = function (mode) {
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
    if ($('#endTime').val() == '') {
      alert('종료시간을 입력해주세요.');
      $('#endTime').focus();
      return false;
    }
    if ($('#'+mode+'workname').val() == '') {
      alert('작업구분을 입력해주세요.');
      $('#'+mode+'workname').focus();
      return false;
    }
    if ($('#'+mode+'work_type').val() == 'tech' && $('#'+mode+'supportMethod').val() == '') {
      alert('지원방법을 입력해주세요.');
      $('#'+mode+'supportMethod').focus();
      return false;
    }
    if ($('#'+mode+'work_type').val() == 'tech' && $('#'+mode+'customerName').val() == '') {
      alert('고객사를 선택해주세요.');
      $('#'+mode+'customerName').focus();
      return false;
    }
    if ($('#'+mode+'work_type').val() == 'general' && $('#'+mode+'title').val() == '') {
      alert('제목을 입력해주세요.');
      $('#'+mode+'title').focus();
      return false;
    }
    if ($('#'+mode+'work_type').val() == 'lab' && $('#'+mode+'dev_type').val() == '') {
      alert('개발구분을 선택해주세요.');
      $('#'+mode+'work_type').focus();
      return false;
    }
    if ($('#'+mode+'work_type').val() == 'lab' && $('#'+mode+'dev_page').val() == '') {
      alert('개발 페이지를 입력해주세요.');
      $('#'+mode+'dev_page').focus();
      return false;
    }
    if ($('#'+mode+'work_type').val() == 'lab' && $('#'+mode+'dev_develop').val() == '') {
      alert('개발사항을 입력해주세요.');
      $('#'+mode+'dev_develop').focus();
      return false;
    }
    if(($('#'+mode+'participant').val() == '') && $('#'+mode+'work_type').val() != 'company'){
      alert('참석자를 선택해주세요.');
      $('#'+mode+'participant').focus();
      return false;
    }

    // insert 직출 checked 선택했을때 y,n 값 넣어주는것
    if( $('#'+mode+'outside_work').is(":checked") ) {
      $('#'+mode+'outside_work').val('Y');
    } else {
      $('#'+mode+'outside_work').val('N');
    }

    //내용분할1
    //일정 내용 분할 값과 주간보고 여부를 배열로 만들어서 보내기
    var contents = [];
    if ($('#'+mode+'work_type').val() != 'lab') {
      var length = $('textarea[name='+mode+'contents]').length;
      if (length > 1) {
        for (var j = 1; j < length; j++) {
          //contents_0을 제외하고 나머지 contents들이 빈값인 상태일때는 해당 칸을 삭제하고 입력한다.
          if (($('#'+mode+'contents_' + j).val() == "") || ($('#'+mode+'contents_' + j).val() == "undefined")) {
            alert(j + 1 + "번째 내용이 비었습니다.");
            return false;
          }
        }
      }

      for (var i = 0; i < length; i++) { //내용이 분할 안된 것들도 0번 한번은 돌게 되어있기에 내용이 입력된다.
        // if (($('#contents_'+i).val()== "") || ($('#contents_'+i).val()== "undefined")) {
        //   alert("새로 추가한 " + i + "번째 내용이 비었습니다.");
        // }else{
        var contents_val = $('#'+mode+'contents_' + i).val();
        var contents_num_val = $('#'+mode+'contents_num_' + i).val();
        if ($('#'+mode+'add_weekly_report_' + i).is(':checked') == true) {
          var weekly_report_val = 'Y';
        } else {
          var weekly_report_val = 'N';
        }
        if ($('#'+mode+'work_type').val() == 'tech' ){
          var weekly_report_val = 'Y';
        }
        contents.push({
          'contents': contents_val,
          'contents_num': contents_num_val,
          'weekly_report': weekly_report_val
        })
        // }
      }
    } else {
      var dev_type = $("#"+mode+"dev_type").val();
      var dev_page = $("#"+mode+"dev_page").val();
      var dev_requester = $(""+mode+"#dev_requester").val();
      var dev_develop = $(""+mode+"#dev_develop").val();
      if ($("#"+mode+"dev_complete").is(':checked')==true){
        var dev_complete = 'Y';
      } else {
        var dev_complete = 'N';
      }

      var contents_val = "dev_type:::"+dev_type+",,,dev_page:::"+dev_page+",,,dev_requester:::"+dev_requester+",,,dev_develop:::"+dev_develop+",,,dev_complete:::"+dev_complete;
      contents.push({
        'contents': contents_val,
        'contents_num': 0,
        'weekly_report': 'Y'
      })
      // console.log(contents);
    }
    // for(var i = 0; i < length; i++){
    //   if (($('#contents_'+i).val()== "") || ($('#contents_'+i).val()== "undefined")) {
    //     alert("새로 추가한 " + i + "번째 내용이 비었습니다.");
    //   }else{
    //     var contents_val = $('#contents_'+i).val();
    //     var contents_num_val = $('#contents_num_'+i).val();
    //     if($('#add_weekly_report_'+i).is(':checked') == true){
    //       var weekly_report_val = 'Y';
    //     }else{
    //       var weekly_report_val = 'N';
    //     }
    //     contents.push({
    //       'contents':contents_val,
    //       'contents_num':contents_num_val,
    //       'weekly_report':weekly_report_val
    //     })
    //   }
    // }
    //내용분할2

    var startDay = $('#'+mode+'startDay').val();
    var startTime = $('#'+mode+'startTime').val();
    var endDay = $('#'+mode+'endDay').val();
    var endTime = $('#'+mode+'endTime').val();
    var workname = $('#'+mode+'workname').val();
    var outside_work = $('#'+mode+'outside_work').val();

    //KI1@@@@@
    // var customer = $('#customer').val();
    var work_type = $('#'+mode+'work_type').val();
    var customer = $('#'+mode+'customerName').val();
    var customer2 = $('#'+mode+'customerName2').val();
    var visitCompany = $('#'+mode+'visitCompany').val();
    var project = $('#'+mode+'project').val();
    var forcasting_seq = $('#'+mode+'forcasting_seq').val();
    //KI2@@@@@
    var supportMethod = $('#'+mode+'supportMethod').val();
    var participant = $('#'+mode+'participant').val();
    // var contents = $('#contents').val();
    // var insertDirect = $('#insertDirect').val();
    var title = $('#'+mode+'title').val();
    var place = $('#'+mode+'place').val();
    var maintain_seq = $('#'+mode+'maintain_seq').val();
    // var customer_manager = $('#customer_manager').val();

    var room_name = $('#'+mode+'room_name').val();
    var car_name = $('#'+mode+'car_name').val();
    if (room_name == '' && car_name != '') {
      var type = 'car_name';
      var name = car_name;
    } else {
      var type = 'room_name';
      var name = room_name;
    }
    // if($('#add_weekly_report').is(":checked") == true){
    //   var weekly_report = 'Y';
    // }else{
    //   var weekly_report = 'N';
    // }
    if ($('#'+mode+'nondisclosure_sch').is(":checked") == true) {
      var nondisclosure = 'Y';
    } else {
      var nondisclosure = 'N';
    }

    var seq = "nan";

    //반복일정 recurring
    var recurring_date = [];
    var recurring_setting = '';
    if($('#'+mode+'recurring_check').is(':checked') == true){

      var cycle_eq_val = $('#'+mode+'recurring_select option').index($('#'+mode+'recurring_select option:selected')); //selected된 option의 index값 구하기
      var cycle_num_val = $('#'+mode+'recurring_select option:eq('+cycle_eq_val+')').attr('num'); //option에 num요소 값 가져오기
      var cycle_ex_eq_val = $('#'+mode+'recurring_select_ex option').index($('#'+mode+'recurring_select_ex option:selected')); //selected된 option의 index값 구하기
      var cycle_ex_num_val = $('#'+mode+'recurring_select_ex option:eq('+cycle_ex_eq_val+')').attr('num'); //option에 num요소 값 가져오기
      recurring_setting = 'cycle:' + cycle_num_val + ';;;cycle_ex:' + cycle_ex_num_val;

      var recurring_val= $('#'+mode+'recurring_select').val();
      var recurring_val_arr = recurring_val.split(',');

      var recurring_ex_opt_id = $('#'+mode+'recurring_select_ex').val();
      var recurring_ex_val = $('#'+recurring_ex_opt_id).val();

      if(recurring_ex_opt_id == mode+'recurring_endDay'){
        for(i = 0; i < recurring_val_arr.length; i++){
          if(recurring_val_arr[i] > recurring_ex_val){
            recurring_val_arr.splice(i);
          }
        }
        recurring_date = recurring_val_arr;

        recurring_setting += ';;;endday:' + recurring_ex_val;

      }else if(recurring_ex_opt_id == mode+'recurring_count'){
        if(recurring_val_arr.length < recurring_ex_val){
          alert('반복 일자가 해당 년을 벗어났습니다.');
          return;
        }
        for(j = 0; j < recurring_ex_val; j++){
          recurring_date.push(recurring_val_arr[j]);
        }

        recurring_setting += ';;;count:' + recurring_ex_val;

      };

    }

    // if( $('#de_recurring_seq').val() != ''){
    //   var recurring_seq = $('#de_recurring_seq').val();
    // }else{ //반복 아닌 일정 등록, 새로운 반복 일정 등록
    //   var recurring_seq = null;
    // }

    var startTime_2 = moment(startTime, 'HH:mm').format('HH:mm');
    var endTime_2 = moment(endTime, 'HH:mm').format('HH:mm');
    if (startTime_2 == '' && endTime_2 != '') {
      alert("시작시간을 먼저 작성해 주세요.");
      $('#endTime').val('');
      return false;
    }
    if ((startDay == endDay) && (startTime_2 > endTime_2)) {
      alert("종료시간이 시작시간보다 이전입니다.");
      $('#endTime').val('');
      return false;
      stopPropagation();
    }

    $.ajax({
      type: "POST",
      url: "/index.php/biz/schedule/duplicate_check",
      dataType: "json",
      data: {
        schedule_seq: seq,
        select_day: startDay,
        start: startTime,
        end: endTime,
        name: name,
        type: type
      },
      cache: false,
      async: false,
      success: function (data) {
        if (data == 'dupl') {
          alert('중복되는 차량 혹은 회의실이 있습니다.');
          stopPropagation();
        }
      }
    });



    // $.ajax({
    //   type: "POST",
    //   url:"/index.php/biz/schedule/sch_report_approval",
    //   dataType:"json",
    //   data:{
    //     startDay: startDay,
    //     endDay:endDay
    //   },
    //   cache:false,
    //   async:false,
    //   success: function(data) {
    //     // console.log(data);
    //     // alert(data['approval_yn']);
    //     if(data === 'Y'){
    //       alert('주간업무보고 결제가 완료된 일정은 수정할 수 없습니다.');
    //       // stopPropagation();
    //       info.revert();
    //       return false;
    //       // calendar.refetchEvents();
    //     }
    //   }
    // });




    //20210326 유사한 일정 확인
    if (work_type == 'tech' && duple_sch_chk === 'false') {
      $.ajax({
        type: "POST",
        url: "/index.php/biz/schedule/sch_duplicate_check",
        dataType: "json",
        data: {
          customer: customer,
          startDay: startDay
        },
        cache: false,
        async: false, //비동기방식
        success: function (data) {
          // alert(data.length);
          // console.log(typeof data);
          if (data.length > 0) {
            $("#duple_sch_popup").bPopup({
              //스크롤 안따라가도록 고정
              follow: [false, false]
            });
            //var i = 0;
            var duple_sch = '';
            duple_sch += '<tr><td colspan="10" height="2" bgcolor="#797c88"></td></tr><tr bgcolor="f8f8f9" class="t_top"><td width="5%" align="center" class="t_border">No.</td><td width="65%" align="center" class="t_border">일정</td><td width="15%" align="center" class="t_border">시작일</td><td width="15%" align="center" class="t_border">종료일</td></tr>';
            for (var i = 0; i < data.length; i++) {
              // data.forEach(function(){
              // console.log(data[i].work_type);
              duple_sch += '<tr><td colspan="5" height="1" bgcolor="#797c88"></td></tr><tr><td width="5%" height="10" align="center" style="font-weight:bold;">' + (i + 1) + '</td><td width="65%" class="t_border" align="left" style="font-weight:bold;">&nbsp;[' + data[i].participant + '] ' + data[i].customer + '/' + data[i].work_name + '/' + data[i].support_method + '</td><td width="15%" class="t_border" align="center" style="font-weight:bold;">' + data[i].start_day + '<br>' + data[i].start_time + '</td><td width="15%" class="t_border" align="center" style="font-weight:bold;">' + data[i].end_day + '<br>' + data[i].end_time + '</td></tr>';
              // i++;
              // })
            }
            duple_sch += '<tr><td colspan="10" height="2" bgcolor="#797c88"></td></tr><tr><td>&nbsp;</td></tr>';
            $('#duple_sch_list').html(duple_sch);
            // stopPropagation();
          } else {
            duple_sch_chk = 'true';
          }
        }
      });
    }

    if (work_type != 'tech' || duple_sch_chk === 'true') {
      $.ajax({
        type: "POST",
        url: "/index.php/biz/schedule/add_schedule",
        dataType: "json",
        data: {
          startDay: startDay,
          startTime: startTime,
          endDay: endDay,
          endTime: endTime,
          work_type: work_type,
          outside_work: outside_work,
          workname: workname,
          room_name: room_name,
          car_name: car_name,
          //KI1@@@@@
          // customer:customer,
          customer: customer,
          customer2: customer2,
          visitCompany: visitCompany,
          project: project,
          forcasting_seq: forcasting_seq,
          //KI2@@@@@
          supportMethod: supportMethod,
          participant: participant,
          contents: contents,
          title: title,
          place: place,
          maintain_seq: maintain_seq,
          // customer_manager:customer_manager,
          // weekly_report:weekly_report,
          nondisclosure: nondisclosure,
          recurring_date: recurring_date,
          recurring_setting:recurring_setting
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

  // });
  };

  // function add_schedule_action(sch_data){
  //   $.ajax({
  //     type: "POST",
  //     url: "/index.php/biz/schedule/duplicate_check",
  //     dataType: "json",
  //     data: {
  //       schedule_seq: sch_data['seq'],
  //       select_day: sch_data['startDay'],
  //       start: sch_data['startTime'],
  //       end: sch_data['endTime'],
  //       name: sch_data['name'],
  //       type: sch_data['type']
  //     },
  //     cache: false,
  //     async: false,
  //     success: function (data) {
  //       if (data == 'dupl') {
  //         alert('중복되는 차량 혹은 회의실이 있습니다.');
  //         stopPropagation();
  //       }
  //     }
  //   });
  //
  //   //20210326 유사한 일정 확인
  //   if (sch_data['work_type'] == 'tech' && duple_sch_chk === 'false') {
  //     $.ajax({
  //       type: "POST",
  //       url: "/index.php/biz/schedule/sch_duplicate_check",
  //       dataType: "json",
  //       data: {
  //         customer: sch_data['customer'],
  //         startDay: sch_data['startDay']
  //       },
  //       cache: false,
  //       async: false, //비동기방식
  //       success: function (data) {
  //         // alert(data.length);
  //         if (data.length > 0) {
  //           $("#duple_sch_popup").bPopup({
  //             //스크롤 안따라가도록 고정
  //             follow: [false, false]
  //           });
  //           //var i = 0;
  //           var duple_sch = '';
  //           duple_sch += '<tr><td colspan="10" height="2" bgcolor="#797c88"></td></tr><tr bgcolor="f8f8f9" class="t_top"><td width="5%" align="center" class="t_border">No.</td><td width="65%" align="center" class="t_border">일정</td><td width="15%" align="center" class="t_border">시작일</td><td width="15%" align="center" class="t_border">종료일</td></tr>';
  //           for (var i = 0; i < data.length; i++) {
  //             // data.forEach(function(){
  //             // console.log(data[i].work_type);
  //             duple_sch += '<tr><td colspan="5" height="1" bgcolor="#797c88"></td></tr><tr><td width="5%" height="10" align="center" style="font-weight:bold;">' + (i + 1) + '</td><td width="65%" class="t_border" align="left" style="font-weight:bold;">&nbsp;[' + data[i].participant + '] ' + data[i].customer + '/' + data[i].work_name + '/' + data[i].support_method + '</td><td width="15%" class="t_border" align="center" style="font-weight:bold;">' + data[i].start_day + '<br>' + data[i].start_time + '</td><td width="15%" class="t_border" align="center" style="font-weight:bold;">' + data[i].end_day + '<br>' + data[i].end_time + '</td></tr>';
  //             // i++;
  //             // })
  //           }
  //           duple_sch += '<tr><td colspan="10" height="2" bgcolor="#797c88"></td></tr><tr><td>&nbsp;</td></tr>';
  //           $('#duple_sch_list').html(duple_sch);
  //           // stopPropagation();
  //         } else {
  //           duple_sch_chk = 'true';
  //         }
  //       }
  //     });
  //   }
  //
  //   if (sch_data['work_type'] != 'tech' || duple_sch_chk === 'true') {
  //     $.ajax({
  //       type: "POST",
  //       url: "/index.php/biz/schedule/add_schedule",
  //       dataType: "json",
  //       data: {
  //         startDay: sch_data['startDay'],
  //         startTime: sch_data['startTime'],
  //         endDay: sch_data['endDay'],
  //         endTime: sch_data['endTime'],
  //         work_type: sch_data['work_type'],
  //         workname: sch_data['workname'],
  //         room_name: sch_data['room_name'],
  //         car_name: sch_data['car_name'],
  //         //KI1@@@@@
  //         // customer:customer,
  //         customer: sch_data['customer'],
  //         customer2: sch_data['customer2'],
  //         project: sch_data['project'],
  //         forcasting_seq: sch_data['forcasting_seq'],
  //         //KI2@@@@@
  //         supportMethod: sch_data['supportMethod'],
  //         participant: sch_data['participant'],
  //         contents: sch_data['contents'],
  //         title: sch_data['title'],
  //         place: sch_data['place'],
  //         maintain_seq: sch_data['maintain_seq'],
  //         // customer_manager:customer_manager,
  //         // weekly_report:weekly_report,
  //         nondisclosure: sch_data['nondisclosure'],
  //         // recurring_rrule: sch_data['recurring_rrule'],
  //         recurring_seq: sch_data['recurring_seq']
  //       },
  //       cache: false,
  //       async: false,
  //       success: function (data) {
  //         if (data == 'false') {
  //           result = 'false';
  //         }
  //         alert("등록되었습니다.");
  //         if(sch_data['mode'] == ''){
  //           $('#addpopup').bPopup().close();
  //         }else{
  //           $('#updateSchedule').bPopup().close();
  //         }
  //         duple_sch_chk = 'false';
  //         calendarRefresh();
  //       },
  //       error: function (request, status, error) {
  //         alert("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);
  //       }
  //     });
  //   }
  // }

  // 대시보드에서 예약하기 버튼 눌러서 접근했을 때
  var dash_rez_date = sessionStorage.getItem('dash_rez_date');
  if (dash_rez_date != null) {
    var rez_date = dash_rez_date;

    var sDate = new Date();
    var st = sDate.getHours();
    var sm = sDate.getMinutes();
    sDate.setHours(sDate.getHours() + 1);
    var et = sDate.getHours();
    if (sm < 10) {
      sm = "0" + sm;
    }
    var startTime = st + ':' + sm;
    var endTime = et + ':' + sm;

    $("#startDay").val(rez_date);
    $("#endDay").val(rez_date);
    $("#startTime").val(startTime);
    $("#endTime").val(endTime);
    $('#addpopup').bPopup({
      follow: [false, false]
    });

    sessionStorage.removeItem('dash_rez_date');
  }

});

function func_search() {
  if ($('#searchText').val() == '' && $('#work_nameSelect').val() == '' && $('#support_methodSelect').val() == '' && $('#customerSelect').val() == '') {
    alert('검색어를 입력하세요.');
    // stopPropagation();
    return false;
  }
  var search_text = $('#searchText').val();
  var re_search_text = search_text.trim();
  re_search_text = re_search_text.replace(/\s/gi, "");
  $('#searchText').val(re_search_text);

  search = 'true';
  calendarRefresh();
  calendarChangeView();

  $('#excelDownload').show();
  $('#searchReset').show();
}

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

function customPop() {
  $('#customPop').bPopup({
    follow: [false, false],
    position: ["auto", 0]
  });
  $(document).scrollTop(0);
}

function colorCustom(el) {
  var tr = $(el).closest('tr');
  var color = $(el).val();
  var type = $(el).attr('name');
  // console.log(type);
  if (type == "work_color") {
    tr.find(".printDemo").css('background-color', color);
  } else if (type == "text_color") {
    tr.find(".printDemo").css('color', color);
  }
}

function save_workColor() {
  sessionStorage.setItem('workColor', 'y');
  var tr = $("#workColor_tbl tr");
  $("#workColor_tbl tr").each(function () {
    var seq = $(this).attr('id');
    var color = $(this).find('.work_color').val();
    var textColor = $(this).find('.text_color').val();

    $.ajax({
      type: "POST",
      // cache:false,
      url: "/index.php/biz/schedule/updateWorkColor",
      dataType: "json",
      async: false,
      data: {
        seq: seq,
        color: color,
        textColor: textColor
      },
      success: function (data) {
        if (data == 'false') {
          result = 'false';
        }
      }
    });
  })
  if (result = 'true') {
    alert('저장을 성공하였습니다.');
    window.location.reload();
  } else {
    alert('저장을 실패하였습니다.');
    window.location.reload();
  }
}

function save_workColor_close() {
  $('#customPop').bPopup().close();
}

function colorChange(el) {
  var text = $(el).text();

  if (text == '사원별 보기') {
    $(el).text('업무별 보기');
    var type = 'user';
  } else {
    $(el).text('사원별 보기');
    var type = 'type';
  }

  $.ajax({
    type: 'POST',
    url: "/index.php/biz/schedule/colorChange",
    data: {
      type: type
    },
    cache: false,
    async: false
  }).done(function (data) {
    // console.log(data);
  })
}

function addUser_Btn() {
  $('#addUserpopup').bPopup({
    follow: [false, false]
  });
  // $('#addUserpopup').bPopup();
}

function closeBtn() {
  $('#addUserpopup').bPopup().close();
}

function report_closeBtn() {
  $('#unwrittenpopup').bPopup().close();
}

// function wow(){
//   console.log("aaa");
// }
// 회의실 예약 창 띄운 후 달력이랑 타임피커 그리기
function open_conference(mode) {
  $('#conference_div').bPopup({
    //스크롤 안따라가도록 고정
    follow: [false, false]
  });
  conference_select_day(mode);
  select_meeting_room(mode);

  // 회의실에 값이 있을 때 날짜 시간에 맞게 그려주기
  if (mode == 'insert') {
    $('#add_conference_btn').attr({
      'name': 'add_conference_btn'
    });
    var room_val = $('#room_name').val();
    var start = $('#startTime').val();
    var start_time = parseInt(start.replace(":", ""));
    var end = $('#endTime').val();
    var end_time = parseInt(end.replace(":", ""));
  } else {
    $('#add_conference_btn').attr({
      'name': 'update_conference_btn'
    });
    var room_val = $('#de_room_name').val();
    var start = $('#de_startTime').val();
    var start_time = parseInt(start.replace(":", ""));
    var end = $('#de_endTime').val();
    var end_time = parseInt(end.replace(":", ""));
  }

  if (room_val != '') {
    var room_arr = room_val.split("+");
    for (var i = 0; i < room_arr.length; i++) {
      var room_name = room_arr[i];
      $("#selectable tr[id=" + room_name + "] td").each(function () {
        var td_id = $(this).attr('id');
        if (td_id >= start_time && td_id <= end_time - 30) {
          $(this).addClass("ui-selected");
        }
      });

    }
    $("#selected_room_name").val(room_val);
    $("#select_room_result").append(start + end);
  }
}


// 달력 날짜 바뀔 때 마다 그 날의 회의실 일정 가져와야되는거 추가
function conference_select_day(mode) {
  if (mode == 'insert') {
    var day = $('#startDay').val();
  } else {
    var day = $('#de_startDay').val();
  }
  // var day = $('#de_startDay').val();
  $('#select_day').val(day);
  var day = day.replace(/-/g, '/');
  $('#select_date').datepicker({
    clearBtn: false
  })

  // $('.datepicker').css('width','90%');
  // $('.datepicker').css('height','98%');


  $('#select_date').datepicker('setDate', day).on("changeDate", function (e) {
    var select_day = moment(e.date).format('YYYY-MM-DD');
    // console.log(select_day);
    $('#select_day').val(select_day);

    select_meeting_room(mode);
  });
}


function select_meeting_room(mode) {
  //  날짜가 바뀔 때 마다 새로운 타임피커 만들어주기 위해 초기화시킨다
  $("#select_room_result").empty();
  $('#selected_room_name').val('');
  $("#selectable tr td[class='reserved']").each(function () {
    $(this).removeClass("reserved ui-selected");
    $(this).addClass("td_item ui-selectee");
  })

  $("#selectable td[id != 'room_name_td']").each(function () {
    $(this).removeClass("ui-selected");
    $(this).addClass("td_item ui-selectee");
  });

  $('#selectable').sortable({
    filter: ".dragable",
    item: ".dragable",
    cancel: ".reserved, .td_item",
  });

  // 셀렉터블 타임피커 만들기
  $('#selectable').selectable({
    filter: ".td_item",
    cancel: ".dragable, .reserved",
    stop: function () {

      var tr = $(this).closest('tr');
      var tr_id = tr.attr('id');
      $('#selected_room_name').val(tr_id);
      //   $("#selectable tr[id!="+tr_id+"] td").each(function(){
      //   $(this).removeClass("ui-selected");
      // })

      $(".selected_room").each(function () {
        $(this).removeClass("selected_room");
      });


      // var result = $( "#select_room_result" ).empty();
      // var index = $(this).find(".ui-selected").text();
      // result.append( index );
      // $('#selected_room_name').val(tr_id);
      // var a = $('.ui-selected').closest('tr').attr('id');
      $("#select_room_result").empty();
      // $("#select_room_name").empty();
      var selected_room = [];
      var selected_time = [];
      // $('.ui-selected').closest('tbody').attr('id')
      $('.ui-selected').each(function () {
        // $("#selectable td[class ='ui-selected']").each(function(){
        var body = $(this).closest('tbody').attr('id');
        if (body == "selectable") {
          var id = $(this).closest('tr').attr('id');
          // console.log(id);
          if (selected_room.indexOf(id) == -1) {
            selected_room.push(id);
          }
          var time = $(this).text();
          if (selected_time.indexOf(time) == -1) {
            selected_time.push(time);
          }
        }
      })
      // $("#select_room_name").append(selected_room);
      $("#select_room_result").append(selected_time);

      var tr_id = selected_room.join("+");
      // console.log(tr_id);
      $('#selected_room_name').val("");
      $('#selected_room_name').val(tr_id);

      // $("#selectable td[class ='ui-selected']").each(function(){
      //   var a = $('.ui-selected').closest('tr').attr('id');
      //   console.log(a);
      //   $("#select_room_name").append(a);

      // })
    }
  })

  // 그 날의 예약된 회의실이 있는지 조회 후 reserved 클래스로 만들어주기
  var select_day = $('#select_day').val();
  // console.log(select_day);
  $.ajax({
    type: "GET",
    url: "/index.php/biz/schedule/search_conference_room",
    dataType: "json",
    data: {
      select_day: select_day
    },
    cache: false,
    async: false,
    success: function (data) {
      //console.log(data);
      if (data != 'false') {
        var schedule_seq = 'nan';
        if (mode == 'detail') {
          schedule_seq = $('#de_seq').val();

        }
        //////////////////////////
        for (var i = 0; i < data.length; i++) {
          // var room_name = data[i].room_name;
          var reserve_room = data[i].room_name;
          var room_arr = reserve_room.split("+");
          for (var j = 0; j < room_arr.length; j++) {
            var room_name = room_arr[j];
            // console.log(room_name);

            var seq = data[i].seq;
            var start_time = data[i].start_time.substring(0, 5);
            var end_time = data[i].end_time.substring(0, 5);
            var id_start_time = parseInt(start_time.replace(":", ""));
            var id_end_time = parseInt(end_time.replace(":", ""));
            if (schedule_seq == seq) {
              $("#selectable tr[id=" + room_name + "] td").each(function () {
                var td_id = $(this).attr('id');
                if (td_id >= id_start_time && td_id <= id_end_time - 30) {
                  $(this).addClass("ui-selected");
                  if (start_time != $('#de_startTime').val() || end_time != $('#de_endTime').val() || reserve_room != $('#de_room_name').val()) {
                    $(this).removeClass("ui-selected");
                  }
                }
              })
            } else {
              var title = data[i].title;
              var participant = data[i].participant;
              // var tip = title + "<br/>" + participant + "<br/>" + "["+reserve_room+"]"+ start_time +"~"+end_time;
              $("#selectable tr[id=" + room_name + "] td").each(function () {
                var td_id = $(this).attr('id');
                if (td_id >= id_start_time && td_id <= id_end_time - 30) {
                  $(this).removeClass("td_item ui-selectee ui-selected");
                  $(this).addClass("reserved");
                  var userName = data[i].user_name + " (" + data[i].insert_date + ")";
                  var tooltip_text = "<h3>" + data[i].title + "</h3>";
                  tooltip_text += "<div><span class='text-point'>[구 분]<span class='text-normal'>&nbsp;" + data[i].work_name + "</span></span><br>";
                  tooltip_text += "<span class='text-point'>[참석자]<span class='text-normal'>&nbsp;" + data[i].participant + "</span></span><br>";
                  tooltip_text += "<span class='text-point'>[등록자]<span class='text-normal'>&nbsp;" + userName + "</span></span></div>";
                  $(this).find('.tooltip-content').html(tooltip_text);
                }
              })
            }
          }
        }
        // ///////////////////////////
      }
    }
  });
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

// 등록 버튼 눌렀을 때
function add_conference(name) {
  if (name == 'update_conference_btn') {
    var schedule_seq = $('#de_seq').val();
    $('#de_car_name').val('');
  } else {
    var schedule_seq = 'nan';
    $('#car_name').val('');
  }

  var select_day = $('#select_day').val();
  var list = $("#select_room_result").text();
  var start = list.substring(0, 5);
  var end = list.substring(list.length - 5);
  var room_name = $('#selected_room_name').val();
  var type = 'room_name';
  if (room_name != "" && start == end) {
    alert('이미 예약된 회의실입니다.')
    // return false;
    stopPropagation();
  }

  $.ajax({
    type: "POST",
    url: "/index.php/biz/schedule/duplicate_check",
    dataType: "json",
    data: {
      schedule_seq: schedule_seq,
      select_day: select_day,
      start: start,
      end: end,
      name: room_name,
      type: type
    },
    cache: false,
    success: function (data) {
      if (data == 'dupl') {
        alert('이미 예약된 회의실입니다.')
      } else {
        var list = $("#select_room_result").text();
        var start = list.substring(0, 5);
        //  if(mobile){
        //   var end = list.substring(list.length - 5);
        //   end = Number(end.substring(0,2))+1+":00";
        //  }else{
          var end = list.substring(list.length - 5);
        //  }
        var select_day = $('#select_day').val();
        if (name = 'update_conference_btn') {
          $('#de_startTime').val(start);
          $('#de_endTime').val(end);
          // var room_name =($(".ui-selected").closest('tr').attr('id'));
          $('#de_room_name').val(room_name);
          // console.log($('.active day').html());
          // console.log(select_day);
          $('#de_startDay').val(select_day);
          $('#de_endDay').val(select_day);
        }
        if (name = 'add_conference_btn') {
          $('#startTime').val(start);
          $('#endTime').val(end);
          // }
          // var room_name =($(".ui-selected").closest('tr').attr('id'));
          $('#room_name').val(room_name);
          // console.log($('.active day').html());
          // console.log(select_day);
          $('#startDay').val(select_day);
          $('#endDay').val(select_day);
        }
        $('#conference_div').bPopup().close();
      }
    }
  });
}

// 회의실 등록하고 날짜바꾸면 등록없애
function conference_room_del(mode) {
  if (mode == 'insert') {
    var start_day = $('#startDay').val();
    var end_day = $('#endDay').val();
    var room_name = $('#room_name').val();

    if (room_name != '' && start_day != end_day) {
      $('#room_name').val('');
    }
  } else {
    var start_day = $('#de_startDay').val();
    var end_day = $('#de_endDay').val();
    var room_name = $('#de_room_name').val();

    if (room_name != '' && start_day != end_day) {
      $('#de_room_name').val('');
    }
  }
}

function open_car_reservation(mode) {
  $('#car_reservation_div').bPopup({
    //스크롤 안따라가도록 고정
    follow: [false, false]
  });
  car_select_day(mode);
  select_car(mode);
  // 차량에 값이 있을 때 날짜 시간에 맞게 그려주기
  if (mode == 'insert') {
    $('#add_car_btn').attr({
      'name': 'add_car_btn'
    });
    var car_val = $('#car_name').val();
    var start = $('#startTime').val();
    var start_time = parseInt(start.replace(":", ""));
    var end = $('#endTime').val();
    var end_time = parseInt(end.replace(":", ""));
  } else {
    $('#add_car_btn').attr({
      'name': 'update_car_btn'
    });
    var car_val = $('#de_car_name').val();
    var start = $('#de_startTime').val();
    var start_time = parseInt(start.replace(":", ""));
    var end = $('#de_endTime').val();
    var end_time = parseInt(end.replace(":", ""));
  }
  if (car_val != '') {
    $("#select_car_tbody tr[id=" + car_val + "] td").each(function () {
      var td_id = $(this).attr('id');
      if (td_id >= start_time && td_id <= end_time - 30) {
        $(this).addClass("ui-selected");
      }
    });
    $("#selected_car_name").val(car_val);
    $("#select_car_result").append(start + end);
  }
}

// 달력 날짜 바뀔 때 마다 그 날의 차량 일정 가져와야되는거 추가
function car_select_day(mode) {
  if (mode == 'insert') {
    var day = $('#startDay').val();
  } else {
    var day = $('#de_startDay').val();
  }
  // var day = $('#de_startDay').val();
  $('#select_car_day').val(day);
  var day = day.replace(/-/g, '/');
  $('#select_car_date').datepicker({
    clearBtn: false
  })
  $('#select_car_date').datepicker('setDate', day).on("changeDate", function (e) {
    var select_car_day = moment(e.date).format('YYYY-MM-DD');
    $('#select_car_day').val(select_car_day);
    select_car(mode);
  });
}

function select_car(mode) {
  //  날짜가 바뀔 때 마다 새로운 타임피커 만들어주기 위해 초기화시킨다
  $("#select_car_result").empty();
  $('#selected_car_name').val('');
  $("#select_car_tbody tr td[class='reserved']").each(function () {
    $(this).removeClass("reserved ui-selected");
    $(this).addClass("td_item ui-selectee");
  })

  $("#select_car_tbody td[name != 'car_info']").each(function () {
    $(this).removeClass("ui-selected");
    $(this).addClass("td_item ui-selectee");
  });
  // 셀렉터블 타임피커 만들기
  $('#select_car_tbody tr').selectable({
    filter: ".td_item",
    cancel: ".reserved",
    stop: function () {
      var tr = $(this).closest('tr');
      var tr_id = tr.attr('id');
      $('#selected_car_name').val(tr_id);
      $("#select_car_tbody tr[id!=" + tr_id + "] td").each(function () {
        $(this).removeClass("ui-selected");
      })
      $(".selected_car").each(function () {
        $(this).removeClass("selected_car");
      });
      var result = $("#select_car_result").empty();
      var index = tr.find(".ui-selected").text();
      result.append(index);
      $('#selected_car_name').val(tr_id);
    }
  });

  // 그 날의 예약된 회의실이 있는지 조회 후 reserved 클래스로 만들어주기
  var select_car_day = $('#select_car_day').val();
  $.ajax({
    type: "GET",
    url: "/index.php/biz/schedule/search_car",
    dataType: "json",
    data: {
      select_car_day: select_car_day
    },
    cache: false,
    async: false,
    success: function (data) {
      // console.log(data);
      if (data != 'false') {
        var schedule_seq = 'nan';
        if (mode == 'detail') {
          schedule_seq = $('#de_seq').val();
        }
        for (var i = 0; i < data.length; i++) {
          var seq = data[i].seq;
          var car_name = data[i].car_name;
          var start_time = data[i].start_time.substring(0, 5);
          var end_time = data[i].end_time.substring(0, 5);
          var id_start_time = parseInt(start_time.replace(":", ""));
          var id_end_time = parseInt(end_time.replace(":", ""));
          if (schedule_seq == seq) {
            $("#select_car_tbody tr[id=" + car_name + "] td").each(function () {
              var td_id = $(this).attr('id');
              if (td_id >= id_start_time && td_id <= id_end_time - 30) {
                $(this).addClass("ui-selected");
                if (start_time != $('#de_startTime').val() || end_time != $('#de_endTime').val() || car_name != $('#de_car_name').val()) {
                  $(this).removeClass("ui-selected");
                }
              }
            })
          } else {
            $("#select_car_tbody tr[id=" + car_name + "] td").each(function () {
              var td_id = $(this).attr('id');
              if (td_id >= id_start_time && td_id <= id_end_time - 30) {
                $(this).removeClass("td_item ui-selectee ui-selected");
                $(this).addClass("reserved");
                var userName = data[i].user_name + " (" + data[i].insert_date + ")";
                var tooltip_text = "<h3>" + data[i].title + "</h3>";
                tooltip_text += "<div><span class='text-point'>[구 분]<span class='text-normal'>&nbsp;" + data[i].work_name + "</span></span><br>";
                tooltip_text += "<span class='text-point'>[참석자]<span class='text-normal'>&nbsp;" + data[i].participant + "</span></span><br>";
                tooltip_text += "<span class='text-point'>[등록자]<span class='text-normal'>&nbsp;" + userName + "</span></span></div>";
                $(this).find('.tooltip-content').html(tooltip_text);
              }
            })
          }
        }
      }
    }
  });
}

// 등록 버튼 눌렀을 때
function add_car(name) {
  if (name == 'update_car_btn') {
    var schedule_seq = $('#de_seq').val();
    $('#de_room_name').val('');
  } else {
    var schedule_seq = 'nan';
    $('#room_name').val('');
  }

  var select_car_day = $('#select_car_day').val();
  var list = $("#select_car_result").text();
  var start = list.substring(0, 5);
  var end = list.substring(list.length - 5);
  var car_name = $('#selected_car_name').val();
  var type = 'car_name';
  // alert(start+"~"+end+"/"+car_name);
  // return false;
  // stopPropagation();
  $.ajax({
    type: "POST",
    url: "/index.php/biz/schedule/duplicate_check",
    dataType: "json",
    data: {
      schedule_seq: schedule_seq,
      select_day: select_car_day,
      start: start,
      end: end,
      name: car_name,
      type: type
    },
    cache: false,
    // async:false,
    success: function (data) {
      // console.log(data);
      if (data == 'dupl') {
        alert('이미 예약된 차량입니다.')
      } else {
        var list = $("#select_car_result").text();
        var start = list.substring(0, 5);
        var end = list.substring(list.length - 5);
        var select_car_day = $('#select_car_day').val();
        if (name = 'update_car_btn') {
          $('#de_startTime').val(start);
          $('#de_endTime').val(end);
          $('#de_car_name').val(car_name);
          $('#de_startDay').val(select_car_day);
          $('#de_endDay').val(select_car_day);
        }
        if (name = 'add_car_btn') {
          $('#startTime').val(start);
          $('#endTime').val(end);
          $('#car_name').val(car_name);
          $('#startDay').val(select_car_day);
          $('#endDay').val(select_car_day);
        }
        $('#car_reservation_div').bPopup().close();
      }
    }
  });
}

// 차량 등록하고 날짜바꾸면 등록없애
function car_reservation_del(mode) {
  if (mode == 'insert') {
    var start_day = $('#startDay').val();
    var end_day = $('#endDay').val();
    var car_name = $('#car_name').val();

    if (car_name != '' && start_day != end_day) {
      $('#car_name').val('');
    }
  } else {
    var start_day = $('#de_startDay').val();
    var end_day = $('#de_endDay').val();
    var car_name = $('#de_car_name').val();

    if (car_name != '' && start_day != end_day) {
      $('#de_car_name').val('');
    }
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

    // var searchName = '';
    // var searchNameArr = [];
    // //직급 제거하기
    // $.each(noneOverlapArr, function () {
    //   searchName = $(this)[0];
    //   searchName = searchName.split(' ')[0];
    //   searchNameArr.push(searchName)
    // })
    // var searchAdduser = searchNameArr.join(",");

    var searchAdduser = noneOverlapArr.join(",");
    $('#searchText').val('');
    $('#searchText').val(searchAdduser);
    $('#searchAddUserpopup').bPopup().close(); //모달 닫기
  } else {
    var noneOverlapArr = multiDimensionalUnique(checked_text); //$$
    // console.log(noneOverlapArr);

    $('#participant_box').html('');
    $('#participant').val('');
    $('#de_participant_box').html('');
    $('#de_participant').val('');
    insert_span_user_name(noneOverlapArr, 'participant')
    insert_span_user_name(noneOverlapArr, 'de_participant')

    $('#addUserpopup').bPopup().close(); //모달 닫기


    // var noneOverlapArr = unique(checked_text);
    //
    // var participantName = '';
    // var participantNameArr = [];
    // // 직급 제거하기
    // $.each(noneOverlapArr, function () {
    //   participantName = $(this)[0];
    //   participantName = participantName.split(' ')[0];
    //   participantNameArr.push(participantName);
    // })
    // // console.log(participantNameArr)
    // $('#participant_box').html('');
    // $('#participant').val('');
    // $('#de_participant_box').html('');
    // $('#de_participant').val('');
    // insert_span_user_name(participantNameArr, 'participant')
    // insert_span_user_name(participantNameArr, 'de_participant')
    //
    // $('#addUserpopup').bPopup().close(); //모달 닫기
  }
}

function searchSelFunc() {
  var selectVal = $('#searchSelect').val();
  if (selectVal == 'work_name') {
    $('#changeDiv').hide();
    $('#changeDiv3').hide();
    $('#changeDiv4').hide();
    $('#changeDiv2').show();
    $('#support_methodSelect').val('');
    $('#customerSelect').val('');
    $('#searchText').val('');
  } else if (selectVal == 'support_method') {
    $('#changeDiv').hide();
    $('#changeDiv2').hide();
    $('#changeDiv4').hide();
    $('#changeDiv3').show();
    $('#work_nameSelect').val('');
    $('#customerSelect').val('');
    $('#searchText').val('');
  } else if (selectVal == 'customer') {
    $('#changeDiv').hide();
    $('#changeDiv2').hide();
    $('#changeDiv3').hide();
    $('#changeDiv4').show();
    $('#customerSelect').select2({
      minimumResultsForSearch:10 //최소 10개 보여달라는것
    });
    $('#work_nameSelect').val('');
    $('#support_methodSelect').val('');
    $('#searchText').val('');
  } else {
    if (selectVal == 'participant') {
      $('#selectParticipantBtn').show(); //participant일 때 조직도 이미지 생성
      // $('#searchText').attr('onClick','searchAddUserBtn()'); //participant일 때 조직도 생성
      // $('#searchText').attr('readonly',true); ///participant일때 수기 입력 불가
      // $('#searchText').removeAttr('onkeyup'); //user_name일 아닐 때 한글만 입력 제거
    } else if (selectVal == 'user_name') {
      $('#selectParticipantBtn').hide(); //participant일 때 조직도 이미지 제거
      // $('#searchText').attr('onkeyup','this.value = onlyKor(this.value)'); //user_name일 때 한글만 입력
      $('#searchText').removeAttr('onClick'); //participant가 아닐 때 조직도 제거
      $('#searchText').attr('readonly', false); ///participant일때 수기 입력 가능
    } else {
      $('#selectParticipantBtn').hide(); //participant일 때 조직도 이미지 제거
      // $('#searchText').removeAttr('onkeyup'); //user_name일 아닐 때 한글만 입력 제거
      $('#searchText').removeAttr('onClick'); //participant가 아닐 때 조직도 제거
      $('#searchText').attr('readonly', false); ///participant일때 수기 입력 가능
    }
    $('#changeDiv2').hide();
    $('#changeDiv3').hide();
    $('#changeDiv4').hide();
    $('#changeDiv').show();
    $('#work_nameSelect').val('');
    $('#support_methodSelect').val('');
    $('#customerSelect').val('');
    $('#searchText').val('');
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
  // $('#searchAddUserpopup').bPopup();
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


$(function () {
  // if (isloaded) {
  //   return;
  // }else{
    var cookiedata = document.cookie;
    if (cookiedata.indexOf("todayCookie=done") < 0) {
      //오늘날짜 구하기
      function getTimeStamp() {
        var d = new Date();
        var s =
          leadingZeros(d.getFullYear(), 4) + '-' +
          leadingZeros(d.getMonth() + 1, 2) + '-' +
          leadingZeros(d.getDate(), 2);
        return s;
      }

      function leadingZeros(n, digits) {
        var zero = '';
        n = n.toString();
        if (n.length < digits) {
          for (i = 0; i < digits - n.length; i++) {
            zero += '0';
          }
        }
        return zero + n;
      }

      var today = getTimeStamp();
      var sessionName = $('#session_name').val();

      //오늘날짜를 송신해 날짜가 지났고 보고서가 미입력된 일정들 불러오기
      $.ajax({
        type: "POST",
        url: "/index.php/biz/schedule/tech_report",
        dataType: "json",
        data: {
          today: today,
          sessionName: sessionName
        },
        success: function (data) {
          var unwrittenText = '';
          $.each(data, function (index, item) {
            unwrittenText += '<li style="cursor:pointer;" onClick="reportClick(' + item.seq + ')">' + item.start_day + " ~ " + item.end_day + ' <br>[' + item.participant + ']' + item.customer + '/' + item.work_name + '/' + item.support_method + '</li><br>';
          })
          var unwrittenModal = '';
          unwrittenModal += '<div id="unwritten-modal-body">';
          unwrittenModal += '<div class="unwritten">';
          unwrittenModal += '<h4>미완료된 일정</h4>';
          unwrittenModal += '</div>';
          unwrittenModal += '<div id="report_notice_list">';
          unwrittenModal += '<ul style="margin-right : 20px;">';
          unwrittenModal += unwrittenText;
          unwrittenModal += '</ul>';
          unwrittenModal += '</div>';
          unwrittenModal += '<div id="report_notice_coment" class="unwritten">';
          unwrittenModal += '<span>※위 일정에 대한 기술지원보고서가 작성되지 않았습니다.※<br>일정을 클릭해 기술지원보고서를 작성해주세요.</span>';
          unwrittenModal += '</div>';
          unwrittenModal += '<div>';
          unwrittenModal += '<input type="checkbox" name="=" id="hideAllday" onclick="hideAlldayModal()" value=""><span>오늘 하루 이 창을 보지않기.</span>';
          unwrittenModal += '</div>';
          $('#unwrittenpopup').append(unwrittenModal);
          // unwrittenModal += '<span>'+unwrittenText+'</span>';
          // unwrittenModal += '</div>';
          if (data.length != 0) {
            $('#unwrittenpopup').bPopup({
              follow: [false, false]
            });
          }
        }
      });
    } else {
      $("#unwrittenpopup").bPopup().close();
    }

  //   isloaded = 'true';
  // }
});

function reportClick(seq) {
  $('#de_hiddenSeq').val(seq);
  $("#unwrittenpopup").bPopup().close();
  detail_modal(seq)
}

function hideAlldayModal() {
  setCookie("todayCookie", "done", 1);
  $("#unwrittenpopup").bPopup().close();
}
// $(document).ready(function () {
//     $("#hideAllday").click(function () {
//         setCookieMobile( "todayCookie", "done" , 1);
//         $("#unwrittenpopup").bPopup().close();
//     });
// });
// 24시간 기준 쿠키 설정하기
// expiredays 후의 클릭한 시간까지 쿠키 설정
function setCookie(name, value, expiredays) {
  var todayDate = new Date();
  todayDate.setDate(todayDate.getDate() + expiredays);
  document.cookie = name + "=" + escape(value) + "; path=/; expires=" + todayDate.toGMTString() + ";"
}

// function getCookie() {
//     var cookiedata = document.cookie;
//     if ( cookiedata.indexOf("todayCookie=done") < 0 ){
//       alert( cookiedata.indexOf("todayCookie=done"));
//       $("#unwrittenpopup").bPopup({follow:[false,false]});
//     }else {
//       alert( "no");
//       $("#unwrittenpopup").bPopup().close();
//     }
// }
// getCookie();


function searchTextChange(participant) {
  if (participant == 'participant') {

  } else {
    $('#searchText').removeattr("onClick");
    $('#searchText').attr("onClick", "searchAddUserBtn()");
  }
}

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
  if (start_date.getTime() > end_date.getTime()) {
    alert("종료일자가 시작일자보다 이전입니다.");
    $('#' + type + 'endDay').val('');
    return false;
  }
}

// 미완료된 일정 모달 띄울 때 tr클릭하면 해당 일정 상세모달 띄우는 함수
// function detail_modal 수정시
// 일정 클릭시 이벤트 상세페이지 이동 부분도 같이 수정!!!
//
function detail_modal(seq) {
  $.ajax({
    type: 'GET',
    dataType: "json",
    url: "/index.php/biz/schedule/tech_schedule_detail",
    data: {
      seq: seq
    },
    cache: false,
    // async:false
  }).done(function (result) {
    if (result) {
      $('#updateSchedule').bPopup({
        //스크롤 안따라가도록 고정
        follow: [false, false]
      });
      $('#techReportInsert, #techReportModify').hide();
      $('#de_startTime').show();
      $('#de_endTime').show();
      $('#usertree').jstree("deselect_all");
      $('#usertree').jstree("close_all");
      // console.log(result);
      var details = result.details;
      var contents = result.contents;

      var seq = details.seq;
      var customer_manager = details.customer_manager;
      var forcasting_seq = details.forcasting_seq;
      var maintain_seq = details.maintain_seq;

      var start_day = details.start_day;
      var start_time = moment(details.start_time, 'HH:mm').format('HH:mm');
      // var start_time = details.start_time;
      var end_day = details.end_day;
      var end_time = moment(details.end_time, 'HH:mm').format('HH:mm');
      // var end_time = details.end_time;
      var work_name = details.work_name;
      var title = details.title;
      var place = details.place;
      var support_method = details.support_method;
      var customer = details.customer;
      var project = details.project;
      var participant_val = details.participant;
      var tech_report = details.tech_report;
      var user_id = details.user_id;
      var user_name = details.user_name;
      var work_type = details.work_type;
      var room_name = details.room_name;
      var car_name = details.car_name;
      // var contents = details.contents;

      var start_reason = details.start_reason;
      var end_reason = details.end_reason;

      var s_file_changename = details.s_file_changename;
      var s_file_realname = details.s_file_realname;
      var e_file_changename = details.e_file_changename;
      var e_file_realname = details.e_file_realname;

      var outside_work = details.outside_work;

      $.ajax({
        type: "POST",
        dataType : "json",
        url: "<?php echo site_url();?>/biz/schedule/find_participant_seq",
        data: {
          participant: participant_val,
        },
        cache:false,
        async:false,
        success: function(result) {
          participant = result;
        }
      });

      //내용분할1
      //해당 seq일정의 내용이 몇 개로 분할되어 있는지 개수 확인
      var contents_length = contents.length;
      for (var i = 0; i < contents_length; i++) {
        // if(contents[i].contents_num == i){
        //불러온 분할 일정을 담을 tr이 존재하지 않을 경우 강제로 클릭시켜서 tr을 생성한다.
        if ($('#de_contents_' + i).length <= 0) {
          contents_add_action('de_contents')
        }
        //불러온 분할 일정을 for문으로 담는다.
        var contents_val = contents[i].contents;
        $('#de_contents_' + i).val(contents_val);
        // }
      }
      //내용분할2

      if (work_type == 'tech') {
        $('#de_work_type').val("tech");
        $('.de_except_company_div').show();
        $('.de_tech_div').show();
        $('.de_general_div').hide();
        $('.de_report_div').hide();
        if(support_method=="원격지원"){
          $('.de_tech_img_div').hide();
        } else if (support_method=='현장지원'){
          $('.de_tech_img_div').show();
        }

        if (s_file_realname != '') {
          $('.s_file_input_box').hide();
          $('.s_file_view_box').show();
          $('.s_file_img').text(s_file_realname);
          // $('#s_img_down').attr('href', '<?php echo $misc; ?>upload/biz/schedule/'+s_file_changename);
          // $('#s_img_down').attr('download', s_file_realname);
          $('#s_img_detail').attr('onclick','img_detail("'+s_file_changename+'")');
          $('#s_img_del').attr('onclick', 'del_img("'+s_file_changename+'", "s")');
        }
        if (s_file_realname == null) {
          $('.s_file_input_box').show();
          $('.s_file_view_box').hide();
        }
        if (e_file_realname != '') {
          $('.e_file_input_box').hide();
          $('.e_file_view_box').show();
          $('.e_file_img').text(e_file_realname);
          // $('#e_img_down').attr('href', '<?php echo $misc; ?>upload/biz/schedule/'+s_file_changename);
          // $('#e_img_down').attr('download', s_file_realname);
          $('#e_img_detail').attr('onclick','img_detail("'+e_file_changename+'")');
          $('#e_img_del').attr('onclick', 'del_img("'+e_file_changename+'", "e")');
        }
        if (e_file_realname == null) {
          $('.e_file_input_box').show();
          $('.e_file_view_box').hide();
        }
        //회사 공지사항 일정 참석자 제거 or 생성
      } else if (work_type == 'company') {
        $('#de_work_type').val("company");
        $('.de_except_company_div').hide();
        $('.de_tech_div, .de_tech_img_div').hide();
        $('.de_general_div').show();
        $('.de_report_div').hide();
      } else {
        $('#de_work_type').val("general");
        $('.de_except_company_div').show();
        $('.de_tech_div, .de_tech_img_div').hide();
        $('.de_general_div').show();
        $('.de_report_div').show();
      }
      $('#de_seq').val(seq);
      $('#de_work_type').val(work_type);
      $('#de_customer_manager').val(customer_manager);
      $('#de_forcasting_seq').val(forcasting_seq);
      $('#de_maintain_seq').val(maintain_seq);
      $('#de_room_name').val(room_name);
      $('#de_car_name').val(car_name);

      $('#de_startDay').val(start_day);
      $('#de_startTime').val(start_time);
      $('#de_endDay').val(end_day);
      $('#de_endTime').val(end_time);
      $('#de_title').val(title);
      $('#de_place').val(place);
      $('#de_customerName').val(customer);
      $('#de_customerName2').val(customer);
      // if(work_type == "general"){
      //   $('#de_customerName2').val(customer);
      // }else if(work_type == "tech"){
      //   $('#de_customerName').val(customer);
      // }else{
      //   $('#de_customerName').val('');
      // }
      $('#de_project').val(project);
      $('#de_start_reason').val(start_reason);
      $('#de_end_reason').val(end_reason);

      // $('#de_participant').val(participant);
      // var split_de_participant = participant.split(','); //$$
      // console.log(split_de_participant);
      // insert_span_user_name(split_de_participant, 'de_participant'); //$$

      var de_participant_arr = []; //$$
      var split_de_participant = participant.split(','); //$$
      // console.log(participant);
      for(i = 0; i < split_de_participant.length; i++){ //$$
        var split_de_participant2 = split_de_participant[i].split('_'); //$$
        var name = split_de_participant2[0]; //$$
        var seq = split_de_participant2[1]; //$$
        de_participant_arr.push({'name':name, 'seq':seq}); //$$
      }
      insert_span_user_name(de_participant_arr, 'de_participant'); //$$

      $('#de_contents').val(contents);
      $("#de_supportMethod").val(support_method).prop("selected", true);
      $("#de_workname").val(work_name).prop("selected", true);
      if (work_name == '납품설치' || work_name == '미팅' || work_name == '데모(BMT)지원') {
        $('#de_customer').val(forcasting_seq);
      } else {
        //포캐스팅+유지보수
        if(maintain_seq == null ){
          $('#de_customer').val(forcasting_seq);
        }else{
          $('#de_customer').val(maintain_seq);
        }
      }

      if (start_time == '00:00:00' && end_time == '00:00:00') {
        $("#de_startTime, #de_startTimeBtn, #de_endTime, #de_endTimeBtn").hide();
        $("input:checkbox[id='de_alldayCheck']").prop("checked", true);
      }

      if ($('#de_forcasting_seq').val() != "" && $('#de_maintain_seq').val()) {
        $('#de_customerName').attr('readonly', true);
        $('#de_project').attr('readonly', true);
      }

      var register = details.user_id;
      var regGroup = details.group;
      var regPgruop = details.p_group;
      //KI1 20210125
      var regParticipant = details.participant;
      var session_name = result.session_name;
      var session_id = result.session_id;
      var login_gruop = result.login_gruop;
      var login_pgroup = result.login_pgroup;
      var login_user_duty = result.login_user_duty;
      //선영
      var approval_yn = details.approval_yn;

      if (((register == session_id) || (login_user_duty == '팀장' && login_gruop == regGroup) || (login_user_duty == '이사' && login_pgroup == regPgruop) || (regParticipant.indexOf(session_name) > -1)) && approval_yn != "Y") { //indexOf값이 -1이 아니면 regParticipant 안에 본인이 들어가 있다는 것
        $("#updateSchedule").find("input, select, button, textarea").prop("disabled", false);
        $("#schdule_contoller_btn").show();
        $("#schdule_contoller_btn2").hide();
      } else { //
        $("#updateSchedule").find("input, select, button, textarea").prop("disabled", true);
        $("#de_participant_input").prop("disabled", false);
        $("#de_participant").prop("disabled", false);
        $("#updateSubmit").prop("disabled", false);
        // $("#updateSchedule").find("button[name=updateSubmit], input[name=de_participant_input], input[name=de_participant]").prop("disabled",false);
        $("#schdule_contoller_btn").hide();
        $("#schdule_contoller_btn2").show();
      }

      var sday = details.start_day;
      sday = new Date(sday);
      var eday = details.end_day;
      eday = new Date(eday);
      var today = new Date();

      var dateDiff = Math.ceil((eday.getTime() - sday.getTime()) / (1000 * 3600 * 24)) + 1;

      <?php if(!$this->agent->is_mobile()){?>
      $('#de_startTime, #de_endTime').timepicker({
          minuteStep: 10,
          showMeridian: false
      });
      <?php } ?>
      $("#de_startDay, #de_endDay").datepicker();
      $('#de_startTime, #de_endTime, #de_startDay, #de_endDay').attr('readonly',false);
      $('#de_startTime, #de_endTime, #de_startDay, #de_endDay').attr('disabled',false);
      $('#de_startTime, #de_endTime, #de_startDay, #de_endDay').css('background-color','#FFFFF2');

      if (work_type == 'tech') {
        if ((start_reason != null || s_file_changename != null)) {
          var workDate = $("#de_startDay");
          var workTime = $("#de_startTime");

          workDate.attr('readonly',true);
          workDate.css('background-color','rgb(199, 199, 199)');
          workTime.attr('readonly',true);
          workTime.css('background-color','rgb(199, 199, 199)');
          workDate.datepicker("destroy");
          var clone = workTime.clone();
          var parent = workTime.parent();
          <?php if($this->agent->is_mobile()){?>
            workDate.attr('disabled', true);
            clone.attr('disabled', true);
            <?php } ?>
          workTime.remove();
          parent.append(clone);
        }
        if ((end_reason != null || e_file_changename != null)) {
          var workDate = $("#de_endDay");
          var workTime = $("#de_endTime");

          workDate.attr('readonly',true);
          workDate.css('background-color','rgb(199, 199, 199)');
          workTime.attr('readonly',true);
          workTime.css('background-color','rgb(199, 199, 199)');
          workDate.datepicker("destroy");
          var clone = workTime.clone();
          var parent = workTime.parent();
          <?php if($this->agent->is_mobile()){?>
            workDate.attr('disabled', true);
            clone.attr('disabled', true);
            <?php } ?>
          workTime.remove();
          parent.append(clone);
        }
        if (s_file_realname != '') {
          $('.s_file_input_box').hide();
          $('.s_file_view_box').show();
          $('.s_file_img').text(s_file_realname);
          // $('#s_img_down').attr('href', '<?php echo $misc; ?>upload/biz/schedule/'+s_file_changename);
          // $('#s_img_down').attr('download', s_file_realname);
          $('#s_img_detail').attr('onclick','img_detail("'+s_file_changename+'")');
          $('#s_img_del').attr('onclick', 'del_img("'+s_file_changename+'", "s")');
        }
        if (s_file_realname == null) {
          $('.s_file_input_box').show();
          $('.s_file_view_box').hide();
        }
        if (e_file_realname != '') {
          $('.e_file_input_box').hide();
          $('.e_file_view_box').show();
          $('.e_file_img').text(e_file_realname);
          // $('#e_img_down').attr('href', '<?php echo $misc; ?>upload/biz/schedule/'+e_file_changename);
          // $('#e_img_down').attr('download', e_file_realname);
          $('#e_img_detail').attr('onclick','img_detail("'+e_file_changename+'")');
          $('#e_img_del').attr('onclick', 'del_img("'+e_file_changename+'", "e")');
        }
        if (e_file_realname == null) {
          $('.e_file_input_box').show();
          $('.e_file_view_box').hide();
        }
      }

      var outside_eday = details.end_day;
      var outside_today = '<?php echo date('Y-m-d'); ?>';
      outside_eday = outside_eday.replace(/-/g, '');
      outside_today = outside_today.replace(/-/g, '');

      if (outside_eday < outside_today) {
        $('#de_outside_work').prop('disabled', true);
      } else {
        $('#de_outside_work').prop('disabled', false);
      }

      if ( ((start_reason != null || s_file_changename != null) && (end_reason != null || e_file_changename != null)) || support_method == '원격지원' ) {
        if (tech_report == 0 && work_type == 'tech' && sday <= today) {
          $('#techReportModify').show();
        } else if (tech_report > 0 && work_type == 'tech' && sday <= today && dateDiff < 3) {
          $('#techReportInsert').show();
          // if (dateDiff > details.tech_report) {
          //   $('#techReportModify').show();
          // }
        }
      }
    }
  });
}


function company_schedule_check() {
  var chk = $('#company_schedule_checkbox').prop("checked");
  if (chk) {
    company_schedule_chk = 'true';
    calendarRefresh();
  } else {
    company_schedule_chk = 'false';
    calendarRefresh();
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
        // var user_name = '';
        // for(var i=0; data.length; i++){
        //   console.log(data[i].user_name);
        //   if(user_name != ''){
        //     user_name += ',';
        //     user_name += data[i].user_name;
        //     alert(user_name);
        //   }else{
        //     user_name += data[i].user_name;
        //     alert(user_name);
        //   }
        // }
        // $('#participant').val(user_name);

        // var length = data.length;
        // var user_name = data[length].user_name;
        // $('#participant').val(user_name);
        if (data === 'false') {
          alert("검색된 사용자가 없습니다.");
          $('#' + id + '_input').val('');
          // }else if(data === 'too many participant'){
          //   $('#addUserpopup').bPopup();
        } else {
          var user_name_arr = [];
          for (var i = 0; i < data.length; i++) {
            // console.log(user_name_arr);
            // if(user_name_arr.length <= 0){
            // user_name_arr.push(data[i].user_name); //$$
            user_name_arr.push({'name':data[i].user_name, 'seq':data[i].seq}); //$$
            //   console.log(1+' '+user_name_arr);
            // }else{
            //   user_name_arr.push(','+data[i].user_name);
            //   console.log(2+' '+user_name_arr);
            // }
          }
          // alert(user_name_arr);
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

  // var participant = $('#'+input_id).val();
  // var ex_participant = explode(',',participant);
  // var filter_participant = ex_participant.filter(function(element){element !== n_span});
  // var filter_participant = ex_participant.filter((element) => element !== n_span);
  // var im_participant = implode(',',filter_participant);
  //
  // $('#'+input_id).val(im_participant);
  // p_span.remove();
}

//비공개 일정 체크부분 표시/숨기기
function nondisclosure_form(mode) {

  var split_mode = mode.split('_');
  if (split_mode.length > 1) {
    var mode2 = 'de_';
  } else {
    var mode2 = '';
  }

  if ($('#' + mode + '_sch').is(":checked") == true) {
    $('.' + mode2 + 'except_nondisclosure_div').hide();
    // contents_split_type('1');
  } else {
    $('.' + mode2 + 'except_nondisclosure_div').show();
    // contents_split_type('2');
  }

  //작동 할 곳이 없는거 같음
  // $('input:checkbox[name=' + mode2 + 'add_weekly_report]').click(function () {
  //   alert(mode2);
  //   if ($('#' + mode + '_sch').is(":checked") == true) {
  //     alert('비공개 일정은 주간업무보고를 작성할 수 없습니다.');
  //     return false;
  //   }
  // });

}

function nondisclosure_weekly_report(mode){
  var split_mode = mode.split('_');
  if (split_mode.length > 1) {
    var mode2 = 'de_';
  } else {
    var mode2 = '';
  }
  if ($('#' + mode + '_sch').is(":checked") == true) {
    alert('비공개 일정은 주간업무보고를 작성할 수 없습니다.');
    $('input:checkbox[name=' + mode2 + 'add_weekly_report]').prop('checked',false);
    return false;
  }
};

//일정 내용 여러개 합치기
// function merge_contents() {
//   var length = $("textarea[name=contents]").length;
//   var contents = "";
//   // var contents_arr = array();
//   for (i=0; i < length; i++) {
//     if (($("textarea[name=contents]")[i].value== "") || ($("textarea[name=contents]")[i].value== "undefined")) {
//       alert(i + "번째는 비었습니다.");
//     } else {
//       contents += $("textarea[name=contents]")[i].value;
//       contents += ";@;";
//       // array_push(contents_arr,contents);
//     }
//   }
//   // console.log(contents);
//   $('#contents').val(contents);
// }


//내용분할1
//일정 내용 추가한 영역 삭제하기
function contents_del(idx, mode) {

  var split_mode = mode.split('_');
  if (split_mode.length > 1) {
    var mode2 = 'de_';
  } else {
    var mode2 = '';
  }

  var length = $("textarea[name=" + mode + "]").length;
  $("#" + mode + "_tr_" + idx).remove();
  var i = 1;
  for (j = 1; j < length; j++) {
    if ($('#' + mode + '_tr_' + j).length > 0) {
      $('#' + mode + '_tr_' + j).attr('id', mode + '_tr_' + i);
      $('#' + mode + '_tr_' + i).find('img').attr('onclick', 'contents_del(' + i + ',"' + mode + '"' + ')');
      $('#' + mode + '_tr_' + i).find('input:checkbox').attr('id', mode2 + 'add_weekly_report_' + i);
      $('#' + mode + '_tr_' + i).find('textarea').attr('id', mode + '_' + i);
      $('#' + mode + '_tr_' + i).find('input:hidden').attr({
        'id': mode + '_num_' + i,
        'value': i
      });
      i++;
    } else {
      continue;
    }
  }
  // k--;
}

//내용분할2

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
  // console.log(result);
})
// function Enter_Remove(){ // input 에서 enter 입력시 input type image의 onclick이 실행되기 때문에
// 	if(event.keyCode == 13){
// 		return false;
// 	}
// }

//숫자를 두자리 정수로 만들기
function numFormat(variable) {
  variable = Number(variable).toString();
  if(Number(variable) < 10 && variable.length == 1)
  variable = "0" + variable;
  return variable;
}


//반복일정 recurring
function change_recurring_select_ex(mode){
  var id = $('#'+mode+'recurring_select_ex').val();
  $('.input_ex').hide();
  $('#'+id).show();
}

//반복일정 recurring
function change_recurring_check(mode){
  if($('#'+mode+'recurring_check').is(':checked') == true){
    $('.'+mode+'recurring_div').show();
  }else{
    $('.'+mode+'recurring_div').hide();
  }
}


//반복일정 recurring
function recurring_form(mode,start){
// function recurring_form(mode,start,recurring_rrule){

  dayOfTheWeek_in_week(start);
  dayOfTheWeek_num_in_month(start);
  everyday(start);
  day_in_month(start);
  // week_num_in_month(startStr);
  var recurring_year = moment(start).format('YYYY');
  var recurring_month = moment(start).format('MM');
  var recurring_day = moment(start).format('DD');
  // $('#'+mode+'recurring_month_day').text('매월 '+recurring_day+'일');
  // $('#'+mode+'recurring_month_day').val('FREQ=MONTHLY');

  // $('#'+mode+'recurring_year').text('매년 '+recurring_month+'월 '+recurring_day+'일');
  // $('#'+mode+'recurring_year').val('FREQ=YEARLY');

  // if(mode == ''){

  <?php if(!$this->agent->is_mobile()){?>
    // var recurring_endStr = moment(start).add(5, 'years').format('YYYY-MM-DD'); //그냥 subtract()는 값을 빼는 함수므로 add()를 써서 1년을 더해줌.
    var recurring_endStr = moment(start).format('YYYY') + '-12-31'; //그냥 subtract()는 값을 빼는 함수므로 add()를 써서 1년을 더해줌.
    datepicker_fun(mode+'recurring_endDay',recurring_endStr);
  <?php } ?>

    change_recurring_check(mode);
    // change_recurring_check('');

  // }else if(mode == 'de_'){
  //
  //   $('#de_recurring_count').val('');
  //   $('#de_recurring_endDay').val('');
  //
  //   if(recurring_rrule != null){
  //     $('#de_recurring_check').prop('checked',true);
  //     $('.de_recurring_div').show();
  //
  //     <?php //if(!$this->agent->is_mobile()){?>
  //     var recurring_split1 = recurring_rrule.split(':')[1];
  //     var recurring_split2 = recurring_split1.split(';');
  //     var recurring_split_key_value = [];
  //     for(i = 0; i < recurring_split2.length; i++){
  //       var recurring_split3 = recurring_split2[i].split('=');
  //       var key = recurring_split3[0];
  //       var value = recurring_split3[1];
  //       // array에 key value로 넣으려는데 아래와 같은 방식이면 key값은 무조건 문자열로 들어가고 동적으로 변경이 안되어 모든 key가 'key'로 들어가게 된다.
  //       //recurring_split_key_value.push({key: value})
  //       //그래서 동적인 key값을 주려면 아래처럼 key value를 매칭시켜서 넣어주여야 한다.
  //       recurring_split_key_value[key] = value;
  //     }
  //     if(recurring_split_key_value['UNTIL'] != null){
  //       var de_recurring_endStr = moment(recurring_split_key_value['UNTIL']).format('YYYY-MM-DD');
  //       datepicker_fun('de_recurring_endDay',de_recurring_endStr)
  //       $('#de_recurring_endDay_opt').prop('selected',true);
  //
  //     }else{
  //       $('#de_recurring_endDay_opt').prop('selected',false);
  //       // $('#de_recurring_endDay').val('');
  //       datepicker_fun('de_recurring_endDay','')
  //     }
  //
  //     if(recurring_split_key_value['COUNT'] != null){
  //       $('#de_recurring_count_opt').prop('selected',true);
  //       $('#de_recurring_count').val(recurring_split_key_value['COUNT']);
  //     }else{
  //       $('#de_recurring_count_opt').prop('selected',false);
  //       // $('#de_recurring_count').val('');
  //     }
  //
  //     if(recurring_split_key_value['FREQ'] == 'DAILY'){
  //       $('#de_recurring_day').prop('selected',true);
  //     }else if(recurring_split_key_value['FREQ'] == 'WEEKLY'){
  //       $('#de_recurring_week').prop('selected',true);
  //     }else if(recurring_split_key_value['FREQ'] == 'MONTHLY' && recurring_split_key_value['BYDAY'] == null){
  //       $('#de_recurring_month_day').prop('selected',true);
  //     }else if(recurring_split_key_value['FREQ'] == 'MONTHLY' && recurring_split_key_value['BYDAY'] != null){
  //       $('#de_recurring_month').prop('selected',true);
  //     }else if(recurring_split_key_value['FREQ'] == 'YEARLY'){
  //       $('#de_recurring_year').prop('selected',true);
  //     }
  //     change_recurring_select_ex('de_');
  //     <?php //} ?>
  //   }else{
  //     $('#de_recurring_check').prop('checked',false);
  //     $('.de_recurring_div').hide();
  //   }
  //
  // }
}

//반복일정 recurring
function everyday(target_date) {
  var recurring_year = moment(target_date).format('YYYY');
  var recurring_month = moment(target_date).format('MM');
  var recurring_day = moment(target_date).format('DD');

  //매일
  // $('#'+mode+'recurring_day').text('매일');
  $('#recurring_day, #de_recurring_day').text('매일');
  var start_date = new Date(target_date);
  var finish_date = new Date(recurring_year+'-12-31');
  var recurring_day_arr = [];
  while(start_date < finish_date){ //해당 일부터 YYYY-12-30 까지 출력
      var strDate = moment(start_date).format('YYYY-MM-DD');
      recurring_day_arr.push(strDate);
      start_date.setDate(start_date.getDate() + 1);
  }
  if(start_date == finish_date){
    last_date = moment(start_date).format('YYYY-MM-DD'); //YYYY-12-31 출력
    recurring_day_arr.push(last_date);
  }
  // $('#'+mode+'recurring_day').val(recurring_day_arr);
  $('#recurring_day, #de_recurring_day').val(recurring_day_arr);
}


function day_in_month(target_date) {
  var recurring_year = moment(target_date).format('YYYY');
  var recurring_month = moment(target_date).format('MM');
  var recurring_day = moment(target_date).format('DD');

  //매월 n일
  // $('#'+mode+'recurring_month_day').text('매월 '+recurring_day+'일');
  $('#recurring_month_day, #de_recurring_month_day').text('매월 '+recurring_day+'일');
  var recurring_month_day_arr = [];
  for(var i = Number(recurring_month); i < 13; i++){
    // var str_month = moment(String(i)).format('MM');
    var str_month = numFormat(i);
    // var val = moment(recurring_year+str_month+recurring_day).format('YYYY-MM-DD');
    var val = recurring_year + '-' + str_month + '-' + recurring_day;
    recurring_month_day_arr.push(val);
  }
  // $('#'+mode+'recurring_month_day').val(recurring_month_day_arr);
  $('#recurring_month_day, #de_recurring_month_day').val(recurring_month_day_arr);
}


function dayOfTheWeek_in_week(target_date) {

    var week = new Array('일요일', '월요일', '화요일', '수요일', '목요일', '금요일', '토요일');
    // var week2 = new Array('SU', 'MO', 'TU', 'WE', 'TH', 'FR', 'SA');
    // var week3 = new Array('sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat');

    var today = new Date(target_date).getDay();
    var todayLabel = week[today];
    // var todayLabel2 = week2[today];
    // var todayLabel3 = week3[today];

    $('#recurring_week, #de_recurring_week').text('매주 '+todayLabel);
    // $('#recurring_week, #de_recurring_week').val('FREQ=WEEKLY;BYDAY='+todayLabel2);

    var start = target_date;
    var start_date = new Date(start);
    var finish_year = moment(target_date).format('YYYY');
    var finish_date = new Date(finish_year + '-12-31');
    var recurring_dayOfweek_arr = [];
    var week = new Array('일요일', '월요일', '화요일', '수요일', '목요일', '금요일', '토요일');
    var today = new Date(start).getDay();
    var start_today = new Date(start).getDay();
    var todayLabel = week[today];
    while(start_date < finish_date){ //해당 일부터 YYYY-12-30 까지 출력
        if(week[start_today] == todayLabel){
            var strDate = moment(start_date).format('YYYY-MM-DD');
            recurring_dayOfweek_arr.push(strDate);
            start_date.setDate(start_date.getDate() + 7);
	          start_today = start_date.getDay();
        }
    }
    $('#recurring_week, #de_recurring_week').val(recurring_dayOfweek_arr);

}

//반복일정 recurring
function dayOfTheWeek_num_in_month(target_date){
  var week = new Array('일요일', '월요일', '화요일', '수요일', '목요일', '금요일', '토요일');
  var week2 = new Array('.fc-day-sun', '.fc-day-mon', '.fc-day-tue', '.fc-day-wed', '.fc-day-thu', '.fc-day-fri', '.fc-day-sat');
  // var week3 = new Array('SU', 'MO', 'TU', 'WE', 'TH', 'FR', 'SA');

  var today = new Date(target_date).getDay();
  var todayLabel = week[today];
  var todayLabel2 = week2[today];
  // var todayLabel3 = week3[today];

  // var tb = $('tbody').find('td[data-date=' + date + ']'); //임의의 tbody 중 해당 날짜가 있는 td(day)를 찾는다.
  // var p_tb = $(tb).parent().parent(); //찾은 td의 첫번째 부모는 tr(week), 두번째 부모는 tboby(해당 페이지에 뜨는 화면)이다.
  // var week_num = $(p_tb).children().length //tbody 아래에 있는 tr의 개수를 구한다.
  // var real_days = $(p_tb).find('.fc-day').not('.fc-day-other').not('.fc-day-sun').not('.fc-day-sat');

  // var real_days = $('tbody').find(todayLabel2).not('.fc-day-other').not('.fc-col-header-cell');
  // var real_days_length = real_days.length;
  // for(i = 0; i < real_days_length; i++){
  //   var real_date = real_days.eq(i).attr('data-date');
  //   if(real_date == target_date){
  //     var count_date = i+1;
  //     break;
  //   }else{
  //     continue;
  //   }
  // }

  var present_days = $('tbody').find(todayLabel2).not('.fc-day-other').not('.fc-col-header-cell');
  var present_days_length = present_days.length;
  for(i = 0; i < present_days_length; i++){
    var present_date = present_days.eq(i).attr('data-date');
    if(present_date == target_date){
      var present_day_date = moment(present_date).format('DD');
      var present_count_date =  Math.ceil(present_day_date/7);
      break;
    }else{
      continue;
    }
  }

  var future_days = $('tbody').find(todayLabel2 + '.fc-day-other.fc-day-future').not('.fc-col-header-cell');
  var future_days_length = future_days.length;
  for(k = 0; k < future_days_length; k++){
    var future_date = future_days.eq(k).attr('data-date');
    if(present_date == target_date){
      var future_day_date = moment(future_date).format('DD');
      var future_count_date =  Math.ceil(future_day_date/7);
      break;
    }else{
      continue;
    }
  }

  var past_days = $('tbody').find(todayLabel2 + '.fc-day-other.fc-day-past').not('.fc-col-header-cell');
  var past_date = past_days.eq(0).attr('data-date');
  var past_day_date = moment(past_date).format('DD');
  var past_count_date =  Math.ceil(past_day_date/7);

  // var test = getWeek(4,target_date);
  // var test = weekNumberByMonth(target_date);
  // console.log(test);

  if(present_count_date != undefined){
    var present_count_date_text = '매월 ' + present_count_date + '번째 '+ todayLabel;
    $('#recurring_month, #de_recurring_month').text(present_count_date_text);
  }else{
    if(future_count_date != undefined){
      var future_count_date_text = '매월 ' + future_count_date + '번째 '+ todayLabel;
      $('#recurring_month, #de_recurring_month').text(future_count_date_text);
    }else{
      var past_count_date_text = '매월 ' + past_count_date + '번째 '+ todayLabel;
      $('#recurring_month, #de_recurring_month').text(past_count_date_text);
    }
  }
  // var count_date_text = '매월 ' + count_date + '번째 '+ todayLabel;
  // $('#recurring_month, #de_recurring_month').text(count_date_text);
  // $('#recurring_month').val('FREQ=MONTHLY;BYDAY='  +todayLabel3 + ';BYSETPOS=' + count_date);
  // $('#de_recurring_month').val('FREQ=MONTHLY;BYDAY='  +todayLabel3 + ';BYSETPOS=' + count_date);

  var recurring_year = moment(target_date).format('YYYY'); // new Date().getFullYear();
  var recurring_month = moment(target_date).format('MM');  // new Date().getMonth() + 1;
  // var recurring_day = moment(target_date).format('DD');    // new Date().getDate();


  var recurring_dayOfweek_num_arr = [];
  var fake_recurring_dayOfweek_num_arr = [];
  for(var i = Number(recurring_month); i < 13; i++){ //남은 월 돌리기
    var str_month = numFormat(i);
    //해당 월 마지막 일 구하기 30 or 31
    var last = new Date( recurring_year, str_month );
    last = new Date( last - 1 );
    var last_day = last.getDate();

    for(j = 1; j <= Number(last_day); j++){ //해당 월의 모든 일의 요일을 구해서 해당일과 같은 요일인 날짜만 배열에 담는다.
      var fake_date =  recurring_year + '-' + str_month + '-' + j;
      var fake_today = new Date(fake_date).getDay();
      var fake_todayLabel = week[fake_today];
      if(fake_todayLabel == todayLabel){
        var fake_recurring_day = numFormat(j);
        var fake_date_push = recurring_year + '-' + str_month + '-' + fake_recurring_day;
        fake_recurring_dayOfweek_num_arr.push(fake_date_push);
      }
    }
    //해당월에 같은 요일인 일들만 담은 배열에서 클릭 날짜의 n번째 순서와 같은 날짜를 골라내 따로 배열에 다시 담는다.
    if(present_count_date != undefined){
      var date_push = fake_recurring_dayOfweek_num_arr[present_count_date-1];
    }else{
      if(future_count_date != undefined){
        var date_push = fake_recurring_dayOfweek_num_arr[future_count_date-1];
      }else{
        var date_push = fake_recurring_dayOfweek_num_arr[past_count_date-1];
      }
    }
    if(date_push != null && date_push != ''){
      recurring_dayOfweek_num_arr.push(date_push);
    }
    fake_recurring_dayOfweek_num_arr = [];

  }
  $('#recurring_month, #de_recurring_month').val(recurring_dayOfweek_num_arr);

  // alert(week_num);
  // F12에서 테스트한 내용 :
  // var tb = $('tbody').find('td[data-date=2021-06-08]');
  // var p_tb = $(tb).parent().parent();
  // var td = $(p_tb).find('td.fc-day-thu').not('.fc-day-other').eq(1);
  // $(td).parent().find('td[data-date=2021-06-08]')

  // F12에서 테스트한 내용 :
  // var tb = $('tbody').find('td[data-date=2021-06-08]');
  // var p_tb = $(tb).parent().parent();
  // var td = $(p_tb).find('td.fc-day-thu').not('.fc-day-other').eq(1);
  // var y_n = $(td).parent().find('td[data-date=2021-06-08]');
  // var real_days = $(p_tb).find('.fc-day').not('.fc-day-other').not('.fc-day-sun').not('.fc-day-sat');
  // var real_days_length = real_days.length;
  // real_days.eq(0).attr('data-date');
  // var date = $('tbody').find('.fc-day-mon').not('.fc-day-other').not('.fc-col-header-cell');
  // date.parent().find('td[data-date=2021-06-07]').parent();
  // var date_num = $('tbody').find('.fc-day-tue').not('.fc-day-other').not('.fc-col-header-cell').eq(0).attr('data-date');

}
// function week_num_in_month(date){
//   var week = new Array('일요일', '월요일', '화요일', '수요일', '목요일', '금요일', '토요일');
//
//   var today = new Date(date).getDay();
//   var todayLabel = week[today];
//
//   // $(".fc-week:eq("+i+")").find("div.fc-bg").find("td.fc-day:eq("+w+")");
//   // var tb = $('tbody').find('td[data-date=2021-05-31]');
//   var tb = $('tbody').find('td[data-date=' + date + ']'); //임의의 tbody 중 해당 날짜가 있는 td(day)를 찾는다.
//   var p_tb = $(tb).parent().parent(); //찾은 td의 첫번째 부모는 tr(week), 두번째 부모는 tboby(해당 페이지에 뜨는 화면)이다.
//   $(p_tb).children().length //tbody 아래에 있는 tr의 개수를 구한다.
//   var real_week_length = $(p_tb).find('td.fc-day-thu').not('.fc-day-other').length //주차의 기준이 그 달의 첫번째 목요일이 존재하는 주부터 기준이 되므로 지난달을 의미하는 fc-day-other 클래스를 포함하지 않은 fc-day-thu를 찾는다.
//   for(i = 0; i<real_week_length; i++){
//     var real_tr = $(p_tb).find('td.fc-day-thu').not('.fc-day-other').eq(i).parent(); //지난달이 포함되지 않은 주차를 하나씩 뽑아온다.
//     var real_td = $(real_tr).find('td[data-date=' + date + ']').length; //뽑아온 주차에 원하는 날짜가 들어가는지 확인한다. 들어가면 length가 0이 아닐 것이고 없으면 0일 것이다.
//     if(real_td > 0){
//       var week_num = i+1;
//       var week_num_text = '매월 '+ week_num + '주차 ' + todayLabel;
//       if(i == real_week_length-1){
//         var week_num_text2 = '매월 마지막 주차 ' + todayLabel;
//       }else{
//         var week_num_text2 = 'none';
//       }
//       break;
//     }else{
//       var week_num = 1;
//       continue;
//     }
//     // console.log(real_td);
//   }
//   $('#recurring_month').text(week_num_text);
//   if(week_num_text2 != 'none'){ //마지막 주차일 때 recurring_month옵션 뒤에 마지막 주차용 옵션을 넣어준다.
//     $('#recurring_month').after('<option value="" id="recurring_month2">' + week_num_text2 + '</option>');
//   }else{ //마지막 주차가 아닐 때는 마지막주차용 옵션을 제거한다.
//     $('#recurring_month2').remove();
//   }
//   // alert(week_num);
//   // F12에서 테스트한 내용 : var tb = $('tbody').find('td[data-date=2021-06-08]'); var p_tb = $(tb).parent().parent(); var td = $(p_tb).find('td.fc-day-thu').not('.fc-day-other').eq(1); $(td).parent().find('td[data-date=2021-06-08]')
// }

// function recurring_drop(seq, startDay, startTime, endDay, endTime, participant){
//   $.ajax({
//     type: 'POST',
//     url: "/index.php/biz/schedule/drop_update",
//     data: {
//       seq: seq,
//       start_day: startDay,
//       start_time: startTime,
//       end_day: endDay,
//       end_time: endTime,
//       participant: participant
//     },
//     cache: false,
//     async: false,
//     success: function (data) {
//       if (data == "report_written") {
//         alert('보고서가 작성된 일정은 수정할 수 없습니다.');
//         calendarRefresh();
//         // calendar.refetchEvents();
//       }
//       // console.log(data);
//       if (data == 'OK') {
//         // console.log('refetch');
//         calendarRefresh();
//         // calendar.refetchEvents();
//       }
//     }
//   });
// }

function getWeek(dowOffset,target_date) {
  /*getWeek() was developed by Nick Baicoianu at MeanFreePath: http://www.meanfreepath.com */

  dowOffset = typeof(dowOffset) == 'number' ? dowOffset : 0; // dowOffset이 숫자면 넣고 아니면 0
  var date = new Date(target_date);
  var newYear = new Date(date.getFullYear(),0,1);
  var day = newYear.getDay() - dowOffset; //the day of week the year begins on
  // var year = moment(target_date).format('YYYY');
  // var month = moment(target_date).format('MM');
  // var day = (moment(target_date).format('DD')) - dowOffset;
  day = (day >= 0 ? day : day + 7);
  var daynum = Math.floor((date.getTime() - newYear.getTime() -
    (date.getTimezoneOffset()-newYear.getTimezoneOffset())*60000)/86400000) + 1;
    // (this.getTimezoneOffset()-newYear.getTimezoneOffset())*60000)/86400000) + 1;
  var weeknum;
  //if the year starts before the middle of a week
  if(day < 4) {
    weeknum = Math.floor((daynum+day-1)/7) + 1;
    if(weeknum > 52) {
      let nYear = new Date(date.getFullYear() + 1,0,1);
      let nday = nYear.getDay() - dowOffset;
      nday = nday >= 0 ? nday : nday + 7;
      /*if the next year starts before the middle of
        the week, it is week #1 of that year*/
      weeknum = nday < 4 ? 1 : 53;
    }
  }
  else {
    weeknum = Math.floor((daynum+day-1)/7);
  }
  return weeknum;
};

$(document).on("change", ".file-input", function(){
  $filename = $(this).val().replace(/.*(\/|\\)/, '');
  var target = $(this).attr('name');
  if($filename == "")
    $filename = "파일을 선택해주세요.";
  $(this).closest("div").find("."+target+"").text($filename);
})

function timeImgChk(mode, callback) {
  const fileInfo = document.getElementById( 'de_' + mode + '_img' ).files[0];
  // alert(fileInfo);

  const reader = new FileReader();

  reader.onload = function() {
    EXIF.getData(fileInfo, function() {
      const tags = EXIF.getAllTags( fileInfo );

      if (mode == 'start') {
        var workDate = $("#de_startDay");
        var workTime = $("#de_startTime");
        var m = '시작';
      } else {
        var workDate = $("#de_endDay");
        var workTime = $("#de_endTime");
        var m = '종료';
      }
      if(tags.DateTime == undefined) {
        alert('사진 정보를 읽을 수 없습니다.\n원본 사진을 첨부해주세요.');
        $('#de_'+mode+"_img").val('');
        $('#de_'+mode+"_img").change();
        return false;
      }
      // alert('|'+tags.DateTime+'|');
      var img_date = tags.DateTime.split(" ")[0];

      var varUA = navigator.userAgent.toLowerCase();

      if ( varUA.indexOf("iphone") > -1||varUA.indexOf("ipad") > -1||varUA.indexOf("ipod") > -1 || (navigator.appName == 'Netscape' && varUA.indexOf('trident') != -1) || (varUA.indexOf("msie") != -1)) {
        img_date = img_date.replace(/:/gi,'/');
        // var wd = workDate.val().replace(/-/gi,'/');
      } else {
        img_date = img_date.replace(/:/gi,'-');
        // var wd = workDate.val();
      }
      var img_time = tags.DateTime.split(" ")[1];
      // var st = new Date(wd + " " + workTime.val());
      // var it = new Date(img_date + " " + img_time);

      if(!confirm("사진 찍은 날짜 : " + img_date + " " + img_time +"\n위 시간으로 일정 " + m + " 시간이 변경됩니다.")) {
        $('#de_'+mode+"_img").val('');
        $('#de_'+mode+"_img").change();
        return false;
      }

      if(mode == 'start') {
        workDate.val(img_date);
        img_time = img_time.split(':');
        workTime.val(img_time[0]+':'+img_time[1]);

        workDate.attr('readonly',true);
        workDate.css('background-color','rgb(199, 199, 199)');
        workTime.attr('readonly',true);
        workTime.css('background-color','rgb(199, 199, 199)');
        workDate.datepicker("destroy");
        var clone = workTime.clone();
        var parent = workTime.parent();
        workTime.remove();
        parent.append(clone);

        return true;
      } else if (mode == 'end') {
        img_time = img_time.split(':');
        var t_time = img_date + ' ' + img_time[0] + ':' + img_time[1];
        if (dateCheck(t_time)) {
          workDate.val(img_date);
          workTime.val(img_time[0]+':'+img_time[1]);

          workDate.attr('readonly',true);
          workDate.css('background-color','rgb(199, 199, 199)');
          workTime.attr('readonly',true);
          workTime.css('background-color','rgb(199, 199, 199)');
          workDate.datepicker("destroy");
          var clone = workTime.clone();
          var parent = workTime.parent();
          workTime.remove();
          parent.append(clone);

          return true;
        } else {
          $('#de_'+mode+"_img").val('');
          $('#de_'+mode+"_img").change();
          return false;
        }
      }

    });
  };

  if( fileInfo ) {
    reader.readAsDataURL( fileInfo );
  }
}

function dateCheck(t_time) {
  var startDate = $('#de_startDay').val() + ' ' + $('#de_startTime').val();
  var endDate = t_time;

  startDate = moment(startDate);
  endDate = moment(endDate);

  console.log(t_time);

  if(startDate > endDate) {
    alert('종료시간이 시작시간보다 이전입니다.');
    return false;
  }

  return true;
}

function del_img(change_filename, type) {
  var seq = $("#de_seq").val();

  $.ajax({
    type: "POST",
    dataType: "json",
    url: "<?php echo site_url(); ?>/biz/schedule/tech_img_del",
    data: {
      seq: seq,
      type: type,
      change_filename: change_filename
    },
    cache: false,
    async: false,
    success: function(result) {
      alert('삭제되었습니다.');
      detail_modal(seq);
    }
  })
}

function img_detail(fileName) {
  var img = '<img id="detail_img" src="<?php echo $misc; ?>upload/biz/schedule/'+fileName+'" style="width:150px;margin-top:10px;">';
  $("#thumbnail").html(img);

<?php if(!$this->agent->is_mobile()){?>
  var t = 500;
<?php } else { ?>
  var t = 1000;
<?php } ?>

  setTimeout(function() {
    get_exif();
  }, t);
}

function get_exif() {
  var detail_img = document.getElementById("detail_img");
  EXIF.getData(detail_img, function() {
    var allMetaData = EXIF.getAllTags(this);
    var make = allMetaData.Make;
    var model = allMetaData.Model;
    var dateTime = allMetaData.DateTime;
    var latitude = allMetaData.GPSLatitude;
    var longitude = allMetaData.GPSLongitude;

    $("#imgMake").text(make);
    $("#imgModel").text(model);
    $("#imgDateTime").text(dateTime);

    latitude_map = dmsToDec(latitude[0],latitude[1],latitude[2]);
    longitude_map = dmsToDec(longitude[0],longitude[1],longitude[2]);

    drawMap(latitude_map, longitude_map);
  });


  $("#img_detail").bPopup();
}

function dmsToDec(deg, min, sec) {
  return deg+(((min*60)+(sec))/3600);
}

function drawMap(lat, lng) {

  var mapContainer = document.getElementById('map'), // 지도를 표시할 div
      mapOption = {
          center: new kakao.maps.LatLng(lat, lng), // 지도의 중심좌표
          level: 5 // 지도의 확대 레벨
      };

  var map = new kakao.maps.Map(mapContainer, mapOption); // 지도를 생성합니다

  // 마커가 표시될 위치입니다
  var markerPosition  = new kakao.maps.LatLng(lat, lng);

  // 마커를 생성합니다
  var marker = new kakao.maps.Marker({
      position: markerPosition
  });

  // 마커가 지도 위에 표시되도록 설정합니다
  map.relayout();
  marker.setMap(map);

}

function supportMethod_change(el) {
  var support_method = $("#de_supportMethod").val();
  if(support_method=="원격지원"){
    $('.de_tech_img_div').hide();
  } else if (support_method=='현장지원'){
    $('.de_tech_img_div').show();
  }
}

// $(function() {
//   var login_pgroup    = $('#login_pgroup').val();
//   var session_id      = $('#session_id').val();
//   var login_user_duty = $('#login_user_duty').val();
//
//   if(login_pgroup == '기술본부' && ( (session_id == 'kkj' || login_user_duty == '팀장') )) {
//     $('#no_written_report').bPopup({
//       follow: [false, false]
//     })
//   }
// })
</script>
