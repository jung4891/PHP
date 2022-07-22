<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";

  if($search_keyword != ''){
    $filter = explode(',',str_replace('"', '&uml;',$search_keyword));
  }
?>
<style>

	.copy_item{

	  height:33%;
	  display: flex;
	  justify-content: center;
	  align-items: center;
	  font-family:"Noto Sans KR", sans-serif;
	}

	#search_tr, #search_tr2 {
		font-weight: bold;
		font-size: 13px;
	}

	#search_tr2 input, #search_tr2 select {
		margin-left:5px;
		margin-right:10px;
	}

	#search_tr td {
		padding-top:2px;
	}

	#search_tr input {
		width:120px;
	}

	#search_tr select {
		width:150px;
	}

</style>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<script type="text/javascript" src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>
<script language="javascript">
function GoSearch(mode) {
	if (mode == 'detail') {
		$("#search_mode").val('detail');
		var searchkeyword = '';
		for (i = 1; i <= $(".filtercolumn").length; i++) {
			if (i == 1) {
				searchkeyword += $("#filter" + i).val().trim();
			} else {
				var filter_val = $("#filter" + i).val().trim();
				if(i == 13 || i == 14){
					filter_val = String(filter_val).replace(/,/g, "");
				}
				searchkeyword += ',' + filter_val;
			}

		}
	} else {
		$("#search_mode").val('simple');
		var searchkeyword = '';
		for (i = 1; i <= $(".filtercolumn2").length; i++) {
			if (i == 1) {
				searchkeyword += $("#filter2_" + i).val().trim();
			} else {
				var filter_val = $("#filter2_" + i).val().trim();
				if(i == 4 || i == 5){
					filter_val = String(filter_val).replace(/,/g, "");
				}
				searchkeyword += ',' + filter_val;
			}

		}
	}

	$("#searchkeyword").val(searchkeyword);

	if (searchkeyword.replace(/,/g, "") == "") {
		alert("검색어가 없습니다.");
		location.href="<?php echo site_url();?>/sales/forcasting/order_completed_list?search_mode="+mode;
		return false;
	}

	document.mform.action = "<?php echo site_url();?>/sales/forcasting/order_completed_list";
	document.mform.cur_page.value = "";
	document.mform.submit();
}
</script>
<link rel="stylesheet" href="/misc/css/bootstrap-datepicker.css"> <!-- 달력 표시 css (datepicker) -->
<script type="text/javascript" src="/misc/js/bootstrap-datepicker.js"></script> <!--  달력 표시 js (datepicker) -->
<body>
<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
	if(isset($_GET['search_mode'])) {
		$search_mode = $_GET['search_mode'];
	} else {
		$search_mode = 'simple';
	}
?>
<div align="center">
<div class="dash1-1">
<form name="mform" action="<?php echo site_url();?>/sales/forcasting/order_completed_list" method="get">
<table width="96%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
<input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
<input type="hidden" name="lpp" value="<?php echo $no_page_list; ?>">
<input type="hidden" name="seq" value="">
<input type="hidden" name="mode" value="">
<input type="hidden" id="searchkeyword" name="searchkeyword" value="<?php echo str_replace('"', '&uml;', $search_keyword );?>"/>
<tbody height="100%">
	<!-- 타이틀 이미지 -->
	<tr height="5%">
		<td class="dash_title">수주완료</td>
	</tr>
	<tr height="65">
		<input type="hidden" id="search_mode" name="search_mode" value="<?php echo $search_mode; ?>">
	</tr>
	<!-- 검색창 -->
	<tr>
		<td align="left" valign="bottom">
			<div class="toggleUpBtn" onclick="showhide('up');" style="cursor:pointer;display:inline-block;<?php if($search_mode == 'simple'){echo 'display:none';} ?>">▲</div>

			<div class="toggleDownBtn" onclick="showhide('down');" style="cursor:pointer;display:inline-block;<?php if($search_mode == 'detail'){echo 'display:none';} ?>">
				<img src="<?php echo $misc;?>img/detail_search.svg" width="100"/>
			</div>
		</td>
	</tr>
	<tr height="20"></tr>
	<tr id="search_tr" class="search_title" style="<?php if($search_mode == 'simple'){echo 'display:none';} ?>" onkeydown="if(event.keyCode==13) return GoSearch('detail');">
		<td align="left" valign="top">
			<table id="filter_table">
				<colgroup>
					<col width="110px">
					<col width="200px">
					<col width="110px">
					<col width="200px">
					<col width="110px">
					<col width="200px">
					<col width="110px">
					<col width="200px">
					<col width="200px">
				</colgroup>
				<div style="float:left;white-space:nowrap">
					<tr>
						<td>고객사</td>
						<td>
							<input type="text" id="filter1" class="input-common filtercolumn" value='<?php if(isset($filter)&&$search_mode=='detail'){echo $filter[0];} ?>'/>
						</td>
						<td>프로젝트명</td>
						<td>
							<input type="text" id="filter2" class="input-common filtercolumn" value='<?php if(isset($filter)&&$search_mode=='detail'){echo $filter[1];} ?>' />
						</td>
						<td>제조사</td>
						<td>
							<input type="text" id="filter3" class="input-common filtercolumn" value='<?php if(isset($filter)&&$search_mode=='detail'){echo $filter[2];} ?>'/>
						</td>
						<td>제품명</td>
						<td>
							<input type="text" id="filter4" class="input-common filtercolumn" value='<?php if(isset($filter)&&$search_mode=='detail'){echo $filter[3];} ?>' />
						</td>
						<td>
							<input type="button" class="btn-common btn-style2" value="검색" style="width:60px;" onclick="return GoSearch('detail');">
						</td>
					</tr>
					<tr>
						<td>매출처</td>
						<td>
							<input type="text" id="filter15" class="input-common filtercolumn" value='<?php if(isset($filter)&&$search_mode=='detail'){echo $filter[14];} ?>' />
						</td>
						<td>영업부서</td>
						<td>
							<select id="filter5" class="select-common select-style1 filtercolumn">
								<option value="">선택</option>
								<option value="사업1부"<?php if(isset($filter)&&$search_mode=='detail' && $filter[4] == '사업1부'){echo "selected";} ?>>사업1부</option>
								<option value="사업2부"<?php if(isset($filter)&&$search_mode=='detail' && $filter[4] == '사업2부'){echo "selected";} ?>>사업2부</option>
								<option value="ICT"<?php if(isset($filter)&&$search_mode=='detail' && $filter[4] == 'ICT'){echo "selected";} ?>>ICT</option>
								<option value="MG"<?php if(isset($filter)&&$search_mode=='detail' && $filter[4] == 'MG'){echo "selected";} ?>>MG</option>
								<option value="기술지원부"<?php if(isset($filter)&&$search_mode=='detail' && $filter[4] == '기술지원부'){echo "selected";} ?>>기술지원부</option>
							</select>
						</td>
						<td>영업회사</td>
						<td>
							<select id="filter6" class="select-common select-style1 filtercolumn">
								<option value="">선택</option>
								<option value="두리안정보기술"<?php if(isset($filter)&&$search_mode=='detail' && $filter[5] == '두리안정보기술'){echo "selected";} ?>>두리안정보기술</option>
								<option value="두리안정보통신기술"<?php if(isset($filter)&&$search_mode=='detail' && $filter[5] == '두리안정보통신기술'){echo "selected";} ?>>두리안정보통신기술</option>
								<option value="더망고"<?php if(isset($filter)&&$search_mode=='detail' && $filter[5] == '더망고'){echo "selected";} ?>>더망고</option>
							</select>
						</td>
						<td>영업담당자(두리안)</td>
						<td>
							<input type="text" id="filter7" class="input-common filtercolumn" value='<?php if(isset($filter)&&$search_mode=='detail'){echo $filter[6];} ?>' />
						</td>
					</tr>
					<tr>
						<td>정보통신공사업</td>
						<td>
							<select id="filter12" class="select-common select-style1 filtercolumn">
								<option value="">선택</option>
								<option value="Y" <?php if(isset($filter)&&$search_mode=='detail' && $filter[11] == 'Y'){echo "selected";} ?>>신청</option>
								<option value="N" <?php if(isset($filter)&&$search_mode=='detail' && $filter[11] == 'N'){echo "selected";} ?>>미신청</option>
							</select>
						</td>
						<td>판매종류</td>
						<td>
							<select id="filter9" class="select-common select-style1 filtercolumn">
								<option value="" >선택</option>
								<option value="1" <?php if(isset($filter)&&$search_mode=='detail' && $filter[8] == '1'){echo "selected";} ?> >판매</option>
								<option value="2" <?php if(isset($filter)&&$search_mode=='detail' && $filter[8] == '2'){echo "selected";} ?> >용역</option>
								<option value="3" <?php if(isset($filter)&&$search_mode=='detail' && $filter[8] == '3'){echo "selected";} ?> >유지보수</option>
								<option value="4" <?php if(isset($filter)&&$search_mode=='detail' && $filter[8] == '4'){echo "selected";} ?> >조달</option>
								<option value="0" <?php if(isset($filter)&&$search_mode=='detail' && $filter[8] == '0'){echo "selected";} ?> >선택없음</option>
							</select>
						</td>
						<td>진척단계</td>
						<td>
							<select id="filter10" class="select-common select-style1 filtercolumn">
								<option value="" >선택</option>
								<option value="001" <?php if(isset($filter)&&$search_mode=='detail' && $filter[9] == '001'){echo "selected";} ?> >영업보류(0%)</option>
								<option value="002" <?php if(isset($filter)&&$search_mode=='detail' && $filter[9] == '002'){echo "selected";} ?> >고객문의(5%)</option>
								<option value="003" <?php if(isset($filter)&&$search_mode=='detail' && $filter[9] == '003'){echo "selected";} ?> >영업방문(10%)</option>
								<option value="004" <?php if(isset($filter)&&$search_mode=='detail' && $filter[9] == '004'){echo "selected";} ?> >일반제안(15%)</option>
								<option value="005" <?php if(isset($filter)&&$search_mode=='detail' && $filter[9] == '005'){echo "selected";} ?> >견적제출(20%)</option>
								<option value="006" <?php if(isset($filter)&&$search_mode=='detail' && $filter[9] == '006'){echo "selected";} ?> >맞춤제안(30%)</option>
								<option value="007" <?php if(isset($filter)&&$search_mode=='detail' && $filter[9] == '007'){echo "selected";} ?> >수정견적(35%)</option>
								<option value="008" <?php if(isset($filter)&&$search_mode=='detail' && $filter[9] == '008'){echo "selected";} ?> >RFI(40%)</option>
								<option value="009" <?php if(isset($filter)&&$search_mode=='detail' && $filter[9] == '009'){echo "selected";} ?> >RFP(45%)</option>
								<option value="010" <?php if(isset($filter)&&$search_mode=='detail' && $filter[9] == '010'){echo "selected";} ?> >BMT(50%)</option>
								<option value="011" <?php if(isset($filter)&&$search_mode=='detail' && $filter[9] == '011'){echo "selected";} ?> >DEMO(55%)</option>
								<option value="012" <?php if(isset($filter)&&$search_mode=='detail' && $filter[9] == '012'){echo "selected";} ?> >가격경쟁(60%)</option>
								<option value="013" <?php if(isset($filter)&&$search_mode=='detail' && $filter[9] == '013'){echo "selected";} ?> >Spen in(70%)</option>
								<option value="014" <?php if(isset($filter)&&$search_mode=='detail' && $filter[9] == '014'){echo "selected";} ?> >수의계약(80%)</option>
								<option value="015" <?php if(isset($filter)&&$search_mode=='detail' && $filter[9] == '015'){echo "selected";} ?> >수주완료(85%)</option>
								<option value="016" <?php if(isset($filter)&&$search_mode=='detail' && $filter[9] == '016'){echo "selected";} ?> >매출발생(90%)</option>
								<option value="017" <?php if(isset($filter)&&$search_mode=='detail' && $filter[9] == '017'){echo "selected";} ?> >미수잔금(95%)</option>
								<option value="018" <?php if(isset($filter)&&$search_mode=='detail' && $filter[9] == '018'){echo "selected";} ?> >수금완료(100%)</option>
							</select>
						</td>
						<td>계산서발행</td>
						<td>
							<select id="filter11" class="select-common select-style1 filtercolumn">
								<option value="">선택</option>
								<option value="0" <?php if(isset($filter)&&$search_mode=='detail' && $filter[10] == '0'){echo "selected";} ?>>미발행</option>
								<option value="1" <?php if(isset($filter)&&$search_mode=='detail' && $filter[10] == '1'){echo "selected";} ?>>발행중</option>
								<option value="100" <?php if(isset($filter)&&$search_mode=='detail' && $filter[10] == '100'){echo "selected";} ?>>발행완료</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>예상월</td>
						<td colspan="3">
							<input type="text" id="filter8" class="input-common filtercolumn datepicker" value='<?php if(isset($filter)&&$search_mode=='detail'){echo $filter[7];} ?>' autocomplete="off"/>
							~
							<input type="text" id="filter16" class="input-common filtercolumn datepicker" value='<?php if(isset($filter)&&$search_mode=='detail'){echo $filter[15];} ?>' autocomplete="off"/>
						</td>
						<td>매출금액</td>
						<td colspan="3">
							<input type="text" id="filter13" class="input-common filtercolumn" style="text-align:right;margin-right:0" onchange="numberFormat(this)" value='<?php if(isset($filter)&&$search_mode=='detail'){if($filter[12]!=""){echo number_format($filter[12]);}} ?>' />원&nbsp;~
							<input type="text" id="filter14" class="input-common filtercolumn" style="text-align:right;margin-right:0" onchange="numberFormat(this)" value='<?php if(isset($filter)&&$search_mode=='detail'){if($filter[13]!=""){echo number_format($filter[13]);}} ?>' />원
						</td>
					</tr>
				</div>
			</table>
		</td>
	</tr>

	<tr id="search_tr2" class="search_title" style="<?php if($search_mode == 'detail'){echo 'display:none';} ?>" onkeydown="if(event.keyCode==13) return GoSearch('simple');">
		<td align="left" valign="top">
			<table width="100%" id="filter_table2">
				<td>
					<div style="float:left;white-space:nowrap">
						판매종류
						<select id="filter2_1" class="select-common select-style1 filtercolumn2">
							<option value="" >선택</option>
							<option value="1" <?php if(isset($filter)&&$search_mode=='simple' && $filter[0] == '1'){echo "selected";} ?> >판매</option>
							<option value="2" <?php if(isset($filter)&&$search_mode=='simple' && $filter[0] == '2'){echo "selected";} ?> >용역</option>
							<option value="3" <?php if(isset($filter)&&$search_mode=='simple' && $filter[0] == '3'){echo "selected";} ?> >유지보수</option>
							<option value="4" <?php if(isset($filter)&&$search_mode=='simple' && $filter[0] == '4'){echo "selected";} ?> >조달</option>
							<option value="0" <?php if(isset($filter)&&$search_mode=='simple' && $filter[0] == '0'){echo "selected";} ?> >선택없음</option>
						</select>
						진척단계
						<select id="filter2_2" class="select-common select-style1 filtercolumn2">
							<option value="" >선택</option>
							<option value="001" <?php if(isset($filter)&&$search_mode=='simple' && $filter[1] == '001'){echo "selected";} ?> >영업보류(0%)</option>
							<option value="002" <?php if(isset($filter)&&$search_mode=='simple' && $filter[1] == '002'){echo "selected";} ?> >고객문의(5%)</option>
							<option value="003" <?php if(isset($filter)&&$search_mode=='simple' && $filter[1] == '003'){echo "selected";} ?> >영업방문(10%)</option>
							<option value="004" <?php if(isset($filter)&&$search_mode=='simple' && $filter[1] == '004'){echo "selected";} ?> >일반제안(15%)</option>
							<option value="005" <?php if(isset($filter)&&$search_mode=='simple' && $filter[1] == '005'){echo "selected";} ?> >견적제출(20%)</option>
							<option value="006" <?php if(isset($filter)&&$search_mode=='simple' && $filter[1] == '006'){echo "selected";} ?> >맞춤제안(30%)</option>
							<option value="007" <?php if(isset($filter)&&$search_mode=='simple' && $filter[1] == '007'){echo "selected";} ?> >수정견적(35%)</option>
							<option value="008" <?php if(isset($filter)&&$search_mode=='simple' && $filter[1] == '008'){echo "selected";} ?> >RFI(40%)</option>
							<option value="009" <?php if(isset($filter)&&$search_mode=='simple' && $filter[1] == '009'){echo "selected";} ?> >RFP(45%)</option>
							<option value="010" <?php if(isset($filter)&&$search_mode=='simple' && $filter[1] == '010'){echo "selected";} ?> >BMT(50%)</option>
							<option value="011" <?php if(isset($filter)&&$search_mode=='simple' && $filter[1] == '011'){echo "selected";} ?> >DEMO(55%)</option>
							<option value="012" <?php if(isset($filter)&&$search_mode=='simple' && $filter[1] == '012'){echo "selected";} ?> >가격경쟁(60%)</option>
							<option value="013" <?php if(isset($filter)&&$search_mode=='simple' && $filter[1] == '013'){echo "selected";} ?> >Spen in(70%)</option>
							<option value="014" <?php if(isset($filter)&&$search_mode=='simple' && $filter[1] == '014'){echo "selected";} ?> >수의계약(80%)</option>
							<option value="015" <?php if(isset($filter)&&$search_mode=='simple' && $filter[1] == '015'){echo "selected";} ?> >수주완료(85%)</option>
							<option value="016" <?php if(isset($filter)&&$search_mode=='simple' && $filter[1] == '016'){echo "selected";} ?> >매출발생(90%)</option>
							<option value="017" <?php if(isset($filter)&&$search_mode=='simple' && $filter[1] == '017'){echo "selected";} ?> >미수잔금(95%)</option>
							<option value="018" <?php if(isset($filter)&&$search_mode=='simple' && $filter[1] == '018'){echo "selected";} ?> >수금완료(100%)</option>
						</select>
						정보통신공사업
						<select id="filter2_3" class="select-common select-style1 filtercolumn2">
							<option value="">선택</option>
							<option value="Y" <?php if(isset($filter)&&$search_mode=='simple' && $filter[2] == 'Y'){echo "selected";} ?>>신청</option>
							<option value="N" <?php if(isset($filter)&&$search_mode=='simple' && $filter[2] == 'N'){echo "selected";} ?>>미신청</option>
						</select>
						매출금액
						<input type="text" id="filter2_4" class="input-common filtercolumn2" style="text-align:right;width:100px;margin-right:0" onchange="numberFormat(this)" value='<?php if(isset($filter)&&$search_mode=='simple'){if($filter[3]!=""){echo number_format($filter[3]);}} ?>' />원
						&nbsp;~
						<input type="text" id="filter2_5" class="input-common filtercolumn2" style="text-align:right;width:100px;margin-right:0" onchange="numberFormat(this)" value='<?php if(isset($filter)&&$search_mode=='simple'){if($filter[4]!=""){echo number_format($filter[4]);}} ?>' />원
						<input type="text" id="filter2_6" class="input-common filtercolumn2" value="<?php if(isset($filter)&&$search_mode=='simple'){echo $filter[5];} ?>" style="margin-left:10px;" placeholder="검색하세요.">
						<input type="button" class="btn-common btn-style2" value="검색" style="margin-left:10px;" onclick="return GoSearch('simple');">
					</div>
				</td>
			</table>
		</td>
	</tr>
<!-- 검색 끝 -->
<!-- 본문 -->
<tr height="35%" id="content_tr">
<td valign="top" style="padding:15px 0px 0px 0px">
	<table class="list_tbl list" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td id="tablePlus"><table width="100%" border="0" cellspacing="0" cellpadding="0">
				<colgroup>
					<col width="2.37%" />  <!--번    호-->
					<col width="2.37%" />	<!--종    류-->
					<col width="9%" />	<!--고 객 사-->
					<col width="11.58%" />	<!--프로젝트-->
					<col width="5.58%" />	<!--매 출 처-->
					<col width="5.58%" />	<!--제 조 사-->
					<col width="8.58%" />	<!--제 품 명 5%-->
					<col width="5.58%" />	<!--예 상 월-->
					<col width="5.58%" />	<!--진척단계-->
					<col width="5.58%" />	<!--진척단계-->
					<col width="5.58%" />	<!--매출금액 6%-->
					<col width="5.58%" />	<!--매입금액 6%-->
					<col width="6.58%" />	<!--마진금액 6%-->
					<col width="4.08%" />	<!--마 진 율-->
					<col width="7.58%" />	<!--업    체-->
					<col width="4.08%" />	<!--담당부서-->
					<col width="4.72%" />	<!--담 당 자-->
				</colgroup>

				<tr class="t_top row-color1">
					<th align="center">번호</th>
					<th align="center">종류</th>
					<th align="center">고객사</th>
					<th align="center">프로젝트</th>
					<th align="center">매출처</th>
					<th align="center">제조사</th>
					<th align="center">제품명</th>
					<!-- <td colspan="2" align="center" style="height:30px;">제안제품</td> -->
					<th align="center">예상월</th>
					<th align="center">진척단계</th>
					<th align="center">계산서발행</th>
					<th align="center">매출금액</th>
					<th align="center">매입금액</th>
					<th align="center">마진금액</th>
					<th align="center">마진율</th>
					<th align="center">업체</th>
					<th align="center">사업부</th>
					<th align="center">영업담당자</th>
				</tr>

<?php
if ($count > 0) {
$i = $count - $no_page_list * ( $cur_page - 1 );
$icounter = 0;

foreach ( $list_val as $item ) {

	if($item['type']==1){
		$strType = "판매";
	}else if($item['type']==2){
		$strType = "용역";
	}else if($item['type']==3){
		$strType = "유지보수";
	}else if($item['type']==4){
		$strType = "조달";
	}else{
		$strType = "";
	}

	if($item['progress_step'] == "001") {
		$strStep = "영업보류(0%)";
	} else if($item['progress_step'] == "002") {
		$strStep = "고객문의(5%)";
	} else if($item['progress_step'] == "003") {
		$strStep = "영업방문(10%)";
	} else if($item['progress_step'] == "004") {
		$strStep = "일반제안(15%)";
	} else if($item['progress_step'] == "005") {
		$strStep = "견적제출(20%)";
	} else if($item['progress_step'] == "006") {
		$strStep = "맞춤제안(30%)";
	} else if($item['progress_step'] == "007") {
		$strStep = "수정견적(35%)";
	} else if($item['progress_step'] == "008") {
		$strStep = "RFI(40%)";
	} else if($item['progress_step'] == "009") {
		$strStep = "RFP(45%)";
	} else if($item['progress_step'] == "010") {
		$strStep = "BMT(50%)";
	} else if($item['progress_step'] == "011") {
		$strStep = "DEMO(55%)";
	} else if($item['progress_step'] == "012") {
		$strStep = "가격경쟁(60%)";
	} else if($item['progress_step'] == "013") {
		$strStep = "Spen in(70%)";
	} else if($item['progress_step'] == "014") {
		$strStep = "수의계약(80%)";
	} else if($item['progress_step'] == "015") {
		$strStep = "수주완료(85%)";
	} else if($item['progress_step'] == "016") {
		$strStep = "매출발생(90%)";
	} else if($item['progress_step'] == "017") {
		$strStep = "미수잔금(95%)";
	} else if($item['progress_step'] == "018") {
		$strStep = "수금완료(100%)";
	}
?>
			 <?php if($cnum == $item['company_num'] || $sales_lv >= 1 ) { ?>
				 <tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'" style="cursor:pointer" onclick="ViewBoard('<?php echo $item['seq'];?>')" onmousedown="copy_div(event, this, '<?php echo $item['seq'];?>');"><?php } else {?>
					 <tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'"><?php } ?>
					<td height="40" align="center"><?php echo $i;?></td>
					<td align="center"><?php echo $strType;?></td>
					<td align="center"><?php echo $item['customer_companyname'];?></td>
					<td align="center"><?php echo $item['project_name'];?></td>
					<td align="center"><?php echo $item['sales_companyname'];?></td>
					<td align="center"><?php echo $item['product_company'];?></td>
					<td align="center"><?php echo $item['product_name'];?></td>
					<td align="center"><?php echo $item['exception_saledate'];?></td>
					<td align="center"><?php echo $strStep;?></td>
					<td align="center">
						<?php if($item['bill_progress_step'] == ""){
							echo "미발행";

						}else if($item['bill_progress_step'] == 100){
							echo "발행완료<br>({$item['bill_progress_step']}%)";
						}else if($item['bill_progress_step'] > 0){
							echo "발행중<br>(".round($item['bill_progress_step'], 5)."%)";
						}?>
					</td>
					<td align="center"><?php if(substr($item['division_month'], 0, 1) === "m"){echo number_format($item['forcasting_sales']/(substr($item['division_month'],1)));}else{echo number_format($item['forcasting_sales']/(12/$item['division_month']));}?></td>
					<td align="center"><?php if(substr($item['division_month'], 0, 1) === "m"){echo number_format($item['forcasting_purchase']/(substr($item['division_month'],1)));}else{echo number_format($item['forcasting_purchase']/(12/$item['division_month']));}?></td>
					<td align="center"><?php if($item['forcasting_profit'] != 0){if(substr($item['division_month'], 0, 1) === "m"){echo number_format($item['forcasting_profit']/(substr($item['division_month'],1)));}else{echo number_format($item['forcasting_profit']/(12/$item['division_month']));}}else{echo 0;}?></td>
					<td align="center"><?php if($item['forcasting_profit'] != 0 && $item['forcasting_profit'] > 0){ echo number_format($item['forcasting_profit']*100/$item['forcasting_sales'],1)."%";}?></td>
					<td align="center"><?php echo $item['cooperation_companyname'];?></td></a>
					<td align="center"><?php echo $item['dept'];?></td></a>
					<td align="center"><?php echo $item['cooperation_username'];?></td></a>
				</tr>

 <?php
	$i--;
	$icounter++;
}
} else {
?>
<tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'">
					<td width="100%" height="40" align="center" colspan="18">등록된 게시물이 없습니다.</td>
				</tr>
				<tr>
					<td colspan="17" height="1" bgcolor="#e8e8e8"></td>
				</tr>
<?php
}
?>


</table>
</td>
</tr>
</table>
</td>
</tr>
<!-- 본문 끝 -->
<!-- 금액조회 시작 -->
<tr id="amount_tr">
	<?php
		$total_sales = 0;
		$total_purchase = 0;
		$total_profit = 0;
		foreach ($amount_list_val as $alv) {
			$total_sales = $total_sales + (int)$alv['forcasting_sales'];
			$total_purchase = $total_purchase + (int)$alv['forcasting_purchase'];
			$total_profit = $total_profit + (int)$alv['forcasting_profit'];
		}
		if ($forcasting_plus) {
			$total_sales = $total_sales + $forcasting_plus['sum'];
			$total_profit = $total_profit + $forcasting_plus['sum'];
		}
		if ($forcasting_minus) {
			$total_sales = $total_sales - $forcasting_minus['sum'];
			$total_profit = $total_profit - $forcasting_minus['sum'];
		}
	?>
	<td style="text-align:center;">
		<table style="width:100%;" border="0" cellpadding="0" cellspacing="0">
			<colgroup>
				<col width="33.3%">
				<col width="33.3%">
				<col width="33.3%">
			</colgroup>
			<tr height="50">
				<td style="text-align:center;font-size:14px;font-weight:bold;background-color:#FFEDED;">
					매출합계 : <span style="color:#E53737"><?php echo number_format($total_sales); ?></span>원
				</td>
				<td style="text-align:center;font-size:14px;font-weight:bold;background-color:#F2FCFF;">
					매입합계 :
					<span style="color:#007BCB"><?php echo number_format($total_purchase); ?></span>원
				</td>
				<td style="text-align:center;font-size:14px;font-weight:bold;background-color:#FFFFF2;">
					이익합계 :
					<span style="color:#1C1C1C"><?php echo number_format($total_profit); ?></span>원
				</td>
			</tr>
		</table>
	</td>
</tr>
<!-- 금액조회 끝 -->
<!--페이징-->
<tr height="40%" id="paging_tr">
	<td align="center" valign="top" style="padding-top:10px;">
	<div style="width:33%;float:left;">
		<input type="button" class="btn-common btn-updownload" value="엑셀 다운로드" style="width:auto;float:left;padding-left:20px;" onclick="excelDownload('excelTable','forcasting');">
		<img src="/misc/img/download_btn.svg" style="float:left; width:12px;position:relative;top:7px; right:105px; padding:2px;">
	</div>
	<div style="width:33%;float:left;">
		<?php if ($count > 0) {?>
		<table width="400" border="0" cellspacing="0" cellpadding="0">
				<tr>
		<?php
		if ($cur_page > 10){
		?>
				<td width="19"><a href="JavaScript:GoFirstPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_last_left.svg" width="20" height="20"/></a></td>
				<td width="2"></td>
				<td width="19"><a href="JavaScript:GoPrevPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_left.svg" width="20" height="20"/></a></td>
		<?php
		} else {
		?>
		<td width="19"></td>
					<td width="2"></td>
					<td width="19"></td>
		<?php
		}
		?>
					<td align="center">
		<?php
		for  ( $i = $start_page; $i <= $end_page ; $i++ ){
		if( $i == $end_page ) {
			$strSection = "";
		} else {
			$strSection = "&nbsp;<span class=\"section\">&nbsp&nbsp</span>&nbsp;";
		}

		if  ( $i == $cur_page ) {
			echo "<a href=\"JavaScript:GoPage( '".$i."' )\" class=\"alink\"><font color=\"#33ccff\">".$i."</font></a>".$strSection;
		} else {
			echo "<a href=\"JavaScript:GoPage( '".$i."' )\" class=\"alink\">".$i."</a>".$strSection;
		}
		}
		?></td>
					<?php
		if   ( floor( ( $cur_page - 1 ) / 10 ) < floor( ( $total_page - 1 ) / 10 ) ){
		?>
		<td width="19"><a href="JavaScript:GoNextPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_right.svg" width="20" height="20"/></a></td>
					<td width="2"></td>
					<td width="19"><a href="JavaScript:GoLastPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_last_right.svg" width="20" height=svg"20"/></a></td>
		<?php
		} else {
		?>
		<td width="19"></td>
					<td width="2"></td>
					<td width="19"></td>
		<?php
		}
		?>
				</tr>
			</table>

		<?php }?>

	</div>
	<div style="width:33%;float:right;">
		<select class="select-common select-style1" id="listPerPage" style="height:25px;float:right;" onchange="change_lpp();">
			<option value="5" <?php if($lpp==5){echo 'selected';} ?>>5건 / 페이지</option>
			<option value="10" <?php if($lpp==10){echo 'selected';} ?>>10건 / 페이지</option>
			<option value="15" <?php if($lpp==15){echo 'selected';} ?>>15건 / 페이지</option>
			<option value="20" <?php if($lpp==20){echo 'selected';} ?>>20건 / 페이지</option>
			<option value="30" <?php if($lpp==30){echo 'selected';} ?>>30건 / 페이지</option>
			<option value="50" <?php if($lpp==50){echo 'selected';} ?>>50건 / 페이지</option>
		</select>
	</div>
	</td>
</tr>
              <!--리스트-->

              <!--리스트-->
<script language="javascript">
function GoFirstPage (){
	document.mform.cur_page.value = 1;
	document.mform.submit();
}

function GoPrevPage (){
	var	cur_start_page = <?php echo $cur_page;?>;

	document.mform.cur_page.value = Math.floor( ( cur_start_page - 11 ) / 10 ) * 10 + 1;
	document.mform.submit( );
}

function GoPage(nPage){
	document.mform.cur_page.value = nPage;
	document.mform.submit();
}

function GoNextPage (){
	var	cur_start_page = <?php echo $cur_page;?>;

	document.mform.cur_page.value = Math.floor( ( cur_start_page + 9 ) / 10 ) * 10 + 1;
	document.mform.submit();
}

function GoLastPage (){
	var	total_page = <?php echo $total_page;?>;
//	alert(total_page);

	document.mform.cur_page.value = total_page;
	document.mform.submit();
}

function ViewBoard (seq){
	document.mform.action = "<?php echo site_url();?>/sales/forcasting/order_completed_view";
	document.mform.seq.value = seq;
	document.mform.mode.value = "modify";

	document.mform.submit();
}
</script>

</tbody>
</table>
</form>
</div>
</div>

<!-- 창 -->
<div id="copy_div" style="height:30%;width:40%;background-color:#ffffff; display:none;border-radius:2em;">

    <div class="copy_item" style="font-size:24px;font-weight:bold;">
      포캐스팅 복사
    </div>
    <div class="copy_item" style="font-size:18px; color:#a19d9d;font-weight:bold;">
			<form action="<?php echo site_url();?>/sales/forcasting/forcasting_copy" method="post">
			<input type="hidden" name="org_seq" id="org_seq" value="">
      프로젝트명
			<input type="text" style="width:400px" name="copy_project_name" id="copy_project_name" value="">
			<button type="submit" id="copy_submit" style="display:none;"></button>
		</form>
    </div>
    <div class="copy_item">
			<!-- <label for="copy_submit"> -->
      <button type="button" name="button" class="skyBtn" style="width:70px" onclick="$('#copy_submit').trigger('click');">복사</button>
		<!-- </label> -->
      <button type="button" name="button" class="skyBtn" style="background-color:#FF6666;width:70px" onclick="$('#copy_div').bPopup().close();">취소</button>
    </div>
</div>

  <!--하단-->
  <?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
  <!--하단-->
<script>
  function excelDownload(id, title) {
    var excel_download_table = "";
    excel_download_table += '<table id="excelTable" width="100%" border="0" cellspacing="0" cellpadding="0" style="display:none;"><colgroup><col width="3%" /><col width="3%" /><col width="12%" /><col width="13%" /><col width="5%" /><col width="5%" /><col width="5%" /><col width="5%" /><col width="5%" /><col width="7%" /><col width="7%" /><col width="8%" /><col width="4%" /><col width="8%" /><col width="5%" /><col width="5%" /></colgroup>';
    // excel_download_table +='<tr><td colspan="16" height="2" bgcolor="#797c88"></td></tr>';
    excel_download_table +='<tr bgcolor="f8f8f9" class="t_top"><td rowspan="2" align="center" class="t_border">번호</td><td rowspan="2" align="center" class="t_border">종류</td><td rowspan="2" align="center" class="t_border">고객사</td><td rowspan="2" align="center" class="t_border">프로젝트</td><td rowspan="2" align="center" class="t_border">매출처</td><td colspan="2" align="center" class="t_border" style="height:30px;">제안제품</td>';
    excel_download_table +='<td rowspan="2" align="center" class="t_border">예상월</td><td rowspan="2" align="center" class="t_border">진척단계</td><td rowspan="2" align="center" class="t_border">매출금액</td><td rowspan="2" align="center" class="t_border">매입금액</td><td rowspan="2" align="center" class="t_border">마진금액</td><td rowspan="2" align="center" class="t_border">마진율</td><td rowspan="2" align="center" class="t_border">업체</td><td rowspan="2" align="center" class="t_border">사업부</td><td rowspan="2" align="center" class="t_border">영업담당자</td></tr>';
    excel_download_table +='<tr><td style="border-top:1px solid #797c88; height:30px;" bgcolor="#f8f8f9" align="center" class="t_border">제조사</td><td style="border-top:1px solid #797c88; height:30px;" bgcolor="#f8f8f9" align="center" class="t_border">제품명</td></tr>';
			<?php
        $cnt = 1;
					foreach ( $excel_val as $item ) {
            if($item['type']==1){
							$strType = "판매";
						}else if($item['type']==2){
							$strType = "용역";
						}else if($item['type']==3){
              $strType = "유지보수";
            }else if($item['type']==4){
              $strType = "조달";
            }else{
							$strType = "";
						}

						if($item['progress_step'] == "001") {
							$strStep = "영업보류(0%)";
						} else if($item['progress_step'] == "002") {
							$strStep = "고객문의(5%)";
						} else if($item['progress_step'] == "003") {
							$strStep = "영업방문(10%)";
						} else if($item['progress_step'] == "004") {
							$strStep = "일반제안(15%)";
						} else if($item['progress_step'] == "005") {
							$strStep = "견적제출(20%)";
						} else if($item['progress_step'] == "006") {
							$strStep = "맞춤제안(30%)";
						} else if($item['progress_step'] == "007") {
							$strStep = "수정견적(35%)";
						} else if($item['progress_step'] == "008") {
							$strStep = "RFI(40%)";
						} else if($item['progress_step'] == "009") {
							$strStep = "RFP(45%)";
						} else if($item['progress_step'] == "010") {
							$strStep = "BMT(50%)";
						} else if($item['progress_step'] == "011") {
							$strStep = "DEMO(55%)";
						} else if($item['progress_step'] == "012") {
							$strStep = "가격경쟁(60%)";
						} else if($item['progress_step'] == "013") {
							$strStep = "Spen in(70%)";
						} else if($item['progress_step'] == "014") {
							$strStep = "수의계약(80%)";
						} else if($item['progress_step'] == "015") {
							$strStep = "수주완료(85%)";
						} else if($item['progress_step'] == "016") {
							$strStep = "매출발생(90%)";
						} else if($item['progress_step'] == "017") {
							$strStep = "미수잔금(95%)";
						} else if($item['progress_step'] == "018") {
							$strStep = "수금완료(100%)";
						}
			?>
      <?php if($cnum == $item['company_num'] || $sales_lv >= 1) { ?>
        excel_download_table +='<tr onmouseover="this.style.backgroundColor='+"#FAFAFA"+'" onmouseout="this.style.backgroundColor='+'#fff'+'" style="cursor:pointer" onclick="ViewBoard(<?php echo $item['seq'];?>)">';
      <?php } else {?>
        excel_download_table +='<tr onmouseover="this.style.backgroundColor='+'#FAFAFA'+'" onmouseout="this.style.backgroundColor='+'#fff'+'">';
      <?php } ?>
        excel_download_table += '<td height="40" align="center"><?php echo $cnt;?></td><td align="center" class="t_border"><?php echo $strType;?></td><td align="center" class="t_border"><?php echo $item['customer_companyname'];?></td><td align="center" class="t_border"><?php echo addslashes($item['project_name']);?></td>';
        excel_download_table += '<td align="center" class="t_border"><?php echo $item['sales_companyname'];?></td><td align="center" class="t_border"><?php echo $item['product_company'];?></td><td align="center" class="t_border"><?php echo $item['product_name'];?></td><td align="center" class="t_border"><?php echo $item['exception_saledate'];?></td>';
        excel_download_table += '<td align="center" class="t_border"><?php echo $strStep;?></td><td align="center" class="t_border"><?php if(substr($item['division_month'], 0, 1) === "m"){echo number_format($item['forcasting_sales']/(substr($item['division_month'],1)));}else{echo number_format($item['forcasting_sales']/(12/$item['division_month']));}?></td><td align="center" class="t_border"><?php if(substr($item['division_month'], 0, 1) === "m"){echo number_format($item['forcasting_purchase']/(substr($item['division_month'],1)));}else{echo number_format($item['forcasting_purchase']/(12/$item['division_month']));}?></td><td align="center" class="t_border"><?php if($item['forcasting_profit']!=0){if(substr($item['division_month'], 0, 1) === "m"){echo number_format($item['forcasting_profit']/(substr($item['division_month'],1)));}else{echo number_format($item['forcasting_profit']/(12/$item['division_month']));}}else{echo 0;}?></td>';
        excel_download_table += '<td align="center" class="t_border"><?php if($item['forcasting_profit']!=0 && $item['forcasting_profit'] > 0) echo number_format($item['forcasting_profit']*100/$item['forcasting_sales'],1)."%";?></td><td align="center" class="t_border"><?php echo $item['cooperation_companyname'];?></td></a><td align="center" class="t_border"><?php echo $item['dept'];?></td></a><td align="center" class="t_border"><?php echo $item['cooperation_username'];?></td></a></tr>';
        // excel_download_table += '<tr><td colspan="16" height="1" bgcolor="#e8e8e8"></td></tr>';
      <?php
      $cnt++;
      }
      ?>

    excel_download_table +='<td colspan="16" height="2" bgcolor="#797c88"></td></tr></table>';

    $("#tablePlus").append(excel_download_table);

    var tab_text = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
    tab_text = tab_text + '<head><meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">';
    tab_text = tab_text + '<xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>'
    tab_text = tab_text + '<x:Name>Test Sheet</x:Name>';
    tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:Panes></x:WorksheetOptions></x:ExcelWorksheet>';
    tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>';
    tab_text = tab_text + "<table border='1px'>";
    var exportTable = $('#' + id).clone();
    exportTable.find('input').each(function (index, elem) {
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

  function showhide(type){
    $(".toggleDownBtn").toggle();
    $(".toggleUpBtn").toggle();

		if(type=="down"){
			$("#search_tr").show();
			$("#search_tr2").hide();
		} else {
			$("#search_tr2").show();
			$("#search_tr").hide();
		}
  }

  //금액 천단위 마다 ,
	function numberFormat(obj) {
		// if (obj.value == "") {
		// 	obj.value = 0;
		// }
		var inputText = obj.value.replace(/[^-?0-9]/gi,"") // 숫자와 - 가능
		var inputNumber = inputText.replace(/,/g, "");
		var fomatnputNumber = inputNumber.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, "$1,");
		obj.value = fomatnputNumber;
	}

	function change_lpp(){
		var lpp = $("#listPerPage").val();
		document.mform.lpp.value = lpp;
		document.mform.submit();
	}

	function copyopen(){
		$("#copy_div").bPopup({
			speed: 450,
			transition: 'slideDown'
		})
	}

function copy_div(e, obj, seq){

	$("#org_seq").val();
	$("#copy_project_name").val();
	var org_project_name = $(obj).find("td").eq(4).html();
	var org_seq = seq;
	$("#org_seq").val(org_seq);
	$("#copy_project_name").val(org_project_name);
			if ((e.button == 2) || (e.which == 3)) {
				document.addEventListener('contextmenu', function() {
					 event.preventDefault();
				});

				copyopen();

			}
	}

$('.datepicker').datepicker();
</script>
</body>
</html>
