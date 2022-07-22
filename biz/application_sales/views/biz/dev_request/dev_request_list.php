<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<!-- <link rel="stylesheet" href="/misc/css/dashboard.css"> -->
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<style media="screen">
.layerpop {
		display: none;
		z-index: 1000;
		border: 2px solid #ccc;
		background: #fff;
		/* cursor: move;  */
		cursor: default;
	 }

.layerpop_area .modal_title {
		padding: 30px 10px 0px 20px;
		/* border: 0px solid #aaaaaa; */
		font-size: 20px;
		font-weight: bold;
		line-height: 24px;
		text-align: left !important;
	 }

.layerpop_area .layerpop_close {
		width: 25px;
		height: 25px;
		display: block;
		position: absolute;
		top: 10px;
		right: 10px;
		background: transparent url('btn_exit_off.png') no-repeat;
	}

.layerpop_area .layerpop_close:hover {
		background: transparent url('btn_exit_on.png') no-repeat;
		cursor: pointer;
	}

.layerpop_area .content {
		width: 96%;
		margin: 2%;
		color: #828282;
	}
</style>
<script language="javascript">

function GoSearch(){
	var searchkeyword = document.mform.searchkeyword.value;
	var searchkeyword = searchkeyword.trim();

	if (searchkeyword.replace(/,/g, "") == "") {
		 alert("검색어가 없습니다.");
		 location.href="<?php echo site_url();?>/biz/dev_request/dev_request_list";
		 return false;
	}

	document.mform.action = "<?php echo site_url();?>/biz/dev_request/dev_request_list";
	document.mform.cur_page.value = "";
	document.mform.submit();
}

</script>
<script type="text/javascript" src="/misc/js/jquery.bpopup-0.1.1.min.js"></script>
<body>
<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
<div align="center">
<div class="dash1-1">
<table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
<form name="mform" action="<?php echo site_url();?>/biz/dev_request/dev_request_list" method="get" onKeyDown="if(event.keyCode==13) return GoSearch();">
<input type="hidden" name="lpp" value="<?php echo $lpp; ?>">
<input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
<input type="hidden" name="seq" value="">
<input type="hidden" name="mode" value="">
<tbody height="100%">
	<!-- 타이틀 이미지 tr -->
<tr height="5%">
  <td class="dash_title">
		개발요청
	</td>
</tr>
<tr>
	<td>
		<table width="100%" cellspacing="0" cellpadding="0" style="margin-top:70px;">
		<tr>
			<td>
			<select name="search1" id="search1" class="select-common select-style1">
				<option value="001" <?php if($search1 == "001"){ echo "selected";}?>>제목</option>
				<option value="002" <?php if($search1 == "002"){ echo "selected";}?>>등록자</option>
			</select>
			<input  type="text" size="25" class="input-common" name="searchkeyword" placeholder="검색하세요." value="<?php echo str_replace('"', '&uml;', $search_keyword );?>"/>
			<input type="button" class="btn-common btn-style2" value="검색" onClick="return GoSearch();">
			<a style="float:right;margin-left:10px;" href="<?php echo site_url();?>/biz/dev_request/dev_request_input">
				<input type="button" class="btn-common btn-color2" value="글쓰기">
			</a>
			<select class="select-common" id="listPerPage" style="height:25px;float:right;color:#1C1C1C;padding-right:5px;height:30px;" onchange="change_lpp();">
				<option value="5" <?php if($lpp==5){echo 'selected';} ?>>5건</option>
				<option value="10" <?php if($lpp==10){echo 'selected';} ?>>10건</option>
				<option value="15" <?php if($lpp==15){echo 'selected';} ?>>15건</option>
				<option value="20" <?php if($lpp==20){echo 'selected';} ?>>20건</option>
				<option value="30" <?php if($lpp==30){echo 'selected';} ?>>30건</option>
				<option value="50" <?php if($lpp==50){echo 'selected';} ?>>50건</option>
			</select>
		</td>
		</tr>
	</table>
</td>
</tr>
<!-- 검색 끝 -->

<!-- 컨텐트 시작 -->
<tr height="45%">
<td valign="top" style="padding:2px 0px 15px 0px">
	<table class="content_dash_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center" valign="top">
              <tr>
                <td><table class="list_tbl" width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:20px;">
									<colgroup>
	                  <col width="10%">
	                  <col width="9%">
	                  <col width="9%">
	                  <col width="35%">
	                  <col width="9%">
	                  <col width="9%">
	                  <col width="9%">
	                  <col width="10%">
	                </colgroup>
                  <tr class="t_top row-color1">
										<th></th>
                    <th height="40" align="center">NO</th>
                    <th align="center">카테고리</th>
                    <th align="center">제목</th>
                    <th align="center">작성자</th>
										<th align="center">담당자</th>
                    <th align="center">개발진행상황</th>
										<th></th>
									</tr>

			<?php
				if ($count > 0) {
					$i = $count - $lpp * ( $cur_page - 1 );
					$icounter = 0;
					foreach ( $list_val as $item ) {
						if($item['file_changename']) {
							$strFile = "<img src='".$misc."img/add.png' width='20' height='20' />";
						} else {
							$strFile = "-";
						}
						?>
						<tr onMouseOver="this.style.backgroundColor='#FAFAFA'" onMouseOut="this.style.backgroundColor='#fff'" style="cursor:pointer;" onclick="ViewBoard(<?php echo $item['seq']; ?>)">
							<td></td>
							<td height="40" align="center"><?php echo $i;?></td>
							<td align="center"><?php echo $item['category'];?></td>
							<td style="padding-left:20px;" align="center"><?php echo $item['subject'];?></td>
							<td align="center"><?php echo $item['user_name'];?></td>
							<td align="center"><?php if(isset($item['responsibility'])) {echo $item['responsibility'];} else { echo '-'; };?></td>
							<td align="center"
							style="color:<?php if($item['progress_step'] == '반려') {echo 'red';} else if($item['progress_step'] == '개발보류') {echo '#808080';} else if($item['progress_step'] == '접수대기') {echo '#D3D3D3';} else if($item['progress_step'] == '접수완료') {echo '#85c86f';} else if($item['progress_step'] == '개발완료') {echo '#black';} else if($item['progress_step'] == '개발진행중') {echo 'blue';}?>"><?php echo $item['progress_step'];?></td>
							<td></td>
						</tr>
						<?php
						$i--;
						$icounter++;
					}
				} else {
			?>
				<tr onMouseOver="this.style.backgroundColor='#FAFAFA'" onMouseOut="this.style.backgroundColor='#fff'">
        	<td width="100%" height="40" align="center" colspan="8">등록된 게시물이 없습니다.</td>
        </tr>
			<?php
				}
			?>
                </table></td>
              </tr>
            </td>
        </tr>
  </table>
</td>
</tr>
<!-- 컨텐트 끝 -->

<!-- 페이징 시작 -->
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
						if ($cur_page > 10) {
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
						for  ( $i = $start_page; $i <= $end_page ; $i++ ) {
						if ( $i == $end_page ) {
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
					</td>
				</tr>
			</table>
		 </td>
		</tr>
<!-- 페이징 끝 -->
</tbody>
</form>
</table>
</div>
</div>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
</body>
<script type="text/javascript">

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

	document.mform.cur_page.value = total_page;
	document.mform.submit();
}

function change_lpp() {
  var lpp = $("#listPerPage").val();
  document.mform.lpp.value = lpp;
  document.mform.submit();
}

function ViewBoard (seq){
  location.href = "<?php echo site_url(); ?>/biz/dev_request/dev_request_view?seq=" + seq;
}

</script>
</html>
