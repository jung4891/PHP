<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<script language="javascript">
function GoSearch(){
	var searchkeyword = document.mform.searchkeyword.value;
	var searchkeyword = searchkeyword.trim();

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
</script>
<body>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
<form name="mform" action="<?php echo site_url();?>/maintain/maintain_list" method="get" onkeydown="if(event.keyCode==13) return GoSearch();">
<input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
<input type="hidden" name="seq" value="">
<input type="hidden" name="mode" value="">
  <tr>
  	<td height="203" align="center" background="<?php echo $misc;?>img/customer07_bg.jpg">
    <table width="1130" cellspacing="0" cellpadding="0" >
    	<tr>
            <td width="197" height="30" background="<?php echo $misc;?>img/customer_t.png"></td>
          <td align="right"><table width="15%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="right"> <?php if( $id != null ) {?>
			  <a href="<?php echo site_url();?>/account/modify_view"><?php echo $name;?></a> 님 | <a href="<?php echo site_url();?>/account/logout"><img src="<?php echo $misc;?>img/btn_logout.jpg" align="absmiddle" /></a>
			  <?php } else {?>
				<a href="<?php echo site_url();?>/account"><img src="<?php echo $misc;?>img/btn_login.jpg" align="absmiddle" /></a>
			  <?php }?></td>
            </tr>
          </table></td>
        </tr>
        <tr>
            <td height="173"><a href="<?php echo site_url();?>"><img src="<?php echo $misc;?>img/sales_title.png" width="197" height="173" /></a></td>
            <td align="center" class="title1">고객의 미래를 생각하는 기업
            <p class="title2">두리안정보기술센터에 오신것을 환영합니다.</p></td>
        </tr>
     </table>
    </td>
  </tr>
  <tr>
    <td align="center" valign="top">

    <table width="1130" height="100%" cellspacing="0" cellpadding="0" >
        <tr>
            <td width="197" valign="top" background="<?php echo $misc;?>img/customer_m_bg.png" style="min-height:620px;">

            <div id='cssmenu'>
            <ul>
               <li><a href='<?php echo site_url();?>/board/notice_list'><span>공지사항</span></a></li>
               <li class='has-sub'><a href='<?php echo site_url();?>/board/manual_list'><span>자료실</span></a>
                  <ul>
                     <li><a href='<?php echo site_url();?>/board/manual_list'><span>매뉴얼</span></a>
                     </li>
                     <li><a href='<?php echo site_url();?>/board/edudata_list'><span>교육자료</span></a>
                     </li>
                  </ul>
               </li>
               <li><a href='<?php echo site_url();?>/board/qna_list'><span>QnA</span></a></li>
               <li><a href='<?php echo site_url();?>/board/faq_list'><span>FAQ</span></a></li>
		<li><a href='<?php echo site_url();?>/forcasting/forcasting_list'><span>포캐스팅</span></a></li>
		<li><a href='<?php echo site_url();?>/maintain/maintain_list'><span class="point">유지보수</span></a></li>
               <li class='last'><a href='<?php echo site_url();?>/customer/customer_view'><span>거래처</span></a></li>
            </ul>
            </div>



            </td>
            <td width="923" align="center" valign="top">

            <!--내용-->
            <table width="890" border="0" style="margin-top:20px;">
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
                     <select name="search2" id="search2" class="input">
                    <option value="001" <?php if($search2 == "001"){ echo "selected";}?>>고객사</option>
                    <option value="002" <?php if($search2 == "002"){ echo "selected";}?>>프로젝트명</option>
					<option value="003" <?php if($search2 == "003"){ echo "selected";}?>>제조사</option>
					<option value="004" <?php if($search2 == "004"){ echo "selected";}?>>품목</option>
					<option value="005" <?php if($search2 == "005"){ echo "selected";}?>>제품명</option>
					<option value="006" <?php if($search2 == "006"){ echo "selected";}?>>담당자(협력사)</option>
					<option value="007" <?php if($search2 == "007"){ echo "selected";}?>>예상월</option>
                	</select>
                    </td>
                    <td style="padding-left:10px;"><table border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td><input type="text" size="25" class="input" name="searchkeyword" placeholder="검색하세요." value="<?php echo str_replace('"', '&uml;', $search_keyword );?>"/></td>
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
                  	<col width="10%" />
                    <col width="20%" />
                    <col width="10%" />
                    <col width="10%" />
                    <col width="10%" />
                    <col width="10%" />
                    <col width="10%" />
                    <col width="10%" />
                    <col width="10%" />
                  </colgroup>
                  <tr>
                    <td colspan="9" height="2" bgcolor="#797c88"></td>
                  </tr>
                  <tr bgcolor="f8f8f9" class="t_top">
                    <td rowspan="2" height="60" align="center">번호</td>
                    <td rowspan="2" align="center" class="t_border">고객사</td>
                    <td rowspan="2" align="center" class="t_border">프로젝트</td>
                    <td colspan="3" align="center" class="t_border" style="height:30px;">제안제품</td>
					<td rowspan="2" align="center" class="t_border">예상월</td>
                    <td rowspan="2" align="center" class="t_border">진척단계</td>
                    <td rowspan="2" align="center" class="t_border">담당자(협력사)</td>
                  </tr>
				  <tr>
                  	<td style="border-top:1px solid #797c88; height:30px;" bgcolor="#f8f8f9" align="center" class="t_border">제조사</td>
                    <td style="border-top:1px solid #797c88; height:30px;" bgcolor="#f8f8f9" align="center" class="t_border">품목</td>
                    <td style="border-top:1px solid #797c88; height:30px;" bgcolor="#f8f8f9" align="center" class="t_border">제품명</td>
                  </tr>
                  <tr>
                    <td colspan="9" height="1" bgcolor="#797c88"></td>
                  </tr>
			<?php
				if ($count > 0) {
					$i = $count - $no_page_list * ( $cur_page - 1 );
					$icounter = 0;

					foreach ( $list_val as $item ) {

//						echo "로그인cnum::".$cnum."<br>";
//						echo "가져온cnum::".$item['company_num']."<br>";


						if($item['progress_step'] == "001") {
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
						}
			?>
                 <?php if($cnum == $item['company_num'] || $lv == 3) { ?><tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'" style="cursor:pointer" onclick="ViewBoard('<?php echo $item['seq'];?>')"><?php } else {?><tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'"><?php } ?>
                    <td height="40" align="center"><?php echo $i;?></td>
                    <td align="center" class="t_border"><?php echo $item['customer_companyname'];?></td>
                    <td align="center" class="t_border"><?php echo $item['project_name'];?></td>
                    <td align="center" class="t_border"><?php echo $item['product_company'];?></td>
                    <td align="center" class="t_border"><?php echo $item['product_item'];?></td>
                    <td align="center" class="t_border"><?php echo $item['product_name'];?></td>
                    <td align="center" class="t_border"><?php echo $item['exception_saledate'];?></td>
                    <td align="center" class="t_border"><?php echo $strStep;?></td>
                    <td align="center" class="t_border"><?php echo $item['cooperation_username'];?></td></a>
                  </tr>
                  <tr>
                    <td colspan="9" height="1" bgcolor="#e8e8e8"></td>
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
                    <td colspan="9" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
			<?php
				}
			?>
                    <td colspan="9" height="2" bgcolor="#797c88"></td>
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
                <td align="right"><a href="<?php echo site_url();?>/maintain/maintain_input" title="작성하기"><img src="<?php echo $misc;?>img/btn_make.jpg" width="64" height="31" /></a></td>
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

            </td>
          <td width="8" background="<?php echo $misc;?>img/right_bg.png"></td>
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

</body>
</html>