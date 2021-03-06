<?php
include $this->input->server('DOCUMENT_ROOT') . "/include/base.php";
include $this->input->server('DOCUMENT_ROOT') . "/include/sales_top.php";
// $max_number = '';
?>
<style type="text/css">
#monthlyInput {
    width: 50px;
    margin-left: 10px;
    display: none;
}

#month {
    display: none;
    margin-right: 170px;
}
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/js/select2.min.js"></script>
<script>
function main_list_del(idx, mcompany_seq) {
    if (mcompany_seq) {
        $("#delete_main_array").val($("#delete_main_array").val() + "," + mcompany_seq)
    }
	$(".main_insert_field_" + idx).remove();
}

function forcasting_profit_change() {
    var mform = document.cform;
    mform.forcasting_profit.value = mform.forcasting_sales.value.replace(/,/g, "") - mform.forcasting_purchase.value.replace(/,/g, "");
    mform.forcasting_profit.value = mform.forcasting_profit.value.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, "$1,");

	//연계프로젝트가 있을때 가격 변동시 전체 값 수정
	if ($("input[name=sub_product_sales]").length > 0) { 
		var total_product_sale=0;
		var total_product_purchase=0;
		var total_product_profit=0;
		for(i=0; i<document.getElementsByName("product_sales").length; i++){
			total_product_sale += Number(document.getElementsByName("product_sales")[i].value.replace(/,/g, ""));
			total_product_purchase += Number(document.getElementsByName("product_purchase")[i].value.replace(/,/g, ""));
			total_product_profit += Number(document.getElementsByName("product_profit")[i].value.replace(/,/g, ""));
		}

		for(i=0; i<document.getElementsByName("sub_product_sales").length; i++){
			total_product_sale += Number(document.getElementsByName("sub_product_sales")[i].value.replace(/,/g, ""));
			total_product_purchase += Number(document.getElementsByName("sub_product_purchase")[i].value.replace(/,/g, ""));
			total_product_profit += Number(document.getElementsByName("sub_product_profit")[i].value.replace(/,/g, ""));

		}
		
		$("#sub_plus_forcasting_sales").val(String(total_product_sale).replace(/(\d)(?=(?:\d{3})+(?!\d))/g, "$1,"));
		$("#sub_plus_forcasting_purchase").val(String(total_product_purchase).replace(/(\d)(?=(?:\d{3})+(?!\d))/g, "$1,"));
		$("#sub_plus_forcasting_profit").val(String(total_product_profit).replace(/(\d)(?=(?:\d{3})+(?!\d))/g, "$1,"));
	}
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
    var strings = "#product_insert_field_4_" + idx + " td input";
    $(strings).eq(2).val($(strings).eq(0).val().replace(/,/g, "") - $(strings).eq(1).val().replace(/,/g, ""));
    $(strings).eq(2).val($(strings).eq(2).val().replace(/(\d)(?=(?:\d{3})+(?!\d))/g, "$1,"));
    t_forcasting_profit_change();

}
</script>
<script language="javascript">
function chkDel() {
    if (confirm("등록된 모든 코멘트들도 삭제됩니다. 정말 삭제하시겠습니까?") == true) {
        <?php
			if($complete_status_val){ 
			 	foreach($complete_status_val as $item){ ?>
        filedel('<?php echo $item['seq']; ?>', '<?php echo $item['file_change_name']; ?>')
        <?php }} ?>
        var mform = document.cform;
        mform.action = "<?php echo site_url(); ?>/tech/maintain/maintain_delete_action";
        mform.submit();
        return false;
    }
}
</script>
<script language="javascript">
function checkNum(obj) {
    var phone_num;

    function phone_regexp(phonNum) {
        phone_num = phonNum.replace(/[^0-9]/g, "").replace(/(^02|^0505|^1[0-9]{3}|^0[0-9]{2})([0-9]+)?([0-9]{4})$/,
            "$1-$2-$3").replace("--", "-");
    }
    var word = obj.value;
    phone_regexp(word);
    var str = "1234567890";
    obj.value = phone_num;
}

function numberFormat(obj) {
    if (obj.value == "") {
        obj.value = 0;
    }
    var inputNumber = obj.value.replace(/,/g, "");
    var fomatnputNumber = inputNumber.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, "$1,");
    obj.value = fomatnputNumber;
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
	
	}else if("<?php echo $_GET['type'] ;?>" == "2"){  //영업 정보
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
			alert("영업담당자(두리안)를 입력해 주세요.");
			return false;
		}
		if (mform.cooperation_username.value == "") {
			mform.cooperation_username.focus();
			alert("담당자를 입력해 주세요.");
			return false;
		}

	}else if("<?php echo $_GET['type'] ;?>" == "3"){ //매출처 정보
		if (mform.sales_companyname.value == "") {
			mform.sales_companyname.focus();
			alert("매출처를 입력해 주세요.");
			return false;
		}
		if (mform.sales_username.value == "") {
			mform.sales_username.focus();
			alert("매출처 담당자를 입력해 주세요.");
			return false;
		}
		if (mform.sales_tel.value == "") {
			mform.sales_tel.focus();
			alert("매출차 담당자 연락처를 입력해 주세요.");
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

		if (objmain_companyname.length > 0) {
			for (var i = 0; i < objmain_companyname.length; i++) {
				if ($.trim(objmain_companyname[i].value) == "") {
					alert(i + 1 + '번째 매입처를 입력해주세요..');
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
		if (objmain_companyname.length > 0) {
			for (var i = 0; i < objmain_companyname.length; i++) {
				$("#update_main_array").val($("#update_main_array").val() + "||" + objmain_companyname[i].value + "~" +
					objmain_username[i].value + "~" + objmain_tel[i].value + "~" + objmain_email[i].value + "~" +
					objmain_seq[i].value);
				//alert($("#license_array").val());
			}
		}
	}else if("<?php echo $_GET['type'] ;?>" == "5"){// 제품 정보
		var objproduct_seq = document.getElementsByName("product_seq");
		var objproduct_name = document.getElementsByName("product_name");
		var objproduct_serial = document.getElementsByName("product_serial");
		var objproduct_state = document.getElementsByName("product_state");
		var objproduct_licence = document.getElementsByName("product_licence");
		var objproduct_maintain_yn = document.getElementsByName("maintain_yn");
		var objproduct_maintain_target = document.getElementsByName("maintain_target");
		var objproduct_maintain_begin = document.getElementsByName("maintain_begin");
		var objproduct_maintain_expire = document.getElementsByName("maintain_expire");
		var objproduct_product_sales = document.getElementsByName("product_sales");
		var objproduct_product_purchase = document.getElementsByName("product_purchase");
		var objproduct_product_profit = document.getElementsByName("product_profit");
		var objproduct_version = document.getElementsByName("product_version");
		var objcustom_title = document.getElementsByName("custom_title");
		var objcustom_detail = document.getElementsByName("custom_detail");
		var objproduct_monthly_input = document.getElementsByName("monthly_input");
		var objproduct_check_list = document.getElementsByName("product_check_list");
		var objproduct_host = document.getElementsByName("product_host");

		var objproduct_seq_sub = document.getElementsByName("sub_product_seq");
		var objproduct_name_sub = document.getElementsByName("sub_product_name");
		var objproduct_serial_sub = document.getElementsByName("sub_product_serial");
		var objproduct_state_sub = document.getElementsByName("sub_product_state");
		var objproduct_licence_sub = document.getElementsByName("sub_product_licence");
		var objproduct_maintain_yn_sub = document.getElementsByName("sub_maintain_yn");
		var objproduct_maintain_target_sub = document.getElementsByName("sub_maintain_target");
		var objproduct_maintain_begin_sub = document.getElementsByName("sub_maintain_begin");
		var objproduct_maintain_expire_sub = document.getElementsByName("sub_maintain_expire");
		var objproduct_product_sales_sub = document.getElementsByName("sub_product_sales");
		var objproduct_product_purchase_sub = document.getElementsByName("sub_product_purchase");
		var objproduct_product_profit_sub = document.getElementsByName("sub_product_profit");
		// var objproduct_version_sub = document.getElementsByName("sub_product_version");
		// var objcustom_title_sub = document.getElementsByName("sub_custom_title");
		// var objcustom_detail_sub = document.getElementsByName("sub_custom_detail");
		// var objseq_sub = document.getElementsByName("sub_seq");
		// var objproduct_check_list_sub = document.getElementsByName("sub_product_check_list");
		// var objproduct_host_sub = document.getElementsByName("sub_product_host");

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
				if ($.trim(objproduct_name[i].value) == "0") {
					alert(i + 1 + '번째 제품명을 선택해주세요..');
					objproduct_name[i].focus();
					return;
				}
				// if($.trim(objproduct_serial[i].value) == "") {
				// 	alert(i+1 + "번째 시리얼을 입력하십시오.");
				// 	objproduct_serial[i].focus();
				// 	return;
				// }
				if ($.trim(objproduct_state[i].value) == "0") {
					alert(i + 1 + "번째 제품 상태를 선택해주세요.");
					objproduct_state[i].focus();
					return;
				}
			}
		}

		if (mform.exception_saledate3.value == "") {
			mform.exception_saledate3.focus();
			alert("유지보수 만료일을 선택해 주세요.");
			return false;
		}

		$("#update_product_array").val('');
		if (objproduct_name.length > 0) {
			for (var i = 0; i < objproduct_name.length; i++) {
				$("#update_product_array").val($("#update_product_array").val() + "||" + objproduct_name[i].value +
					"~" + objproduct_licence[i].value + "~" + objproduct_serial[i].value + "~" + objproduct_state[i]
					.value + "~" + objproduct_maintain_begin[i].value.split(' ')[0] + "~" +
					objproduct_maintain_expire[i].value.split(' ')[0] + "~" + objproduct_maintain_yn[i].value +
					"~" + objproduct_maintain_target[i].value + "~" + objproduct_product_sales[i].value.replace(
						/,/g, "") + "~" + objproduct_product_purchase[i].value.replace(/,/g, "") + "~" +
					objproduct_product_profit[i].value.replace(/,/g, "") + "~" + objproduct_seq[i].value);
				//alert($("#license_array").val());
			}
		}
		
		$("#update_sub_product_array").val('');
		if (objproduct_name_sub.length > 0) {
			for (var i = 0; i < objproduct_name_sub.length; i++) {
				$("#update_sub_product_array").val($("#update_sub_product_array").val() + "||" + objproduct_name_sub[i]
					.value + "~" + objproduct_licence_sub[i].value + "~" + objproduct_serial_sub[i].value + "~" +
					objproduct_state_sub[i].value + "~" + objproduct_maintain_begin_sub[i].value.split(' ')[0] +
					"~" + objproduct_maintain_expire_sub[i].value.split(' ')[0] + "~" + objproduct_maintain_yn_sub[
						i].value + "~" + objproduct_maintain_target_sub[i].value + "~" +
					objproduct_product_sales_sub[i].value.replace(/,/g, "") + "~" + objproduct_product_purchase_sub[
						i].value.replace(/,/g, "") + "~" + objproduct_product_profit_sub[i].value.replace(/,/g,
					"") + "~" + objproduct_seq_sub[i].value);
			}
		}

	}else if("<?php echo $_GET['type'] ;?>" == "6"){//수주 정보
		if (mform.complete_status.value == "0") {
			mform.complete_status.focus();
			alert("수주여부를 선택해 주세요.");
			return false;
		}
	}
    // console.log($("#update_product_array").val());

    mform.submit();
    return false;
}

function chkForm2() {
    var rform = document.rform;
    var objproduct_maintain_begin = document.getElementsByName("maintain_begin");
    var objproduct_maintain_expire = document.getElementsByName("maintain_expire");

    if (rform.comment.value == "") {
        rform.comment.focus();
        alert("답변을 등록해 주세요.");
        return false;
    }

    rform.action = "<?php echo site_url(); ?>/tech/maintain/maintain_comment_action";
    rform.submit();
    return false;
}

function chkForm3(seq) {
    if (confirm("정말 삭제하시겠습니까?") == true) {
        var rform = document.rform;
        rform.cseq.value = seq;
        rform.action = "<?php echo site_url(); ?>/tech/maintain/maintain_comment_delete";
        rform.submit();
        return false;
    }
}
</script>
<body>
    <table width="90%" height="100%" border="0" cellspacing="0" cellpadding="0" style="margin-left:30px;">
        <tr>
            <td width="100%" align="center" valign="top">
                <!--내용-->
                <table width="100%" border="0" style="margin-top:50px; margin-bottom: 50px;">
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
                        <td>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="main_list">
                                <form name="cform" action="<?php echo site_url(); ?>/tech/maintain/maintain_input_action"
                                    method="post" onSubmit="javascript:chkForm();return false;">
                                    <input type="hidden" id="update_main_array" name="update_main_array" />
                                    <input type="hidden" id="delete_main_array" name="delete_main_array" />
                                    <input type="hidden" id="update_product_array" name="update_product_array" />
                                    <input type="hidden" id="update_sub_product_array" name="update_sub_product_array" />
									<input type="hidden" name="seq" value="<?php echo $seq; ?>">
									<?php if(isset($_GET['type'])){
										echo "<input type='hidden' name='data_type' value='{$_GET['type']}' />";
									}?>
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
                                    
                                    <?php if($_GET['type'] == '1'){ ?>
                                    <tr>
                                        <td height="40" style="font-weight:bold;font-size:13px;">고객사 정보</td>
                                    </tr>
                                    <tr>
                                        <td colspan="10" height="2" bgcolor="#797c88"></td>
                                    </tr>
                                    <tr>
                                        <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">고객사</td>
                                        <td align="left" class="t_border" style="padding-left:10px;"><input name="customer_companyname" type="text" class="input7" id="customer_companyname" value="<?php echo $view_val['customer_companyname']; ?>" /></td>
									</tr>
									<tr>
										<td colspan="10" height="1" bgcolor="#e8e8e8"></td>
									</tr>
									<tr>	
										<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">담당자</td>
                                        <td align="left" class="t_border" style="padding-left:10px;"><input name="customer_username" type="text" class="input7" id="customer_username" value="<?php echo $view_val['customer_username']; ?>" /></td>
									</tr>
									<tr>
										<td colspan="10" height="1" bgcolor="#e8e8e8"></td>
									</tr>
									<tr>	
										<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">연락처</td>
                                        <td align="left" class="t_border" style="padding-left:10px;"><input type="text" name="customer_tel" id="customer_tel" class="input7" value="<?php echo $view_val['customer_tel']; ?>" onclick="checkNum(this);" onKeyUp="checkNum(this);" /></td>
									</tr>
									<tr>
										<td colspan="10" height="1" bgcolor="#e8e8e8"></td>
									</tr>
									<tr>	
										<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">이메일</td>
                                        <td align="left" class="t_border" style="padding-left:10px;"><input type="text" name="customer_email" id="customer_email" class="input7" value="<?php echo $view_val['customer_email']; ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td colspan="10" height="2" bgcolor="#797c88"></td>
                                    </tr>
										<?php }else if($_GET['type'] == '2'){ ?>
									<tr>
                                        <td height="40" style="font-weight:bold;font-size:13px;">영업 정보</td>
                                    </tr>
                                    <tr>
                                        <td colspan="10" height="2" bgcolor="#797c88"></td>
                                    </tr>
                                    <tr>
                                        <td height="40" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">프로젝트</td>
										<td align="left" class="t_border" style="padding-left:10px;"><input name="project_name" type="text" class="input2" id="project_name" value="<?php echo $view_val['project_name']; ?>" style="width:95%;" /></td>
										<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">연계프로젝트</td>
                                        <td align="center" class="t_border" style="font-weight:bold;">
                                            <input type="hidden" name="subProjectAddInput" id="subProjectAddInput" value='<?php echo $view_val['sub_project_add'] ?>'></input>
                                            <input type="hidden" id="subProjectRemoveInput" value='' />
                                            <select id="sub_project_add" class="input7" onchange="subProjectAdd()">
                                                <option value="0">조회추가</option>
                                                <?php
												foreach ($sub_project as $val) {
													echo '<option value="' . $val['seq'] . '">'. $val['customer_companyname'].'-' . $val['project_name'] . '</option>';
												}
												?>
                                            </select>
                                            <select id="sub_project_remove" class="input7" onchange="subProjectRemove()">
                                                <option>조회취소</option>
                                                <?php
												foreach ($sub_project_cancle as $val) {
													echo '<option value="' . $val['seq'] . '">'. $val['customer_companyname'].'-' . $val['project_name'] . '</option>';
												}
												?>
                                            </select>
                                        </td>
									</tr>
									<!-- <tr>	
										<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">관리팀</td>
										<td align="left" class="t_border" style="padding-left:10px;width:500px">
											<select  name="manage_team" id="manage_team" class="input5">
                                                <option value="-1" selected>담당팀선택</option>
                                                <option value="1" <?php if ($view_val['manage_team'] == "1") {
																					echo "selected";
																				} ?>>기술 1팀</option>
                                                <option value="2" <?php if ($view_val['manage_team'] == "2") {
																					echo "selected";
																				} ?>>기술 2팀</option>
                                                <option value="3" <?php if ($view_val['manage_team'] == "3") {
																					echo "selected";
																				} ?>>기술 3팀</option>
											</select>
										</td>
                                        <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">점검주기</td>
										<td align="left" class="t_border" style="padding-left:10px;width:500px">
											<select name="maintain_cycle" id="manage_cycle" class="input5">
                                                <option value="9" selected>- 점검주기선택-</option>
                                                <option value="1" <?php if ($view_val['maintain_cycle'] == "1") { echo "selected"; } ?>>월점검</option>
                                                <option value="3" <?php if ($view_val['maintain_cycle'] == "3") { echo "selected"; } ?>>분기점검</option>
                                                <option value="6" <?php if ($view_val['maintain_cycle'] == "6") { echo "selected"; } ?>>반기점검</option>
                                                <option value="0" <?php if ($view_val['maintain_cycle'] == "0") { echo "selected"; } ?>>장애시</option>
                                                <option value="7" <?php if ($view_val['maintain_cycle'] == "7") { echo "selected"; } ?>>미점검</option>
											</select>
                                        </td>
                                    </tr> -->
                                    <tr>
                                        <td colspan="10" height="1" bgcolor="#e8e8e8"></td>
                                    </tr>
                                    <tr>
                                        <td height="40" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">진척단계</td>
										<td align="left" class="t_border" style="padding-left:10px;">
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
                                                <option value="016" <?php if ($view_val['progress_step'] == "016") {
																					echo "selected";
																				} ?>>매출발생(90%)</option>
                                                <option value="017" <?php if ($view_val['progress_step'] == "017") {
																					echo "selected";
																				} ?>>미수잔금(95%)</option>
                                                <option value="018" <?php if ($view_val['progress_step'] == "018") {
																					echo "selected";
																				} ?>>수금완료(100%)</option>
											</select>
										</td>
                                        <td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">판매종류</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<select name="type" id="type" class="input5">
												<option value="1" <?php if ($view_val['type'] == "1") {
																					echo "selected";
																				} ?>>판매</option>
												<option value="2" <?php if ($view_val['type'] == "2") {
																					echo "selected";
																				} ?>>용역</option>
												<option value="0" <?php if ($view_val['type'] == "0") {
																					echo "selected";
																				} ?>>미지정</option>
											</select>
										</td>
                                    </tr>
                                    <tr>
                                        <td colspan="10" height="1" bgcolor="#e8e8e8"></td>
                                    </tr>
                                    <tr>
                                        <td height="40" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">영업업체</td>
                                        <td align="left" class="t_border" style="padding-left:10px;">
                                            <select name="cooperation_companyname" id="cooperation_companyname" class="input7">
                                                <option value="" <?php if ($view_val['cooperation_companyname'] == " ") echo "selected"; ?>>선택하세요</option>
                                                <option value="두리안정보기술" <?php if ($view_val['cooperation_companyname'] == "두리안정보기술") echo "selected"; ?>>두리안정보기술</option>
                                                <option value="두리안정보통신기술" <?php if ($view_val['cooperation_companyname'] == "두리안정보통신기술") echo "selected"; ?>>두리안정보통신기술</option>
                                                <option value="더망고" <?php if ($view_val['cooperation_companyname'] == "더망고") echo "selected"; ?>>더망고</option>
                                            </select>
                                        </td>
                                        <td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">영업담당자</td>
                                        <td align="left" class="t_border" style="padding-left:10px;">
                                            <input name="cooperation_username" type="text" class="input5" id="cooperation_username" value="<?php echo $view_val['cooperation_username']; ?>" />
										</td>
									</tr>
									<tr>
                                        <td colspan="10" height="1" bgcolor="#e8e8e8"></td>
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
                                            <input name="cooperation_tel" type="hidden" class="input5" id="cooperation_tel" value="<?php echo $view_val['cooperation_tel']; ?>" />
                                        </td>
                                        <!--                    <td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">이메일</td>-->
                                        <!-- <td colspan="4" align="left" class="t_border" style="padding-left:10px;"><input
                                                name="cooperation_email" type="hidden" class="input5"
                                                id="cooperation_email"
												value="<?php echo $view_val['cooperation_email']; ?>" />
										</td> -->
									</tr>
									<tr>
                                        <td colspan="10" height="2" bgcolor="#797c88"></td>
									</tr>
									<?php }else if($_GET['type'] == '7'){ ?>
									<tr>
                                        <td height="40" style="font-weight:bold;font-size:13px;">점검 정보</td>
                                    </tr>
                                    <tr>
                                        <td colspan="10" height="2" bgcolor="#797c88"></td>
                                    </tr>
                                    <tr>
                                        <td height="40" align="center" class="t_border" bgcolor="f8f8f9" style="font-weight:bold;">관리팀</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<select  name="manage_team" id="manage_team" class="input2">
                                                <option value="-1" selected>담당팀선택</option>
                                                <option value="1" <?php if ($view_val['manage_team'] == "1") {
																					echo "selected";
																				} ?>>기술 1팀</option>
                                                <option value="2" <?php if ($view_val['manage_team'] == "2") {
																					echo "selected";
																				} ?>>기술 2팀</option>
                                                <option value="3" <?php if ($view_val['manage_team'] == "3") {
																					echo "selected";
																				} ?>>기술 3팀</option>
											</select>
										</td>
									</tr>
									<tr>
                                        <td colspan="10" height="1" bgcolor="#e8e8e8"></td>
                                    </tr>
									<tr>
                                        <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">점검주기</td>
                                        <td align="left" class="t_border" style="padding-left:10px;">
											<select name="maintain_cycle" id="manage_cycle" class="input2">
                                                <option value="9" selected>- 점검주기선택-</option>
                                                <option value="1" <?php if ($view_val['maintain_cycle'] == "1") { echo "selected"; } ?>>월점검</option>
                                                <option value="3" <?php if ($view_val['maintain_cycle'] == "3") { echo "selected"; } ?>>분기점검</option>
                                                <option value="6" <?php if ($view_val['maintain_cycle'] == "6") { echo "selected"; } ?>>반기점검</option>
                                                <option value="0" <?php if ($view_val['maintain_cycle'] == "0") { echo "selected"; } ?>>장애시</option>
                                                <option value="7" <?php if ($view_val['maintain_cycle'] == "7") { echo "selected"; } ?>>미점검</option>
											</select>
										</td>
									</tr>
									<tr>
                                        <td colspan="10" height="1" bgcolor="#e8e8e8"></td>
                                    </tr>
									<tr>
                                        <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">점검일자</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<input name="maintain_date" type="date" class="input2" id="maintain_date" value="<?php echo $view_val['maintain_date']; ?>" />
										</td>
									</tr>
									<tr>
                                        <td colspan="10" height="1" bgcolor="#e8e8e8"></td>
                                    </tr>
									<tr>
                                        <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">점검자</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<input name="maintain_user" type="text" class="input2" id="maintain_user" value="<?php echo $view_val['maintain_user']; ?>" />	
										</td>
									</tr>
									<tr>
                                        <td colspan="10" height="1" bgcolor="#e8e8e8"></td>
                                    </tr>
									<tr>
                                        <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">점검방법</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<select name="maintain_type" id="maintain_type" class="input2">
												<option value="9" selected>- 점검방법선택 -</option>
												<option value="1" <?php if ($view_val['maintain_type'] == "1") {
																echo "selected";
															} ?>>방문점검</option>
												<option value="2" <?php if ($view_val['maintain_type'] == "2") {
																echo "selected";
															} ?>>원격점검</option>
											</select>
										</td>
									</tr>
									<tr>
                                        <td colspan="10" height="1" bgcolor="#e8e8e8"></td>
                                    </tr>
									<tr>
                                        <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">점검여부</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<select name="maintain_result" id="maintain_result" class="input2">
												<option value="9" selected>- 점검여부선택 -</option>
												<option value="1" <?php if ($view_val['maintain_result'] == "1") {
																echo "selected";
															} ?>>완료</option>
												<option value="0" <?php if ($view_val['maintain_result'] == "0") {
																echo "selected";
															} ?>>미완료</option>
												<option value="2" <?php if ($view_val['maintain_result'] == "2") {
																echo "selected";
															} ?>>미해당</option>
												<option value="9" <?php if ($view_val['maintain_result'] == "9") {
																echo "selected";
															} ?>>예정</option>
												<option value="3" <?php if ($view_val['maintain_result'] == "3") {
																echo "selected";
															} ?>>연기</option>
												<option value="4" <?php if ($view_val['maintain_result'] == "4") {
																echo "selected";
															} ?>>협력사 점검</option>
											</select>
										</td>
									</tr>
									<tr>
                                        <td colspan="10" height="1" bgcolor="#e8e8e8"></td>
                                    </tr>
									<tr>
                                        <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">점검코멘트</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<textarea name="maintain_comment" id="maintain_comment" class="input7" ><?php echo $view_val['maintain_comment']; ?></textarea>
										</td>
									</tr>
									<tr>
                                        <td colspan="10" height="2" bgcolor="#797c88"></td>
                                    </tr>
									
									<?php }else if($_GET['type'] == '3'){ ?>
									<tr>
                                        <td height="40" style="font-weight:bold;font-size:13px;">매출처 정보</td>
                                    </tr>
                                    <tr>
                                        <td colspan="10" height="2" bgcolor="#797c88"></td>
                                    </tr>
                                    <tr>
                                        <td height="70" align="center" class="t_border" bgcolor="f8f8f9" style="font-weight:bold;">매출처</td>
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
                                            </select>
                                            <input name="sales_companyname" type="text" class="input7" id="sales_companyname" value="<?php echo $view_val['sales_companyname']; ?>" />
										</td>
									</tr>
									<tr>
                                        <td colspan="10" height="1" bgcolor="#e8e8e8"></td>
                                    </tr>
									<tr>
                                        <td height="70" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">담당자</td>
                                        <td align="left" class="t_border" style="padding-left:10px;">
                                            <select id="select_sales_user" class="input2">
                                                <!-- <?php if($view_val['sales_username']== ''){ echo '<option value="" selected>담당자 선택</option>' ; }?>	 -->
                                                <option value="">담당자 선택</option>
                                            </select>
                                            <input name="sales_username" type="text" class="input7" id="sales_username" value="<?php echo $view_val['sales_username']; ?>" />
										</td>
									</tr>
									<tr>
                                        <td colspan="10" height="1" bgcolor="#e8e8e8"></td>
                                    </tr>
									<tr>
                                        <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">연락처</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<input  name="sales_tel" type="text" class="input7" id="sales_tel" value="<?php echo $view_val['sales_tel']; ?>" onclick="checkNum(this);" onKeyUp="checkNum(this);" />
										</td>
									</tr>
									<tr>
                                        <td colspan="10" height="1" bgcolor="#e8e8e8"></td>
                                    </tr>
									<tr>
                                        <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">이메일</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<input name="sales_email" type="text" class="input7" id="sales_email" value="<?php echo $view_val['sales_email']; ?>" />
										</td>
									</tr>
									<tr>
                                        <td colspan="10" height="2" bgcolor="#797c88"></td>
                                    </tr>
									<?php }else if($_GET['type'] == '4'){ 
									$i = 0;
									foreach ($view_val2 as $item2) {
										if ($i == 0) {
									?>
										<tr id="main_insert_field_<?php echo $i; ?>">
											<td colspan="10" height="0" bgcolor="#e8e8e8"></td>
										</tr>
										<tr>
											<td height="40" style="font-weight:bold;font-size:13px;">매입처 정보</td>
										</tr>
										<tr>
											<td colspan="10" height="2" bgcolor="#797c88"></td>
										</tr>
										<tr class="main_insert_field_<?php echo $i; ?>">
											<td height="70" align="center" class="t_border" bgcolor="f8f8f9" style="font-weight:bold;">매입처</td>
											<td align="left" class="t_border" style="padding-left:10px;">
												<select id="select_main_company" class="input2" onchange="selectMainCompany(); ">
													<option value=''>매입처 선택</option>
													<?php foreach($sales_customer as $sc){
														echo "<option value='{$sc['seq']}'";
														if( $item2['main_companyname'] == $sc['company_name']){
															echo "selected";
														}
														echo ">{$sc['company_name']}</option>";
													}?>
												</select>
												<input name="main_companyname" type="text" class="input2" id="main_companyname" value="<?php echo $item2['main_companyname']; ?>" />
												<input name="main_seq" type="hidden" id="main_seq" value="<?php echo $item2['seq']; ?>" />
											</td>
											<td height="70" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">담당자</td>
											<td align="left" class="t_border" style="padding-left:10px;">
												<select id="select_main_user" class="input2" onchange="selectMainUser();">
													<option value=''>담당자 선택</option>
												</select>
												<input name="main_username" type="text" class="input2" id="main_username" value="<?php echo $item2['main_username']; ?>" />
											</td>
										</tr>
										<tr class="main_insert_field_<?php echo $i; ?>">
											<td colspan="10" height="1" bgcolor="#e8e8e8"></td>
										</tr>
										<tr class="main_insert_field_<?php echo $i; ?>">
											<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">연락처</td>
											<td align="left" class="t_border" style="padding-left:10px;">
												<input name="main_tel" type="text" class="input2" id="main_tel" value="<?php echo $item2['main_tel']; ?>" onclick="checkNum(this);" onKeyUp="checkNum(this);" />
											</td>
											<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">
												이메일</td>
											<td align="left" class="t_border" style="padding-left:10px;">
												<input name="main_email" type="text" class="input2" id="main_email" value="<?php echo $item2['main_email']; ?>" />
											</td>
										</tr>
										<tr class="main_insert_field_<?php echo $i; ?>">
											<td colspan="10" height="2" bgcolor="#797c88"></td>
										</tr>
                                    	<?php } else { ?>
										<tr class="main_insert_field_<?php echo $i; ?>">
											<td></td>
										</tr>
										<tr class="main_insert_field_<?php echo $i; ?>">
											<td height="70" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">매입처</td>
											<td align="left" class="t_border" style="padding-left:10px;">
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
												</select>
												<input name="main_companyname" type="text" class="input7" id="main_companyname<?php echo $i;?>" value="<?php echo $item2['main_companyname']; ?>" />
												<input name="main_seq" type="hidden" id="main_seq" value="<?php echo $item2['seq']; ?>" />
											</td>
											<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">담당자</td>
											<td align="left" class="t_border" style="padding-left:10px;">
												<select id="select_main_user<?php echo $i;?>" class="input2" onchange="selectMainUser(<?php echo $i; ?>);">
													<option value=''>담당자 선택</option>
												</select>
												<input name="main_username" type="text" class="input7" id="main_username<?php echo $i;?>" value="<?php echo $item2['main_username']; ?>" />
											</td>
										</tr>
										<tr class="main_insert_field_<?php echo $i; ?>">
											<td colspan="10" height="1" bgcolor="#e8e8e8"></td>
										</tr>
										<tr class="main_insert_field_<?php echo $i; ?>">
											<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">연락처</td>
											<td align="left" class="t_border" style="padding-left:10px;">
												<input name="main_tel" type="text" class="input2" id="main_tel<?php echo $i;?>" value="<?php echo $item2['main_tel']; ?>" onclick="checkNum(this);" onKeyUp="checkNum(this);" />
											</td>
											<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">이메일</td>
											<td align="left" class="t_border" style="padding-left:10px;">
												<input name="main_email" type="text" class="input2" id="main_email<?php echo $i;?>" value="<?php echo $item2['main_email']; ?>" />
											</td>
											<td align="center">
												<img src="<?php echo $misc; ?>img/btn_del0.jpg" onclick='javascript:main_list_del(<?php echo $i; ?>,<?php echo $item2["seq"]; ?>);' style="cursor:pointer;" />
											</td>
										</tr>
										<tr class="main_insert_field_<?php echo $i; ?>">
											<td colspan="10" height="2" bgcolor="#797c88"></td>
										</tr>
										<script>
										$("#select_main_company<?php echo $i;?>").select2();
										</script>
									<?php
										}
										$max_number = $i;
										$i++;
									}?>
										<tr id="main_insert">
											<td>
												<input type="hidden" id="row_max_index" name="row_max_index" value="<?php echo $max_number; ?>" />
											</td>
										</tr>
									<?php }else if($_GET['type'] == '5'){ ?>
                                    <?php
										$mb_cnt = 2;
										$j = 1;
										$i = 0;
										foreach ($view_val3 as $item3) {
											if ($j == 1) {
									?>
                                    <tr>
                                        <td colspan=10 height="40" style="font-weight:bold;font-size:13px;">제품 정보</td>
                                    </tr>
                                    <tr id="product_insert_field_<?php echo $j; ?>">
                                        <td colspan="10" height="2" bgcolor="#797c88"></td>
									</tr>
									<tr id="product_insert_field_1_<?php echo $j; ?>">
										<td colspan=2 height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">프로젝트명</td>
										<td colspan=8 align="left" class="t_border" style="padding-left:10px;">
											<?php echo $view_val['project_name']; ?>(<?php echo $view_val['exception_saledate'];?>)
										</td>
									</tr>
									<tr>
										<td colspan="10" height="1" bgcolor="#e8e8e8"></td>
									</tr>
                                    <tr id="product_insert_field_1_<?php echo $j; ?>">
                                        <td colspan=2 height="40" align="center" class="t_border" bgcolor="f8f8f9" style="font-weight:bold;">제조사</td>
                                        <td colspan=3 align="left" class="t_border" style="padding-left:10px;" colspan="1">
                                            <select name="product_company" id="product_company" class="input2" onchange="productSearch();">
                                                <option value="">제조사</option>
                                                <?php foreach($product_company as $pc){
													echo "<option value='{$pc['product_company']}'";
													if($item3['product_company'] == $pc['product_company'] ){
														echo "selected";
													}
													echo ">{$pc['product_company']}</option>";
												}?>
                                            </select>
                                        </td>
                                        <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">하드웨어/소프트웨어</td>
                                        <td colspan=3 align="left" class="t_border" style="padding-left:10px;" colspan="1">
                                            <select name="product_type" id="product_type" class="input2" onchange="productSearch();">
                                                <option value="" selected>전체</option>
                                                <option value="hardware" <?php if($item3['product_type'] == "hardware"){echo "selected"; }?>>하드웨어</option>
                                                <option value="software" <?php if($item3['product_type'] == "software"){echo "selected"; }?>>소프트웨어</option>
                                            </select>
                                        </td>
									</tr>
									<tr>
										<td colspan="10" height="1" bgcolor="#e8e8e8"></td>
									</tr>
                                    <tr id="product_insert_field_2_<?php echo $j; ?>">
                                        <td colspan=2 height="40" align="center" class="t_border" bgcolor="f8f8f9" style="font-weight:bold;">제품명</td>
                                        <td align="left" class="t_border" style="padding-left:10px;" colspan="1">
                                            <input type="hidden" name="product_seq" id="product_seq" value="<?php echo $item3['seq']; ?>" />
                                            <select name="product_name" id="product_name" class="input7" onclick="productSearch();">
                                                <option value="<?php echo $item3['product_code'] ;?>" selected> <?php echo $item3['product_name'] ;?></option>
                                            </select>
                                        </td>
                                        <td height="40" align="center"  bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">라이선스</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<input name="product_licence" type="text" class="input5" id="product_licence" value="<?php echo $item3['product_licence']; ?>" onkeyup="commaCheck(this);" /> 
										</td>
                                        <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">Serial</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<input name="product_serial" type="text" class="input5" id="product_serial" value="<?php echo $item3['product_serial']; ?>" onkeyup="commaCheck(this);" /> 
										</td>
                                        <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">제품 상태</td>
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
									<tr>
										<td colspan="10" height="1" bgcolor="#e8e8e8"></td>
									</tr>
                                    <tr id="product_insert_field_3_<?php echo $j; ?>">
                                        <td colspan=2 height="40" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">장비유지보수시작일</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<input name="maintain_begin" type="date" class="input7" id="maintain_begin1" value="<?php echo $item3['maintain_begin']; ?>" /> 
										</td>
                                        <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">장비유지보수만료일</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<input name="maintain_expire" type="date" class="input7" id="maintain_expire1" value="<?php echo $item3['maintain_expire']; ?>" /> 
										</td>
                                        <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">유/무상</td>
                                        <td align="left" class="t_border" style="padding-left:10px;">
                                            <select name="maintain_yn" id="product_yn" class="input5">
                                                <option value="0">- 유/무상여부 -</option>
                                                <option value="Y" <?php if ($item3['maintain_yn'] == "Y") {
																							echo "selected";
																						} ?>>유상</option>
                                                <option value="N" <?php if ($item3['maintain_yn'] == "N") {
																							echo "selected";
																						} ?>>무상</option>
                                            </select>
                                        </td>
                                        <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">유지보수 대상</td>
                                        <td align="left" class="t_border" style="padding-left:10px;">
                                            <select name="maintain_target" id="maintain_target" class="input5">
                                                <option value="0">유지보수 대상</option>
                                                <option value="Y" <?php if ($item3['maintain_target'] == "Y") {
																							echo "selected";
																						} ?>>대상</option>
                                                <option value="N" <?php if ($item3['maintain_target'] == "N") {
																							echo "selected";
																						} ?>>비대상</option>
											</select>
											<input name="product_version" type="hidden" class="input5" id="product_version" value="<?php echo $item3['product_version']; ?>" />
											<input name="product_check_list" type="hidden" class="input5" id="product_check_list" value="<?php echo $item3['product_check_list']; ?>" />
											<input name="product_host" type="hidden" class="input5" id="product_host" value="<?php echo $item3['product_host']; ?>" />
											<input name="custom_title" type="hidden" class="input5" id="custom_title" value="<?php echo $item3['custom_title']; ?>" />
											<input name="custom_detail" type="hidden" class="input5" id="custom_detail" value="<?php echo $item3['custom_detail']; ?>" />
										</td>
									</tr>
									<tr>
										<td colspan="10" height="1" bgcolor="#e8e8e8"></td>
									</tr>
									<tr id="product_insert_field_4_<?php echo $j; ?>">
										<td colspan=2 height="40" align="center" class="t_border" bgcolor="f8f8f9" style="font-weight:bold;">장비매출가</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<input name="product_sales" type="text" class="input5" id="product_sales" value="<?php if(trim($item3['product_sales']) == ""){echo $item3['product_sales'];}else{echo number_format($item3['product_sales']);} ?>" onclick="numberFormat(this);" onchange="numberFormat(this);product_profit_change(<?php echo $j; ?>);" /> 
										</td>
										<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">장비매입가</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<input name="product_purchase" type="text" class="input5" id="product_purchase" value="<?php if(trim($item3['product_purchase']) == ""){echo $item3['product_purchase'];}else{echo number_format($item3['product_purchase']);} ?>" onclick="numberFormat(this);" onchange="numberFormat(this);product_profit_change(<?php echo $j; ?>);" /> 
									    </td>
										<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">장비마진</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<input name="product_profit" type="text" class="input5" id="product_profit" value="<?php if(trim($item3['product_profit']) == ""){echo $item3['product_profit'];}else{echo number_format($item3['product_profit']);} ?>" readonly /> 
										</td>
									</tr>
									<tr id="product_insert_field_<?php echo $j; ?>">
                                        <td colspan="10" height="2" bgcolor="#797c88"></td>
									</tr>
									<?php } else { ?>
									<tr>
										<td colspan=2 height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">프로젝트명</td>
										<td colspan=8 align="left" class="t_border" style="padding-left:10px;">
											<?php echo $view_val['project_name']; ?>(<?php echo $view_val['exception_saledate']; ?>)
										</td>
									</tr>
									<tr>
										<td colspan="10" height="1" bgcolor="#e8e8e8"></td>
									</tr>
									<tr id="product_insert_field_1_<?php echo $j; ?>">
										<td colspan=2 height="40" align="center" class="t_border" bgcolor="f8f8f9" style="font-weight:bold;">제조사</td>
										<td colspan=3 align="left" class="t_border" style="padding-left:10px;" colspan="1">
											<select name="product_company" id="product_company<?php echo $i; ?>" class="input2" onchange="productSearch(<?php echo $i; ?>);">
												<option value="">제조사</option>
												<?php foreach($product_company as $pc){
													echo "<option value='{$pc['product_company']}'";
													if($item3['product_company'] == $pc['product_company'] ){
														echo "selected";
													}
													echo ">{$pc['product_company']}</option>";
												}?>
											</select>
										</td>
										<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">하드웨어/소프트웨어</td>
										<td colspan=3 align="left" class="t_border" style="padding-left:10px;">
											<select name="product_type" id="product_type<?php echo $i; ?>" class="input2" onchange="productSearch(<?php echo $i; ?>);">
												<option value="" selected>전체</option>
												<option value="hardware" <?php if($item3['product_type'] == "hardware"){echo "selected"; }?>>하드웨어</option>
												<option value="software" <?php if($item3['product_type'] == "software"){echo "selected"; }?>>소프트웨어</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan="10" height="1" bgcolor="#e8e8e8"></td>
									</tr>
									<tr id="product_insert_field_2_<?php echo $j; ?>">
										<td colspan=2 height="40" align="center" class="t_border" bgcolor="f8f8f9" style="font-weight:bold;">제품명</td>
										<td align="left" class="t_border" style="padding-left:10px;" colspan="1">
											<input type="hidden" name="product_seq" id="product_seq" value="<?php echo $item3['seq']; ?>" />
											<select name="product_name" id="product_name<?php echo $i; ?>" class="input7" onclick="productSearch(<?php echo $i; ?>);">
												<option value="<?php echo $item3['product_code'] ;?>" selected><?php echo $item3['product_name'] ;?></option>
											</select>
										</td>
										<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">라이선스</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<input name="product_licence" type="text" class="input5" id="product_licence" value="<?php echo $item3['product_licence']; ?>" onkeyup="commaCheck(this);" /> 
										</td>
										<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">Serial</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<input name="product_serial" type="text" class="input5" id="product_serial" value="<?php echo $item3['product_serial']; ?>" onkeyup="commaCheck(this);" /> 
										</td>
										<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">제품 상태</td>
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
									<tr>
										<td colspan="10" height="1" bgcolor="#e8e8e8"></td>
									</tr>
									<tr id="product_insert_field_3_<?php echo $j; ?>">
										<td colspan=2 height="40" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">장비유지보수시작일</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<input name="maintain_begin" type="date" class="input7" id="maintain_begin_<?php echo $mb_cnt; ?>" value="<?php echo $item3['maintain_begin']; ?>" /> 
										</td>
										<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">장비유지보수만료일</td>
										<td align="left" class="t_border" style="padding-left:10px;"><input name="maintain_expire" type="date"
												class="input7" id="maintain_expire_<?php echo $mb_cnt; ?>"
												value="<?php echo $item3['maintain_expire']; ?>" /> </td>
										<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">유/무상</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<select name="maintain_yn" id="maintain_yn" class="input5">
												<option value="0">- 유/무상여부 -</option>
												<option value="Y" <?php if ($item3['maintain_yn'] == "Y") {
																						echo "selected";
																					} ?>>유상</option>
												<option value="N" <?php if ($item3['maintain_yn'] == "N") {
																						echo "selected";
																					} ?>>무상</option>
											</select>
										</td>
										<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">유지보수 대상</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<select name="maintain_target" id="maintain_target" class="input5">
												<option value="0">유지보수 대상</option>
												<option value="Y" <?php if ($item3['maintain_target'] == "Y") {
																						echo "selected";
																					} ?>>대상</option>
												<option value="N" <?php if ($item3['maintain_target'] == "N") {
																						echo "selected";
																					} ?>>비대상</option>
											</select>
											<input name="product_version" type="hidden" class="input5" id="product_version" value="<?php echo $item3['product_version']; ?>" />
											<input name="product_check_list" type="hidden" class="input5" id="product_check_list" value="<?php echo $item3['product_check_list']; ?>" />
											<input name="product_host" type="hidden" class="input5" id="product_host" value="<?php echo $item3['product_host']; ?>" />
											<input name="custom_title" type="hidden" class="input5" id="custom_title" value="<?php echo $item3['custom_title']; ?>" />
											<input name="custom_detail" type="hidden" class="input5" id="custom_detail" value="<?php echo $item3['custom_detail']; ?>" />
										</td>
									</tr>
									<tr>
										<td colspan="10" height="1" bgcolor="#e8e8e8"></td>
									</tr>
									<tr id="product_insert_field_4_<?php echo $j; ?>">
										<td colspan=2 height="40" align="center" class="t_border" bgcolor="f8f8f9" style="font-weight:bold;">장비매출가</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<input name="product_sales" type="text" class="input5" id="product_sales" value="<?php if(trim($item3['product_sales']) == ""){echo $item3['product_sales'];}else{ echo number_format($item3['product_sales']);} ?>" onclick="numberFormat(this);" onchange="numberFormat(this);product_profit_change(<?php echo $j; ?>);" /> 
										</td>
										<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">장비매입가</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<input name="product_purchase" type="text" class="input5" id="product_purchase" value="<?php if(trim($item3['product_purchase']) == ""){echo $item3['product_purchase'];}else{echo number_format($item3['product_purchase']);} ?>" onclick="numberFormat(this);" onchange="numberFormat(this);product_profit_change(<?php echo $j; ?>);" /> 
										</td>
										<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">장비마진</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<input name="product_profit" type="text" class="input5" id="product_profit" value="<?php if(trim($item3['product_profit']) == ""){echo $item3['product_profit'];}else{echo number_format($item3['product_profit']);} ?>" readonly /> 
										</td>
									</tr>
									<tr id="product_insert_field_<?php echo $j; ?>">
										<td colspan="10" height="2" bgcolor="#797c88"></td>
									</tr>

									<?php
									}
									$mb_cnt++;
									$max_number2 = $j;
									$j++;
									$i++;
									}

									// if(count($sub_project_add[0]) > 0){
									// 	echo "<tr id='product_insert_field_{$j}'><td colspan='10' height='40'  style='font-weight:bold;'>- 연계 프로젝트 제품</td></tr>";
									// }

									foreach($sub_project_add as $sub_project){
										foreach($sub_project as $sub){
									?>
									<tr id="product_insert_field_<?php echo $j; ?>" name="<?php echo $sub['sfSeq'];?>">
										<td colspan="10" bgcolor="#e8e8e8"></td>
									</tr>
									<tr>
										<td colspan=2 height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">프로젝트명</td>
										<td colspan=8 align="left" class="t_border" style="padding-left:10px;">
											<?php echo $sub['project_name'];?>(<?php echo $sub['exception_saledate'];?>)
										</td>
									</tr>
									<tr>
										<td colspan="10" height="1" bgcolor="#e8e8e8"></td>
									</tr>
									<tr id="product_insert_field_1_<?php echo $j; ?>" name="<?php echo $sub['sfSeq'];?>">
										<td colspan=2 height="40" align="center"  class="t_border" bgcolor="f8f8f9" style="font-weight:bold;">제조사</td>
										<td colspan=3 align="left" class="t_border" style="padding-left:10px;" colspan="1">
											<select name="product_company" id="product_company<?php echo $j-1; ?>" class="input2" onchange="subProductSearch(<?php echo $j-1; ?>);">
												<option value="">제조사</option>
												<?php foreach($product_company as $pc){
													echo "<option value='{$pc['product_company']}'";
													if($sub['product_company'] == $pc['product_company'] ){
														echo "selected";
													}
													echo ">{$pc['product_company']}</option>";
												}?>
											</select>
										</td>
										<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">하드웨어/소프트웨어</td>
										<td colspan=3 align="left" class="t_border" style="padding-left:10px;">
											<select name="product_type" id="product_type<?php echo $j-1; ?>" class="input2" onchange="subProductSearch(<?php echo $j-1; ?>);">
												<option value="" selected>전체</option>
												<option value="hardware" <?php if($sub['product_type'] == "hardware"){echo "selected"; }?>>하드웨어</option>
												<option value="software" <?php if($sub['product_type'] == "software"){echo "selected"; }?>>소프트웨어</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan="10" height="1" bgcolor="#e8e8e8"></td>
									</tr>
									<tr id="product_insert_field_2_<?php echo $j; ?>" name="<?php echo $sub['sfSeq'];?>">
										<td colspan=2 height="40" align="center" class="t_border" bgcolor="f8f8f9" style="font-weight:bold;">제품명</td>
										<td align="left" class="t_border" style="padding-left:10px;" colspan="1">
											<input type="hidden" name="sub_product_seq" id="sub_product_seq" value="<?php echo $sub['seq'];?>" readonly />
											<select name="sub_product_name" id="sub_product_name<?php echo $j-1; ?>" class="input7" onclick="subProductSearch(<?php echo $j-1; ?>);">
												<option value="<?php echo $sub['product_code'];?>" selected><?php echo $sub['product_name'];?></option>
											</select>
										</td>
										<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">라이선스</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<input type="text" class="input5" name="sub_product_licence" id="product_licence" value="<?php echo $sub['product_licence'];?>" onkeyup="commaCheck(this);" /> </td>
										<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">Serial</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<input type="text" class="input5" name="sub_product_serial" id="product_serial" value="<?php echo $sub['product_serial'];?>" onkeyup="commaCheck(this);" /> </td>
										<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">제품 상태</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<select name="sub_product_state" id="product_state<?php echo $j-1; ?>" class="input5">
												<option value="0">- 제품 상태 -</option>
												<option value="001" <?php if ($sub['product_state'] == "001") {echo "selected";} ?>>입고 전</option>
												<option value="002" <?php if ($sub['product_state'] == "002") {echo "selected";} ?>>창고</option>
												<option value="003" <?php if ($sub['product_state'] == "003") {echo "selected";} ?>>고객사 출고</option>
												<option value="004" <?php if ($sub['product_state'] == "004") {echo "selected";} ?>>장애반납</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan="10" height="1" bgcolor="#e8e8e8"></td>
									</tr>
									<tr id="product_insert_field_3_<?php echo $j; ?>" name="<?php echo $sub['sfSeq'];?>">
										<td colspan=2 height="40" align="center" class="t_border" bgcolor="f8f8f9" style="font-weight:bold;">장비유지보수시작일</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<input name="sub_maintain_begin" type="date" class="input7" id="maintain_begin" value="<?php echo $sub['maintain_begin'];?>" /> 
										</td>
										<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">장비유지보수만료일</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<input name="sub_maintain_expire" type="date" class="input7" id="maintain_expire" value="<?php echo $sub['maintain_expire'];?>" /> 
										</td>
										<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">유/무상</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<select name="sub_maintain_yn" id="maintain_yn<?php echo $j-1; ?>" class="input5">
												<option value="0">- 유/무상여부 -</option>
												<option value="Y" <?php if ($sub['maintain_yn'] == "Y") {echo "selected";} ?>>유상</option>
												<option value="N" <?php if ($sub['maintain_yn'] == "N") {echo "selected";} ?>>무상</option>
											</select>
										</td>
										<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">유지보수 대상</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<select name="sub_maintain_target" id="maintain_target<?php echo $j-1; ?>" class="input5">
												<option value="0">유지보수 대상</option>
												<option value="Y" <?php if ($sub['maintain_target'] == "Y") {echo "selected";} ?>>대상</option>
												<option value="N" <?php if ($sub['maintain_target'] == "N") {echo "selected";} ?>>비대상</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan="10" height="1" bgcolor="#e8e8e8"></td>
									</tr>
									<tr id="product_insert_field_4_<?php echo $j; ?>" name="<?php echo $sub['sfSeq'];?>">
										<td colspan=2 height="40" align="center" class="t_border" bgcolor="f8f8f9" style="font-weight:bold;">장비매출가</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<input type="text" name="sub_product_sales" class="input5" id="product_sales" value="<?php echo number_format($sub['product_sales']); ?>" onclick="numberFormat(this);" onchange="numberFormat(this);product_profit_change(<?php echo $j; ?>);" />
										</td>
										<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">장비매입가</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<input type="text" name="sub_product_purchase" class="input5" id="sub_product_purchase" value="<?php echo number_format($sub['product_purchase']);?>" onclick="numberFormat(this);" onchange="numberFormat(this);product_profit_change(<?php echo $j; ?>);" />
										</td>
										<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">장비마진</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<input type="text" name="sub_product_profit" class="input5" id="sub_product_profit" value="<?php echo number_format($sub['product_profit']); ?>" readonly />
										</td>
									</tr>
									<tr id="product_insert_field_<?php echo $j; ?>">
										<td colspan="10" height="2" bgcolor="#797c88"></td>
									</tr>
									<?php 
										$mb_cnt++;
										$max_number2 = $j;
										$j++;
										$i++;
										}
									} 
									?>
									<input type="hidden" id="row_max_index2" name="row_max_index2" value="<?php echo $max_number2 ;?>" />
									<tr>
										<td id="productEnd" colspan="10" height="0" bgcolor="#e8e8e8"></td>
									</tr>
									<tr>
										<td colspan=2 name=test height="40" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">고객사총매출가</td>
										<td name=test align="left" class="t_border" style="padding-left:10px;"><input name="forcasting_sales"
												type="text" class="input5" id="forcasting_sales"
												value="<?php echo number_format($view_val['forcasting_sales']); ?>"
												onchange="forcasting_profit_change();" /> </td>
										<td name=test height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">고객사총매입가
										</td>
										<td name=test align="left" class="t_border" style="padding-left:10px;"><input name="forcasting_purchase"
												type="text" class="input5" id="forcasting_purchase"
												value="<?php echo number_format($view_val['forcasting_purchase']); ?>"
												onchange="forcasting_profit_change();" /> </td>
										<td name=test height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">고객사총마진
										</td>
										<td name=test align="left" class="t_border" style="padding-left:10px;"><input name="forcasting_profit"
												type="text" class="input5" id="forcasting_profit"
												value="<?php echo number_format($view_val['forcasting_profit']); ?>" readonly /> </td>

										<!-- 선영테스트 -->
										<td colspan=2 name=sub height="40" class="t_border"align="center" bgcolor="f8f8f9" style="font-weight:bold;display:none">고객사총매출가</td>
										<td name=sub align="left" class="t_border" style="padding-left:10px; display:none"><input type="text"
												class="input5" id="sub_plus_forcasting_sales" value="" /> </td>
										<td name=sub height="40" align="center" bgcolor="f8f8f9" class="t_border"
											style="font-weight:bold; display:none">고객사총매입가</td>
										<td name=sub align="left" class="t_border" style="padding-left:10px; display:none"><input type="text"
												class="input5" id="sub_plus_forcasting_purchase" value="" /> </td>
										<td name=sub height="40" align="center" bgcolor="f8f8f9" class="t_border"
											style="font-weight:bold; display:none">고객사총마진</td>
										<td name=sub align="left" class="t_border" style="padding-left:10px; display:none"><input type="text"
												class="input5" id="sub_plus_forcasting_profit" value="" readonly /> </td>
										<!-- 선영테스트끝 -->

										<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">분할월수</td>
										<td colspan="3" align="left" class="t_border" style="padding-left:10px;"><select name="division_month"
												id="division_month" class="input5" onchange="monthDivision()">
												<option value="12" <?php if ($view_val['division_month'] == "12") {
																echo "selected";
															} ?>>당월</option>
												<option value="6" <?php if ($view_val['division_month'] == "6") {
																echo "selected";
															} ?>>반기별</option>
												<option value="3" <?php if ($view_val['division_month'] == "3") {
																echo "selected";
															} ?>>분기별</option>
												<option value="month" <?php if ($view_val['division_month'] == "1" || substr($view_val['division_month'], 0, 1) === "m") {
																	echo "selected";
																} ?>>월별</option>
												<input type="text" name="monthly_input" id="monthlyInput" onchange="month()"></input>
												<div id="month" style="float:right">개월<div>
										</td>
									</tr>

									<tr>
										<td colspan=2 height="40" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">고객사유지보수시작일</td>
										<td align="left" class="t_border" style="padding-left:10px;"><input name="exception_saledate2" type="date"
												class="input7" id="exception_saledate2" value="<?php echo $view_val['exception_saledate2']; ?>" />
										</td>
										<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">고객사유지보수종료일</td>
										<td align="left" class="t_border" style="padding-left:10px;"><input name="exception_saledate3" type="date"
												class="input7" id="exception_saledate3" value="<?php echo $view_val['exception_saledate3']; ?>" />
										</td>
										<!-- <td align="left"  colspan="7" ><img src="<?php echo $misc; ?>img/btn_calendar.jpg" /></td> -->
										<!-- <td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">점검일자</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<input name="maintain_date" type="date" class="input7" id="maintain_date" value="<?php echo $view_val['maintain_date']; ?>" />
										</td>
										<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">점검자</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<input name="maintain_user" type="text" class="input5" id="maintain_user" value="<?php echo $view_val['maintain_user']; ?>" />
										</td> -->
									</tr>
									<tr>
										<td colspan="10" height="2" bgcolor="#797c88"></td>
									</tr>
									<tr>
										<td height=0></td>
									</tr>
									<?php }else{?>
									<tr>
										<td height="40" style="font-weight:bold;font-size:13px;">수주 정보</td>
									</tr>
									<tr>
										<td colspan="10" height="2" bgcolor="#797c88"></td>
									</tr>
									<tr>
										<td height="40" align="center" class="t_border" bgcolor="f8f8f9" style="font-weight:bold;">수주여부</td>
										<td colspan="3" align="left" class="t_border" style="padding-left:10px;">
											<select name="complete_status" id="complete_status" class="input2">
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
										<td colspan="10" height="1" bgcolor="#e8e8e8"></td>
									</tr>
									<!-- <tr>
										<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">점검방법</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<select name="maintain_type" id="maintain_type" class="input2">
												<option value="9" selected>- 점검방법선택 -</option>
												<option value="1" <?php if ($view_val['maintain_type'] == "1") {
																echo "selected";
															} ?>>방문점검</option>
												<option value="2" <?php if ($view_val['maintain_type'] == "2") {
																echo "selected";
															} ?>>원격점검</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan="10" height="1" bgcolor="#e8e8e8"></td>
									</tr>
									<tr>
										<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">점검여부</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<select name="maintain_result" id="maintain_result" class="input2">
												<option value="9" selected>- 점검여부선택 -</option>
												<option value="1" <?php if ($view_val['maintain_result'] == "1") {
																echo "selected";
															} ?>>완료</option>
												<option value="0" <?php if ($view_val['maintain_result'] == "0") {
																echo "selected";
															} ?>>미완료</option>
												<option value="2" <?php if ($view_val['maintain_result'] == "2") {
																echo "selected";
															} ?>>미해당</option>
												<option value="9" <?php if ($view_val['maintain_result'] == "9") {
																echo "selected";
															} ?>>예정</option>
											</select>
										</td>
									</tr> -->
									<tr>
										<td colspan="10" height="2" bgcolor="#797c88"></td>
									</tr>
									<?php } ?>

								</form>
							</table>
    					</td>
    				</tr>
					<tr>
						<td height="10"></td>
					</tr>
    <!--버튼-->
					<tr>
						<td align="right">
							<!-- <img src="<?php echo $misc; ?>img/btn_list.jpg" width="64" height="31" style="cursor:pointer"onClick="javascript:history.go(-1)" />  -->
							<input type="image" src="<?php echo $misc; ?>img/btn_adjust.jpg" width="64" height="31" style="cursor:pointer" onclick="javascript:chkForm();sub_project_add_update();sub_project_remove_update(); return false; " />
							<!-- <img src="<?php echo $misc; ?>img/btn_delete.jpg" width="64" height="31" style="cursor:pointer" border="0" onclick="javascript:chkDel();return false;" /></td> -->
					</tr>
    <!--//버튼-->
					<tr>
						<td>&nbsp;</td>
					</tr>
				</table>
			</td>
    	</tr>
    </table>
    <script src="//cdnjs.cloudflare.com/ajax/libs/babel-standalone/6.26.0/babel.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/babel-polyfill/7.4.3/polyfill.js"></script>
    <script type="text/babel" data-presets="es2015, stage-3">
        var mb_cnt = Number($("#row_max_index2").val());

      //조회 추가 됐을 때 기존의 고객사총매출가를 안보이게하고 새로 추가
		if ($("input[name=sub_product_sales]").length > 0) {
			var subProductSales = 0;
			var subProductPurchase=0;
			var subProductProfit=0;
			for (var i = 0; i < document.getElementsByName("sub_product_sales").length; i++) {
				subProductSales += parseInt(document.getElementsByName("sub_product_sales")[i].value.replace(/,/g, ""));
				subProductPurchase += parseInt(document.getElementsByName("sub_product_purchase")[i].value.replace(/,/g, ""));
				subProductProfit += parseInt(document.getElementsByName("sub_product_profit")[i].value.replace(/,/g, ""));
				
			}
			$("td[name=test]").css("display", "none");
			$("td[name=sub]").css("display", "");
		
			$("#sub_plus_forcasting_sales").val((<?php echo $view_val['forcasting_sales']; ?> + subProductSales).toString().replace(/(\d)(?=(?:\d{3})+(?!\d))/g, "$1,"));
			$("#sub_plus_forcasting_purchase").val((<?php echo $view_val['forcasting_purchase']; ?> + subProductPurchase).toString().replace(/(\d)(?=(?:\d{3})+(?!\d))/g, "$1,"));
			$("#sub_plus_forcasting_profit").val((<?php echo $view_val['forcasting_profit']; ?> + subProductProfit).toString().replace(/(\d)(?=(?:\d{3})+(?!\d))/g, "$1,"));
		}

		//select box 검색 기능
		$("select[name=product_company]").select2();
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

		//수정 누르기 전에 조회추가를 눌렀을 때 보이는 모습
		function subProjectAdd(){
			var subProjectSeq = $("#sub_project_add").val();
			var subProjectName = $("#sub_project_add option:checked").text();

			if ($("#subProjectAddInput").val() == "") {
				$("#subProjectAddInput").val(subProjectSeq);
			} else {
				$("#subProjectAddInput").val($("#subProjectAddInput").val() + "," + subProjectSeq);
			}

			$.ajax({
				type: "POST",
				cache: false,
				url: "<?php echo site_url(); ?>/tech/maintain/subProjectAdd",
				dataType: "json",
				async: false,
				data: {
					subProjectSeq: subProjectSeq
				},
				success: function(data) {
					for (var i = 0; i < data.length; i++) {	
						$("#row_max_index2").before(
							`<tr id="product_insert_field_1_${mb_cnt+1}" name="${subProjectSeq}"><td colspan="10" height="5" bgcolor="#e8e8e8"></td></tr><tr id="product_insert_field_2_${mb_cnt+1}" name="${subProjectSeq}"><td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">제품명</td><td align="left" class="t_border" style="padding-left:10px;">
						<input type="text" class="input7" value="${data[i].product_name}" readonly/>
						<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">라이선스</td>
						<td align="left" class="t_border" style="padding-left:10px;"><input  type="text" class="input5" id="product_licence" value="${data[i].product_licence}" readonly /> </td>
						<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">Serial</td>
						<td align="left" class="t_border" style="padding-left:10px;"><input type="text" class="input5" id="product_serial" value="${data[i].product_serial}" readonly/> </td>
						<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">제품 상태</td><td align="left" class="t_border" style="padding-left:10px;" readonly>
						<select id="product_state${mb_cnt}" class="input5" disabled>
							<option value="0">- 제품 상태 -</option>
							<option value="001">입고 전</option>
							<option value="002">창고</option>
							<option value="003">고객사 출고</option>
							<option value="004">장애반납</option>
						</select>
						</td>
						</tr>
						<tr id="product_insert_field_3_${mb_cnt+1}" name="${subProjectSeq}">
							<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">장비유지보수시작일</td>
							<td align="left" class="t_border" style="padding-left:10px;"><input type="date" class="input7" id="maintain_begin" value="${data[i].maintain_begin}" readonly /> </td>
							<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">장비유지보수만료일</td>
							<td align="left" class="t_border" style="padding-left:10px;"><input type="date" class="input7" id="maintain_expire" value="${data[i].maintain_expire}" readonly /> </td>
							<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">유/무상</td>
							<td align="left" class="t_border" style="padding-left:10px;">
								<select id="maintain_yn${mb_cnt}" class="input5" disabled>
									<option value="0">- 유/무상여부 -</option>
									<option value="Y">유상</option>
									<option value="N">무상</option>
								</select></td>
								<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">유지보수 대상</td>
								<td align="left" class="t_border" style="padding-left:10px;">
									<select id="maintain_target${mb_cnt}" class="input5" disabled>
										<option value="0">유지보수 대상</option>
										<option value="Y">대상</option>
										<option value="N">비대상</option>
									</select>
								</td>
							<input type="hidden" class="input5" id="product_version" value="${data[i].product_version}" />
							<input type="hidden" class="input5" id="product_check_list" value="${data[i].product_check_list}" />
							<input type="hidden" class="input5" id="custom_title" value="${data[i].custom_tilte}" />
							<input  type="hidden" class="input5" id="custom_detail" value="${data[i].custom_detail}" />
						</tr>

						<tr id="product_insert_field_4_${mb_cnt+1}" name="${subProjectSeq}">
							<td height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">장비매출가</td>
							<td align="left" class="t_border" style="padding-left:10px;"><input type="text" class="input5" id="product_sales" value="${data[i].product_sales.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, "$1,")}" onclick="numberFormat(this);" onchange="numberFormat(this);product_profit_change(${mb_cnt+1});" readonly/> </td>
							<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">장비매입가</td>
							<td align="left" class="t_border" style="padding-left:10px;"><input type="text" class="input5" id="product_purchase" value="${data[i].product_purchase.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, "$1,")}" onclick="numberFormat(this);" onchange="numberFormat(this);product_profit_change(${mb_cnt+1});" readonly/> </td>
							<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">장비마진</td>
							<td align="left" class="t_border" style="padding-left:10px;"><input type="text" class="input5" id="product_profit" value="${data[i].product_profit.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, "$1,")}" readonly /> </td>
							<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">프로젝트명</td>
							<td align="left" class="t_border" style="padding-left:10px;"><input type="text" class="input2" id="project_name2" value="${data[i].project_name}(${data[i].exception_saledate})" readonly /> </td>
						</tr>`
						);
						$(`#product_state${mb_cnt}`).val(data[i].product_state).prop("selected", true);
						$(`#product_state${mb_cnt} option[value!= ${data[i].product_state}]`).remove();
						$(`#maintain_yn${mb_cnt}`).val(data[i].maintain_yn).prop("selected", true);
						$(`#maintain_yn${mb_cnt} option[value!= ${data[i].maintain_yn}]`).remove();
						$(`#maintain_target${mb_cnt}`).val(data[i].maintain_target).prop("selected", true);
						$(`#maintain_target${mb_cnt} option[value!= ${data[i].maintain_target}]`).remove();
						mb_cnt++;
					}
					$(`#sub_project_add option[value='${subProjectSeq}']`).remove();
					$(`#sub_project_remove option:eq(0)`).after(`<option value='${subProjectSeq}'>${subProjectName}</option>`);

					if (($("#subProjectRemoveInput").val()).indexOf(subProjectSeq) != -1) {
						if (($("#subProjectRemoveInput").val()).indexOf("," + subProjectSeq) != -1) {
							var subProjectRemoveInput = ($("#subProjectRemoveInput").val()).replace("," + subProjectSeq, "");
							$("#subProjectRemoveInput").val(subProjectRemoveInput);
						} else {
							var subProjectRemoveInput = ($("#subProjectRemoveInput").val()).replace(subProjectSeq, "");
							if (subProjectRemoveInput.charAt(0) == ',') {
								subProjectRemoveInput = subProjectRemoveInput.substring(1);
							}
							$("#subProjectRemoveInput").val(subProjectRemoveInput);
						}
					}		
				}
			});
		}

		//조회취소 눌렀을 때
		function subProjectRemove() {
			var subProjectSeq = $("#sub_project_remove").val();
			var subProjectName = $("#sub_project_remove option:checked").text();
			$(`tr[name=${subProjectSeq}]`).remove();
			$(`#sub_project_remove option[value='${subProjectSeq}']`).remove();
			$(`#sub_project_add option:eq(0)`).after(`<option value='${subProjectSeq}'>${subProjectName}</option>`);
			if($("#subProjectRemoveInput").val() == "") {
				$("#subProjectRemoveInput").val($("#subProjectRemoveInput").val() + subProjectSeq)
			}else{
				$("#subProjectRemoveInput").val($("#subProjectRemoveInput").val() + ',' + subProjectSeq);
			}

			if (($("#subProjectAddInput").val()).indexOf(subProjectSeq) != -1) {
				if (($("#subProjectAddInput").val()).indexOf("," + subProjectSeq) != -1) {
					var subProjectAddInput = ($("#subProjectAddInput").val()).replace("," + subProjectSeq, "");
					$("#subProjectAddInput").val(subProjectAddInput);
				} else {
					var subProjectAddInput = ($("#subProjectAddInput").val()).replace(subProjectSeq, "");
					if (subProjectAddInput.charAt(0) == ',') {
						subProjectAddInput = subProjectAddInput.substring(1);
					}
					$("#subProjectAddInput").val(subProjectAddInput);
				}
			}
		}


		//조회 추가 후 수정버튼을 누르면 자식,부모 sub_project_add컬럼에 자식seq가 들어감
		function sub_project_add_update() {
			var subProjectSeq = $("#subProjectAddInput").val();
			var subSplit = subProjectSeq.split(",");
			for (var i = 0; i < subSplit.length; i++) {
				$.ajax({
					type: "POST",
					cache: false,
					url: "<?php echo site_url(); ?>/tech/maintain/sub_project_add_update",
					dataType: "json",
					async: false,
					data: {
						seq: subSplit[i],
						subProjectSeq: subProjectSeq
					},
					success: function(data) {
					}
				})
			}
		}

		//조회 취소 후 수정버튼을 누르면 자식,부모 sub_project_add컬럼에 null 값 들어감
		function sub_project_remove_update() {
			var subProjectSeq = $("#subProjectRemoveInput").val();
			var subSplit = subProjectSeq.split(",");
			for (var i = 0; i < subSplit.length; i++) {
				$.ajax({
					type: "POST",
					cache: false,
					url: "<?php echo site_url(); ?>/tech/maintain/sub_project_remove_update",
					dataType: "json",
					async: false,
					data: {
						seq: subSplit[i],
						subProjectSeq: subProjectSeq
					},
					success: function(data) {
					}
				})
			}
		}

		function productSearch(idx) {
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

		function subProductSearch(idx) {
			console.log(idx)
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
					console.log(data)
					var html = "<option value=''>제품선택</option>";
					for (i = 0; i < data.length; i++) {
						html += "<option value ='" + data[i].seq + "'>" + data[i].product_name + "</option>";
					}
					$("#sub_product_name" + idx).html(html);
					$("#sub_product_name" + idx).select2();
				}
			});
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
	var row=0;
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


	//콤마제거
	function commaCheck(obj){
		if(($(obj).val()).indexOf(',') != -1){
			alert(', 를 입력하실 수 없습니다.');
			$(obj).val($(obj).val().replace(',',''));
		}
	}
	</script>
</body>

</html>