<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<style type="text/css">
.ui-datepicker{ font-size: 13.2px; width: 293px; height:190px; z-index:100; margin-left:10px;} 

#dropdown-list, .k-animation-container, .k-list-container
{
	font-size:12px !important;
	visibility:hidden !important;
}
.k-input
{
	/*padding-bottom:25px !important;*/
}

#ui-datepicker-div
{
	height:210px;
}
</style>
<script>
$(function() {
	$("#service_add").click(function() {
		$("#row_max_index").val(Number(Number($("#row_max_index").val()) + Number(1)));
		var id = "service_insert_field_" + $("#row_max_index").val();
		var id2 = "service_insert_field_2_" + $("#row_max_index").val();
		$('#service_list').after("<tr id=" + id + "><td colspan='9' height='1' bgcolor='#e8e8e8'></td></tr><tr id=" + id2 + "><td height='40' align='center'><input name='service_supply' type='text' class='input2' id='service_supply' /></td><td align='center' class='t_border' ><input name='expert_work' type='text' class='input2' id='expert_work' /></td><td align='center' class='t_border' ><img src='<?php echo $misc;?>img/btn_del0.jpg' style='cursor:pointer;' onclick='javascript:service_list_del(" + $("#row_max_index").val() + ");'/></td></tr>");
	});

	$("#project_add").click(function() {
		$("#row_max_index2").val(Number(Number($("#row_max_index2").val()) + Number(1)));
		var id = "project_insert_field_" + $("#row_max_index2").val();
		var id2 = "project_insert_field_2_" + $("#row_max_index2").val();
		$('#project_list').after("<tr id=" + id + "><td colspan='9' height='1' bgcolor='#e8e8e8'></td></tr><tr id=" + id2 + "><td height='40' align='center'><input name='project_name' type='text' class='input' id='project_name' /></td><td align='center' class='t_border' ><input name='perform_company' type='text' class='input1' id='perform_company' /></td><td align='center' class='t_border' ><input name='start_date' type='text' class='input1' id='start_date' onclick='checkNum(this);' onKeyUp='checkNum(this);'/></td><td align='center' class='t_border' ><input name='end_date' type='text' class='input1' id='end_date' onclick='checkNum(this);' onKeyUp='checkNum(this);'/></td><td align='center' class='t_border' ><input name='main_role' type='text' class='input' id='main_role' /></td><td align='center' class='t_border' ><input name='main_service' type='text' class='input' id='main_service' /></td><td align='center' class='t_border' ><input name='expertise' type='text' class='input1' id='expertise' /></td><td align='center' class='t_border' ><input name='solution' type='text' class='input1' id='solution' /></td><td align='center' class='t_border' ><img src='<?php echo $misc;?>img/btn_del0.jpg' style='cursor:pointer;' onclick='javascript:project_list_del(" + $("#row_max_index2").val() + ");'/></td></tr>");
	});
});

function checkNum(obj) {
	var word = obj.value;
	var str = "1234567890-";
	for (i=0;i< word.length;i++){
		if(str.indexOf(word.charAt(i)) < 0){
			alert("숫자 조합만 가능합니다.");
			obj.value="";
			obj.focus();
			return false;
		}
	}
}

function service_list_del(idx)
{
	$("#service_insert_field_" + idx).remove();
	$("#service_insert_field_2_" + idx).remove();
}
function project_list_del(idx)
{
	$("#project_insert_field_" + idx).remove();
	$("#project_insert_field_2_" + idx).remove();
}
</script>
<script language="javascript">
function chkForm () {
	var mform = document.cform;
	
	var objservice_supply = document.getElementsByName("service_supply");
	var objexpert_work = document.getElementsByName("expert_work");
	
//	if(objservice_supply.length > 0) {
//		for(i=0; i<objservice_supply.length; i++) {
//			if($.trim(objservice_supply[i].value) == "") {
//				alert(i+1 + '번째 서비스제공을 입력해 주세요.');
//				objservice_supply[i].focus();
//				return;	
//			}
//			if($.trim(objexpert_work[i].value) == "") {
//				alert(i+1 + "번째 세부전문업무를 입력하십시오.");
//				objexpert_work[i].focus();
//				return;	
//			}
//		}
//	}
	
	var objproject_name = document.getElementsByName("project_name");
	var objperform_company = document.getElementsByName("perform_company");
	var objstart_date = document.getElementsByName("start_date");
	var objend_date = document.getElementsByName("end_date");
	var objmain_role = document.getElementsByName("main_role");
	var objmain_service = document.getElementsByName("main_service");
	var objexpertise = document.getElementsByName("expertise");
	var objsolution = document.getElementsByName("solution");
	
//	if(objproject_name.length > 0) {
//		for(i=0; i<objproject_name.length; i++) {
//			if($.trim(objproject_name[i].value) == "") {
//				alert(i+1 + '번째 프로젝트명을 입력해 주세요.');
//				objproject_name[i].focus();
//				return;	
//			}
//			if($.trim(objperform_company[i].value) == "") {
//				alert(i+1 + "번째 수행처를 입력하십시오.");
//				objperform_company[i].focus();
//				return;	
//			}
//			if($.trim(objstart_date[i].value) == "") {
//				alert(i+1 + "번째 투입시작일을 입력하십시오.");
//				objstart_date[i].focus();
//				return;	
//			}
//			if($.trim(objend_date[i].value) == "") {
//				alert(i+1 + "번째 투입종료일을 입력하십시오.");
//				objend_date[i].focus();
//				return;	
//			}
//			if($.trim(objmain_role[i].value) == "") {
//				alert(i+1 + "번째 주요역할을 입력하십시오.");
//				objmain_role[i].focus();
//				return;	
//			}
//			if($.trim(objmain_service[i].value) == "") {
//				alert(i+1 + "번째 주요서비스제공을 입력하십시오.");
//				objmain_service[i].focus();
//				return;	
//			}
//			if($.trim(objexpertise[i].value) == "") {
//				alert(i+1 + "번째 활용전문기술을 입력하십시오.");
//				objexpertise[i].focus();
//				return;	
//			}
//			if($.trim(objsolution[i].value) == "") {
//				alert(i+1 + "번째 활용전문솔루션을 입력하십시오.");
//				objsolution[i].focus();
//				return;	
//			}
//		}
//	}

	$("#service_array").val('');
	if(objservice_supply.length > 0) {
		for(i=0; i<objservice_supply.length; i++) {
			$("#service_array").val($("#service_array").val() + "||" + objservice_supply[i].value + "~" + objexpert_work[i].value);
		}
	}
	$("#project_array").val('');
	if(objproject_name.length > 0) {
		for(i=0; i<objproject_name.length; i++) {
			$("#project_array").val($("#project_array").val() + "||" + objproject_name[i].value + "~" + objperform_company[i].value+ "~" + objstart_date[i].value+ "~" + objend_date[i].value+ "~" + objmain_role[i].value+ "~" + objmain_service[i].value+ "~" + objexpertise[i].value+ "~" + objsolution[i].value);
		}
	}
	
//	if (mform.homepage.value == "") {
//		mform.homepage.focus();
//		alert("홈페이지를 입력해 주세요.");
//		return false;
//	}

	mform.submit();
	return false;
}

</script>
<body>
<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
<form name="cform" action="<?php echo site_url();?>/admin/customer/customer_input_action4" method="post" onSubmit="javascript:chkForm();return false;">
<input type="hidden" id="service_array" name="service_array" />
<input type="hidden" id="project_array" name="project_array" />
<input type="hidden" id="row_max_index" name="row_max_index" value="0"/>
<input type="hidden" id="row_max_index2" name="row_max_index2" value="0"/>
<input type="hidden" name="seq" value="<?php echo $seq;?>">
<input type="hidden" name="mode" value="0">
  <tr>
    <td align="center" valign="top">
    <table width="1130" height="100%" cellspacing="0" cellpadding="0" >
        <tr>
           <td width="923" align="center" valign="top">
            
            <!--내용-->
            <table width="1100" border="0" style="margin-top:50px; margin-bottom: 50px;">
              <!--타이틀-->
              <tr>
                <td class="title3">거래처</td>
              </tr>
              <!--//타이틀-->
              <tr>
                <td>&nbsp;</td>
              </tr>
			 <!--탭-->
              <tr>
              	<td height="40">
                    <ul style="list-style:none; padding:0; margin:0;">
                    <li style="float:left;"><img src="<?php echo $misc;?>img/sales_tab_1.jpg" /></li>
                    <li style="float:left;"><img src="<?php echo $misc;?>img/sales_tab_2.jpg" /></li>
                    <li style="float:left;"><img src="<?php echo $misc;?>img/sales_tab_3.jpg" /></li>
                    <li style="float:left;"><img src="<?php echo $misc;?>img/sales_tab_4_on.jpg" /></li>
                    <li style="float:left;"><img src="<?php echo $misc;?>img/sales_tab_5.jpg" /></li>
                    <li style="float:left;"><img src="<?php echo $misc;?>img/sales_tab_6.jpg" /></li>
                    </ul>
                </td>
              </tr>
              <!--//탭-->
              <tr>
                <td>&nbsp;</td>
              </tr>
              
              <!--서비스 제공정보-->
              <tr>
                <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <colgroup>
                  	<col width="42%" />
                    <col width="43%" />
                    <col width="5%" />
                  </colgroup>
                  <!--시작라인-->
                  <tr>
                    <td colspan="3" height="2" bgcolor="#797c88"></td>
                  </tr>
                  <!--//시작라인-->
                  <tr>
                    <td height="40" colspan="3" align="center" style="font-weight:bold; font-size:16px;">서비스 제공 정보</td>
                  </tr>
                  <tr>
                    <td colspan="3" height="1" bgcolor="#797c88"></td>
                  </tr>
                  
                  <tr>
                    <td height="40" align="center" bgcolor="f8f8f9" >서비스제공</td>
                    <td align="center" class="t_border" bgcolor="f8f8f9" >세부전문업무</td>
                    <td align="center" class="t_border" bgcolor="f8f8f9" ><img src="<?php echo $misc;?>img/btn_add.jpg" id="service_add" name="service_add" style="cursor:pointer;"/></td>
                  </tr>
                  
                  <!--추가항목-->
                  <tr>
                    <td colspan="9" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr id="service_list">
                    <td height="40" align="center"><input name="service_supply" type="text" class="input2" id="service_supply" /></td>
                    <td align="center" class="t_border" ><input name="expert_work" type="text" class="input2" id="expert_work" /></td>
                    <td align="center" class="t_border" ><!-- <img src="<?php echo $misc;?>img/btn_del0.jpg" /> --></td>
                  </tr>
                  <!--//추가항목-->

                  <!--마지막라인-->
                  <tr>
                    <td colspan="9" height="2" bgcolor="#797c88"></td>
                  </tr>
                  <!--//마지막라인-->                
                </table></td>
              </tr>
              <!--//서비스 제공정보-->
              <tr>
              	<td>&nbsp;</td>
              </tr>
              <!--수행이력정보-->
              <tr>
                <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <colgroup>
                  	<col width="15%" />
                    <col width="10%" />
                    <col width="10%" />
                    <col width="10%" />
                    <col width="15%" />
                    <col width="15%" />
                    <col width="10%" />
                    <col width="10%" />
                    <col width="5%" />
                  </colgroup>
                  <!--시작라인-->
                  <tr>
                    <td colspan="9" height="2" bgcolor="#797c88"></td>
                  </tr>
                  <!--//시작라인-->
                  <tr>
                    <td height="40" colspan="9" align="center" style="font-weight:bold; font-size:16px;">프로젝트 수행이력 정보</td>
                  </tr>  
                  <tr>
                    <td colspan="9" height="1" bgcolor="#797c88"></td>
                  </tr>
                  
                  <tr>
                    <td height="40" align="center" bgcolor="f8f8f9" >프로젝트명</td>
                    <td align="center" class="t_border" bgcolor="f8f8f9" >수행처(발주처)</td>
                    <td align="center" class="t_border" bgcolor="f8f8f9" >투입시작일<br>(예)2015-01-01</td>
                    <td align="center" class="t_border" bgcolor="f8f8f9" >투입종료일<br>(예)2015-01-01</td>
                    <td align="center" class="t_border" bgcolor="f8f8f9" >주요역할</td>
                    <td align="center" class="t_border" bgcolor="f8f8f9" >주요서비스제공</td>
                    <td align="center" class="t_border" bgcolor="f8f8f9" >활용전문기술</td>
                    <td align="center" class="t_border" bgcolor="f8f8f9" >활용전문솔루션</td>
                    <td align="center" class="t_border" bgcolor="f8f8f9" ><img src="<?php echo $misc;?>img/btn_add.jpg" id="project_add" name="project_add" style="cursor:pointer;"/></td>
                  </tr>
                  
                  <!--추가항목-->
                  <tr>
                    <td colspan="9" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr id="project_list">
                    <td height="40" align="center"><input name="project_name" type="text" class="input" id="project_name" /></td>
                    <td align="center" class="t_border" ><input name="perform_company" type="text" class="input1" id="perform_company" /></td>
                    <td align="center" class="t_border" ><input name="start_date" type="text" class="input1" id="start_date" onclick="checkNum(this);" onKeyUp="checkNum(this);"/></td>
                    <td align="center" class="t_border" ><input name="end_date" type="text" class="input1" id="end_date" onclick="checkNum(this);" onKeyUp="checkNum(this);"/></td>
                    <td align="center" class="t_border" ><input name="main_role" type="text" class="input" id="main_role" /></td>
                    <td align="center" class="t_border" ><input name="main_service" type="text" class="input" id="main_service" /></td>
                    <td align="center" class="t_border" ><input name="expertise" type="text" class="input1" id="expertise" /></td>
                    <td align="center" class="t_border" ><input name="solution" type="text" class="input1" id="solution" /></td>
                    <td align="center" class="t_border" ><!-- <img src="<?php echo $misc;?>img/btn_del0.jpg" /> --></td>
                  </tr>
                  <!--//추가항목-->

                  <!--마지막라인-->
                  <tr>
                    <td colspan="9" height="2" bgcolor="#797c88"></td>
                  </tr>
                  <!--//마지막라인-->                
                </table></td>
              </tr>
              <!--//수행이력정보-->
              <tr>
              	<td>&nbsp;</td>
              </tr>
              <!--기타사항-->
              <tr>
                <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <colgroup>
                  	<col width="15%" />
                    <col width="85%" />
                  </colgroup>
                  <!--시작라인-->
                  <tr>
                    <td colspan="2" height="2" bgcolor="#797c88"></td>
                  </tr>
                  <!--//시작라인-->
                  <tr>
                    <td height="40" colspan="2" align="center" style="font-weight:bold; font-size:16px;">기타사항</td>
                  </tr>  
                  <tr>
                    <td colspan="4" height="1" bgcolor="#797c88"></td>
                  </tr>
                  
                  <tr>
                    <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">홈페이지</td>
                    <td align="left" class="t_border" style="padding-left:10px;" ><input name="homepage" type="text" class="input2" id="homepage"/> <span style="color:#666; font-size:12px;">예) http://www.durianit.co.kr</span></td>
                  </tr>

                  <!--마지막라인-->
                  <tr>
                    <td colspan="2" height="2" bgcolor="#797c88"></td>
                  </tr>
                  <!--//마지막라인-->                
                </table></td>
              </tr>
              <!--//기타사항-->
              
              <tr>
                <td height="10"></td>
              </tr>
              <!--버튼-->
               <tr>
                <td align="right"><input type="image" src="<?php echo $misc;?>img/btn_b_next.jpg" width="64" height="31" style="cursor:pointer" onclick="javascript:chkForm();return false;"/> <a href="<?php echo site_url();?>/admin/customer/customer_list"><img src="<?php echo $misc;?>img/btn_list.jpg" width="64" height="31" border="0"/></a></td>
              </tr>
              <!--//버튼-->
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table>
            <!--//내용-->
            
            </td>
          
        </tr>
     </table>
    
    </td>
  </tr>
</form>
</table>
<!--하단-->
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
<!--//하단-->
</body>
</html>