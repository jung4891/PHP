<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/customer_top.php";
?>
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

	document.mform.action = "<?php echo site_url();?>/maintain/maintain_list";
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
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
<form name="mform" action="<?php echo site_url();?>/maintain/maintain_list" method="get" onkeydown="if(event.keyCode==13) return GoSearch();">
<input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
<input type="hidden" name="seq" value="">
<input type="hidden" name="mode" value="">
<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/tech_header.php";
?>
  <tr>
    <td align="center" valign="top">

    <table width="1130" height="100%" cellspacing="0" cellpadding="0" >
        <tr>
            
            <td width="923" align="center" valign="top">

            <!--내용-->
            <table width="1100" border="0" style="margin-top:50px; margin-bottom: 50px;">
              <!--타이틀-->
              <tr>
                <td class="title3">유지보수</td>
              </tr>
              <!--타이틀-->
              <tr>
                <td>&nbsp;</td>
              </tr>
              <!--선택/찾기-->
              <tr>
                <td><table border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td>
                     <select name="search2" id="search2" class="input" onChange="change();">
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
                    <td style="padding-left:10px;"><table border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td><input type="text" size="25" class="input" name="searchkeyword" placeholder="검색하세요." value="<?php echo str_replace('"', '&uml;', $search_keyword );?>"/></td>
                        <td>
							<select name="searchkeyword2" id="searchkeyword2" class="input" style="display:none;">
								<option value="1" <?php if($search_keyword2 == "1"){ echo "selected";}?>>점검완료</option>
								<option value="9" <?php if($search_keyword2 == "9"){ echo "selected";}?>>점검예정</option>
								<option value="0" <?php if($search_keyword2 == "0"){ echo "selected";}?>>점검미완료</option>
								<option value="2" <?php if($search_keyword2 == "2"){ echo "selected";}?>>점검미대상</option>
							</select>
						</td>
                        <td style="padding-left:2px;"><input type="image" style='cursor:hand' onclick="return GoSearch();" src="<?php echo $misc;?>img/btn_search.jpg" align="middle" border="0" />
                        </td>
                      </tr>
                    </table></td>
                  </tr>
                </table></td>
              </tr>
              <!--선택/찾기-->
              <tr>
                <td>&nbsp;</td>
              </tr>
              <!--리스트-->
              <tr>
                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <colgroup>
                  	<col width="5%" />
                    <col width="12%" />
                    <col width="18%" />
                    <col width="10%" />
                    <col width="10%" />
                    <col width="10%" />
                    <col width="10%" />
                    <col width="5%" />
                    <col width="5%" />
					<col width="5%" />
					<col width="5%" />
					<col width="5%" />
                  </colgroup>
                  <tr>
                    <td colspan="12" height="2" bgcolor="#797c88"></td>
                  </tr>
                  <tr bgcolor="f8f8f9" class="t_top">
                    <td rowspan="2" height="60" align="center">번호</td>
                    <td rowspan="2" align="center" class="t_border">고객사</td>
                    <td rowspan="2" align="center" class="t_border">프로젝트</td>
                    <td colspan="3" align="center" class="t_border" style="height:30px;">제안제품</td>
					<td rowspan="2" align="center" class="t_border">유지보수종료일</td>
					<td rowspan="2" align="center" class="t_border">점검주기</td>
					<td rowspan="2" align="center" class="t_border">관리팀</td>
					<td rowspan="2" align="center" class="t_border">점검자</td>
					<td rowspan="2" align="center" class="t_border">점검여부</td>
					<td rowspan="2" align="center" class="t_border">첨부파일</td>
                  </tr>
				  <tr>
                  	<td style="border-top:1px solid #797c88; height:30px;" bgcolor="#f8f8f9" align="center" class="t_border">제조사</td>
                    <td style="border-top:1px solid #797c88; height:30px;" bgcolor="#f8f8f9" align="center" class="t_border">품목</td>
                    <td style="border-top:1px solid #797c88; height:30px;" bgcolor="#f8f8f9" align="center" class="t_border">제품명</td>
                  </tr>
                  <tr>
                    <td colspan="12" height="1" bgcolor="#797c88"></td>
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
                 <?php if($cnum == $item['company_num'] || $lv != "") { ?><tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'" style="cursor:pointer" onclick="ViewBoard('<?php echo $item['seq'];?>')"><?php } else {?><tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'"><?php } ?>
                    <td height="40" align="center"><?php echo $i;?></td>
                    <td align="center" class="t_border"><?php echo $item['customer_companyname'];?></td>
                    <td align="center" class="t_border"><?php echo $item['project_name'];?></td>
                    <td align="center" class="t_border"><?php echo $item['product_company'];?></td>
                    <td align="center" class="t_border"><?php echo $item['product_item'];?></td>
                    <td align="center" class="t_border"><?php echo $item['product_name'];?></td>
                    <td align="center" class="t_border"><?php echo $item['exception_saledate3'];?></td>
                    <td align="center" class="t_border">
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
					<td align="center" class="t_border"><?php echo $strstep;?></td>
					<td align="center" class="t_border"><?php echo $item['maintain_user'];?></td>
                    <td align="center" class="t_border">
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
					<td align="center" class="t_border">
						<?php if ( $item['maintain_result']==1 && $item['file'] == 'Y'){ echo "<img src='{$misc}img/add.png'/>" ;}else{echo "-";};?>
					</td>
		</a>

                  </tr>
                  <tr>
                    <td colspan="12" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
           <?php
						$i--;
						$icounter++;
					}
				} else {
			?>
				<tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'">
                    <td width="100%" height="40" align="center" colspan="9">등록된 게시물이 없습니다.</td>
                  </tr>
                  <tr>
                    <td colspan="12" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
			<?php
				}
			?>
                    <td colspan="12" height="2" bgcolor="#797c88"></td>
                  </tr>
                </table></td>
              </tr>
              <!--리스트-->
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
	document.mform.action = "<?php echo site_url();?>/maintain/maintain_view";
	document.mform.seq.value = seq;
	document.mform.mode.value = "modify";

	document.mform.submit();
}
</script>
              <tr>
                <td height="15"></td>
              </tr>
              <!--버튼-->
             <tr>
                <td align="left">
					<input type="button" class="basicBtn" value="정기점검 미완료" onclick="openModal();" />
				</td>
              </tr>
              <!--버튼-->

              <!--페이징-->
              <tr>
                <td align="center">
		<?php if ($count > 0) {?>
				<table width="400" border="0" cellspacing="0" cellpadding="0">
                  <tr>
				<?php
					if ($cur_page > 10){
				?>
                    <td width="19"><a href="JavaScript:GoFirstPage()"><img src="<?php echo $misc;?>img/btn_prev.jpg" /></a></td>
                    <td width="2"></td>
                    <td width="19"><a href="JavaScript:GoPrevPage()"><img src="<?php echo $misc;?>img/btn_left.jpg" /></a></td>
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
								$strSection = "&nbsp;<span class=\"section\">|</span>&nbsp;";
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
					<td width="19"><a href="JavaScript:GoNextPage()"><img src="<?php echo $misc;?>img/btn_right.jpg"/></a></td>
                    <td width="2"></td>
                    <td width="19"><a href="JavaScript:GoLastPage()"><img src="<?php echo $misc;?>img/btn_next.jpg" /></a></td>
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
              <!--페이징-->
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table>
			<!--내용-->
			<div id="modal" class="searchModal">
				<div class="search-modal-content">
					<button onClick="closeModal();" style="float:right;">닫기</button>
					<div class="page-header">
					<h1>MODAL</h1>
					</div>
					<div class="row">
					<div class="col-sm-12">
						<div class="row">
						<div class="col-sm-12">
							<h2>정기점검 미완료</h2>
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
            </td>
          
        </tr>
	 </table>
    </td>
  </tr>
  <!--하단-->
  <tr>
  	<td align="center" height="100" bgcolor="#CCCCCC"><table width="1130" cellspacing="0" cellpadding="0" >
      <tr>
        <td width="197" height="100" align="center" background="<?php echo $misc;?>img/customer_f_bg.png"><img src="<?php echo $misc;?>img/f_ci.png"/></td>
        <td><?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?></td>
      </tr>
    </table></td>
  </tr>
  <!--하단-->
</form>
</table>
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
