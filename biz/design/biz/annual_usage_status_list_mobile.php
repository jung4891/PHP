<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
  if($search_keyword != ''){
    $filter = explode(',',str_replace('"', '&uml;',$search_keyword));
  }
?>
<body>
	<?php
	  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	  ?>
	<meta name="viewport" content="width=device-width,height=device-width, initial-scale=1.0">
	<style>
	.menu_div {
		margin-top:10px;
		padding: 10px;
		border-bottom: thin #EFEFEF solid;
		overflow-x: scroll;
		white-space:nowrap;
	}
	.menu_div::-webkit-scrollbar {
		display: none;
	}
	.menu_list {
		cursor:pointer;margin:10px;font-weight:bold;font-size:15px;
	}
	.basic_table{
		width:100%;
		 border-collapse:collapse;
		 border:1px solid;
		 border-color:#DEDEDE;
		 table-layout: auto !important;
		 border-left:none;
		 border-right:none;
	}

	.basic_table td{
		height:35px;
		 padding:0px 10px 0px 10px;
		 border:1px solid;
		 border-color:#DEDEDE;
	}
	.border_n {
		border:none;
	}
	.border_n td {
		border:none;
	}
	.basic_table tr > td:first-child {
		border-left:none;
	}
	.basic_table tr > td:last-child {
		border-right:none;
	}
	.contents_div {
		overflow-x: scroll;
		white-space: nowrap;
	}
	.input-common, .select-common, .btn-common {
		height: 35px !important;
		border-radius: 3px !important;
		box-sizing: border-box;
	}
	.dayBtn {
		background:url(<?php echo $misc; ?>img/mobile/footer_schedule.svg) no-repeat 98% 50% #fff;
		background-size: 20px;
	}
	.ui-datepicker .ui-datepicker-title select {
		font-size: 16px !important;
	}
	</style>
	<link rel="stylesheet" href="/misc/css/view_page_common.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.9.2/i18n/jquery.ui.datepicker-ko.min.js"></script>
  <script language="javascript">
  function moveList(page){
     location.href="<?php echo site_url();?>/biz/attendance/"+page;
  }
  </script>
	<?php
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_side.php";
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_header.php";
  ?>
     <div class="menu_div">
   		<a class="menu_list" onclick ="moveList('attendance_user')" style='color:#B0B0B0'>출근기록</a>
   		<a class="menu_list" onclick ="moveList('attendance_working_hours')" style='color:#B0B0B0'>통계</a>
   		<a class="menu_list" onclick ="moveList('annual_usage_status')" style='color:#B0B0B0'>휴가사용현황</a>
   		<a class="menu_list" onclick ="moveList('annual_usage_status_list')" style='color:#0575E6'>휴가사용내역</a>
   	</div>

	<div style="max-width:90%;margin: 0 auto;margin-top:30px;">
		<table class="basic_table">
			<colgroup>
				<col width="30%">
				<col width="70%">
			</colgroup>
			<tbody>

<?php
if (!empty($view_val)) {
  foreach($view_val as $val){?>
				<tr>
					<td bgcolor="#F4F4F4" style="font-weight:bold;">휴가구분</td>
					<td>
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
				</tr>
				<tr>
					<td bgcolor="#F4F4F4" style="font-weight:bold;">전일/반일</td>
					<td>
            <?php if($val['annual_type2'] == "001"){
              echo "전일";
            }else if($val['annual_type2'] == "002"){
              echo "오전반차";
            }else if($val['annual_type2'] == "003"){
              echo "오후반차";
            } ?>
          </td>
				</tr>
				<tr>
					<td bgcolor="#F4F4F4" style="font-weight:bold;">휴가사용일</td>
					<td><?php echo $val['annual_start_date'];?> ~ <?php echo $val['annual_end_date'];?></td>
				</tr>
				<tr>
					<td bgcolor="#F4F4F4" style="font-weight:bold;">전자결재상태</td>
					<td>
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
				</tr>
				<tr>
					<td bgcolor="#F4F4F4" style="font-weight:bold;">휴가사유</td>
					<td><?php echo $val['annual_reason'];?></td>
				</tr>
        <tr>
          <td height="20"></td>
        </tr>
<?php
    }
} else {
?>
        <tr>
          <td colspan="2">조회 결과가 없습니다.</td>
        </tr>
<?php } ?>
			</tbody>
		</table>
	</div>

	<!-- 검색 모달 시작 -->
  <div id="search_div" style="height:auto;width:100%;background-color:#ffffff; display:none;border-radius:5px;">
    <div class="modal_contain" style="font-size:16px; color:#1C1C1C;font-weight:bold;">
			<form id="cform" name="cform" action="<?php echo site_url();?>/biz/attendance/annual_usage_status_list" method="get" onkeydown="if(event.keyCode==13) return GoSearch();">
        <input type="hidden" name="searchkeyword" id="searchkeyword" value="<?php echo str_replace('"', '&uml;',$search_keyword); ?>" />
				<table style="width:100%;padding:5%;" cellspacing="0">
					<colgroup>
						<col width="50%">
						<col width="50%">
					</colgroup>
					<tr>
						<td colspan="2" align="left" height="40">사용기간</td>
					</tr>
          <tr>
            <td><input type="date" id="filter1" class="input-common filtercolumn dayBtn" style="width:100%;" value='<?php if(isset($filter)){echo $filter[0];}else{echo date("Y-m-01");} ?>' onkeydown="if(event.keyCode==13) return GoSearch();" /></td>
            <td><input type="date" id="filter2" class="input-common filtercolumn dayBtn" style="width:100%;" value='<?php if(isset($filter)){echo $filter[1];}else{echo date("Y-m-d");} ?>' onkeydown="if(event.keyCode==13) return GoSearch();" /></td>
          </tr>
					<tr>
						<td colspan="2" align="left" height="40">휴가항목</td>
					</tr>
          <tr>
            <td colspan="2">
              <select id="filter4" class="select-common select-style1 filtercolumn" onkeydown="if(event.keyCode==13) return GoSearch();"  style="width:100%;">
                <option value="" <?php if(isset($filter)){if($filter[3] == ""){echo "selected";}} ?>>전체</option>
                <option value="001" <?php if(isset($filter)){if($filter[3] == "001"){echo "selected";}} ?>>보건휴가</option>
                <option value="002" <?php if(isset($filter)){if($filter[3] == "002"){echo "selected";}} ?>>출산휴가</option>
                <option value="003" <?php if(isset($filter)){if($filter[3] == "003"){echo "selected";}} ?>>연/월차 휴가</option>
                <option value="004" <?php if(isset($filter)){if($filter[3] == "004"){echo "selected";}} ?>>특별유급 휴가</option>
                <option value="005" <?php if(isset($filter)){if($filter[3] == "005"){echo "selected";}} ?>>공가</option>
              </select>
            </td>
          </tr>
					<tr>
						<td colspan="2" align="left" height="40">전자결재상태</td>
					</tr>
          <tr>
            <td colspan="2">
              <select id="filter3" class="select-common select-style1 filtercolumn" onkeydown="if(event.keyCode==13) return GoSearch();"  style="width:100%;">
                <option value="" <?php if(isset($filter)){if($filter[2] == ""){echo "selected";}} ?>>전체</option>
                <option value="001" <?php if(isset($filter)){if($filter[2] == "001"){echo "selected";}} ?>>진행중</option>
                <option value="002" <?php if(isset($filter)){if($filter[2] == "002"){echo "selected";}} ?>>완료</option>
                <option value="003" <?php if(isset($filter)){if($filter[2] == "003"){echo "selected";}} ?>>반려</option>
                <option value="004" <?php if(isset($filter)){if($filter[2] == "004"){echo "selected";}} ?>>회수</option>
                <option value="006" <?php if(isset($filter)){if($filter[2] == "006"){echo "selected";}} ?>>보류</option>
              </select>
            </td>
          </tr>
					<tr>
						<td height="20"></td>
					</tr>
					<tr>
						<td>
							<input type="button" class="btn-common btn-color1" style="width:95%" value="취소" onclick="$('#search_div').bPopup().close();">
						</td>
						<td align="right">
							<input type="button" class="btn-common btn-color2" style="width:95%" value="검색" onclick="return GoSearch();">
						</td>
					</tr>
				</table>
			</form>
    </div>
  </div>
	<!-- 검색 모달 끝 -->

	<div style="width:90%;margin:0 auto;margin-bottom:10px;">
    <?php if($tech_lv == 3) { ?>
			<!-- <a href="<?php echo site_url();?>/tech/board/manual_input"> -->
				<!-- <input style="width:100%" type="button" class="btn-common btn-color2" value="글쓰기"> -->
			<!-- </a> -->
    <?php } ?>
	</div>
  <div style="position:fixed;bottom:100px;right:5px;">
  		<img src="<?php echo $misc; ?>img/mobile/btn_top.svg" onclick="$('html').scrollTop(0);">
  </div>
	<div style="width:90%;padding-left:10px;padding-bottom:60px;">
		<span style="color:red;margin-right:5px;">*</span><?php echo $title; ?> 검색 시 우측 하단에 검색 아이콘을 눌러주세요.
	</div>
	<?php include $this->input->server('DOCUMENT_ROOT')."/include/mobile_bottom.php"; ?>
  <script language="javascript">
  function open_search() {
  	$('#search_div').bPopup();
  }
  $(window).bind("pageshow", function(event) {
    if (event.originalEvent.persisted) {
        document.location.reload();
    }
  });
  </script>
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
    $("#searchkeyword").val(searchkeyword);
    // console.log(searchkeyword);

    if (searchkeyword.replace(/,/g, "") == "") {
    alert("검색어가 없습니다.");
    location.href = "<?php echo site_url();?>/biz/attendance/annual_usage_status_list";
    return false;
    }

    document.cform.action = "<?php echo site_url();?>/biz/attendance/annual_usage_status_list";
    document.cform.submit();
}
	</script>
</body>
