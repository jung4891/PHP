<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<style type="text/css">
/* Dropdown Button */
.dropbtn {
  font-size: 13px;
  border: none;
  cursor: pointer;
  border-radius: 5px;
  background-color: #eee;
  margin: 0px 0px 0px 0px;
  width: 50px;
  display: inline-block;
  text-align: center;
  border: 4px solid #eee;
}

/* Dropdown button on hover & focus */
.dropbtn:hover,
.dropbtn:focus {
  /* background-color: #3e8e41; */
}

/* The container <div> - needed to position the dropdown content */
.dropdown {
  position: relative;
  display: inline-block;
}

/* Dropdown Content (Hidden by Default) */
.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f6f6f6;
  min-width: 230px;
  border: 1px solid #ddd;
  z-index: 1;
}

/* Links inside the dropdown */
.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

/* Change color of dropdown links on hover */
.dropdown-content a:hover {
  background-color: #f1f1f1
}

.work_text_table textarea {
  font-family: 'Nanum Gothic', '나눔고딕', Tahoma, 'Georgia', '맑은 고딕', sans-serif;
  line-height: 150%;
  font-size: 12px;
  color: #333;
  border: none;
  border-right: 0px;
  border-top: 0px;
  border-left: 0px;
  border-bottom: 0px;
  width: 80%;
  height: 20px;
  overflow-y: hidden;
  resize: none;
}

.switch {
  position: relative;
  display: inline-block;
  width: 35px;
  height: 17px;
  vertical-align: middle;
  float: right;
  margin-right: 30px;
}

.onoff{
margin:0px;
display:inline-block;
font-size:9px;
font-weight:bold;
float:right;
}

/* Hide default HTML checkbox */
.switch input {display:none;}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 13px;
  width: 13px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(13px);
  -ms-transform: translateX(13px);
  transform: translateX(13px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 17px;
}

.slider.round:before {
  border-radius: 50%;
}

.field td {
  height: 0px !important;
  border: none;
}

.border-n {
  border: none !important;
}

.select-common,
.input-common {
  width:calc(100% - 10px);
  box-sizing: border-box;
}

/* 첨부파일 */
	.box-file-input label{
	display:inline-block;
	background:#565656;
	color:#fff;
	padding:0px 15px;
	line-height:30px;
	cursor:pointer;
	border-radius:3px;
  font-size:14px;
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

<!-- 시간 24시간 형식으로 가져오는거 -->
<link rel="stylesheet" href="<?php echo $misc; ?>css/w2ui.css" type="text/css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript" src="http://w2ui.com/src/w2ui-1.4.min.js"></script>
<script language="javascript">
  //장비 정보 가져오는 함수
  var err_mode = 1; //작업명이 장애지원 인경우
  var k = 26; //지원내역부분이 추가될 Index
  var row_min = 38; //지원내역이 1개 이상 있을 row 조건

  var table = null;
  var rowCount = null;
  var row = null;
  var row_count = null;
  var childPage='';

  $(function() {
    $("#main_add").click(function() {
      k++;
      $("#row_max_index").val(Number(Number($("#row_max_index").val()) + Number(1)));
      var id = "main_insert_field_" + $("#row_max_index").val();
      $('#manager_input_field').before("<tr id=" + id + "><td height='40' align='center' style='font-weight:bold;' class='row-color1 border-l' >담당자명</td><td style='padding-left:10px;'><input type='text' name='customer_manager[]' id='customer_manager' class='input-common customer_manager' style='width:100%;'/><input type='hidden' name='maintain_end' id='maintain_end' class='input-common'/></td><td height='40' align='center' style='font-weight:bold;' class='row-color1'>이메일</td><td style='padding-left:10px;' class='border-r'><input type='text' name='manager_mail[]' id='manager_mail' class='input-common manager_mail' style='width:calc(100% - 25px);margin-right:2px;'><img src='<?php echo $misc; ?>img/btn_minus_white.svg' style='cursor:pointer;width:23px;vertical-align:middle;' onclick='javascript:main_list_del(" + $("#row_max_index").val() + ");'/></td><td class='border-n' width='3%' style='padding-left:10px;'><input type='hidden' name='del_ck'></td><td class='border-n' align='center;'></td></tr>");
    });
  });

  function main_list_del(idx) {
    //	$("#main_insert_field_"+idx+" td input").eq(3).val("N");
    $("#main_insert_field_" + idx).remove();
    k--;
  }

  function check_add(btn,tableNum) {
    var normalCheck = [];
    for(i=0; i<$('#work_text_table'+tableNum).find($("[name*='produce"+tableNum+"']")).length; i++){
      normalCheck[i]=$('#work_text_table'+tableNum).find($("[name*='produce"+tableNum+"']")).eq(i).attr('name').replace("produce"+tableNum+"_","");
    }
    var normalCheck_idx = Number(Math.max.apply(null, normalCheck))+1;

    var tr =$(btn).parent().parent();
    var trClass = tr.attr('class');
    var trNum = trClass.substring(5);
    var nextTr = Number(trNum)+1;
    // if($('#work_text_table'+tableNum).find($(".check"+nextTr)).length != 0){
      $('#work_text_table'+tableNum).find($("."+trClass)).last().after('<tr class="'+trClass+'"><td class="tdSolid" colspan="2"><textarea name="work_text'+trNum+'[]" onkeyup="xSize(this);" style="width:80%;"></textarea><img src="<?php echo $misc;?>img/dashboard/dash_plus.svg" style="cursor:pointer;" class="tdDivisionBtn" onclick="tdDivision(this,'+trNum+');"/></td><td class="tdSolid"> \
      <div style="margin:0 auto; text-align: -webkit-center;font-weight:normal;">\
      <input type="hidden" name="work_text'+trNum+'[]" value="normal">\
      <input type="radio" name="produce'+tableNum+'_'+normalCheck_idx+'" value="normal" onclick="normalCheck(this);" checked="checked">정상\
      <input type="radio" name="produce'+tableNum+'_'+normalCheck_idx+'" value="abnormal" onclick="normalCheck(this);">비정상\
      </div></td>\
      <td class="tdSolid"><textarea name="work_text'+trNum+'[]" onkeyup="xSize(this);"></textarea><img src="<?php echo $misc; ?>img/btn_minus_white.svg" style="cursor:pointer;width:23px;" onclick ="check_del(this)" /></td>\
      <td width="0%" class="border-n adddelbtn"><input type="hidden" name="del_ck"></td> \
      <td align="center;" class ="border-n adddelbtn"></td></tr>');
    // }else{
    //   $('#work_text_table'+tableNum).find($(".check0")).before('<tr class="'+trClass+'"><td class="tdSolid" colspan="2"><textarea name="work_text'+trNum+'[]" onkeyup="xSize(this);" style="width:80%;"></textarea><img src="<?php echo $misc;?>img/dashboard/dash_plus.svg" style="cursor:pointer;" class="tdDivisionBtn" onclick="tdDivision(this,'+trNum+');"/></td><td class="tdSolid"> \
    //   <div style="margin:0 auto; text-align: -webkit-center;font-weight:normal;">\
    //   <input type="hidden" name="work_text'+trNum+'[]" value="normal">\
    //   <input type="radio" name="produce'+tableNum+'_'+normalCheck_idx+'" value="normal" onclick="normalCheck(this);" checked="checked">정상\
    //   <input type="radio" name="produce'+tableNum+'_'+normalCheck_idx+'" value="abnormal" onclick="normalCheck(this);">비정상\
    //   </div></td>\
    //   <td class="tdSolid"><textarea name="work_text'+trNum+'[]" onkeyup="xSize(this);"></textarea></td>\
    //   <td width="3%" class="t_border adddelbtn"><input type="hidden" name="del_ck"></td> \
    //   <td align="center;" class ="adddelbtn"><img src="<?php echo $misc; ?>img/btn_minus_white.svg" style="cursor:pointer;" onclick ="check_del(this)" /></td></tr>');
    // }

    var rowspan;
    if(tr.children(":first").attr("rowSpan")==undefined){
      rowspan = 1;
    }else{
      rowspan = Number(tr.children(":first").attr("rowSpan"));
    }
    var rowspanChange =tr.children(":first").attr("rowspan",rowspan+1)
  }

  function check_del(btn) {
      var tr =$(btn).parent().parent();
      var trClass = tr.attr('class')
      var rowspan = Number(tr.parent().children('.'+trClass).eq(0).children(":first").attr("rowSpan"));
      var rowspanChange = (tr.parent().children('.'+trClass).eq(0)).children(":first").attr("rowSpan",rowspan-1)
      tr.remove();
  }

  function merge_email() {
    var length = document.getElementsByName("customer_manager").length;
    var tmp_manager = "";
    var tmp_mail = "";
    for (i=0; i < length; i++) {
      if ((document.getElementsByName("customer_manager")[i].value== "") || (document.getElementsByName("customer_manager")[i].value== "undefined")) {
        alert(i + "번째는 비었습니다.");
      } else {
        tmp_manager += document.getElementsByName("customer_manager")[i].value.replace(/;/g,"");
        tmp_manager += ";";
        tmp_mail += document.getElementsByName("manager_mail")[i].value.replace(/;/g,"");
        tmp_mail += ";";
      }
    }
    document.getElementsByName("customer_manager")[length-1].value = tmp_manager;
    document.getElementsByName("manager_mail")[length-1].value = tmp_mail;
  }

  //장애지원 선택시 장애 탭 추가
  function change() {
    var work_name = document.getElementById("work_name").value;
    if (work_name == "장애지원") {
      $("#err_row1").show();
      $("#err_row2").show();
      $("#err_row3").show();
      $("#err_row4").show();
      $(".err_row").show();
    } else if (work_name != "장애지원") {
      if($("#work_name option:selected").val()=="정기점검2"){
        $("#nonPeriodic").hide();
        $("#deleteRowBtn").hide();
        $("#addRowBtn").hide();
        $("#periodic").show();
      }else{
        $("#periodic").hide();
        $("#nonPeriodic").show();
        $("#deleteRowBtn").show();
        $("#addRowBtn").show();
      }
      $("#err_row1").hide();
      $("#err_row2").hide();
      $("#err_row3").hide();
      $("#err_row4").hide();
      $(".err_row").hide();
    } else {
      return
    }
  }

  //제품명 선택 하는 함수
  function test(name,add) {
    if($("#customer").val() == ""){
      alert("고객사를 선택해주세요");
      $("#dropbtn").click();
    }else{
      var settings = 'height=500,width=1000,left=0,top=0';
      var mode = "maintain";
      if($("#work_name").val() == "납품설치" || $("#work_name").val() == "미팅" || $("#work_name").val() == "데모(BMT)지원" ){
        var mode = "forcasting";
      //포캐스팅+유지보수
      }else{
        if($("#maintain_seq").val() == ''){
          var mode = "forcasting";
        }
      }
      if("<?php echo $this->cooperation_yn; ?>" == "Y") {
        var mode = "forcasting";
      }
      if(!add){
        childPage= window.open('/index.php/tech/tech_board/search_device?name=' + name +'&mode='+mode,'_blank');
      }else{
        childPage= window.open('/index.php/tech/tech_board/search_device?name=' + name +'&mode='+mode+'&type='+add,'_blank');
      }
    }
  }

  //담당 SE 가져오는 함수
  function test2() {
    var settings = 'height=500,width=1000,left=0,top=0';
    window.open('/index.php/tech/tech_board/search_se', '_blank');
    window.opener.parent.focus();
  }

  // 고객사 담당자 가져오는 함수
  function test3(name,mode) {
    var settings = 'height=500,width=1000,left=0,top=0';
    var popup = window.open('/index.php/tech/tech_board/search_manager?name=' + name+'&mode='+mode, '_blank');
    window.focus();
  }

  /// 제출전 확인할것들
  var doubleSubmitFlag = false;
  var chkForm = function(type) {
    var rv = true;
    if(doubleSubmitFlag){
        return false;
    } else {
    doubleSubmitFlag = true;
    var mform = document.cform;

    if(type == 'N'){ //임시저장
      $('#type').val('N');

      if(mform.customerName.value == ''){
        mform.customerName.focus();
      // if($('#customerName').val() == ''){
      //   $("#customerName").focus();
        alert("고객사를 입력해주세요.");
        doubleSubmitFlag = false;
        return rv = false;
      }

    }else{ //기존 등록
      $('#type').val('Y');

      if((trim(mform.customerName.value) == "SKB(유통망)" || trim(mform.customerName.value) == "SKB(과금망)") && $(".produce").length == 1){
        if($("#serial_value").val()==""){
          $("#serial_value").focus();
          alert("serial 번호를 직접 입력해주세요.");
          doubleSubmitFlag = false;
          return rv = false;
        }
      }

      if(mform.customerName.value == ''){
        mform.customerName.focus();
      // if($('#customerName').val() == ''){
      //   $("#customerName").focus();
        alert("고객사를 입력해주세요.");
        doubleSubmitFlag = false;
        return rv = false;
      }

      if($("#work_name option:selected").val() != "교육참석" && $("#work_name option:selected").val() != "미팅"){
        if (mform.produce.value == "") {
          mform.produce.focus();
          alert("장비/시스템을 입력해주세요.");
          doubleSubmitFlag = false;
          return rv = false;
        }
      }

      if($("#sign_consent").val() != "true"){
        alert("확인서명을 해주세요.")
        doubleSubmitFlag = false;
        return rv = false;
      }

      if (mform.engineer.value == "") {
        mform.engineer.focus();
        alert("담당 SE를 선택해주세요.");
        doubleSubmitFlag = false;
        return rv = false;
      }

      // if (mform.customer_manager.value == "") {
      //   mform.customer_manager.focus();
      //   alert("담당자를 입력해주세요.");
      //   doubleSubmitFlag = false;
      //   return false
      // }

      $('.customer_manager').each(function(){
        var v = $(this).val();
        if(v == "") {
            alert("담당자를 입력해주세요.");
            $(this).focus();
            doubleSubmitFlag = false;
            return rv = false;
        }
      })

      if (mform.income_time.value == "") {
        mform.income_time.focus();
        alert("작업일을 선택해주세요.");
        doubleSubmitFlag = false;
        return rv = false;
      }

      if (mform.engineer.value == "") {
        mform.engineer.focus();
        alert("엔지니어를 입력해주세요.");
        doubleSubmitFlag = false;
        return rv = false;
      }

      if (mform.start_time.value == "") {
        mform.start_time.focus();
        alert("시작시간을 입력해주세요.");
        doubleSubmitFlag = false;
        return rv = false;
      }

      if (mform.end_time.value == "") {
        mform.end_time.focus();
        alert("종료시간을 입력해주세요.");
        doubleSubmitFlag = false;
        return rv = false;
      }


      //작업시간이 12시간이 넘는지 체크
      // var start_date = getFormatDate(new Date()).split('-');
      // var start_time = mform.start_time.value.split(':');
      // var end_time = mform.end_time.value.split(':');
      // var total_hour;

      //date format 함수
      // function getFormatDate(date) {
      //   var year = date.getFullYear(); //yyyy
      //   var month = (1 + date.getMonth()); //M
      //   month = month >= 10 ? month : '0' + month; //month 두자리로 저장
      //   var day = date.getDate(); //d
      //   day = day >= 10 ? day : '0' + day; //day 두자리로 저장
      //   return year + '-' + month + '-' + day; //'-' 추가하여 yyyy-mm-dd 형태 생성 가능
      // }

      // if(start_time[0] >= 12 && end_time[0] <12){ //시작시간이 오후인데 종료시간이 오전이면? 날짜가 바뀐거지
      //   var test = new Date();
      //   test.setDate(test.getDate()+1)
      //   var end_date = getFormatDate(test).split('-');
      //   var time1 = new Date(start_date[0],start_date[1],start_date[2],start_time[0],start_time[1]);
      //   var time2 = new Date(end_date[0],end_date[1],end_date[2],end_time[0],end_time[1]);
      //   total_hour = (time2 - time1)/ 1000 / 60 / 60;
      // }else{ //시작하는시간 종료시간 날짜 같음
      //   var time1 = new Date(start_date[0],start_date[1],start_date[2],start_time[0],start_time[1]);
      //   var time2 = new Date(start_date[0],start_date[1],start_date[2],end_time[0],end_time[1]);
      //   total_hour = (time2 - time1)/ 1000 / 60 / 60;
      // }
    // }

      // if(time2 - time1 < 0){
      //   var result = confirm("작업 종료시간이 작업 시작시간 보다 빠릅니다. 올바르게 입력하셨나요?");
      //   if(!result){
      //     $("#start_time").focus();
      //     return false;
      //   }
      // }
      //
      // if(total_hour >= 12){
      //   var result = confirm("작업시간이 12시간 이상입니다. 올바르게 입력하셨나요?");
      //   if(!result){
      //     $("#start_time").focus();
      //     return false;
      //   }
      // }

      //작업시간 12시간 넘는지 체크 끝
    }

    // merge_email();
if(rv) {
    var work_text = document.getElementsByName('work_text[]');
    var comment = document.getElementById("comment");
    var str = "";
    var i = 0;

    if($("#work_name option:selected").val()!="정기점검2"){
      for (i; i < work_text.length; i++) {
        document.getElementsByName('work_text[]')[i].value = escapeHtml(work_text[i].value).replace(/\n/g, '<br/>');
      }
    }else{
      document.getElementsByName('work_text[]')[0].value = "";
        for(k=0; k<$(".work_text_table").length; k++){
          var check = [];
          for (i = 0; i < $('.work_text_table').eq(k).find($("[class*='check']")).length; i++) {
            check[i] = $('.work_text_table').eq(k).find($("[class*='check']")).eq(i).attr('class').replace("check", "");
          }
          var maxCheckidx = Number(Math.max.apply(null, check));
          for (i = 0; i <= maxCheckidx; i++) {
            var j = 0;
            while ($('.work_text_table').eq(k).find('[name="work_text' + i + "[]" + '"]').eq(j).length != 0) {
              if (j == 0) {
                document.getElementsByName('work_text[]')[0].value += '@@#*' + $('.work_text_table').eq(k).find('[name="work_text' + i + "[]" + '"]').eq(j).val();
              } else {
                document.getElementsByName('work_text[]')[0].value += '#*' + $('.work_text_table').eq(k).find('[name="work_text' + i + "[]" + '"]').eq(j).val();
              }
              j++;
            }
          }
          document.getElementsByName('work_text[]')[0].value += "|||";
        }

        function replaceAll(str, searchStr, replaceStr) {
          return str.split(searchStr).join(replaceStr);
        }

        document.getElementsByName('work_text[]')[0].value = replaceAll(document.getElementsByName('work_text[]')[0].value, "#*::#*", "::");
        document.getElementsByName('work_text[]')[0].value = escapeHtml(document.getElementsByName('work_text[]')[0].value);
        document.getElementsByName('work_text[]')[0].value = document.getElementsByName('work_text[]')[0].value.replace(/\n/g, '<br/>');
    }

    //순서바뀌었을 수도 있으니깐 제품명,host,버전,서버,hardware,라이선스,serial 다시
    mform.produce_seq.value = '';
    mform.produce.value = '';
    mform.host.value='';
    mform.version.value='';
    mform.hardware.value='';
    mform.license.value='';
    mform.serial.value='';

    for(i=0; i<$(".produce").length; i++){
      if(i == 0){//처음
        mform.produce_seq.value += $(".produce_seq").eq(i).html();
        mform.produce.value += $(".produce").eq(i).html();
        mform.host.value += $(".host").eq(i).html();
        mform.version.value += $(".version").eq(i).html();
        mform.hardware.value += $(".hardware").eq(i).html();
        mform.license.value += $(".license").eq(i).html();
        mform.serial.value += $(".serial").eq(i).html();
      }else{
        mform.produce_seq.value += ',' + $(".produce_seq").eq(i).html();
        mform.produce.value += ',' + $(".produce").eq(i).html();
        mform.host.value += ',' + $(".host").eq(i).html();
        mform.version.value += ',' + $(".version").eq(i).html();
        mform.hardware.value += ',' + $(".hardware").eq(i).html();
        mform.license.value += ',' + $(".license").eq(i).html();
        mform.serial.value += ',' + $(".serial").eq(i).html();
      }
    }
    document.getElementById("comment").value = comment.value.replace(/\n/g, '<br/>');

    if($("#some_inspection").is(":checked") == true){
      $("#some_inspection").val('Y');
    }

      mform.submit();
      return false;
    }
  }
}

  function addRow() {
    var num = $(".num").last('td').html().split('.').splice(0, 1);
    var addNum = Number(num) + 1;
    var addText = '<tr class="addRow" id="' + addNum + '"><td height="40" align="center" class="row-color1 border-l num" style="font-weight:bold;">' + addNum + '. 지원날짜</td><td style="padding-left:10px;"><input type="date" name="work_day_s[]" class="input-common" style="width:48%;" id="work_day_s" size="8">&ensp;<input type="date" name="work_day_e[]" id="work_day_e" class="input-common" style="width:48%;" size="8"></td><td align="center" class="row-color1" style="font-weight:bold;">' + addNum + '. 지원시간</td><td class="border-r" style="padding-left:10px;"><input type="eu-time" name="work_time_s[]" id="work_time_s" class="input-common" style="width:48%;" autocomplete="off" size="2">&ensp;<input type="eu-time" name="work_time_e[]" id="work_time_e" class="input-common" style="width:48%;" autocomplete="off" size="2"></td></tr><tr class="addRow" id="' + addNum + '"><td height="40" align="center" class="row-color1 border-l border-r" colspan="4" style="font-weight:bold;">' + addNum + '. 지원내역</td></tr><tr class="addRow" id="' + addNum + '"><td colspan="4" class="border-l border-r" style="padding:10px 20px 10px 20px;"><textarea rows="5" style="width:calc(100% - 35px);float:left;margin-right:2px;" name="work_text[]" id="work_text">';
    addText += '담당자 : 두리안정보기술 홍길동 대리, 연락처 : 010-1234-5678, 이메일 : gdhong@durianit.co.kr \n';
    addText += '담당자 : 더 망고 이영희 사원 , 연락처 : 010-3456-7890, 이메일 : yhlee@mango.co.kr \n ';
    addText += '\n업무목적 : 기술지원한 목적을 작성 해주세요. \n';
    addText += '대상장비: 기술지원한 장비명을 작성해주세요. (S/N : xxxxxxx, Version : v.1.0) \n';
    addText += '</textarea><img src="<?php echo $misc; ?>img/btn_minus_white.svg" style="float:right;margin-top:30px;cursor:pointer;width:23px;" onclick="deleteRow(' + addNum + ');return false;"/></td></tr>';
    $(".addRow").last().after(addText);
  }

  function deleteRow(tableID) {
    // if($(".addRow").length == 1){
    //   alert("적어도 하나의 지원내역이 필요합니다.");
    // }else{
      // $(".addRow").last().remove();
      $('tr').remove("#"+tableID);
    // }
  }

  $(document).ready(function(){
    if( getParam('schedule_seq') != 'N'){
      $('#income_time').prop('readonly',true);
      $('#end_work_day').prop('readonly',true);
    }else{
      $('#income_time').prop('readonly',false);
      $('#end_work_day').prop('readonly',false);
    }
  });

  // get 값 가져오는 함수
  function getParam(sname) {
    var params = location.search.substr(location.search.indexOf("?") + 1);
    var sval = "";
    params = params.split("&");
    for (var i = 0; i < params.length; i++) {
      temp = params[i].split("=");
      if ([temp[0]] == sname) {
        sval = temp[1];
      }
    }
    return sval;
  }

  function failure_add() {
    var target = $('.err_row').last();
    var text = '<tr class="err_row field"><td colspan="5" height="1" bgcolor="#e8e8e8"></td></tr><tr class="err_row"><td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="row-color1 border-l"><input type="text" class="input-common failure_title" name="failure_title[]" value=""></td><td colspan="3" style="font-weight:bold;padding: 12px;" class="border-r"><input type="text" name="failure_content[]" id="failure_content[]" class="input-common" style="width:98%;margin-right:2px;" value="-" /><img src="/misc/img/btn_minus_white.svg" style="cursor:pointer;width:23px;vertical-align:middle;" onclick="failure_del(this);"/></td></tr>';

    $(target).after(text);
  }

  function failure_del(el) {
    var tr = $(el).closest('tr');
    var border_tr = $(tr).prev('tr');

    tr.remove();
    border_tr.remove();
  }

</script>

<body>
<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
<div align="center">
<div class="dash1-1">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
    <tr height="5%">
      <td class="dash_title">
    		기술지원보고서 작성
    	</td>
    </tr>
      <tr>
        <tr>
          <td align="right">
            <input style="margin-top:20px;margin-right:10px;width:80px;color:#333;" type="button" class="btn-common" value="임시저장" onClick="javascript:chkForm('N');return false;">
            <input style="margin-top:20px;margin-right:10px;width:60px;" type="button" class="btn-common btn-color4" value="취소" onClick="javascript:history.go(-1)">
            <!-- <input id="deleteRowBtn" style="margin-top:20px;margin-right:10px;width:80px;" type="button" class="btn-common btn-color4" value="내용삭제" onClick="deleteRow('input_table');return false;">
            <input id="addRowBtn" style="margin-top:20px;margin-right:10px;width:80px;" type="button" class="btn-common btn-color7" value="내용추가" onClick="addRow();change_w2field();return false;"> -->
            <input style="margin-top:20px;margin-right:40px;width:60px;" type="button" class="btn-common btn-color2" value="등록" onClick="javascript:chkForm('Y');return false;">
          </td>
        </tr>
        <td align="center" valign="top">
          <table width="100%" height="100%" cellspacing="0" cellpadding="0">
            <tr>
              <td width="100%" align="center" valign="top">
                <form name="cform" action="<?php echo site_url(); ?>/tech/tech_board/tech_doc_input_action<?php if(!empty($_GET['type'])){ echo "?type=".$_GET['type']; } ?>" method="post" enctype="multipart/form-data">
                <!-- <form name="cform" action="<?php echo site_url(); ?>/tech/tech_board/tech_doc_input_action" method="post" enctype="multipart/form-data" onSubmit="javascript:chkForm();return false;"> -->
                <table width="100%" border="0" style="margin-top:20px;">
                  <input type="hidden" id="row_max_index" name="row_max_index" value="0" />
                  <input type="hidden" id="customer_tmp" name="customer_tmp" value="" />
                  <!-- KI1 20210125 -->
                  <input type="hidden" id="forcasting_seq" name="forcasting_seq" value="<?php if(isset($schedule)){echo $schedule->forcasting_seq;}?>" />
                  <input type="hidden" id="maintain_seq" name="maintain_seq" value="<?php if(isset($schedule)){echo $schedule->maintain_seq;}?>" />
                  <!-- KI2 20210125 -->
                  <input type="hidden" id="checkListForm" name="checkListForm" value="" />
                  <input type="hidden" id="type" name="type" value="" />
                  <tr>
                    <!-- <td class="title3">기술지원보고서 등록/수정</td> -->
                    <input type="hidden" id="schedule_seq" name="schedule_seq" value="<?php if(isset($schedule)){echo $schedule->seq;}else{echo null;}?>">
                    <!-- <input type="hidden" id="schedule_seq" name="schedule_seq" value="<?php if(isset($schedule)){echo $schedule_seq;}else{echo 'normal';}?>"> -->
                  </tr>
                  <tr>
                    <td>
                      <table id="input_table" class="list_tbl" width="100%" border="0" cellspacing="0" cellpadding="0">
                        <colgroup>
                          <col width="15%">
                          <col width="35%">
                          <col width="15%">
                          <col width="35%">
                        </colgroup>
                        <tr>
                          <td height="40" align="center" class="row-color1 border-l" style="font-weight:bold;border-top:thin solid #DFDFDF">작업명(종류)</td>
                          <td width="35%" style="padding-left:10px;border-top:thin solid #DFDFDF">
                            <select name="work_name" id="work_name" class="select-common" onChange="change();periodicInspection();" style="height:23px;">
                              <!-- <option value="정기점검">정기점검</option> -->
                              <option value="정기점검2" <?php if((isset($schedule)) && ($schedule->work_name =='정기점검2')){echo 'selected="selected"';}?>>정기점검2</option>
                              <option value="교육지원" <?php if((isset($schedule)) && ($schedule->work_name =='교육지원')){echo 'selected="selected"';}?>>교육지원</option>
                              <option value="교육참석" <?php if((isset($schedule)) && ($schedule->work_name =='교육참석')){echo 'selected="selected"';}?>>교육참석</option>
                              <option value="장애지원" <?php if((isset($schedule)) && ($schedule->work_name =='장애지원')){echo 'selected="selected"';}elseif(empty($schedule)){echo 'selected="selected"';}?> >장애지원</option>
                              <!-- <option value="장애지원" selected="selected">장애지원</option> -->
                              <option value="설치지원" <?php if((isset($schedule)) && ($schedule->work_name =='설치지원')){echo 'selected="selected"';}?>>설치지원</option>
                              <option value="기술지원" <?php if((isset($schedule)) && ($schedule->work_name =='기술지원')){echo 'selected="selected"';}?>>기술지원</option>
                              <option value="납품설치" <?php if((isset($schedule)) && ($schedule->work_name =='납품설치')){echo 'selected="selected"';}?>>납품설치</option>
                              <option value="미팅" <?php if((isset($schedule)) && ($schedule->work_name =='미팅')){echo 'selected="selected"';}?>>미팅</option>
                              <option value="데모(BMT)지원" <?php if((isset($schedule)) && ($schedule->work_name =='데모(BMT)지원')){echo 'selected="selected"';}?>>데모(BMT)지원</option>
                            </select>
                          </td>
                          <td align="center" class="row-color1" style="font-weight:bold;border-top:thin solid #DFDFDF">등록자</td>
                          <td class="border-r" style="padding-left:10px;border-top:thin solid #DFDFDF"><input type="hidden" id="writer" name="writer" value="<?php echo $name; ?>"><?php echo $name; ?></td>
                        </tr>
                        <tr>
                          <td align="center" class="row-color1 border-l" style="font-weight:bold;">고객사</td>
                          <td style="padding-left:10px;">
                            <div class="dropdown" id="dropdown">
                              <!-- KI1 20210125 $schedule값이 있을 경우 불러오기 추가-->
                              <input id="customerName" name ="customerName" type="text" class="input-common" style="width:200px;font-weight:bold;text-align:center;margin-right:5px;" onchange="customerNameChange(this.value);" value="<?php if(isset($schedule)){echo $schedule->customer;}?>" readonly>
                              <input id="dropbtn" style="width:60px;" type="button" class="btn-common btn-style2" value="검색" onClick="searchFunction(this.id)">
                              <!-- 포캐스팅+유지보수 -->
                              <!-- <input type="hidden" id="customer" name="customer" value="<?php if(isset($schedule)){if($schedule->work_name=='납품설치' || $schedule->work_name=='미팅' || $schedule->work_name=='데모(BMT)지원'){echo $schedule->forcasting_seq;}else{ echo $schedule->maintain_seq; }}?>" style="border:none" readonly> -->
                              <input type="hidden" id="customer" name="customer" value="<?php if(isset($schedule)){if($schedule->work_name=='납품설치' || $schedule->work_name=='미팅' || $schedule->work_name=='데모(BMT)지원'){echo $schedule->forcasting_seq;}else{ if($schedule->maintain_seq == null){ echo $schedule->forcasting_seq; }else{ echo $schedule->maintain_seq; }}}?>" style="border:none" readonly>
                              <!-- KI2 20210125 -->
                              <div id="myDropdown" class="dropdown-content">
                                <input type="text" name="0" placeholder="고객사를 입력하세요" id="searchInput" class="searchInput" onkeyup="filterFunction(this)" ;>
                                <div id="dropdown_option" style="overflow:scroll; width:277px; height:300px;">
                                  <?php
                                  foreach ($customer as $val) {
                                    // if (strtotime(date("Y-m-d")) > strtotime(date($val['maintain_end']))) {
                                    //   echo '<a style="color:red;" ';
                                    //   echo 'onclick ="clickCustomerName(this,' . strtotime(date($val['maintain_end'])) . ','.$val['maintain_seq'].','.$val['forcasting_seq'].')" >' . $val['customer'].' - '.addslashes($val['project_name']).'</a>';
                                    // } else {
                                    //포캐스팅+유지보수
                                      echo '<a ';
                                      echo 'onclick ="clickCustomerName(this,' . strtotime(date($val['maintain_end'])) . ','.$val['maintain_seq'].','.$val['forcasting_seq'].')" >'. $val['customer'].' - '.addslashes($val['project_name']).'</a>';
                                    // }
                                  }
                                  ?>
                                </div>
                              </div>
                            </div>
                          </td>
                          <td class="border-r" colspan="2"></td>
                        </tr>
                        <tr>
                          <td height="40" align="center" class="row-color1 border-l" style="font-weight:bold;">작업시작일</td>
                          <td style="padding-left:10px;">
                            <input type="date" name="income_time" id="income_time" class="input-common" value="<?php if(isset($schedule)){echo $income_day;}?>" />
                          </td>
                          <td align="center" class="row-color1" style="font-weight:bold;">작업종료일</td>
                          <td class="border-r" style="padding-left:10px;">
                            <input type="date" name="end_work_day" id="end_work_day" class="input-common" value="<?php if(isset($schedule)&& $end_work_day != NULL){echo $end_work_day;}else if(isset($schedule)&& $end_work_day == NULL){echo $income_day;}?>" />
                          </td>
                        </tr>
                        <tr>
                          <td height="40" align="center" class="row-color1 border-l" style="font-weight:bold;">프로젝트명</td>
                          <td style="padding-left:10px;">
                            <!-- KI1 20210125 $schedule값이 있을 경우 불러오기 추가-->
                            <input name="project_name" id="project_name" class="input-common" value="<?php if(isset($schedule)){echo $schedule->project;}?>" readonly>
                            <!-- KI2 20210125 -->
                          </td>
                          <td align="center" class="row-color1" style="font-weight:bold;">표지/로고</td>
                          <td class="border-r" style="padding-left:10px;">
                            <select id="cover" name="cover" class="select-common" style="height:23px;width:48%;">
                              <option value="basic" selected>기본</option>
                              <?php
                               foreach($cover as $co){
                                 echo "<option value='{$co['seq']}'>{$co['cover_name']}</option>";
                               }
                              ?>
                            </select>&ensp;
                            <select id="logo" name="logo" class="select-common" style="height:23px;width:48%;">
                              <?php
                               foreach($logo as $lo){
                                 if($lo == "durianit_logo.png"){
                                   echo "<option value='$lo' selected='selected'>$lo</option>";
                                 }else{
                                   echo "<option value='$lo'>$lo</option>";
                                 }
                               }
                              ?>
                            </select>
                          </td>
                        </tr>
                        <tr class="field" id="err_row1">
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr id="err_row2">
                          <td height="40" align="center" class="row-color1 border-l" style="font-weight:bold;">장애구분</td>
                          <td style="padding-left:10px;">
                            <select name="err_type" id="err_type" class="select-common">
                              <option value="HW">HW</option>
                              <option value="SW">SW</option>
                            </select>
                          </td>
                          <td align="center" class="row-color1" style="font-weight:bold;">심각도</td>
                          <td class="border-r" style="padding-left:10px;">
                            <select name="warn_level" id="warn_level" class="select-common">
                              <option value="001">전체서비스중단</option>
                              <option value="002">일부서비스중단/서비스지연</option>
                              <option value="003">관리자불편/대고객신뢰도저하</option>
                              <option value="004">특정기능장애</option>
                              <option value="005">서비스무관단순장애</option>
                            </select>
                          </td>
                        </tr>
                        <tr class="field" id="err_row3">
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr id="err_row4">
                          <td height="40" align="center" class="row-color1 border-l" style="font-weight:bold;">장애유형</td>
                          <td style="padding-left:10px;">
                            <select name="warn_type" id="warn_type" class="select-common">
                              <option value="001">파워 불량</option>
                              <option value="002">하드웨어 결함</option>
                              <option value="003">인터페이스 불량</option>
                              <option value="004">DISK 불량</option>
                              <option value="005">LED 불량</option>
                              <option value="006">FAN 불량</option>
                              <option value="007">하드웨어 소음</option>
                              <option value="008">설정 오류</option>
                              <option value="009">고객 과실</option>
                              <option value="010">기능 버그</option>
                              <option value="011">OS 오류</option>
                              <option value="012">펌웨어 오류</option>
                              <option value="013">타사 제품 문제</option>
                              <option value="014">호환 문제</option>
                              <option value="015">시스템 부하</option>
                              <option value="016">PC 문제</option>
                              <option value="017">원인 불명</option>
                              <option value="018">기타 오류</option>
                            </select>
                          </td>
                          <td align="center" class="row-color1" style="font-weight:bold;">장애처리방법</td>
                          <td class="border-r" style="padding-left:10px;">
                            <!-- <input type="date" name="income_time" id="income_time" class="input-common"/></td> -->
                            <select name="work_action" id="work_action" class="select-common">
                              <option value="001">기술지원</option>
                              <option value="002">설정지원</option>
                              <option value="003">장비교체</option>
                              <option value="004">업그레이드</option>
                              <option value="005">패치</option>
                              <option value="006">협의중</option>
                            </select>
                          </td>
                        </tr>
                        <tr id="main_insert_field_0">
                          <td height="40" align="center" class="row-color1 border-l" style="font-weight:bold;">담당자명</td>
                          <td style="padding-left:10px;">
                            <!-- KI1 20210125 -->
                            <input type="text" name="customer_manager[]" id="customer_manager" class="input-common customer_manager" value="<?php if(isset($schedule)){echo $schedule->customer_manager;}?>"/>
                            <input type="hidden" name="maintain_end" id="maintain_end" class="input-common" value="" />
                          </td>
                          <td align="center" class="row-color1" style="font-weight:bold;">이메일</td>
                          <td class="border-r" style="padding-left:10px;">
                            <input type="text" name="manager_mail[]" id="manager_mail" class="input-common manager_mail" style="width:calc(100% - 35px);">
                            <img src="<?php echo $misc; ?>img/dashboard/dash_plus.svg" id="main_add" name="main_add" style="cursor:pointer;vertical-align:middle;height:25px;" />
                          </td>
                          <td class="border-n" width="3%" style="padding-left:10px;">
                            <input type="hidden" name="del_ck" class="input-common">
                          </td>
                          <td class="border-n" align="center">
                          </td>
                        </tr>
                        <tr class='field' id='manager_input_field'>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                          <td height="40" align="center" class="row-color1 border-l" style="font-weight:bold;">시작시간</td>
                          <td style="padding-left:10px;">
                            <!-- <input  type="eu-time"> -->

                            <?php
                            if(isset($schedule)){
                              $start_time =  explode(":", $schedule->start_time);
                              $end_time =  explode(":", $schedule->end_time);
                            }
                            ?>
                            <input type="eu-time" name="start_time" id="start_time" class="input-common" autocomplete="off" <?php if(isset($schedule)){echo "value='".$start_time[0].":".$start_time[1]."' readonly";}?> />
                          </td>
                          <td align="center" class="row-color1" style="font-weight:bold;">종료시간</td>
                          <td class="border-r" style="padding-left:10px;">
                            <input type="eu-time" name="end_time" id="end_time" class="input-common" autocomplete="off" <?php if(isset($schedule)){echo "value='".$end_time[0].":".$end_time[1]."' readonly";}?> />
                          </td>
                        </tr>
                      <?php if(isset($schedule)){ ?>
                        <tr>
                          <td height="40" align="center" class="row-color1 border-l" style="font-weight:bold;"><?php if($schedule->start_reason != ''){echo "사유(시작)";}if($schedule->s_file_realname){echo '사진(시작)';} ?></td>
                          <td style="padding-left:10px;">
                            <?php if($schedule->start_reason != ''){echo $schedule->start_reason;}if($schedule->s_file_realname){echo $schedule->s_file_realname;} ?>
                          </td>
                          <td align="center" class="row-color1" style="font-weight:bold;"><?php if($schedule->end_reason != ''){echo "사유(종료)";}if($schedule->e_file_realname){echo '사진(종료)';} ?></td>
                          <td class="border-r" style="padding-left:10px;">
                            <?php if($schedule->end_reason != ''){echo $schedule->end_reason;}if($schedule->e_file_realname){echo $schedule->e_file_realname;} ?>
                          </td>
                        </tr>
                      <?php } ?>
                        <tr>
                          <td height="40" align="center" class="row-color1 border-l" style="font-weight:bold;">담당SE</td>
                          <td style="padding-left:10px;">
                            <input type="text" name="engineer" id="engineer" class="input-common" onclick="test2();" value="<?php if(isset($schedule)){echo $participant;}?>" readonly>
                            <input type="hidden" name="engineer_seq" id="engineer_seq" class="input-common" value="<?php if(isset($schedule)){echo $schedule->participant_seq;}?>" />
                          </td>
                          <td align="center" class="row-color1" style="font-weight:bold;">지원방법</td>
                          <td class="border-r" style="padding-left:10px;">
                            <select name="handle" id="handle" class="select-common">
                              <option value="현장지원" <?php if((isset($schedule)) && ($schedule->support_method =='현장지원')){echo 'selected="selected"';}?>>현장지원</option>
                              <option value="원격지원" <?php if((isset($schedule))&& ($schedule->support_method =='원격지원')){echo 'selected="selected"';}?>>원격지원</option>>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td align="center" class="row-color1 border-l" style="font-weight:bold;">제품</td>
                          <td align="left" colspan="2" style="padding-left:10px;">
                          <input type="text" id="serial_value" style="display:none;border:1px solid" placeholder="serial직접입력" onchange="serialChange();" />
                          <input type="hidden" name="produce_seq" id="produce_seq" class="input-common_red" readonly>
                          <input type="hidden" name="produce" id="produce" class="input-common_red" readonly>
                          <input type="hidden" name="host" id="host" class="input-common_red" readonly>
                          <input type="hidden" name="version" id="version" class="input-common_red" readonly>
                          <input type="hidden" name="hardware" id="hardware" class="input-common_red" readonly>
                          <input type="hidden" name="license" id="license" class="input-common_red" readonly>
                          <input type="hidden" name="serial" id="serial" class="input-common_red"  readonly>
                          <input type="hidden" name="manufacturer" id="manufacturer" class="input-common_red"  readonly>
                          <input type="hidden" name="duplication_yn" id="duplication_yn" class="input-common_red"  readonly>
                          <input type="hidden" name="currentProduce" id="currentProduce" class="input-common_red" readonly>
                          <input type="hidden" name="currentPage" id="currentPage" class="input-common_red" value=1 readonly>
                          <ul id="sortable">
                          </ul>
                          </td>
                          <td align="right" colspan="1" class="border-r">
                            <input type="hidden" name="productSeq" id="productSeq" class="input-common_red" value="">
                            <input type="button" id="produceBtn" class="btn-common btn-style2" value="제품선택" onclick="test(document.cform.customer.value);" style="cursor:pointer;margin-right:10px;width:80px;">
                            <input type="button" id="produceAddBtn" class="btn-common btn-style2" value="제품추가선택" onclick="test(document.cform.customer.value,'add');" style="cursor:pointer;margin-right:10px;width:110px;">
                          </td>
                        </tr>
                        <tr>
                          <td align="center" class="row-color1 border-l" style="font-weight:bold;">지원내용</td>
                          <td colspan="3" class="border-r" style="padding-left:10px;">
                            <input type="text" name="subject" id="subject" class="input-common" value="<?php if(isset($schedule)){echo $schedule->contents;}?>" />
                          </td>
                        </tr>
                        <tbody id ="nonPeriodic">
                        <tr>
                          <td height="40" align="center" class="row-color1 border-l num" style="font-weight:bold;">1. 지원날짜</td>
                          <td style="padding-left:10px;">
                            <input type="date" name="work_day_s[]" id="work_day_s" class="input-common" style="width:48%;" size="8" value="<?php if(isset($schedule)){echo $income_day;}?>">&ensp;
                            <input type="date" name="work_day_e[]" id="work_day_e" class="input-common" style="width:48%;" size="8" value="<?php if(isset($schedule)&& $end_work_day != NULL){echo $end_work_day;}else if(isset($schedule)&& $end_work_day == NULL){echo $income_day;}?>">
                          </td>
                          <td align="center" class="row-color1" style="font-weight:bold;">1. 지원시간</td>
                          <td class="border-r" style="padding-left:10px;">
                            <input type="eu-time" name="work_time_s[]" id="work_time_s" class="input-common" autocomplete="off" style="width:48%" size="2" value="<?php if(isset($schedule)){echo $start_time[0].":".$start_time[1];}?>">&ensp;
                            <input type="eu-time" name="work_time_e[]" id="work_time_e" class="input-common" autocomplete="off" style="width:48%" size="2" value="<?php if(isset($schedule)){echo $end_time[0].":".$end_time[1];}?>">
                          </td>
                        </tr>
                        <tr>
                          <td height="40" align="center" class="row-color1 border-l border-r" colspan="4" style="font-weight:bold;">1. 지원내역</td>
                        </tr>
                        <tr class="addRow">
                          <td colspan="4" class="border-l border-r" style="padding:10px 20px 10px 20px;">
                            <textarea rows="5" style="width:calc(100% - 35px);float:left;" name="work_text[]" id="work_text">
담당자 : 두리안정보기술 홍길동 대리, 연락처 : 010-1234-5678, 이메일 : gdhong@durianit.co.kr
담당자 : 더 망고 이영희 사원 , 연락처 : 010-3456-7890, 이메일 : yhlee@mango.co.kr

업무목적 : 기술지원한 목적을 작성 해주세요.
대상장비: 기술지원한 장비명을 작성해주세요. (S/N : xxxxxxx, Version : v.1.0)
                            </textarea>
                            <img src='<?php echo $misc; ?>img/dashboard/dash_plus.svg' style='float:right;cursor:pointer;margin-top:30px;' onclick='addRow();change_w2field();return false;'/>
                          </td>
                        </tr>
                        </tbody>

                        <!-- 정기점검2 -->
                        <tbody id ="periodic">
                          <tr>
                            <td colspan="4" height="40" align="center" style="font-weight:bold;" class="border-l border-r">
                              <table id="work_text_table1" class ="work_text_table" width=100% border=1 style="border-collapse:collapse;border:none;">
                                <tr>
                                    <th height="30" class="row-color1" ><input value="점검항목" readonly onfocus="javascrpt:blur();"
                                            style="cursor:default; font-weight:bold; text-align: -webkit-center;background-color:transparent;border:none;"></input></th>
                                    <th colspan="2" height="30" class="row-color1"><input value="점검내용" readonly onfocus="javascrpt:blur();"
                                            style="cursor:default; font-weight:bold; text-align: -webkit-center;background-color:transparent;border:none;"></input></th>
                                    <th height="30" class="row-color1"><input value="점검결과" readonly onfocus="javascrpt:blur();"
                                            style="cursor:default; font-weight:bold; text-align: -webkit-center;background-color:transparent;border:none;"></input></th>
                                    <th height="30" class="row-color1"><input value="특이사항" readonly onfocus="javascrpt:blur();"
                                            style="cursor:default; font-weight:bold; text-align: -webkit-center;background-color:transparent;border:none;"></input></th>
                                </tr>
                                <?php
                                $basicFormIdx = 1;
                                $check = explode(',',"기타 특이사항,CPU,메모리,디스크,LAN,UPTIME,SW데몬상태");
                                for($i=1; $i<count($check); $i++){
                                  echo '<tr class="check'.$i.'">';
                                  echo '<td class="tdSolid"><input name="work_text'.$i.'[]" value="'.$check[$i].'" style="width:80%;border:none;"/><img src="'.$misc.'img/btn_minus_white.svg" style="cursor:pointer;width:23px;" class="adddelbtn" onclick="trRemove(this,1);"/></td><td class="tdSolid" colspan="2"><textarea name="work_text'.$i.'[]" onkeyup="xSize(this);" style="width:80%;"></textarea><img src="'.$misc.'img/dashboard/dash_plus.svg" style="cursor:pointer;" class="tdDivisionBtn" onclick="tdDivision(this,'.$i.');"/></td>';
                                  echo '<td class="tdSolid"><div style="margin:0 auto; text-align: -webkit-center;font-weight:normal;">';
                                  echo '<input type="hidden" name="work_text'.$i.'[]" value="normal"><input type="radio" name="produce1_'.$i.'" value="normal" onclick="normalCheck(this);" checked="checked">정상<input type="radio" name="produce1_'.$i.'" value="abnormal" onclick="normalCheck(this);">비정상</div></td>';
                                  echo '<td class="tdSolid"><textarea name="work_text'.$i.'[]" onkeyup="xSize(this);"></textarea><img src="'.$misc.'img/dashboard/dash_plus.svg" onclick ="check_add(this,1)" style="cursor:pointer;" /></td>';
                                  echo '<td width="0%" class="border-n adddelbtn"><input type="hidden" name="del_ck" class="input-common"></td>';
                                  echo '<td align="center" class="border-n adddelbtn"></td></tr>';
                                  $basicFormIdx++;
                                }
                                echo '<tr class="check0" height="80"><td class="tdSolid"><input name="work_text0[]" value= "기타 특이사항" readonly onfocus="javascrpt:blur();" style="border:none"></td><td colspan="4"><textarea name="work_text0[]" rows="5" style="width:95%;"></textarea></td></tr>';
                                ?>
                              </table>
                              <img src="<?php echo $misc; ?>img/dashboard/dash_plus.svg" id="trPlusBtn" onclick="trPlus();" style="margin:5px;"/>
                              <span id="templateOnOFF1" class="templateOnOFF">
                                <label class="switch">
                                  <input id="checkOnOFF" type="checkbox" onclick="template_check(1)">
                                  <span class="slider round"></span>
                                </label>
                                <p id="templateOff" class="onoff">TEMPLATE OFF</p><p id="templateOn" class="onoff" style="display:none;">TEMPLATE ON</p>
                              </span>
                            </td>
                          </tr>
                        </tbody>
                        <!-- 정기점검2끝 -->
                        <!-- <tr>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                          <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">버전정보</td>
                          <td width="35%" style="padding-left:10px;" class="t_border">
                            <input type="text" name="version_info" id="version_info" class="input-common" value=""/>
                          </td>
                          <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">제조사</td>
                          <td width="35%" style="padding-left:10px;" class="t_border">
                            <select id="manufacturer" name="manufacturer" class="select-common">
                              <option value="" >제조사</option>
                              <?php foreach($product_company as $pc){
                                echo "<option value='{$pc['product_company']}'>{$pc['product_company']}</option>";
                              }?>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                          <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">시리얼번호</td>
                          <td width="35%" style="padding-left:10px;" class="t_border">
                            <input type="text" name="serial_number" id="serial_number" class="input-common" value=""/>
                          </td>
                          <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">이중화 여부</td>
                          <td width="35%" style="padding-left:10px;" class="t_border">
                            <input type="checkbox" name="duplication_yn" id="duplication_yn" value="N" />
                          </td>
                        </tr> -->


                        <tr class="err_row field">
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr class="err_row">
                          <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="row-color1 border-l">
                            <input type="text" class="input-common failure_title" style="text-align:center;font:'Noto Sans KR', sans-sans-serif;font-weight:bold;font-size:12px;" name="failure_title[]" value="장애증상">
                          </td>
                          <td colspan="3" style="font-weight:bold;padding:12px;" class="border-r">
                            <input type="text" name="failure_content[]" id="failure_content[]" class="input-common" style="width:98%;" value="-" />
                            <img src="<?php echo $misc; ?>img/dashboard/dash_plus.svg" onclick="failure_add();" style="cursor:pointer;vertical-align:middle;" />
                          </td>
                        </tr>

                        <tr>
                          <td align="center" class="row-color1 border-l" style="font-weight:bold;">지원의견</td>
                          <td colspan="3" class="border-r" style="padding-left:10px;">
                            <!-- <textarea rows="5" style="width:95%;" name="comment" id="comment"></textarea> -->
                            <input type="text" name="comment" id="comment" class="input-common" value="-" />
                          </td>
                        </tr>
                        <tr>
                          <td align="center" class="row-color1 border-l" style="font-weight:bold;">지원결과</td>
                          <td colspan="3" class="border-r" style="padding-left:10px;">
                            <select name="result" id="result" class="select-common" style="height:23px;width:40%">
                              <option value="기술지원 완료(100% 진행)">기술지원 완료(100% 진행)</option>
                              <option value="기술지원 미완료(90% 진행)">기술지원 미완료(90%진행)</option>
                              <option value="기술지원 미완료(70% 진행)">기술지원 미완료(70%진행)</option>
                              <option value="기술지원 미완료(50% 진행)">기술지원 미완료(50%진행)</option>
                              <option value="기술지원 미완료(30% 진행)">기술지원 미완료(30%진행)</option>
                              <option value="기술지원 미완료(10% 진행)">기술지원 미완료(10%진행)</option>
                              <option value="교육완료">교육완료</option>
                              <option value="미팅완료">미팅완료</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td align="center" class="row-color1 border-l" style="font-weight:bold;">요청사항</td>
                          <td colspan="3" class="border-r" style="padding-left:10px;">
                            <!-- <textarea rows="3" style="width:95%;" name="request" id="request"></textarea> -->
                            <input type="text" name="comment" id="comment" class="input-common" value="-" />
                          </td>
                        </tr>
                        <tr>
                          <td align="center" class="row-color1 border-l" style="font-weight:bold;">이슈</td>
                          <td colspan="3" class="border-r" style="padding-left:10px;">
                            <!-- <textarea rows="3" style="width:95%;" name="issue" id="issue"></textarea> -->
                            <input type="text" name="issue" id="issue" class="input-common" value="-" />
                          </td>
                        </tr>
                        <tr>
                          <td align="center" class="row-color1 border-l" style="font-weight:bold;">버그</td>
                          <td colspan="3" class="border-r" style="padding-left:10px;">
                            <!-- <textarea rows="3" style="width:95%;" name="bug" id="bug"></textarea> -->
                            <input type="text" name="bug" id="bug" class="input-common" value="-" />
                          </td>
                        </tr>
                        <tr>
                          <td align="center" class="row-color1 border-l" style="font-weight:bold;">확인서명</td>
                          <td style="padding-left:10px;">
                            <input type="checkbox" id="sign_consent" name="sign_consent" value=0>서명동의
                              <div id="dialog" title="비밀번호를 입력하세요" style="float:right;display:none;">
                                <input id="passwordCheck" type="password" size="30" style="height:28px;" />
                              </div>
                          </td>
                          <td align="center" class="row-color1" style="font-weight:bold;">일부점검</td>
                          <td  class="border-r" style="padding-left:10px;">
                            <input id="some_inspection" name="some_inspection" type="checkbox" value='N'>
                          </td>
                        </tr>
                        <tr>
                          <td align="center" class="row-color1 border-l" style="font-weight:bold;">첨부파일</td>
                          <td colspan="3" class="border-r" style="padding-left:10px;">
                            <!-- <input type="file" class="box-file-input" name="cfile" id="cfile" />
                              (용량제한 100MB) -->
                              <div class="box-file-input s_file_input_box" style="margin:10px;"><span style="margin-right:10px;" class="file_span"></span>
                              <label id="label" style="float:right;margin-bottom:10px;">
                                <form id="ajaxFrom" method="post" enctype="multipart/form-data"><input type="file" class="file-input" name="cfile" id="cfile" onchange="file_change(this);" /></form>
                              </label><span style="margin-right:10px;float:right;" class="text_span">선택된 파일 없음 </span></div>
                          </td>
                        </tr>
                        <tr>
                          <td align="center" class="row-color1 border-l" style="font-weight:bold;">#해시태그</td>
                          <td colspan="3" class="border-r" style="padding-left:10px;">
                            <input type="text" name="hashtag" id="hashtag" class="input-common" value="" placeholder="#홍길동  #두리안정보기술"/>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr class="comment_tr">
                    <td>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:30px;border:none;">
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
</table>
</div>
</div>
<?php
 include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php";
?>
</body>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/js/select2.min.js"></script>
<script>
// $("#manufacturer").select2({width:'54%'});

  // 고객사 검색
  function searchFunction(id) {
    if( ($("#work_name").val() == "납품설치" || $("#work_name").val() == "미팅" || $("#work_name").val() == "데모(BMT)지원") || '<?php echo $this->cooperation_yn; ?>' == 'Y' ){
      $("#dropdown_option").html(
        <?php
        echo "'";
        foreach ($customer2 as $val) {
            echo '<a ';
            echo 'onclick ="clickCustomerName(this,0,'.$val['forcasting_seq'].','.$val['forcasting_seq'].')" >'. $val['customer'].' - '.addslashes($val['project_name']).'</a>';
        }
        echo "'";
        ?>
      );
    }else{
      $("#dropdown_option").html(
      <?php
         echo "'";
        foreach ($customer as $val) {
          // if (strtotime(date("Y-m-d")) > strtotime(date($val['maintain_end']))) {
          //   echo '<a style="color:red;" ';
          //   echo 'onclick ="clickCustomerName(this,' . strtotime(date($val['maintain_end'])) . ','.$val['maintain_seq'].','.$val['forcasting_seq'].')" >' . $val['customer'].' - '.addslashes($val['project_name']).'</a>';
          // } else {
          //   echo '<a ';
          //   echo 'onclick ="clickCustomerName(this,' . strtotime(date($val['maintain_end'])) . ','.$val['maintain_seq'].','.$val['forcasting_seq'].')" >'. $val['customer'].' - '.addslashes($val['project_name']).'</a>';
          // }
          //포캐스팅+유지보수
          if ($val['maintain_seq'] == null) {
            echo '<a ';
            echo 'onclick ="clickCustomerName(this,0,'.$val['forcasting_seq'].','.$val['forcasting_seq'].')" >'. $val['customer'].' - '.addslashes($val['project_name']).'</a>';
          } else {
            echo '<a ';
            echo 'onclick ="clickCustomerName(this,' . strtotime(date($val['maintain_end'])) . ','.$val['maintain_seq'].','.$val['forcasting_seq'].')" >'. $val['customer'].' - '.addslashes($val['project_name']).'</a>';
          }
        }
        echo "'";
        ?>
      );
    }
    var myDropdown = $("#" + id).parent().find('div').attr('id');
    $("#searchInput").val("");
    $("#myDropdown").toggle();
    $(".searchInput").focus();
  }

  //고객사 선택
  function clickCustomerName(customerName, maintainEnd, seq , forcasting_seq) {
    // $("#sortable").find('li').remove();
    $("#customer").val('');
    $("#forcasting_seq").val('');
    $("#maintain_seq").val('');
    var customerCompanyName = ($(customerName).text()).split(' - ')[0];
    var projectName = ($(customerName).text()).split(' - ')[1];
    $("#customerName").val(customerCompanyName);
    $("#project_name").val(projectName);
    $("#customer").val(seq);
    $("#forcasting_seq").val(forcasting_seq);

    if($("#work_name").val() != "납품설치" && $("#work_name").val() != "미팅" && $("#work_name").val() != "데모(BMT)지원" ){
      // test3(document.cform.customer.value,'maintain');
      // if (<?php echo strtotime(date("Y-m-d")) ?> > maintainEnd) {
      //   $("#customer").val('');
      //   $("#customerName").val('');
      //   $("#project_name").val('');
      // }
      //포캐스팅+유지보수
      if(maintainEnd != '0'){
        test3(document.cform.customer.value,'maintain');
        if (<?php echo strtotime(date("Y-m-d")) ?> > maintainEnd) {
          $("#customer").val('');
          $("#customerName").val('');
          $("#project_name").val('');
        }
      }else{
        test3(document.cform.customer.value,'forcasting');
      }
    }else{
      test3(document.cform.customer.value,'forcasting');
    }
    $("#myDropdown").toggle();
  }

  //고객사 입력 검색
  function filterFunction(customerName) {
    // 시리얼 넘버 검색 추가할게융
    $('.serial_row').remove();
    var keyword = $('#searchInput').val();
    if(keyword.length >= 3){
       if($("#work_name").val() == "납품설치" || $("#work_name").val() == "미팅" || $("#work_name").val() == "데모(BMT)지원" ){
         var type = "forcasting";
       }else{
         var type = "maintain";
       }

       $.ajax({
         type:"GET",
         url:"<?php echo site_url(); ?>/tech/tech_board/search_serial",
         dataType:"json",
         data:{
           type: type,
           keyword: keyword
         },
         success: function(data){

          if(type=="forcasting"){
            for (var i = 0; i < data.length; i++) {
              var search_result = "<a class='serial_row' onclick ='clickCustomerName(this,0,"+ data[i].forcasting_seq+", "+data[i].forcasting_seq+")'>"+data[i].customer_companyname+" - " +data[i].project_name+"</a>";

              $('#dropdown_option').append(search_result);
            }
          }else{
            for (var i = 0; i < data.length; i++) {
              // console.log(data);
              var date = "<?php echo strtotime(date('Y-m-d')) ?>";
              var maintain_end = data[i].maintain_end.split('.');
              var maintain_end = maintain_end[0];

              // if(date > maintain_end){
              //   var search_result = "<a style='color:red' class='serial_row' onclick ='clickCustomerName(this,"+maintain_end+", "+ data[i].maintain_seq+", "+data[i].forcasting_seq+")'>"+data[i].customer_companyname+" - " +data[i].project_name+"</a>";
              // }else{
              //   var search_result = "<a class='serial_row' onclick ='clickCustomerName(this,"+maintain_end+", "+ data[i].maintain_seq+", "+data[i].forcasting_seq+")'>"+data[i].customer_companyname+" - " +data[i].project_name+"</a>";
              // }
              //포캐스팅+유지보수
              if(data[i].maintain_seq == null){
                var search_result = "<a class='serial_row' onclick ='clickCustomerName(this,0,"+ data[i].forcasting_seq+", "+data[i].forcasting_seq+")'>"+data[i].customer_companyname+" - " +data[i].project_name+"</a>";
              }else{
                var search_result = "<a class='serial_row' onclick ='clickCustomerName(this,"+maintain_end+", "+ data[i].maintain_seq+", "+data[i].forcasting_seq+")'>"+data[i].customer_companyname+" - " +data[i].project_name+"</a>";
              }
              $('#dropdown_option').append(search_result);
            }

          }
         }
       })

    }
// ///////////////////

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

  // 외부영역 클릭 시 팝업 닫기
  $(document).mouseup(function (e){
    var LayerPopup = $("#dropdown");
    if(LayerPopup.has(e.target).length === 0){
      $("#searchInput").val("");
      $("#myDropdown").hide();
    }
  });

</script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.min.js"></script>
<script>
  //점검 결과 radiobox 값넣기
  var basicFormIdx = <?php echo $basicFormIdx-1 ; ?>;
  $("input:radio[name=normalCheck]").click(function(){normalCheck(this);});
  function normalCheck(check){
    if($(check).is(":checked")== true){
      var testResult = $(check).parent().children().eq(0);
      testResult.val($(check).val());
    }
  }

  //textarea 스크롤바없이 높이 조정
  function xSize(e){
      e.style.height = '1px';
      e.style.height = (e.scrollHeight + 12) + 'px';
  }

  if($("#sign_consent").val()=="true"){
    $("input[name=sign_consent]").prop("checked", true);
  }

  $(document).ready(function () {
    $("#sign_consent").change(function () {
      if ($("#sign_consent").is(":checked")) {
        $("#passwordCheck").val('');
        $("#dialog").dialog({
          open: function(event, ui) {
            $(".ui-dialog-titlebar-close", $(this).parent()).hide();
          },
          buttons: {
            "확인": function () {
              $(this).dialog('close');
              var dialogValue = $("#passwordCheck").val();
              var pw = CryptoJS.SHA1(dialogValue);
              var name = "<?php echo $name ; ?>";

              $.ajax({
                type: "POST",
                cache: false,
                url: "<?php echo site_url(); ?>/ajax/pwcheck",
                dataType: "json",
                async: false,
                data: {
                  name: name
                },
                success: function (data) {
                  if (data.user_password == CryptoJS.enc.Hex.stringify(pw)) {
                    $("#sign_consent").val(true);
                    alert("인증되었습니다");
                  } else {
                    $("input[name=sign_consent]").prop("checked", false);
                    alert("비밀번호가 틀렸습니다")
                  }
                }
              });
            },
            "취소": function () {
              $(this).dialog('close');
              $("input[name=sign_consent]").prop("checked", false);
            }
          }
        });
      } else {
        $("#dialog").dialog('close');
        alert("서명동의 취소");
      }
    });
  });
</script>
<script>
  $("#periodic").hide();
  <?php
  if(isset($schedule)){ ?>
    change();  //일정관리에서 작업명 가져올수도있으니깐 한번실행해줘
  <?php } ?>

  $(document).ready(function(){
    if ($("#customer").val()!=""){
      if ($("#work_name").val() != "납품설치" && $("#work_name").val() != "미팅" && $("#work_name").val() != "데모(BMT)지원"){
        //포캐스팅+유지보수
        if($('#maintain_seq').val() == ''){
          test3($("#customer").val(),'forcasting');
        }else{
          test3($("#customer").val(),"maintain");
        }
      } else {
        test3($("#customer").val(),'forcasting');
      }
    }
  });

  function periodicInspection(){
    //작업명 바뀌면 비워주기
    $("#customerName").val('');
    $("#project_name").val('');
    $("#customer").val('');
    $("#produce").val('');
    $("#version").val('');
    $("#hardware").val('');
    $("#license").val('');
    $("#serial").val('');
    $("#productSeq").val('');
    $("#sortable").empty();

    if($("#work_name option:selected").val()=="정기점검2"){
      $("#nonPeriodic").hide();
      $("#deleteRowBtn").hide();
      $("#addRowBtn").hide();
      $("#periodic").show();
    }else{
      $("#periodic").hide();
      $("#nonPeriodic").show();
      $("#deleteRowBtn").show();
      $("#addRowBtn").show();
    }
  }

  function trPlus(){
    var tableNum = 1;
    var currentTable;
    for(i=0; i < $(".work_text_table").length; i++){
      if($('.work_text_table').eq(i).css("display") != "none"){//display none 아님
        tableNum = $('.work_text_table').eq(i).attr('id').replace("work_text_table","");
        currentTable = tableNum
      }
    }

    var check = [];
    for(i=0; i<$('#work_text_table'+currentTable).find($("[class*='check']")).length; i++){
      check[i]=$('#work_text_table'+currentTable).find($("[class*='check']")).eq(i).attr('class').replace("check","");
    }
    var check_Idx =Number(Math.max.apply(null, check))+1;

    var normalCheck = [];
    for(i=0; i<$('#work_text_table'+currentTable).find($("[name*='produce"+currentTable+"']")).length; i++){
      normalCheck[i]=$('#work_text_table'+currentTable).find($("[name*='produce"+currentTable+"']")).eq(i).attr('name').replace("produce"+currentTable+"_","");
    }
    var normalCheck_idx = Number(Math.max.apply(null, normalCheck))+1;

    var lastTr = $("#work_text_table"+currentTable).find("tr:last").prev();
    lastTr.after('<tr class="check'+check_Idx+'"><td class="tdSolid"><input name="work_text'+check_Idx+'[]" style="width:80%"/><img src="<?php echo $misc; ?>img/btn_minus_white.svg" style="cursor:pointer;width:23px;" class="adddelbtn" onclick="trRemove(this,'+currentTable+');" /></td><td class="tdSolid" colspan="2"><textarea name="work_text'+check_Idx+'[]" onkeyup="xSize(this);" style="width:80%;"></textarea><img src="<?php echo $misc;?>img/dashboard/dash_plus.svg" style="cursor:pointer;" class="tdDivisionBtn" onclick="tdDivision(this,'+check_Idx+');"/></td><td class="tdSolid"> <div style ="margin:0 auto; text-align: -webkit-center;font-weight:normal;"><input type="hidden" name="work_text'+check_Idx+'[]" value="normal"><input type="radio" name="produce'+currentTable+'_'+normalCheck_idx+'" value="normal" onclick="normalCheck(this);" checked="checked">정상<input type="radio" name="produce'+currentTable+'_'+normalCheck_idx+'" value="abnormal" onclick="normalCheck(this);">비정상</div></td><td class="tdSolid"><textarea name="work_text'+check_Idx+'[]" onkeyup="xSize(this);"></textarea><img src="<?php echo $misc; ?>img/dashboard/dash_plus.svg" onclick ="check_add(this,'+currentTable+')" style="cursor:pointer;" /></td></tr>')
  }

  function trRemove(btn,tableNum){
    var thisTr = $(btn).parent().parent();
    var trClass = thisTr.attr("class");
    $('#work_text_table'+tableNum).find($("."+trClass)).remove();
  }

  function tdDivision(btn,num) {
    var td =$(btn).parent();
    btn.remove();
    td.attr("colspan",1);
    var txt = '<td class="tdSolid"><input type="hidden" name="work_text'+num+'[]" value="::">'+td.html()+'<img src="<?php echo $misc;?>img/btn_minus_white.svg" style="cursor:pointer;width:23px;" class="tdDivisionBtn" onclick="tdMerge(this,'+num+');"/></td>';
    $(td).after(txt);
  }

  function tdMerge(btn,num) {
    var td =$(btn).parent();
    btn.remove();
    var txt= $($(td).prev().children('textarea')).val();
    $(td).prev().remove();
    $(td).children('input').remove();
    td.attr("colspan",2);
    $(td).children('textarea').val(txt+$(td).children('textarea').val());
    td.append('<img src="<?php echo $misc;?>img/dashboard/dash_plus.svg" style="cursor:pointer;" class="tdDivisionBtn" onclick="tdDivision(this,'+num+');"/>');
  }

  //점검항목 탬플릿 가져오는 부분
  function template(product, tablenum) {
    if ($("#work_name option:selected").val() == "정기점검2") {
      $.ajax({
        type: "POST",
        cache: false,
        url: "<?php echo site_url(); ?>/tech/tech_board/template",
        dataType: "json",
        async: false,
        data: {
          product: product
        },
        success: function (data) {
          if (data.length) {
            basicFormIdx = 1;
            normalIdx = 1;
            var txt = '<tr><th class="tdSolid" height="30" bgcolor="f8f8f9"><input value="점검항목" readonly onfocus="javascrpt:blur();" style="cursor:default; font-weight:bold; text-align: -webkit-center;background-color:transparent;"></input></th><th colspan="2" height="30" bgcolor="f8f8f9" class="tdSolid"><input value="점검내용" readonly onfocus="javascrpt:blur();" style="cursor:default; font-weight:bold; text-align: -webkit-center;background-color:transparent;"></input></th><th height="30" bgcolor="f8f8f9" class="tdSolid"><input value="점검결과" readonly onfocus="javascrpt:blur();" style="cursor:default; font-weight:bold; text-align: -webkit-center;background-color:transparent;"></input></th><th height="30" bgcolor="f8f8f9" class="tdSolid"><input value="특이사항" readonly onfocus="javascrpt:blur();" style="cursor:default; font-weight:bold; text-align: -webkit-center;background-color:transparent;"></input></th></tr>';
            var process_text = ((data[0].check_list.replace(/(<br>|<br\/>|<br \/>)/g, '\r\n')).replace(";", '')).split('@@');
            for (i = 1; i < process_text.length; i++) {
              var process_text1 = process_text[i].split('#*');
              if (i != 1) {
                process_text1 = process_text[i].split('#*');
                for (j = 1; j < process_text1.length; j++) {
                  if (j == 1) {
                    txt += '<tr class="check' + (i - 1) + '"><td class="tdSolid" rowspan="' + Math.floor((process_text1.length - 1) / 3) + '"><input name="work_text' + (i - 1) + '[]" value="' + process_text1[j] + '" style="width:70%"></input><img src="<?php echo $misc; ?>img/btn_minus_white.svg" style="cursor:pointer;width:23px;" class="adddelbtn" onclick="trRemove(this,' + tablenum + ');" /></td>'; //cpu, 메모리
                  } else if (j <= 4) { //점검항목 중 첫번째 점검내용
                    if (j != 4) {
                      if (j % 3 == 0) {
                        txt += '<td class="tdSolid"><div style="margin:0 auto; text-align: -webkit-center;font-weight:normal;"><input type="hidden" name="work_text' + (i - 1) + '[]" value="' + process_text1[j] + '"><input type="radio" name="produce' + tablenum + "_" + (normalIdx - 1) + '" value="normal" onclick="normalCheck(this);"'
                        if (process_text1[j] == "normal") {
                          txt += 'checked="checked"';
                        }
                        txt += '>정상<input type="radio" name="produce' + tablenum + "_" + (normalIdx - 1) + '" value="abnormal" onclick="normalCheck(this);"'
                        if (process_text1[j] == "abnormal") {
                          txt += 'checked="checked"';
                        }
                        txt += '>비정상</div></td>';
                      } else {
                        if (process_text1[j].indexOf("::") == -1) {
                          txt += '<td class="tdSolid" colspan="2"><textarea name="work_text' + (i - 1) + '[]" onkeyup="xSize(this);">' + process_text1[j] + '</textarea><img src="<?php echo $misc ;?>img/dashboard/dash_plus.svg" style="cursor:pointer;" class="tdDivisionBtn" onclick="tdDivision(this,' + (basicFormIdx - 1) + ');" /></td>';
                        } else {
                          var text = process_text1[j].split('::');
                          txt += '<td class="tdSolid"><textarea name="work_text' + (i - 1) + '[]" onkeyup="xSize(this);">' + text[0] + '</textarea></td>';
                          txt += '<td class="tdSolid"><input type="hidden" name="work_text' + (i - 1) + '[]" value="::"><textarea name="work_text' + (i - 1) + '[]" onkeyup="xSize(this);">' + text[1] + '</textarea><img src="<?php echo $misc ;?>img/btn_23px;_white.svg" style="cursor:pointer;" class="tdDivisionBtn" onclick="tdMerge(this,' + (basicFormIdx - 1) + ');"/></td>';
                        }
                      }
                    } else {
                      txt += '<td class="tdSolid"><textarea name="work_text' + (i - 1) + '[]" onkeyup="xSize(this);">' + process_text1[j] + '</textarea></td>';
                      txt += '<td width="3%" class="t_border adddelbtn"><input type="hidden" name="del_ck" class="input-common"></td><td align="center" class ="adddelbtn" ><img src="<?php echo $misc; ?>img/dashboard/dash_plus.svg" onclick ="check_add(this,' + tablenum + ')" style="cursor:pointer;" /></td></tr>';
                    }
                  } else { //점검 항목 중 첫번 째가 아닌 나머지들
                    if (j % 3 == 2) {
                      if (process_text1[j].indexOf("::") == -1) {
                        txt += '<tr class="check' + (i - 1) + '"><td class="tdSolid" colspan="2"><textarea name="work_text' + (i - 1) + '[]" onkeyup="xSize(this);">' + process_text1[j] + '</textarea><img src="<?php echo $misc;?>img/dashboard/dash_plus.svg" style="cursor:pointer;" class="tdDivisionBtn" onclick="tdDivision(this,' + (basicFormIdx - 1) + ');" /></td>';
                      } else {
                        var text = process_text1[j].split('::')
                        txt += '<tr class="check' + (i - 1) + '"><td class="tdSolid"><textarea name="work_text' + (i - 1) + '[]" onkeyup="xSize(this);">' + text[0] + '</textarea></td>';
                        txt += '<td class="tdSolid"><input type="hidden" name="work_text' + (i - 1) + '[]" value="::"><textarea name="work_text' + (i - 1) + '[]" onkeyup="xSize(this);">' + text[1] + '</textarea><img src="<?php echo $misc ;?>img/btn_minus_white.svg" style="cursor:pointer;width:23px;" class="tdDivisionBtn" onclick="tdMerge(this,' + (basicFormIdx - 1) + ');" /></td>';
                      }
                      normalIdx = normalIdx+1;
                    } else if (j % 3 == 0) {
                      txt += '<td class="tdSolid"><div style="margin:0 auto; text-align: -webkit-center;font-weight:normal;"><input type="hidden" name="work_text' + (i - 1) + '[]" value="' + process_text1[j] + '"><input type="radio" name="produce' + tablenum + "_" + (normalIdx - 1) + '" value="normal" onclick="normalCheck(this);"';
                      if (process_text1[j] == "normal") {
                        txt += 'checked="checked"';
                      }
                      txt += '>정상<input type="radio" name="produce' + tablenum + "_" + (normalIdx - 1) + '" value="abnormal" onclick="normalCheck(this);"'
                      if (process_text1[j] == "abnormal") {
                        txt += 'checked="checked"';
                      }
                      txt += '>비정상</div></td>';
                    } else if (j % 3 == 1) {
                      txt += '<td class="tdSolid"><textarea name="work_text' + (i - 1) + '[]" onkeyup="xSize(this);">' + process_text1[j] + '</textarea></td><td width="3%" class="t_border adddelbtn"><input type="hidden" name="del_ck" ></td><td align="center;" class ="adddelbtn"><img src="<?php echo $misc ;?>img/btn_23px;_white.svg" style="cursor:pointer;" onclick ="check_del(this)" /></td></tr>';
                    }
                  }
                }
              }
              basicFormIdx = basicFormIdx + 1;
              normalIdx =normalIdx+1;
            }
            process_text1 = process_text[1].split('#*');
            for (j = 1; j < process_text1.length; j++) {
              if ((j + 1) != process_text1.length) {
                txt += '<tr class="check0" class="check' + (process_text.length - 1) + '"><td class="tdSolid"><input name="work_text0[]" value="' + process_text1[j] + '"></input></td>';
              } else {
                txt += '<td colspan="4" class="tdSolid"><textarea name="work_text0[]" onkeyup="xSize(this);" >' + process_text1[j] + '</textarea></td></tr>';
              }
            }
            $("#work_text_table" + tablenum).html(txt);
            $("#templateOnOFF" + tablenum).find("#templateOff").css("display", "none");
            $("#templateOnOFF" + tablenum).find("#templateOn").css("display", "block");
            $("#templateOnOFF" + tablenum).find("#checkOnOFF").attr('onclick', '').unbind('click');
            $("#templateOnOFF" + tablenum).find("#checkOnOFF").click();
            $("#templateOnOFF" + tablenum).find("#checkOnOFF").attr('onclick', 'template_check(' + tablenum + ')').unbind('click');
          } else {
            //포캐스팅+유지보수
            //무상보증 만료일 이전인 수주완료상태의 포캐스팅 고객사는 ajax data가 false이기 때문에 기본 template을 제품 개수만큼 열어준다.
            template_check(tablenum);
            return false;
          }
        }
      });
    }
  }

  // 템플릿보여줄꺼야 말꺼야
  function template_check(num){
    if($("#templateOnOFF"+num).find("#templateOff").css("display") == "none"){ //템플릿 OFF
      $("#templateOnOFF"+num).find("#templateOn").toggle();
      $("#templateOnOFF"+num).find("#templateOff").toggle();
      basicFormIdx = 1;
      var data = "기타 특이사항,CPU,메모리,디스크,LAN,UPTIME,SW데몬상태"
      var check = data.split(',');
      var txt ='<tr><th height="30" bgcolor="f8f8f9" class="tdSolid"><input value="점검항목" readonly onfocus="javascrpt:blur();" style="cursor:default; font-weight:bold; text-align: -webkit-center;background-color:transparent;border:none;"></input></th><th colspan="2" height="30" bgcolor="f8f8f9" class="tdSolid"><input value="점검내용" readonly onfocus="javascrpt:blur();" style="cursor:default; font-weight:bold; text-align: -webkit-center;background-color:transparent;border:none;"></input></th><th height="30" bgcolor="f8f8f9" class="tdSolid"><input value="점검결과" readonly onfocus="javascrpt:blur();" style="cursor:default; font-weight:bold; text-align: -webkit-center;background-color:transparent;border:none;"></input></th><th height="30" bgcolor="f8f8f9" class="tdSolid"><input value="특이사항" readonly onfocus="javascrpt:blur();" style="cursor:default; font-weight:bold; text-align: -webkit-center;background-color:transparent;border:none;"></input></th></tr>';
      for(i=1; i<check.length; i++){
        txt += '<tr class="check'+i+'">';
        txt += '<td class="tdSolid"><input name="work_text'+i+'[]" value="'+check[i]+'" readonly onfocus="javascrpt:blur();"style="cursor:default;width:80%;border:none;"><img src="<?php echo $misc; ?>img/btn_minus_white.svg" style="cursor:pointer;width:23px;" class="adddelbtn" onclick="trRemove(this,' + num + ');" /></td><td class="tdSolid" colspan="2"><textarea name="work_text'+i+'[]" onkeyup="xSize(this);" style="width:80%;"></textarea><img src="<?php echo $misc;?>img/dashboard/dash_plus.svg" style="cursor:pointer;" class="tdDivisionBtn" onclick="tdDivision(this,'+i+');"/></td>'
        txt += '<td class="tdSolid"><div style="margin:0 auto; text-align: -webkit-center;font-weight:normal;">';
        txt += '<input type="hidden" name="work_text'+i+'[]" value="normal"><input type="radio" name="produce'+num+"_"+i+'" value="normal" onclick="normalCheck(this);" checked="checked">정상<input type="radio" name="produce'+num+"_"+i+'" value="abnormal" onclick="normalCheck(this);">비정상</div></td>';
        txt += '<td class="tdSolid"><textarea name="work_text'+i+'[]" onkeyup="xSize(this);"></textarea>'
        txt += '<img src="<?php echo $misc; ?>img/dashboard/dash_plus.svg" onclick ="check_add(this,'+num+')" style="cursor:pointer;" /></td>  </tr>';
        basicFormIdx++;
      }
      txt += '<tr class="check0" height="80"><td class="tdSolid"><input name="work_text0[]" value= "기타 특이사항" style="border:none;" readonly onfocus="javascrpt:blur();"></td><td colspan="4"><textarea name="work_text0[]" rows="5" style="width:95%;"></textarea></td></tr>';
      $("#work_text_table"+num).html(txt);
    }else{//템플릿 ON
      $("#templateOnOFF"+num).find("#templateOn").toggle();
      $("#templateOnOFF"+num).find("#templateOff").toggle();
      template($("#currentProduce").val(),num);
    }
  }

  //textarea height 글자수에 맞게 늘려주는 거
  function textareaSize(){
    var textarea = document.getElementsByTagName("textarea");
    for (var i = 0; i < textarea.length; i++) {
      if (textarea[i].value != '') {
        textarea[i].style.height = '1px';
        textarea[i].style.height = (textarea[i].scrollHeight) + 'px';
      }
    }
  }

  //점검항목 2 제품 여러개일 때
  function createTable(num,max){
    if($("#work_name option:selected").val()=="정기점검2"){
      $("#leftBtn").show();
      $("#rightBtn").show();
      var txt='';
      var templateOnOff='';
      if(!max){
        for(i=1; i <= num; i++){
          txt += '<table id="work_text_table'+i+'" width=100% border=1 class ="work_text_table" style="border-collapse:collapse;border:none;display:none"></table>';
          templateOnOff += '<span id="templateOnOFF'+i+'" class="templateOnOFF" style="display:none;"><label class="switch"><input id="checkOnOFF" type="checkbox" onclick="template_check('+i+')"><span class="slider round"></span></label><p id="templateOff" class="onoff">TEMPLATE OFF</p><p id="templateOn" class="onoff" style="display:none;">TEMPLATE ON</p></span>';
        }
      }else{
        max = max+1;
        for(i=max; i<max+num; i++){
          txt += '<table id="work_text_table'+i+'" width=100% border=1 class="work_text_table" style="border-collapse:collapse;border:none;display:none"></table>';
          templateOnOff += '<span id="templateOnOFF'+i+'" class="templateOnOFF" style="display:none;"><label class="switch"><input id="checkOnOFF" type="checkbox" onclick="template_check('+i+')"><span class="slider round"></span></label><p id="templateOff" class="onoff">TEMPLATE OFF</p><p id="templateOn" class="onoff" style="display:none;">TEMPLATE ON</p></span>';
        }
      }
      $("#trPlusBtn").before(txt);

      if($(".templateOnOFF").length == 0){
        $("#trPlusBtn").after(templateOnOff);
      }else{
        $(".templateOnOFF").last().after(templateOnOff)
      }

      $('.click_produce').eq(0).css("color","red");
      $('.work_text_table').eq(0).show();
      $(".templateOnOFF").eq(0).show();
    }
  }

  //제품명 클릭 할때
  function clickProduce(i,produceSeq){
    if($("#work_name option:selected").val()=="정기점검2"){
      $("#currentProduce").val(produceSeq);
      $("#currentPage").val(i);
      $(".work_text_table").hide();
      $(".click_produce").css('color','black');
      $('.templateOnOFF').hide();

      $('#work_text_table'+i).show();
      $("#produce"+i).css('color','red');
      $('#templateOnOFF'+i).show();

      textareaSize();
    }
  }

  // 이전,다음 제품 (버튼 <,>) 누를 때
  function changePage(direction){
    var currentTable = '';
    var nextTable = '';
    var prevTable ='';

    for(i=0; i<$(".work_text_table").length; i++){
      if($(".work_text_table").eq(i).css("display") != "none"){
      currentTable = $(".work_text_table").eq(i).attr('id')
      }
    }

    currentNum = currentTable.replace("work_text_table","");

    if(direction == "left"){
      prevTable = $("#"+currentTable).prev().attr('id');
      if(prevTable == undefined){
        alert("이전 제품이 없습니다.");
      }else{
        var prevNum = prevTable.replace("work_text_table","");
        $("#"+currentTable).hide();
        $("#"+prevTable).show();
        $("#produce"+currentNum).css("color","black");
        $("#produce"+prevNum).css("color","red");
        $('#templateOnOFF'+currentNum).hide();
        $('#templateOnOFF'+prevNum).show();
      }
    }else{
      nextTable = $("#"+currentTable).next().attr('id');
      if(nextTable == "trPlusBtn"){
        alert("다음 제품이 없습니다.");
      }else{
        var nextNum = nextTable.replace("work_text_table","");
        $("#"+currentTable).hide();
        $("#"+nextTable).show();
        $("#produce"+currentNum).css("color","black");
        $("#produce"+nextNum).css("color","red");
        $('#templateOnOFF'+currentNum).hide();
        $('#templateOnOFF'+nextNum).show();
      }
    }
    textareaSize();
  }

  function tableRemove(){
    $(".work_text_table").remove();
    $(".templateOnOFF").remove();
  }

  function produceRemove(num){
    if($("#work_name option:selected").val() == "정기점검2"){
      if($("#work_text_table"+num).css("display") != "none"){
        $("#li"+num).remove();
        $("#work_text_table"+num).remove();
        $("#templateOnOFF"+num).remove();
        $('.click_produce').eq(0).css("color","red");
        $('.work_text_table').eq(0).show();
        $(".templateOnOFF").eq(0).show();
      }else{
        $("#li"+num).remove();
        $("#work_text_table"+num).remove();
      }
    }else{
      $("#li"+num).remove();
    }
    textareaSize();
  }

  function fileRemove(){
    $(".file_span").text('');
  }

 function escapeHtml(unsafe) {
    return unsafe
         .replace(/&/g, "&amp;")
         .replace(/</g, "&lt;")
         .replace(/>/g, "&gt;")
         .replace(/"/g, "&quot;")
         .replace(/'/g, "&#039;");
 }

  //sortable
  $("#sortable").sortable({
    update: function(event, ui) {
      var liArray = $("#sortable").sortable('toArray', {attribute: 'id'});
      var id = ui.item.attr("id");
      var changeTarget = liArray.indexOf(id);

      if(id != 0){
        var insertAfter = liArray[changeTarget-1];
        id = id.replace("li","");
        if(insertAfter == undefined){
          var insertBefore = liArray[changeTarget+1];
          insertBefore = insertBefore.replace("li","");
          $("#work_text_table"+id).insertBefore($("#work_text_table"+insertBefore));
        }else{
          insertAfter = insertAfter.replace("li","");
          $("#work_text_table"+id).insertAfter($("#work_text_table"+insertAfter));
        }
      }
    }
  });


//시간 24시간 형식으로 가져오는고
  $(function () {
    var month = (new Date()).getMonth() + 1;
    var year = (new Date()).getFullYear();
    $('input[type=eu-time]').w2field('time', {
      format: 'h24'
    });
  });

  function change_w2field(){
    var month = (new Date()).getMonth() + 1;
    var year = (new Date()).getFullYear();
    $('input[type=eu-time]').w2field('time', {
      format: 'h24'
    });
  }


  //skb 유통망 과금망일때 serial 직접입력
  function serialInput(){
    if((trim($("#customerName").val()) == "SKB(유통망)" || trim($("#customerName").val()) == "SKB(과금망)") && $(".produce").length == 1){
      $("#serial_value").val("");
      $("#serial_value").show();
    }else{
      $("#serial_value").hide();
    }
  }

  function serialChange(){
    $(".serial").eq(0).text($("#serial_value").val());
  }

  function file_change(el) {
    console.log(el)
		var filename = $(el).val().replace(/.*(\/|\\)/, '') + '&emsp;<input type="button" value="×" style="color:red;cursor:pointer;border:none;background-color:#FFEDED;" onclick="fileRemove()" />';
    console.log(filename);
    if(filename == "") {
	    filename = "파일을 선택해주세요.";
		}
	  $(el).closest("div").find(".file_span").html(filename);
    $(el).closest("div").find(".text_span").text('');
	}

</script>
</html>
