<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
  if($search_keyword != ''){
    $filter = explode(',',str_replace('"', '&uml;',$search_keyword));
  }
?>
<style>
	p, div, span, a, a:hover, a:visited, a:active, label, input, h1,h2,h3,h4,h5,h6{font-family: "Noto Sans KR";}

.contents_item span{
  font-size:14px;
  font-weight: bold;
}

.contents_tbl th{
		text-align:center;
		font-size: 14px;
		font-weight:bold;
		height:40px;


}

.contents_tbl td{
		text-align:center;
		font-size: 14px;
		height:40px;
}
</style>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">
<link rel="stylesheet" href="/misc/css/bootstrap-datepicker.css">
<body>
<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
<form id="cform" name="cform" action="<?php echo site_url();?>/biz/attendance/annual_usage_status_list" method="get" onkeydown="if(event.keyCode==13) return GoSearch();">
  <input type="hidden" name="searchkeyword" id="searchkeyword" value="<?php echo str_replace('"', '&uml;',$search_keyword); ?>" />
</form>
<div class="contents_container" align="center">
  <!-- 타이틀 -->
	<div class="contents_item dash_title" style="display:flex;">
		<p align="left">
			휴가사용내역
		</p>
	</div>
<!-- 검색 -->
	<div class="contents_item" align="left" style="margin-top:10vh;">
    <span>사용기간</span>
    <input type="date" id="filter1" class="input-common filtercolumn" style="width:150px;" value='<?php if(isset($filter)){echo $filter[0];}else{echo date("Y-m-01");} ?>' onkeydown="if(event.keyCode==13) return GoSearch();" />
    &ensp; ~ &ensp;
    <input type="date" id="filter2" class="input-common filtercolumn" style="width:150px;" value='<?php if(isset($filter)){echo $filter[1];}else{echo date("Y-m-d");} ?>' onkeydown="if(event.keyCode==13) return GoSearch();" />
    <span>휴가항목</span>
    <select id="filter4" class="select-common select-style1 filtercolumn" onkeydown="if(event.keyCode==13) return GoSearch();" >
      <option value="" <?php if(isset($filter)){if($filter[3] == ""){echo "selected";}} ?>>전체</option>
      <option value="001" <?php if(isset($filter)){if($filter[3] == "001"){echo "selected";}} ?>>보건휴가</option>
      <option value="002" <?php if(isset($filter)){if($filter[3] == "002"){echo "selected";}} ?>>출산휴가</option>
      <option value="003" <?php if(isset($filter)){if($filter[3] == "003"){echo "selected";}} ?>>연/월차 휴가</option>
      <option value="004" <?php if(isset($filter)){if($filter[3] == "004"){echo "selected";}} ?>>특별유급 휴가</option>
      <option value="005" <?php if(isset($filter)){if($filter[3] == "005"){echo "selected";}} ?>>공가</option>
    </select>
    <span>전자결재상태</span>
    <select id="filter3" class="select-common select-style1 filtercolumn" onkeydown="if(event.keyCode==13) return GoSearch();" >
      <option value="" <?php if(isset($filter)){if($filter[2] == ""){echo "selected";}} ?>>전체</option>
      <option value="001" <?php if(isset($filter)){if($filter[2] == "001"){echo "selected";}} ?>>진행중</option>
      <option value="002" <?php if(isset($filter)){if($filter[2] == "002"){echo "selected";}} ?>>완료</option>
      <option value="003" <?php if(isset($filter)){if($filter[2] == "003"){echo "selected";}} ?>>반려</option>
      <option value="004" <?php if(isset($filter)){if($filter[2] == "004"){echo "selected";}} ?>>회수</option>
      <option value="006" <?php if(isset($filter)){if($filter[2] == "006"){echo "selected";}} ?>>보류</option>
    </select>
    <button type="submit" class="btn-common btn-style1" name="button" onclick="return GoSearch();">검 색</button>
  </div>
  <!-- 본문 -->
  <div class="contents_item" style="margin-top:10px;">
    <input type="hidden" name="seq" value="">
    <input type="hidden" name="mode" value="">
    <table class="contents_tbl" align="center" width="100%"  border="0" cellspacing="0" cellpadding="0">
            <colgroup>
              <col width="7%" />
              <col width="7%" />
              <col width="10%" />
              <col width="10%" />
              <col width="7%" />
              <col width="15%" />
              <col width="10%" />
              <col width="5%" />
              <col width="10%" />
              <col width="10%" />
              <col width="9%" />
            </colgroup>
            <thead>
              <tr class="t_top">
                <th class="sticky-th" height="40" align="center">성명</th>
                <th class="sticky-th" align="center">직급</th>
                <th class="sticky-th" align="center">부서</th>
                <th class="sticky-th" align="center">휴가구분</th>
                <th class="sticky-th" align="center">전일/반일</th>
                <th class="sticky-th" align="center">휴가사용일</th>
                <th class="sticky-th" align="center">연차사용일수 </th>
                <th class="sticky-th" align="center">근태일수</th>
                <th class="sticky-th" align="center">전자결재상태</th>
                <th class="sticky-th" align="center">휴가사유</th>
                <th class="sticky-th" align="center">기준년도</th>
              </tr>
            </thead>
            <tbody>
            <?php
            if (!empty($view_val)) {
              foreach($view_val as $val){?>
              <tr>
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
              </tr>
            <?php
                }
            } else {
            ?>
            <tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'">
              <td width="100%" height="40" align="center" colspan="11">조회 결과가 없습니다.</td>
            </tr>
            <?php
            }
          ?>
          </tbody>
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
		location.href = "<?php echo site_url();?>/biz/attendance/annual_usage_status_list";
		return false;
		}

		document.cform.action = "<?php echo site_url();?>/biz/attendance/annual_usage_status_list";
		document.cform.submit();
}
</script>
</html>
