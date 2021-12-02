<?php
include $this->input->server('DOCUMENT_ROOT') . "/include/base.php";
include $this->input->server('DOCUMENT_ROOT') . "/include/sales_top.php";
// $max_number = '';
?>
<style type="text/css">
   .basic_td{
      border:1px solid;
      border-color:#d7d7d7;
      padding:0px 10px 0px 10px;
   }
   .basic_table{
      border-collapse:collapse;
      border:1px solid;
      border-color:#d7d7d7;
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
        mform.action = "<?php echo site_url(); ?>/maintain/maintain_delete_action";
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
		var objpurchase_pay_session = document.getElementsByName("purchase_pay_session");

		if (objmain_companyname.length > 1) {
			for (var i = 0; i < objmain_companyname.length; i++) {
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
			for (var i = 0; i < objmain_seq.length; i++) {
				$("#update_main_array").val($("#update_main_array").val() + "||" + objmain_companyname[i].value + "~" + objmain_username[i].value + "~" + objmain_tel[i].value + "~" + objmain_email[i].value + "~" + objpurchase_pay_session[i].value +"~"+ objmain_seq[i].value );
			}
		}

		$("#insert_main_array").val('');
		if (objmain_companyname.length > objmain_seq.length) {
			for (var i = objmain_seq.length; i < objmain_companyname.length; i++) { 
				$("#insert_main_array").val($("#insert_main_array").val() + "||" +"<?php echo $view_val['forcasting_seq'];?>" + "~" +objmain_companyname[i].value + "~" + objmain_username[i].value + "~" + objmain_tel[i].value + "~"+ objmain_email[i].value +"~"+objpurchase_pay_session[i].value);
			}
		}
	}else if("<?php echo $_GET['type'] ;?>" == "5"){// 제품 정보
		var objproduct_seq = document.getElementsByName("product_seq");
		var objproduct_name = document.getElementsByName("product_name");
		var objproduct_supplier = document.getElementsByName("product_supplier");
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

		if (objproduct_maintain_begin.length > 0) {
			for (var i = 0; i < objproduct_maintain_begin.length; i++) {
				if ($.trim(objproduct_maintain_begin[i].value) == "0000-00-00" || $.trim(objproduct_maintain_begin[i].value) == "") {
					alert('장비 유지보수 시작일을 입력해주세요.');
					objproduct_maintain_begin[i].focus();
					return;
				}

				if ($.trim(objproduct_maintain_expire[i].value) == "0000-00-00" || $.trim(objproduct_maintain_expire[i].value) == ""){
					alert('장비 유지보수 만료일을 입력해주세요.');
					objproduct_maintain_expire[i].focus();
					return;
				}
			}
		}

		if (objproduct_name.length > 0) {
			for (var i = 0; i < objproduct_name.length; i++) {
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

		if (mform.exception_saledate3.value == "") {
			mform.exception_saledate3.focus();
			alert("유지보수 만료일을 선택해 주세요.");
			return false;
		}

		///////////////// 유지보수 날짜 수정 됐을때(만료일만)

		if('<?php echo $view_val['exception_saledate3']; ?>' != $("#exception_saledate3").val()){
			if('<?php echo $view_val['exception_saledate3']; ?>' != ""){
				$("#update_exception_saledate3").val('<?php echo $view_val['exception_saledate3']; ?>');
			}else{
				$("#update_exception_saledate3").val('new');
			}
		}

		// 끝
		$("#update_product_array").val('');
		if (objproduct_seq.length > 0) {
			for (var i = 0; i < objproduct_seq.length; i++) {
				$("#update_product_array").val($("#update_product_array").val() + "||" + objproduct_name[i].value +"~"+objproduct_supplier[i].value+
					"~" + objproduct_licence[i].value + "~" + objproduct_serial[i].value + "~" + objproduct_state[i]
					.value + "~" + objproduct_maintain_begin[i].value.split(' ')[0] + "~" +
					objproduct_maintain_expire[i].value.split(' ')[0] + "~" + objproduct_maintain_yn[i].value +
					"~" + objproduct_maintain_target[i].value + "~" + objproduct_product_sales[i].value.replace(/,/g, "") + "~" + objproduct_product_purchase[i].value.replace(/,/g, "") + "~" +
					objproduct_product_profit[i].value.replace(/,/g, "") + "~" + objproduct_seq[i].value);
			}
		}

		$("#insert_product_array").val('');
		if (objproduct_name.length > objproduct_seq.length) {
			for (i = objproduct_seq.length; i < objproduct_name.length; i++) {
				$("#insert_product_array").val($("#insert_product_array").val() + "||" +"<?php echo $_GET['seq']; ?>"+"~"+"<?php echo $_GET['seq']; ?>"+"~"+"<?php echo $view_val['forcasting_seq']; ?>"+"~"+ objproduct_name[i].value + "~"+objproduct_supplier[i].value + "~" + objproduct_licence[i].value + "~" + objproduct_serial[i].value + "~" + objproduct_state[i].value + "~"
				 + objproduct_maintain_begin[i].value.split(' ')[0] + "~" + objproduct_maintain_expire[i].value.split(' ')[0] + "~" + objproduct_maintain_yn[i].value + "~" + objproduct_maintain_target[i].value + "~" + 
				+ objproduct_product_sales[i].value.replace(/,/g, "") + "~" + objproduct_product_purchase[i].value.replace(/,/g, "") + "~" + objproduct_product_profit[i].value.replace(/,/g, ""));
			}
		}
	}else if("<?php echo $_GET['type'] ;?>" == "6"){ //수주 정보
		if (mform.complete_status.value == "0") {
			mform.complete_status.focus();
			alert("수주여부를 선택해 주세요.");
			return false;
		}
	}else if ("<?php echo $_GET['type'] ;?>" == "8"){ //계산서 발행 정보
		// insert
		var insertObject = new Object();
		var insert_bill_total = [];
		if($(".insert_sales_bill").length > 0 || $(".insert_purchase_bill").length > 0){
			var i = 0;
			for (i = 0; i < $(".insert_sales_bill").length; i++) {
				var type = "001";
				var company_name = "<?php echo $view_val['sales_companyname']; ?>";
				var pay_session = $(".insert_sales_bill").eq(i).find('input[name=pay_session]').val();
				var issuance_amount = $(".insert_sales_bill").eq(i).find('input[name=sales_issuance_amount]').val();
				var tax_approval_number = $(".insert_sales_bill").eq(i).find('input[name=sales_tax_approval_number]').val();
				var issuance_month = $(".insert_sales_bill").eq(i).find('input[name=sales_issuance_month]').val();
				var issuance_date = $(".insert_sales_bill").eq(i).find('input[name=sales_issuance_date]').val();
				var issuance_status = $(".insert_sales_bill").eq(i).find('input[name=sales_issuance_status]').val();
				var deposit_date = $(".insert_sales_bill").eq(i).find('input[name=sales_deposit_date]').val();
				var deposit_status = $(".insert_sales_bill").eq(i).find('input[name=sales_deposit_status]').val();
				insert_bill_total[i] = type+"||"+company_name+"||"+pay_session+"||"+issuance_amount+"||"+tax_approval_number+"||"+issuance_month+"||"+issuance_date+"||"+issuance_status+"||"+deposit_date+"||"+deposit_status;
			}

			for(var j=0; j< $(".insert_purchase_bill").length; j++){
				var type = "002";
				// var company_name = Number(trim($(".insert_purchase_bill").eq(j).attr("class").replace("purchase_tax_invoice",'').replace('insert_purchase_bill','')))-1;
				// company_name = $('input[name=purchase_company_name]').eq(company_name).val();
				var company_name = $(".insert_purchase_bill").eq(j).find('input[name=purchase_company_name]').val();
				var pay_session = $(".insert_purchase_bill").eq(j).find('input[name=pay_session]').val();
				var issuance_amount = $(".insert_purchase_bill").eq(j).find('input[name=purchase_issuance_amount]').val();
				var tax_approval_number = $(".insert_purchase_bill").eq(j).find('input[name=purchase_tax_approval_number]').val();
				var issuance_month = $(".insert_purchase_bill").eq(j).find('input[name=purchase_issuance_month]').val();
				var issuance_date = $(".insert_purchase_bill").eq(j).find('input[name=purchase_issuance_date]').val();
				var issuance_status = $(".insert_purchase_bill").eq(j).find('input[name=purchase_issuance_status]').val();
				var deposit_date = $(".insert_purchase_bill").eq(j).find('input[name=purchase_deposit_date]').val();
				var deposit_status = $(".insert_purchase_bill").eq(j).find('input[name=purchase_deposit_status]').val();
				insert_bill_total[i] = type+"||"+company_name+"||"+pay_session+"||"+issuance_amount+"||"+tax_approval_number+"||"+issuance_month+"||"+issuance_date+"||"+issuance_status+"||"+deposit_date+"||"+deposit_status;
				i++;
			}
			insertObject.value = insert_bill_total;
			insert_bill_total = JSON.stringify(insertObject);
			
			$('#insert_bill_array').val(insert_bill_total);

		}
		
		//update
		var updateObject = new Object();
		var update_bill_total = [];
		if($("#update_seq").val() != ""){
			var update_seq = $("#update_seq").val().split(',');
			update_seq = Array.from(new Set(update_seq));
			var mode ='';
			for (var i = 0; i < update_seq.length; i++) {
				var seq = update_seq[i];
				if($("#bill_"+seq).attr("class").indexOf("purchase") != -1 ){
					mode = "purchase";
				}else{
					mode = "sales";
				}
				var pay_session = $("#bill_"+seq).find('input[name=pay_session]').val();
				var issuance_amount = $("#bill_"+seq).find('input[name='+mode+'_issuance_amount]').val();
				var tax_approval_number = $("#bill_"+seq).find('input[name='+mode+'_tax_approval_number]').val();
				var issuance_month = $("#bill_"+seq).find('input[name='+mode+'_issuance_month]').val();
				var issuance_date = $("#bill_"+seq).find('input[name='+mode+'_issuance_date]').val();
				var issuance_status = $("#bill_"+seq).find('input[name='+mode+'_issuance_status]').val();
				var deposit_date = $("#bill_"+seq).find('input[name='+mode+'_deposit_date]').val();
				var deposit_status = $("#bill_"+seq).find('input[name='+mode+'_deposit_status]').val();
				update_bill_total[i] = seq +"||"+pay_session+"||"+issuance_amount+"||"+tax_approval_number+"||"+issuance_month+"||"+issuance_date+"||"+issuance_status+"||"+deposit_date+"||"+deposit_status;
			}
			updateObject.value = update_bill_total;
			update_bill_total = JSON.stringify(updateObject);
			
			$('#update_bill_array').val(update_bill_total);

		}
		
		//매출발행금액이 총매출금액과 같은지
		var sales_total_issuance_amount = 0;
		for(var i=0; i<$('input[name=sales_issuance_status]').length; i++){
			if($('input[name=sales_issuance_status]').eq(i).val()== "Y"){
				sales_total_issuance_amount += Number($('input[name=sales_issuance_amount]').eq(i).val().replace(/,/g, ""));
			}
		}

		if(sales_total_issuance_amount == <?php echo $view_val['forcasting_sales']; ?>){
			$("#sales_total_issuance_amount").val(1);
		}

		var sales_total_deposit_amount = 0;
		for(var i=0; i<$('input[name=sales_deposit_status]').length; i++){
			if($('input[name=sales_deposit_status]').eq(i).val() == "Y"){
				sales_total_deposit_amount += Number($('input[name=sales_issuance_amount]').eq(i).val().replace(/,/g, ""));
			}
		}

		if(sales_total_deposit_amount == <?php echo $view_val['forcasting_sales']; ?>){
			$("#sales_total_issuance_amount").val(2);
		}
	}

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

    rform.action = "<?php echo site_url(); ?>/maintain/maintain_comment_action";
    rform.submit();
    return false;
}

function chkForm3(seq) {
    if (confirm("정말 삭제하시겠습니까?") == true) {
        var rform = document.rform;
        rform.cseq.value = seq;
        rform.action = "<?php echo site_url(); ?>/maintain/maintain_comment_delete";
        rform.submit();
        return false;
    }
}
</script>
<body>
    <table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" style="margin-left:30px;">
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
                                <form name="cform" action="<?php echo site_url(); ?>/maintain/maintain_input_action"
                                    method="post" onSubmit="javascript:chkForm();return false;">
									<input type="hidden" id="insert_main_array" name="insert_main_array" />
                                    <input type="hidden" id="update_main_array" name="update_main_array" />
                                    <input type="hidden" id="delete_main_array" name="delete_main_array" />
                                    <input type="hidden" id="update_product_array" name="update_product_array" />
									<input type="hidden" id="insert_product_array" name="insert_product_array" />
									<input type="hidden" id="delete_product_array" name="delete_product_array" />
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
                                            <!-- <input type="hidden" name="subProjectAddInput" id="subProjectAddInput" value='<?php echo $view_val['sub_project_add'] ?>'></input> -->
                                            <input type="hidden" name="subProjectAddInput" id="subProjectAddInput" value=''></input>
											<input type="hidden" id="subProjectRemoveInput" name="subProjectRemoveInput" value='' />
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
												foreach ($sub_project_cancel as $val) {
													echo '<option value="' . $val['seq'] . '">'. $val['customer_companyname'].'-' . $val['project_name'] . '</option>';
												}
												?>
                                            </select>
                                        </td>
									</tr>
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
                                                <option value="0" selected>담당팀선택</option>
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
											<select name="maintain_cycle" id="maintain_cycle" class="input2">
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
												<option value="" selected>- 점검여부선택 -</option>
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
                                        <td colspan="10" height="1" bgcolor="#e8e8e8"></td>
                                    </tr>
									<tr>
                                        <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">납부회차</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<input name="sales_pay_session" type="text" class="input7" id="sales_pay_session" value="<?php echo $view_val['sales_pay_session']; ?>" />
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
											<td colspan=4 align="right">
												<img src="<?php echo $misc; ?>img/btn_add.jpg" id="main_add" name="main_add" style="cursor:pointer;" />
											</td>
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
											<td colspan="10" height="1" bgcolor="#e8e8e8"></td>
										</tr>
										<tr class="main_insert_field_<?php echo $i; ?>">
											<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">납부회차</td>
											<td align="left" class="t_border" style="padding-left:10px;">
												<input name="purchase_pay_session" type="text" class="input5" value="<?php echo $item2['purchase_pay_session']; ?>"/>
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
											<td align="right">
												<img src="<?php echo $misc; ?>img/btn_del0.jpg" onclick='javascript:main_list_del(<?php echo $i; ?>,<?php echo $item2["seq"]; ?>);' style="cursor:pointer;" />
											</td>
										</tr>
										<tr class="main_insert_field_<?php echo $i; ?>">
											<td colspan="10" height="1" bgcolor="#e8e8e8"></td>
										</tr>
										<tr class="main_insert_field_<?php echo $i; ?>">
											<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">납부회차</td>
											<td align="left" class="t_border" style="padding-left:10px;">
												<input name="purchase_pay_session" type="text" class="input5" value="<?php echo $item2['purchase_pay_session']; ?>"/>
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
									<tr>
										<td colspan=10 height="40" align="left" style="padding:30px 0px 30px 0px;">
										<div style="background-color:#f8f8f9;padding:10px 0px 10px 10px;">
										<span style="font-weight:bold;">* 일괄적용</span><br>
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
													<td>제품명</td>
													<td>
														<select id="check_product_name" class="input7" onclick="productSearch('check');">
															<option value="" selected>제조사를 선택해주세요</option>
														</select>
													</td>
													<td>
														<input type="button" class="input7" value="선택적용" onclick="collectiveApplication('product_name',2);" style="margin-right:30px;" />
													</td>
													<td>제품상태</td>
													<td>
														<select id="check_product_state" class="input7">
															<option value="0">- 제품 상태 -</option>
															<option value="001">입고 전</option>
															<option value="002">창고</option>
															<option value="003">고객사 출고</option>
															<option value="004">장애반납</option>
														</select>
													</td>
													<td>
														<input type="button" class="input7" value="선택적용" onclick="collectiveApplication('product_state',1);" style="margin-right:30px;" />
													</td>
												</tr>
												<tr>
													<td>장비유지보수시작일</td>
													<td><input type="date" id="check_maintain_begin" class="input7" ></td>
													<td><input type="button" class="input7" value="선택적용" onclick="collectiveApplication('maintain_begin',0);" style="margin-right:30px;" /></td>
													<td>장비유지보수만료일</td>
													<td><input type="date" id="check_maintain_expire" class="input7" ></td>
													<td><input type="button" class="input7" value="선택적용" onclick="collectiveApplication('maintain_expire',0);" style="margin-right:30px;" /></td>
												</tr>
												<tr>
													<td>유/무상</td>
													<td>
														<select id="check_maintain_yn" class="input5" >
															<option value="0">- 유/무상여부 -</option>
															<option value="Y">유상</option>
															<option value="N">무상</option>
														</select>
													</td>
													<td><input type="button" class="input7" value="선택적용" onclick="collectiveApplication('maintain_yn',1);" style="margin-right:30px;" /></td>
													<td>유지보수 대상</td>
													<td>
														<select id="check_maintain_target" class="input5" >
															<option value="0">유지보수 대상</option>
															<option value="Y">대상</option>
															<option value="N">비대상</option>
														</select>
													</td>
													<td><input type="button" class="input7" value="선택적용" onclick="collectiveApplication('maintain_target',1);" style="margin-right:30px;" /></td>
												</tr>
												<tr>
													<td>유지보수매출가</td>
													<td><input type="text" class="input2" id="check_product_sales" value=0 onclick="numberFormat(this);" onchange="numberFormat(this);" /></td>
													<td><input type="button" class="input7" value="선택적용" onclick="collectiveApplication('product_sales',0);" style="margin-right:30px;" /></td>
													<td>유지보수매입가</td>
													<td><input type="text" class="input2" id="check_product_purchase" value=0 onclick="numberFormat(this);" onchange="numberFormat(this);" /></td>
													<td><input type="button" class="input7" value="선택적용" onclick="collectiveApplication('product_purchase',0);" style="margin-right:30px;" /></td>
													<!-- <td><input type="button" class="input5" value="선택적용" onclick="collectiveApplication('maintain_target',1);" style="margin-right:30px;" /></td> -->
												</tr>
											</table>
										</div>
										
										
											<!-- 매입처
											<select id="check_product_supplier" class="input2">
											<?php foreach($view_val2 as $item2){
												echo "<option value='{$item2['main_companyname']}'";
												if($item3['product_supplier'] == $item2['main_companyname']){
													echo "selected";
												}
												echo ">{$item2['main_companyname']}</option>";
											}?>
											</select>
											<input type="button" class="input5" value="선택적용" onclick="collectiveApplication('product_supplier',1);" style="margin-right:30px;" /> -->
											
											<!-- 장비매출가
											<input type="text" class="input2" id="check_product_sales" onclick="numberFormat(this);" onchange="numberFormat(this);" />
											<input type="button" class="input5" value="선택적용" onclick="collectiveApplication('product_sales',0);" style="margin-right:30px;" />
											장비매입가
											<input type="text" class="input2" id="check_product_purchase" onclick="numberFormat(this);" onchange="numberFormat(this);" />
											<input type="button" class="input5" value="선택적용" onclick="collectiveApplication('product_purchase',0);" style="margin-right:30px;" /> -->
										</td>
									</tr>
									<tr>
										<td colspan=9 align="left"><input type="checkbox" id="allCheck" />&nbsp;전체 * 일괄적용을 위한 선택입니다. </td>
										<td align="right"><img src="<?php echo $misc; ?>img/btn_add.jpg" id="product_add" name="product_add" style="cursor:pointer;" /></td>
									</tr>
                                    <tr id="product_insert_field_<?php echo $j; ?>">
                                        <td colspan="10" height="2" bgcolor="#797c88"></td>
									</tr>
									<tr id="product_insert_field_0_<?php echo $j; ?>">
										<td colspan=2 height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;"><input type="checkbox" name="product_row" value="0" style="float:left;" />프로젝트명</td>
										<td colspan=3 align="left" class="t_border" style="padding-left:10px;">
											<!-- <input type="hidden" id="update_exception_saledate2" name="update_exception_saledate2" /> -->
											<input type="hidden" id="update_exception_saledate3" name="update_exception_saledate3" />
											<input type="hidden" id="update_produce_saledate" name="update_produce_saledate" />
											<input type="hidden" name="customer_companyname" class="input7" id="customer_companyname" value="<?php echo $view_val['customer_companyname']; ?>" />
											<input type="hidden" name="project_name" class="input7" id="project_name" value="<?php echo $view_val['project_name']; ?>" />
											<input type="hidden" name="maintain_cycle" class="input7" id="maintain_cycle" value="<?php echo $view_val['maintain_cycle']; ?>" />
											<!-- <?php echo $view_val['project_name']; ?>(<?php echo $view_val['exception_saledate'];?>) -->
											<?php echo $item3['project_name']."(".$item3['exception_saledate'].")"; ?>
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
									</tr>
									<tr class="product_insert_field_<?php echo $j; ?>">
										<td colspan="10" height="1" bgcolor="#e8e8e8"></td>
									</tr>
                                    <tr id="product_insert_field_1_<?php echo $j; ?>">
                                        <td colspan=2 height="40" align="center" class="t_border" bgcolor="f8f8f9" style="font-weight:bold;">제조사</td>
                                        <td colspan=3 align="left" class="t_border" style="padding-left:10px;" colspan="1">
                                            <select name="product_company" id="product_company" class="input2" onchange="product_type_default();productSearch();">
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
									<tr class="product_insert_field_<?php echo $j; ?>">
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
                                            <select name="product_state" id="product_state" class="input5" >
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
									<tr class="product_insert_field_<?php echo $j; ?>">
										<td colspan="10" height="1" bgcolor="#e8e8e8"></td>
									</tr>
                                    <tr id="product_insert_field_3_<?php echo $j; ?>">
                                        <td colspan=2 height="40" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">장비유지보수시작일</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<!-- <input name="maintain_begin" type="date" class="input7" id="maintain_begin1" value="<?php echo $item3['maintain_begin']; ?>" onchange="exceptionsaledateChange('<?php echo $item3['product_name']; ?>','begin','<?php echo $item3['maintain_begin']; ?>',this.value);" /> -->
											<input name="maintain_begin" type="date" class="input7" id="maintain_begin" value="<?php echo $item3['maintain_begin']; ?>" />  
										</td>
                                        <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">장비유지보수만료일</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<input name="maintain_expire" type="date" class="input7" id="maintain_expire" value="<?php echo $item3['maintain_expire'];?>" onchange="exceptionsaledateChange('<?php echo $j; ?>','expire','<?php echo $item3['maintain_expire']; ?>',this.value);"/> 
										</td>
                                        <td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">유/무상</td>
                                        <td align="left" class="t_border" style="padding-left:10px;">
                                            <select name="maintain_yn" id="maintain_yn" class="input5" >
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
                                            <select name="maintain_target" id="maintain_target" class="input5" >
                                                <option value="0">유지보수 대상</option>
                                                <option value="Y" <?php if ($item3['maintain_target'] == "Y") {
																							echo "selected";
																						} ?>>대상</option>
                                                <option value="N" <?php if ($item3['maintain_target'] == "N") {
																							echo "selected";
																						} ?>>비대상</option>
											</select>
											<!-- <input name="product_version" type="hidden" class="input5" id="product_version" value="<?php echo $item3['product_version']; ?>" />
											<input name="product_check_list" type="hidden" class="input5" id="product_check_list" value="<?php echo $item3['product_check_list']; ?>" />
											<input name="product_host" type="hidden" class="input5" id="product_host" value="<?php echo $item3['product_host']; ?>" />
											<input name="custom_title" type="hidden" class="input5" id="custom_title" value="<?php echo $item3['custom_title']; ?>" />
											<input name="custom_detail" type="hidden" class="input5" id="custom_detail" value="<?php echo $item3['custom_detail']; ?>" /> -->
										</td>
									</tr>
									<tr class="product_insert_field_<?php echo $j; ?>">
										<td colspan="10" height="1" bgcolor="#e8e8e8"></td>
									</tr>
									<tr id="product_insert_field_4_<?php echo $j; ?>">
										<td colspan=2 height="40" align="center" class="t_border" bgcolor="f8f8f9" style="font-weight:bold;">유지보수매출가</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<input name="product_sales" type="text" class="input5" id="product_sales" value="<?php if(trim($item3['product_sales']) == ""){echo $item3['product_sales'];}else{echo number_format($item3['product_sales']);} ?>" onclick="numberFormat(this);" onchange="numberFormat(this);product_profit_change(<?php echo $j; ?>);" /> 
										</td>
										<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">유지보수매입가</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<input name="product_purchase" type="text" class="input5" id="product_purchase" value="<?php if(trim($item3['product_purchase']) == ""){echo $item3['product_purchase'];}else{echo number_format($item3['product_purchase']);} ?>" onclick="numberFormat(this);" onchange="numberFormat(this);product_profit_change(<?php echo $j; ?>);" /> 
									    </td>
										<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">유지보수마진</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<input name="product_profit" type="text" class="input5" id="product_profit" value="<?php if(trim($item3['product_profit']) == ""){echo $item3['product_profit'];}else{echo number_format($item3['product_profit']);} ?>" readonly /> 
										</td>
									</tr >
									<tr id="product_insert_field_<?php echo $j; ?>">
                                        <td colspan="10" height="2" bgcolor="#797c88"></td>
									</tr>
									<?php } else { ?>
									<tr id="product_insert_field_0_<?php echo $j; ?>">
										<td colspan=2 height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;"><input type="checkbox" name="product_row" value="<?php echo $i;?>" style="float:left;" />프로젝트명</td>
										<td colspan=3 align="left" class="t_border" style="padding-left:10px;">
											<!-- <?php echo $view_val['project_name']; ?>(<?php echo $view_val['exception_saledate']; ?>) -->
											<?php echo $item3['project_name']."(".$item3['exception_saledate'].")"; ?>
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
										<td align="right">
											<img src="<?php echo $misc; ?>img/btn_del0.jpg" onclick='javascript:product_list_del(<?php echo $j; ?>,<?php echo $item3["seq"]; ?>);' style="cursor:pointer;" />
										</td>
									</tr>
									<tr class="product_insert_field_<?php echo $j; ?>">
										<td colspan="10" height="1" bgcolor="#e8e8e8"></td>
									</tr>
									<tr id="product_insert_field_1_<?php echo $j; ?>">
										<td colspan=2 height="40" align="center" class="t_border" bgcolor="f8f8f9" style="font-weight:bold;">제조사</td>
										<td colspan=3 align="left" class="t_border" style="padding-left:10px;" colspan="1">
											<select name="product_company" id="product_company<?php echo $i; ?>" class="input2" onchange="product_type_default(<?php echo $i;?>);productSearch(<?php echo $i; ?>);">
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
									<tr class="product_insert_field_<?php echo $j; ?>">
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
											<input name="product_licence" type="text" class="input5" id="product_licence<?php echo $i;?>" value="<?php echo $item3['product_licence']; ?>" onkeyup="commaCheck(this);" /> 
										</td>
										<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">Serial</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<input name="product_serial" type="text" class="input5" id="product_serial<?php echo $i;?>" value="<?php echo $item3['product_serial']; ?>" onkeyup="commaCheck(this);" /> 
										</td>
										<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">제품 상태</td>
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
											</select>
										</td>
									</tr>
									<tr class="product_insert_field_<?php echo $j; ?>">
										<td colspan="10" height="1" bgcolor="#e8e8e8"></td>
									</tr>
									<tr id="product_insert_field_3_<?php echo $j; ?>">
										<td colspan=2 height="40" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">장비유지보수시작일</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<!-- <input name="maintain_begin" type="date" class="input7" id="maintain_begin_<?php echo $mb_cnt; ?>" value="<?php echo $item3['maintain_begin']; ?>" onchange="exceptionsaledateChange('<?php echo $item3['product_name']; ?>','begin','<?php echo $item3['maintain_begin']; ?>',this.value);" />  -->
											<input name="maintain_begin" type="date" class="input7" id="maintain_begin<?php echo $i;?>" value="<?php echo $item3['maintain_begin']; ?>"  /> 
										</td>
										<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">장비유지보수만료일</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<input name="maintain_expire" type="date" class="input7" id="maintain_expire<?php echo $i; ?>" value="<?php echo $item3['maintain_expire']; ?>" onchange="exceptionsaledateChange('<?php echo $j; ?>','expire','<?php echo $item3['maintain_expire']; ?>',this.value);" /> 
										</td>
										<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">유/무상</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<select name="maintain_yn" id="maintain_yn<?php echo $i;?>" class="input5">
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
											<select name="maintain_target" id="maintain_target<?php echo $i;?>" class="input5">
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
									<tr class="product_insert_field_<?php echo $j; ?>">
										<td colspan="10" height="1" bgcolor="#e8e8e8"></td>
									</tr>
									<tr id="product_insert_field_4_<?php echo $j; ?>">
										<td colspan=2 height="40" align="center" class="t_border" bgcolor="f8f8f9" style="font-weight:bold;">장비매출가</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<input name="product_sales" type="text" class="input5" id="product_sales<?php echo $i;?>" value="<?php if(trim($item3['product_sales']) == ""){echo $item3['product_sales'];}else{ echo number_format($item3['product_sales']);} ?>" onclick="numberFormat(this);" onchange="numberFormat(this);product_profit_change(<?php echo $j; ?>);" /> 
										</td>
										<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">장비매입가</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<input name="product_purchase" type="text" class="input5" id="product_purchase<?php echo $i;?>" value="<?php if(trim($item3['product_purchase']) == ""){echo $item3['product_purchase'];}else{echo number_format($item3['product_purchase']);} ?>" onclick="numberFormat(this);" onchange="numberFormat(this);product_profit_change(<?php echo $j; ?>);" /> 
										</td>
										<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">장비마진</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<input name="product_profit" type="text" class="input5" id="product_profit<?php echo $i;?>" value="<?php if(trim($item3['product_profit']) == ""){echo $item3['product_profit'];}else{echo number_format($item3['product_profit']);} ?>" readonly /> 
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
									}?>

									<input type="hidden" id="row_max_index2" name="row_max_index2" value="<?php echo $max_number2 ;?>" />
									<tr>
										<td id="productEnd" colspan="10" height="0" bgcolor="#e8e8e8"></td>
									</tr>
									<tr id="input_point">
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

										<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">분할월수</td>
										<td colspan="3" align="left" class="t_border" style="padding-left:10px;">
										<select name="division_month" id="division_month" class="input5" onchange="monthDivision()">
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
										</select>
										<input type="text" name="monthly_input" id="monthlyInput" onchange="month()"></input>
										<div id="month" style="float:right">개월<div>
										</td>
									</tr>

									<tr>
										<td colspan=2 height="40" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">
											<input type="checkbox" name="product_row" value="project" style="float:left;" />고객사유지보수시작일
										</td>
										<td align="left" class="t_border" style="padding-left:10px;"><input name="exception_saledate2" type="date"
												class="input7" id="exception_saledate2" value="<?php echo $view_val['exception_saledate2']; ?>" />
										</td>
										<td align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">고객사유지보수종료일</td>
										<td align="left" class="t_border" style="padding-left:10px;">
											<input name="exception_saledate3" type="date" class="input7" id="exception_saledate3" value="<?php echo $view_val['exception_saledate3']; ?>" />
										</td>
									</tr>
									<tr>
										<td colspan="10" height="2" bgcolor="#797c88"></td>
									</tr>
									<tr>
										<td height=0></td>
									</tr>
									<?php }else if($_GET['type'] == '6'){?>
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
									<tr>
										<td colspan="10" height="2" bgcolor="#797c88"></td>
									</tr>
									<?php }else if ($_GET['type'] == '8'){ ?>
										<?php
										$i = 0;
										$main_company_amount1 = 0;
										foreach ($view_val2 as $item2) {
											${"main_company_amount".($i+1)} = 0;
											if ($i == 0) {
											foreach ($view_val3 as $item3) {
												if($item3['product_supplier'] == $item2['main_companyname']){
													$main_company_amount1 += (int)$item3['product_purchase'];
													}
												}
											} else {
												foreach ($view_val3 as $item3) {
													if($item3['product_supplier'] == $item2['main_companyname']){
													${"main_company_amount".($i+1)} += (int)$item3['product_purchase'];
													}
												}
											}
											$i++;
										}

										$sales_cnt=0;
										$purchase_cnt=0;
										if(!empty($bill_val)){
											foreach($bill_val as $bill){
												if($bill['type'] == "001"){
													$sales_cnt++;
												}else if($bill['type'] == "002"){
													$purchase_cnt++;
												}
											}
										}
										?>
										<tr>
											<td colspan="11" height="40" style="font-weight:bold;font-size:13px;">계산서 발행 정보</td>
										</tr>
										<tr>
											<td colspan="11" height="2" bgcolor="#797c88"></td>
										</tr>
										<tr>
											<td colspan="11" class="basic_td" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">매출</td>
										</tr>
										<tr>
										<input type="hidden" id="insert_bill_array" name="insert_bill_array" />
										<input type="hidden" id="update_bill_array" name="update_bill_array" />
										<input type="hidden" id="delete_bill_array" name="delete_bill_array" />
										<input type="hidden" id="sales_total_issuance_amount" name="sales_total_issuance_amount" value="0" />
										<input type="hidden" id="update_seq" name="update_seq" />
											<td colspan="2" class="basic_td" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">계약금액</td>
											<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">회차</td>
											<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">발행금액</td>
											<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">국세청 승인번호</td>
											<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">해당월</td>
											<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">발행일자</td>
											<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">발행여부</td>
											<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">입금일자</td>
											<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">입금여부</td>
											<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;"></td>
										</tr>
										<?php if(empty($bill_val) || $sales_cnt == 0){?>
											<tr class="insert_sales_bill">
												<td rowspan="<?php echo $view_val['sales_pay_session']; ?>" id="sales_contract_total_amount" rowspan="1" colspan="2" class="basic_td" height="40"
													align="center"><?php echo number_format($view_val['forcasting_sales']); ?></td>
												<?php for($k=0; $k<$view_val['sales_pay_session']; $k++){
												if($k != 0 ){
													echo "<tr class='insert_sales_bill'>";
												}?>
												<td height="40" class="basic_td" align="center"><input type="text" id="pay_session<?php echo ($k+1); ?>" name="pay_session" class="input7" value="<?php echo ($k+1); ?>" style="width:60%;text-align:center;" readonly/></td>
												<td height="40" class="basic_td" align="right"><input type="text" id="sales_issuance_amount1"
														name="sales_issuance_amount" class="input7" style="text-align:right;" value=""
														onchange="numberFormat(this);" />
												</td>
												<td height="40" class="basic_td" align="center">
													<input type="text" id="sales_tax_approval_number<?php echo ($k+1); ?>" name="sales_tax_approval_number" class="input7" onchange="taxApprovalNumer(this,<?php echo ($k+1); ?>,0);" />
												</td>
												<td height="40" class="basic_td" align="center"><input type="text" id="sales_issuance_month<?php echo ($k+1); ?>"
														name="sales_issuance_month" class="input7" style="text-align:center;" readonly /></td>
												<td height="40" class="basic_td" align="center"><input type="text" id="sales_issuance_date<?php echo ($k+1); ?>"
														name="sales_issuance_date" class="input7" onchange="issuance_date_change(this,<?php echo ($k+1); ?>,0);" style="text-align:center;" readonly />
												</td>
												<td height="40" class="basic_td" align="center"><input type="hidden" id="sales_issuance_status<?php echo ($k+1); ?>"
														name="sales_issuance_status" class="input7" value="N" /><span
														id="sales_issuance_YN<?php echo ($k+1); ?>">미완료</span></td>
												<td height="40" class="basic_td" align="center"><input type="date" id="sales_deposit_date<?php echo ($k+1); ?>"
														name="sales_deposit_date" class="input7" onchange="deposit_date_change(this,<?php echo ($k+1); ?>,0);" />
												</td>
												<td height="40" class="basic_td" align="center"><input type="hidden" id="sales_deposit_status<?php echo ($k+1); ?>"
														name="sales_deposit_status" class="input7" value="N" /><span
														id="sales_deposit_YN<?php echo ($k+1); ?>">미완료</span></td>
												<td height="40" class="basic_td" align="center">
													<?php if($k == 0){?>
														<img src="<?php echo $misc; ?>img/btn_add.jpg" onclick="addRow('sales_issuance_amount_insert_line','sales_contract_total_amount',0);" style="cursor:pointer;" />
													<?php }else{ ?>
														<img src="<?php echo $misc; ?>img/btn_del0.jpg" onclick="deleteRow(this,'sales_contract_total_amount',0);" style="cursor:pointer;"/>
													<?php } ?>
												</td>
												<?php
													echo "</tr>";
												} ?>
										<?php 
										}
										if($sales_cnt > 0){
											$row = 1; 
											foreach($bill_val as $bill){
												if($bill['type'] == "001"){//매출
													if($row == 1){
										?>
														<tr id="bill_<?php echo $bill['seq']; ?>" class="update_sales_bill" >
															<td id="sales_contract_total_amount" rowspan="1" colspan="2" class="basic_td" height="40" align="center"><?php echo number_format($view_val['forcasting_sales']); ?></td>
															<?php if($bill['issuance_status'] == "Y"){?>
															<td height="40" class="basic_td" align="center"><?php echo $bill['pay_session']; ?> 
																<input type="hidden" id="pay_session<?php echo $row;?>" name="pay_session" class="input7" value="<?php echo $bill['pay_session']; ?>" style="width:60%;text-align:center;" />
															</td>
															<td height="40" class="basic_td" align="right"><?php if($bill['issuance_amount'] == "" ){echo $bill['issuance_amount']; }else{echo number_format($bill['issuance_amount']);} ?>
																<input type="hidden" id="sales_issuance_amount<?php echo $row; ?>" name="sales_issuance_amount" class="input7" style="text-align:right;" value="<?php if($bill['issuance_amount'] == "" ){echo $bill['issuance_amount']; }else{echo number_format($bill['issuance_amount']);} ?>"/>
															</td>
															<td height="40" class="basic_td" align="center"><?php echo $bill['tax_approval_number']; ?>
																<input type="hidden" id="sales_tax_approval_number<?php echo $row; ?>" name="sales_tax_approval_number" class="input7" value="<?php echo $bill['tax_approval_number']; ?>" onchange="taxApprovalNumer(this,<?php echo $row; ?>,0);" />
															</td>
															<?php }else{?>
															<td height="40" class="basic_td" align="center">
																<input type="text" id="pay_session<?php echo $row;?>" name="pay_session" class="input7" value="<?php echo $bill['pay_session']; ?>" style="width:60%;" onchange="updateSeq(<?php echo $bill['seq']; ?>);" />
																</td>
															<td height="40" class="basic_td" align="right"><input type="text" id="sales_issuance_amount<?php echo $row; ?>"
																	name="sales_issuance_amount" class="input7" style="text-align:right;"
																	value="<?php echo number_format($bill['issuance_amount']); ?>"
																	onchange="numberFormat(this);updateSeq(<?php echo $bill['seq']; ?>);" />
															</td>
															<td height="40" class="basic_td" align="center">
																<input type="text" id="sales_tax_approval_number<?php echo $row; ?>" name="sales_tax_approval_number" class="input7" value="<?php echo $bill['tax_approval_number']; ?>" onchange="taxApprovalNumer(this,<?php echo $row; ?>,0);" />
															</td>
															<?php } ?>
															
															<td height="40" class="basic_td" align="center"><input type="text" id="sales_issuance_month<?php echo $row; ?>"
																	name="sales_issuance_month" class="input7" style="text-align:center;" value="<?php echo $bill['issuance_month']; ?>" readonly /></td>
															<td height="40" class="basic_td" align="center"><input type="text" id="sales_issuance_date<?php echo $row; ?>"
																	name="sales_issuance_date" class="input7" value="<?php echo $bill['issuance_date']; ?>" onchange="issuance_date_change(this,<?php echo $row; ?>,0);updateSeq(<?php echo $bill['seq']; ?>);" style="text-align:center;" readonly />
															</td>
															<td height="40" class="basic_td" align="center">
																<input type="hidden" id="sales_issuance_status<?php echo $row; ?>" name="sales_issuance_status" class="input7" value="<?php echo $bill['issuance_status']; ?>" />
																<span id="sales_issuance_YN<?php echo $row; ?>">
																	<?php if($bill['issuance_status'] == "Y"){
																		echo "완료";
																	}else{
																		echo "미완료";
																	} ?>
																</span>
															</td>
															<td height="40" class="basic_td" align="center"><input type="date" id="sales_deposit_date<?php echo $row; ?>"
																	name="sales_deposit_date" class="input7" value="<?php echo $bill['deposit_date']; ?>" onchange="deposit_date_change(this,<?php echo $row; ?>,0);updateSeq(<?php echo $bill['seq']; ?>);" />
															</td>
															<td height="40" class="basic_td" align="center">
																<input type="hidden" id="sales_deposit_status<?php echo $row; ?>" name="sales_deposit_status" class="input7" value="<?php echo $bill['deposit_status']?>" />
																<span id="sales_deposit_YN<?php echo $row; ?>">
																	<?php if($bill['deposit_status'] == "Y"){
																		echo "완료";
																	}else{
																		echo "미완료";
																	} ?>
																</span>
															</td>
															<td height="40" class="basic_td" align="center">
																<img src="<?php echo $misc; ?>img/btn_add.jpg" onclick="addRow('sales_issuance_amount_insert_line','sales_contract_total_amount',0);" />
															</td>
														</tr>

										<?php		
													$row++;
													}else{ ?>
														<tr id="bill_<?php echo $bill['seq']; ?>" class="update_sales_bill" >
														<?php if($bill['issuance_status'] == "Y"){ ?>
															<td height="40" class="basic_td" align="center"><?php echo $bill['pay_session']; ?> 
																<input type="hidden" id="pay_session<?php echo $row;?>" name="pay_session" class="input7" value="<?php echo $bill['pay_session']; ?>" style="width:60%;text-align:center;" />
															</td>
															<td height="40" class="basic_td" align="right"><?php if($bill['issuance_amount'] == ""){echo $bill['issuance_amount']; }else{echo number_format($bill['issuance_amount']);} ?>
																<input type="hidden" id="sales_issuance_amount<?php echo $row; ?>" name="sales_issuance_amount" class="input7" style="text-align:right;" value="<?php if($bill['issuance_amount'] == ""){echo $bill['issuance_amount']; }else{echo number_format($bill['issuance_amount']);} ?>" />
															</td>
															<td height="40" class="basic_td" align="center"><?php echo $bill['tax_approval_number']; ?>
																<input type="hidden" id="sales_tax_approval_number<?php echo $row; ?>" name="sales_tax_approval_number" class="input7" value="<?php echo $bill['tax_approval_number']; ?>" onchange="taxApprovalNumer(this,<?php echo $row; ?>,0);" />
															</td>
														<?php }else{?>
															<td height="40" class="basic_td" align="center">
																<input type="text" id="pay_session<?php echo $row;?>" name="pay_session" class="input7" value="<?php echo $bill['pay_session']; ?>" style="width:60%;text-align:center;" onchange="calculation_amount(<?php echo $view_val['forcasting_sales']; ?>,this,<?php echo $row; ?>,0);updateSeq(<?php echo $bill['seq']; ?>);" />
																</td>
															<td height="40" class="basic_td" align="right"><input type="text" id="sales_issuance_amount<?php echo $row; ?>"
																	name="sales_issuance_amount" class="input7" style="text-align:right;"
																	value="<?php if($bill['issuance_amount'] == "" ){echo $bill['issuance_amount']; }else{echo number_format($bill['issuance_amount']);} ?>"
																	onchange="numberFormat(this);updateSeq(<?php echo $bill['seq']; ?>);" />
															</td>
															<td height="40" class="basic_td" align="center">
																<input type="text" id="sales_tax_approval_number<?php echo $row; ?>" name="sales_tax_approval_number" class="input7" value="<?php echo $bill['tax_approval_number']; ?>" onchange="taxApprovalNumer(this,<?php echo $row; ?>,0);" />
															</td>
														<?php }?>
															
															<td height="40" class="basic_td" align="center"><input type="text" id="sales_issuance_month<?php echo $row; ?>"
																	name="sales_issuance_month" class="input7" style="text-align:center;" value="<?php echo $bill['issuance_month']; ?>" readonly /></td>
															<td height="40" class="basic_td" align="center"><input type="text" id="sales_issuance_date<?php echo $row; ?>"
																	name="sales_issuance_date" class="input7" value="<?php echo $bill['issuance_date']; ?>" onchange="issuance_date_change(this,<?php echo $row; ?>,0);updateSeq(<?php echo $bill['seq']; ?>);" style="text-align:center;" readonly />
															</td>
															<td height="40" class="basic_td" align="center">
																<input type="hidden" id="sales_issuance_status<?php echo $row; ?>" name="sales_issuance_status" class="input7" value="<?php echo $bill['issuance_status']; ?>" />
																<span id="sales_issuance_YN<?php echo $row; ?>">
																	<?php if($bill['issuance_status'] == "Y"){
																		echo "완료";
																	}else{
																		echo "미완료";
																	} ?>
																</span>
															</td>
															<td height="40" class="basic_td" align="center"><input type="date" id="sales_deposit_date<?php echo $row; ?>"
																	name="sales_deposit_date" class="input7" value="<?php echo $bill['deposit_date']; ?>" onchange="deposit_date_change(this,<?php echo $row; ?>,0);updateSeq(<?php echo $bill['seq']; ?>);" />
															</td>
															<td height="40" class="basic_td" align="center">
																<input type="hidden" id="sales_deposit_status<?php echo $row; ?>" name="sales_deposit_status" class="input7" value="<?php echo $bill['deposit_status']?>" />
																<span id="sales_deposit_YN<?php echo $row; ?>">
																	<?php if($bill['deposit_status'] == "Y"){
																		echo "완료";
																	}else{
																		echo "미완료";
																	} ?>
																</span>
															</td>
															<td height="40" class="basic_td" align="center">
																<img src="<?php echo $misc; ?>img/btn_del0.jpg" onclick="deleteRow(this,'sales_contract_total_amount',0);deleteSeq(<?php echo $bill['seq']; ?>);" />
															</td>
														</tr>
										<?php
													echo "<script>";
													echo "$('#sales_contract_total_amount').attr('rowSpan', {$row});";
													echo "</script>";
													$row++;
													}
												}	
											}
										}
										if(empty($bill_val) || $purchase_cnt == 0){?>
											<tr id="sales_issuance_amount_insert_line">
												<td colspan="11" class="basic_td" height="40" align="center" bgcolor="f8f8f9"
													style="font-weight:bold;">매입</td>
											</tr>
											<tr>
												<td class="basic_td" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">업체
												</td>
												<td class="basic_td" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">계약금액
												</td>
												<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">회차
												</td>
												<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">발행금액
												</td>
												<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">국세청 승인번호
												</td>
												<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">해당월
												</td>
												<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">발행일자
												</td>
												<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">발행여부
												</td>
												<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">입금일자
												</td>
												<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">입금여부
												</td>
												<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;"></td>
											</tr>
											<?php
											$num = 1; 
											foreach ($view_val2 as $item2) {?>
											<tr class="purchase_tax_invoice<?php echo $num; ?> insert_purchase_bill">
												<td rowspan="<?php echo $item2['purchase_pay_session']; ?>" height="40" class="purchase_contract_total_amount<?php echo $num; ?> basic_td" align="center"><?php echo $item2['main_companyname']; ?></td>
												<td id="purchase_contract_total_amount<?php echo $num; ?>" rowspan="<?php echo $item2['purchase_pay_session']; ?>" class="purchase_contract_total_amount<?php echo $num; ?> basic_td" height="40" align="center"><?php echo number_format(${"main_company_amount".$num}); ?></td>
												<?php for($k=0; $k<$item2['purchase_pay_session']; $k++){
												if($k != 0 ){
													echo "<tr class='purchase_tax_invoice{$num} insert_purchase_bill'>";
												}?>
												<td height="40" class="basic_td" align="center">
													<input type="hidden" name="purchase_company_name" value="<?php echo $item2['main_companyname']; ?>" />
													<input type="text" id="pay_session<?php echo ($k+1); ?>" name="pay_session" class="input7" value="<?php echo ($k+1); ?>" style="width:60%;text-align:center;" readonly/>
													</td>
												<td height="40" class="basic_td" align="right"><input type="text"
														class="purchase_issuance_amount<?php echo $num; ?> input7"
														name="purchase_issuance_amount" style="text-align:right;" value=""
														onchange="numberFormat(this);" />
												</td>
												<td height="40" class="basic_td" align="center">
													<input type="text" name="purchase_tax_approval_number" class="purchase_tax_approval_number<?php echo $num; ?> input7" onchange="taxApprovalNumer(this,<?php echo $num; ?>,1);" />
												</td>
												<td height="40" class="basic_td" align="center"><input type="text"
														class="purchase_issuance_month<?php echo $num; ?> input7" name="purchase_issuance_month"
														style="text-align:center;" readonly /></td>
												<td height="40" class="basic_td" align="center"><input type="text"
														class="purchase_issuance_date<?php echo $num; ?> input7" name="purchase_issuance_date"
														onchange="issuance_date_change(this,<?php echo $num; ?>,1);" style="text-align:center;" readonly /></td>
												<td height="40" class="basic_td" align="center"><input type="hidden"
														class="purchase_issuance_status<?php echo $num; ?> input7"
														name="purchase_issuance_status" value="N" /><span
														class="purchase_issuance_YN<?php echo $num; ?>">미완료</span></td>
												<td height="40" class="basic_td" align="center"><input type="date"
														class="purchase_deposit_date<?php echo $num; ?> input7" name="purchase_deposit_date"
														onchange="deposit_date_change(this,<?php echo $num; ?>,1);" /></td>
												<td height="40" class="basic_td" align="center"><input type="hidden"
														class="purchase_deposit_status<?php echo $num; ?> input7" name="purchase_deposit_status"
														value="N" /><span class="purchase_deposit_YN<?php echo $num; ?>">미완료</span></td>
												<td height="40" class="basic_td" align="center">
													<?php if($k == 0){?>
														<img src="<?php echo $misc; ?>img/btn_add.jpg" onclick="addRow('purchase_tax_invoice<?php echo $num; ?>','purchase_contract_total_amount<?php echo $num; ?>',1);" style="cursor:pointer;" />
													<?php }else{ ?>
														<img src="<?php echo $misc; ?>img/btn_del0.jpg" onclick="deleteRow(this,'purchase_contract_total_amount<?php echo $num; ?>',1);" style="cursor:pointer;"/>
													<?php } ?>
												</td>
												<?php
													echo "</tr>";
												} ?>
											<?php 
											$num++;
											}?>
										<?php  
										}
										if($purchase_cnt > 0){ ?>
										<tr id="sales_issuance_amount_insert_line">
											<td colspan="11" class="basic_td" height="40" align="center" bgcolor="f8f8f9"
												style="font-weight:bold;">매입</td>
										</tr>
										<tr>
											<td class="basic_td" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">업체
											</td>
											<td class="basic_td" height="40" align="center" bgcolor="f8f8f9" style="font-weight:bold;">계약금액
											</td>
											<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">회차
											</td>
											<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">발행금액
											</td>
											<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">국세청 승인번호
											</td>
											<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">해당월
											</td>
											<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">발행일자
											</td>
											<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">발행여부
											</td>
											<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">입금일자
											</td>
											<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">입금여부
											</td>
											<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;"></td>
										</tr>
										<?php 
											$num = 1;
											foreach ($view_val2 as $item2) {
												$row2 = 1; 
												foreach($bill_val as $bill){
													if($bill['type'] == "002"){//매입
													if($item2['main_companyname'] == $bill['company_name']){
													if($row2 == 1){ 
										?>
														<tr id="bill_<?php echo $bill['seq']; ?>" class="purchase_tax_invoice<?php echo $num; ?> update_purchase_bill">
															<td height="40" class="purchase_contract_total_amount<?php echo $num; ?> basic_td"
																align="center"><?php echo $bill['company_name']; ?></td>
															<td id="purchase_contract_total_amount<?php echo $num; ?>" rowspan="1"
																class="purchase_contract_total_amount<?php echo $num; ?> basic_td" height="40"
																align="center"><?php echo number_format(${"main_company_amount".$num}); ?></td>

															<?php if($bill['issuance_status'] == "Y"){?>
																<td height="40" class="basic_td" align="center"><?php echo $bill['pay_session']; ?>
																	<input type="hidden" name="purchase_company_name" value="<?php echo $bill['company_name']; ?>" />
																	<input type="hidden" class="pay_session<?php echo $num; ?> input7" name="pay_session" value="<?php echo $bill['pay_session']; ?>" style="width:60%;" />
																</td>
																<td height="40" class="basic_td" align="right"><?php if($bill['issuance_amount']==""){echo $bill['issuance_amount'];}else{echo number_format($bill['issuance_amount']);} ?><input type="hidden"
																		class="purchase_issuance_amount<?php echo $num; ?> input7" name="purchase_issuance_amount" style="text-align:right;"
																		value="<?php if($bill['issuance_amount']==""){echo $bill['issuance_amount'];}else{echo number_format($bill['issuance_amount']);} ?>" />
																</td>
																<td height="40" class="basic_td" align="center"><?php echo $bill['tax_approval_number']; ?>
																	<input type="hidden" name="purchase_tax_approval_number" class="purchase_tax_approval_number<?php echo $num; ?> input7" value="<?php echo $bill['tax_approval_number']; ?>" onchange="taxApprovalNumer(this,<?php echo $num; ?>,1);" />
																</td>
															<?php }else{ ?>
																<td height="40" class="basic_td" align="center">
																	<input type="hidden" name="purchase_company_name" value="<?php echo $bill['company_name']; ?>" />
																	<input type="text" class="pay_session<?php echo $num; ?> input7" name="pay_session" value="<?php echo $bill['pay_session']; ?>" style="width:60%;text-align:center;" onchange="updateSeq(<?php echo $bill['seq']; ?>);" />
																</td>
																<td height="40" class="basic_td" align="right"><input type="text"
																		class="purchase_issuance_amount<?php echo $num; ?> input7"
																		name="purchase_issuance_amount" style="text-align:right;"
																		value="<?php if($bill['issuance_amount'] == "" ){echo $bill['issuance_amount']; }else{echo number_format($bill['issuance_amount']);} ?>"
																		onchange="numberFormat(this);updateSeq(<?php echo $bill['seq']; ?>);" />
																</td>
																<td height="40" class="basic_td" align="center">
																	<input type="text" name="purchase_tax_approval_number" class="purchase_tax_approval_number<?php echo $num; ?> input7" value="<?php echo $bill['tax_approval_number']; ?>" onchange="taxApprovalNumer(this,<?php echo $num; ?>,1);" />
																</td>
															<?php }?>	
															<td height="40" class="basic_td" align="center"><input type="text"
																	class="purchase_issuance_month<?php echo $num; ?> input7" name="purchase_issuance_month" value="<?php echo $bill['issuance_month']; ?>"
																	style="text-align:center;" readonly /></td>
															<td height="40" class="basic_td" align="center"><input type="text"
																	class="purchase_issuance_date<?php echo $num; ?> input7" name="purchase_issuance_date" value="<?php echo $bill['issuance_date']; ?>"
																	onchange="issuance_date_change(this,<?php echo $num; ?>,1);updateSeq(<?php echo $bill['seq']; ?>);" style="text-align:center;" readonly /></td>
															<td height="40" class="basic_td" align="center">
																<input type="hidden" class="purchase_issuance_status<?php echo $num; ?> input7" name="purchase_issuance_status" value="<?php echo $bill['issuance_status']; ?>" />
																<span class="purchase_issuance_YN<?php echo $num; ?>">
																<?php if($bill['issuance_status'] == "Y"){
																	echo "완료";
																}else{
																	echo "미완료";
																} ?>
																</span>
															</td>
															<td height="40" class="basic_td" align="center">
																<input type="date" class="purchase_deposit_date<?php echo $num; ?> input7" name="purchase_deposit_date" value = "<?php echo $bill['deposit_date']; ?>" onchange="deposit_date_change(this,<?php echo $num; ?>,1);updateSeq(<?php echo $bill['seq']; ?>);" />
															</td>
															<td height="40" class="basic_td" align="center">
																<input type="hidden" class="purchase_deposit_status<?php echo $num; ?> input7" name="purchase_deposit_status" value="<?php echo $bill['deposit_status']; ?>" />
																<span class="purchase_deposit_YN<?php echo $num; ?>">
																<?php if($bill['deposit_status'] == "Y"){
																		echo "완료";
																}else{
																	echo "미완료";
																} ?>
															</span>
															</td>
															<td height="40" class="basic_td" align="center"><img src="<?php echo $misc; ?>img/btn_add.jpg" onclick="addRow('purchase_tax_invoice<?php echo $num; ?>','purchase_contract_total_amount<?php echo $num; ?>',1);" />
															</td>
														</tr>
												<?php 	
														}else{
												?>
														<tr id="bill_<?php echo $bill['seq']; ?>" class="purchase_tax_invoice<?php echo $num; ?> update_purchase_bill">
														<?php if($bill['issuance_status'] == "Y"){?>
															<td height="40" class="basic_td" align="center"><?php echo $bill['pay_session']; ?>
																<input type="hidden" name="purchase_company_name" value="<?php echo $bill['company_name']; ?>" />
																<input type="hidden" class="pay_session<?php echo $num; ?> input7" name="pay_session" value="<?php echo $bill['pay_session']; ?>" style="width:60%;" />
															</td>
															<td height="40" class="basic_td" align="right"><?php if($bill['issuance_amount'] == "" ){echo $bill['issuance_amount']; }else{echo number_format($bill['issuance_amount']);} ?>
																<input type="hidden" class="purchase_issuance_amount<?php echo $num; ?> input7"
																	name="purchase_issuance_amount" style="text-align:right;" value="<?php if($bill['issuance_amount'] == "" ){echo $bill['issuance_amount']; }else{echo number_format($bill['issuance_amount']);} ?>"/>
															</td>
															<td height="40" class="basic_td" align="center">
																<?php echo $bill['tax_approval_number']; ?>
																<input type="hidden" name="purchase_tax_approval_number" class="purchase_tax_approval_number<?php echo $num; ?> input7" value="<?php echo $bill['tax_approval_number']; ?>" onchange="taxApprovalNumer(this,<?php echo $num; ?>,1);" />
															</td>
														<?php }else{ ?>
															<td height="40" class="basic_td" align="center">
																<input type="hidden" name="purchase_company_name" value="<?php echo $bill['company_name']; ?>" />
																<input type="text" class="pay_session<?php echo $num; ?> input7" name="pay_session" value="<?php echo $bill['pay_session']; ?>" style="width:60%;text-align:center;" onchange="updateSeq(<?php echo $bill['seq']; ?>);" />
															</td>
															<td height="40" class="basic_td" align="right">
																<input type="text" class="purchase_issuance_amount<?php echo $num; ?> input7" name="purchase_issuance_amount" style="text-align:right;" value="<?php if($bill['issuance_amount'] == "" ){echo $bill['issuance_amount']; }else{echo number_format($bill['issuance_amount']);} ?>" onchange="numberFormat(this);updateSeq(<?php echo $bill['seq']; ?>);" />
															</td>
															<td height="40" class="basic_td" align="center">
																<input type="text" name="purchase_tax_approval_number" class="purchase_tax_approval_number<?php echo $num; ?> input7" value="<?php echo $bill['tax_approval_number']; ?>" onchange="taxApprovalNumer(this,<?php echo $num; ?>,1);" />
															</td>
														<?php } ?>
															<td height="40" class="basic_td" align="center"><input type="text"
																	class="purchase_issuance_month<?php echo $num; ?> input7" name="purchase_issuance_month" value="<?php echo $bill['issuance_month']; ?>"
																	style="text-align:center;" readonly /></td>
															<td height="40" class="basic_td" align="center"><input type="text"
																	class="purchase_issuance_date<?php echo $num; ?> input7" name="purchase_issuance_date" value="<?php echo $bill['issuance_date']; ?>"
																	onchange="issuance_date_change(this,<?php echo $num; ?>,1);updateSeq(<?php echo $bill['seq']; ?>);" style="text-align:center;" readonly /></td>
															<td height="40" class="basic_td" align="center">
																<input type="hidden" class="purchase_issuance_status<?php echo $num; ?> input7" name="purchase_issuance_status" value="<?php echo $bill['issuance_status']; ?>" />
																<span class="purchase_issuance_YN<?php echo $num; ?>">
																<?php if($bill['issuance_status'] == "Y"){
																	echo "완료";
																}else{
																	echo "미완료";
																} ?>
																</span>
															</td>
															<td height="40" class="basic_td" align="center">
																<input type="date" class="purchase_deposit_date<?php echo $num; ?> input7" name="purchase_deposit_date" value = "<?php echo $bill['deposit_date']; ?>" onchange="deposit_date_change(this,<?php echo $num; ?>,1);updateSeq(<?php echo $bill['seq']; ?>);" />
															</td>
															<td height="40" class="basic_td" align="center">
																<input type="hidden" class="purchase_deposit_status<?php echo $num; ?> input7" name="purchase_deposit_status" value="<?php echo $bill['deposit_status']; ?>" />
																<span class="purchase_deposit_YN<?php echo $num; ?>">
																<?php if($bill['deposit_status'] == "Y"){
																		echo "완료";
																}else{
																	echo "미완료";
																} ?>
															</span>
															</td>
															<td height="40" class="basic_td" align="center"><img src="<?php echo $misc; ?>img/btn_del0.jpg" onclick="deleteRow(this,'purchase_contract_total_amount<?php echo $num; ?>',1);deleteSeq(<?php echo $bill['seq']; ?>);" />
															</td>
														</tr>
												<?php
														}
														echo "<script>";
														echo "$('.purchase_contract_total_amount{$num}').attr('rowSpan', {$row2});";
														echo "</script>";
														$row2++;
													}
												} 
											}
											$num++;
										}
									} } ?>
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
							<input type="image" src="<?php echo $misc; ?>img/btn_adjust.jpg" width="64" height="31" style="cursor:pointer" onclick="javascript:chkForm(); return false; " />
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

		//select box 검색 기능
		$("#check_product_company").select2();
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

		//수정 누르기 전에 조회추가를 눌렀을 때
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
				url: "<?php echo site_url(); ?>/ajax/subProjectAdd",
				dataType: "json",
				async: false,
				data: {
					subProjectSeq: subProjectSeq
				},
				success: function(data) {
					for (var i = 0; i < data.length; i++) {	
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


		// //조회 추가 후 수정버튼을 누르면 부모 sub_project_add컬럼에 자식seq가 들어감
		// function sub_project_add_update(){
		// 	var parent_seq = "<?php echo $_GET['seq']; ?>";
		// 	var subProjectSeq = $("#subProjectAddInput").val();
		// 	console.log("add",subProjectSeq);
		// 	var subSplit = subProjectSeq.split(",");
		// 	for (var i = 0; i < subSplit.length; i++) {
		// 		$.ajax({
		// 			type: "POST",
		// 			cache: false,
		// 			url: "<?php echo site_url(); ?>/ajax/sub_project_add_update",
		// 			dataType: "json",
		// 			async: false,
		// 			data: {
		// 				seq: parent_seq,
		// 				subProjectSeq: subSplit[i]
		// 			},
		// 			success: function(data) {
		// 			}
		// 		})
		// 	}
		// }

		// //조회 취소 후 수정버튼을 누르면 자식,부모 sub_project_add컬럼에 null 값 들어감
		// function sub_project_remove_update() {
		// 	var parent_seq = "<?php echo $_GET['seq']; ?>";
		// 	var subProjectSeq = $("#subProjectRemoveInput").val();

		// 	var subSplit = subProjectSeq.split(",");
		// 	for (var i = 0; i < subSplit.length; i++) {
		// 		$.ajax({
		// 			type: "POST",
		// 			cache: false,
		// 			url: "<?php echo site_url(); ?>/ajax/sub_project_remove_update",
		// 			dataType: "json",
		// 			async: false,
		// 			data: {
		// 				parent_seq :parent_seq,
		// 				seq: subSplit[i]
		// 			},
		// 			success: function(data) {
		// 			}
		// 		})
		// 	}
		// }

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
						for (var i = 0; i < data.length; i++) {
							html += "<option value ='" + data[i].seq + "'>" + data[i].product_name + "</option>";
						}
						$("#product_name" + idx).html(html);
						$("#product_name" + idx).select2();
					}
				});
			}
		}

		// function subProductSearch(idx) {
		// 	console.log(idx)
		// 	if (idx == undefined) {
		// 		idx = '';
		// 	}
		// 	var productCompany = $("#product_company" + idx).val();
		// 	var productType = $("#product_type" + idx).val();
		// 	$.ajax({
		// 		type: "POST",
		// 		cache: false,
		// 		url: "<?php echo site_url();?>/ajax/product_search",
		// 		dataType: "json",
		// 		async: false,
		// 		data: {
		// 			productCompany: productCompany,
		// 			productType: productType
		// 		},
		// 		success: function (data) {
		// 			console.log(data)
		// 			var html = "<option value=''>제품선택</option>";
		// 			for (i = 0; i < data.length; i++) {
		// 				html += "<option value ='" + data[i].seq + "'>" + data[i].product_name + "</option>";
		// 			}
		// 			$("#sub_product_name" + idx).html(html);
		// 			$("#sub_product_name" + idx).select2();
		// 		}
		// 	});
		// }

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
					for (var i = 0; i < data.length; i++) {
						html += "<option value=" + data[i].seq + ">" + data[i].user_name + "</option>"
					}
					$("#select_sales_user").html(html);

					$("#select_sales_user").change(function(){
						$("#sales_username").val($("#select_sales_user option:selected").text());
						for (var i = 0; i < data.length; i++) {
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
				for (var i = 0; i < data.length; i++) {
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
				for (var i = 0; i < data.length; i++) {
					html += "<option value=" + data[i].seq + ">" + data[i].user_name + "</option>"
				}
				$("#select_sales_user").html(html);
				$("#select_sales_user option").filter(function () {
					return this.text == "<?php echo $view_val['sales_username']?>";
				}).attr('selected', true);

				$("#select_sales_user").change(function () {
					$("#sales_username").val($("#select_sales_user option:selected").text());
					for (var i = 0; i < data.length; i++) {
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
					for (var i = 0; i < data.length; i++) {
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
				for (var i = 0; i < data.length; i++) {
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


	//제품 유지보수 시작일,종료일 수정했을 때
	function exceptionsaledateChange(row_num,change,oldValue,newValue){
		if(oldValue != newValue){
			var type = $("#product_insert_field_2_"+row_num).find($("select[name=product_name]")).text().trim();
			$("#update_produce_saledate").val($("#update_produce_saledate").val()+"/"+type+","+change+","+oldValue+","+newValue);
			console.log($("#update_produce_saledate").val());
		}
	}

	// //일괄적용
	// function collectiveApplication(obj,tagName){
	// 	if($('input:checkbox[name="product_row"]:checked').length > 0){
	// 		if(confirm("체크 되어 있는 제품에 일괄 수정하시겠습니까?")){
	// 			var id = $(obj).attr("name");
	// 			console.log(id)
	// 			if(id.indexOf("sub_") != -1){
	// 				id = id.replace("sub_",'');
	// 			}
	// 			console.log(id)
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
	// 						if(tagName == 0){//input
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
							if(this.value != "project"){
								if(this.value != 0){
									idx = this.value;
								}
								if($("#product_company"+idx).val() != $("#check_product_company").val()){
									alert("제조사 먼저 선택적용 해주세요.");
									return false;
								}
							}
						} 
					});
				}
				$('input:checkbox[name="product_row"]').each(function () {
					if (this.checked == true) {
						var val = $("#check_"+column).val();
						if(this.value == 0){ //첫번째 product_row
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
						}else if (this.value != "project"){ //product_row 첫번째꺼 제외
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
						}else{//projcet_row 일때 (고객사유지보수시작일,고객사유지보수종료일)
							if(column == "maintain_begin"){
								$("#exception_saledate2").val(val);
							}else if (column == "maintain_expire"){
								$("#exception_saledate3").val(val);
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

	//매입처 + ,제품 +
	$(function() {
		$("#main_add").click(function() {
			$("#row_max_index").val(Number(Number($("#row_max_index").val()) + Number(1)));
			var id = "main_insert_field_" + $("#row_max_index").val();
			var html ="<tr class=" + id + "><td colspan='10' height='1' bgcolor='#e8e8e8'></td></tr><tr class=" + id + "><td height='70' align='center' class='t_border' bgcolor='f8f8f9' style='font-weight:bold;'>매입처</td><td align='left' class='t_border' style='padding-left:10px;'>";
			html += '<select id="select_main_company'+$("#row_max_index").val()+'" class="input2" onchange="selectMainCompany('+$("#row_max_index").val()+'); ">';
			html +=	"<option value=''>매입처 선택</option>";
			html += "<?php foreach($sales_customer as $sc){ echo "<option value='".$sc['seq']."'>".$sc['company_name']."</option>";}?>";
			html += "</select><br><input name='main_companyname' type='text' class='input2' id='main_companyname"+$("#row_max_index").val()+"'/></td><td align='center' bgcolor='f8f8f9' class='t_border' style='font-weight:bold;'>담당자</td><td align='left' class='t_border' style='padding-left:10px;'>";
			html += '<select id="select_main_user'+$("#row_max_index").val()+'" class="input2" onchange="selectMainUser('+$("#row_max_index").val()+')"><option value="">담당자 선택</option></select><br>';
			html += "<input name='main_username' type='text' class='input2' id='main_username"+$("#row_max_index").val()+"'/></td></tr><tr class=" + id + "><td colspan='10' height='1' bgcolor='#e8e8e8'></td></tr><tr class=" + id + "><td height='40' align='center' bgcolor='f8f8f9' class='t_border' style='font-weight:bold;'>연락처</td><td align='left' class='t_border' style='padding-left:10px;'><input name='main_tel' type='text' class='input2' id='main_tel"+$("#row_max_index").val()+"' onclick='checkNum(this);' onKeyUp='checkNum(this);'/></td><td align='center' bgcolor='f8f8f9' class='t_border' style='font-weight:bold;'>이메일</td><td align='left' class='t_border' style='padding-left:10px;'><input name='main_email' type='text' class='input2' id='main_email"+$("#row_max_index").val()+"'/></td><td align='right' style='padding-left:10px;'><img src='<?php echo $misc; ?>img/btn_del0.jpg' style='cursor:pointer;' onclick='javascript:main_list_del(" + $("#row_max_index").val() + ");'/></td></tr>";
			html += "<tr class=" + id + "><td colspan='10' height='1' bgcolor='#e8e8e8'></td></tr><tr class=" + id + "><td height='40' align='center' class='t_border' bgcolor='f8f8f9' style='font-weight:bold;'>납부회차</td><td align='left' class='t_border' style='padding-left:10px;'><input type='text' name='purchase_pay_session' class='input5' ></td></tr>"
			html += "<tr class=" + id + "><td colspan=10 height='2' bgcolor='#797c88'></td></tr>";
			$('#main_insert').before(html);
			$("#select_main_company"+$("#row_max_index").val()).select2();
			document.documentElement.scrollTop = document.body.scrollHeight; //스크롤 맨밑으로 내려
		});

		$("#product_add").click(function() {
			$("#row_max_index2").val(Number(Number($("#row_max_index2").val()) + Number(1)));
			var row_num = Number($("#row_max_index2").val())-1;
			var id3 = "product_insert_field_" + $("#row_max_index2").val(); //선
			var id2 = "product_insert_field_0_" + $("#row_max_index2").val();
			var id4 = "product_insert_field_1_" + $("#row_max_index2").val();
			var id5 = "product_insert_field_2_" + $("#row_max_index2").val();
			var id6 = "product_insert_field_3_" + $("#row_max_index2").val();
			var id7 = "product_insert_field_4_" + $("#row_max_index2").val();
			var html = "<tr class=" + id3 + "><td colspan='9' height='1' bgcolor='#e8e8e8'></td></tr><tr id=" + id2 + ">";
			html += '<td colspan=2 height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;"><input type="checkbox" name="product_row" value="'+row_num+'" style="float:left;" />프로젝트명</td><td align="left" class="t_border" style="padding-left:10px;" colspan="3"><?php echo $view_val['project_name']; ?></td>';
			html += '<td colspan=1 height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">매입처</td><td align="left" class="t_border" style="padding-left:10px;" colspan="3"><select name="product_supplier" id="product_supplier'+row_num+'" class="input7" >';
				<?php foreach($view_val2 as $item2){ ?>
					html += "<option value='<?php echo $item2['main_companyname'];?>'><?php echo $item2['main_companyname'];?></option>";
				<?php } ?>
			html += '</td><td align="right"><img src="<?php echo $misc; ?>img/btn_del0.jpg" style="cursor:pointer;" onclick="javascript:product_list_del('+"'"+$("#row_max_index2").val()+"'"+');"/></td></tr>';
			html += '<tr class=' + id3 + '><td colspan="10" height="1" bgcolor="#e8e8e8"></td></tr><tr id=' + id5 + '><td colspan=2 height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">제조사</td><td colspan=3 align="left" class="t_border" style="padding-left:10px;" colspan="1">';
			html += '<select name="product_company" id="product_company'+row_num+'" class="input2" onchange="product_type_default('+row_num+');productSearch('+row_num+');"><option value="">제조사</option>';
			<?php foreach($product_company as $pc){?>
				html += "<option value='<?php echo $pc['product_company'];?>'><?php echo $pc['product_company']; ?></option>";
			<?php } ?>
			html += '</select></td><td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">하드웨어/소프트웨어</td><td align="left" class="t_border" style="padding-left:10px;" colspan="3">'
			html += '<select name="product_type" id="product_type'+row_num+'" class="input7" onchange="productSearch('+row_num+');" ><option value="">전체</option><option value="hardware">하드웨어</option><option value="software">소프트웨어</option></select></td></tr>';
			html += "<tr class=" + id3 + "><td colspan='10' height='1' bgcolor='#e8e8e8'></td></tr>"
			html += '<tr id='+id5+'><td colspan=2 height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">제품명</td><td align="left" class="t_border" style="padding-left:10px;" colspan="1">'
			html += '<select name ="product_name" id="product_name'+row_num+'" class="input7" onclick="productSearch('+row_num+');"><option value="" >제품선택</option></select></td>';
			html += "<td height='40' align='center' bgcolor='f8f8f9' class='t_border' style='font-weight:bold;'>라이선스</td><td align='left' class='t_border' style='padding-left:10px;'><input name='product_licence' type='text' class='input5' id='product_licence"+row_num+"' onkeyup ='commaCheck(this);' /> </td><td height='40' align='center' bgcolor='f8f8f9' class='t_border' style='font-weight:bold;'>Serial</td><td align='left' class='t_border' style='padding-left:10px;'><input name='product_serial' type='text' class='input5' id='product_serial"+row_num+"' onkeyup ='commaCheck(this);' /> </td><td height='40' align='center' bgcolor='f8f8f9' class='t_border' style='font-weight:bold;'>제품 상태</td><td align='left' class='t_border' style='padding-left:10px;'><select name='product_state' id='product_state"+row_num+"' class='input5' ><option value='0'>- 제품 상태 -</option><option value='001'>입고 전</option><option value='002'>창고</option><option value='003'>고객사 출고</option><option value='004'>장애반납</option></select></td><img src='<?php echo $misc; ?>img/btn_del0.jpg' style='cursor:pointer;' onclick='javascript:product_list_del(" + $("#row_max_index2").val() + ");'/></td></tr>";
			html += '<tr class=' + id3 + '><td colspan=2 height="40" class="t_border" align="center" bgcolor="f8f8f9" style="font-weight:bold;">장비유지보수시작일</td><td align="left" class="t_border" style="padding-left:10px;"><input name="maintain_begin" type="date" class="input7" id="maintain_begin'+row_num+'" /></td><td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">장비유지보수만료일</td><td align="left" class="t_border" style="padding-left:10px;"><input name="maintain_expire" type="date" class="input7" id="maintain_expire'+row_num+'" onchange="exceptionsaledateChange('+$("#row_max_index2").val()+','+"'expire'"+','+"''"+',this.value)" /></td>';
			html += '<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">유/무상</td><td align="left" class="t_border" style="padding-left:10px;"><select name="maintain_yn" id="maintain_yn'+row_num+'" class="input5"><option value="0">- 유/무상여부 -</option><option value="Y">유상</option><option value="N">무상</option></select></td>';
			html += '<td height="40" align="center" bgcolor="f8f8f9" class="t_border" style="font-weight:bold;">유지보수 대상</td><td align="left" class="t_border" style="padding-left:10px;"><select name="maintain_target" id="maintain_target'+row_num+'" class="input5"><option value="0">유지보수 대상</option><option value="Y">대상</option><option value="N">비대상</option></select></td></tr>';
			
			html += "<tr class=" + id3 + "><td colspan='10' height='1' bgcolor='#e8e8e8'></td></tr><tr id=" + id6 + "><td colspan=2 height='40' align='center' bgcolor='f8f8f9' class='t_border' style='font-weight:bold;'>유지보수매출가</tdheight=><td align='left' class='t_border' style='padding-left:10px;'><input name='product_sales' type='text' class='input5' id='product_sales"+row_num+"' value=0 onclick='numberFormat(this);' onchange='numberFormat(this);product_profit_change(1," + $("#row_max_index2").val() + ");' /></td><td height='40' align='center' bgcolor='f8f8f9' class='t_border' style='font-weight:bold;'>유지보수매입가</td><td align='left' class='t_border' style='padding-left:10px;'><input name='product_purchase' type='text' class='input5' id='product_purchase"+row_num+"' value=0 onclick='numberFormat(this);' onchange='numberFormat(this);product_profit_change(1," + $("#row_max_index2").val() + ");'/></td><td height='40' align='center' bgcolor='f8f8f9' class='t_border' style='font-weight:bold;'>유지보수마진</td><td align='left' class='t_border' style='padding-left:10px;'><input name='product_profit' type='text' class='input5' id='product_profit"+row_num+"' value=0 readonly/></td></tr>";
		
			html += "<tr class=" + id3 + "><td colspan=10 height='2' bgcolor='#797c88'></td></tr>";
			$('#input_point').before(html);
			$("#product_company"+row_num).select2();
			document.documentElement.scrollTop = document.body.scrollHeight; //스크롤 맨밑으로 내려
		});
	});

	function product_list_del(idx,product_seq) {
		if(product_seq){
			$("#delete_product_array").val($("#delete_product_array").val()+","+product_seq)
		}
		$(".product_insert_field_" + idx).remove();
		$("#product_insert_field_0_" + idx).remove();
		$("#product_insert_field_1_" + idx).remove();
		$("#product_insert_field_2_" + idx).remove();
		$("#product_insert_field_3_" + idx).remove();
		$("#product_insert_field_4_" + idx).remove();
		t_forcasting_profit_change();
		// $("#row_max_index2").val(Number(Number($("#row_max_index2").val()) - Number(1)));
	}

	//delete row(세금계산서)
	function deleteRow(obj, rowspanid, type) {
		if (type == 0) {
			var update_seq = "";
			var tr = $(obj).parent().parent();
			var change_num = tr.find($("input[name=pay_session]")).val();
			var cnt = tr.nextAll().find($("input[name=pay_session]")).length;
			for(var i=0; i<cnt; i++){
				var change_session = tr.nextAll().find($("input[name=pay_session]"))[i];
				var change_session_tr = $(change_session).parent().parent();
				if(change_session_tr.attr("class") == "insert_sales_bill" || change_session_tr.attr("class") == "update_sales_bill"){
					if(change_session_tr.attr("id").indexOf("bill_") !=-1){
						if(update_seq == ""){
							update_seq += change_session_tr.attr("id").replace("bill_","");
						}else{
							update_seq += ',' + change_session_tr.attr("id").replace("bill_","");
						}
					};
					$(change_session).val(change_num);
					change_num++;	
				}
			}
			tr.remove();
			var rowspan = Number($("#" + rowspanid).attr("rowspan"));
			$("#" + rowspanid).attr("rowSpan", rowspan - 1);
			updateSeq(update_seq);
		} else {
			var update_seq = "";
			var tr = $(obj).parent().parent();
			var trclass=tr.attr('class');
			var change_num = tr.find($("input[name=pay_session]")).val()
			var cnt = tr.nextAll().find($("input[name=pay_session]")).length;
			for(var i=0; i<cnt; i++){
				var change_session = tr.nextAll().find($("input[name=pay_session]"))[i];
				var change_session_tr = $(change_session).parent().parent();
				if(change_session_tr.attr('class').indexOf(trclass) != -1){
					if(change_session_tr.attr("id").indexOf("bill_") !=-1){
						if(update_seq == ""){
							update_seq += change_session_tr.attr("id").replace("bill_","");
						}else{
							update_seq += ',' + change_session_tr.attr("id").replace("bill_","");
						}
						
					};
					$(change_session).val(change_num);
					change_num++;
				}
			}
			tr.remove();
			var rowspan = Number($("#" + rowspanid).attr("rowspan"));
			$("." + rowspanid).attr("rowSpan", rowspan - 1);
			updateSeq(update_seq);
		}
	}

	//계싼서 추가
	function addRow(insertLine, rowspanid, type) {
		if (type == 0) {
			//나머지 금액구하기
			var total_amount = Number($("#sales_contract_total_amount").text().replace(/\,/g, ''));
			var remain_amount = total_amount;
			var row_num = $("input[name=sales_issuance_amount]").length + 1;
			for (var i=0; i<$("input[name=sales_issuance_amount]").length; i++) {
				remain_amount -= Number($("input[name=sales_issuance_amount]").eq(i).val().replace(/\,/g, ''));
			}

			if (remain_amount == 0) {
				alert("총 발행 금액이 계약 금액과 일치합니다.")
				return false;
			}

			var html = '<tr class="insert_sales_bill"><td height="40" class="basic_td" align="center"><input type="text" id="pay_session'+row_num +'" name="pay_session" class="input7" value="'+row_num+'" style="width:60%;text-align:center;" /></td>';
			html += '<td height="40" class="basic_td" align="right"><input type="text" id="sales_issuance_amount' +
				row_num + '" name="sales_issuance_amount" class="input7" style="text-align:right;" value="' +
				remain_amount + '" onchange="numberFormat(this);" /></td>';
			html += '<td height="40" class="basic_td" align="center"><input type="text" id="sales_tax_approval_number'+row_num+'" name="sales_tax_approval_number" class="input7" onchange="taxApprovalNumer(this,'+row_num+',0);" /></td>';
			html += '<td height="40" class="basic_td" align="center"><input type="text" id="sales_issuance_month' +
				row_num + '" name="sales_issuance_month" class="input7" style="text-align:center;" readonly/></td>';
			html += '<td height="40" class="basic_td" align="center"><input type="text" id="sales_issuance_date' +
				row_num + '" name="sales_issuance_date" class="input7" onchange="issuance_date_change(this,' + row_num +
				',0);" style="text-align:center;" readonly /></td>';
			html += '<td height="40" class="basic_td" align="center"><input type="hidden" id="sales_issuance_status' +
				row_num + '" name="sales_issuance_status" class="input7" value="N" /><span id="sales_issuance_YN' +
				row_num + '">미완료</span></td>';
			html += '<td height="40" class="basic_td" align="center"><input type="date" id="sales_deposit_date' +
				row_num + '" name="sales_deposit_date" class="input7" onchange="deposit_date_change(this,' + row_num +
				',0);"/></td>';
			html += '<td height="40" class="basic_td" align="center"><input type="hidden" id="sales_deposit_status' +
				row_num + '" name="sales_deposit_status" class="input7" value="N" /><span id="sales_deposit_YN' +
				row_num + '">미완료</span></td>';
			html +=
				'<td height="40" class="basic_td" align="center"><img src="<?php echo $misc; ?>img/btn_del0.jpg" onclick="deleteRow(this,' +
				"'sales_contract_total_amount'" + ',0);"/></td></tr>';


			var rowspan = Number($("#" + rowspanid).attr("rowspan"));
			$("#" + rowspanid).attr("rowSpan", rowspan + 1);

			$("#" + insertLine).before(html);
			$("#sales_issuance_amount" + row_num).trigger('change');
		} else {
			//나머지 금액구하기
			var row_num = insertLine.replace('purchase_tax_invoice', '');
			var session_num = $(".purchase_tax_invoice"+row_num).length+1; 
			var total_amount = Number($("#purchase_contract_total_amount" + row_num).text().replace(/\,/g, ''));
			var remain_amount = total_amount;
			var eq = $(".purchase_issuance_amount" + row_num).length;
			for (var i = 0; i < $(".purchase_issuance_amount" + row_num).length; i++) {
				remain_amount -= Number($(".purchase_issuance_amount" + row_num).eq(i).val().replace(/\,/g, ''));
			}

			if (remain_amount == 0) {
				alert("총 발행 금액이 계약 금액과 일치합니다.")
				return false;
			}

			var purchase_company_name = $("."+rowspanid).eq(0).text().trim();

			var html = '<tr class="purchase_tax_invoice' + row_num +
				' insert_purchase_bill"><td height="40" class="basic_td" align="center"><input type="hidden" name="purchase_company_name" value="'+purchase_company_name+'" /><input type="text" id="pay_session'+row_num +'" name="pay_session" class="input7" value="'+session_num+'" style="width:60%;text-align:center;" /></td>';
			html +=
				'<td height="40" class="basic_td" align="right"><input type="text" class="purchase_issuance_amount' +
				row_num + ' input7" name="purchase_issuance_amount" style="text-align:right;" value="' + remain_amount +
				'" onchange="numberFormat(this);" /></td>';
				html += '<td height="40" class="basic_td" align="center"><input type="text" name="purchase_tax_approval_number" class="purchase_tax_approval_number'+row_num+' input7" onchange="taxApprovalNumer(this,'+row_num+',1);" /></td>';
			html +=
				'<td height="40" class="basic_td" align="center"><input type="text" class="purchase_issuance_month' +
				row_num + ' input7" name="purchase_issuance_month" style="text-align:center;" readonly/></td>';
			html += '<td height="40" class="basic_td" align="center"><input type="text" class="purchase_issuance_date' +
				row_num + ' input7" name="purchase_issuance_date" onchange="issuance_date_change(this,' + row_num +
				',1);" style="text-align:center;" readonly /></td>';
			html +=
				'<td height="40" class="basic_td" align="center"><input type="hidden" class="purchase_issuance_status' +
				row_num + ' input7" name="purchase_issuance_status" value="N" /><span class="purchase_issuance_YN' +
				row_num + '">미완료</span></td>';
			html += '<td height="40" class="basic_td" align="center"><input type="date" class="purchase_deposit_date' +
				row_num + ' input7" name="purchase_deposit_date" onchange="deposit_date_change(this,' + row_num +
				',1);"/></td>';
			html +=
				'<td height="40" class="basic_td" align="center"><input type="hidden" class="purchase_deposit_status' +
				row_num + ' input7" name="purchase_deposit_status" value="N" /><span class="purchase_deposit_YN' +
				row_num + '">미완료</span></td>';
			html +=
				'<td height="40" class="basic_td" align="center"><img src="<?php echo $misc; ?>img/btn_del0.jpg" onclick="deleteRow(this,' +
				"'purchase_contract_total_amount" + row_num + "'" + ',1);"/></td></tr>';


			var rowspan = Number($("#" + rowspanid).attr("rowspan"));
			$("." + rowspanid).attr("rowSpan", rowspan + 1);

			$("." + insertLine).eq($("." + insertLine).length - 1).after(html);
			$(".purchase_issuance_amount" + row_num).eq(eq).trigger('change');
		}
	}
	//금액 천단위 마다 ,
	function numberFormat(obj) {
		if (obj.value == "") {
			obj.value = 0;
		}
		var inputNumber = obj.value.replace(/,/g, "");
		var fomatnputNumber = inputNumber.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, "$1,");
		obj.value = fomatnputNumber;
	}

	//국세청 승인번호
	function taxApprovalNumer(obj, num, type){
		$(obj).val(trim($(obj).val()))
		var date = $(obj).val().split("-")[0];
		date = date.replace(/(\d{4})(\d{2})(\d{2})/, '$1-$2-$3');
		
		if(type == 0){
			$("#sales_issuance_date"+num).val(date);
			$("#sales_issuance_date"+num).change();
		}else{
			var className = trim($(obj).attr('class').replace('input7', ''));
			var eq = $('.' + className).index(obj);
			$(".purchase_issuance_date"+num).eq(eq).val(date);
			$(".purchase_issuance_date"+num).eq(eq).change();
		}
	}
	//발행일자 change
	function issuance_date_change(obj, num, type) {
		if (type == 0) {
			var val = $(obj).val();
			val = val.substring(0, val.length - 3);
			$('#sales_issuance_month' + num).val(val);
			$("#sales_issuance_status" + num).val("Y");
			$("#sales_issuance_YN" + num).text("완료")
		} else {
			var className = trim($(obj).attr('class').replace('input7', ''));
			var eq = $('.' + className).index(obj);
			var val = $(obj).val();
			val = val.substring(0, val.length - 3);

			$('.purchase_issuance_month' + num).eq(eq).val(val);
			$(".purchase_issuance_status" + num).eq(eq).val("Y");
			$(".purchase_issuance_YN" + num).eq(eq).text("완료")
		}
	}

	//입금일자 change
	function deposit_date_change(obj, num, type) {
		if (type == 0) {
			$("#sales_deposit_status" + num).val("Y");
			$("#sales_deposit_YN" + num).text("완료");
		} else {
			var className = trim($(obj).attr('class').replace('input7', ''));
			var eq = $('.' + className).index(obj);
			console.log(eq);
			$(".purchase_deposit_status" + num).eq(eq).val("Y");
			$(".purchase_deposit_YN" + num).eq(eq).text("완료");
		}
	}
	
	//업데이트 되는 seq 가져오기
	function updateSeq(seq){
		if(trim($("#update_seq").val()) == ""){
			$("#update_seq").val(seq);
		}else{
			$("#update_seq").val($("#update_seq").val()+','+seq);
		}
		console.log($("#update_seq").val())
	}

	//delete 되는 seq 가져왕
	function deleteSeq(seq){
		if(trim($("#delete_bill_array").val()) == ""){
			$("#delete_bill_array").val(seq);
		}else{
			$("#delete_bill_array").val($("#delete_bill_array").val()+','+seq);
		}
	}
</script>
</body>
</html>