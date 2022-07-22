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

	document.mform.action = "<?php echo site_url();?>/customer/sourcing_list";
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
<form name="mform" action="<?php echo site_url();?>/customer/sourcing_list" method="get" onkeydown="if(event.keyCode==13) return GoSearch();">
<input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
<input type="hidden" name="seq" value="">
<input type="hidden" name="mode" value="">
<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/admin_header.php";
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
                <td class="title3">Sourcing Group</td>
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
                    <option value="001" <?php if($search2 == "001"){ echo "selected";}?>>Solution Group</option>
                    <option value="002" <?php if($search2 == "002"){ echo "selected";}?>>제조사</option>
					<option value="003" <?php if($search2 == "003"){ echo "selected";}?>>자격</option>
					<option value="004" <?php if($search2 == "004"){ echo "selected";}?>>엔지니어수</option>
					<option value="005" <?php if($search2 == "005"){ echo "selected";}?>>거래실적(건)</option>
					<option value="006" <?php if($search2 == "006"){ echo "selected";}?>>관리</option>
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
                    <col width="10%" />
                    <col width="15%" />
                    <col width="10%" />
                    <col width="10%" />
                    <col width="10%" />
                    <col width="15%" />
                    <col width="15%" />
                    <col width="10%" />
                  </colgroup>
                  <tr>
                    <td colspan="9" height="2" bgcolor="#797c88"></td>
                  </tr>
                  <tr bgcolor="f8f8f9" class="t_top">
                    <td height="40" align="center">번호</td>
                    <td align="center" class="t_border">구분</td>
                    <td align="center" class="t_border">Solution Group</td>
                    <td align="center" class="t_border">제조사</td>
					<td align="center" class="t_border">자격</td>
                    <td align="center" class="t_border">엔지어수</td>
                    <td align="center" class="t_border">거래실적</td>
                    <td align="center" class="t_border">증빙서류</td>
                    <td align="center" class="t_border">관리</td>
                  </tr>

                  <tr>
                    <td colspan="9" height="1" bgcolor="#797c88"></td>
                  </tr>
			<?php
				if ($count > 0) {
					$i = $count - $no_page_list * ( $cur_page - 1 );
					$icounter = 0;
					
					foreach ( $list_val as $item ) {
						if($item['part'] == "001") {
							$strPart = "SW";
						} else if($item['part'] == "002") {
							$strPart = "HW";
						} if($item['part'] == "003") {
							$strPart = "기타";
						}
						
						if($item['file_changename']) {
							$strFile = "<img src='".$misc."img/add.png' width='20' height='20' />";
						} else {
							$strFile = "-";
						}

//						foreach ($category  as $val) {
//							if( $item['product_company'] && ( $val['code'] == $item['product_company'] ) ) {
//								$strCompany = $val['code_name'];
//							}
//						}
			?>
                 <tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'" style="cursor:pointer" onclick="ViewBoard('<?php echo $item['seq'];?>')">
                    <td height="40" align="center"><?php echo $i;?></td>
                    <td align="center" class="t_border"><?php echo $strPart;?></td>
                    <td align="center" class="t_border"><?php echo $item['solution_group'];?></td>
                    <td align="center" class="t_border"><?php echo $item['product_company'];?></td>
                    <td align="center" class="t_border"><?php echo $item['product_capacity'];?></td>
                    <td align="center" class="t_border"><?php echo $item['ecount'];?></td>
                    <td align="center" class="t_border"><?php echo $item['dcount'];?></td>
                    <td align="center" class="t_border"><?php echo $strFile;?></td>
                    <td align="center" class="t_border"><?php echo $item['manage'];?></td>
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
                  <tr>
                    <td colspan="10" height="2" bgcolor="#797c88"></td>
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
	document.mform.action = "<?php echo site_url();?>/customer/sourcing_view";
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
                <td align="right"><a href="<?php echo site_url();?>/customer/sourcing_input" title="작성"><img src="<?php echo $misc;?>img/btn_add2.jpg" width="64" height="31" /></a></td>
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