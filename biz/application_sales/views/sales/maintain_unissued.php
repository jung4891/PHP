<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";

if($search_keyword != ''){
	$filter = explode(',',str_replace('"', '&uml;',$search_keyword));
}
?>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css" rel="stylesheet" />
<style media="screen">

.search_div{
	margin-top: 75px;
}
.search_contains {
	font: Noto sans(Medium);
	font-size: 13px;
	font-weight: bold;
	color: #1c1c1c;
}
.search_contains input, select {
	margin-left: 10px;
	margin-right: 10px;
}
.list_tbl td {
	text-align: center;
}
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/js/select2.min.js"></script>
<script type="text/javascript" src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>
<script language="javascript">
function GoSearch(){
	var searchkeyword = '';

	for (i = 1; i <= $(".filtercolumn").length; i++) {
		if (i == 1) {
			searchkeyword += $("#filter" + i).val().trim();
		} else {
			var filter_val = $("#filter" + i).val().trim();
			searchkeyword += ',' + filter_val;
		}
	}
  $("#searchkeyword").val(searchkeyword);

  if (searchkeyword.replace(/,/g, "") == "") {
    alert("검색어가 없습니다.");
	location.href="<?php echo site_url();?>/sales/maintain/maintain_unissued";
	return false;
  }

	var s_day = $("input[name=start_d]").val();
	var e_day = $("input[name=end_d]").val();
	if((s_day != "" && e_day =="")||(e_day != "" && s_day =="")){
		alert("발행예정기간을 확인하세요.");
		return false;
	}


  document.mform.action = "<?php echo site_url();?>/sales/maintain/maintain_unissued";
  document.mform.cur_page.value = "";
  document.mform.submit();
}

</script>
<body>
  <?php
  	include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
  ?>
<div align="center">
<div class="dash1-1">

<form name="mform" action="<?php echo site_url();?>/sales/maintain/maintain_unissued" method="get" onkeydown="if(event.keyCode==13) return GoSearch();">
<table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
<tbody height="100%">
  <tr height="5%">
	   <td class="dash_title">계산서 미발행</td>

	</tr>
  <input type="hidden" name="seq" value="">
  <input type="hidden" name="mode" value="">
  <input type="hidden" name="type" value="">
  <input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
  <input type="hidden" name="lpp" value="<?php echo $no_page_list; ?>">
  <input type="hidden" id="searchkeyword" name="searchkeyword" value="<?php echo str_replace('"', '&uml;', $search_keyword );?>"/>
  <!-- 감색창 -->
  <tr height="15%" id="search_tr">
    <td align="left" valign="top">
    <div class="search_div">
      <div class="search_contains">
        <div>
          구분
          <select id="filter1" class="select-common select-style1 filtercolumn" name="sales_type">
            <option value="">전체</option>
            <option value="001" <?php if(isset($filter) && $filter[0] == '001'){echo "selected";} ?>>매출</option>
            <option value="002" <?php if(isset($filter) && $filter[0] == '002'){echo "selected";} ?>>매입</option>
          </select>
          회사
          <select id="filter2" class="select-common select-style1 filtercolumn" name="company" onchange="change_company(this);">
            <option value="">미선택</option>
            <option value="IT" <?php if(isset($filter) && $filter[1] == 'IT'){echo "selected";} ?>>IT</option>
            <option value="ICT" <?php if(isset($filter) && $filter[1] == 'ICT'){echo "selected";} ?>>ICT</option>
            <option value="MG" <?php if(isset($filter) && $filter[1] == 'MG'){echo "selected";} ?>>MG</option>
          </select>
          <span style="<?php if(isset($filter) && $filter[1] != 'IT'){echo "display:none";} ?>" class="dept">부서</span>
          <select id="filter3" class="select-common select-style1 filtercolumn dept" name="dept" style="<?php if(isset($filter) && $filter[1] != 'IT'){echo "display:none";} ?>">
            <option value="전체" <?php if(isset($filter) && $filter[2] == '전체'){echo "selected";} ?>>전체</option>
            <option value="사업1부" <?php if(isset($filter) && $filter[2] == '사업1부'){echo "selected";} ?>>사업1부</option>
            <option value="사업2부" <?php if(isset($filter) && $filter[2] == '사업2부'){echo "selected";} ?>>사업2부</option>
            <option value="기술지원부" <?php if(isset($filter) && $filter[2] == '기술지원부'){echo "selected";} ?>>기술지원부</option>
          </select>

          종류
          <select id="filter4" class="select-common select-style1 filtercolumn" name="maintain_type">
            <option value="">미선택</option>
            <option value="유지보수" <?php if(isset($filter) && $filter[3] == '유지보수'){echo "selected";} ?>>유지보수</option>
            <option value="통합유지보수" <?php if(isset($filter) && $filter[3] == '통합유지보수'){echo "selected";} ?>>통합유지보수</option>
            <option value="기술지원요청" <?php if(isset($filter) && $filter[3] == '기술지원요청'){echo "selected";} ?>>기술지원요청</option>
          </select>

        발행예정기간
          <input id="filter5" type="date" class="input-common input-style1 filtercolumn" name="start_d" value="<?php if(isset($filter)){echo $filter[4];} ?>" style="width:120px" /> ~
          <input id="filter6" type="date" class="input-common input-style1 filtercolumn" name="end_d" value="<?php if(isset($filter)){echo $filter[5];} ?>" style="width:120px" />
          <input type="button" class='btn-common btn-style2' onclick="return GoSearch();" value="검색"/>
					<div style="float:right;">
						<input type="button" class="btn-common btn-updownload" value="엑셀 다운로드" onclick="excel_down();"style="width:auto;float:left;padding-left:20px;position: relative;left: 15%;">
						<img src="/misc/img/download_btn.svg" style="float:right;width:12px;position:relative;top:10px;right:65%;">
					</div>
        </div>
      </div>
    </div>
    </td>
  </tr>
  <tr id="content_tr">
    <td valign="top" style="padding:15px 0px 15px 0px">
      	<table class="list_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0"style="margin-top:20px;">
          <thead>
          <colgroup>
  					<col width="5%" />
  					<col width="5%" /> <!-- No-->
  					<col width="7%" /> <!-- 담당부서-->
  					<col width="7.5%" /> <!-- 종류 -->
  					<col width="5%" /> <!-- 구분 -->
  					<col width="7.5%" /> <!--고객사-->
  					<col width="7.5%" /> <!--거래처-->
  					<col width="18%" /> <!--프로젝트명-->
  					<col width="5%" /> <!--회차-->
  					<col width="7.5%" /> <!--발행예정일-->
  					<col width="7.5%" /> <!--발행금액-->
  					<col width="7.5%" /> <!--업체-->
  					<col width="5%" /> <!--영업담당자-->
  					<col width="5%" />
  				</colgroup>
          <tr class="t_top row-color1">
            <th></th>
            <th height="40" align="center">No.</th>
            <th align="center">담당부서</th>
            <th align="center">종류</th>
            <th align="center">구분</th>
            <th align="center">고객사</th>
            <th align="center">거래처</th>
            <th align="center">프로젝트명</th>
            <th align="center">회차</th>
            <th align="center">발행예정일</th>
            <th align="center">발행금액</th>
            <th align="center">업체</th>
            <th align="center">영업담당자</th>
            <th></th>
          </tr>
        </thead>
        <tbody class="content_tbody">
        <?php
		if ($count > 0) {
        $i = $count - $no_page_list * ( $cur_page - 1 );
        $icounter = 0;
        foreach ($view_val as $val){ ?>
          <tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'" style="cursor:pointer" onclick="ViewBoard('<?php echo $val->maintain_seq;?>', '<?php echo $val->main_type; ?>')">
          <td></td>
          <td><?php echo $i; ?></td>
          <td><?php echo $val->dept; ?></td>
          <td><?php echo $val->main_type; ?></td>
          <td><?php echo ($val->type == '001') ?'매출' : '매입'; ?></td>
          <td><?php echo $val->customer_companyname; ?></td>
          <td><?php echo $val->company_name; ?></td>
          <td><?php echo $val->project_name; ?></td>
          <td><?php echo $val->pay_session; ?></td>
          <td><?php echo $val->issue_schedule_date; ?></td> <!-- 발행 예쩡일 컬럼생기면 바꿔 --><!-- 그래서 바꿨다-->
          <td><?php echo number_format($val->issuance_amount); ?></td>
          <td><?php echo $val->cooperation_companyname; ?></td>
          <td><?php echo $val->cooperation_username; ?></td>
          <td></td>
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

    <?php
      }
    ?>
      </tbody>
        </table>
  </tr>
    <!--페이징-->
    <tr height="30%" id="paging_tr">
    	<td align="center" valign="top" style="padding-bottom:15px;">
  <div id="contains">
    <div>
    </div>
    <div>
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
    			<td width="19"><a href="JavaScript:GoLastPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_last_right.svg" width="20" height="20"/></a></td>
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
  <div style="float:right;">
    	<select class="select-common select-style1" id="listPerPage" style="height:25px" onchange="change_lpp();">
    		<option value="5" <?php if($lpp==5){echo 'selected';} ?>>5건 / 페이지</option>
    		<option value="10" <?php if($lpp==10){echo 'selected';} ?>>10건 / 페이지</option>
    		<option value="15" <?php if($lpp==15){echo 'selected';} ?>>15건 / 페이지</option>
    		<option value="20" <?php if($lpp==20){echo 'selected';} ?>>20건 / 페이지</option>
    		<option value="30" <?php if($lpp==30){echo 'selected';} ?>>30건 / 페이지</option>
    		<option value="50" <?php if($lpp==50){echo 'selected';} ?>>50건 / 페이지</option>
    	</select>
  </div>
</div>
    </td>
    </tr>

    <!-- 페이징  끝-->



    </td>
  </tr>


</tbody>
</table>
</form>
</div>
</div>

<!-- 엑셀 export용 테이블 -->
<div id="excel_div" style="width:100%;"></div>
<!-- 엑셀 export용 테이블 끝 -->






  <!--하단-->
  <?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
  <!--하단-->
</body>
<script>
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

function change_lpp(){
	var lpp = $("#listPerPage").val();
	document.mform.lpp.value = lpp;
	document.mform.submit();
}

function ViewBoard(main_seq, main_type){
	if (main_seq.indexOf('r_') != -1) {
		location.href='<?php echo site_url(); ?>/tech/tech_board/request_tech_support_list';
	} else {
		if(main_type == '유지보수') {
			main_type = '001';
		} else if (main_type == '통합유지보수') {
			main_type = '002';
		} else {
			main_type = '001';
		}
		document.mform.action = "<?php echo site_url();?>/sales/maintain/maintain_view";
		document.mform.seq.value = main_seq;
		document.mform.mode.value = "modify";
		document.mform.type.value = main_type;

		document.mform.submit();
	}
}

// 오늘 날짜 구하는 함수
function getToday() {
  var d = new Date();
  var s = leadingZeros(d.getFullYear(), 4) + '-' + leadingZeros(d.getMonth() + 1, 2) + '-' + leadingZeros(d.getDate(), 2);
  return s;
}

// 오늘 날짜 구하는 함수
function leadingZeros(n, digits) {
  var zero = '';
  n = n.toString();

  if (n.length < digits) {
    for (i = 0; i < digits - n.length; i++)
      zero += '0';
  }
  return zero + n;
}

function excel_down() {
	var excel_download_table = '';

	var searchkeyword = '<?php echo $search_keyword; ?>';

	$.ajax({
		type: "POST",
		cache: false,
		url: '/index.php/sales/maintain/maintain_unissued_excel',
		dataType: 'json',
		async: false,
		data: {
			searchkeyword: searchkeyword
		},
		success: function(data) {
			if(data){
				excel_download_table += '<table id="excelTable" class="list_tbl" style="width:100%;display:none"><colgroup><col width="8.3%"><col width="8.8%"><col width="6.3%"><col width="8.8%"><col width="8.8%"><col width="19.3%"><col width="6.3%"><col width="8.8%"><col width="8.8%"><col width="8.8%"><col width="6.3%"></colgroup>';
				excel_download_table += '<tr class="row-color1"><td height="60" align="center">담당부서</td><td height="60" align="center">종류</td><td height="60" align="center">구분</td><td height="60" align="center">고객사</td><td height="60" align="center">거래처</td><td height="60" align="center">프로젝트명</td><td height="60" align="center">회차</td><td height="60" align="center">발행예정일</td><td height="60" align="center">발행금액</td><td height="60" align="center">업체</td><td height="60" align="center">영업담당자</td>';

				for(var i=0; i<data.length; i++){
					if(data[i].dept==null){
						data[i].dept = '';
					}
					if(data[i].main_type==null){
						data[i].main_type = '';
					}
					if(data[i].type==null){
						data[i].type = '';
					} else {
						if(data[i].type=='001'){
							data[i].type = '매출';
						} else {
							data[i].type = '매입';
						}
					}
					if(data[i].customer_companyname==null){
						data[i].customer_companyname = '';
					}
					if(data[i].company_name==null){
						data[i].company_name = '';
					}
					if(data[i].project_name==null){
						data[i].project_name = '';
					}
					if(data[i].pay_session==null){
						data[i].pay_session = '';
					}
					if(data[i].issue_schedule_date==null){
						data[i].issue_schedule_date = '';
					}
					if(data[i].issuance_amount==null){
						data[i].issuance_amount = '';
					}
					if(data[i].cooperation_companyname==null){
						data[i].cooperation_companyname = '';
					}
					if(data[i].cooperation_username==null){
						data[i].cooperation_username = '';
					}
					excel_download_table += '<tr>';
					excel_download_table += '<td>'+data[i].dept+'</td>';
					excel_download_table += '<td>'+data[i].main_type+'</td>';
					excel_download_table += '<td>'+data[i].type+'</td>';
					excel_download_table += '<td>'+data[i].customer_companyname+'</td>';
					excel_download_table += '<td>'+data[i].company_name+'</td>';
					excel_download_table += '<td>'+data[i].project_name+'</td>';
					excel_download_table += '<td>'+data[i].pay_session+'</td>';
					excel_download_table += '<td>'+data[i].issue_schedule_date+'</td>';
					excel_download_table += '<td>'+data[i].issuance_amount+'</td>';
					excel_download_table += '<td>'+data[i].cooperation_companyname+'</td>';
					excel_download_table += '<td>'+data[i].cooperation_username+'</td>';
					excel_download_table += '</tr>';
				}
			}
		}
	})
	$("#excel_div").append(excel_download_table);

  var today = getToday();

  var title = "계산서미발발행_" + today;

  var tab_text = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
  tab_text = tab_text + '<head><meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">';
  tab_text = tab_text + '<xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>'
  tab_text = tab_text + '<x:Name>Test Sheet</x:Name>';
  tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:Panes></x:WorksheetOptions></x:ExcelWorksheet>';
  tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>';
  tab_text = tab_text + "<table border='1px' style='width:100%'>";
  var exportTable = $('#excelTable').clone();
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

function change_company(el) {
	if($(el).val() == 'IT') {
		$(".dept").show();
	} else {
		$(".dept").hide();
	}
}


</script>


</html>
