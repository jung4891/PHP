<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <style>
     p,span, a, a:hover, a:visited, a:active, label, input, h1,h2,h3,h4,h5,h6,input,textarea:not(#summernote),select{
        font-family: "Noto Sans KR" !important;
     }

     #formLayoutDiv:not(#summernote){
        font-size:13px !important;
     }

     .basic_td{
        padding:0px 10px 0px 10px;
        border:1px solid;
        border-color:#d7d7d7;
     }

     .basic_table{
        border-collapse:collapse;
        border:1px solid;
        border-color:#d7d7d7;
     }

     .basic_table td{
        padding:0px 10px 0px 10px;
        border:1px solid;
        border-color:#d7d7d7;
     }

     .basicBtn2{
        cursor:pointer;
        height:31px;
        background-color:#fff;
        vertical-align:top;
        font-weight:bold;
        border : .5px solid;
        margin-right: 5px;
     }

     .btn-common{
       margin-right: 5px;
     }

     .file_upload{
        outline: 2px dashed #92b0b3 ;
        outline-offset:-10px;
        text-align: center;
        transition: all .15s ease-in-out;
        width: 300px;
        height: 300px;
        background-color: gray;
     }

     /* 모달 css */
     .searchModal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 10; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        z-index: 1002;
     }
        /* Modal Content/Box */
     .search-modal-content {
        background-color: #fefefe;
        margin: 15% auto; /* 15% from the top and centered */
        padding: 20px;
        border: 1px solid #888;
        width: 70%; /* Could be more or less, depending on screen size */
        z-index: 1002;
     }
     ul{
        list-style:none;
        padding-left:0px;
     }

     li{
        list-style:none;
        padding-left:0px;
     }

     #formLayoutDiv input:not(input[type='radio']){
        border: none !important;
        background: transparent !important;
     }

     #formLayoutDiv select{
        border:none;
        border-radius:0;
        -webkit-appearance: none;
        appearance: none;
        background: transparent !important;
     }
     #formLayoutDiv textarea{
        /* color: transparent;
        text-shadow: 0 0 0 black; */
        border: none !important;
        background: transparent !important;
     }
     #formLayoutDiv select {
        pointer-events: none;
     }
     #formLayoutDiv input:not(input[type='radio']) {
        border: none !important;
        background: transparent !important;
     }

     #formLayoutDiv input[type=date] {
        pointer-events: none;
     }

      #formLayoutDiv ::-webkit-calendar-picker-indicator{
        display:none;
     }
     .select2-hidden-accessible,.select2-selection__choice__remove,.select2-search,.select2-container--below,.select2-selection__rendered{
        display:none;
     }
     .select2-selection__rendered{
        margin-top :0px !important;
     }
     .note-editable[contenteditable="false"] {
        background: transparent !important;
     }
     /* input[type='radio']:checked {
       appearance: none;
       width: 0.74rem;
       height: 0.74rem;
       border-radius:100%;
       margin-right: 0.20rem;
       margin-top:0.5px;
     }
     input[type='radio']:checked {
        background-color: black !important;
      } */
      #formLayoutDiv input[type='radio']:checked {
        appearance:none;
      }
      .stamp {
      	position: static;
      	background-size:contain;
      	/* background-position: right bottom; */
      	background-repeat:no-repeat;
      	padding-top:10px;
      	padding-bottom:10px;
      	padding-right:50px;
      	padding-left:10px;
      }
  </style>
  <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
  <body>

    <div class="result">
      <table id="excel_table">
        <tr>
          <th>PK</th>
          <th>시작일</th>
          <th>시작시간</th>
          <th>종료일</th>
          <th>종료시간</th>
          <th>구분</th>
          <th>일정타입</th>
          <th>고객사</th>
          <th>방문업체(영업)</th>
          <th>지원방법</th>
          <th>참석자</th>
          <th>참석자 시퀀스</th>
          <th>포캐스팅 시퀀스</th>
          <th>유지보수 시퀀스</th>
          <th>프로젝트명</th>
          <th>내용</th>
          <th>작성자 아이디</th>
          <th>작성자 이름</th>
          <th>수정자 아이디</th>
          <th>수정자 이름</th>
          <th>소속부서</th>
          <th>소속 상위부서</th>
          <th>기술지원보고서 작성</th>
          <th>주간보고 작성 여부</th>
          <th>일정 제목</th>
          <th>일정 장소</th>
          <th>작성일</th>
          <th>수정일</th>
          <th>회의실 사용</th>
          <th>차량 사용</th>
          <th>공개/비공개</th>
          <th>일정 시작 사진</th>
          <th>일정 시작 사진2</th>
          <th>일정 종료 사진</th>
          <th>일정 종료 사진2</th>
          <th>미첨부 사유</th>
          <th>미첨부 사유2</th>
          <th>직출 여부</th>
        </tr>
        <tbody id="tbody">
<?php
foreach($schedule_list as $s) {
  $participant = $s['participant'];
  $pa = explode(',', $participant);
  for($i = 0; $i < count($pa); $i++) {
    ?>
    <tr>
      <td><?php echo $s['seq']; ?></td>
      <td><?php echo $s['start_day']; ?></td>
      <td><?php echo $s['start_time']; ?></td>
      <td><?php echo $s['end_day']; ?></td>
      <td><?php echo $s['end_time']; ?></td>
      <td><?php echo $s['work_name']; ?></td>
      <td><?php echo $s['work_type']; ?></td>
      <td><?php echo $s['customer']; ?></td>
      <td><?php echo $s['visit_company']; ?></td>
      <td><?php echo $s['support_method']; ?></td>
      <td><?php echo $pa[$i]; ?></td>
      <td><?php echo $s['participant_seq']; ?></td>
      <td><?php echo $s['forcasting_seq']; ?></td>
      <td><?php echo $s['maintain_seq']; ?></td>
      <td><?php echo $s['project']; ?></td>
      <td><?php echo $s['contents']; ?></td>
      <td><?php echo $s['user_id']; ?></td>
      <td><?php echo $s['user_name']; ?></td>
      <td><?php echo $s['modifier_id']; ?></td>
      <td><?php echo $s['modifier_name']; ?></td>
      <td><?php echo $s['group']; ?></td>
      <td><?php echo $s['p_group']; ?></td>
      <td><?php echo $s['tech_report']; ?></td>
      <td><?php echo $s['weekly_report']; ?></td>
      <td><?php echo $s['title']; ?></td>
      <td><?php echo $s['place']; ?></td>
      <td><?php echo $s['insert_date']; ?></td>
      <td><?php echo $s['modify_date']; ?></td>
      <td><?php echo $s['room_name']; ?></td>
      <td><?php echo $s['car_name']; ?></td>
      <td><?php echo $s['nondisclosure']; ?></td>
      <td><?php echo $s['s_file_changename']; ?></td>
      <td><?php echo $s['s_file_realname']; ?></td>
      <td><?php echo $s['e_file_changename']; ?></td>
      <td><?php echo $s['e_file_realname']; ?></td>
      <td><?php echo $s['start_reason']; ?></td>
      <td><?php echo $s['end_reason']; ?></td>
      <td><?php echo $s['outside_work']; ?></td>
    </tr>
    <?php
  }
}
?>
        </tbody>
      </table>
    </div>
  </body>

  <script type="text/javascript">
$(function() {
  var tab_text = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
  tab_text = tab_text + '<head><meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">';
  tab_text = tab_text + '<xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>'
  tab_text = tab_text + '<x:Name>Test Sheet</x:Name>';
  tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:Panes></x:WorksheetOptions></x:ExcelWorksheet>';
  tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>';
  tab_text = tab_text + "<table border='1px'>";
  var exportTable = $('#excel_table').clone();
  exportTable.find('input').each(function (index, elem) {
    $(elem).remove();
  });
  tab_text = tab_text + exportTable.html();
  tab_text = tab_text + '</table></body></html>';
  var data_type = 'data:application/vnd.ms-excel';
  var ua = window.navigator.userAgent;
  var msie = ua.indexOf("MSIE ");
  var fileName = '일정_데이터_추출.xls';
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
})

  </script>
</html>
