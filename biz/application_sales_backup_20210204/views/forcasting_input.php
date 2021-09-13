<?php
include $this->input->server('DOCUMENT_ROOT') . "/include/base.php";
include $this->input->server('DOCUMENT_ROOT') . "/include/sales_top.php";
?>
<style type="text/css">
	.productName {
		font-size: 12px;
		width: 190px;
	}

	#monthlyInput {
		width: 50px;
		margin-left: 10px;
		display: none;
	}

	#month {
		display: none;
	}
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/js/select2.min.js"></script>
<script>
	$(function() {
		$("#main_add").click(function() {
			$("#row_max_index").val(Number(Number($("#row_max_index").val()) + Number(1)));
			var id = "main_insert_field_" + $("#row_max_index").val();
			var id2 = "main_insert_field_2_" + $("#row_max_index").val();
			var html = "<tr id=" + id + "><td colspan='9' height='1' bgcolor='#e8e8e8'></td></tr><tr id=" + id2 + "><td height='40' align='center' bgcolor='f8f8f9' style='font-weight:bold;'>매입처</td><td align='left' class='t_border' style='padding-left:10px;'>";
			html += '<select id="select_main_company'+$("#row_max_index").val()+'" class="input7" onchange="selectMainCompany('+$("#row_max_index").val()+');addOptionMainCompany('+$("#row_max_index").val()+');">';
			html +=	"<option value=''>매입처 선택</option>";
			html += "<?php foreach($sales_customer as $sc){ echo "<option value='".$sc['seq']."'>".$sc['company_name']."</option>";}?>";							
			html += "</select><input name='main_companyname' type='text' class='input7' id='main_companyname"+$("#row_max_index").val()+"' onchange='addOptionMainCompany("+$("#row_max_index").val()+");' />";
			html += "</td><td align='center' bgcolor='f8f8f9' class='t_border' style='font-weight:bold;'>담당자</td><td align='left' class='t_border' style='padding-left:10px;'>";
			html += '<select id="select_main_user'+$("#row_max_index").val()+'" class="input7"><option value="">담당자 선택</option></select>';
			html += "<input name='main_username' type='text' class='input5' id='main_username"+$("#row_max_index").val()+"'/></td><td align='center' bgcolor='f8f8f9' class='t_border' style='font-weight:bold;'>연락처</td><td align='left' class='t_border' style='padding-left:10px;'><input name='main_tel' type='text' class='input5' id='main_tel"+$("#row_max_index").val()+"' onclick='checkNum(this);' onKeyUp='checkNum(this);'/></td><td align='center' bgcolor='f8f8f9' class='t_border' style='font-weight:bold;'>이메일</td><td align='left' class='t_border' style='padding-left:10px;'><input name='main_email' type='text' class='input5' id='main_email"+$("#row_max_index").val()+"'/></td><td align='left' style='padding-left:10px;'><img src='<?php echo $misc; ?>img/btn_del0.jpg' style='cursor:pointer;' onclick='javascript:main_list_del(" + $("#row_max_index").val() + ");'/></td></tr>";
			$('#main_insert').before(html);
			$("#select_main_company"+$("#row_max_index").val()).select2();
		});

		$("#product_add").click(function() {
			$("#row_max_index2").val(Number(Number($("#row_max_index2").val()) + Number(1)));
			var id3 = "product_insert_field_" + $("#row_max_index2").val();
			var id4 = "product_insert_field_1_" + $("#row_max_index2").val();
			var id5 = "product_insert_field_2_" + $("#row_max_index2").val();
			var id6 = "product_insert_field_3_" + $("#row_max_index2").val();
			var html = "<tr id=" + id3 + "><td colspan='9' height='1' bgcolor='#e8e8e8'></td></tr><tr id=" + id4 + ">";
			html += '<td height="40" align="left" bgcolor="f8f8f9" style="font-weight:bold;"><input type="checkbox" name="product_row" value="'+$("#row_max_index2").val()+'"/>&emsp;&emsp;&nbsp;&nbsp;제조사</td><td align="left" class="t_border" style="padding-left:10px;" colspan="1">';
			html += '<select name="product_company" id="product_company'+$("#row_max_index2").val()+'" class="input7" onchange="productSearch('+$("#row_max_index2").val()+');product_type_default('+$("#row_max_index2").val()+')"><option value="">제조사</option>';
			<?php foreach($product_company as $pc){?>
				html += "<option value='<?php echo $pc['product_company'];?>'><?php echo $pc['product_company']; ?></option>";
			<?php } ?>
			html += '<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">매입처</td><td align="left" class="t_border" style="padding-left:10px;" colspan="1"><select name="product_supplier" id="product_supplier'+$("#row_max_index2").val()+'" class="input7"><option value=""></option></select></td>';
			html += '</select></td><td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">하드웨어/소프트웨어</td><td align="left" class="t_border" style="padding-left:10px;" colspan="1">';
			html += '<select name="product_type" id="product_type'+$("#row_max_index2").val()+'" class="input7" onchange="productSearch('+$("#row_max_index2").val()+');"><option value="">전체</option><option value="hardware">하드웨어</option><option value="software">소프트웨어</option></select></td></tr>'
			html += '<tr id='+id5+'><td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">제품명</td><td align="left" class="t_border" style="padding-left:10px;" colspan="1">'
			html += '<select name ="product_name" id="product_name'+$("#row_max_index2").val()+'" class="input7" onclick="productSearch('+$("#row_max_index2").val()+');"><option value="" >제품선택</option></select></td>';
			html += "<td height='40' align='center' bgcolor='f8f8f9' class='t_border' style='font-weight:bold;'>라이선스</td><td align='left' class='t_border' style='padding-left:10px;'><input name='product_licence' type='text' class='input5' id='product_licence"+$("#row_max_index2").val()+"' onkeyup ='commaCheck(this);' /> </td><td height='40' align='center' bgcolor='f8f8f9' class='t_border' style='font-weight:bold;'>Serial</td><td align='left' class='t_border' style='padding-left:10px;'><input name='product_serial' type='text' class='input5' id='product_serial"+$("#row_max_index2").val()+"' onkeyup ='commaCheck(this);' /> </td><td height='40' align='center' bgcolor='f8f8f9' class='t_border' style='font-weight:bold;'>제품 상태</td><td align='left' class='t_border' style='padding-left:10px;'><select name='product_state' id='product_state"+$("#row_max_index2").val()+"' class='input5' ><option value='0'>- 제품 상태 -</option><option value='001'>입고 전</option><option value='002'>창고</option><option value='003'>고객사 출고</option><option value='004'>장애반납</option></select></td><input name='maintain_begin' type='hidden' class='input5' id='maintain_begin"+$("#row_max_index2").val()+"' value=' '/><input name='maintain_expire' type='hidden' class='input5' id='maintain_expire"+$("#row_max_index2").val()+"' value=' '/><input name='maintain_yn' type='hidden' class='input5' id='maintain_yn"+$("#row_max_index2").val()+"' value=' '/><input name='product_version' type='hidden' class='input5' id='product_version"+$("#row_max_index2").val()+"' value=' ' /><input name='maintain_target' type='hidden' class='input5' id='maintain_target"+$("#row_max_index2").val()+"' value='Y'/><input name='product_check_list' type='hidden' class='input5' id='product_check_list"+$("#row_max_index2").val()+"' value='1'/><input name='product_host' type='hidden' class='input5' id='product_host"+$("#row_max_index2").val()+"' value=''/><td align='center'  colspan='1' ><img src='<?php echo $misc; ?>img/btn_del0.jpg' style='cursor:pointer;' onclick='javascript:product_list_del(" + $("#row_max_index2").val() + ");'/></td></tr><tr id=" + id6 + "><td  height='40' align='center' bgcolor='f8f8f9' style='font-weight:bold;'>장비매출가</td><td align='left' class='t_border' style='padding-left:10px;'><input name='product_sales' type='text' class='input5' id='product_sales"+$("#row_max_index2").val()+"' value=0 onclick='numberFormat(this);' onchange='numberFormat(this);product_profit_change(" + $("#row_max_index2").val() + ");' /></td><td height='40' align='center' bgcolor='f8f8f9' class='t_border' style='font-weight:bold;'>장비매입가</td><td align='left' class='t_border' style='padding-left:10px;'><input name='product_purchase' type='text' class='input5' id='product_purchase"+$("#row_max_index2").val()+"' value=0 onclick='numberFormat(this);' onchange='numberFormat(this);product_profit_change(" + $("#row_max_index2").val() + ");'/></td><td height='40' align='center' bgcolor='f8f8f9' class='t_border' style='font-weight:bold;'>장비마진</td><td align='left' class='t_border' style='padding-left:10px;'><input name='product_profit' type='text' class='input5' id='product_profit"+$("#row_max_index2").val()+"' value=0 readonly/></td></tr><tr><td colspan='9' height='1' bgcolor='#e8e8e8'></td></tr>";
			$('#input_point').before(html);
			$("#product_company"+$("#row_max_index2").val()).select2();
			$("#product_supplier"+$("#row_max_index2").val()).html($("#product_supplier").html());//제품 처음꺼랑 똑같게 매입처 option 가져오는거
		});
	});

	function main_list_del(idx) {
		$("#main_insert_field_" + idx).remove();
		$("#main_insert_field_2_" + idx).remove();
	}

	function product_list_del(idx) {
		$("#product_insert_field_" + idx).remove();
		$("#product_insert_field_1_" + idx).remove();
		$("#product_insert_field_2_" + idx).remove();
		$("#product_insert_field_3_" + idx).remove();
		t_forcasting_profit_change();

	}

	function forcasting_profit_change() {
		var mform = document.cform;
		mform.forcasting_profit.value = mform.forcasting_sales.value.replace(/,/g, "") - mform.forcasting_purchase.value.replace(/,/g, "");
		mform.forcasting_profit.value = mform.forcasting_profit.value.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, "$1,");
	}

	function t_forcasting_profit_change() {
		var mform = document.cform;
		mform.forcasting_sales.value = 0;
		mform.forcasting_purchase.value = 0;

		for (i = 0; i < document.getElementsByName("product_sales").length; i++) {
			mform.forcasting_sales.value = parseInt(mform.forcasting_sales.value.replace(/,/g, "")) + parseInt(document.getElementsByName("product_sales")[i].value.replace(/,/g, ""));
			mform.forcasting_sales.value = mform.forcasting_sales.value.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, "$1,");
			mform.forcasting_purchase.value = parseInt(mform.forcasting_purchase.value.replace(/,/g, "")) + parseInt(document.getElementsByName("product_purchase")[i].value.replace(/,/g, ""));
			mform.forcasting_purchase.value = mform.forcasting_purchase.value.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, "$1,");
		}
		forcasting_profit_change();
	}

	function product_profit_change(idx) {
		var mform = document.cform;
		if (idx == 0) {
			mform.product_profit.value = mform.product_sales.value.replace(/,/g, "") - mform.product_purchase.value.replace(/,/g, "");
			mform.product_profit.value= mform.product_profit.value.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, "$1,");
		} else {
			var strings = "#product_insert_field_3_" + idx + " td input";
			$(strings).eq(2).val($(strings).eq(0).val().replace(/,/g, "") - $(strings).eq(1).val().replace(/,/g, ""));
			$(strings).eq(2).val($(strings).eq(2).val().replace(/(\d)(?=(?:\d{3})+(?!\d))/g, "$1,"));
		}
		t_forcasting_profit_change();
	}

</script>
<script language="javascript">
	function checkNum(obj) {
		var phone_num;
		function phone_regexp(phonNum){
			phone_num = phonNum.replace(/[^0-9]/g, "").replace(/(^02|^0505|^1[0-9]{3}|^0[0-9]{2})([0-9]+)?([0-9]{4})$/,"$1-$2-$3").replace("--", "-");
		}
		var word = obj.value;
		phone_regexp(word);
		var str = "1234567890";
		obj.value = phone_num; 
	}

	function numberFormat(obj) {
		if(obj.value == ""){
			obj.value =0;
		}
		var inputNumber = obj.value.replace(/,/g, "");
		var fomatnputNumber = inputNumber.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, "$1,");
		obj.value= fomatnputNumber;
	}

	var chkForm = function() {
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
		var regex = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
		if (regex.test(mform.customer_email.value) === false) {
			alert("잘못된 이메일 형식입니다.");
			mform.customer_email.focus();
			return false;
		}

		if (mform.project_name.value == "") {
			mform.project_name.focus();
			alert("프로젝트명을 입력해 주세요.");
			return false;
		}

		if (mform.type.value == "0") {
			mform.type.focus();
			alert("판매종류를 선택해 주세요.");
			return false;
		}

		if (mform.progress_step.value == "0") {
			mform.progress_step.focus();
			alert("진척단계를 선택해 주세요.");
			return false;
		}
		if (mform.cooperation_companyname.value == "") {
			mform.cooperation_companyname.focus();
			alert("영업담당자 업체를 입력해 주세요.");
			return false;
		}
		if (mform.cooperation_username.value == "") {
			mform.cooperation_username.focus();
			alert("영업담당자를 입력해 주세요.");
			return false;
		}
		/*	if (mform.cooperation_tel.value == "") {
				mform.cooperation_tel.focus();
				alert("영업담당자 연락처를 입력해 주세요.");
				return false;
			}
			if (mform.cooperation_email.value == "") {
				mform.cooperation_email.focus();
				alert("영업담당자 이메일을 입력해 주세요.");
				return false;
			}
			var regex2=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
			if(regex2.test(mform.cooperation_email.value) === false) {
				alert("잘못된 이메일 형식입니다.");
				mform.cooperation_email.focus();
				return false;
			}*/
		if (mform.sales_companyname.value == "") {
			mform.sales_companyname.focus();
			alert("매출처 업체를 입력해 주세요.");
			return false;
		}
		if (mform.sales_username.value == "") {
			mform.sales_username.focus();
			alert("매출처 담당자를 입력해 주세요.");
			return false;
		}
		if (mform.sales_tel.value == "") {
			mform.sales_tel.focus();
			alert("매출처 담당자  연락처를 입력해 주세요.");
			return false;
		}
		if (mform.sales_email.value == "") {
			mform.sales_email.focus();
			alert("매출처 담당자 이메일을 입력해 주세요.");
			return false;
		}
		var regex2 = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
		if (regex2.test(mform.sales_email.value) === false) {
			alert("잘못된 이메일 형식입니다.");
			mform.sales_email.focus();
			return false;
		}

		var objmain_companyname = document.getElementsByName("main_companyname");
		var objmain_username = document.getElementsByName("main_username");
		var objmain_tel = document.getElementsByName("main_tel");
		var objmain_email = document.getElementsByName("main_email");

		if (objmain_companyname.length > 1) {
			for (i = 0; i < objmain_companyname.length; i++) {
				if ($.trim(objmain_companyname[i].value) == "") {
					alert(i + 1 + '번째 매입처를 입력해주세요.');
					objmain_companyname[i].focus();
					return;
				}
				if ($.trim(objmain_username[i].value) == "") {
					alert(i + 1 + "번째 담당자를 입력하십시오.");
					objmain_username[i].focus();
					return;
				}
				if ($.trim(objmain_tel[i].value) == "") {
					alert(i + 1 + "번째 연락처를 입력하십시오.");
					objmain_tel[i].focus();
					return;
				}
				if ($.trim(objmain_email[i].value) == "") {
					alert(i + 1 + "번째 이메일을 입력하십시오.");
					objmain_email[i].focus();
					return;
				}
				var regex3 = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
				if (regex3.test(objmain_email[i].value) === false) {
					alert("잘못된 이메일 형식입니다.");
					objmain_email[i].focus();
					return false;
				}
			}
		}

		var objproduct_name = document.getElementsByName("product_name");
		var objproduct_supplier = document.getElementsByName("product_supplier");
		var objproduct_serial = document.getElementsByName("product_serial");
		var objproduct_state = document.getElementsByName("product_state");
		var objproduct_licence = document.getElementsByName("product_licence");
		var objmaintain_begin = document.getElementsByName("maintain_begin");
		var objmaintain_expire = document.getElementsByName("maintain_expire");
		var objmaintain_yn = document.getElementsByName("maintain_yn");
		var objmaintain_target = document.getElementsByName("maintain_target");
		var objproduct_check_list = document.getElementsByName("product_check_list");
		var objproduct_host = document.getElementsByName("product_host");
		var objproduct_version = document.getElementsByName("product_version");
		var objproduct_product_sales = document.getElementsByName("product_sales");
		var objproduct_product_purchase = document.getElementsByName("product_purchase");
		var objproduct_product_profit = document.getElementsByName("product_profit");
		var objproduct_monthly_input = document.getElementsByName("monthly_input");

		var regex3 = /^[0-9]+$/;
		if (objproduct_name.length > 0) {
			if (regex3.test(objproduct_monthly_input[0].value) === false) {
				if (objproduct_monthly_input[0].value != "") {
					alert("숫자만 입력하세요");
					objproduct_monthly_input[0].focus();
					return false;
				} else {
					if ($("#division_month").val() == "month") {
						if ($.trim(objproduct_monthly_input[0].value) == "") {
							alert('개월 수를 입력 해주세요..');
							objproduct_monthly_input[0].focus();
							return;
						}
					}
				}
			}
		}

		if (objproduct_name.length > 0) {
			for (i = 0; i < objproduct_name.length; i++) {
				if ($.trim(objproduct_name[i].value) == "0" || $.trim(objproduct_name[i].value) == "") {
					alert(i + 1 + '번째 제품명을 선택해주세요..');
					objproduct_name[i].focus();
					return;
				}
				if ($.trim(objproduct_state[i].value) == "0") {
					alert(i + 1 + "번째 제품 상태를 선택해주세요.");
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

		$("#insert_main_array").val('');
		if (objmain_companyname.length > 0) {
			for (i = 0; i < objmain_companyname.length; i++) {
				$("#insert_main_array").val($("#insert_main_array").val() + "||" + objmain_companyname[i].value + "~" + objmain_username[i].value + "~" + objmain_tel[i].value + "~" + objmain_email[i].value);
			}
		}

		$("#insert_product_array").val('');
		if (objproduct_name.length > 0) {
			for (i = 0; i < objproduct_name.length; i++) {
				$("#insert_product_array").val($("#insert_product_array").val() + "||" + objproduct_name[i].value + "~" + objproduct_supplier[i].value + "~" + objproduct_licence[i].value + "~" + objproduct_serial[i].value + "~" + objproduct_state[i].value + "~" + objproduct_product_sales[i].value.replace(/,/g, "") + "~" + objproduct_product_purchase[i].value.replace(/,/g, "") + "~" + objproduct_product_profit[i].value.replace(/,/g, ""));
			}
		}

		mform.submit();
		return false;
	}
</script>

<body>
	<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
		<form name="cform" action="<?php echo site_url(); ?>/forcasting/forcasting_input_action" method="post" onSubmit="javascript:chkForm();return false;">
			<input type="hidden" id="insert_main_array" name="insert_main_array" />
			<input type="hidden" id="insert_product_array" name="insert_product_array" />
			<input type="hidden" id="row_max_index" name="row_max_index" value="0" />
			<input type="hidden" id="row_max_index2" name="row_max_index2" value="0" />
			<?php
			include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
			?>
			<tr>
				<td align="center" valign="top">

					<table width="90%" height="100%" cellspacing="0" cellpadding="0">
						<tr>

							<td width="100%" align="center" valign="top">

								<!--내용-->
								<table width="100%" border="0" style="margin-top:50px; margin-bottom: 50px;">
									<!--타이틀-->
									<tr>
										<td class="title3">포캐스팅</td>
									</tr>
									<!--//타이틀-->
									<tr>
										<td>&nbsp;</td>
									</tr>

									<!--작성-->
									<tr>
										<td>
											<table width="100%" border="0" cellspacing="0" cellpadding="0" id="main_list">
												<colgroup>
													<col width="10%" />
													<col width="15%" />
													<col width="10%" />
													<col width="15%" />
													<col width="10%" />
													<col width="15%" />
													<col width="10%" />
													<col width="10%" />
													<col width="5%" />
												</colgroup>
												<tr>
													<td height=15></td> 
												</tr>
												<tr>
													<td style="font-weight:bold;font-size:13px;">고객사 정보</td>
												</tr>
												<!--시작라인-->
												<tr>
													<td colspan="9" height="2" bgcolor="#797c88"></td>
												</tr>
												<!--//시작라인-->
												<tr>
													<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">고객사</td>
													<td align="left" class="t_border" style="padding-left:10px;"><input name="customer_companyname" type="text" class="input5" id="customer_companyname" /></td>
													<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">담당자</td>
													<td align="left" class="t_border" style="padding-left:10px;"><input name="customer_username" type="text" class="input5" id="customer_username" /></td>
													<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">연락처</td>
													<td align="left" class="t_border" style="padding-left:10px;"><input type="text" name="customer_tel" id="customer_tel" class="input5" onclick="checkNum(this);" onKeyUp="checkNum(this);" /></td>
													<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">이메일</td>
													<td colspan="2" align="left" class="t_border" style="padding-left:10px;"><input type="text" name="customer_email" id="customer_email" class="input5" /></td>
												</tr>
												<tr>
													<td colspan="9" height="1" bgcolor="#e8e8e8"></td>
												</tr>
												<tr>
													<td height=30></td> 
													<!-- 빈칸 -->
												</tr>
												<tr>
													<td style="font-weight:bold;font-size:13px;">영업 정보</td>
												</tr>
												<tr>
													<td colspan="9" height="2" bgcolor="#797c88"></td>
												</tr>
												<tr>
													<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">프로젝트</td>
													<td colspan="3" align="left" class="t_border" style="padding-left:10px;"><input name="project_name" type="text" class="input2" id="project_name" /></td>
													<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">판매종류</td>
													<td align="left" class="t_border" style="padding-left:10px;">
														<select name="type" id="type" class="input5" onclick="project_type(this.value)">
															<option value="1">판매</option>
															<option value="2">용역</option>
															<option value="3">유지보수</option>
															<option value="4">조달</option>
															<option value="0" selected>선택없음</option>
														</select>
													</td>
													<td align="center" bgcolor="f8f8f9" class="t_border procurement" style="font-weight:bold;display:none;">조달 판매금액(VAT포함)</td>
													<td align="left" class="t_border procurement" style="padding-left:10px;display:none;">
														<input type="text" id="procurement_sales_amount" class="input5" name="procurement_sales_amount" oninput="if(this.value != '0'){this.value = this.value.replace(/^0+|\D+/g, '').replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,')}" /> 
													</td>
												</tr>

												<tr>
													<td colspan="9" height="1" bgcolor="#e8e8e8"></td>
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
															<!-- <option value="016">매출발생(90%)</option>
															<option value="017">미수잔금(95%)</option>
															<option value="018">수금완료(100%)</option> -->
														</select></td>
												</tr>
												<tr>
													<td colspan="9" height="1" bgcolor="#e8e8e8"></td>
												</tr>
												<tr>
													<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">영업업체</td>
													<td align="left" class="t_border" style="padding-left:10px;">
														<select name="cooperation_companyname" id="cooperation_companyname" class="input7">
															<option value="미지정">선택하세요</option>
															<option value="두리안정보기술">두리안정보기술</option>
															<option value="두리안정보통신기술">두리안정보통신기술</option>
															<option value="더망고">더망고</option>
														</select>
													</td>
													<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">영업담당자</td>
													<td align="left" class="t_border" style="padding-left:10px;"><input name="cooperation_username" type="text" class="input5" id="cooperation_username" /></td>
													<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">사업부</td>
													<td align="left" class="t_border" style="padding-left:10px;">
														<select name="dept" id="dept" class="input5">
															<option value="미지정">선택하세요</option>
															<option value="사업1부">사업1부</option>
															<option value="사업2부">사업2부</option>
															<option value="ICT">ICT</option>
															<option value="MG">MG</option>
															<option value="기술지원부">기술지원부</option>
														</select>
													</td>
													<input name="cooperation_tel" type="hidden" class="input5" id="cooperation_tel" onclick="checkNum(this);" onKeyUp="checkNum(this);" />
													<!--                    <td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">이메일</td>-->
													<!--		    <td colspan="2" align="left" class="t_border" style="padding-left:10px;"> -->
													<input name="cooperation_email" type="hidden" class="input5" id="cooperation_email" />
										</td>
									</tr>
									<tr>
										<td colspan="9" height="1" bgcolor="#e8e8e8"></td>
									</tr>
									<tr>
										<td height=30></td> 
										<!-- 빈칸 -->
									</tr>
									<tr>
										<td style="font-weight:bold;font-size:13px;">매출처 정보</td>
									</tr>
									<tr>
										<td colspan="9" height="2" bgcolor="#797c88"></td>
									</tr>
									<tr>
										<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">매출처</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<select id="select_sales_company" class="input7" onchange="selectSalesCompany(this); ">
												<option value=''>매출처 선택</option>
												<?php foreach($sales_customer as $sc){
													echo "<option value='{$sc['seq']}'>{$sc['company_name']}</option>";
												}
												?>
											</select>
											<input name="sales_companyname" type="text" class="input7" id="sales_companyname" />
										</td>
										<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">담당자</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<select id="select_sales_user" class="input7">
												<option value=''>담당자 선택</option>
											</select>
											<input name="sales_username" type="text" class="input5" id="sales_username" />
										</td>
										<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">연락처</td>
										<td align="left" class="t_border" style="padding-left:10px;"><input name="sales_tel" type="text" class="input5" id="sales_tel" onclick="checkNum(this);" onKeyUp="checkNum(this);" /></td>
										<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">이메일</td>
										<td colspan="2" align="left" class="t_border" style="padding-left:10px;"><input name="sales_email" type="text" class="input5" id="sales_email" /></td>
									</tr>
									<tr>
										<td colspan="9" height="1" bgcolor="#e8e8e8"></td>
									</tr>
									<tr>
										<td height=30></td> 
										<!-- 빈칸 -->
									</tr>
									<tr>
										<td style="font-weight:bold;font-size:13px;">매입처 정보</td>
									</tr>
									<!--시작라인-->
									<tr>
										<td colspan="9" height="2" bgcolor="#797c88"></td>
									</tr>
									<tr>
										<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">매입처</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<select id="select_main_company" class="input7" onchange="selectMainCompany();addOptionMainCompany(0);">
												<option value=''>매입처 선택</option>
												<?php foreach($sales_customer as $sc){
														echo "<option value='{$sc['seq']}'>{$sc['company_name']}</option>";
													}
												?>
											</select>
											<input name="main_companyname" type="text" class="input7" id="main_companyname" onchange="addOptionMainCompany(0);" />
										</td>
										<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">담당자</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<select id="select_main_user" class="input7">
												<option value=''>담당자 선택</option>
											</select>
											<input name="main_username" type="text" class="input5" id="main_username" />
										</td>
										<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">연락처</td>
										<td align="left" class="t_border" style="padding-left:10px;"><input name="main_tel" type="text" class="input5" id="main_tel" onclick="checkNum(this);" onKeyUp="checkNum(this);" /></td>
										<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">이메일</td>
										<td align="left" class="t_border" style="padding-left:10px;"><input name="main_email" type="text" class="input5" id="main_email" /></td>
										<td align="center"><img src="<?php echo $misc; ?>img/btn_add.jpg" id="main_add" name="main_add" style="cursor:pointer;" /></td>
									</tr>
									<tr>
										<td colspan="9" height="1" bgcolor="#e8e8e8"></td>
									</tr>
									<tr id="main_insert">
										<td height=30></td> 
										<!-- 빈칸 -->
									</tr>
									<tr>
										<td style="font-weight:bold;font-size:13px;">제품 정보</td>
									</tr>
									<tr>
										<td colspan=9 height="40" align="left" style="padding:30px 0px 30px 30px;">
										* 일괄적용 <br>
										<table>
											<tr>
												<td>제조사</td>
												<td>
													<select id="check_product_company" class="input2" onchange="productSearch('check');">
														<option value="" >제조사</option>
														<?php foreach($product_company as $pc){
															echo "<option value='{$pc['product_company']}'>{$pc['product_company']}</option>";
														}?>
													</select>
												</td>
												<td><input type="button" class="input5" value="선택적용" onclick="collectiveApplication('product_company',2);" style="margin-right:30px;" /></td>
												<td>매입처</td>
												<td>
													<select id="check_product_supplier" class="input2">
													<?php foreach($view_val2 as $item2){
														echo "<option value='{$item2['main_companyname']}'";
														if($item3['product_supplier'] == $item2['main_companyname']){
															echo "selected";
														}
														echo ">{$item2['main_companyname']}</option>";
													}?>
													</select>
												</td>
												<td><input type="button" class="input5" value="선택적용" onclick="collectiveApplication('product_supplier',1);" style="margin-right:30px;" /></td>
												<td>제품상태</td>
												<td>
													<select id="check_product_state" class="input5">
														<option value="0">- 제품 상태 -</option>
														<option value="001">입고 전</option>
														<option value="002">창고</option>
														<option value="003">고객사 출고</option>
														<option value="004">장애반납</option>
													</select>
												</td>
												<td><input type="button" class="input5" value="선택적용" onclick="collectiveApplication('product_state',1);" style="margin-right:30px;" /></td>

											</tr>
											<tr>
												<td>제품명</td>
												<td>
													<select id="check_product_name" class="input2" onclick="productSearch('check');">
														<option value="" selected>제조사를 선택해주세요</option>
													</select>
												</td>
												<td><input type="button" class="input5" value="선택적용" onclick="collectiveApplication('product_name',2);" style="margin-right:30px;" /></td>
												<td>장비매출가</td>
												<td><input type="text" class="input2" id="check_product_sales" value=0 onclick="numberFormat(this);" onchange="numberFormat(this);" /></td>
												<td><input type="button" class="input5" value="선택적용" onclick="collectiveApplication('product_sales',0);" style="margin-right:30px;" /></td>
												<td>장비매입가</td>
												<td><input type="text" class="input2" id="check_product_purchase" value=0 onclick="numberFormat(this);" onchange="numberFormat(this);" /></td>
												<td><input type="button" class="input5" value="선택적용" onclick="collectiveApplication('product_purchase',0);" style="margin-right:30px;" /></td>
											</tr>
										</table>
										</td>
									</tr>
									<tr>
										<td><input type="checkbox" id="allCheck" />전체 </td>
										<td colspan=8></td>
									</tr>
									<!--시작라인-->
									<tr>
										<td colspan="9" height="2" bgcolor="#797c88"></td>
									</tr>
									<tr>
										<td height="40" align="left" bgcolor="f8f8f9" style="font-weight:bold;"><input type="checkbox" name="product_row" value="0" />&emsp;&emsp;&nbsp;&nbsp;제조사</td>
										<td align="left" class="t_border" style="padding-left:10px;" colspan="1">
											<select name="product_company" id="product_company" class="input7" onchange="productSearch();product_type_default();" >
												<option value="">제조사</option>
												<?php foreach($product_company as $pc){
													echo "<option value='{$pc['product_company']}'>{$pc['product_company']}</option>";
												}?>
											</select>
										</td>
										<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">매입처</td>
										<td align="left" class="t_border" style="padding-left:10px;" colspan="1">
											<select name="product_supplier" id="product_supplier" class="input7" >
												<option value=""></option>
											</select>
										</td>
										<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">하드웨어/소프트웨어</td>
										<td align="left" class="t_border" style="padding-left:10px;" colspan="1">
											<select name="product_type" id="product_type" class="input7" onchange="productSearch();">
												<option value="">전체</option>
												<option value="hardware">하드웨어</option>
												<option value="software">소프트웨어</option>
											</select>
										</td>
									</tr>
									<!-- <tr>
										<td colspan="9" height="1" bgcolor="#e8e8e8"></td>
									</tr> -->
									<tr id="product_data_field">
										<td  height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">제품명</td>
										<td align="left" class="t_border" style="padding-left:10px;" colspan="1">
											<select name ="product_name" id="product_name" class="input7" onclick="productSearch();">
												<option value="" >제품선택</option>
											</select>
										</td>
										<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">라이선스</td>
										<td align="left" class="t_border" style="padding-left:10px;"><input name="product_licence" type="text" class="input5" id="product_licence" onkeyup ="commaCheck(this);" /> </td>
										<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">Serial</td>
										<!-- <td align="left" class="t_border" style="padding-left:10px;"><input name="product_count" type="text" class="input5" id="product_count" onclick="checkNum(this);" onKeyUp="checkNum(this);"/> </td> -->
										<td align="left" class="t_border" style="padding-left:10px;"><input name="product_serial" type="text" class="input5" id="product_serial" onkeyup ="commaCheck(this);" /> </td>
										<!-- <td align="left"  colspan="1" ><img src="<?php echo $misc; ?>img/btn_add.jpg" id="product_add" name="product_add" style="cursor:pointer;"/></td> -->

										<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">제품 상태</td>
										<!-- <td align="left" class="t_border" style="padding-left:10px;"><input name="product_count" type="text" class="input5" id="product_count" onclick="checkNum(this);" onKeyUp="checkNum(this);"/> </td> -->
										<td align="left" class="t_border" style="padding-left:10px;">
											<select name="product_state" id="product_state" class="input5" >
												<option value="0">- 제품 상태 -</option>
												<option value="001">입고 전</option>
												<option value="002">창고</option>
												<option value="003">고객사 출고</option>
												<option value="004">장애반납</option>
											</select></td>
										<input name="maintain_begin" type="hidden" class="input5" id="maintain_begin" value=" " />
										<input name="maintain_expire" type="hidden" class="input5" id="maintain_expire" value=" " />
										<input name="maintain_yn" type="hidden" class="input5" id="maintain_yn" value=" " />
										<input name="product_version" type="hidden" class="input5" id="product_version" value=" " />
										<input name="maintain_target" type="hidden" class="input5" id="maintain_target" value="Y" />
										<input name="product_check_list" type="hidden" class="input5" id="product_check_list" value="1" />
										<input name="product_host" type="hidden" class="input5" id="product_host" value="" />


										<td align="center" colspan="1"><img src="<?php echo $misc; ?>img/btn_add.jpg" id="product_add" name="product_add" style="cursor:pointer;" /></td>


									</tr>
									<tr id="product_data_field_2">
										<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">장비매출가</td>
										<td align="left" class="t_border" style="padding-left:10px;"><input name="product_sales" type="text" class="input5" id="product_sales" value=0 onclick="numberFormat(this);" onchange="numberFormat(this);product_profit_change(0);" /> </td>
										<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">장비매입가</td>
										<td align="left" class="t_border" style="padding-left:10px;"><input name="product_purchase" type="text" class="input5" id="product_purchase" value=0 onclick="numberFormat(this);" onchange="numberFormat(this);product_profit_change(0);" /> </td>
										<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">장비마진</td>
										<td align="left" class="t_border" style="padding-left:10px;"><input name="product_profit" type="text" class="input5" id="product_profit" value=0 readonly /> </td>
									</tr>
									<tr>
										<td colspan="9" height="1" bgcolor="#e8e8e8"></td>
									</tr>
									<tr id="input_point">
										<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">고객사총매출가</td>
										<td align="left" class="t_border" style="padding-left:10px;"><input name="forcasting_sales" type="text" class="input5" id="forcasting_sales" value=0 onchange="forcasting_profit_change();" readonly/> </td>
										<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">고객사총매입가</td>
										<td align="left" class="t_border" style="padding-left:10px;"><input name="forcasting_purchase" type="text" class="input5" id="forcasting_purchase" value=0 onchange="forcasting_profit_change();" readonly /> </td>
										<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">고객사총마진</td>
										<td align="left" class="t_border" style="padding-left:10px;"><input name="forcasting_profit" type="text" class="input5" id="forcasting_profit" value=0 readonly /> </td>
										<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">분할월수</td>
										<td colspan="3" align="left" class="t_border" style="padding-left:10px;"><select name="division_month" id="division_month" class="input5" onchange="monthDivision()">
												<option value="12" selected>당월</option>
												<option value="6">반기별</option>
												<option value="3">분기별</option>
												<option value="month">월별</option>
												<input type="text" name="monthly_input" id="monthlyInput" onchange="month()"></input>
												<div id="month" style="float:right">개월<div>
										</td>

									</tr>
						</tr>
						<tr>
							<td colspan="9" height="1" bgcolor="#e8e8e8"></td>
						</tr>
						<tr>
							<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">최초 매출일</td>
							<td align="left" class="t_border" style="padding-left:10px;"><input name="first_saledate" type="date" class="input7" id="first_saledate"/></td>
							<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">예상 매출일</td>
							<td align="left" class="t_border" style="padding-left:10px;"><input name="exception_saledate" type="date" class="input7" id="exception_saledate"/></td>
							<!-- <td align="left"  colspan="7" ><!-- <img src="<?php echo $misc; ?>img/btn_calendar.jpg" /><!-- </td> -->
						</tr>
						<tr>
							<td colspan="9" height="1" bgcolor="#e8e8e8"></td>
						</tr>
						<tr>
							<td height=30></td> 
						</tr>
						<tr>
							<td style="font-weight:bold;font-size:13px;">수주 정보</td>
						</tr>
						<!--시작라인-->
						<tr>
							<td colspan="9" height="2" bgcolor="#797c88"></td>
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
						<tr>
							<td colspan="9" height="1" bgcolor="#e8e8e8"></td>
						</tr>

						<!--마지막라인-->
						<!-- <tr>
							<td colspan="9" height="2" bgcolor="#797c88"></td>
						</tr> -->
						<!--//마지막라인-->
					</table>
				</td>
			</tr>
			<!--//작성-->

			<tr>
				<td height="10"></td>
			</tr>
			<!--버튼-->
			<tr>
				<td align="right"><input type="image" src="<?php echo $misc; ?>img/btn_ok.jpg" width="64" height="31" style="cursor:pointer" onclick="javascript:chkForm();return false;" /> <img src="<?php echo $misc; ?>img/btn_cancel.jpg" width="64" height="31" style="cursor:pointer" onClick="javascript:history.go(-1)" /></td>
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
		<td align="center" height="100" bgcolor="#CCCCCC">
			<table width="1130" cellspacing="0" cellpadding="0">
				<tr>
					<td width="197" height="100" align="center" background="<?php echo $misc; ?>img/customer_f_bg.png"><img src="<?php echo $misc; ?>img/f_ci.png" /></td>
					<td><?php include $this->input->server('DOCUMENT_ROOT') . "/include/sales_bottom.php"; ?></td>
				</tr>
			</table>
		</td>
	</tr>
	<!--//하단-->
	</form>
	</table>
	<script>
	//select box 검색 기능
	$("#check_product_company").select2();
	$("#product_company").select2();
	$("#select_sales_company").select2();
	$("#select_main_company").select2();

	function selectSalesCompany() {
		$("#sales_companyname").val($("#select_sales_company option:selected").text());

		var seq = $("#select_sales_company option:selected").val();

		$.ajax({
			type: "POST",
			cache: false,
			url: "<?php echo site_url();?>/ajax/sales_customer_staff",
			dataType: "json",
			async: false,
			data: {
				seq: seq
			},
			success: function (data) {
				var html = "<option value='' selected>담당자 선택</option>";
				for (i = 0; i < data.length; i++) {
					html += "<option value=" + data[i].seq + ">" + data[i].user_name + "</option>"
				}
				$("#select_sales_user").html(html);

				$("#select_sales_user").change(function () {
					$("#sales_username").val($("#select_sales_user option:selected").text());
					for (i = 0; i < data.length; i++) {
						if ($("#select_sales_user").val() == data[i].seq) {
							$("#sales_tel").val(data[i].user_tel);
							$("#sales_tel").click();
							$("#sales_email").val(data[i].user_email);
						}
					}
				})
			}
		});
	}

	function selectMainCompany(idx) {
		if (idx == undefined) {
			var seq = $("#select_main_company option:selected").val();
			$("#main_companyname").val($("#select_main_company option:selected").text());
		} else {
			var seq = $("#select_main_company" + idx + " option:selected").val();
			$("#main_companyname" + idx).val($("#select_main_company" + idx + " option:selected").text());
		}

		$.ajax({
			type: "POST",
			cache: false,
			url: "<?php echo site_url();?>/ajax/sales_customer_staff",
			dataType: "json",
			async: false,
			data: {
				seq: seq
			},
			success: function (data) {
				var html = "<option value='' selected>담당자 선택</option>";
				for (i = 0; i < data.length; i++) {
					html += "<option value=" + data[i].seq + ">" + data[i].user_name + "</option>"
				}

				if (idx == undefined) {
					$("#select_main_user").html(html);

					$("#select_main_user").change(function () {
						$("#main_username").val($("#select_main_user option:selected").text());
						for (i = 0; i < data.length; i++) {
							if ($("#select_main_user").val() == data[i].seq) {
								$("#main_tel").val(data[i].user_tel);
								$("#main_tel").click();
								$("#main_email").val(data[i].user_email);
							}
						}
					})
				}else{
					$("#select_main_user"+idx).html(html);

					$("#select_main_user"+idx).change(function () {
						$("#main_username"+idx).val($("#select_main_user"+idx+" option:selected").text());
						for (i = 0; i < data.length; i++) {
							if ($("#select_main_user"+idx).val() == data[i].seq) {
								$("#main_tel"+idx).val(data[i].user_tel);
								$("#main_tel"+idx).click();
								$("#main_email"+idx).val(data[i].user_email);
							}
						}
					})

				}
			}
		});
	}

	function monthDivision() {
		if ($("#division_month").val() == "month") {
			$("#monthlyInput").show();
			$("#month").show();
		} else {
			$("#monthlyInput").hide();
			$("#month").hide();
			$("#monthlyInput").val('');
		}
	}

	function month() {
		var monthlyInputValue = $("#monthlyInput").val();
		var divisionMonthValue = $("#division_month").val();
		$("#division_month option:eq(3)").val("m" + monthlyInputValue);
	}

	function productSearch(idx) {
		if(idx == "check"){
			var productCompany = $("#"+idx+"_product_company").val();
			var productType = $("#"+idx+"_product_type").val();
			$.ajax({
				type: "POST",
				cache: false,
				url: "<?php echo site_url();?>/ajax/product_search",
				dataType: "json",
				async: false,
				data: {
					productCompany: productCompany,
					productType: productType
				},
				success: function (data) {
					var html = "<option value=''>제품선택</option>";
					for (i = 0; i < data.length; i++) {
						html += "<option value ='" + data[i].seq + "'>" + data[i].product_name + "</option>";
					}
					$("#"+idx+"_product_name").html(html);
					$("#"+idx+"_product_name").select2();
				}
			});

		}else{
			if(idx ==undefined){
				idx='';
			}
			var productCompany = $("#product_company"+idx).val();
			var productType = $("#product_type"+idx).val();

			$.ajax({
				type: "POST",
				cache: false,
				url: "<?php echo site_url();?>/ajax/product_search",
				dataType: "json",
				async: false,
				data: {
					productCompany: productCompany,
					productType:productType
				},
				success: function (data) {
					var html = "<option value=''>제품선택</option>";
					for(i=0; i<data.length; i++){
						html += "<option value ='"+ data[i].seq +"'>" + data[i].product_name + "</option>";
					}
					$("#product_name"+idx).html(html);
					$("#product_name"+idx).select2();
				}
			});
		}
	}

	//콤마제거
	function commaCheck(obj){
		if(($(obj).val()).indexOf(',') != -1){
			alert(', 를 입력하실 수 없습니다.');
			$(obj).val($(obj).val().replace(',',''));
		}
	}

	//일괄적용
	function collectiveApplication(column,tagName){
		if($('input:checkbox[name="product_row"]:checked').length > 0){
			if(confirm("일괄수정 하시겠습니까?")){
				if(column == "product_name"){
					$('input:checkbox[name="product_row"]').each(function () {
						if (this.checked == true) {
							var idx ='';
							if(this.value != 0){
								idx = this.value;
							}
							if($("#product_company"+idx).val() != $("#check_product_company").val()){
								alert("제조사 먼저 선택적용 해주세요.");
								return false;
							}
						} 
					});
				}
				$('input:checkbox[name="product_row"]').each(function () {
					if (this.checked == true) {
						var val = $("#check_"+column).val();
						if(this.value == 0){
							if(tagName == 0){//input
								$("#"+column).val(val);
								$("#"+column).trigger('change');
							}else if(tagName == 1){//select
								$("#"+column).val(val).prop("selected",true);
							}else{//select2
								$("#"+column).val(val).prop("selected",true);
								$("#"+column).select2().val(val);
								$("#"+column).trigger('change');
							}
						}else{
							if(tagName == 0){//input
								$("#"+column+this.value).val(val);
								$("#"+column+this.value).trigger('change');
							}else if(tagName == 1){//select
								$("#"+column+this.value).val(val).prop("selected",true);
							}else{//select2
								$("#"+column+this.value).val(val).prop("selected",true);
								$("#"+column+this.value).select2().val(val);
								$("#"+column+this.value).trigger('change');
							}
						}

					}
				});
			}
		}else{
			alert("선택된 제품이 없습니다.")
			return false;
		}
	}

	//전체선택 체크박스 클릭 
	$(function () {
		$("#allCheck").click(function () { //만약 전체 선택 체크박스가 체크된상태일경우 
			if ($("#allCheck").prop("checked")) { //해당화면에 전체 checkbox들을 체크해준다 
				$("input[name=product_row]").prop("checked", true); // 전체선택 체크박스가 해제된 경우 
			} else { //해당화면에 모든 checkbox들의 체크를해제시킨다. 
				$("input[name=product_row]").prop("checked", false);
			}
		})
	})

	//매입처 수정될때마다 제품쪽 매입처 옵션 새로 넣어주기
	function addOptionMainCompany(num){
		var val = $("input[name=main_companyname]").eq(num).val();

		for(i=0; i<$("select[name=product_supplier]").length; i++){
			if ($("select[name=product_supplier]").eq(i).find($("option")).eq(num).val() == undefined) {
				var html = "<option value='" + val + "'>" + val + "</option>";
				$("select[name=product_supplier]").eq(i).html($("select[name=product_supplier]").eq(i).html() + html);
			} else {
				$("select[name=product_supplier]").eq(i).find($("option")).eq(num).val(val);
				$("select[name=product_supplier]").eq(i).find($("option")).eq(num).html(val);
			}
		}

		$("#check_product_supplier")
		if ($("#check_product_supplier").find($("option")).eq(num).val() == undefined) {
			var html = "<option value='" + val + "'>" + val + "</option>";
			$("#check_product_supplier").html($("#check_product_supplier").html() + html);
		} else {
			$("#check_product_supplier").find($("option")).eq(num).val(val);
			$("#check_product_supplier").find($("option")).eq(num).html(val);
		}

	}

	//제조사 바뀌면 하드웨어 소프트웨어 전체로 수정
	function product_type_default(idx){
		if(idx == undefined){
			idx = '';
		}else{
			idx = idx;
		}
		$("#product_type"+idx).val("");
	}

	//판매종류 선택
	function project_type(val){
		if(val == "4"){ //조달일때
			$(".procurement").show();
		}else{
			$(".procurement").hide();
		}
	}
	</script>

</body>

</html>