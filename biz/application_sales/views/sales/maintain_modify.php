<?php
include $this->input->server('DOCUMENT_ROOT') . "/include/base.php";
include $this->input->server('DOCUMENT_ROOT') . "/include/sales_top.php";
?>
<link rel="stylesheet" href="<?php echo $misc;?>css/view_page_common.css">
<style type="text/css">
.input-common {
  width: 98.5%;
}
.textarea-common {
  width: 98.5%;
}
.select-common {
  width: 99%;
}
.product_tbl td {
  text-align:center;
  padding-left:5px;
  padding-right:5px;
}
<?php if ($_GET['type'] == '8'){ ?>
  .input-common {
    width: 80.5% !important;
  }
  .textarea-common {
    width: 80.5% !important;
  }
  .select-common {
    width: 81% !important;
  }
  .date_input {
    width: 122px !important;
  }
<?php } else if ($_GET['type'] == '5') { ?>
  #check_product_info {
    margin-left:10px;
    font-size:12px;
    font-weight: normal;
    color: #0575E6;
  }
<?php } ?>
.change_collective {
  background-color: rgb(250, 162, 162);
}
.change_collective ~ span .select2-selection--single {
  background-color: rgb(250, 162, 162) !important;
}
</style>
<script type="text/javascript" src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/js/select2.min.js"></script>
<script src="<?php echo $misc;?>js/excel/excel-bootstrap-table-filter-bundle.js"></script>
<link rel="stylesheet" href="<?php echo $misc;?>js/excel/excel-bootstrap-table-filter-style.css" />
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
function chkDel() {
    if (confirm("등록된 모든 코멘트들도 삭제됩니다. 정말 삭제하시겠습니까?") == true) {
        <?php
			if($complete_status_val){
			 	foreach($complete_status_val as $item){ ?>
        filedel('<?php echo $item['seq']; ?>', '<?php echo $item['file_change_name']; ?>')
        <?php }} ?>
        var mform = document.cform;
        mform.action = "<?php echo site_url(); ?>/sales/maintain/maintain_delete_action";
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


var doubleSubmitFlag = false;
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
		// var objpurchase_pay_session = document.getElementsByName("purchase_pay_session");

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
				$("#update_main_array").val($("#update_main_array").val() + "||" + objmain_companyname[i].value + "~" + objmain_username[i].value + "~" + objmain_tel[i].value + "~" + objmain_email[i].value + "~" + objmain_seq[i].value );
			}
		}

		$("#insert_main_array").val('');
		if (objmain_companyname.length > objmain_seq.length) {
			for (var i = objmain_seq.length; i < objmain_companyname.length; i++) {
				$("#insert_main_array").val($("#insert_main_array").val() + "||" +"<?php echo $view_val['forcasting_seq'];?>" + "~" +objmain_companyname[i].value + "~" + objmain_username[i].value + "~" + objmain_tel[i].value + "~"+ objmain_email[i].value);
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
		var objcomment = document.getElementsByName("comment");

		var regex3 = /^[0-9]+$/;

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
				// if ($.trim(objproduct_name[i].value) == "0" || $.trim(objproduct_name[i].value) == "") {
				// 	alert(i + 1 + '번째 제품명을 선택해주세요..');
				// 	objproduct_name[i].focus();
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
					objproduct_product_profit[i].value.replace(/,/g, "") + "~" + objcomment[i].value + "~" + objproduct_seq[i].value);
			}
		}

		$("#insert_product_array").val('');
		if (objproduct_name.length > objproduct_seq.length) {
			for (var i = objproduct_seq.length; i < objproduct_name.length; i++) {
				$("#insert_product_array").val($("#insert_product_array").val() + "||" +"<?php echo $_GET['seq']; ?>"+"~"+"<?php echo $_GET['seq']; ?>"+"~"+"<?php echo $view_val['forcasting_seq']; ?>"+"~"+ objproduct_name[i].value + "~"+objproduct_supplier[i].value + "~" + objproduct_licence[i].value + "~" + objproduct_serial[i].value + "~" + objproduct_state[i].value + "~"
				 + objproduct_maintain_begin[i].value.split(' ')[0] + "~" + objproduct_maintain_expire[i].value.split(' ')[0] + "~" + objproduct_maintain_yn[i].value + "~" + objproduct_maintain_target[i].value + "~" +
				+ objproduct_product_sales[i].value.replace(/,/g, "") + "~" + objproduct_product_purchase[i].value.replace(/,/g, "") + "~" + objproduct_product_profit[i].value.replace(/,/g, "")+"~"+objcomment[i].value);
			}
		}
	}else if("<?php echo $_GET['type'] ;?>" == "6"){ //수주 정보
		if (mform.complete_status.value == "0") {
			mform.complete_status.focus();
			alert("수주여부를 선택해 주세요.");
			return false;
		}
	}else if ("<?php echo $_GET['type'] ;?>" == "8"){ //계산서 발행 정보
    if(doubleSubmitFlag){
        return false;
    } else {
        doubleSubmitFlag = true;
		//매입처 발행주기 update
		var issue_cycle = "";
		<?php foreach($view_val2 as $item2){?>
			issue_cycle += ",<?php echo $item2['seq']; ?>||"+$("#purchase_issue_cycle_<?php echo $item2['seq']; ?>").val()+"||"+$("#purchase_pay_session_<?php echo $item2['seq']; ?>").val();
		<?php } ?>
		issue_cycle = issue_cycle.replace(",","");
		$("#purchase_issue_cycle").val(issue_cycle);


		// insert
		var insertObject = new Object();
		var insert_bill_total = [];
		if($(".insert_sales_bill").length > 0 || $(".insert_purchase_bill").length > 0){
			var i = 0;
			for (i = 0; i < $(".insert_sales_bill").length; i++) {
				if($(".insert_sales_bill").find(".empty_row").length < 1){
					var type = "001";
					var company_name = "<?php echo $view_val['sales_companyname']; ?>";
					var pay_session = $(".insert_sales_bill").eq(i).find('input[name=pay_session]').val();
					var issuance_amount = $(".insert_sales_bill").eq(i).find('input[name=sales_issuance_amount]').val();
					var tax_amount = $(".insert_sales_bill").eq(i).find('input[name=sales_tax_amount]').val();
					var total_amount = $(".insert_sales_bill").eq(i).find('input[name=sales_total_amount]').val();
					var tax_approval_number = $(".insert_sales_bill").eq(i).find('input[name=sales_tax_approval_number]').val();
					var issuance_month = $(".insert_sales_bill").eq(i).find('input[name=sales_issuance_month]').val();
					var issuance_date = $(".insert_sales_bill").eq(i).find('input[name=sales_issuance_date]').val();
					var issuance_status = $(".insert_sales_bill").eq(i).find('input[name=sales_issuance_status]').val();
					var deposit_date = $(".insert_sales_bill").eq(i).find('input[name=sales_deposit_date]').val();
					var deposit_status = $(".insert_sales_bill").eq(i).find('input[name=sales_deposit_status]').val();
					var issue_schedule_date = $(".insert_sales_bill").eq(i).find('input[name=issue_schedule_date]').val();
					insert_bill_total.push(type+"||"+company_name+"||"+pay_session+"||"+issuance_amount+"||"+tax_amount+"||"+total_amount+"||"+tax_approval_number+"||"+issuance_month+"||"+issuance_date+"||"+issuance_status+"||"+deposit_date+"||"+deposit_status+"||"+issue_schedule_date);
				}
			}

			for(var j=0; j< $(".insert_purchase_bill").length; j++){
				if($(".insert_purchase_bill").eq(j).find('input[name=pay_session]').length > 0){
					var type = "002";
					var company_name = $(".insert_purchase_bill").eq(j).find('input[name=purchase_company_name]').val();
					var pay_session = $(".insert_purchase_bill").eq(j).find('input[name=pay_session]').val();
					var issuance_amount = $(".insert_purchase_bill").eq(j).find('input[name=purchase_issuance_amount]').val();
					var tax_amount = $(".insert_purchase_bill").eq(j).find('input[name=purchase_tax_amount]').val();
					var total_amount = $(".insert_purchase_bill").eq(j).find('input[name=purchase_total_amount]').val();
					var tax_approval_number = $(".insert_purchase_bill").eq(j).find('input[name=purchase_tax_approval_number]').val();
					var issuance_month = $(".insert_purchase_bill").eq(j).find('input[name=purchase_issuance_month]').val();
					var issuance_date = $(".insert_purchase_bill").eq(j).find('input[name=purchase_issuance_date]').val();
					var issuance_status = $(".insert_purchase_bill").eq(j).find('input[name=purchase_issuance_status]').val();
					var deposit_date = $(".insert_purchase_bill").eq(j).find('input[name=purchase_deposit_date]').val();
					var deposit_status = $(".insert_purchase_bill").eq(j).find('input[name=purchase_deposit_status]').val();
					var issue_schedule_date = $(".insert_purchase_bill").eq(j).find('input[name=issue_schedule_date]').val();
					insert_bill_total.push(type+"||"+company_name+"||"+pay_session+"||"+issuance_amount+"||"+tax_amount+"||"+total_amount+"||"+tax_approval_number+"||"+issuance_month+"||"+issuance_date+"||"+issuance_status+"||"+deposit_date+"||"+deposit_status+"||"+issue_schedule_date);
					i++;
				}
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
			var real_num = 0;
			for (var i = 0; i < update_seq.length; i++) {
				var seq = update_seq[i];
				if($("#bill_"+seq).length > 0){
					if($("#bill_"+seq).attr("class").indexOf("purchase") != -1 ){
						mode = "purchase";
					}else{
						mode = "sales";
					}
					var pay_session = $("#bill_"+seq).find('input[name=pay_session]').val();
					var issuance_amount = $("#bill_"+seq).find('input[name='+mode+'_issuance_amount]').val();
					var tax_amount = $("#bill_"+seq).find('input[name='+mode+'_tax_amount]').val();
					var total_amount = $("#bill_"+seq).find('input[name='+mode+'_total_amount]').val();
					var tax_approval_number = $("#bill_"+seq).find('input[name='+mode+'_tax_approval_number]').val();
					var issuance_month = $("#bill_"+seq).find('input[name='+mode+'_issuance_month]').val();
					var issuance_date = $("#bill_"+seq).find('input[name='+mode+'_issuance_date]').val();
					var issuance_status = $("#bill_"+seq).find('input[name='+mode+'_issuance_status]').val();
					var deposit_date = $("#bill_"+seq).find('input[name='+mode+'_deposit_date]').val();
					var deposit_status = $("#bill_"+seq).find('input[name='+mode+'_deposit_status]').val();
					var issue_schedule_date = $("#bill_"+seq).find('input[name=issue_schedule_date]').val();
					update_bill_total[real_num] = seq +"||"+pay_session+"||"+issuance_amount+"||"+tax_amount+"||"+total_amount+"||"+tax_approval_number+"||"+issuance_month+"||"+issuance_date+"||"+issuance_status+"||"+deposit_date+"||"+deposit_status+"||"+issue_schedule_date;
					real_num++;
				}
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
	}
	// return false;
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

    rform.action = "<?php echo site_url(); ?>/sales/maintain/maintain_comment_action";
    rform.submit();
    return false;
}

function chkForm3(seq) {
    if (confirm("정말 삭제하시겠습니까?") == true) {
        var rform = document.rform;
        rform.cseq.value = seq;
        rform.action = "<?php echo site_url(); ?>/sales/maintain/maintain_comment_delete";
        rform.submit();
        return false;
    }
}


// 고객사 등록되있는건지 확인해서 인풋 보여줄지 말지
  $(document).ready(function(){
    var customer = $("#select_customer_company").val();
    var customer_staff = $("#select_customer_user").val();
    if(customer == ""){
      $("#customer_companyname").prop('type','text');
    }else{
      $("#customer_companyname").prop('type','hidden');
    }
    if(customer_staff == "" ){
      $("#customer_username").prop('type','text');
    }else{
      $("#customer_username").prop('type','hidden');
    }

  })

  // 고객사 변경시 바뀌는거
  function selectCustomerCompany(type){

    if (type == 'company') {
      $('#customer_seq_hidden').val("");

      var customer_name = $("#select_customer_company option:selected").text();

      $("#customer_companyname").val(customer_name);
    }

    if($('#customer_seq_hidden').val() != ""){
      var seq = $('#customer_seq_hidden').val();
    }else{
      var seq = $("#select_customer_company").val();

    }
    // alert(seq + customer_name);
    if(type == 'company'){
      $("#customer_username").val("");
      $("#customer_tel").val("");
      $("#customer_email").val("");
      if(seq ==""){
        $("#customer_companyname").prop('type','text');
        $("#customer_companyname").val('');
        $("#customer_username").prop('type','text');
        $("#select_customer_user option:not(:first)").remove();
      }
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
        if (type=="company") {

          var html = "<option value='' selected>담당자 선택</option>";
          if(data.length == 0 ){
            $("#customer_username").prop('type','text');
          }else{
            $("#customer_username").prop('type','hidden');
          }
          for (i = 0; i < data.length; i++) {
            html += "<option value=" + data[i].seq + ">" + data[i].user_name + "</option>";
          }
          $("#select_customer_user").html(html);
        }

        if(type=="staff"){
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
            }
          }
        });
      }
</script>
<body>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="100%" align="center" valign="top">
      <!--내용-->
      <table width="100%" border="0" style="padding:50px;">
        <!--타이틀-->
        <tr>
          <td class="title3">유지보수</td>
        </tr>
        <!--//타이틀-->
        <tr>
            <td>&nbsp;</td>
        </tr>
				<tr>
					<td align="right">
            <input type="button" class="btn-common btn-color1" width="64" height="31" style="cursor:pointer;margin-right:10px;" onclick="popup_close();" value="취소" />
						<input type="button" class="btn-common btn-color2" width="64" height="31" style="cursor:pointer" onclick="javascript:chkForm();return false;" value="수정" />
					</td>
				</tr>
        <!--작성-->
        <tr>
          <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="main_list">
              <form name="cform" action="<?php echo site_url(); ?>/sales/maintain/maintain_input_action" method="post" onSubmit="javascript:chkForm();return false;">
								<input type="hidden" id="insert_main_array" name="insert_main_array" />
                <input type="hidden" id="update_main_array" name="update_main_array" />
                <input type="hidden" id="delete_main_array" name="delete_main_array" />
                <input type="hidden" id="update_product_array" name="update_product_array" />
								<input type="hidden" id="insert_product_array" name="insert_product_array" />
								<input type="hidden" id="delete_product_array" name="delete_product_array" />
                <input type="hidden" id="update_sub_product_array" name="update_sub_product_array" />
								<input type="hidden" name="seq" value="<?php echo $seq; ?>">
								<input type="hidden" id="purchase_issue_cycle" name="purchase_issue_cycle" value="" />
								<?php if(isset($_GET['type'])){
									echo "<input type='hidden' name='data_type' value='{$_GET['type']}' />";
								}?>
                <!-- <colgroup>
                  <col width="10%" />
                  <?php
                  if($_GET['type'] == '8'){
                    echo '<col width="10%" /><col width="3%" />';
                  }else{
                    echo '<col width="13%" />';
                  }
                  ?>
                  <col width="10%" />
                  <col width="12%" />
                  <col width="10%" />
                  <col width="15%" />
                  <col width="10%" />
                  <col width="5%" />
                  <col width="10%" />
                  <col width="5%" />
                </colgroup> -->
                <?php if($_GET['type'] == '1'){ ?>
                <colgroup>
                  <col width="20%">
  								<col width="80%">
                </colgroup>
                <tr>
                  <td class="tbl-sub-title">고객사 정보</td>
                  <input type="hidden" id="customer_seq_hidden" value="<?php echo $view_val['customer_seq']; ?>">
                </tr>
                <tr class="tbl-tr cell-tr border-t">
                  <td class="tbl-title">고객사</td>
                  <td class="tbl-cell">
                    <select id="select_customer_company" name="select_customer_company" class="input7" onchange="selectCustomerCompany('company');" />
                      <option value=''>고객사 선택</option>
                      <?php
                       $selected_company = $view_val['customer_companyname'];
                       foreach($sales_customer as $sc){
                         if ($selected_company == $sc['company_name']) {
                           $select = " selected";
                         }else{
                           $select = "";
                         }
                        echo "<option value='{$sc['seq']}'{$select}>{$sc['company_name']}</option>";
                      }
                      ?>
                    </select>
                    <input name="customer_companyname" type="hidden" class="input7" id="customer_companyname" value="<?php echo $view_val['customer_companyname']; ?>" />
                  </td>
								</tr>
								<tr class="tbl-tr cell-tr">
									<td class="tbl-title">담당자</td>
                  <td class="tbl-cell">
                    <select id="select_customer_user" name="select_customer_user" class="select-common" onchange="selectCustomerCompany('staff');"/>
                      <option value=''>담당자 선택</option>
                      <?php
                      if (isset($customer_staff)) {
                        $selected_staff = $view_val['customer_username'];
                        foreach ($customer_staff as $cs) {
                          if ($selected_staff == $cs['user_name']) {
                            $select = " selected";
                          }else{
                            $select = "";
                          }
                          echo "<option value='{$cs['seq']}'{$select}>{$cs['user_name']}</option>";
                        }
                      }
                       ?>
                    </select>
                    <input name="customer_username" type="text" class="input-common" id="customer_username" value="<?php echo $view_val['customer_username']; ?>" />
                  </td>
								</tr>
								<tr class="tbl-tr cell-tr">
									<td class="tbl-title">연락처</td>
                  <td class="tbl-cell"><input type="text" name="customer_tel" id="customer_tel" class="input-common" value="<?php echo $view_val['customer_tel']; ?>" onclick="checkNum(this);" onKeyUp="checkNum(this);" /></td>
								</tr>
								<tr class="tbl-tr cell-tr">
									<td class="tbl-title">이메일</td>
                  <td class="tbl-cell"><input type="text" name="customer_email" id="customer_email" class="input-common" value="<?php echo $view_val['customer_email']; ?>" /></td>
                </tr>


					<?php }else if($_GET['type'] == '2'){ ?>
                <colgroup>
                  <col width="18%">
  								<col width="32%">
  								<col width="18%">
  								<col width="32%">
                </colgroup>
								<tr>
                  <td class="tbl-sub-title">영업 정보</td>
                </tr>
                <tr class="tbl-tr cell-tr border-t">
                  <td class="tbl-title">프로젝트</td>
                  <td class="tbl-cell">
                    <input name="project_name" type="text" class="input-common" id="project_name" value="<?php echo $view_val['project_name']; ?>"/>
                  </td>
                  <td class="tbl-title">연계프로젝트</td>
                  <td class="tbl-cell">
                    <input type="hidden" name="subProjectAddInput" id="subProjectAddInput" value=''></input>
                    <input type="hidden" id="subProjectRemoveInput" name="subProjectRemoveInput" value='' />
                    <select id="sub_project_add" class="select-common" onchange="subProjectAdd()">
                      <option value="0">조회추가</option>
                      <?php
                      foreach ($sub_project as $val) {
                      echo '<option value="' . $val['seq'] . '">'. $val['customer_companyname'].'-' . $val['project_name'] . '</option>';
                      }
                      ?>
                    </select>
                    <select id="sub_project_remove" class="select-common" onchange="subProjectRemove()">
                      <option>조회취소</option>
                      <?php
                      foreach ($sub_project_cancel as $val) {
                      echo '<option value="' . $val['seq'] . '">'. $val['customer_companyname'].'-' . $val['project_name'] . '</option>';
                      }
                      ?>
                    </select>
                  </td>
                </tr>
                <tr class="tbl-tr cell-tr">
                  <td class="tbl-title">진척단계</td>
									<td class="tbl-cell">
										<select name="progress_step" id="progress_step" class="select-common">
                      <option value="0">-진척단계-</option>
                      <option value="001" <?php if ($view_val['progress_step'] == "001") {echo "selected";} ?>>영업보류(0%)</option>
                      <option value="002" <?php if ($view_val['progress_step'] == "002") {echo "selected";} ?>>고객문의(5%)</option>
                      <option value="003" <?php if ($view_val['progress_step'] == "003") {echo "selected";} ?>>영업방문(10%)</option>
                      <option value="004" <?php if ($view_val['progress_step'] == "004") {echo "selected";} ?>>일반제안(15%)</option>
                      <option value="005" <?php if ($view_val['progress_step'] == "005") {echo "selected";} ?>>견적제출(20%)</option>
                      <option value="006" <?php if ($view_val['progress_step'] == "006") {echo "selected";} ?>>맞춤제안(30%)</option>
                      <option value="007" <?php if ($view_val['progress_step'] == "007") {echo "selected";} ?>>수정견적(35%)</option>
                      <option value="008" <?php if ($view_val['progress_step'] == "008") {echo "selected";} ?>>RFI(40%)</option>
                      <option value="009" <?php if ($view_val['progress_step'] == "009") {echo "selected";} ?>>RFP(45%)</option>
                      <option value="010" <?php if ($view_val['progress_step'] == "010") {echo "selected";} ?>>BMT(50%)</option>
                      <option value="011" <?php if ($view_val['progress_step'] == "011") {echo "selected";} ?>>DEMO(55%)</option>
                      <option value="012" <?php if ($view_val['progress_step'] == "012") {echo "selected";} ?>>가격경쟁(60%)</option>
                      <option value="013" <?php if ($view_val['progress_step'] == "013") {echo "selected";} ?>>Spec in(70%)</option>
                      <option value="014" <?php if ($view_val['progress_step'] == "014") {echo "selected";} ?>>수의계약(80%)</option>
                      <option value="015" <?php if ($view_val['progress_step'] == "015") {echo "selected";} ?>>수주완료(85%)</option>
                      <option value="016" <?php if ($view_val['progress_step'] == "016") {echo "selected";} ?>>매출발생(90%)</option>
                      <option value="017" <?php if ($view_val['progress_step'] == "017") {echo "selected";} ?>>미수잔금(95%)</option>
                      <option value="018" <?php if ($view_val['progress_step'] == "018") {echo "selected";} ?>>수금완료(100%)</option>
										</select>
                    <input type="hidden" name="original_progress_step" value="<?php echo $view_val['progress_step']; ?>">
									</td>
                  <td class="tbl-title">판매종류</td>
									<td class="tbl-cell">
										<select name="type" id="type" class="select-common" onclick="project_type(this.value);">
											<option value="0" <?php if ($view_val['type'] == "0") {echo "selected";} ?>>선택없음</option>
											<option value="1" <?php if ($view_val['type'] == "1") {echo "selected";} ?>>판매</option>
											<option value="2" <?php if ($view_val['type'] == "2") {echo "selected";} ?>>용역</option>
											<option value="3" <?php if ($view_val['type'] == "3") {echo "selected";} ?>>유지보수</option>
											<option value="4" <?php if ($view_val['type'] == "4") {echo "selected";} ?>>조달</option>
										</select>
											<div id="procurement" style="<?php if($view_val['type'] != "4"){echo "display:none;"; } ?>">
												조달 판매 금액(VAT포함) :
												<input type="text" id="procurement_sales_amount" class="input-common" name="procurement_sales_amount" value="<?php echo $view_val['procurement_sales_amount']; ?>" oninput="if(this.value != '0'){this.value = this.value.replace(/^0+|\D+/g, '').replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,')}" style="width:200px;" />
											</div>
										</td>
                  </tr>
                  <tr class="tbl-tr cell-tr">
                    <td class="tbl-title">영업업체</td>
                    <td class="tbl-cell">
                      <select name="cooperation_companyname" id="cooperation_companyname" class="select-common">
                        <option value="" <?php if ($view_val['cooperation_companyname'] == " ") echo "selected"; ?>>선택하세요</option>
                        <option value="두리안정보기술" <?php if ($view_val['cooperation_companyname'] == "두리안정보기술") echo "selected"; ?>>두리안정보기술</option>
                        <option value="두리안정보통신기술" <?php if ($view_val['cooperation_companyname'] == "두리안정보통신기술") echo "selected"; ?>>두리안정보통신기술</option>
                        <option value="더망고" <?php if ($view_val['cooperation_companyname'] == "더망고") echo "selected"; ?>>더망고</option>
                      </select>
                    </td>
                    <td class="tbl-title">영업담당자</td>
                    <td class="tbl-cell">
                        <input name="cooperation_username" type="text" class="input-common" id="cooperation_username" value="<?php echo $view_val['cooperation_username']; ?>" />
										</td>
									</tr>
									<tr class="tbl-tr cell-tr">
                    <td class="tbl-title">사업부</td>
                    <td class="tbl-cell">
                      <select name="dept" id="dept" class="select-common">
                        <option value="" <?php if ($view_val['dept'] == "") echo "selected" ?>>선택하세요</option>
                        <option value="사업1부" <?php if ($view_val['dept'] == "사업1부") echo "selected" ?>>사업1부</option>
                        <option value="사업2부" <?php if ($view_val['dept'] == "사업2부") echo "selected" ?>>사업2부</option>
                        <option value="ICT" <?php if ($view_val['dept'] == "ICT") echo "selected" ?>>ICT</option>
                        <option value="MG" <?php if ($view_val['dept'] == "MG") echo "selected" ?>>MG</option>
                        <option value="기술지원부" <?php if ($view_val['dept'] == "기술지원부") echo "selected" ?>>기술지원부</option>
                      </select>
                      <input name="cooperation_tel" type="hidden" class="input5" id="cooperation_tel" value="<?php echo $view_val['cooperation_tel']; ?>" />
                    </td>
                    <td class="tbl-title">정보통신공사업</td>
                    <td class="tbl-cell">
                      <input type="radio" name="infor_comm_corporation" value="Y" <?php if($view_val['infor_comm_corporation'] == "Y"){echo "checked"; } ?> /> 신청
                      <input type="radio" name="infor_comm_corporation" value="N" <?php if($view_val['infor_comm_corporation'] == "N"){echo "checked"; } ?> /> 미신청
                    </td>
									</tr>
									<?php }else if($_GET['type'] == '7'){ ?>
                  <colgroup>
                    <col width="20%">
    								<col width="80%">
                  </colgroup>
									<tr>
                    <td class="tbl-sub-title">점검 정보</td>
                  </tr>
                  <tr class="tbl-tr cell-tr border-t">
                    <td class="tbl-title">관리팀</td>
										<td class="tbl-cell">
											<select  name="manage_team" id="manage_team" class="select-common">
                        <option value="0" selected>담당팀선택</option>
                        <option value="1" <?php if ($view_val['manage_team'] == "1") {echo "selected";} ?>>기술 1팀</option>
                        <option value="2" <?php if ($view_val['manage_team'] == "2") {echo "selected";} ?>>기술 2팀</option>
                        <option value="3" <?php if ($view_val['manage_team'] == "3") {echo "selected";} ?>>기술 3팀</option>
											</select>
										</td>
									</tr>
									<tr class="tbl-tr cell-tr">
                    <td class="tbl-title">점검주기</td>
                    <td class="tbl-cell">
											<select name="maintain_cycle" id="maintain_cycle" class="select-common">
                        <option value="9" selected>- 점검주기선택-</option>
                        <option value="1" <?php if ($view_val['maintain_cycle'] == "1") { echo "selected"; } ?>>월점검</option>
                        <option value="3" <?php if ($view_val['maintain_cycle'] == "3") { echo "selected"; } ?>>분기점검</option>
                        <option value="6" <?php if ($view_val['maintain_cycle'] == "6") { echo "selected"; } ?>>반기점검</option>
                        <option value="0" <?php if ($view_val['maintain_cycle'] == "0") { echo "selected"; } ?>>장애시</option>
                        <option value="7" <?php if ($view_val['maintain_cycle'] == "7") { echo "selected"; } ?>>미점검</option>
											</select>
										</td>
									</tr>
									<tr class="tbl-tr cell-tr">
                    <td class="tbl-title">점검일자</td>
										<td class="tbl-cell">
											<input name="maintain_date" type="date" class="input-common" id="maintain_date" value="<?php echo $view_val['maintain_date']; ?>" />
										</td>
									</tr>
									<tr class="tbl-tr cell-tr">
                    <td class="tbl-title">점검자</td>
										<td class="tbl-cell">
											<input name="maintain_user" type="text" class="input-common" id="maintain_user" value="<?php echo $view_val['maintain_user']; ?>" />
										</td>
									</tr>
									<tr class="tbl-tr cell-tr">
                    <td class="tbl-title">점검방법</td>
										<td class="tbl-cell">
											<select name="maintain_type" id="maintain_type" class="select-common">
												<option value="9" selected>- 점검방법선택 -</option>
												<option value="1" <?php if ($view_val['maintain_type'] == "1") {echo "selected";} ?>>방문점검</option>
												<option value="2" <?php if ($view_val['maintain_type'] == "2") {echo "selected";} ?>>원격점검</option>
											</select>
										</td>
									</tr>
									<tr class="tbl-tr cell-tr">
                    <td class="tbl-title">점검여부</td>
										<td class="tbl-cell">
											<select name="maintain_result" id="maintain_result" class="select-common">
												<option value="" selected>- 점검여부선택 -</option>
												<option value="1" <?php if ($view_val['maintain_result'] == "1") {echo "selected";} ?>>완료</option>
												<option value="0" <?php if ($view_val['maintain_result'] == "0") {echo "selected";} ?>>미완료</option>
												<option value="2" <?php if ($view_val['maintain_result'] == "2") {echo "selected";} ?>>미해당</option>
												<option value="9" <?php if ($view_val['maintain_result'] == "9") {echo "selected";} ?>>예정</option>
												<option value="3" <?php if ($view_val['maintain_result'] == "3") {echo "selected";} ?>>연기</option>
												<option value="4" <?php if ($view_val['maintain_result'] == "4") {echo "selected";} ?>>협력사 점검</option>
											</select>
										</td>
									</tr>
									<tr class="tbl-tr cell-tr">
                    <td class="tbl-title">점검코멘트</td>
										<td class="tbl-cell">
											<textarea name="maintain_comment" id="maintain_comment" class="textarea-common" ><?php echo $view_val['maintain_comment']; ?></textarea>
										</td>
									</tr>

									<?php }else if($_GET['type'] == '3'){ ?>
                  <colgroup>
                    <col width="20%">
    								<col width="80%">
                  </colgroup>
									<tr>
                    <td class="tbl-sub-title">매출처 정보</td>
                  </tr>
                  <tr class="tbl-tr cell-tr border-t">
                    <td class="tbl-title" style="height:70px;">매출처</td>
                    <td class="tbl-cell">
                      <select id="select_sales_company" class="select-common" onchange="selectSalesCompany(this); ">
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
                      <input name="sales_companyname" type="text" class="input-common" id="sales_companyname" value="<?php echo $view_val['sales_companyname']; ?>" />
										</td>
									</tr>
									<tr class="tbl-tr cell-tr">
                    <td class="tbl-title" style="height:70px;">담당자</td>
                    <td class="tbl-cell">
                      <select id="select_sales_user" class="select-common">
                        <option value="">담당자 선택</option>
                      </select>
                      <input name="sales_username" type="text" class="input-common" id="sales_username" value="<?php echo $view_val['sales_username']; ?>" />
										</td>
									</tr>
									<tr class="tbl-tr cell-tr">
                    <td class="tbl-title">연락처</td>
										<td class="tbl-cell">
											<input name="sales_tel" type="text" class="input-common" id="sales_tel" value="<?php echo $view_val['sales_tel']; ?>" onclick="checkNum(this);" onKeyUp="checkNum(this);" />
										</td>
									</tr>
									<tr class="tbl-tr cell-tr">
                    <td class="tbl-title">이메일</td>
										<td class="tbl-cell">
											<input name="sales_email" type="text" class="input-common" id="sales_email" value="<?php echo $view_val['sales_email']; ?>" />
										</td>
									</tr>

				<?php }else if($_GET['type'] == '4'){
								$i = 0;
								foreach ($view_val2 as $item2) {
									if ($i == 0) {
							?>
                  <colgroup>
                    <col width="18%">
                    <col width="32%">
                    <col width="18%">
                    <col width="32%">
                  </colgroup>
									<tr>
										<td class="tbl-sub-title">매입처 정보</td>
										<td colspan="3" align="right">
											<img src="<?php echo $misc; ?>img/btn_add.jpg" id="main_add" name="main_add" style="cursor:pointer;" />
										</td>
									</tr>
									<tr class="main_insert_field_<?php echo $i; ?> tbl-tr cell-tr border-t">
										<td class="tbl-title" style="height:70px;">매입처</td>
										<td class="tbl-cell">
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
											<input name="main_companyname" type="text" class="input-common" id="main_companyname" value="<?php echo $item2['main_companyname']; ?>" />
											<input name="main_seq" type="hidden" id="main_seq" value="<?php echo $item2['seq']; ?>" />
										</td>
										<td class="tbl-title">담당자</td>
										<td class="tbl-cell">
											<select id="select_main_user" class="select-common" onchange="selectMainUser();">
												<option value=''>담당자 선택</option>
											</select>
											<input name="main_username" type="text" class="input-common" id="main_username" value="<?php echo $item2['main_username']; ?>" />
										</td>
									</tr>
									<tr class="main_insert_field_<?php echo $i; ?> tbl-tr cell-tr">
										<td class="tbl-title">연락처</td>
										<td class="tbl-cell">
											<input name="main_tel" type="text" class="input-common" id="main_tel" value="<?php echo $item2['main_tel']; ?>" onclick="checkNum(this);" onKeyUp="checkNum(this);" />
										</td>
										<td class="tbl-title">
											이메일</td>
										<td class="tbl-cell">
											<input name="main_email" type="text" class="input-common" id="main_email" value="<?php echo $item2['main_email']; ?>" />
										</td>
									</tr>
									<tr class="main_insert_field_<?php echo $i; ?>">
										<td colspan="4" height="2" bgcolor="#797c88"></td>
									</tr>
          	<?php } else { ?>
									<tr class="main_insert_field_<?php echo $i; ?> tbl-tr cell-tr border-t">
										<td class="tbl-title" style="height:70px;">매입처</td>
										<td class="tbl-cell">
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
											<input name="main_companyname" type="text" class="input-common" id="main_companyname<?php echo $i;?>" value="<?php echo $item2['main_companyname']; ?>" />
											<input name="main_seq" type="hidden" id="main_seq" value="<?php echo $item2['seq']; ?>" />
										</td>
										<td class="tbl-title">담당자</td>
										<td class="tbl-cell">
											<select id="select_main_user<?php echo $i;?>" class="select-common" onchange="selectMainUser(<?php echo $i; ?>);">
												<option value=''>담당자 선택</option>
											</select>
											<input name="main_username" type="text" class="input-common" id="main_username<?php echo $i;?>" value="<?php echo $item2['main_username']; ?>" />
										</td>
									</tr>
									<tr class="main_insert_field_<?php echo $i; ?> tbl-tr cell-tr">
										<td class="tbl-title">연락처</td>
										<td class="tbl-cell">
											<input name="main_tel" type="text" class="input-common" id="main_tel<?php echo $i;?>" value="<?php echo $item2['main_tel']; ?>" onclick="checkNum(this);" onKeyUp="checkNum(this);" />
										</td>
										<td class="tbl-title">이메일</td>
										<td class="tbl-cell">
											<input name="main_email" type="text" class="input-common" id="main_email<?php echo $i;?>" value="<?php echo $item2['main_email']; ?>" style="width:92%" />
                      <img src="<?php echo $misc; ?>img/btn_del0.jpg" onclick='javascript:main_list_del(<?php echo $i; ?>,<?php echo $item2["seq"]; ?>);' style="cursor:pointer;float:right;padding-top:4px;" />
										</td>
									</tr>
									<tr class="main_insert_field_<?php echo $i; ?>">
										<td colspan="10" height="2" bgcolor="#797c88"></td>
									</tr>
									<script>
									$("#select_main_company<?php echo $i;?>").select2({width:'99%'});
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

									<tr>
										<td colspan=10 height="40" align="left">
										<div>
					            <span class="tbl-sub-title">* 일괄적용</span> <br><br>
                      <table style="width:70%;">
												<colgroup>
													<col width="50px" />
													<col width="200px" />
													<col width="100px" />
													<col width="50px" />
													<col width="200px" />
													<col width="100px" />
													<col width="50px" />
													<col width="200px" />
													<col width="100px" />
												</colgroup>
												<tr>
													<td style="font-weight:bold;">제조사</td>
													<td>
														<select id="check_product_company" class="input7" onchange="productSearch('check');product_collective(this);$('#check_product_name').change();">
															<option value="" >제조사</option>
															<?php foreach($product_company as $pc){
																echo "<option value='{$pc['product_company']}'>{$pc['product_company']}</option>";
															}?>
														</select>
													</td>
													<td><input type="button" class="btn-common btn-style2" value="선택적용" onclick="collectiveApplication('product_company',2);" style="width:90px;margin-right:30px;" /></td>
													<td style="font-weight:bold;">제품명</td>
													<td>
														<select id="check_product_name" class="input7" onclick="productSearch('check');" onchange="product_collective(this);">
															<option value="" selected>제조사를 선택해주세요</option>
														</select>
													</td>
													<td>
														<input type="button" class="btn-common btn-style2" value="선택적용" onclick="collectiveApplication('product_name',2);" style="width:90px;margin-right:30px;" />
													</td>
													<td style="font-weight:bold;">제품상태</td>
													<td>
														<select id="check_product_state" class="select-common" onchange="product_collective(this);">
															<option value="0">- 제품 상태 -</option>
															<option value="001">입고 전</option>
															<option value="002">창고</option>
															<option value="003">고객사 출고</option>
															<option value="004">장애반납</option>
														</select>
													</td>
													<td>
														<input type="button" class="btn-common btn-style2" value="선택적용" onclick="collectiveApplication('product_state',1);" style="width:90px;margin-right:30px;" />
													</td>
                          <td rowspan="2" style="padding-bottom:10px;">
                            <input type="button" class="btn-common btn-style2" value="일괄적용" onclick="collectiveApplication_all();" style="width:90px;height:60px;" />
                          </td>
												</tr>
												<tr>
												<td style="font-weight:bold;">매입처</td>
													<td>
														<select id="check_product_supplier" class="select-common" onchange="product_collective(this);">
														<?php foreach($view_val2 as $item2){
															echo "<option value='{$item2['main_companyname']}'>{$item2['main_companyname']}</option>";
														}?>
														</select>
													</td>
													<td><input type="button" class="btn-common btn-style2" value="선택적용" onclick="collectiveApplication('product_supplier',1);" style="width:90px;margin-right:30px;" /></td>
													<td style="font-weight:bold;">장비유지보수시작일</td>
													<td><input type="date" id="check_maintain_begin" class="input-common" onchange="product_collective(this);"></td>
													<td><input type="button" class="btn-common btn-style2" value="선택적용" onclick="collectiveApplication('maintain_begin',0);" style="width:90px;margin-right:30px;"/></td>
													<td style="font-weight:bold;">장비유지보수만료일</td>
													<td><input type="date" id="check_maintain_expire" class="input-common" onchange="product_collective(this);"></td>
													<td><input type="button" class="btn-common btn-style2" value="선택적용" onclick="collectiveApplication('maintain_expire',0);" style="width:90px;margin-right:30px;" /></td>
												</tr>
												<tr>
													<td style="font-weight:bold;">유/무상</td>
													<td>
														<select id="check_maintain_yn" class="select-common" onchange="product_collective(this);">
															<option value="0">- 유/무상여부 -</option>
															<option value="Y">유상</option>
															<option value="N">무상</option>
														</select>
													</td>
													<td><input type="button" class="btn-common btn-style2" value="선택적용" onclick="collectiveApplication('maintain_yn',1);" style="width:90px;margin-right:30px;" /></td>
													<td style="font-weight:bold;">유지보수 대상</td>
													<td>
														<select id="check_maintain_target" class="select-common" onchange="product_collective(this);">
															<option value="0">유지보수 대상</option>
															<option value="Y">대상</option>
															<option value="N">비대상</option>
														</select>

													</td>
													<td><input type="button" class="btn-common btn-style2" value="선택적용" onclick="collectiveApplication('maintain_target',1);" style="width:90px;margin-right:30px;" /></td>
												</tr>
												<tr>
													<td style="font-weight:bold;">유지보수매출가</td>
													<td><input type="text" class="input-common" id="check_product_sales" value=0 onclick="numberFormat(this);" onchange="numberFormat(this);product_collective(this);" /></td>
													<td><input type="button" class="btn-common btn-style2" value="선택적용" onclick="collectiveApplication('product_sales',0);" style="width:90px;margin-right:30px;" /></td>
													<td style="font-weight:bold;">유지보수매입가</td>
													<td><input type="text" class="input-common" id="check_product_purchase" value=0 onclick="numberFormat(this);" onchange="numberFormat(this);product_collective(this);" /></td>
													<td><input type="button" class="btn-common btn-style2" value="선택적용" onclick="collectiveApplication('product_purchase',0);" style="width:90px;margin-right:30px;" /></td>
													<!-- <td><input type="button" class="input5" value="선택적용" onclick="collectiveApplication('maintain_target',1);" style="margin-right:30px;" /></td> -->
												</tr>
											</table>
										</div>


										</td>
									</tr>
                  <tr>
                    <td colspan=10 height="40" class="tbl-sub-title">
                      제품 정보<span id="check_product_info"></span></td>
									</tr>
									<tr>
										<td colspan="10" >
											<img src="<?php echo $misc;?>/img/filter_refresh.png" onclick="filter_reset('product_table');" width=20 style="float:right;cursor:pointer;margin-bottom:5px;"/>
										</td>
									</tr>
									<!-- 여기서부터 찐 제품 -->
									<tr>
  									<td colspan=10>
  										<input type="hidden" id="update_exception_saledate3" name="update_exception_saledate3" />
  										<input type="hidden" id="update_produce_saledate" name="update_produce_saledate" />
  										<input type="hidden" name="customer_companyname" class="input7" id="customer_companyname" value="<?php echo $view_val['customer_companyname']; ?>" />
  										<input type="hidden" name="project_name" class="input7" id="project_name" value="<?php echo $view_val['project_name']; ?>" />
  										<input type="hidden" name="maintain_cycle" class="input7" id="maintain_cycle" value="<?php echo $view_val['maintain_cycle']; ?>" />
  										<table id="product_table" style="width:100%;" onchange="filter_reload('product_table',event)" border="0" cellspacing="0" cellpadding="0" class="product_tbl">
  											<colgroup>
  												<col width="2%" />
  												<col width="2%" />
  												<col width="7%" />
  												<col width="7%" />
  												<col width="7%" />
  												<col width="5%" />
  												<col width="7%" />
  												<col width="5%" />
  												<col width="7%" />
  												<col width="4%" />
  												<col width="5%" />
  												<col width="5%" />
  												<col width="5%" />
  												<col width="5%" />
  												<col width="7%" />
  												<col width="7%" />
  												<col width="7%" />
  												<col width="4%" />
  												<col width="2%" />
  											</colgroup>
  											<thead>
  											<tr class="row-color1 tbl-tr cell-tr border-t">
  												<th><input type="checkbox" class="drop" id="allCheck" /></th>
  												<th class ="apply-filter"><input type="hidden" id="filter0" class="filter_n" value="all">번호</th>
  												<th class ="apply-filter"><input type="hidden" id="filter1" class="filter_n" value="all">프로젝트명</th>
  												<th class ="apply-filter"><input type="hidden" id="filter2" class="filter_n" value="all">제조사</th>
  												<th class ="apply-filter"><input type="hidden" id="filter3" class="filter_n" value="all">매입처</th>
  												<th class ="apply-filter"><input type="hidden" id="filter4" class="filter_n" value="all">구분</th>
  												<th class ="apply-filter"><input type="hidden" id="filter5" class="filter_n" value="all">제품명</th>
  												<th class ="apply-filter"><input type="hidden" id="filter6" class="filter_n" value="all">라이선스 수량</th>
  												<th class ="apply-filter"><input type="hidden" id="filter7" class="filter_n" value="all">hardware/software<br>serial number</th>
  												<th class ="apply-filter"><input type="hidden" id="filter8" class="filter_n" value="all">제품 상태</th>
  												<th class ="apply-filter"><input type="hidden" id="filter9" class="filter_n" value="all">장비유지보수<br>시작일</th>
  												<th class ="apply-filter"><input type="hidden" id="filter10" class="filter_n" value="all">장비유지보수<br>만료일</th>
  												<th class ="apply-filter"><input type="hidden" id="filter11" class="filter_n" value="all">유/무상</th>
  												<th class ="apply-filter"><input type="hidden" id="filter12" class="filter_n" value="all">유지보수 대상</th>
  												<th class ="apply-filter"><input type="hidden" id="filter13" class="filter_n" value="all">유지보수매출가</th>
  												<th class ="apply-filter"><input type="hidden" id="filter14" class="filter_n" value="all">유지보수매입가</th>
  												<th class ="apply-filter"><input type="hidden" id="filter15" class="filter_n" value="all">유지보수마진</th>
  												<th class ="apply-filter" ><input type="hidden" id="filter16" class="filter_n" value="all">비고</th>
  												<th><img src="<?php echo $misc; ?>img/btn_add.jpg" id="product_add" name="product_add" style="cursor:pointer;" /></th>
  											</tr>
											</thead>
											<tbody id="product_input_place">
  										<?php
  											$j = 1;
  											$i = 0;
  											foreach ($view_val3 as $item3) {
  										?>
    										<tr id="product_insert_field_<?php echo $j; ?>" class="tbl-tr cell-tr border-t">
    											<td><input type="checkbox" name="product_row" value="<?php echo $i; ?>" /></td>
    											<td><span class="p_num"><?php echo $j; ?></span></td>
    											<td align="left">
    												<?php echo $item3['project_name']; ?>
    											</td>
    											<td align="left">
  												<?php if($item3['integration_maintain_seq'] == ""){?>
  													<select name="product_company" id="product_company<?php echo $i; ?>" class="input7" onchange="product_type_default(<?php echo $i; ?>);productSearch(<?php echo $i; ?>,this.value);">
  														<option value="">제조사</option>
  														<?php foreach($product_company as $pc){
  															echo "<option value='{$pc['product_company']}'";
  															if($item3['product_company'] == $pc['product_company'] ){
  																echo "selected";
  															}
  															echo ">{$pc['product_company']}</option>";
  														}?>
  													</select>
  												<?php }else{
  													echo $item3['product_company'];
  												} ?>
    											</td>
    											<td>
    												<select name="product_supplier" id="product_supplier<?php echo $i; ?>" class="select-common">
                              <option value="" <?php if($item3['product_supplier']==''){echo 'selected';} ?>></option>
    												<?php foreach($view_val2 as $item2){
    													echo "<option value='{$item2['main_companyname']}'";
    													if($item3['product_supplier'] == $item2['main_companyname']){
    														echo "selected";
    													}
    													echo ">{$item2['main_companyname']}</option>";
    												}?>
    												</select>
    											</td>
    											<td align="left">
    												<select name="product_type" id="product_type<?php echo $i; ?>" class="input-common" onchange="productSearch(<?php echo $i; ?>);">
    													<option value="" selected>전체</option>
    													<option value="hardware" <?php if($item3['product_type'] == "hardware"){echo "selected"; }?>>하드웨어</option>
    													<option value="software" <?php if($item3['product_type'] == "software"){echo "selected"; }?>>소프트웨어</option>
    													<option value="appliance" <?php if($item3['product_type'] == "appliance"){echo "selected"; }?>>어플라이언스</option>
    												</select>
    											</td>
    											<td align="left">
    												<input type="hidden" name="product_seq" id="product_seq<?php echo $i; ?>" value="<?php echo $item3['seq']; ?>" />
    												<?php if($item3['integration_maintain_seq'] == ""){?>
    													<select name="product_name" id="product_name<?php echo $i; ?>" class="select-common" onclick="productSearch(<?php echo $i; ?>,this.value);">
    														<option value="<?php echo $item3['product_code'] ;?>" selected> <?php echo $item3['product_name'] ;?></option>
    													</select>
    												<?php }else{
    													echo "<input type='hidden' name='product_name' />";
    													echo $item3['product_name'];
    												}?>
    											</td>
    											<td align="left" >
    												<input name="product_licence" type="text" class="input-common" id="product_licence<?php echo $i; ?>" value="<?php echo $item3['product_licence']; ?>" onkeyup="commaCheck(this);" />
    											</td>
    											<td align="left" >
    												<input name="product_serial" type="text" class="input-common" id="product_serial<?php echo $i; ?>" value="<?php echo $item3['product_serial']; ?>" onkeyup="commaCheck(this);" />
    											</td>
    											<td align="left">
    												<select name="product_state" id="product_state<?php echo $i; ?>" class="select-common" >
    													<option value="0">- 제품 상태 -</option>
    													<option value="001" <?php if ($item3['product_state'] == "001") {echo "selected";} ?>>입고 전</option>
    													<option value="002" <?php if ($item3['product_state'] == "002") {echo "selected";} ?>>창고</option>
    													<option value="003" <?php if ($item3['product_state'] == "003") {echo "selected";} ?>>고객사 출고</option>
    													<option value="004" <?php if ($item3['product_state'] == "004") {echo "selected";} ?>>장애반납</option>
    												</select>
    											</td>
    											<td align="left" >
    												<input name="maintain_begin" type="date" class="input-common" id="maintain_begin<?php echo $i; ?>" value="<?php echo $item3['maintain_begin']; ?>" />
    											</td>
    											<td align="left" >
    												<input name="maintain_expire" type="date" class="input-common" id="maintain_expire<?php echo $i; ?>" value="<?php echo $item3['maintain_expire'];?>" onchange="exceptionsaledateChange('<?php echo $j; ?>','expire','<?php echo $item3['maintain_expire']; ?>',this.value);" onkeypress="return false"/>
    											</td>
    											<td align="left">
    												<select name="maintain_yn" id="maintain_yn<?php echo $i; ?>" class="select-common" >
    													<option value="0">- 유/무상여부 -</option>
    													<option value="Y" <?php if ($item3['maintain_yn'] == "Y") {echo "selected";} ?>>유상</option>
    													<option value="N" <?php if ($item3['maintain_yn'] == "N") {echo "selected";} ?>>무상</option>
    												</select>
    											</td>
    											<td class="tbl-cell">
    												<select name="maintain_target" id="maintain_target<?php echo $i; ?>" class="select-common" >
    													<option value="0">대상여부</option>
    													<option value="Y" <?php if ($item3['maintain_target'] == "Y") {echo "selected";} ?>>대상</option>
    													<option value="N" <?php if ($item3['maintain_target'] == "N") {echo "selected";} ?>>비대상</option>
    												</select>
    											</td>
    											<td align="left">
    												<input name="product_sales" type="text" class="input-common" id="product_sales<?php echo $i; ?>" value="<?php if(trim($item3['product_sales']) == ""){echo $item3['product_sales'];}else{echo number_format((int)$item3['product_sales']);} ?>" onclick="numberFormat(this);" onchange="numberFormat(this);product_profit_change(<?php echo $i; ?>,0);" style="text-align:right;" />
    											</td>
    											<td align="left">
    												<input name="product_purchase" type="text" class="input-common" id="product_purchase<?php echo $i; ?>" value="<?php if(trim($item3['product_purchase']) == ""){echo $item3['product_purchase'];}else{echo number_format((int)$item3['product_purchase']);} ?>" onclick="numberFormat(this);" onchange="numberFormat(this);product_profit_change(<?php echo $i; ?>,0);" style="text-align:right;"/>
    											</td>
    											<td align="left">
    												<input name="product_profit" type="text" class="input-common" id="product_profit<?php echo $i; ?>" value="<?php if(trim($item3['product_profit']) == ""){echo $item3['product_profit'];}else{echo number_format((int)$item3['product_profit']);} ?>" style="text-align:right;" readonly />
    											</td>
    											<td align="left">
    												<input name="comment" type="text" class="input-common" id="comment<?php echo $i; ?>" value="<?php echo $item3['comment']; ?>" />
    											</td>
    											<td align="center">
    												<?php if($j != 1){ ?>
    													<img src="<?php echo $misc; ?>img/btn_del0.jpg" onclick='javascript:product_list_del(<?php echo $j; ?>,<?php echo $item3["seq"]; ?>);' style="cursor:pointer;" />
    												<?php }?>
    											</td>
    										</tr>
    										<?php
    											$max_number2 = $j;
    											$j++;
    											$i++;
    										}
    										?>
    										<?php
    										if(!empty($view_val5)){?>
    										<?php foreach ($view_val5 as $item3) {
    										?>
    										<tr id="product_insert_field_<?php echo $j; ?>" class="tbl-tr cell-tr" >
    											<td><input type="checkbox" name="product_row" value="<?php echo $i; ?>" /></td>
    											<td><?php echo $j; ?></td>
    											<td align="left">
    												<?php echo $item3['project_name']; ?>
    											</td>
    											<td align="left">
    												<?php if($item3['integration_maintain_seq'] == ""){?>
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
    												<?php }else{
    													echo $item3['product_company'];
    												} ?>
    											</td>
    											<td>
    												<select name="product_supplier" id="product_supplier<?php echo $i; ?>" class="select-common">
                              <option value="" <?php if($item3['product_supplier']==''){echo 'selected';} ?>></option>
    												<?php foreach($view_val2 as $item2){
    													echo "<option value='{$item2['main_companyname']}'";
    													if($item3['product_supplier'] == $item2['main_companyname']){
    														echo "selected";
    													}
    													echo ">{$item2['main_companyname']}</option>";
    												}?>
    												</select>
    											</td>

    											<td align="left">
    												<input type='hidden' name='product_type' />
    												<?php echo $item3['product_type']; ?>
    											</td>
    											<td align="left">
    												<input type="hidden" name="product_seq" id="product_seq<?php echo $i; ?>" value="<?php echo $item3['seq']; ?>" />
    												<?php if($item3['integration_maintain_seq'] == ""){?>
    													<select name="product_name" id="product_name<?php echo $i; ?>" class="select-common" onclick="productSearch(<?php echo $i; ?>,this.value);">
    														<option value="<?php echo $item3['product_code'] ;?>" selected> <?php echo $item3['product_name'] ;?></option>
    													</select>
    												<?php }else{
    													echo "<input type='hidden' name='product_name' />";
    													echo $item3['product_name'];
    												}?>
    											</td>
    											<td align="left" >
    												<input name="product_licence" type="text" class="input-common" id="product_licence<?php echo $i; ?>" value="<?php echo $item3['product_licence']; ?>" onkeyup="commaCheck(this);" />
    											</td>
    											<td align="left" >
    												<input name="product_serial" type="text" class="input-common" id="product_serial<?php echo $i; ?>" value="<?php echo $item3['product_serial']; ?>" onkeyup="commaCheck(this);" />
    											</td>
    											<td align="left">
    												<select name="product_state" id="product_state<?php echo $i; ?>" class="select-common" >
    													<option value="0">- 제품 상태 -</option>
    													<option value="001" <?php if ($item3['product_state'] == "001") {echo "selected";} ?>>입고 전</option>
    													<option value="002" <?php if ($item3['product_state'] == "002") {echo "selected";} ?>>창고</option>
    													<option value="003" <?php if ($item3['product_state'] == "003") {echo "selected";} ?>>고객사 출고</option>
    													<option value="004" <?php if ($item3['product_state'] == "004") {echo "selected";} ?>>장애반납</option>
    												</select>
    											</td>
    											<td align="left" >
    												<input name="maintain_begin" type="date" class="input-common" id="maintain_begin<?php echo $i; ?>" value="<?php echo $item3['maintain_begin']; ?>" />
    											</td>
    											<td align="left" >
    												<input name="maintain_expire" type="date" class="input-common" id="maintain_expire<?php echo $i; ?>" value="<?php echo $item3['maintain_expire'];?>" onchange="exceptionsaledateChange('<?php echo $j; ?>','expire','<?php echo $item3['maintain_expire']; ?>',this.value);" onkeypress="return false"/>
    											</td>
    											<td align="left">
    												<select name="maintain_yn" id="maintain_yn<?php echo $i; ?>" class="select-common" >
    													<option value="0">- 유/무상여부 -</option>
    													<option value="Y" <?php if ($item3['maintain_yn'] == "Y") {echo "selected";} ?>>유상</option>
    													<option value="N" <?php if ($item3['maintain_yn'] == "N") {echo "selected";} ?>>무상</option>
    												</select>
    											</td>
    											<td class="tbl-cell">
    												<select name="maintain_target" id="maintain_target<?php echo $i; ?>" class="select-common" >
    													<option value="0">대상 여부</option>
    													<option value="Y" <?php if ($item3['maintain_target'] == "Y") {echo "selected";} ?>>대상</option>
    													<option value="N" <?php if ($item3['maintain_target'] == "N") {echo "selected";} ?>>비대상</option>
    												</select>
    											</td>
    											<td align="left">
    												<input name="product_sales" type="text" class="input-common" id="product_sales<?php echo $i; ?>" value="<?php if(trim($item3['product_sales']) == ""){echo $item3['product_sales'];}else{echo number_format((int)$item3['product_sales']);} ?>" onclick="numberFormat(this);" onchange="numberFormat(this);product_profit_change(<?php echo $i; ?>,0);" style="text-align:right;" />
    											</td>
    											<td align="left">
    												<input name="product_purchase" type="text" class="input-common" id="product_purchase<?php echo $i; ?>" value="<?php if(trim($item3['product_purchase']) == ""){echo $item3['product_purchase'];}else{echo number_format((int)$item3['product_purchase']);} ?>" onclick="numberFormat(this);" onchange="numberFormat(this);product_profit_change(<?php echo $i; ?>,0);" style="text-align:right;"/>
    											</td>
    											<td align="left">
    												<input name="product_profit" type="text" class="input-common" id="product_profit<?php echo $i; ?>" value="<?php if(trim($item3['product_profit']) == ""){echo $item3['product_profit'];}else{echo number_format((int)$item3['product_profit']);} ?>" style="text-align:right;" readonly />
    											</td>
    											<td align="left">
    												<input name="comment" type="text" class="input-common" id="comment<?php echo $i; ?>" value="<?php echo $item3['comment']; ?>" />
    											</td>
    											<td align="center">
    												<?php if($j != 1){ ?>
    													<img src="<?php echo $misc; ?>img/btn_del0.jpg" onclick='javascript:product_list_del(<?php echo $j; ?>,<?php echo $item3["seq"]; ?>);' style="cursor:pointer;" />
    												<?php }?>
    											</td>
    										</tr>
  										<?php
  											$max_number2 = $j;
  											$j++;
  											$i++;
  										}}
  										?>
  										</tbody>
										</table>
				            <table id="filter_sales" style="width:100%;" cellspacing="0" cellpadding="0" class="product_tbl">
  											<colgroup>
                          <col width="2%" />
  												<col width="2%" />
  												<col width="7%" />
  												<col width="7%" />
  												<col width="7%" />
  												<col width="5%" />
  												<col width="7%" />
  												<col width="5%" />
  												<col width="7%" />
  												<col width="4%" />
  												<col width="5%" />
  												<col width="5%" />
  												<col width="5%" />
  												<col width="5%" />
  												<col width="7%" />
  												<col width="7%" />
  												<col width="7%" />
  												<col width="4%" />
  												<col width="2%" />
  											</colgroup>
  												<tr class="row-color1 tbl-tr cell-tr">
  													<td colspan=14></td>
  													<td class="tbl-title">필터별총매출가</td>
  													<td class="tbl-title">필터별총매입가</td>
  													<td class="tbl-title">필터별총마진</td>
  													<td></td>
  													<td></td>
  												</tr>
  												<tr class="tbl-tr cell-tr">
  													<td colspan=14></td>
  													<td align="right" id="filter_forcasting_sales" style="padding-right:5px;"><?php echo number_format($view_val['forcasting_sales']); ?></td>
  													<td align="right" id="filter_forcasting_purchase" style="padding-right:5px;"><?php echo number_format($view_val['forcasting_purchase']); ?></td>
  													<td align="right" id="filter_forcasting_profit" style="padding-right:5px;"><?php echo number_format($view_val['forcasting_profit']); ?></td>
  													<td></td>
  													<td></td>
  												</tr>
  										</table>
  										<table style="width:100%;" cellspacing="0" cellpadding="0" class="product_tbl">
  											<colgroup>
                          <col width="2%" />
  												<col width="2%" />
  												<col width="7%" />
  												<col width="7%" />
  												<col width="7%" />
  												<col width="5%" />
  												<col width="7%" />
  												<col width="5%" />
  												<col width="7%" />
  												<col width="4%" />
  												<col width="5%" />
  												<col width="5%" />
  												<col width="5%" />
  												<col width="5%" />
  												<col width="7%" />
  												<col width="7%" />
  												<col width="7%" />
  												<col width="4%" />
  												<col width="2%" />
  											</colgroup>
  											<tr class="row-color1 tbl-tr cell-tr">
  												<td colspan=14></td>
  												<td class="tbl-title">총매출가</td>
  												<td class="tbl-title">총매입가</td>
  												<td class="tbl-title">총마진</td>
  												<td></td>
  												<td></td>
  											</tr>
  											<tr>
  												<td colspan=14></td>
  												<td align="left" ><input name="forcasting_sales" type="text" class="input-common" id="forcasting_sales" value="<?php echo number_format($view_val['forcasting_sales']); ?>" onchange="forcasting_profit_change();" style="text-align:right" readonly /> </td>
  												<td align="left" ><input name="forcasting_purchase" type="text" class="input-common" id="forcasting_purchase" value="<?php echo number_format($view_val['forcasting_purchase']); ?>" onchange="forcasting_profit_change();" style="text-align:right" readonly /> </td>
  												<td align="left" ><input name="forcasting_profit" type="text" class="input-common" id="forcasting_profit" value="<?php echo number_format($view_val['forcasting_profit']); ?>" style="text-align:right" readonly /></td>
  												<td></td>
  												<td></td>
  											</tr>
  										</table>
  										</td>
									</tr>
									<input type="hidden" id="row_max_index2" name="row_max_index2" value="<?php echo $max_number2 ;?>" />
									<tr>
										<td id="productEnd" colspan="10" height="0" bgcolor="#e8e8e8"></td>
									</tr>
									<tr class="tbl-tr cell-tr border-t">
										<td colspan=2 class="tbl-title">
											<input type="checkbox" name="product_row" value="project" style="float:left;" />고객사유지보수시작일
										</td>
										<td class="tbl-cell"><input name="exception_saledate2" type="date"
												class="input-common" id="exception_saledate2" value="<?php echo $view_val['exception_saledate2']; ?>" />
										</td>
										<td class="tbl-title">고객사유지보수종료일</td>
										<td class="tbl-cell">
											<input name="exception_saledate3" type="date" class="input-common" id="exception_saledate3" value="<?php echo $view_val['exception_saledate3']; ?>" />
										</td>
									</tr>

									<?php }else if($_GET['type'] == '6'){?>
                  <colgroup>
                    <col width="20%">
    								<col width="80%">
                  </colgroup>
									<tr>
										<td class="tbl-sub-title">수주 정보</td>
									</tr>
									<tr class="tbl-tr cell-tr border-t">
										<td class="tbl-title">수주여부</td>
										<td class="tbl-cell">
											<select name="complete_status" id="complete_status" class="select-common">
												<option value="001" <?php if ($view_val['complete_status'] == "001") {echo "selected";} ?>>수주중</option>
												<option value="002" <?php if ($view_val['complete_status'] == "002") {echo "selected";} ?>>수주완료</option>
											</select>
										</td>
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
											if(!empty($view_val5)){
												foreach ($view_val5 as $item3) {
													if($item3['product_supplier'] == $item2['main_companyname']){
														$main_company_amount1 += (int)$item3['product_purchase'];
													}
												}
											}
										} else {
											foreach ($view_val3 as $item3) {
												if($item3['product_supplier'] == $item2['main_companyname']){
													${"main_company_amount".($i+1)} += (int)$item3['product_purchase'];
												}
											}
											if(!empty($view_val5)){
												foreach ($view_val5 as $item3) {
													if($item3['product_supplier'] == $item2['main_companyname']){
														${"main_company_amount".($i+1)} += (int)$item3['product_purchase'];
													}
												}
											}
										}
										$i++;
									}
									?>

										<tr>
										<td colspan=12>
                      <span class="tbl-sub-title">* 일괄 적용</span> <br><br>
					            <table>
  											<tr height="40">
  												<td style="font-weight:bold;width:50px;">발행주기</td>
  												<td style="padding-left:5px;width:150px;">
  													<select id="collective_issue_cycle" class="select-common" style="width:90%">
  														<option value="">-미선택-</option>
  														<option value="매월">매월</option>
  														<option value="익월">익월</option>
  														<option value="분기">분기</option>
  														<option value="분기익월">분기익월</option>
  														<option value="반기">반기</option>
  														<option value="연1회">연1회</option>
  														<option value="지정일">지정일</option>
  													</select>
  												</td>
  												<td style="font-weight:bold;width:100px;padding-left:10px;">계산서 발행 기준일</td>
  												<td>
  													<input type="date" class="input-common" id="collective_issue_date" value="" style="width:90%"/>
  												</td>
  												<td style="font-weight:bold;padding-left:10px;">납부 회차</td>
  												<td style="padding-left:5px;">
  													<input type="text" class="input-common" id="collective_pay_session" value="" onchange="numberFormat(this);" style="width:90%"/>
  												</td>
  												<td style="padding-left:5px;">
  													<input type="radio" name="bill_insert_modify" value="생성"/>생성
  													<input type="radio" name="bill_insert_modify" value="수정"/>수정
  												</td>
  												<td style="padding-left:5px;">
  													<input type="button" class="btn-common btn-style2" value="선택적용" onclick="collectiveIssueCycle();" style="margin-right:30px;width:90px;" />
  												</td>
  											</tr>
											<tr height="40">
												<td style="font-weight:bold;width:50px;">발행금액 </td>
												<td style="padding-left:5px;">
													<input type="text" class="input-common" id="collectiveApplication_cost" name="collectiveApplication_cost" value="" onchange="numberFormat(this);" style="text-align:right; padding:0 5px;">
												</td>
												<td style="padding-left:10px;">
													<input type="button" class="btn-common btn-style2" value="선택적용" onclick="collectiveApplication_bill();" style="width:90px;" />
												</td>
                        <td style="padding-left:10px;">
                          <input type="button" class="btn-common btn-style1" value="발행취소" onclick="unIssue();" style="width:90px;" >
                        </td>
											</tr>
										</table>
										생성 : 발행된 계산서가 없을 때 계산서를 새로 생성(회차,발행예정일,발행금액 변경)<br/>
										수정 : 발행된 계산서는 수정 되지 않고 발행주기와 발행 예정일 수정 <br/>
										<br>
									</tr>
										<!-- 세금계싼서  -->
                  <tr>
										<td colspan="12" class="tbl-sub-title">계산서 발행 정보</td>
									</tr>
									<tr>
										<td colspan="12" >
											<img src="<?php echo $misc;?>/img/filter_refresh.png" onclick="filter_reset('sales_statement_table');" width=20 style="float:right;cursor:pointer;margin-bottom:5px;"/>
										</td>
									</tr>
									<tr>
        						<td>
        							<input type="hidden" id="insert_bill_array" name="insert_bill_array" />
        							<input type="hidden" id="update_bill_array" name="update_bill_array" />
        							<input type="hidden" id="delete_bill_array" name="delete_bill_array" />
        							<input type="hidden" id="sales_total_issuance_amount" name="sales_total_issuance_amount" value="0" />
        							<input type="hidden" id="update_seq" name="update_seq" />
        						</td>
        					</tr>
        					<tr class="tbl-tr cell-tr border-t">
        						<td colspan="12" bgcolor="DEDEDE" align="center" style="font-weight:bold;">매출</td>
        					</tr>
        					<tr>
        						<td colspan="12">
        							<table id="sales_statement_table" width="100%" border="0" cellspacing="0" cellpadding="0" onchange = "filter_reload('sales_statement_table',event)" style="border-collapse:collapse;">
        								<colgroup>
        									<col width="5%" />
        									<col width="5%" />
        									<col width="7%" />
        									<col width="3%" />
        									<col width="5%" />
        									<col width="5%" />
        									<col width="5%" />
        									<col width="5%" />
        									<col width="5%" />
        									<col width="19%" />
        									<col width="7%" />
        									<col width="10%" />
        									<col width="5%" />
        									<col width="10%" />
        									<col width="5%" />
        								</colgroup>
        								<thead>
        									<tr class="tbl-tr cell-tr row-color1">
        										<th>
        											<input type="checkbox" id="sales_company_check_all" class="drop" value="">
        										</th>
        										<th colspan="2" class="apply-filter no-sort" filter_column="1"><input type="hidden" class="filter_n" value="all">계약금액</th>
        										<th align="center">
        											<input type="checkbox" id="chk_all_1" class="drop" name="chk_all_1" value="">
        										</th>
        										<th class="apply-filter no-sort" filter_column="2"><input type="hidden" class="filter_n" value="all">회차</th>
        										<th class="apply-filter no-sort" filter_column="3"><input type="hidden" class="filter_n" value="all">발행예정일</th>
        										<th class="apply-filter no-sort" filter_column="4"><input type="hidden" class="filter_n" value="all">발행금액</th>
        										<th class="apply-filter no-sort" filter_column="5"><input type="hidden" class="filter_n" value="all">세액</th>
        										<th class="apply-filter no-sort" filter_column="6"><input type="hidden" class="filter_n" value="all">합계</th>
        										<th class="apply-filter no-sort" filter_column="7"><input type="hidden" class="filter_n" value="all">국세청 승인번호</th>
        										<th class="apply-filter no-sort" filter_column="8"><input type="hidden" class="filter_n" value="all">발행월</th>
        										<th class="apply-filter no-sort" filter_column="9"><input type="hidden" class="filter_n" value="all">발행일자</th>
        										<th class="apply-filter no-sort" filter_column="10"><input type="hidden" class="filter_n" value="all">발행여부</th>
        										<th class="apply-filter no-sort" filter_column="11"><input type="hidden" class="filter_n" value="all">입금일자</th>
        										<th class="apply-filter no-sort" filter_column="12"><input type="hidden" class="filter_n" value="all">입금여부</th>
        										<th style="font-weight:bold;">
        											<img src="<?php echo $misc; ?>img/btn_add.jpg" class="drop" onclick="addRow('sales_issuance_amount_insert_line','sales_contract_total_amount',0);" />
        										</th>
        									</tr>
        								</thead>
        								<tbody>
        										<?php if(empty($sales_bill_val)){?>
        											<tr class="insert_sales_bill tbl-tr cell-tr">
        												<input type="hidden" id="sales_issuance_status1" name="sales_issuance_status" class="input7" value="N" />
        												<input type="hidden" id="sales_deposit_status1" name="sales_deposit_status" class="input7" value="N" />
        												<td rowspan="1" class="border-f" height="40" align="center">
        													<input type="checkbox" name="company_check" class="drop" value="sales_issuance_amount_insert_line">
        													<p>발행주기</p>
        													<select class="select-common drop" id="sales_issue_cycle" name="sales_issue_cycle" style="width:90%">
        														<option value="">-미선택-</option>
        														<option value="매월">매월</option>
        														<option value="익월">익월</option>
        														<option value="분기">분기</option>
        														<option value="분기익월">분기익월</option>
        														<option value="반기">반기</option>
        														<option value="연1회">연1회</option>
        														<option value="지정일">지정일</option>
        													</select> <!-- //발행주기 -->
        													<p>납부회차</p>
        													<input type="text" id="sales_pay_session" name="sales_pay_session" class="drop input-common" value="<?php echo $view_val['sales_pay_session'];?>" onchange="numberFormat(this);" style="width:85px">
        												</td>
        												<td id="sales_contract_total_amount" rowspan="1" colspan="2" filter_column="1" class="basic_td" height="40" align="center">
        													<?php echo number_format((int)$view_val['forcasting_sales']); ?>
        												</td>
        												<td colspan='13' height='40' class='basic_td empty_row' align='center' >-등록된 계산서가 없습니다.</td>
        											</tr>
        										<?php }
        											$row = 1;
        											if(!empty($sales_bill_val)){
        											foreach($sales_bill_val as $bill){
        										?>
  														<tr id="bill_<?php echo $bill['seq']; ?>" class="update_sales_bill tbl-tr cell-tr" <?php if($bill['issuance_status'] == "M"){echo "style='background-color:rgb(255, 227, 227);'";}?>>
                                <?php if($row == 1){?>
                                  <td rowspan="<?php echo count($sales_bill_val); ?>" class="basic_td" height="40" align="center">
                                    <input type="checkbox" name="company_check" class="drop" value="sales_issuance_amount_insert_line">
                                    <p>발행주기</p>
                                    <select class="select-common drop" id="sales_issue_cycle" name="sales_issue_cycle" style="width:90%">
                                      <option value="" <?php if($view_val['issue_cycle'] == ""){echo "selected";} ?>>-미선택-</option>
                                      <option value="매월" <?php if($view_val['issue_cycle'] == "매월"){echo "selected";} ?>>매월</option>
                                      <option value="익월" <?php if($view_val['issue_cycle'] == "익월"){echo "selected";} ?>>익월</option>
                                      <option value="분기" <?php if($view_val['issue_cycle'] == "분기"){echo "selected";} ?>>분기</option>
                                      <option value="분기익월" <?php if($view_val['issue_cycle'] == "분기익월"){echo "selected";} ?>>분기익월</option>
                                      <option value="반기" <?php if($view_val['issue_cycle'] == "반기"){echo "selected";} ?>>반기</option>
                                      <option value="연1회" <?php if($view_val['issue_cycle'] == "연1회"){echo "selected";} ?>>연1회</option>
                                      <option value="지정일" <?php if($view_val['issue_cycle'] == "지정일"){echo "selected";} ?>>지정일</option>
                                    </select> <!-- //발행주기 -->
                                    <p>납부회차</p>
                                    <input type="text" id="sales_pay_session" name="sales_pay_session" class="drop input-common" value="<?php echo $view_val['sales_pay_session'];?>" onchange="numberFormat(this);" style="width:85px;">
                                  </td>
                                  <td id="sales_contract_total_amount"  filter_column="1"  rowspan="<?php echo count($sales_bill_val); ?>" colspan="2" class="basic_td" height="40" align="center">
                                    <?php echo number_format((int)$view_val['forcasting_sales']); ?>
                                  </td>
                                <?php } ?>
  															<input type="hidden" id="sales_issuance_status<?php echo $row; ?>" name="sales_issuance_status" class="input7" onchange="updateSeq(<?php echo $bill['seq']; ?>);" value="<?php echo $bill['issuance_status']; ?>" />
  															<input type="hidden" id="sales_deposit_status<?php echo $row; ?>" name="sales_deposit_status" class="input7" onchange="updateSeq(<?php echo $bill['seq']; ?>);" value="<?php echo $bill['deposit_status']?>" />
  															<?php if($bill['issuance_status'] == "Y" && ($id != "skkim" && $id !="yjjoo" && $id !="hbhwang" && $id !="selee")){?>
  															<td height="40" class="basic_td" align="center">
  																<input type="checkbox" name="pay_checkbox" class="checkbox_1" value="">
  															</td>
  															<td height="40" class="basic_td" align="center"  filter_column="2"><?php echo $bill['pay_session']; ?>
  																<input type="hidden" id="pay_session<?php echo $row;?>" name="pay_session" class="input7" value="<?php echo $bill['pay_session']; ?>" style="width:60%;text-align:center;" />
  															</td>
  															<td height="40" class="basic_td" align="center"  filter_column="3">
  																<input type="date" id="issue_schedule_date<?php echo $row;?>" name="issue_schedule_date" class="input-common date_input" value="<?php echo $bill['issue_schedule_date']; ?>" onchange="updateSeq(<?php echo $bill['seq']; ?>);" style="width:60%;text-align:center;" />
  															</td>
  															<td height="40" class="basic_td" align="center"  filter_column="4"><?php if($bill['issuance_amount'] == "" ){echo $bill['issuance_amount']; }else{echo number_format((int)$bill['issuance_amount']);} ?>
  																<input type="hidden" id="sales_issuance_amount<?php echo $row; ?>" name="sales_issuance_amount" class="input7" style="text-align:right;" value="<?php if($bill['issuance_amount'] == "" ){echo $bill['issuance_amount']; }else{echo number_format((int)$bill['issuance_amount']);} ?>"/>
  															</td>
  															<td height="40" class="basic_td" align="center"  filter_column="5"><?php if($bill['tax_amount'] == "" ){echo $bill['tax_amount']; }else{echo number_format((int)$bill['tax_amount']);} ?>
  																<input type="hidden" id="sales_tax_amount<?php echo $row; ?>" name="sales_tax_amount" class="input7" style="text-align:right;" value="<?php if($bill['tax_amount'] == "" ){echo $bill['tax_amount']; }else{echo number_format((int)$bill['tax_amount']);} ?>"/>
  															</td>
  															<td height="40" class="basic_td" align="center"  filter_column="6"><?php if($bill['total_amount'] == "" ){echo $bill['total_amount']; }else{echo number_format((int)$bill['total_amount']);} ?>
  																<input type="hidden" id="sales_total_amount<?php echo $row; ?>" name="sales_total_amount" class="input7" style="text-align:right;" value="<?php if($bill['total_amount'] == "" ){echo $bill['total_amount']; }else{echo number_format((int)$bill['total_amount']);} ?>"/>
  															</td>
  															<td height="40" class="basic_td" align="center"  filter_column="7"><?php echo $bill['tax_approval_number']; ?>
  																<input type="hidden" id="sales_tax_approval_number<?php echo $row; ?>" name="sales_tax_approval_number" class="input7" value="<?php echo $bill['tax_approval_number']; ?>" onchange="taxApprovalNumer(this,<?php echo $row; ?>,0);" />
  															</td>
  															<?php }else{?>
  															<td height="40" class="basic_td" align="center">
  																<input type="checkbox" name="pay_checkbox" class="checkbox_1" value="">
  															</td>
  															<td height="40" class="basic_td" align="center"  filter_column="2">
  																<input type="text" id="pay_session<?php echo $row;?>" name="pay_session" class="input-common" value="<?php echo $bill['pay_session']; ?>" style="width:60%;text-align:center;" onchange="updateSeq(<?php echo $bill['seq']; ?>);" />
  															</td>
  															<td height="40" class="basic_td" align="center"  filter_column="3">
  																<input type="date" id="issue_schedule_date<?php echo $row;?>" name="issue_schedule_date" class="input-common date_input" value="<?php echo $bill['issue_schedule_date']; ?>" onchange="updateSeq(<?php echo $bill['seq']; ?>);" style="width:200px;text-align:center;" />
  															</td>
  															<td height="40" class="basic_td" align="center" filter_column="4">
  																<input type="text" id="sales_issuance_amount<?php echo $row; ?>" name="sales_issuance_amount" class="input-common" style="text-align:right;" value="<?php if($bill['issuance_amount'] == ""){echo $bill['issuance_amount']; }else{echo number_format((int)$bill['issuance_amount']);}  ?>" onchange="numberFormat(this);updateSeq(<?php echo $bill['seq']; ?>);get_tax_amount(this,0,<?php echo $row; ?>);get_total_amount(this,0);" />
  															</td>
  															<td height="40" class="basic_td" align="center" filter_column="5">
  																<input type="text" id="sales_tax_amount<?php echo $row; ?>" name="sales_tax_amount" class="input-common" style="text-align:right;" value="<?php if($bill['tax_amount'] == ""){echo $bill['tax_amount']; }else{echo number_format((int)$bill['tax_amount']);}  ?>" onchange="numberFormat(this);updateSeq(<?php echo $bill['seq']; ?>);get_total_amount(this,0);" />
  															</td>
  															<td height="40" class="basic_td" align="center" filter_column="6">
  																<input type="text" id="sales_total_amount<?php echo $row; ?>" name="sales_total_amount" class="input-common" style="text-align:right;" value="<?php if($bill['total_amount'] == ""){echo $bill['total_amount']; }else{echo number_format((int)$bill['total_amount']);}  ?>" onchange="numberFormat(this);get_sum_amount(0);" />
  															</td>
  															<td height="40" class="basic_td" align="center" filter_column="7">
  																<input type="text" id="sales_tax_approval_number<?php echo $row; ?>" name="sales_tax_approval_number" class="input7" value="<?php echo $bill['tax_approval_number']; ?>" onchange="taxApprovalNumer(this,<?php echo $row; ?>,0);updateSeq(<?php echo $bill['seq']; ?>);" />
  															</td>
  															<?php } ?>
  															<td height="40" class="basic_td" align="center" filter_column="8"><input type="text" id="sales_issuance_month<?php echo $row; ?>"
  																	name="sales_issuance_month" class="input7" style="text-align:center;" value="<?php echo $bill['issuance_month']; ?>" readonly /></td>
  															<td height="40" class="basic_td" align="center" filter_column="9"><input type="text" id="sales_issuance_date<?php echo $row; ?>"
  																	name="sales_issuance_date" class="input-common" value="<?php echo $bill['issuance_date']; ?>" onchange="issuance_date_change(this,<?php echo $row; ?>,0);updateSeq(<?php echo $bill['seq']; ?>);" style="text-align:center;" readonly />
  															</td>
  															<td height="40" class="basic_td" align="center"  filter_column="10">
  																<span id="sales_issuance_YN<?php echo $row; ?>" name="sales_issuance_YN">
  																	<?php if($bill['issuance_status'] == "Y"){
  																		echo "완료";
  																	}else if ($bill['issuance_status'] == "N"){
  																		echo "미완료";
  																	}else if ($bill['issuance_status'] == "C"){
  																		echo "발행취소";
  																	}else if ($bill['issuance_status'] == "M"){
  																		echo "마이너스발행";
  																	}
  																	?>
  																</span>
  															</td>
  															<td height="40" class="basic_td" align="center" filter_column="11">
  																<input type="date" id="sales_deposit_date<?php echo $row; ?>" name="sales_deposit_date" class="input-common" value="<?php echo $bill['deposit_date']; ?>" onchange="deposit_date_change(this,<?php echo $row; ?>,0);updateSeq(<?php echo $bill['seq']; ?>);" />
  															</td>
  															<td height="40" class="basic_td" align="center"  filter_column="12">
  																<span id="sales_deposit_YN<?php echo $row; ?>">
  																	<?php if($bill['deposit_status'] == "Y"){
  																		echo "완료";
  																	} else if ($bill['deposit_status'] == "L") {
        															echo '부족';
        														} else if ($bill['deposit_status'] == "O") {
        															echo '과잉';
        														}else{
  																		echo "미완료";
  																	} ?>
  																</span>
  															</td>
  															<td height="40" class="basic_td" align="center">
  															<?php if($row != 1){?>
  																<img src="<?php echo $misc; ?>img/btn_del0.jpg" onclick="deleteRow(this,'sales_contract_total_amount',0);deleteSeq(<?php echo $bill['seq']; ?>);" />
  															<?php }?>
  															</td>
  														</tr>
        													<?php
        													$row++;
        												}
        											}
        											?>

        										<tr id="sales_issuance_amount_insert_line" >
        											<td></td>
        										</tr>
        										<tr height="40" class="tbl-tr cell-tr" align="center" style="font-weight:bold;">
        											<td>합계</td>
        											<td colspan=2></td>
        											<td></td>
        											<td></td>
        											<td></td>
        											<td><input id="sum_sales_issuance_amount" value="" class="input-common" onchange="numberFormat(this);" style="text-align:right;" readonly/></td>
        											<td><input id="sum_sales_tax_amount" class="input-common" value="" onchange="numberFormat(this);" style="text-align:right;" readonly/></td>
        											<td><input id="sum_sales_total_amount" class="input-common" value="" onchange="numberFormat(this);" style="text-align:right;" readonly/></td>
        											<td></td>
        											<td></td>
        											<td></td>
        											<td></td>
        											<td></td>
        											<td></td>
        											<td></td>
        										</tr>
        									</tbody>
        							</table>
        						</td>
        					</tr>
					<tr>
						<td colspan="12" height="40"></td>
					</tr>
					<tr>
						<td colspan="12" >
							<img src="<?php echo $misc;?>/img/filter_refresh.png" onclick="filter_reset('purchase_statement_table');" width=20 style="float:right;cursor:pointer;margin-bottom:5px;"/>
						</td>
					</tr>
					<tr class="tbl-tr cell-tr border-t">
						<td colspan="12" bgcolor="DEDEDE" align="center" style="font-weight:bold;">매입</td>
					</tr>
					<tr>
						<td colspan="12">
							<table id="purchase_statement_table" width="100%" border="0" cellspacing="0" cellpadding="0" onchange ="filter_reload('purchase_statement_table',event)" style="border-collapse:collapse;">
								<colgroup>
								<col width="4%" />
								<col width="6%" />
								<col width="8%" />
								<col width="2%" />
								<col width="5%" />
								<col width="5%" />
								<col width="5%" />
								<col width="5%" />
								<col width="5%" />
								<col width="17%" />
								<col width="5%" />
								<col width="10%" />
								<col width="5%" />
								<col width="10%" />
								<col width="5%" />
								<col width="3%" />
								</colgroup>
								<thead>
									<tr class="tbl-tr cell-tr row-color1">
										<th align="center">
											<input type="checkbox" id="purchase_company_check_all" class="drop" value="">
										</th>
										<th class="apply-filter no-sort" filter_column="1"><input type="hidden" class="filter_n" value="all">업체
										</th>
										<th class="apply-filter no-sort" filter_column="2"><input type="hidden" class="filter_n" value="all">계약금액
										</th>
										<th>
											<input type="checkbox" class="drop" id="chk_all_2" name="chk_all_2" value="">
										</th>
										<th class="apply-filter no-sort" filter_column="3"><input type="hidden" class="filter_n" value="all">회차
										</th>
										<th class="apply-filter no-sort" filter_column="4"><input type="hidden" class="filter_n" value="all">발행예정일</th>
										<th class="apply-filter no-sort" filter_column="5"><input type="hidden" class="filter_n" value="all">발행금액</th>
										<th class="apply-filter no-sort" filter_column="6"><input type="hidden" class="filter_n" value="all">세액</th>
										<th class="apply-filter no-sort" filter_column="7"><input type="hidden" class="filter_n" value="all">합계</th>
										<th class="apply-filter no-sort" filter_column="8"><input type="hidden" class="filter_n" value="all">국세청 승인번호
										</th>
										<th class="apply-filter no-sort" filter_column="9"><input type="hidden" class="filter_n" value="all">발행월
										</th>
										<td class="apply-filter no-sort" filter_column="10"><input type="hidden" class="filter_n" value="all">발행일자
										</td>
										<th class="apply-filter no-sort" filter_column="11"><input type="hidden" class="filter_n" value="all">발행여부
										</th>
										<th class="apply-filter no-sort" filter_column="12"><input type="hidden" class="filter_n" value="all">입금일자
										</th>
										<th class="apply-filter no-sort" filter_column="13"><input type="hidden" class="filter_n" value="all">입금여부
										</th>
										<th></th>
									</tr>
								</thead>
										<?php
										if(empty($purchase_bill_val)){
											$num = 1;
											foreach ($view_val2 as $item2) {
											// ${"purchase_total_issuance_amount".$num} = 0;?>
											<tr class="purchase_tax_invoice<?php echo $num; ?> insert_purchase_bill  tbl-tr cell-tr">
												<input type="hidden" name="purchase_company_name" value="<?php echo $item2['main_companyname']; ?>" />
												<input type="hidden" class="purchase_issuance_status<?php echo $num; ?> input7" name="purchase_issuance_status" value="N" />
												<input type="hidden" class="purchase_deposit_status<?php echo $num; ?> input7" name="purchase_deposit_status" value="N" />

												<td rowspan="1" class="border" height="40" align="center">
													<input type="checkbox" class="drop" name="company_check" value="purchase_tax_invoice<?php echo $num; ?>" style="vertical-align:top;">
													<p>발행주기</p>
													<select class="select-common drop" id="purchase_issue_cycle_<?php echo $item2['seq']; ?>" name="issue_cycle" style="width:90%">
														<option value="">-미선택-</option>
														<option value="매월">매월</option>
														<option value="익월">익월</option>
														<option value="분기">분기</option>
														<option value="분기익월">분기익월</option>
														<option value="반기">반기</option>
														<option value="연1회">연1회</option>
														<option value="지정일">지정일</option>
													</select> <!-- //발행주기 -->
													<p>납부회차</p>
													<input type="text" id="purchase_pay_session_<?php echo $item2['seq']; ?>" class="input-common" name="purchase_pay_session" value="<?php echo $item2['purchase_pay_session']; ?>" onchange="numberFormat(this);"/>
												</td>
												<td rowspan="1" height="40" class="purchase_contract_total_amount<?php echo $num; ?> basic_td" align="center" filter_column="1"><?php echo $item2['main_companyname']; ?></td>
												<td id="purchase_contract_total_amount<?php echo $num; ?>" rowspan="1" filter_column="2" class="purchase_contract_total_amount<?php echo $num; ?> basic_td" height="40" align="center"><?php echo number_format((int)${"main_company_amount".$num}); ?></td>
												<td colspan="13" height="40" class="basic_td empty_row" align="center">-등록된 계산서가 없습니다.</td>
											</tr>
                      <tr align="center" style="font-weight:bold;" class="tbl-tr cell-tr">
  											<td colspan=3 class="basic_td"><?php echo $item2['main_companyname']." "; ?>요약</td>
  											<td class="basic_td"></td>
  											<td class="basic_td"></td>
  											<td class="basic_td"></td>
  											<td class="basic_td"><input id="sum_purchase_issuance_amount<?php echo $num; ?>" name ="sum_purchase_issuance_amount" value="" class="input-common" onchange="numberFormat(this);" style="text-align:right;" readonly/></td>
  											<td class="basic_td"><input id="sum_purchase_tax_amount<?php echo $num; ?>" name ="sum_purchase_tax_amount" class="input-common" value="" onchange="numberFormat(this);"style="text-align:right;" readonly/></td>
  											<td class="basic_td"><input id="sum_purchase_total_amount<?php echo $num; ?>" name ="sum_purchase_total_amount" class="input-common" value="" onchange="numberFormat(this);" style="text-align:right;" readonly/></td>
  											<td class="basic_td"></td>
  											<td class="basic_td"></td>
  											<td class="basic_td"></td>
  											<td class="basic_td"></td>
  											<td class="basic_td"></td>
  											<td class="basic_td"></td>
  											<td class="basic_td"></td>
  										</tr>
											<?php
											$num++;
											}
										}else{
											$num = 1;
											foreach ($view_val2 as $item2) {
												$row2 = 1;
												foreach($purchase_bill_val as $bill){
													if($bill['type'] == "002"){//매입
													if($item2['main_companyname'] == $bill['company_name']){
										?>
														<tr id="bill_<?php echo $bill['seq']; ?>" class="purchase_tax_invoice<?php echo $num; ?> update_purchase_bill tbl-tr cell-tr" <?php if($bill['issuance_status'] == "M"){echo "style='background-color:rgb(255, 227, 227);'";}?>>
                              <?php if($row2 == 1){ ?>
                                <td rowspan="1" class="basic_td" height="40" align="center">
                                  <input type="checkbox" class="drop" name="company_check" value="purchase_tax_invoice<?php echo $num; ?>" style="vertical-align:top;">
                                  <p>발행주기</p>
                                  <select class="select-common drop" id="purchase_issue_cycle_<?php echo $item2['seq']; ?>" name="issue_cycle" style="width:90%">
                                    <option value="" <?php if($item2['issue_cycle'] == ""){echo "selected";} ?>>-미선택-</option>
                                    <option value="매월" <?php if($item2['issue_cycle'] == "매월"){echo "selected";} ?>>매월</option>
                                    <option value="익월" <?php if($item2['issue_cycle'] == "익월"){echo "selected";} ?>>익월</option>
                                    <option value="분기" <?php if($item2['issue_cycle'] == "분기"){echo "selected";} ?>>분기</option>
                                    <option value="분기익월" <?php if($item2['issue_cycle'] == "분기익월"){echo "selected";} ?>>분기익월</option>
                                    <option value="반기" <?php if($item2['issue_cycle'] == "반기"){echo "selected";} ?>>반기</option>
                                    <option value="연1회" <?php if($item2['issue_cycle'] == "연1회"){echo "selected";} ?>>연1회</option>
                                    <option value="지정일" <?php if($item2['issue_cycle'] == "지정일"){echo "selected";} ?>>지정일</option>
                                  </select> <!-- //발행주기 -->
                                  <p>납부회차</p>
                                  <input type="text" id="purchase_pay_session_<?php echo $item2['seq']; ?>" class="input-common" name="purchase_pay_session" value="<?php echo $item2['purchase_pay_session']; ?>" onchange="numberFormat(this);" />
                                </td>
                                <td height="40" class="purchase_contract_total_amount<?php echo $num; ?> basic_td"
                                  align="center" filter_column="1"><?php echo $bill['company_name']; ?></td>
                                  <td id="purchase_contract_total_amount<?php echo $num; ?>" rowspan="1"
                                    class="purchase_contract_total_amount<?php echo $num; ?> basic_td" height="40"
                                    align="center" filter_column="2"><?php echo number_format((int)${"main_company_amount".$num}); ?></td>
                                  <?php } ?>
															<input type="hidden" name="purchase_company_name" value="<?php echo $bill['company_name']; ?>" />
															<input type="hidden" class="purchase_issuance_status<?php echo $num; ?> input7" name="purchase_issuance_status" onchange="updateSeq(<?php echo $bill['seq']; ?>);" value="<?php echo $bill['issuance_status']; ?>" />
															<input type="hidden" class="purchase_deposit_status<?php echo $num; ?> input7" name="purchase_deposit_status" onchange="updateSeq(<?php echo $bill['seq']; ?>);" value="<?php echo $bill['deposit_status']; ?>" />
															<?php if($bill['issuance_status'] == "Y" && ($id != "skkim" && $id !="yjjoo" && $id !="hbhwang" && $id !="selee")){?>
																<td height="40" class="basic_td" align="center">
																	<input type="checkbox" name="pay_checkbox" class="checkbox_2" value="">
																</td>
																<td height="40" class="basic_td" align="center" filter_column="3"><?php echo $bill['pay_session']; ?>
																	<input type="hidden" class="pay_session<?php echo $num; ?> input7" name="pay_session" value="<?php echo $bill['pay_session']; ?>" style="width:60%;" />
																</td>
																<td height="40" class="basic_td" align="center" filter_column="4">
																	<input type="date" class="issue_schedule_date<?php echo $num; ?> input-common date_input" name="issue_schedule_date" value="<?php echo $bill['issue_schedule_date']; ?>" onchange="updateSeq(<?php echo $bill['seq']; ?>);" style="width:100%;" />
																</td>
																<td height="40" class="basic_td" align="center" filter_column="5"><?php if($bill['issuance_amount']==""){echo $bill['issuance_amount'];}else{echo number_format((int)$bill['issuance_amount']);} ?>
                                 								 <input type="hidden" class="purchase_issuance_amount<?php echo $num; ?> input7" name="purchase_issuance_amount" style="text-align:right;" value="<?php if($bill['issuance_amount']==""){echo $bill['issuance_amount'];}else{echo number_format((int)$bill['issuance_amount']);} ?>" />
																</td>
																<td height="40" class="basic_td" align="center" filter_column="6"><?php if($bill['tax_amount']==""){echo $bill['tax_amount'];}else{echo number_format((int)$bill['tax_amount']);} ?>
                                 								 <input type="hidden" class="purchase_tax_amount<?php echo $num; ?> input7" name="purchase_tax_amount" style="text-align:right;" value="<?php if($bill['tax_amount']==""){echo $bill['tax_amount'];}else{echo number_format((int)$bill['tax_amount']);} ?>" />
																</td>
																<td height="40" class="basic_td" align="center" filter_column="7"><?php if($bill['total_amount']==""){echo $bill['total_amount'];}else{echo number_format((int)$bill['total_amount']);} ?>
                                 								 <input type="hidden" class="purchase_total_amount<?php echo $num; ?> input7" name="purchase_total_amount" style="text-align:right;" value="<?php if($bill['total_amount']==""){echo $bill['total_amount'];}else{echo number_format((int)$bill['total_amount']);} ?>" />
																</td>
																<td height="40" class="basic_td" align="center" filter_column="8"><?php echo $bill['tax_approval_number']; ?>
																	<input type="hidden" name="purchase_tax_approval_number" class="purchase_tax_approval_number<?php echo $num; ?> input7" value="<?php echo $bill['tax_approval_number']; ?>" onchange="taxApprovalNumer(this,<?php echo $num; ?>,1);" />
																</td>
															<?php }else{ ?>
																<td height="40" class="basic_td" align="center">
																	<input type="checkbox" name="pay_checkbox" class="checkbox_2" value="">
																</td>
																<td height="40" class="basic_td" align="center" filter_column="3">
																	<input type="text" class="pay_session<?php echo $num; ?> input-common" name="pay_session" value="<?php echo $bill['pay_session']; ?>" style="width:60%;text-align:center;" onchange="updateSeq(<?php echo $bill['seq']; ?>);" />
																</td>
																<td height="40" class="basic_td" align="center" filter_column="4">
																	<input type="date" class="issue_schedule_date<?php echo $num; ?> input-common date_input" name="issue_schedule_date" value="<?php echo $bill['issue_schedule_date']; ?>" onchange="updateSeq(<?php echo $bill['seq']; ?>);" style="width:100%;" />
																</td>
																<td height="40" class="basic_td" align="center" filter_column="5">
																	<input type="text" class="purchase_issuance_amount<?php echo $num; ?> input-common" name="purchase_issuance_amount" style="text-align:right;" value="<?php if($bill['issuance_amount'] == "" ){echo $bill['issuance_amount']; }else{echo number_format((int)$bill['issuance_amount']);} ?>" onchange="numberFormat(this);updateSeq(<?php echo $bill['seq']; ?>);get_tax_amount(this,1,<?php echo $num; ?>);get_total_amount(this,1);" />
																</td>
																<td height="40" class="basic_td" align="center" filter_column="6">
																	<input type="text" class="purchase_tax_amount<?php echo $num; ?> input-common" name="purchase_tax_amount" style="text-align:right;" value="<?php if($bill['tax_amount'] == "" ){echo $bill['tax_amount']; }else{echo number_format((int)$bill['tax_amount']);} ?>" onchange="numberFormat(this);updateSeq(<?php echo $bill['seq']; ?>);get_total_amount(this,1);" />
																</td>
																<td height="40" class="basic_td" align="center" filter_column="7">
																	<input type="text" class="purchase_total_amount<?php echo $num; ?> input-common" name="purchase_total_amount" style="text-align:right;" value="<?php if($bill['total_amount'] == "" ){echo $bill['total_amount']; }else{echo number_format((int)$bill['total_amount']);} ?>" onchange="numberFormat(this);get_sum_amount(1,<?php echo $num; ?>);" readonly />
																</td>
																<td height="40" class="basic_td" align="center" filter_column="8">
																	<input type="text" name="purchase_tax_approval_number" class="purchase_tax_approval_number<?php echo $num; ?> input7" value="<?php echo $bill['tax_approval_number']; ?>" onchange="taxApprovalNumer(this,<?php echo $num; ?>,1);updateSeq(<?php echo $bill['seq']; ?>);" />
																</td>
															<?php }?>
															<td height="40" class="basic_td" align="center" filter_column="9"><input type="text"
																	class="purchase_issuance_month<?php echo $num; ?> input7" name="purchase_issuance_month" value="<?php echo $bill['issuance_month']; ?>"
																	style="text-align:center;" readonly /></td>
															<td height="40" class="basic_td" align="center" filter_column="10"><input type="text"
																	class="purchase_issuance_date<?php echo $num; ?> input7" name="purchase_issuance_date" value="<?php echo $bill['issuance_date']; ?>"
																	onchange="issuance_date_change(this,<?php echo $num; ?>,1);updateSeq(<?php echo $bill['seq']; ?>);" style="text-align:center;" readonly /></td>
															<td height="40" class="basic_td" align="center" filter_column="11">
																<span class="purchase_issuance_YN<?php echo $num; ?>" name="purchase_issuance_YN">
																	<?php if($bill['issuance_status'] == "Y"){
																		echo "완료";
																	}else if ($bill['issuance_status'] == "N"){
																		echo "미완료";
																	}else if ($bill['issuance_status'] == "C"){
																		echo "발행취소";
																	}else if ($bill['issuance_status'] == "M"){
																		echo "마이너스발행";
																	}
																	?>
																</span>
															</td>
															<td height="40" class="basic_td" align="center" filter_column="12">
																<input type="date" class="purchase_deposit_date<?php echo $num; ?> input-common" name="purchase_deposit_date" value = "<?php echo $bill['deposit_date']; ?>" onchange="deposit_date_change(this,<?php echo $num; ?>,1);updateSeq(<?php echo $bill['seq']; ?>);" />
															</td>
															<td height="40" class="basic_td" align="center" filter_column="13">
																<span class="purchase_deposit_YN<?php echo $num; ?>">
																<?php if($bill['deposit_status'] == "Y"){
																		echo "완료";
																} else if ($bill['deposit_status'] == "L") {
    															echo '부족';
    														} else if ($bill['deposit_status'] == "O") {
    															echo '과잉';
    														} else{
																	echo "미완료";
																} ?>
															</span>
															</td>
															<td height="40" class="basic_td" align="center">
															<?php if($row2 == 1 ){ ?>
																<img src="<?php echo $misc; ?>img/btn_add.jpg" onclick="addRow('purchase_tax_invoice<?php echo $num; ?>','purchase_contract_total_amount<?php echo $num; ?>',1);" />
															<?php }else{ ?>
																<img src="<?php echo $misc; ?>img/btn_del0.jpg" onclick="deleteRow(this,'purchase_contract_total_amount<?php echo $num; ?>',1);deleteSeq(<?php echo $bill['seq']; ?>);" />
															<?php } ?>
															</td>
														</tr>
														<?php
														echo "<script>";
														echo "$('.purchase_contract_total_amount{$num}').attr('rowSpan', {$row2});";
														echo "$('.purchase_contract_total_amount{$num}').prev().attr('rowSpan', {$row2});";
														echo "</script>";
														$row2++;
												}
											}

										}
										if($row2 == 1){?>
											<tr class="purchase_tax_invoice<?php echo $num; ?> insert_purchase_bill tbl-tr cell-tr">
												<input type="hidden" name="purchase_company_name" value="<?php echo $item2['main_companyname']; ?>" />
												<input type="hidden" class="purchase_issuance_status<?php echo $num; ?> input7" name="purchase_issuance_status" value="N" />
												<input type="hidden" class="purchase_deposit_status<?php echo $num; ?> input7" name="purchase_deposit_status" value="N" />
												<td rowspan="1" class="basic_td" height="40" align="center">
													<input type="checkbox" class="drop" name="company_check" value="purchase_tax_invoice<?php echo $num; ?>" style="vertical-align:top;">
													<p>발행주기</p>
													<select class="select-common drop" id="purchase_issue_cycle_<?php echo $item2['seq']; ?>" name="issue_cycle" style="width:90%">
														<option value="">-미선택-</option>
														<option value="매월">매월</option>
														<option value="익월">익월</option>
														<option value="분기">분기</option>
														<option value="분기익월">분기익월</option>
														<option value="반기">반기</option>
														<option value="연1회">연1회</option>
														<option value="지정일">지정일</option>
													</select> <!-- //발행주기 -->
													<p>납부회차</p>
													<input type="text" id="purchase_pay_session_<?php echo $item2['seq']; ?>" class="input-common" name="purchase_pay_session" value="<?php echo $item2['purchase_pay_session']; ?>" onchange="numberFormat(this);"/>
												</td>
												<td rowspan="1" height="40" class="purchase_contract_total_amount<?php echo $num; ?> basic_td" align="center" filter_column="1"><?php echo $item2['main_companyname']; ?></td>
												<td id="purchase_contract_total_amount<?php echo $num; ?>" rowspan="1" filter_column="2" class="purchase_contract_total_amount<?php echo $num; ?> basic_td" height="40" align="center"><?php echo number_format((int)${"main_company_amount".$num}); ?></td>
												<td colspan="13" height="40" class="basic_td empty_row" align="center">-등록된 계산서가 없습니다.</td>
											</tr>
										<?php } ?>
										<tr align="center" style="font-weight:bold;" class="tbl-tr cell-tr">
											<td colspan=3 class="basic_td"><?php echo $item2['main_companyname']." "; ?>요약</td>
											<td class="basic_td"></td>
											<td class="basic_td"></td>
											<td class="basic_td"></td>
											<td class="basic_td"><input id="sum_purchase_issuance_amount<?php echo $num; ?>" name ="sum_purchase_issuance_amount" value="" class="input-common" onchange="numberFormat(this);" style="text-align:right;" readonly/></td>
											<td class="basic_td"><input id="sum_purchase_tax_amount<?php echo $num; ?>" name ="sum_purchase_tax_amount" class="input-common" value="" onchange="numberFormat(this);"style="text-align:right;" readonly/></td>
											<td class="basic_td"><input id="sum_purchase_total_amount<?php echo $num; ?>" name ="sum_purchase_total_amount" class="input-common" value="" onchange="numberFormat(this);" style="text-align:right;" readonly/></td>
											<td class="basic_td"></td>
											<td class="basic_td"></td>
											<td class="basic_td"></td>
											<td class="basic_td"></td>
											<td class="basic_td"></td>
											<td class="basic_td"></td>
											<td class="basic_td"></td>
										</tr>
										<?php
										$num++;
									}
									}?>
									<tr height="40" class="tbl-tr cell-tr" align="center" style="font-weight:bold;">
										<td colspan=3>매입 총 합계</td>
										<td></td>
										<td></td>
										<td></td>
										<td><input id="t_sum_purchase_issuance_amount" name ="t_sum_purchase_issuance_amount" value="" class="input-common" onchange="numberFormat(this);" style="text-align:right;" readonly/></td>
										<td><input id="t_sum_purchase_tax_amount" name ="t_sum_purchase_tax_amount" class="input-common" value="" onchange="numberFormat(this);"style="text-align:right;" readonly/></td>
										<td><input id="t_sum_purchase_total_amount" name ="t_sum_purchase_total_amount" class="input-common" value="" onchange="numberFormat(this);" style="text-align:right;" readonly/></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
							</table>
    					</td>
    				</tr>
					<?php } ?>
					</table>
    					</td>
    				</tr>
					<tr>
						<td height="10"></td>
					</tr>
					</form>

    <!--버튼-->
					<tr>
						<td align="right">
              <input type="button" class="btn-common btn-color1" width="64" height="31" style="cursor:pointer;margin-right:10px;" onclick="popup_close();" value="취소" />
  						<input type="button" class="btn-common btn-color2" width="64" height="31" style="cursor:pointer" onclick="javascript:chkForm();return false;" value="수정" />
						</td>
					</tr>
    <!--//버튼-->
					<tr>
						<td>&nbsp;</td>
					</tr>
				</table>
			</td>
    	</tr>
    </table>
    <div style="display:none;" id="loading_div">
      <img width=50 src="<?php echo $misc; ?>img/loading.gif"/>
    </div>
    <script src="//cdnjs.cloudflare.com/ajax/libs/babel-standalone/6.26.0/babel.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/babel-polyfill/7.4.3/polyfill.js"></script>
    <script type="text/babel" data-presets="es2015, stage-3">

		get_sum_amount(0); // 매출총합

		for(var i=0; i<$("input[name=sum_purchase_issuance_amount]").length; i++){
			get_sum_amount(1,i+1);
		}

        var mb_cnt = Number($("#row_max_index2").val());

		//select box 검색 기능
		$("#check_product_company").select2({width:'99%'});
		$("#check_product_name").select2({width:'99%'});
		$("select[name=product_company]").select2({width:'99%'});


    $("#select_customer_company, #select_main_company, #select_sales_company").select2({
      width:'99%',
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
        return{
          results: data
        };
      }
    }
  });

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
				url: "<?php echo site_url(); ?>/sales/forcasting/subProjectAdd",
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

		function productSearch(idx,val) {
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
						for (var i = 0; i < data.length; i++) {
							html += "<option value ='" + data[i].seq + "'>" + data[i].product_name + "</option>";
						}
						$("#"+idx+"_product_name").html(html);
						$("#"+idx+"_product_name").select2({width:'99%'});
					}
				});
			}else{
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
						if(val != undefined){
							$("#product_name" + idx).val(val);
						}
						$("#product_name" + idx).select2({width:'99%'});
					}
				});
			}
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
		$("#select_main_company" + idx).select2({width:'99%'});

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
			var type = $("#product_insert_field_"+row_num).find($("select[name=product_name]")).text().trim();
			$("#update_produce_saledate").val($("#update_produce_saledate").val()+"/"+type+","+change+","+oldValue+","+newValue);
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
							if(this.value != "project"){
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

						 if (this.value != "project"){ //product_row
							if(tagName == 0){//input
								var old_val = $("#"+column+this.value).val();
								$("#"+column+this.value).val(val);
								if(column=="product_sales" || column=="product_purchase" ){
									product_profit_change(this.value,1);
								}else if(column=="maintain_expire"){
									exceptionsaledateChange((this.value+1),'expire',old_val,val);
								}else{
									if($("#"+column+this.value).attr('onchange') != "" && $("#"+column+this.value).attr('onchange') != undefined ){
										$("#"+column+this.value).trigger('change');
									}
								}
							}else if(tagName == 1){//select
								$("#"+column+this.value).val(val).prop("selected",true);
								if($("#"+column+this.value).attr('onchange') != "" && $("#"+column+this.value).attr('onchange') != undefined ){
									$("#"+column+this.value).trigger('change');
								}
							}else{//select2
								$("#"+column+this.value).val(val).prop("selected",true);
								$("#"+column+this.value).select2().val(val);

								if(column == "product_company"){
									product_type_default(this.value);
									productSearch(this.value);
								}else{
									if($("#"+column+this.value).attr('onchange') != "" && $("#"+column+this.value).attr('onchange') != undefined ){
										$("#"+column+this.value).trigger('change');
									}
								}
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
				filter_reload('product_table');
				if(column=="product_sales" || column=="product_purchase" ){
					t_forcasting_profit_change();
					forcasting_profit_change();
				}
			}
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
        var input_t = ['maintain_begin', 'maintain_expire', 'product_sales', 'product_purchase'];
        var select_t = ['product_state', 'product_supplier', 'maintain_yn', 'maintain_target'];
        var select2_t = ['product_company', 'product_name'];
        $('input:checkbox[name="product_row"]').each(function() {
          if(this.checked == true) {
            if(this.value != 'project') {
              for (var i = 0; i < input_t.length; i++) {
                var column = input_t[i];
                if($.inArray('check_'+column, change_collective) != -1) {

                  var val = $('#check_'+column).val();

                  var old_val = $("#"+column+this.value).val();
  								$("#"+column+this.value).val(val);
  								if(column=="product_sales" || column=="product_purchase" ){
  									product_profit_change(this.value,1);
  								}else if(column=="maintain_expire"){
  									exceptionsaledateChange((this.value+1),'expire',old_val,val);
  								}else{
  									if($("#"+column+this.value).attr('onchange') != "" && $("#"+column+this.value).attr('onchange') != undefined ){
  										$("#"+column+this.value).trigger('change');
  									}
  								}
                }
              }
              for (var i = 0; i < select_t.length; i++) {
                var column = select_t[i];

                if($.inArray('check_'+column, change_collective) != -1) {
                  var val = $('#check_'+column).val();

                  $("#"+column+this.value).val(val).prop("selected",true);
  								if($("#"+column+this.value).attr('onchange') != "" && $("#"+column+this.value).attr('onchange') != undefined ){
  									$("#"+column+this.value).trigger('change');
  								}
                }
              }
              for (var i = 0; i < select2_t.length; i++) {
                var column = select2_t[i];

                if($.inArray('check_'+column, change_collective) != -1) {
                  var val = $('#check_'+column).val();

                  $("#"+column+this.value).val(val).prop("selected",true);
  								$("#"+column+this.value).select2().val(val);

  								if(column == "product_company"){
  									product_type_default(this.value);
  									productSearch(this.value);
  								}else{
  									if($("#"+column+this.value).attr('onchange') != "" && $("#"+column+this.value).attr('onchange') != undefined ){
  										$("#"+column+this.value).trigger('change');
  									}
  								}
                }
              }
            } else {
              $('#exception_saledate2').val($('#check_maintain_begin').val());
              $('#exception_saledate3').val($('#check_maintain_expire').val());
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
				for(var i=0; i< $("input[name=product_row]").length; i++){
					var tr = $("input[name=product_row]").eq(i).parent().parent();
					var td = $("input[name=product_row]").eq(i).parent();
					if(tr.css('display') !== 'none' && td.css('display') !== 'none' ){
						$("input[name=product_row]").eq(i).prop("checked", true);
					}
				}
				// $("input[name=product_row]").prop("checked", true); // 전체선택 체크박스가 해제된 경우
			} else { //해당화면에 모든 checkbox들의 체크를해제시킨다.
				$("input[name=product_row]").prop("checked", false);
			}
      check_product_info();
		})
	})

	//제조사 바뀌면 하드웨어 소프트웨어 전체로 수정
	function product_type_default(idx){
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
			// html += "<tr class=" + id + "><td colspan='10' height='1' bgcolor='#e8e8e8'></td></tr><tr class=" + id + "><td height='40' align='center' class='t_border' bgcolor='f8f8f9' style='font-weight:bold;'>납부회차</td><td align='left' class='t_border' style='padding-left:10px;'><input type='text' name='purchase_pay_session' class='input5' ></td></tr>"
			html += "<tr class=" + id + "><td colspan=10 height='2' bgcolor='#797c88'></td></tr>";
			$('#main_insert').before(html);
			$("#select_main_company"+$("#row_max_index").val()).select2({width:'99%'});
			document.documentElement.scrollTop = document.body.scrollHeight; //스크롤 맨밑으로 내려
		});

		$("#product_add").click(function() {
			$("#row_max_index2").val(Number(Number($("#row_max_index2").val()) + Number(1)));
			var row_num = Number($("#row_max_index2").val())-1;
			var id = "product_insert_field_" + $("#row_max_index2").val(); //선
			var html = "";
			html += '<tr id="'+id+'" class="tbl-tr cell-tr"><td height="40" align="center" ><input type="checkbox" name="product_row" value="'+row_num+'" /></td>';
			html += '<td align="center"><span class="p_num">'+$("#row_max_index2").val()+'</span></td>';
			html += '<td align="left"></td>';
			html += '<td align="left">';
			html += '<select name="product_company" id="product_company'+row_num+'" class="select-common" onchange="product_type_default('+row_num+');productSearch('+row_num+');">';
			html += '<option value="" >제조사</option>';
			<?php foreach($product_company as $pc){?>
				html += "<option value='<?php echo $pc['product_company'] ;?>'><?php echo $pc['product_company']; ?></option>";
			<?php }?>
			html += '</select></td>';
			html += '<td><select name="product_supplier" id="product_supplier'+row_num+'" class="select-common">';
      html += '<option value=""></option>';
			<?php foreach($view_val2 as $item2){?>
				html += "<option value='<?php echo $item2['main_companyname'];?>'><?php echo $item2['main_companyname']; ?></option>";
			<?php }?>
			html += '</select></td><td align="left">';
			html += '<select name="product_type" id="product_type'+row_num+'" class="select-common" onchange="productSearch('+row_num+');">';
			html += '<option value="" selected>전체</option>';
			html += '<option value="hardware">하드웨어</option>';
			html += '<option value="software">소프트웨어</option>';
			html += '<option value="appliance">어플라이언스</option>';
			html += '</select></td><td align="left">';
			html += '<select name ="product_name" id="product_name'+row_num+'" class="select-common" onclick="productSearch('+row_num+');">';
			html += '<option value="" >제품선택</option>';
			html += '</select></td>';
			html += '<td align="left"><input name="product_licence" type="text" class="input-common" id="product_licence'+row_num+'" value="" onkeyup="commaCheck(this);" /></td>';
			html += '<td align="left"><input name="product_serial" type="text" class="input-common" id="product_serial'+row_num+'" value="" onkeyup="commaCheck(this);" /></td>';
			html += '<td align="left"><select name="product_state" id="product_state'+row_num+'" class="select-common" >';
			html += '<option value="0">- 제품 상태 -</option>';
			html += '<option value="001">입고 전</option>';
			html += '<option value="002">창고</option>';
			html += '<option value="003">고객사 출고</option>';
			html += '<option value="004">장애반납</option></select></td>';
			html += '<td align="left"><input name="maintain_begin" type="date" class="input-common" id="maintain_begin'+row_num+'" value="" /></td>';
			html += '<td align="left"><input name="maintain_expire" type="date" class="input-common" id="maintain_expire'+row_num+'" value="" onchange="exceptionsaledateChange('+$("#row_max_index2").val()+','+"'expire'"+','+"''"+',this.value)" onkeypress="return false"/></td>';
			html += '<td align="left"><select name="maintain_yn" id="maintain_yn'+row_num+'" class="select-common" ><option value="0">- 유/무상여부 -</option><option value="Y">유상</option><option value="N">무상</option></select></td>';
			html += '<td class="tbl-cell"><select name="maintain_target" id="maintain_target'+row_num+'" class="select-common" ><option value="0">유지보수 대상</option><option value="Y">대상</option><option value="N">비대상</option></select></td>';
			html += '<td align="left"><input name="product_sales" type="text" class="input-common" id="product_sales'+row_num+'" value="0" onclick="numberFormat(this);" onchange="numberFormat(this);product_profit_change('+row_num+',0);" style="text-align:right;" /></td>';
			html += '<td align="left"><input name="product_purchase" type="text" class="input-common" id="product_purchase'+row_num+'" value="0" onclick="numberFormat(this);" onchange="numberFormat(this);product_profit_change('+row_num+',0);" style="text-align:right;"/></td>';
			html += '<td align="left"><input name="product_profit" type="text" class="input-common" id="product_profit'+row_num+'" value="0" style="text-align:right;" readonly /></td>';
			html += '<td align="left"><input name="comment" type="text" class="input-common" id="comment'+row_num+'" value="" /></td><td align="center"><img src="<?php echo $misc; ?>img/btn_del0.jpg" onclick="javascript:product_list_del('+$("#row_max_index2").val()+');" style="cursor:pointer;" /></td></tr>';
			$('#product_input_place').append(html);
			$("#product_company"+row_num).select2({width:'99%'});
			document.documentElement.scrollTop = document.body.scrollHeight; //스크롤 맨밑으로 내려
			filter_reload('produt_table');
			$(".select-all").prop('checked',false);
      p_numbering();
      check_product_info();
		});
	});

	function product_list_del(idx,product_seq) {
		if(product_seq){
			$("#delete_product_array").val($("#delete_product_array").val()+","+product_seq)
		}
		$("#product_insert_field_" + idx).remove();
		t_forcasting_profit_change();
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

	//delete row(세금계산서)
	function deleteRow(obj, rowspanid, type) {
		if (type == 0) {
			var update_seq = "";
			var tr = $(obj).parent().parent();
			var change_num = tr.find($("input[name=pay_session]")).val();
			var cnt = tr.nextAll().find($("input[name=pay_session]")).length;

			var num =0;
			tr.closest("table").find("input[name=pay_session]").each(function () {
				if(this.value == change_num){
					num++;
				}
			})

			if(num == 1){
				for(var i=0; i<cnt; i++){
					var change_session = tr.nextAll().find($("input[name=pay_session]"))[i];
					var change_session_tr = $(change_session).closest("tr");
					if(change_session_tr.attr("class") != undefined){
						if(change_session_tr.attr("class") == "update_sales_bill"){
								if(change_session_tr.attr("id").indexOf("bill_") !== -1){
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
				}
			}
			tr.remove();
			var rowspan = Number($("#" + rowspanid).attr("rowspan"));
			$("#" + rowspanid).attr("rowSpan", rowspan - 1);
			$("#" + rowspanid).prev().attr("rowSpan", rowspan - 1);
			get_sum_amount(0);
			updateSeq(update_seq);
		} else {
			var update_seq = "";
			var tr = $(obj).parent().parent();
			var trclass=tr.attr('class');
			var change_num = tr.find($("input[name=pay_session]")).val()
			var cnt = tr.nextAll().find($("input[name=pay_session]")).length;

			var num =0;
			var test =trclass.split(" ");
			$("."+test[0]).find("input[name=pay_session]").each(function () {
				if(this.value == change_num){
					num++;
				}
			})
			if(num == 1){
				for(var i=0; i<cnt; i++){
					var change_session = tr.nextAll().find($("input[name=pay_session]"))[i];
					var change_session_tr = $(change_session).parent().parent();
					if(change_session_tr.attr('class').indexOf(trclass) != -1){
						if(change_session_tr.attr("id")!=undefined){
							if(change_session_tr.attr("id").indexOf("bill_") !=-1){
								if(update_seq == ""){
									update_seq += change_session_tr.attr("id").replace("bill_","");
								}else{
									update_seq += ',' + change_session_tr.attr("id").replace("bill_","");
								}

							};
						}
						$(change_session).val(change_num);
						change_num++;
					}
				}
			}
			tr.remove();
			var rowspan = Number($("#" + rowspanid).attr("rowspan"));
			$("." + rowspanid).attr("rowSpan", rowspan - 1);
			$("." + rowspanid).prev().attr("rowSpan", rowspan - 1);
			for(var i=0; i<$("input[name=sum_purchase_issuance_amount]").length; i++){
				get_sum_amount(1,i+1);
			}
			updateSeq(update_seq);
		}
	}

	//계싼서 추가
	function addRow(insertLine, rowspanid, type ,collective) {
		var tr_row = false;

		if(collective == "unIssue"){ // 취소발행
			tr_row = true
		}else{
			if(type == 0){//매출
				var first_row = $("#"+insertLine).closest("table").find(".empty_row");
				if($("#"+insertLine).closest("table").find("input[name=pay_session]").length != 0){
					tr_row = true
				}
			}else{//매입
				var first_row = $("."+insertLine).find(".empty_row");
				if($("."+insertLine).find("input[name=pay_session]").length != 0){
					tr_row = true
				}
			}

			if(collective == undefined){
				if(first_row.length >= 1){
					alert("계산서 최초 생성은 발행주기와 계산서 발행 기준일로 생성해주세요.");
					return false;
				}
			}
		}

		if (type == 0) {//매출
			//나머지 금액구하기
			var total_amount = Number($("#sales_contract_total_amount").text().replace(/\,/g, ''));
			var remain_amount = total_amount;
			var row_num = $("input[name=sales_issuance_amount]").length + 1;
			var pay_session =[];
			var idx = 0;
			if($("#sales_statement_table").find("input[name=pay_session]").length == 0 ){
				pay_session = 1;
			}else{
				$("#sales_statement_table").find("input[name=pay_session]").each(function () {
					pay_session[idx] = this.value;
					idx++;
				})
				pay_session = (Math.max.apply(null,pay_session))+1;
			}

			var issue_schedule_date = "";
			if(collective == undefined){
				for (var i=0; i<$("input[name=sales_issuance_amount]").length; i++) {
					remain_amount -= Number($("input[name=sales_issuance_amount]").eq(i).val().replace(/\,/g, ''));
				}
			}else{
				collective = collective.split(',')
				issue_schedule_date = collective[0];
				remain_amount = "";
			}

			if (remain_amount == 0 && remain_amount != "") {
				alert("총 발행 금액이 계약 금액과 일치합니다.")
				return false;
			}
			var html ="";
			if(tr_row){
				html = '<tr class="insert_sales_bill"><input type="hidden" id="sales_issuance_status' +
				row_num + '" name="sales_issuance_status" class="input7" value="N" /><input type="hidden" id="sales_deposit_status' +
				row_num + '" name="sales_deposit_status" class="input7" value="N" />';
			}
			html += '<td height="40" class="basic_td" align="center"><input type="checkbox" name="pay_checkbox" class="checkbox_1" value=""></td>';
			html += '<td height="40" class="basic_td" align="center" filter_column="2"><input type="text" id="pay_session'+row_num +'" name="pay_session" class="input7" value="'+pay_session+'" style="width:60%;text-align:center;" /></td>';
			html += '<td height="40" class="basic_td" align="center" filter_column="3"><input type="date" id="issue_schedule_date'+row_num +'" name="issue_schedule_date" class="input7 date_input" value="'+issue_schedule_date+'" style="width:100%;text-align:center;" /></td>';
			html += '<td height="40" class="basic_td" align="right" filter_column="4"><input type="text" id="sales_issuance_amount' + row_num + '" name="sales_issuance_amount" class="input7" style="text-align:right;" value="' + remain_amount + '" onchange="numberFormat(this);get_tax_amount(this,0,'+row_num+');get_total_amount(this,0);" /></td>';
			html += '<td height="40" class="basic_td" align="right" filter_column="5"><input type="text" id="sales_tax_amount' + row_num + '" name="sales_tax_amount" class="input7" style="text-align:right;" value="" onchange="numberFormat(this);get_total_amount(this,0);" /></td>';
			html += '<td height="40" class="basic_td" align="right" filter_column="6"><input type="text" id="sales_total_amount' + row_num + '" name="sales_total_amount" class="input7" style="text-align:right;" value="" onchange="numberFormat(this);get_sum_amount(0);" /></td>';
			html += '<td height="40" class="basic_td" align="center" filter_column="7"><input type="text" id="sales_tax_approval_number'+row_num+'" name="sales_tax_approval_number" class="input7" onchange="taxApprovalNumer(this,'+row_num+',0);" /></td>';
			html += '<td height="40" class="basic_td" align="center" filter_column="8"><input type="text" id="sales_issuance_month' +
			row_num + '" name="sales_issuance_month" class="input7" style="text-align:center;" readonly/></td>';
			html += '<td height="40" class="basic_td" align="center" filter_column="9"><input type="text" id="sales_issuance_date' +
			row_num + '" name="sales_issuance_date" class="input7" onchange="issuance_date_change(this,' + row_num +
			',0);" style="text-align:center;" readonly /></td>';
			html += '<td height="40" class="basic_td" align="center" filter_column="10"><span id="sales_issuance_YN' +
			row_num + '" name="sales_issuance_YN">미완료</span></td>';
			html += '<td height="40" class="basic_td" align="center" filter_column="11"><input type="date" id="sales_deposit_date' +
			row_num + '" name="sales_deposit_date" class="input7" onchange="deposit_date_change(this,' + row_num +
			',0);"/></td>';
			html += '<td height="40" class="basic_td" align="center" filter_column="12"><span id="sales_deposit_YN' +
			row_num + '">미완료</span></td>';
			html +=
			'<td height="40" class="basic_td" align="center"><img src="<?php echo $misc; ?>img/btn_del0.jpg" onclick="deleteRow(this,' +
			"'sales_contract_total_amount'" + ',0);"/></td>';
			if(tr_row){
				html += '</tr>';
			}

			var rowspan = Number($("#" + rowspanid).attr("rowspan"));
			if(tr_row == false){
				$("#" + insertLine).prev().append(html);
				if($("#" + insertLine).prev().attr("id") != undefined){
					updateSeq($("#" + insertLine).prev().attr("id").replace("bill_",""));
				}
			}else{
				if(collective == "unIssue"){//발행취소일때
					$(insertLine).after(html);
				}else{
					$("#" + insertLine).before(html);
				}
				$("#" + rowspanid).attr("rowSpan", rowspan + 1);
				$("#" + rowspanid).prev().attr("rowSpan", rowspan + 1);
			}
			$("#sales_issuance_amount" + row_num).trigger('change');
			if(collective != "unIssue"){
				$("#sales_pay_session").val(pay_session);
			}
			filter_reload('sales_statement_table');
		} else {//매입
			//나머지 금액구하기
			if(collective == "unIssue"){
				var row_num = $(insertLine).attr("class").split(" ")[0].replace('purchase_tax_invoice', ''); // 이거는 발행취소 add
			}else{
				var row_num = insertLine.replace('purchase_tax_invoice', ''); //이거는 걍 addrow
			}

			// if(!tr_row){
			// 	var session_num = $(".purchase_tax_invoice"+row_num).length;
			// }else{
			// 	var session_num = $(".purchase_tax_invoice"+row_num).length+1;
			// }

			//발행회차 구하기
			var pay_session =[];
			var idx = 0;
			var session_num = 1;
			if($(".purchase_tax_invoice" + row_num).find("input[name=pay_session]").length != 0){
				$(".purchase_tax_invoice" + row_num).find("input[name=pay_session]").each(function () {
					pay_session[idx] = this.value;
					idx++;
				})
				session_num  = (Math.max.apply(null,pay_session))+1;
			}

			var total_amount = Number($("#purchase_contract_total_amount" + row_num).text().replace(/\,/g, ''));
			var remain_amount = total_amount;
			var issue_schedule_date = "";
			var eq = $(".purchase_issuance_amount" + row_num).length;
			if(collective == undefined){
				for (var i = 0; i < $(".purchase_issuance_amount" + row_num).length; i++) {
					remain_amount -= Number($(".purchase_issuance_amount" + row_num).eq(i).val().replace(/\,/g, ''));
				}
			}else{
				collective = collective.split(',')
				issue_schedule_date = collective[0];
				remain_amount = "";
			}

			if (remain_amount == 0 && remain_amount != "" ) {
				alert("총 발행 금액이 계약 금액과 일치합니다.")
				return false;
			}
			var purchase_company_name = $("."+rowspanid).eq(0).text().trim();
			var html ="";
			if(tr_row){
				html = '<tr class="purchase_tax_invoice' + row_num + ' insert_purchase_bill"><input type="hidden" name="purchase_company_name" value="'+purchase_company_name+'" /><input type="hidden" class="purchase_issuance_status' +
				row_num + ' input7" name="purchase_issuance_status" value="N" /><input type="hidden" class="purchase_deposit_status' +
				row_num + ' input7" name="purchase_deposit_status" value="N" />';
			}
			html += '<td height="40" class="basic_td" align="center"><input type="checkbox" name="pay_checkbox" class="checkbox_2" value=""></td>';
			html += '<td height="40" class="basic_td" align="center" filter_column="3"><input type="text" id="pay_session'+row_num +'" name="pay_session" class="input7" value="'+session_num+'" style="width:60%;text-align:center;" /></td>';
			html += '<td height="40" class="basic_td" align="center" filter_column="4"><input type="date" class="issue_schedule_date'+row_num +' input7 date_input" name="issue_schedule_date" value="'+issue_schedule_date+'" style="width:100%;text-align:center;" /></td>';
			html += '<td height="40" class="basic_td" align="right" filter_column="5"><input type="text" class="purchase_issuance_amount' + row_num + ' input7" name="purchase_issuance_amount" style="text-align:right;" value="' + remain_amount + '" onchange="numberFormat(this);get_tax_amount(this,1,'+row_num+');get_total_amount(this,1,'+row_num+');" /></td>';
			html += '<td height="40" class="basic_td" align="right" filter_column="6"><input type="text" class="purchase_tax_amount' + row_num + ' input7" name="purchase_tax_amount" style="text-align:right;" value="' + remain_amount + '" onchange="numberFormat(this);get_total_amount(this,1);" /></td>';
			html += '<td height="40" class="basic_td" align="right" filter_column="7"><input type="text" class="purchase_total_amount' + row_num + ' input7" name="purchase_total_amount" style="text-align:right;" value="' + remain_amount + '" onchange="numberFormat(this);get_sum_amount(1,'+ row_num +');" /></td>';
			html += '<td height="40" class="basic_td" align="center" filter_column="8"><input type="text" name="purchase_tax_approval_number" class="purchase_tax_approval_number'+row_num+' input7" onchange="taxApprovalNumer(this,'+row_num+',1);" /></td>';
			html +=
				'<td height="40" class="basic_td" align="center" filter_column="9"><input type="text" class="purchase_issuance_month' +
				row_num + ' input7" name="purchase_issuance_month" style="text-align:center;" readonly/></td>';
			html += '<td height="40" class="basic_td" align="center" filter_column="10"><input type="text" class="purchase_issuance_date' +
				row_num + ' input7" name="purchase_issuance_date" onchange="issuance_date_change(this,' + row_num +
				',1);" style="text-align:center;" readonly /></td>';
			html +=
				'<td height="40" class="basic_td" align="center" filter_column="11"><span class="purchase_issuance_YN' +
				row_num + '" name="purchase_issuance_YN">미완료</span></td>';
			html += '<td height="40" class="basic_td" align="center" filter_column="12"><input type="date" class="purchase_deposit_date' +
				row_num + ' input7" name="purchase_deposit_date" onchange="deposit_date_change(this,' + row_num +
				',1);"/></td>';
			html +=
				'<td height="40" class="basic_td" align="center" filter_column="13"><span class="purchase_deposit_YN' +
				row_num + '">미완료</span></td>';
			html +='<td height="40" class="basic_td" align="center">';
			if(eq == 0){
				html +='<img src="<?php echo $misc; ?>img/btn_add.jpg" onclick="addRow('+"'purchase_tax_invoice"+row_num+"'" + ',' +"'purchase_contract_total_amount" + row_num + "'" + ',1);"/>';
			}else{
				html +='<img src="<?php echo $misc; ?>img/btn_del0.jpg" onclick="deleteRow(this,' +"'purchase_contract_total_amount" + row_num + "'" + ',1);"/>';
			}
			html +='</td>';
			if(tr_row){
				html += '</tr>';
			}


			var rowspan = Number($("#" + rowspanid).attr("rowspan"));

			if(tr_row == false){
				$("." + insertLine).eq(0).append(html);
				if($("." + insertLine).eq(0).attr("id") != undefined){
					updateSeq($("." + insertLine).eq(0).attr("id").replace("bill_",""));
				}
			}else{
				if(collective == "unIssue"){
					$(insertLine).after(html);
				}else{
					$("." + insertLine).eq($("." + insertLine).length - 1).after(html);
				}
				$("." + rowspanid).attr("rowSpan", rowspan + 1);
				$("." + rowspanid).prev().attr("rowSpan", rowspan + 1);
			}
			$(".purchase_issuance_amount" + row_num).eq(eq).trigger('change');
			if(collective != "unIssue"){
				$("input[name=purchase_pay_session]").eq(row_num-1).val(session_num);
			}
			filter_reload('purchase_statement_table');
		}
	}
	//금액 천단위 마다 ,
	function numberFormat(obj) {
		if (obj.value == "") {
			obj.value = 0;
		}
    	var inputText = obj.value.replace(/[^-?0-9]/gi,"") // 숫자와 - 가능
		var inputNumber = inputText.replace(/,/g, "");
		var fomatnputNumber = inputNumber.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, "$1,");
		obj.value = fomatnputNumber;
	}

	//국세청 승인번호
	function taxApprovalNumer(obj, num, type){
		$(obj).val($(obj).val().replace(/ /gi, "")); //공백제거
		if($(obj).val().length > 26 || $(obj).val().length < 26){
			alert("국세청 승인번호는 26자리로 입력하셔야합니다.");
			$(obj).val("");
			//국세청 승인번호 지우거나 이상있을때 발행월/발행일자/발행여부도 리쉣
			if(type == 0){
				$("#sales_issuance_date"+num).val("");
				$("#sales_issuance_month"+num).val("");
				$("#sales_issuance_status"+num).val("N");
				$("#sales_issuance_YN"+num).text("미완료");
			}else{
				var className = trim($(obj).attr('class').replace('input7', ''));
				var eq = $('.' + className).index(obj);
				$(".purchase_issuance_date"+num).eq(eq).val("");
				$(".purchase_issuance_month"+num).eq(eq).val("");
				$(".purchase_issuance_status"+num).eq(eq).val("N");
				$(".purchase_issuance_YN"+num).eq(eq).text("미완료");
			}
			return false;
		}
		var date = $(obj).val().split("-")[0];
		date = date.replace(/(\d{4})(\d{2})(\d{2})/, '$1-$2-$3');

		if(type == 0){
			$("#sales_issuance_date"+num).val(date);
			$("#sales_issuance_date"+num).change();
			if($(obj).val() == ""){//국세청 승인번호 빈칸일때
				$("#sales_issuance_status"+num).val("N");
				$("#sales_issuance_YN"+num).text("미완료");
			}
		}else{
			var className = trim($(obj).attr('class').replace('input7', ''));
			var eq = $('.' + className).index(obj);
			$(".purchase_issuance_date"+num).eq(eq).val(date);
			$(".purchase_issuance_date"+num).eq(eq).change();
			if($(obj).val() == ""){//국세청 승인번호 빈칸일때
				$(".purchase_issuance_status"+num).val("N");
				$(".purchase_issuance_YN"+num).text("미완료");
			}
		}
	}
	//발행일자 change
	function issuance_date_change(obj, num, type) {
		if (type == 0) {
			var val = $(obj).val();
			val = val.substring(0, val.length - 3);
			$('#sales_issuance_month' + num).val(val);
			if($("#sales_issuance_status" + num).val() != "C" && $("#sales_issuance_status" + num).val() != "M" ){
				$("#sales_issuance_status" + num).val("Y");
				$("#sales_issuance_YN" + num).text("완료")
			}
		} else {
			var className = trim($(obj).attr('class').replace('input7', ''));
			var eq = $('.' + className).index(obj);
			var val = $(obj).val();
			val = val.substring(0, val.length - 3);

			$('.purchase_issuance_month' + num).eq(eq).val(val);
			if($(".purchase_issuance_status" + num).eq(eq).val() != "C" && $(".purchase_issuance_status" + num).eq(eq).val() != "M" ){
				$(".purchase_issuance_status" + num).eq(eq).val("Y");
				$(".purchase_issuance_YN" + num).eq(eq).text("완료")
			}
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
	}

	//delete 되는 seq 가져왕
	function deleteSeq(seq){
		if(trim($("#delete_bill_array").val()) == ""){
			$("#delete_bill_array").val(seq);
		}else{
			$("#delete_bill_array").val($("#delete_bill_array").val()+','+seq);
		}
	}

	//팝업 닫아!!!!!!!!!!!!!!!!!!
	function popup_close(){
		if(confirm("이 페이지에서 나가시겠습니까? 작성중인 내용은 저장 되지 않습니다.")){
			self.close();
		}
	}

  // ki 일괄적용할 회차를 체크 후 선택적용으로 발행금액에 적용
  function collectiveApplication_bill(){
    var c_a_cost = $('#collectiveApplication_cost').val();
    if(c_a_cost == ''){
      alert('적용할 금액을 입력해주세요.');
      return false;
    }

    var chk_length = $('input:checkbox[name="pay_checkbox"]:checked').length;
    if(chk_length <= 0){
      alert('일괄적용할 회차를 선택해주세요.');
      return false;
    }
    for (var i = 0; i < chk_length; i++) {
      var chk_tr = $('input:checkbox[name="pay_checkbox"]:checked').eq(i).closest('tr');
      var chk_class = chk_tr.attr('class');
      console.log(chk_class);
      if(chk_class.indexOf('update_sales_bill') != -1 || chk_class.indexOf('insert_sales_bill') != -1){
        var chk_target = chk_tr.find('input[name="sales_issuance_amount"]');
      }else{
      var chk_target = chk_tr.find('input[name="purchase_issuance_amount"]');
      }
      chk_target.val(c_a_cost);
      chk_target.trigger('change');
    };
    alert('일괄 수정되었습니다.');
  }

  //ki 발행금액 일괄적용 매출 전체선택 체크박스 클릭
  $("#chk_all_1").click(function () {
    if ($("#chk_all_1").is(":checked") == true) { //만약 전체 선택 체크박스가 체크된상태일경우
		for(var i=0; i< $(".checkbox_1").length; i++){
			var tr = $(".checkbox_1").eq(i).parent().parent();
			var td = $(".checkbox_1").eq(i).parent();
			if(tr.css('display') !== 'none' && td.css('display') !== 'none' ){
				$(".checkbox_1").eq(i).prop("checked", true);
			}
		}
    } else { // 전체선택 체크박스가 해제된 경우
      $(".checkbox_1").prop("checked", false);//해당화면에 모든 checkbox들의 체크를해제시킨다.
    }
  })
  //발행금액 일괄적용 매입 전체선택 체크박스 클릭
  $("#chk_all_2").click(function () {
    if ($("#chk_all_2").is(":checked") == true) {  //만약 전체 선택 체크박스가 체크된상태일경우
		for(var i=0; i< $(".checkbox_2").length; i++){
			var tr = $(".checkbox_2").eq(i).parent().parent();
			var td = $(".checkbox_2").eq(i).parent();
			if(tr.css('display') !== 'none' && td.css('display') !== 'none' ){
				$(".checkbox_2").eq(i).prop("checked", true);
			}
		}
    } else { // 전체선택 체크박스가 해제된 경우
      $(".checkbox_2").prop("checked", false);//해당화면에 모든 checkbox들의 체크를해제시킨다.
    }
  })

/////////////////////////////////////필터 선영//////////////////

  //필터적용햇을때 돈계싼(수정전용)
	function filter_profit_change(){
		var forcasting_sales = 0;
		var forcasting_purchase = 0;
		var forcasting_profit = 0;
		for (var i = 0; i <$("input[name=product_sales]").length; i++) {
			if($("input[name=product_sales]").eq(i).parent().parent().css('display') !== 'none' && $("input[name=product_sales]").eq(i).parent().css('display') !== 'none'){
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
		if(e != undefined && $(e.target).attr('class')){
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
		if(target=="sales_statement_table"){
			get_sum_amount(0);
		}else if (target=="purchase_statement_table"){
			for(var i=0; i<$("input[name=sum_purchase_issuance_amount]").length; i++){
				get_sum_amount(1,i+1);
			}
		}
		$("#"+target).find($(".select-all:not(:checked)")).trigger("click");
	}


	//발행주기 발행 기준일로 생성 및 수정
	function collectiveIssueCycle(){

		if($('input:checkbox[name="company_check"]:checked').length < 1){
			alert("계산서를 생성할 매출처 또는 매입처를 선택해주세요.");
			return false;
		}
		if($("#collective_issue_cycle").val() == ""){
			alert("발행주기를 선택해 주세요.");
			$("#collective_issue_cycle").focus();
			return false;
		}
		// if($("#collective_issue_cycle").val() != "지정일" && $("#collective_issue_date").val() == ""){
		if($("#collective_issue_date").val() == ""){
			alert("계산서 발행 기준일을 선택해 주세요.");
			$("#collective_issue_date").focus();
			return false;
		}

		if($("#collective_pay_session").val() == ""){
			alert("납부회차를 입력해주세요.");
			$("#collective_pay_session").focus();
			return false;
		}

		if($("input[name=bill_insert_modify]:checked").length == 0){
			alert("적용 방법 (생성,수정)에 대해 선택해주세요");
			return false;
		}


		var addrow_cnt = $("#collective_pay_session").val();

		// if($("#collective_issue_cycle").val()=="매월"){
		// 	addrow_cnt = 12;
		// }else if($("#collective_issue_cycle").val()=="익월"){
		// 	addrow_cnt = 12;
		// }else if($("#collective_issue_cycle").val()=="분기"){
		// 	addrow_cnt = 4;
		// }else if($("#collective_issue_cycle").val()=="분기익월"){
		// 	addrow_cnt = 4;
		// }else if ($("#collective_issue_cycle").val()=="반기"){
		// 	addrow_cnt = 2;
		// }else if ($("#collective_issue_cycle").val()=="연1회"){
		// 	addrow_cnt = 1;
		// }else if ($("#collective_issue_cycle").val()=="지정일"){
		// 	addrow_cnt = 1;
		// }
		// addrow_cnt


		var date = new Date($("#collective_issue_date").val());
		var get_date = date.getDate();
		$('input:checkbox[name="company_check"]').each(function () {
			if (this.checked == true) {
				//발행주기,납부회차 넣어주기
				if(this.value.indexOf("purchase_tax_invoice") !== -1){//매입
					$("."+this.value).find("select[name=issue_cycle]").val($("#collective_issue_cycle").val())
					$("."+this.value).find("input[name=purchase_pay_session]").val(addrow_cnt);
				}else{ //매출
					$("#sales_issue_cycle").val($("#collective_issue_cycle").val());
					$("#sales_pay_session").val(addrow_cnt);
				}
				var change_date = new Date($("#collective_issue_date").val());
				if($("input[name=bill_insert_modify]:checked").val() == "생성"){
					if(this.value.indexOf("purchase_tax_invoice") !== -1){//매입
						var update_tr = $("."+this.value+"[class*='update']");
						var num = 0;
						for(var i=1; i <= update_tr.length; i++){
							if(update_tr.find("input[class*=purchase_issuance_status]").val()=="Y"){
								num++;
							}
						}
						if(num == 0){
							if($("."+this.value).find(".empty_row").length < 1){
								if(!confirm("해당 매입 세금계산서가 생성 되어 있습니다. 재생성 하시겠습니까?")){
									return true ;
								}else{
									$("."+this.value+":not(:first)").find("img").click();
									$("."+this.value).find("td").not(":first").not(":eq(0)").not(":eq(0)").remove();

									for(var i=0; i<3; i++){
										$("."+this.value+":first").find("td").eq(i).attr("rowspan",1)
									}
									// $("."+this.value+":first").append("<td class='empty_row' colspan=11>-등록된 계산서가 없습니다.</td>");
								}
							}
						}else{
							alert("발행된 세금계산서가 존재하여 세금계산서 생성이 불가능합니다.")
							return true;
						}
					}else{//매출
						var table = $("#"+ this.value).closest("table");
						var table_empty = $("#"+ this.value).closest("table").find(".empty_row");
						if(table_empty.length < 1){
							var update_tr = table.find("tr[class*='update']");
							var num =0;
							for(var i=1; i <= update_tr.length; i++){
								if(update_tr.find("input[name*=sales_issuance_status]").val() == "Y"){
									num++;
								}
							}
							if(num == 0){
								if(!confirm("매출 세금계산서가 생성 되어 있습니다. 재생성 하시겠습니까?")){
									return true ;
								}else{
									var tr = $("#"+ this.value).closest("table").find("tr");
									// tr.not(":first").not(":last").not(":eq(0)").remove();
									tr.not(":first").not(":last").not(":eq(0)").find("img").click();
									if(tr.eq(1).attr("id") != undefined){
										updateSeq(tr.eq(1).attr("id").replace("bill_",""));
										// tr.eq(1).attr("id","");
									}
									tr.eq(1).find("td").not(":first").not(":eq(0)").remove();
									for(var i=0; i<2; i++){
										tr.eq(1).find("td").eq(i).attr("rowspan",1)
									}
									// tr.eq(1).append("<td class='empty_row' colspan=11>-등록된 계산서가 없습니다.</td>");
								}
							}else{
								alert("발행된 세금계산서가 존재하여 세금계산서 생성이 불가능합니다.")
								return true;
							}
						}
					}
					////생성 부분 /////
					for(var i=0; i < addrow_cnt; i++){
						if($("#collective_issue_cycle").val()=="매월"){
							if(i != 0) {
								change_date = month_plus(change_date,1,get_date);
							}
							change_date = format_date(change_date);
						}else if($("#collective_issue_cycle").val()=="익월"){
							change_date = month_plus(change_date,1,get_date);
							// change_date = format_date(change_date);
						}else if($("#collective_issue_cycle").val()=="분기"){
							if( i == 0 ){
								change_date = month_plus(change_date,2,get_date);
							}else{
								change_date = month_plus(change_date,3,get_date);
							}
						}else if($("#collective_issue_cycle").val()=="분기익월"){
							if(i == 0){
								change_date = month_plus(change_date,3,get_date);
							}else{
								change_date = month_plus(change_date,3,get_date);
							}
							change_date = format_date(change_date);
						}else if ($("#collective_issue_cycle").val()=="반기"){
							if(i == 0){
								change_date = month_plus(change_date,5,get_date);
							}else{
								change_date = month_plus(change_date,6,get_date);
							}
						}else if ($("#collective_issue_cycle").val()=="연1회"){
							change_date= format_date(change_date)
						}else if ($("#collective_issue_cycle").val()=="지정일"){
							if(change_date){
								change_date = format_date(change_date);
							}else{
								change_date = "";
							}
						}
						var collective_info = change_date + "," + addrow_cnt;

						if(this.value.indexOf("purchase_tax_invoice") !== -1){//매입
							var num = this.value.replace("purchase_tax_invoice","");
							addRow(this.value,'purchase_contract_total_amount'+Number(num),1,collective_info);
						}else{//매출
							addRow(this.value,'sales_contract_total_amount',0,collective_info);
						}
					}
					if(this.value.indexOf("purchase_tax_invoice") !== -1){//매입
						var first_row = $("."+ this.value).closest("tr").find(".empty_row");
						$(first_row).remove();
					}else{//매출
						var first_row = $("#"+ this.value).closest("table").find(".empty_row");
						$(first_row).remove();
					}
				}else{ // 수정일때
					if(this.value.indexOf("purchase_tax_invoice") !== -1){//매입
						var first_row = $("."+ this.value).closest("tr").find(".empty_row");
						if(first_row.length > 0){
							alert("세금계산서 생성부터 진행해주세요");
							return true;
						}
					}else{//매출
						var first_row = $("#"+ this.value).closest("table").find(".empty_row");
						if(first_row.length > 0){
							alert("세금계산서 생성부터 진행해주세요");
							return true;
						}
					}
					for(var i=0; i<addrow_cnt; i++){
						if($("#collective_issue_cycle").val()=="매월"){
							if(i != 0) {
								change_date = month_plus(change_date,1,get_date);
							}
							change_date = format_date(change_date);
						}else if($("#collective_issue_cycle").val()=="익월"){
							change_date = month_plus(change_date,1,get_date);
							// change_date = format_date(change_date);
						}else if($("#collective_issue_cycle").val()=="분기"){
							if( i == 0 ){
								change_date = month_plus(change_date,2,get_date);
							}else{
								change_date = month_plus(change_date,3,get_date);
							}
						}else if($("#collective_issue_cycle").val()=="분기익월"){
							if(i == 0){
								change_date = month_plus(change_date,3,get_date);
							}else{
								change_date = month_plus(change_date,3,get_date);
							}
							change_date = format_date(change_date);
						}else if ($("#collective_issue_cycle").val()=="반기"){
							if(i == 0){
								change_date = month_plus(change_date,5,get_date);
							}else{
								change_date = month_plus(change_date,6,get_date);
							}
						}else if ($("#collective_issue_cycle").val()=="연1회"){
							change_date= format_date(change_date)
						}else if ($("#collective_issue_cycle").val()=="지정일"){
							if(change_date){
								change_date = format_date(change_date);
							}else{
								change_date = "";
							}
						}
						var collective_info = change_date + "," + addrow_cnt;

						var issuance=0;
						if(this.value.indexOf("purchase_tax_invoice") !== -1){
							for(var j=0; j<$("."+this.value).length; j++){
								if($("."+this.value).eq(j).find("input[name=purchase_issuance_status]").val() == "Y"){
									issuance++;
								}
							}

							if(issuance >= addrow_cnt){
								alert("발행 완료 된 회차가 발행주기 보다 커 직접 수정하셔야합니다.");
								return true;
							}else{
								if($("."+this.value).eq(i).length == 1){
									if($("."+this.value).eq(i).find("input[name=purchase_issuance_status]").val() == "N"){
										$("."+this.value).eq(i).find("input[name=issue_schedule_date]").val(change_date);
										$("."+this.value).eq(i).find("input[name=issue_schedule_date]").change();
									}
								}else{
									var num = this.value.replace("purchase_tax_invoice","");
									addRow(this.value,'purchase_contract_total_amount'+Number(num),1,collective_info);
								}
								var length = $("."+this.value).length;
								if(length > addrow_cnt){
									for(var f = addrow_cnt; f < length; f++){
										$("."+this.value).eq(addrow_cnt).find("img").click();
									}
								}
							}
						}else{
							var sales_tr = $("#"+this.value).closest("table").find("tr[class*=sales_bill]");
							for(var j=0; j<sales_tr.length; j++){
								if(sales_tr.eq(j).find("input[name=sales_issuance_status]").val() == "Y"){
									issuance++;
								}
							}

							if(issuance >= addrow_cnt){
								alert("발행 완료 된 회차가 발행주기 보다 커 직접 수정하셔야합니다.");
								return true;
							}else{
								if(sales_tr.eq(i).length == 1){
									if(sales_tr.eq(i).find("input[name=sales_issuance_status]").val() == "N"){
										sales_tr.eq(i).find("input[name=issue_schedule_date]").val(change_date);
										sales_tr.eq(i).find("input[name=issue_schedule_date]").change();
									}
								}else{
									addRow(this.value,'sales_contract_total_amount',0,collective_info);
								}

								if(sales_tr.length > addrow_cnt){
									for(var k=addrow_cnt; k<sales_tr.length; k++){
										sales_tr.eq(k).find("img").click();
									}
								}
							}
						}
					}
				}
			}
		});
	}

	//yyyy-mm-dd 변환
	function format_date(d){
		d = new Date(d);
		var year = d.getFullYear();
		var month = ("0" + (1 + d.getMonth())).slice(-2);
		var day = ("0" + d.getDate()).slice(-2);
    	return year + "-" + month + "-" + day;
	}

	//월 더하기~~~~~ (31일이 없는 경우엔 월의 마지막날로, 2월달의 경우엔 월의 마지막일로)
	function month_plus(change_date,interval,get_date){
		change_date= new Date(change_date);
		var old_month = change_date.getMonth();

		if(get_date == 31){
			change_date = new Date(change_date.getFullYear(), change_date.getMonth()+interval,1);
			change_date = new Date(change_date.getFullYear(),change_date.getMonth()+1, 0);
		}else{
			change_date = new Date(change_date.setMonth(change_date.getMonth() + interval));
		}

		var new_month = change_date.getMonth();
		if(old_month+interval >= 12){ //연도 넘어갔을때에에에ㅔ
			old_month =old_month+interval-12;
		}
		if(old_month+interval != new_month){ //2월같은 경우^-^
			if(old_month != new_month){
				change_date = new Date(change_date.getFullYear(), change_date.getMonth(),1);
				change_date =new Date(change_date.getFullYear(),change_date.getMonth(), 0);
			}
		}else if(get_date != 31){
			change_date = new Date(change_date.setDate(get_date));
		}
		change_date = format_date(change_date);
		return change_date;
	}

	//전체선택 체크박스 클릭
	$(function () {
	$("#sales_company_check_all").click(function () { //만약 전체 선택 체크박스가 체크된상태일경우
			if ($("#sales_company_check_all").prop("checked")) { //해당화면에 전체 checkbox들을 체크해준다
				$("#sales_statement_table input[name=company_check]").prop("checked", true);
			} else { //해당화면에 모든 checkbox들의 체크를해제시킨다.
				$("#sales_statement_table input[name=company_check]").prop("checked", false);
			}
		})
	})

	$(function () {
	$("#purchase_company_check_all").click(function () { //만약 전체 선택 체크박스가 체크된상태일경우
			if ($("#purchase_company_check_all").prop("checked")) { //해당화면에 전체 checkbox들을 체크해준다
				$("#purchase_statement_table input[name=company_check]").prop("checked", true);
			} else { //해당화면에 모든 checkbox들의 체크를해제시킨다.
				$("#purchase_statement_table input[name=company_check]").prop("checked", false);
			}
		})
	})

	//세액구하기
	function get_tax_amount(obj,type,row){
		var amount = $(obj).val().replace(/,/g, "");
		var tax = Math.round(amount*0.1);
		if(type == 0){//매입
			$("#sales_tax_amount"+row).val(tax);
			$("#sales_tax_amount"+row).change();
		}else{//매출
			var eq = $('.purchase_issuance_amount'+row).index(obj);
			$(".purchase_tax_amount" + row).eq(eq).val(tax);
			$(".purchase_tax_amount" + row).eq(eq).change();
		}
	}

	//합계구하기
	function get_total_amount(obj,type){
		var tr = $(obj).closest('tr');
		if(type == 0){ //매입
			var inssuance_amount = tr.find("input[name=sales_issuance_amount]").val().replace(/,/g, "");
			var tax_amount = tr.find("input[name=sales_tax_amount]").val().replace(/,/g, "");
			var total_amount = Number(inssuance_amount)+Number(tax_amount);
			tr.find("input[name=sales_total_amount]").val(total_amount);
			tr.find("input[name=sales_total_amount]").change();
		}else{ //매출
			var inssuance_amount = tr.find("input[name=purchase_issuance_amount]").val().replace(/,/g, "");
			var tax_amount = tr.find("input[name=purchase_tax_amount]").val().replace(/,/g, "");
			var total_amount = Number(inssuance_amount)+Number(tax_amount);
			tr.find("input[name=purchase_total_amount]").val(total_amount);
			tr.find("input[name=purchase_total_amount]").change();
		}
	}

	//총 합!
	function get_sum_amount(type,row){
		var issuance_amount = 0;
		var tax_amount = 0;
		var total_amount =  0;
		if(type == 0){ //매출
			for(var i=0; i<$("input[name=sales_issuance_amount]").length; i++){
				if($("input[name=sales_issuance_amount]").eq(i).is(":visible")){
					issuance_amount += Number($("input[name=sales_issuance_amount]").eq(i).val().replace(/,/g, ""));
					tax_amount += Number($("input[name=sales_tax_amount]").eq(i).val().replace(/,/g, ""));
					total_amount += Number($("input[name=sales_total_amount]").eq(i).val().replace(/,/g, ""));
				}
			}
			$("#sum_sales_issuance_amount").val(issuance_amount);
			$("#sum_sales_issuance_amount").change();
			$("#sum_sales_tax_amount").val(tax_amount);
			$("#sum_sales_tax_amount").change();
			$("#sum_sales_total_amount").val(total_amount);
			$("#sum_sales_total_amount").change();
		}else{ //매입
			for(var i=0; i<$(".purchase_issuance_amount"+row).length; i++){
				if($(".purchase_issuance_amount"+row).eq(i).is(":visible")){
					issuance_amount += Number($(".purchase_issuance_amount"+row).eq(i).val().replace(/,/g, ""));
					tax_amount += Number($(".purchase_tax_amount"+row).eq(i).val().replace(/,/g, ""));
					total_amount += Number($(".purchase_total_amount"+row).eq(i).val().replace(/,/g, ""));
				}
			}
			$("#sum_purchase_issuance_amount"+row).val(issuance_amount);
			$("#sum_purchase_issuance_amount"+row).change();
			$("#sum_purchase_tax_amount"+row).val(tax_amount);
			$("#sum_purchase_tax_amount"+row).change();
			$("#sum_purchase_total_amount"+row).val(total_amount);
			$("#sum_purchase_total_amount"+row).change();

			var t_issuance_amount = 0;
			var t_tax_amount = 0;
			var t_total_amount =  0;
			for(var i=0; i < $("input[name=sum_purchase_issuance_amount]").length; i++){
				t_issuance_amount += Number($("input[name=sum_purchase_issuance_amount]").eq(i).val().replace(/,/g, ""));
				t_tax_amount += Number($("input[name=sum_purchase_tax_amount]").eq(i).val().replace(/,/g, ""));
				t_total_amount += Number($("input[name=sum_purchase_total_amount]").eq(i).val().replace(/,/g, ""));
			}
			$("#t_sum_purchase_issuance_amount").val(t_issuance_amount);
			$("#t_sum_purchase_issuance_amount").change();
			$("#t_sum_purchase_tax_amount").val(t_tax_amount);
			$("#t_sum_purchase_tax_amount").change();
			$("#t_sum_purchase_total_amount").val(t_total_amount);
			$("#t_sum_purchase_total_amount").change();

		}
	}

	//발행취소
	function unIssue(){
		if($('input:checkbox[name="pay_checkbox"]:checked').length == 0){
			alert("발행취소할 세금계산서를 선택해주세요.");
			return false;
		}

		$('input:checkbox[name="pay_checkbox"]').each(function () {
			if (this.checked == true) {
				var tr= this.closest("tr");
				var table = tr.closest("table");
				var tr_id = $(tr).attr("id");
				var table_id = $(table).attr("id");
				var type = "sales";
				for(var i=0; i<2; i++){
					if(table_id == "sales_statement_table"){
						addRow(tr, 'sales_contract_total_amount', 0,'unIssue');
					}else{
						var n = $(tr).attr("class").split(" ")[0].replace("purchase_tax_invoice","");
						addRow(tr, 'purchase_contract_total_amount'+n, 1,'unIssue');
						type="purchase"
					}
				}
				var pay_session = $(tr).find("input[name=pay_session]").val();
				var issuance_amount =$(tr).find("input[name="+type+"_issuance_amount]").val();
				var tax_amount =$(tr).find("input[name="+type+"_tax_amount]").val();

				$(tr).find("input[name="+type+"_issuance_status]").val("C");
				$(tr).find("input[name="+type+"_issuance_status]").change();
				$(tr).find("span[name="+type+"_issuance_YN]").text("발행취소");
				$(tr).find("input[name=pay_session]").val(pay_session);
				$(tr).next().find("input[name="+type+"_issuance_status]").val("M");
				$(tr).next().find("span[name="+type+"_issuance_YN]").text("마이너스발행");
				$(tr).next().css("background-color","rgb(255, 227, 227)");
				$(tr).next().find("input[name=pay_session]").val(pay_session);

				$(tr).next().find("input[name="+type+"_issuance_amount]").val("-"+issuance_amount);
				if(tax_amount != ""){
					$(tr).next().find("input[name="+type+"_tax_amount]").val("-"+tax_amount);
					$(tr).next().find("input[name="+type+"_tax_amount]").change();
				}
				$(tr).next().next().find("input[name=pay_session]").val(pay_session);
			}
		});
	}

<?php if($_GET['type'] == '5'){ ?>
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
<?php } ?>

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
