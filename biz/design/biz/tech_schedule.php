<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/customer_top.php";
  include $this->input->server('DOCUMENT_ROOT')."/misc/js/tech_schedule/tech_schedule2.php";
?>
<?php
  // if($_SERVER['SERVER_ADDR'] == '192.168.1.104'){
  //   echo "<meta http-equiv='refresh' content='5; url=http://dev.biz.durianit.co.kr/'>";
  //   print "로컬서버입니다.";
  // }
  // if($_SERVER['SERVER_ADDR'] == '192.168.1.101'){
  //   echo "<meta http-equiv='refresh' content='5; url=http://biz.durianit.co.kr/'>";
  // }
?>

<html>
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width = device-width, initial-scale = 1, maximum-scale = 1, viewport-fit = cover, user-scalable = no, shrink-to-fit = no ">
    <title></title>

  </head>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="<?php echo $misc; ?>js/touch-punch.js"></script>
  <!-- <link href='/misc/css/dashboard.css' rel='stylesheet' /> -->
  <link href='/misc/css/tech_schedule/tech_schedule_1.0.css' rel='stylesheet' />
  <link href='/misc/css/view_page_common.css' rel='stylesheet' />
  <link href='/misc/css/tech_schedule/main.css' rel='stylesheet' />
  <link rel="stylesheet" href="/misc/css/bootstrap-datepicker.css">
  <link rel="stylesheet" href="/misc/css/bootstrap-timepicker.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" /> <!-- 조직도 생성 -->
  <link rel="stylesheet" href="/misc/css/tech_schedule/proton/style.min.css" /> <!-- 조직도 생성 -->
  <link rel="stylesheet" href="/misc/css/tech_schedule/jquery.minicolors.css" />
  <link rel="stylesheet" href="/misc/css/chosen.css">
  <!-- <link rel="stylesheet" href="/misc/css/bootstrap.css"> -->
  <script src='/misc/js/tech_schedule/main.js'></script>
  <script src='/misc/js/tech_schedule/ko.js'></script>
  <script src='/misc/js/chosen.jquery.js'></script>

  <!--rrule lib 반복일정 관련 플러그인-->
  <!-- <script src="rrule/dist/es5/rrule.min.js"></script> -->
  <!-- <script src='https://cdn.jsdelivr.net/npm/rrule@2.6.8/dist/es5/rrule.min.js'></script> -->
  <script src='https://cdn.jsdelivr.net/npm/rrule@2.6.4/dist/es5/rrule.min.js'></script>

  <!-- fullcalendar bundle 반복일정 관련 플러그인--> <!-- 이거 쓰면 fullcalendar main.js를 다시 참조해오기 때문에 기존 설정값일부가 안먹는듯? 예를 들어 일정 상단 버튼이 월->month 로 변하고 그럼-->
  <!-- <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.5.1/main.min.js'></script> -->

  <!-- the rrule-to-fullcalendar connector. must go AFTER the rrule lib 반복일정 관련 플러그인 qksemtl rrule lib 이후에 나와야한다.-->
  <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/rrule@5.5.0/main.global.min.js'></script>

  <!-- <script src='/misc/js/tech_schedule/tech_schedule2.js'></script> -->

  <!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script> -->
  <!-- <script src='/misc/js/select2.min.js'></script> -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/js/select2.min.js"></script>

  <script type="text/javascript" src="/misc/js/bootstrap-datepicker.js"></script>
  <script type="text/javascript" src="/misc/js/bootstrap-timepicker.js"></script>
  <script type="text/javascript" src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.0/moment.min.js"></script>
  <script src="https://unpkg.com/popper.js/dist/umd/popper.min.js"></script>
  <script src="https://unpkg.com/tooltip.js/dist/umd/tooltip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script> <!-- 조직도 생성 -->
  <script type="text/javascript" src="/misc/js/tech_schedule/jquery.minicolors.js"></script>
  <script src='/misc/js/exif.js'></script>
  <script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=be899438c615f0b45f7b6f838aa7cef3"></script>


  <style>
/* 모바일 csss */
@media (max-width: 575px), (max-width: 768px) {

  /* #techReportInsert,#techReportModify{
    display:none;
  } */

  #add_conference_btn,#add_car_btn{
    margin:20px 0px  !important;
  }
  .select_time{
    font-size:14px;
    display:flex;
    display: -webkit-box;
    display: -ms-flexbox;
    overflow-x: auto;
    overflow-y: hidden;
  }
  .select_time_th{
    width:100% !important;
  }
  .select_time tbody{
    display:flex
  }
  .select_time th:first-child{
    display:block;
    height:30px !important;
  }
  .select_time th:not(:first-child){
    display:block;
    height:22px !important;
  }
  .select_time td{
    display:block;
  }
  .select_time td:first-child{
    height:30px !important;
  }

  .select_time td:not(:first-child){
    height:0px !important;
  }
  input,
  textarea,
  select {
      font-size: 16px !important;
  }
  #select_date,#select_car_date{
    width:220px !important;
    float: none !important;
    margin:20px 0px !important;
  }

  #select_table,#select_car_table{
    display:inline-block  !important;
    width:100% !important;
    margin:0px !important;
  }

  #conference_div{
    width:100% !important;
  }

  #car_reservation_div{
    width:100% !important;
  }

  li{
    list-style: none;
  }
  #addpopup, #updateSchedule{
    width:100% !important;
    margin-left: 100px !important;
  }
  #addpopup input:not(#room_name,#car_name,.dayBtn,.timeBtn,.dateBtn,.basicBtn,.add_weekly_report,.btn-common),#addpopup textarea,
  #updateSchedule input:not(#de_room_name,#de_car_name,.dayBtn,.timeBtn,.dateBtn,.basicBtn,.add_weekly_report,.btn-common),#updateSchedule textarea{
    width:70% !important;
  }
  #room_name,#car_name,#de_room_name,#de_car_name{
    width:50% !important;
  }
  #searchDiv{
    width:25% !important;
    float:left !important;
  }
  #searchBtnDiv{
    width:20% !important;
    float:left !important;
    text-align: center;
  }
  #changeDiv{
    width:50% !important;
    float:left !important;
  }
  #searchSelect,#searchText{
    width:100% !important;
    font-family:"Noto Sans KR", sans-serif !important;
  }

  #scheduleSidebar,#company_schedule,#selectParticipantBtn {
    display : none !important;
  }
  #scheduleTop{
    width:100% !important;
    margin:0px !important;
  }
  #calendar{
    width:100% !important;
    height: 600px !important;

  }

  .fc .fc-toolbar{
    font-size: 10px;
    display: inline-block !important;
  }

  .fc-toolbar-title{
    margin-bottom:10px !important;
  }

  .fc .fc-daygrid-day-frame{
    min-height:100% !important;

  }

  .fc-button-group:first-child{
    margin-top:10px;
    width:100% !important;
  }



}

/* 모바일css끝 */


  #feedback { font-size: 1.4em; }
  #selectable .ui-selecting { background: #80dfff; }
  #selectable .ui-selected { background: #52b1fa; color: white; }
  #selectable { list-style-type: none; margin: 0; padding: 0; width: 60%; }

  #select_car_tbody .ui-selecting { background: #80dfff; }
  #select_car_tbody .ui-selected { background: #52b1fa; color: white; }
  #select_car_tbody { list-style-type: none; margin: 0; padding: 0; width: 60%; }

  div.scheduleHint {
    font-size:18px; position:absolute; width:450px; line-height:1.5em; padding:5px 8px 7px; border: 1px solid #cccccc;  border-radius: 4px; background:#fff;  /* z-index:10001; */
    -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
    -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
  }

  h3 {
    padding:0;
    margin: 0;
    font-weight: bold;
    line-height: 1.1;
    display: block;
    font-size: 1.17em;
    margin-block-start:1em;
    margin-block-end:1em;
    margin-inline-start:0px;
    margin-inline-end:0px;
  }

  .event_color_button {
    display: inline-block;
    vertical-align: middle;
    width: 15px;
    height: 15px;
  }

  .fc .fc-daygrid-day-frame {
    position: relative;
    min-height: 145px;
    max-height: 145px;
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
  /* 일정추가 버튼 */
  .fc-addSchedule-button {
    background-color: #E7F3FF !important;
    border-color: #E7F3FF !important;
    color: #1A8DFF !important;
    width: 100px !important;
    margin-right: 20px !important;
  }
  .fc-addSchedule-button:hover {
    background-color: #badaf9 !important;
    border-color: #badaf9 !important;
  }
  /* 리스트 버튼 */
  .fc-listMonth-button, .fc-listWeek-button, .fc-listDay-button, .fc-dayGridMonth-button, .fc-timeGridWeek-button, .fc-timeGridDay-button {
    background-color: #E7F3FF !important;
    border-color: #E7F3FF !important;
    color: #1A8DFF !important;
  }
  .fc-listMonth-button:hover, .fc-listWeek-button:hover, .fc-listDay-button:hover, .fc-dayGridMonth-button:hover, .fc-timeGridWeek-button:hover, .fc-timeGridDay-button:hover {
    background-color: #badaf9 !important;
    border-color: #badaf9 !important;
  }
  .fc-button-active {
    background-color: #0575E6 !important;
    border-color: #0575E6 !important;
    color: #FFFFFF !important;
  }
  /* .fc-toolbar-chunk:nth-child(2) {
    flex: 3 !important;
  }
  .fc-toolbar-chunk:nth-child(1) {
    flex: 1 !important;
    max-width
  } */
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
  .fc-event-title {
    text-align:right !important;
  }
  .koHolidays {
    background-color: #fff !important;
  }

<?php foreach($work_color as $wc){ ?>
<?php echo '.event_class_type'.$wc->seq; ?> { border: 1px solid #474889; border-radius: 50%; background: <?php echo $wc->color; ?> !important; color: #fff !important;
   -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
   -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
   box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
}
<?php } ?>

  .text-point { color:#d3292c !important; }
  .text-normal { color:black !important; }

  .tooltip-content{
    visibility: hidden;
    width: 450px;
    /* background-color: white; */
    padding:5px 8px 7px;
    line-height:1.5em;
    margin-top: 10px;
    position: absolute;
    z-index: 1;
    color:black;
    font-size: 18px;
    border: 1px solid #cccccc;
    border-radius: 4px;
    background:#fff;  /* z-index:10001; */
    -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
    -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
  }

  /* 첨부파일 */
  .box-file-input label{
  display:inline-block;
  background:#a9abac;
  color:#fff;
  padding:0px 15px;
  line-height:30px;
  cursor:pointer;
  border-radius: 3px;
 }

 .box-file-input label:after{
  content:"파일 선택";
 }

 .box-file-input .file-input{
  display:none;
 }

 .box-file-input .filename{
  display:inline-block;
  padding-left:10px;
 }

 .btn-file {
   width:50px;
 }
 .btn-file-left {
   float:left;
   border: 1px solid #B6B6B6;
   background: white;
   color: #565656;
 }
 .btn-file-right {
   /* right:0; */
   float:right;
   margin-right: 40px;
 }
 .file_span {
   color: #B6B6B6;
   max-width: 200px;
 }
  </style>

  <script>
  // $(document).ready(function () {
  //   $(".koHolidays").parent('div').parent('div').parent('div').css("background-color","#FFF7F7");
  // });

document.addEventListener('DOMContentLoaded', function(){
  $('.demo').each( function() {
    $(this).minicolors({
      control: $(this).attr('data-control') || 'hue',
      defaultValue: $(this).attr('data-defaultValue') || '',
      format: $(this).attr('data-format') || 'hex',
      keywords: $(this).attr('data-keywords') || '',
      inline: $(this).attr('data-inline') === 'true',
      letterCase: $(this).attr('data-letterCase') || 'lowercase',
      opacity: $(this).attr('data-opacity'),
      position: $(this).attr('data-position') || 'bottom',
      swatches: $(this).attr('data-swatches') ? $(this).attr('data-swatches').split('|') : [],
      change: function(value, opacity) {
        if( !value ) return;
        if( opacity ) value += ', ' + opacity;
        if( typeof console === 'object' ) {
        }
      },
      theme: 'bootstrap'
    });
  });
})

function list_search(){
  var act = "<?php echo site_url();?>/biz/schedule/tech_schedule";
  $("#searchWord").attr('action', act).submit();
}


// // KI1 20210125 고객사 포캐스팅형/유지보수형으로 변경에 적용되는 함수들
function searchFunction(id) {
  var myDropdown = $("#" + id).parent().find('div').attr('id');
  if(myDropdown == 'de_myDropdown'){
    var workname = 'de_workname';
    var dropdown_option = 'de_dropdown_option';
  }else{
    var workname = 'workname';
    var dropdown_option = 'dropdown_option';
  }

  if( $("#"+workname).val() == "납품설치" || $("#"+workname).val() == "미팅" || $("#"+workname).val() == "데모(BMT)지원" ){
    $("#"+dropdown_option).html(
      <?php
      echo "'";
      //KI1 20210208
      echo '<a onClick="show_input_customerName(this)" value="">직접입력</a>';
      //KI2 20210208
      foreach ($customer2 as $val) {
          echo '<a ';
          echo 'onclick ="clickCustomerName(this,0,'.$val['forcasting_seq'].','.$val['forcasting_seq'].')" >'. $val['customer'].' - '.addslashes($val['project_name']).'</a>';
      }
      echo "'";
      ?>
    );
  }else if(workname ==''){
    $("#"+myDropdown).toggle();
    alert('작업구분을 먼저 선택해주세요.');
    $("#"+workname).focus();
  }else{
    $("#"+dropdown_option).html(
    <?php
       echo "'";
       //KI1 20210208
       echo '<a onClick="show_input_customerName(this)" value="">직접입력</a>';
       //KI2 20210208
      foreach ($customer as $val) {
        // if (strtotime(date("Y-m-d")) > strtotime(date($val['maintain_end']))) {
        //   echo '<a style="color:red;" ';
        //   echo 'onclick ="clickCustomerName(this,' . strtotime(date($val['maintain_end'])) . ','.$val['maintain_seq'].','.$val['forcasting_seq'].')" >' . $val['customer'].' - '.addslashes($val['project_name']).'</a>';
        // } else {
        //   echo '<a ';
        //   echo 'onclick ="clickCustomerName(this,' . strtotime(date($val['maintain_end'])) . ','.$val['maintain_seq'].','.$val['forcasting_seq'].')" >'. $val['customer'].' - '.addslashes($val['project_name']).'</a>';
        // }

        if($val['maintain_seq'] == null){
          echo '<a ';
          echo 'onclick ="clickCustomerName(this, 0 ,'.$val['forcasting_seq'].','.$val['forcasting_seq'].')" >'. $val['customer'].' - '.addslashes($val['project_name']).'</a>';
        }else{
          echo '<a ';
          echo 'onclick ="clickCustomerName(this,' . strtotime(date($val['maintain_end'])) . ','.$val['maintain_seq'].','.$val['forcasting_seq'].')" >'. $val['customer'].' - '.addslashes($val['project_name']).'</a>';
        }
      }
      echo "'";
      ?>
    );
  }
  $("#"+myDropdown).toggle();
  // $("#myDropdown").toggle();
  $(".searchInput").focus();
}

//고객사 선택
function clickCustomerName(customerName, maintainEnd, seq , forcasting_seq) {
  var parent_id = $(customerName).closest("div").attr("id");
  // alert(parent_id);
  // alert(JSON.stringify(parent_id));
  // alert(JSON.stringify(parent_id));
  // var parent_id = $(this).parent('div').attr('id');
  // console.log('customerName: '+customerName+'  maintainEnd: '+maintainEnd+'  seq: '+seq+'  forcasting_seq: '+forcasting_seq+' parent_id: '+parent_id);
  if(parent_id == 'de_dropdown_option'){
    var customerName_id = 'de_customerName';
    var project_id = 'de_project';
    var customer_id = 'de_customer';
    var forcasting_seq_id = 'de_forcasting_seq';
    var maintain_seq_id = 'de_maintain_seq';
    var workname_id = 'de_workname';
    var myDropdown = 'de_myDropdown';
  }else{
    var customerName_id = 'customerName';
    var project_id = 'project';
    var customer_id = 'customer';
    var forcasting_seq_id = 'forcasting_seq';
    var maintain_seq_id = 'maintain_seq';
    var workname_id = 'workname';
    var myDropdown = 'myDropdown';
  }
  //KI1 20210208
  $('#'+customerName_id).attr('readonly',true);
  $('#'+project_id).attr('readonly',true);
  //KI2 20210208

  var customerCompanyName = ($(customerName).text()).split(' - ')[0];
  var projectName = ($(customerName).text()).split(' - ')[1];
  $('#'+customerName_id).val(customerCompanyName);
  $('#'+project_id).val(projectName);
  $("#"+customer_id).val(seq);
  $("#"+forcasting_seq_id).val('');
  $("#"+forcasting_seq_id).val(forcasting_seq);
  $("#"+maintain_seq_id).val('');
  $("#"+maintain_seq_id).val(seq);

  if($("#"+workname_id).val() != "납품설치" && $("#"+workname_id).val() != "미팅" && $("#"+workname_id).val() != "데모(BMT)지원" ){ //유지보수
      // test3($("#"+customer_id).val(),'maintain');
      // if (<?php echo strtotime(date("Y-m-d")) ?> > maintainEnd) {
      //   $("#"+customer_id).val('');
      //   $('#'+customerName_id).val('');
      //   $('#'+project_id).val('');
      // }

    if(maintainEnd != '0'){
      test3($("#"+customer_id).val(),'maintain');
      if (<?php echo strtotime(date("Y-m-d")) ?> > maintainEnd) {
        $("#"+customer_id).val('');
        $('#'+customerName_id).val('');
        $('#'+project_id).val('');
      }
    }else{
      test3($("#"+customer_id).val(),'forcasting');
      $("#"+maintain_seq_id).val('');
    }
  }else{ //포캐스팅
    test3($("#"+customer_id).val(),'forcasting');
    $("#"+maintain_seq_id).val('');
  }
  $("#"+myDropdown).toggle();
}

//고객사 입력 검색
function filterFunction(customerName) {
  var input, filter, ul, li, a, i;
  input = document.getElementById(customerName.id);
  filter = input.value.toUpperCase();
  myDropDown = $(customerName).parent().attr('id');
  div = document.getElementById(myDropDown);
  a = div.getElementsByTagName("a");
  for (i = 0; i < a.length; i++) {
    txtValue = a[i].textContent || a[i].innerText;
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
      a[i].style.display = "";
    } else {
      a[i].style.display = "none";
    }
  }
}

// 고객사 담당자 가져오는 함수
function test3(name,mode) {
  var settings = 'height=500,width=1000,left=0,top=0';
  var popup = window.open('/index.php/tech/tech_board/search_manager?name=' + name+'&mode='+mode+'&page=sch', '_blank');
  window.focus();
}

// 외부영역 클릭 시 팝업 닫기
$(document).mouseup(function (e){
  var LayerPopup = $("#dropdown");
  if(LayerPopup.has(e.target).length === 0){
    $("#myDropdown").hide();
  }

  var de_LayerPopup = $("#de_dropdown");
  if(de_LayerPopup.has(e.target).length === 0){
    $("#de_myDropdown").hide();
  }
});
// KI2 20210125

//KI1 20210208
function show_input_customerName(customerName){
  var parent_id = $(customerName).closest("div").attr("id");
  if(parent_id == 'de_dropdown_option'){
    var customerName_id = 'de_customerName';
    var project_id = 'de_project';
    var customer_manager_id = 'de_customer_manager';
    // var customer_tmp_id = 'de_customer_tmp';
    var forcasting_seq_id = 'de_forcasting_seq';
    var maintain_seq_id = 'de_maintain_seq';
    var tech_report_id = 'de_tech_report';
    var myDropdown = 'de_myDropdown';
  }else{
    var customerName_id = 'customerName';
    var project_id = 'project';
    var customer_manager_id = 'customer_manager';
    // var customer_tmp_id = 'customer_tmp';
    var forcasting_seq_id = 'forcasting_seq';
    var maintain_seq_id = 'maintain_seq';
    var tech_report_id = 'tech_report';
    var myDropdown = 'myDropdown';
  }
  $('#'+customerName_id).attr('readonly',false);
  $('#'+project_id).attr('readonly',false);
  $('#'+customerName_id).css('border','2px solid');
  $('#'+customerName_id).css('border-color','black');
  $('#'+customerName_id).css('border-radius','5px');
  $('#'+customerName_id).val('');
  $('#'+customer_manager_id).val('');
  // $('#'+customer_tmp_id).val('');
  $('#'+project_id).val('');
  $('#'+forcasting_seq_id).val('');
  $('#'+maintain_seq_id).val('');
  $('#'+tech_report_id).val('Y');
  $("#"+myDropdown).toggle();
}
//KI2 20210208

function popupClose(close_popup_id) {
 $("#show_day_select_popup").bPopup().close();
}

function show_day_select() {
  $("#show_day_select_popup").bPopup();
}

  </script>
<body>
<?php
  if($this->agent->is_mobile()){
    include $this->input->server('DOCUMENT_ROOT')."/include/mobile_header.php";
  }else{
    include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
  }
?>
<table id="zg" width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" valign="top">
      <!-- //여기부터 -->

      <!-- 일정 추가 팝업 -->
      <!-- 일정 추가 팝업 -->
  <div id='addpopup' style=" width:30%; height: auto;">
        <!-- KI1 20210125 고객사 담당자를 불러오기 위해 name=cform으로 적용-->
      <article class="layerpop_area">
        <form name="cform" id="cform" action="<?php echo site_url();?>/biz/schedule/add_schedule" method="post">
        <!-- KI2 20210125 -->
          <!-- <table> -->
          <div align="left" class="modal_title">일정등록
            <!-- <a style="float:right" onclick="$('#addpopup').bPopup().close();">
              <img src="/misc/img/btn_del2.jpg"/>
            </a> -->
          </div>
            <table width="100%" border="0" callspacing="0" cellspacing="0">
              <tbody align="left">
                <!-- KI1 20210125 고객사 담당자 적용을 위한 hidden input 적용, 프로젝트 input 추가 -->
                <input type="hidden" name="customer_manager" id="customer_manager" class="input2">
                <!-- <input type="hidden" name="maintain_end" id="maintain_end" class="input2">

                <input type="hidden" id="row_max_index" name="row_max_index" value="0" />
                <input type="hidden" id="customer_tmp" name="customer_tmp" value="" /> -->
                <!-- ↑customerName과 동일 -->
                <input type="hidden" id="forcasting_seq" name="forcasting_seq" value="" />
                <input type="hidden" id="maintain_seq" name="maintain_seq" value="" />
                <input type="hidden" id="work_type" name="work_type" value="" />
                <!-- <input type="hidden" id="checkListForm" name="checkListForm" value="" /> -->
                <!-- KI1 20210208 -->
                <input type="hidden" id="tech_report" name="tech_report" value="" />
                <!-- KI2 20210208 -->
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                   <td>
                     <td align="center">
                       <table border="0" cellspacing="0" cellpadding="0" width="95%" class="modal-input-tbl">
                          <colgroup>
                            <col width="25%" />
                            <col width="75%" />
                          </colgroup>
                         <tbody>
                           <tr>
                             <td style="font-weight:bold;">구분</td>
                             <td>
                               <select name="workname" id="workname" class="select-common select-style1" onchange="" style="float:left;margin-right:10%;">
                                 <option value="" selected disabled hidden>선택하세요</option>
                                  <?php
                                  if ($this->group == '기술연구소') {
                                    echo "<option value='기술연구소'>기술연구소</option>";
                                  }
                                  foreach ($work_name as $val) {
                                    echo "<option value='{$val->work_name}' >{$val->work_name}</option>";
                                  }
                                  ?>
                               </select>
                               <span class="" style="float:left;font-weight:bold;width:30px;margin-top:3px;">직출</span>
                               <span class="" style="float:left;">
                                 <input type="checkbox" name="outside_work" id="outside_work" value="" style="margin-top:5px;">
                               </span>

                               <span class="tech_div" style="float:left;font-weight:bold;width:60px;margin-top:3px;margin-left:5%;">지원방법</span>

                               <span class="tech_div" style="float:left;">
                                 <select class="select-common select-style1" name="supportMethod" id="supportMethod">
                                   <option value="" selected disabled hidden>선택하세요</option>
                                   <option value="현장지원">현장지원</option>
                                   <option value="원격지원">원격지원</option>
                                 </select>
                               </span>
                             </td>
                           </tr>
                           <tr class="except_nondisclosure_div">
                             <td style="font-weight:bold;">회의실 예약</td>
                             <td>
                               <input class="input-common" onclick="open_conference('insert');" type="text" id="room_name" name="room_name" value="" style="width:80%" readonly>
                               <img src="<?php echo $misc; ?>/img/x-box.svg" style="cursor:pointer;width:20px;margin-left:5px;vertical-align:middle;" onclick="$('#room_name').val('');">
                             </td>
                           </tr>
                           <tr class="except_nondisclosure_div">
                              <td style="font-weight:bold;">차량 예약</td>
                              <td>
                                <input class="input-common" onclick="open_car_reservation('insert');" type="text" id="car_name" name="car_name" value="" style="width:80%" readonly>
                                <img src="<?php echo $misc; ?>/img/x-box.svg" style="cursor:pointer;width:20px;margin-left:5px;vertical-align:middle;" onclick="$('#car_name').val('');">
                              </td>
                           </tr>
                           <tr>
                             <td style="font-weight:bold; ">시작일자</td>
                             <td>
                              <?php if($this->agent->is_mobile()){ ?>
                                <input class="input-common dayBtn" type="date" name="startDay" id="startDay" value="<?php echo date("Y-m-d"); ?>" autocomplete="off" onchange="conference_room_del('insert'); date_compare('');" style="width:40%;vertical-align:middle;background-color:#FFFFF2;">
                                <input class="input-common timeBtn" type="time" name="startTime" id="startTime" value="" autocomplete="off" style="width:30%;vertical-align:middle;background-color:#FFFFF2;">
                              <?php }else{?>
                                  <input class="input-common dayBtn" type="text" name="startDay" id="startDay" value="<?php echo date("Y-m-d"); ?>" autocomplete="off" onchange="conference_room_del('insert'); date_compare('');" style="width:40%;background-color:#FFFFF2;">
                                  <input class="dateBtn" type="button" name="" id="startBtn" value=" " onclick="openStartDate();" style="width:10%;margin-left:10px;" >
                                  <input class="input-common timeBtn" type="text" name="startTime" id="startTime" value="" autocomplete="off" style="width:30%;background-color:#FFFFF2;margin-left:10px;">
                              <?php } ?>
                             </td>
                           </tr>
                           <tr>
                             <td style="font-weight:bold; ">종료일자</td>
                             <td>
                              <?php if($this->agent->is_mobile()){ ?>
                                <input class="input-common dayBtn" type="date" name="endDay" id="endDay" value="<?php echo date("Y-m-d"); ?>" autocomplete="off" onchange="conference_room_del('insert'); date_compare('');" style="width:40%;vertical-align:middle;background-color:#FFFFF2;">
                                <input class="input-common timeBtn" type="time" name="endTime" id="endTime" value="" autocomplete="off" style="width:30%;vertical-align:middle;background-color:#FFFFF2;">
                              <?php }else{?>
                               <input class="input-common dayBtn" type="text" name="endDay" id="endDay" value="<?php echo date("Y-m-d"); ?>" autocomplete="off" onchange="conference_room_del('insert'); date_compare('');" style="width:40%;background-color:#FFFFF2;">
                               <input type="button" name="" id="endBtn" class="dateBtn" value=" " onclick="openEndDate();" style="width:10%;margin-left:10px;">
                               <input class="input-common timeBtn" type="text" name="endTime" id="endTime" value="" autocomplete="off" style="width:30%;background-color:#FFFFF2;margin-left:10px;">
                              <?php } ?>
                              </td>
                           </tr>
                           <tr>
                             <td style="font-weight:bold; ">반복일정<input type="checkbox" name="recurring_check" id="recurring_check" value="" onchange="change_recurring_check('');"></td>
                             <td>
                               <select class="select-common select-style1 recurring_div" name="recurring_select" id="recurring_select">
                                 <option value="" num = "1" id="recurring_day"></option>
                                 <!-- 요일값 -->
                                 <option value="" num = "2" id="recurring_week"></option>
                                 <option value="" num = "3" id="recurring_month_day"></option>
                                 <!-- BYSETPOS 사용 -->
                                 <option value="" num = "4" id="recurring_month"></option>
                                 <!-- 월과 일자값 -->
                                 <!-- <option value="" id="recurring_year"></option> -->
                               </select>
                               <select class="select-common select-style1 recurring_div" name="recurring_select_ex" id="recurring_select_ex" onchange="change_recurring_select_ex('');">
                                 <option value="recurring_endDay" num = "1" id="recurring_endDay_opt">종료일자</option>
                                 <option value="recurring_count" num = "2" id="recurring_count_opt">반복횟수</option>
                               </select>
                               <input type="text" name="recurring_endDay" id="recurring_endDay" class="dayBtn input_ex input-common recurring_div" value="" autocomplete="off" onchange="conference_room_del('insert'); date_compare('');" style="width:20%; display:none;">
                               <input type="text" name="recurring_count" id="recurring_count" class="input_ex input-common recurring_div" value="" style="width:20%; display:none;" placeholder="숫자로 입력">
                             </td>
                           <tr class="general_div sch_title_div">
                             <td style="font-weight:bold; ">제목</td>
                             <td>
                               <input class="input-common" type="text" name="title" id="title" value="" style="width:80%">
                             </td>
                           </tr>
                           <tr class="general_div sch_loc_div">
                             <td style="font-weight:bold;">장소</td>
                             <td>
                               <input class="input-common" type="text" name="place" id="place" value="" style="width:80%">
                             </td>
                           </tr>
                           <tr class="except_company_div">
                             <td style="font-weight:bold; " >고객사</td>
                             <td>
                                 <div class="dropdown tech_div" id="dropdown">
                                   <p onclick="searchFunction(this.id)" id="dropbtn" class="dropbtn">검색</p>
                                   <input id="customerName" name ="customerName" type="text" class="customerName" value="" style="border:none;width:200px;font-weight:bold;text-align:center;">
                                   <input type="hidden" id="customer" name="customer" value="" style="border:none" readonly>
                                   <div id="myDropdown" class="dropdown-content">
                                     <input type="text" name="0" placeholder="고객사를 입력하세요" id="searchInput" class="searchInput" onkeyup="filterFunction(this)" autocomplete="off">
                                     <div id="dropdown_option" style="overflow:scroll; width:277px; height:300px;">
                                     </div>
                                   </div>
                                 </div>
                                 <div class="general_div except_company_div">
                                   <input class="input-common" type="text" id="customerName2" name="customerName2" value="" style="width:80%">
                                 </div>
                             </td>
                           </tr>
                           <tr class="sales_div" style="display:none;">
                             <td style="font-weight:bold;">방문 업체</td>
                             <td>
                               <input class="input-common" type="text" id="visitCompany" name="visitCompany" value="" style="width:80%">
                             </td>
                           </tr>
                           <tr class="tech_div">
                             <td style="font-weight:bold; ">프로젝트</td>
                             <td>
                               <input class="input-common" type="text" id="project" name="project" value="" style="width:80%">
                             </td>
                           </tr>
                           <tr class="except_company_div">
                           <!-- <tr class="except_company_div except_nondisclosure_div"> -->
                             <td style="font-weight:bold; ">참석자</td>
                             <td>
                               <!-- <input type="text" name="participant" id="participant" value="" placeholder="" size='45'>
                               <input type="image" src="<?php echo $misc; ?>/img/participant_add.jpg" id="addUserBtn" class="btn" style="width:25px; height:25px; vertical-align:middle;" onclick="addUser_Btn();return false;"> -->
                               <li>
                                 <div class="" style="padding:5px 0;">
                                   <input class="input-common" type="text" name="participant_input" id="participant_input" value="" placeholder="" onkeypress="keypress(event,this.value,'participant')" autocomplete="off" style="width:80%;">
                                   <input type="hidden" name="participant" id="participant" value="" placeholder="">
                                   <img src="<?php echo $misc; ?>/img/participant_add.svg" id="addUserBtn" class="btn" style="width:25px;margin-left:5px;vertical-align:middle;" onclick="addUser_Btn();return false;">
                                   <!-- <input type="image" src="<?php echo $misc; ?>/img/participant_add.jpg" id="addUserBtn" class="btn" style="width:25px; height:25px; vertical-align:middle;" onclick="addUser_Btn();return false;"> -->
                                 </div>
                               </li>
                               <li style="margin-top:5px;margin-bottom:5px;">
                                 <div id="participant_box" name="participant_box">

                                 </div>
                               </li>
                             </td>
                           </tr>
                           <tr class="general_div explanation_div none-tr" style="display:none;">
                             <td colspan="1"></td>
                             <td>
                               <div class="" style="float:left; width:50%; text-align:left;">
                                 <span style="font-size:10px; font-weight:bold;">주간업무</span>
                               </div>
                               <div class="" style="display:inline-block; width:50%; text-align:right;">
                                 <span style="font-size:10px; font-weight:bold;">추가/삭제</span>
                               </div>
                             </td>
                           </tr>
                           <!-- <tr>
                             <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                           </tr> -->
                           <!-- KI_20210405_내용분할1 -->
                           <tr id="contents_tr_0">
                             <td style="font-weight:bold; ">내용</td>
                             <td>
                               <input type="checkbox" class="add_weekly_report" id="add_weekly_report_0" name="add_weekly_report" value="" style="vertical-align:middle;width:10%;float:left" onclick="nondisclosure_weekly_report('nondisclosure')">
                               <textarea class="textarea-common" rows="2" name='contents' id="contents_0" placeholder="상세내용" style="resize:none; vertical-align:middle; margin:2px -1.8px;width:80%;float:left;margin-top:10px;margin-bottom:10px;" maxlength="300"></textarea>
                               <input type="hidden" name="contents_num" id="contents_num_0" value="0">
                               <img src="<?php echo $misc; ?>img/btn_add.jpg" id="contents_add" name="contents_add" onclick="contents_add_action('contents');return false;" style="cursor:pointer;vertical-align:middle;float:right" />
                             </td>
                           </tr>

                           <!-- 기술연구소 -->
                           <tr id="lab_contents_tr" class="lab_contents_tr" style="display:none;">
                              <td style="font-weight:bold">개발구분</td>
                              <td>
                                <select class="select-common" id="dev_type" name="dev_type" style="float:left;margin-right:10%;">
                                  <option value="" selected disabled hidden>선택하세요</option>
                                  <option value="신규개발">신규개발</option>
                                  <option value="기능개선">기능개선</option>
                                  <option value="버그수정">버그수정</option>
                                </select>
                                <span style="float:left;font-weight:bold;width:60px;margin-top:3px;margin-right:5%;">페이지</span>
                                <span style="float:left;">
                                  <input class="input-common" type="text" id="dev_page" name="dev_page" value="" style="width:100px;">
                                </span>
                              </td>
                           </tr>
                           <tr id="lab_contents_tr" class="lab_contents_tr" style="display:none;">
                             <td style="font-weight:bold">요청자</td>
                             <td>
                               <input class="input-common" type="text" id="dev_requester" name="dev_requester" value="" style="width:80%;">
                             </td>
                           </tr>
                           <tr id="lab_contents_tr" class="lab_contents_tr" style="display:none;">
                             <td style="font-weight:bold">개발사항</td>
                             <td>
                               <textarea class="textarea-common" id="dev_develop" name="dev_develop" rows="5" cols="52" style="resize:none; vertical-align:middle;width:80%;float:left;margin-top:10px;margin-bottom:10px;"></textarea>
                             </td>
                           </tr>
                           <tr id="lab_contents_tr" class="lab_contents_tr" style="display:none;">
                              <td style="font-weight:bold;">완료여부</td>
                              <td>
                                <input type="checkbox" id="dev_complete" name="dev_complete" value="">
                              </td>
                           </tr>
                           <!-- 기술연구소 -->

                             <!-- KI_20210405_내용분할2 -->
                           </tr>
                           <tr class="report_div" style="display:none;">
                             <td style="font-weight:bold; ">비공개</td>
                             <td>
                               <input type="checkbox" id="nondisclosure_sch" name="nondisclosure_sch" value="" onclick="nondisclosure_form('nondisclosure')">
                             </td>
                           </tr>
                         </tbody>
                       </table>
                       <div style="margin-top:30px;">
                         <button type="button" name="scheduleAdd" id="scheduleAdd" class="btn-common btn-color2" onClick="sch_insert('')" style="float:right;margin-right:14px;">등록</button>
                         <button type="button" class="btn-common btn-color1" onClick="$('#addpopup').bPopup().close();" style="float:right;margin-right:14px;">취소</button>
                       </div>
                     </td>
                   </td>
                </tr>
            </table>
        </form>
      </article>
  </div>
<!-- 팝업 끝 -->

<!-- KI1 20210125 참여자 추가 형태를 검색 참여자 추가 형태로 변경  -->
<!-- 참여자 팝업 추가 -->
<div id="addUserpopup">
  <img id="addUserpopupCloseBtn" src="<?php echo $misc;?>img/btn_del2.jpg" onclick="closeBtn()" width=25  style="cursor:pointer;margin:0% 0% 0% 92%"/>
  <!-- <span id="addUserpopupCloseBtn" class="btn" onclick="closeBtn()" style="margin:0% 0% 0% 96%; color:white;">X</span> -->
  <div id="modal-body">
    <div id="modal-grouptree">
      <div id="usertree">
        <ul>
          <li>(주)두리안정보기술
            <ul>
            <?php
            foreach ($parentGroup as $pg){
            ?>

            <?php
            if ($pg->childGroupNum==1 && $pg->depth==1){
            ?>
              <li>
                <?php echo $pg->parentGroupName;
                  foreach ($userInfo as $ui){
                      if ($pg->groupName==$ui->user_group){
                ?>
                <ul>
                  <li id="<?php echo $ui->user_name; ?>" seq="<?php echo $ui->seq; ?>" ><?php echo $ui->user_name." ".$ui->user_duty; ?></li>
                </ul>
                <?php
                      }
                  }
                ?>
              </li>
              <?php
              } else if ($pg->childGroupNum>1 && $pg->depth==1){
              ?>
              <li>
              <?php echo $pg->parentGroupName;
              foreach ($user_group as $ug) {
                if ($pg->parentGroupName==$ug->parentGroupName){
              ?>
                <ul>
                  <?php
                  foreach ($userDepth as $ud){
                      if ($ug->groupName == $ud->groupName){
                        echo '<li id="'.$ud->user_name.'" seq="'.$ud->seq.'">'.$ud->user_name." ".$ud->user_duty.'</li>';
                      }
                  }
                  if ($ug->groupName != $pg->groupName){
                    echo "<li>".$ug->groupName;
                  }
                  ?>
                    <ul>
                    <?php
                      foreach($userInfo as $ui) {
                        if ($ug->groupName==$ui->user_group){
                          echo '<li id="'.$ui->user_name.'" seq="'.$ui->seq.'" >'.$ui->user_name." ".$ui->user_duty.'</li>';
                        }
                      }
                    ?>
                    </ul>
                  </li>
                </ul>
              <?php
                }
              }
              ?>
              </li>
              <?php
              }
              ?>
            <?php
            }
            ?>
            </ul>
          </li>
        </ul>
      </div>
    </div>
        <div id="btnDiv">
          <input type="button" style="float:right;" class="basicBtn" id="insertUserBtn" name="" value="적용" onclick="addUser(this.id)">
        </div>
      </div>
    </div>
    <!-- 참여자 팝업 끝 -->
    <!-- KI2 20210125 -->

    <!-- 검색 참여자 팝업 추가 -->
    <div id="searchAddUserpopup">
      <span id="searchAddUserpopupCloseBtn" class="btn" onclick="searchCloseBtn()" style="margin:0% 0% 0% 96%; color:white;">X</span>
      <div id="search-modal-body">
        <div id="search-modal-grouptree">
          <div id="search-usertree">
            <ul>
              <li>(주)두리안정보기술
                <ul>
                <?php
                foreach ($parentGroup as $pg){
                ?>

                <?php
                if ($pg->childGroupNum==1 && $pg->depth==1){
                ?>
                  <li>
                    <?php echo $pg->parentGroupName;
                      foreach ($userInfo as $ui){
                          if ($pg->groupName==$ui->user_group){
                    ?>
                    <ul>
                      <li id="<?php echo $ui->user_name; ?>"><?php echo $ui->user_name." ".$ui->user_duty; ?></li>
                    </ul>
                    <?php
                          }
                      }
                    ?>
                  </li>
                  <?php
                  } else if ($pg->childGroupNum>1 && $pg->depth==1){
                  ?>
                  <li>
                  <?php echo $pg->parentGroupName;
                  foreach ($user_group as $ug) {
                    if ($pg->parentGroupName==$ug->parentGroupName){
                  ?>
                    <ul>
                      <?php
                      foreach ($userDepth as $ud){
                          if ($ug->groupName == $ud->groupName){
                            echo '<li id="'.$ud->user_name.'">'.$ud->user_name." ".$ud->user_duty.'</li>';
                          }
                      }
                      if ($ug->groupName != $pg->groupName){
                        echo "<li>".$ug->groupName;
                      }
                      ?>
                        <ul>
                        <?php
                          foreach($userInfo as $ui) {
                            if ($ug->groupName==$ui->user_group){
                              echo '<li id="'.$ui->user_name.'">'.$ui->user_name." ".$ui->user_duty.'</li>';
                            }
                          }
                        ?>
                        </ul>
                      </li>
                    </ul>
                  <?php
                    }
                  }
                  ?>
                  </li>
                  <?php
                  }
                  ?>
                <?php
                }
                ?>
                </ul>
              </li>
            </ul>
          </div>
        </div>
        <div id="search-btnDiv">
        <input type="button" style="float:right;" class="basicBtn" id="searchChosenBtn" name="" value="적용" onclick="addUser(this.id)">
        </div>
      </div>
    </div>
        <!-- 검색 참여자 팝업 끝 -->

<!-- 색상 커스터미이징 팝업 -->

      <div id='customPop' style="display : none; background-color: white; width: 700px; height: 700px;">
        <h3 style="text-align:center; color:#aaa;">작업별 색상 설정</h3>
        <div class="well">
          <div class="row">
            <table id="workColor_tbl">
              <tbody style="width:100%">


<?php
foreach($work_color as $val){
  if($val->work_type == 'tech'){
    echo '<tr id="'.$val->seq.'" style="border-bottom: 30px solid #f5f5f5; width:100%; height:90%;">';
    echo '<td style="width:30%"><label for="hue-demo">'.$val->work_name.'</label>';
    echo '<input style="height:30px" type="text" name="work_color" class="form-control demo work_color" data-control="hue" value="'.$val->color.'" onchange="colorCustom(this);"/></td>';
    echo '<td style="width:30%"><label for="saturation-demo">글자색</label>';
    echo '<input style="height:30px" type="text" name="text_color" class="form-control demo text_color" data-control="saturation" value="'.$val->textColor.'" onchange="colorCustom(this);"/></td>';
    echo '<td style="width:30%"><label for="saturation-demo">출력</label>';
    echo '<input type="text" class="form-control printDemo" data-control="saturation" value="'.$val->work_name.'" style="background-color:'.$val->color.'; color:'.$val->textColor.'; height:30px"/></td></tr>';
  }
}
 ?>
            </tbody>
          </table>
          <button style="float:right" type="button" class="btn" name="button" onclick="save_workColor_close();" class="">닫기</button>
          <button style="float:right" type="button" class="btn" name="button" onclick="save_workColor();">저장</button>

          </div>
        </div>
      </div>
<!-- 색상 커스터미이징 팝업 끝-->

<!-- 기술지원보고서 알림 팝업 시작 -->
<div id="unwrittenpopup" >
  <a style="margin:0% 0% 0% 96%;cursor:pointer;"><span id="unwrittenpopupCloseBtn" onclick="report_closeBtn()"><span style="color:black;">X</span></span></a>
  <input type="hidden" id="session_name" value= "<?php echo $session_name?>"/>
</div>
<!-- 기술지원보고서 알림 팝업 끝 -->
      <div id='updateform' style="display: none; background-color: white; width: 450px; height: 500px;">
        <form name="hiddenSeq" action="<?php echo site_url();?>/biz/schedule/tech_schedule_detail" method="GET">
          <input type="text" name="hiddenSeq" id="hiddenSeq" value="">
          <input type="text" id="login_pgroup" name="login_pgroup" value= "<?php echo $pGroupName?>"/>
          <input type="text" id="login_group" name="login_group" value= "<?php echo $login_group?>"/>
          <input type="text" id="login_user_duty" name="login_user_duty" value= "<?php echo $login_user_duty?>"/>
          <input type="submit" name="seqBtn" id="seqBtn" >
        </form>
        <input type="text" id="session_id" value= "<?php echo $session_id;?>"/>
      </div>
      <div id="body_contain">
      <div id="sd_contain">
        <div id="scheduleTop" style="margin-bottom:20px;">
              <!-- <button <?php if($session_id!='kkj'){echo 'style="display:none;"';} ?> type="button" name="button" onclick="customPop();" class="fc-addSchedule-button fc-button fc-button-primary"><img src="<?php echo $misc?>/img/setting.png" style="width:25px; height:25px; vertical-align:middle;"></button> -->
              <form id="searchWord" method="POST">
                <br>
                <div class="searchbox searchDiv" id="searchDiv" >
                  <select id="searchSelect" class="select-common select-style1" style="margin-right:10px;" onchange="searchSelFunc()">
                    <option value="participant">참석자</option>
                    <option value="user_name">등록자</option>
                    <option value="work_name">구분</option>
                    <option value="support_method">지원방법</option>
                    <option value="customer">고객사</option>
                    <option value="contents">내용</option>
                    <option value="group">부서</option>
                  </select>
                </div>
                <div class="searchbox changeDiv" id="changeDiv">
                  <input type="text" id="searchText" class="input-common" style="margin-right:10px;" placeholder="검색어를 입력하세요." autocomplete="off" onfocus="onFoc(this.id)">
                  <!-- <input type="text" id="searchText" class="input2" style="vertical-align:middle; border-radius:20px; outline:none;" placeholder="검색어를 입력하세요." autocomplete="off" onfocus="onFoc(this.id)" onClick="searchAddUserBtn()" readonly> -->

                  <!-- onkeyup="this.value = onlyKor(this.value);"  -->
                  <!-- onkeyup="onlyKor(this);" -->
                  <!-- style="width: 270px;" -->
                  <img src="<?php echo $misc; ?>/img/participant_add.svg" id="selectParticipantBtn" class="btn" style="width:30px;margin-right: 10px;vertical-align:middle;" onclick="searchAddUserBtn()">
                </div>
                <div class="searchbox changeDiv2" id="changeDiv2" style="display:none;">
                  <select class="select-common" id="work_nameSelect" style="margin-right:10px;width:115px;" onfocus="onFoc(this.id)" >
                    <!-- style="width: 275px;" -->
                    <option value="" selected disabled hidden>선택하세요</option>
                    <?php
                      foreach ($work_name as $val2) {
                        echo "<option value = '{$val2->work_name}'>{$val2->work_name}</option>";
                      }
                    ?>
                </select>
                </div>
                <div class="searchbox changeDiv3" id="changeDiv3" style="display:none;">
                  <select class="select-common" id="support_methodSelect" style="margin-right:10px;width:115px;" onfocus="onFoc(this.id)" >
                    <!-- style="width: 275px;" -->
                    <option value="" selected disabled hidden>선택하세요</option>
                    <option value="현장지원">현장지원</option>
                    <option value="원격지원">원격지원</option>
                  </select>
                </div>
                <div class="searchbox changeDiv4" id="changeDiv4" style="display:none;">
                  <select class="input7" id="customerSelect" style="height:23px; border-radius:20px; outline:none;" onfocus="onFoc(this.id)">
                  <!-- <select class="input" id="customerSelect" style="height:23px; border-radius:20px; outline:none;" onfocus="onFoc(this.id)" onmouseover="select2(this);"> -->
                    <option value="" selected disabled hidden >선택하세요</option>
                    <?php
                    foreach ($search_customer as $val) {
                      echo "<option value = '".$val['customer']."'>".$val['customer']."</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="searchbox searchBtnDiv" id="searchBtnDiv">
                  <!-- <img id="searchBtn" style="height:23px;width:23px; text-align:middle; cursor:pointer;" onclick="func_search()" src="<?php echo $misc; ?>img/dashboard/btn/btn_search.png"> -->
                  <input id="searchBtn" class="btn-common btn-style1" type="button" onclick="func_search();" value="검색" >
                  <!-- <button type="button" name="submit" id="searchBtn" style="height:25px; text-align:middle;" onclick="func_search()" class="basicBtn">검색</button> -->
                  <input class="basicBtn" type="submit" id="searchReset" style="display:none;height:25px;" onclick="list_search()" value="초기화">
                  <button type="button" name="button" onclick="excelExport();" class="fc-addSchedule-button fc-button fc-button-primary basicBtn" id="excelDownload" style="display:none; height:25px; width:80px;">엑셀 다운</button>
              </div>
            </form><br><br>
        </div>
        <div id="scheduleSidebar" style="text-align: left;width:230px;">
          <div class="" style="text-align:left;" id="company_schedule">
            <input type="checkbox" id="company_schedule_checkbox" onclick="company_schedule_check()" checked><span class="notice_text">공지일정 보기<span>
          </div>
          <!-- <h2>sidebar</h2> -->
          <!-- @@ ↓ -->

          <div id="tree">
            <ul>
              <li>(주)두리안정보기술 (<?php echo $user_count[0]['cnt']; ?>)
                <ul>
                <?php
                foreach ($parentGroup as $pg){
                ?>
                  <?php
                  if ($pg->childGroupNum==1 && $pg->depth==1){
                  ?>
                    <li>
                      <?php foreach($parent_group_count as $pgc) {
                        if ($pg->parentGroupName == $pgc['parentGroupName']) {
                          echo $pg->parentGroupName." (".$pgc['cnt'].")";
                        }
                      }
                      foreach ($userInfo as $ui){
                          if ($pg->groupName==$ui->user_group){
                      ?>
                      <ul>
                        <li id="<?php echo $ui->user_name; ?>"><?php echo $ui->user_name." ".$ui->user_duty; ?></li>
                      </ul>
                      <?php
                          }
                      }
                      ?>
                    </li>
                  <?php
                  } else if ($pg->childGroupNum>1 && $pg->depth==1){
                  ?>
                  <li>
                    <?php
                    foreach($parent_group_count as $pgc) {
                      if ($pg->parentGroupName == $pgc['parentGroupName']) {
                        echo $pg->parentGroupName." (".$pgc['cnt'].")";
                      }
                    }
                    foreach ($user_group as $ug) {
                      if ($pg->parentGroupName==$ug->parentGroupName){
                    ?>
                    <ul>
                    <?php
                      foreach ($userDepth as $ud){
                        if ($ug->groupName == $ud->groupName){
                          echo '<li id="'.$ud->user_name.'">'.$ud->user_name." ".$ud->user_duty.'</li>';
                        }
                      }
                      if ($ug->groupName != $pg->groupName){
                        foreach($user_group_count as $ugc){
                          if ($ug->groupName == $ugc['groupName']) {
                            echo "<li>".$ug->groupName.' ('.$ugc['cnt'].')';
                          }
                        }
                      }
                    ?>
                        <ul>
                          <?php
                          foreach($userInfo as $ui) {
                            if ($ug->groupName==$ui->user_group){
                              echo '<li id="'.$ui->user_name.'">'.$ui->user_name." ".$ui->user_duty.'</li>';
                            }
                          }
                          ?>
                        </ul>
                      </li>
                    </ul>
                    <?php
                      }
                    }
                    ?>
                  </li>
                    <?php
                  }
                    ?>
                <?php
                }
                ?>
                </ul>
              </li>
            </ul>

          </div>
          <!-- @@ ↑ -->
        </div>
        <div id='calendar' style="padding-bottom:100px;">
          <!-- 여기 달력뷰 -->
        </div>
      </div>
      <!-- <div id="scheduleBottom"> </div> -->
      <!-- ↑sd 컨테인 끝 -->

      <div id = 'updateSchedule' style="width:30%; height: auto;" class="layerpop" >
        <article class="layerpop_area">
          <!-- <form id="de_hiddenSeq" name="de_cform" method="GET"> -->
            <!-- KI2 20210125 -->
            <div align="left" class="modal_title">일정 상세
              <!-- <a style="float:right" onclick="$('#updateSchedule').bPopup().close();">
                <img src="/misc/img/btn_del2.jpg"/>
              </a> -->
            </div>

                  <table width="100%" border="0" callspacing="0" cellspacing="0">
                    <!-- KI1 20210125 고객사 담당자 선택을 위한 name=cform 적용-->
                      <!-- KI2 20210125 -->
                      <!-- <form name="hiddenSeq" action="<?php echo site_url();?>/schedule/modify" method="post"> -->
                      <!-- <tbody> -->
                      <!-- 일정의 seq -->
                      <input type="hidden" name="de_seq" id="de_seq" value="">
                      <input type="hidden" id ="de_work_type" name="de_work_type" value="">
                      <input type="hidden" id="de_mode" name="de_mode" value="">
                      <input type="hidden" id="de_link" name="de_link" value="">
                      <!-- KI1 20210125 고객사 담당자 적용을 위한 hidden input 적용, 프로젝트 input 추가 -->
                      <input type="hidden" name="de_customer_manager" id="de_customer_manager" class="input2" value="">
                      <!-- <input type="hidden" name="de_maintain_end" id="de_maintain_end" class="input2">
                      <input type="hidden" id="de_row_max_index" name="de_row_max_index" value="0" />
                      <input type="hidden" id="de_customer_tmp" name="de_customer_tmp" value="" /> -->
                      <!-- ↑customerName과 동일 -->
                      <input type="hidden" id="de_forcasting_seq" name="de_forcasting_seq" value="" />
                      <input type="hidden" id="de_maintain_seq" name="de_maintain_seq" value="" />
                      <tr>
                        <td>&nbsp;</td>
                     </tr>
                     <tr>
                       <td>
                         <td align="center">
                           <table border="0" cellspacing="0" cellpadding="0" width="95%" class="modal-input-tbl">
                           <colgroup>
                            <col width="25%" />
                            <col width="75%" />
                          </colgroup>
                              <tbody>
                                <tr>
                                  <td style="font-weight:bold; ">구분</td>
                                  <td>
                                    <select name="de_workname" id="de_workname" class="select-common select-style1" onchange="" style="float:left;margin-right:10%;">
                                      <option value="" selected disabled hidden>선택하세요</option>
                                       <?php
                                       foreach ($work_name as $val) {
                                         echo "<option value='{$val->work_name}' >{$val->work_name}</option>";
                                       }
                                       ?>
                                     </select>
                                       <span class="" style="float:left;font-weight:bold;width:30px;margin-top:3px;">직출</span>
                                       <span class="" style="float:left;">
                                         <input type="checkbox" name="de_outside_work" id="de_outside_work" value="de_outside_work" style="margin-top:5px;">
                                       </span>

                                         <span class="tech_div" style="float:left;font-weight:bold;width:60px;margin-top:3px;margin-left:5%;">지원방법</span>

                                         <span class="tech_div" style="float:left;">
                                           <select class="select-common select-style1" name="de_supportMethod" id="de_supportMethod">
                                             <option value="" selected disabled hidden>선택하세요</option>
                                             <option value="현장지원">현장지원</option>
                                             <option value="원격지원">원격지원</option>`
                                           </select>
                                         </span>



                                       </td>
                                </tr>
                                <tr class="de_except_nondisclosure_div">
                                  <td style="font-weight:bold;">회의실 예약</td>
                                  <td>
                                    <input class="input-common" type="text" id="de_room_name" name="de_room_name" value="" onclick="open_conference('detail');" style="width:80%" readonly>
                                    <img src="<?php echo $misc; ?>/img/x-box.svg" style="cursor:pointer;width:20px;margin-left:5px;vertical-align:middle;" onclick="$('#de_room_name').val('');">
                                  </td>
                                </tr>
                                <tr class="de_except_nondisclosure_div">
                                   <td style="font-weight:bold;">차량 예약</td>
                                   <td>
                                     <input class="input-common" type="text" id="de_car_name" name="de_car_name" value="" onclick="open_car_reservation('detail');" style="width:80%" readonly>
                                     <img src="<?php echo $misc; ?>/img/x-box.svg" style="cursor:pointer;width:20px;margin-left:5px;vertical-align:middle;" onclick="$('#de_car_name').val('');">
                                   </td>
                                </tr>
                               <form id="img_file_form" method="post" enctype="multipart/form-data">
                               <tr>
                                 <td style="font-weight:bold; ">시작일자</td>
                                 <td>
                                  <?php if($this->agent->is_mobile()){ ?>
                                    <input type="date" name="de_startDay" id="de_startDay" class="input-common dayBtn" value="" autocomplete="off" onchange="conference_room_del('update'); date_compare('de_');" style="width:40%;vertical-align:middle;background-color:#FFFFF2;">
                                    <input type="time" name="de_startTime" id="de_startTime" class="input-common timeBtn" value="" autocomplete="off" style="width:30%;vertical-align:middle;background-color:#FFFFF2;">
                                  <?php }else{?>
                                    <input type="text" name="de_startDay" id="de_startDay" class="input-common dayBtn" value="" autocomplete="off" onchange="conference_room_del('update'); date_compare('de_');" style="width:40%;background-color:#FFFFF2;">
                                    <input type="button" name="" id="de_startBtn" class="dateBtn" onclick="openStartDate('de');" style="width:10%;margin-left:10px;" >
                                    <input type="text" name="de_startTime" id="de_startTime" class="input-common timeBtn" value="" autocomplete="off" style="width:30%;background-color:#FFFFF2;margin-left:10px;">
                                  <?php } ?>
                                 </td>
                               </tr>
                               <tr class="de_tech_img_div" style="display:none;">
                                 <td style="font-weight:bold;">사진</td>
                                 <td>
                                   <div style="margin-top:5px;">
                                     <input class="input-common" type="text" name="de_s_reason" id="de_start_reason" value="" style="width:88%;" placeholder="첨부할 사진이 없을 경우에 사유를 입력해주세요.">
                                   </div>
                                   <div style="margin-top:5px;margin-bottom:5px;">
                                     <div class="box-file-input s_file_input_box">
                                       <label>
                                           <input type="file" name="de_start_img" class="file-input" accept="image/*" id="de_start_img" onchange="timeImgChk('start');">
                                       </label>
                                       <span class="de_start_img file_span">파일을 선택해주세요
                                     </div>
                                     <div class="s_file_view_box">
                                       <input id="s_img_del" type="button" class="btn-common btn-file btn-file-left" value="삭제">
                                       <span class="s_file_img file_span" style="float:left;margin-left:10px;"></span>
                                       <input id="s_img_detail" type="button" class="btn-common btn-style1 btn-file btn-file-right" value="보기">
                                     </div>
                                 </td>
                               </tr>
                               <tr>
                                 <td style="font-weight:bold; ">종료일자</td>
                                 <td>
                                  <?php if($this->agent->is_mobile()){ ?>
                                    <input type="date" name="de_endDay" id="de_endDay" class="input-common dayBtn" value="" autocomplete="off" onchange="conference_room_del('update'); date_compare('de_');" style="width:40%;vertical-align:middle;background-color:#FFFFF2;">
                                    <input type="time" name="de_endTime" id="de_endTime" class="timeBtn" value="" autocomplete="off" style="width:30%;vertical-align:middle;background-color:#FFFFF2;">
                                  <?php }else{?>
                                    <input type="text" name="de_endDay" id="de_endDay" class="input-common dayBtn" value="" autocomplete="off" onchange="conference_room_del('update'); date_compare('de_');" style="width:40%;background-color:#FFFFF2;">
                                    <input type="button" name="" id="de_endBtn" class="dateBtn" value=" " onclick="openEndDate('de');" style="width:10%;margin-left:10px;">
                                    <input type="text" name="de_endTime" id="de_endTime" class="input-common timeBtn" value="" autocomplete="off" style="width:30%;background-color:#FFFFF2;margin-left:10px;">
                                  <?php } ?>
                                 </td>
                               </tr>
                               <tr class="de_tech_img_div" style="display:none;">
                                 <td style="font-weight:bold;">사진</td>
                                 <td>
                                   <div style="margin-top:5px;">
                                     <input class="input-common" type="text" name="de_e_reason" id="de_end_reason" value="" style="width:88%;" placeholder="첨부할 사진이 없을 경우에 사유를 입력해주세요.">
                                   </div>
                                   <div style="margin-top:5px;margin-bottom:5px;">
                                     <div class="box-file-input e_file_input_box">
                                       <label>
                                           <input type="file" name="de_end_img" class="file-input" accept="image/*" id="de_end_img" onchange="timeImgChk('end');">
                                       </label>
                                       <span class="de_end_img file_span">파일을 선택해주세요
                                     </div>
                                     <div class="e_file_view_box">
                                       <input id="e_img_del" type="button" class="btn-common btn-file btn-file-left" value="삭제">
                                       <span class="e_file_img file_span" style="float:left;margin-left:10px;"></span>
                                       <input id="e_img_detail" type="button" class="btn-common btn-style1 btn-file btn-file-right" value="보기">
                                     </div>
                                 </td>
                               </tr>
                             </form>
                               <!-- 반복일정 recurring -->
                               <tr>
                                 <td style="font-weight:bold; ">반복일정<input type="checkbox" name="de_recurring_check" id="de_recurring_check" value="" onchange="change_recurring_check('de_');"></td>
                                 <td>
                                   <input type="hidden" id="de_recurring_select_before_val" value="">
                                   <select class="select-common select-style1 de_recurring_div" name="de_recurring_select" id="de_recurring_select">
                                     <option value="" num = "1" id="de_recurring_day"></option>
                                     <!-- 요일값 -->
                                     <option value="" num = "2" id="de_recurring_week"></option>
                                     <option value="" num = "3" id="de_recurring_month_day"></option>
                                     <!-- BYSETPOS 사용 -->
                                     <option value="" num = "4" id="de_recurring_month"></option>
                                     <!-- 월과 일자값 -->
                                   </select>
                                   <input type="hidden" id="de_recurring_select_ex_before_val" value="">
                                   <select class="select-common select-style1 de_recurring_div" name="de_recurring_select_ex" id="de_recurring_select_ex" onchange="change_recurring_select_ex('de_');">
                                     <option value="de_recurring_endDay" num = "1" id="de_recurring_endDay_opt">종료일자</option>
                                     <option value="de_recurring_count" num = "2" id="de_recurring_count_opt">반복횟수</option>
                                   </select>
                                   <input type="hidden" id="de_recurring_input_before_val" value="">
                                   <input type="text" name="de_recurring_endDay" id="de_recurring_endDay" class="dayBtn input_ex input-common de_recurring_div" value="" autocomplete="off" onchange="conference_room_del('update'); date_compare('de_');" style="width:20%; display:none;">
                                   <input type="text" name="de_recurring_count" id="de_recurring_count" class="input_ex input-common de_recurring_div" value="" style="width:20%; display:none;" placeholder="숫자로 입력">
                                 </td>
                               </tr>
                               <!-- <tr class="de_recurring_div">
                                 <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                               </tr> -->
                               <tr class="de_general_div de_sch_title_div">
                                 <td style="font-weight:bold; ">제목</td>
                                 <td>
                                   <input class="input-common" type="text" name="de_title" id="de_title" value="" style="width:80%;">
                                 </td>
                               </tr>
                               <tr class="de_general_div de_sch_loc_div">
                                 <td style="font-weight:bold; ">장소</td>
                                 <td>
                                   <input class="input-common" type="text" name="de_place" id="de_place" value="" style="width:80%;">
                                 </td>
                               </tr>
                               <tr class="de_except_company_div">
                               <!-- <tr class="de_tech_div"> -->
                                 <td style="font-weight:bold; ">고객사</td>
                                 <td>
                                     <div class="dropdown de_tech_div" id="de_dropdown">
                                       <p onclick="searchFunction(this.id)" id="de_dropbtn" class="dropbtn">검색</p>
                                       <input id="de_customerName" name ="de_customerName" type="text" class="customerName" value="" style="border:none;width:200px;font-weight:bold;text-align:center;">
                                       <!-- <input id="de_customerName" name ="de_customerName" type="text" class="customerName" value="" style="border:none;width:200px;font-weight:bold;text-align:center;" onchange="customerNameChange(this.value);"> -->

                                       <input type="hidden" id="de_customer" name="de_customer" value="" style="border:none" readonly>
                                       <div id="de_myDropdown" class="dropdown-content">
                                         <input type="text" name="0" placeholder="고객사를 입력하세요" id="de_searchInput" class="searchInput" onkeyup="filterFunction(this)" autocomplete="off">
                                         <div id="de_dropdown_option" style="overflow:scroll; width:277px; height:300px;">
                                         </div>
                                       </div>
                                     </div>
                                     <div class="de_general_div">
                                       <input class="input-common" type="text" id="de_customerName2" name="de_customerName2" value="" style="width:80%;" >
                                     </div>

                                 </td>
                               </tr>
                               <tr class="de_sales_div" style="display:none;">
                                 <td style="font-weight:bold;">방문 업체</td>
                                 <td>
                                   <input class="input-common" type="text" id="de_visitCompany" name="de_visitCompany" value="" style="width:80%">
                                 </td>
                               </tr>
                               <tr class="de_tech_div">
                                 <td style="font-weight:bold; ">프로젝트</td>
                                 <td>
                                   <input class="input-common" type="text" id="de_project" name="de_project" value="" style="width:80%;" />
                                 </td>
                               </tr>
                               <tr class="de_except_company_div">
                               <!-- <tr class="de_except_company_div de_except_nondisclosure_div"> -->
                                 <!-- <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold; ">참석자</td>
                                 <td colspan="3" class="t_border" style="padding-left:10px">
                                   <input type="text" name="de_participant" id="de_participant" value="" placeholder="" size='45' autocomplete="off">
                                   <input type="image" src="<?php echo $misc; ?>/img/participant_add.jpg" id="de_addUserBtn" class="btn" style="width:25px; height:25px; vertical-align:middle;" onclick="addUser_Btn();return false;">
                                 </td> -->
                                 <td style="font-weight:bold; ">참석자</td>
                                 <td>
                                   <li>
                                     <div class="" style="padding:5px 0;">
                                       <input class="input-common" type="text" name="de_participant_input" id="de_participant_input" value="" placeholder="" onkeypress="keypress(event,this.value,'de_participant')" autocomplete="off" style="width:80%;">
                                       <input type="hidden" name="de_participant" id="de_participant" value="" placeholder="">
                                       <img src="<?php echo $misc; ?>/img/participant_add.svg" id="addUserBtn" class="btn" style="width:25px;margin-left:5px;vertical-align:middle;" onclick="addUser_Btn();return false;">
                                       <!-- <input type="image" src="<?php echo $misc; ?>/img/participant_add.jpg" id="addUserBtn" class="btn" style="width:25px; height:25px; vertical-align:middle;" onclick="addUser_Btn();return false;"> -->
                                     </div>
                                   </li>
                                   <li>
                                     <div id="de_participant_box" name="de_participant_box">

                                     </div>
                                   </li>
                                 </td>
                               </tr>
                               <tr class="de_general_div de_explanation_div none-tr" style="display:none;">
                                 <td></td>
                                 <td>
                                   <div class="" style="float:left; width:50%; text-align:left;">
                                     <span style="font-size:10px; font-weight:bold;">주간업무</span>
                                   </div>
                                   <div class="" style="display:inline-block; width:50%; text-align:right;">
                                     <span style="font-size:10px; font-weight:bold;">추가/삭제</span>
                                   </div>
                                 </td>
                               </tr>
                               <tr id="de_contents_tr_0">
                                 <td style="font-weight:bold; ">내용</td>
                                 <td>
                                   <input type="checkbox" class="add_weekly_report" id="de_add_weekly_report_0" name="de_add_weekly_report" value="" style="vertical-align:middle;width:10%;float:left" onclick="nondisclosure_weekly_report('de_nondisclosure');">
                                   <!-- textarea의 cols는 실질적으로 js에 있는 contents_split_type에서 41로 지정한 값이 반영된다. -->
                                   <textarea class="textarea-common" rows="2" name='de_contents' id="de_contents_0" placeholder="상세내용" style="resize:none; vertical-align:middle; margin:2px -1.8px;width:80%;float:left;margin-top:10px;margin-bottom:10px;" maxlength="300"></textarea>
                                   <input type="hidden" name="de_contents_num" id="de_contents_num_0" value="0">
                                   <!-- <img src="<?php echo $misc; ?>img/btn_add.jpg" id="contents_add" name="contents_add" onclick="contents_add_action('de_contents');return false;" style="cursor:pointer; vertical-align:middle;float:right;" /> -->
                                   <img src="<?php echo $misc; ?>img/btn_add.jpg" id="contents_add" name="contents_add" style="cursor:pointer; vertical-align:middle;float:right;" />
                                 </td>

                               <!-- 기술연구소 -->
                               <tr id="de_lab_contents_tr" class="de_lab_contents_tr" style="display:none;">
                                  <td style="font-weight:bold">개발구분</td>
                                  <td>
                                    <select class="select-common" id="de_dev_type" name="dev_type" style="float:left;margin-right:10%;">
                                      <option value="" selected disabled hidden>선택하세요</option>
                                      <option value="신규개발">신규개발</option>
                                      <option value="기능개선">기능개선</option>
                                      <option value="버그수정">버그수정</option>
                                    </select>
                                    <span style="float:left;font-weight:bold;width:60px;margin-top:3px;margin-right:5%;">페이지</span>
                                    <span style="float:left;">
                                      <input class="input-common" type="text" id="de_dev_page" name="dev_page" value="" style="width:100px;">
                                    </span>
                                  </td>
                               </tr>
                               <tr id="de_lab_contents_tr" class="de_lab_contents_tr" style="display:none;">
                                 <td style="font-weight:bold">요청자</td>
                                 <td>
                                   <input class="input-common" type="text" id="de_dev_requester" name="de_dev_requester" value="" style="width:80%;">
                                 </td>
                               </tr>
                               <tr id="de_lab_contents_tr" class="de_lab_contents_tr" style="display:none;">
                                 <td style="font-weight:bold">개발사항</td>
                                 <td>
                                   <textarea class="textarea-common" id="de_dev_develop" name="de_dev_develop" rows="5" cols="52" style="resize:none; vertical-align:middle;width:80%;float:left;margin-top:10px;margin-bottom:10px;"></textarea>
                                 </td>
                               </tr>
                               <tr id="de_lab_contents_tr" class="de_lab_contents_tr" style="display:none;">
                                  <td style="font-weight:bold;">완료여부</td>
                                  <td>
                                    <input type="checkbox" id="de_dev_complete" name="de_dev_complete" value="">
                                  </td>
                               </tr>
                               <!-- 기술연구소 -->

                               <tr class="de_report_div" style="display:none;">
                                 <!-- <td align="center" bgcolor="f8f8f9" style="font-weight:bold; ">주간보고</td>
                                 <td colspan="1" class="t_border" style="padding-left:10px;">
                                   <input type="checkbox" id="de_add_weekly_report" name="de_add_weekly_report" value="">
                                 </td> -->
                                 <!-- 내용분할 전에 주간보고여부가 작성된 일정들을 위한 예외1 -->
                                 <!-- <input type="hidden" id="de_old_weekly_report" name="de_old_weekly_report" value=""> -->
                                 <!-- 내용분할 전에 주간보고여부가 작성된 일정들을 위한 예외2 -->
                                 <td style="font-weight:bold; ">비공개</td>
                                 <td>
                                   <input type="checkbox" id="de_nondisclosure_sch" name="de_nondisclosure_sch" value="" onclick="nondisclosure_form('de_nondisclosure')">
                                 </td>
                               </tr>
                             </tbody>
                           </table>
                           <div id="schdule_contoller_btn2" style="display:none;" style="margin-top:30px;">
                             <input type="button" name="updateSubmit" id="updateSubmit" class="btn-common btn-color2" onclick="modify('schedule_modify')" style="float:right;margin-right:10px;" value="수정">
                           </div>
                           <div id="schdule_contoller_btn" style="margin-top:30px;">
                             <div style="float:right;width:100%;">
                               <input type="button" id="techReportInsert" name="techReportInsert" class="btn-common btn-color2 hidden_btn" style="width:150px;float:right;margin-right:10px;" onclick="modify('report')" value="기술지원보고서 작성">
                               <input type="button" id="techReportModify" name="techReportModify" class="btn-common btn-color1 hidden_btn" style="width:150px;float:right;margin-right:10px;" onclick="modify('modify')" value="기술지원보고서 수정">
                             </div>
                             <div style="float:right;width:100%;margin-top:10px;">
                               <input type="button" name="updateSubmit" id="updateSubmit" class="btn-common btn-color1" onclick="modify('schedule_modify')" style="float:right;margin-right:10px;" value="수정">
                               <button type="button" class="btn-common btn-color1" onClick="$('#updateSchedule').bPopup().close();" style="float:right;margin-right:10px;">취소</button>
                               <input type="button" name="delSubmit" id="delSubmit" class="btn-common btn-color1" onclick="modify('schedule_delete')" style="float:right;margin-right:10px;" value="삭제">
                             </div>
                             <!-- KI -->
                           </div>
                         </td>
                       </td>
                     </tr>
                   </table>
              <!-- </form> -->
            </article>
          </div>
    <!-- 디테일 디브 끝 -->
      </div>
<!-- 회의실 예약 시작 -->
<!-- <div id="conference_div" style="display:none; position: absolute; background-color: white; width: auto; height: auto;"> -->
<div id="conference_div" style="display:none; position: absolute; background-color: white; width: 1150px; height: auto;">
<!-- <div id="conference_div" style="display:none; position: absolute; background-color: white; width: 950px; height: 300px;"> -->
  <div style="background-color: #aaaab3;text-align:right;">
      <img id="addUserpopupCloseBtn" src="<?php echo $misc;?>img/btn_del2.jpg"  onclick="$('#conference_div').bPopup().close();" width=25 style="cursor:pointer;" />
      <!-- <span id="addUserpopupCloseBtn" class="btn" onclick="$('#conference_div').bPopup().close();" style="color:#e03b09;font-size:14px;">X</span> -->
  </div>
  <!-- <div id="select_date" style="width: 20%; height:90%; float:left; border: 1px solid #000; margin-bottom:20px;margin-top:20px;"> -->
  <div id="select_date" style="width: 18%; height:90%; float:left; border: 1px solid #000; margin:20px 0px 20px 20px;">
  <!-- <div>
    <input type="text" name="" value="" id="select_date"> -->
  </div>
  <!-- <div id="select_table" style="width: 78%; height:90%; float:right; border: none; margin-bottom:20px;margin-top:20px;"> -->
  <div id="select_table" style="width: 80%; height:90%; float:right; border:none; margin-top:20px;margin-bottom:20px;">
  <!-- <div id="select_table" style="width: 78%; height:90%; float:right; border: 1px solid #000;"> -->
    <input type="hidden" id="select_day" name="select_day" value="">
    <input type="hidden" id ="selected_room_name" name="selected_room_name" value="">
    <div>
      <table class="select_time" style="width:98%; margin-right:50px;">
      <!-- <table class="select_time"> -->
        <thead class="select_time_th">
        <tr>
          <th>회의실명</th>
          <th colspan="2">08</th>
          <th colspan="2">09</th>
          <th colspan="2">10</th>
          <th colspan="2">11</th>
          <th colspan="2">12</th>
          <th colspan="2">13</th>
          <th colspan="2">14</th>
          <th colspan="2">15</th>
          <th colspan="2">16</th>
          <th colspan="2">17</th>
          <th colspan="2">18</th>
          <th colspan="2">19</th>
          <th colspan="2">20</th>
          <th colspan="2">21</th>
        </tr>
        </thead>
        <tbody class="select_time_tb" id="selectable">
          <?php
            function plus_time($start){
              $last = strtotime('22:00');
              if($start < $last){
                $start_time = date("H:i", $start);
                $end = strtotime('+30 minutes', $start);
                $end_time = date("H:i", $end);
                $id_time = (int)str_replace(':','',$start_time);
                echo "<td class = 'td_item' style='cursor:pointer;' id='{$id_time}' onmouseover='tooltip(this);' onmouseout='tooltip_remove(this);'>{$start_time}{$end_time}<div class='tooltip-content'></div></td>";
                plus_time($end);
              }
            }
                   foreach ($rooms as $room) {

                     echo "<tr id='{$room->room_name}'>";
                     $start = strtotime('08:00');
                     echo "<td class='dragable' id='room_name_td' style='cursor:s-resize'>{$room->room_name}</td>";
                     plus_time($start);
                     echo "</tr>";

                   }
           ?>

        </tbody>
      </table>
    </div>
    <div>
      <p id="feedback" style="display:none;">
        <span>You&apos;ve selected:</span> <span id="select_room_result">none</span>
        <!-- <span id="select_room_name">/</span> -->
      </p>
      <button type="button" id="add_conference_btn" name="add_conference_btn" onclick="add_conference(this.name);" class="basicBtn">등록</button>
    </div>
  </div>
</div>
<!-- 회의실 예약 끝 -->

<!-- 차량 예약 시작 -->
<div id="car_reservation_div" style="display:none; position: absolute; background-color: white; width: 1150px; height: auto;">
<!-- <div id="car_reservation_div" style="display:none; position: absolute; background-color: white; width: auto; height: 300px;"> -->
  <div style="background-color: #aaaab3;text-align:right;">
    <img id="addUserpopupCloseBtn" src="<?php echo $misc;?>img/btn_del2.jpg" onclick="$('#car_reservation_div').bPopup().close();" width=25 style="cursor:pointer;"/>
      <!-- <span id="addUserpopupCloseBtn" class="btn" onclick="$('#car_reservation_div').bPopup().close();"style="margin:0% 0% 0% 96%; color:#e03b09">X</span> -->
  </div>
  <div id="select_car_date" style="width: 18%; height:90%; float:left; border: 1px solid #000; margin:20px 0px 20px 20px;">
  <!-- <div>
    <input type="text" name="" value="" id="select_date"> -->
  </div>
  <div id="select_car_table" style="width: 80%; height:90%; float:right; border: none; margin-bottom:20px;margin-top:20px;">
  <!-- <div id="select_car_table" style="width: 78%; height:90%; float:right; border: 1px solid #000;"> -->
    <input type="hidden" id="select_car_day" name="select_car_day" value="">
    <input type="hidden" id ="selected_car_name" name="selected_car_name" value="">
    <div>
      <table class="select_time" style="width:98%; margin-right:50px;">
        <thead class="select_time_th">
        <tr>
          <th>차종</th>
          <!-- <th>번호</th> -->
          <th colspan="2">08</th>
          <th colspan="2">09</th>
          <th colspan="2">10</th>
          <th colspan="2">11</th>
          <th colspan="2">12</th>
          <th colspan="2">13</th>
          <th colspan="2">14</th>
          <th colspan="2">15</th>
          <th colspan="2">16</th>
          <th colspan="2">17</th>
          <th colspan="2">18</th>
          <th colspan="2">19</th>
          <th colspan="2">20</th>
          <th colspan="2">21</th>
        </tr>
        </thead>
        <tbody class="select_time_tb" id="select_car_tbody">
          <?php

           foreach ($cars as $car) {

             echo "<tr id='{$car->type}{$car->number}'>";
             $start = strtotime('08:00');
             echo "<td name='car_info' id='car_name_td'>{$car->type}<br>{$car->number}</td>";
            //  echo "<td name='car_info' id='car_num_td'>{$car->number}</td>";
             plus_time($start);
             echo "</tr>";

           }
           ?>

        </tbody>
      </table>
    </div>
    <div style="bottom: 0;">
      <p id="feedback" style="display:none;">
        <span>You&apos;ve selected:</span> <span id="select_car_result">none</span>
      </p>
      <button type ="button" id ="add_car_btn" name = "add_car_btn" onclick="add_car(this.name);" class="basicBtn">등록</button>
    </div>
  </div>
</div>
<!-- 차량 예약 끝 -->

<!-- 팝업뜰때 배경 -->
<div id="mask2"></div>
<!--schedule detail Popup Start -->
<!-- <form class="" name="" action="index.html" method="post"> -->
<div id="show_day_select_popup" name="show_day_select_popup" class="layerpop" style="width: 550px; height: 470px;">
  <article class="layerpop_area">
    <div align="center" class="modal_title">일정 선택</div>
    <a href="javascript:popupClose('show_day_select_popup');" class="layerpop_close" id="layerbox_close"><img src="/misc/img/btn_del2.jpg"/></a>
    <table width="100%" border="0" callspacing="0" cellspacing="0">
      <tr>
        <td colspan="10" height="2" bgcolor="#173162"></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>
          <td align="center"><table border="0" cellspacing="0" cellpadding="0" style="">
            <colgroup>
              <col width="3%" />
              <col width="15%" />
              <col width="20%" />
              <col width="15%" />
            </colgroup>
            <tr>
              <td colspan="4" height="2" bgcolor="#797c88"></td>
            </tr>
            <tr bgcolor="f8f8f9" class="t_top">
              <td height="40" align="center"></td>
              <td align="center" class="t_border">일차</td>
              <td align="center" class="t_border">작업일</td>
              <td align="center" class="t_border">보고서 작성</td>
            </tr>
            <tr>
              <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
            </tr>
            <tbody id="select_day_body"></tbody>
            <tr>
              <td colspan="4" height="2" bgcolor="#797c88"></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
          </table>
          <div id="select_day_btn"></div>
        </td>
      </td>
    </tr>
  </table>
</article>
</div>
<!--schedule insert Popup End -->


<!-- 일정 중복방지 팝업창 시작 -->

<div id="duple_sch_popup" name="duple_sch_popup" class="layerpop" style="display:none; width:700px; height:auto;">
  <article class="layerpop_area" align="center">
  <div align="center" class="modal_title">유사 일정 목록</div>
  <table width="100%" border="0" callspacing="0" cellspacing="0">
  	<tr>
  	   <td colspan="10" height="2" bgcolor="#173162" align="center"></td>
  	</tr>
    <tr >
      <td style="padding:10px 0;">
        <!-- 유사한 일정이 다음과 같이 존재합니다. 일정 등록을 계속 진행하시겠습니까?
        <br> -->
        ※유사한 일정이 다음과 같이 존재합니다. 중복 일정이 있는지 확인 후 등록해주세요.※
      </td>
    </tr>
  </table>

  <table border="0" cellspacing="0" cellpadding="0" style="width:90%" align="center" id="duple_sch_list">
  </table>
  <table>
    <button type="button" name="duple_sch_continue" id="duple_sch_continue" class="basicBtn" onclick="duple_sch_chk='true'; $('#scheduleAdd').click(); $('#duple_sch_popup').bPopup().close();">등록</button>
    &nbsp;
    <button type="button" name="duple_sch_stop" id="duple_sch_stop" class="basicBtn" onclick="$('#duple_sch_popup').bPopup().close(); $('#addpopup').bPopup().close();" >취소</button>
  </table>
  </article>
</div>
<!-- 일정 중복방지 팝업창 끝 -->

<!-- 반복일정 수정안내 팝업창 시작 -->
<div id="recurring_sch_popup" name="recurring_sch_popup" class="layerpop" style="display:none; width:250px; height:auto;">
  <article class="layerpop_area" align="center">
    <div align="center" class="modal_title">
      반복 일정 설정
    </div>
  <table border="0" cellspacing="0" cellpadding="0" style="width:80%; margin: 10%; border:solid 2px lightgray;" align="center" id="recurring_sch_list">
    <input type="hidden" id="recurring_modify_choose" name="" value="">
    <input type="hidden" id="de_recurring_seq" name="" value="">
    <input type="hidden" id="recurring_mode" name="" value="">
    <tr id="btn_only_this_sch" onMouseOver="this.style.backgroundColor='#EAEAEA';this.style.cursor='pointer'" onMouseOut="this.style.backgroundColor='#fff'" onclick="" class="recurring_modify">
    <!-- <tr id="btn_only_this_sch" onMouseOver="this.style.backgroundColor='#EAEAEA';this.style.cursor='pointer'" onMouseOut="this.style.backgroundColor='#fff'" onclick="$('#recurring_modify_choose').val('only_this_sch');$('#recurring_sch_popup').bPopup().close();modify($('#recurring_mode').val())" class="recurring_modify"> -->
      <td style="padding:5px 0; border-bottom:solid 1px lightgray;">이 일정</td>
    </tr>
    <tr id="btn_forward_sch" onMouseOver="this.style.backgroundColor='#EAEAEA';this.style.cursor='pointer'" onMouseOut="this.style.backgroundColor='#fff'" onclick="">
    <!-- <tr id="btn_forward_sch" onMouseOver="this.style.backgroundColor='#EAEAEA';this.style.cursor='pointer'" onMouseOut="this.style.backgroundColor='#fff'" onclick="$('#recurring_modify_choose').val('forward_sch');$('#recurring_sch_popup').bPopup().close();modify($('#recurring_mode').val())"> -->
      <td style="padding:5px 0; border-bottom:solid 1px lightgray;">이 일정 및 향후 일정</td>
    </tr>
    <tr id="btn_all_sch" onMouseOver="this.style.backgroundColor='#EAEAEA';this.style.cursor='pointer'" onMouseOut="this.style.backgroundColor='#fff'" onclick="" class="recurring_modify2">
    <!-- <tr id="btn_all_sch" onMouseOver="this.style.backgroundColor='#EAEAEA';this.style.cursor='pointer'" onMouseOut="this.style.backgroundColor='#fff'" onclick="$('#recurring_modify_choose').val('all_sch');$('#recurring_sch_popup').bPopup().close();modify($('#recurring_mode').val())" class="recurring_modify2"> -->
      <td style="padding:5px 0;">모든 일정</td>
    </tr>
  </table>
  </article>
</div>
<!-- 반복일정 수정안내 팝업창 끝 -->

<!-- 사진 상세 -->
<div id='img_detail' style="width:400px; height: auto;" class="layerpop" >
  <article class="layerpop_area">
    <div align="left" class="modal_title">사진 상세
    </div>
    <a onclick="$('#img_detail').bPopup().close();" class="layerpop_close" id="layerbox_close"><img src="/misc/img/btn_del2.jpg"/></a>
    <table border="0" cellspacing="0" cellpadding="0" width="95%" class="modal-input-tbl">
      <colgroup>
        <col width="25%" />
        <col width="75%" />
      </colgroup>
      <tr>
        <td style="font-weight:bold;">제조사</td>
        <td id="imgMake"></td>
      </tr>
      <tr>
        <td style="font-weight:bold;">모델명</td>
        <td id="imgModel"></td>
      </tr>
      <tr>
        <td class="non-border" style="font-weight:bold;">찍은 날짜</td>
        <td class="non-border" id="imgDateTime"></td>
      </tr>
      <tr>
        <td></td>
        <td><div id="thumbnail" class="thumbnail" style="margin: 0 auto;margin-bottom:10px;"></div></td>
      </tr>
      <tr>
        <td style="font-weight:bold;vertical-align:top;padding-top:30px;">위치</td>
        <td>
          <div id="map" style="width:250px;height:250px;"></div>
        </td>
      </tr>
    </table>
  </article>
</div>


      <!-- //여기까지 -->
    </td>
  </tr>
  <tr>
    <td align="center">
      <div style="width:90%;text-align:right;margin-top:15px;<?php if($session_id!='kkj'){echo 'display:none;';} ?>">

          <img src="<?php echo $misc?>/img/setting.png" style="width:20px;height:20px;cursor:pointer;" onclick="customPop();">

      </div>
    </td>
  </tr>
  <!--하단-->
</table>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
<script>
// KI2 20210125
// function modify(mode){
//   $('#detail_contain').hide();
//   $('#sd_contain').show();
//     calendarRefresh();
// if(mode = 'schedule_delete'){
//   }
// }


function modify(mode){
  // alert(mode);

  var seq = $("#de_seq").val();
  var work_type = $('#de_work_type').val();
  // var customer_manager = $("#de_customer_manager").val();
  var start_day = $("#de_startDay").val();
  var start_time = $("#de_startTime").val();
  var end_day = $("#de_endDay").val();
  var end_time = $("#de_endTime").val();
  var work_name = $("#de_workname").val();
  var customerName = $("#de_customerName").val();
  var customerName2 = $("#de_customerName2").val();
  var visitCompany = $("#de_visitCompany").val();
  var forcasting_seq = $("#de_forcasting_seq").val();
  var maintain_seq = $("#de_maintain_seq").val();
  var project = $("#de_project").val();
  var tech_report = $("#de_tech_report").val();
  var support_method = $("#de_supportMethod").val();
  var participant = $("#de_participant").val();
  // var contents = $("#de_contents").val();
  var title = $("#de_title").val();
  var place = $("#de_place").val();
  var sday = $('#de_startDay').val();
  var eday = $('#de_endDay').val();
  var room_name = $('#de_room_name').val();
  var car_name = $('#de_car_name').val();
  if(room_name == '' && car_name != ''){
    var name = car_name;
    var type = 'car_name';
  }else{
    var name = room_name;
    var type = "room_name";
  }
  // if($('#de_add_weekly_report').is(":checked") == true){
  //   var weekly_report = "Y";
  // }else{
  //   var weekly_report = "N";
  // }
  // if($('#de_old_weekly_report').val() != null){
  //
  // }
  if($('#de_nondisclosure_sch').is(":checked") == true){
    var nondisclosure = "Y";
  }else{
    var nondisclosure = "N";
  }

  if( $('#de_outside_work').is(":checked") ) {
    var outside_work = 'Y';
  } else {
    var outside_work = 'N';
  }

  //반복 일정 recurring
  var recurring_modify_choose = $('#recurring_modify_choose').val();
  var recurring_seq = $('#de_recurring_seq').val();
  var recurring_count = $('#de_recurring_count').val();
  //반복일정 수정되는지 확인하기 위해 수정 전 val값을 받아놓은 것을 가져옴
  var recurring_select_before_val = $('#de_recurring_select_before_val').val();
  var recurring_select_ex_before_val = $('#de_recurring_select_ex_before_val').val();
  var recurring_input_before_val = $('#de_recurring_input_before_val').val();

  //내용분할1
  //일정 내용 분할 값과 주간보고 여부를 배열로 만들어서 보내기
  var contents= [];
  if(work_type != 'lab'){

    var length = $('textarea[name=de_contents]').length;

    if(length > 1){
      for(var j = 1; j < length; j++){
        //contents_0을 제외하고 나머지 contents들이 빈값인 상태일때는 해당 칸을 삭제하고 입력한다.
        if (($('#de_contents_'+j).val()== "") || ($('#de_contents_'+j).val()== "undefined")) {
          alert(j+1 + "번째 내용이 비었습니다.");
          return false;
        }
      }
    }

    for(var i = 0; i < length; i++){ //내용이 분할 안된 것들도 0번 한번은 돌게 되어있기에 내용이 수정된다.
      var contents_val = $('#de_contents_'+i).val();
      var contents_num_val = $('#de_contents_num_'+i).val();
      if($('#de_add_weekly_report_'+i).is(':checked') == true){
        var weekly_report_val = 'Y';
      }else{
        var weekly_report_val = 'N';
      }
      if(work_type == 'tech'){
        var weekly_report_val = 'Y';
      }
      contents.push({
        'contents':contents_val,
        'contents_num':contents_num_val,
        'weekly_report':weekly_report_val
      })
    }

  }else{
    var dev_type = $("#de_dev_type").val();
    var dev_page = $("#de_dev_page").val();
    var dev_requester = $("#de_dev_requester").val();
    var dev_develop = $("#de_dev_develop").val();
    if ($("#de_dev_complete").is(':checked')==true){
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
  }
  //내용분할2


  if(mode == 'schedule_delete'){
    // alert(recurring_modify_choose + '-' +recurring_seq);
    //recurring
    if(recurring_modify_choose == '' && recurring_seq != ''){
      // alert('recurring_modify_choose: '+recurring_modify_choose+' recurring_seq:'+recurring_seq);
      recurring_setting_change('3', null);
      // $('#recurring_sch_popup').bPopup();
      // $('#recurring_mode').val('schedule_delete');
      return;
    }else if(recurring_modify_choose == '' && recurring_seq == ''){
      recurring_modify_choose = null;
      recurring_seq = null;
    }

    var result = confirm("정말 삭제 하시겠습니까?");
    if(result){
      var seq = $('#de_seq').val();
      $.ajax({
        type: "POST",
        dataType : "json",
        url: "<?php echo site_url();?>/biz/schedule/delete",
        data: {
          seq: seq,
          recurring_modify_choose: recurring_modify_choose,
          recurring_seq: recurring_seq
        },
        success: function(result){
          // console.log(result);
          if (result == "report_written"){
            alert('보고서가 작성된 일정은 삭제할 수 없습니다.\n작성된 기술지원보고서를 먼저 삭제해주세요.');
            calendar.refetchEvents();
          }

          if(result == "true"){
            calendarRefresh();
            // $('#detail_contain').hide();
            // $('#sd_contain').show();
            $('#updateSchedule').bPopup().close();
          }
          $('#de_recurring_seq').val('');
          $('#recurring_mode').val('');
          $('#recurring_modify_choose').val('');
        }
      });
    }else{
      $('#recurring_mode').val('');
      $('#recurring_modify_choose').val('');
    }
  }

  if(mode == 'schedule_modify'){
    var start_reason = $('#de_start_reason').val();
    var end_reason = $('#de_end_reason').val();
    //KI1 20210125 입력시 빈칸이 있으면 넘어가지 않도록 조건 제한
    if( $('#de_work_type').val() == 'tech' ){

      if($('#de_startDay').val() == ''){
        alert('시작날짜를 입력해주세요.');
        $('#de_startDay').focus();
        return false;
      }
      if($('#de_endDay').val() == ''){
        alert('종료날짜를 입력해주세요.');
        $('#de_endDay').focus();
        return false;
      }
      if($('#de_startTime').val() == ''){
        alert('시작시간을 입력해주세요.');
        $('#de_startTime').focus();
        return false;
      }
      if($('#de_endTime').val() == ''){
        alert('종료시간을 입력해주세요.');
        $('#de_endTime').focus();
        return false;
      }
      if($('#de_workname').val() == ''){
        alert('작업구분을 입력해주세요.');
        $('#de_workname').focus();
        return false;
      }
      if($('#de_supportMethod').val() == ''){
        alert('지원방법을 입력해주세요.');
        $('#de_supportMethod').focus();
        return false;
      }
      if($('#de_customerName').val() == ''){
        alert('고객사를 선택해주세요.');
        $('#de_customerName').focus();
        return false;
      }
      if($('#de_project').val() == ''){
        alert('프로젝트란이 비어있습니다. 고객사를 다시 선택해주세요.');
        $('#de_customerName').val('');
        $('#de_customerName').focus();
        // $('#de_project').focus();
        return false;
      }
      if(($('#de_participant').val() == '') && ($('#de_work_type').val() != 'company')){
        alert('참석자를 선택해주세요.');
        $('#de_participant').focus();
        return false;
      }
    } else if ( $('#de_work_type').val() == 'lab' ) {
      if ($('#de_dev_type').val() == '') {
        alert('개발구분을 선택해주세요.');
        $('#de_work_type').focus();
        return false;
      }
      if ($('#de_dev_page').val() == '') {
        alert('개발 페이지를 입력해주세요.');
        $('#de_work_page').focus();
        return false;
      }
      if ($('#de_dev_develop').val() == '') {
        alert('개발사항을 입력해주세요.');
        $('#de_dev_develop').focus();
        return false;
      }
    } else{
      if($('#de_title').val() == ''){
        alert('제목을 입력해주세요.');
        $('#de_title').focus();
        return false;
      }
      if($('#de_endDay').val() == ''){
        alert('종료날짜를 입력해주세요.');
        $('#de_endDay').focus();
        return false;
      }
      if($('#de_endTime').val() == ''){
        alert('종료시간을 입력해주세요.');
        $('#de_endTime').focus();
        return false;
      }
      // if($('#de_place').val() == ''){
      //   alert('장소를 입력해주세요.');
      //   $('#de_place').focus();
      //   return false;
      // }
      if(($('#de_participant').val() == '') && ($('#de_work_type').val() != 'company')){
        alert('참석자를 선택해주세요.');
        $('#de_participant').focus();
        return false;
      }
    }
    //KI2 20210125
    var start_time_2 = moment(start_time,'HH:mm').format('HH:mm');
    var end_time_2 = moment(end_time,'HH:mm').format('HH:mm');
    if (start_time == '' && end_time != ''){
      alert("시작시간을 먼저 작성해 주세요.");
      $('#de_endTime').val('');
      return false;
    }
    if((start_day == end_day) && (start_time_2 > end_time_2)) {
        alert("종료시간이 시작시간보다 이전입니다.");
        $('#de_endTime').val('');
        return false;
    }

// alert('forcasting_seq:'+forcasting_seq+' maintain_seq:'+maintain_seq)

    // var act = "<?php echo site_url();?>/biz/schedule/modify"
    // $("#de_hiddenSeq").attr('action', act).submit();
    // var seq = $('#de_seq').val();


    //반복일정 recurring
    var recurring_setting = '';
    var recurring_date = [];
    var recurring_val = '';
    if($('#de_recurring_check').is(':checked') == true){

      if(recurring_modify_choose == '' && recurring_seq != ''){
        recurring_setting_change('1', null);
        return;

      // }else if(recurring_modify_choose == '' && recurring_seq == ''){ //반복일정 아닌 일정을 반복일정으로 체크 후 저장
        // sch_insert('de_');
        //해당 일정도 수정하고 반복일정 나머지 새로 insert한다.
      }else{ //모든 일정

        var cycle_eq_val = $('#de_recurring_select option').index($('#de_recurring_select option:selected')); //selected된 option의 index값 구하기
        var cycle_num_val = $('#de_recurring_select option:eq('+cycle_eq_val+')').attr('num'); //option에 num요소 값 가져오기
        var cycle_ex_eq_val = $('#de_recurring_select_ex option').index($('#de_recurring_select_ex option:selected')); //selected된 option의 index값 구하기
        var cycle_ex_num_val = $('#de_recurring_select_ex option:eq('+cycle_ex_eq_val+')').attr('num'); //option에 num요소 값 가져오기
        recurring_setting = 'cycle:' + cycle_num_val + ';;;cycle_ex:' + cycle_ex_num_val;

        if(recurring_modify_choose == '' && recurring_seq == ''){
          recurring_seq = seq;
          recurring_val= $('#de_recurring_select').val();
        }else{

          if(recurring_modify_choose == 'all_sch'){ //모든 일정
            //이 일정의 re_seq와 일치하는 모든 일정 update
            $.ajax({
              type: "POST",
              url:"<?php echo site_url();?>/biz/schedule/find_recurring_original_sch",
              dataType:"json",
              data:{
                recurring_seq: recurring_seq,
                seq: null
              },
              cache:false,
              async:false,
              success: function(data) {
                if(cycle_num_val == 1){
                  everyday(data.start_day);
                  recurring_val = $('#de_recurring_day').val();
                }else if(cycle_num_val == 2){
                  dayOfTheWeek_in_week(data.start_day);
                  recurring_val = $('#de_recurring_week').val();
                }else if(cycle_num_val == 3){
                  day_in_month(data.start_day);
                  recurring_val = $('#de_recurring_month_day').val();
                }else if(cycle_num_val == 4){
                  dayOfTheWeek_num_in_month(data.start_day);
                  recurring_val = $('#de_recurring_month').val();
                }
                // end_day = data.end_day;
              }
            });

          }else if(recurring_modify_choose == 'forward_sch'){ // 이 일정 및 향후 일정
            //   //이 일정의 re_seq와 일치하는 일정들을 seq로 정렬해서 이 일정과 그 이후의 모든 일정 update
            // recurring_val= $('#de_recurring_select').val();
            $.ajax({
              type: "POST",
              url:"<?php echo site_url();?>/biz/schedule/find_recurring_original_sch",
              dataType:"json",
              data:{
                recurring_seq: recurring_seq,
                seq: seq
              },
              cache:false,
              async:false,
              success: function(data) {
                if(cycle_num_val == 1){
                  everyday(data.start_day);
                  recurring_val = $('#de_recurring_day').val();
                }else if(cycle_num_val == 2){
                  dayOfTheWeek_in_week(data.start_day);
                  recurring_val = $('#de_recurring_week').val();
                }else if(cycle_num_val == 3){
                  day_in_month(data.start_day);
                  recurring_val = $('#de_recurring_month_day').val();
                }else if(cycle_num_val == 4){
                  dayOfTheWeek_num_in_month(data.start_day);
                  recurring_val = $('#de_recurring_month').val();
                }
                // end_day = data.end_day;
              }
            });

          }else if(recurring_modify_choose == 'only_this_sch'){ //이 일정만
            //이 일정의 seq만 가져가서 해당 일정만 update
            recurring_val= $('#de_recurring_select').val();
            //반복세팅 수정 안된 상태
            // sch_insert('de_');
            // return;
          }
        }
        var recurring_val_arr = recurring_val.split(',');

        var recurring_ex_opt_id = $('#de_recurring_select_ex').val();
        var recurring_ex_val = $('#'+recurring_ex_opt_id).val();

        if(recurring_ex_opt_id == 'de_recurring_endDay'){ //반복일자만큼 자르기
            for(i = 0; i < recurring_val_arr.length; i++){
                if(recurring_val_arr[i] > recurring_ex_val){
                  recurring_val_arr.splice(i);
                }
            }
            recurring_date = recurring_val_arr;
            recurring_setting += ';;;endday:' + recurring_ex_val;

        }else if(recurring_ex_opt_id == 'de_recurring_count'){  //반복횟수만큼 자르기
          // if(recurring_val_arr.length < recurring_ex_val){
          //   console.log(recurring_val_arr.length+'-'+recurring_ex_val);
          //   alert('반복 일자가 해당 년을 벗어났습니다.');
          //   return;
          // }
          for(j = 0; j < recurring_ex_val; j++){
            recurring_date.push(recurring_val_arr[j]);
          }
          recurring_setting += ';;;count:' + recurring_ex_val;
        };
      }

    }else{
      recurring_setting = null;
      recurring_date = null;
      recurring_seq = null;
      recurring_modify_choose = null;
      recurring_count = null;
    }

    $.ajax({
      type: "POST",
      url:"<?php echo site_url();?>/biz/schedule/duplicate_check",
      // url:"<?php //echo site_url();?>/biz/schedule/duplicate_checkroom",
      dataType:"json",
      data:{
        schedule_seq: seq,
        select_day: start_day,
        start:start_time,
        end:end_time,
        name: name,
        type: type
      },
      cache:false,
      async:false,
      success: function(data) {
        // console.log(data);
        if(data == 'dupl'){
          alert('중복되는 차량 혹은 회의실 일정이 있습니다.');
          stopPropagation();
        }
      }
    });

    $.ajax({
      type: "POST",
      url:"<?php echo site_url();?>/biz/schedule/sch_report_approval",
      dataType:"json",
      data:{
        schedule_seq: seq
      },
      cache:false,
      async:false,
      success: function(data) {
        // alert(data['approval_yn']);
        if(data === 'Y'){
          alert('주간업무보고 결제가 완료된 일정은 수정할 수 없습니다.');
          stopPropagation();
        }
      }
    });

    if ($("#de_start_img").val() != '' || $("#de_end_img").val() != '') {

      var formData = new FormData(document.getElementById("img_file_form"));

      var fileCount = 0;
      var fileType = [];
      $(".file-input").each(function() {
        if ($(this).val()!='') {
          formData.append('file_'+fileCount, $(this)[0].files[0]);
          var id = $(this).attr('id');
          type = id.split('_')[1];
          fileType.push(type.charAt(0));
          fileCount++;
        }
      })

      formData.append('fileType', fileType);
      formData.append('seq', $('#de_seq').val());
      formData.append('fileCount', fileCount);

      $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: '<?php echo site_url(); ?>/biz/schedule/tech_img_upload',
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        success: function(data) {
          console.log("success:",data);
        },
        error: function(e) {
          console.log("ERROR:",e);
        }
      })
    }


    $.ajax({
      type: "GET",
      dataType : "json",
      url: "<?php echo site_url();?>/biz/schedule/modify",
      data: {
        seq: seq, //#
        work_type : work_type,
        // customer_manager: customer_manager,
        startDay: start_day,
        startTime: start_time,
        endDay: end_day,
        endTime: end_time,
        workname: work_name,
        customerName: customerName,
        customerName2: customerName2,
        visitCompany: visitCompany,
        forcasting_seq: forcasting_seq,
        maintain_seq: maintain_seq,
        project: project,
        supportMethod: support_method,
        tech_report: tech_report, //#
        participant: participant,
        contents: contents,
        title: title,
        place: place,
        room_name: room_name,
        car_name: car_name,
        // weekly_report:weekly_report,
        nondisclosure:nondisclosure,
        recurring_seq: recurring_seq, //#
        recurring_date: recurring_date,
        recurring_setting: recurring_setting,
        recurring_modify_choose: recurring_modify_choose, //#
        recurring_count: recurring_count, //#
        start_reason: start_reason,
        end_reason: end_reason,
        outside_work:outside_work
      },
      cache:false,
      async:false,
      success: function(result) {
        if (result == "report_written"){
          alert('보고서가 작성된 일정은 수정할 수 없습니다.');
          calendar.refetchEvents();
        }
        if(result == "true"){
          calendarRefresh();
          alert('수정되었습니다.');
          $('#updateSchedule').bPopup().close();
          $('#de_recurring_seq').val(''); //이 값이 존재하냐 마냐로 반복 일정 등록할 때 recurring_seq를 생성할지 말지 결정하기에 미리 비워두는 것
        }else{
          alert('오류가 발생했습니다.');
          $('#updateSchedule').bPopup().close();
          $('#de_recurring_seq').val(''); //이 값이 존재하냐 마냐로 반복 일정 등록할 때 recurring_seq를 생성할지 말지 결정하기에 미리 비워두는 것
        }
      }
    });

    $('#de_recurring_seq').val('');
    $('#recurring_mode').val('');
    $('#recurring_modify_choose').val('');
  }

  if(mode == 'report'){ //기술지원보고서 작성
    //KI1 20210125 입력시 빈칸이 있으면 넘어가지 않도록 조건제한
    if($('#de_startDay').val() == ''){
      alert('시작날짜를 입력해주세요.');
      $('#startDay').focus();
      return false;
    }
    if($('#de_endDay').val() == ''){
      alert('종료날짜를 입력해주세요.');
      $('#de_endDay').focus();
      return false;
    }
    if($('#de_workname').val() == ''){
      alert('작업구분을 입력해주세요.');
      $('#de_workname').focus();
      return false;
    }
    if($('#de_supportMethod').val() == ''){
      alert('지원방법을 입력해주세요.');
      $('#de_supportMethod').focus();
      return false;
    }
    if($('#de_customerName').val() == ''){
      alert('고객사를 선택해주세요.');
      $('#de_customerName').focus();
      return false;
    }
    if(($('#de_participant').val() == '') && ($('#de_work_type').val() != 'company')){
      alert('참석자를 선택해주세요.');
      $('#de_participant').focus();
      return false;
    }

    var schedule_seq = $('#de_seq').val();
    move(schedule_seq, sday, eday);

  }

//@@@
  if(mode == 'modify'){ //기술지원보고서 수정
    var schedule_seq = $('#de_seq').val();
    $.ajax({
      type : "POST",
      url : "<?php echo site_url(); ?>/biz/schedule/tech_seq_find",
      dataType : "json",
      data : {
        schedule_seq : schedule_seq,
        start_day: start_day,
        customer: customerName,
        type : "Y"
      },
      success : function(data){
        var seq = data[0].seq;

        location.href = "<?php echo site_url(); ?>/tech/tech_board/tech_doc_view?mode=view&seq="+seq+"&type=Y";
      }
    })

  }
}

function select_day(type){
	var seq = $("#de_seq").val();
	var income_day = '';
	var end_work_day = '';
	var report_seq = '';
	$("input:checkbox[name=income_day]:checked").each(function(){
		income_day = $(this).val();
		var tr = $(this).closest('tr');
		report_seq = tr.find('input[id=modify_report_seq]').val();
	})

	if(type=='input') {
		if (income_day == ''){
			alert('작성할 보고서의 작업일을 선택하세요.');
		} else {
 //수정 (기지보 일괄작성)
      var income = new Array();
      var income_day_arr = new Array();
      var i=0;
      $("input:checkbox[name=income_day]").each(function(index){
          if($(this).is(":checked")){
              income[i]=index;
              income_day_arr[i] = $(this).val();
              i++;
          }
      });
      if(income.length != 1){
        var temp = income[0];
        for(var k=1; k<income.length; k++){
            if(temp+k != income[k]){
              alert("연속된 일정만 보고서를 한번에 작성 가능합니다.");
              $("input:checkbox[name=income_day]").prop('checked',false);
              // $("input:checkbox[name=income_day]").each(function(){
              //   $(this).checked = false;
              // })
              return false;
            }
        }
      }
      if (income.length>1){
        var income_day = income_day_arr[0];
        var end_work_day = income_day_arr[income_day_arr.length-1];
      }

      var schedule_seq = seq;
      move(schedule_seq, income_day, end_work_day);

      // var act = "<?php echo site_url();?>/tech/tech_board/tech_doc_input?schedule_seq="+seq+"&income_day="+income_day+"&end_work_day="+end_work_day;
      // $("#de_hiddenSeq").attr('action', act);
      // $("#de_hiddenSeq").attr('method', 'POST');
      // $("#de_hiddenSeq").submit();
		}
	} else if (type=='modify'){
		if (income_day == ''){
			alert('작성할 보고서의 작업일을 선택하세요.');
		} else {
			location.href = "<?php echo site_url(); ?>/tech/tech_board/tech_doc_view?mode=view&seq="+report_seq+"&type=Y";
		}
	}
}



function move(schedule_seq, income_day, end_work_day){

  $.ajax({
    url : "<?php echo site_url(); ?>/biz/schedule/find_seq_in_tech_doc_basic_temporary_save",
    type : "POST",
    dataType : "json",
    data : {
      seq : schedule_seq,
      income_time : income_day
    },
    cache : false,
    async : false,
    success : function(data){
      console.log(data);
      if(data != null){
        var con = confirm("임시저장된 기술지원보고서가 존재합니다.\n\n저장 내용을 불러오려면 확인 버튼을 눌러주세요.\n\n저장 내용을 삭제하고 새로 작성하려면 취소 버튼을 눌러주세요.");
        if(con){
          location.href = "<?php echo site_url(); ?>/tech/tech_board/tech_doc_view?mode=view&seq="+data+"&type=N";

          // location.href='<?php echo site_url();?>/tech/tech_board/tech_doc_input?schedule_seq='+schedule_seq+"&income_day="+income_day+"&end_work_day="+end_work_day;

          // $.ajax({
          //   type : "POST",
          //   url : "<?php echo site_url(); ?>/biz/schedule/tech_seq_find",
          //   dataType : "json",
          //   data : {
          //     schedule_seq : schedule_seq,
          //     start_day : sday,
          //     customer : customer_name,
          //     type : "N"
          //   },
          //   success : function(data){
          //     var seq = data[0].seq;
          //
          //     location.href = "<?php echo site_url(); ?>/tech/tech_board/tech_doc_view?mode=view&seq="+seq+"&type=N";
          //   }
          // });

        }else{
          $.ajax({
            url:"<?php echo site_url(); ?>/biz/schedule/tech_doc_basic_temporary_save_delete",
            type : "POST",
            dataType : "json",
            data : {
              schedule_seq : schedule_seq
            },
            success: function(data){
              if(data == 'true'){
                alert('임시저장된 보고서가 삭제되었습니다.');
                // move();
                // location.href='<?php echo site_url();?>/tech/tech_board/tech_doc_input?schedule_seq='+schedule_seq+"&income_day="+income_day+"&end_work_day="+end_work_day;
                location.href= "<?php echo site_url();?>/tech/tech_board/tech_doc_input?schedule_seq="+schedule_seq+"&income_day="+income_day+"&end_work_day="+end_work_day;
                // $("#de_hiddenSeq").attr('action', act);
                // $("#de_hiddenSeq").attr('method', 'POST');
                // $("#de_hiddenSeq").submit();
              }
            }
          });
        }
      }else{ //data == null
        // move();
        // location.href='<?php echo site_url();?>/tech/tech_board/tech_doc_input?schedule_seq='+schedule_seq+"&income_day="+income_day+"&end_work_day="+end_work_day;
        location.href= "<?php echo site_url();?>/tech/tech_board/tech_doc_input?schedule_seq="+schedule_seq+"&income_day="+income_day+"&end_work_day="+end_work_day;
        // $("#de_hiddenSeq").attr('action', act);
        // $("#de_hiddenSeq").attr('method', 'POST');
        // $("#de_hiddenSeq").submit();
      }
    }
  });
}


function getDateRange(startDate, endDate, listDate){
	var dateMove = new Date(startDate);
	var strDate = startDate;

	if (startDate == endDate) {
		var strDate = dateMove.toISOString().slice(0,10);
		listDate.push(strDate);
	} else {
		while (strDate<endDate){
			var strDate = dateMove.toISOString().slice(0,10);
			listDate.push(strDate);
			dateMove.setDate(dateMove.getDate() + 1);
		}
	}
	return listDate;
}


function checkOnlyOne(el){
	// var checkboxes = document.getElementsByName('income_day');
	$("input:checkbox[name=income_day]:checked").each(function(){
		this.checked = false;
	})
	el.checked = true;
}

$(".select_time_tb tr td[id='room_name_td']").click(function(){
  $('#selected_room_name').val('');
});

//내용분할1
//일정 내용 영역 추가하기
function contents_add_action(mode){
  var length = $("textarea[name=" + mode + "]").length;
  var before_id = mode + "_tr_" + (length-1);
  var after_id = mode + "_tr_" + length;
  var split_mode = mode.split('_');
  if(split_mode.length > 1){
    var mode2 = 'de_';
  }else{
    var mode2 = '';
  }
  // $('#'+before_id).after("<tr id="+ after_id +"><td align='center' bgcolor='f8f8f9' style='font-weight:bold;'></td><td class='t_border' colspan='3' bgcolor='f8f8f9' align='left'><input type='checkbox' class='add_weekly_report' id='" + mode2 + "add_weekly_report_" + length + "' name='" + mode2 + "add_weekly_report' value='' style='vertical-align:middle;width:10%;float:left'><textarea rows='2' name='" + mode + "' id='" + mode + "_" + length + "' placeholder='상세내용' style='resize:none; vertical-align:middle; margin:2px -1.8px;width:70%;float:left'></textarea><input type='hidden' name='" + mode + "_num' id='" + mode + "_num_" + length + "' value='" + length + "'><img src='<?php echo $misc; ?>img/btn_del0.jpg' style='cursor:pointer; vertical-align:middle;float:right' id='" + mode2 + "contents_remove_" + length + "' name='" + mode2 + "contents_remove' onclick='contents_del(" + length + ',' + '"' + mode + '"' + ");return false;'/></td></tr>");
  $('#'+before_id).after("<tr id="+ after_id +"><td style='font-weight:bold;'></td><td  colspan='3'><input type='checkbox' class='add_weekly_report' id='" + mode2 + "add_weekly_report_" + length + "' name='" + mode2 + "add_weekly_report' value='' style='vertical-align:middle;width:10%;float:left' onClick='nondisclosure_weekly_report("+'"'+mode2+"nondisclosure"+'"'+")'><textarea class='textarea-common' rows='2' name='" + mode + "' id='" + mode + "_" + length + "' placeholder='상세내용' style='resize:none; vertical-align:middle; margin:2px -1.8px;width:80%;float:left' maxlength='300'></textarea><input type='hidden' name='" + mode + "_num' id='" + mode + "_num_" + length + "' value='" + length + "'><img src='<?php echo $misc; ?>img/btn_del0.jpg' style='cursor:pointer; vertical-align:middle;float:right' id='" + mode2 + "contents_remove_" + length + "' name='" + mode2 + "contents_remove' onclick='contents_del(" + length + ',' + '"' + mode + '"' + ");return false;'/></td></tr>");
}
//내용분할2

//반복일정에서 내용만 수정되면 수정 옵션 3개가, 반복세팅이 수정되면 수정 옵션 2개가 보이도록 설정
function recurring_setting_change(mode, key_val){
  if(mode == '1' || mode == '3'){
    //반복일정 수정되는지 확인하기 위해 수정 전 val값을 받아놓은 것을 가져옴
    var recurring_select_before_val = $('#de_recurring_select_before_val').val();
    var recurring_select_ex_before_val = $('#de_recurring_select_ex_before_val').val();
    var recurring_input_before_val = $('#de_recurring_input_before_val').val();


    var recurring_select_after_eq_val = $('#de_recurring_select option').index($('#de_recurring_select option:selected')); //selected된 option의 index값 구하기
    var recurring_select_after_val = $('#de_recurring_select option:eq('+recurring_select_after_eq_val+')').attr('num'); //option에 num요소 값 가져오기
    var recurring_select_ex_after_eq_val = $('#de_recurring_select option').index($('#de_recurring_select option:selected')); //selected된 option의 index값 구하기
    var recurring_select_ex_after_val = $('#de_recurring_select_ex option:eq('+recurring_select_ex_after_eq_val+')').attr('num'); //option에 num요소 값 가져오기

    var recurring_select_ex_opt_id = $('#de_recurring_select_ex').val();
    var recurring_input_after_val = $('#'+recurring_select_ex_opt_id).val();

    if(mode == '1'){
      if(recurring_select_before_val != recurring_select_after_val || recurring_select_ex_before_val != recurring_select_ex_after_val || recurring_input_before_val != recurring_input_after_val){
        $('.recurring_modify').css('display','none');
        $('.recurring_modify2').css('display','');
      }else{
        $('.recurring_modify').css('display','');
        $('.recurring_modify2').css('display','');
      }

      $('#recurring_sch_popup').bPopup();
      $('#recurring_mode').val('schedule_modify');

    }else if(mode == '3'){
      $('.recurring_modify').css('display','');
      $('.recurring_modify2').css('display','');

      $('#recurring_sch_popup').bPopup();
      $('#recurring_mode').val('schedule_delete');
    }

    $('#btn_only_this_sch').attr("onClick", "$('#recurring_modify_choose').val('only_this_sch');$('#recurring_sch_popup').bPopup().close();modify($('#recurring_mode').val());");
    $('#btn_forward_sch').attr("onClick", "$('#recurring_modify_choose').val('forward_sch');$('#recurring_sch_popup').bPopup().close();modify($('#recurring_mode').val());");
    $('#btn_all_sch').attr("onClick", "$('#recurring_modify_choose').val('all_sch');$('#recurring_sch_popup').bPopup().close();modify($('#recurring_mode').val());");

  }else if(mode == '2'){ //drop update

    var val_arr = [key_val.seq, key_val.start_day, key_val.start_time, key_val.end_day, key_val.end_time, key_val.participant];
    // var str = json.stringify(key_val);
    $('.recurring_modify').css('display','');
    $('.recurring_modify2').css('display','none');
    $('#recurring_sch_popup').bPopup();
    $('#recurring_mode').val('schedule_modify');

    $('#btn_only_this_sch').attr("onClick", "$('#recurring_modify_choose').val('only_this_sch');$('#recurring_sch_popup').bPopup().close();recurring_drop('"+val_arr+"','only_this_sch');");
    $('#btn_forward_sch').attr("onClick", "$('#recurring_modify_choose').val('forward_sch');$('#recurring_sch_popup').bPopup().close();recurring_drop('"+val_arr+"','forward_sch');");
    // $('#btn_only_this_sch').attr("onClick", "$('#recurring_modify_choose').val('only_this_sch');$('#recurring_sch_popup').bPopup().close();recurring_drop("+arr+",'only_this_sch');");
    // $('#btn_forward_sch').attr("onClick", "$('#recurring_modify_choose').val('forward_sch');$('#recurring_sch_popup').bPopup().close();recurring_drop("+arr+",'forward_sch');");

    // $('#btn_only_this_sch').attr("onClick", "$('#recurring_modify_choose').val('only_this_sch');$('#recurring_sch_popup').bPopup().close();recurring_drop();");
    // $('#btn_forward_sch').attr("onClick", "$('#recurring_modify_choose').val('forward_sch');$('#recurring_sch_popup').bPopup().close();recurring_drop();");
    // $('#btn_all_sch').attr("onClick", "$('#recurring_modify_choose').val('all_sch');$('#recurring_sch_popup').bPopup().close();recurring_drop();");
  }
}

function recurring_drop(val_text, mode){

  var val_arr = val_text.split(',');

  var seq = val_arr[0];
  var start_day = val_arr[1];
  var start_time = val_arr[2];
  var end_day = val_arr[3];
  var end_time = val_arr[4];
  var participant = val_arr[5];

  var sday = new Date(start_day);
  var eday = new Date(end_day);
  var date_diff = Math.ceil((eday.getTime() - sday.getTime()) / (1000 * 3600 * 24));
  // var date_diff = Math.ceil((eday.getTime() - sday.getTime()) / (1000 * 3600 * 24)) + 1;
  // alert(date_diff);

  var date_diff2 = '';

  if(mode == 'forward_sch'){
    $.ajax({
      type: "POST",
      url: "/index.php/biz/schedule/recurring_drop_seq",
      dataType: "json",
      data: {
        seq: seq
      },
      cache: false,
      async: false, //비동기방식
      success: function (data) {
        // console.log(data.length);
        for(i = 0; i < data.length; i++){
          // console.log(end_day+'/'+data[0]['end_day']);
          // console.log(start_day+'/'+data[0]['start_day']);
          // var test = moment(data[i]['start_day']).add(date_diff, 'days').format('YYYY-MM-DD');
          if(start_day != data[0]['start_day']){

            if(i == 0){
              var sday2 = new Date(start_day);
              var eday2 = new Date(data[i]['start_day']);
              date_diff2 = Math.ceil((eday2.getTime() - sday2.getTime()) / (1000 * 3600 * 24));
            }
            if(start_day > data[0]['start_day']){
              var start_day_val = moment(data[i]['start_day']).subtract(date_diff2, 'days').format('YYYY-MM-DD');
              // alert(start_day_val);
            }else if(start_day < data[0]['start_day']){
              var start_day_val = moment(data[i]['start_day']).subtract(date_diff2, 'days').format('YYYY-MM-DD');
              // var start_day_val = moment(data[i]['start_day']).add(date_diff2, 'days').format('YYYY-MM-DD');
              // alert(start_day_val);
            }else{
              var start_day_val = data[i]['start_day'];
            }
          }else{
            var start_day_val = data[i]['start_day'];
          }
          if(date_diff != 0){
            var end_day_val = moment(start_day_val).add(date_diff, 'days').format('YYYY-MM-DD');
          }else{
            var end_day_val = start_day_val;
          }
          $.ajax({
            type: 'POST',
            url: "/index.php/biz/schedule/drop_update",
            data: {
              seq: data[i]['seq'],
              start_day: start_day_val,
              start_time:start_time,
              end_day: end_day_val,
              end_time: end_time,
              participant: participant
            },
            cache: false,
            async: false, //비동기방식
            success: function (data) {
              // console.log(data);
              if (data == "report_written") {
                alert('보고서가 작성된 일정은 수정할 수 없습니다.');
                calendarRefresh();
              }
              // if (data == 'OK') {
              //   calendarRefresh();
              // }
            }
          });
        }
        // calendarRefresh();
      }
    });
  }else if(mode == 'only_this_sch'){

    $.ajax({
      type: 'POST',
      url: "/index.php/biz/schedule/drop_update",
      data: {
        seq: seq,
        start_day: start_day,
        start_time: start_time,
        end_day: end_day,
        end_time: end_time,
        participant: participant
      },
      cache: false,
      async: false, //비동기방식
      success: function (data) {
        // console.log(data);
        if (data == "report_written") {
          alert('보고서가 작성된 일정은 수정할 수 없습니다.');
          calendar.refetchEvents();
        }
      }
    });
  }
  $('#recurring_modify_choose').val('');
  calendarRefresh();
}


<?php
  if($this->agent->is_mobile()){?>
    $("#selectParticipantBtn").remove();
    $("#searchReset").remove();
    $("#excelDownload").remove();
    window.addEventListener('DOMContentLoaded', function(){
    $(".fc-today-button").insertBefore($(".fc-next-button"));
    $(".fc-toolbar-chunk").first().insertAfter($(".fc-view-harness"));
  });
<?php } ?>

window.onload = function() {
  $("#scheduleSidebar").css('height', $("#calendar").height()-2);
}
$(window).resize(function() {
  setTimeout(function() {
    $("#scheduleSidebar").css('height', $("#calendar").height()-2);
  },500);
})

</script>
</body>
<style media="screen">
.fc-daygrid-more-link {
  float: right !important;
}
</style>
</html>
