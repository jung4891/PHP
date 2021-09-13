<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";

if($search_keyword != ''){
	$filter = explode(',',str_replace('"', '&uml;',$search_keyword));
}
?>
<style>

.select2-selection{
	height: 30px;
	border-color: #B6B6B6;
	border-radius: 3px;
	color: #B0B0B0;
	vertical-align: middle;
	font-family: "Noto Sans KR", sans-serif !important;
}

#search_tr, #search_tr2 {
	font-weight: bold;
	font-size: 13px;
}

#search_tr td {
	padding-top:2px;
}

#search_tr input {
	width:120px;
}
#search_tr2 input {
	width:136px;
	margin-right: 10px;
}

#search_tr select {
	width:150px;
}
#search_tr2 select {
	width:142px;
	margin-right: 10px;
}
</style>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/js/select2.min.js"></script>
<script type="text/javascript" src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>
<script language="javascript">

function GoSearch(mode){
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
				if(i == 7 || i == 8){
					filter_val = String(filter_val).replace(/,/g, "");
				}
				searchkeyword += ',' + filter_val;
			}

		}
	}

  $("#searchkeyword").val(searchkeyword);

  if (searchkeyword.replace(/,/g, "") == "") {
    alert("검색어가 없습니다.");
	location.href="<?php echo site_url();?>/sales/maintain/maintain_list";
	return false;
  }

  document.mform.action = "<?php echo site_url();?>/sales/maintain/maintain_list";
  document.mform.cur_page.value = "";
  document.mform.submit();
}

</script>
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
	<form name="mform" action="<?php echo site_url();?>/sales/maintain/maintain_list" method="get">
		<table width="96%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
			<input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
			<input type="hidden" name="lpp" value="<?php echo $no_page_list; ?>">
			<input type="hidden" name="seq" value="">
			<input type="hidden" name="mode" value="">
			<input type="hidden" name="type" value="<?php echo $type; ?>">
			<input type="hidden" id="searchkeyword" name="searchkeyword" value="<?php echo str_replace('"', '&uml;', $search_keyword );?>"/>
			<tbody height="100%">
				<!-- 타이틀 이미지 -->
				<tr height="5%">
	<?php if($type == "001"){?>
				  <td class="dash_title">유지보수</td>
	<?php }else{ ?>
				  <td class="dash_title">통합유지보수</td>
	<?php } ?>
				</tr>
				<tr height="65">
					<input type="hidden" id="search_mode" name="search_mode" value="<?php echo $search_mode; ?>">
				</tr>

				<!-- 검색창 -->
				<tr>
					<td align="left" valign="bottom">
						<div class="toggleUpBtn" onclick="showhide('up');" style="cursor:pointer;display:inline-block;<?php if($search_mode == 'simple'){echo 'display:none';} ?>">▲</div>

						<div class="toggleDownBtn" onclick="showhide('down');" style="cursor:pointer;display:inline-block;<?php if($search_mode == 'detail'){echo 'display:none';} ?>">
							<span style="color:#0575E6;">자세한 검색을 원하신다면</span>
							<span style="color:black;">▼</span>
						</div>
					</td>
				</tr>
				<tr height="20"></tr>
				<tr id="search_tr" style="<?php if($search_mode == 'simple'){echo 'display:none';} ?>" onkeydown="if(event.keyCode==13) return GoSearch('detail');">
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
									<td>유지보수<br>시작일</td>
									<td>
										<input type="date" id="filter3" class="input-common filtercolumn" value='<?php if(isset($filter)&&$search_mode=='detail'){echo $filter[2];} ?>'/>
									</td>
									<td>유지보수<br>종료일</td>
									<td>
										<input type="date" id="filter4" class="input-common filtercolumn" value='<?php if(isset($filter)&&$search_mode=='detail'){echo $filter[3];} ?>' />
									</td>
									<td>
										<input type="button" class="btn-common btn-style2" value="검색" style="width:60px;" onclick="return GoSearch('detail');">
									</td>
								</tr>
								<tr>
									<td>영업담당자<br>(두리안)</td>
									<td>
										<input type="text" id="filter5" class="input-common filtercolumn" value='<?php if(isset($filter)&&$search_mode=='detail'){echo $filter[4];} ?>' />
									</td>
									<td>제조사</td>
									<td>
										<input type="text" id="filter6" class="input-common filtercolumn" value='<?php if(isset($filter)&&$search_mode=='detail'){echo $filter[5];} ?>' />
									</td>
									<td>품목</td>
									<td>
										<input type="text" id="filter7" class="input-common filtercolumn" value='<?php if(isset($filter)&&$search_mode=='detail'){echo $filter[6];} ?>' />
									</td>
									<td>제품명</td>
									<td colspan="2">
										<input type="text" id="filter8" class="input-common filtercolumn" value='<?php if(isset($filter)&&$search_mode=='detail'){echo $filter[7];} ?>'/>
									</td>
								</tr>
								<tr>
									<td>관리팀</td>
									<td>
										<select id="filter9" class="select-common select-style1 filtercolumn">
											<option value="" >관리팀 선택</option>
											<option value="1" <?php if(isset($filter)&&$search_mode=='detail' && $filter[8] == '1'){echo "selected";} ?> >기술1팀</option>
											<option value="2" <?php if(isset($filter)&&$search_mode=='detail' && $filter[8] == '2'){echo "selected";} ?> >기술2팀</option>
											<option value="3" <?php if(isset($filter)&&$search_mode=='detail' && $filter[8] == '3'){echo "selected";} ?> >기술3팀</option>
										</select>
									</td>
									<td>점검여부</td>
									<td>
										<select id="filter10" class="select-common select-style1 filtercolumn">
											<option value="" >점검여부 선택</option>
											<option value="1" <?php if(isset($filter)&&$search_mode=='detail' && $filter[9] == '1'){echo "selected";} ?> >점검완료</option>
											<option value="0" <?php if(isset($filter)&&$search_mode=='detail' && $filter[9] == '0'){echo "selected";} ?> >점검미완료</option>
											<option value="2" <?php if(isset($filter)&&$search_mode=='detail' && $filter[9] == '2'){echo "selected";} ?> >점검미해당</option>
											<option value="9" <?php if(isset($filter)&&$search_mode=='detail' && $filter[9] == '9'){echo "selected";} ?> >예정</option>
											<option value="3" <?php if(isset($filter)&&$search_mode=='detail' && $filter[9] == '3'){echo "selected";} ?> >연기</option>
											<option value="4" <?php if(isset($filter)&&$search_mode=='detail' && $filter[9] == '4'){echo "selected";} ?> >협력사 점검</option>
										</select>
									</td>
									<td>계산서발행</td>
									<td>
										<select id="filter11" class="select-common select-style1 filtercolumn">
											<option value="">계산서 발행여부 선택</option>
											<option value="0" <?php if(isset($filter)&&$search_mode=='detail' && $filter[10] == '0'){echo "selected";} ?>>미발행</option>
											<option value="1" <?php if(isset($filter)&&$search_mode=='detail' && $filter[10] == '1'){echo "selected";} ?>>발행중</option>
											<option value="100" <?php if(isset($filter)&&$search_mode=='detail' && $filter[10] == '100'){echo "selected";} ?>>발행완료</option>
										</select>
									</td>
									<td>정보통신공사업</td>
									<td>
										<select id="filter12" class="select-common select-style1 filtercolumn">
											<option value="">신청여부 선택</option>
											<option value="Y" <?php if(isset($filter)&&$search_mode=='detail' && $filter[11] == 'Y'){echo "selected";} ?>>신청</option>
											<option value="N" <?php if(isset($filter)&&$search_mode=='detail' && $filter[11] == 'N'){echo "selected";} ?>>미신청</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>매출금액</td>
									<td colspan="7">
										<input type="text" id="filter13" class="input-common filtercolumn" style="text-align:right;margin-right:0" onchange="numberFormat(this)" value='<?php if(isset($filter)&&$search_mode=='detail'){if($filter[12]!=""){echo number_format($filter[12]);}} ?>' />원&nbsp;~
										<input type="text" id="filter14" class="input-common filtercolumn" style="text-align:right;margin-right:0" onchange="numberFormat(this)" value='<?php if(isset($filter)&&$search_mode=='detail'){if($filter[13]!=""){echo number_format($filter[13]);}} ?>' />원
									</td>
								</tr>
							</div>
						</table>
					</td>
					<td valign="bottom">
		<?php if($type == "001"){ ?>
						<div>
							<input type="button" class="btn-common btn-color2" style="width:110px;float:right;" value="유지보수 생성" onclick="$('#add_maintain_div').bPopup();">
						</div>
		<?php } ?>
					</td>
				</tr>

				<tr id="search_tr2" style="<?php if($search_mode == 'detail'){echo 'display:none';} ?>" onkeydown="if(event.keyCode==13) return GoSearch('simple');">
					<td align="left" valign="top">
						<table width="100%" id="filter_table2">
							<colgroup>
								<col width="60px">
								<col width="0px">
								<col width="60px">
								<col width="0px">
								<col width="65px">
								<col width="0px">
								<col width="110px">
								<col width="500px">
							</colgroup>
							<div style="float:left;white-space:nowrap">
								<tr>
									<td>관리팀</td>
									<td>
										<select id="filter2_1" class="select-common select-style1 filtercolumn2">
											<option value="" >관리팀 선택</option>
											<option value="1" <?php if(isset($filter)&&$search_mode=='simple' && $filter[0] == '1'){echo "selected";} ?> >기술1팀</option>
											<option value="2" <?php if(isset($filter)&&$search_mode=='simple' && $filter[0] == '2'){echo "selected";} ?> >기술2팀</option>
											<option value="3" <?php if(isset($filter)&&$search_mode=='simple' && $filter[0] == '3'){echo "selected";} ?> >기술3팀</option>
										</select>
									</td>
									<td>점검여부</td>
									<td>
										<select id="filter2_2" class="select-common select-style1 filtercolumn2">
											<option value="" >점검여부 선택</option>
											<option value="1" <?php if(isset($filter)&&$search_mode=='simple' && $filter[1] == '1'){echo "selected";} ?> >점검완료</option>
											<option value="0" <?php if(isset($filter)&&$search_mode=='simple' && $filter[1] == '0'){echo "selected";} ?> >점검미완료</option>
											<option value="2" <?php if(isset($filter)&&$search_mode=='simple' && $filter[1] == '2'){echo "selected";} ?> >점검미해당</option>
											<option value="9" <?php if(isset($filter)&&$search_mode=='simple' && $filter[1] == '9'){echo "selected";} ?> >예정</option>
											<option value="3" <?php if(isset($filter)&&$search_mode=='simple' && $filter[1] == '3'){echo "selected";} ?> >연기</option>
											<option value="4" <?php if(isset($filter)&&$search_mode=='simple' && $filter[1] == '4'){echo "selected";} ?> >협력사 점검</option>
										</select>
									</td>
									<td>계산서발행</td>
									<td colspan="8">
										<select id="filter2_3" class="select-common select-style1 filtercolumn2">
											<option value="">계산서 발행여부 선택</option>
											<option value="0" <?php if(isset($filter)&&$search_mode=='simple' && $filter[2] == '0'){echo "selected";} ?>>미발행</option>
											<option value="1" <?php if(isset($filter)&&$search_mode=='simple' && $filter[2] == '1'){echo "selected";} ?>>발행중</option>
											<option value="100" <?php if(isset($filter)&&$search_mode=='simple' && $filter[2] == '100'){echo "selected";} ?>>발행완료</option>
										</select>
										정보통신공사업
										<select id="filter2_4" class="select-common select-style1 filtercolumn2">
											<option value="">신청여부 선택</option>
											<option value="Y" <?php if(isset($filter)&&$search_mode=='simple' && $filter[3] == 'Y'){echo "selected";} ?>>신청</option>
											<option value="N" <?php if(isset($filter)&&$search_mode=='simple' && $filter[3] == 'N'){echo "selected";} ?>>미신청</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>유지보수<br>시작일</td>
									<td>
										<input type="date" id="filter2_5" class="input-common filtercolumn2" value='<?php if(isset($filter)&&$search_mode=='simple'){echo $filter[4];} ?>' style="width:140px;"/>
									</td>
									<td>유지보수<br>종료일</td>
									<td>
										<input type="date" id="filter2_6" class="input-common filtercolumn2" value='<?php if(isset($filter)&&$search_mode=='simple'){echo $filter[5];} ?>' style="width:140px;"/>
									</td>
									<td>매출금액</td>
									<td colspan="8">
										<input type="text" id="filter2_7" class="input-common filtercolumn2" style="text-align:right;margin-right:0;width:100px;" onchange="numberFormat(this)" value='<?php if(isset($filter)&&$search_mode=='simple'){if($filter[6]!=""){echo number_format($filter[6]);}} ?>' />원&nbsp;~
										<input type="text" id="filter2_8" class="input-common filtercolumn2" style="text-align:right;margin-right:0;width:100px;" onchange="numberFormat(this)" value='<?php if(isset($filter)&&$search_mode=='simple'){if($filter[7]!=""){echo number_format($filter[7]);}} ?>' />원
										<input type="text" id="filter2_9" class="input-common filtercolumn2" value="<?php if(isset($filter)&&$search_mode=='simple'){echo $filter[8];} ?>" style="margin-left:10px;width:200px;" placeholder="검색하세요.">
											<input type="button" class="btn-common btn-style2" value="검색" style="width:60px;" onclick="return GoSearch('simple');">
									</td>
									<td>
									</td>
								</tr>
							</div>
						</table>
					</td>
					<td valign="bottom">
					<?php if($type == "001"){ ?>
						<div>
							<input type="button" class="btn-common btn-color2" style="width:110px;float:right;" value="유지보수 생성" onclick="$('#add_maintain_div').bPopup();">
						</div>
					<?php } ?>
					</td>
				</tr>
				<!-- 검색 끝 -->
				<!-- 본문 -->
				<tr height="35%" id="content_tr">
					<td valign="top" style="padding:15px 0px 0px 0px" colspan="2">
						<table class="list_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td id="tablePlus">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<colgroup>
											<col width="2.51%" />  <!--번    호-->
											<col width="9.14%" />	<!--고 객 사-->
											<col width="11.72%" />	<!--프로젝트-->
											<col width="5.72%" />	<!--제조사-->
											<col width="5.72%" />	<!--품목-->
											<col width="8.72%" />	<!--제품명-->
											<col width="5.72%" />	<!--유지보수시작일-->
											<col width="5.72%" />	<!--유지보수종료일-->
											<col width="5.72%" />	<!--매출금액-->
											<col width="5.72%" />	<!--매입금액-->
											<col width="5.72%" />	<!--마진금액-->
											<col width="6.72%" />	<!--마진율-->
											<col width="4.22%" />	<!--점검주기-->
											<col width="7.72%" />	<!--관리팀-->
											<col width="4.22%" />	<!--점검여부-->
											<col width="4.86%" />	<!--알림-->
										</colgroup>
										<tr class="t_top row-color1">
											<th height="40" align="center">번호</th>
											<th align="center">고객사</th>
											<th align="center">프로젝트</th>
											<th align="center">제조사</th>
											<th align="center">품목</th>
											<th align="center">제품</th>
											<th align="center">유지보수시작일</th>
											<th align="center">유지보수종료일</th>
											<th align="center">매출금액</th>
											<th align="center">매입금액</th>
											<th align="center">마진금액</th>
											<th align="center">마진율</th>
											<th align="center">점검주기</th>
											<th align="center">관리팀</th>
											<th align="center">점검여부</th>
											<th align="center">알림</th>
										</tr>
			<?php
				if ($count > 0) {
					$i = $count - $no_page_list * ( $cur_page - 1 );
					$icounter = 0;

					foreach ( $list_val as $item ) {
						if($item['manage_team']=="1"){
							$strstep ="기술1팀";
						}else if($item['manage_team']=="2"){
							$strstep ="기술2팀";
						}else if($item['manage_team']=="3"){
							$strstep ="기술3팀";
						}else{
							$strstep ="없음";
						}
						if($cnum == $item['company_num'] || $sales_lv >= 1) {
					?>
										<tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'" style="cursor:pointer" onclick="ViewBoard('<?php echo $item['seq'];?>')">
					<?php
						} else {
					?>
										<tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'">
					<?php
						}
					?>
					            <td height="40" align="center"><?php echo $i;?></td>
					            <td align="center"><?php echo $item['customer_companyname'];?></td>
					            <td align="center"><?php echo $item['project_name'];?></td>
					            <td align="center"><?php echo $item['product_company'];?></td>
					            <td align="center"><?php echo $item['product_item'];?></td>
					            <td align="center"><?php echo $item['product_name'];?></td>
					            <td align="center"><?php echo $item['exception_saledate2'];?></td>
					            <td align="center"><?php echo $item['exception_saledate3'];?></td>
									 	 	<td align="center">
												<?php
													echo number_format($item['forcasting_sales']);
												?>
											</td>
											<td align="center">
												<?php
								 					echo number_format($item['forcasting_purchase']);
												?>
											</td>
											<td align="center">
												<?php
													if($item['forcasting_profit']!=0) {
														echo number_format($item['forcasting_profit']);
													}else{
														echo 0;
													}
					 							?>
											</td>
											<td align="center">
												<?php
													if($item['forcasting_profit']!=0 && $item['forcasting_profit'] > 0) {
														echo number_format($item['forcasting_profit']*100/$item['forcasting_sales'],1)."%";
													}
												?>
						 					</td>
              				<td align="center">
												<?php
													if ($item['maintain_cycle'] == "1") {
														echo "월점검";
													}else if ($item['maintain_cycle'] == "3") {
														echo "분기점검";
													}else if ($item['maintain_cycle'] == "6") {
														echo "반기점검";
													}else if ($item['maintain_cycle'] == "0") {
														echo "장애시";
													}else if ($item['maintain_cycle'] == "7") {
														echo "미점검";
													}else{
														echo "미선택";
													}
												?>
					    				</td>
              				<td align="center"><?php echo $strstep;?></td>
              				<td align="center">
												<?php
													switch($item['maintain_result']){
														case 0:
															echo "미완료";
															break;
														case 1:
															echo "완료";
															break;
														case 2:
															echo "미해당";
															break;
														case 9:
															echo "예정";
															break;
														default:
															echo "미선택";
															break;
													}
													?>
												</td>
												<?php
													$end_date = strtotime($item['exception_saledate3']);
													$today = strtotime(date('Y-m-d'));
													if ($today > $end_date) {
														$m = '기간만료';
													} else {
														$m = '진행';
													}
													if ($item['exception_saledate3'] == '') {
														$m = '';
													}
												?>
												<td align="center"><?php echo $m; ?></td>
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
              					<td colspan="16" height="1" bgcolor="#e8e8e8"></td>
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
					?>
						<td style="text-align:center;" colspan="2">
							<table style="width:100%;">
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
						<td align="center" valign="top" style="padding:15px;" colspan="2">
							<div style="width:33%;float:left;">
								<input type="button" class="btn-common btn-style2" value="엑셀 다운" style="width:100px;float:left;" onclick="excelDownload('excelTable','maintain');">
							</div>
							<div style="width:33%;float:left;">
								<?php if ($count > 0) {?>
									<table width="400" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<?php
												if ($cur_page > 10){
											?>
											<td width="19"><a href="JavaScript:GoFirstPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_first.png" width="20" height="20"/></a></td>
											<td width="2"></td>
											<td width="19"><a href="JavaScript:GoPrevPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_left.png" width="20" height="20"/></a></td>
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
												for ( $i = $start_page; $i <= $end_page ; $i++ ){
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
												?>
											</td>
											<?php
											if   ( floor( ( $cur_page - 1 ) / 10 ) < floor( ( $total_page - 1 ) / 10 ) ){
											?>
											<td width="19"><a href="JavaScript:GoNextPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_right.png" width="20" height="20"/></a></td>
											<td width="2"></td>
											<td width="19"><a href="JavaScript:GoLastPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_last.png" width="20" height="20"/></a></td>
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
								<?php } ?>
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

				<!-- 페이징  끝-->
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
					document.mform.action = "<?php echo site_url();?>/sales/maintain/maintain_view";
					document.mform.seq.value = seq;
					document.mform.mode.value = "modify";

					document.mform.submit();
				}
				function change_lpp(){
					var lpp = $("#listPerPage").val();
					document.mform.lpp.value = lpp;
					document.mform.submit();
				}
				</script>
			</tbody>
		</table>
	</form>
</div>
</div>

<!-- 유지보수 생성 모달 시작 -->
<div id="add_maintain_div" style="display:none; position: absolute; background-color: white; width: auto; height: auto;">
	<form name="cform" action="<?php echo site_url();?>/sales/maintain/forcasting_duplication" method="post" onSubmit="javascript:chkForm();return false;">
    <table width="700px" height="100%" style="padding:20px 18px;" border="0" cellspacing="0" cellpadding="0">
			<colgroup>
				<col width=20%>
				<col width=70%>
				<col width=10%>
			</colgroup>
      <tr>
        <td colspan="3" align="left" valign="top" class="tbl-sub-title">유지보수 생성</td>
      </tr>
			<tr class="tbl-tr border-b">
        <td align="left" style="font-weight:bold;font-size:14px;padding-bottom:5px;">포캐스팅</td>
				<td align="left">
					<select id="forcasting_seq" name="forcasting_seq" class="input" onchange="maintainDuplicate();">
						<option value="">미선택</option>
						<?php
						foreach($forcasting_list as $fl){
							echo "<option value='{$fl['seq']}' value2='{$fl['project_name']}'>{$fl['customer_companyname']}({$fl['project_name']})</option>";
						}
						?>
					</select>
				</td>
				<td>
					<input id="forcasting_view" class="btn-common btn-color1" type="button" value="포캐스팅 뷰" onclick="forcastingView();"/>
				</td>
			</tr>

			<tr class="tbl-tr border-b">
      	<td align="left" style="font-weight:bold;font-size:14px;padding-bottom:5px;">프로젝트</td>
				<td align="left">
					<input name="project_name" type="text" class="input-common" id="project_name" style="width:90%"/>
				</td>
				<td></td>
			</tr>

			<tr class="tbl-tr border-b">
				<td align="left" style="font-weight:bold;font-size:14px;padding-bottom:5px;">진척단계</td>
				<td align="left">
					<select name="progress_step" id="progress_step" class="select-common" style="width:92%">
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
						<option value="015">수주완료(85%)</option>
						<option value="016">매출발생(90%)</option>
						<option value="017">미수잔금(95%)</option>
						<option value="018">수금완료(100%)</option>
					</select>
				</td>
				<td></td>
			</tr>
      <tr>
        <td colspan="3" align="right" style="padding-top:30px;">
					<input type="button" class="btn-common btn-color1" value="취소" onClick="$('#add_maintain_div').bPopup().close()">
					<input type="button" class="btn-common btn-color2" value="등록" onclick="javascript:chkForm();return false;">
        </td>
      </tr>
    </table>
  </form>
</div>

<!--하단-->
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
<!--하단-->
<script>
function excelDownload(id, title) {
	var excel_download_table = "";
	<?php if(isset($_GET['searchkeyword'])) {
		$search_keyword = $_GET['searchkeyword'];
	}
	else {
		$search_keyword = "";
	}
	?>
	$.ajax({
		 type: "POST",
		 cache: false,
		 url: "<?php echo site_url(); ?>/sales/maintain/excel_data",
		 dataType: "json",
		 async: false,
		 data: {
			 type: '<?php echo $type; ?>',
			 search_keyword : '<?php echo $search_keyword ;?>',
			 search_mode : '<?php echo $search_mode; ?>'

		 },
		 success: function (data) {
			 if(data){
				excel_download_table += '<table id="excelTable" width="100%" border="0" cellspacing="0" cellpadding="0" style="display:none;"><colgroup><col width="5%" /><col width="5%" /><col width="15%" /><col width="10%" /><col width="5%" /><col width="5%" /><col width="10%" /><col width="6%" /><col width="6%" /><col width="5%" /><col width="5%" /><col width="6%" /><col width="5%" /><col width="4%" /> <col width="4%" /><col width="4%" /></colgroup>';
				excel_download_table += '<tr bgcolor="f8f8f9" class="t_top"><td rowspan="2" height="60" align="center">번호</td><td rowspan="2" align="center" class="t_border">종류</td><td rowspan="2" align="center" class="t_border">고객사</td><td rowspan="2" align="center" class="t_border">프로젝트</td><td colspan="3" align="center" class="t_border" style="height:30px;">제안제품</td><td rowspan="2" align="center" class="t_border">유지보수시작일</td><td rowspan="2" align="center" class="t_border">유지보수종료일</td>';
				excel_download_table += '<td rowspan="2" align="center" class="t_border">매출금액</td><td rowspan="2" align="center" class="t_border">매입금액</td><td rowspan="2" align="center" class="t_border">마진금액</td><td rowspan="2" align="center" class="t_border">마진율</td><td rowspan="2" align="center" class="t_border">점검주기</td><td rowspan="2" align="center" class="t_border">관리팀</td><td rowspan="2" align="center" class="t_border">점검여부</td></tr>';
				excel_download_table += '<tr><td style="border-top:1px solid #797c88; height:30px;" bgcolor="#f8f8f9" align="center" class="t_border">제조사</td><td style="border-top:1px solid #797c88; height:30px;" bgcolor="#f8f8f9" align="center" class="t_border">품목</td><td style="border-top:1px solid #797c88; height:30px;" bgcolor="#f8f8f9" align="center" class="t_border">제품명</td></tr>';

				for(var i=0; i<data.length; i++){
					if(data[i]['manage_team']=="1"){
						var strstep ="기술1팀";
					}else if(data[i]['manage_team']=="2"){
						var strstep ="기술2팀";
					}else if(data[i]['manage_team']=="3"){
						var strstep ="기술3팀";
					}else{
						var strstep ="없음";
					}
					excel_download_table +='<tr>';
					excel_download_table += '<td height="40" align="center">'+(i+1)+'</td><td align="center" class="t_border"><?php if($type == '001'){echo "유지보수"; }else{echo "통합유지보수";} ?></td><td align="center" class="t_border">'+data[i]['customer_companyname']+'</td><td align="center" class="t_border">'+data[i]['project_name']+'</td>';
					excel_download_table += '<td align="center" class="t_border">'+data[i]['product_company']+'</td><td align="center" class="t_border">'+data[i]['product_item']+'</td><td align="center" class="t_border">'+data[i]['product_name']+'</td><td align="center" class="t_border">'+data[i]['exception_saledate2']+'</td><td align="center" class="t_border">'+data[i]['exception_saledate3']+'</td><td align="center" class="t_border">';
					excel_download_table += data[i]['forcasting_sales'];
					excel_download_table += '</td><td align="center" class="t_border">';
					excel_download_table += data[i]['forcasting_purchase'];
					excel_download_table += '</td><td align="center" class="t_border">';
					if(data[i]['forcasting_profit']!=0) {
						excel_download_table += data[i]['forcasting_profit'];
					}else{
						excel_download_table += '0';
					}
					excel_download_table += '</td><td align="center" class="t_border">';
					if(data[i]['forcasting_profit']!=0 && data[i]['forcasting_profit'] > 0) {
						excel_download_table += data[i]['forcasting_profit']*100/data[i]['forcasting_sales']+"%";
					}
					excel_download_table += '</td><td align="center" class="t_border">';
					if(data[i]['maintain_cycle'] == '0'){
						excel_download_table += "장애시";
					}else if (data[i]['maintain_cycle'] == '1'){
						excel_download_table += "월점검";
					}else if (data[i]['maintain_cycle'] == '3'){
						excel_download_table += '분기점검';
					}else if (data[i]['maintain_cycle'] == '6'){
						excel_download_table += "반기점검";
					}else if (data[i]['maintain_cycle'] == '7'){
						excel_download_table +='미점검';
					}else{
						excel_download_table +="미선택";
					}
					excel_download_table +='</td><td align="center" class="t_border">'+ strstep +'</td><td align="center" class="t_border">';

					if(data[i]['maintain_result'] == '0'){
						excel_download_table +="미완료";
					}else if(data[i]['maintain_result'] == '1'){
						excel_download_table +='완료';
					}else if(data[i]['maintain_result'] == '2'){
						excel_download_table +='미해당';
					}else if(data[i]['maintain_result'] == '9'){
						excel_download_table += '예정';
					}else{
						excel_download_table +='미선택';
					}
					excel_download_table +='</td></a></tr>';
				}
			 }
			}
		});

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
//유지보수 생성
function maintainInput(){
	location.href = "<?php echo site_url(); ?>/sales/maintain/maintain_input";
 }

 // 유지보수인풋에서 옮겨 온거
 var chkForm = function () {
 	var mform = document.cform;

 	if (mform.forcasting_seq.value == "") {
 		mform.forcasting_seq.focus();
 		alert("포캐스팅을 선택해 주세요.");
 		return false;
 	}
 	if (mform.project_name.value == "") {
 		mform.project_name.focus();
 		alert("프로젝트명을 입력해주세요");
 		return false;
 	}
 	if (mform.progress_step.value == 0) {
 		mform.progress_step.focus();
 		alert("진척단계를 선택해 주세요.");
 		return false;
 	}

 	mform.submit();
 	return false;
 }

 $("#forcasting_seq").select2({
	 dropdownParent: $('#add_maintain_div'),
	 width:'92%'
 });

 //포캐스팅 보러가기^0^
 function forcastingView(){
	 var seq = $("#forcasting_seq").val();
	 if(seq == ""){
		 alert("포캐스팅을 선택해주세요.");
		 $("#forcasting_seq").focus();
	 }else{
		 window.open("<?php echo site_url(); ?>/sales/forcasting/order_completed_view?seq="+seq,"","width = 1200, height = 500, scrollbars=1,resizable=yes");
	 }
 }

 //유지보수 중복 여부
 function maintainDuplicate(){
	 $("#project_name").val( $("#forcasting_seq option:selected").attr('value2'));
	 var seq = $("#forcasting_seq").val();
	 $.ajax({
		 type: "POST",
		 cache: false,
		 url: "<?php echo site_url(); ?>/sales/maintain/maintainDuplicate",
		 dataType: "json",
		 async: false,
		 data: {
			 seq: seq
		 },
		 success: function (data) {
			 if(data){
				 if(confirm('해당 포캐스팅으로 유지보수가 존재합니다. 선택을 유지하시겠습니까?')){
				 }else{
					 $("#forcasting_seq").select2().val(val);
					 $("#forcasting_seq").trigger('change');
				 }
			 }
		 }
	 });
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

</script>
</body>
</html>