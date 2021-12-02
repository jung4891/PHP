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

	document.mform.action = "<?php echo site_url();?>/account/user";
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
<form name="mform" action="<?php echo site_url();?>/account/user" method="get" onkeydown="if(event.keyCode==13) return GoSearch();">
<input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
<input type="hidden" name="seq" value="">
<input type="hidden" name="mode" value="">
  <tr>
  	<td height="203" align="center" background="<?php echo $misc;?>img/customer04_bg.jpg">
    <table width="1130" cellspacing="0" cellpadding="0" >
    	<tr>
            <td width="197" height="30" background="<?php echo $misc;?>img/customer_t.png"></td>
          <td align="right"><table width="15%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="right">
			  <?php if( $id != null ) {?>
			  <a href="<?php echo site_url();?>/account/modify_view"><?php echo $name;?></a> 님 | <a href="<?php echo site_url();?>/account/logout"><img src="<?php echo $misc;?>img/btn_logout.jpg" align="absmiddle" /></a>
			  <?php } else {?>
				<a href="<?php echo site_url();?>/account"><img src="<?php echo $misc;?>img/btn_login.jpg" align="absmiddle" /></a>
			  <?php }?>
			  </td>
            </tr>
          </table></td>
        </tr>
        <tr>
            <td height="173"><a href="<?php echo site_url();?>"><img src="<?php echo $misc;?>img/admin_title.png" width="197" height="173" /></a></td>
            <td align="center" class="title1">고객의 미래를 생각하는 기업
            <p class="title2">두리안정보기술센터에 오신것을 환영합니다.</p></td>
        </tr>
     </table>
    </td>
  </tr>
	<tr style="height: 0px;">
	<td width="197" valign="top" style="background-color: #666666">
            
            <div id='cssmenu'>
            <ul>
               <li style="float: left"><a href='<?php echo site_url();?>/account/user'><span class="point">회원정보</span></a></li>
               <!--<li class='has-sub'><a href='#'><span>자료실</span></a>
                  <ul>
                     <li><a href='#'><span>매뉴얼</span></a>
                     </li>
                     <li><a href='#'><span>교육자료</span></a>
                     </li>
                  </ul>
               </li>-->
               <li style="float: left"><a href='<?php echo site_url();?>/company/companynum_list'><span>사업자등록번호</span></a></li>
               <li style="float: left"><a href='<?php echo site_url();?>/company/product_list'><span>제품명</span></a></li>
               <li  style="float: left"><a href='<?php echo site_url();?>/customer/customer_list'><span>거래처</span></a></li>
               <li class="last"  style="float: left"><a href='<?php echo site_url();?>/customer/sourcing_list'><span>Sourcing Group</span></a></li>
               <li class="last"  style="float: left"><a href='<?php echo site_url();?>/account/group_tree_management'><span>조직도 관리</span></a></li>
            </ul>
            </div>
            
            
            
            </td>
		</tr>
  <tr>
    <td align="center" valign="top">
    
    <table width="1130" height="100%" cellspacing="0" cellpadding="0" >
        <tr>
            
            <td width="923" align="center" valign="top">
            
            <!--내용-->
            <table width="1100" border="0" style="margin-top:50px; margin-bottom: 50px;">
              <!--타이틀-->
              <tr>
                <td class="title3">회원정보</td>
              </tr>
             <tr>
                <td>&nbsp;</td>
              </tr>
              <!--선택/찾기-->
              <tr>
                <td><table border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td>
                     <select name="search2" id="search2" class="input">
                    <option value="001" <?php if($search2 == "001"){ echo "selected";}?>>회사명</option>
                    <option value="002" <?php if($search2 == "002"){ echo "selected";}?>>아이디</option>
					<option value="003" <?php if($search2 == "003"){ echo "selected";}?>>사업자등록번호</option>
					<option value="004" <?php if($search2 == "004"){ echo "selected";}?>>이름</option>
					<option value="005" <?php if($search2 == "005"){ echo "selected";}?>>이메일</option>
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
              <!--//선택/찾기-->
              <tr>
                <td>&nbsp;</td>
              </tr>
              
             <!--리스트-->
             <tr>
                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <colgroup>
                  	<col width="5%" />
                    <!-- <col width="5%" /> -->
                    <col width="10%" />
                    <col width="10%" />
                    <col width="10%" />
                    <col width="10%" />
                    <col width="10%" />
                    <col width="5%" />
                    <col width="15%" />
                    <col width="10%" />
                    <col width="5%" />
                  </colgroup>
                  <tr>
                    <td colspan="11" height="2" bgcolor="#797c88"></td>
                  </tr>
                  <tr bgcolor="f8f8f9" class="t_top">
                    <td height="40" align="center">번호</td>
                    <!-- <td align="center" class="t_border">구분</td> -->
                    <td align="center" class="t_border">회사명</td>
                    <td align="center" class="t_border">부서</td>
                    <td align="center" class="t_border">아이디</td>
					<td align="center" class="t_border">사업자등록번호</td>
                    <td align="center" class="t_border">이름</td>
                    <td align="center" class="t_border">직급/직책</td>
                    <td align="center" class="t_border">이메일</td>
                    <td align="center" class="t_border">연락처</td>
                    <td align="center" class="t_border">승인여부</td>
                  </tr>

                  <tr>
                    <td colspan="11" height="1" bgcolor="#797c88"></td>
                  </tr>
			<?php
				if ($count > 0) {
					$i = $count - $no_page_list * ( $cur_page - 1 );
					$icounter = 0;
					
					foreach ( $list_val as $item ) {
						if($item['user_part'] == "001") {
							$strPart = "영업";
						} else if($item['user_part'] == "002") {
							$strPart = "기술";
						} else if($item['user_part'] == "003") {
							$strPart = "고객사";
						} else {
							$strPart = "관리자";
						}

						if($item['confirm_flag'] == "Y") {
							$strConfirm = "승인";
						} else if($item['confirm_flag'] == "N") {
							$strConfirm = "미승인";
						}
			?>
                <tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'" style="cursor:pointer" onclick="ViewBoard('<?php echo $item['seq'];?>')">
                    <td height="40" align="center"><?php echo $i;?></td>
                    <!-- <td  align="center" class="t_border"><?php echo $strPart;?></td> -->
                    <td align="center" class="t_border"><?php echo $item['company_name'];?></td>
                    <td align="center" class="t_border"><?php echo $item['user_group'];?></td>
                    <td align="center" class="t_border"><?php echo $item['user_id'];?></td>
                    <td align="center" class="t_border"><?php echo $item['company_num'];?></td>
                    <td align="center" class="t_border"><?php echo $item['user_name'];?></td>
                    <td align="center" class="t_border"><?php echo $item['user_duty'];?></td>
                    <td align="center" class="t_border"><?php echo $item['user_email'];?></td>
                    <td align="center" class="t_border"><?php echo $item['user_tel'];?></td>
                    <td align="center" class="t_border"><?php echo $strConfirm;?></td>
                  </tr>
                  <tr>
                    <td colspan="11" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
             <?php
						$i--;
						$icounter++;
					}
				} else {
			?>
				<tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'">
                    <td width="100%" height="40" align="center" colspan="11">등록된 게시물이 없습니다.</td>
                  </tr>
                  <tr>
                    <td colspan="11" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
			<?php
				}	
			?>   
                  <tr>
                    <td colspan="11" height="2" bgcolor="#797c88"></td>
                  </tr>
                </table></td>
              </tr>
              <!--//리스트-->
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
	document.mform.action = "<?php echo site_url();?>/account/user_view";
	document.mform.seq.value = seq;
	document.mform.mode.value = "modify";

	document.mform.submit();
}
</script>
		<?php if($at == "777") {?>
              <tr>
                <td height="10"></td>
              </tr>
              <!--버튼-->
              <tr>
                <td align="right"><a href="<?php echo site_url();?>/account/user_input" title="작성"><img src="<?php echo $misc;?>img/btn_add2.jpg" width="64" height="31" /></a></td>
              </tr>
              <!--//버튼-->
		<?php }?>
			  <tr>
                <td height="10"></td>
              </tr>
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
              <!--//페이징-->           

              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table>
            <!--//내용-->
            
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
  <!--//하단-->
</form>
</table>

</body>
</html>