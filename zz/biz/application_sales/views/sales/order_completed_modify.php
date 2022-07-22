<?php
include $this->input->server('DOCUMENT_ROOT') . "/include/base.php";
include $this->input->server('DOCUMENT_ROOT') . "/include/sales_top.php";
?>
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
<link rel="stylesheet" href="<?php echo $misc;?>css/view_page_common.css">
<style type="text/css">
.input-common {
	width: 98.5%;
}
.select-common {
	width: 99%;
}
.modify-tbl td {
	padding-left: 10px;
	padding-right: 10px;
}
</style>
<script src="<?php echo $misc;?>js/excel/excel-bootstrap-table-filter-bundle.js"></script>
<link rel="stylesheet" href="<?php echo $misc;?>js/excel/excel-bootstrap-table-filter-style.css" />
<script language="javascript">
var chkForm = function() {
    var mform = document.cform;
    var regex = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;


	// var objproduct_seq = document.getElementsByName("product_seq");
	// var objproduct_name = document.getElementsByName("product_name");


	// if (mform.exception_saledate.value == "") {
	// 	mform.exception_saledate.focus();
	// 	alert("예상매출일을 선택해 주세요.");
	// 	return false;

	// insert
	var insertObject = new Object();
	var insert_bill_total = [];
	if($(".insert_sales_bill").length > 0 || $(".insert_purchase_bill").length > 0){
		var i = 0;
		for (i = 0; i < $(".insert_sales_bill").length; i++) {
			if($(".insert_sales_bill").eq(i).find('input[name=pay_session]').length > 0){
				var type = "001";
				var company_name = "<?php echo $view_val['sales_companyname']; ?>";
				var pay_session = $(".insert_sales_bill").eq(i).find('input[name=pay_session]').val();
				var percentage = $(".insert_sales_bill").eq(i).find('input[name=sales_percentage]').val();
				var issuance_amount = $(".insert_sales_bill").eq(i).find('input[name=sales_issuance_amount]').val();
				var tax_amount = $(".insert_sales_bill").eq(i).find('input[name=sales_tax_amount]').val();
				var total_amount = $(".insert_sales_bill").eq(i).find('input[name=sales_total_amount]').val();

				var tax_approval_number = $(".insert_sales_bill").eq(i).find('input[name=sales_tax_approval_number]').val();
				var issuance_month = $(".insert_sales_bill").eq(i).find('input[name=sales_issuance_month]').val();
				var issuance_date = $(".insert_sales_bill").eq(i).find('input[name=sales_issuance_date]').val();
				var issuance_status = $(".insert_sales_bill").eq(i).find('input[name=sales_issuance_status]').val();
				var deposit_date = $(".insert_sales_bill").eq(i).find('input[name=sales_deposit_date]').val();
				var deposit_status = $(".insert_sales_bill").eq(i).find('input[name=sales_deposit_status]').val();
				insert_bill_total[i] = type+"||"+company_name+"||"+pay_session+"||"+percentage+"||"+issuance_amount+"||"+tax_amount+"||"+total_amount+"||"+tax_approval_number+"||"+issuance_month+"||"+issuance_date+"||"+issuance_status+"||"+deposit_date+"||"+deposit_status;
			}
		}

		for(j=0; j< $(".insert_purchase_bill").length; j++){
			if($(".insert_purchase_bill").eq(j).find('input[name=pay_session]').length > 0){
				var type = "002";
				// var company_name = Number(trim($(".insert_purchase_bill").eq(j).attr("class").replace("purchase_tax_invoice",'').replace('insert_purchase_bill','')))-1;
				// company_name = $('input[name=purchase_company_name]').eq(company_name).val();
				var company_name = $(".insert_purchase_bill").eq(j).find('input[name=purchase_company_name]').val();
				var pay_session = $(".insert_purchase_bill").eq(j).find('input[name=pay_session]').val();
				var percentage = $(".insert_purchase_bill").eq(j).find('input[name=purchase_percentage]').val();
				var issuance_amount = $(".insert_purchase_bill").eq(j).find('input[name=purchase_issuance_amount]').val();
				var tax_amount = $(".insert_purchase_bill").eq(j).find('input[name=purchase_tax_amount]').val();
				var total_amount = $(".insert_purchase_bill").eq(j).find('input[name=purchase_total_amount]').val();

				var tax_approval_number = $(".insert_purchase_bill").eq(j).find('input[name=purchase_tax_approval_number]').val();
				var issuance_month = $(".insert_purchase_bill").eq(j).find('input[name=purchase_issuance_month]').val();
				var issuance_date = $(".insert_purchase_bill").eq(j).find('input[name=purchase_issuance_date]').val();
				var issuance_status = $(".insert_purchase_bill").eq(j).find('input[name=purchase_issuance_status]').val();
				var deposit_date = $(".insert_purchase_bill").eq(j).find('input[name=purchase_deposit_date]').val();
				var deposit_status = $(".insert_purchase_bill").eq(j).find('input[name=purchase_deposit_status]').val();
				insert_bill_total[i] = type+"||"+company_name+"||"+pay_session+"||"+percentage+"||"+issuance_amount+"||"+tax_amount+"||"+total_amount+"||"+tax_approval_number+"||"+issuance_month+"||"+issuance_date+"||"+issuance_status+"||"+deposit_date+"||"+deposit_status;
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
		for (i = 0; i < update_seq.length; i++) {
			var seq = update_seq[i];
			if($("#bill_"+seq).length > 0){
				if($("#bill_"+seq).attr("class").indexOf("purchase") != -1 ){
					mode = "purchase";
				}else{
					mode = "sales";
				}
				var pay_session = $("#bill_"+seq).find('input[name=pay_session]').val();
				var percentage = $("#bill_"+seq).find('input[name='+mode+'_percentage]').val();
				var issuance_amount = $("#bill_"+seq).find('input[name='+mode+'_issuance_amount]').val();
				var tax_amount = $("#bill_"+seq).find('input[name='+mode+'_tax_amount]').val();
				var total_amount = $("#bill_"+seq).find('input[name='+mode+'_total_amount]').val();

				var tax_approval_number = $("#bill_"+seq).find('input[name='+mode+'_tax_approval_number]').val();
				var issuance_month = $("#bill_"+seq).find('input[name='+mode+'_issuance_month]').val();
				var issuance_date = $("#bill_"+seq).find('input[name='+mode+'_issuance_date]').val();
				var issuance_status = $("#bill_"+seq).find('input[name='+mode+'_issuance_status]').val();
				var deposit_date = $("#bill_"+seq).find('input[name='+mode+'_deposit_date]').val();
				var deposit_status = $("#bill_"+seq).find('input[name='+mode+'_deposit_status]').val();
				update_bill_total[i] = seq +"||"+pay_session+"||"+percentage+"||"+issuance_amount+"||"+tax_amount+"||"+total_amount+"||"+tax_approval_number+"||"+issuance_month+"||"+issuance_date+"||"+issuance_status+"||"+deposit_date+"||"+deposit_status;
				real_num++;
			}
		}
		updateObject.value = update_bill_total;
		update_bill_total = JSON.stringify(updateObject);

		$('#update_bill_array').val(update_bill_total);

	}

	//매출발행금액이 총매출금액과 같은지
	var sales_total_issuance_amount = 0;
	for(i=0; i<$('input[name=sales_issuance_status]').length; i++){
		if($('input[name=sales_issuance_status]').eq(i).val()== "Y"){
			sales_total_issuance_amount += Number($('input[name=sales_issuance_amount]').eq(i).val().replace(/,/g, ""));
		}
	}

	if(sales_total_issuance_amount == <?php echo $view_val['forcasting_sales']; ?>){
		$("#sales_total_issuance_amount").val(1);
	}

	var sales_total_deposit_amount = 0;
	for(i=0; i<$('input[name=sales_deposit_status]').length; i++){
		if($('input[name=sales_deposit_status]').eq(i).val() == "Y"){
			sales_total_deposit_amount += Number($('input[name=sales_issuance_amount]').eq(i).val().replace(/,/g, ""));
		}
	}

	if(sales_total_deposit_amount == <?php echo $view_val['forcasting_sales']; ?>){
		$("#sales_total_issuance_amount").val(2);
	}

	// 발행 완료시 예상매출일 업데이트
	var bill_progress = true;
	var exception_saledate = '';
	$('span[name=sales_issuance_YN]').each(function() {
		var result = $.trim($(this).text());
		if(result == '미완료') {
			bill_progress = false;
		}
		var tr = $(this).closest('tr');
		var issuance_date = tr.find('input[name=sales_issuance_date]').val();
		if(new Date(exception_saledate) < new Date(issuance_date) || exception_saledate == '') {
			exception_saledate = issuance_date;
		}
	})

	if(bill_progress) {
		$('#exception_saledate').val(exception_saledate);
	} else {
		$('#exception_saledate').val('');
	}
	// return false;
    mform.submit();
    return false;
}
</script>

<body>
<form name="cform" action="<?php echo site_url(); ?>/sales/forcasting/completed_modfiy_action" method="post" onSubmit="javascript:chkForm();return false;">
  <table width="90%" height="100%" cellspacing="0" cellpadding="0" style="margin: 0 auto;">
    <tr>
      <td width="100%" align="center" valign="top">
				<input type="hidden" id="forcasting_seq" name="forcasting_seq" value="<?php echo $_GET['seq']; ?>" />
				<input type="hidden" id="insert_bill_array" name="insert_bill_array" />
				<input type="hidden" id="update_bill_array" name="update_bill_array" />
				<input type="hidden" id="delete_bill_array" name="delete_bill_array" />
				<input type="hidden" id="sales_total_issuance_amount" name="sales_total_issuance_amount" value="0" />
				<input type="hidden" id="update_seq" name="update_seq" />
				<input type="hidden" id="exception_saledate" name="exception_saledate" value="">

      	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:50px;margin-bottom:50px;border-collapse:collapse;">
          <tr>
            <td colspan="11" class="dash_title">계산서 발행 정보</td>
          </tr>
					<!--버튼-->
					<tr>
						<td colspan="12" align="right">
							<input type="button" class="btn-common btn-color1" onclick="popup_close();" value="취소" style="margin-right:10px;"/>
							<input type="button" class="btn-common btn-color2" onclick="javascript:chkForm();return false;" value="수정" />
						</td>
					</tr>
					<!-- ki -->
					<tr>
						<td colspan=12 height="40" align="left" style="padding-top:30px;">
						* 금액 일괄 적용 <br>
							<table style="margin-top:5px;">
								<tr height="60">
									<td style="font-weight:bold;">발행금액</td>
									<td style="padding-left:5px;">
										<input type="text" class="input-common" id="collectiveApplication_cost" name="collectiveApplication_cost" value="" onchange="numberFormat(this);" style="text-align:right; padding:0 5px;">
									</td>
									<td style="padding-left:5px;">
										<input type="button" class="btn-common btn-style2" value="선택적용" onclick="collectiveApplication_bill();" style="margin-right:10px;margin-left:10px;width:80px;" />
										<input type="button" class="btn-common btn-style1" value="발행취소" onclick="unIssue();" style="width:80px;">
									</td>
								</tr>
							</table>
					</tr>
                    <!--시작라인-->
					<tr>
						<td colspan="12" >
							<img src="<?php echo $misc;?>/img/filter_refresh.png" onclick="filter_reset('sales_statement_table');" width=20 style="float:right;cursor:pointer;margin-bottom:5px;"/>
						</td>
					</tr>
          <tr class="tbl-tr cell-tr border-t">
            <td colspan="12" bgcolor="DEDEDE" style="text-align:center;font-weight:bold;">매출</td>
          </tr>
					<tr>
						<td colspan="12">
							<table id="sales_statement_table" class="modify-tbl" width="100%" border="0" cellspacing="0" cellpadding="0" onchange = "filter_reload('sales_statement_table',event)">
								<colgroup>
									<col width="8%" />
									<col width="2%" />
									<col width="3%" />
									<col width="6%" />
									<col width="3%" />
									<col width="8%" />
									<col width="8%" />
									<col width="8%" />
									<col width="16%" />
									<col width="5%" />
									<col width="10%" />
									<col width="5%" />
									<col width="10%" />
									<col width="5%" />
									<col width="3%" />
								</colgroup>
								<thead>
									<tr class="tbl-tr cell-tr row-color1">
										<th colspan="2" class="apply-filter no-sort" filter_column="1"><input type="hidden" class="filter_n" value="all">계약금액</th>
										<th class="apply-filter no-sort" filter_column="2"><input type="hidden" class="filter_n" value="all">회차</th>
										<th class="apply-filter no-sort" filter_column="3"><input type="hidden" class="filter_n" value="all">%</th>
										<th align="center"> <input type="checkbox" id="chk_all_1" name="chk_all_1" value=""> </th>
										<th class="apply-filter no-sort" filter_column="4"><input type="hidden" class="filter_n" value="all">발행금액</th>
										<th class="apply-filter no-sort" filter_column="5"><input type="hidden" class="filter_n" value="all">세액</th>
										<th class="apply-filter no-sort" filter_column="6"><input type="hidden" class="filter_n" value="all">합계</th>

										<th class="apply-filter no-sort" filter_column="7"><input type="hidden" class="filter_n" value="all">국세청 승인번호
										</th>
										<th class="apply-filter no-sort" filter_column="8"><input type="hidden" class="filter_n" value="all">발행월
										</th>
										<th class="apply-filter no-sort" filter_column="9"><input type="hidden" class="filter_n" value="all">발행일자
										</th>
										<th class="apply-filter no-sort" filter_column="10"><input type="hidden" class="filter_n" value="all">발행여부
										</th>
										<th class="apply-filter no-sort" filter_column="11"><input type="hidden" class="filter_n" value="all">입금일자
										</th>
										<th class="apply-filter no-sort" filter_column="12"><input type="hidden" class="filter_n" value="all">입금여부
										</th>
										<th align="center">
											<img src="<?php echo $misc; ?>img/btn_add.jpg" onclick="addRow('sales_issuance_amount_insert_line','sales_contract_total_amount',0);" />
										</th>
									</tr>
								</thead>
								<tbody>
								<?php if(empty($bill_val) || $sales_cnt == 0){?>
									<tr class="insert_sales_bill tbl-tr cell-tr">
										<td id="sales_contract_total_amount" rowspan="1" colspan="2" filter_column="1"
										align="center"><?php echo number_format($view_val['forcasting_sales']); ?></td>
										<input type="hidden" id="sales_issuance_status1" name="sales_issuance_status" class="input7" value="N" />
										<input type="hidden" id="sales_deposit_status1" name="sales_deposit_status" class="input7" value="N" />
										<td filter_column="2" align="center">
											<input type="text" id="pay_session1" name="pay_session" class="input-common" value="1" style="width:60%;" />
										</td>
										<td filter_column="3"  align="center">
											<input type="text" id="sales_percentage1" name="sales_percentage" class="input-common" value="100" style="width:60%;" onchange="calculation_amount(<?php echo $view_val['forcasting_sales']; ?>,this,1,0);" />
											%
										</td>
										<td align="center">
											<input type="checkbox" name="pay_checkbox" class="checkbox_1" value="">
										</td>
										<td filter_column="4" align="right">
											<input type="text" id="sales_issuance_amount1" name="sales_issuance_amount" class="input-common" style="text-align:right;" value="<?php echo number_format($view_val['forcasting_sales']); ?>" onchange="percentage(<?php echo $view_val['forcasting_sales']; ?>,this,1,0); numberFormat(this);get_tax_amount(this,0,1);" />
										</td>
										<td filter_column="5" align="right">
											<input type="text" id="sales_tax_amount1" name="sales_tax_amount" class="input-common" style="text-align:right;" value="<?php echo number_format($view_val['forcasting_sales'] * 0.1); ?>" onchange="numberFormat(this);get_total_amount(this,0);" />
										</td>
										<td filter_column="6" align="right">
											<input type="text" id="sales_total_amount1" name="sales_total_amount" class="input-common" style="text-align:right;" value="<?php echo number_format($view_val['forcasting_sales']+($view_val['forcasting_sales'] * 0.1)); ?>" onchange="numberFormat(this);get_sum_amount(0,1);" />
										</td>
										<td filter_column="7" align="center">
											<input type="text" id="sales_tax_approval_number1" name="sales_tax_approval_number" class="input-common" onchange="taxApprovalNumer(this,1,0);" />
										</td>
										<td filter_column="8" align="center">
											<input type="text" id="sales_issuance_month1"
												name="sales_issuance_month" class="input-common" style="text-align:center;" readonly />
											</td>
										<td filter_column="9" align="center">
											<input type="text" id="sales_issuance_date1"
												name="sales_issuance_date" class="input-common" onchange="issuance_date_change(this,1,0);" style="text-align:center;" readonly />
										</td>
										<td filter_column="10" align="center">
											<span id="sales_issuance_YN1" name="sales_issuance_YN">미완료</span>
										</td>
										<td filter_column="11" align="center">
											<input type="date" id="sales_deposit_date1"
												name="sales_deposit_date" class="input-common" onchange="deposit_date_change(this,1,0);" />
										</td>
										<td filter_column="12" align="center">
											<span id="sales_deposit_YN1">미완료</span>
										</td>
										<td height="40" align="center">
											<!-- <img src="<?php echo $misc; ?>img/btn_add.jpg" onclick="addRow('sales_issuance_amount_insert_line','sales_contract_total_amount',0);" /> -->
										</td>
									</tr>
								<?php
								}
								if($sales_cnt > 0){
									$row = 1;
									foreach($bill_val as $bill){
										if($bill['type'] == "001"){//매출
								?>
									<tr id="bill_<?php echo $bill['seq']; ?>" class="update_sales_bill tbl-tr cell-tr" <?php if($bill['issuance_status'] == "M"){echo "style='background-color:rgb(255, 227, 227);'";}?>>
						<?php if($row == 1){ ?>
										<td id="sales_contract_total_amount" rowspan="1" colspan="2" filter_column="1"  height="40" align="center"><?php echo number_format($view_val['forcasting_sales']); ?></td>
						<?php } ?>
										<input type="hidden" id="sales_issuance_status<?php echo $row; ?>" name="sales_issuance_status" class="input7" value="<?php echo $bill['issuance_status']; ?>" onchange="updateSeq(<?php echo $bill['seq']; ?>);" />
										<input type="hidden" id="sales_deposit_status<?php echo $row; ?>" name="sales_deposit_status" class="input7" value="<?php echo $bill['deposit_status']?>" />
						<?php if($bill['issuance_status'] == "Y" && ($id != "skkim" && $id !="yjjoo" && $id !="hbhwang" && $id !="selee") ){?>
										<td filter_column="2" align="center"><?php echo $bill['pay_session']; ?>
											<input type="hidden" id="pay_session<?php echo $row;?>" name="pay_session" class="input7" value="<?php echo $bill['pay_session']; ?>" style="width:60%;" />
										</td>
										<td filter_column="3" align="center"><?php echo $bill['percentage']; ?> %
											<input type="hidden" id="sales_percentage<?php echo $row;?>" name="sales_percentage" class="input7" value="<?php echo $bill['percentage']; ?>" style="width:60%;" />
										</td>
										<!-- ki -->
										<td align="center">
											<input type="checkbox" name="pay_checkbox" class="checkbox_1" value="">
										</td>
										<!-- ki -->
										<td filter_column="4" align="right"><?php echo number_format($bill['issuance_amount']); ?>
											<input type="hidden" id="sales_issuance_amount<?php echo $row; ?>" name="sales_issuance_amount" class="input7" style="text-align:right;" value="<?php echo number_format($bill['issuance_amount']); ?>"/>
										</td>
										<td filter_column="5" align="right"><?php echo number_format($bill['issuance_amount']); ?>
											<input type="hidden" id="sales_tax_amount<?php echo $row; ?>" name="sales_tax_amount" class="input7" style="text-align:right;" value="<?php echo number_format($bill['tax_amount']); ?>"/>
										</td>
										<td filter_column="6" align="right"><?php echo number_format($bill['issuance_amount']); ?>
											<input type="hidden" id="sales_total_amount<?php echo $row; ?>" name="sales_total_amount" class="input7" style="text-align:right;" value="<?php echo number_format($bill['total_amount']); ?>"/>
										</td>
										<td filter_column="7" align="center"><?php echo $bill['tax_approval_number']; ?>
											<input type="hidden" id="sales_tax_approval_number<?php echo $row; ?>" name="sales_tax_approval_number" class="input7" value="<?php echo $bill['tax_approval_number']; ?>" onchange="taxApprovalNumer(this,<?php echo $row; ?>,0);" />
										</td>
							<?php }else{?>
										<td filter_column="2" align="center">
											<input type="text" id="pay_session<?php echo $row;?>" name="pay_session" class="input-common" value="<?php echo $bill['pay_session']; ?>" style="width:60%;text-align:center;" onchange="updateSeq(<?php echo $bill['seq']; ?>);" />
										</td>
										<td filter_column="3" align="center">
											<input type="text" id="sales_percentage<?php echo $row;?>" name="sales_percentage" class="input-common" value="<?php echo $bill['percentage']; ?>" style="width:60%;" onchange="calculation_amount(<?php echo $view_val['forcasting_sales']; ?>,this,<?php echo $row; ?>,0);updateSeq(<?php echo $bill['seq']; ?>);" />
											%
										</td>
										<td align="center">
											<input type="checkbox" name="pay_checkbox" class="checkbox_1" value="" >
										</td>
										<td filter_column="4" align="right">
											<input type="text" id="sales_issuance_amount<?php echo $row; ?>" name="sales_issuance_amount" class="input-common" style="text-align:right;" value="<?php echo number_format($bill['issuance_amount']); ?>" onchange="percentage(<?php echo $view_val['forcasting_sales']; ?>,this,<?php echo $row; ?>,0); numberFormat(this);updateSeq(<?php echo $bill['seq']; ?>);get_tax_amount(this,0,<?php echo $row; ?>);" />
										</td>
										<td filter_column="5" align="right">
											<input type="text" id="sales_tax_amount<?php echo $row; ?>" name="sales_tax_amount" class="input-common" style="text-align:right;" value="<?php echo number_format($bill['tax_amount']); ?>" onchange="numberFormat(this);updateSeq(<?php echo $bill['seq']; ?>);get_total_amount(this,0);" />
										</td>
										<td filter_column="6" align="right">
											<input type="text" id="sales_total_amount<?php echo $row; ?>" name="sales_total_amount" class="input-common" style="text-align:right;" value="<?php echo number_format($bill['total_amount']); ?>" onchange="numberFormat(this);get_sum_amount(0,<?php echo $row; ?>);" />
										</td>
										<td filter_column="7" align="center">
											<input type="text" id="sales_tax_approval_number<?php echo $row; ?>" name="sales_tax_approval_number" class="input-common" value="<?php echo $bill['tax_approval_number']; ?>" onchange="taxApprovalNumer(this,<?php echo $row; ?>,0);updateSeq(<?php echo $bill['seq']; ?>);" />
										</td>
							<?php } ?>
										<td filter_column="8" align="center">
											<input type="text" id="sales_issuance_month<?php echo $row; ?>"	name="sales_issuance_month" class="input-common" style="text-align:center;" value="<?php echo $bill['issuance_month']; ?>" readonly />
										</td>
										<td filter_column="9" align="center">
											<input type="text" id="sales_issuance_date<?php echo $row; ?>" name="sales_issuance_date" class="input-common" value="<?php echo $bill['issuance_date']; ?>" onchange="issuance_date_change(this,<?php echo $row; ?>,0);updateSeq(<?php echo $bill['seq']; ?>);" style="text-align:center;" readonly />
										</td>
										<td filter_column="10" align="center">
											<span id="sales_issuance_YN<?php echo $row; ?>" name="sales_issuance_YN" class="select-common">
												<?php if($bill['issuance_status'] == "Y"){
													echo "완료";
												}else if ($bill['issuance_status'] == "N"){
													echo "미완료";
												}else if ($bill['issuance_status'] == "C"){
													echo "발행취소";
												}else if ($bill['issuance_status'] == "M"){
													echo "마이너스<br>발행";
												}
												?>
											</span>
										</td>
										<td height="40"  filter_column="11" align="center">
											<input type="date" id="sales_deposit_date<?php echo $row; ?>"	name="sales_deposit_date" class="input-common" value="<?php echo $bill['deposit_date']; ?>" onchange="deposit_date_change(this,<?php echo $row; ?>,0);updateSeq(<?php echo $bill['seq']; ?>);" />
										</td>
										<td filter_column="12" align="center">
											<span id="sales_deposit_YN<?php echo $row; ?>">
												<?php if($bill['deposit_status'] == "Y"){
													echo "완료";
												} else if($bill['deposit_status'] == "O"){
													echo "과잉";
												} else if($bill['deposit_status'] == "L"){
													echo "부족";
												}else{
													echo "미완료";
												} ?>
											</span>
										</td>
							<?php if($row == 1){ ?>
										<td  align="center"></td>
							<?php }else{?>
										<td align="center">
											<img src="<?php echo $misc; ?>img/btn_del0.jpg" onclick="deleteRow(this,'sales_contract_total_amount',0);deleteSeq(<?php echo $bill['seq']; ?>);" />
										</td>
							<?php }?>
									</tr>
										<?php
										$row++;
										echo "<script>";
										echo "$('#sales_contract_total_amount').attr('rowSpan', {$row});";
										echo "</script>";

										}
									}
								}
								?>
								<tr id="sales_issuance_amount_insert_line">
								</tr>
								<tr align="center" class="tbl-tr cell-tr" style="font-weight:bold;">
									<td colspan=2 >합계</td>
									<td></td>
									<td></td>
									<td></td>
									<td>
										<input id="sum_sales_issuance_amount" value="" class="input-common" onchange="numberFormat(this);" style="text-align:right;" readonly/>
									</td>
									<td>
										<input id="sum_sales_tax_amount" class="input-common" value="" onchange="numberFormat(this);" style="text-align:right;" readonly/>
									</td>
									<td>
										<input id="sum_sales_total_amount" class="input-common" value="" onchange="numberFormat(this);" style="text-align:right;" readonly/>
									</td>
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
					<tr >
						<td height="40"></td>
					</tr>
					<tr>
						<td colspan="12" >
							<img src="<?php echo $misc;?>/img/filter_refresh.png" onclick="filter_reset('purchase_statement_table');" width=20 style="float:right;cursor:pointer;margin-bottom:5px;"/>
						</td>
					</tr>
					<tr class="tbl-tr cell-tr border-t">
            <td colspan="12" bgcolor="DEDEDE" style="text-align:center;font-weight:bold;">매입</td>
					</tr>
					<tr>
						<td colspan="12">
							<table id="purchase_statement_table" class="modify-tbl" width="100%" border="0" cellspacing="0" cellpadding="0" onchange = "filter_reload('purchase_statement_table',event)">
								<colgroup>
									<col width="7%" />
									<col width="10%" />
									<col width="3%" />
									<col width="5%" />
									<col width="3%" />
									<col width="6%" />
									<col width="6%" />
									<col width="6%" />
									<col width="16%" />
									<col width="5%" />
									<col width="10%" />
									<col width="5%" />
									<col width="10%" />
									<col width="5%" />
									<col width="3%" />
								</colgroup>
								<thead>
									<tr class="tbl-tr cell-tr row-color1">
										<th class="apply-filter no-sort" filter_column="1" align="center"><input type="hidden" class="filter_n" value="all">업체
										</th>
										<th class="apply-filter no-sort" filter_column="2" align="center"><input type="hidden" class="filter_n" value="all">계약금액
										</th>
										<th class="apply-filter no-sort" filter_column="3" align="center"><input type="hidden" class="filter_n" value="all">회차</th>
										<th class="apply-filter no-sort" filter_column="3" align="center"><input type="hidden" class="filter_n" value="all">%</th>
										<th align="center">
											<input type="checkbox" id="chk_all_2" name="chk_all_2" value="">
										</th>
										<th class="apply-filter no-sort" filter_column="4" align="center"><input type="hidden" class="filter_n" value="all">발행금액</th>
										<th class="apply-filter no-sort" filter_column="5" align="center"><input type="hidden" class="filter_n" value="all">세액</th>
										<th class="apply-filter no-sort" filter_column="6" align="center"><input type="hidden" class="filter_n" value="all">합계</th>

										<th class="apply-filter no-sort" filter_column="7" align="center"><input type="hidden" class="filter_n" value="all">국세청 승인번호
										</th>
										<th class="apply-filter no-sort" filter_column="8" align="center"><input type="hidden" class="filter_n" value="all">발행월
										</th>
										<th class="apply-filter no-sort" filter_column="9" align="center"><input type="hidden" class="filter_n" value="all">발행일자
										</th>
										<th class="apply-filter no-sort" filter_column="10" align="center"><input type="hidden" class="filter_n" value="all">발행여부
										</th>
										<th class="apply-filter no-sort" filter_column="11" align="center"><input type="hidden" class="filter_n" value="all">입금일자
										</th>
										<th class="apply-filter no-sort" filter_column="12" align="center"><input type="hidden" class="filter_n" value="all">입금여부
										</th>
										<th align="center"></th>
									</tr>
								</thead>
								<tbody>
					<?php if(empty($bill_val) || $purchase_cnt == 0){?>
						<?php
						$num = 1;
						foreach ($view_val2 as $item2) {?>
						<tr class="purchase_tax_invoice<?php echo $num; ?> insert_purchase_bill tbl-tr cell-tr">
							<td height="40" filter_column="1" class="purchase_contract_total_amount<?php echo $num; ?> basic_td" align="center"><?php echo $item2['main_companyname']; ?></td>
							<input type="hidden" name="purchase_company_name" value="<?php echo $item2['main_companyname']; ?>" />
							<td id="purchase_contract_total_amount<?php echo $num; ?>" rowspan="1" filter_column="2" class="purchase_contract_total_amount<?php echo $num; ?> basic_td" height="40" align="center"><?php echo number_format(${"main_company_amount".$num}); ?></td>
							<td align="center" filter_column="3">
								<input type="text" class="pay_session<?php echo $num; ?> input-common" name="pay_session" value="1" style="width:60%;" />
							</td>
							<td align="center" filter_column="3">
								<input type="text" class="purchase_percentage<?php echo $num; ?> input-common" name="purchase_percentage" value="100" style="width:60%;" onchange="calculation_amount(<?php echo ${'main_company_amount'.$num}; ?>,this,<?php echo $num; ?>,1);" />%
							</td>
							<td align="center">
								<input type="checkbox" name="pay_checkbox" class="checkbox_2" value="" >
							</td>
							<td align="right" filter_column="4">
								<input type="text" class="purchase_issuance_amount<?php echo $num; ?> input-common" name="purchase_issuance_amount" style="text-align:right;" value="<?php echo number_format(${"main_company_amount".$num}); ?>" onchange="percentage(<?php echo ${'main_company_amount'.$num}; ?>,this,<?php echo $num;?>,1); numberFormat(this);get_tax_amount(this,1,<?php echo $num; ?>);" />
							</td>
							<td align="right" filter_column="5">
								<input type="text" class="purchase_tax_amount<?php echo $num; ?> input-common" name="purchase_tax_amount" style="text-align:right;" value="<?php echo number_format(${"main_company_amount".$num}*0.1); ?>" onchange="numberFormat(this);get_total_amount(this,1);" />
							</td>
							<td align="right" filter_column="6">
								<input type="text" class="purchase_total_amount<?php echo $num; ?> input-common" name="purchase_total_amount" style="text-align:right;" value="<?php echo number_format(${"main_company_amount".$num}+(${"main_company_amount".$num}*0.1)); ?>" onchange="numberFormat(this);get_sum_amount(1,<?php echo $num; ?>);" />
							</td>
							<td align="center" filter_column="7">
								<input type="text" name="purchase_tax_approval_number" class="purchase_tax_approval_number<?php echo $num; ?> input-common" onchange="taxApprovalNumer(this,<?php echo $num; ?>,1);" />
							</td>
							<td align="center" filter_column="8">
								<input type="text" class="purchase_issuance_month<?php echo $num; ?> input-common" name="purchase_issuance_month" style="text-align:center;" readonly />
							</td>
							<td align="center" filter_column="9"><input type="text"
									class="purchase_issuance_date<?php echo $num; ?> input-common" name="purchase_issuance_date"
									onchange="issuance_date_change(this,<?php echo $num; ?>,1);" style="text-align:center;" readonly /></td>
							<td align="center" filter_column="10">
								<input type="hidden" class="purchase_issuance_status<?php echo $num; ?> input-common" name="purchase_issuance_status" value="N" /><span class="purchase_issuance_YN<?php echo $num; ?>" name="purchase_issuance_YN">미완료</span></td>
							<td align="center" filter_column="11"><input type="date"
									class="purchase_deposit_date<?php echo $num; ?> input-common" name="purchase_deposit_date"
									onchange="deposit_date_change(this,<?php echo $num; ?>,1);" /></td>
							<td align="center" filter_column="12"><input type="hidden"
									class="purchase_deposit_status<?php echo $num; ?> input-common" name="purchase_deposit_status"
									value="N" /><span class="purchase_deposit_YN<?php echo $num; ?>">미완료</span></td>
							<td align="center"><img src="<?php echo $misc; ?>img/btn_add.jpg"
									onclick="addRow('purchase_tax_invoice<?php echo $num; ?>','purchase_contract_total_amount<?php echo $num; ?>',1);" />
							</td>
						</tr>
						<tr height="40"  align="center" style="font-weight:bold;">
							<td colspan=4 ><?php echo $item2['main_companyname']." "; ?>요약</td>
							<td></td>
							<td><input id="sum_purchase_issuance_amount<?php echo $num; ?>" name ="sum_purchase_issuance_amount" value="" class="input-common" onchange="numberFormat(this);" style="text-align:right;" /></td>
							<td><input id="sum_purchase_tax_amount<?php echo $num; ?>" name ="sum_purchase_tax_amount" class="input-common" value="" onchange="numberFormat(this);"style="text-align:right;" /></td>
							<td><input id="sum_purchase_total_amount<?php echo $num; ?>" name ="sum_purchase_total_amount" class="input-common" value="" onchange="numberFormat(this);" style="text-align:right;" /></td>
							<td ></td>
							<td ></td>
							<td ></td>
							<td ></td>
							<td ></td>
							<td ></td>
							<td ></td>
						</tr>
						<?php
						$num++;
						}?>
					<?php
					}
					if($purchase_cnt > 0){ ?>
					<?php
						$num = 1;
						foreach ($view_val2 as $item2) {
							$row2 = 1;
							foreach($bill_val as $bill){
								if($bill['type'] == "002"){//매입
								if($item2['main_companyname'] == $bill['company_name']){
					?>
									<tr id="bill_<?php echo $bill['seq']; ?>" class="purchase_tax_invoice<?php echo $num; ?> update_purchase_bill tbl-tr cell-tr" <?php if($bill['issuance_status'] == "M"){echo "style='background-color:rgb(255, 227, 227);'";}?>>
										<?php if($row2 == 1){ ?>
											<td filter_column="1" class="purchase_contract_total_amount<?php echo $num; ?>" align="center"><?php echo $bill['company_name']; ?></td>
											<td id="purchase_contract_total_amount<?php echo $num; ?>" filter_column="2" rowspan="1" class="purchase_contract_total_amount<?php echo $num; ?>" align="center">
												<?php echo number_format(${"main_company_amount".$num}); ?>
											</td>
										<?php } ?>
										<input type="hidden" name="purchase_company_name" value="<?php echo $bill['company_name']; ?>" />
										<input type="hidden" class="purchase_issuance_status<?php echo $num; ?> input7" name="purchase_issuance_status" value="<?php echo $bill['issuance_status']; ?>" onchange="updateSeq(<?php echo $bill['seq']; ?>);" />
										<input type="hidden" class="purchase_deposit_status<?php echo $num; ?> input7" name="purchase_deposit_status" value="<?php echo $bill['deposit_status']; ?>" />

										<?php if($bill['issuance_status'] == "Y" && ($id != "skkim" && $id !="yjjoo" && $id !="hbhwang" && $id !="selee")){?>
											<td filter_column="3"  align="center"><?php echo $bill['pay_session']; ?>
												<input type="hidden" class="pay_session<?php echo $num; ?> input7" name="pay_session" value="<?php echo $bill['pay_session']; ?>" style="width:60%;" />
											</td>
											<td filter_column="3"  align="center"><?php echo $bill['percentage']; ?> %
												<input type="hidden" class="purchase_percentage<?php echo $num; ?> input7" name="purchase_percentage" value="<?php echo $bill['percentage']; ?>" style="width:60%;" />
											</td>
											<td height="40"  align="center">
												<input type="checkbox" name="pay_checkbox" class="checkbox_2" value="">
											</td>
											<td height="40" filter_column="4"  align="right">
												<?php echo number_format($bill['issuance_amount']); ?>
												<input type="hidden" class="purchase_issuance_amount<?php echo $num; ?> input7" name="purchase_issuance_amount" style="text-align:right;" value="<?php echo number_format($bill['issuance_amount']); ?>" />
											</td>
											<td height="40" filter_column="5"  align="right">
												<?php echo number_format($bill['tax_amount']); ?>
												<input type="hidden" class="purchase_tax_amount<?php echo $num; ?> input7" name="purchase_tax_amount" style="text-align:right;" value="<?php echo number_format($bill['tax_amount']); ?>" />
											</td>
											<td height="40" filter_column="6"  align="right">
												<?php echo number_format($bill['total_amount']); ?>
												<input type="hidden" class="purchase_total_amount<?php echo $num; ?> input7" name="purchase_total_amount" style="text-align:right;" value="<?php echo number_format($bill['total_amount']); ?>" />
											</td>
											<td height="40" filter_column="7"  align="center"><?php echo $bill['tax_approval_number']; ?>
												<input type="hidden" name="purchase_tax_approval_number" class="purchase_tax_approval_number<?php echo $num; ?> input7" value="<?php echo $bill['tax_approval_number']; ?>" onchange="taxApprovalNumer(this,<?php echo $num; ?>,1);" />
											</td>
										<?php }else{ ?>
											<td height="40" filter_column="3"  align="center">
												<input type="text" class="pay_session<?php echo $num; ?> input-common" name="pay_session" value="<?php echo $bill['pay_session']; ?>" style="width:60%;" onchange="updateSeq(<?php echo $bill['seq']; ?>);" />
											</td>
											<td height="40" filter_column="3"  align="center">
												<input type="text" class="purchase_percentage<?php echo $num; ?> input-common" name="purchase_percentage" value="<?php echo $bill['percentage']; ?>" style="width:60%;" onchange="calculation_amount(<?php echo ${'main_company_amount'.$num}; ?>,this,<?php echo $num; ?>,1);updateSeq(<?php echo $bill['seq']; ?>);" />
												%
											</td>
											<td height="40"  align="center">
												<input type="checkbox" name="pay_checkbox" class="checkbox_2" value="">
											</td>
											<td height="40" filter_column="4"  align="right">
												<input type="text" class="purchase_issuance_amount<?php echo $num; ?> input-common" name="purchase_issuance_amount" style="text-align:right;" value="<?php echo number_format($bill['issuance_amount']); ?>" onchange="percentage(<?php echo ${'main_company_amount'.$num}; ?>,this,<?php echo $num;?>,1);numberFormat(this);updateSeq(<?php echo $bill['seq']; ?>);get_tax_amount(this,1,<?php echo $num; ?>);" />
											</td>
											<td height="40" filter_column="5"  align="right">
												<input type="text" class="purchase_tax_amount<?php echo $num; ?> input-common" name="purchase_tax_amount" style="text-align:right;" value="<?php echo number_format($bill['tax_amount']); ?>" onchange="numberFormat(this);updateSeq(<?php echo $bill['seq']; ?>);get_total_amount(this,1);" />
											</td>
											<td height="40" filter_column="6"  align="right">
												<input type="text" class="purchase_total_amount<?php echo $num; ?> input-common" name="purchase_total_amount" style="text-align:right;" value="<?php echo number_format($bill['total_amount']); ?>" onchange="numberFormat(this);get_sum_amount(1,<?php echo $num; ?>)" />
											</td>
											<td height="40" filter_column="7"  align="center">
												<input type="text" name="purchase_tax_approval_number" class="purchase_tax_approval_number<?php echo $num; ?> input-common" value="<?php echo $bill['tax_approval_number']; ?>" onchange="taxApprovalNumer(this,<?php echo $num; ?>,1);updateSeq(<?php echo $bill['seq']; ?>)" />
											</td>
										<?php }?>
										<td height="40" filter_column="8"  align="center"><input type="text"
												class="purchase_issuance_month<?php echo $num; ?> input-common" name="purchase_issuance_month" value="<?php echo $bill['issuance_month']; ?>"
												style="text-align:center;" readonly /></td>
										<td height="40" filter_column="9"  align="center"><input type="text"
												class="purchase_issuance_date<?php echo $num; ?> input-common" name="purchase_issuance_date" value="<?php echo $bill['issuance_date']; ?>"
												onchange="issuance_date_change(this,<?php echo $num; ?>,1);updateSeq(<?php echo $bill['seq']; ?>);" style="text-align:center;" readonly /></td>
										<td height="40" filter_column="10"  align="center">
											<span class="purchase_issuance_YN<?php echo $num; ?>" name="purchase_issuance_YN">
											<?php if($bill['issuance_status'] == "Y"){
												echo "완료";
											}else if ($bill['issuance_status'] == "N"){
												echo "미완료";
											}else if ($bill['issuance_status'] == "C"){
												echo "발행취소";
											}else if ($bill['issuance_status'] == "M"){
												echo "마이너스<br>발행";
											}
											?>
											</span>
										</td>
										<td height="40" filter_column="11"  align="center">
											<input type="date" class="purchase_deposit_date<?php echo $num; ?> input-common" name="purchase_deposit_date" value = "<?php echo $bill['deposit_date']; ?>" onchange="deposit_date_change(this,<?php echo $num; ?>,1);updateSeq(<?php echo $bill['seq']; ?>);" />
										</td>
										<td height="40" filter_column="12"  align="center">
											<span class="purchase_deposit_YN<?php echo $num; ?>">
											<?php if($bill['deposit_status'] == "Y"){
													echo "완료";
											} else if($bill['deposit_status'] == "O"){
												echo "과잉";
											} else if($bill['deposit_status'] == "L"){
												echo "부족";
											}else{
												echo "미완료";
											} ?>
										</span>
										</td>
										<td height="40"  align="center">
										<?php if($row2 == 1){ ?>
											<img src="<?php echo $misc; ?>img/btn_add.jpg" onclick="addRow('purchase_tax_invoice<?php echo $num; ?>','purchase_contract_total_amount<?php echo $num; ?>',1);" />
										<?php }else{?>
											<img src="<?php echo $misc; ?>img/btn_del0.jpg" onclick="deleteRow(this,'purchase_contract_total_amount<?php echo $num; ?>',1);deleteSeq(<?php echo $bill['seq']; ?>);" />
										<?php } ?>
										</td>
									</tr>
									<?php
									echo "<script>";
									echo "$('.purchase_contract_total_amount{$num}').attr('rowSpan', {$row2});";
									echo "</script>";
									$row2++;
								}
							}
						}?>
						<tr height="40" class="tbl-tr cell-tr" align="center" style="font-weight:bold;">
							<td colspan=4 ><?php echo $item2['main_companyname']." "; ?>요약</td>
							<td></td>
							<td><input id="sum_purchase_issuance_amount<?php echo $num; ?>" name ="sum_purchase_issuance_amount" value="" class="input-common" onchange="numberFormat(this);" style="text-align:right;" readonly/></td>
							<td><input id="sum_purchase_tax_amount<?php echo $num; ?>" name ="sum_purchase_tax_amount" class="input-common" value="" onchange="numberFormat(this);"style="text-align:right;" readonly/></td>
							<td><input id="sum_purchase_total_amount<?php echo $num; ?>" name ="sum_purchase_total_amount" class="input-common" value="" onchange="numberFormat(this);" style="text-align:right;" readonly/></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<?php $num++;
					}
				}
					?>
					<tr height="40" class="tbl-tr cell-tr" align="center" style="font-weight:bold;">
						<td colspan=4 >매입 총 합계</td>
						<td ></td>
						<td ><input id="t_sum_purchase_issuance_amount" name ="t_sum_purchase_issuance_amount" value="" class="input-common" onchange="numberFormat(this);" style="text-align:right;" readonly/></td>
						<td ><input id="t_sum_purchase_tax_amount" name ="t_sum_purchase_tax_amount" class="input-common" value="" onchange="numberFormat(this);"style="text-align:right;" readonly/></td>
						<td ><input id="t_sum_purchase_total_amount" name ="t_sum_purchase_total_amount" class="input-common" value="" onchange="numberFormat(this);" style="text-align:right;" readonly/></td>
						<td ></td>
						<td ></td>
						<td ></td>
						<td ></td>
						<td ></td>
						<td ></td>
						<td ></td>
					</tr>
					</tbody>
							</table>
						</td>
					</tr>
                </table>
            </td>
        </tr>
        <!--버튼-->
        <tr>
          <td align="right">
						<input type="button" class="btn-common btn-color1" onclick="popup_close();" value="취소" style="margin-right:10px;"/>
						<input type="button" class="btn-common btn-color2" onclick="javascript:chkForm();return false;" value="수정" />
					</td>
		</tr>
	</table>
</form>
<script>
//매입&매출 총합
get_sum_amount(0);
for(var i=0; i<$("input[name=sum_purchase_issuance_amount]").length; i++){
	get_sum_amount(1,i+1);
}
//계싼서 추가
function addRow(insertLine, rowspanid, type, collective) {
	if (type == 0) {
		//나머지 금액구하기
		var total_amount = Number($("#sales_contract_total_amount").text().replace(/\,/g, ''));
		var remain_amount = total_amount;
		var row_num = $("input[name=sales_issuance_amount]").length + 1;
		for (i = 0; i < $("input[name=sales_issuance_amount]").length; i++) {
			remain_amount -= Number($("input[name=sales_issuance_amount]").eq(i).val().replace(/\,/g, ''));
		}

		if (remain_amount == 0 && collective != "unIssue") {
			alert("총 발행 금액이 계약 금액과 일치합니다.")
			return false;
		}

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

		var html = '<tr class="insert_sales_bill tbl-tr cell-tr"><input type="hidden" id="sales_deposit_status' + row_num + '" name="sales_deposit_status" class="input7" value="N" /><input type="hidden" id="sales_issuance_status' + row_num + '" name="sales_issuance_status" class="input7" value="N" />';
		html += '<td height="40"  align="center" filter_column="2"><input type="text" id="pay_session'+row_num +'" name="pay_session" class="input-common" value="'+pay_session+'" style="width:60%;text-align:center;" /></td>';
		html+='<td height="40" filter_column="2"  align="center"><input type="text" id="sales_percentage' + row_num + '" name="sales_percentage" class="input-common" style="width:60%" value="" onchange="calculation_amount(' + total_amount + ',this,' + row_num + ',0)" /> %</td>';
    	html += '<td height="40"  align="center"><input type="checkbox" name="pay_checkbox" class="checkbox_1" value=""></td>';
		html += '<td height="40" filter_column="3"  align="right"><input type="text" id="sales_issuance_amount' + row_num + '" name="sales_issuance_amount" class="input-common" style="text-align:right;" value="' + remain_amount + '" onchange="percentage(' + total_amount + ',this,' + row_num + ',0); numberFormat(this);get_tax_amount(this,0,'+row_num+')" /></td>';
		html += '<td height="40" filter_column="4"  align="right"><input type="text" id="sales_tax_amount' + row_num + '" name="sales_tax_amount" class="input-common" style="text-align:right;" value="" onchange="numberFormat(this);get_total_amount(this,0);" /></td>';
		html += '<td height="40" filter_column="5"  align="right"><input type="text" id="sales_total_amount' + row_num + '" name="sales_total_amount" class="input-common" style="text-align:right;" value="" onchange="numberFormat(this);get_sum_amount(0,'+row_num+')" /></td>';
		html += '<td height="40" filter_column="6"  align="center"><input type="text" id="sales_tax_approval_number'+row_num+'" name="sales_tax_approval_number" class="input-common" onchange="taxApprovalNumer(this,'+row_num+',0);" /></td>';
		html += '<td height="40" filter_column="7"  align="center"><input type="text" id="sales_issuance_month' +
			row_num + '" name="sales_issuance_month" class="input-common" style="text-align:center;" readonly/></td>';
		html += '<td height="40" filter_column="8"  align="center"><input type="text" id="sales_issuance_date' +
			row_num + '" name="sales_issuance_date" class="input-common" onchange="issuance_date_change(this,' + row_num +
			',0);" style="text-align:center;" readonly /></td>';
		html += '<td height="40" filter_column="9"  align="center"><span id="sales_issuance_YN' +
			row_num + '" name="sales_issuance_YN">미완료</span></td>';
		html += '<td height="40" filter_column="10"  align="center"><input type="date" id="sales_deposit_date' +
			row_num + '" name="sales_deposit_date" class="input-common" onchange="deposit_date_change(this,' + row_num +
			',0);"/></td>';
		html += '<td height="40" filter_column="11"  align="center"><span id="sales_deposit_YN' + row_num + '">미완료</span></td>';
		html +=
			'<td height="40"  align="center"><img src="<?php echo $misc; ?>img/btn_del0.jpg" onclick="deleteRow(this,' +
			"'sales_contract_total_amount'" + ',0);"/></td></tr>';


		var rowspan = Number($("#" + rowspanid).attr("rowspan"));
		$("#" + rowspanid).attr("rowSpan", rowspan + 1);
		if(collective == "unIssue"){//발행취소일때
			$(insertLine).after(html);
		}else{
			$("#" + insertLine).before(html);
		}
		$("#sales_issuance_amount" + row_num).trigger('change');
		filter_reload('sales_statement_table');
	} else {
		//나머지 금액구하기
		if(collective == "unIssue"){
			var row_num = $(insertLine).attr("class").split(" ")[0].replace('purchase_tax_invoice', ''); // 이거는 발행취소 add
		}else{
			var row_num = insertLine.replace('purchase_tax_invoice', '');
		}

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
		var eq = $(".purchase_issuance_amount" + row_num).length;
		for (i = 0; i < $(".purchase_issuance_amount" + row_num).length; i++) {
			remain_amount -= Number($(".purchase_issuance_amount" + row_num).eq(i).val().replace(/\,/g, ''));
		}

		if (remain_amount == 0 && collective != "unIssue") {
			alert("총 발행 금액이 계약 금액과 일치합니다.")
			return false;
		}
        // var company_name = $(".purchase_tax_invoice"+(session_num-1) +" input[name=purchase_company_name]").val();
		var purchase_company_name = $("."+rowspanid).eq(0).text().trim();
		var html = '<tr class="purchase_tax_invoice' + row_num +' insert_purchase_bill tbl-tr cell-tr">';
		html +=' <input type="hidden" name="purchase_company_name" value="'+purchase_company_name+'" />';
		html +=' <input type="hidden" class="purchase_issuance_status' + row_num + ' input7" name="purchase_issuance_status" value="N" /><input type="hidden" class="purchase_deposit_status' + row_num + ' input7" name="purchase_deposit_status" value="N" />';
		html += '<td height="40"  align="center" filter_column="3"><input type="text" id="pay_session'+row_num +'" name="pay_session" class="input-common" value="'+session_num+'" style="width:60%;text-align:center;" /></td>';
		html +='<td height="40" filter_column="3"  align="center"><input type="text" class="purchase_percentage' + row_num + ' input-common" name="purchase_percentage" style="width:60%" value="" onchange="calculation_amount(' + total_amount + ',this,' + row_num + ',1)" /> %</td>';
    	html += '<td height="40"  align="center"><input type="checkbox" name="pay_checkbox" class="checkbox_2" value=""></td>';
		html += '<td height="40" filter_column="4"  align="right"><input type="text" class="purchase_issuance_amount' + row_num + ' input-common" name="purchase_issuance_amount" style="text-align:right;" value="' + remain_amount + '" onchange="percentage(' + total_amount + ',this,' + row_num + ',1); numberFormat(this);get_tax_amount(this,1,'+row_num+');" /></td>';
		html += '<td height="40" filter_column="5"  align="right"><input type="text" class="purchase_tax_amount' + row_num + ' input-common" name="purchase_tax_amount" style="text-align:right;" value="" onchange="numberFormat(this);get_total_amount(this,1);" /></td>';
		html += '<td height="40" filter_column="6"  align="right"><input type="text" class="purchase_total_amount' + row_num + ' input-common" name="purchase_total_amount" style="text-align:right;" value="" onchange="numberFormat(this);get_sum_amount(1,'+row_num+')" /></td>';

		html += '<td height="40" filter_column="7"  align="center"><input type="text" name="purchase_tax_approval_number" class="purchase_tax_approval_number'+row_num+' input-common" onchange="taxApprovalNumer(this,'+row_num+',1);" /></td>';
		html +=
			'<td height="40" filter_column="8"  align="center"><input type="text" class="purchase_issuance_month' +
			row_num + ' input-common" name="purchase_issuance_month" style="text-align:center;" readonly/></td>';
		html += '<td height="40" filter_column="9"  align="center"><input type="text" class="purchase_issuance_date' +
			row_num + ' input-common" name="purchase_issuance_date" onchange="issuance_date_change(this,' + row_num +
			',1);" style="text-align:center;" readonly /></td>';
		html +=
			'<td height="40" filter_column="10"  align="center"><span class="purchase_issuance_YN' +
			row_num + '" name="purchase_issuance_YN">미완료</span></td>';
		html += '<td height="40" filter_column="11"  align="center"><input type="date" class="purchase_deposit_date' +
			row_num + ' input-common" name="purchase_deposit_date" onchange="deposit_date_change(this,' + row_num +
			',1);"/></td>';
		html +=
			'<td height="40" filter_column="12"  align="center"><span class="purchase_deposit_YN' +
			row_num + '">미완료</span></td>';
		html +=
			'<td height="40"  align="center"><img src="<?php echo $misc; ?>img/btn_del0.jpg" onclick="deleteRow(this,' +
			"'purchase_contract_total_amount" + row_num + "'" + ',1);"/></td></tr>';


		var rowspan = Number($("#" + rowspanid).attr("rowspan"));

		if(collective == "unIssue"){
			$(insertLine).after(html);
		}else{
			$("." + insertLine).eq($("." + insertLine).length - 1).after(html);
		}
		$("." + rowspanid).attr("rowSpan", rowspan + 1);
		$(".purchase_issuance_amount" + row_num).eq(eq).trigger('change');
		filter_reload('purchase_statement_table');
	}
}
//delete row
// function deleteRow(obj, rowspanid, type) {
// 	if (type == 0) {
// 		var tr = $(obj).parent().parent();
// 		tr.remove();
// 		var rowspan = Number($("#" + rowspanid).attr("rowspan"));
// 		$("#" + rowspanid).attr("rowSpan", rowspan - 1);
// 		get_sum_amount(0);
// 	} else {
// 		var tr = $(obj).parent().parent();
// 		tr.remove();
// 		var rowspan = Number($("#" + rowspanid).attr("rowspan"));
// 		$("." + rowspanid).attr("rowSpan", rowspan - 1);
// 		for(var i=0; i<$("input[name=sum_purchase_issuance_amount]").length; i++){
// 			get_sum_amount(1,i+1);
// 		}
// 	}
// }
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

//금액으로 퍼센트 구하기
function percentage(total_amount, obj, num, type) {
	if (type == 0) {
		var val = $(obj).val().replace(/\,/g, '');
		$("#sales_percentage" + num).val(val / total_amount * 100);
	} else {
		var className = trim($(obj).attr('class').replace('input-common', ''));
		var eq = $('.' + className).index(obj);
		var val = $(obj).val().replace(/\,/g, '');
		$(".purchase_percentage" + num).eq(eq).val(val / total_amount * 100);
	}
}

//퍼센트로 금액 구하기
function calculation_amount(total_amount, obj, num, type) {
	if (type == 0) {
		var val = total_amount * Number($(obj).val()) / 100;
		val = String(val).replace(/(\d)(?=(?:\d{3})+(?!\d))/g, "$1,");
		$("#sales_issuance_amount" + num).val(val);
		$("#sales_issuance_amount" + num).change();
	} else {
		var className = trim($(obj).attr('class').replace('input-common', ''));
		var eq = $('.' + className).index(obj);
		var val = total_amount * Number($(obj).val()) / 100;
		val = String(val).replace(/(\d)(?=(?:\d{3})+(?!\d))/g, "$1,");
		$(".purchase_issuance_amount" + num).eq(eq).val(val);
		$(".purchase_issuance_amount" + num).eq(eq).change();
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

//발행일자 change
function issuance_date_change(obj, num, type) {
	if (type == 0) {
		var val = $(obj).val();
		val = val.substring(0, val.length - 3);
		$('#sales_issuance_month' + num).val(val);
		if($("#sales_issuance_status" + num).val() != "C" && $("#sales_issuance_status" + num).val() != "M" ){
			$("#sales_issuance_status" + num).val("Y");
			$("#sales_issuance_YN" + num).text("완료");
		}
	} else {
		var className = trim($(obj).attr('class').replace('input-common', ''));
		var eq = $('.' + className).index(obj);
		var val = $(obj).val();
		val = val.substring(0, val.length - 3);

		$('.purchase_issuance_month' + num).eq(eq).val(val);
		if($(".purchase_issuance_status" + num).eq(eq).val() != "C" && $(".purchase_issuance_status" + num).eq(eq).val() != "M" ){
			$(".purchase_issuance_status" + num).eq(eq).val("Y");
			$(".purchase_issuance_YN" + num).eq(eq).text("완료");
		}
	}
}

//입금일자 change
function deposit_date_change(obj, num, type) {
	if (type == 0) {
		$("#sales_deposit_status" + num).val("Y");
		$("#sales_deposit_YN" + num).text("완료");
	} else {
		var className = trim($(obj).attr('class').replace('input-common', ''));
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
//국세청 승인번호
function taxApprovalNumer(obj, num, type){
	$(obj).val($(obj).val().replace(/ /gi, "")); //공백제거
	if($(obj).val().length > 26 || $(obj).val().length < 26){
		alert("국세청 승인번호는 26자리로 입력하셔야합니다.");
		$(obj).val("");
		if(type == 0){
			$("#sales_issuance_date"+num).val("");
			$("#sales_issuance_month"+num).val("");
			$("#sales_issuance_status"+num).val("N");
			$("#sales_issuance_YN"+num).text("미완료");
		}else{
			var className = trim($(obj).attr('class').replace('input-common', ''));
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
		var className = trim($(obj).attr('class').replace('input-common', ''));
		var eq = $('.' + className).index(obj);
		$(".purchase_issuance_date"+num).eq(eq).val(date);
		$(".purchase_issuance_date"+num).eq(eq).change();
		if($(obj).val() == ""){//국세청 승인번호 빈칸일때
			$(".purchase_issuance_status"+num).val("N");
			$(".purchase_issuance_YN"+num).text("미완료");
		}
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
    if(chk_class === 'update_sales_bill' || chk_class === 'insert_sales_bill'){
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
    // $(".checkbox_1").prop("checked", true); //해당화면에 전체 checkbox들을 체크해준다
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
				var tax_amount = $(tr).find("input[name="+type+"_tax_amount]").val();
				$(tr).find("input[name="+type+"_issuance_status]").val("C");
				$(tr).find("input[name="+type+"_issuance_status]").change();
				$(tr).find("span[name="+type+"_issuance_YN]").text("발행취소");
				$(tr).find("input[name=pay_session]").val(pay_session);
				$(tr).next().find("input[name="+type+"_issuance_status]").val("M");
				$(tr).next().find("span[name="+type+"_issuance_YN]").text("마이너스발행");
				$(tr).next().css("background-color","rgb(255, 227, 227)");
				$(tr).next().find("input[name=pay_session]").val(pay_session);


				$(tr).next().find("input[name="+type+"_issuance_amount]").val("-"+issuance_amount);
				$(tr).next().find("input[name="+type+"_issuance_amount]").change();
				if(tax_amount != ""){
					$(tr).next().find("input[name="+type+"_tax_amount]").val("-"+tax_amount);
					$(tr).next().find("input[name="+type+"_tax_amount]").change();
				}
				$(tr).next().next().find("input[name=pay_session]").val(pay_session);
			}
		});
	}
</script>
</body>

</html>
