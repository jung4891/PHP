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
    <?php

foreach($approval_list as $al) {
  echo '<div class="target" style="display:none;">';
  echo $al['contents_html'];
  echo '</div>';
}
// echo'<div class="target">';
// echo $approval_list[0]['contents_html'];
// echo'</div>';

    ?>

    <div class="result">
      <table id="excel_table">
        <tr>
          <th>No</th>
          <th>출장자</th>
          <th>출장일</th>
          <th>출장지</th>
          <th>출장처</th>
        </tr>
        <tbody id="tbody">

        </tbody>
      </table>
    </div>
  </body>

  <script type="text/javascript">
  $(function() {
    var i = 1;
    $('.target').each(function() {
      var target = $(this);
      var v1 = target.find('input[name=tr1_td1]').val();
      var v2 = target.find('.tr2_td1').val();
      var v3 = target.find('.tr3_td1').val();
      var v4 = target.find('.tr4_td1').val();

      var contents = '';

      contents += "<tr>";
      contents += "<td>" + i + '</td>';
      contents += "<td>" + v1 + '</td>';
      contents += "<td>" + v2 + '</td>';
      contents += "<td>" + v3 + '</td>';
      contents += "<td>" + v4 + '</td>';
      contents += "</tr>";

      $('#tbody').append(contents);

      i++;
      // console.log('출장자 : ' + v1 + ' 출장일 : ' + v2 + ' 출장지 : ' + v3 + ' 출장처 : ' + v4);
    })

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
    var fileName = '출장품의서.xls';
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
