<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";

	if($search_keyword != ''){
		$filter = explode(',',str_replace('"', '&uml;',$search_keyword));
	}
	if(isset($_GET['search_mode'])) {
		$search_mode = $_GET['search_mode'];
	} else {
		$search_mode = 'simple';
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
	.content_list {
		width:100%;
	 display: inline-block;
	 padding-bottom:20px;
	}
	.approval_list_tbl {
		padding-top: 20px;
		padding-left: 15px;
		padding-right:15px;
		border-spacing: 0 10px;
		table-layout: fixed;
	}
	.approval_list_tbl td {
		overflow:hidden;
		white-space : nowrap;
		text-overflow: ellipsis;
	}
	#paging_tbl {
		margin-top:10px;
		width:100%;
	}
	#paging_tbl a {
		font-size: 18px;
	}
	.input-common, .select-common, .btn-common {
		height: 40px !important;
		border-radius: 3px !important;
		box-sizing : border-box !important;
	}
	.dayBtn {
		background:url(<?php echo $misc; ?>img/mobile/footer_schedule.svg) no-repeat 98% 50% #fff;
		background-size: 20px;
	}
	</style>
	<link rel="stylesheet" href="/misc/css/view_page_common.css">
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

	function moveList(page){
		if(page == 'maintain_unissued') {
			location.href="<?php echo site_url();?>/sales/maintain/maintain_unissued";
		} else {
			location.href="<?php echo site_url();?>/sales/maintain/maintain_list?type="+page;
		}
  }
  </script>
	<?php
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_side.php";
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_header.php";
  ?>
		<form name="mform" action="<?php echo site_url();?>/sales/maintain/maintain_unissued" method="get" onkeydown="if(event.keyCode==13) return GoSearch();">
			<input type="hidden" name="seq" value="">
		  <input type="hidden" name="mode" value="">
		  <input type="hidden" name="type" value="">
		  <input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
		  <input type="hidden" name="lpp" value="<?php echo $no_page_list; ?>">
		  <input type="hidden" id="searchkeyword" name="searchkeyword" value="<?php echo str_replace('"', '&uml;', $search_keyword );?>"/>

			<div class="menu_div">
			 <a class="menu_list" onclick ="moveList('001')" style='color:#B0B0B0'>유지보수</a>
			 <a class="menu_list" onclick ="moveList('002')" style='color:#B0B0B0'>통합유지보수</a>
			 <a class="menu_list" onclick ="moveList('maintain_unissued')" style='color:#0575E6'>계산서 미발행 목록</a>
			</div>

	<div class="content_list">
		<table class="approval_list_tbl" width="100%" border="0" cellspacing="0" cellpadding="0">
			<colgroup>
				<col width="85%">
				<col width="15%">
			</colgroup>
			<tbody>
<?php foreach ($view_val as $val){ ?>
				<tr onclick="ViewBoard('<?php echo $val->maintain_seq;?>', '<?php echo $val->view_type; ?>')">
					<td align="left" style="color:#A1A1A1;"><?php echo $val->customer_companyname; ?></td>
					<td align="right" style="color:#A1A1A1;"><?php echo $val->dept; ?></td>
				</tr>
				<tr onclick="ViewBoard('<?php echo $val->maintain_seq;?>', '<?php echo $val->view_type; ?>')">
					<td align="left" style="color:#1C1C1C;font-weight:bold;"><?php echo $val->project_name; ?></td>
					<td align="right" style="color:#1C1C1C;font-weight:bold;"><?php echo ($val->type == '001') ?'매출' : '매입'; ?></td>
				</tr>
				<tr><td height="1" colspan="2" bgcolor="#EFEFEF"></td></tr>
<?php } ?>
<?php if($count == 0) { ?>
				<tr>
					<td colspan="2" align="center" height="40" style="font-weight:bold;">등록된 게시물이 없습니다.</td>
				</tr>
<?php } ?>
			</tbody>

		<!-- 페이징 -->
		<table id="paging_tbl" cellspacing="0" cellpadding="0">
		  <!-- 페이징처리 -->
		  <tr>
		     <td align="center">
		     <?php if ($count > 0) {?>
		           <table border="0" cellspacing="0" cellpadding="0">
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
		     <?php }?>
		           </td>
		     </tr>
		  <!-- 페이징처리끝 -->
		</table>
	</div>

	<!-- 검색 모달 시작 -->
  <div id="search_div" style="height:auto;width:100%;background-color:#ffffff; display:none;border-radius:5px;">
    <div class="modal_contain" style="font-size:16px; color:#1C1C1C;font-weight:bold;">
      <table style="width:100%;padding:5%;" cellspacing="0">
				<colgroup>
					<col width="50%">
					<col width="50%">
				</colgroup>
				<tr>
      		<td align="left" colspan="2" height="40">구분</td>
      	</tr>
				<tr>
					<td colspan="2">
						<select id="filter1" class="select-common select-style1 filtercolumn" name="sales_type" style="width:100%;">
	            <option value="">전체</option>
	            <option value="001" <?php if(isset($filter) && $filter[0] == '001'){echo "selected";} ?>>매출</option>
	            <option value="002" <?php if(isset($filter) && $filter[0] == '002'){echo "selected";} ?>>매입</option>
	          </select>
					</td>
				</tr>
				<tr>
      		<td align="left" colspan="2" height="40">회사</td>
      	</tr>
				<tr>
					<td colspan="2">
						<select id="filter2" class="select-common select-style1 filtercolumn" name="company" onchange="change_company(this);" style="width:100%;">
	            <option value="">미선택</option>
	            <option value="IT" <?php if(isset($filter) && $filter[1] == 'IT'){echo "selected";} ?>>IT</option>
	            <option value="ICT" <?php if(isset($filter) && $filter[1] == 'ICT'){echo "selected";} ?>>ICT</option>
	            <option value="MG" <?php if(isset($filter) && $filter[1] == 'MG'){echo "selected";} ?>>MG</option>
	          </select>
					</td>
				</tr>
				<tr class="dept" style="<?php if(isset($filter) && $filter[1] != 'IT'){echo "display:none";} ?>">
      		<td align="left" colspan="2" height="40">부서</td>
      	</tr>
				<tr class="dept" style="<?php if(isset($filter) && $filter[1] != 'IT'){echo "display:none";} ?>">
					<td colspan="2">
						<select id="filter3" class="select-common select-style1 filtercolumn dept" name="dept" style="width:100%;">
	            <option value="전체" <?php if(isset($filter) && $filter[2] == '전체'){echo "selected";} ?>>전체</option>
	            <option value="사업1부" <?php if(isset($filter) && $filter[2] == '사업1부'){echo "selected";} ?>>사업1부</option>
	            <option value="사업2부" <?php if(isset($filter) && $filter[2] == '사업2부'){echo "selected";} ?>>사업2부</option>
	            <option value="기술지원부" <?php if(isset($filter) && $filter[2] == '기술지원부'){echo "selected";} ?>>기술지원부</option>
	          </select>
					</td>
				</tr>
				<tr>
      		<td align="left" colspan="2" height="40">종류</td>
      	</tr>
				<tr>
					<td colspan="2">
						<select id="filter4" class="select-common select-style1 filtercolumn" name="maintain_type" style="width:100%;">
	            <option value="">미선택</option>
	            <option value="유지보수" <?php if(isset($filter) && $filter[3] == '유지보수'){echo "selected";} ?>>유지보수</option>
	            <option value="통합유지보수" <?php if(isset($filter) && $filter[3] == '통합유지보수'){echo "selected";} ?>>통합유지보수</option>
	            <option value="기술지원요청" <?php if(isset($filter) && $filter[3] == '기술지원요청'){echo "selected";} ?>>기술지원요청</option>
	          </select>
					</td>
				</tr>
				<tr>
      		<td align="left" colspan="2" height="40">발행예정기간</td>
      	</tr>
				<tr>
					<td>
						<input id="filter5" type="date" class="input-common input-style1 filtercolumn dayBtn" name="start_d" value="<?php if(isset($filter)){echo $filter[4];} ?>" style="width:160px" />
					</td>
					<td>
						<input id="filter6" type="date" class="input-common input-style1 filtercolumn dayBtn" name="end_d" value="<?php if(isset($filter)){echo $filter[5];} ?>" style="width:160px" />
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
						<input type="button" class="btn-common btn-color2" style="width:95%" value="검색" onclick="return GoSearch('simple');">
					</td>
				</tr>
      </table>
    </div>
  </div>
	<!-- 검색 모달 끝 -->
</form>
	<div style="width:90%;margin:0 auto;margin-bottom:10px;">
    <?php if($tech_lv == 3) { ?>
			<!-- <a href="<?php echo site_url();?>/tech/board/manual_input"> -->
				<!-- <input style="width:100%" type="button" class="btn-common btn-color2" value="글쓰기"> -->
			<!-- </a> -->
    <?php } ?>
	</div>
	<div style="width:90%;padding-left:10px;padding-bottom:60px;">
		<span style="color:red;margin-right:5px;">*</span><?php echo $title; ?> 검색 시 우측 하단에 검색 아이콘을 눌러주세요.
	</div>
	<?php include $this->input->server('DOCUMENT_ROOT')."/include/mobile_bottom.php"; ?>
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

	function ViewBoard(main_seq, main_type){
		if (main_seq.indexOf('r_') != -1) {
			location.href='<?php echo site_url(); ?>/tech/tech_board/request_tech_support_list';
		} else {
			document.mform.action = "<?php echo site_url();?>/sales/maintain/maintain_view";
			document.mform.seq.value = main_seq;
			document.mform.mode.value = "modify";
			document.mform.type.value = main_type;

			document.mform.submit();
		}
	}

  function open_search() {
  	$('#search_div').bPopup();
  }
  $(window).bind("pageshow", function(event) {
    if (event.originalEvent.persisted) {
        document.location.reload();
    }
  });

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

	function change_company(el) {
		if($(el).val() == 'IT') {
			$(".dept").show();
		} else {
			$(".dept").hide();
		}
	}
  </script>
</body>
