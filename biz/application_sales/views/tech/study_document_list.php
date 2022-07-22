<?php
include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<script type="text/javascript" src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>
<script language="javascript">
function GoSearch(){
	var searchkeyword = document.mform.searchkeyword.value;
	var searchkeyword = searchkeyword.trim();

//	if(searchkeyword == ""){
//		alert( "검색어를 입력해 주세요." );
//		return false;
//	}

	document.mform.action = "<?php echo site_url();?>/tech/board/study_document_list";
	document.mform.cur_page.value = "";
//	document.mform.search_keyword.value = searchkeyword;
	document.mform.submit();
}

$(document).ready(function() {
   $('li > ul').show();
});
</script>
<body>
	<?php
		include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
	?>
	<div align="center">
	<div class="dash1-1">
	<form name="mform" action="<?php echo site_url();?>/tech/board/study_document_list" method="get" onKeyDown="if(event.keyCode==13) return GoSearch();">
<table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
<input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
<input type="hidden" name="seq" value="">
<input type="hidden" name="mode" value="">
<!-- 타이틀 이미지 자리요 -->
<tr height="5%">
<td class="dash_title">스터디 자료</td>
</tr>
<!-- 타이틀 자리 끝이요 -->
<!-- 여기는 검색 자리요 -->
<tr height="10%">
	<td align="left" valign="bottom">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:70px;">
			<tr>
				<td>
					<span class="search_title">년도</span>
					<select class="select-common" name="search_year" style="margin-left:5px;margin-right:10px;">
						<option value="">년도 선택</option>
						<?php
						$year = date('Y');
						for($i=$year - 1; $i<=$year + 2; $i++){ ?>
							<option value="<?php echo $i; ?>" <?php if($search_year == $i){echo "selected";} ?>><?php echo $i.'년'; ?></option>
			<?php }
						?>
					</select>
					<span class="search_title">주차</span>
					<select class="select-common" name="search_week" style="margin-left:5px;margin-right:10px;">
						<option value="">주차 선택</option>
						<?php
						for($i = 1; $i <= 26; $i++) { ?>
							<option value="<?php echo $i; ?>" <?php if($search_week == $i){echo "selected";} ?>><?php echo $i.'주차'; ?></option>
			<?php }
						?>
					</select>
				<span>
				<select name="search1" id="search1" class="select-common select-style1" style="margin-right:10px;">
					<option value="001" <?php if($search1 == "001"){ echo "selected";}?>>등록자</option>
				</select>
				</span>
				<span>
				<input  type="text" size="25" class="input-common" name="searchkeyword" placeholder="검색하세요." value="<?php echo str_replace('"', '&uml;', $search_keyword );?>"/>
				</span>
				<span>
					<input type="button" class="btn-common btn-style2" value="검색" onClick="return GoSearch();">
				</span>
				</td>
				<td align="right">
					<input type="button" class="btn-common btn-color2" value="글쓰기" onclick="$('#input_modal').bPopup();">
				</td>
			</tr>
		</table>
	</td>
</tr>
<!-- 검색 끝이요 -->
<!-- 본문 자리요 -->
<tr height="45%">
<td valign="top" style="padding:10px 0px;">
		<table class="content_dash_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td>
					<table class="list_tbl" style="margin-top:20px;" width="100%" border="0" cellspacing="0" cellpadding="0">
						<colgroup>
							<col width="15%">
							<col width="5%">
							<col width="5%">
							<col width="5%">
							<col width="30%">
							<col width="10%">
							<col width="5%">
							<col width="5%">
							<col width="5%">
							<col width="15%">
						</colgroup>

						<tr class="t_top row-color1">
							<th></th>
							<th height="40" align="center">NO</th>
							<th align="center">년도</th>
							<th align="center">주차</th>
							<th align="center">제목</th>
							<th align="center">작성자</th>
							<th align="center">작성일</th>
							<th align="center">첨부</th>
							<th align="center">결재</th>
							<th></th>
						</tr>
						<?php
						if ($count > 0) {
							$i = $count - $no_page_list * ( $cur_page - 1 );
							$icounter = 0;

							foreach ( $list_val as $item ) {
								if($item['file_changename']) {
									$strFile = "<img src='".$misc."img/add.png' width='20' height='20' />";
								} else {
									$strFile = "-";
								}
								?>
								<tr onMouseOver="this.style.backgroundColor='#FAFAFA'" onMouseOut="this.style.backgroundColor='#fff'" onclick="JavaScript:ViewBoard('<?php echo $item['seq'];?>')" style="cursor:pointer;">
									<td></td>
									<td height="40" align="center"><?php echo $i;?></td>
									<td align="center"><?php echo $item['year'];?></td>
									<td align="center"><?php echo $item['week'].'주차';?></td>
									<td align="center"><?php echo stripslashes($item['subject']);?></td>
									<td align="center"><?php echo $item['user_name'];?></td>
									<td align="center"><?php echo substr($item['write_date'], 0, 10);?></td>
									<td align="center"><?php echo $strFile;?></td>
									<td align="center"><?php if($item['approval_yn'] == 'Y'){echo '승인';}else{echo '미승인';}?></td>
									<td></td>
								</tr>
								<?php
								$i--;
								$icounter++;
							}
						} else {
							?>
							<tr onMouseOver="this.style.backgroundColor='#FAFAFA'" onMouseOut="this.style.backgroundColor='#fff'">
								<td width="100%" height="40" align="center" colspan="10">등록된 게시물이 없습니다.</td>
							</tr>
							<tr>

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

<!-- 본문 끝이요 -->
<!-- 페이징 들어갈 자리요 -->
<tr height="40%">
	<td align="left" valign="top">
		<table width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<td width="19%">

				<tr height="20%">
					<td align="center" valign="top">
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
for  ( $i = $start_page; $i <= $end_page ; $i++ ){
if( $i == $end_page ) {
	$strSection = "";
} else {
	$strSection = "&nbsp;<span class=\"section\">&nbsp&nbsp</span>&nbsp;";
	// $strSection = "&nbsp;<span class=\"section\">|</span>&nbsp;";
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
<!-- <td width="19"><a href="JavaScript:GoNextPage()"><img src="<?php echo $misc;?>img/dashboard/page_next.png" width="20" height="20"/></a></td> -->
			<td width="2"></td>
			<td width="19"><a href="JavaScript:GoNextPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_right.png" width="20" height="20"/></a></td>
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
</td>
</tr>
</table>
</td>
</tr>
<!-- 페이징 끝이오 -->
</table>
</form>
</div>
</div>

<div id="input_modal" style="display:none; position: absolute; background-color: white; width: auto; height: auto;">
  <form name="cform" id="cform" method="post" enctype="multipart/form-data">
    <table width="100%" height="100%" style="padding:20px 18px;" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="4" align="left" valign="top" style="padding-bottom:20px; font-weight:bold; font-size:17px;">스터디자료 등록</td>
      </tr>
      <tr>
        <th colspan="4" height="2"></th>
        <tr height="40">
          <td align="left" style="padding:0 8px 5px; font-weight:bold;">
            년도
          </td>
          <td>
            <select name="year" id="year" class="select-common" style="width:150px; height:25px;">
              <?php
							$year = date('Y');
							for($k=$year - 1; $k<=$year + 2; $k++){
								if ($year == $k) {
									echo "<option value={$k} selected>{$k}년</option>";
								} else {
									echo "<option value={$k}>{$k}년</option>";
								}
              }?>
            </select>
          </td>
        </tr>
        <tr height="40">
          <td align="left" style="padding:0 8px 5px; font-weight:bold;">
            주차
          </td>
          <td>
            <select name="week" id="week" class="select-common" style="width:150px; height:25px;">
              <?php for($k=1; $k<=25; $k++){
                echo "<option value={$k}>{$k}주차</option>";
              }?>
            </select>
          </td>
        </tr>
      </tr>
      <tr>
        <td colspan="4" align="center" style="padding-top:30px;">
          <input type="button" class="btn-common btn-color2" name="" value="등록" onClick="study_document_input();" style="float:right;">
          <input type="button" class="btn-common btn-color4" name="" value="취소" onClick="$('#input_modal').bPopup().close();" style="float:right;margin-right:10px;">
        </td>
      </tr>
    </table>
  </form>
</div>

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
	document.mform.action = "<?php echo site_url();?>/tech/board/study_document_view";
	document.mform.seq.value = seq;
	document.mform.mode.value = "view";

	document.mform.submit();
}

function study_document_input() {
	var year = $('#year').val();
	var week = $('#week').val();

	if(year == '') {
		alert('년도를 선택해주세요.');
		return false;
	}

	if(week == '') {
		alert('주차를 선택해주세요.');
		return false;
	}

	location.href = "<?php echo site_url(); ?>/tech/board/study_document_input?year=" + year + "&week=" + week;
}
</script>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
</body>
</html>
