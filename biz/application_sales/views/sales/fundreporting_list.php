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
/* .search_btn{
	 background-image: url('<?php echo $misc;?>img/dashboard/btn/btn_search.png');
	 background-repeat: no-repeat;
	 width:40px;
	 height:40px;
	 border: 0;
	 } */
	 @import url(//fonts.googleapis.com/earlyaccess/notosanskr.css);
	 body {
		 font-family:"Noto Sans KR", sans-serif !important;
	 }
	 /* .title_parent {
	  width: 100%;
		height: 100%;
	 } */
	 /* .title_child {
	  float: left;
	 } */
	 .title_parent h1 {
		 display: inline;
	 }
	 /* 계산서 이동 선택 */
	 .contextmenu {
		 display: none;
		 position: absolute;
		 min-width: 200px;
		 margin: 0;
		 padding: 0;
		 background: #FFFFFF;
		 border-radius: 5px;
		 list-style: none;
		 box-shadow:
			 0 15px 35px rgba(50,50,90,0.1),
			 0 5px 15px rgba(0,0,0,0.07);
		 overflow: hidden;
		 z-index: 999999;
 	}
 	.contextmenu li {
		 border-left: 3px solid transparent;
		 transition: ease .2s;
 	}
 	.contextmenu li a {
		 display: block;
		 padding: 10px;
		 color: #B0BEC5;
		 text-decoration: none;
		 transition: ease .2s;
 	}
 	.contextmenu li:hover {
		 background: #CE93D8;
		 border-left: 3px solid #9C27B0;
 	}
 	.contextmenu li:hover a {
	 color: #FFFFFF;
 	}
 	/* #bottom{
	 position: fixed;
	 right: 100px;
 	} */

	.paging strong {
    color:#0575E6;
	}
  </style>
	<link rel="stylesheet" href="/misc/css/view_page_common.css">
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
<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>

<div align="center" style="margin-top:20px">
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
<?php if(strpos($_SERVER['REQUEST_URI'],'/fundreporting_list') !== false) {?>
	var firstPage = parseInt(<?php echo $firstPage-1; ?>/100)*100;

	if (window.location.pathname == "/index.php/sales/fundreporting/fundreporting_list" && firstPage > 0){
		location.href="/index.php/sales/fundreporting/fundreporting_list/page/"+firstPage+"?company=" + getParam("company")+"&old_new=<?php echo $old_new; ?>";
		}
<?php } ?>
</script>
<?php
	$week = array("일", "월", "화", "수", "목", "금", "토");
	if (!isset($day)){
		$day = date("Y-m-d");
	}
	$s = $week[date("w",strtotime($day))];
	switch ($company) {
		case 'DUIT':
			$companyName = '두리안정보기술';
			break;
		case 'DUITOLD':
			$companyName = '두리안정보기술(구)';
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
		case 'DK':
			$companyName = '던킨';
			break;
	}
	if($company == 'DUIT') {
		$company = '?company='.$company.'&old_new='.$old_new;
	} else {
		$company = '?company='.$company;
	}

	$baseUrl = site_url();
	$segment1 = $this->uri->segment(2);
	$segment2 = $this->uri->segment(3, 0);
	$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>
<!-- 본문 div -->
		<div class="content" style="margin-left:10px; margin-right:20px;margin-top:70px;">
			<div style="display:none">
				<input type="hidden" id="userId" value="<?php echo $id; ?>">
			</div>
			<div class="top-header" style="height:60px;">
				<div>
					<div class="title_parent" style="position:absolute">
						<h1 style="font-weight:5000;font-size:2.5em;text-align:left;" class="title_child"><?php echo $companyName?></h1>
						<h1 style="font-weight:300;font-size:2.5em" class="title_child">&nbsp;자금보고서&nbsp;&nbsp;</h1>
						<a style='cursor:pointer; color:#0575E6;;margin-top:25px;font-size:15px' id='bankbook_day' onclick='searchBankBook();' class="title_child"><?php echo '('.date("Y년 n월 j일 $s\요일",strtotime($day)).')'; ?></a>
						<h3 style="color:#a9abac;font-weight: normal;text-align:left;" class="title_child">자금 입출금 현황 및 SCHEDULE</h3>
					</div>
				</div>
				<div>
					<button type="button" name="modalBtn" id="modalBtn" class="btn-common btn-style4" style="float:right; cursor:pointer;<?php if($pGroupName=='영업본부' || $_GET['company']=='DUITOLD'){echo 'display:none';} ?>" onclick="modalOpen();">은행관리</button>
				</div>
				<div>
					<input type="button" class="btn-common btn-color2" onclick="fold_bankbook(this);" style="float:right;margin-right:10px;" value="잔고현황 ▼" />
				</div>
			</div>


			<!-- 날짜 검색 팝업창 시작 -->
			<!-- 팝업뜰때 배경 -->
			<div id="search_bankBook" class="search_bankBook" role="dialog" tabindex="-1" aria-hidden="true" data-backdrop="static" data-keyboard="false" style="margin-top:30px; display:none;">
				<form class="" action="<?php echo $actual_link; ?>" method="post">
					<table >
						<tr>
							<td><input type="date" id="searchday" name="searchday" value="" autocomplete="off"></td>
							<td><input type="submit" name="" value="검색"></td>
							<td><span style="float:right; cursor: pointer;" onclick="searchBankBook_close();"><img class="manImg" src="/misc/img/btn_del2.jpg"></img></span></td>

						</tr>
					</table>
				</form>
			</div>
			<!-- 날짜 검색 팝업창 끝 -->

<!-- 은행 정보 -->
			<div id="fold_bankbook" class="bankBook-container" style="width:95%;display:none;">
				<table class="bankbook" style="width:100%;margin-top:40px;" border="0" cellspacing="0" cellpadding="0">
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
            <tr class="bankBook_top row-color1">
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
					echo '<td scope="row" name="accountType" style="text-align:left;">'.$val->type.'</td>';
					echo '<td scope="row" name="bank" style="text-align:left;">'.$val->bank.'</td>';
					echo '<td scope="row" name="bankType" style="text-align:left;">'.$val->banktype.'</td>';
					echo '<td scope="row" name="account" style="text-align:left;">'.$val->account.'</td>';
					echo '<td scope="row" name="breakdown" style="text-align:left;">'.$val->breakdown.'</td>';
					echo '<td scope="row" name="yesbalance" style="text-align:right;">'.number_format($val->yesbalance).'</td>';
					echo '<td scope="row" name="todaydeposit" style="text-align:right;">'.number_format($val->todaydeposit).'</td>';
					echo '<td scope="row" name="todaywithdraw" style="text-align:right;">'.number_format($val->todaywithdraw).'</td>';
					echo '<td scope="row" name="balance" class="bank-balance" style="text-align:right; font-weight:bold;">'.number_format($val->balance).'</td>';
					echo '<td scope="row" name="balance2" class="bank-balance2" style="text-align:right;">'.number_format($val->balance).'</td>';
					echo '</tr>';
				}
			}
?>
					</tbody>
					<tbody>
						<tr style="background-color:#FFFFF2;">
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
					echo '<td scope="row" name="accountType" style="text-align:left;">'.$val->type.'</td>';
					echo '<td scope="row" name="bank" style="text-align:left;">'.$val->bank.'</td>';
					echo '<td scope="row" name="bankType" style="text-align:left;">'.$val->banktype.'</td>';
					echo '<td scope="row" name="account" style="text-align:left;">'.$val->account.'</td>';
					echo '<td scope="row" name="breakdown" style="text-align:left;">'.$val->breakdown.'</td>';
					echo '<td scope="row" name="yesbalance" style="text-align:right;">'.number_format($val->yesbalance).'</td>';
					echo '<td scope="row" name="todaydeposit" style="text-align:right;">'.number_format($val->todaydeposit).'</td>';
					echo '<td scope="row" name="todaywithdraw" style="text-align:right;">'.number_format($val->todaywithdraw).'</td>';
					echo '<td scope="row" name="balance" class="bank-balance" style="text-align:right; font-weight:bold;">'.number_format($val->balance).'</td>';
					echo '<td scope="row" name="balance2" class="bank-balance2" style="text-align:right;">'.number_format($val->balance).'</td>';
					echo '</tr>';
				}
			}
?>
					</tbody>
<?php foreach ($bankBook as $val) { ?>
					<tbody id="deposit_bank">
<?php 	if ($val->type == '보증금') {
					echo '<tr class="deposit_bank_list">';
					echo '<td scope="row" name="accountType" style="text-align:left;">'.$val->type.'</td>';
					echo '<td scope="row" name="bank" style="text-align:left;">'.$val->bank.'</td>';
					echo '<td scope="row" name="bankType" style="text-align:left;">'.$val->banktype.'</td>';
					echo '<td scope="row" name="account" style="text-align:left;">'.$val->account.'</td>';
					echo '<td scope="row" name="breakdown" style="text-align:left;">'.$val->breakdown.'</td>';
					echo '<td scope="row" name="yesbalance" style="text-align:right;">'.number_format($val->yesbalance).'</td>';
					echo '<td scope="row" name="todaydeposit" style="text-align:right;">'.number_format($val->todaydeposit).'</td>';
					echo '<td scope="row" name="todaywithdraw" style="text-align:right;">'.number_format($val->todaywithdraw).'</td>';
					echo '<td scope="row" name="balance" class="bank-balance" style="text-align:right; font-weight:bold;">'.number_format($val->balance).'</td>';
					echo '<td scope="row" name="balance2" class="bank-balance2" style="text-align:right;">'.number_format($val->balance).'</td>';
					echo '</tr>';
				}
			}
?>
					</tbody>
<?php foreach ($bankBook as $val) { ?>
					<tbody id="loan_bank">
<?php 	if ($val->type == '대출금') {
					echo '<tr class="loan_bank_list">';
					echo '<td scope="row" name="accountType" style="text-align:left;">'.$val->type.'</td>';
					echo '<td scope="row" name="bank" style="text-align:left;">'.$val->bank.'</td>';
					echo '<td scope="row" name="bankType" style="text-align:left;">'.$val->banktype.'</td>';
					echo '<td scope="row" name="account" style="text-align:left;">'.$val->account.'</td>';
					echo '<td scope="row" name="breakdown" style="text-align:left;">'.$val->breakdown.'</td>';
					echo '<td scope="row" name="yesbalance" style="text-align:right;">'.number_format($val->yesbalance).'</td>';
					echo '<td scope="row" name="todaydeposit" style="text-align:right;">'.number_format($val->todaydeposit).'</td>';
					echo '<td scope="row" name="todaywithdraw" style="text-align:right;">'.number_format($val->todaywithdraw).'</td>';
					echo '<td scope="row" name="balance" class="bank-balance" style="text-align:right; font-weight:bold;">'.number_format($val->balance).'</td>';
					echo '<td scope="row" name="balance2" class="bank-balance2" style="text-align:right;">'.number_format($val->balance).'</td>';
					echo '</tr>';
				}
			}
?>
					</tbody>
<?php foreach ($bankBook as $val) { ?>
					<tbody id="loan_bank">
<?php 	if ($val->type == '투자금') {
					echo '<tr class="loan_bank_list">';
					echo '<td scope="row" name="accountType" style="text-align:left;">'.$val->type.'</td>';
					echo '<td scope="row" name="bank" style="text-align:left;">'.$val->bank.'</td>';
					echo '<td scope="row" name="bankType" style="text-align:left;">'.$val->banktype.'</td>';
					echo '<td scope="row" name="account" style="text-align:left;">'.$val->account.'</td>';
					echo '<td scope="row" name="breakdown" style="text-align:left;">'.$val->breakdown.'</td>';
					echo '<td scope="row" name="yesbalance" style="text-align:right;">'.number_format($val->yesbalance).'</td>';
					echo '<td scope="row" name="todaydeposit" style="text-align:right;">'.number_format($val->todaydeposit).'</td>';
					echo '<td scope="row" name="todaywithdraw" style="text-align:right;">'.number_format($val->todaywithdraw).'</td>';
					echo '<td scope="row" name="balance" class="bank-balance" style="text-align:right; font-weight:bold;">'.number_format($val->balance).'</td>';
					echo '<td scope="row" name="balance2" class="bank-balance2" style="text-align:right;">'.number_format($val->balance).'</td>';
					echo '</tr>';
				}
			}
?>
					</tbody>
<?php foreach ($bankBook as $val) { ?>
					<tbody id="loan_bank">
<?php 	if ($val->type == '자산(건물)') {
					echo '<tr class="loan_bank_list">';
					echo '<td scope="row" name="accountType" style="text-align:left;">'.$val->type.'</td>';
					echo '<td scope="row" name="bank" style="text-align:left;">'.$val->bank.'</td>';
					echo '<td scope="row" name="bankType" style="text-align:left;">'.$val->banktype.'</td>';
					echo '<td scope="row" name="account" style="text-align:left;">'.$val->account.'</td>';
					echo '<td scope="row" name="breakdown" style="text-align:left;">'.$val->breakdown.'</td>';
					echo '<td scope="row" name="yesbalance" style="text-align:right;">'.number_format($val->yesbalance).'</td>';
					echo '<td scope="row" name="todaydeposit" style="text-align:right;">'.number_format($val->todaydeposit).'</td>';
					echo '<td scope="row" name="todaywithdraw" style="text-align:right;">'.number_format($val->todaywithdraw).'</td>';
					echo '<td scope="row" name="balance" class="bank-balance" style="text-align:right; font-weight:bold;">'.number_format($val->balance).'</td>';
					echo '<td scope="row" name="balance2" class="bank-balance2" style="text-align:right;">'.number_format($val->balance).'</td>';
					echo '</tr>';
				}
			}
?>
					</tbody>
					<tbody>
						<tr style="background-color:#FFFFF2;">
							<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
							<td style="text-align:center; font-weight:bold;">소&nbsp;&nbsp;&nbsp;계</td>
							<td style="text-align:right; font-weight:bold; text-align:right;"><?php echo number_format($sum_not_botong) ?></td>
							<td></td>
						</tr>
					</tbody>
					<tbody id="bankbook_total_sum">
						<tr style="background-color:#F2FCFF;">
							<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
							<td style="text-align:center; font-weight:bold;<?php if($sum_botong != $sum_list_banktype){echo 'color:red;';}else{echo 'color:#007BCB;';} ?>">합&nbsp;&nbsp;&nbsp;계</td>
							<td style="text-align:right; font-weight:bold; text-align:right;color:#007BCB"><?php echo number_format($sum_botong+$sum_not_botong) ?></td>
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
							<td style="background:yellow; text-align:center; background-color:#FFEDED; color:#E53737; font-weight:bold;">매 출 채 권</td>
							<td scope="row" name="bond" style="text-align:right; font-weight:bold;background-color:#FFEDED; color:#E53737;"><?php echo number_format($bond[0]->bond + $bond_adjust['bond_adjust']); ?></td>
							<td style="background:yellow; text-align:center; background-color:#F2FCFF; color:#007BCB; font-weight:bold;">매 입 채 무</td>
							<td scope="row" name="debt" style="text-align:right; font-weight:bold;background-color:#F2FCFF; color:#007BCB;"><?php echo number_format($debt[0]->debt + $debt_adjust['debt_adjust']) ?></td>
						</tr>
					</tbody>
				</table>
			</div>


			<div id="bankModal" class="bankModal" role="dialog" tabindex="-1" aria-hidden="true" data-backdrop="static" data-keyboard="false" style="margin-top:30px;<?php if($pGroupName=='영업본부'){echo 'display:none';} ?>">
				<!-- <span style="float:right; cursor: pointer;" onclick="modalClose();">
					<img class="manImg" src="/misc/img/dashboard/btn/icon_x.svg"></img>
				</span> -->
				<div class="modal-dialog modal-lg" data-backdrop="static" data-keyboard="false">

					<div class="modal-contents" data-backdrop="static" data-keyboard="false">
						<div class="modal-header">
							<h2 align="left">은행 입력</h2>
						</div>
						<div class="modal-body">
							<table style="margin:0px; border-collapse: collapse;" name="modal_insert">
								<thead style="align:middle;">
									<tr style="margin:0px;" class="modal_insert_col">
										<th scope="colgroup" style="width:10%; background-color: #F4F4F4;"><strong>예금종류</strong></th>
										<th scope="colgroup"  style="width:10%; background-color: #F4F4F4;"><strong>은행</strong></th>
										<th scope="colgroup" style="width:10%; background-color: #F4F4F4;"><strong>은행구분</strong></th>
										<th scope="colgroup" style="width:14%; background-color: #F4F4F4;"><strong>계좌번호</strong><br><font size="1px">('-'기호 포함)</font></th>
										<th scope="colgroup" style="width:40%; background-color: #F4F4F4;"><strong>내역</strong></th>
										<th scope="colgroup" style="width:11%; background-color: #F4F4F4;"><strong>금액</strong></th>
										<th scope="colgroup" style="width:7%; background-color: #F4F4F4;"></th>
									</tr>
								</thead>
								<tbody style="align:middle;" id="insertTbody">
									<tr id="modal_insert_row">
										<td scope="row">
											<select id="insertType" name="insertType" class="select-common select-style1" style="width:100%; border:solid 1px black;" onchange="insertType(this);">
												<option value="" selected disabled hidden>선택하세요</option>
												<option value="보통예금">보통예금</option>
												<option value="예적금">예적금</option>
												<option value="보증금">보증금</option>
												<option value="대출금">대출금</option>
												<option value="투자금">투자금</option>
												<option value="자산(건물)">자산(건물)</option>
											</select>
										</td>
										<td scope="row">
											<select id="insertBank" name="insertBank" class="select-common select-style1" style="width:100%; border:solid 1px black;" onchange="selboxDirect(this);">
												<option value=""></option>
												<option value="직접입력">직접입력</option>
<?php
	foreach ($bankList as $val){
		echo "<option value=".$val->bank.">".$val->bank."</option>";
	}
 ?>
												<option value="" selected disabled hidden>선택하세요</option>
											</select>
											<input style="width:93%; border:solid 1px black; display:none;" type="text" class="selboxDirect input-common" value="" onchange="insBankDirect(this);">
										</td>
										<td scope="row"><input class="input-common" style="width:95%; border:solid 1px black;" type="text" name="insertBankType" id="insertBankType"></td>
										<td scope="row"><input class="input-common" style="width:97%; border:solid 1px black;" type="text" name="insertAccount" id="insertAccount" onkeyup="onlyNumHipen(this)"></td>
										<td scope="row"><input class="input-common" style="width:97%; border:solid 1px black;" type="text" name="insertBreakdown" id="insertBreakdown"></td>
										<td scope="row"><input class="input-common" style="width:95%; border:solid 1px black;" type="text" name="insertBalance" id='insertBalance'
												onFocus="deCommaStr(this);" onBlur="this.value = commaStr(this.value);" onkeyup="onlyNumber(this)"></td>
										<td><button type="button" style="width:60px;" data-dismiss="modal" name="modalSaveBtn" onclick="insertBank();" class="btn-common btn-style2">저장</button></td>
									</tr>
								</tbody>
							</table><br>

							<strong><a href="javascript:void(0);" id="selectTableBtn" align="center" onclick="fold_modal(this)">보통예금▼</a></strong>
							<div class="modal_select_div" style="display:none;">
								<div class="modal_select_box">
									<table style="margin:10px,20px;" id="selectTable" name="selectTable">
										<thead>
											<tr class="fixed_top">
												<th scope="colgroup" style="width:10%; background-color: #F4F4F4;"><strong>예금종류</strong></th>
												<th scope="colgroup" style="width:10%; background-color: #F4F4F4;"><strong>은행</strong></th>
												<th scope="colgroup" style="width:10%; background-color: #F4F4F4;"><strong>은행구분</strong></th>
												<th scope="colgroup" style="width:14%; background-color: #F4F4F4;"><strong>계좌번호</strong></th>
												<th scope="colgroup" style="width:41%; background-color: #F4F4F4;"><strong>내역</strong></th>
												<th scope="colgroup" style="width:12%; background-color: #F4F4F4;"><strong>금액</strong></th>
												<th scope="colgroup" style="width:5%; background-color: #F4F4F4;"></th>
											</tr>
										</thead>
										<tbody>
<?php
	foreach($selectBanklist as $val){
		if($val->type == "보통예금") {
			echo '<tr class="modal_select_row" id="modal_select_row" name="'.$val->idx.'">';
			// echo '<input type="hidden" style="color:red" id="idx'.$val->idx.'" value="'.$val->idx.'">';
			echo '<td style="width:10%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<select class="input select-common select-style1" id="selectType" name="selectType" style="width:100%; border:solid 1px black;" onchange="modifyModalInput(this);">';
			echo '<option value="보통예금" selected="">보통예금</option>';
			echo '<option value="보증금">보증금</option>';
			echo '<option value="예적금">예적금</option>';
			echo '<option value="대출금">대출금</option>';
			echo '<option value="투자금">투자금</option><option value="자산(건물)">자산(건물)</option></select></td>';
			echo '<td style="width:10%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<select class="input select-common select-style1" id="selectBank" name="selectBank" style="width:100%; border:solid 1px black;" onchange="selboxDirect(this); modifyModalInput(this);">';
			echo '<option value="직접입력">직접입력</option>';
			echo '<option value=""></option>';
			echo '<option value="'.$val->bank.'" selected="">'.$val->bank.'</option>';
			foreach($bankList as $option){
				if($option->bank != $val->bank){
					echo '<option value="'.$option->bank.'">'.$option->bank.'</option>';
				}
			}
			echo '</select>';
			echo '<input type="text" class="selboxDirect input2" style="display:none; width:90%;" scope="row"></td>';
			echo '<td style="width:10%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<input class="input" style="width:90%; text-align:left;" type="text" id="selectBankType" name="selectBankType" value="'.$val->banktype.'" onchange="modifyModalInput(this);"></td>';
			echo '<td style="width:20%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<input class="input" style="width:95%; text-align:left;" type="text" id="selectAccount" name="selectAccount" value="'.$val->account.'" onchange="modifyModalInput(this);" onkeyup="onlyNumHipen(this)"></td>';
			echo '<td style="width:25%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<input class="input" style="width:95%; text-align:left;" type="text" id="selectBreakdown" name="selectBreakdown" value="'.$val->breakdown.'" onchange="modifyModalInput(this);"></td>';
			echo '<td style="width:20%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<input class="input" style="width:95%; text-align:right;" type="text" id="selectBalance" name="selectBalance" value="'.number_format($val->balance).'" onfocus="deCommaStr(this);" onblur="this.value = commaStr(this.value);" onchange="modifyModalInput(this);" onkeyup="onlyNumber(this)" readonly=""></td>';
			echo '<td style="width:5%; border-bottom: 0.1px solid #D8D8D8">';
			echo '<input type="button" style="width:95%;" id="delBank" class="delBank fundBtn" onclick="delBank(this)" value="X"></td></tr>';
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
									<table style="margin:10px,20px;" class="selectSaveTable" id="selectSaveTable" name="saveTable" style="border-collapse: collapse;">
										<thead>
											<tr class="fixed_top3">
												<th scope="colgroup" style="width:10%; background-color: #F4F4F4;"><strong>예금종류</strong></th>
												<th scope="colgroup" style="width:10%; background-color: #F4F4F4;"><strong>은행</strong></th>
												<th scope="colgroup" style="width:10%; background-color: #F4F4F4;"><strong>은행구분</strong></th>
												<th scope="colgroup" style="width:14%; background-color: #F4F4F4;"><strong>계좌번호</strong></th>
												<th scope="colgroup" style="width:41%; background-color: #F4F4F4;"><strong>내역</strong></th>
												<th scope="colgroup" style="width:12%; background-color: #F4F4F4;"><strong>금액</strong></th>
												<th scope="colgroup" style="width:5%; background-color: #F4F4F4;"></th>
											</tr>
										</thead>
										<tbody>
<?php
	foreach($selectBanklist as $val){
		if($val->type == "예적금") {
			echo '<tr class="modal_select_Save_row" id="modal_select_Save_row" name="'.$val->idx.'">';
			// echo '<input type="hidden" style="color:red" id="idx'.$val->idx.'" value="'.$val->idx.'">';
			echo '<td style="width:10%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<select class="input select-common select-style1" id="selectType" name="selectType" style="width:100%; border:solid 1px black;" onchange="modifyModalInput(this);">';
			echo '<option value="보통예금">보통예금</option>';
			echo '<option value="보증금">보증금</option>';
			echo '<option value="예적금" selected="">예적금</option>';
			echo '<option value="대출금">대출금</option>';
			echo '<option value="투자금">투자금</option><option value="자산(건물)">자산(건물)</option></select></td>';
			echo '<td style="width:10%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<select class="input select-common select-style1" id="selectBank" name="selectBank" style="width:100%; border:solid 1px black;" onchange="selboxDirect(this); modifyModalInput(this);">';
			echo '<option value="직접입력">직접입력</option>';
			echo '<option value=""></option>';
			echo '<option value="'.$val->bank.'" selected="">'.$val->bank.'</option>';
			foreach($bankList as $option){
				if($option->bank != $val->bank){
					echo '<option value="'.$option->bank.'">'.$option->bank.'</option>';
				}
			}
			echo '</select>';
			echo '<input type="text" class="selboxDirect input2" style="display:none; width:90%;" scope="row"></td>';
			echo '<td style="width:10%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<input class="input" style="width:90%; text-align:left;" type="text" id="selectBankType" name="selectBankType" value="'.$val->banktype.'" onchange="modifyModalInput(this);"></td>';
			echo '<td style="width:20%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<input class="input" style="width:95%; text-align:left;" type="text" id="selectAccount" name="selectAccount" value="'.$val->account.'" onchange="modifyModalInput(this);" onkeyup="onlyNumHipen(this)"></td>';
			echo '<td style="width:25%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<input class="input" style="width:95%; text-align:left;" type="text" id="selectBreakdown" name="selectBreakdown" value="'.$val->breakdown.'" onchange="modifyModalInput(this);"></td>';
			echo '<td style="width:20%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<input class="input" style="width:95%; text-align:right;" type="text" id="selectBalance" name="selectBalance" value="'.number_format($val->balance).'" onfocus="deCommaStr(this);" onblur="this.value = commaStr(this.value);" onchange="modifyModalInput(this);" onkeyup="onlyNumber(this)"></td>';
			echo '<td style="width:5%; border-bottom: 0.1px solid #D8D8D8">';
			echo '<input type="button" style="width:95%;" id="delBank" class="delBank fundBtn" onclick="delBank(this)" value="X"></td></tr>';
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
												<th scope="colgroup" style="width:10%; background-color: #F4F4F4;"><strong>예금종류</strong></th>
												<th scope="colgroup" style="width:10%; background-color: #F4F4F4;"><strong>은행</strong></th>
												<th scope="colgroup" style="width:10%; background-color: #F4F4F4;"><strong>은행구분</strong></th>
												<th scope="colgroup" style="width:14%; background-color: #F4F4F4;"><strong>계좌번호</strong></th>
												<th scope="colgroup" style="width:41%; background-color: #F4F4F4;"><strong>내역</strong></th>
												<th scope="colgroup" style="width:12%; background-color: #F4F4F4;"><strong>금액</strong></th>
												<th scope="colgroup" style="width:5%; background-color: #F4F4F4;"></th>
											</tr>
										</thead>
										<tbody>
<?php
	foreach($selectBanklist as $val){
		if($val->type == "보증금") {
			echo '<tr class="modal_select_Deposit_row" id="modal_select_Deposit_row" name="'.$val->idx.'">';
			// echo '<input type="hidden" style="color:red" id="idx'.$val->idx.'" value="'.$val->idx.'">';
			echo '<td style="width:10%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<select class="input select-common select-style1" id="selectType" name="selectType" style="width:100%; border:solid 1px black;" onchange="modifyModalInput(this);">';
			echo '<option value="보통예금">보통예금</option>';
			echo '<option value="보증금" selected="">보증금</option>';
			echo '<option value="예적금">예적금</option>';
			echo '<option value="대출금">대출금</option>';
			echo '<option value="투자금">투자금</option><option value="자산(건물)">자산(건물)</option></select></td>';
			echo '<td style="width:10%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<select class="input select-common select-style1" id="selectBank" name="selectBank" style="width:100%; border:solid 1px black;" onchange="selboxDirect(this); modifyModalInput(this);">';
			echo '<option value="직접입력">직접입력</option>';
			echo '<option value=""></option>';
			echo '<option value="'.$val->bank.'" selected="">'.$val->bank.'</option>';
			foreach($bankList as $option){
				if($option->bank != $val->bank){
					echo '<option value="'.$option->bank.'">'.$option->bank.'</option>';
				}
			}
			echo '</select>';
			echo '<input type="text" class="selboxDirect input2" style="display:none; width:90%;" scope="row"></td>';
			echo '<td style="width:10%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<input class="input" style="width:90%; text-align:left;" type="text" id="selectBankType" name="selectBankType" value="'.$val->banktype.'" onchange="modifyModalInput(this);"></td>';
			echo '<td style="width:20%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<input class="input" style="width:95%; text-align:left;" type="text" id="selectAccount" name="selectAccount" value="'.$val->account.'" onchange="modifyModalInput(this);" onkeyup="onlyNumHipen(this)"></td>';
			echo '<td style="width:25%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<input class="input" style="width:95%; text-align:left;" type="text" id="selectBreakdown" name="selectBreakdown" value="'.$val->breakdown.'" onchange="modifyModalInput(this);"></td>';
			echo '<td style="width:20%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<input class="input" style="width:95%; text-align:right;" type="text" id="selectBalance" name="selectBalance" value="'.number_format($val->balance).'" onfocus="deCommaStr(this);" onblur="this.value = commaStr(this.value);" onchange="modifyModalInput(this);" onkeyup="onlyNumber(this)"></td>';
			echo '<td style="width:5%; border-bottom: 0.1px solid #D8D8D8">';
			echo '<input type="button" style="width:95%;" id="delBank" class="delBank fundBtn" onclick="delBank(this)" value="X"></td></tr>';
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
												<th scope="colgroup" style="width:10%; background-color: #F4F4F4;"><strong>예금종류</strong></th>
												<th scope="colgroup" style="width:10%; background-color: #F4F4F4;"><strong>은행</strong></th>
												<th scope="colgroup" style="width:10%; background-color: #F4F4F4;"><strong>은행구분</strong></th>
												<th scope="colgroup" style="width:14%; background-color: #F4F4F4;"><strong>계좌번호</strong></th>
												<th scope="colgroup" style="width:41%; background-color: #F4F4F4;"><strong>내역</strong></th>
												<th scope="colgroup" style="width:12%; background-color: #F4F4F4;"><strong>금액</strong></th>
												<th scope="colgroup" style="width:5%; background-color: #F4F4F4;"></th>
											</tr>
										</thead>
										<tbody>
<?php
	foreach($selectBanklist as $val){
		if($val->type == "대출금") {
			echo '<tr class="modal_select_Loan_row" id="modal_select_Loan_row" name="'.$val->idx.'">';
			// echo '<input type="hidden" style="color:red" id="idx'.$val->idx.'" value="'.$val->idx.'">';
			echo '<td style="width:10%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<select class="input select-common select-style1" id="selectType" name="selectType" style="width:100%; border:solid 1px black;" onchange="modifyModalInput(this);">';
			echo '<option value="보통예금">보통예금</option>';
			echo '<option value="보증금">보증금</option>';
			echo '<option value="예적금">예적금</option>';
			echo '<option value="대출금" selected="">대출금</option>';
			echo '<option value="투자금">투자금</option><option value="자산(건물)">자산(건물)</option></select></td>';
			echo '<td style="width:10%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<select class="input select-common select-style1" id="selectBank" name="selectBank" style="width:100%; border:solid 1px black;" onchange="selboxDirect(this); modifyModalInput(this);">';
			echo '<option value="직접입력">직접입력</option>';
			echo '<option value=""></option>';
			echo '<option value="'.$val->bank.'" selected="">'.$val->bank.'</option>';
			foreach($bankList as $option){
				if($option->bank != $val->bank){
					echo '<option value="'.$option->bank.'">'.$option->bank.'</option>';
				}
			}
			echo '</select>';
			echo '<input type="text" class="selboxDirect input2" style="display:none; width:90%;" scope="row"></td>';
			echo '<td style="width:10%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<input class="input" style="width:90%; text-align:left;" type="text" id="selectBankType" name="selectBankType" value="'.$val->banktype.'" onchange="modifyModalInput(this);"></td>';
			echo '<td style="width:20%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<input class="input" style="width:95%; text-align:left;" type="text" id="selectAccount" name="selectAccount" value="'.$val->account.'" onchange="modifyModalInput(this);" onkeyup="onlyNumHipen(this)"></td>';
			echo '<td style="width:25%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<input class="input" style="width:95%; text-align:left;" type="text" id="selectBreakdown" name="selectBreakdown" value="'.$val->breakdown.'" onchange="modifyModalInput(this);"></td>';
			echo '<td style="width:20%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<input class="input" style="width:95%; text-align:right;" type="text" id="selectBalance" name="selectBalance" value="'.number_format($val->balance).'" onfocus="deCommaStr(this);" onblur="this.value = commaStr(this.value);" onchange="modifyModalInput(this);" onkeyup="onlyNumber(this)"></td>';
			echo '<td style="width:5%; border-bottom: 0.1px solid #D8D8D8">';
			echo '<input type="button" style="width:95%;" id="delBank" class="delBank fundBtn" onclick="delBank(this)" value="X"></td></tr>';
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
												<th scope="colgroup" style="width:10%; background-color: #F4F4F4;"><strong>예금종류</strong></th>
												<th scope="colgroup" style="width:10%; background-color: #F4F4F4;"><strong>은행</strong></th>
												<th scope="colgroup" style="width:10%; background-color: #F4F4F4;"><strong>은행구분</strong></th>
												<th scope="colgroup" style="width:14%; background-color: #F4F4F4;"><strong>계좌번호</strong></th>
												<th scope="colgroup" style="width:41%; background-color: #F4F4F4;"><strong>내역</strong></th>
												<th scope="colgroup" style="width:12%; background-color: #F4F4F4;"><strong>금액</strong></th>
												<th scope="colgroup" style="width:5%; background-color: #F4F4F4;"></th>
											</tr>
										</thead>
										<tbody>
<?php
	foreach($selectBanklist as $val){
		if($val->type == "투자금") {
			echo '<tr class="modal_select_invest_row" id="modal_select_invest_row" name="'.$val->idx.'">';
			// echo '<input type="hidden" style="color:red" id="idx'.$val->idx.'" value="'.$val->idx.'">';
			echo '<td style="width:10%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<select class="input select-common select-style1" id="selectType" name="selectType" style="width:100%; border:solid 1px black;" onchange="modifyModalInput(this);">';
			echo '<option value="보통예금">보통예금</option>';
			echo '<option value="보증금">보증금</option>';
			echo '<option value="예적금">예적금</option>';
			echo '<option value="대출금">대출금</option>';
			echo '<option value="투자금" selected="">투자금</option><option value="자산(건물)">자산(건물)</option></select></td>';
			echo '<td style="width:10%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<select class="input select-common select-style1" id="selectBank" name="selectBank" style="width:100%; border:solid 1px black;" onchange="selboxDirect(this); modifyModalInput(this);">';
			echo '<option value="직접입력">직접입력</option>';
			echo '<option value=""></option>';
			echo '<option value="'.$val->bank.'" selected="">'.$val->bank.'</option>';
			foreach($bankList as $option){
				if($option->bank != $val->bank){
					echo '<option value="'.$option->bank.'">'.$option->bank.'</option>';
				}
			}
			echo '</select>';
			echo '<input type="text" class="selboxDirect input2" style="display:none; width:90%;" scope="row"></td>';
			echo '<td style="width:10%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<input class="input" style="width:90%; text-align:left;" type="text" id="selectBankType" name="selectBankType" value="'.$val->banktype.'" onchange="modifyModalInput(this);"></td>';
			echo '<td style="width:20%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<input class="input" style="width:95%; text-align:left;" type="text" id="selectAccount" name="selectAccount" value="'.$val->account.'" onchange="modifyModalInput(this);" onkeyup="onlyNumHipen(this)"></td>';
			echo '<td style="width:25%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<input class="input" style="width:95%; text-align:left;" type="text" id="selectBreakdown" name="selectBreakdown" value="'.$val->breakdown.'" onchange="modifyModalInput(this);"></td>';
			echo '<td style="width:20%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<input class="input" style="width:95%; text-align:right;" type="text" id="selectBalance" name="selectBalance" value="'.number_format($val->balance).'" onfocus="deCommaStr(this);" onblur="this.value = commaStr(this.value);" onchange="modifyModalInput(this);" onkeyup="onlyNumber(this)"></td>';
			echo '<td style="width:5%; border-bottom: 0.1px solid #D8D8D8">';
			echo '<input type="button" style="width:95%;" id="delBank" class="delBank fundBtn" onclick="delBank(this)" value="X"></td></tr>';
		}
	}
 ?>
										</tbody>
									</table>
								</div>
							</div>
							<br>

							<strong><a href="javascript:void(0);" id="buildingTableBtn" align="center" onclick="fold_modal(this)">자산(건물)▼</a></strong>
							<div class="modal_select_building_div" style="display:none;">
								<div class="modal_select_a_box">
									<table style="margin:10px,20px;" class="selectBuildingTable" id="selectBuildingTable" name="buildingTable">
										<thead>
											<tr class="fixed_top">
												<th scope="colgroup" style="width:10%; background-color: #F4F4F4;"><strong>예금종류</strong></th>
												<th scope="colgroup" style="width:10%; background-color: #F4F4F4;"><strong>은행</strong></th>
												<th scope="colgroup" style="width:10%; background-color: #F4F4F4;"><strong>은행구분</strong></th>
												<th scope="colgroup" style="width:14%; background-color: #F4F4F4;"><strong>계좌번호</strong></th>
												<th scope="colgroup" style="width:41%; background-color: #F4F4F4;"><strong>내역</strong></th>
												<th scope="colgroup" style="width:12%; background-color: #F4F4F4;"><strong>금액</strong></th>
												<th scope="colgroup" style="width:5%; background-color: #F4F4F4;"></th>
											</tr>
										</thead>
										<tbody>
<?php
	foreach($selectBanklist as $val){
		if($val->type == "자산(건물)") {
			echo '<tr class="modal_select_building_row" id="modal_select_building_row" name="'.$val->idx.'">';
			// echo '<input type="hidden" style="color:red" id="idx'.$val->idx.'" value="'.$val->idx.'">';
			echo '<td style="width:10%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<select class="input select-common select-style1" id="selectType" name="selectType" style="width:100%; border:solid 1px black;" onchange="modifyModalInput(this);">';
			echo '<option value="보통예금">보통예금</option>';
			echo '<option value="보증금">보증금</option>';
			echo '<option value="예적금">예적금</option>';
			echo '<option value="대출금">대출금</option>';
			echo '<option value="투자금">투자금</option><option value="자산(건물)" selected="">자산(건물)</option></select></td>';
			echo '<td style="width:10%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<select class="input select-common select-style1" id="selectBank" name="selectBank" style="width:100%; border:solid 1px black;" onchange="selboxDirect(this); modifyModalInput(this);">';
			echo '<option value="직접입력">직접입력</option>';
			echo '<option value=""></option>';
			echo '<option value="'.$val->bank.'" selected="">'.$val->bank.'</option>';
			foreach($bankList as $option){
				if($option->bank != $val->bank){
					echo '<option value="'.$option->bank.'">'.$option->bank.'</option>';
				}
			}
			echo '</select>';
			echo '<input type="text" class="selboxDirect input2" style="display:none; width:90%;" scope="row"></td>';
			echo '<td style="width:10%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<input class="input" style="width:90%; text-align:left;" type="text" id="selectBankType" name="selectBankType" value="'.$val->banktype.'" onchange="modifyModalInput(this);"></td>';
			echo '<td style="width:20%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<input class="input" style="width:95%; text-align:left;" type="text" id="selectAccount" name="selectAccount" value="'.$val->account.'" onchange="modifyModalInput(this);" onkeyup="onlyNumHipen(this)"></td>';
			echo '<td style="width:25%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<input class="input" style="width:95%; text-align:left;" type="text" id="selectBreakdown" name="selectBreakdown" value="'.$val->breakdown.'" onchange="modifyModalInput(this);"></td>';
			echo '<td style="width:20%; border-bottom: 0.1px solid #D8D8D8" scope="row">';
			echo '<input class="input" style="width:95%; text-align:right;" type="text" id="selectBalance" name="selectBalance" value="'.number_format($val->balance).'" onfocus="deCommaStr(this);" onblur="this.value = commaStr(this.value);" onchange="modifyModalInput(this);" onkeyup="onlyNumber(this)"></td>';
			echo '<td style="width:5%; border-bottom: 0.1px solid #D8D8D8">';
			echo '<input type="button" style="width:95%;" id="delBank" class="delBank fundBtn" onclick="delBank(this)" value="X"></td></tr>';
		}
	}
 ?>
										</tbody>
									</table>
								</div>
							</div>

						</div>
						<div class="modal-footer" style="float:right;">
							<button type="button" class="btn-common btn-color1" style="vertical-align:center; margin-right:10px;"  data-dismiss="modal" name="modalChangeBtn" onclick="modifyBank();">수정</button>
							<a href="javascript:void(0);" rel="modal:close" onclick="modalClose();"><button class="btn-common btn-color2">닫기</button></a>
						</div>
					</div>
				</div>
			</div>
			<br>

			<!-- 버튼 시작 -->
<br><br><br>
			<div style="clear:both;width:100%;width:100%;align:center;<?php if($segment2=='fundreporting_list'){echo 'height:20px;';}else{echo 'min-height:20px;';} ?>">
			<?php if($_GET['company'] == 'DUIT' && $pGroupName != '영업본부') { ?>
				<span style="float:left;font-weight:bold;">
					<input type="checkbox" name="old_new" value="" <?php if($old_new == 'old'){echo 'checked';} ?> onchange="change_old_new(this);">
					이전 자료 보기
				</span>
			<?php } ?>
				<form id="fundSearch" method="post" >
					<select name="selectDate" id="selectDate" class="select-common select-style1" style="float:center;">
						<option value="dueDate" <?php if(isset($selectDate) && $selectDate=="dueDate"){echo 'selected';} ?>>확정일</option>
						<option value="fixedDate" <?php if(isset($selectDate) && $selectDate=="fixedDate"){echo 'selected';} ?>>예정일</option>
						<option value="dateOfIssue" <?php if(isset($selectDate) && $selectDate=="dateOfIssue"){echo 'selected';} ?>>발행일</option>
					</select>
					<input type="text" class="mousetrap input-common input-style1" id="fromDate" name="fromDate" size="7"  autocomplete="off" maxlength="10" onkeyup="onlyNumHipen(this)" onkeypress="auto_datetime_format(event, this);" onmouseover="genDatepicker(this);" value="<?php if(isset($fromDate)){echo $fromDate;}; ?>" style="float:center;width:70px;">
					<input type="button" name="" class="dateBtn" onclick="dateBtn('fromDate');" value=" " style="float:center;"><span style="float:center;margin-right:10px;vertical-align: middle;">~</span>
					<input type="text" class="mousetrap input-common input-style1" id="toDate" name="toDate"  autocomplete="off" size="7" maxlength="10" onkeyup="onlyNumHipen(this)" onkeypress="auto_datetime_format(event, this);" onmouseover="genDatepicker(this);" value="<?php if(isset($toDate)){echo $toDate;}; ?>" style="float:center;width:70px;">
					<input type="button" name="" class="dateBtn" onclick="dateBtn('toDate');" value=" " style="float:center;">
					<select name="search1" id="search1" class="select-common select-style1"  style="float:center;">
						<option value="type" <?php if(isset($search1) && $search1=='type'){echo 'selected';} ?>>대구분</option>
						<option value="customer" <?php if(isset($search1) && $search1=='customer'){echo 'selected';} ?>>거래처</option>
						<option value="endUser" <?php if(isset($search1) && $search1=='endUser'){echo 'selected';} ?>>END-USER</option>
						<option value="bankType" <?php if(isset($search1) && $search1=='bankType'){echo 'selected';} ?>>은행구분</option>
						<option value="breakdown" <?php if(isset($search1) && $search1=='breakdown'){echo 'selected';} ?>>내역</option>
					</select>
					<input type="text" class="mousetrap input-common" id="keyword1" name="keyword1" value="<?php if(isset($keyword1)){echo $keyword1;}; ?>" size="8" style="float:center;width:120px;">
					<select name="search2" id="search2" name="search2" class="select-common select-style1" style="float:center;">
						<option value="customer" <?php if(isset($search2) && $search2=='customer'){echo 'selected';} ?>>거래처</option>
						<option value="type" <?php if(isset($search2) && $search2=='type'){echo 'selected';} ?>>대구분</option>
						<option value="endUser" <?php if(isset($search2) && $search2=='endUser'){echo 'selected';} ?>>END-USER</option>
						<option value="bankType" <?php if(isset($search2) && $search2=='bankType'){echo 'selected';} ?>>은행구분</option>
						<option value="breakdown" <?php if(isset($search2) && $search2=='breakdown'){echo 'selected';} ?>>내역</option>
					</select>
					<input type="text" class="mousetrap input-common" id="keyword2" name="keyword2" value="<?php if(isset($keyword2)){echo $keyword2;}; ?>" size="8" style="float:center;width:120px;">
					<select name="search3" id="search3" name="search3" class="select-common select-style1" style="float:center;">
						<option value="endUser" <?php if(isset($search3) && $search3=='endUser'){echo 'selected';} ?>>END-USER</option>
						<option value="type" <?php if(isset($search3) && $search3=='type'){echo 'selected';} ?>>대구분</option>
						<option value="customer" <?php if(isset($search3) && $search3=='customer'){echo 'selected';} ?>>거래처</option>
						<option value="bankType" <?php if(isset($search3) && $search3=='bankType'){echo 'selected';} ?>>은행구분</option>
						<option value="breakdown" <?php if(isset($search3) && $search3=='breakdown'){echo 'selected';} ?>>내역</option>
					</select>
					<input type="text" class="mousetrap input-common" id="keyword3" name="keyword3" value="<?php if(isset($keyword3)){echo $keyword3;}; ?>" size="8" style="float:center;width:120px;">
					<input class="btn-common btn-style2" type="submit" name="submit" onclick="list_search('search');" value="검색" style="float:center;width:60px;">
					<input class="btn-common btn-style2" type="submit" style="float:center;width:60px;<?php if($segment2=="fundreporting_list"){echo 'display:none';} ?>" onclick="list_search('reset');" value="초기화">
				</form>
				<div style="<?php if($segment2=="fundreporting_list" || $_GET['company'] == 'DUITOLD'){echo 'display:none;';} ?> margin-top:10px" class="">
					<select name="modify_col" id="modify_col" class="select-common select-style1" onchange="search_modify_select(this);">
						<option value="" selected disabled hidden>선택하세요</option>
						<option value="dueDate">확정일</option>
						<option value="customer">거래처</option>
						<option value="endUser">END-USER</option>
						<option value="breakdown">내역</option>
					</select>
					<input type="text" style="width:100px;" id="modify_before" class="input-common" name="" value="" size="8" placeholder="변경 전">
					<span><img style="width:10px; height:10px;" src="/misc/img/righarrow_87553.png"></img></span>
					<input type="text" style="width:100px;" id="modify_after" name="" class="input-common" value="" size="8" placeholder="변경 후">
					<input class="fund_btn2 fund_btn3" class="btn-common btn-style2" style="width:90px;" type="button" onclick="search_modify();" value="선택 바꾸기">
				</div>
				<script type="text/javascript">
					function list_search(search){
						if(search=='reset'){
							var segment = 'fundreporting_list';
						} else {
							var segment = 'search';
						}
						var act = "<?php echo site_url();?>/sales/fundreporting/"+segment+"<?php echo $company; ?>";
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
				<div id="searchResult" <?php if ($this->uri->segment(3, 0)!='search'){echo 'style="display: none;"';} ?>>
<?php
	if($total_rows == 0){
 ?>
					<div>
						<h5 style ="color: black;">검색결과가 없습니다.</h5>
					</div>
<?php
	} else {
 ?>
					<h5 style ="color: black;">검색건수 : <?php echo number_format($total_rows); ?>건 /    입금총액 : <?php echo  number_format($sumDeposit); ?>원 /  출금총액 : <?php echo  number_format($sumWithdraw); ?>원 / 미입금총액 : <?php echo  number_format($nsDeposit); ?>원 / 미출금총액 : <?php echo  number_format($nsWithdraw); ?>원</h5>
					<h5 style ="color: black;">2022 Version /    입금총액 : <?php
					if($_GET['company'] == 'DUIT') {
						echo  number_format($sumDeposit + $sumDeposit_adjust);
					} else {
						echo  number_format($sumDeposit);
					}
					?>원 /  출금총액 : <?php
					if($_GET['company'] == 'DUIT') {
						echo  number_format($sumWithdraw + $sumWithdraw_adjust);
					} else {
						echo  number_format($sumWithdraw);
					}
					?>원 / 미입금총액 : <?php
					if($_GET['company'] == 'DUIT') {
						echo  number_format($nsDeposit + $nsDeposit_adjust);
					} else {
						echo  number_format($nsDeposit);
					}
					?>원 / 미출금총액 : <?php
					if($_GET['company'] == 'DUIT') {
						echo  number_format($nsWithdraw + $nsWithdraw_adjust);
					} else {
						echo  number_format($nsWithdraw);
					}
					?>원</h5>
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
							<col style="width:6.4%">
							<col style="width:10%">
							<col style="width:10%">
							<col style="width:21.3%">
							<col style="width:6%">
							<col style="width:6%">
							<col style="width:6%">
							<col style="width:6.5%">
							<col style="width:6.5%;">
							<col>
						</colgroup>
						<thead>
							<?php
							$sort1 = "&sort=dateOfIssue";
							$sort2 = "&sort=dueDate";
							$sort3 = "&sort=endUser";
							if(isset($_GET['sort'])){
								$getSort = $_GET['sort'];
							} else {
								$getSort = 'dueDate';
							}
							 ?>
							<tr class="fixed_top">
								<th class="cell0" scope="colgroup"><input type="checkbox" id="allCheck" onchange="allCheck(this);"/></th>
								<th class="cell1" scope="colgroup" style="<?php if($segment2=='sort'){echo 'background:#90EE90;';}else if($segment2=='search'&&$getSort=="dateOfIssue"){echo 'background:#90EE90;';} ?>">
									<?php if ($segment2 == "search"){ ?>
										<a href="<?php echo $baseUrl.'/sales/'.$segment1.'/';echo 'search'.$company.$sort1; ?>">발행일</a>
									<?php } else {?>
										<a href="<?php echo $baseUrl.'/sales/'.$segment1.'/';if($segment2!='sort'){echo 'sort';}else {echo 'fundreporting_list';} echo $company; ?>">발행일</a>
								<?php } ?>
								</th>
								<th class="cell2" scope="colgroup">예정일</th>
 								<th class="cell3" scope="colgroup" style="<?php if($segment2=='fundreporting_list'){echo 'background:#90EE90;';}else if($segment2=='search'&&$getSort=="dueDate"){echo 'background:#90EE90;';} ?>">
									<?php if ($segment2=="search"){ ?>
										<a style="display: block;" href="<?php echo $baseUrl.'/sales/'.$segment1.'/';echo 'search'.$company.$sort2; ?>">확정일</a>
									<?php } else { ?>
										<a style="display: block;" href="<?php echo $baseUrl.'/sales/'.$segment1.'/';if($segment2!='fundreporting_list'){echo 'fundreporting_list';}else {echo 'sort';} echo $company; ?>">확정일</a>
									<?php } ?>
								</th>
								<th class="cell4" scope="colgroup">대구분</th>
								<th class="cell5" scope="colgroup">은행구분</th>
								<th class="cell6" scope="colgroup">거래처</th>
 								<th class="cell7" scope="colgroup" style="<?php if($segment2=='enduser'){echo 'background:#90EE90;';}else if($segment2=='search'&&$getSort=="endUser"){echo 'background:#90EE90;';} ?>">
									<?php if($segment2=="search"){ ?>
										<a href="<?php echo $baseUrl.'/sales/'.$segment1.'/';echo 'search'.$company.$sort3; ?>">END-USER</a>
									<?php } else { ?>
										<a href="<?php echo $baseUrl.'/sales/'.$segment1.'/';if($segment2!='enduser'){echo 'enduser';}else {echo 'fundreporting_list';} echo $company; ?>">END-USER</a>
									<?php } ?>
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
		$balance = $set_balance['balance'] + 0;
	} else {
		$balance = $set_balance['balance'] + $pagingBalance[0]->pagingBalance;
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
								<input type="hidden" name="bill_seq" value="<?php echo $val->bill_seq; ?>">
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
									<input class="input mousetrap" style="width:100%; text-align:left;<?php if($val->bill_seq != ''){echo 'cursor:pointer;';} ?> <?php echo $color; ?>" type="text" id="breakdown" name="breakdown" value="<?php echo $val->breakdown?>" title="<?php echo $val->breakdown?>" onchange="modifyInput(this);"/>
								</td>
								<td class="cell9" scope="row">
									<input class="input mousetrap" style="width:70%; text-align:right; <?php echo $color; ?>" type="text" id="requisition" name="requisition" value="<?php echo $requisition?>" title="<?php echo $requisition?>" onchange="modifyInput(this);" onFocus="deCommaStr(this);" onBlur="this.value = commaStr(this.value);" onkeyup="<?php if($_GET['company']=='DK'){echo 'onlyNumHipen';}else{echo 'onlyNumber';} ?>(this);" />
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

			<!-- 영업본부 조회 용 테이블 -->
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
									<a href="<?php echo $baseUrl.'/sales/'.$segment1.'/';echo 'fundreporting_list'.$company; ?>">발행일</a>
								</th>
								<th class="cell2" scope="colgroup">예정일</th>
								<th class="cell3" scope="colgroup" style="<?php if($segment2=='sort'){echo 'background:#90EE90;';} ?>">
									<a href="<?php echo $baseUrl.'/sales/'.$segment1.'/';if($segment2!='sort'){echo 'sort';}else {echo 'fundreporting_list';} echo $company; ?>">확정일</a>
								</th>
								<th class="cell4" scope="colgroup">대구분</th>
								<th class="cell5" scope="colgroup">은행구분</th>
								<th class="cell6" scope="colgroup">거래처</th>
								<th class="cell7" scope="colgroup" style="<?php if($segment2=='enduser'){echo 'background:#90EE90;';} ?>">
									<a href="<?php echo $baseUrl.'/sales/'.$segment1.'/';if($segment2!='enduser'){echo 'enduser';}else {echo 'fundreporting_list';} echo $company; ?>">END-USER</a>
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
			<div class="scroll" style="float: right; position:relative; left:10px; bottom:55px;">
				<a href="JavaScript:scrollUp()"><img src="<?php echo $misc;?>img/dashboard/btn/scroll_top.svg" align="right" width="20" height="20" style="position:relative; left:10px;"/>
				<a href="JavaScript:scrollDown()"><img src="<?php echo $misc;?>img/dashboard/btn/scroll_bottom.svg" align="right" width="20" height="20" style="position:relative; left:30px; top:15px;"/>
			</div>
			<!-- 영업본부 조회 용 테이블 끝 -->


			<!-- 엑셀 export용 테이블 -->
			<div id="excel_div"></div>
			<!-- 엑셀 export용 테이블 끝 -->

			<div class = "paging">
				<?php echo $pagination; ?>
			</div>

				<button id="hideButton" class="btn-common btn-updownload" style="float: left;display:inline;width:140px;margin-right:10px;<?php if($_GET['company']=='DUITOLD'){echo 'display:none;';} ?>" type="button" onclick="location.href='<?php echo site_url();?>/sales/fundreporting/download';">엑셀 폼 다운로드
					<img src="/misc/img/download_btn.svg"  style="float:left; width:12px; padding:5px;">
				</button>

				<input type="button" class="btn-common btn-style5" style="margin-bottom: 30px;float:left;display:inline;width:90px;margin-right:10px;<?php if($pGroupName=='영업본부' || $_GET['company'] == 'DUITOLD'){echo 'display:none';} ?>" onclick="newRow('add');" value="한줄추가" />
				<input type="button" class="btn-common btn-style5" style="float:left;display:inline;width:90px;margin-right:10px;<?php if($pGroupName=='영업본부' || $_GET['company'] == 'DUITOLD'){echo 'display:none';} ?>" onclick="newRow('paste');" value="한줄복사" />
				<!-- <button class="fund_btn5" class="moveTop" style="float: right;" type="button" name="button" onclick="scrollUp();">↑<br>TOP</button> -->

				<!-- <div class="scroll" style="float: right;">
					<a href="JavaScript:scrollUp()"><img src="<?php echo $misc;?>img/dashboard/btn/scroll_top.svg" align="right" width="20" height="20" style="display: inline;"/><br>
					<a href="JavaScript:scrollDown()"><img src="<?php echo $misc;?>img/dashboard/btn/scroll_bottom.svg" align="right" width="20" height="20" style="display: inline;"/>
				</div> -->

				<input type='button' class="btn-common btn-updownload" value='엑셀 다운로드' onclick="fnExcelReport('excelTable');" style="float: right;display:inline;margin-right:10px;padding-left:20px;width:auto;"/>
				<img src="/misc/img/download_btn.svg" style="float:right; width:12px; position:relative; top:10px; left:20px; padding-right:2px;">

				<div style="float:right;height:50px;">
				<input type='button' style="display:inline;width:100px;margin-right:-8px;padding-left:20px;<?php if($pGroupName=='영업본부' || $_GET['company'] == 'DUITOLD'){echo 'display:none';} ?>" class="btn-common btn-updownload" onclick="$('#excelFile').click();" value="파일업로드" />
					<input style="display:none;" type="file" id="excelFile" onchange="excelExport(event)" />
					<img src="/misc/img/upload_btn.svg" style="float:left; width:12px; position:relative; top:10px; left:20px; padding: 2px;">
				</div>

				<button class="btn-common btn-style3" style="border-width:thin;float: right;display:inline;width:90px;margin-right:-8px;<?php if($pGroupName=='영업본부' || $_GET['company'] == 'DUITOLD'){echo 'display:none';} ?>" type="button" id="update" onclick="saveList();">저장</button>
				<button class="btn-common btn-color4" style="border-width:thin;float: right;display:inline;width:90px;margin-right:10px;<?php if($pGroupName=='영업본부' || $_GET['company'] == 'DUITOLD'){echo 'display:none';} ?>;" type="button"name="button" onclick="deleteRow();">삭제</button>
			</div>
			<span id="sumSpan" style="align:right"></span>
			<!-- <button style="float: right;<?php if($pGroupName=='영업본부'){echo 'display:none';} ?>" for="excelFile">파일업로드</button> -->
			<!-- <div id="bottom">
			</div>
			<div class="filebox" id="hideDiv">
				</label>
				<br><br>
		    <button class="fundBtn" class="moveBottom" style="float: right;" type="button" name="button" onclick="scrollDown();">▼</button>

			</div> -->
		</div>
    <!-- ********************** 본문 끝 ********************** -->
	</div>
	<ul class="contextmenu">
	  <li class="memo_menu" id="memo_select_li"><a style="cursor:pointer;">계산서 이동</a></li>
	</ul>
<!--하단-->
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
<!--하단-->
<script type="text/javascript" src="/misc/js/fundReporting.js"></script>
<script>
function searchBankBook(){
	$('#search_bankBook').bPopup({follow:[false,false],position:['45%','15%'],modalColor:'gray'});
	$('#search_bankBook').draggable();
	$('#searchday').val('<?php echo $day; ?>');
}

function searchBankBook_close(){
	$('#search_bankBook').bPopup().close();
}

var selectDate = '';
var fromDate = '';
var toDate = '';
var search1 = '';
var keyword1 = '';
var search2 = '';
var keyword2 = '';
var search3 = '';
var keyword3 = '';

<?php if(strpos($_SERVER['REQUEST_URI'],'/search') !== false) {?>
	var selectDate = '<?php echo $selectDate; ?>';
	var fromDate = '<?php echo $fromDate; ?>';
	var toDate = '<?php echo $toDate; ?>';
	var search1 = '<?php echo $search1; ?>';
	var keyword1 = '<?php echo $keyword1; ?>';
	var search2 = '<?php echo $search2; ?>';
	var keyword2 = '<?php echo $keyword2; ?>';
	var search3 = '<?php echo $search3; ?>';
	var keyword3 = '<?php echo $keyword3; ?>';
<?php } ?>
var page = '<?php echo $this->uri->segment(3); ?>';

// 엑셀 파일 저장
function fnExcelReport(id) {
  var excel_download_table = "";

  $.ajax({
		 type: "POST",
		 cache: false,
		 url: '/index.php/sales/fundreporting/excel_download?company=' + getParam("company") + '&page=' + page,
		 dataType: "json",
		 async: false,
		 data: {
			 selectDate:selectDate,
			 fromDate:fromDate,
			 toDate:toDate,
			 search1:search1,
			 keyword1:keyword1,
			 search2:search2,
			 keyword2:keyword2,
			 search3:search3,
			 keyword3:keyword3
		 },
		 success: function (data) {
			 if(data){
         excel_download_table += '<table id="excelTable" class="exportTable" style="width:100%;display:none"><colgroup><col style="width:5%"><col style="width:5%"><col style="width:5%"><col style="width:5.3%"><col style="width:5.4%"><col style="width:10.7%"><col style="width:10.7%"><col style="width:30.9%"><col style="width:6%"><col style="width:6%"><col style="width:6%"></colgroup>';
         excel_download_table += '<tr bgcolor="f8f8f9" class="t_top"><td height="60" align="center">발행일</td><td height="60" align="center">예정일</td><td height="60" align="center">확정일</td><td height="60" align="center">대구분</td><td height="60" align="center">은행구분</td><td height="60" align="center">거래처</td><td height="60" align="center">END-USER</td><td height="60" align="center">내역</td><td height="60" align="center">청구금액</td><td height="60" align="center">입금</td><td height="60" align="center">출금</td>';

         for(var i=0; i<data.length; i++){
           if(data[i].dateOfIssue==null){
             data[i].dateOfIssue = '';
           }
           if(data[i].fixedDate==null){
             data[i].fixedDate = '';
           }
           if(data[i].dueDate==null){
             data[i].dueDate = '';
           }
           if(data[i].type==null){
             data[i].type = '';
           }
           if(data[i].bankType==null){
             data[i].bankType = '';
           }
           if(data[i].customer==null){
             data[i].customer = '';
           }
           if(data[i].endUser==null){
             data[i].endUser = '';
           }
           if(data[i].breakdown==null){
             data[i].breakdown = '';
           }
           if(data[i].requisition==null){
             data[i].requisition = '';
           }
           if(data[i].deposit==null){
             data[i].deposit = '';
           }
           if(data[i].withdraw==null){
             data[i].withdraw = '';
           }
           excel_download_table += '<tr>';
           excel_download_table += '<td scope="row" class="cell1" style="text-align:left;">'+data[i].dateOfIssue+'</td>';
           excel_download_table += '<td scope="row" class="cell1" style="text-align:left;">'+data[i].fixedDate+'</td>';
           excel_download_table += '<td scope="row" class="cell1" style="text-align:left;">'+data[i].dueDate+'</td>';
           excel_download_table += '<td scope="row" class="cell1" style="text-align:left;">'+data[i].type+'</td>';
           excel_download_table += '<td scope="row" class="cell1" style="text-align:left;">'+data[i].bankType+'</td>';
           excel_download_table += '<td scope="row" class="cell1" style="text-align:left;">'+data[i].customer+'</td>';
           excel_download_table += '<td scope="row" class="cell1" style="text-align:left;">'+data[i].endUser+'</td>';
           excel_download_table += '<td scope="row" class="cell1" style="text-align:left;">'+data[i].breakdown+'</td>';
           excel_download_table += '<td scope="row" class="cell1" style="text-align:left;">'+data[i].requisition+'</td>';
           excel_download_table += '<td scope="row" class="cell1" style="text-align:left;">'+data[i].deposit+'</td>';
           excel_download_table += '<td scope="row" class="cell1" style="text-align:left;">'+data[i].withdraw+'</td>';
           excel_download_table += '</tr>';
         }
			 }
			}
		});

	$("#excel_div").append(excel_download_table);

  var today = getToday();
  $("#accountlist tr[class=bankTypeHidden]").remove();

  var title = "자금보고서_" + today;

  var tab_text = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
  tab_text = tab_text + '<head><meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">';
  tab_text = tab_text + '<xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>'
  tab_text = tab_text + '<x:Name>Test Sheet</x:Name>';
  tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:Panes></x:WorksheetOptions></x:ExcelWorksheet>';
  tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>';
  tab_text = tab_text + "<table border='1px'>";
  var exportTable = $('#' + id).clone();
  exportTable.find('input').each(function(index, elem) {
    $(elem).remove();
  });
  tab_text = tab_text + exportTable.html();
  tab_text = tab_text + '</table></body></html>';
  var data_type = 'data:application/vnd.ms-excel';
  var ua = window.navigator.userAgent;
  var msie = ua.indexOf("MSIE ");
  var fileName = title + '.xls';
  //Explorer 환경에서 다운로드
  if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
    if (window.navigator.msSaveBlob) {
      var blob = new Blob([tab_text], {
        type: "application/csv;charset=utf-8;"
      });
      navigator.msSaveBlob(blob, fileName);
    }
  } else {
    var blob2 = new Blob([tab_text], {
      type: "application/csv;charset=utf-8;"
    });
    var filename = fileName;
    var elem = window.document.createElement('a');
    elem.href = window.URL.createObjectURL(blob2);
    elem.download = filename;
    document.body.appendChild(elem);
    elem.click();
    document.body.removeChild(elem);
  }
}

function change_old_new(el) {
	var url = '<?php echo site_url(); ?>';
	if($(el).is(':checked')) {
		location.href="/index.php/sales/fundreporting/fundreporting_list?company=" + getParam("company") + '&old_new=old';
	} else {
		location.href="/index.php/sales/fundreporting/fundreporting_list?company=" + getParam("company") + '&old_new=new';
	}
}

// const url = new URL($(location).attr('href'));
//
// const urlParams = url.searchParams;
//
// alert(urlParams.has('old_new'));

$("input[name=breakdown]").contextmenu(function(e){
	var tr = $(this).closest('tr');
	var bill_seq = tr.find('input[name=bill_seq]').val();

	if (bill_seq != '') {
		$('#memo_select_li').attr('onclick', 'go_site("'+bill_seq+'")');
		$("#memo_select_li").show();
		//Get window size:
		var winWidth = $(document).width();
		var winHeight = $(document).height();
		//Get pointer position:
		var posX = e.pageX;
		var posY = e.pageY;
		//Get contextmenu size:
		var menuWidth = $(".contextmenu").width();
		var menuHeight = $(".contextmenu").height();
		//Security margin:
		var secMargin = 10;
		//Prevent page overflow:
		if(posX + menuWidth + secMargin >= winWidth
			&& posY + menuHeight + secMargin >= winHeight){
				//Case 1: right-bottom overflow:
				posLeft = posX - menuWidth - secMargin;
				posTop = posY - menuHeight - secMargin;
			}
			else if(posX + menuWidth + secMargin >= winWidth){
				//Case 2: right overflow:
				posLeft = posX - menuWidth - secMargin;
				posTop = posY + secMargin;
			}
			else if(posY + menuHeight + secMargin >= winHeight){
				//Case 3: bottom overflow:
				posLeft = posX + secMargin;
				posTop = posY - menuHeight - secMargin;
			}
			else {
				//Case 4: default values:
				posLeft = posX + secMargin;
				posTop = posY + secMargin;
			};
			//Display contextmenu:
			$(".contextmenu").css({
				"left": posLeft - 60 + "px",
				"top": posTop - 70 + "px"
			}).show();
			//Prevent browser default contextmenu.
			return false;
	}
});
// Hide contextmenu:
// $(document).not("ul.contextmenu").click(function(){
//   $(".contextmenu").hide();
// });
$(document).mouseup(function (e){
   var LayerPopup = $(".contextmenu");
   if(LayerPopup.has(e.target).length === 0){
     $(".contextmenu").hide();
   }
 });
Mousetrap.bind('esc', function(e) {
  $(".contextmenu").hide();
});

function go_site(bill_seq) {

	if (bill_seq.indexOf('r_') != -1) {
		var url = '<?php echo site_url(); ?>/tech/tech_board/request_tech_support_list';
		window.open(url, '_blank');
	} else if (bill_seq.indexOf('m_') != -1 || bill_seq.indexOf('f_') != -1) {
		$.ajax({
			type: "POST",
			dataType: 'json',
			async: false,
			url: "<?php echo site_url(); ?>/sales/fundreporting/find_bill_target",
			data: {
				bill_seq: bill_seq
			},
			success: function(data) {
				var target_seq = data.target_seq;
				if (bill_seq.indexOf('f_') != -1) {
					var url = '<?php echo site_url(); ?>/sales/forcasting/order_completed_view?seq='+target_seq;
						window.open(url, '_blank');
				} else if (bill_seq.indexOf('m_') != -1) {
					$.ajax({
						type: "POST",
						dataType: "json",
						async: false,
						url: "<?php echo site_url(); ?>/sales/purchase_sales/check_maintain",
						data: {
							seq: target_seq
						},
						success: function(data) {
							var cnt = data[0]['cnt'];
							if (cnt > 0) {
								var type = '002';
							} else {
								var type = '001';
							}
							var url = '<?php echo site_url(); ?>/sales/maintain/maintain_view?seq='+target_seq+'&type='+type;
							window.open(url, '_blank');
						}
					})
				}
			}
		})
	} else if (bill_seq.indexOf('o_') != -1) {
		$.ajax({
			type: 'POST',
			dataType: 'json',
			async: false,
			url: "<?php echo site_url(); ?>/sales/fundreporting/find_bill_target",
			data: {
				bill_seq: bill_seq
			},
			success: function(data) {
				var issuance_month = data.issuance_month;
				var year = issuance_month.split('-')[0];
				var month = issuance_month.split('-')[1];
				var url = '<?php echo site_url(); ?>/sales/purchase_sales/purchase_sales_view?company='+data.dept+'&year='+year+'&month='+month;
				window.open(url, '_blank');
			}
		})
	}

	// if (bill_seq.indexOf('m_')) {
	// 	$.ajax({
	// 		type: "POST",
	// 		dataType: "json",
	// 		async: false,
	// 		url: "<?php echo site_url(); ?>/sales/purchase_sales/check_maintain",
	// 		data: {
	// 			seq: seq
	// 		},
	// 		success: function(data) {
	// 			var cnt = data[0]['cnt'];
	// 			if (cnt > 0) {
	// 				var type = '002';
	// 			} else {
	// 				var type = '001';
	// 			}
	// 			var url = '<?php echo site_url(); ?>/sales/maintain/maintain_view?seq='+seq+'&type='+type;
	// 			window.open(url, '_blank');
	// 		}
	// 	})
	// } else if (bill_seq.indexOf('f_')) {
	// 	var url = '<?php echo site_url(); ?>/sales/forcasting/order_completed_view?seq='+seq;
	// 	window.open(url, '_blank');
	// } else if (bill_seq.indexOf('r_')) {
	// 	var url = '<?php echo site_url(); ?>/tech/tech_board/request_tech_support_list';
	// 	window.open(url, '_blank');
	// }

}
</script>
</body>
</html>
