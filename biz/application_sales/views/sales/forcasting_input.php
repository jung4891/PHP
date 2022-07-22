<?php
include $this->input->server('DOCUMENT_ROOT') . "/include/base.php";
include $this->input->server('DOCUMENT_ROOT') . "/include/sales_top.php";
?>
<link rel="stylesheet" href="<?php echo $misc;?>css/view_page_common.css">
<style type="text/css">
.input-common {
	width: 100%;
}
.select-common {
	width: 100%;
}
.tbl-cell {
	padding-right:10px;
}
.product_tbl td {
	text-align:center;
	padding-left:5px;
	padding-right:5px;
}
#check_product_info {
	margin-left:10px;
	font-size:12px;
	font-weight: normal;
	color: #0575E6;
}
.change_collective {
  background-color: rgb(250, 162, 162);
}
.change_collective ~ span .select2-selection--single {
  background-color: rgb(250, 162, 162) !important;
}
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/js/select2.min.js"></script>
<script src="<?php echo $misc;?>js/excel/excel-bootstrap-table-filter-bundle.js"></script>
<link rel="stylesheet" href="<?php echo $misc;?>js/excel/excel-bootstrap-table-filter-style.css" />
<script type="text/javascript" src="<?php echo $misc;?>js/jquery.bpopup-0.1.1.min.js"></script>
<script>
	$(function() {
		$("#main_add").click(function() {
			$("#row_max_index").val(Number(Number($("#row_max_index").val()) + Number(1)));
			var id = "main_insert_field_" + $("#row_max_index").val();
			var id2 = "main_insert_field_2_" + $("#row_max_index").val();
			var html = "<tr id=" + id2 + " class='tbl-tr cell-tr border-t'><td class='tbl-title'>매입처</td><td class='tbl-cell'>";
			html += '<select id="select_main_company'+$("#row_max_index").val()+'" class="select-common" onchange="selectMainCompany('+$("#row_max_index").val()+');addOptionMainCompany('+$("#row_max_index").val()+');">';
			html +=	"<option value=''>매입처 선택</option>";
			html += "<?php foreach($sales_customer as $sc){ echo "<option value='".$sc['seq']."'>".$sc['company_name']."</option>";}?>";
			html += "</select><input name='main_companyname' type='text' class='input-common' id='main_companyname"+$("#row_max_index").val()+"' onchange='addOptionMainCompany("+$("#row_max_index").val()+");' style='width:97%;'/>";
			html += "</td><td class='tbl-title'>담당자</td><td class='tbl-cell'>";
			html += '<select id="select_main_user'+$("#row_max_index").val()+'" class="select-common"><option value="">담당자 선택</option></select>';
			html += "<input name='main_username' type='text' class='input-common' id='main_username"+$("#row_max_index").val()+"' style='width:97%;'/></td><td class='tbl-title'>연락처</td><td class='tbl-cell'><input name='main_tel' type='text' class='input-common' id='main_tel"+$("#row_max_index").val()+"' onclick='checkNum(this);' onKeyUp='checkNum(this);'/></td><td class='tbl-title'>이메일</td><td class='tbl-cell'><input name='main_email' type='text' class='input-common' id='main_email"+$("#row_max_index").val()+"'/></td><td align='center'><img src='<?php echo $misc; ?>img/btn_del0.jpg' style='cursor:pointer;' onclick='javascript:main_list_del(" + $("#row_max_index").val() + ");'/></td></tr>";
			$('#main_insert').before(html);
			$("#select_main_company"+$("#row_max_index").val()).select2();
			$("#sidebar_left").height($("#main_contents").height());
		});

		$("#product_add").click(function() {
			$("#row_max_index2").val(Number(Number($("#row_max_index2").val()) + Number(1)));
			var row_num = Number($("#row_max_index2").val())-1;
			var id = "product_insert_field_" + $("#row_max_index2").val(); //선
			var html = "";
			html += '<tr id="'+id+'" class="tbl-tr cell-tr"><td height="40" align="center"><input type="checkbox" class="drop" name="product_row" value="'+row_num+'" /></td>';
			html += '<td align="center" class="tbl-cell"><span class="p_num">'+$("#row_max_index2").val()+'</span></td>';
			html += '<td align="left" class="tbl-cell">';
			html += '<select name="product_company" id="product_company'+row_num+'" class="select-common" onchange="product_type_default('+row_num+');productSearch('+row_num+');">';
			html += '<option value="" >제조사</option>';
			<?php foreach($product_company as $pc){?>
				html += "<option value='<?php echo $pc['product_company'] ;?>'><?php echo $pc['product_company']; ?></option>";
			<?php }?>
			html += '</select></td>';
			html += '<td align="left" class="tbl-cell">';
			html += '<select name="product_supplier" id="product_supplier'+row_num+'" class="select-common"><option value=""></option></select></td>';
			html += '<td align="left" class="tbl-cell">';
			html += '<select name="product_type" id="product_type'+row_num+'" class="select-common" onchange="productSearch('+row_num+');">';
			html += '<option value="" selected >전체</option>';
			html += '<option value="hardware">하드웨어</option>';
			html += '<option value="software">소프트웨어</option>';
			html += '<option value="appliance">어플라이언스</option>';
			html += '</select></td>';
			html += '<td align="left" class="tbl-cell">'
			html += '<select name ="product_name" id="product_name'+row_num+'" class="select-common" onclick="productSearch('+row_num+');">';
			html += '<option value="" >제품선택</option>';
			html += '</select>';
			html += '</td>';
			html += '<td align="left" class="tbl-cell"><input name="product_licence" type="text" class="input-common" id="product_licence'+row_num+'" value="" onkeyup ="commaCheck(this);" /> </td>';
			html += '<td align="left" class="tbl-cell"><input name="product_serial" type="text" class="input-common" id="product_serial'+row_num+'" value="" onkeyup ="commaCheck(this);" /> </td>';
			html += '<td align="left" class="tbl-cell">';
			html += '<select name="product_state" id="product_state'+row_num+'" class="select-common">';
			html += '<option value="0">- 제품 상태 -</option>';
			html += '<option value="001" >입고 전</option>';
			html += '<option value="002" >창고</option>';
			html += '<option value="003">고객사 출고</option>';
			html += '<option value="004" >장애반납</option>';
			html += '</select></td>';
			html += '<td align="left" class="tbl-cell"><input name="product_sales" type="text" class="input-common" id="product_sales'+row_num+'" value="0" onclick="numberFormat(this);" onchange="numberFormat(this);product_profit_change('+row_num+',0);" style="text-align:right" /> </td>';
			html += '<td align="left" class="tbl-cell"><input name="product_purchase" type="text" class="input-common" id="product_purchase'+row_num+'" value="0" onclick="numberFormat(this);" onchange="numberFormat(this);product_profit_change('+row_num+',0);" style="text-align:right" /> </td>';
			html += '<td align="left" class="tbl-cell"><input name="product_profit" type="text" class="input-common" id="product_profit'+row_num+'" value="0" style="text-align:right" readonly /></td>';
			html += '<td align="left" class="tbl-cell"><input name="comment" type="text" class="input-common" id="comment'+row_num+'" value="" /></td>';
			html += '<td align="center" class="tbl-cell"><img src="<?php echo $misc; ?>img/btn_del0.jpg" onclick="javascript:product_list_del('+$("#row_max_index2").val()+');" style="cursor:pointer;" /></td></tr>';

			$('#product_input_place').append(html);
			$("#product_company"+row_num).select2({width:'100%'});
			$("#product_supplier"+row_num).html($("#product_supplier0").html());//제품 처음꺼랑 똑같게 매입처 option 가져오는거
			document.documentElement.scrollTop = document.body.scrollHeight; //스크롤 맨밑으로 내려
			filter_reload('product_table');
			$(".select-all").prop('checked',false);
			$("#sidebar_left").height($("#main_contents").height());
			p_numbering();
			check_product_info();
		});
	});

	function main_list_del(idx) {
		$("#main_insert_field_" + idx).remove();
		$("#main_insert_field_2_" + idx).remove();

		$("#sidebar_left").height($("#main_contents").height());
	}

	function product_list_del(idx) {
		$("#product_insert_field_" + idx).remove();
		t_forcasting_profit_change();

		$("#sidebar_left").height($("#main_contents").height());
		p_numbering();
		check_product_info();
	}

	function p_numbering() {
    var num = 1;
    $('.p_num').each(function() {
      $(this).text(num);
      num ++;
    })
  }

	function forcasting_profit_change() {
		var mform = document.cform;
		mform.forcasting_profit.value = mform.forcasting_sales.value.replace(/,/g, "") - mform.forcasting_purchase.value.replace(/,/g, "");
		mform.forcasting_profit.value = mform.forcasting_profit.value.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, "$1,");
		filter_profit_change();
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

	function product_profit_change(idx,type) {
		var product_sales = Number(String($("#product_sales"+idx).val()).replace(/,/g, ""));
		var product_purchase =Number(String($("#product_purchase"+idx).val()).replace(/,/g, ""));
		var product_profit = String(product_sales-product_purchase).replace(/(\d)(?=(?:\d{3})+(?!\d))/g, "$1,");
		$("#product_profit"+idx).val(product_profit);
		if(type == 0){//일괄적용이 아닐때만 실행(일괄적용시 실행하면 너무 느려)
			t_forcasting_profit_change();
		}
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

		if(mform.sales_type.value == '') {
			// mform.sales_type[0].focus();
			alert('매출종류를 선택해 주세요.');
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
		var objproduct_comment = document.getElementsByName("comment");

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
				$("#insert_product_array").val($("#insert_product_array").val() + "||" + objproduct_name[i].value + "~" + objproduct_supplier[i].value + "~" + objproduct_licence[i].value + "~" + objproduct_serial[i].value + "~" + objproduct_state[i].value + "~" + objproduct_product_sales[i].value.replace(/,/g, "") + "~" + objproduct_product_purchase[i].value.replace(/,/g, "") + "~" + objproduct_product_profit[i].value.replace(/,/g, "")+"~"+objproduct_comment[i].value);
			}
		}

		mform.submit();
		return false;
	}
</script>

<body>
<?php
include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>

<div align="center">
<div class="dash1-1">
	<table width="93%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
		<form name="cform" action="<?php echo site_url(); ?>/sales/forcasting/forcasting_input_action" method="post" onSubmit="javascript:chkForm();return false;">
			<input type="hidden" id="insert_main_array" name="insert_main_array" />
			<input type="hidden" id="insert_product_array" name="insert_product_array" />
			<!-- 매입처수 -->
			<input type="hidden" id="row_max_index" name="row_max_index" value="0" />
			<!-- 제품수 -->
			<input type="hidden" id="row_max_index2" name="row_max_index2" value="1" />
			<tr height="5%">
				<td class="dash_title">포캐스팅</td>
			</tr>
			<tr>
				<td align="center" valign="top">
					<table width="100%" height="100%" cellspacing="0" cellpadding="0">
						<tr>
							<td width="100%" align="center" valign="top">
								<!--내용-->
								<table width="100%" border="0" style="margin-top:50px; margin-bottom: 50px;">
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
													<td colspan="9" class="tbl-sub-title">고객사 정보
														<input type="button" class="btn-common btn-color2" value="등록" style="float:right;" onclick="javascript:chkForm();return false;">
														<input type="button" class="btn-common btn-color1" value="취소" style="margin-right:10px;float:right;" onClick="javascript:history.go(-1)">
													</td>
												</tr>
												<tr class="tbl-tr cell-tr border-t">
													<td class="tbl-title">고객사</td>
													<td class="tbl-cell">
														<select id="select_customer_company" name="select_customer_company" class="select-common" onchange="selectCustomerCompany(this);">
															<option value=''>고객사 선택</option>
															<?php foreach($sales_customer as $sc){
																echo "<option value='{$sc['seq']}'>{$sc['company_name']}</option>";
															}
															?>
														</select>
														<span style="float:right;display:none;">
															*포캐스팅 이력조회
														<img src="<?php echo $misc; ?>img/dashboard/btn/btn_search.png" width="20" id="btn_search_history" name="" onclick="search_history_customer();" style="cursor:pointer; vertical-align:top;" />
													</span>
														<input name="customer_companyname" type="hidden" class="input7" id="customer_companyname" />
												</td>
												<td class="tbl-title">담당자</td>
												<td class="tbl-cell">
													<select id="select_customer_user" class="select-common">
														<option value=''>담당자 선택</option>
													</select>
													<input name="customer_username" type="hidden" class="input7" id="customer_username" />
												</td>
												<td class="tbl-title">연락처</td>
												<td class="tbl-cell"><input type="text" name="customer_tel" id="customer_tel" class="input-common" onclick="checkNum(this);" onKeyUp="checkNum(this);" /></td>
												<td class="tbl-title">이메일</td>
												<td colspan="2" class="tbl-cell"><input type="text" name="customer_email" id="customer_email" class="input-common" /></td>
											</tr>
											<tr>
												<td height=30></td>
												<!-- 빈칸 -->
											</tr>
											<tr>
												<td class="tbl-sub-title">영업 정보</td>
											</tr>
											<tr class="tbl-tr cell-tr border-t">
												<td class="tbl-title">프로젝트</td>
												<td colspan="3" class="tbl-cell"><input name="project_name" type="text" class="input-common" id="project_name" /></td>
												<td class="tbl-title">판매종류</td>
												<td class="tbl-cell" colspan="4">
													<select name="type" id="type" class="select-common" onclick="project_type(this, this.value)" style="width:150px;">
														<option value="1">판매</option>
														<option value="2">용역</option>
														<!-- <option value="3">유지보수</option> -->
														<option value="4">조달</option>
														<option value="0" selected>선택없음</option>
													</select>
												</td>
												<td align="center" bgcolor="f8f8f9" class="t_border procurement" style="font-weight:bold;display:none;">조달 판매금액(VAT포함)</td>
												<td colspan="2" align="left" class="t_border procurement tbl-cell" style="display:none;">
													<input type="text" id="procurement_sales_amount" class="input-common" name="procurement_sales_amount" oninput="if(this.value != '0'){this.value = this.value.replace(/^0+|\D+/g, '').replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,')}" />
												</td>
											</tr>
											<tr class="tbl-tr cell-tr">
												<td class="tbl-title">진척단계</td>
												<td colspan="8" class="tbl-cell">
													<select name="progress_step" id="progress_step" class="select-common" onchange="mistake_order(this,this.value);" style="width:120px;">
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
														<option value="013">Spec in(70%)</option>
														<option value="014">수의계약(80%)</option>
														<!-- <option value="015">수주완료(85%)</option> -->
														<!-- <option value="016">매출발생(90%)</option>
														<option value="017">미수잔금(95%)</option>
														<option value="018">수금완료(100%)</option> -->
														<!-- <option value="000">실주</option> -->
													</select>
												</td>
												<td class="tbl-title mistake_order" style="display:none;">실주사유</td>
												<td colspan="5" class="tbl-cell mistake_order" style="display:none;">
													<input type="text" id="mistake_order_reason" name="mistake_order_reason" class="input-common" />
												</td>
											</tr>
											<tr class="tbl-tr cell-tr">
												<td class="tbl-title">영업업체</td>
												<td class="tbl-cell">
													<select name="cooperation_companyname" id="cooperation_companyname" class="select-common">
														<option value="미지정">선택하세요</option>
														<option value="두리안정보기술">두리안정보기술</option>
														<option value="두리안정보통신기술">두리안정보통신기술</option>
														<option value="더망고">더망고</option>
													</select>
												</td>
												<td class="tbl-title">영업담당자</td>
												<td class="tbl-cell"><input name="cooperation_username" type="text" class="input-common" id="cooperation_username" /></td>
												<td class="tbl-title">사업부</td>
												<td class="tbl-cell" colspan="5">
													<select name="dept" id="dept" class="select-common" style="width:150px;">
														<option value="미지정">선택하세요</option>
														<option value="사업1부">사업1부</option>
														<option value="사업2부">사업2부</option>
														<option value="ICT">ICT</option>
														<option value="MG">MG</option>
														<option value="기술지원부">기술지원부</option>
													</select>
												</td>
												<input name="cooperation_tel" type="hidden" class="input5" id="cooperation_tel" onclick="checkNum(this);" onKeyUp="checkNum(this);" />
												<!--                    <td class="tbl-title">이메일</td>-->
												<!--		    <td colspan="2" class="tbl-cell"> -->
												<input name="cooperation_email" type="hidden" class="input5" id="cooperation_email" />
												</td>
											</tr>
											<tr class="tbl-tr cell-tr">
												<td class="tbl-title">정보통신공사업</td>
												<td class="tbl-cell" colspan="3">
													<input type="radio" name="infor_comm_corporation" value="Y" /> 신청
													<input type="radio" name="infor_comm_corporation" value="N" checked /> 미신청
												</td>
												<td class="tbl-title">매출종류</td>
												<td class="tbl-cell" colspan="3">
													<input type="radio" name="sales_type" value="delivery"/> 납품
													<input type="radio" name="sales_type" value="circulation"/> 유통
												</td>
											</tr>
											<tr>
												<td height=30></td>
												<!-- 빈칸 -->
											</tr>
											<tr>
												<td class="tbl-sub-title">매출처 정보</td>
											</tr>
											<tr class="tbl-tr cell-tr border-t">
												<td class="tbl-title">매출처</td>
												<td class="tbl-cell">
													<select id="select_sales_company" class="select-common" onchange="selectSalesCompany(this); ">
														<option value=''>매출처 선택</option>
														<?php foreach($sales_customer as $sc){
															echo "<option value='{$sc['seq']}'>{$sc['company_name']}</option>";
														}
														?>
													</select>

													<input name="sales_companyname" type="text" class="input-common" id="sales_companyname" style="width:97%"/>

												</td>
												<td class="tbl-title">담당자</td>
												<td class="tbl-cell">
													<select id="select_sales_user" class="select-common">
														<option value=''>담당자 선택</option>
													</select>
													<input name="sales_username" type="text" class="input-common" id="sales_username" style="width:97%"/>
												</td>
												<td class="tbl-title">연락처</td>
												<td class="tbl-cell"><input name="sales_tel" type="text" class="input-common" id="sales_tel" onclick="checkNum(this);" onKeyUp="checkNum(this);" /></td>
												<td class="tbl-title">이메일</td>
												<td colspan="2" class="tbl-cell"><input name="sales_email" type="text" class="input-common" id="sales_email" /></td>
											</tr>
											<tr>
												<td height=30></td>
												<!-- 빈칸 -->
											</tr>
											<tr>
												<td class="tbl-sub-title">매입처 정보</td>
											</tr>
									<!--시작라인-->
											<tr class="tbl-tr cell-tr border-t">
												<td class="tbl-title">매입처</td>
												<td class="tbl-cell">
													<select id="select_main_company" class="select-common" onchange="selectMainCompany();addOptionMainCompany(0);">
														<option value=''>매입처 선택</option>
														<?php foreach($sales_customer as $sc){
																echo "<option value='{$sc['seq']}'>{$sc['company_name']}</option>";
															}
														?>
													</select>
													<input name="main_companyname" type="text" class="input-common" id="main_companyname" onchange="addOptionMainCompany(0);" style="width:97%"/>
												</td>
												<td class="tbl-title">담당자</td>
												<td class="tbl-cell">
													<select id="select_main_user" class="select-common">
														<option value=''>담당자 선택</option>
													</select>
													<input name="main_username" type="text" class="input-common" id="main_username" style="width:97%"/>
												</td>
												<td class="tbl-title">연락처</td>
												<td class="tbl-cell"><input name="main_tel" type="text" class="input-common" id="main_tel" onclick="checkNum(this);" onKeyUp="checkNum(this);" /></td>
												<td class="tbl-title">이메일</td>
												<td class="tbl-cell"><input name="main_email" type="text" class="input-common" id="main_email" /></td>
												<td align="center"><img src="<?php echo $misc; ?>img/btn_add.jpg" id="main_add" name="main_add" style="cursor:pointer;" /></td>
											</tr>
											<tr id="main_insert">
												<td height=30></td>
												<!-- 빈칸 -->
											</tr>
											<tr>
												<td class="tbl-sub-title" colspan="3">제품 정보<span id="check_product_info"></span></td>
											</tr>
											<tr>
												<td colspan=9 height="40" align="left">
												<table style="width:100%;" border="0" cellspacing="0" cellpadding="0">
													<colgroup>
														<col width="5%" />
														<col width="23%" />
														<col width="10%" />
														<col width="23%" />
														<col width="10%" />
														<col width="23%" />
														<col width="6%" />
													</colgroup>
													<tr>
													 <td colspan=9><span style="font-weight:bold;font-size:13px;">* 일괄적용</span><br></td>
													</tr>
													<tr class="tbl-tr cell-tr border-t">
														<td class="tbl-title">제조사</td>
														<td class="tbl-cell" align="left">
															<select id="check_product_company" class="select-common" onchange="productSearch('check');product_collective(this);$('#check_product_name').change();">
																<option value="" >제조사</option>
																<?php foreach($product_company as $pc){
																	echo "<option value='{$pc['product_company']}'>{$pc['product_company']}</option>";
																}?>
															</select>
															<input type="button" class="btn-common btn-style1" value="선택적용" onclick="collectiveApplication('product_company',2);" style="cursor:pointer;width:80px;" />
														</td>
														<td class="tbl-title">매입처</td>
														<td class="tbl-cell" align="left">
															<select id="check_product_supplier" class="select-common" style="width:200px;" onchange="product_collective(this);">
															<?php foreach($view_val2 as $item2){
																echo "<option value='{$item2['main_companyname']}'";
																if($item3['product_supplier'] == $item2['main_companyname']){
																	echo "selected";
																}
																echo ">{$item2['main_companyname']}</option>";
															}?>
															</select>
															<input type="button" class="btn-common btn-style1" value="선택적용" onclick="collectiveApplication('product_supplier',1);" style="width:80px;cursor:pointer;" />
														</td>
														<td class="tbl-title">제품상태</td>
														<td class="tbl-cell" align="left">
															<select id="check_product_state" class="select-common" style="width:200px;" onchange="product_collective(this);">
																<option value="0">- 제품 상태 -</option>
																<option value="001">입고 전</option>
																<option value="002">창고</option>
																<option value="003">고객사 출고</option>
																<option value="004">장애반납</option>
															</select>
															<input type="button" class="btn-common btn-style1" value="선택적용" onclick="collectiveApplication('product_state',1);" style="width:80px;cursor:pointer;" />
														</td>
														<td class="tbl-cell" rowspan="2">
															<input type="button" class="btn-common btn-style1" value="일괄적용" onclick="collectiveApplication_all();" style="width:80px;cursor:pointer;" />
														</td>
													</tr>
													<tr class="tbl-tr cell-tr">
														<td class="tbl-title">제품명</td>
														<td class="tbl-cell" align="left">
															<select id="check_product_name" class="select-common" style="width:200px;" onclick="productSearch('check');" onchange="product_collective(this);">
																<option value="" selected>제조사를 선택해주세요</option>
															</select>
															<input type="button" class="btn-common btn-style1" value="선택적용" onclick="collectiveApplication('product_name',2);" style="width:80px;cursor:pointer;" />
														</td>
														<td class="tbl-title">장비매출가</td>
														<td class="tbl-cell" align="left">
															<input type="text" class="input-common" id="check_product_sales" value=0 onclick="numberFormat(this);" onchange="numberFormat(this);product_collective(this);" style="width:195px;"/>
															<input type="button" class="btn-common btn-style1" value="선택적용" onclick="collectiveApplication('product_sales',0);" style="width:80px;cursor:pointer;" />
														</td>
														<td class="tbl-title">장비매입가</td>
														<td class="tbl-cell" align="left">
															<input type="text" class="input-common" id="check_product_purchase" value=0 onclick="numberFormat(this);" onchange="numberFormat(this);product_collective(this);" style="width:195px;"/>
															<input type="button" class="btn-common btn-style1" value="선택적용" onclick="collectiveApplication('product_purchase',0);" style="width:80px;cursor:pointer;" />
														</td>
													</tr>
												</table>
												</td>
											</tr>
									<!--시작라인-->
									<tr>
										<td height="20"></td>
									</tr>
									<tr>
										<td colspan="9" >
											<img src="<?php echo $misc;?>/img/filter_refresh.png" onclick="filter_reset('product_table');" width=20 style="float:right;cursor:pointer;margin-bottom:5px;"/>
										</td>
									</tr>
									<tr>
										<td colspan=9>
											<table id="product_table" class ="basic_table" style="width:100%;" onchange="filter_reload('product_table',event)" border="0" cellspacing="0" cellpadding="0">
												<colgroup>
													<col width="3%" />
													<col width="3%" />
													<col width="8%" />
													<col width="10%" />
													<col width="7%" />
													<col width="10%" />
													<col width="7%" />
													<col width="10%" />
													<col width="8%" />
													<col width="8%" />
													<col width="8%" />
													<col width="8%" />
													<col width="7%" />
													<col width="3%" />
												</colgroup>
												<thead>
												<tr class="tbl-tr cell-tr border-t row-color1">
													<th><input type="checkbox" id="allCheck" class="drop" /></th>
													<th class="apply-filter" >
													<input type="hidden" id="filter0" class="filter_n" value="all">
													번호
													</th>
													<th class="apply-filter"><input type="hidden" class="filter_n" value="all">제조사</th>
													<th class="apply-filter"><input type="hidden" class="filter_n" value="all">매입처</th>
													<th class="apply-filter"><input type="hidden" class="filter_n" value="all">하드웨어/소프트웨어</th>
													<th class="apply-filter"><input type="hidden" class="filter_n" value="all">제품명</th>
													<th class="apply-filter"><input type="hidden" class="filter_n" value="all">라이선스 수량</th>
													<th class="apply-filter"><input type="hidden" class="filter_n" value="all">hardware/software<br>serial number</th>
													<th class="apply-filter"><input type="hidden" class="filter_n" value="all">제품 상태</th>
													<th class="apply-filter"><input type="hidden" class="filter_n" value="all">장비매출가</th>
													<th class="apply-filter"><input type="hidden" class="filter_n" value="all">장비매입가</th>
													<th class="apply-filter"><input type="hidden" class="filter_n" value="all">장비마진</th>
													<th class="apply-filter"><input type="hidden" class="filter_n" value="all">비고</th>
													<th><img src="<?php echo $misc; ?>img/btn_add.jpg" id="product_add" class="drop" name="product_add" style="cursor:pointer;" /></th>
												</tr>
												</thead>
												<tbody id="product_input_place">
												<tr id="product_insert_field_1" class="tbl-tr cell-tr">
													<td height="40" align="center">
														<input type="hidden" name ="product_seq" id="product_seq0" value="" />
														<input type="checkbox" name="product_row" value="0" class="drop" />
													</td>
													<td align="center" class="tbl-cell" ><span class="p_num">1</span></td>
													<td align="center" class="tbl-cell">
														<select name="product_company" id="product_company0" class="select-common" onchange="product_type_default(0);productSearch(0);">
															<option value="" >제조사</option>
															<?php foreach($product_company as $pc){
																echo "<option value='{$pc['product_company']}'>{$pc['product_company']}</option>";
															}?>
														</select>
													</td>
													<td align="left" class="tbl-cell">
														<select name="product_supplier" id="product_supplier0" class="select-common" >
															<option value=""></option>
														</select>
													</td>
													<td align="left" class="tbl-cell">
														<select name="product_type" id="product_type0" class="select-common" onchange="productSearch(0);">
															<option value="" selected >전체</option>
															<option value="hardware">하드웨어</option>
															<option value="software">소프트웨어</option>
															<option value="appliance">어플라이언스</option>
														</select>
													</td>
													<td align="left" class="tbl-cell">
														<select name ="product_name" id="product_name0" class="select-common" onclick="productSearch();">
															<option value="" >제품선택</option>
														</select>
													</td>
													<td align="left" class="tbl-cell">
														<input name="product_licence" type="text" class="input-common" id="product_licence0" value="" onkeyup ="commaCheck(this);" />
													</td>
													<td align="left" class="tbl-cell">
														<input name="product_serial" type="text" class="input-common" id="product_serial0" value="" onkeyup ="commaCheck(this);" />
													</td>
													<td align="left" class="tbl-cell">
														<select name="product_state" id="product_state0" class="select-common">
															<option value="0">- 제품 상태 -</option>
															<option value="001">입고 전</option>
															<option value="002">창고</option>
															<option value="003">고객사 출고</option>
															<option value="004">장애반납</option>
														</select>
													</td>
													<td align="left" class="tbl-cell">
														<input name="product_sales" type="text" class="input-common" id="product_sales0" value="0" onclick="numberFormat(this);" onchange="numberFormat(this);product_profit_change(0,0);" style="text-align:right" />
													</td>
													<td align="left" class="tbl-cell">
														<input name="product_purchase" type="text" class="input-common" id="product_purchase0" value="0" onclick="numberFormat(this);" onchange="numberFormat(this);product_profit_change(0,0);" style="text-align:right" />
													</td>
													<td align="left" class="tbl-cell">
														<input name="product_profit" type="text" class="input-common" id="product_profit0" value="0" style="text-align:right" readonly />
													</td>
													<td align="center" class="tbl-cell">
														<input name="comment" type="text" class="input-common" id="comment0" value="" />
													</td>
													<td align="center"></td>
												</tr>
												</tbody>
											</table>
											<table id="filter_sales" class="basic_table" style="min-width:100%;display:none;" border="0" cellspacing="0" cellpadding="0">
												<colgroup>
													<col width="3%" />
													<col width="3%" />
													<col width="8%" />
													<col width="10%" />
													<col width="7%" />
													<col width="10%" />
													<col width="7%" />
													<col width="10%" />
													<col width="8%" />
													<col width="8%" />
													<col width="8%" />
													<col width="8%" />
													<col width="7%" />
													<col width="3%" />
												</colgroup>
													<tr class="tbl-tr cell-tr row-color1">
														<th colspan=9></th>
														<th>필터별총매출가</th>
														<th>필터별총매입가</th>
														<th>필터별총마진</th>
														<th colspan=2></th>
													</tr>
													<tr class="tbl-tr cell-tr">
														<td colspan=9></td>
														<td align="right" id="filter_forcasting_sales" class="tbl-cell"><?php echo number_format($view_val['forcasting_sales']); ?></td>
														<td align="right" id="filter_forcasting_purchase" class="tbl-cell"><?php echo number_format($view_val['forcasting_purchase']); ?></td>
														<td align="right" id="filter_forcasting_profit" class="tbl-cell"><?php echo number_format($view_val['forcasting_profit']); ?></td>
														<td></td>
														<td></td>
													</tr>
											</table>
											<table class ="basic_table" style="width:100%;" border="0" cellspacing="0" cellpadding="0">
												<colgroup>
													<col width="3%" />
													<col width="3%" />
													<col width="8%" />
													<col width="10%" />
													<col width="7%" />
													<col width="10%" />
													<col width="7%" />
													<col width="10%" />
													<col width="8%" />
													<col width="8%" />
													<col width="8%" />
													<col width="8%" />
													<col width="7%" />
													<col width="3%" />
												</colgroup>
												<tr class="tbl-tr cell-tr row-color1">
													<th colspan=9></th>
													<th height="40" align="center" >총매출가</th>
													<th height="40" align="center" >총매입가</th>
													<th height="40" align="center" >총마진</th>
													<th></th>
													<th></th>
												</tr>
												<tr class="tbl-tr cell-tr">
													<td colspan=9></td>
													<td align="left" class="tbl-cell"><input name="forcasting_sales" type="text" class="input-common" id="forcasting_sales" value="0" onchange="forcasting_profit_change();" style="text-align:right" readonly /> </td>
													<td align="left" class="tbl-cell"><input name="forcasting_purchase" type="text" class="input-common" id="forcasting_purchase" value="0" onchange="forcasting_profit_change();" style="text-align:right" readonly /> </td>
													<td align="left" class="tbl-cell"><input name="forcasting_profit" type="text" class="input-common" id="forcasting_profit" value="0" style="text-align:right" readonly /></td>
												    <td></td>
													<td></td>
												</tr>
											</table>
										</td>
									</tr>
						<tr>
							<td colspan="9" height="40"></td>
						</tr>
						<tr class="tbl-tr cell-tr border-t">
							<td class="tbl-title">분할월수</td>
							<!-- <td colspan="2" class="tbl-cell"><select name="division_month" id="division_month" class="input5" onchange="monthDivision()"> -->
							<td colspan="1" class="tbl-cell">
								<select name="division_month" id="division_month" class="select-common" onchange="monthDivision()" style="width:100px;">
									<option value="12" selected>당월</option>
									<option value="6">반기별</option>
									<option value="3">분기별</option>
									<option value="month">월별</option>
									<input type="text" name="monthly_input" id="monthlyInput" class="input-common" onchange="month()" style="display:none;margin-left:5px;width:100px;"></input>
									<div id="month" style="float:right;display:none;">개월<div>
							</td>
							<td class="tbl-title">최초 매출일</td>
							<td class="tbl-cell"><input name="first_saledate" type="date" class="input-common" id="first_saledate"/></td>
							<td class="tbl-title">예상 매출일</td>
							<td class="tbl-cell"><input name="exception_saledate" type="date" class="input-common" id="exception_saledate"/></td>
							<td class="tbl-title">무상보증 종료일</td>
							<td class="tbl-cell" colspan="3"><input name="warranty_end_date" type="date" class="input-common" id="warranty_end_date"/></td>
						</tr>
						<tr>
							<td height=30></td>
						</tr>
						<tr>
							<td class="tbl-sub-title">수주 정보</td>
						</tr>
						<!--시작라인-->
						<tr class="tbl-tr cell-tr border-t">
							<td class="tbl-title">수주여부</td>
							<td colspan="8" class="tbl-cell">
								<select name="complete_status" id="complete_status" class="select-common" style="width:250px;">
									<option value="0">-수주여부-</option>
									<option value="001">수주중</option>
									<option value="002">수주완료</option>
								</select></td>
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
				<td align="right">
					<input type="button" class="btn-common btn-color2" value="등록" style="float:right;" onclick="javascript:chkForm();return false;">
					<input type="button" class="btn-common btn-color1" value="취소" style="margin-right:10px;float:right;" onClick="javascript:history.go(-1)">
				</td>
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
</div>
</div>


<!-- 히스토리 모달 -->
<div id = "customer_history" style="display:none; position: absolute; background-color: white; width: auto; height: auto; min-width:800px;">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" id="customer_history_table" class = "content_dash_tbl">
				<colgroup>
					<col width="9%" />
					<col width="3%" />  <!--번    호-->
					<col width="15%" />	<!--종    류-->
					<col width="20%" />	<!--고 객 사-->
					<col width="25%" />	<!--프로젝트-->
					<col width="10%" /> <!--예상월-->
					<col width="6%" />  <!--단계-->
					<col width="12%" />
				</colgroup>
				<thead>
				<tr class="t_top">
					<th></th>
					<th align="center" height=40>번호</th>
					<th align="center">고객사</th>
					<th align="center">종류</th>
					<th align="center">프로젝트</th>
					<th align="center">예상월</th>
					<th align="center">진척단계</th>
					<th aling="right"><img src="<?php echo $misc;?>img/dashboard/btn/icon_x.svg" width="20" height="20" style="cursor:pointer;" onclick="$('#customer_history').bPopup().close();"/></th>
				</tr>
			</thead>
				<tbody id = "customer_tbody">

			</tbody>
			</table>
</div>
<!--하단-->
<?php include $this->input->server('DOCUMENT_ROOT') . "/include/sales_bottom.php"; ?>
<!--//하단-->
	<script>
	//select box 검색 기능
	$("#check_product_company").select2({width:'54%'});
	$("#product_company0").select2({width:'100%'});
	// $("#select_sales_company").select2({width:'100%'});
	// $("#select_main_company").select2({width:'100%'});
	$("#select_customer_company, #select_main_company, #select_sales_company").select2({
		width:'100%',
		ajax:{
			type: "POST",
			url:"<?php echo site_url();?>/sales/forcasting/select_customer",
			dataType:'json',
			delay: 250,
			data: function(params){
				var keyword = {
					keyword: params.term
				}
				return keyword;
			},

		processResults: function(data){
			console.log(data);
			return{
				results: data
			};
		}
	}
});
// 고객사 회사명이랑 담당자 바뀔 때
function selectCustomerCompany(ths){
	var seq = $(ths).val();
	var customer_name = $("#select_customer_company option:selected").text();

	$("#customer_companyname").val(customer_name)
	// alert(seq + customer_name);
	$("#customer_username").val("");
	$("#customer_tel").val("");
	// $("#customer_tel").click();
	$("#customer_email").val("");
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
			// console.log(data.length);
			var html = "<option value='' selected>담당자 선택</option>";
			if(data.length == 0 ){
				$("#customer_username").prop('type','text');
			}else{
				$("#customer_username").prop('type','hidden');
			}
			for (i = 0; i < data.length; i++) {
				html += "<option value=" + data[i].seq + ">" + data[i].user_name + "</option>"
			}
			$("#select_customer_user").html(html);

			$("#select_customer_user").change(function () {
				$("#customer_username").val($("#select_customer_user option:selected").text());
				for (i = 0; i < data.length; i++) {
					if ($("#select_customer_user").val() == data[i].seq) {
						$("#customer_tel").val(data[i].user_tel);
						$("#customer_tel").click();
						$("#customer_email").val(data[i].user_email);
					}

				}
if ($("#select_customer_user").val() == ""){
	$("#customer_tel").val("");
	// $("#customer_tel").click();
	$("#customer_email").val("");
}

			})
		}
	});
}

// 고객사 포캐스팅 이력 조회 하는거
function search_history_customer(){
	var customer_seq = $("#select_customer_company option:selected").val();
	// console.log(customer_seq);
	$.ajax({
		url: "<?php echo site_url();?>/sales/forcasting/search_history_customer",
		type: "POST",
		dataType: "json",
		// async:false,
		data: {
			customer_seq: customer_seq
		},
		success: function (data) {
			console.log(data);
			if(data == "zero"){
				alert("검색 결과가 없습니다.");
			}else{
				console.log(data.length);
			$('#customer_history_table > tbody').empty();
				var td ="";
				for (var i = 0; i < data.length; i++) {

					if(data[i].type==1){
						var strType = "판매";
					}else if(data[i].type==2){
						var strType = "용역";
					}else if(data[i].type==3){
						var strType = "유지보수";
					}else if(data[i].type==4){
						var strType = "조달";
					}else{
						var strType = "";
					}

					if(data[i].progress_step == "001"){
							var strStep = "영업보류(0%)";
					}else if(data[i].progress_step == "002"){
							var strStep = "고객문의(5%)";
					}else if(data[i].progress_step == "003"){
							var strStep = "영업방문(10%)";
					}else if(data[i].progress_step == "004"){
							var strStep = "일반제안(15%)";
					}else if(data[i].progress_step == "005"){
							var strStep = "견적제출(20%)";
					}else if(data[i].progress_step == "006"){
							var strStep = "맞춤제안(30%)";
					}else if(data[i].progress_step == "007"){
							var strStep = "수정견적(35%)";
					}else if(data[i].progress_step == "008"){
							var strStep = "RFI(40%)";
					}else if(data[i].progress_step == "009"){
							var strStep = "RFP(45%)";
					}else if(data[i].progress_step == "010"){
							var strStep = "BMT(50%)";
					}else if(data[i].progress_step == "011"){
							var strStep = "DEMO(55%)";
					}else if(data[i].progress_step == "012"){
							var strStep = "가격경쟁(60%)";
					}else if(data[i].progress_step == "013"){
							var strStep = "Spec in(70%)";
					}else if(data[i].progress_step == "014"){
							var strStep = "수의계약(80%)";
					}else if(data[i].progress_step == "015"){
							var strStep = "수주완료(85%)";
					}else if(data[i].progress_step == "016"){
							var strStep = "매출발생(90%)";
					}else if(data[i].progress_step == "017"){
							var strStep = "미수잔금(95%)";
					}else if(data[i].progress_step == "018"){
							var strStep = "수금완료(100%)";
					}else if(data[i].progress_step == "000"){
							var strStep = "실주";
					}


					td += "<tr><td align='center' height=40></td>";
					td += "<td align='center'>"+(i+1)+"</td>";
					td += "<td align='center'>"+data[i].customer_companyname+"</td>";
					td += "<td align='center'>"+strType+"</td>";
					td += "<td align='center'>"+data[i].project_name+"</td>";
					td += "<td align='center'>"+data[i].exception_saledate+"</td>";
					td += "<td align='center'>"+strStep+"</td>";
					td += "<td></td></tr>";

				}
				$('#customer_history_table > tbody').append(td);
				$("#customer_history").bPopup();
			}
		}
	})
}

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
			if(confirm("선택 수정 하시겠습니까?")){
				if(column == "product_name"){
					$('input:checkbox[name="product_row"]').each(function () {
						if (this.checked == true) {
							var idx = this.value;
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
						if(tagName == 0){//input
							$("#"+column+this.value).val(val);
							if(column=="product_sales" || column=="product_purchase" ){
								product_profit_change(this.value,1);
							}else{
								$("#"+column+this.value).trigger('change');
							}
						}else if(tagName == 1){//select
							$("#"+column+this.value).val(val).prop("selected",true);
						}else{//select2
							$("#"+column+this.value).val(val).prop("selected",true);
							$("#"+column+this.value).select2().val(val);
							$("#"+column+this.value).trigger('change');
						}
					}
				});
				if(column=="product_sales" || column=="product_purchase" ){
					t_forcasting_profit_change();
					forcasting_profit_change();
				}
			}
			filter_reload('product_table');
		}else{
			alert("선택된 제품이 없습니다.")
			return false;
		}
	}

	function collectiveApplication_all() {
    if($('input:checkbox[name="product_row"]:checked').length > 0){
			var change_t = '';
      var change_collective = [];
      $('.change_collective').each(function(){
        var td = $(this).closest('td').prev();
        var name = td.text();
        change_t += '\n' + name;
        change_collective.push($(this).attr('id'));
      })

			if(change_collective.length == 0) {
				alert('변동사항이 없습니다.');
				return false;
			}

      if(confirm('일괄수정 하시겠습니까?\n----변경사항----' + change_t)) {
        var input_t = ['product_sales', 'product_purchase'];
        var select_t = ['product_state', 'product_supplier'];
        var select2_t = ['product_company', 'product_name'];
        $('input:checkbox[name="product_row"]').each(function() {
          if(this.checked == true) {
            for (var i = 0; i < input_t.length; i++) {
              var column = input_t[i];
							if($.inArray('check_'+column, change_collective) != -1) {

	              var val = $('#check_'+column).val();

								$("#"+column+this.value).val(val);
								if(column=="product_sales" || column=="product_purchase" ){
									product_profit_change(this.value,1);
								}else{
									$("#"+column+this.value).trigger('change');
								}
							}
            }
            for (var i = 0; i < select_t.length; i++) {
              var column = select_t[i];

							if($.inArray('check_'+column, change_collective) != -1) {
	              var val = $('#check_'+column).val();

	              $("#"+column+this.value).val(val).prop("selected",true);
							}
            }
            for (var i = 0; i < select2_t.length; i++) {
              var column = select2_t[i];

							if($.inArray('check_'+column, change_collective) != -1) {
	              var val = $('#check_'+column).val();

								$("#"+column+this.value).val(val).prop("selected",true);
								$("#"+column+this.value).select2().val(val);
								$("#"+column+this.value).trigger('change');
							}
            }
          }
        });
        filter_reload('product_table');
				t_forcasting_profit_change();
				forcasting_profit_change();
      }
    } else {
      alert('선택된 제품이 없습니다.');
      return false;
    }
  }

	//전체선택 체크박스 클릭
	$(function () {
		$("#allCheck").click(function () { //만약 전체 선택 체크박스가 체크된상태일경우
			if ($("#allCheck").prop("checked")) { //해당화면에 전체 checkbox들을 체크해준다
				for(i=0; i< $("input[name=product_row]").length; i++){
					var tr = $("input[name=product_row]").eq(i).parent().parent();
					var td = $("input[name=product_row]").eq(i).parent();
					if(tr.css('display') !== 'none' && td.css('display') !== 'none'){
						$("input[name=product_row]").eq(i).prop("checked", true);
					}
				}
				// $("input[name=product_row]").prop("checked", true);
			} else { //해당화면에 모든 checkbox들의 체크를해제시킨다.
				$("input[name=product_row]").prop("checked", false);
			}
			check_product_info();
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
		filter_reload('product_table');

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
	function project_type(el, val){
		if(val == "4"){ //조달일때
			$(".procurement").show();
			$(el).closest('td').attr('colspan', '1');
		}else{
			$(".procurement").hide();
			$(el).closest('td').attr('colspan', '4');
		}
	}

	//실주일 경우에 실주사유 쓰는 칸 생성!
	function mistake_order(el, val){
		if(val == "000"){//실주일때!
			$(".mistake_order").show();
			$(el).closest('td').attr('colspan', '3');
		}else{
			$(".mistake_order").hide();
			$(el).closest('td').attr('colspan', '8');
		}
	}

	//필터적용햇을때 돈계싼(수정전용)
	function filter_profit_change(){
		var forcasting_sales = 0;
		var forcasting_purchase = 0;
		var forcasting_profit = 0;
		for (var i = 0; i <$("input[name=product_sales]").length; i++) {
			if($("input[name=product_sales]").eq(i).parent().parent().css('display') !== 'none' && $("input[name=product_sales]").eq(i).parent().css('display') !== 'none' ){
				forcasting_sales +=  parseInt($("input[name=product_sales]").eq(i).val().replace(/,/g, ""));
				forcasting_purchase += parseInt($("input[name=product_purchase]").eq(i).val().replace(/,/g, ""));
				forcasting_profit += parseInt($("input[name=product_profit]").eq(i).val().replace(/,/g, ""));
			}
			$("#filter_forcasting_sales").text(String(forcasting_sales).replace(/(\d)(?=(?:\d{3})+(?!\d))/g, "$1,"));
			$("#filter_forcasting_purchase").text(String(forcasting_purchase).replace(/(\d)(?=(?:\d{3})+(?!\d))/g, "$1,"));
			$("#filter_forcasting_profit").text(String(forcasting_profit).replace(/(\d)(?=(?:\d{3})+(?!\d))/g, "$1,"));
		}
		$("#filter_sales").show();
	}

	//엑셀필터 적용
	$(function () {
      // Apply the plugin
      $('#product_table').excelTableFilter({
		columnSelector: '.apply-filter',
		captions :{a_to_z: '오름차순',
        z_to_a: '내림차순',
        search: 'Search',
        select_all: '전체'}
	  });
    });

	//필터 다시 돌려
	function filter_reload(target,e){
		if(e != undefined){
			if($(e.target).attr('class').indexOf('drop') === -1){
				$('#'+target).find($(".dropdown-filter-dropdown")).remove();
				$('#'+target).excelTableFilter({
					columnSelector: '.apply-filter',
					captions :{a_to_z: '오름차순',
					z_to_a: '내림차순',
					search: 'Search',
					select_all: '전체'}
				});
			}
		}else{
			$('#'+target).find($(".dropdown-filter-dropdown")).remove();
			$('#'+target).excelTableFilter({
				columnSelector: '.apply-filter',
				captions :{a_to_z: '오름차순',
				z_to_a: '내림차순',
				search: 'Search',
				select_all: '전체'}
			});
		}
	}

	//엑셀필터 초기화
	function filter_reset(target){
		$("#"+target).find($(".오름차순:first")).trigger("click");
		$("#"+target).find("tr").show();
		$("#"+target).find("td").show();
		$("#"+target).find($(".filter_n")).val('all');
		if(target.indexOf("product") !== -1){
			for (var i = 0; i <$("td[name=product_sales]").length; i++) {
				$("td[name=product_sales]").eq(i).show();
				$("td[name=product_sales]").eq(i).parent().show();
			}
			$("#filter_sales").hide();
		}
		filter_reload(target);
		$("#"+target).find($(".select-all:not(:checked)")).trigger("click");
	}

  $(function() {
    check_product_info();
  })

  $('#product_table input[name="product_row"]').change(function() {
    check_product_info();
  })

  function check_product_info() {
    var total = $('#product_table input[name="product_row"]').length;
    var checked = $('#product_table input[name=product_row]:checked').length;

    $('#check_product_info').text('선택 수 : 총 ' + total + ' 중 ' + checked + ' 건');
  }

	function product_collective(el) {
	  console.log($(el).val());
	  if($(el).val()!= '' && $(el).val()!= '0') {
	    $(el).addClass('change_collective');
	  } else if ($(el).val()=='' || $(el).val()=='0') {
	    $(el).removeClass('change_collective');
	  }
	}
</script>
</body>
</html>
