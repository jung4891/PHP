<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="/misc/css/fundReporting.css">
  </head>
  <style type="text/css">

  </style>
	<script type="text/javascript" src="/misc/js/jquery.bpopup-0.1.1.min.js"></script> <!-- 모달창 js (bpopup) -->
	<script type="text/javascript" src="http://code.jquery.com/ui/1.8.17/jquery-ui.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script> <!-- selectbox 검색 js (select2) -->
	<link rel="stylesheet" href="/misc/css/select2.css"> <!--  selectbox 검색 css (select2) -->
	<link rel="stylesheet" href="/misc/css/bootstrap-datepicker.css"> <!-- 달력 표시 css (datepicker) -->
	<script type="text/javascript" src="/misc/js/bootstrap-datepicker.js"></script> <!--  달력 표시 js (datepicker) -->
	<script type="text/javascript" src="/misc/js/excelImport.js"></script> <!--  엑셀 임포트 js -->
  <script type="text/javascript" src="/misc/js/xlsx.full.min.js"></script> <!--  엑셀 임포트 js -->
	<script type="text/javascript" src="/misc/js/mousetrap.js"></script> <!--  단축키 js -->
<body>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
  <tr width="100%">
    <td align="center" valign="top">
    <!-- ********************** 본문 시작 ********************** -->
<script type="text/javascript">
// get 값 가져오는 함수
function getParam(sname) {
  var params = location.search.substr(location.search.indexOf("?") + 1);
  var sval = "";
  params = params.split("&");
  for (var i = 0; i < params.length; i++) {
    temp = params[i].split("=");
    if ([temp[0]] == sname) {
      sval = temp[1];
    }
  }
  return sval;
}
var firstPage = parseInt(<?php echo $firstPage-1; ?>/100)*100;

if (window.location.pathname == "/index.php/fundreporting/fundreporting_list" && firstPage > 0){
	location.href="/index.php/fundreporting/fundreporting_list/page/"+firstPage+"?company=" + getParam("company");
	}
</script>
<?php
	$week = array("일", "월", "화", "수", "목", "금", "토");
	$s = $week[date("w")];
	switch ($company) {
		case 'DUIT':
			$companyName = '두리안정보기술';
			break;
		case 'DUICT':
			$companyName = '두리안정보통신기술';
			break;
		case 'MG':
			$companyName = '더망고';
			break;
		case 'DBS':
			$companyName = '두리안정보기술부산지점';
			break;
	}
	$company = '?company='.$company;

	$baseUrl = site_url();
	$segment1 = $this->uri->segment(1);
	$segment2 = $this->uri->segment(2, 0);
?>
<!-- 본문 div -->
		<div class="content" style="margin-left:10px; margin-right:10px;">
			<div style="display:none">
				<input type="hidden" id="userId" value="<?php echo $id; ?>">
			</div>

			<h2 style="font-weight:900;"><?php echo $companyName." <".date("Y년 n월 j일 $s\요일")."> "; ?>자금보고서</h2>
			<!-- <h4 style="<?php if($sum_botong == $sum_list_banktype){echo "color:blue;";}else{echo "color:red;";} ?>">계좌 총액 : <?php echo number_format($sum_botong); if($sum_botong!=$sum_list_banktype){echo " (차액 : ".number_format($sum_botong-$sum_list_banktype).")";}?></h4> -->
<!-- 은행 정보 -->
			<div id="fold_bankbook" class="bankBook-container" style="width:95%; display:none;">
				<table class="bankbook" style="width:100%">
					<colgroup>
						<col style="width:6%">
						<col style="width:10%">
						<col style="width:6%">
						<col style="width:11%">
						<col style="width:32%">
						<col style="width:7%">
						<col style="width:7%">
						<col style="width:7%">
						<col style="width:7%">
						<col style="width:7%">
					</colgroup>
					<thead>
            <tr class="bankBook_top" style="background-color:#f2f2f2;">
              <th scope="colgroup" style="text-align:left;">예금종류</th>
              <th scope="colgroup" style="text-align:left;">은행</th>
              <th scope="colgroup" style="text-align:left;">은행구분</th>
              <th scope="colgroup" style="text-align:left;">계좌번호</th>
							<th scope="colgroup" style="text-align:left;">내역</th>
              <th scope="colgroup" style="text-align:right;">전일이월</th>
              <th scope="colgroup" style="text-align:right;">당일증가</th>
              <th scope="colgroup" style="text-align:right;">당일감소</th>
              <th scope="colgroup" style="text-align:right;">당일잔액</th>
              <th scope="colgroup" style="text-align:right;">가용금액</th>
            </tr>
          </thead>
<?php foreach ($bankBook as $val) { ?>
					<tbody id="ordinary_bank">
<?php 	if ($val->type == '보통예금') {
					echo '<tr class="ordinary_bank_list">';
					echo '<td scope="row" class="line" name="accountType" style="text-align:left;">'.$val->type.'</td>';
					echo '<td scope="row" class="line" name="bank" style="text-align:left;">'.$val->bank.'</td>';
					echo '<td scope="row" class="line" name="bankType" style="text-align:left;">'.$val->banktype.'</td>';
					echo '<td scope="row" class="line" name="account" style="text-align:left;">'.$val->account.'</td>';
					echo '<td scope="row" class="line" name="breakdown" style="text-align:left;">'.$val->breakdown.'</td>';
					echo '<td scope="row" class="line" name="yesbalance" style="text-align:right;">'.number_format($val->yesbalance).'</td>';
					echo '<td scope="row" class="line" name="todaydeposit" style="text-align:right;">'.number_format($val->todaydeposit).'</td>';
					echo '<td scope="row" class="line" name="todaywithdraw" style="text-align:right;">'.number_format($val->todaywithdraw).'</td>';
					echo '<td scope="row" class="line" name="balance" style="text-align:right; font-weight:bold;">'.number_format($val->balance).'</td>';
					echo '<td scope="row" class="line" name="balance2" style="text-align:right;">'.number_format($val->balance).'</td>';
					echo '</tr>';
				}
			}
?>
					</tbody>
					<tbody>
						<tr style="background-color:#f2f2f2;">
							<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
							<td style="text-align:center; font-weight:bold;">소&nbsp;&nbsp;&nbsp;계</td>
							<td style="text-align:right; font-weight:bold; text-align:right;"><?php echo number_format($sum_botong) ?></td>
							<td></td>
						</tr>
					</tbody>
<?php foreach ($bankBook as $val) { ?>
					<tbody id="save_bank">
<?php 	if ($val->type == '예적금') {
					echo '<tr class="save_bank_list">';
					echo '<td scope="row" class="line" name="accountType" style="text-align:left;">'.$val->type.'</td>';
					echo '<td scope="row" class="line" name="bank" style="text-align:left;">'.$val->bank.'</td>';
					echo '<td scope="row" class="line" name="bankType" style="text-align:left;">'.$val->banktype.'</td>';
					echo '<td scope="row" class="line" name="account" style="text-align:left;">'.$val->account.'</td>';
					echo '<td scope="row" class="line" name="breakdown" style="text-align:left;">'.$val->breakdown.'</td>';
					echo '<td scope="row" class="line" name="yesbalance" style="text-align:right;">'.number_format($val->yesbalance).'</td>';
					echo '<td scope="row" class="line" name="todaydeposit" style="text-align:right;">'.number_format($val->todaydeposit).'</td>';
					echo '<td scope="row" class="line" name="todaywithdraw" style="text-align:right;">'.number_format($val->todaywithdraw).'</td>';
					echo '<td scope="row" class="line" name="balance" style="text-align:right; font-weight:bold;">'.number_format($val->balance).'</td>';
					echo '<td scope="row" class="line" name="balance2" style="text-align:right;">'.number_format($val->balance).'</td>';
					echo '</tr>';
				}
			}
?>
					</tbody>
<?php foreach ($bankBook as $val) { ?>
					<tbody id="deposit_bank">
<?php 	if ($val->type == '보증금') {
					echo '<tr class="deposit_bank_list">';
					echo '<td scope="row" class="line" name="accountType" style="text-align:left;">'.$val->type.'</td>';
					echo '<td scope="row" class="line" name="bank" style="text-align:left;">'.$val->bank.'</td>';
					echo '<td scope="row" class="line" name="bankType" style="text-align:left;">'.$val->banktype.'</td>';
					echo '<td scope="row" class="line" name="account" style="text-align:left;">'.$val->account.'</td>';
					echo '<td scope="row" class="line" name="breakdown" style="text-align:left;">'.$val->breakdown.'</td>';
					echo '<td scope="row" class="line" name="yesbalance" style="text-align:right;">'.number_format($val->yesbalance).'</td>';
					echo '<td scope="row" class="line" name="todaydeposit" style="text-align:right;">'.number_format($val->todaydeposit).'</td>';
					echo '<td scope="row" class="line" name="todaywithdraw" style="text-align:right;">'.number_format($val->todaywithdraw).'</td>';
					echo '<td scope="row" class="line" name="balance" style="text-align:right; font-weight:bold;">'.number_format($val->balance).'</td>';
					echo '<td scope="row" class="line" name="balance2" style="text-align:right;">'.number_format($val->balance).'</td>';
					echo '</tr>';
				}
			}
?>
					</tbody>
<?php foreach ($bankBook as $val) { ?>
					<tbody id="loan_bank">
<?php 	if ($val->type == '대출금') {
					echo '<tr class="loan_bank_list">';
					echo '<td scope="row" class="line" name="accountType" style="text-align:left;">'.$val->type.'</td>';
					echo '<td scope="row" class="line" name="bank" style="text-align:left;">'.$val->bank.'</td>';
					echo '<td scope="row" class="line" name="bankType" style="text-align:left;">'.$val->banktype.'</td>';
					echo '<td scope="row" class="line" name="account" style="text-align:left;">'.$val->account.'</td>';
					echo '<td scope="row" class="line" name="breakdown" style="text-align:left;">'.$val->breakdown.'</td>';
					echo '<td scope="row" class="line" name="yesbalance" style="text-align:right;">'.number_format($val->yesbalance).'</td>';
					echo '<td scope="row" class="line" name="todaydeposit" style="text-align:right;">'.number_format($val->todaydeposit).'</td>';
					echo '<td scope="row" class="line" name="todaywithdraw" style="text-align:right;">'.number_format($val->todaywithdraw).'</td>';
					echo '<td scope="row" class="line" name="balance" style="text-align:right; font-weight:bold;">'.number_format($val->balance).'</td>';
					echo '<td scope="row" class="line" name="balance2" style="text-align:right;">'.number_format($val->balance).'</td>';
					echo '</tr>';
				}
			}
?>
					</tbody>
<?php foreach ($bankBook as $val) { ?>
					<tbody id="loan_bank">
<?php 	if ($val->type == '투자금') {
					echo '<tr class="loan_bank_list">';
					echo '<td scope="row" class="line" name="accountType" style="text-align:left;">'.$val->type.'</td>';
					echo '<td scope="row" class="line" name="bank" style="text-align:left;">'.$val->bank.'</td>';
					echo '<td scope="row" class="line" name="bankType" style="text-align:left;">'.$val->banktype.'</td>';
					echo '<td scope="row" class="line" name="account" style="text-align:left;">'.$val->account.'</td>';
					echo '<td scope="row" class="line" name="breakdown" style="text-align:left;">'.$val->breakdown.'</td>';
					echo '<td scope="row" class="line" name="yesbalance" style="text-align:right;">'.number_format($val->yesbalance).'</td>';
					echo '<td scope="row" class="line" name="todaydeposit" style="text-align:right;">'.number_format($val->todaydeposit).'</td>';
					echo '<td scope="row" class="line" name="todaywithdraw" style="text-align:right;">'.number_format($val->todaywithdraw).'</td>';
					echo '<td scope="row" class="line" name="balance" style="text-align:right; font-weight:bold;">'.number_format($val->balance).'</td>';
					echo '<td scope="row" class="line" name="balance2" style="text-align:right;">'.number_format($val->balance).'</td>';
					echo '</tr>';
				}
			}
?>
					</tbody>
					<tbody>
						<tr style="background-color:#f2f2f2;">
							<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
							<td style="text-align:center; font-weight:bold;">소&nbsp;&nbsp;&nbsp;계</td>
							<td style="text-align:right; font-weight:bold; text-align:right;"><?php echo number_format($sum_not_botong) ?></td>
							<td></td>
						</tr>
					</tbody>
					<tbody id="bankbook_total_sum">
						<tr style="background-color:#deebf7;">
							<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
							<td style="text-align:center; font-weight:bold;<?php if($sum_botong != $sum_list_banktype){echo 'color:red;';}else{echo 'color:black;';} ?>">합&nbsp;&nbsp;&nbsp;계</td>
							<td style="text-align:right; font-weight:bold; text-align:right;"><?php echo number_format($sum_botong+$sum_not_botong) ?></td>
							<td></td>
						</tr>
					</tbody>
					<tbody>
						<tr class="bondDebt">
							<td style="border-bottom:none;"></td>
							<td style="border-bottom:none;"></td>
							<td style="border-bottom:none;"></td>
							<td style="border-bottom:none;"></td>
							<td style="border-bottom:none;"></td>
							<td style="border-bottom:none;"></td>
							<td style="background:yellow; text-align:center; background-color:#deebf7; color:red; font-weight:bold;">매 출 채 권</td>
							<td scope="row" class="line" name="bond" style="text-align:right; font-weight:bold;"><?php echo number_format($bond[0]->bond) ?></td>
							<td style="background:yellow; text-align:center; background-color:#deebf7; color:blue; font-weight:bold;">매 입 채 무</td>
							<td scope="row" class="line" name="debt" style="text-align:right; font-weight:bold;"><?php echo number_format($debt[0]->debt) ?></td>
						</tr>
					</tbody>
				</table>
			</div>

			<div>
				<strong><a href="#" id="foldBtn" align="center" onclick="fold_bankbook(this);">잔고현황▼</a></strong>
			</div>
			<div>
				<button type="button" name="modalBtn" id="modalBtn" style="float:right; cursor:pointer;<?php if($pGroupName=='영업본부'){echo 'display:none';} ?>" onclick="modalOpen();">은행관리</button>
			</div>

			<div id="bankModal" class="bankModal" role="dialog" tabindex="-1" aria-hidden="true" data-backdrop="static" data-keyboard="false" style="margin-top:30px;<?php if($pGroupName=='영업본부'){echo 'display:none';} ?>">
				<span style="float:right; cursor: pointer;" onclick="modalClose();">
					<img class="manImg" src="/misc/img/btn_del2.jpg"></img>
				</span>
				<div class="modal-dialog modal-lg" data-backdrop="static" data-keyboard="false">

					<div class="modal-contents" data-backdrop="static" data-keyboard="false">
						<div class="modal-header">

							<h2 align="center">은행 입력</h2>
						</div>
						<div class="modal-body">
							<table style="margin:0px;" name="modal_insert">
								<thead style="align:middle;">
									<tr style="margin:0px;" class="modal_insert_col">
										<th scope="colgroup" style="width:10%; background-color: #f2f2f2"><strong>예금종류</strong></th>
										<th scope="colgroup" style="width:10%; background-color: #f2f2f2"><strong>은행</strong></th>
										<th scope="colgroup" style="width:10%; background-color: #f2f2f2"><strong>은행구분</strong></th>
										<th scope="colgroup" style="width:14%; background-color: #f2f2f2"><strong>계좌번호</strong><br><font size="1px">('-'기호 포함)</font></th>
										<th scope="colgroup" style="width:40%; background-color: #f2f2f2"><strong>내역</strong></th>
										<th scope="colgroup" style="width:11%; background-color: #f2f2f2;"><strong>금액</strong></th>
										<th scope="colgroup" style="width:7%; background-color: #f2f2f2;"></th>
									</tr>
								</thead>
								<tbody style="align:middle;" id="insertTbody">
									<tr id="modal_insert_row">
										<td scope="row">
											<select id="insertType" name="insertType" style="width:100%; border:solid 1px black;" onchange="insertType(this);">
												<option value="" selected disabled hidden>선택하세요</option>
												<option value="보통예금">보통예금</option>
												<option value="예적금">예적금</option>
												<option value="보증금">보증금</option>
												<option value="대출금">대출금</option>
												<option value="투자금">투자금</option>
											</select>
										</td>
										<td scope="row">
											<select id="insertBank" name="insertBank" style="width:100%; border:solid 1px black;" onchange="selboxDirect(this);">
												<option value=""></option>
												<option value="직접입력">직접입력</option>
<?php
	foreach ($bankList as $val){
		echo "<option value=".$val->bank.">".$val->bank."</option>";
	}
 ?>
												<option value="" selected disabled hidden>선택하세요</option>
											</select>
											<input style="width:93%; border:solid 1px black; display:none;" type="text" class="selboxDirect" value="" onchange="insBankDirect(this);">
										</td>
										<td scope="row"><input style="width:95%; border:solid 1px black;" type="text" name="insertBankType" id="insertBankType"></td>
										<td scope="row"><input style="width:97%; border:solid 1px black;" type="text" name="insertAccount" id="insertAccount" onkeyup="onlyNumHipen(this)"></td>
										<td scope="row"><input style="width:97%; border:solid 1px black;" type="text" name="insertBreakdown" id="insertBreakdown"></td>
										<td scope="row"><input style="width:97%; border:solid 1px black;" type="text" name="insertBalance" id='insertBalance'
												onFocus="deCommaStr(this);" onBlur="this.value = commaStr(this.value);" onkeyup="onlyNumber(this)"></td>
										<td><button type="button" style="width:97%; vertical-align:center; padding:4px;" data-dismiss="modal" name="modalSaveBtn" onclick="insertBank();"><font size="2px">저장</font></button></td>
									</tr>
								</tbody>
							</table><br>

							<strong><a href="javascript:void(0);" id="selectTableBtn" align="center" onclick="fold_modal(this)">보통예금▼</a></strong>
							<div class="modal_select_div" style="display:none;">
								<div class="modal_select_box">
									<table style="margin:10px,20px;" id="selectTable" name="selectTable">
										<thead>
											<tr class="fixed_top">
												<th scope="colgroup" style="width:10%; background-color: #f2f2f2"><strong>예금종류</strong></th>
												<th scope="colgroup" style="width:10%; background-color: #f2f2f2"><strong>은행</strong></th>
												<th scope="colgroup" style="width:10%; background-color: #f2f2f2"><strong>은행구분</strong></th>
												<th scope="colgroup" style="width:14%; background-color: #f2f2f2"><strong>계좌번호</strong></th>
												<th scope="colgroup" style="width:41%; background-color: #f2f2f2"><strong>내역</strong></th>
												<th scope="colgroup" style="width:12%; background-color: #f2f2f2;"><strong>금액</strong></th>
												<th scope="colgroup" style="width:5%; background-color: #f2f2f2;"></th>
											</tr>
										</thead>
										<tbody>
<?php
	foreach($selectBanklist as $val){
		if($val->type == "보통예금") {
			echo '<tr class="modal_select_row" id="modal_select_row" name="'.$val->idx.'">';
			// echo '<input type="hidden" style="color:red" id="idx'.$val->idx.'" value="'.$val->idx.'">';
			echo '<td style="width:10%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<select class="input" id="selectType" name="selectType" style="width:100%; border:solid 1px black;" onchange="modifyModalInput(this);">';
			echo '<option value="보통예금" selected="">보통예금</option>';
			echo '<option value="보증금">보증금</option>';
			echo '<option value="예적금">예적금</option>';
			echo '<option value="대출금">대출금</option>';
			echo '<option value="투자금">투자금</option></select></td>';
			echo '<td style="width:10%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<select class="input" id="selectBank" name="selectBank" style="width:100%; border:solid 1px black;" onchange="selboxDirect(this); modifyModalInput(this);">';
			echo '<option value="직접입력">직접입력</option>';
			echo '<option value=""></option>';
			echo '<option value="'.$val->bank.'" selected="">'.$val->bank.'</option>';
			foreach($bankList as $option){
				if($option->bank != $val->bank){
					echo '<option value="'.$option->bank.'">'.$option->bank.'</option>';
				}
			}
			echo '</select>';
			echo '<input type="text" class="selboxDirect" style="display:none; width:90%;" scope="row"></td>';
			echo '<td style="width:10%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<input class="input" style="width:90%; text-align:left;" type="text" id="selectBankType" name="selectBankType" value="'.$val->banktype.'" onchange="modifyModalInput(this);"></td>';
			echo '<td style="width:20%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<input class="input" style="width:95%; text-align:left;" type="text" id="selectAccount" name="selectAccount" value="'.$val->account.'" onchange="modifyModalInput(this);" onkeyup="onlyNumHipen(this)"></td>';
			echo '<td style="width:25%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<input class="input" style="width:95%; text-align:left;" type="text" id="selectBreakdown" name="selectBreakdown" value="'.$val->breakdown.'" onchange="modifyModalInput(this);"></td>';
			echo '<td style="width:20%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<input class="input" style="width:95%; text-align:right;" type="text" id="selectBalance" name="selectBalance" value="'.number_format($val->balance).'" onfocus="deCommaStr(this);" onblur="this.value = commaStr(this.value);" onchange="modifyModalInput(this);" onkeyup="onlyNumber(this)" readonly=""></td>';
			echo '<td style="width:5%; border-bottom: 0.1px solid #D8D8D8">';
			echo '<input type="button" style="width:95%;" id="delBank" class="delBank" onclick="delBank(this)" value=" X "></td></tr>';
		}
	}
 ?>
										</tbody>
									</table>
								</div>
							</div>
							<br>

							<strong><a href="javascript:void(0);" id="saveTableBtn" align="center" onclick="fold_modal(this)">예적금▼</a></strong>
							<div class="modal_select_Save_div" style="display:none;">
								<div class="modal_select_a_box">
									<table style="margin:10px,20px;" class="selectSaveTable" id="selectSaveTable" name="saveTable">
										<thead>
											<tr class="fixed_top3">
												<th scope="colgroup" style="width:10%; background-color: #f2f2f2"><strong>예금종류</strong></th>
												<th scope="colgroup" style="width:10%; background-color: #f2f2f2"><strong>은행</strong></th>
												<th scope="colgroup" style="width:10%; background-color: #f2f2f2"><strong>은행구분</strong></th>
												<th scope="colgroup" style="width:14%; background-color: #f2f2f2"><strong>계좌번호</strong></th>
												<th scope="colgroup" style="width:41%; background-color: #f2f2f2"><strong>내역</strong></th>
												<th scope="colgroup" style="width:12%; background-color: #f2f2f2;"><strong>금액</strong></th>
												<th scope="colgroup" style="width:5%; background-color: #f2f2f2;"></th>
											</tr>
										</thead>
										<tbody>
<?php
	foreach($selectBanklist as $val){
		if($val->type == "예적금") {
			echo '<tr class="modal_select_Save_row" id="modal_select_Save_row" name="'.$val->idx.'">';
			// echo '<input type="hidden" style="color:red" id="idx'.$val->idx.'" value="'.$val->idx.'">';
			echo '<td style="width:10%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<select class="input" id="selectType" name="selectType" style="width:100%; border:solid 1px black;" onchange="modifyModalInput(this);">';
			echo '<option value="보통예금">보통예금</option>';
			echo '<option value="보증금">보증금</option>';
			echo '<option value="예적금" selected="">예적금</option>';
			echo '<option value="대출금">대출금</option>';
			echo '<option value="투자금">투자금</option></select></td>';
			echo '<td style="width:10%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<select class="input" id="selectBank" name="selectBank" style="width:100%; border:solid 1px black;" onchange="selboxDirect(this); modifyModalInput(this);">';
			echo '<option value="직접입력">직접입력</option>';
			echo '<option value=""></option>';
			echo '<option value="'.$val->bank.'" selected="">'.$val->bank.'</option>';
			foreach($bankList as $option){
				if($option->bank != $val->bank){
					echo '<option value="'.$option->bank.'">'.$option->bank.'</option>';
				}
			}
			echo '</select>';
			echo '<input type="text" class="selboxDirect" style="display:none; width:90%;" scope="row"></td>';
			echo '<td style="width:10%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<input class="input" style="width:90%; text-align:left;" type="text" id="selectBankType" name="selectBankType" value="'.$val->banktype.'" onchange="modifyModalInput(this);"></td>';
			echo '<td style="width:20%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<input class="input" style="width:95%; text-align:left;" type="text" id="selectAccount" name="selectAccount" value="'.$val->account.'" onchange="modifyModalInput(this);" onkeyup="onlyNumHipen(this)"></td>';
			echo '<td style="width:25%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<input class="input" style="width:95%; text-align:left;" type="text" id="selectBreakdown" name="selectBreakdown" value="'.$val->breakdown.'" onchange="modifyModalInput(this);"></td>';
			echo '<td style="width:20%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<input class="input" style="width:95%; text-align:right;" type="text" id="selectBalance" name="selectBalance" value="'.number_format($val->balance).'" onfocus="deCommaStr(this);" onblur="this.value = commaStr(this.value);" onchange="modifyModalInput(this);" onkeyup="onlyNumber(this)"></td>';
			echo '<td style="width:5%; border-bottom: 0.1px solid #D8D8D8">';
			echo '<input type="button" style="width:95%;" id="delBank" class="delBank" onclick="delBank(this)" value=" X "></td></tr>';
		}
	}
 ?>
										</tbody>
									</table>
								</div>
							</div>
							<br>
							<strong><a href="javascript:void(0);" id="depositTableBtn" align="center" onclick="fold_modal(this)">보증금▼</a></strong>
							<div class="modal_select_Deposit_div" style="display:none;">
								<div class="modal_select_a_box">
									<table style="margin:10px,20px;" class="selectDepositTable" id="selectDepositTable" name="depositTable">
										<thead>
											<tr class="fixed_top">
												<th scope="colgroup" style="width:10%; background-color: #f2f2f2"><strong>예금종류</strong></th>
												<th scope="colgroup" style="width:10%; background-color: #f2f2f2"><strong>은행</strong></th>
												<th scope="colgroup" style="width:10%; background-color: #f2f2f2"><strong>은행구분</strong></th>
												<th scope="colgroup" style="width:14%; background-color: #f2f2f2"><strong>계좌번호</strong></th>
												<th scope="colgroup" style="width:41%; background-color: #f2f2f2"><strong>내역</strong></th>
												<th scope="colgroup" style="width:12%; background-color: #f2f2f2;"><strong>금액</strong></th>
												<th scope="colgroup" style="width:5%; background-color: #f2f2f2;"></th>
											</tr>
										</thead>
										<tbody>
<?php
	foreach($selectBanklist as $val){
		if($val->type == "보증금") {
			echo '<tr class="modal_select_Deposit_row" id="modal_select_Deposit_row" name="'.$val->idx.'">';
			// echo '<input type="hidden" style="color:red" id="idx'.$val->idx.'" value="'.$val->idx.'">';
			echo '<td style="width:10%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<select class="input" id="selectType" name="selectType" style="width:100%; border:solid 1px black;" onchange="modifyModalInput(this);">';
			echo '<option value="보통예금">보통예금</option>';
			echo '<option value="보증금" selected="">보증금</option>';
			echo '<option value="예적금">예적금</option>';
			echo '<option value="대출금">대출금</option>';
			echo '<option value="투자금">투자금</option></select></td>';
			echo '<td style="width:10%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<select class="input" id="selectBank" name="selectBank" style="width:100%; border:solid 1px black;" onchange="selboxDirect(this); modifyModalInput(this);">';
			echo '<option value="직접입력">직접입력</option>';
			echo '<option value=""></option>';
			echo '<option value="'.$val->bank.'" selected="">'.$val->bank.'</option>';
			foreach($bankList as $option){
				if($option->bank != $val->bank){
					echo '<option value="'.$option->bank.'">'.$option->bank.'</option>';
				}
			}
			echo '</select>';
			echo '<input type="text" class="selboxDirect" style="display:none; width:90%;" scope="row"></td>';
			echo '<td style="width:10%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<input class="input" style="width:90%; text-align:left;" type="text" id="selectBankType" name="selectBankType" value="'.$val->banktype.'" onchange="modifyModalInput(this);"></td>';
			echo '<td style="width:20%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<input class="input" style="width:95%; text-align:left;" type="text" id="selectAccount" name="selectAccount" value="'.$val->account.'" onchange="modifyModalInput(this);" onkeyup="onlyNumHipen(this)"></td>';
			echo '<td style="width:25%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<input class="input" style="width:95%; text-align:left;" type="text" id="selectBreakdown" name="selectBreakdown" value="'.$val->breakdown.'" onchange="modifyModalInput(this);"></td>';
			echo '<td style="width:20%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<input class="input" style="width:95%; text-align:right;" type="text" id="selectBalance" name="selectBalance" value="'.number_format($val->balance).'" onfocus="deCommaStr(this);" onblur="this.value = commaStr(this.value);" onchange="modifyModalInput(this);" onkeyup="onlyNumber(this)"></td>';
			echo '<td style="width:5%; border-bottom: 0.1px solid #D8D8D8">';
			echo '<input type="button" style="width:95%;" id="delBank" class="delBank" onclick="delBank(this)" value=" X "></td></tr>';
		}
	}
 ?>
										</tbody>
									</table>
								</div>
							</div>
							<br>

							<strong><a href="javascript:void(0);" id="loanTableBtn" align="center" onclick="fold_modal(this)">대출금▼</a></strong>
							<div class="modal_select_Loan_div" style="display:none;">
								<div class="modal_select_a_box">
									<table style="margin:10px,20px;" class="selectLoanTable" id="selectLoanTable" name="loanTable">
										<thead>
											<tr class="fixed_top">
												<th scope="colgroup" style="width:10%; background-color: #f2f2f2"><strong>예금종류</strong></th>
												<th scope="colgroup" style="width:10%; background-color: #f2f2f2"><strong>은행</strong></th>
												<th scope="colgroup" style="width:10%; background-color: #f2f2f2"><strong>은행구분</strong></th>
												<th scope="colgroup" style="width:14%; background-color: #f2f2f2"><strong>계좌번호</strong></th>
												<th scope="colgroup" style="width:41%; background-color: #f2f2f2"><strong>내역</strong></th>
												<th scope="colgroup" style="width:12%; background-color: #f2f2f2;"><strong>금액</strong></th>
												<th scope="colgroup" style="width:5%; background-color: #f2f2f2;"></th>
											</tr>
										</thead>
										<tbody>
<?php
	foreach($selectBanklist as $val){
		if($val->type == "대출금") {
			echo '<tr class="modal_select_Loan_row" id="modal_select_Loan_row" name="'.$val->idx.'">';
			// echo '<input type="hidden" style="color:red" id="idx'.$val->idx.'" value="'.$val->idx.'">';
			echo '<td style="width:10%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<select class="input" id="selectType" name="selectType" style="width:100%; border:solid 1px black;" onchange="modifyModalInput(this);">';
			echo '<option value="보통예금">보통예금</option>';
			echo '<option value="보증금">보증금</option>';
			echo '<option value="예적금">예적금</option>';
			echo '<option value="대출금" selected="">대출금</option>';
			echo '<option value="투자금">투자금</option></select></td>';
			echo '<td style="width:10%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<select class="input" id="selectBank" name="selectBank" style="width:100%; border:solid 1px black;" onchange="selboxDirect(this); modifyModalInput(this);">';
			echo '<option value="직접입력">직접입력</option>';
			echo '<option value=""></option>';
			echo '<option value="'.$val->bank.'" selected="">'.$val->bank.'</option>';
			foreach($bankList as $option){
				if($option->bank != $val->bank){
					echo '<option value="'.$option->bank.'">'.$option->bank.'</option>';
				}
			}
			echo '</select>';
			echo '<input type="text" class="selboxDirect" style="display:none; width:90%;" scope="row"></td>';
			echo '<td style="width:10%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<input class="input" style="width:90%; text-align:left;" type="text" id="selectBankType" name="selectBankType" value="'.$val->banktype.'" onchange="modifyModalInput(this);"></td>';
			echo '<td style="width:20%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<input class="input" style="width:95%; text-align:left;" type="text" id="selectAccount" name="selectAccount" value="'.$val->account.'" onchange="modifyModalInput(this);" onkeyup="onlyNumHipen(this)"></td>';
			echo '<td style="width:25%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<input class="input" style="width:95%; text-align:left;" type="text" id="selectBreakdown" name="selectBreakdown" value="'.$val->breakdown.'" onchange="modifyModalInput(this);"></td>';
			echo '<td style="width:20%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<input class="input" style="width:95%; text-align:right;" type="text" id="selectBalance" name="selectBalance" value="'.number_format($val->balance).'" onfocus="deCommaStr(this);" onblur="this.value = commaStr(this.value);" onchange="modifyModalInput(this);" onkeyup="onlyNumber(this)"></td>';
			echo '<td style="width:5%; border-bottom: 0.1px solid #D8D8D8">';
			echo '<input type="button" style="width:95%;" id="delBank" class="delBank" onclick="delBank(this)" value=" X "></td></tr>';
		}
	}
 ?>
										</tbody>
									</table>
								</div>
							</div>
							<br>

							<strong><a href="javascript:void(0);" id="investTableBtn" align="center" onclick="fold_modal(this)">투자금▼</a></strong>
							<div class="modal_select_invest_div" style="display:none;">
								<div class="modal_select_a_box">
									<table style="margin:10px,20px;" class="selectInvestTable" id="selectInvestTable" name="investTable">
										<thead>
											<tr class="fixed_top">
												<th scope="colgroup" style="width:10%; background-color: #f2f2f2"><strong>예금종류</strong></th>
												<th scope="colgroup" style="width:10%; background-color: #f2f2f2"><strong>은행</strong></th>
												<th scope="colgroup" style="width:10%; background-color: #f2f2f2"><strong>은행구분</strong></th>
												<th scope="colgroup" style="width:14%; background-color: #f2f2f2"><strong>계좌번호</strong></th>
												<th scope="colgroup" style="width:41%; background-color: #f2f2f2"><strong>내역</strong></th>
												<th scope="colgroup" style="width:12%; background-color: #f2f2f2;"><strong>금액</strong></th>
												<th scope="colgroup" style="width:5%; background-color: #f2f2f2;"></th>
											</tr>
										</thead>
										<tbody>
<?php
	foreach($selectBanklist as $val){
		if($val->type == "투자금") {
			echo '<tr class="modal_select_invest_row" id="modal_select_invest_row" name="'.$val->idx.'">';
			// echo '<input type="hidden" style="color:red" id="idx'.$val->idx.'" value="'.$val->idx.'">';
			echo '<td style="width:10%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<select class="input" id="selectType" name="selectType" style="width:100%; border:solid 1px black;" onchange="modifyModalInput(this);">';
			echo '<option value="보통예금">보통예금</option>';
			echo '<option value="보증금">보증금</option>';
			echo '<option value="예적금">예적금</option>';
			echo '<option value="대출금">대출금</option>';
			echo '<option value="투자금" selected="">투자금</option></select></td>';
			echo '<td style="width:10%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<select class="input" id="selectBank" name="selectBank" style="width:100%; border:solid 1px black;" onchange="selboxDirect(this); modifyModalInput(this);">';
			echo '<option value="직접입력">직접입력</option>';
			echo '<option value=""></option>';
			echo '<option value="'.$val->bank.'" selected="">'.$val->bank.'</option>';
			foreach($bankList as $option){
				if($option->bank != $val->bank){
					echo '<option value="'.$option->bank.'">'.$option->bank.'</option>';
				}
			}
			echo '</select>';
			echo '<input type="text" class="selboxDirect" style="display:none; width:90%;" scope="row"></td>';
			echo '<td style="width:10%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<input class="input" style="width:90%; text-align:left;" type="text" id="selectBankType" name="selectBankType" value="'.$val->banktype.'" onchange="modifyModalInput(this);"></td>';
			echo '<td style="width:20%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<input class="input" style="width:95%; text-align:left;" type="text" id="selectAccount" name="selectAccount" value="'.$val->account.'" onchange="modifyModalInput(this);" onkeyup="onlyNumHipen(this)"></td>';
			echo '<td style="width:25%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<input class="input" style="width:95%; text-align:left;" type="text" id="selectBreakdown" name="selectBreakdown" value="'.$val->breakdown.'" onchange="modifyModalInput(this);"></td>';
			echo '<td style="width:20%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<input class="input" style="width:95%; text-align:right;" type="text" id="selectBalance" name="selectBalance" value="'.number_format($val->balance).'" onfocus="deCommaStr(this);" onblur="this.value = commaStr(this.value);" onchange="modifyModalInput(this);" onkeyup="onlyNumber(this)"></td>';
			echo '<td style="width:5%; border-bottom: 0.1px solid #D8D8D8">';
			echo '<input type="button" style="width:95%;" id="delBank" class="delBank" onclick="delBank(this)" value=" X "></td></tr>';
		}
	}
 ?>
										</tbody>
									</table>
								</div>
							</div>

						</div>
						<div class="modal-footer">
							<button type="button" style="vertical-align:center; margin-right:3px;"  data-dismiss="modal" name="modalChangeBtn" onclick="modifyBank();">수정</button>
							<a href="javascript:void(0);" rel="modal:close" style="margin-left:3px;" onclick="modalClose();"><button>닫기</button></a>
						</div>
					</div>
				</div>
			</div>
			<br>
			<h3 align="center">자금 입출금 현황 및 SCHEDULE</h3>

			<!-- 버튼 시작 -->
			<div class="filebox" id="hideDiv">
				<label style="float: left;<?php if($pGroupName=='영업본부'){echo 'display:none';} ?>" class="input-file-button" for="excelFile">파일 업로드</label>
				<input style="display:none;" type="file" id="excelFile" onchange="excelExport(event)" />
				<br><br>
				<button id="hideButton" style="float: left;" type="button" onclick="location.href='<?php echo site_url();?>/fundreporting/download';">엑셀 폼 다운로드</button>
				<button style="float: right;<?php if($pGroupName=='영업본부'){echo 'display:none';} ?>" type="button" class="hideButton" id="update" onclick="saveList();">저장</button>
		    <button style="float: right;<?php if($pGroupName=='영업본부'){echo 'display:none';} ?>;" type="button" class="hideButton" name="button" onclick="deleteRow();">삭제</button>
		    <button class="moveBottom" style="float: right;" type="button" name="button" onclick="scrollDown();">▼</button>
		    <button class="moveTop" style="float: right;" type="button" name="button" onclick="scrollUp();">▲</button>
			</div>
			<div>
				<form id="fundSearch" method="post" >
					<select name="selectDate" id="selectDate">
						<option value="dueDate" <?php if(isset($selectDate) && $selectDate=="dueDate"){echo 'selected';} ?>>확정일</option>
						<option value="fixedDate" <?php if(isset($selectDate) && $selectDate=="fixedDate"){echo 'selected';} ?>>예정일</option>
						<option value="dateOfIssue" <?php if(isset($selectDate) && $selectDate=="dateOfIssue"){echo 'selected';} ?>>발행일</option>
					</select>
					<input type="text" class="mousetrap" id="fromDate" name="fromDate" size="7"  autocomplete="off" maxlength="10" onkeyup="onlyNumHipen(this)" onkeypress="auto_datetime_format(event, this);" onmouseover="genDatepicker(this);" value="<?php if(isset($fromDate)){echo $fromDate;}; ?>">
					<input type="button" name="" class="dateBtn" onclick="dateBtn('fromDate');" value=" "> ~
					<input type="text" class="mousetrap" id="toDate" name="toDate"  autocomplete="off" size="7" maxlength="10" onkeyup="onlyNumHipen(this)" onkeypress="auto_datetime_format(event, this);" onmouseover="genDatepicker(this);" value="<?php if(isset($toDate)){echo $toDate;}; ?>">
					<input type="button" name="" class="dateBtn" onclick="dateBtn('toDate');" value=" ">
					<select name="search1" id="search1" >
						<option value="type" <?php if(isset($search1) && $search1=='type'){echo 'selected';} ?>>대구분</option>
						<option value="customer" <?php if(isset($search1) && $search1=='customer'){echo 'selected';} ?>>거래처</option>
						<option value="endUser" <?php if(isset($search1) && $search1=='endUser'){echo 'selected';} ?>>END-USER</option>
						<option value="bankType" <?php if(isset($search1) && $search1=='bankType'){echo 'selected';} ?>>은행구분</option>
						<option value="breakdown" <?php if(isset($search1) && $search1=='breakdown'){echo 'selected';} ?>>내역</option>
					</select>
					<input type="text" class="mousetrap" id="keyword1" name="keyword1" value="<?php if(isset($keyword1)){echo $keyword1;}; ?>" size="8">
					<select name="search2" id="search2" name="search2">
						<option value="customer" <?php if(isset($search2) && $search2=='customer'){echo 'selected';} ?>>거래처</option>
						<option value="type" <?php if(isset($search2) && $search2=='type'){echo 'selected';} ?>>대구분</option>
						<option value="endUser" <?php if(isset($search2) && $search2=='endUser'){echo 'selected';} ?>>END-USER</option>
						<option value="bankType" <?php if(isset($search2) && $search2=='bankType'){echo 'selected';} ?>>은행구분</option>
						<option value="breakdown" <?php if(isset($search2) && $search2=='breakdown'){echo 'selected';} ?>>내역</option>
					</select>
					<input type="text" class="mousetrap" id="keyword2" name="keyword2" value="<?php if(isset($keyword2)){echo $keyword2;}; ?>" size="8">
					<select name="search3" id="search3" name="search3">
						<option value="endUser" <?php if(isset($search3) && $search3=='endUser'){echo 'selected';} ?>>END-USER</option>
						<option value="type" <?php if(isset($search3) && $search3=='type'){echo 'selected';} ?>>대구분</option>
						<option value="customer" <?php if(isset($search3) && $search3=='customer'){echo 'selected';} ?>>거래처</option>
						<option value="bankType" <?php if(isset($search3) && $search3=='bankType'){echo 'selected';} ?>>은행구분</option>
						<option value="breakdown" <?php if(isset($search3) && $search3=='breakdown'){echo 'selected';} ?>>내역</option>
					</select>
					<input type="text" class="mousetrap" id="keyword3" name="keyword3" value="<?php if(isset($keyword3)){echo $keyword3;}; ?>" size="8">
					<input class="btn-primary" type="submit" name="submit" onclick="list_search('search');" value="검색">
					<input class="btn-primary" type="submit" style="<?php if($segment2=="fundreporting_list"){echo 'display:none';} ?>" onclick="list_search('reset');" value="초기화">
				</form>
				<!-- <div style="<?php if($segment2=="fundreporting_list"){echo 'display:none;';} ?> margin-top:10px" class=""> -->
					<!-- <select name="modify_col" id="modify_col" > -->
						<!-- <option value="type">대구분</option>
						<option value="bankType">은행구분</option> -->
						<!-- <option value="customer">거래처</option> -->
						<!-- <option value="endUser">END-USER</option> -->
						<!-- <option value="breakdown">내역</option> -->
					<!-- </select> -->
					<!-- <input type="text" id="modify_before" name="" value="" size="8" placeholder="변경 전"> -->
					<!-- <span><img style="width:10px; height:10px;" src="/misc/img/righarrow_87553.png"></img></span> -->
					<!-- <input type="text" id="modify_after" name="" value="" size="8" > -->
					<!-- <input class="btn-primary" type="button" onclick="search_modify();" value="일괄수정"> -->
				<!-- </div> -->
				<div style="<?php if($segment2=="fundreporting_list"){echo 'display:none;';} ?> margin-top:10px" class="">
					<select name="modify_col" id="modify_col" onchange="search_modify_select(this);">
						<option value="" selected disabled hidden>선택하세요</option>
						<option value="dueDate">확정일</option>
						<option value="customer">거래처</option>
						<option value="endUser">END-USER</option>
						<option value="breakdown">내역</option>
					</select>
					<input type="text" id="modify_before" name="" value="" size="8" placeholder="변경 전">
					<span><img style="width:10px; height:10px;" src="/misc/img/righarrow_87553.png"></img></span>
					<input type="text" id="modify_after" name="" value="" size="8" placeholder="변경 후">
					<input class="btn-primary" type="button" onclick="search_modify();" value="선택 바꾸기">
				</div>
				<script type="text/javascript">
					function list_search(search){
						if(search=='reset'){
							var segment = 'fundreporting_list';
						} else {
							var segment = 'search';
						}
						var act = "<?php echo site_url();?>/fundreporting/"+segment+"<?php echo $company ?>";
						$("#fundSearch").attr('action', act).submit();
					}
				</script>
<?php
	isset($total_rows)?$total_rows:$total_rows = "";
	isset($sumDeposit)?$sumDeposit:$sumDeposit = "";
	isset($sumWithdraw)?$sumWithdraw:$sumWithdraw = "";
	isset($nsDeposit)?$nsDeposit:$nsDeposit = "";
	isset($nsWithdraw)?$nsWithdraw:$nsWithdraw = "";
?>
				<div id="searchResult" <?php if ($this->uri->segment(2, 0)!='search'){echo 'style="display: none;"';} ?>>
<?php
	if($total_rows == 0){
 ?>
					<div>
						<h5 style ="color: black;">검색결과가 없습니다.</h5>
					</div>
<?php
	} else {
 ?>
					<h5 style ="color: black;">검색건수 : <?php echo number_format($total_rows); ?>건 /    입금총액 : <?php echo  number_format($sumDeposit); ?>원 /  출금총액 : <?php echo  number_format($sumWithdraw); ?>원 / 미지급입금총액 : <?php echo  number_format($nsDeposit); ?>원 / 미지급출금총액 : <?php echo  number_format($nsWithdraw); ?>원</h5>
<?php
	};
 ?>
				</div>
			</div>
			<!-- 버튼 끝 -->

			<!-- 일괄수정 모달 -->
			<!-- <div id='modify_pop' style="display : none; background-color: white;">
        <h3 style="text-align:center;">일괄 수정</h3>
        <div class="well">
          <div class="row">
						<input type="text" name="" value="">
						<input type="text" name="" value="">
          	<button style="float:right" type="button" class="btn" name="button" onclick="search_modify_save();">수정</button>

          </div>
        </div>
      </div> -->
			<!-- 일괄수정 모달 끝 -->

			<!-- 거래 내역 테이블 -->
			<div class="table-container" id="accountlist-container" style="width: 100%;<?php if($pGroupName=='영업본부'){echo 'display:none';} ?>">
				<div class="table-box" id="table-box">
					<table id = "accountlist" class="accountlist" style="width: 100%; height:100%">
						<colgroup>
							<col style="width:1%">
							<col style="width:5%">
							<col style="width:5%">
							<col style="width:5%">
							<col style="width:5.3%">
							<col style="width:5.4%">
							<col style="width:10.7%">
							<col style="width:10.7%">
							<col style="width:21.9%">
							<col style="width:6%">
							<col style="width:6%">
							<col style="width:6%">
							<col style="width:6%">
							<col style="width:6%;">
							<col>
						</colgroup>
						<thead>
							<tr class="fixed_top">
								<th class="cell0" scope="colgroup"><input type="checkbox" id="allCheck" onchange="allCheck(this);"/></th>
								<th class="cell1" scope="colgroup" >
									<a href="<?php echo $baseUrl.'/'.$segment1.'/';echo 'fundreporting_list'.$company; ?>">발행일</a>
								</th>
								<th class="cell2" scope="colgroup">예정일</th>
 								<th class="cell3" scope="colgroup" style="<?php if($segment2=='fundreporting_list'){echo 'background:#90EE90;';} ?>">
									<a style="display: block;" href="<?php echo $baseUrl.'/'.$segment1.'/';if($segment2!='sort'){echo 'sort';}else {echo 'fundreporting_list';} echo $company; ?>">확정일</a>
								</th>
								<th class="cell4" scope="colgroup">대구분</th>
								<th class="cell5" scope="colgroup">은행구분</th>
								<th class="cell6" scope="colgroup">거래처</th>
 								<th class="cell7" scope="colgroup" style="<?php if($segment2=='enduser'){echo 'background:#90EE90;';} ?>">
									<a href="<?php echo $baseUrl.'/'.$segment1.'/';if($segment2!='enduser'){echo 'enduser';}else {echo 'fundreporting_list';} echo $company; ?>">END-USER</a>
								</th>
								<th class="cell8" scope="colgroup">내역</th>
								<th class="cell9" scope="colgroup">청구금액</th>
								<th class="cell10" scope="colgroup">입금</th>
								<th class="cell11" scope="colgroup">출금</th>
								<th class="cell12" scope="colgroup">잔액</th>
								<th class="cell13" scope="colgroup">가용금액</th>
								<th><th>
							</tr>
						</thead>
						<tbody id="AddOption">
<?php
	if ($pagingBalance==0) {
		$balance = 0;
	} else {
		$balance = $pagingBalance[0]->pagingBalance;
	}
 ?>
							<input type="hidden" id="saveBalance" value="<?php echo $balance ?>">
<?php
	foreach (array_reverse($list) as $key => $val) {
		$today = date("Y-m-d");
		$diff_60day = false;
		$bankTypeIsNull = false;
		$color = '';

		$dateOfIssue = date($val->dateOfIssue);
		if (strtotime($dateOfIssue) < strtotime($today)){
			$diff = abs(strtotime($dateOfIssue) - strtotime($today))/60/60/24;
			if ($diff > 60){
				$diff_60day = true;
			}
		}
		if ($val->bankType == '') {
			$bankTypeIsNull = true;
		}
		if ($diff_60day && $bankTypeIsNull && $val->type=='매입채무'){
			$color = "color:blue";
		}
		if ($diff_60day && $bankTypeIsNull && $val->type=='매출채권'){
			$color = "color:red";
		}

		$balance = $balance - $val->withdraw + $val->deposit;
		$bankType = $val->bankType;
		$deposit = number_format($val->deposit);
		$withdraw = number_format($val->withdraw);
		$balance = number_format($balance);
		$requisition = number_format($val->requisition);
		if ($deposit == 0) {
			$deposit = '';
		}
		if ($withdraw == 0) {
			$withdraw = '';
		}
		if ($requisition == 0) {
			$requisition = '';
		}
 ?>
							<tr class="row_accountlist" name="<?php echo $key ?>">
								<input type="hidden" id="idx" value="<?php echo $val->idx ?>" />
								<td class="cell0" scope="row">
									<input type="checkbox" class="delRow" name="delRow" id="rowCheck" onchange="delRowCheck(this);"/>
								</td>
								<td class="cell1" scope="row">
									<input type="text" class="input mousetrap" style="width:100%; text-align:left; <?php echo $color; ?>" id="dateOfIssue" name="dateOfIssue" value="<?php echo $val->dateOfIssue?>" maxlength="10" onchange="plusDate(this); modifyInput(this);" onkeyup="onlyNumHipen(this)" onkeypress="auto_datetime_format(event, this);" onmouseover="genDatepicker(this);"/>
								</td>
								<td class="cell2" scope="row">
									<input class="input mousetrap" style="width:100%; text-align:left; <?php echo $color; ?>" type="text" id="fixedDate" name="fixedDate" value="<?php echo $val->fixedDate?>" maxlength="10" onchange="modifyInput(this);" onkeyup="onlyNumHipen(this)" onkeypress="auto_datetime_format(event, this);" onmouseover="genDatepicker(this);" />
								</td>
								<td class="cell3" scope="row">
									<input class="input mousetrap" style="width:100%; text-align:left; <?php echo $color; ?>" type="text" id="dueDate" name="dueDate" value="<?php echo $val->dueDate?>" maxlength="10" onchange="modifyInput(this);"  onkeyup="onlyNumHipen(this)" onkeypress="auto_datetime_format(event, this);" onmouseover="genDatepicker(this);" />
								</td>
								<td class="cell4" scope="row">
									<select id="type" name="type" style="height:100%; width:100%; text-align:left; border:none; <?php echo $color; ?>" onchange="modifyInput(this);">
										<option value="" <?php if($val->type==null){ echo 'selected'; } ?>>&nbsp;</option>
										<option value="매입채무" <?php if($val->type=='매입채무'){ echo 'selected'; } ?>>매입채무</option>
										<option value="매출채권" <?php if($val->type=='매출채권'){ echo 'selected'; } ?>>매출채권</option>
										<option value="운영비용" <?php if($val->type=='운영비용'){ echo 'selected'; } ?>>운영비용</option>
									</select>
								</td>
								<td class="cell5" scope="row">
									<select id="bankType" name="bankType" style="height:100%; width:100%; text-align:left; border:none; <?php echo $color; ?>" onchange="modifyInput(this);" onmouseover="select2Mouseover(this);">
										<option value="" <?php if($val->bankType){ echo 'selected'; } ?>>&nbsp;</option>
<?php
	foreach ($selectBankTypeList as $option) {
		echo '<option value="'.$option->banktype.'" ';
		if ($val->bankType==$option->banktype) {
			echo 'selected';
		}
		echo '>'.$option->banktype.'</option>';
	}
 ?>
									</select>
								</td>
								<td class="cell6" scope="row">
									<input class="input mousetrap" style="width:100%; text-align:left; <?php echo $color; ?>" type="text" id="customer" name="customer"	value="<?php echo $val->customer?>" title="<?php echo $val->customer?>" onchange="modifyInput(this);"/>
								</td>
								<td class="cell7" scope="row">
									<input class="input mousetrap" style="width:100%; text-align:left; <?php echo $color; ?>" type="text" id="endUser" name="endUser" value="<?php echo $val->endUser?>" title="<?php echo $val->endUser?>" onchange="modifyInput(this);"/>
								</td>
								<td class="cell8" scope="row">
									<input class="input mousetrap" style="width:100%; text-align:left; <?php echo $color; ?>" type="text" id="breakdown" name="breakdown" value="<?php echo $val->breakdown?>" title="<?php echo $val->breakdown?>" onchange="modifyInput(this);"/>
								</td>
								<td class="cell9" scope="row">
									<input class="input mousetrap" style="width:70%; text-align:right; <?php echo $color; ?>" type="text" id="requisition" name="requisition" value="<?php echo $requisition?>" title="<?php echo $requisition?>" onchange="modifyInput(this);" onFocus="deCommaStr(this);" onBlur="this.value = commaStr(this.value);" onkeyup="onlyNumber(this);" />
								</td>
								<td class="cell10" scope="row">
									<input class="input mousetrap" style="width:70%; text-align:right; <?php echo $color; ?>" type="text" id="deposit" name="deposit" class="deposit" value="<?php echo $deposit?>" title="<?php echo $deposit?>" onchange="calcBalance(); modifyInput(this);" onFocus="deCommaStr(this);" onBlur="this.value = commaStr(this.value);" onkeyup="onlyNumber(this);" />
								</td>
								<td class="cell11" scope="row">
									<input class="input mousetrap" style="width:70%; text-align:right; <?php echo $color; ?>" type="text" id="withdraw" name="withdraw" class="withdraw" value="<?php echo $withdraw?>" title="<?php echo $withdraw?>" onchange="calcBalance(); modifyInput(this);" onFocus="deCommaStr(this);" onBlur="this.value = commaStr(this.value);" onkeyup="onlyNumber(this);"/>
								</td>
								<td class="cell12" scope="row">
									<input class="input mousetrap" style="width:70%; text-align:right; <?php echo $color; ?>" type="text" id="balance" name="balance" class="balance" value="<?php echo $balance?>" title="<?php echo $balance?>" onFocus="deCommaStr(this);" onBlur="this.value = commaStr(this.value);" readonly/>
								</td>
								<td class="cell13" scope="row">
									<input class="input mousetrap" style="width:70%; text-align:right; <?php echo $color; ?>" type="text" id="balance2" name="balance2" class="balance2" value="<?php echo $balance?>" title="<?php echo $balance?>" onFocus="deCommaStr(this);" onBlur="this.value = commaStr(this.value);" readonly/>
								</td>
							</tr>
<?php
	$deposit = filter_var($deposit, 519);
	$withdraw = filter_var($withdraw, 519);
	$balance = filter_var($balance, 519);
	$requisition = filter_var($requisition, 519);
	}
 ?>
						</tbody>
					</table>
				</div>
			</div>

			<!-- 엑셀 export, 영업본부 조회 용 테이블 -->
			<div class="table-container" id="excelExport-container" style="width:100%; <?php if($pGroupName!='영업본부'){echo 'display:none';} ?>">
				<div class="table-box" id="table-box">
					<table id="exportTable" class="exportTable" style="width:100%">
						<colgroup>
							<col style="width:5%">
							<col style="width:5%">
							<col style="width:5%">
							<col style="width:5.3%">
							<col style="width:5.4%">
							<col style="width:10.7%">
							<col style="width:10.7%">
							<col style="width:21.9%">
							<col style="width:6%">
							<col style="width:6%">
							<col style="width:6%">
							<col style="width:6%">
							<col style="width:6%;">
						</colgroup>
						<thead>
							<tr class="fixed_top">
								<th class="cell1" scope="colgroup">
									<a href="<?php echo $baseUrl.'/'.$segment1.'/';echo 'fundreporting_list'.$company; ?>">발행일</a>
								</th>
								<th class="cell2" scope="colgroup">예정일</th>
								<th class="cell3" scope="colgroup" style="<?php if($segment2=='sort'){echo 'background:#90EE90;';} ?>">
									<a href="<?php echo $baseUrl.'/'.$segment1.'/';if($segment2!='sort'){echo 'sort';}else {echo 'fundreporting_list';} echo $company; ?>">확정일</a>
								</th>
								<th class="cell4" scope="colgroup">대구분</th>
								<th class="cell5" scope="colgroup">은행구분</th>
								<th class="cell6" scope="colgroup">거래처</th>
								<th class="cell7" scope="colgroup" style="<?php if($segment2=='enduser'){echo 'background:#90EE90;';} ?>">
									<a href="<?php echo $baseUrl.'/'.$segment1.'/';if($segment2!='enduser'){echo 'enduser';}else {echo 'fundreporting_list';} echo $company; ?>">END-USER</a>
								</th>
 								<th class="cell8" scope="colgroup">내역</th>
								<th class="cell9" scope="colgroup">청구금액</th>
		            <th class="cell10" scope="colgroup">입금</th>
		            <th class="cell11" scope="colgroup">출금</th>
		            <th class="cell12" scope="colgroup">잔액</th>
		            <th class="cell13" scope="colgroup">가용금액</th>
							</tr>
						</thead>
						<tbody>
<?php
	if ($pagingBalance==0) {
		$balance = 0;
	} else {
		$balance = $pagingBalance[0]->pagingBalance;
	}
 ?>
							<input type="hidden" id="saveBalance" value="<?php echo $balance ?>">
<?php
	foreach ($list as $key => $val) {

		$balance = $balance - $val->withdraw + $val->deposit;
		$bankType = $val->bankType;
		$deposit = number_format($val->deposit);
		$withdraw = number_format($val->withdraw);
		$balance = number_format($balance);
		$requisition = number_format($val->requisition);
		if ($deposit == 0) {
			$deposit = '';
		}
		if ($withdraw == 0) {
			$withdraw = '';
		}
		if ($requisition == 0) {
			$requisition = '';
		}
?>
							<tr class="excelExport_row" name="<?php echo $key ?>">
								<td scope="row" class="cell1" style="text-align:left;"><?php echo $val->dateOfIssue?></td>
								<td scope="row" class="cell2" style="text-align:left;"><?php echo $val->fixedDate?></td>
								<td scope="row" class="cell3" style="text-align:left;"><?php echo $val->dueDate?></td>
								<td scope="row" class="cell4" style="text-align:left;"><?php echo $val->type ?></td>
								<td scope="row" class="cell5" style="text-align:left;"><?php echo $val->bankType ?></td>
								<td scope="row" class="cell6" style="text-align:left;"><?php echo $val->customer?></td>
								<td scope="row" class="cell7" style="text-align:left;"><?php echo $val->endUser?></td>
								<td scope="row" class="cell8" style="text-align:left;"><?php echo $val->breakdown?></td>
								<td scope="row" class="cell9" style="text-align:right;"><?php echo $requisition?></td>
								<td scope="row" class="cell10" style="text-align:right;"><?php echo $deposit?></td>
								<td scope="row" class="cell11" style="text-align:right;"><?php echo $withdraw?></td>
								<td scope="row" class="cell12" style="text-align:right;"><?php echo $balance?></td>
								<td scope="row" class="cell3" style="text-align:right;"><?php echo $balance?></td>
							</tr>
<?php
	$deposit = filter_var($deposit, 519);
	$withdraw = filter_var($withdraw, 519);
	$balance = filter_var($balance, 519);
	$requisition = filter_var($requisition, 519);
}
 ?>
						</tbody>
					</table>
				</div>
			</div>
			<!-- 엑셀 export용 테이블 끝 -->

			<div>
				<?php echo $pagination; ?>
			</div>
			<div id="bottom">
				<span id="sumSpan" style="align:right"></span>
				<input type="button" style="float:left;<?php if($pGroupName=='영업본부'){echo 'display:none';} ?>" onclick="newRow('add');" value="추가" />
				<input type="button" style="float:left;<?php if($pGroupName=='영업본부'){echo 'display:none';} ?>" onclick="newRow('paste');" value="한줄복사" />
				<input type='button' class='btn btn-inverse' value='excel 다운' onclick="fnExcelReport('exportTable');" style="float: right;"/>
			</div>
		</div>
    <!-- ********************** 본문 끝 ********************** -->
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
  <!--하단-->
</table>

<script type="text/javascript" src="/misc/js/fundReporting.js"></script>
</body>
</html>