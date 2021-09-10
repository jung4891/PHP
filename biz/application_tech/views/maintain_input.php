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
	//미니달력 공통 설정
	$.datepicker.setDefaults({
		showMonthAfterYear:true,
		dateFormat: 'yy-mm-dd',
		//buttonImageOnly: true,
		buttonImageOnly: true,
//		showOn: "both",
		//buttonText: "달력",
		changeYear: true,
		changeMonth: true,
		yearRange: 'c-100:c+10',
		nextText: '>',
		prevText: '<',
		dayNamesMin: ['월', '화', '수', '목', '금', '토', '일'], // 요일의 한글 형식.
		monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'], // 월의 한글 형식.
		yearSuffix: '년',
		buttonImage: "<?php echo $misc;?>img/btn_calendar.jpg",
		regional: 'ko'
	});

	$("#exception_saledate").datepicker();
	$("#exception_saledate2").datepicker();

	$("img.ui-datepicker-trigger").attr("style", "align=center; margin-left:4px; cursor: Pointer;");

	$("#main_add").click(function() {
		$("#row_max_index").val(Number(Number($("#row_max_index").val()) + Number(1)));
		var id = "main_insert_field_" + $("#row_max_index").val();
		var id2 = "main_insert_field_2_" + $("#row_max_index").val();

		 $('#main_list tr:eq(9)').after("<tr id=" + id + "><td colspan='9' height='1' bgcolor='#e8e8e8'></td></tr><tr id=" + id2 + "><td height='40' align='center' bgcolor='f8f8f9' style='font-weight:bold;'>주사업자</td><td align='left' class='t_border' style='padding-left:10px;'><input name='main_companyname' type='text' class='input5' id='main_companyname'/></td><td align='center' bgcolor='f8f8f9' class='t_border' style='font-weight:bold;'>담당자</td><td align='left' class='t_border' style='padding-left:10px;'><input name='main_username' type='text' class='input5' id='main_username'/></td><td align='center' bgcolor='f8f8f9' class='t_border' style='font-weight:bold;'>연락처</td><td align='left' class='t_border' style='padding-left:10px;'><input name='main_tel' type='text' class='input5' id='main_tel' onclick='checkNum(this);' onKeyUp='checkNum(this);'/></td><td align='center' bgcolor='f8f8f9' class='t_border' style='font-weight:bold;'>이메일</td><td align='left' class='t_border' colspan='2' style='padding-left:10px;'><input name='main_email' type='text' class='input5' id='main_email'/></td><td align='left' style='padding-left:10px;'><img src='<?php echo $misc;?>img/btn_del0.jpg' style='cursor:pointer;' onclick='javascript:main_list_del(" + $("#row_max_index").val() + ");'/></td></tr>");
	});

	$("#product_add").click(function() {
		$("#row_max_index2").val(Number(Number($("#row_max_index2").val()) + Number(1)));
		var id3 = "product_insert_field_" + $("#row_max_index2").val();
		var id4 = "product_insert_field_2_" + $("#row_max_index2").val();

		  $('#product_data_field').after("<tr id=" + id3 + "><td colspan='9' height='1' bgcolor='#e8e8e8'></td></tr><tr id=" + id4 + "><td height='40' align='center' bgcolor='f8f8f9' style='font-weight:bold;'>제품명</td><td align='left' class='t_border' style='padding-left:10px;' colspan='1'><select name='product_name' id='product_name' class='input7'><option value='0'>제품명 (제조사-품목)</option><?php
			 foreach ($product as $val) {
				echo "<option value='".$val['seq']."'>".$val['product_name']." (".$val['product_company']."-".$val['product_item'].")</option>";
		     }
		?></select></td><td height='40' align='center' bgcolor='f8f8f9' class='t_border' style='font-weight:bold;'>라이선스</td><td align='left' class='t_border' style='padding-left:10px;'><input name='product_licence' type='text' class='input5' id='product_licence' /> </td><td height='40' align='center' bgcolor='f8f8f9' class='t_border' style='font-weight:bold;'>Serial</td><td align='left' class='t_border' style='padding-left:10px;'><input name='product_serial' type='text' class='input5' id='product_serial' /> </td><td height='40' align='center' bgcolor='f8f8f9' class='t_border' style='font-weight:bold;'>제품 상태</td><td align='left' class='t_border' style='padding-left:10px;'><select name='product_state' id='product_state' class='input5'><option value='0'>- 제품 상태 -</option><option value='001'>입고 전</option><option value='002'>창고</option><option value='003'>고객사 출고</option><option value='004'>장애반납</option></select></td><td align='center'><input type='checkbox' name='maintain_yn' id='maintain_yn'></td><td align='center'  colspan='1' ><img src='<?php echo $misc;?>img/btn_del0.jpg' style='cursor:pointer;' onclick='javascript:product_list_del(" + $("#row_max_index2").val() + ");'/></td></tr>");
	});
});

function main_list_del(idx)
{
	$("#main_insert_field_" + idx).remove();
	$("#main_insert_field_2_" + idx).remove();
}

function product_list_del(idx)
{
	$("#product_insert_field_" + idx).remove();
	$("#product_insert_field_2_" + idx).remove();
}
</script>
<script language="javascript">
function checkNum(obj) {
	var word = obj.value;
	var str = "1234567890";
	for (i=0;i< word.length;i++){
		if(str.indexOf(word.charAt(i)) < 0){
			alert("숫자 조합만 가능합니다.");
			obj.value="";
			obj.focus();
			return false;
		}
	}
}

var chkForm = function () {
	var mform = document.cform;

	if (mform.customer_companyname.value == "") {
		mform.customer_companyname.focus();
		alert("고객사를 입력해 주세요.");
		return false;
	}
	if (mform.customer_username.value == "") {
		mform.customer_username.focus();
		alert("담당자를 입력해 주세요.");
		return false;
	}
	if (mform.customer_tel.value == "") {
		mform.customer_tel.focus();
		alert("연락처 입력해 주세요.");
		return false;
	}
	if (mform.customer_email.value == "") {
		mform.customer_email.focus();
		alert("이메일을 입력해 주세요.");
		return false;
	}
	var regex=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
	if(regex.test(mform.customer_email.value) === false) {
		alert("잘못된 이메일 형식입니다.");
		mform.customer_email.focus();
		return false;
	}

	if (mform.project_name.value == "") {
		mform.project_name.focus();
		alert("프로젝트명을 입력해 주세요.");
		return false;
	}
	if (mform.progress_step.value == "0") {
		mform.progress_step.focus();
		alert("진척단계를 선택해 주세요.");
		return false;
	}
	if (mform.cooperation_companyname.value == "") {
		mform.cooperation_companyname.focus();
		alert("협력사를 입력해 주세요.");
		return false;
	}
	if (mform.cooperation_username.value == "") {
		mform.cooperation_username.focus();
		alert("담당자를 입력해 주세요.");
		return false;
	}
	if (mform.cooperation_tel.value == "") {
		mform.cooperation_tel.focus();
		alert("연락처를 입력해 주세요.");
		return false;
	}
	if (mform.cooperation_email.value == "") {
		mform.cooperation_email.focus();
		alert("이메일을 입력해 주세요.");
		return false;
	}
	var regex2=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
	if(regex2.test(mform.cooperation_email.value) === false) {
		alert("잘못된 이메일 형식입니다.");
		mform.cooperation_email.focus();
		return false;
	}

	var objmain_companyname = document.getElementsByName("main_companyname");
	var objmain_username = document.getElementsByName("main_username");
	var objmain_tel = document.getElementsByName("main_tel");
	var objmain_email = document.getElementsByName("main_email");

	if(objmain_companyname.length > 0) {
		for(i=0; i<objmain_companyname.length; i++) {
			if($.trim(objmain_companyname[i].value) == "") {
				alert(i+1 + '번째 주사업자를 입력해주세요..');
				objmain_companyname[i].focus();
				return;
			}
			if($.trim(objmain_username[i].value) == "") {
				alert(i+1 + "번째 담당자를 입력하십시오.");
				objmain_username[i].focus();
				return;
			}
			if($.trim(objmain_tel[i].value) == "") {
				alert(i+1 + "번째 연락처를 입력하십시오.");
				objmain_tel[i].focus();
				return;
			}
			if($.trim(objmain_email[i].value) == "") {
				alert(i+1 + "번째 이메일을 입력하십시오.");
				objmain_email[i].focus();
				return;
			}
			var regex3=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
			if(regex3.test(objmain_email[i].value) === false) {
				alert("잘못된 이메일 형식입니다.");
				objmain_email[i].focus();
				return false;
			}
		}
	}

	var objproduct_name = document.getElementsByName("product_name");
	var objproduct_serial = document.getElementsByName("product_serial");
	var objproduct_state = document.getElementsByName("product_state");
	var objproduct_licence = document.getElementsByName("product_licence");
	var objproduct_maintain_yn = document.getElementsByName("maintain_yn");

	if(objproduct_name.length > 0) {
		for(i=0; i<objproduct_name.length; i++) {
			if($.trim(objproduct_name[i].value) == "0") {
				alert(i+1 + '번째 제품명을 선택해주세요..');
				objproduct_name[i].focus();
				return;
			}
			// if($.trim(objproduct_serial[i].value) == "") {
			// 	alert(i+1 + "번째 시리얼을 입력하십시오.");
			// 	objproduct_serial[i].focus();
			// 	return;
			// }
			if($.trim(objproduct_state[i].value) == "0") {
				alert(i+1 + "번째 제품 상태를 선택해주세요.");
				objproduct_state[i].focus();
				return;
			}
		}
	}

	if (mform.exception_saledate.value == "") {
		mform.exception_saledate.focus();
		alert("예상매출일을 선택해 주세요.");
		return false;
	}
	if (mform.complete_status.value == "0") {
		mform.complete_status.focus();
		alert("수주여부를 선택해 주세요.");
		return false;
	}

	$("#main_array").val('');
	if(objmain_companyname.length > 0) {
		for(i=0; i<objmain_companyname.length; i++) {
			$("#main_array").val($("#main_array").val() + "||" + objmain_companyname[i].value + "~" + objmain_username[i].value + "~" + objmain_tel[i].value+ "~" + objmain_email[i].value);
			//alert($("#license_array").val());
		}
	}

	$("#product_array").val('');
	if(objproduct_name.length > 0) {
		for(i=0; i<objproduct_name.length; i++) {
			$("#product_array").val($("#product_array").val() + "||" + objproduct_name[i].value + "~" + objproduct_licence[i].value + "~" + objproduct_serial[i].value + "~" + objproduct_state[i].value + "~" + objproduct_maintain_yn[i].checked);
			//alert($("#license_array").val());
		}
	}

	mform.submit();
	return false;
}
</script>
<body>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
<form name="cform" action="<?php echo site_url();?>/maintain/maintain_input_action" method="post" onSubmit="javascript:chkForm();return false;">
<input type="hidden" id="main_array" name="main_array" />
<input type="hidden" id="product_array" name="product_array" />
<input type="hidden" id="row_max_index" name="row_max_index" value="0"/>
<input type="hidden" id="row_max_index2" name="row_max_index2" value="0"/>
<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/tech_header.php";
?>
  <tr>
    <td align="center" valign="top">
    <table width="1130" height="100%" cellspacing="0" cellpadding="0" >
        <tr>
            <td width="923" align="center" valign="top">
            <!--내용-->
            <table width="1100" border="0" style="margin-top:50px; margin-bottom: 50px;">
              <!--타이틀-->
              <tr>
                <td class="title3">유지보수</td>
              </tr>
              <!--//타이틀-->
              <tr>
                <td>&nbsp;</td>
              </tr>

              <!--작성-->
              <tr>
                <td><table width="100%" border="0" cellspacing="0" cellpadding="0" id="main_list">
                  <colgroup>
                    <col width="10%" />
                    <col width="13%" />
                    <col width="10%" />
                    <col width="12%" />
                    <col width="10%" />
                    <col width="15%" />
                    <col width="10%" />
                    <col width="10%" />
                    <col width="5%" />
                    <col width="5%" />
                  </colgroup>
                  <!--시작라인-->
                  <tr>
                    <td colspan="10" height="2" bgcolor="#797c88"></td>
                  </tr>
                  <!--//시작라인-->

                  <tr>
                    <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">고객사</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="customer_companyname" type="text" class="input5" id="customer_companyname"/></td>
                    <td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">담당자</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="customer_username" type="text" class="input5" id="customer_username"/></td>
                    <td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">연락처</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input type="text" name="customer_tel" id="customer_tel" class="input5" onclick="checkNum(this);" onKeyUp="checkNum(this);"/></td>
                    <td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">이메일</td>
                    <td colspan="2" align="left" class="t_border" style="padding-left:10px;"><input type="text" name="customer_email" id="customer_email" class="input5"/></td>
                  </tr>
                  <tr>
                    <td colspan="10" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                    <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">프로젝트</td>
                    <td colspan="8" align="left" class="t_border" style="padding-left:10px;"><input name="project_name" type="text" class="input2" id="project_name"/></td>
                  </tr>
                  <tr>
                    <td colspan="10" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                    <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">진척단계</td>
                    <td colspan="8" align="left" class="t_border" style="padding-left:10px;"><select name="progress_step" id="progress_step" class="input5">
					  <option value="0">-진척단계-</option>
                      <option value="001">영업보류(0%)</option>
                      <option value="002">고객문의(5%)</option>
					  <option value="003">영업방문(10%)</option>
                      <option value="004">일반제안(15%)</option>
					  <option value="005">견적제출(20%)</option>
                      <option value="006">맞춤제안(30%)</option>
					  <option value="007">수정견적(35%)</option>
                      <option value="008">RFI(40%)</option>
					  <option value="009">RFP(45%)</option>
                      <option value="010">BMT(50%)</option>
					  <option value="011">DEMO(55%)</option>
					  <option value="012">가격경쟁(60%)</option>
					  <option value="013">Spen in(70%)</option>
					  <option value="014">수의계약(80%)</option>
					  <option value="015">수주완료(85%)</option>
					  <option value="016">매출발생(90%)</option>
					  <option value="017">미수잔금(95%)</option>
					  <option value="018">수금완료(100%)</option>
                    </select></td>
                  </tr>
                  <tr>
                    <td colspan="10" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                    <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">협력사</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="cooperation_companyname" type="text" class="input5" id="cooperation_companyname"/></td>
                    <td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">담당자</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="cooperation_username" type="text" class="input5" id="cooperation_username"/></td>
                    <td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">연락처</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="cooperation_tel" type="text" class="input5" id="cooperation_tel" onclick="checkNum(this);" onKeyUp="checkNum(this);"/></td>
                    <td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">이메일</td>
                    <td colspan="2" align="left" class="t_border" style="padding-left:10px;"><input name="cooperation_email" type="text" class="input5" id="cooperation_email"/></td>
                  </tr>
                  <tr>
                    <td colspan="10" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                    <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">주사업자</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="main_companyname" type="text" class="input5" id="main_companyname"/></td>
                    <td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">담당자</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="main_username" type="text" class="input5" id="main_username"/></td>
                    <td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">연락처</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="main_tel" type="text" class="input5" id="main_tel" onclick="checkNum(this);" onKeyUp="checkNum(this);"/></td>
                    <td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">이메일</td>
                    <td align="left" colspan="2" class="t_border" style="padding-left:10px;"><input name="main_email" type="text" class="input5" id="main_email"/></td>
                    <td align="center"><img src="<?php echo $misc;?>img/btn_add.jpg" id="main_add" name="main_add" style="cursor:pointer;"/></td>
                  </tr>

                  <!--추가버튼 눌렀을때 오픈-->
                  <!-- <tr>
                    <td colspan="9" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                    <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">주사업자</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="textfield" type="text" class="input5" id="textfield" value="거래처1"/></td>
                    <td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">담당자</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="textfield" type="text" class="input5" id="textfield" value="나담당"/></td>
                    <td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">연락처</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="textfield" type="text" class="input5" id="textfield" value="000-0000"/></td>
                    <td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">이메일</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="textfield" type="text" class="input5" id="textfield" value="admin@"/></td>
                    <td align="left" style="padding-left:10px;"><a href="#" title="추가항목삭제" ><img src="<?php echo $misc;?>img/btn_del0.jpg" /></a></td>
                  </tr> -->
                  <!--//추가버튼 눌렀을때 오픈-->

                  <tr>
                    <td colspan="10" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr id="product_data_field">
                    <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">제품명</td>
                    <td align="left" class="t_border" style="padding-left:10px;" colspan="1"><select name="product_name" id="product_name" class="input7">
					<option value="0">제품명 (제조사-품목)</option>
					<?php
						foreach ($product as $val) {
							echo '<option value="'.$val['seq'].'"';
							echo ">".$val['product_name']." (".$val['product_company']."-".$val['product_item'].")</option>";
						}
					?>
                      <!-- <option value="001">제조사</option>
                      <option value="002">제조사1</option> -->
                    </select></td>
                    <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">라이선스</td>
										<td align="left" class="t_border" style="padding-left:10px;"><input name="product_licence" type="text" class="input5" id="product_licence" /> </td>
                    <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">Serial</td>
                    <!-- <td align="left" class="t_border" style="padding-left:10px;"><input name="product_count" type="text" class="input5" id="product_count" onclick="checkNum(this);" onKeyUp="checkNum(this);"/> </td> -->
										<td align="left" class="t_border" style="padding-left:10px;"><input name="product_serial" type="text" class="input5" id="product_serial" /> </td>
										<!-- <td align="left"  colspan="1" ><img src="<?php echo $misc;?>img/btn_add.jpg" id="product_add" name="product_add" style="cursor:pointer;"/></td> -->

										<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">제품 상태</td>
                    <!-- <td align="left" class="t_border" style="padding-left:10px;"><input name="product_count" type="text" class="input5" id="product_count" onclick="checkNum(this);" onKeyUp="checkNum(this);"/> </td> -->
										<td align="left" class="t_border" style="padding-left:10px;">
										<select name="product_state" id="product_state" class="input5">
										<option value="0">- 제품 상태 -</option>
											<option value="001">입고 전</option>
											<option value="002">창고</option>
											<option value="003">고객사 출고</option>
											<option value="004">장애반납</option>
										</select></td>

<td align="left" class="t_border" style="padding-left:10px;"><input type="checkbox" name="maintain_yn" id="maintain_yn"></td>
										<td align="center"  colspan="1" ><img src="<?php echo $misc;?>img/btn_add.jpg" id="product_add" name="product_add" style="cursor:pointer;"/></td>

                  </tr>

                  <!--추가버튼 눌렀을때 오픈-->
                  <!-- <tr>
                    <td colspan="9" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                    <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">제품 시리얼</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><select name="select" id="select" class="input5">
                      <option>제조사</option>
                      <option>제조사1</option>
                    </select></td>
                    <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">제품 시리얼</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="textfield" type="text" class="input5" id="textfield" value="거래처1"/> </td>
                    <td align="left"  colspan="3" ><a href="#" title="추가항목삭제" ><img src="<?php echo $misc;?>img/btn_del0.jpg" /></a></td>
                  </tr> -->
                  <!--//추가버튼 눌렀을때 오픈-->

                  <tr>
                    <td colspan="10" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                    <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">유지보수시작일</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="exception_saledate" type="text" class="input5" id="exception_saledate" readOnly/></td>
                    <td height="40" align="center" class="t_border" bgcolor="f8f8f9" style="font-weight:bold;">유지보수종료일</td>
                    <td align="left" class="t_border" style="padding-left:10px;"><input name="exception_saledate2" type="text" class="input5" id="exception_saledate2" readOnly/></td>
                    <!-- <td align="left"  colspan="7" ><!-- <img src="<?php echo $misc;?>img/btn_calendar.jpg" /><!-- </td> -->
                  </tr>
                  <tr>
                    <td colspan="10" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
                  <tr>
                    <td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">수주여부</td>
                    <td colspan="8" align="left" class="t_border" style="padding-left:10px;">
                    <select name="complete_status" id="complete_status" class="input5">
					  <option value="0">-수주여부-</option>
                      <option value="001">수주중</option>
                      <option value="002">수주완료</option>
                    </select></td>
                  </tr>

                  <!--마지막라인-->
                  <tr>
                    <td colspan="10" height="2" bgcolor="#797c88"></td>
                  </tr>
                  <!--//마지막라인-->
                </table></td>
              </tr>
              <!--//작성-->

              <tr>
                <td height="10"></td>
              </tr>
              <!--버튼-->
              <tr>
                <td align="right"><input type="image" src="<?php echo $misc;?>img/btn_ok.jpg" width="64" height="31" style="cursor:pointer" onclick="javascript:chkForm();return false;"/> <img src="<?php echo $misc;?>img/btn_cancel.jpg" width="64" height="31" style="cursor:pointer" onClick="javascript:history.go(-1)"/></td>
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
  <!--하단-->
  <tr>
  	<td align="center" height="100" bgcolor="#CCCCCC"><table width="1130" cellspacing="0" cellpadding="0" >
      <tr>
        <td width="197" height="100" align="center" background="<?php echo $misc;?>img/customer_f_bg.png"><img src="<?php echo $misc;?>img/f_ci.png"/></td>
        <td><?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?></td>
      </tr>
    </table></td>
  </tr>
  <!--//하단-->
</form>
</table>

</body>
</html>
