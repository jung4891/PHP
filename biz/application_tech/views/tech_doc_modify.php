<?php
include $this->input->server('DOCUMENT_ROOT') . "/include/base.php";
include $this->input->server('DOCUMENT_ROOT') . "/include/customer_top.php";
$g_member = array();
foreach($group_member as $member){
  array_push( $g_member, $member['user_name'] );
}

// 수정 권한
if(substr($at,0,1) != 1 && substr($at,0,1) != 3 && substr($at,0,1) != 5 && substr($at,0,1) != 7){ //본인 수정 권한 x
  if ($view_val['writer'] == $name){
    echo "<script>alert('본인 글에 수정 권한이 없습니다.');history.go(-1);</script>";
    echo exit;
  }else{
    if(substr($at,1,1) != 1 && substr($at,1,1) != 3 && substr($at,1,1) != 5 && substr($at,1,1) != 7){//같은팀 수정 권한 없음
      if (in_array($view_val['writer'], $g_member)) {//같은팀
        echo "<script>alert('같은 부서 사용자 글에 수정 권한이 없습니다.');history.go(-1);</script>";
        echo exit;
      }else{// 같은팀x
        if(substr($at,2,1) != 1 && substr($at,2,1) != 3 && substr($at,2,1) != 5 && substr($at,2,1) != 7){
          echo "<script>alert('다른 사용자 글에 수정 권한이 없습니다.');history.go(-1);</script>";
          echo exit;
        }
      }
    }else{
      if(substr($at,2,1) != 1 && substr($at,2,1) != 3 && substr($at,2,1) != 5 && substr($at,2,1) != 7){
        if(!in_array($view_val['writer'], $g_member)){
          echo "<script>alert('다른 사용자 글에 수정 권한이 없습니다.');history.go(-1);</script>";
          echo exit;
        }
      }
    }
  }
}else{
  if ($view_val['writer'] != $name){
    if(substr($at,1,1) != 1 && substr($at,1,1) != 3 && substr($at,1,1) != 5 && substr($at,1,1) != 7){//같은팀 수정 권한 없음
      if (in_array($view_val['writer'], $g_member)) {//같은팀
        echo "<script>alert('같은 부서 사용자 글에 수정 권한이 없습니다.');history.go(-1);</script>";
        echo exit;
      }else{// 같은팀x
        if(substr($at,2,1) != 1 && substr($at,2,1) != 3 && substr($at,2,1) != 5 && substr($at,2,1) != 7){
          echo "<script>alert('다른 사용자 글에 수정 권한이 없습니다.');history.go(-1);</script>";
          echo exit;
        }
      }
    }else{
      if(substr($at,2,1) != 1 && substr($at,2,1) != 3 && substr($at,2,1) != 5 && substr($at,2,1) != 7){
        if(!in_array($view_val['writer'], $g_member)){
          echo "<script>alert('다른 사용자 글에 수정 권한이 없습니다.');history.go(-1);</script>";
          echo exit;
        }
      }
    }
  }
}
?>

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

  /* The search field */
  .searchInput {
    box-sizing: border-box;
    background-position: 14px 12px;
    background-repeat: no-repeat;
    font-size: 16px;
    padding: 14px 20px 12px 45px;
    border: none;
    border-bottom: 1px solid #ddd;
  }

  /* The search field when it gets focus/clicked on */
  .searchInput:focus {
    outline: 3px solid #ddd;
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

  /* Show the dropdown menu (use JS to add this class to the .dropdown-content container when the user clicks on the dropdown button) */
  .show {
    display: block;
  }

  .work_text_table
  textarea {font-family:'Nanum Gothic', '나눔고딕', Tahoma, 'Georgia', '맑은 고딕', sans-serif; line-height:150%; font-size:12px; color:#333; border:none; border-right:0px; border-top:0px; border-left:0px; border-bottom:0px; width:80%; height:20px; overflow-y:hidden; resize: none;} input{border:none; border-right:0px; border-top:0px; border-left:0px; border-bottom:0px;}

  #trPlusBtn{
    margin-top: 10px;
  }

  .adddelbtn {
    border: none;
    border-right: 0px;
    border-top: 0px;
    border-left: 0px;
    border-bottom: 0px;
    margin: 0px;
    padding: 0px;
    float:right;
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

  p {
    margin:0px;
    display:inline-block;
    font-size:9px;
    font-weight:bold;
  }
  .tdDivisionBtn{
    float:right;
  }
  .tdSolid {
    border-left :none;
    border-right:1.5px solid;
    border-color: #ddd;
  }
</style>
<!-- 시간 24시간 형식으로 가져오는거 -->
<link rel="stylesheet" href="<?php echo $misc; ?>css/w2ui.css" type="text/css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript" src="http://w2ui.com/src/w2ui-1.4.min.js"></script>

<link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" ></script>
<script language="javascript">
  //장비 정보 가져오는 함수

  var err_mode = 1;
  var k = 26; //지원내역부분이 추가될 Index
  var row_min = 37; //지원내역이 1개 이상 있을 row 조건

  var table = null;
  var rowCount = null;
  var row = null;
  var row_count = null;
  var childPage='';

  $(function() {
    $("#main_add").click(function() {
      $("#row_max_index").val(Number(Number($("#row_max_index").val()) + Number(1)));
      var id = "main_insert_field_" + $("#row_max_index").val();
      $('#manager_input_field').before("<tr id=" + id + "><td colspan='2' width='15%' height='40' align='center' bgcolor='f8f8f9' style='font-weight:bold;'class='t_border' >담당자명</td><td width='35%' style='padding:10px;' class='t_border'><input type='text' name='customer_manager' id='customer_manager' class='input2'/><input type='hidden' name='maintain_end' id='maintain_end' class='input2'/></td><td width='15%' height='40' align='center' bgcolor='f8f8f9' style='font-weight:bold;' class='t_border'>이메일</td><td width='35%' style='padding:10px;' class='t_border'><input type='text' name='manager_mail' id='manager_mail' class='input2'></td><td width='3%' style='padding:10px;' class='t_border'><input type='hidden' name='del_ck' id='del_ck'></td><td align='left'><img src='<?php echo $misc; ?>img/btn_del0.jpg' style='cursor:pointer;' onclick='javascript:main_list_del(" + $("#row_max_index").val() + ");'></td></tr>");
    });
  });

  function main_list_del(idx) {
    $("#line_field_" + idx).remove();
    $("#main_insert_field_" + idx).remove();
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
    if($('#work_text_table'+tableNum).find($(".check"+nextTr)).length != 0){
      $('#work_text_table'+tableNum).find($(".check"+nextTr)).eq(0).before('<tr class="'+trClass+'"><td class="tdSolid" colspan="2"><textarea name="work_text'+trNum+'[]" onkeyup="xSize(this);" style="width:80%;"></textarea><img src="<?php echo $misc;?>img/btn_add.jpg" style="cursor:pointer;" class="tdDivisionBtn" onclick="tdDivision(this,'+trNum+');"/></td><td class="tdSolid"> \
      <div style="margin:0 auto; text-align: -webkit-center;font-weight:normal;">\
      <input type="hidden" name="work_text'+trNum+'[]" value="normal">\
      <input type="radio" name="produce'+tableNum+'_'+normalCheck_idx+'" value="normal" onclick="normalCheck(this);" checked="checked">정상\
      <input type="radio" name="produce'+tableNum+'_'+normalCheck_idx+'" value="abnormal" onclick="normalCheck(this);">비정상\
      </div></td>\
      <td class="tdSolid"><textarea name="work_text'+trNum+'[]" onkeyup="xSize(this);"></textarea></td>\
      <td width="3%" class="t_border adddelbtn"><input type="hidden" name="del_ck" id="del_ck"></td> \
      <td align="center;" class ="adddelbtn"><img src="<?php echo $misc; ?>img/btn_del0.jpg" style="cursor:pointer;" onclick ="check_del(this)" /></td></tr>');
    }else{
      $('#work_text_table'+tableNum).find($(".check0")).before('<tr class="'+trClass+'"><td class="tdSolid" colspan="2"><textarea name="work_text'+trNum+'[]" onkeyup="xSize(this);" style="width:80%;"></textarea><img src="<?php echo $misc;?>img/btn_add.jpg" style="cursor:pointer;" class="tdDivisionBtn" onclick="tdDivision(this,'+trNum+');"/></td><td class="tdSolid"> \
      <div style="margin:0 auto; text-align: -webkit-center;font-weight:normal;">\
      <input type="hidden" name="work_text'+trNum+'[]" value="normal">\
      <input type="radio" name="produce'+tableNum+'_'+normalCheck_idx+'" value="normal" onclick="normalCheck(this);" checked="checked">정상\
      <input type="radio" name="produce'+tableNum+'_'+normalCheck_idx+'" value="abnormal" onclick="normalCheck(this);">비정상\
      </div></td>\
      <td class="tdSolid"><textarea name="work_text'+trNum+'[]" onkeyup="xSize(this);"></textarea></td>\
      <td width="3%" class="t_border adddelbtn"><input type="hidden" name="del_ck" id="del_ck"></td> \
      <td align="center;" class ="adddelbtn"><img src="<?php echo $misc; ?>img/btn_del0.jpg" style="cursor:pointer;" onclick ="check_del(this)" /></td></tr>');
    }

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

  window.onload = function() {
    if (document.getElementById("work_name").value != "장애지원") {
      change();
    }
    var i = 0;
    var work_text = document.getElementsByName("work_text[]");
    var comment = document.getElementById("comment");

    for (i; i < work_text.length; i++) {
      work_text[i].value = work_text[i].value.replace(/<br\/>/g, "\n");
    }
    document.getElementById("comment").value = comment.value.replace(/<br\/>/g, "\n");
  };

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


  function filedel(seq, filename) {
    if (confirm("정말 삭제하시겠습니까?") == true) {
      location.href = "<?php echo site_url(); ?>/tech_board/tech_doc_filedel/" + seq + "/" + filename;
      return false;
    }
  }

  function change() {

    var work_name = document.getElementById("work_name").selectedIndex;

    if (work_name == 4 && err_mode == 0) {

      tmp = document.getElementById("tmp_table");
      // rowCount = table.rows.length;
      table = document.getElementById("input_table");

      row = table.insertRow(7);
      row.innerHTML = tmp.rows[0].innerHTML;
      row = table.insertRow(8);
      row.innerHTML = tmp.rows[1].innerHTML;
      row = table.insertRow(9);
      row.innerHTML = tmp.rows[2].innerHTML;
      row = table.insertRow(10);
      row.innerHTML = tmp.rows[3].innerHTML;

      row_min = row_min + 4;
      k = k + 4;
      err_mode = 1;

    } else if (work_name != 4 && err_mode == 1) {

      table = document.getElementById("input_table");

      for (var i = 0; i < 4; i++) {
        table.deleteRow(7);
      }
      row_min = row_min - 4;
      k = k - 4;
      err_mode = 0;
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
      }
      if(!add){
        childPage= window.open('/index.php/tech_board/search_device?name=' + name +'&mode='+mode,'_blank');
      }else{
        childPage= window.open('/index.php/tech_board/search_device?name=' + name +'&mode='+mode+'&type='+add,'_blank');
      }
    }
  }

  //담당 SE 가져오는 함수
  function test2() {
    var settings = 'height=500,width=1000,left=0,top=0';
    window.open('/index.php/tech_board/search_se', '_blank');
  }

  // 고객사 담당자 가져오는 함수
  function test3(name,mode) {
    var settings = 'height=500,width=1000,left=0,top=0';
    var popup = window.open('/index.php/tech_board/search_manager?name=' + name+'&mode='+mode, '_blank');
    window.focus();
  }

  /// 제출전 확인할것들
  var chkForm = function() {
    var mform = document.cform;

    if((trim(mform.customerName.value) == "SKB(유통망)" || trim(mform.customerName.value) == "SKB(과금망)") && $(".produce").length == 1){
      if($("#serial_value").val()==""){
        $("#serial_value").focus();
        alert("serial 번호를 직접 입력해주세요.");
        return false
      }
    }

    if (mform.start_time.value == "") {
      mform.start_time.focus();
      alert("시작시간을 입력해주세요.");
      return false
    }

    if (mform.end_time.value == "") {
      mform.end_time.focus();
      alert("종료시간을 입력해주세요.");
      return false
    }

    var start_date = getFormatDate(new Date()).split('-');
    var start_time = mform.start_time.value.split(':');
    var end_time = mform.end_time.value.split(':');
    var total_hour;

    //date format 함수
    function getFormatDate(date) {
      var year = date.getFullYear(); //yyyy
      var month = (1 + date.getMonth()); //M
      month = month >= 10 ? month : '0' + month; //month 두자리로 저장
      var day = date.getDate(); //d
      day = day >= 10 ? day : '0' + day; //day 두자리로 저장
      return year + '-' + month + '-' + day; //'-' 추가하여 yyyy-mm-dd 형태 생성 가능
    }

    if(start_time[0] >= 12 && end_time[0] <12){//시작시간이 오후인데 종료시간이 오전이면? 날짜가 바뀐거지
      var test = new Date();
      test.setDate(test.getDate()+1)
      var end_date = getFormatDate(test).split('-');
      var time1 = new Date(start_date[0],start_date[1],start_date[2],start_time[0],start_time[1]);
      var time2 = new Date(end_date[0],end_date[1],end_date[2],end_time[0],end_time[1]);
      total_hour = (time2 - time1)/ 1000 / 60 / 60;
    }else{//시작하는시간 종료시간 날짜 같음
      var time1 = new Date(start_date[0],start_date[1],start_date[2],start_time[0],start_time[1]);
      var time2 = new Date(start_date[0],start_date[1],start_date[2],end_time[0],end_time[1]);
      total_hour = (time2 - time1)/ 1000 / 60 / 60;
    }

    if(time2 - time1 < 0){
      var result = confirm("작업 종료시간이 작업 시작시간 보다 빠릅니다. 올바르게 입력하셨나요?");
      if(!result){
        $("#start_time").focus();
        return false;
      }
    }

    if(total_hour >= 12){
      var result = confirm("작업시간이 12시간 이상입니다. 올바르게 입력하셨나요?");
      if(!result){
        $("#start_time").focus();
        return false;
      }
    }

    merge_email();

    // if (mform.produce.value == "") {
    //   mform.produce.focus();
    //   alert("장비/시스템을 입력해주세요.");
    //   return false
    // }

    // if (mform.customer.value == "") {
    //   mform.customer.focus();
    //   alert("고객사(등록Site)정보를 입력해주세요.");
    //   return false
    // }

    // if($("#sign_consent").val() != "true"){
    //   alert("확인서명을 해주세요.")
    //   return false
    // }

    var work_text = document.getElementsByName('work_text[]');
    var comment = document.getElementById("comment");
    var str = "";
    var i = 0;

    if($("#work_name option:selected").val() != "정기점검2"){
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
      for(i=0; i < $(".produce").length; i++){
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

  function addRow() {
    var addText = '<tr class="addRow"><td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border"><input type="text" name="work_time_s[]"  id="work_time_s" size="2"></td><td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;"><input type="text" name="work_time_e[]" id="work_time_e" size="2"></td><td colspan="6" height="40" style="font-weight:bold; padding: 12px;" class="t_border" id="work_test_field"><textarea rows="5" style="width:95%; max-width:720px;" name="work_text[]" id="work_text">';
    addText += '담당자 : 두리안정보기술 홍길동 대리, 연락처 : 010-1234-5678, 이메일 : gdhong@durianit.co.kr \n';
    addText += '담당자 : 더 망고 이영희 사원 , 연락처 : 010-3456-7890, 이메일 : yhlee@mango.co.kr \n ';
    addText += '\n업무목적 : 기술지원한 목적을 작성 해주세요. \n';
    addText += '대상장비: 기술지원한 장비명을 작성해주세요. (S/N : xxxxxxx, Version : v.1.0) \n';
    addText += '</textarea></td></tr>';
    $(".addRow").last().after(addText);
  }

  function deleteRow(tableID) {
    if($(".addRow").length == 1){
      alert("적어도 하나의 지원내역이 필요합니다.");
    }else{
      $(".addRow").last().remove();
    }
  }

</script>

<body>
  <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
    <script src="<?php echo $misc; ?>ckeditor/ckeditor.js"></script>
    <?php
      include $this->input->server('DOCUMENT_ROOT')."/include/tech_header.php";
    ?>
    <tr>
      <td align="center" valign="top">

        <table width="1130" height="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td><img src="<?php echo $misc; ?>img/btn_left.jpg" id="leftBtn" style="cursor:pointer;display:none;float:right;" onclick="changePage('left')"/></td>
            <td width="923" align="center" valign="top">

              <!-- 시작합니다. 여기서 부터  -->

              <form name="cform" action="<?php echo site_url(); ?>/tech_board/tech_doc_input_action" method="post" enctype="multipart/form-data" onSubmit="javascript:chkForm();return false;">
                <input type="hidden" name="seq" value="<?php echo $seq; ?>">
                <input type="hidden" name="customer_tmp" value="<?php echo $view_val['customer']; ?>">
                <input type="hidden" name="forcasting_seq" value="<?php echo $view_val['forcasting_seq']; ?>">
                <input type="hidden" name="maintain_seq" value="<?php echo $view_val['maintain_seq']; ?>">
                <table width="890" border="0" style="margin-top:20px;">
                  <tr>
                    <td class="title3">기술지원보고서 등록/수정</td>
                    <!-- //KI1 -->
                    <script type="text/javascript">
                    $(function(){
                        var sessionSchSeq = sessionStorage.getItem("schedule_seq");
                        // alert(sessionSchSeq);
                        sessionStorage.removeItem("schedule_seq");
                        if(sessionSchSeq == null){
                          // alert(1);
                          $('#schedule_seq').val(<?php echo $view_val['schedule_seq'] ?>);
                        }else{
                          $('#schedule_seq').val(sessionSchSeq);
                        }
                    });

                    </script>
                    <input type="hidden" id="schedule_seq" name="schedule_seq" value="" >
                    <!-- //KI2 -->
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>
                      <table id="input_table" width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td colspan="5" height="2" bgcolor="#797c88"></td>
                        </tr>
                        <tr>
                        <tr>
                          <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">작업명(종류)</td>
                          <td width="35%" style="padding-left:10px;" class="t_border">
                            <select name="work_name" id="work_name" class="input2" onChange="change();periodicInspection();">
                              <option value="정기점검">정기점검</option>
                              <option value="정기점검2">정기점검2</option>
                              <option value="교육지원">교육지원</option>
                              <option value="교육참석">교육참석</option>
                              <option value="장애지원">장애지원</option>
                              <option value="설치지원">설치지원</option>
                              <option value="기술지원">기술지원</option>
                              <option value="납품설치">납품설치</option>
                              <option value="미팅">미팅</option>
                              <option value="데모(BMT)지원">데모(BMT)지원</option>
                            </select>
                            <script language="javascript">
                              var work_name_s = document.getElementById("work_name");
                              for (i = 0; i < work_name_s.options.length; i++) {
                                if (work_name_s.options[i].value == '<?php echo $view_val['work_name']; ?>') {
                                  work_name_s.options[i].selected = true;
                                  break;
                                }
                              }
                            </script>
                          </td>
                          
                          <td idth="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">등록자</td>
                          <td width="35%" align="center" class="t_border"><input type="hidden" id="writer" name="writer" value="<?php echo $view_val['writer']; ?>"><?php echo $view_val['writer']; ?></td>
                        </tr>
                        <tr>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                          <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">고객사</td>
                            <td width="35%" style="padding-left:10px;" class="t_border">
                              <div class="dropdown" id="dropdown">
                                <p onclick="searchFunction(this.id)" id="dropbtn" class="dropbtn">검색</p>
                                <input id="customerName" type="text" name="customerName" class="input5" value="<?php echo $view_val['customer'] ?>" style="border:none;width:200px;font-weight:bold;text-align:center;" readonly>
                                <input type="hidden" id="customer" name="customer" value="<?php if($view_val['work_name']=="납품설치" || $view_val['work_name']=="미팅" || $view_val['work_name']=="데모(BMT)지원"){echo $view_val['forcasting_seq'];}else{echo $view_val['maintain_seq'];} ?>" style="border:none" readonly>
                                <div id="myDropdown" class="dropdown-content">
                                  <input type="text" name="0" placeholder="고객사를 입력하세요" id="searchInput" class="searchInput" onkeyup="filterFunction(this)" ;>
                                  <div id="dropdown_option" style="overflow:scroll; width:277px; height:300px;">
                                    <?php
                                    foreach ($customer  as $val) {
                                      if (strtotime(date("Y-m-d")) > strtotime(date($val['maintain_end']))) {
                                        echo '<a style="color:red;" ';
                                        echo 'onclick ="clickCustomerName(this,' . strtotime(date($val['maintain_end'])) . ',' . $val['maintain_seq'].','.$val['forcasting_seq'].')" >'. $val['customer'].' - '.$val['project_name'].'</a>';
                                      } else {
                                        echo '<a ';
                                        echo 'onclick ="clickCustomerName(this,' . strtotime(date($val['maintain_end'])) . ',' . $val['maintain_seq'].','.$val['forcasting_seq'].')" >' . $val['customer'].' - '.$val['project_name'].'</a>';
                                      }
                                    }
                                    ?>
                                  </div>
                                </div>
                              </div>
                            </td>
                            <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">작업일</td>
                            <td width="35%" style="padding-left:10px;" class="t_border"><input type="date" name="income_time" id="income_time" class="input2" value="<?php echo substr($view_val['income_time'], 0, 10); ?>"></td>
                        </tr>
                        <tr>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                          <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">프로젝트명</td>
                          <td width="35%" style="padding-left:10px;" class="t_border">
                            <input name="project_name" id="project_name" class="input2" value="<?php echo $view_val['project_name']; ?>" readonly>
                          </td>
                          <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">표지/로고</td>
                          <td width="35%" style="padding-left:10px;" class="t_border">
                            <select name="cover" id="cover" class="input2">
                              <option value="basic" <?php if($view_val['cover'] == "basic"){echo "selected";};?>>기본</option>
                              <?php
                                foreach($cover as $co){
                                  echo "<option value='{$co['seq']}'";
                                  if($view_val['cover'] == $co['seq']){echo "selected";}
                                  echo ">{$co['cover_name']}</option>";
                                }
                              ?>
                            </select>
                            <select id="logo" name="logo" class="input2">
                             <?php
                              foreach($logo as $lo){
                                echo "<option value='$lo'";
                                if($view_val['logo'] == $lo){echo "selected";}
                                echo ">$lo</option>";
                              }
                             ?>
                           </select>
                          </td>
                        </tr>
                        <tr id="err_row1">
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr id="err_row2">
                          <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">장애구분</td>
                          <td width="35%" style="padding-left:10px;" class="t_border">
                            <select name="err_type" id="err_type" class="input2">
                              <option value="HW">HW</option>
                              <option value="SW">SW</option>
                            </select>
                            <script language="javascript">
                              var err_type_s = document.getElementById("err_type");
                              for (i = 0; i < err_type_s.options.length; i++) {
                                if (err_type_s.options[i].value == '<?php echo $view_val['err_type']; ?>') {
                                  err_type_s.options[i].selected = true;
                                  break;
                                }
                              }
                            </script>
                          </td>
                          <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">심각도</td>
                          <td width="35%" style="padding-left:10px;" class="t_border">
                            <select name="warn_level" id="warn_level" class="input2">
                              <option value="001">전체서비스중단</option>
                              <option value="002">일부서비스중단/서비스지연</option>
                              <option value="003">관리자불편/대고객신뢰도저하</option>
                              <option value="004">특정기능장애</option>
                              <option value="005">서비스무관단순장애</option>
                            </select>
                          </td>
                          <script language="javascript">
                            var warn_level_s = document.getElementById("warn_level");
                            for (i = 0; i < warn_level_s.options.length; i++) {
                              if (warn_level_s.options[i].value == '<?php echo $view_val['warn_level']; ?>') {
                                warn_level_s.options[i].selected = true;
                                break;
                              }
                            }
                          </script>
                        </tr>
                        <tr id="err_row3">
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr id="err_row4">
                          <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">장애유형</td>
                          <td width="35%" style="padding-left:10px;" class="t_border">
                            <select name="warn_type" id="warn_type" class="input2">
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
                          <script language="javascript">
                            var warn_type_s = document.getElementById("warn_type");
                            for (i = 0; i < warn_type_s.options.length; i++) {
                              if (warn_type_s.options[i].value == '<?php echo $view_val['warn_type']; ?>') {
                                warn_type_s.options[i].selected = true;
                                break;
                              }
                            }
                          </script>
                          <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">장애처리방법</td>
                          <td width="35%" style="padding-left:10px;" class="t_border">
                            <select name="work_action" id="work_action" class="input2">
                              <option value="001">기타지원</option>
                              <option value="002">설정지원</option>
                              <option value="003">장비교체</option>
                              <option value="004">업그레이드</option>
                              <option value="005">패치</option>
                              <option value="006">협의중</option>
                            </select></td>
                          <script language="javascript">
                            var work_action_s = document.getElementById("work_action");
                            for (i = 0; i < work_action_s.options.length; i++) {
                              if (work_action_s.options[i].value == '<?php echo $view_val['work_action']; ?>') {
                                work_action_s.options[i].selected = true;
                                break;
                              }
                            }
                          </script>
                        </tr>


                        <?php

                        $arr_manager = explode(';', $view_val['customer_manager']);
                        $arr_mail = explode(';', $view_val['manager_mail']);
                        ?>
                        <input type="hidden" id="row_max_index" name="row_max_index" value="<?php echo count($arr_manager) - 1; ?>" />

                        <?php
                        for ($i = 0; $i < count($arr_manager); $i++) {
                          if ($arr_manager[$i] != "") {
                        ?>
                            <tr id="line_field_<?php echo $i; ?>">
                              <td colspan="5" height="1" bgcolor="#e8e8e8" class="t_border"></td>
                            </tr>
                            <tr id="main_insert_field_<?php echo $i; ?>">
                              <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">담당자명</td>
                              <td width="35%" style="padding:10px;" class="t_border" class="t_border">
                                <input type="text" name="customer_manager" id="customer_manager" class="input2" value="<?php echo $arr_manager[$i] ?>">
                                <input type='hidden' name='maintain_end' id='maintain_end' class='input2' />
                              </td>
                              <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">이메일</td>
                              <td width="35%" style="padding:10px;" class="t_border">
                                <input type="text" name="manager_mail" id="manager_mail" class="input2" value="<?php echo $arr_mail[$i] ?>">
                              </td>
                              <?php if ($i == 0) { ?>
                                <td align="center"><img src="<?php echo $misc; ?>img/btn_add.jpg" id="main_add" name="main_add" style="cursor:pointer;" /></td>
                              <?php } else { ?>
                                <td align="center"><img src='<?php echo $misc; ?>img/btn_del0.jpg' style='cursor:pointer;' onclick='javascript:main_list_del(<?php echo $i; ?>);'></td>

                              <?php } ?>
                            </tr>
                        <?php  }
                        }
                        ?>
                        <tr id="manager_input_field">
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                          <td colspan="2" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">시작시간</td>
                          <td style="padding-left:10px;" class="t_border">
                            <input type="eu-time" name="start_time" id="start_time" class="input2" value="<?php echo substr($view_val['start_time'],0,5); ?>" autocomplete="off" />
                          </td>
                          <td align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">종료시간</td>
                          <td style="padding:10px;" class="t_border">
                            <input type="eu-time" name="end_time" id="end_time" class="input2" value="<?php echo substr($view_val['end_time'],0,5); ?>" autocomplete="off" />
                          </td>
                        </tr>
                        <tr>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                          <td colspan="2" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">담당SE</td>
                          <td style="padding-left:10px;" class="t_border">
                            <input type="text" name="engineer" id="engineer" class="input2" value="<?php echo $view_val['engineer']; ?>" onclick="test2();" readonly>
                          </td>
                          <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">지원방법</td>
                          <td width="35%" style="padding-left:10px;" class="t_border">
                            <select name="handle" id="handle" class="input2">
                              <option value="현장지원">현장지원</option>
                              <option value="원격지원">원격지원</option>
                            </select>
                            <script language="javascript">
                              var handle_s = document.getElementById("handle");
                              for (i = 0; i < handle_s.options.length; i++) {
                                if (handle_s.options[i].value == '<?php echo $view_val['handle']; ?>') {
                                  handle_s.options[i].selected = true;
                                  break;
                                }
                              }
                            </script>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                          <td colspan="2" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">제품명/host/버전/서버/라이선스</td>
                          <td colspan = "3" style="padding-left:10px;" class="t_border">
                          <!-- <input type="hidden" name="seqList" id="seqList" class="input2_red"> -->
                            <input type="hidden" name="productSeq" id="productSeq" class="input2_red" value="">
                            <input type="button" id="produceBtn" value="제품선택" onclick="test(document.cform.customer.value);" style="cursor:pointer;margin:5px 0px 5px 0px;">
                            <input type="button" id="produceAddBtn" value="제품추가선택" onclick="test(document.cform.customer.value,'add');" style="cursor:pointer;margin:5px 0px 5px 0px;">

                            <input type="text" id="serial_value" style="border:1px solid;<?php if((trim($view_val['customer']) != "SKB(유통망)" && trim($view_val['customer']) != "SKB(과금망)") || strpos($view_val['produce'],',') !== false){echo 'display:none;';}?>" placeholder="serial직접입력" value="<?php echo $view_val['sn'] ;?>" onchange="serialChange();" />

                            <input type="hidden" name="produce_seq" id="produce_seq" class="input2_red" value="<?php echo $view_val['produce_seq']; ?>" readonly>
                            <input type="hidden" name="produce" id="produce" class="input2_red" value="<?php echo $view_val['produce']; ?>" readonly>
                            <input type="hidden" name="host" id="host" class="input2_red" value="<?php echo $view_val['host']; ?>" >
                            <input type="hidden" name="version" id="version" class="input2_blue" value="<?php echo $view_val['version']; ?>" readonly>
                            <input type="hidden" name="hardware" id="hardware" class="input2_blue" value="<?php echo $view_val['hardware']; ?>" readonly>
                            <input type="hidden" name="license" id="license" class="input2_blue" value="<?php echo $view_val['license']; ?>" readonly>
                            <input type="hidden" name="serial" id="serial" class="input2_blue" value="<?php echo $view_val['sn']; ?>" readonly>
                            <input type="hidden" name="currentProduce" id="currentProduce" class="input2_red" readonly>
                            <input type="hidden" name="currentPage" id="currentPage" class="input2_red" value=1 readonly>
                              <ul id="sortable">
                              <?php
                                $produce= explode(",",$view_val['produce']);
                                $version= explode(",",$view_val['version']);
                                $hardware= explode(",",$view_val['hardware']);
                                $license= explode(",",$view_val['license']);
                                $host = array();
                                if(trim($view_val['host']) == "" || $view_val['host'] == null){//host가 후에 생겨서 빈값인 경우
                                  for($i=0; $i<count($produce); $i++){
                                    $host[$i]= '';
                                  }
                                }else{
                                  $host = explode(",",$view_val['host']);
                                }

                                $produce_seq = array();
                                if(trim($view_val['produce_seq']) == "" || $view_val['produce_seq'] == null){//produce_seq가 후에 생겨서 빈값인 경우
                                  for($i=0; $i<count($produce); $i++){
                                    $produce_seq[$i]= '';
                                  }
                                }else{
                                  $produce_seq = explode(",",$view_val['produce_seq']);
                                }

                                $sn = explode(",",$view_val['sn']);
                                for($i=1; $i<=count($produce); $i++){
                                  echo '<li id="li'.$i.'"><span style="cursor:pointer;" id="produce'.$i.'" class="click_produce" onclick="clickProduce('.$i.')"><span class="produce_seq" style="display:none;">'.$produce_seq[($i-1)].'</span><span class="produce">'.$produce[($i-1)].'</span> / <span class="host">'.$host[($i-1)].'</span> / <span class="version">'.$version[($i-1)].'</span> / <span class="hardware">'.$hardware[($i-1)].'</span> / <span class="license">'.$license[($i-1)].'</span><span class="serial" style="display:none">'.$sn[($i-1)].'</span></span>&nbsp;&nbsp;<input type="button" value="x" style="color:red;cursor:pointer;" onclick="produceRemove('.$i.')" /></li>';
                                }
                              ?>
                              </ul>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <tr>
                          <td colspan="2" size="100" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">지원내용</td>
                          <td colspan="3" style="padding-left:10px;" style="width:95%; max-width:720px;" class="t_border">
                            <input type="text" name="subject" id="subject" class="input2" style="width:95%;max-width:720px;" value="<?php echo $view_val['subject']; ?>">
                          </td>
                        </tr>
                        <tr>
                          <td colspan="5" height="1" bgcolor="#797c88"></td>
                        </tr>
                        <tbody id ="nonPeriodic">
                          <tr class="addRow">
                            <td colspan="2" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">시간</td>
                            <td height="40" colspan="3" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">지원내역</td>
                          </tr>
                          <tr>
                            <td colspan="5" height="1" bgcolor="#797c88"></td>
                          </tr>
                          <!-- 반복구문!!!  -->
                          <?php
                          $tmp = explode(";;", $view_val['work_process_time']);
                          $process_txt =  explode(";;", $view_val['work_process']);

                          for ($i = 0; $i < count($tmp) - 1; $i++) {
                            $time = explode("-", $tmp[$i]);
                          ?>
                            <tr class="addRow">
                              <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">
                                <input type="text" name="work_time_s[]" id="work_time_s" size="2" value="<?php echo $time[0]; ?>">
                              </td>
                              <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">
                                <input type="text" name="work_time_e[]" id="work_time_e" size="2" value="<?php echo $time[1]; ?>">
                              </td>
                              <td colspan="4" height="40" align="center" style="font-weight:bold; padding: 12px; " class="t_border">
                                <textarea rows="5" style="width:95%; max-width:720px;" name="work_text[]" id="work_text" value="<?php echo $process_txt[$i]; ?>"><?php echo $process_txt[$i]; ?></textarea>
                               </td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>

                        <!-- 정기점검2 -->
                        <tbody id ="periodic">
                          <tr>
                            <td colspan="7" height="40" align="center" style="font-weight:bold;" class="t_border">
                            <?php
                              function br2nl($string){
                                return preg_replace('/\<br(\s*)?\/?\>/i', "\n", $string);
                              }
                              $total_process_text = rtrim(str_replace(';','',br2nl($view_val['work_process'])),'|');
                              $total_process_text = explode('|||',$total_process_text); // 제품별 나누기
                              for($a=0; $a<count($total_process_text); $a++){
                            ?>
                              <table id="work_text_table<?php echo ($a+1) ;?>" class="work_text_table" width=100% border=1 style="display:none;border-collapse:collapse;border-right:none;border-left:none;">
                                <tr>
                                  <th height="30" bgcolor="f8f8f9" class="tdSolid"><input value="점검항목" readonly onfocus="javascrpt:blur();" style="cursor:default; font-weight:bold; text-align: -webkit-center; background-color:transparent;"></input></th>
                                  <th colspan="2" height="30" bgcolor="f8f8f9" class="tdSolid"><input value="점검내용" readonly onfocus="javascrpt:blur();" style="cursor:default; font-weight:bold; text-align: -webkit-center; background-color:transparent;" ></input></th>
                                  <th height="30" bgcolor="f8f8f9" class="tdSolid"><input value="점검결과" readonly onfocus="javascrpt:blur();" style="cursor:default; font-weight:bold; text-align: -webkit-center; background-color:transparent;"></input></th>
                                  <th height="30" bgcolor="f8f8f9" class="tdSolid"><input value="특이사항" readonly onfocus="javascrpt:blur();" style="cursor:default; font-weight:bold; text-align: -webkit-center; background-color:transparent;"></input></th>
                                </tr>
                                <?php
                                  $basicFormIdx=0;
                                  $normalIdx=0;
                                    $process_text = explode('@@',$total_process_text[$a]);
                                    for($i=1; $i<count($process_text); $i++){
                                      $basicFormIdx=$basicFormIdx+1;
                                      $normalIdx=$normalIdx+1;
                                      $process_text1 = explode('#*',$process_text[$i]); //점검 내용 별로 나누기
                                        if($i <> 1){ //기타 특이사항을 제외한 나머지
                                            $process_text1 = explode('#*',$process_text[$i]);

                                            for($j=1; $j<count($process_text1); $j++){
                                              if($j==1){
                                                  echo '<tr class="check'.($i-1).'"><td class="tdSolid" rowspan="'.floor((count($process_text1)-1)/3).'"><input name="work_text'.($i-1).'[]" value="'.$process_text1[$j].'" style="width:70%"></input><img src="'.$misc.'img/btn_del0.jpg" style="cursor:pointer;" class="adddelbtn" onclick="trRemove(this,'.($a+1).');" /></td>'; //cpu, 메모리

                                              }elseif($j<=4){ //점검항목 중 첫번째 점검내용
                                                  if($j!=4){
                                                    if($j%3==0){
                                                        echo '<td class="tdSolid"><div style="margin:0 auto; text-align: -webkit-center;font-weight:normal;"><input type="hidden" name="work_text'.($i-1).'[]" value="'.$process_text1[$j].'">
                                                            <input type="radio" name="produce'.($a+1)."_".($normalIdx-1).'" value="normal" onclick="normalCheck(this);"'.($process_text1[$j]=="normal"?'checked="checked"':'').'>정상
                                                            <input type="radio" name="produce'.($a+1)."_".($normalIdx-1).'" value="abnormal" onclick="normalCheck(this);"'.($process_text1[$j]=="abnormal"?'checked="checked"':'').'>비정상</div></td>';
                                                    }else{
                                                      if(strpos($process_text1[$j],"::") === false){
                                                        if($process_text1[$j] == "::"){
                                                          $text = explode('::',$process_text1[$j]);
                                                          echo '<td class="tdSolid"><textarea name="work_text'.($i-1).'[]" onkeyup="xSize(this);">'.$text[0].'</textarea></td>';
                                                          echo '<td class="tdSolid"><input type="hidden" name="work_text'.($i-1).'[]" value="::"><textarea name="work_text'.($i-1).'[]" onkeyup="xSize(this);">'.$text[1].'</textarea><img src="'.$misc.'img/btn_del0.jpg" style="cursor:pointer;" class="tdDivisionBtn" onclick="tdMerge(this,'.($basicFormIdx-1).');" /></td>';
                                                        }else{
                                                          echo '<td class="tdSolid" colspan="2"><textarea name="work_text'.($i-1).'[]" onkeyup="xSize(this);">'.$process_text1[$j].'</textarea><img src="'.$misc.'img/btn_add.jpg" style="cursor:pointer;" class="tdDivisionBtn" onclick="tdDivision(this,'.($basicFormIdx-1).');" /></td>';
                                                        }
                                                      }else{
                                                        $text = explode('::',$process_text1[$j]);
                                                        echo '<td class="tdSolid"><textarea name="work_text'.($i-1).'[]" onkeyup="xSize(this);">'.$text[0].'</textarea></td>';
                                                        echo '<td class="tdSolid"><input type="hidden" name="work_text'.($i-1).'[]" value="::"><textarea name="work_text'.($i-1).'[]" onkeyup="xSize(this);">'.$text[1].'</textarea><img src="'.$misc.'img/btn_del0.jpg" style="cursor:pointer;" class="tdDivisionBtn" onclick="tdMerge(this,'.($basicFormIdx-1).');" /></td>';
                                                      }
                                                    }
                                                  }else{
                                                    echo '<td class="tdSolid"><textarea name="work_text'.($i-1).'[]" onkeyup="xSize(this);">'.$process_text1[$j].'</textarea></td>';
                                                    echo '<td width="3%" class="t_border adddelbtn"><input type="hidden" name="del_ck" id="del_ck" class="input2"></td><td align="center" class ="adddelbtn" ><img src="'.$misc.'img/btn_add.jpg" onclick ="check_add(this,'.($a+1).')" style="cursor:pointer;" /></td></tr>';
                                                  }
                                              }else{ //점검 항목 중 첫번 째가 아닌 나머지들
                                                  if($j%3==2){
                                                    $normalIdx=$normalIdx+1;
                                                    if(strpos($process_text1[$j],"::") === false){
                                                      if($process_text1[$j] == "::"){
                                                        $text = explode('::',$process_text1[$j]);
                                                        echo '<tr class="check'.($i-1).'"><td class="tdSolid"><textarea name="work_text'.($i-1).'[]" onkeyup="xSize(this);">'.$text[0].'</textarea></td>';
                                                        echo '<td class="tdSolid"><input type="hidden" name="work_text'.($i-1).'[]" value="::"><textarea name="work_text'.($i-1).'[]" onkeyup="xSize(this);">'.$text[1].'</textarea><img src="'.$misc.'img/btn_del0.jpg" style="cursor:pointer;" class="tdDivisionBtn" onclick="tdMerge(this,'.($basicFormIdx-1).');" /></td>';
                                                      }else{
                                                        echo '<tr class="check'.($i-1).'"><td class="tdSolid" colspan="2"><textarea name="work_text'.($i-1).'[]" onkeyup="xSize(this);">'.$process_text1[$j].'</textarea><img src="'.$misc.'img/btn_add.jpg" style="cursor:pointer;" class="tdDivisionBtn" onclick="tdDivision(this,'.($basicFormIdx-1).');" /></td>';
                                                      }
                                                    }else{
                                                      $text = explode('::',$process_text1[$j]);
                                                      echo '<tr class="check'.($i-1).'"><td class="tdSolid"><textarea name="work_text'.($i-1).'[]" onkeyup="xSize(this);">'.$text[0].'</textarea></td>';
                                                      echo '<td class="tdSolid"><input type="hidden" name="work_text'.($i-1).'[]" value="::"><textarea name="work_text'.($i-1).'[]" onkeyup="xSize(this);">'.$text[1].'</textarea><img src="'.$misc.'img/btn_del0.jpg" style="cursor:pointer;" class="tdDivisionBtn" onclick="tdMerge(this,'.($basicFormIdx-1).');" /></td>';
                                                    }
                                                  }elseif($j%3==0){
                                                    echo '<td class="tdSolid"><div style="margin:0 auto; text-align: -webkit-center;font-weight:normal;"><input type="hidden" name="work_text'.($i-1).'[]" value="'.$process_text1[$j].'">
                                                            <input type="radio" name="produce'.($a+1)."_".($normalIdx-1).'" value="normal" onclick="normalCheck(this);"'.($process_text1[$j]=="normal"?'checked="checked"':'').'>정상
                                                            <input type="radio" name="produce'.($a+1)."_".($normalIdx-1).'" value="abnormal" onclick="normalCheck(this);"'.($process_text1[$j]=="abnormal"?'checked="checked"':'').'>비정상</div></td>';
                                                  }elseif($j%3==1){
                                                    echo '<td class="tdSolid"><textarea name="work_text'.($i-1).'[]" onkeyup="xSize(this);">'.$process_text1[$j].'</textarea></td>
                                                            <td width="3%" class="t_border adddelbtn"><input type="hidden" name="del_ck" id="del_ck"></td>
                                                            <td align="center;" class ="adddelbtn"><img src="'.$misc.'img/btn_del0.jpg" style="cursor:pointer;" onclick ="check_del(this)" /></td></tr>';
                                                  }
                                              }
                                            }
                                        }
                                    }

                                    //기타 특이사항
                                    for($i=1; $i<count($process_text); $i++){
                                      if($i == 1){
                                        $process_text1 = explode('#*',$process_text[1]);
                                        for($j=1; $j<count($process_text1); $j++){
                                          if($j+1 <> count($process_text1)){
                                              echo '<tr class="check0" class="check'.(count($process_text)-1).'"><td class="tdSolid"><input name="work_text0[]" value="'.$process_text1[$j].'"></input></td>';
                                          }else{
                                              echo '<td class="tdSolid" colspan="4"><textarea name="work_text0[]" onkeyup="xSize(this);" >'.$process_text1[$j].'</textarea></td></tr>';
                                          }
                                        }
                                      }
                                    }
                                  ?>
                              </table>
                              <?php
                                }
                              ?>
                              <img src="<?php echo $misc; ?>img/btn_add.jpg" id="trPlusBtn" onclick="trPlus();"/>
                              <!-- <label class="switch">
                                <input id="checkOnOFF" type="checkbox">
                                <span class="slider round"></span>
                              </label>
                              <p id="templateOff" class="onoff">TEMPLATE OFF</p><p id="templateOn" class="onoff" style="display:none;">TEMPLATE ON</p> -->
                            </td>
                          </tr>
                        </tbody>
                    <!-- 정기점검2 -->

                        <tr>
                          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                        </tr>
                        <td colspan="2" class="t_border" size="100" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">지원의견</td>
                        <td colspan="4" height="40" align="center" style="font-weight:bold; padding: 12px; " class="t_border">
                          <textarea rows="5" style="width:95%; max-width:720px;" name="comment" id="comment" value="<?php echo  $view_val['comment']; ?>"><?php echo  $view_val['comment']; ?></textarea>
                        </td>
                        <tr>
                          <td colspan="5" height="1" bgcolor="#797c88"></td>
                        </tr>
                        <tr id ="resultOfSupport">
                          <td colspan="2" class="t_border" size="100" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">지원결과</td>
                          <td colspan="3" style="padding-left:10px;" class="t_border">
                            <select name="result" id="result" class="input2">
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

                        <!-- 선영테스트 -->
                        <tr>
                          <td colspan="5" height="1" bgcolor="#797c88"></td>
                        </tr>
                        <tr>
                          <td colspan="2" class="t_border" size="100" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">확인서명</td>
                          <td style="padding-left:10px;" class="t_border">서명동의
                            <input type="checkbox" id="sign_consent" name="sign_consent" value="<?php echo $view_val['sign_consent']; ?>">
                            <div id="dialog" title="비밀번호를 입력하세요" style="float:right;display:none;">
                              <input id="passwordCheck" type="password" size="30" style="height:28px;" />
                            </div>
                          </td>
                          <td size="100" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">일부점검</td>
                          <td style="padding-left:10px;" class="t_border">
                            <input id="some_inspection" name="some_inspection" type="checkbox" value="<?php echo $view_val['some_inspection'];?>" <?php if($view_val['some_inspection'] == "Y"){echo "checked";} ?> >
                          </td>
                        </tr>
                        <!-- 선영테스트끝 -->

                        <tr>
                          <td colspan="5" height="1" bgcolor="#797c88"></td>
                        </tr>
                        <tr>
                          <td colspan="2" class="t_border" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">첨부파일</td>
                          <td class="t_border" style="padding-left:10px;" colspan="3"><?php if ($view_val['file_changename']) { ?><a href="<?php echo site_url(); ?>/tech_board/tech_doc_download/<?php echo $seq; ?>/<?php echo $view_val['file_changename']; ?>"><?php echo $view_val['file_realname']; ?></a> <a href="javascript:filedel('<?php echo $seq; ?>','<?php echo $view_val['file_changename']; ?>');"><img src="<?php echo $misc; ?>img/del.png" width="8" height="8" /></a>&nbsp;&nbsp;<input name="cfile" id="cfile" type="file" size="78" disabled><?php } else { ?><input name="cfile" type="file" size="78"> <span class="point0 txt_s">(용량제한 100MB)<?php } ?> </td>
                        </tr>

                        <tr>
                          <td colspan="5" height="2" bgcolor="#797c88"></td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="right">
                      <!--지원내용 추가 버튼-->
                      <img src="<?php echo $misc; ?>img/btn_add_column3.jpg" id="addRowBtn" width="64" height="31" style="cursor:pointer" onclick="addRow('input_table');return false;" />
                      <img src="<?php echo $misc; ?>img/btn_add_column4.jpg" id="deleteRowBtn" width="64" height="31" style="cursor:pointer" onclick="deleteRow('input_table');return false;" />

                      <input type="image" src="<?php echo $misc; ?>img/btn_adjust.jpg" width="64" height="31" style="cursor:pointer" onClick="javascript:chkForm();return false;" />
                      <img src="<?php echo $misc; ?>img/btn_continue.png" id="continueBtn" width="64" height="31" style="cursor:pointer;display:none" onClick="formAction1();" />
                      <img src="<?php echo $misc; ?>img/btn_cancel.jpg" width="64" height="31" style="cursor:pointer" onClick="javascript:history.go(-1)" /></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                </table>


            </td>
            <td><img src="<?php echo $misc; ?>img/btn_right.jpg" id="rightBtn" onclick="changePage('right');" style="cursor:pointer;display:none"/></td>

          </tr>
        </table>

      </td>
    </tr>
    </form>

    <!-- 폼 끝 -->

    <tr>
      <td align="center" height="100" bgcolor="#CCCCCC">
        <table width="1130" cellspacing="0" cellpadding="0">
          <tr>
            <td width="197" height="100" align="center" background="<?php echo $misc; ?>img/customer_f_bg.png"><img src="<?php echo $misc; ?>img/f_ci.png" /></td>
            <td><?php include $this->input->server('DOCUMENT_ROOT') . "/include/customer_bottom.php"; ?></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>

  <table id="tmp_table">

    <tr id="err_tmp_row1" style="visibility:hideen">
      <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
    </tr>
    <tr id="err_tmp_row2" style='visibility:hidden'>
      <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">장애구분</td>
      <td width="35%" style="padding-left:10px;" class="t_border">
        <select name="err_type" id="err_type" class="input2">
          <option value="HW">HW</option>
          <option value="SW">SW</option>
        </select>
        <script language="javascript">
          var err_type_s = document.getElementById("err_type");
          for (i = 0; i < err_type_s.options.length; i++) {
            if (err_type_s.options[i].value == '<?php echo $view_val['err_type']; ?>') {
              err_type_s.options[i].selected = true;
              break;
            }
          }
        </script>
      </td>
      <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">심각도</td>
      <td width="35%" style="padding-left:10px;" class="t_border">
        <select name="warn_level" id="warn_level" class="input2">
          <option value="001">전체서비스중단</option>
          <option value="002">일부서비스중단/서비스지연</option>
          <option value="003">관리자불편/대고객신뢰도저하</option>
          <option value="004">특정기능장애</option>
          <option value="005">서비스무관단순장애</option>
        </select></td>
      <script language="javascript">
        var warn_level_s = document.getElementById("warn_level");
        for (i = 0; i < warn_level_s.options.length; i++) {
          if (warn_level_s.options[i].value == '<?php echo $view_val['warn_level']; ?>') {
            warn_level_s.options[i].selected = true;
            break;
          }
        }
      </script>
    </tr>
    <tr id="err_tmp_row3" style='visibility:hidden'>
      <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
    </tr>
    <tr id="err_tmp_row4" style='visibility:hidden'>
      <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">장애유형</td>
      <td width="35%" style="padding-left:10px;" class="t_border">
        <select name="warn_type" id="warn_type" class="input2">
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
      <script language="javascript">
        var warn_type_s = document.getElementById("warn_type");
        for (i = 0; i < warn_type_s.options.length; i++) {
          if (warn_type_s.options[i].value == '<?php echo $view_val['warn_type']; ?>') {
            warn_type_s.options[i].selected = true;
            break;
          }
        }
      </script>
      <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">장애원인</td>
      <td width="35%" style="padding-left:10px;" class="t_border">
        <select name="work_action" id="work_action" class="input2">
          <option value="001">기술지원</option>
          <option value="002">설정지원</option>
          <option value="003">장비교체</option>
          <option value="004">업그레이드</option>
          <option value="005">패치</option>
          <option value="006">협의중</option>
        </select></td>
      <script language="javascript">
        var work_action_s = document.getElementById("work_action");
        for (i = 0; i < work_action_s.options.length; i++) {
          if (work_action_s.options[i].value == '<?php echo $view_val['work_action']; ?>') {
            work_action_s.options[i].selected = true;
            break;
          }
        }
      </script>

    </tr>
  </table>

  <script>
    //textarea height 글자수에 맞게 늘려주는 거
    textareaSize();

    function textareaSize(){
      var textarea = document.getElementsByTagName("textarea");
      for (var i = 0; i < textarea.length; i++) {
        if (textarea[i].value != '') {
          textarea[i].style.height = '1px';
          textarea[i].style.height = (textarea[i].scrollHeight) + 'px';
        }
      }
    }

    function xSize(e){
      e.style.height = '1px';
      e.style.height = (e.scrollHeight + 12) + 'px';
    }

    if("<?php echo $view_val['work_name']; ?>" == "정기점검2"){
      $("#work_text_table1").show();
      $("#produce1").css("color","red");
      $("#leftBtn").show();
      $("#rightBtn").show();
      textareaSize();
    }

  // 고객사 검색
  function searchFunction(id) {
    if($("#work_name").val() == "납품설치" || $("#work_name").val() == "미팅" || $("#work_name").val() == "데모(BMT)지원" ){
      $("#dropdown_option").html(
        <?php
        echo "'";
        foreach ($customer2 as $val) {
            echo '<a ';
            echo 'onclick ="clickCustomerName(this,0,'.$val['forcasting_seq'].','.$val['forcasting_seq'].')" >'. $val['customer'].' - '.$val['project_name'].'</a>';
        }
        echo "'";
        ?>
      );
    }else{
      $("#dropdown_option").html(
      <?php
         echo "'";
        foreach ($customer as $val) {
          if (strtotime(date("Y-m-d")) > strtotime(date($val['maintain_end']))) {
            echo '<a style="color:red;" ';
            echo 'onclick ="clickCustomerName(this,' . strtotime(date($val['maintain_end'])) . ','.$val['maintain_seq'].','.$val['forcasting_seq'].')" >' . $val['customer'].' - '.$val['project_name'].'</a>';
          } else {
            echo '<a ';
            echo 'onclick ="clickCustomerName(this,' . strtotime(date($val['maintain_end'])) . ','.$val['maintain_seq'].','.$val['forcasting_seq'].')" >'. $val['customer'].' - '.$val['project_name'].'</a>';
          }
        }
        echo "'";
        ?>
      );
    }
    var myDropdown = $("#" + id).parent().find('div').attr('id');
    $("#myDropdown").toggle();
    $(".searchInput").focus();
  }

  //고객사 선택
  function clickCustomerName(customerName, maintainEnd, seq , forcasting_seq) {
    var customerCompanyName = ($(customerName).text()).split('- ')[0];
    var projectName = ($(customerName).text()).split('- ')[1];
    $("#customerName").val(customerCompanyName);
    $("#project_name").val(projectName);
    $("#customer").val(seq);
    $("#forcasting_seq").val(forcasting_seq);

    if($("#work_name").val() != "납품설치" && $("#work_name").val() != "미팅" && $("#work_name").val() != "데모(BMT)지원" ){
      test3(document.cform.customer.value,'maintain');
      if (<?php echo strtotime(date("Y-m-d")) ?> > maintainEnd) {
        $("#customer").val('');
        $("#customerName").val('');
        $("#project_name").val('');
      }
    }else{
      test3(document.cform.customer.value,'forcasting');
    }
    $("#myDropdown").toggle();
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

  // 외부영역 클릭 시 팝업 닫기
  $(document).mouseup(function (e){
    var LayerPopup = $("#dropdown");
    if(LayerPopup.has(e.target).length === 0){
      $("#myDropdown").hide();
    }
  });
  </script>
  <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.min.js"></script>
  <script>
  //점검 결과 radiobox 값넣기
  var basicFormIdx = <?php echo $basicFormIdx; ?>;
  $("input:radio[name=normalCheck]").click(function(){normalCheck(this);});

  function normalCheck(check){
    if($(check).is(":checked")== true){
      var testResult =$(check).parent().children().eq(0);
      testResult.val($(check).val());
    }
  }

  if($("#sign_consent").val()=="true"){
    $("input[name=sign_consent]").prop("checked", true);
  }

  $(document).ready(function(){
    $("#sign_consent").change(function(){
      if("<?php echo $_SESSION['stc']['name']; ?>" != "<?php echo  $view_val['writer'] ?>"){
          alert("담당자가 아닙니다.");
          if($("input:checkbox[name=sign_consent]").is(":checked") == true) {
            $("input[name=sign_consent]").prop("checked", false);
          }else{
            $("input[name=sign_consent]").prop("checked", true);
          }
      }else{
        if($("#sign_consent").is(":checked")){
          $("#passwordCheck").val('');
          $("#dialog").dialog({
            open: function(event, ui) {
              $(".ui-dialog-titlebar-close", $(this).parent()).hide();
            },
            buttons: {
              "확인": function() {
                $(this).dialog('close');
                var dialogValue = $("#passwordCheck").val();
                var pw =CryptoJS.SHA1(dialogValue);
                var name = "<?php echo  $view_val['writer'] ?>"; //작성자 name

                $.ajax({
                    type: "POST",
                    cache: false,
                    url: "<?php echo site_url(); ?>/ajax/pwcheck",
                    dataType: "json",
                    async: false,
                    data: {
                      name:name
                    },
                    success: function (data) {
                      if(data.user_password==CryptoJS.enc.Hex.stringify(pw)){
                          $("#sign_consent").val(true);
                          alert("인증되었습니다");
                      }else{
                          $("input[name=sign_consent]").prop("checked", false);
                          alert("비밀번호가 틀렸습니다")
                      }
                    }
                });
              },
              "취소": function() { $(this).dialog('close');$("input[name=sign_consent]").prop("checked", false); }
            }
          });
        }else{
            $("#dialog").dialog('close');
            alert("서명동의 취소");
        }
      }
    });
  });

</script>
<!-- 정기점검2 -->
<script>
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
    // $("#click_version").empty();
    // $("#click_hardware").empty();
    // $("#click_license").empty();

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
    textareaSize();
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
    lastTr.after('<tr class="check'+check_Idx+'"><td class="tdSolid"><input name="work_text'+check_Idx+'[]" style="width:80%"/><img src="<?php echo $misc; ?>img/btn_del0.jpg" style="cursor:pointer;" class="adddelbtn" onclick="trRemove(this,'+currentTable+');" /></td><td class="tdSolid" colspan="2"><textarea name="work_text'+check_Idx+'[]" onkeyup="xSize(this);" style="width:80%;"></textarea><img src="<?php echo $misc;?>img/btn_add.jpg" style="cursor:pointer;" class="tdDivisionBtn" onclick="tdDivision(this,'+check_Idx+');"/></td><td class="tdSolid"> <div style ="margin:0 auto; text-align: -webkit-center;font-weight:normal;"><input type="hidden" name="work_text'+check_Idx+'[]" value="normal"><input type="radio" name="produce'+currentTable+'_'+normalCheck_idx+'" value="normal" onclick="normalCheck(this);" checked="checked">정상<input type="radio" name="produce'+currentTable+'_'+normalCheck_idx+'" value="abnormal" onclick="normalCheck(this);">비정상</div></td><td class="tdSolid"><textarea name="work_text'+check_Idx+'[]" onkeyup="xSize(this);"></textarea></td><td width="3%" class="t_border adddelbtn"><input type="hidden" name="del_ck" id="del_ck" class="input2"></td><td align="center" class ="adddelbtn"><img src="<?php echo $misc; ?>img/btn_add.jpg" onclick ="check_add(this,'+currentTable+')" style="cursor:pointer;" /></td></tr>')
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
    var txt = '<td class="tdSolid"><input type="hidden" name="work_text'+num+'[]" value="::">'+td.html()+'<img src="<?php echo $misc;?>img/btn_del0.jpg" style="cursor:pointer;" class="tdDivisionBtn" onclick="tdMerge(this,'+num+');"/></td>';
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
    td.append('<img src="<?php echo $misc;?>img/btn_add.jpg" style="cursor:pointer;" class="tdDivisionBtn" onclick="tdDivision(this,'+num+');"/>');
  }


  //점검항목 탬플릿 가져오는 부분
  function template(product, tablenum) {
    if ($("#work_name option:selected").val() == "정기점검2") {
      $.ajax({
        type: "POST",
        cache: false,
        url: "<?php echo site_url(); ?>/ajax/template",
        dataType: "json",
        async: false,
        data: {
          product: product
        },
        success: function (data) {
          if (data.length) {
            basicFormIdx = 1;
            var txt = '<tr><th class="tdSolid" height="30" bgcolor="f8f8f9"><input value="점검항목" readonly onfocus="javascrpt:blur();" style="cursor:default; font-weight:bold; text-align: -webkit-center;background-color:transparent;"></input></th><th colspan="2" height="30" bgcolor="f8f8f9" class="tdSolid"><input value="점검내용" readonly onfocus="javascrpt:blur();" style="cursor:default; font-weight:bold; text-align: -webkit-center;background-color:transparent;"></input></th><th height="30" bgcolor="f8f8f9" class="tdSolid"><input value="점검결과" readonly onfocus="javascrpt:blur();" style="cursor:default; font-weight:bold; text-align: -webkit-center;background-color:transparent;"></input></th><th height="30" bgcolor="f8f8f9" class="tdSolid"><input value="특이사항" readonly onfocus="javascrpt:blur();" style="cursor:default; font-weight:bold; text-align: -webkit-center;background-color:transparent;"></input></th></tr>';
            // var process_text = (data[0].check_list.replace(";", '')).split('@@');
            var process_text = ((data[0].check_list.replace(/(<br>|<br\/>|<br \/>)/g, '\r\n')).replace(";", '')).split('@@');
            for (i = 1; i < process_text.length; i++) {
              var process_text1 = process_text[i].split('#*');
              if (i != 1) {
                process_text1 = process_text[i].split('#*');
                for (j = 1; j < process_text1.length; j++) {
                  if (j == 1) {
                    txt += '<tr class="check' + (i - 1) + '"><td class="tdSolid" rowspan="' + Math.floor((process_text1.length - 1) / 3) + '"><input name="work_text' + (i - 1) + '[]" value="' + process_text1[j] + '" style="width:70%"></input><img src="<?php echo $misc; ?>img/btn_del0.jpg" style="cursor:pointer;" class="adddelbtn" onclick="trRemove(this,' + tablenum + ');" /></td>'; //cpu, 메모리
                  } else if (j <= 4) { //점검항목 중 첫번째 점검내용
                    if (j != 4) {
                      if (j % 3 == 0) {
                        txt += '<td class="tdSolid"><div style="margin:0 auto; text-align: -webkit-center;font-weight:normal;"><input type="hidden" name="work_text' + (i - 1) + '[]" value="' + process_text1[j] + '"><input type="radio" name="produce' + tablenum + "_" + (basicFormIdx - 1) + '" value="normal" onclick="normalCheck(this);"'
                        if (process_text1[j] == "normal") {
                          txt += 'checked="checked"';
                        }
                        txt += '>정상<input type="radio" name="produce' + tablenum + "_" + (basicFormIdx - 1) + '" value="abnormal" onclick="normalCheck(this);"'
                        if (process_text1[j] == "abnormal") {
                          txt += 'checked="checked"';
                        }
                        txt += '>비정상</div></td>';
                      } else {
                        if (process_text1[j].indexOf("::") == -1) {
                          txt += '<td class="tdSolid" colspan="2"><textarea name="work_text' + (i - 1) + '[]" onkeyup="xSize(this);">' + process_text1[j] + '</textarea><img src="<?php echo $misc ;?>img/btn_add.jpg" style="cursor:pointer;" class="tdDivisionBtn" onclick="tdDivision(this,' + (basicFormIdx - 1) + ');" /></td>';
                        } else {
                          var text = process_text1[j].split('::');
                          txt += '<td class="tdSolid"><textarea name="work_text' + (i - 1) + '[]" onkeyup="xSize(this);">' + text[0] + '</textarea></td>';
                          txt += '<td class="tdSolid"><input type="hidden" name="work_text' + (i - 1) + '[]" value="::"><textarea name="work_text' + (i - 1) + '[]" onkeyup="xSize(this);">' + text[1] + '</textarea><img src="<?php echo $misc ;?>img/btn_del0.jpg" style="cursor:pointer;" class="tdDivisionBtn" onclick="tdMerge(this,' + (basicFormIdx - 1) + ');"/></td>';
                        }
                      }
                    } else {
                      txt += '<td class="tdSolid"><textarea name="work_text' + (i - 1) + '[]" onkeyup="xSize(this);">' + process_text1[j] + '</textarea></td>';
                      txt += '<td width="3%" class="t_border adddelbtn"><input type="hidden" name="del_ck" id="del_ck" class="input2"></td><td align="center" class ="adddelbtn" ><img src="<?php echo $misc; ?>img/btn_add.jpg" onclick ="check_add(this,' + tablenum + ')" style="cursor:pointer;" /></td></tr>';
                    }
                  } else { //점검 항목 중 첫번 째가 아닌 나머지들
                    if (j % 3 == 2) {
                      if (process_text1[j].indexOf("::") == -1) {
                        txt += '<tr class="check' + (i - 1) + '"><td class="tdSolid" colspan="2"><textarea name="work_text' + (i - 1) + '[]" onkeyup="xSize(this);">' + process_text1[j] + '</textarea><img src="<?php echo $misc;?>img/btn_add.jpg" style="cursor:pointer;" class="tdDivisionBtn" onclick="tdDivision(this,' + (basicFormIdx - 1) + ');" /></td>';
                      } else {
                        var text = process_text1[j].split('::')
                        txt += '<tr class="check' + (i - 1) + '"><td class="tdSolid"><textarea name="work_text' + (i - 1) + '[]" onkeyup="xSize(this);">' + text[0] + '</textarea></td>';
                        txt += '<td class="tdSolid"><input type="hidden" name="work_text' + (i - 1) + '[]" value="::"><textarea name="work_text' + (i - 1) + '[]" onkeyup="xSize(this);">' + text[1] + '</textarea><img src="<?php echo $misc ;?>img/btn_del0.jpg" style="cursor:pointer;" class="tdDivisionBtn" onclick="tdMerge(this,' + (basicFormIdx - 1) + ');" /></td>';
                      }
                      basicFormIdx = basicFormIdx + 1;
                    } else if (j % 3 == 0) {
                      txt += '<td class="tdSolid"><div style="margin:0 auto; text-align: -webkit-center;font-weight:normal;"><input type="hidden" name="work_text' + (i - 1) + '[]" value="' + process_text1[j] + '"><input type="radio" name="produce' + tablenum + "_" + (basicFormIdx - 1) + '" value="normal" onclick="normalCheck(this);"';
                      if (process_text1[j] == "normal") {
                        txt += 'checked="checked"';
                      }
                      txt += '>정상<input type="radio" name="produce' + tablenum + "_" + (basicFormIdx - 1) + '" value="abnormal" onclick="normalCheck(this);"'
                      if (process_text1[j] == "abnormal") {
                        txt += 'checked="checked"';
                      }
                      txt += '>비정상</div></td>';
                    } else if (j % 3 == 1) {
                      txt += '<td class="tdSolid"><textarea name="work_text' + (i - 1) + '[]" onkeyup="xSize(this);">' + process_text1[j] + '</textarea></td><td width="3%" class="t_border adddelbtn"><input type="hidden" name="del_ck" id="del_ck"></td><td align="center;" class ="adddelbtn"><img src="<?php echo $misc ;?>img/btn_del0.jpg" style="cursor:pointer;" onclick ="check_del(this)" /></td></tr>';
                    }
                  }
                }
              }
              basicFormIdx = basicFormIdx + 1;
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
      var txt ='<tr><th height="30" bgcolor="f8f8f9" class="tdSolid"><input value="점검항목" readonly onfocus="javascrpt:blur();" style="cursor:default; font-weight:bold; text-align: -webkit-center;background-color:transparent;"></input></th><th colspan="2" height="30" bgcolor="f8f8f9" class="tdSolid"><input value="점검내용" readonly onfocus="javascrpt:blur();" style="cursor:default; font-weight:bold; text-align: -webkit-center;background-color:transparent;"></input></th><th height="30" bgcolor="f8f8f9" class="tdSolid"><input value="점검결과" readonly onfocus="javascrpt:blur();" style="cursor:default; font-weight:bold; text-align: -webkit-center;background-color:transparent;"></input></th><th height="30" bgcolor="f8f8f9" class="tdSolid"><input value="특이사항" readonly onfocus="javascrpt:blur();" style="cursor:default; font-weight:bold; text-align: -webkit-center;background-color:transparent;"></input></th></tr>';
      for(i=1; i<check.length; i++){
        txt += '<tr class="check'+i+'">';
        txt += '<td class="tdSolid"><input name="work_text'+i+'[]" value="'+check[i]+'" readonly onfocus="javascrpt:blur();"style="cursor:default"><img src="<?php echo $misc; ?>img/btn_del0.jpg" style="cursor:pointer;" class="adddelbtn" onclick="trRemove(this,' + num + ');" /></td><td class="tdSolid" colspan="2"><textarea name="work_text'+i+'[]" onkeyup="xSize(this);" style="width:80%;"></textarea><img src="<?php echo $misc;?>img/btn_add.jpg" style="cursor:pointer;" class="tdDivisionBtn" onclick="tdDivision(this,'+i+');"/></td>'
        txt += '<td class="tdSolid"><div style="margin:0 auto; text-align: -webkit-center;font-weight:normal;">';
        txt += '<input type="hidden" name="work_text'+i+'[]" value="normal"><input type="radio" name="produce'+num+"_"+i+'" value="normal" onclick="normalCheck(this);" checked="checked">정상<input type="radio" name="produce'+num+"_"+i+'" value="abnormal" onclick="normalCheck(this);">비정상</div></td>';
        txt += '<td class="tdSolid"><textarea name="work_text'+i+'[]" onkeyup="xSize(this);"></textarea></td>'
        txt += '<td width="3%" class="t_border adddelbtn"><input type="hidden" name="del_ck" id="del_ck" class="input2"></td>';
        txt += '<td align="center" class ="adddelbtn" ><img src="<?php echo $misc; ?>img/btn_add.jpg" onclick ="check_add(this,'+num+')" style="cursor:pointer;" /></td>  </tr>';
        basicFormIdx++;
      }
      txt += '<tr class="check0" height="80" ><td class="tdSolid"><input name="work_text0[]" value= "기타 특이사항" readonly onfocus="javascrpt:blur();"></td><td class="tdSolid" colspan="4"><textarea name="work_text0[]" rows="5" style="width:95%;height:100%"></textarea></td></tr>';
      $("#work_text_table"+num).html(txt);
    }else{//템플릿 ON
      $("#templateOnOFF"+num).find("#templateOn").toggle();
      $("#templateOnOFF"+num).find("#templateOff").toggle();
      template($("#currentProduce").val(),num);
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

  //escape
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
</script>
</body>
</html>
