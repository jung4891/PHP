<?php
 // 김수성 추가
$cnt=0;
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/customer_top.php";
?>
<script language="javascript">
//장비 정보 가져오는 함수
var err_mode=1; //작업명이 장애지원 인경우
var k =24; //지원내역부분이 추가될 Index 
var row_min=33; //지원내역이 1개 이상 있을 row 조건

var table = null;
var rowCount = null;
var row= null;
var row_count=null;



function checktest(){


var chbx = document.createElement("input");
    chbx.setAttribute("type", "checkbox");
    chbx.setAttribute("id", "produce");
    chbx.setAttribute("value", "test2");
    document.getElementById("produce_m").appendChild(chbx);

}


//장애지원 선택시 장애 탭 추가
function change(){

 var work_name = document.getElementsByName("work_name[]");

 //var work_name = document.getElementById("work_name[]").selectedIndex;


if(work_name[3].checked){

 tmp = document.getElementById("tmp_table");
 table = document.getElementById("input_table");
 rowCount = table.rows.length;

 row = table.insertRow(5);
 row.innerHTML = tmp.rows[0].innerHTML;
 row = table.insertRow(6);
 row.innerHTML = tmp.rows[1].innerHTML;
 row = table.insertRow(7);
 row.innerHTML = tmp.rows[2].innerHTML;
 row = table.insertRow(8);
 row.innerHTML = tmp.rows[3].innerHTML;

 row_min = row_min+4;
 k=k+4;
 err_mode=1;

}else{

 table = document.getElementById("input_table");

 rowCount = table.rows.length;
if(rowCount >= 33){
 for(var i=0; i<4;i++){
    table.deleteRow( 5 );
 }
 row_min = row_min-4;
 k=k-4;
 err_mode=0;

  return
} 
}
}

function test(name){

  var settings ='height=500,width=1000,left=0,top=0';

  window.open('/index.php/tech_board/search_device?name='+name,'_blank');

}

//담당 SE 가져오는 함수
function test2(){

  var settings ='height=500,width=1000,left=0,top=0';

  window.open('/index.php/tech_board/search_se','_blank');

    window.focus();

}

// 고객사 담당자 가져오는 함수
function test3(name){

  var settings ='height=500,width=1000,left=0,top=0';

  var popup =  window.open('/index.php/tech_board/search_manager?name='+name,'_blank');
  window.focus();


}

/// 제출전 확인할것들
var chkForm = function () {
	var mform = document.cform;

  if (mform.produce.value == "") {
    mform.produce.focus();
    alert("장비/시스템을 입력해주세요.");
    return false
  }

  /*if (mform.customer.value == "") {
    mform.customer.focus();
    alert("고객사(등록Site)정보를 입력해주세요.");
    return false
  }

  if (mform.income_time.value == "00:00") {
    mform.income_time.focus();
    alert("작업일을 입력해주세요.");
    return false
  }
  if (mform.customer_manager_time.value == "") {
    mform.customer_manager.focus();
    alert("담당자명을 입력해주세요.");
    return false
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
  if (mform.engineer.value == "") {
    mform.engineer.focus();
    alert("엔지니어를 입력해주세요.");
    return false
  }
  if (mform.engineer.value == "") {
    mform.engineer.focus();
    alert("엔지니어를 입력해주세요.");
    return false
  }

*/


var work_text=document.getElementsByName('work_text[]');
var comment=document.getElementById("comment");
var str="";
var i=0;


for(i;i<work_text.length;i++){

        document.getElementsByName('work_text[]')[i].value = work_text[i].value.replace(/\n/g,'<br/>');

}

document.getElementById("comment").value = comment.value.replace(/\n/g,'<br/>');

  mform.submit();
  return false;


}

function addRow() {
  table = document.getElementById('input_table');
  rowCount = table.rows.length;
  row = table.insertRow(rowCount-8);
  var colCount = table.rows[k].cells.length;

  row.innerHTML = table.rows[k].innerHTML;

}

function deleteRow(tableID) {

 table = document.getElementById(tableID);
 row_count = table.rows.length;
 if (row_count > row_min ){
 table.deleteRow( table.rows.length-9 );
 } else {
  alert("적어도 하나의 지원내역이 필요합니다.");
 }
}

</script>
<body>

  <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
     <td height="203" align="center" background="<?php echo $misc;?>img/customer06_bg.jpg">
      <table width="1130" cellspacing="0" cellpadding="0" >
       <tr>
        <td width="197" height="30" background="<?php echo $misc;?>img/customer_t.png"></td>
        <td align="right"><table width="15%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="right"><?php if( $id != null ) {?>
             <a href="<?php echo site_url();?>/account/modify_view"><?php echo $name;?></a> 님 | <a href="<?php echo site_url();?>/account/logout"><img src="<?php echo $misc;?>img/btn_logout.jpg" align="absmiddle" /></a>
             <?php } else {?>
             <a href="<?php echo site_url();?>/account"><img src="<?php echo $misc;?>img/btn_login.jpg" align="absmiddle" /></a>
             <?php }?></td>
           </tr>
         </table></td>
       </tr>
       <tr>
        <td height="173"><a href="<?php echo site_url();?>"><img src="<?php echo $misc;?>img/customer_title.png" width="197" height="173" /></a></td>
        <td align="center" class="title1">고객의 미래를 생각하는 기업
          <p class="title2">두리안정보기술센터에 오신것을 환영합니다.</p></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td align="center" valign="top">

      <table width="1130" height="100%" cellspacing="0" cellpadding="0" >
        <tr>
          <td width="197" valign="top" background="<?php echo $misc;?>img/customer_m_bg.png" style="min-height:620px;">

           <div id='cssmenu'>
            <ul>
             <li><a href='<?php echo site_url();?>/board/notice_list'><span>공지사항</span></a></li>
             <li class='has-sub'><a href='<?php echo site_url();?>/board/manual_list'><span>자료실</span></a>
              <ul>
               <li><a href='<?php echo site_url();?>/board/manual_list'><span>매뉴얼</span></a>
               </li>
               <li><a href='<?php echo site_url();?>/board/edudata_list'><span>교육자료</span></a>
               </li>
             </ul>
           </li>
           <li><a href='<?php echo site_url();?>/board/eduevent_list'><span>교육 &amp; 행사</span></a></li>
           <li><a href='<?php echo site_url();?>/board/release_note_list'>릴리즈노트</span></a></li>
<!--           <li><a href='<?php echo site_url();?>/board/qna_list'><span>QnA</span></a></li>-->
           <li><a href='<?php echo site_url();?>/board/faq_list'><span>FAQ</span></a></li>
           <!-- 김수성 추가 2017-02-01 -->
           <?php if( $this->company == 2118872631 ) {?>
           <li><a href='<?php echo site_url();?>/tech_board/tech_doc_list'><span class="point">기술지원보고서</span></a></li>
           <li><a href='<?php echo site_url();?>/tech_board/tech_device_list'><span>장비/시스템 등록</span></a></li>
              <li><a href='<?php echo site_url();?>/durian_car/car_drive_list'>차량운행일지</span></a></li>
           <li><a href='<?php echo site_url();?>/board/network_map_list'>구성도</span></a></li>
           <?php

           $customer_cnt=0;
         } ?><!-- 김수성 끝 나중에 다 고쳐야됨 -->
         <li class='last'><a href='<?php echo site_url();?>/board/suggest_list'><span>건의사항</span></a></li>

       </ul>
     </div>

   </td>
   <td width="923" align="center" valign="top">
    <form name="cform" action="<?php echo site_url();?>/tech_board/tech_doc_input_action_test" method="post" enctype="multipart/form-data" onSubmit="javascript:chkForm();return false;">
     <table width="890" border="0" style="margin-top:20px;">
      <tr>
        <td class="title3">기술지원보고서 등록/수정</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table id="input_table" width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td colspan="5" height="2" bgcolor="#797c88"></td>
          </tr>
          <tr>
           <tr>
            <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border" >고객사</td>
            <td width="35%" style="padding-left:10px;" class="t_border" >
              <select name="customer" id="customer"  class="input2" onChange="javascript:test3(document.cform.customer.value);">
                <?php


                foreach ($customer  as $val) {
                  echo '<option value="'.$val['customer'].'"';
                  echo '>'.$val['customer'].'</option>';
                }
                ?>
              </select>
            </td>
            <td idth="15%" height="40" align="center" bgcolor="f8f8f9"  style="font-weight:bold;" class="t_border" >등록자</td>
            <td width="35%" align="center" class="t_border" ><input type="hidden" id="writer" name="writer" value="<?php echo $name;?>"><?php echo $name;?></td>
          </tr>
          <tr>
            <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
          </tr>

          <tr>
            <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">작업명(종류)</td>
            <td width="35%" style="padding-left:10px;" class="t_border">
              <input type="checkbox" name="work_name[]" id="work_name[]" value="정기점검" >정기점검
              <input type="checkbox" name="work_name[]" id="work_name[]" value="교육지원" >교육지원
              <input type="checkbox" name="work_name[]" id="work_name[]" value="교육참석" >교육참석
              <input type="checkbox" name="work_name[]" id="work_name[]" value="장애지원" onChange="change();">장애지원<br />
              <input type="checkbox" name="work_name[]" id="work_name[]" value="설치지원" >설치지원
              <input type="checkbox" name="work_name[]" id="work_name[]" value="기술지원" >기술지원
              <input type="checkbox" name="work_name[]" id="work_name[]" value="납품설치" >납품설치
              <input type="checkbox" name="work_name[]" id="work_name[]" value="미팅" >미팅<br />
              <input type="checkbox" name="work_name[]" id="work_name[]" value="데모(BMT)지원" >데모(BMT)지원
            </td>
            <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">작업일</td>
            <td width="35%" style="padding-left:10px;" class="t_border"><input type="date" name="income_time" id="income_time" class="input2"/></td>
          </tr>
<!-- 추가 내용-->
<!-- 여기까지 삭제-->


          <tr id="err_row1">
            <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
          </tr>


          <tr>
            <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
          </tr>
          <tr>
            <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;"class="t_border" >담당자명</td>
            <td width="35%" style="padding:10px;" class="t_border"><input type="text" name="customer_manager" id="customer_manager" class="input2"/></td>
            <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">투입시간</td>
            <td width="35%" style="padding:10px;" class="t_border">자동입력</td>
          </tr>
          <tr>
            <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
          </tr>
          <tr>
            <td colspan="2" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">시작시간</td>
            <td  style="padding-left:10px;" class="t_border"><input type="time" name="start_time" id="start_time" class="input2"/></td>
            <td align="center" bgcolor="f8f8f9"  style="font-weight:bold;" class="t_border">종료시간</td>
            <td  style="padding:10px;" class="t_border" ><input type="time" name="end_time" id="end_time" class="input2"></td>
          </tr>
          <tr>
           <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
         </tr>
         <tr>
          <td colspan="2" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">담당SE</td>
          <td  style="padding-left:10px;" class="t_border"><input type="text" name="engineer" id="engineer" class="input2" onclick="test2();" readonly ></td>
          <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">지원방법</td>
          <td width="35%" style="padding-left:10px;" class="t_border">
            <select name="handle" id="handle" class="input2">
              <option value="현장지원">현장지원</option>
              <option value="원격지원">원격지원</option>
            </select>
          </td>
        </tr>
        <tr>
          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
        </tr>
        <tr>
          <td colspan="2" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">제품명</td>
          <td style="padding-left:10px;" class="t_border">
            <input type="text" name="produce" id="produce" class="input2_red" onclick="test(document.cform.customer.value);" readonly >
          </td>
          <td align="center" bgcolor="f8f8f9"  style="font-weight:bold;" class="t_border">버전정보</td>
          <td  style="padding-left:10px;" class="t_border">
            <input type="text" name="version" id="version" class="input2_blue" readonly >
          </td>
        </tr>
        <tr>
          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
        </tr>
        <tr>
          <td colspan="2" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">서버</td>
          <td  style="padding-left:10px;" class="t_border">
            <input type="text" name="hardware" id="hardware"  class="input2_blue" readonly >
          </td>
          <td align="center" bgcolor="f8f8f9"  style="font-weight:bold;" class="t_border">라이선스</td>
          <td  style="padding-left:10px;"  class="t_border">
            <input type="text"  name="license" id="license" class="input2_blue" class="t_border" readonly >
            <input type="hidden"  name="serial" id="serial" class="input2_blue" class="t_border" readonly >
          </td>
        </tr>
        <tr>
          <td colspan="5" height="1" bgcolor="#797c88"></td>
        </tr>
        <tr name="test_c" id="test_c">
          <td colspan="2" size="100" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">지원내용</td>
          <td colspan="3"  style="padding-left:10px;"  class="t_border">
            <input type="text" name="subject" id="subject" style="width:95%; max-width:720px;">
          </td>
        </tr>
        <tr name="test_a" id="test_a">
          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
        </tr>
        <tr>
          <td colspan="2" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">시간</td>
          <td height="40" colspan="3" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">지원내역</td>
        </tr>
        <tr>
          <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
        </tr>
        <tr> <!-- 여기 지금 20번-->
          <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;"  class="t_border">
            <input type="text" name="work_time_s[]" id="work_time_s[]"  size="2">
          </td>
          <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">
           <input type="text" name="work_time_e[]" id="work_time_e[]" size="2">
         </td>
         <td colspan="6" height="40" style="font-weight:bold; padding: 12px;"  class="t_border">
           <textarea rows="5" style="width:95%; max-width:720px; " name="work_text[]" id="work_text[]" >
담당자 : 두리안정보기술 홍길동 대리, 연락처 : 010-1234-5678, 이메일 : gdhong@durianit.co.kr
담당자 : 더 망고 이영희 사원 , 연락처 : 010-3456-7890, 이메일 : yhlee@mango.co.kr

업무목적 : 기술지원한 목적을 작성 해주세요.
대상장비: 기술지원한 장비명을 작성해주세요. (S/N : xxxxxxx, Version : v.1.0)
</textarea>

         </td>
       </tr>


       <tr>
        <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
      </tr>
	<tr>
          <td colspan="2" size="100" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">지원의견</td>
          <td colspan="3"   style="font-weight:bold;"  class="t_border">
<textarea rows="5" style="width:95%; max-width:720px;" name="comment" id="comment"></textarea>
          </td>
        </tr>



       <tr>
        <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
      </tr>
      <tr>
        <td colspan="2" size="100" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border" >지원결과</td>
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

        <tr>
          <td colspan="5" height="1" bgcolor="#797c88"></td>
        </tr>


	<tr>
                  <td colspan="2" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_boder">첨부파일</td>
                  <td class="t_border" style="padding-left:10px;" colspan="3" class="t_border"><input type="file" name="cfile" id="cfile" />
                    (용량제한 100MB)</td>
                  </tr>
                  <tr>
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
    <img src="<?php echo $misc;?>img/btn_add_column3.jpg" width="64" height="31" style="cursor:pointer" onclick="addRow();return false;"/>
    <img src="<?php echo $misc;?>img/btn_add_column4.jpg" width="64" height="31" style="cursor:pointer" onclick="deleteRow('input_table');return false;"/>

    <input type="image" src="<?php echo $misc;?>img/btn_ok.jpg" width="64" height="31" style="cursor:pointer" onClick="javascript:chkForm();return false;"/>
    <img src="<?php echo $misc;?>img/btn_cancel.jpg" width="64" height="31" style="cursor:pointer" onClick="javascript:history.go(-1)"/></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>


</td>
<td width="8" background="<?php echo $misc;?>img/right_bg.png"></td>
</tr>
</table>

</td>
</tr>
</form>

<!-- 폼 끝 -->

<tr>
 <td align="center" height="100" bgcolor="#CCCCCC"><table width="1130" cellspacing="0" cellpadding="0" >
  <tr>
    <td width="197" height="100" align="center" background="<?php echo $misc;?>img/customer_f_bg.png"><img src="<?php echo $misc;?>img/f_ci.png"/></td>
    <td><?php include $this->input->server('DOCUMENT_ROOT')."/include/customer_bottom.php"; ?></td>
  </tr>
</table></td>
</tr>
</table>
<table id="tmp_table">

          <tr id="err_tmp_row1" style="visibility:hideen">
            <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
          </tr>
          <tr id="err_tmp_row2" style='visibility:hidden'>
            <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">장애구분</td>
            <td width="35%" style="padding-left:10px;" class="t_border">
              <select name="err_type" id="err_type" class="input2" >
                <option value="HW">HW</option>
                <option value="SW">SW</option>
              </select>
            </td>
            <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">심각도</td>
            <!-- <td width="35%" style="padding-left:10px;" class="t_border"><input type="date" name="income_time" id="income_time" class="input2"/></td> -->
            <td width="35%" style="padding-left:10px;" class="t_border">
              <select name="warn_level" id="warn_level" class="input2" >
                <option value="001">전체서비스중단</option>
                <option value="002">일부서비스중단/서비스지연</option>
                <option value="003">관리자불편/대고객신뢰도저하</option>
                <option value="004">특정기능장애</option>
                <option value="005">서비스무관단순장애</option>
              </select></td>
          </tr>
          <tr id="err_tmp_row3" style='visibility:hidden'>
            <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
          </tr>
          <tr id="err_tmp_row4" style='visibility:hidden'>
            <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">장애유형</td>
            <td width="35%" style="padding-left:10px;" class="t_border">
              <select name="warn_type" id="warn_type" class="input2" >
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
            <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">장애처리방법</td>
            <td width="35%" style="padding-left:10px;" class="t_border">
              <!-- <input type="date" name="income_time" id="income_time" class="input2"/></td> -->
              <select name="work_action" id="work_action" class="input2" >
                <option value="001">기술지원</option>
		<option value="002">설정지원</option>
                <option value="003">장비교체</option>
                <option value="004">업그레이드</option>
                <option value="005">패치</option>
                <option value="006">협의중</option>
              </select></td>
          </tr>
</table>
</body>
</html>
