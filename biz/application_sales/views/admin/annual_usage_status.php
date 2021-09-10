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
    /* .fc-h-event{
      font-family:"Noto Sans KR", sans-serif !important;
      color: black !important;
    } */
    .fc-h-event {
      display: block !important;
      border: none !important;
      background-color: #3892FF;
      /* border: 1px solid var(--fc-event-border-color, #3788d8); */
      /* border-radius: 15px; */
      /* background-color: transparent !important; */
      /* background-color: var(--fc-event-bg-color, #3788d8); */
    }
    .fc-event-title{
      font-family:"Noto Sans KR", sans-serif !important;
      font-size: 14px !important;
      /* font-weight: bold; */
      width:100% !important;
      text-align: left !important;
      /* color : #3C3C3C !important; */
    }
    /* .fc-event[href]{
      cursor:initial;
    } */
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
    .fc-toolbar-title{
      padding-left: 15px;
    }

    .fc .fc-toolbar {
      justify-content: flex-start;
    }
  </style>


<body>
<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
<div align="center">
	<div class="dash1-1">
		<table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
			<tbody>
        <tr height="5%">
          <td class="dash_title">
            휴가사용현황
          </td>
        </tr>
				<tr height="13%">
        </tr>
        <tr style="max-height:45%">
          <td colspan="2" valign="top" >

            <div id='attendance_calendar' style="padding:80px 5%;">
            </div>
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
      <?php
      if(!empty($view_val)){
      foreach($view_val as $val){?>
          var ev = new Object();//상태
          ev.title = "<?php echo $val['user_name'];?>";
          ev.start = "<?php echo $val['annual_start_date'];?>";
          ev.end   = "<?php echo $val['annual_end_date'];?>";
          events.push(ev);
      <?php }} ?>
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
    headerToolbar: {
      left: 'today prev,next', //왼쪽버튼
      center: 'title', //중앙 버튼
      right: ''
    },
    // navLinks: true, //날짜 클릭시 그날 일정으로 가는 거
    dayMaxEventRows: true,
    displayEventTime: false,
    events:events,
    eventContent: function(arg) {
      let arrayOfDomNodes = []
      // title event
      let titleEvent = document.createElement('div')
      if(arg.event._def.title) {
        titleEvent.innerHTML = arg.event._def.title
        titleEvent.classList = "fc-event-title fc-sticky"
      }

      arrayOfDomNodes = [titleEvent]

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


</script>
</body>
</html>
