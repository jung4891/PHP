<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>

<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <link rel="stylesheet" href="/misc/css/view_page_common.css">
  <link href='/misc/css/tech_schedule/tech_schedule_1.0.css' rel='stylesheet' />
  <link href='/misc/css/tech_schedule/main.css' rel='stylesheet' />
  <link rel="stylesheet" href="/misc/css/bootstrap-datepicker.css">
  <link rel="stylesheet" href="/misc/css/bootstrap-timepicker.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
  <!-- <link rel="stylesheet" href="/misc/css/tech_schedule/proton/style.min.css" />  -->
  <link rel="stylesheet" href="/misc/css/tech_schedule/jquery.minicolors.css" />
  <link rel="stylesheet" href="/misc/css/chosen.css">

  <script src='/misc/js/tech_schedule/main.js'></script>
  <script src='/misc/js/tech_schedule/ko.js'></script>
  <script src='/misc/js/chosen.jquery.js'></script>

  <!-- <script src='/misc/js/tech_schedule/tech_schedule.js'></script> -->
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
  <script type="text/javascript" src="/misc/js/bootstrap-datepicker.js"></script>
  <script type="text/javascript" src="/misc/js/bootstrap-timepicker.js"></script>
  <script type="text/javascript" src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.0/moment.min.js"></script>
  <script src="https://unpkg.com/popper.js/dist/umd/popper.min.js"></script>
  <script src="https://unpkg.com/tooltip.js/dist/umd/tooltip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script> <!-- 조직도 생성 -->
  <script type="text/javascript" src="/misc/js/tech_schedule/jquery.minicolors.js"></script>
  <style>
    .fc-col-header{
      width:100% !important;
    }
    .fc-daygrid-body{
      width:100% !important;
    }
    .fc-scrollgrid-sync-table {
      width:100% !important;
    }

    .event_color_button {
      display: inline-block;
      vertical-align: middle;
      width: 15px;
      height: 15px;
    }

    .fc .fc-daygrid-day-frame {
      position: relative;

      min-height: 145px !important;
      max-height: 145px !important;
    }
    /* 오늘버튼 */
    .fc-today-button:disabled {
      cursor:pointer !important;
      background-color: #0575E6 !important;
      border-color: #0575E6 !important;
      width: 60px !important;
      border-radius: 3px !important;
      color: #FFFFFF !important;
      opacity: 1 !important;
    }
    .fc-today-button {
      cursor:pointer !important;
      background-color: #84c0fe !important;
      border-color: #84c0fe !important;
      width: 60px !important;
      border-radius: 3px !important;
      color: #FFFFFF !important;
      opacity: 1 !important;
    }
    /* 왼쪽버튼 */
    .fc-prev-button {
      cursor:pointer;
      background-color: #B0B0B0 !important;
      border-color: #B0B0B0 !important;
    }
    .fc-prev-button:hover {
      cursor:pointer;
      background-color: #797979 !important;
      border-color: #797979 !important;
    }
    /* 오른쪽버튼 */
    .fc-next-button {
      cursor:pointer;
      background-color: #B0B0B0 !important;
      border-color: #B0B0B0 !important;
    }
    .fc-next-button:hover {
      cursor:pointer;
      background-color: #797979 !important;
      border-color: #797979 !important;
    }

    /* 달력 테이블 border */
    .fc-scrollgrid {
      border: thin solid #DFDFDF !important;
      border-radius: 5px;
    }
    .fc-scrollgrid th {
      border: none !important;
      /* border-bottom: thin solid #DFDFDF !important; */
    }
    .fc-scrollgrid td {
      border: none !important;
      border-bottom: thin solid #DFDFDF !important;
      border-right: thin solid #DFDFDF !important;
    }
    .fc-scrollgrid td:last-child {
      border-right: none !important;
    }
    /* 토/일 글자색상 및 배경색상 */
    .fc-day-sun a, .fc-day-sun a.fc-daygrid-day-number {
       color:red;
     }
    .fc-day-sat a, .fc-day-sat a.fc-daygrid-day-number {
      color:blue;
    }
    .fc-daygrid-day-top {
      flex-direction: row !important;
    }
    .fc-daygrid-day-number {
      direction: ltr !important;
      margin-left: 5px;
    }


    .koHolidays {
      background-color: #fff !important;
    }

    .fc-h-event {
      /* display: block !important; */
      border: none !important;
      font-size: 14px;
      /* border: 1px solid var(--fc-event-border-color, #3788d8); */
      background-color: transparent !important;
      /* background-color: var(--fc-event-bg-color, #3788d8); */
    }

    .fc-h-event .fc-event-main {
      color: black;
      text-align:left;
    }

.fc-toolbar-title{
  padding-left: 15px;
}

.fc .fc-toolbar {
  justify-content: flex-start;
}

#attendance_calendar{
  margin-top:100px;
  margin-bottom: 15vh;
}
  </style>


<body>
<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
<div class="" align="center">
<div class="dash1-1">
  <table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
    <tbody>
    <tr height="5%">
      <td class="dash_title">
        출근기록
      </td>
    </tr>
    <tr>
      <td>
          <div id='attendance_calendar'></div>
      </td>
    </tr>
  </tbody>
  </table>
</div>


</div>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
<script>

if(!String.prototype.padStart) {
	String.prototype.padStart = function padStart(targetLength, padString) {
		if(this.length >= targetLength) {
			return String(this);
		} else {
			if(padString == null || padString == " ") {
				padString = " ";
			} else if(padString.length > 1) {
				padString = padString.substring(0,1);
			}
			targetLength = targetLength - this.length;
			var prefix = "";
			for(var i = 0; i < targetLength; i++) {
				prefix += padString;
			}
			return prefix + String(this);
		}
	};
}


  let today = new Date();
  let year = today.getFullYear(); // 년도
  let month = today.getMonth() + 1;  // 월
  let date = today.getDate();  // 날짜
  let day = today.getDay();  // 요일
  let today_date= String(year)+String(month).padStart(2, '0')+String(date).padStart(2, '0');

  var events =new Array();
  		$.ajax({
			type: "POST",
			async: false,
			url: "<?php echo site_url();?>/biz/attendance/attendance_user_val",
			dataType: "json",
			data: {
			},
			success: function (data) {
				for(var i=0; i<data.length; i++){
          var ev = new Object();//상태
          var ev1 = new Object();//출근
          var ev2 = new Object();//퇴근
          //출근!
          var wstime = data[i].go_time;
          if(wstime!= "" && wstime != null){
            // wstime = data[i].wstime.substring(8);
            wstime = wstime.substring(0,4);
            wstime =wstime.replace(/(.{2})/,"$1:");
            // wstime = wstime
          }else{
            wstime = "00:00";
          }

          //퇴근!
          var wctime = data[i].leave_time;
          if(wctime!= "" && wctime != null){
            // wctime = data[i].wctime.substring(8);
            wctime = wctime.substring(0,4);
            wctime = wctime.replace(/(.{2})/,"$1:");
            // wctime =wctime
          }else{
            wctime = "00:00";
          }

          // var font_color=" style='margin-bottom:5px;font-weight:bold;";
          // if(data[i].status == "미처리" || data[i].status == "지각"){
          //   font_color += "color:red;";
          // }else if (data[i].status == "정상출근") {
          //   font_color += "color:blue;";
          // }
          // font_color+="'";
          //
          // var status = data[i].status;
          // if(status == null){
          //   status="<br>";
          // }

          var ws_font_color = "";
          if(wstime>=data[i].ws_time){
            ws_font_color=" style='color:red;'";
          }
          var wc_font_color = "";
          if(wctime < data[i].wc_time){
            wc_font_color=" style='color:red;'";
          }

          // ev.title = "<div"+font_color+">"+status+"</div>"+"<div"+ws_font_color+">출근 : "+wstime+"</div>"+"<div"+wc_font_color+">퇴근 : "+wctime+"</div>"
          ev.title = "<div"+ws_font_color+">출근 : "+wstime+"</div>"+"<div"+wc_font_color+">퇴근 : "+wctime+"</div>"
          ev.start = data[i].e_date;
          ev.end   = data[i].e_date;
          // ev.imageurl = '<center><img src="<?php echo $misc;?>img/chat.png" style="width:20px;cursor:pointer;" onclick="attendanceAdjustment('+data[i].seq+')";></center>';
          events.push(ev);

        }

			}
		})
  document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('attendance_calendar');

  var calendar = new FullCalendar.Calendar(calendarEl, {
    googleCalendarApiKey:'AIzaSyBLpSLtCDQOB3mG0eAK1YrAqDjzQIjfeI0',
    locale: 'ko', //언어 설정
    selectable: true,
    // selectHelper: true,
    // editable: true, // 일정 드래그 가능 여부
    // aspectRatio: 1.8,
    eventOverlap: true, //동일 날짜 시간 중복등록 가능
    scrollTime: '08:00', // 포커스 되는 시간
    // navLinks: true, //날짜 클릭시 그날 일정으로 가는 거
    dayMaxEventRows: true,
    displayEventTime: false,
    headerToolbar: {
      left: 'today prev,next', //왼쪽버튼
      center: 'title', //중앙 버튼
      right: ''
    },
    events:events,
    eventContent: function(arg) {
      let arrayOfDomNodes = []
      // title event
      let titleEvent = document.createElement('div')
      if(arg.event._def.title) {
        titleEvent.innerHTML = arg.event._def.title
        titleEvent.classList = "fc-event-title fc-sticky"
      }

      // image event
      let imgEventWrap = document.createElement('div');
      var image_url=arg.event._def.extendedProps.imageurl
      if(image_url) {
        let imgEvent = image_url;
        imgEventWrap.classList = "fc-event-img"
        imgEventWrap.innerHTML = imgEvent;
      }

      arrayOfDomNodes = [ imgEventWrap ,titleEvent]

      return { domNodes: arrayOfDomNodes }
    },
  });
  calendar.render();
});



  // 외부영역 클릭 시 팝업 닫기
  $(document).mouseup(function (e){
    var LayerPopup = $("#dropdown");
    if(LayerPopup.has(e.target).length === 0){
      $("#myDropdown").hide();
    }
  });

  //ㅎㅎ 근태조정계 쓰러가기
  function attendanceAdjustment(seq){
    location.href = "<?php echo site_url();?>/biz/approval/electronic_approval_doc_input?seq=attendance&attendance_seq="+seq;
  }
</script>
</body>
</html>
