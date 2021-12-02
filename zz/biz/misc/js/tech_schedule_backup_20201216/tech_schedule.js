
//일정 등록
function scheduleAdd(){

  var startDay = $('#startDay').val();
  var startTime = $('#startTime').val();
  var endDay = $('#endDay').val();
  var endTime = $('#endTime').val();
  var workname = $('#workname').val();
  var customer = $('#customer').val();
  var supportMethod = $('#supportMethod').val();
  var participant = $('#participant').val();
  var contents = $('#contents').val();
  var insertDirect = $('#insertDirect').val();
  if (workname == '') {
    alert('업무 종류를 선택하세요.');
    stopPropagation();
  }
  if (startDay == '' || endDay == ''){
    alert('날짜를 입력해 주세요.');
    stopPropagation();
  }

  (customer=="직접입력")?customer=insertDirect : customer=customer;

  $.ajax({
    type: "POST",
    url:"/index.php/schedule/add_schedule",
    dataType:"json",
    data:{
      startDay:startDay,
      startTime:startTime,
      endDay:endDay,
      endTime:endTime,
      workname:workname,
      customer:customer,
      supportMethod:supportMethod,
      participant:participant,
      contents:contents
    },
    success: function(data) {
      alert("등록되었습니다.");
      if (data == 'false') {
        result = 'false';
      }
    }
});
    window.location.reload();
};


//날짜선택 달력으로 표시
$(function(){
  $("#startDay, #endDay").datepicker();

});
$(function(){
  $('#startTime, #endTime').timepicker({
                minuteStep: 10,
                // template: 'modal',
                // appendWidgetTo: 'body',
                // showSeconds: true,
                showMeridian: false
                // defaultTime: false
            });
})
function openStartDate(){
  $("#startDay").focus();
}

function openEndDate(){

  $("#endDay").focus();
}

/////// 인풋 고객사 셀렉트2로
function select2(obj){

  $(obj).chosen();
}

// 모달 창 직접입력 선택 시 인풋 창 생성
function insertDirect(el) {
  if ($(el).val() == "직접입력") {
    // alert("!");
    $(el).siblings('.insertDirect').show();
  } else {
    $(el).siblings('.insertDirect').hide();
  }
}


// 종일 버튼 누를시 시간선택 숨기기
function hideTime(){
if($("input:checkbox[name='alldayCheck']").is(":checked") == true){
  $("#startTime, #startTimeBtn, #endTime, #endTimeBtn").hide();
  $("#startTime, #endTime").val("");

}else{
  $("#startTime, #startTimeBtn, #endTime, #endTimeBtn").show();
}

}

// 참석자 추가
function addUser(){
  var user = $('#participant').val();
  var adduser = $('#adduser').val();

  var users = user +", "+adduser;
  $('#participant').val(users);
}

var checked_name = [];
var events = new Array();
var jsonEvents = '';

// 조직도 트리 생성
$(function() {
    $('#tree').jstree({
      "checkbox" : {
    "keep_selected_style" : false
    },
    'plugins': ["wholerow", "checkbox"],
    'core' : {
      'themes' : {
        'name': 'proton',
        "icons" : false

        }
    }
    });
    $("#tree").bind("changed.jstree",
    function (e, data) {
      checked_name = [];
      var reg = /^[가-힣]*$/;
      $.each($("#tree").jstree("get_checked",true),function(){
        if (reg.test(this.id)){
          checked_name.push(this.id);
        }
        // console.log(this);
      })
      // console.log(checked_name);
      if (checked_name.length>0) {
        $.ajax({
          type: "POST",
          dataType:'json',
          url:"/index.php/schedule/user",
          data:{
            userArr: checked_name
          },
          success: function(data, textStatus) {
          },
          error :function(jqXHR, textStatus, errorThrown) {
             alert("something went wrong");
          }
        }).done(function(data){
          console.log(data);
          events = new Array ();
          var eventObj = new Object();
          // for (var i = 0; i < data.length; i++) {
            for (var j = 0; j<data.length; j++){
              eventObj = new Object();
              extendObj = new Object();
              if(data[j].start_time=="00:00:00"&&data[j].end_time=="00:00:00"){
                eventObj.start = data[j].start_day;
                eventObj.end = data[j].end_day;
              } else {
                eventObj.start = data[j].start_day+"T"+data[j].start_time;
                eventObj.end = data[j].end_day+"T"+data[j].end_time;
              }
              var participant = data[j].participant;
              participant = participant.split(",");
              len_participant = participant.length - 1;
              if (len_participant == 0){
                participant = participant[0];
              } else {
                participant = participant[0]+" 외 "+len_participant+"명";
              }
              // console.log(participant);
              eventObj.title = "["+participant+"]" + data[j].customer + "-" + data[j].work_name;
              eventObj.id = data[j].seq;
              extendObj.participant = data[j].participant;
              extendObj.user_name = data[j].user_name;
              extendObj.insert_date = data[j].insert_date;
              // eventObj.extendedProps = '{participant:"' + data[j].participant + '", user_name:"' + data[j].user_name + '", insert_date:"' + data[j].modify_date + '"},'
              eventObj.extendedProps = extendObj;
              eventObj.color = data[j].color;
              eventObj.textColor = data[j].textColor;
              events.push(eventObj);
            }
          // }
          calendartest();
        })
      } else {
        events = '';
        calendartest();
      }
    });
});

// 사원 선택 캘린더 재생성
function calendartest(){
  console.log(events);
  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {

    // googleCalendarApiKey: 'AIzaSyDaKrURvXhNj_960m5JPkHiOI32UCNwdlk',
    locale: 'ko', //언어 설정
    // selectable: true,
    // selectHelper: true,
    editable: true, // 일정 드래그 가능 여부
    // aspectRatio: 1.8,
    eventOverlap: true, //동일 날짜 시간 중복등록 가능
    scrollTime: '08:00', // 포커스 되는 시간
    navLinks: true, //날짜 클릭시 그날 일정으로 가는 거
    dayMaxEventRows: true,
    // dayMaxEvent: true,
    //버튼 만들기
    customButtons: {
      //일정 추가 버튼
      addSchedule: {
        text: '일정추가',
        click: function() {
          $('#addpopup').bPopup();
        }
      }

    },
    headerToolbar: {
      left: 'today prev,next', //왼쪽버튼
      center: 'title', //중앙 버튼
      right: 'addSchedule dayGridMonth,listMonth timeGridWeek,listWeek timeGridDay,listDay' //dayGridWeek//오른쪽 버튼

    },
    initialView: 'dayGridMonth',

    // 일정 그리기
    eventSources:[
      {events:events}
      ], //이벤트 리소스 끝

      dayCellContent: function (arg) {
      return arg.date.getDate();
    },

      eventClick: function(info) { //일정 클릭시 이벤트 상세페이지 이동
        var seq = info.event.id;
        $('#hiddenSeq').val(seq);
        $('#seqBtn').click();
        ///////////////////////////////////////////


      },

      eventDidMount: function(info) {       //일정 마우스 오버시 툴팁 창
        var startDay = moment(info.event.start).format('YY-MM-DD HH:mm');
        var endDay = moment(info.event.end).format('YY-MM-DD HH:mm');
        var participant = info.event.extendedProps.participant;
        var userName = info.event.extendedProps.user_name+" "+info.event.extendedProps.insert_date;
        var tooltip = new Tooltip(info.el, {
          title: "<table class='tg' style='undefined;table-layout: fixed; width: 300px'><colgroup><col style='width: 300px'></colgroup><thead><tr><th class='tg-zd5i'>"+info.event.title+"</th></tr></thead><tbody><tr><td class='tg-l6li'>"+ startDay +" ~ "+ endDay +"</td></tr><tr><td class='tg-73a0'>[참석자] "+participant+"</td></tr><tr><td class='tg-73a0'>[등록자] "+userName+"</td></tr></tbody></table>",
          placement: 'right',
          trigger: 'hover',
          delay: {show:800},
          html:true,
          template: '<div class="tooltip" role="tooltip"><div class="tooltip-inner"></div></div>',
        });
      },


      //드래그 드랍시 날짜 업데이트
      eventDrop: function(info){
        var seq = info.event.id;
        var startDay = moment(info.event.start).format('YY-MM-DD');
        var startTime =moment(info.event.start).format('HH:mm');
        var endDay = moment(info.event.end).format('YY-MM-DD');
        var endTime = moment(info.event.end).format('HH:mm');
        // alert(seq+"/////"+startDay +"////"+startTime+"///"+endDay+"//"+endTime);
        $.ajax({
          type: 'POST',
          url:"/index.php/schedule/drop_update",
          data:{
            seq: seq,
            start_day : startDay,
            start_time : startTime,
            end_day : endDay,
            end_time : endTime
          },
          cache:false,
          async:false
        })
        .done(function(result){
          if(result == 'OK'){
            $('#calendar').fullCalendar("refetchEvents");
          }
        });

      },

      //이벤트 리사이즈시 날짜 시간 업데이트
      eventResize: function(info){
        var seq = info.event.id;
        var startDay = moment(info.event.start).format('YY-MM-DD');
        var startTime =moment(info.event.start).format('HH:mm');
        var endDay = moment(info.event.end).format('YY-MM-DD');
        var endTime = moment(info.event.end).format('HH:mm');
        // alert(seq+"/////"+startDay +"////"+startTime+"///"+endDay+"//"+endTime);
        $.ajax({
          type: 'POST',
          url:"/index.php/schedule/drop_update",
          data:{
            seq: seq,
            start_day : startDay,
            start_time : startTime,
            end_day : endDay,
            end_time : endTime
          },
          cache:false,
          async:false
        })
        .done(function(result){
          if(result == 'OK'){
            $('#calendar').fullCalendar("refetchEvents");
          }
        });

      }


    });
    calendar.render();
}


$(".jstree-checkbox").click(function(){
  alert(1);
})

// 엑셀 다운로드
function excelExport() {

  $(".fc-listMonth-button").trigger("click");
  var date = $(".fc-toolbar-title").text();
  var title = "일정 리스트_"+date;


  var tab_text = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
  tab_text = tab_text + '<head><meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">';
  tab_text = tab_text + '<xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>'
  tab_text = tab_text + '<x:Name>Test Sheet</x:Name>';
  tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:Panes></x:WorksheetOptions></x:ExcelWorksheet>';
  tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>';
  tab_text = tab_text + "<table border='1px'>";
  var exportTable = $(".fc-list-table").clone();
  exportTable.find('.fc-list-event-graphic').remove();
  exportTable.find('.fc-list-day-cushion').css("text-align","left");
  exportTable.find("th").attr("colspan",2);
  exportTable.find(".fc-list-day-text").each(function(){
    $(this).text($(this).text()+" ");
  })
  exportTable.find('input').each(function(index, elem) {
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
  $('#customPop').bPopup({follow:[false,false],position:["auto",0]});
  $(document).scrollTop(0);
}

function colorCustom(el) {
  var tr = $(el).closest('tr');
  var color = $(el).val();
  var type = $(el).attr('name');
  // console.log(type);
  if (type=="work_color"){
    tr.find(".printDemo").css('background-color', color);
  } else if (type=="text_color"){
    tr.find(".printDemo").css('color', color);
  }
}

function save_workColor() {
  sessionStorage.setItem('workColor', 'y');
  var tr = $("#workColor_tbl tr");
  $("#workColor_tbl tr").each(function(){
    var seq = $(this).attr('id');
    var color = $(this).find('.work_color').val();
    var textColor = $(this).find('.text_color').val();
    // console.log(seq + color + textColor);

    $.ajax({
      type: "POST",
      // cache:false,
      url: "/index.php/schedule/updateWorkColor",
      dataType: "json",
      async: false,
      data: {
        seq: seq,
        color: color,
        textColor: textColor
      },
      success: function(data) {
        if (data == 'false') {
          result = 'false';
        }
      }
    });
  })
  if (result = 'true'){
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
  // alert($(el).text());
  var text = $(el).text();

  if (text == '사원별 보기'){
    $(el).text('업무별 보기');
    var type = 'user';
  } else {
    $(el).text('사원별 보기');
    var type = 'type';
  }

  $.ajax({
    type: 'POST',
    url:"/index.php/schedule/colorChange",
    data:{
      type: type
    },
    cache:false,
    async:false
  }).done(function(data){
    console.log(data);
  })
}

function addUserBtn(){
  $('#addUserpopup').bPopup({follow:[false,false]});
}

function closeBtn(){
  $('#addUserpopup').bPopup().close();
}

// 조직도 트리 생성
var checked_text = [];
$(function() {
    $('#usertree').jstree({
      "checkbox" : {
    "keep_selected_style" : false
    },
    'plugins': ["wholerow", "checkbox"],
    'core' : {
      'themes' : {
        'name': 'proton',
        "icons" : false

        }
    }
    // checked_text = [];
    });
    $("#usertree").bind("changed.jstree",
    function (e, data) {
      var reg = /^[가-힣]*$/;
      checked_text.length = 0;
      $.each($("#usertree").jstree("get_checked",true),function(){

        if (reg.test(this.id)){
          checked_text.push(this.text);
          // console.log(this.text);
        }
      })
    });
});

// 조직도 트리 생성
var checked_text = [];
$(function() {
    $('#usertree2').jstree({
      "checkbox" : {
    "keep_selected_style" : false
    },
    'plugins': ["wholerow", "checkbox"],
    'core' : {
      'themes' : {
        'name': 'proton',
        "icons" : false

        }
    }
    // checked_text = [];
    });
    $("#usertree2").bind("changed.jstree",
    function (e, data) {
      var reg = /^[가-힣]*$/;
      checked_text.length = 0;
      $.each($("#usertree2").jstree("get_checked",true),function(){

        if (reg.test(this.id)){
          checked_text.push(this.text);
          // console.log(this.text);
        }
      })
    });
});


var exsistText = []; //이미 append한 값
var spliceText = []; //중복 데이터를 담을 배열
function insertUser(){
  // console.log(checked_text);

  //중복 데이터 고르는 이중for문
  for(k=0;k<exsistText.length;k++){
  	for(j=0;j<checked_text.length;j++) {
  		if(exsistText[k] == checked_text[j]) {
  			spliceText.push(checked_text[j]); //중복 데이터 배열에 담기
  		}else{
        continue;
      }
  	}
  }
  //중복 데이터를 append할 배열에서 제거
  for(p=0;p<spliceText.length;p++){
    checked_text.splice(checked_text.indexOf(spliceText[p]),1); // "A"를 찾아서 삭제한다.
  }
  //중복 데이터를 뺀 나머지를 append하고 append한 데이터를 배열에 담기
  for(i=0;i<checked_text.length;i++){
    $('#insertParticipant').append('<li><input type="checkbox" id="'+checked_text[i]+'" value="'+checked_text[i]+'">'+checked_text[i]+'</li>')
  }
  // console.log('exsistText: '+exsistText);
  // console.log('spliceText: '+spliceText);
  // console.log('checked_text: '+checked_text);
  // checked_text=[];
  checked_text.length = 0;

  //$('#insertParticipant')에 담긴 줄 확인
  var liLength = [];
  liLength = $('#insertParticipant').children().size();
  // console.log(liLength);
  //exsistText 배열 초기화
  exsistText.length = 0;
  for(q=0;q<liLength;q++){
    var inputValue = $("#insertParticipant li > input")[q].value;
    console.log(inputValue);
    exsistText.push(inputValue);
  }
  // console.log('exsistText: '+exsistText);
$("#usertree").jstree("deselect_all");
}

function deleteUser(){
  console.log($("#insertParticipant li > input").val());
  // $("#insertParticipant li > input").val();
  $("#insertParticipant li > input").each(function(){
    if ($(this).is(":checked")){
      // $("input:checkbox[id='ID']").is(":checked")
      $(this).closest('li').remove();
      exsistText.splice(exsistText.indexOf($(this).val()),1);
    }
  })
}

function reset(){
  //배열 및 요소들 리셋
  $("#insertParticipant").empty();
  exsistText.length = 0;
  spliceText.length = 0;
  checked_text.length = 0;
}

// // 참석자 추가
// function addUser(){
//   var user = '';
//   var adduser = '';
//   $.each(exsistText,function(){
//     user = $('#participant').val(); //참석자 칸 변수 받아오기
//     adduser = $(this)[0]; // 추가할 참석자(init string으로 받아오기에 인덱스 지정해서 string만 받아옴)
//     user = user +", "+adduser; //참석자 변수에 추가
//     $('#participant').val(user); //참석자 칸에 값 넣기
//   })
//   // exsistText.length = 0; //추가한 참석자 배열 비우기
//   $('#addUserpopup').bPopup().close(); //모달 닫기
// }



// 참석자 추가
function addUser(){
  var user = $('#participant').val(); //참석자 칸 변수 받아오기
  // console.log('ss '+user);
  var exsistText2;
  var exsistTextArr =[];
  var participantArr = user.split(', ');
  // console.log("participantArr "+participantArr);
  var spliceText2 = [];

  $.each(exsistText,function(){
      exsistText2 = $(this)[0];
      exsistText2 = exsistText2.split(' ')[0];
      exsistTextArr.push(exsistText2)
  })
  // console.log(exsistTextArr);

  //중복 데이터 고르는 이중for문
  for(k=0;k<participantArr.length;k++){
    for(j=0;j<exsistTextArr.length;j++) {
      if(exsistTextArr[j] == participantArr[k]) {
        // alert(1);
        spliceText2.push(participantArr[k]); //중복 데이터 배열에 담기
      }else{
        continue;
      }
    }
  }
  //중복 데이터를 append할 배열에서 제거
  for(p=0;p<spliceText2.length;p++){
    // console.log('삭제');
    exsistTextArr.splice(exsistTextArr.indexOf(spliceText2[p]),1); // 중복데이터를 찾아서 삭제한다.
  }
  //참석자에 append하기
  var adduser = '';
  $.each(exsistTextArr,function(){
    user = $('#participant').val();
    adduser = $(this)[0];
    // console.log('adduser '+adduser);
    $('#participant').val(user+", "+adduser);
  })
  adduser = '';
  exsistTextArr = [];
  $('#addUserpopup').bPopup().close(); //모달 닫기
}
