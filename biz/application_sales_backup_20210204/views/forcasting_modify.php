<?php
include $this->input->server('DOCUMENT_ROOT') . "/include/base.php";
include $this->input->server('DOCUMENT_ROOT') . "/include/sales_top.php";
?>
<style type="text/css">
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
			var html ="<tr class=" + id + "><td colspan='9' height='1' bgcolor='#e8e8e8'></td></tr><tr class=" + id + "><td height='70' align='center' class='t_border' bgcolor='f8f8f9' style='font-weight:bold;'>매입처</td><td colspan=3 align='left' class='t_border' style='padding-left:10px;'>";
			html += '<select id="select_main_company'+$("#row_max_index").val()+'" class="input2" onchange="selectMainCompany('+$("#row_max_index").val()+'); ">';
			html +=	"<option value=''>매입처 선택</option>";
			html += "<?php foreach($sales_customer as $sc){ echo "<option value='".$sc['seq']."'>".$sc['company_name']."</option>";}?>";
			html += "</select><br><input name='main_companyname' type='text' class='input2' id='main_companyname"+$("#row_max_index").val()+"'/></td><td align='center' bgcolor='f8f8f9' class='t_border' style='font-weight:bold;'>담당자</td><td align='left' class='t_border' style='padding-left:10px;'>";
			html += '<select id="select_main_user'+$("#row_max_index").val()+'" class="input2" onchange="selectMainUser('+$("#row_max_index").val()+')"><option value="">담당자 선택</option></select><br>';
			html += "<input name='main_username' type='text' class='input2' id='main_username"+$("#row_max_index").val()+"'/></td></tr><tr class=" + id + "><td colspan='9' height='1' bgcolor='#e8e8e8'></td></tr><tr class=" + id + "><td height='40' align='center' bgcolor='f8f8f9' class='t_border' style='font-weight:bold;'>연락처</td><td colspan=3 align='left' class='t_border' style='padding-left:10px;'><input name='main_tel' type='text' class='input2' id='main_tel"+$("#row_max_index").val()+"' onclick='checkNum(this);' onKeyUp='checkNum(this);'/></td><td align='center' bgcolor='f8f8f9' class='t_border' style='font-weight:bold;'>이메일</td><td colspan=3 align='left' class='t_border' style='padding-left:10px;'><input name='main_email' type='text' class='input2' id='main_email"+$("#row_max_index").val()+"'/></td><td align='left' style='padding-left:10px;'><img src='<?php echo $misc; ?>img/btn_del0.jpg' style='cursor:pointer;' onclick='javascript:main_list_del(" + $("#row_max_index").val() + ");'/></td></tr>";
			html += "<tr class=" + id + "><td colspan=9 height='2' bgcolor='#797c88'></td></tr>";
			$('#main_insert').before(html);
			$("#select_main_company"+$("#row_max_index").val()).select2();
			document.documentElement.scrollTop = document.body.scrollHeight; //스크롤 맨밑으로 내려
		});

		$("#product_add").click(function() {
			$("#row_max_index2").val(Number(Number($("#row_max_index2").val()) + Number(1)));
			var row_num = Number($("#row_max_index2").val())-1;
			var id3 = "product_insert_field_" + $("#row_max_index2").val(); //선
			var id4 = "product_insert_field_1_" + $("#row_max_index2").val();
			var id5 = "product_insert_field_2_" + $("#row_max_index2").val();
			var id6 = "product_insert_field_3_" + $("#row_max_index2").val();
			var html = "<tr class=" + id3 + "><td colspan='9' height='1' bgcolor='#e8e8e8'></td></tr><tr id=" + id4 + ">";
			html += '<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;"><input type="checkbox" name="product_row" value="'+row_num+'" /><br>제조사</td><td align="left" class="t_border" style="padding-left:10px;" colspan="1">';
			html += '<select name="product_company" id="product_company'+row_num+'" class="input7" onchange="product_type_default('+row_num+');productSearch('+row_num+');"><option value="">제조사</option>';
			<?php foreach($product_company as $pc){?>
				html += "<option value='<?php echo $pc['product_company'];?>'><?php echo $pc['product_company']; ?></option>";
			<?php } ?>
			html += '<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">매입처</td><td colspan=3 align="left" class="t_border" style="padding-left:10px;" colspan="1"><select name="product_supplier" id="product_supplier'+row_num+'" class="input7" >';
				<?php foreach($view_val2 as $item2){ ?>
					html += "<option value='<?php echo $item2['main_companyname'];?>'><?php echo $item2['main_companyname'];?></option>";
				<?php } ?>
			html += '</select></td>';
			html += '</select></td><td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">하드웨어/소프트웨어</td><td align="left" class="t_border" style="padding-left:10px;" colspan="1">'
			html += '<select name="product_type" id="product_type'+row_num+'" class="input7" onchange="productSearch('+row_num+');" ><option value="">전체</option><option value="hardware">하드웨어</option><option value="software">소프트웨어</option></select></td></tr>';
			html += "<tr class=" + id3 + "><td colspan='9' height='1' bgcolor='#e8e8e8'></td></tr>"
			html += '<tr id='+id5+'><td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">제품명</td><td align="left" class="t_border" style="padding-left:10px;" colspan="1">'
			html += '<select name ="product_name" id="product_name'+row_num+'" class="input7" onclick="productSearch('+row_num+');"><option value="" >제품선택</option></select></td>';
			html += "<td height='40' align='center' bgcolor='f8f8f9' class='t_border' style='font-weight:bold;'>라이선스</td><td align='left' class='t_border' style='padding-left:10px;'><input name='product_licence' type='text' class='input5' id='product_licence"+row_num+"' onkeyup ='commaCheck(this);' /> </td><td height='40' align='center' bgcolor='f8f8f9' class='t_border' style='font-weight:bold;'>Serial</td><td align='left' class='t_border' style='padding-left:10px;'><input name='product_serial' type='text' class='input5' id='product_serial"+row_num+"' onkeyup ='commaCheck(this);' /> </td><td height='40' align='center' bgcolor='f8f8f9' class='t_border' style='font-weight:bold;'>제품 상태</td><td align='left' class='t_border' style='padding-left:10px;'><select name='product_state' id='product_state"+row_num+"' class='input5' ><option value='0'>- 제품 상태 -</option><option value='001'>입고 전</option><option value='002'>창고</option><option value='003'>고객사 출고</option><option value='004'>장애반납</option></select></td><input name='maintain_begin' type='hidden' class='input5' id='maintain_begin' value=' '/><input name='maintain_expire' type='hidden' class='input5' id='maintain_expire' value=' '/><input name='maintain_yn' type='hidden' class='input5' id='maintain_yn' value=' '/><input name='product_version' type='hidden' class='input5' id='product_version' value=' ' /><input name='maintain_target' type='hidden' class='input5' id='maintain_target' value='Y'/><input name='product_check_list' type='hidden' class='input5' id='product_check_list' value='1'/><input name='product_host' type='hidden' class='input5' id='product_host' value=''/><td align='center' colspan='1' ><img src='<?php echo $misc; ?>img/btn_del0.jpg' style='cursor:pointer;' onclick='javascript:product_list_del(" + $("#row_max_index2").val() + ");'/></td></tr>";
			html += "<tr class=" + id3 + "><td colspan='9' height='1' bgcolor='#e8e8e8'></td></tr><tr id=" + id6 + "><td  height='40' align='center' bgcolor='f8f8f9' class='t_border' style='font-weight:bold;'>장비매출가</td><td align='left' class='t_border' style='padding-left:10px;'><input name='product_sales' type='text' class='input5' id='product_sales"+row_num+"' value=0 onclick='numberFormat(this);' onchange='numberFormat(this);product_profit_change(1," + $("#row_max_index2").val() + ");' /></td><td height='40' align='center' bgcolor='f8f8f9' class='t_border' style='font-weight:bold;'>장비매입가</td><td align='left' class='t_border' style='padding-left:10px;'><input name='product_purchase' type='text' class='input5' id='product_purchase"+row_num+"' value=0 onclick='numberFormat(this);' onchange='numberFormat(this);product_profit_change(1," + $("#row_max_index2").val() + ");'/></td><td height='40' align='center' bgcolor='f8f8f9' class='t_border' style='font-weight:bold;'>장비마진</td><td align='left' class='t_border' style='padding-left:10px;'><input name='product_profit' type='text' class='input5' id='product_profit"+row_num+"' value=0 readonly/></td></tr>";
			html += "<tr class=" + id3 + "><td colspan=9 height='2' bgcolor='#797c88'></td></tr>";
			$('#input_point').before(html);
			$("#product_company"+row_num).select2();
			document.documentElement.scrollTop = document.body.scrollHeight; //스크롤 맨밑으로 내려
		});
	});

	function main_list_del(idx,mcompany_seq) {
		if(mcompany_seq){
			$("#delete_main_array").val($("#delete_main_array").val()+","+mcompany_seq)
		}
		$(".main_insert_field_" + idx).remove();
	}

	function product_list_del(idx,product_seq) {
		if(product_seq){
			$("#delete_product_array").val($("#delete_product_array").val()+","+product_seq)
		}
		$(".product_insert_field_" + idx).remove();
		$("#product_insert_field_1_" + idx).remove();
		$("#product_insert_field_2_" + idx).remove();
		$("#product_insert_field_3_" + idx).remove();
		t_forcasting_profit_change();
		// $("#row_max_index2").val(Number(Number($("#row_max_index2").val()) - Number(1)));
	}

	function forcasting_profit_change() {
		var mform = document.cform;
		mform.forcasting_profit.value = mform.forcasting_sales.value.replace(/,/g, "")- mform.forcasting_purchase.value.replace(/,/g, "");
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

	function product_profit_change(mode, idx) {
		var strings = "#product_insert_field_3_" + idx + " td input";
		$(strings).eq(2).val($(strings).eq(0).val().replace(/,/g, "") - $(strings).eq(1).val().replace(/,/g, ""));
		$(strings).eq(2).val($(strings).eq(2).val().replace(/(\d)(?=(?:\d{3})+(?!\d))/g, "$1,"));
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
			obj.value = 0;
		}
		var inputNumber = obj.value.replace(/,/g, "");
		var fomatnputNumber = inputNumber.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, "$1,");
		obj.value= fomatnputNumber;
		
	}

	var chkForm = function() {
		var mform = document.cform;
		var regex = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;

		if("<?php echo $_GET['type'] ;?>" == "1"){ //고객사 정보

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
			
			if (regex.test(mform.customer_email.value) === false) {
				alert("잘못된 이메일 형식입니다.");
				mform.customer_email.focus();
				return false;
			}

		}else if("<?php echo $_GET['type'] ;?>" == "2"){ // 영업 정보
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
				alert("영업담당자 회사명을 입력해 주세요.");
				return false;
			}
			if (mform.cooperation_username.value == "") {
				mform.cooperation_username.focus();
				alert("영업담당자를 입력해 주세요.");
				return false;
			}

			if("<?php echo $view_val['progress_step']; ?>" != mform.progress_step.value){
				if(mform.progress_step.value == "015"){
					$("#create_maintain_table").val("Y");
				}
			}
		}else if("<?php echo $_GET['type'] ;?>" == "3"){ //매출처 정보
			if (mform.sales_companyname.value == "") {
				mform.sales_companyname.focus();
				alert("매출처 회사명을 입력해 주세요.");
				return false;
			}
			if (mform.sales_username.value == "") {
				mform.sales_username.focus();
				alert("매출처 담당자를 입력해 주세요.");
				return false;
			}
			if (mform.sales_tel.value == "") {
				mform.sales_tel.focus();
				alert("매출처 담당자 연락처를 입력해 주세요.");
				return false;
			}
			if (mform.sales_email.value == "") {
				mform.sales_email.focus();
				alert("매출처 담당자 이메일을 입력해 주세요.");
				return false;
			}
			if (regex.test(mform.sales_email.value) === false) {
				alert("잘못된 이메일 형식입니다.");
				mform.sales_email.focus();
				return false;
			}
		}else if("<?php echo $_GET['type'] ;?>" == "4"){ // 매입처 정보
			var objmain_seq = document.getElementsByName("main_seq");
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
					if (regex.test(objmain_email[i].value) === false) {
						alert("잘못된 이메일 형식입니다.");
						objmain_email[i].focus();
						return false;
					}
				}
			}

			$("#update_main_array").val('');
			if (objmain_seq.length > 0) {
				for (i = 0; i < objmain_seq.length; i++) {
					$("#update_main_array").val($("#update_main_array").val() + "||" + objmain_companyname[i].value + "~" + objmain_username[i].value + "~" + objmain_tel[i].value + "~" + objmain_email[i].value + "~" + objmain_seq[i].value );
				}
			}

			$("#insert_main_array").val('');
			if (objmain_companyname.length > objmain_seq.length) {
				for (i = objmain_seq.length; i < objmain_companyname.length; i++) { 
					$("#insert_main_array").val($("#insert_main_array").val() + "||" + objmain_companyname[i].value + "~" + objmain_username[i].value + "~" + objmain_tel[i].value + "~" + objmain_email[i].value );
				}
			}
		}else if("<?php echo $_GET['type'] ;?>" == "5"){// 제품 정보
			var objproduct_seq = document.getElementsByName("product_seq");
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
					if ($.trim(objproduct_name[i].value) == "0" || $.trim(objproduct_name[i].value) == "" ) {
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

			$("#update_product_array").val('');
			if(objproduct_seq.length > 0){
				for (i = 0; i < objproduct_seq.length; i++) {
				$("#update_product_array").val($("#update_product_array").val() + "||" + objproduct_name[i].value + "~" +objproduct_supplier[i].value+ "~" +objproduct_licence[i].value + "~" + objproduct_serial[i].value + "~" + objproduct_state[i].value + "~" + objproduct_product_sales[i].value.replace(/,/g, "") + "~" + objproduct_product_purchase[i].value.replace(/,/g, "")+ "~" + objproduct_product_profit[i].value.replace(/,/g, "") + "~" + objproduct_seq[i].value);
				//alert($("#license_array").val());
				}
			}

			$("#insert_product_array").val('');
			if (objproduct_name.length > objproduct_seq.length) {
				for (i = objproduct_seq.length; i < objproduct_name.length; i++) {
					$("#insert_product_array").val($("#insert_product_array").val() + "||" + objproduct_name[i].value + "~"+objproduct_supplier[i].value + "~" + objproduct_licence[i].value + "~" + objproduct_serial[i].value + "~" + objproduct_state[i].value + "~" + objproduct_product_sales[i].value.replace(/,/g, "") + "~" + objproduct_product_purchase[i].value.replace(/,/g, "") + "~" + objproduct_product_profit[i].value.replace(/,/g, ""));
					//alert($("#license_array").val());
				}
			}
		
		}else if("<?php echo $_GET['type'] ;?>" == "6"){//수주 정보
			if (mform.complete_status.value == "0") {
				mform.complete_status.focus();
				alert("수주여부를 선택해 주세요.");
				return false;
			}
		}
	
		mform.submit();
		return false;
	}

	function chkForm2() {
		var rform = document.rform;

		if (rform.comment.value == "") {
			rform.comment.focus();
			alert("답변을 등록해 주세요.");
			return false;
		}

		rform.action = "<?php echo site_url(); ?>/forcasting/forcasting_comment_action";
		rform.submit();
		return false;
	}

	function chkForm3(seq) {
		if (confirm("정말 삭제하시겠습니까?") == true) {
			var rform = document.rform;
			rform.cseq.value = seq;
			rform.action = "<?php echo site_url(); ?>/forcasting/forcasting_comment_delete";
			rform.submit();
			return false;
		}
	}
</script>

<body>

<table width="90%" height="100%" cellspacing="0" cellpadding="0" style="margin-left:30px;">
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
							<form name="cform" action="<?php echo site_url(); ?>/forcasting/forcasting_input_action" method="post" onSubmit="javascript:chkForm();return false;">
								<input type="hidden" id="update_main_array" name="update_main_array" />
								<input type="hidden" id="insert_main_array" name="insert_main_array" />
								<input type="hidden" id="delete_main_array" name="delete_main_array" />
								<input type="hidden" id="update_product_array" name="update_product_array" />
								<input type="hidden" id="insert_product_array" name="insert_product_array" />
								<input type="hidden" id="delete_product_array" name="delete_product_array" />
								<input type="hidden" name="seq" value="<?php echo $seq; ?>" />
								<?php if(isset($_GET['type'])){
									echo "<input type='hidden' name='data_type' value='{$_GET['type']}' />";
								}?>
								
								<!-- <colgroup>
									<col width="10%" />
									<col width="10%" />
									<col width="10%" />
									<col width="10%" />
									<col width="10%" />
									<col width="10%" />
									<col width="10%" />
									<col width="10%" />
									<col width="10%" />
								</colgroup> -->
								<!-- 고객사정보 -->
								<?php if($_GET['type'] == '1'){ ?> 
								<tr>
									<td height="40" style="font-weight:bold;font-size:13px;">고객사 정보</td>
								</tr>
								<tr>
									<td colspan="9" height="2" bgcolor="#797c88"></td>
								</tr>
								<tr>
									<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">고객사</td>
									<td align="left" class="t_border" style="padding-left:10px;"><input name="customer_companyname" type="text" class="input7" id="customer_companyname" value="<?php echo $view_val['customer_companyname']; ?>" /></td>
								</tr>
								<tr>
									<td colspan="9" height="1" bgcolor="#e8e8e8"></td>
								</tr>
								<tr>
									<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">담당자</td>
									<td align="left" class="t_border" style="padding-left:10px;"><input name="customer_username" type="text" class="input7" id="customer_username" value="<?php echo $view_val['customer_username']; ?>" /></td>
								</tr>
								<tr>
									<td colspan="9" height="1" bgcolor="#e8e8e8"></td>
								</tr>
								<tr>	
									<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">연락처</td>
									<td align="left" class="t_border" style="padding-left:10px;"><input type="text" name="customer_tel" id="customer_tel" class="input7" value="<?php echo $view_val['customer_tel']; ?>" onclick="checkNum(this);" onKeyUp="checkNum(this);"/></td>
								</tr>
								<tr>
									<td colspan="9" height="1" bgcolor="#e8e8e8"></td>
								</tr>
								<tr>		
									<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">이메일</td>
									<td colspan="2" align="left" class="t_border" style="padding-left:10px;"><input type="text" name="customer_email" id="customer_email" class="input7" value="<?php echo $view_val['customer_email']; ?>" /></td>
								</tr>
								<tr>
									<td colspan="9" height="2" bgcolor="#797c88"></td>
								</tr>
								<?php }else if($_GET['type'] == '2'){?>
								<tr>
									<td height="40" width="30%" style="font-weight:bold;font-size:13px;">영업 정보</td>
								</tr>
								<tr>
									<td colspan="9" height="2" bgcolor="#797c88"></td>
								</tr>
								<tr>
									<td height="40" align="center" class="t_border" bgcolor="f8f8f9" style="font-weight:bold;">프로젝트</td>
									<td colspan="3" align="left" class="t_border" style="padding-left:10px;"><input name="project_name" type="text" class="input7" id="project_name" value="<?php echo $view_val['project_name']; ?>" /></td>
								</tr>
								<tr>
									<td colspan="9" height="1" bgcolor="#e8e8e8"></td>
								</tr>
								<tr>	
									<td height="40" align="center" class="t_border" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">판매종류</td>
									<td colspan="3" align="left" class="t_border" style="padding-left:10px;">
										<select name="type" id="type" class="input5" onclick="project_type(this.value);">
											<option value="0" <?php if ($view_val['type'] == "0") {
																	echo "selected";
																} ?>>선택없음</option>
											<option value="1" <?php if ($view_val['type'] == "1") {
																	echo "selected";
																} ?>>판매</option>
											<option value="2" <?php if ($view_val['type'] == "2") {
																	echo "selected";
																} ?>>용역</option>
											<option value="3" <?php if ($view_val['type'] == "3") {
																	echo "selected";
																} ?>>유지보수</option>
											<option value="4" <?php if ($view_val['type'] == "4") {
																	echo "selected";
																} ?>>조달</option>
										</select>
										<div id="procurement" style="<?php if($view_val['type'] != "4"){echo "display:none;"; } ?>">
											조달 판매 금액(VAT포함) : 
											<input type="text" id="procurement_sales_amount" class="input2" name="procurement_sales_amount" value="<?php echo $view_val['procurement_sales_amount']; ?>" oninput="if(this.value != '0'){this.value = this.value.replace(/^0+|\D+/g, '').replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,')}" /> 
										</div>
									</td>
								</tr>
								<tr>
									<td colspan="9" height="1" bgcolor="#e8e8e8"></td>
								</tr>
								<tr>
									<td height="40" align="center" class="t_border" bgcolor="f8f8f9" style="font-weight:bold;">진척단계</td>
									<td colspan="8" align="left" class="t_border" style="padding-left:10px;">
										<input type="hidden" id="create_maintain_table" name="create_maintain_table" value="N" />
										<select name="progress_step" id="progress_step" class="input5">
											<option value="0">-진척단계-</option>
											<option value="001" <?php if ($view_val['progress_step'] == "001") {
																	echo "selected";
																} ?>>영업보류(0%)</option>
											<option value="002" <?php if ($view_val['progress_step'] == "002") {
																	echo "selected";
																} ?>>고객문의(5%)</option>
											<option value="003" <?php if ($view_val['progress_step'] == "003") {
																	echo "selected";
																} ?>>영업방문(10%)</option>
											<option value="004" <?php if ($view_val['progress_step'] == "004") {
																	echo "selected";
																} ?>>일반제안(15%)</option>
											<option value="005" <?php if ($view_val['progress_step'] == "005") {
																	echo "selected";
																} ?>>견적제출(20%)</option>
											<option value="006" <?php if ($view_val['progress_step'] == "006") {
																	echo "selected";
																} ?>>맞춤제안(30%)</option>
											<option value="007" <?php if ($view_val['progress_step'] == "007") {
																	echo "selected";
																} ?>>수정견적(35%)</option>
											<option value="008" <?php if ($view_val['progress_step'] == "008") {
																	echo "selected";
																} ?>>RFI(40%)</option>
											<option value="009" <?php if ($view_val['progress_step'] == "009") {
																	echo "selected";
																} ?>>RFP(45%)</option>
											<option value="010" <?php if ($view_val['progress_step'] == "010") {
																	echo "selected";
																} ?>>BMT(50%)</option>
											<option value="011" <?php if ($view_val['progress_step'] == "011") {
																	echo "selected";
																} ?>>DEMO(55%)</option>
											<option value="012" <?php if ($view_val['progress_step'] == "012") {
																	echo "selected";
																} ?>>가격경쟁(60%)</option>
											<option value="013" <?php if ($view_val['progress_step'] == "013") {
																	echo "selected";
																} ?>>Spen in(70%)</option>
											<option value="014" <?php if ($view_val['progress_step'] == "014") {
																	echo "selected";
																} ?>>수의계약(80%)</option>
											<option value="015" <?php if ($view_val['progress_step'] == "015") {
																	echo "selected";
																} ?>>수주완료(85%)</option>
											<option value="016" disabled <?php if ($view_val['progress_step'] == "016") {
																	echo "selected";
																} ?>>매출발생(90%)</option>
											<option value="017" disabled <?php if ($view_val['progress_step'] == "017") {
																	echo "selected";
																} ?>>미수잔금(95%)</option>
											<option value="018" disabled <?php if ($view_val['progress_step'] == "018") {
																	echo "selected";
																} ?>>수금완료(100%)</option>
										</select></td>
								</tr>
								<tr>
									<td colspan="9" height="1" bgcolor="#e8e8e8"></td>
								</tr>
								<tr>
									<td height="40" align="center" class="t_border" bgcolor="f8f8f9" style="font-weight:bold;">영업업체</td>
									<td align="left" class="t_border" style="padding-left:10px;">
										<select name="cooperation_companyname" id="cooperation_companyname" class="input7">
											<option value="" <?php if ($view_val['cooperation_companyname'] == " ") echo "selected"; ?>>선택하세요</option>
											<option value="두리안정보기술" <?php if ($view_val['cooperation_companyname'] == "두리안정보기술") echo "selected"; ?>>두리안정보기술</option>
											<option value="두리안정보통신기술" <?php if ($view_val['cooperation_companyname'] == "두리안정보통신기술") echo "selected"; ?>>두리안정보통신기술</option>
											<option value="더망고" <?php if ($view_val['cooperation_companyname'] == "더망고") echo "selected"; ?>>더망고</option>
										</select>
									</td>
								</tr>
								<tr>
									<td colspan="9" height="1" bgcolor="#e8e8e8"></td>
								</tr>
								<tr>
									<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">영업담당자</td>
									<td align="left" class="t_border" style="padding-left:10px;"><input name="cooperation_username" type="text" class="input7" id="cooperation_username" value="<?php echo $view_val['cooperation_username']; ?>" /></td>
								</tr>
								<tr>
									<td colspan="9" height="1" bgcolor="#e8e8e8"></td>
								</tr>
								<tr>	
									<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">사업부</td>
									<td align="left" class="t_border" style="padding-left:10px;">
										<select name="dept" id="dept" class="input5">
											<option value="" <?php if ($view_val['dept'] == "") echo "selected" ?>>선택하세요</option>
											<option value="사업1부" <?php if ($view_val['dept'] == "사업1부") echo "selected" ?>>사업1부</option>
											<option value="사업2부" <?php if ($view_val['dept'] == "사업2부") echo "selected" ?>>사업2부</option>
											<option value="ICT" <?php if ($view_val['dept'] == "ICT") echo "selected" ?>>ICT</option>
											<option value="MG" <?php if ($view_val['dept'] == "MG") echo "selected" ?>>MG</option>
											<option value="기술지원부" <?php if ($view_val['dept'] == "기술지원부") echo "selected" ?>>기술지원부</option>
										</select>
									</td>
									<input name="cooperation_tel" type="hidden" class="input5" id="cooperation_tel" value="<?php echo $view_val['cooperation_tel']; ?>" />
									<input name="cooperation_email" type="hidden" class="input5" id="cooperation_email" value="<?php echo $view_val['cooperation_email']; ?>" />
								</tr>
								<tr>
									<td colspan="9" height="2" bgcolor="#797c88"></td>
								</tr>
							<?php }else if($_GET['type'] == '3'){?>
								<tr>
									<td height="40" style="font-weight:bold;font-size:13px;">매출처 정보</td>
								</tr>
								<tr>
									<td colspan="9" height="2" bgcolor="#797c88"></td>
								</tr>
								<tr>
									<td height="70" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">매출처</td>
									<td align="left" class="t_border" style="padding-left:10px;">
										<select id="select_sales_company" class="input2" onchange="selectSalesCompany(this); ">
											<option value=''>매출처 선택</option>
											<?php foreach($sales_customer as $sc){
												echo "<option value='{$sc['seq']}'";
												if( $view_val['sales_companyname'] == $sc['company_name']){
													echo "selected";
												}
												echo ">{$sc['company_name']}</option>";
											}
											?>
										</select><br>
										<input name="sales_companyname" type="text" class="input7" id="sales_companyname" value="<?php echo $view_val['sales_companyname']; ?>" />
									</td>
								</tr>
								<tr>
									<td colspan="9" height="1" bgcolor="#e8e8e8"></td>
								</tr>
								<tr>
									<td height="70" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">담당자</td>
									<td align="left" class="t_border" style="padding-left:10px;">
										<select id="select_sales_user" class="input5">
											<!-- <?php if($view_val['sales_username']== ''){ echo '<option value="" selected>담당자 선택</option>' ; }?>	 -->
											<option value="" >담당자 선택</option>
										</select><br>
										<input name="sales_username" type="text" class="input7" id="sales_username" value="<?php echo $view_val['sales_username']; ?>" />
									</td>
								</tr>
								<tr>
									<td colspan="9" height="1" bgcolor="#e8e8e8"></td>
								</tr>
								<tr>
									<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">연락처</td>
									<td align="left" class="t_border" style="padding-left:10px;"><input name="sales_tel" type="text" class="input7" id="sales_tel" value="<?php echo $view_val['sales_tel']; ?>" onclick="checkNum(this);" onKeyUp="checkNum(this);" /></td>
								</tr>
								<tr>
									<td colspan="9" height="1" bgcolor="#e8e8e8"></td>
								</tr>
								<tr>	
									<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">이메일</td>
									<td colspan="2" align="left" class="t_border" style="padding-left:10px;"><input name="sales_email" type="text" class="input7" id="sales_email" value="<?php echo $view_val['sales_email']; ?>" /></td>
								</tr>
								<tr>
									<td colspan="9" height="2" bgcolor="#797c88"></td>
								</tr>
							<?php }else if($_GET['type'] == '4'){ ?>
								<?php
								$i = 0;
								foreach ($view_val2 as $item2) {
									if ($i == 0) {
								?>
										<tr>
											<td height="40" colspan="8" style="font-weight:bold;font-size:13px;">
												매입처 정보
											</td>
											<td align="right">
												<img src="<?php echo $misc; ?>img/btn_add.jpg" id="main_add" name="main_add" style="cursor:pointer;" />
											</td>
										</tr>
										<tr>
											<td colspan="9" height="2" bgcolor="#797c88"></td>
										</tr>
										<tr id="main_insert_field_2_<?php echo $i; ?>">
											<td height="70" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">매입처</td>
											<td colspan=3 align="left" class="t_border" style="padding-left:10px;">
												<select id="select_main_company" class="input2" onchange="selectMainCompany(); ">
													<option value=''>매입처 선택</option>
													<?php foreach($sales_customer as $sc){
															echo "<option value='{$sc['seq']}'";
															if( $item2['main_companyname'] == $sc['company_name']){
																echo "selected";
															}
															echo ">{$sc['company_name']}</option>";
														}
													?>
												</select><br>
												<input name="main_companyname" type="text" class="input2" id="main_companyname" value="<?php echo $item2['main_companyname']; ?>" />
												<input name="main_seq" type="hidden" class="input5" id="main_seq" value="<?php echo $item2['seq']; ?>" />
											</td>
											<td height="70" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">담당자</td>
											<td colspan="3" align="left" class="t_border" style="padding-left:10px;">
												<select id="select_main_user" class="input2" onchange="selectMainUser();">
													<option value=''>담당자 선택</option>
												</select><br>
												<input name="main_username" type="text" class="input2" id="main_username" value="<?php echo $item2['main_username']; ?>" />
											</td>
										</tr>
										<tr>
											<td colspan="9" height="1" bgcolor="#e8e8e8"></td>
										</tr>
										<tr>
											<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">연락처</td>
											<td colspan=3 align="left" class="t_border" style="padding-left:10px;">
												<input name="main_tel" type="text" class="input2" id="main_tel" value="<?php echo $item2['main_tel']; ?>" onclick="checkNum(this);" onKeyUp="checkNum(this);"/>
											</td>
											<td height="40" align="center" width="80" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">이메일</td>
											<td colspan=3 align="left" class="t_border" style="padding-left:10px;">
												<input name="main_email" type="text" class="input2" id="main_email" value="<?php echo $item2['main_email']; ?>" />
											</td>
										</tr>
										<tr>
											<td colspan="9" height="2" bgcolor="#797c88"></td>
										</tr>
									<?php
									} else {
									?>
										<!-- <tr class="main_insert_field_<?php echo $i; ?>">
											<td></td>
										</tr> -->
										<tr class="main_insert_field_<?php echo $i; ?>">
											<td height="70" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">매입처</td>
											<td colspan=3 align="left" class="t_border" style="padding-left:10px;">
												<select id="select_main_company<?php echo $i;?>" class="input2" onchange="selectMainCompany(<?php echo $i;?>); ">
													<option value=''>매입처 선택</option>
													<?php foreach($sales_customer as $sc){
															echo "<option value='{$sc['seq']}'";
															if( $item2['main_companyname'] == $sc['company_name']){
																echo "selected";
															}
															echo ">{$sc['company_name']}</option>";
														}
													?>
												</select><br>
												<input name="main_companyname" type="text" class="input2" id="main_companyname<?php echo $i;?>" value="<?php echo $item2['main_companyname']; ?>" />
												<input name="main_seq" type="hidden" class="input7" id="main_seq" value="<?php echo $item2['seq']; ?>" />
											</td>
											<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">담당자</td>
											<td colspan=3 align="left" class="t_border" style="padding-left:10px;">
												<select id="select_main_user<?php echo $i;?>" class="input2" onchange="selectMainUser(<?php echo $i; ?>);">
													<option value=''>담당자 선택</option>
												</select><br>
												<input name="main_username" type="text" class="input2" id="main_username<?php echo $i;?>" value="<?php echo $item2['main_username']; ?>" />
											</td>
											<td>

											</td>
										</tr>
										<tr class="main_insert_field_<?php echo $i; ?>">
											<td colspan="9" height="1" bgcolor="#e8e8e8"></td>
										</tr>
										<tr class="main_insert_field_<?php echo $i; ?>">
											<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">연락처</td>
											<td colspan=3 align="left" class="t_border" style="padding-left:10px;"><input name="main_tel" type="text" class="input2" id="main_tel<?php echo $i;?>" value="<?php echo $item2['main_tel']; ?>" onclick="checkNum(this);" onKeyUp="checkNum(this);"/></td>	
											<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">이메일</td>
											<td colspan=3 align="left" class="t_border" style="padding-left:10px;"><input name="main_email" type="text" class="input2" id="main_email<?php echo $i;?>" value="<?php echo $item2['main_email']; ?>" /></td>
											<td align="right"><img src="<?php echo $misc; ?>img/btn_del0.jpg" onclick='javascript:main_list_del(<?php echo $i; ?>,<?php echo $item2["seq"]; ?>);' style="cursor:pointer;" /></td>
										</tr>
										<tr class="main_insert_field_<?php echo $i; ?>">
											<td colspan="9" height="2" bgcolor="#797c88"></td>
										</tr>
								<?php
									}
									$max_number = $i;
									$i++;
								}
								?>
								<tr id="main_insert">
									<td>
										<input type="hidden" id="row_max_index" name="row_max_index" value="<?php echo $max_number; ?>" />
									</td>
								</tr>
							<?php }else if($_GET['type'] == '5'){ ?>
								<?php
								$j = 1;
								$i = 0;
								foreach ($view_val3 as $item3) {
									if ($j == 1) {
								?>
										<tr>
											<td height="40" colspan="8" style="font-weight:bold;font-size:13px;">제품 정보</td>				
										</tr>
										<tr>
											<td colspan=9 height="40" align="left" style="padding:30px 0px 30px 0px;">
												<div style="background-color:#f8f8f9;padding:10px 0px 10px 10px;">
													<span style="font-weight:bold;">* 일괄적용</span> <br>
													<table>
														<tr>
															<td>제조사</td>
															<td>
																<select id="check_product_company" class="input7" onchange="productSearch('check');">
																	<option value="" >제조사</option>
																	<?php foreach($product_company as $pc){
																		echo "<option value='{$pc['product_company']}'>{$pc['product_company']}</option>";
																	}?>
																</select>
															</td>
															<td><input type="button" class="input7" value="선택적용" onclick="collectiveApplication('product_company',2);" style="margin-right:30px;" /></td>
															<td>매입처</td>
															<td>
																<select id="check_product_supplier" class="input7">
																<?php foreach($view_val2 as $item2){
																	echo "<option value='{$item2['main_companyname']}'";
																	if($item3['product_supplier'] == $item2['main_companyname']){
																		echo "selected";
																	}
																	echo ">{$item2['main_companyname']}</option>";
																}?>
																</select>
															</td>
															<td><input type="button" class="input7" value="선택적용" onclick="collectiveApplication('product_supplier',1);" style="margin-right:30px;" /></td>
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
															<td><input type="button" class="input7" value="선택적용" onclick="collectiveApplication('product_state',1);" style="margin-right:30px;" /></td>

														</tr>
														<tr>
															<td>제품명</td>
															<td>
																<select id="check_product_name" class="input7" onclick="productSearch('check');">
																	<option value="" selected>제조사를 선택해주세요</option>
																</select>
															</td>
															<td><input type="button" class="input7" value="선택적용" onclick="collectiveApplication('product_name',2);" style="margin-right:30px;" /></td>
															<td>장비매출가</td>
															<td><input type="text" class="input7" id="check_product_sales" value=0 onclick="numberFormat(this);" onchange="numberFormat(this);" /></td>
															<td><input type="button" class="input7" value="선택적용" onclick="collectiveApplication('product_sales',0);" style="margin-right:30px;" /></td>
															<td>장비매입가</td>
															<td><input type="text" class="input7" id="check_product_purchase" value=0 onclick="numberFormat(this);" onchange="numberFormat(this);" /></td>
															<td><input type="button" class="input7" value="선택적용" onclick="collectiveApplication('product_purchase',0);" style="margin-right:30px;" /></td>
														</tr>
													</table>
												</div>
											</td>
										</tr>
										<tr>
											<td align="center"><input type="checkbox" id="allCheck" /></td>
											<td colspan=8 align="right"><img src="<?php echo $misc; ?>img/btn_add.jpg" id="product_add" name="product_add" style="cursor:pointer;" /></td>
										</tr>
										<!--시작라인-->
										<tr class="product_insert_field_<?php echo $j; ?>">
											<td colspan="9" height="2" bgcolor="#797c88"></td>
										</tr>
										<tr id="product_insert_field_1_<?php echo $j; ?>" >
											<td height="40" align="center" class="t_border" bgcolor="f8f8f9" style="font-weight:bold;"><input type="checkbox" name="product_row" value="0" /><br>제조사</td>
											<td align="left" class="t_border" style="padding-left:10px;" colspan="1">
												<select name="product_company" id="product_company" class="input7" onchange="product_type_default();productSearch();">
													<option value="" >제조사</option>
													<?php foreach($product_company as $pc){
														echo "<option value='{$pc['product_company']}'";
														if($item3['product_company'] == $pc['product_company'] ){
															echo "selected";
														}
														echo ">{$pc['product_company']}</option>";
													}?>
												</select>
											</td>
											<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">매입처</td>
											<td colspan=3 align="left" class="t_border" style="padding-left:10px;" colspan="1">
												<select name="product_supplier" id="product_supplier" class="input7">
												<?php foreach($view_val2 as $item2){
													echo "<option value='{$item2['main_companyname']}'";
													if($item3['product_supplier'] == $item2['main_companyname']){
														echo "selected";
													}
													echo ">{$item2['main_companyname']}</option>";
												}?>
												</select>
											</td>
											<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">하드웨어/소프트웨어</td>
											<td colspan=4 align="left" class="t_border" style="padding-left:10px;" colspan="1">
												<select name="product_type" id="product_type" class="input7" onchange="productSearch();">
													<option value="" selected >전체</option>
													<option value="hardware" <?php if($item3['product_type'] == "hardware"){echo "selected"; }?> >하드웨어</option>
													<option value="software" <?php if($item3['product_type'] == "software"){echo "selected"; }?> >소프트웨어</option>
												</select>
											</td>
										</tr>
										<tr class="product_insert_field_1_<?php echo $j; ?>">
											<td colspan="9" height="1" bgcolor="#e8e8e8"></td>
										</tr>
										<tr id="product_insert_field_2_<?php echo $j; ?>">
											<td height="40" align="center" class="t_border" bgcolor="f8f8f9" style="font-weight:bold;">제품명</td>
											<td align="left" class="t_border" style="padding-left:10px;" colspan="1">
												<input type="hidden" name ="product_seq" id="product_seq" value="<?php echo $item3['seq']; ?>" />
												<select name ="product_name" id="product_name" class="input7" onclick="productSearch();">
													<option value="<?php echo $item3['product_code'] ;?>" selected><?php echo $item3['product_name'] ;?></option>
												</select>
											</td>
											<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">라이선스</td>
											<td align="left" class="t_border" style="padding-left:10px;"><input name="product_licence" type="text" class="input5" id="product_licence" value="<?php echo $item3['product_licence']; ?>" onkeyup ="commaCheck(this);" /> </td>
											<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">Serial</td>
											<td align="left" class="t_border" style="padding-left:10px;"><input name="product_serial" type="text" class="input5" id="product_serial" value="<?php echo $item3['product_serial']; ?>" onkeyup ="commaCheck(this);" /> </td>
											<input name="maintain_begin" type="hidden" class="input5" id="maintain_begin" value="<?php echo $item3['maintain_begin']; ?>" />
											<input name="maintain_expire" type="hidden" class="input5" id="maintain_expire" value="<?php echo $item3['maintain_expire']; ?>" />
											<input name="maintain_yn" type="hidden" class="input5" id="maintain_yn" value="<?php echo $item3['maintain_yn']; ?>" />
											<input name="product_version" type="hidden" class="input5" id="product_version" value="<?php echo $item3['product_version']; ?>" />
											<input name="maintain_target" type="hidden" class="input5" id="maintain_target" value="<?php echo $item3['maintain_target']; ?>" />
											<input name="product_check_list" type="hidden" class="input5" id="product_check_list" value="<?php echo $item3['product_check_list']; ?>" />
											<input name="product_host" type="hidden" class="input5" id="product_host" value="<?php echo $item3['product_host']; ?>" />

											<!-- <td align="left"  colspan="1" ><img src="<?php echo $misc; ?>img/btn_add.jpg" id="product_add" name="product_add" style="cursor:pointer;"/></td> -->

											<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">제품 상태</td>
											<!-- <td align="left" class="t_border" style="padding-left:10px;"><input name="product_count" type="text" class="input5" id="product_count" onclick="checkNum(this);" onKeyUp="checkNum(this);"/> </td> -->
											<td align="left" class="t_border" style="padding-left:10px;">
												<select name="product_state" id="product_state" class="input5">
													<option value="0">- 제품 상태 -</option>
													<option value="001" <?php if ($item3['product_state'] == "001") {
																			echo "selected";
																		} ?>>입고 전</option>
													<option value="002" <?php if ($item3['product_state'] == "002") {
																			echo "selected";
																		} ?>>창고</option>
													<option value="003" <?php if ($item3['product_state'] == "003") {
																			echo "selected";
																		} ?>>고객사 출고</option>
													<option value="004" <?php if ($item3['product_state'] == "004") {
																			echo "selected";
																		} ?>>장애반납</option>
												</select>
											</td>
										</tr>
										<tr class="product_insert_field_1_<?php echo $j; ?>">
											<td colspan="9" height="1" bgcolor="#e8e8e8"></td>
										</tr>
										<tr id="product_insert_field_3_<?php echo $j; ?>">
											<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">장비매출가</td>
											<td align="left" class="t_border" style="padding-left:10px;"><input name="product_sales" type="text" class="input5" id="product_sales" value="<?php if(trim($item3['product_sales']) == ""){echo $item3['product_sales'];}else{echo number_format($item3['product_sales']);} ?>" onclick="numberFormat(this);" onchange="numberFormat(this);product_profit_change(1,<?php echo $j; ?>);" /> </td>
											<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">장비매입가</td>
											<td align="left" class="t_border" style="padding-left:10px;"><input name="product_purchase" type="text" class="input5" id="product_purchase" value="<?php if(trim($item3['product_purchase']) == ""){echo $item3['product_purchase'];}else{echo number_format($item3['product_purchase']);} ?>" onclick="numberFormat(this);" onchange="numberFormat(this);product_profit_change(1,<?php echo $j; ?>);" /> </td>
											<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">장비마진</td>
											<td colspan=4 align="left" class="t_border" style="padding-left:10px;"><input name="product_profit" type="text" class="input5" id="product_profit" value="<?php if(trim($item3['product_profit']) == ""){echo $item3['product_profit'];}else{echo number_format($item3['product_profit']);}?>" readonly /></td>
										</tr>
									<?php
									} 
									else {
									?>
										<tr class="product_insert_field_<?php echo $j; ?>">
											<td colspan="9" height="2" bgcolor="#797c88"></td>
										</tr>
										<tr id="product_insert_field_1_<?php echo $j; ?>">
											<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;"><input type="checkbox" name="product_row" value="<?php echo $i; ?>" /><br>제조사</td>
											<td align="left" class="t_border" style="padding-left:10px;" colspan="1">
												<select name="product_company" id="product_company<?php echo $i; ?>" class="input7" onchange="product_type_default(<?php echo $i; ?>);productSearch(<?php echo $i; ?>);">
													<option value="">제조사</option>
													<?php foreach($product_company as $pc){
														echo "<option value='{$pc['product_company']}'";
														if($item3['product_company'] == $pc['product_company'] ){
															echo "selected";
														}
														echo ">{$pc['product_company']}</option>";
													}?>
												</select>
												<?php echo "<script>$('#product_company{$i}').select2();</script>";?>
											</td>
											<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">매입처</td>
											<td colspan=3 align="left" class="t_border" style="padding-left:10px;" colspan="1">
												<select name="product_supplier" id="product_supplier<?php echo $i; ?>" class="input7" >
												<?php foreach($view_val2 as $item2){
													echo "<option value='{$item2['main_companyname']}'";
													if($item3['product_supplier'] == $item2['main_companyname']){
														echo "selected";
													}
													echo ">{$item2['main_companyname']}</option>";
												}?>
												</select>
											</td>
											<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">하드웨어/소프트웨어</td>
											<td colspan=4 align="left" class="t_border" style="padding-left:10px;" colspan="1">
												<select name="product_type" id="product_type<?php echo $i; ?>" class="input7" onchange="productSearch(<?php echo $i; ?>);">
													<option value="" selected >전체</option>
													<option value="hardware" <?php if($item3['product_type'] == "hardware"){echo "selected"; }?> >하드웨어</option>
													<option value="software" <?php if($item3['product_type'] == "software"){echo "selected"; }?> >소프트웨어</option>
												</select>
											</td>
										</tr>
										<tr class="product_insert_field_<?php echo $j; ?>">
											<td colspan="9" height="1" bgcolor="#e8e8e8"></td>
										</tr>
										<tr id="product_insert_field_2_<?php echo $j; ?>">
											<input type="hidden" name ="product_seq" id="product_seq<?php echo $i; ?>" value="<?php echo $item3['seq']; ?>" />
											<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">제품명</td>
											<td align="left" class="t_border" style="padding-left:10px;" colspan="1">
												<select name ="product_name" id="product_name<?php echo $i; ?>" class="input7" onclick="productSearch(<?php echo $i; ?>);">
													<option value="<?php echo $item3['product_code'] ;?>" selected><?php echo $item3['product_name'] ;?></option>
												</select>
											</td>
											<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">라이선스</td>
											<td align="left" class="t_border" style="padding-left:10px;"><input name="product_licence" type="text" class="input5" id="product_licence<?php echo $i; ?>" value="<?php echo $item3['product_licence']; ?>" onkeyup ="commaCheck(this);"  /> </td>
											<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">Serial</td>
											<td align="left" class="t_border" style="padding-left:10px;"><input name="product_serial" type="text" class="input5" id="product_serial<?php echo $i; ?>" value="<?php echo $item3['product_serial'];  ?>" onkeyup ="commaCheck(this);" /> </td>
											<input name="maintain_begin" type="hidden" class="input5" id="maintain_begin" value="<?php echo $item3['maintain_begin']; ?>" />
											<input name="maintain_expire" type="hidden" class="input5" id="maintain_expire" value="<?php echo $item3['maintain_expire']; ?>" />
											<input name="maintain_yn" type="hidden" class="input5" id="maintain_yn" value="<?php echo $item3['maintain_yn']; ?>" />
											<input name="product_version" type="hidden" class="input5" id="product_version" value="<?php echo $item3['product_version']; ?>" />
											<input name="maintain_target" type="hidden" class="input5" id="maintain_target" value="<?php echo $item3['maintain_target']; ?>" />
											<input name="product_check_list" type="hidden" class="input5" id="product_check_list" value="<?php echo $item3['product_check_list']; ?>" />
											<input name="product_host" type="hidden" class="input5" id="product_host" value="<?php echo $item3['product_host']; ?>" />
											
											<!-- <td align="left"  colspan="1" ><img src="<?php echo $misc; ?>img/btn_add.jpg" id="product_add" name="product_add" style="cursor:pointer;"/></td> -->

											<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">제품 상태</td>
											<!-- <td align="left" class="t_border" style="padding-left:10px;"><input name="product_count" type="text" class="input5" id="product_count" onclick="checkNum(this);" onKeyUp="checkNum(this);"/> </td> -->
											<td align="left" class="t_border" style="padding-left:10px;">
												<select name="product_state" id="product_state<?php echo $i;?>" class="input5" >
													<option value="0">- 제품 상태 -</option>
													<option value="001" <?php if ($item3['product_state'] == "001") {
																			echo "selected";
																		} ?>>입고 전</option>
													<option value="002" <?php if ($item3['product_state'] == "002") {
																			echo "selected";
																		} ?>>창고</option>
													<option value="003" <?php if ($item3['product_state'] == "003") {
																			echo "selected";
																		} ?>>고객사 출고</option>
													<option value="004" <?php if ($item3['product_state'] == "004") {
																			echo "selected";
																		} ?>>장애반납</option>
												</select></td>


											<td align="center" colspan="1"><img src="<?php echo $misc; ?>img/btn_del0.jpg" onclick='javascript:product_list_del(<?php echo $j; ?>,<?php echo $item3["seq"]; ?>);' style="cursor:pointer;" /></td>
										</tr>
										<tr class="product_insert_field_<?php echo $j; ?>">
											<td colspan="9" height="1" bgcolor="#e8e8e8"></td>
										</tr>
										<tr id="product_insert_field_3_<?php echo $j; ?>">
											<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">장비매출가</td>
											<td align="left" class="t_border" style="padding-left:10px;">
												<input name="product_sales" type="text" class="input5" id="product_sales<?php echo $i; ?>" value="<?php if(trim($item3['product_sales']) == ""){echo $item3['product_sales'];}else{echo number_format($item3['product_sales']);} ?>" onclick="numberFormat(this);" onchange="numberFormat(this);product_profit_change(1,<?php echo $j; ?>);" />
											</td>
											<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">장비매입가</td>
											<td align="left" class="t_border" style="padding-left:10px;">
												<input name="product_purchase" type="text" class="input5" id="product_purchase<?php echo $i; ?>" value="<?php if(trim($item3['product_purchase']) == ""){echo $item3['product_purchase'];}else{echo number_format($item3['product_purchase']);} ?>" onclick="numberFormat(this);" onchange="numberFormat(this);product_profit_change(1,<?php echo $j; ?>);" />
											</td>
											<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">장비마진</td>
											<td colspan=4 align="left" class="t_border" style="padding-left:10px;">
												<input name="product_profit" type="text" class="input5" id="product_profit<?php echo $i; ?>" value="<?php if(trim($item3['product_profit']) == ""){echo $item3['product_profit'];}else{echo number_format($item3['product_profit']);} ?>" readonly />
											</td>
										</tr>
								<?php
									}
									$max_number2 = $j;
									$j++;
									$i++;
								}
								?>
								
								<input type="hidden" id="row_max_index2" name="row_max_index2" value="<?php echo $max_number2; ?>" />
								<tr id="product_insert_field_<?php echo $j; ?>">
									<td colspan="9" height="2" bgcolor="#797c88"></td>
								</tr>
								<tr id="input_point">
									<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">고객사총매출가</td>
									<td align="left" class="t_border" style="padding-left:10px;"><input name="forcasting_sales" type="text" class="input5" id="forcasting_sales" value="<?php echo number_format($view_val['forcasting_sales']); ?>" onchange="forcasting_profit_change();" readonly /> </td>
									<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">고객사총매입가</td>
									<td align="left" class="t_border" style="padding-left:10px;"><input name="forcasting_purchase" type="text" class="input5" id="forcasting_purchase" value="<?php echo number_format($view_val['forcasting_purchase']); ?>" onchange="forcasting_profit_change();" readonly /> </td>
									<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">고객사총마진</td>
									<td align="left" class="t_border" style="padding-left:10px;"><input name="forcasting_profit" type="text" class="input5" id="forcasting_profit" value="<?php echo number_format($view_val['forcasting_profit']); ?>" readonly /> </td>
									<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">분할월수</td>
									<td colspan="3" align="left" class="t_border" style="padding-left:10px;"><select name="division_month" id="division_month" class="input5" onchange="monthDivision()">
											<option value="12" <?php if ($view_val['division_month'] == "12") {
																	echo "selected";
																} ?>>당월</option>
											<option value="6" <?php if ($view_val['division_month'] == "6") {
																	echo "selected";
																} ?>>반기별</option>
											<option value="3" <?php if ($view_val['division_month'] == "3") {
																	echo "selected";
																} ?>>분기별</option>
											<option value="month" <?php
																	if ($view_val['division_month'] == "1" || substr($view_val['division_month'], 0, 1) === "m") {
																		echo "selected";
																	} ?>>월별</option>
											<input type="text" name="monthly_input" value = "<?php echo substr($view_val['division_month'],1)  ?>" id="monthlyInput" onchange="month()"></input>
											<div id="month" style="float:right">개월<div>
									</td>
								</tr>
								<tr>
									<td colspan="9" height="1" bgcolor="#e8e8e8"></td>
								</tr>
								<tr>
									<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">최초 매출일</td>
									<td align="left" class="t_border" style="padding-left:10px;"><input name="first_saledate" type="date" class="input7" id="first_saledate" value="<?php echo $view_val['first_saledate']; ?>" /></td>
									<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">예상 매출일</td>
									<td align="left" class="t_border" style="padding-left:10px;"><input name="exception_saledate" type="date" class="input7" id="exception_saledate" value="<?php echo $view_val['exception_saledate']; ?>" /></td>
									<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">월별마진</td>
									<td align="left" class="t_border" style="padding-left:10px;">
										<input name="montly_profit" type="text" class="input5" id="montly_profit" value="<?php if (substr($view_val['division_month'], 0, 1) === "m") {
											echo $view_val['forcasting_profit'] / substr($view_val['division_month'], 1);
										} else {
											echo $view_val['forcasting_profit'] / (12 / $view_val['division_month']);
										} ?>" readonly />
									</td>
									<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">해당월</td>
									<td colspan="3" align="left" class="t_border" style="padding-left:10px;"><select name="montly_f_p" id="montly_f_p" class="input5">
										<?php
										$montly_f_p = explode('-', $view_val['exception_saledate']);

										if (substr($view_val['division_month'], 0, 1) === "m") {
											for ($i = 0; $i < substr($view_val['division_month'], 1); $i++) {
												$montly_tmp = ($montly_f_p[1] + 1 * $i) % 12;

												if ($montly_tmp == 0) {
													$montly_tmp = 12;
												}
												$plusYear = $montly_f_p[0] + (int) (($montly_f_p[1] + $i) / 13);
												echo '<option selected>' . $plusYear . '_' . (sprintf('%02d', $montly_tmp)) . '</option>';
											};
										} else {
											for ($i = 0; $i < 12 / $view_val['division_month']; $i++) {
												$montly_tmp = ($montly_f_p[1] + ($view_val['division_month']) * $i) % 12;
												if ($montly_tmp == 0) {
													$montly_tmp = 12;
												}
										?>
											<option selected><?php echo $montly_f_p[0] + (int) (($montly_f_p[1] + $i) / 13) . "-" . (sprintf('%02d', $montly_tmp)); ?></option>

										<?php }
										} ?>
								</tr>
								<tr id="product_insert_field_<?php echo $j; ?>">
									<td colspan="9" height="2" bgcolor="#797c88"></td>
								</tr>
				<?php }else{ ?>
				<tr>
					<td colspan="9"style="font-weight:bold;font-size:13px;">수주 정보</td>
				</tr>
				<!--시작라인-->
				<tr>
					<td colspan="9" height="2" bgcolor="#797c88"></td>
				</tr>
				<tr>
					<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">수주여부</td>
					<td colspan=8 align="left" class="t_border" style="padding-left:10px;">
						<select name="complete_status" id="complete_status" class="input5">
							<option value="0">-수주여부-</option>
							<option value="001" <?php if ($view_val['complete_status'] == "001") {
													echo "selected";
												} ?>>수주중</option>
							<option value="002" <?php if ($view_val['complete_status'] == "002") {
													echo "selected";
												} ?>>수주완료</option>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="9" height="1" bgcolor="#e8e8e8"></td>
				</tr>
				<?php } ?>
				</form>
			</table>
		</td>
		<td height="10"></td>
	</tr>
	<!--버튼-->
	<tr>
		<td align="right">
			<!-- <img src="<?php echo $misc; ?>img/btn_list.jpg" width="64" height="31" style="cursor:pointer" onClick="javascript:history.go(-1)" /> -->
			<input type="image" src="<?php echo $misc; ?>img/btn_adjust.jpg" width="64" height="31" style="cursor:pointer" onclick="javascript:chkForm();return false;" />
			<!-- <img src="<?php echo $misc; ?>img/btn_delete.jpg" width="64" height="31" style="cursor:pointer" border="0" onclick="javascript:chkDel();return false;" /></td> -->
	</tr>
</table>
<script>
	//select box 검색 기능
	$("#check_product_company").select2();
	$("#product_company").select2();
	$("#select_sales_company").select2();
	$("#select_main_company").select2();

	if ($("#division_month").val() == "month") {
		$("#monthlyInput").show();
		$("#month").show();
		$("#monthlyInput").val(<?php echo substr($view_val['division_month'], 1) ?>)
		var monthlyInputValue = $("#monthlyInput").val();
		var divisionMonthValue = $("#division_month").val();
		$("#division_month option:eq(3)").val("m" + monthlyInputValue);
	} else {
		$("#monthlyInput").hide();
		$("#month").hide();
		$("#monthlyInput").val('');
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


	//매출처 불러오기 선택하면 담당자 불러옴
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

				$("#select_sales_user").change(function(){
					$("#sales_username").val($("#select_sales_user option:selected").text());
					for (i = 0; i < data.length; i++) {
						if ($("#select_sales_user").val() == data[i].seq) {
							$("#sales_tel").val(data[i].user_tel);
							$("#sales_email").val(data[i].user_email);
						}
					}
				})
			}
		});
	}

	//매입처 불러오기 선택하면 담당자 불러옴
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
					html += "<option value=" + data[i].seq + ">" + data[i].user_name + "</option>";
				}

				if (idx == undefined) {
					$("#select_main_user").html(html);
				}else{
					$("#select_main_user"+idx).html(html);
				}
			}
		});
	}

	//처음 로드할때 매출처에 맞게 담당자 select option 가져오기
	if ($("#select_sales_company").val() != '') {
		var seq = $("#select_sales_company").val();
		$.ajax({
			type: "POST",
			cache: false,
			url: "<?php echo site_url(); ?>/ajax/sales_customer_staff",
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
				$("#select_sales_user option").filter(function () {
					return this.text == "<?php echo $view_val['sales_username']?>";
				}).attr('selected', true);

				$("#select_sales_user").change(function () {
					$("#sales_username").val($("#select_sales_user option:selected").text());
					for (i = 0; i < data.length; i++) {
						if ($("#select_sales_user").val() == data[i].seq) {
							$("#sales_tel").val(data[i].user_tel);
							$("#sales_email").val(data[i].user_email);
						}
					}
				})
			}
		});
	}
	
	//처음 로드할때 매입처에 맞게 담당자 select option 가져오기
	var row = 0;
	<?php foreach($view_val2 as $item2){ ?>
		if (row == 0) {
			var idx = '';
		} else {
			var idx = row;
		}
		$("#select_main_company" + idx).select2();

		if ($("#select_main_company" + idx).val() != '') {
			var seq = $("#select_main_company" + idx).val();
			$.ajax({
				type: "POST",
				cache: false,
				url: "<?php echo site_url(); ?>/ajax/sales_customer_staff",
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
					$("#select_main_user" + idx).html(html);
					$("#select_main_user" + idx + " option").filter(function () {
						return this.text == "<?php echo $item2['main_username']?>";
					}).attr('selected', true);
				}
			});
		}
		row++;
	<?php } ?>

	//담당자 선택할 때
	function selectMainUser(idx){
		if(idx == undefined){
			idx = '';
		}else{
			idx = idx;
		}
		var seq = $("#select_main_company"+idx).val();
		$.ajax({
			type: "POST",
			cache: false,
			url: "<?php echo site_url(); ?>/ajax/sales_customer_staff",
			dataType: "json",
			async: false,
			data: {
				seq: seq
			},
			success: function (data) {
				$("#main_username"+idx).val($("#select_main_user"+idx+" option:selected").text());
				for (i = 0; i < data.length; i++) {
					if ($("#select_main_user"+idx).val() == data[i].seq) {
						$("#main_tel"+idx).val(data[i].user_tel);
						$("#main_email"+idx).val(data[i].user_email);
					}
				}
			}
		});
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
			if (idx == undefined) {
				idx = '';
			}
			var productCompany = $("#product_company" + idx).val();
			var productType = $("#product_type" + idx).val();
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
					$("#product_name" + idx).html(html);
					$("#product_name" + idx).select2();
				}
			});
		}
	}

	function completeStatusCommentAdd(){
		var num;
		if($("#complete_status_comment>table:last").length == 0){
			num = 1;
		}else{
			num = Number($("#complete_status_comment>table:last").attr('id').replace('completeStatusCommentAdd',''))+1;
		}
		
		var html = '<table id="completeStatusCommentAdd'+num+'" width="100%" border="0" cellspacing="0" cellpadding="5"><tr bgcolor="f8f8f9">';
		html += '<td width="8%" class="answer"><?php echo $name; ?></td>';
		html += '<td colspan="2" width="20%" align="right"><input type="image" src="<?php echo $misc; ?>img/btn_answer2.jpg" width="50" height="18" style="cursor:pointer" onclick="ajaxFileUpload('+num+');" /></td></tr>'
		html += '<tr><td width="10%"><select id="comment_status" class="input5">';
		html += '<option value="0" selected>-수주여부-</option><option value="001">수주중</option><option value="002">수주완료</option></select>';
		html += '<td width="80%"><input type="text" id="comment_contents" value="" style="width:95%;"/></td>';
		html += '<td width="10%"><form id="ajaxFrom" method="post" enctype="multipart/form-data"><input type="file" id="ajaxFile" />(용량제한 100MB)</form></td>'
		html += '</tr></table>'
		$("#complete_status_comment").html($("#complete_status_comment").html()+html)
	}

	function completeStatusCommentDel(seq){
		if (confirm("코멘트를 삭제하시겠습니까?") == true) {
			$.ajax({
				type: "POST",
				cache: false,
				url: "<?php echo site_url();?>/ajax/forcasting_complete_status_comment_delete",
				dataType: "json",
				async: false,
				data: {
					seq: seq
				},
				success: function (data) {
					if(data.result == "true"){
						alert("수주여부 코멘트 삭제 되었습니다.");
					}else{
						alert("수주여부 코멘트 삭제 실패하였습니다.");
					}
					location.reload();
				}
			});
		}
	}

	//수주 여부 코멘트 등록 
	function ajaxFileUpload(num) {
		var status = $("#completeStatusCommentAdd"+num).find("#comment_status option:selected").val();//수주 상태
		var contents = $("#completeStatusCommentAdd"+num).find("#comment_contents").val();//코멘트 내용

		if(jQuery("#ajaxFile")[0].files[0] == undefined){ //첨부파일 없성
			$.ajax({
				type: "POST",
				cache: false,
				url: "<?php echo site_url();?>/ajax/forcasting_complete_status_comment_insert",
				dataType: "json",
				async: false,
				data: {
					seq: <?php echo $seq ;?>,
					status: status,
					contents:contents,
					file_real_name:'',
					file_change_name:''
				},
				success: function (data) {
					if(data.result == "true"){
						alert("수주여부 코멘트 등록 되었습니다.");
					}else{
						alert("수주여부 코멘트 등록을 실패하였습니다.");
					}
					location.reload();
				}
			});

		}else{//첨부파일 있썽
			var form = jQuery("#ajaxFrom")[0];
			var formData = new FormData(form);
			formData.append("message", "ajax로 파일 전송하기");
			formData.append("file", jQuery("#ajaxFile")[0].files[0]);

			jQuery.ajax({
				url: "<?php echo site_url();?>/ajax/forcasting_complete_status_file_upload",
				type : "POST",
				processData : false,
				contentType : false,
				data : formData,
				success:function(json) {
					var obj = JSON.parse(json);
					if(obj == "false"){
						alert('업로드 파일에 문제가 있습니다. 다시 처리해 주시기 바랍니다.')
					}else{
						var file_real_name = obj.file_real_name;
						var file_change_name = obj.file_change_name;
					
						$.ajax({
							type: "POST",
							cache: false,
							url: "<?php echo site_url();?>/ajax/forcasting_complete_status_comment_insert",
							dataType: "json",
							async: false,
							data: {
								seq: <?php echo $seq ;?>,
								status: status,
								contents:contents,
								file_real_name:file_real_name,
								file_change_name:file_change_name
							},
							success: function (data) {
								if(data.result == "true"){
									alert("수주여부 코멘트 등록 되었습니다.");
								}else{
									alert("수주여부 코멘트 등록을 실패하였습니다.");
								}
								location.reload();
							}
						});
					}
				}
			});

		}
	}

	//수주여부 코멘트 첨부파일 삭제
	function filedel(seq, filename) {
		if(filename != ""){
			if (confirm("첨부파일을 삭제하시겠습니까?") == true) {
				location.href = "<?php echo site_url(); ?>/forcasting/forcasting_complete_status_filedel/" + seq + "/" + filename;
				return false;
			}
		}
 	}

	//콤마제거
	function commaCheck(obj){
		if(($(obj).val()).indexOf(',') != -1){
			alert(', 를 입력하실 수 없습니다.');
			$(obj).val($(obj).val().replace(',',''));
		}
	}

	// //일괄적용
	// function collectiveApplication(obj,tagName){
	// 	if($('input:checkbox[name="product_row"]:checked').length > 0){
	// 		if(confirm("체크 되어 있는 제품에 일괄 수정하시겠습니까?")){
	// 			var id = $(obj).attr("name");
	// 			$('input:checkbox[name="product_row"]').each(function () {
	// 				if (this.checked == true) {
	// 					if(this.value == 0){
	// 						if(tagName == 0){//input
	// 							$("#"+id).val(obj.value);
	// 						}else if(tagName == 1){//select
	// 							$("#"+id).val(obj.value).prop("selected",true);
	// 						}else{//select2
	// 							$("#"+id).val(obj.value).prop("selected",true);
	// 							$("#"+id).select2().val(obj.value);
	// 						}
	// 					}else{
	// 						if(tagName == 0){//select2
	// 							$("#"+id+this.value).val(obj.value);
	// 						}else if(tagName == 1){//select
	// 							$("#"+id+this.value).val(obj.value).prop("selected",true);
	// 						}else{//select2
	// 							$("#"+id+this.value).val(obj.value).prop("selected",true);
	// 							$("#"+id+this.value).select2().val(obj.value);
	// 						}
	// 					}
	// 				}
	// 			});
	// 		}
	// 	}else{
	// 		return false;
	// 	}
	// }

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
			$("#procurement").show();
		}else{
			$("#procurement").hide();
		}
	}
</script>
</body>

</html>