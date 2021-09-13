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
<style type="text/css">
.basic_td {
    border: 1px solid;
    border-color: #d7d7d7;
    padding: 0px 10px 0px 10px;
}

.basic_table {
    border-collapse: collapse;
    border: 1px solid;
    border-color: #d7d7d7;
}
</style>
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
	// }


	// insert
	var insertObject = new Object();
	var insert_bill_total = [];
	if($(".insert_sales_bill").length > 0 || $(".insert_purchase_bill").length > 0){
		var i = 0;
		for (i = 0; i < $(".insert_sales_bill").length; i++) {
			var type = "001";
			var company_name = "<?php echo $view_val['sales_companyname']; ?>";
			var percentage = $(".insert_sales_bill").eq(i).find('input[name=sales_percentage]').val();
			var issuance_amount = $(".insert_sales_bill").eq(i).find('input[name=sales_issuance_amount]').val();
			var tax_approval_number = $(".insert_sales_bill").eq(i).find('input[name=sales_tax_approval_number]').val();
			var issuance_month = $(".insert_sales_bill").eq(i).find('input[name=sales_issuance_month]').val();
			var issuance_date = $(".insert_sales_bill").eq(i).find('input[name=sales_issuance_date]').val();
			var issuance_status = $(".insert_sales_bill").eq(i).find('input[name=sales_issuance_status]').val();
			var deposit_date = $(".insert_sales_bill").eq(i).find('input[name=sales_deposit_date]').val();
			var deposit_status = $(".insert_sales_bill").eq(i).find('input[name=sales_deposit_status]').val();
			insert_bill_total[i] = type+"||"+company_name+"||"+percentage+"||"+issuance_amount+"||"+tax_approval_number+"||"+issuance_month+"||"+issuance_date+"||"+issuance_status+"||"+deposit_date+"||"+deposit_status;
		}

		for(j=0; j< $(".insert_purchase_bill").length; j++){
			var type = "002";
			var company_name = Number(trim($(".insert_purchase_bill").eq(j).attr("class").replace("purchase_tax_invoice",'').replace('insert_purchase_bill','')))-1;
			company_name = $('input[name=purchase_company_name]').eq(company_name).val();
			var percentage = $(".insert_purchase_bill").eq(j).find('input[name=purchase_percentage]').val();
			var issuance_amount = $(".insert_purchase_bill").eq(j).find('input[name=purchase_issuance_amount]').val();
			var tax_approval_number = $(".insert_purchase_bill").eq(j).find('input[name=purchase_tax_approval_number]').val();
			var issuance_month = $(".insert_purchase_bill").eq(j).find('input[name=purchase_issuance_month]').val();
			var issuance_date = $(".insert_purchase_bill").eq(j).find('input[name=purchase_issuance_date]').val();
			var issuance_status = $(".insert_purchase_bill").eq(j).find('input[name=purchase_issuance_status]').val();
			var deposit_date = $(".insert_purchase_bill").eq(j).find('input[name=purchase_deposit_date]').val();
			var deposit_status = $(".insert_purchase_bill").eq(j).find('input[name=purchase_deposit_status]').val();
			insert_bill_total[i] = type+"||"+company_name+"||"+percentage+"||"+issuance_amount+"||"+tax_approval_number+"||"+issuance_month+"||"+issuance_date+"||"+issuance_status+"||"+deposit_date+"||"+deposit_status;
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
		for (i = 0; i < update_seq.length; i++) {
			var seq = update_seq[i];
			if($("#bill_"+seq).attr("class").indexOf("purchase") != -1 ){
				mode = "purchase";
			}else{
				mode = "sales";
			}
			var percentage = $("#bill_"+seq).find('input[name='+mode+'_percentage]').val();
			var issuance_amount = $("#bill_"+seq).find('input[name='+mode+'_issuance_amount]').val();
			var tax_approval_number = $("#bill_"+seq).find('input[name='+mode+'_tax_approval_number]').val();
			var issuance_month = $("#bill_"+seq).find('input[name='+mode+'_issuance_month]').val();
			var issuance_date = $("#bill_"+seq).find('input[name='+mode+'_issuance_date]').val();
			var issuance_status = $("#bill_"+seq).find('input[name='+mode+'_issuance_status]').val();
			var deposit_date = $("#bill_"+seq).find('input[name='+mode+'_deposit_date]').val();
			var deposit_status = $("#bill_"+seq).find('input[name='+mode+'_deposit_status]').val();
			update_bill_total[i] = seq +"||"+percentage+"||"+issuance_amount+"||"+tax_approval_number+"||"+issuance_month+"||"+issuance_date+"||"+issuance_status+"||"+deposit_date+"||"+deposit_status;
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

    mform.submit();
    return false;
}
</script>

<body>
<form name="cform" action="<?php echo site_url(); ?>/forcasting/completed_modfiy_action" method="post" onSubmit="javascript:chkForm();return false;">
    <table width="90%" height="100%" cellspacing="0" cellpadding="0" style="margin-left:30px;">
        <tr>
            <td width="100%" align="center" valign="top">
				<input type="hidden" id="forcasting_seq" name="forcasting_seq" value="<?php echo $_GET['seq']; ?>" />
				<input type="hidden" id="insert_bill_array" name="insert_bill_array" />
				<input type="hidden" id="update_bill_array" name="update_bill_array" />
				<input type="hidden" id="delete_bill_array" name="delete_bill_array" />
				<input type="hidden" id="sales_total_issuance_amount" name="sales_total_issuance_amount" value="0" />
				<input type="hidden" id="update_seq" name="update_seq" />
				
                <table width="100%" border="0" style="margin-top:50px;margin-bottom:50px;border-collapse:collapse;">
                    <tr>
                        <td colspan="11" class="title3">계산서 발행 정보</td>
                    </tr>
                    <!--//타이틀-->
                    <tr>
                        <td>&nbsp;</td>
                    </tr>

                    <!--시작라인-->
                    <tr>
                        <td colspan="11" height="2" bgcolor="#797c88"></td>
                    </tr>
                    <tr>
                        <td colspan="11" class="basic_td" height="40" align="center" bgcolor="f8f8f9"
                            style="font-weight:bold;">매출</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="basic_td" height="40" align="center" bgcolor="f8f8f9"
                            style="font-weight:bold;">계약금액</td>
                        <td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">%
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
					<?php if(empty($bill_val) || $sales_cnt == 0){?>
						<tr class="insert_sales_bill">
							<td id="sales_contract_total_amount" rowspan="1" colspan="2" class="basic_td" height="40"
								align="center"><?php echo number_format($view_val['forcasting_sales']); ?></td>
							<td height="40" class="basic_td" align="center"><input type="text" id="sales_percentage1"
									name="sales_percentage" class="input7" value="100" style="width:60%;"
									onchange="calculation_amount(<?php echo $view_val['forcasting_sales']; ?>,this,1,0);" />
								%</td>
							<td height="40" class="basic_td" align="right"><input type="text" id="sales_issuance_amount1"
									name="sales_issuance_amount" class="input7" style="text-align:right;"
									value="<?php echo number_format($view_val['forcasting_sales']); ?>"
									onchange="percentage(<?php echo $view_val['forcasting_sales']; ?>,this,1,0); numberFormat(this);" />
							</td>
							<td height="40" class="basic_td" align="center">
								<input type="text" id="sales_tax_approval_number1" name="sales_tax_approval_number" class="input7" onchange="taxApprovalNumer(this,1,0);" />
							</td>
							<td height="40" class="basic_td" align="center"><input type="text" id="sales_issuance_month1"
									name="sales_issuance_month" class="input7" style="text-align:center;" readonly /></td>
							<td height="40" class="basic_td" align="center"><input type="text" id="sales_issuance_date1"
									name="sales_issuance_date" class="input7" onchange="issuance_date_change(this,1,0);" style="text-align:center;" readonly />
							</td>
							<td height="40" class="basic_td" align="center"><input type="hidden" id="sales_issuance_status1"
									name="sales_issuance_status" class="input7" value="N" /><span
									id="sales_issuance_YN1">미완료</span></td>
							<td height="40" class="basic_td" align="center"><input type="date" id="sales_deposit_date1"
									name="sales_deposit_date" class="input7" onchange="deposit_date_change(this,1,0);" />
							</td>
							<td height="40" class="basic_td" align="center"><input type="hidden" id="sales_deposit_status1"
									name="sales_deposit_status" class="input7" value="N" /><span
									id="sales_deposit_YN1">미완료</span></td>
							<td height="40" class="basic_td" align="center"><img src="<?php echo $misc; ?>img/btn_add.jpg"
									onclick="addRow('sales_issuance_amount_insert_line','sales_contract_total_amount',0);" />
							</td>
						</tr>
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
										<td height="40" class="basic_td" align="center"><?php echo $bill['percentage']; ?> %
											<input type="hidden" id="sales_percentage<?php echo $row;?>" name="sales_percentage" class="input7" value="<?php echo $bill['percentage']; ?>" style="width:60%;" />
										</td>
										<td height="40" class="basic_td" align="right"><?php echo number_format($bill['issuance_amount']); ?>
											<input type="hidden" id="sales_issuance_amount<?php echo $row; ?>" name="sales_issuance_amount" class="input7" style="text-align:right;" value="<?php echo number_format($bill['issuance_amount']); ?>"/>
										</td>
										<td height="40" class="basic_td" align="center"><?php echo $bill['tax_approval_number']; ?>
											<input type="hidden" id="sales_tax_approval_number<?php echo $row; ?>" name="sales_tax_approval_number" class="input7" value="<?php echo $bill['tax_approval_number']; ?>" onchange="taxApprovalNumer(this,<?php echo $row; ?>,0);" />
										</td>
										<?php }else{?>
										<td height="40" class="basic_td" align="center">
											<input type="text" id="sales_percentage<?php echo $row;?>" name="sales_percentage" class="input7" value="<?php echo $bill['percentage']; ?>" style="width:60%;" onchange="calculation_amount(<?php echo $view_val['forcasting_sales']; ?>,this,<?php echo $row; ?>,0);updateSeq(<?php echo $bill['seq']; ?>);" />
											%</td>
										<td height="40" class="basic_td" align="right"><input type="text" id="sales_issuance_amount<?php echo $row; ?>"
												name="sales_issuance_amount" class="input7" style="text-align:right;"
												value="<?php echo number_format($bill['issuance_amount']); ?>"
												onchange="percentage(<?php echo $view_val['forcasting_sales']; ?>,this,<?php echo $row; ?>,0); numberFormat(this);updateSeq(<?php echo $bill['seq']; ?>);" />
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
										<td height="40" class="basic_td" align="center"><?php echo $bill['percentage']; ?> %
											<input type="hidden" id="sales_percentage<?php echo $row;?>" name="sales_percentage" class="input7" value="<?php echo $bill['percentage']; ?>" style="width:60%;" />
										</td>
										<td height="40" class="basic_td" align="right"><?php echo number_format($bill['issuance_amount']); ?>
											<input type="hidden" id="sales_issuance_amount<?php echo $row; ?>" name="sales_issuance_amount" class="input7" style="text-align:right;" value="<?php echo number_format($bill['issuance_amount']); ?>" />
										</td>
										<td height="40" class="basic_td" align="center"><?php echo $bill['tax_approval_number']; ?>
											<input type="hidden" id="sales_tax_approval_number<?php echo $row; ?>" name="sales_tax_approval_number" class="input7" value="<?php echo $bill['tax_approval_number']; ?>" onchange="taxApprovalNumer(this,<?php echo $row; ?>,0);" />
										</td>
									<?php }else{?>
										<td height="40" class="basic_td" align="center">
											<input type="text" id="sales_percentage<?php echo $row;?>" name="sales_percentage" class="input7" value="<?php echo $bill['percentage']; ?>" style="width:60%;" onchange="calculation_amount(<?php echo $view_val['forcasting_sales']; ?>,this,<?php echo $row; ?>,0);updateSeq(<?php echo $bill['seq']; ?>);" />
											%</td>
										<td height="40" class="basic_td" align="right"><input type="text" id="sales_issuance_amount<?php echo $row; ?>"
												name="sales_issuance_amount" class="input7" style="text-align:right;"
												value="<?php echo number_format($bill['issuance_amount']); ?>"
												onchange="percentage(<?php echo $view_val['forcasting_sales']; ?>,this,<?php echo $row; ?>,0); numberFormat(this);updateSeq(<?php echo $bill['seq']; ?>);" />
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
							<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">%
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
							<td height="40" class="purchase_contract_total_amount<?php echo $num; ?> basic_td"
								align="center"><?php echo $item2['main_companyname']; ?></td>
							<td id="purchase_contract_total_amount<?php echo $num; ?>" rowspan="1"
								class="purchase_contract_total_amount<?php echo $num; ?> basic_td" height="40"
								align="center"><?php echo number_format(${"main_company_amount".$num}); ?></td>
							<td height="40" class="basic_td" align="center">
								<input type="hidden" name="purchase_company_name" value="<?php echo $item2['main_companyname']; ?>" />
								<input type="text"
									class="purchase_percentage<?php echo $num; ?> input7" name="purchase_percentage"
									value="100" style="width:60%;"
									onchange="calculation_amount(<?php echo ${'main_company_amount'.$num}; ?>,this,<?php echo $num; ?>,1);" />
								%</td>
							<td height="40" class="basic_td" align="right"><input type="text"
									class="purchase_issuance_amount<?php echo $num; ?> input7"
									name="purchase_issuance_amount" style="text-align:right;"
									value="<?php echo number_format(${"main_company_amount".$num}); ?>"
									onchange="percentage(<?php echo ${'main_company_amount'.$num}; ?>,this,<?php echo $num;?>,1); numberFormat(this);" />
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
							<td height="40" class="basic_td" align="center"><img src="<?php echo $misc; ?>img/btn_add.jpg"
									onclick="addRow('purchase_tax_invoice<?php echo $num; ?>','purchase_contract_total_amount<?php echo $num; ?>',1);" />
							</td>
						</tr>
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
						<td height="40" class="basic_td" align="center" bgcolor="f8f8f9" style="font-weight:bold;">%
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
											<td height="40" class="basic_td" align="center"><?php echo $bill['percentage']; ?> %
												<input type="hidden" name="purchase_company_name" value="<?php echo $bill['company_name']; ?>" />
												<input type="hidden"
													class="purchase_percentage<?php echo $num; ?> input7" name="purchase_percentage"
													value="<?php echo $bill['percentage']; ?>" style="width:60%;" />
											</td>
											<td height="40" class="basic_td" align="right"><?php echo number_format($bill['issuance_amount']); ?><input type="hidden"
													class="purchase_issuance_amount<?php echo $num; ?> input7" name="purchase_issuance_amount" style="text-align:right;"
													value="<?php echo number_format($bill['issuance_amount']); ?>" />
											</td>
											<td height="40" class="basic_td" align="center"><?php echo $bill['tax_approval_number']; ?>
												<input type="hidden" name="purchase_tax_approval_number" class="purchase_tax_approval_number<?php echo $num; ?> input7" value="<?php echo $bill['tax_approval_number']; ?>" onchange="taxApprovalNumer(this,<?php echo $num; ?>,1);" />
											</td>
										<?php }else{ ?>
											<td height="40" class="basic_td" align="center">
												<input type="hidden" name="purchase_company_name" value="<?php echo $bill['company_name']; ?>" />
												<input type="text"
													class="purchase_percentage<?php echo $num; ?> input7" name="purchase_percentage"
													value="<?php echo $bill['percentage']; ?>" style="width:60%;"
													onchange="calculation_amount(<?php echo ${'main_company_amount'.$num}; ?>,this,<?php echo $num; ?>,1);updateSeq(<?php echo $bill['seq']; ?>);" />
												%</td>
											<td height="40" class="basic_td" align="right"><input type="text"
													class="purchase_issuance_amount<?php echo $num; ?> input7"
													name="purchase_issuance_amount" style="text-align:right;"
													value="<?php echo number_format($bill['issuance_amount']); ?>"
													onchange="percentage(<?php echo $bill['issuance_amount']; ?>,this,<?php echo $num;?>,1);numberFormat(this);updateSeq(<?php echo $bill['seq']; ?>);" />
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
										<td height="40" class="basic_td" align="center"><?php echo $bill['percentage']; ?> %
											<input type="hidden" name="purchase_company_name" value="<?php echo $bill['company_name']; ?>" />
											<input type="hidden" class="purchase_percentage<?php echo $num; ?> input7" name="purchase_percentage"
												value="<?php echo $bill['percentage']; ?>" style="width:60%;" />
										</td>
										<td height="40" class="basic_td" align="right"><?php echo number_format($bill['issuance_amount']); ?>
											<input type="hidden" class="purchase_issuance_amount<?php echo $num; ?> input7"
												name="purchase_issuance_amount" style="text-align:right;" value="<?php echo number_format($bill['issuance_amount']); ?>"/>
										</td>
										<td height="40" class="basic_td" align="center">
											<?php echo $bill['tax_approval_number']; ?>
											<input type="hidden" name="purchase_tax_approval_number" class="purchase_tax_approval_number<?php echo $num; ?> input7" value="<?php echo $bill['tax_approval_number']; ?>" onchange="taxApprovalNumer(this,<?php echo $num; ?>,1);" />
										</td>
									<?php }else{ ?>
										<td height="40" class="basic_td" align="center">
											<input type="hidden" name="purchase_company_name" value="<?php echo $bill['company_name']; ?>" />
											<input type="text"
												class="purchase_percentage<?php echo $num; ?> input7" name="purchase_percentage"
												value="<?php echo $bill['percentage']; ?>" style="width:60%;"
												onchange="calculation_amount(<?php echo ${'main_company_amount'.$num}; ?>,this,<?php echo $num; ?>,1);updateSeq(<?php echo $bill['seq']; ?>);" />
											%</td>
										<td height="40" class="basic_td" align="right"><input type="text"
												class="purchase_issuance_amount<?php echo $num; ?> input7"
												name="purchase_issuance_amount" style="text-align:right;"
												value="<?php echo number_format($bill['issuance_amount']); ?>"
												onchange="percentage($bill['issuance_amount'],this,<?php echo $num;?>,1); numberFormat(this);updateSeq(<?php echo $bill['seq']; ?>);" />
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
				}
					?>
                </table>
            </td>
        </tr>
        <!--버튼-->
        <tr>
            <td align="right">
                <input type="image" src="<?php echo $misc; ?>img/btn_adjust.jpg" width="64" height="31" style="cursor:pointer" onclick="javascript:chkForm();return false;" />
			</td>
		</tr>
	</table>
</form>
<script>
//계싼서 추가
function addRow(insertLine, rowspanid, type) {
	if (type == 0) {
		//나머지 금액구하기
		var total_amount = Number($("#sales_contract_total_amount").text().replace(/\,/g, ''));
		var remain_amount = total_amount;
		var row_num = $("input[name=sales_issuance_amount]").length + 1;
		for (i = 0; i < $("input[name=sales_issuance_amount]").length; i++) {
			remain_amount -= Number($("input[name=sales_issuance_amount]").eq(i).val().replace(/\,/g, ''));
		}

		if (remain_amount == 0) {
			alert("총 발행 금액이 계약 금액과 일치합니다.")
			return false;
		}

		var html = '<tr class="insert_sales_bill"><td height="40" class="basic_td" align="center"><input type="text" id="sales_percentage' +
			row_num +
			'" name="sales_percentage" class="input7" style="width:60%" value="" onchange="calculation_amount(' +
			total_amount + ',this,' + row_num + ',0)" /> %</td>';
		html += '<td height="40" class="basic_td" align="right"><input type="text" id="sales_issuance_amount' +
			row_num + '" name="sales_issuance_amount" class="input7" style="text-align:right;" value="' +
			remain_amount + '" onchange="percentage(' + total_amount + ',this,' + row_num +
			',0); numberFormat(this);" /></td>';
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
		var total_amount = Number($("#purchase_contract_total_amount" + row_num).text().replace(/\,/g, ''));
		var remain_amount = total_amount;
		var eq = $(".purchase_issuance_amount" + row_num).length;
		for (i = 0; i < $(".purchase_issuance_amount" + row_num).length; i++) {
			remain_amount -= Number($(".purchase_issuance_amount" + row_num).eq(i).val().replace(/\,/g, ''));
		}

		if (remain_amount == 0) {
			alert("총 발행 금액이 계약 금액과 일치합니다.")
			return false;
		}

		var html = '<tr class="purchase_tax_invoice' + row_num +
			' insert_purchase_bill"><td height="40" class="basic_td" align="center"><input type="text" class="purchase_percentage' +
			row_num + ' input7" name="purchase_percentage" style="width:60%" value="" onchange="calculation_amount(' +
			total_amount + ',this,' + row_num + ',1)" /> %</td>';
		html +=
			'<td height="40" class="basic_td" align="right"><input type="text" class="purchase_issuance_amount' +
			row_num + ' input7" name="purchase_issuance_amount" style="text-align:right;" value="' + remain_amount +
			'" onchange="percentage(' + total_amount + ',this,' + row_num + ',1); numberFormat(this);" /></td>';
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
//delete row
function deleteRow(obj, rowspanid, type) {
	if (type == 0) {
		var tr = $(obj).parent().parent();
		tr.remove();
		var rowspan = Number($("#" + rowspanid).attr("rowspan"));
		$("#" + rowspanid).attr("rowSpan", rowspan - 1);
	} else {
		var tr = $(obj).parent().parent();
		tr.remove();
		var rowspan = Number($("#" + rowspanid).attr("rowspan"));
		$("." + rowspanid).attr("rowSpan", rowspan - 1);
	}
}

//금액으로 퍼센트 구하기
function percentage(total_amount, obj, num, type) {
	if (type == 0) {
		var val = $(obj).val().replace(/\,/g, '');
		$("#sales_percentage" + num).val(val / total_amount * 100);
	} else {
		var className = trim($(obj).attr('class').replace('input7', ''));
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
	} else {
		var className = trim($(obj).attr('class').replace('input7', ''));
		var eq = $('.' + className).index(obj);
		var val = total_amount * Number($(obj).val()) / 100;
		val = String(val).replace(/(\d)(?=(?:\d{3})+(?!\d))/g, "$1,");
		$(".purchase_issuance_amount" + num).eq(eq).val(val);
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
	
	console.log(date);
} 
</script>
</body>

</html>