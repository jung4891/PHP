<?php
  // 김수성 추가
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/customer_top.php";
?>
<script language="javascript">
//장비 정보 가져오는 함수

var err_mode=1;
var k =24;
var row_min=32;

var table = null;
var rowCount = null;
var row= null;
var row_count=null;

window.onload = function() {

	if(document.getElementById("work_name").value!="장애지원"){
		change();

	}
	var i=0;
	var work_text=document.getElementsByName("work_text[]");
	for(i;i<work_text.length;i++){

		work_text[i].value=work_text[i].value.replace(/<br\/>/g,"\n");

	}


};

function filedel(seq, filename) {
        if (confirm("정말 삭제하시겠습니까?") == true){
                location.href = "<?php echo site_url();?>/tech_board/tech_doc_filedel/" + seq + "/" + filename;
                return false;
        }
}


function change(){


 var x = document.getElementById("work_name").selectedIndex;


 if(x==3&&err_mode==0){

 tmp = document.getElementById("tmp_table");
 rowCount = table.rows.length;
 table = document.getElementById("input_table");

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

 }else if(x!=3&&err_mode==1){

 table = document.getElementById("input_table");

 for(var i=0; i<4;i++){
    table.deleteRow( 5 );
 }


 row_min = row_min-4;
 k=k-4;
 err_mode=0
}
else{
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
}

// 고객사 담당자 가져오는 함수
function test3(val){
/*

  var tmp = document.getElementById('customer').value;        
  //var tmp = document.getElementsByName("customer").value;
  alert(tmp);


  var tmp1_array = <?php echo var_dump(val)?>;
  alert(tmp1_array);
  var tmp_array = <?php echo json_encode($view_val) ?>;
  var customer_name="";
 
  alert(tmp_array[0][1]);

  /*
  while(tmp==tmp_array[0]){
    customer_name=tmp_array[0];

  }
  */
  opener.getElementsByName("customer").value=customer_name;



}
var print_r = function(tar){ 
    var str = ''; 
    for (var p in tar) { 
        var tmp = eval("tar['" + p.toString() + "']"); 
        if (tmp != null && tmp.toString != null && tmp.toString() != ''){ 
            if (str != '') str += ", "; 
            str += p.toString() + " = " + tmp.toString(); 
        } 
    } 
    return str; 
}
 

/// 제출전 확인할것들 
var chkForm = function () {
  var mform = document.cform;

  if (mform.produce.value == "") {
    mform.produce.focus();
    alert("장비/시스템을 입력해주세요.");
    return false
  }
  
  if (mform.customer.value == "") {
    mform.customer.focus();
    alert("고객사(등록Site)정보를 입력해주세요.");
    return false
  }

var work_text=document.getElementsByName('work_text[]');
var str="";
var i=0;


for(i;i<work_text.length;i++){
	document.getElementsByName('work_text[]')[i].value = work_text[i].value.replace(/\n/g,'<br/>');

}

  mform.submit();

 
  return false;
}


function addRow() {
  table = document.getElementById('input_table');
  rowCount = table.rows.length;
  row = table.insertRow(rowCount-7);
  var colCount = table.rows[k].cells.length;

  row.innerHTML = table.rows[k].innerHTML;

}

function deleteRow(tableID) {

 table = document.getElementById(tableID);
 row_count = table.rows.length;
 if (row_count > row_min ){
 table.deleteRow( table.rows.length-8);
 } else {
  alert("적어도 하나의 지원내역이 필요합니다.");
 }

}

</script>
<body>
  <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
    <script src="<?php echo $misc;?>ckeditor/ckeditor.js"></script>

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
                 <li><a href='<?php echo site_url();?>/board/qna_list'><span>QnA</span></a></li>
                 <li><a href='<?php echo site_url();?>/board/faq_list'><span>FAQ</span></a></li>
                 <!-- 김수성 추가 2017-02-01 -->
                 <?php if( $lv == 2 || $lv == 3 ) {?>
                 <li><a href='<?php echo site_url();?>/tech_board/tech_doc_list'><span class="point">기술지원보고서</span></a></li>
                 <li><a href='<?php echo site_url();?>/tech_board/tech_device_list'><span>장비/시스템 등록</span></a></li>
                 <?php } ?><!-- 김수성 끝 나중에 다 고쳐야됨 -->
                 <li class='last'><a href='<?php echo site_url();?>/board/suggest_list'><span>건의사항</span></a></li>

               </ul>
             </div>

           </td>
           <td width="923" align="center" valign="top">

            <!-- 시작합니다. 여기서 부터  -->

            <form name="cform" action="<?php echo site_url();?>/tech_board/tech_doc_input_action" method="post" enctype="multipart/form-data" onSubmit="javascript:chkForm();return false;">
              <input type="hidden" name="seq" value="<?php echo $seq;?>">

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
                      <td width="35%"  style="padding-left:10px;" class="t_border"><select name="customer" id="customer" class="input2" onChange="javascript:test3(<?php echo $view_val ?>);return false;">
                        <?php
                        foreach ($customer  as $val) {
                          echo '<option value="'.$val['customer'].'"';
                          if( $view_val['customer'] && ( $val['customer'] == $view_val['customer'] ) ) {
                            echo 'selected';
                          }
                          echo '>'.$val['customer'].'</option>';
                        }
                        ?>

                      </select></td>
                      <td idth="15%" height="40" align="center" bgcolor="f8f8f9"  style="font-weight:bold;" class="t_border">등록자</td>
                      <td width="35%" align="center" class="t_border"><input type="hidden" id="writer" name="writer" value="<?php echo $view_val['writer'];?>"><?php echo $view_val['writer'];?></td>
                    </tr>
                    <tr>
                      <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                    </tr>

                    <tr>
                      <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border" >작업명(종류)</td>
                      <td width="35%" style="padding-left:10px;"class="t_border" >

                        <select name="work_name" id="work_name" class="input2" onChange="change();">
                          <option value="정기점검">정기점검</option>
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
                          for(i=0; i< work_name_s.options.length; i++){
                            if( work_name_s.options[i].value == '<?php echo $view_val['work_name'] ; ?>')
                            {
                             work_name_s.options[i].selected = true;
                             break;
                           }
                         }
                       </script>

                       <!--                    <input type="text" name="work_name" id="work_name" class="input2"/> -->
                     </td>
                     <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border" >작업일</td>
                     <td width="35%" style="padding-left:10px;" class="t_border"><input type="date" name="income_time" id="income_time" class="input2" value="<?php echo substr($view_val['income_time'], 0, 10);?>"></td>
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
                          for(i=0; i< err_type_s.options.length; i++){
                            if( err_type_s.options[i].value == '<?php echo $view_val['err_type'] ; ?>')
                            {
                             err_type_s.options[i].selected = true;
                             break;
                           }
                         }
                       </script>
            </td>
            <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">심각도</td>
	  <td width="35%" style="padding-left:10px;" class="t_border">
              <select name="warn_level" id="warn_level" class="input2" >
                <option value="001">전체서비스중단</option>
                <option value="002">일부서비스중단/서비스지연</option>
                <option value="003">관리자불편/대고객신뢰도저하</option>
                <option value="004">특정기능장애</option>
                <option value="005">서비스무관단순장애</option>
              </select>
</td>
                        <script language="javascript">
                          var warn_level_s = document.getElementById("warn_level");
                          for(i=0; i< warn_level_s.options.length; i++){
                            if( warn_level_s.options[i].value == '<?php echo $view_val['warn_level'] ; ?>')
                            {
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
                        <script language="javascript">
                          var warn_type_s = document.getElementById("warn_type");
                          for(i=0; i< warn_type_s.options.length; i++){
                            if( warn_type_s.options[i].value == '<?php echo $view_val['warn_type'] ; ?>')
                            {
                             warn_type_s.options[i].selected = true;
                             break;
                           }
                         }
                       </script>
            <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">장애처리방법</td>
            <td width="35%" style="padding-left:10px;" class="t_border">
              <select name="work_action" id="work_action" class="input2" >
		<option value="001">기타지원</option>
                <option value="002">설정지원</option>
                <option value="003">장비교체</option>
                <option value="004">업그레이드</option>
                <option value="005">패치</option>
                <option value="006">협의중</option>
              </select></td>
                        <script language="javascript">
                          var work_action_s = document.getElementById("work_action");
                          for(i=0; i< work_action_s.options.length; i++){
                            if( work_action_s.options[i].value == '<?php echo $view_val['work_action'] ; ?>')
                            {
                             work_action_s.options[i].selected = true;
                             break;
                           }
                         }
                       </script>
          </tr>




                   <tr>
                    <td colspan="5" height="1" bgcolor="#e8e8e8" class="t_border" ></td>
                  </tr>
                  <tr>
                    <td colspan="2" width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">담당자명</td>
                    <td width="35%" style="padding:10px;"class="t_border" class="t_border">
                      <input type="text" name="customer_manager" id="customer_manager" class="input2" value="<?php echo $view_val['customer_manager'];?>"  >
                    </td>
                    <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">투입시간</td>
                    <td width="35%" style="padding:10px;" class="t_border" >자동입력</td>
                  </tr>
                  <tr>
                    <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                    <td colspan="2" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">시작시간</td>
                    <td  style="padding-left:10px;" class="t_border">
                      <input type="time" name="start_time" id="start_time" class="input2" value="<?php echo $view_val['start_time'];?>"/>
                    </td>
                    <td align="center" bgcolor="f8f8f9"  style="font-weight:bold;" class="t_border">종료시간</td>
                    <td  style="padding:10px;" class="t_border">
                      <input type="time" name="end_time" id="end_time" class="input2" value="<?php echo $view_val['end_time'];?>">
                    </td>
                  </tr>
                  <tr>
                    <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                    <td colspan="2" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">담당SE</td>
                    <td  style="padding-left:10px;" class="t_border">
                      <input type="text" name="engineer" id="engineer" class="input2" value="<?php echo $view_val['engineer'];?>" onclick="test2();"  readonly >
                    </td>
                    <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">지원방법</td>
                    <td width="35%" style="padding-left:10px;" class="t_border">
                      <select name="handle" id="handle" class="input2">
                        <option value="현장지원">현장지원</option>
                        <option value="원격지원">원격지원</option>
                      </select>
                      <script language="javascript">
                        var handle_s = document.getElementById("handle");
                        for(i=0; i< handle_s.options.length; i++){
                          if( handle_s.options[i].value == '<?php echo $view_val['handle'] ; ?>')
                          {
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
                  <td colspan="2" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">제품명</td>
                  <td  style="padding-left:10px;" class="t_border">
                    <input type="text" name="produce" id="produce" class="input2_red" value="<?php echo $view_val['produce'];?>"  onclick="test(document.cform.customer.value);" readonly >
                  </td>
                  <td align="center" bgcolor="f8f8f9"  style="font-weight:bold;" class="t_border">버전정보</td>
                  <td  style="padding-left:10px;" class="t_border">
                    <input type="text" name="version" id="version" class="input2_blue" value="<?php echo $view_val['version'];?>" readonly>
                  </td>
                </tr>
                <tr>
                  <td colspan="5" height="1" bgcolor="#e8e8e8" ></td>
                </tr>
                <tr>
                  <td colspan="2" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">서버</td>
                  <td  style="padding-left:10px;" class="t_border">
                    <input type="text" name="hardware" id="hardware" class="input2_blue" value="<?php echo $view_val['hardware'];?>" readonly>
                  </td>
                  <td align="center" bgcolor="f8f8f9"  style="font-weight:bold;" class="t_border">라이선스</td>
                  <td  style="padding-left:10px;" class="t_border">
                    <input type="text" name="license" id="license" class="input2_blue" value="<?php echo $view_val['license'];?>" readonly >
                    <input type="hidden" name="serial" id="serial" class="input2_blue" value="<?php echo $view_val['sn'];?>" readonly >
                  </td>
                </tr>
                <tr>
                  <td colspan="5" height="1" bgcolor="#e8e8e8"></td>
                </tr>
                <tr>
                  <td colspan="2" size="100" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">지원내용</td>
                  <td colspan="3"  style="padding-left:10px;" style="width:95%; max-width:720px;" class="t_border">
                    <input type="text" name="subject" id="subject" class="input2" style="width:95%; max-width:720px;" value="<?php echo $view_val['subject'];?>">
                  </td>
                </tr>
                <tr>
                  <td colspan="5" height="1" bgcolor="#797c88"></td>
                </tr>
                <tr>
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

                for($i=0;$i<count($tmp)-1;$i++){

                  $time = explode("-",$tmp[$i]);

                  ?>
                  <tr>
                    <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">
                      <input type="text" name="work_time_s[]" id="work_time_s[]"  size="2"  value="<?php echo $time[0];?>" >
                    </td>
                    <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">
                      <input type="text" name="work_time_e[]" id="work_time_e[]" size="2" value="<?php echo $time[1];?>" >
                    </td>
                    <td colspan="4" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold; padding: 12px; " class="t_border">
                      <textarea rows="5" style="width:95%; max-width:720px;" name="work_text[]" id="work_text[]" value="<?php echo $process_txt[$i];?>"><?php echo $process_txt[$i];?></textarea>
                    </td>
                  </tr>
                  <?php
                }

                ?>

                <tr>
                  <td colspan="5" height="1" bgcolor="#797c88"></td>
                </tr>
                  <td colspan="2" size="100" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">지원의견</td>
                    <td colspan="4" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold; padding: 12px; " class="t_border">
                      <textarea rows="5" style="width:95%; max-width:720px;" name="comment" id="comment" value="<?php echo  $view_val['comment'];?>"><?php echo  $view_val['comment'];?></textarea>
                    </td>
                <tr>
                  <td colspan="5" height="1" bgcolor="#797c88"></td>
                </tr>
                <tr>
                  <td colspan="2" size="100" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">지원결과</td>
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
              <td colspan="2" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">첨부파일</td>
<td class="t_border" style="padding-left:10px;" colspan="3"><?php if($view_val['file_changename']) {?><a href="<?php echo site_url();?>/tech_board/tech_doc_download/<?php echo $seq;?>/<?php echo $view_val['file_changename'];?>"><?php echo $view_val['file_realname'];?></a> <a href="javascript:filedel('<?php echo $seq;?>','<?php echo $view_val['file_changename'];?>');"><img src="<?php echo $misc;?>img/del.png" width="8" height="8" /></a>&nbsp;&nbsp;<input name="cfile" id="cfile" type="file" size="78" disabled><?php } else {?><input name="cfile" type="file" size="78"> <span class="point0 txt_s">(용량제한 100MB)<?php }?> </td>
            </tr>

                <tr>
                  <td colspan="5" height="2" bgcolor="#797c88"></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td align="right">
                <!--지원내용 추가 버튼-->
                <img src="<?php echo $misc;?>img/btn_add_column3.jpg" width="64" height="31" style="cursor:pointer" onclick="addRow('input_table');return false;"/>
                <img src="<?php echo $misc;?>img/btn_add_column4.jpg" width="64" height="31" style="cursor:pointer" onclick="deleteRow('input_table');return false;"/>

                <input type="image" src="<?php echo $misc;?>img/btn_adjust.jpg" width="64" height="31" style="cursor:pointer" onClick="javascript:chkForm();return false;"/>
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
              <select name="err_type" id="err_type" class="input2">
                <option value="HW">HW</option>
                <option value="SW">SW</option>
              </select>
                        <script language="javascript">
                          var err_type_s = document.getElementById("err_type");
                          for(i=0; i< err_type_s.options.length; i++){
                            if( err_type_s.options[i].value == '<?php echo $view_val['err_type'] ; ?>')
                            {
                             err_type_s.options[i].selected = true;
                             break;
                           }
                         }
                       </script>
            </td>
            <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">심각도</td>
	  <td width="35%" style="padding-left:10px;" class="t_border">
              <select name="warn_level" id="warn_level" class="input2" >
                <option value="001">전체서비스중단</option>
                <option value="002">일부서비스중단/서비스지연</option>
                <option value="003">관리자불편/대고객신뢰도저하</option>
                <option value="004">특정기능장애</option>
                <option value="005">서비스무관단순장애</option>
              </select></td>
                        <script language="javascript">
                          var warn_level_s = document.getElementById("warn_level");
                          for(i=0; i< warn_level_s.options.length; i++){
                            if( warn_level_s.options[i].value == '<?php echo $view_val['warn_level'] ; ?>')
                            {
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
                        <script language="javascript">
                          var warn_type_s = document.getElementById("warn_type");
                          for(i=0; i< warn_type_s.options.length; i++){
                            if( warn_type_s.options[i].value == '<?php echo $view_val['warn_type'] ; ?>')
                            {
                             warn_type_s.options[i].selected = true;
                             break;
                           }
                         }
                       </script>
            <td width="15%" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;" class="t_border">장애원인</td>
            <td width="35%" style="padding-left:10px;" class="t_border">
              <select name="work_action" id="work_action" class="input2" >
		<option value="001">기술지원</option>
                <option value="002">설정지원</option>
                <option value="003">장비교체</option>
                <option value="004">업그레이드</option>
                <option value="005">패치</option>
                <option value="006">협의중</option>
              </select></td>
                        <script language="javascript">
                          var work_action_s = document.getElementById("work_action");
                          for(i=0; i< work_action_s.options.length; i++){
                            if( work_action_s.options[i].value == '<?php echo $view_val['work_action'] ; ?>')
                            {
                             work_action_s.options[i].selected = true;
                             break;
                           }
                         }
                       </script>

          </tr>
</table>


</body>
</html>
