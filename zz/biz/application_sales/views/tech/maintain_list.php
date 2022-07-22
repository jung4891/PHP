<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/customer_top.php";
?>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<style type="text/css">
.searchModal {
display: none; /* Hidden by default */
position: fixed; /* Stay in place */
z-index: 10; /* Sit on top */
left: 0;
top: 0;
width: 100%; /* Full width */
height: 100%; /* Full height */
overflow: auto; /* Enable scroll if needed */
background-color: rgb(0,0,0); /* Fallback color */
background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}
/* Modal Content/Box */
.search-modal-content {
background-color: #fefefe;
margin: 15% auto; /* 15% from the top and centered */
padding: 20px;
border: 1px solid #888;
width: 70%; /* Could be more or less, depending on screen size */
}
</style>
<script language="javascript">
window.onload = function(){
 change();
}

function GoSearch(){
	var searchkeyword = document.mform.searchkeyword.value;
	var searchkeyword = searchkeyword.trim();

	var searchkeyword2 = document.mform.searchkeyword2.value;

	var search2 = document.getElementById("search2").selectedIndex;

		if((!(searchkeyword>=0 && searchkeyword<=3)||searchkeyword=="")&&search2==8){

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
	var search2 = document.getElementById("search2").value;
	var searchkeyword2 = document.getElementById("searchkeyword2");

	if(search2=="009" || search2=="010" ){
        	searchkeyword2.style="width:130px;";
	}else{
        	searchkeyword2.style="display:none;";
	}

}

</script>
<body>
<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
<!--점검 모달이요-->
<div id="modal" class="searchModal">
	<div class="search-modal-content">
		<!-- <button onClick="closeModal();" style="float:right;">닫기</button> -->
		<img src="<?php echo $misc;?>img/dashboard/btn/icon_x.svg" width="25" height="25" style="float:right;" onClick="closeModal();"/>
		<div class="row">
		<div class="col-sm-12">
			<div class="row">
			<div class="col-sm-12">
				<h2 align="center">정기점검 미완료</h2>
			</div>
			<div>
				<table  width="100%" border="1" cellspacing="0" cellpadding="0" style="font-weight:bold;font-size:13px;">
					<tr width="100%" height=30>
						<td align="center" width="10%" bgcolor="f8f8f9" >idx</td>
						<td align="center" width="20%" bgcolor="f8f8f9" >고객사</td>
						<td align="center" width="20%" bgcolor="f8f8f9" >프로젝트명</td>
						<td align="center" width="10%" bgcolor="f8f8f9" >점검주기</td>
						<td align="center" width="10%" bgcolor="f8f8f9" >마지막점검일</td>
						<td align="center" width="10%" bgcolor="f8f8f9" >관리팀</td>
						<td align="center" width="10%" bgcolor="f8f8f9" >점검자</td>
						<td align="center" width="10%" bgcolor="f8f8f9" >코멘트</td>
					</tr>

					<?php
					$idx=1;
					foreach($view_val as $val){
					$font_color='';
					if($val['maintain_result']==9){
						$font_color="style='color:red'";
					}
						echo "<tr height=30 align='center'><td>{$idx}</td>";
						echo "<td>{$val['customer_companyname']}</td>";
						echo "<td>{$val['project_name']}</td>";
						echo "<td>";
						if ($val['maintain_cycle'] == "1") {
							echo "월점검";
						}else if ($val['maintain_cycle'] == "3") {
							echo "분기점검";
						}else if ($val['maintain_cycle'] == "6") {
							echo "반기점검";
						}else if ($val['maintain_cycle'] == "0") {
							echo "장애시";
						}else if ($val['maintain_cycle'] == "7") {
							echo "미점검";
						}else{
							echo "";
						}
						echo "</td>";
						echo "<td {$font_color}>{$val['maintain_date']}</td>";
						echo "<td>";
						if ($val['manage_team'] == "1") {
						echo "기술 1팀";
						}else if ($val['manage_team'] == "2") {
							echo "기술 2팀";
						}else if ($val['manage_team'] == "3") {
							echo "기술 3팀";
						}else{
							echo "";
						}
						echo "</td>";
						echo "<td>{$val['maintain_user']}</td>";
						echo "<td>{$val['maintain_comment']}</td></tr>";

						$idx=$idx+1;
					}
					?>
				</table>
			</div>
			</div>
		</div>
		</div>
	</div>
	</div>
<div align="center">
<div class="dash1-1">
<form name="mform" action="<?php echo site_url();?>/tech/maintain/maintain_list" method="get" onkeydown="if(event.keyCode==13) return GoSearch();">
<table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
<input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
<input type="hidden" name="seq" value="">
<input type="hidden" name="mode" value="">


<!-- 타이틀 이미지 자리요 -->
<tr height="5%">
	<td class="dash_title">
		유지보수
	</td>
</tr>
<!-- 타이틀 자리 끝이요 -->
<!-- 여기는 검색 자리요 -->
<tr height="10%">
<td align="left" valign="bottom">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:70px;">
		<tr>
			<td>
				<select name="search2" id="search2" class="select-common select-style1" onChange="change();" style="margin-right:10px;">
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
			<span>
			<input  type="text" size="25" class="input-common" name="searchkeyword" placeholder="검색하세요." value="<?php echo str_replace('"', '&uml;', $search_keyword );?>" style="margin-right:10px;"/>
			</span>
			<!-- </td>
			<td> -->
<span>
	<select name="searchkeyword2" id="searchkeyword2" class="select-common select-style1" style="display:none;margin-right:10px;">
		<option value="1" <?php if($search_keyword2 == "1"){ echo "selected";}?>>점검완료</option>
		<option value="9" <?php if($search_keyword2 == "9"){ echo "selected";}?>>점검예정</option>
		<option value="0" <?php if($search_keyword2 == "0"){ echo "selected";}?>>점검미완료</option>
		<option value="2" <?php if($search_keyword2 == "2"){ echo "selected";}?>>점검미대상</option>
	</select>
</span>
			<span>
				<input type="button" class="btn-common btn-style2" value="검색" onClick="return GoSearch();">
			</span>
			</td>
			<td align="right">
				<input type="button" class="btn-common btn-color5" value="정기점검 미완료" onclick="openModal();" style="width:120px;"/>
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
				<table class="list_tbl list" style="margin-top:20px;" width="100%" border="0" cellspacing="0" cellpadding="0">
					<colgroup>
						<col width="3%" />
						<col width="5%" />
						<col width="12%" />
						<col width="16%" />
						<col width="9%" />
						<col width="9%" />
						<col width="9%" />
						<col width="9%" />
						<col width="5%" />
						<col width="5%" />
						<col width="5%" />
						<col width="5%" />
						<col width="5%" />
						<col width="3%" />
					</colgroup>

					<tr class="t_top row-color1">
						<th></th>
						<th height="40" align="center">번호</th>
						<th align="center">고객사</th>
						<th align="center">프로젝트</th>
						<th align="center">제조사</th>
						<th align="center">품목</th>
						<th align="center">제품명</th>
						<th align="center">유지보수종료일</th>
						<th align="center">점검주기</th>
						<th align="center">관리팀</th>
						<th align="center">점검자</th>
						<th align="center">점검여부</th>
						<th align="center">첨부파일</th>
						<th></th>
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


							//						echo "로그인cnum::".$cnum."<br>";
							//						echo "가져온cnum::".$item['company_num']."<br>";


							/*						if($item['progress_step'] == "001") {
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
}*/
?>
<?php if($cnum == $item['company_num'] || $tech_lv != "0") { ?><tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'" style="cursor:pointer" onclick="ViewBoard('<?php echo $item['seq'];?>')"><?php } else {?><tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'"><?php } ?>
	<td></td>
	<td height="40" align="center"><?php echo $i;?></td>
	<td align="center"><?php echo $item['customer_companyname'];?></td>
	<td align="center"><?php echo $item['project_name'];?></td>
	<td align="center"><?php echo $item['product_company'];?></td>
	<td align="center"><?php echo $item['product_item'];?></td>
	<td align="center"><?php echo $item['product_name'];?></td>
	<td align="center"><?php echo $item['exception_saledate3'];?></td>
	<td align="center">
		<?php switch($item['maintain_cycle']){
			case 0:
			echo "장애시";
			break;
			case 1:
			echo "월점검";
			break;
			case 3:
			echo "분기점검";
			break;
			case 6:
			echo "반기점검";
			break;
			case 7:
			echo "미점검";
			break;
			default:
			echo "미선택";
			break;
		}

		?>


	</td>
	<td align="center"><?php echo $strstep;?></td>
	<td align="center"><?php echo $item['maintain_user'];?></td>
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
	<td align="center">
		<?php if ( $item['maintain_result']==1 && $item['file'] == 'Y'){ echo "<img src='{$misc}img/add.png'/>" ;}else{echo "-";};?>
	</td>
</a>
<td></td>

</tr>
<?php
$i--;
$icounter++;
}
} else {
	?>
	<tr onMouseOver="this.style.backgroundColor='#FAFAFA'" onMouseOut="this.style.backgroundColor='#fff'">
		<td width="100%" height="40" align="center" colspan="14">등록된 게시물이 없습니다.</td>
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
		<td width="19"><a href="JavaScript:GoNextPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_right.svg" width="20" height="20"/></a></td>
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
</script>
<!--하단-->
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
<!--하단-->
<script>
function closeModal() {
	$('.searchModal').hide();
};

function openModal(){
	$("#modal").show();
}
</script>
</body>
</html>
