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
	window.onload = function(){
	 change();
	}

	function GoSearch(){
		$('#searchkeyword').val($('#modal_searchkeyword').val());
		$('#searchkeyword2').val($('#modal_searchkeyword2').val());
		$('#search2').val($('#modal_search2').val());

		var searchkeyword = $('#searchkeyword').val();
		var searchkeyword = searchkeyword.trim();

		var searchkeyword2 = $('#searchkeyword2').val();

		var search2 = $('#search2').val();

			if((!(searchkeyword>=0 && searchkeyword<=3)||searchkeyword=="")&&search2=='009'){

					alert( "검색 팀명을 다시 입력하세요.\n 기술1팀 : 1 , 기술2팀 : 2, 기술3팀 : 3 , 미배정 : 0" );
					return false;
			}

		if(searchkeyword == ""){
			alert( "검색어를 입력해 주세요." );
			return false;
		}

		document.mform.action = "<?php echo site_url();?>/tech/maintain/maintain_list";
		document.mform.cur_page.value = "";
	//	document.mform.search_keyword.value = searchkeyword;
		document.mform.submit();
	}
	//$(document).ready(function() {
	//   $('li > ul').show();
	//});

	function change(){
		var search2 = $('#modal_search2').val();

		if(search2=="009" || search2=="010" ){
	    $('#modal_searchkeyword2').show();
		}else{
			$('#modal_searchkeyword2').hide();
		}

	}

	function moveList(page){
     location.href="<?php echo site_url();?>/tech/"+page;
  }
  </script>
	<?php
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_side.php";
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_header.php";
  ?>
	<form name="mform" action="<?php echo site_url();?>/tech/maintain/maintain_list" method="get" onkeydown="if(event.keyCode==13) return GoSearch();">
	<input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
	<input type="hidden" name="seq" value="">
	<input type="hidden" name="mode" value="">
	<input type="hidden" id="searchkeyword" name="searchkeyword" value="<?php echo str_replace('"', '&uml;', $search_keyword );?>"/>
	<input type="hidden" id="searchkeyword2" name="searchkeyword2" value="<?php echo $search_keyword2;?>"/>
	<input type="hidden" id="search2" name="search2" value="<?php echo $search2;?>"/>

	 <div class="menu_div">
		 <a class="menu_list" onclick ="moveList('maintain/maintain_list')" style='color:#0575E6'>유지보수</a>
		 <a class="menu_list" onclick ="moveList('board/network_map_list')" style='color:#B0B0B0'>구성도</a>
		 <a class="menu_list" onclick ="moveList('tech_board/tech_doc_list?type=Y')" style='color:#B0B0B0'>기술지원보고서</a>
		 <a class="menu_list" onclick ="moveList('tech_board/request_tech_support_list')" style='color:#B0B0B0'>기술지원요청</a>
		 <a class="menu_list" onclick ="moveList('tech_board/tech_issue')" style='color:#B0B0B0'>요청/이슈</a>
	 </div>

	<div class="content_list">
		<table class="approval_list_tbl" width="100%" border="0" cellspacing="0" cellpadding="0">
			<colgroup>
				<col width="85%">
				<col width="15%">
			</colgroup>
			<tbody>
<?php foreach ($list_val as $item) {
				if($item['manage_team']=="1"){
					$strstep ="기술1팀";
				}else if($item['manage_team']=="2"){
					$strstep ="기술2팀";
				}else if($item['manage_team']=="3"){
					$strstep ="기술3팀";
				}else{
					$strstep ="없음";
				}
				if($cnum == $item['company_num'] || $sales_lv >= 1) {	?>
				<tr onclick="ViewBoard('<?php echo $item['seq'];?>')">
				<?php } else { ?>
				<tr>
				<?php } ?>
					<td align="left" style="color:#A1A1A1;"><?php echo $item['customer_companyname']; ?></td>
					<td align="right" style="color:#A1A1A1;"><?php echo $strstep;?></td>
				</tr>
	<?php	if($cnum == $item['company_num'] || $sales_lv >= 1) {	?>
				<tr onclick="ViewBoard('<?php echo $item['seq'];?>')">
				<?php } else { ?>
				<tr>
				<?php } ?>
					<td align="left" style="color:#1C1C1C;font-weight:bold;"><?php echo $item['project_name'];?></td>
					<td align="right" style="color:#1C1C1C;font-weight:bold;">
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
				</tr>
				<tr><td height="1" colspan="2" bgcolor="#EFEFEF"></td></tr>
<?php } ?>
<?php if($count == 0) { ?>
				<tr>
					<td colspan="2" align="center" height="40" style="font-weight:bold;">등록된 게시물이 없습니다.</td>
				</tr>
<?php } ?>
			</tbody>
		</table>

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
      		<td align="left" height="40">
						<select id="modal_search2" class="select-common select-style1" onChange="change();" style="width:100%;">
							<option value="001" <?php if($search2 == "001"){ echo "selected";}?>>고객사</option>
							<option value="002" <?php if($search2 == "002"){ echo "selected";}?>>프로젝트명</option>
							<option value="003" <?php if($search2 == "003"){ echo "selected";}?>>제조사</option>
							<option value="004" <?php if($search2 == "004"){ echo "selected";}?>>품목</option>
							<option value="005" <?php if($search2 == "005"){ echo "selected";}?>>제품명</option>
							<option value="006" <?php if($search2 == "006"){ echo "selected";}?>>담당자(협력사)</option>
							<option value="007" <?php if($search2 == "007"){ echo "selected";}?>>유지보수시작일</option>
							<option value="008" <?php if($search2 == "008"){ echo "selected";}?>>유지보수종료일</option>
							<option value="009" <?php if($search2 == "009"){ echo "selected";}?>>관리팀</option>
							<option value="010" <?php if($search2 == "010"){ echo "selected";}?>>점검자</option>
						</select>
					</td>
					<td>
						<select id="modal_searchkeyword2" class="select-common select-style1" style="display:none;width:100%;">
							<option value="1" <?php if($search_keyword2 == "1"){ echo "selected";}?>>점검완료</option>
							<option value="9" <?php if($search_keyword2 == "9"){ echo "selected";}?>>점검예정</option>
							<option value="0" <?php if($search_keyword2 == "0"){ echo "selected";}?>>점검미완료</option>
							<option value="2" <?php if($search_keyword2 == "2"){ echo "selected";}?>>점검미대상</option>
						</select>
					</td>
      	</tr>
				<tr>
					<td height="20"></td>
				</tr>
				<tr>
					<td colspan="2">
						<input  type="text" size="25" class="input-common" id="modal_searchkeyword" placeholder="검색하세요." value="<?php echo str_replace('"', '&uml;', $search_keyword );?>" style="width:100%;"/>
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

	function ViewBoard (seq){
		document.mform.action = "<?php echo site_url();?>/tech/maintain/maintain_view";
		document.mform.seq.value = seq;
		document.mform.mode.value = "modify";

		document.mform.submit();
	}

  function open_search() {
  	$('#search_div').bPopup();
  }
  $(window).bind("pageshow", function(event) {
    if (event.originalEvent.persisted) {
        document.location.reload();
    }
  });

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
