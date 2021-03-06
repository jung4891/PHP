<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
  if($search_keyword != ''){
    $filter = explode(',',str_replace('"', '&uml;',$search_keyword));
  }
?>
<style>
	p, div, span, a, a:hover, a:visited, a:active, label, input, h1,h2,h3,h4,h5,h6{font-family: "Noto Sans KR";}
	.contents td{
		border-bottom: 1px solid #e8e8e8;
		height:40px;
	}
	.sticky-th {
		position:sticky;
		top:0px;
		background-color:#fff;
	}
</style>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">
<link rel="stylesheet" href="/misc/css/bootstrap-datepicker.css">
<body>
<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
<form id="cform" name="cform" action="<?php echo site_url();?>/admin/annual_admin/annual_usage_status_list" method="get" onkeydown="if(event.keyCode==13) return GoSearch();">
	<input type="hidden" name="searchkeyword" id="searchkeyword" value="<?php echo str_replace('"', '&uml;',$search_keyword); ?>" />
</form>
<div align="center">
	<div class="dash1-1">
		<table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
			<tbody>
        <tr height="5%">
					<td class="dash_title">
						휴가사용내역
					</td>
				</tr>
				<!-- 검색! -->
				<tr id="search_tr">
					<td align="left" valign="top">
						<table width="100%" id="filter_table" style="margin-top:80px;">
              <tr>
                <td style="font-weight:bold;vertical-align:middle;">
                  <div>
                    &nbsp;사용기간
                    <input type="date" id="filter1" class="input-common input-style1 filtercolumn" style="width:130px" value='<?php if(isset($filter)){echo $filter[0];}else{echo date("Y-m-01");} ?>' onkeydown="if(event.keyCode==13) return GoSearch();" />
                    &ensp; ~ &ensp;
                    <input type="date" id="filter2" class="input-common input-style1 filtercolumn" style="width:130px" value='<?php if(isset($filter)){echo $filter[1];}else{echo date("Y-m-d");} ?>' onkeydown="if(event.keyCode==13) return GoSearch();" />
                    &nbsp;전자결재상태
                    <select id="filter3" class="select-common select-style1 filtercolumn" onkeydown="if(event.keyCode==13) return GoSearch();" >
                      <option value="" <?php if(isset($filter)){if($filter[2] == ""){echo "selected";}} ?>>전체</option>
                      <option value="001" <?php if(isset($filter)){if($filter[2] == "001"){echo "selected";}} ?>>진행중</option>
                      <option value="002" <?php if(isset($filter)){if($filter[2] == "002"){echo "selected";}} ?>>완료</option>
                      <option value="003" <?php if(isset($filter)){if($filter[2] == "003"){echo "selected";}} ?>>반려</option>
                      <option value="004" <?php if(isset($filter)){if($filter[2] == "004"){echo "selected";}} ?>>회수</option>
                      <option value="006" <?php if(isset($filter)){if($filter[2] == "006"){echo "selected";}} ?>>보류</option>
                    </select>
                    &nbsp;검색어
                    <select id="filter4" class="select-common select-style1 filtercolumn" onkeydown="if(event.keyCode==13) return GoSearch();" >
                      <option value="user_name" <?php if(isset($filter)){if($filter[3] == "user_name"){echo "selected";}} ?>>성명</option>
                      <option value="user_group" <?php if(isset($filter)){if($filter[3] == "user_group"){echo "selected";}} ?>>부서</option>
                    </select>
                    <input type="text" id="filter5" class="input-common filtercolumn" style="width:130px;" value='<?php if(isset($filter)){echo $filter[4];} ?>' onkeydown="if(event.keyCode==13) return GoSearch();"  />
                    &nbsp;휴가항목
                    <select id="filter6" class="select-common select-style1 filtercolumn" onkeydown="if(event.keyCode==13) return GoSearch();" >
                      <option value="" <?php if(isset($filter)){if($filter[5] == ""){echo "selected";}} ?>>전체</option>
                      <option value="001" <?php if(isset($filter)){if($filter[5] == "001"){echo "selected";}} ?>>보건휴가</option>
                      <option value="002" <?php if(isset($filter)){if($filter[5] == "002"){echo "selected";}} ?>>출산휴가</option>
                      <option value="003" <?php if(isset($filter)){if($filter[5] == "003"){echo "selected";}} ?>>연/월차 휴가</option>
                      <option value="004" <?php if(isset($filter)){if($filter[5] == "004"){echo "selected";}} ?>>특별유급 휴가</option>
                      <option value="005" <?php if(isset($filter)){if($filter[5] == "005"){echo "selected";}} ?>>공가</option>
                    </select>
                    <input type="button" style='cursor:hand;' class="btn-common btn-style2" value="검색" onclick="return GoSearch();" src="<?php echo $misc;?>img/dashboard/btn/btn_search.png" valign="top" border="0" width="28" />
                  </div>
                </td>
              </tr>
						</table>
					</tr>
				<tr style="max-height:45%">
					<td colspan="2" valign="top" style="padding:10px 0px;">
						<table class="content_dash_tbl" align="center" width="100%"  border="0" cellspacing="0" cellpadding="0" class="list_tbl">
							<tr>
								<td align="center" valign="top">
									<!-- <input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>"> -->
									<input type="hidden" name="seq" value="">
									<input type="hidden" name="mode" value="">
								</td>
							</tr>
							<tr>
								<td>
									<div style="width:100%; height:500px; overflow:auto">
									<table width="100%" class="contents" border="0" cellspacing="0" cellpadding="0">
										<colgroup>
											<col width="10%" />
											<col width="5%" />
											<col width="5%" />
											<col width="10%" />
											<col width="10%" />
											<col width="5%" />
											<col width="15%" />
											<col width="5%" />
											<col width="5%" />
											<col width="5%" />
											<col width="10%" />
											<col width="5%" />
											<col width="10%" />
										</colgroup>
										<thead>
											<tr class="t_top row-color1">
												<th class="tbl-title sticky-th" ></th>
												<th class="tbl-title sticky-th" height="40" align="center">성명</th>
												<th class="tbl-title sticky-th" align="center">직급</th>
												<th class="tbl-title sticky-th" align="center">부서</th>
												<th class="tbl-title sticky-th" align="center">휴가구분</th>
												<th class="tbl-title sticky-th" align="center">전일/반일</th>
												<th class="tbl-title sticky-th" align="center">휴가사용일</th>
												<th class="tbl-title sticky-th" align="center">연차사용일수 </th>
												<th class="tbl-title sticky-th" align="center">근태일수</th>
												<th class="tbl-title sticky-th" align="center">전자결재상태</th>
												<th class="tbl-title sticky-th" align="center">휴가사유</th>
												<th class="tbl-title sticky-th" align="center">기준년도</th>
												<th class="tbl-title sticky-th" ></th>
											</tr>
										</thead>
										<tbody>
										<?php
										if (!empty($view_val)) {
											foreach($view_val as $val){?>
											<tr >
												<td></td>
												<td  align="center"><?php echo $val['user_name']; ?></td>
												<td  align="center"><?php echo $val['user_duty']; ?></td>
												<td  align="center"><?php echo $val['user_group']; ?></td>
												<td  align="center">
													<?php if($val['annual_type'] == "001"){
														echo "보건휴가";
													}else if($val['annual_type'] == "002"){
														echo "출산휴가";
													}else if($val['annual_type'] == "003"){
														echo "연/월차 휴가";
													}else if($val['annual_type'] == "004"){
														echo "특별유급 휴가";
													}else if($val['annual_type'] == "005"){
														echo "공가";
													} ?>
												</td>
												<td align="center">
													<?php if($val['annual_type2'] == "001"){
														echo "전일";
													}else if($val['annual_type2'] == "002"){
														echo "오전반차";
													}else if($val['annual_type2'] == "003"){
														echo "오후반차";
													} ?>
												</td>
												<td  align="center"><?php echo $val['annual_start_date'];?> ~ <?php echo $val['annual_end_date'];?></td>
												<td  align="center"><?php echo $val['annual_cnt'];?></td>
												<td  align="center"><?php echo $val['annual_cnt'];?></td>
												<td  align="center">
													<?php if($val['approval_doc_status'] == "001"){
														echo "진행중";
													}else if($val['approval_doc_status'] == "002"){
														echo "완료";
													}else if($val['approval_doc_status'] == "003"){
														echo "반려";
													}else if($val['approval_doc_status'] == "004"){
														echo "회수";
													}else if($val['approval_doc_status'] == "006"){
														echo "보류";
													} ?>
												</td>
												<td  align="center"><?php echo $val['annual_reason'];?></td>
												<td  align="center"><?php echo substr($val['annual_start_date'],0,4);?></td>
												<td></td>
											</tr>
										<?php
										    }
										} else {
										?>
										<tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'">
											<td width="100%" height="40" align="center" colspan="13">등록된 게시물이 없습니다.</td>
										</tr>
										<?php
										}
									?>
									</tbody>
									</table>
									</div>
								</td>
							</tr>

						</table>

					</td>
				</tr>
			</table>
	</div>
</div>

<!--하단-->
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
<!--//하단-->
</body>
<script type="text/javascript">


  //거엄색!
	function GoSearch() {
		console.log(11);
		var searchkeyword = '';
		for (i = 1; i <= $(".filtercolumn").length; i++) {
		if (i == 1) {
			searchkeyword += $("#filter" + i).val().trim();
		} else {
			var filter_val = $("#filter" + i).val().trim();
			if (i == 13 || i == 14) {
			filter_val = String(filter_val).replace(/,/g, "");
			}
			searchkeyword += ',' + filter_val;
		}
		}
		$("#searchkeyword").val(searchkeyword)

		if (searchkeyword.replace(/,/g, "") == "") {
		alert("검색어가 없습니다.");
		location.href = "<?php echo site_url();?>/admin/annual_admin/annual_usage_status_list";
		return false;
		}

		document.cform.action = "<?php echo site_url();?>/admin/annual_admin/annual_usage_status_list";
		document.cform.submit();
}
</script>
</html>
