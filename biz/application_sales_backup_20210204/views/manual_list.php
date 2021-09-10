<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<script language="javascript">
function GoSearch(){
	var searchkeyword = document.mform.searchkeyword.value;
	var searchkeyword = searchkeyword.trim();
	
//	if(searchkeyword == ""){
//		alert( "검색어를 입력해 주세요." );
//		return false;
//	}

	document.mform.action = "<?php echo site_url();?>/board/manual_list";
	document.mform.cur_page.value = "";
//	document.mform.search_keyword.value = searchkeyword;
	document.mform.submit();
}

$(document).ready(function() {
   $('li > ul').show();
});
</script>
<body>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
<form name="mform" action="<?php echo site_url();?>/board/manual_list" method="get" onKeyDown="if(event.keyCode==13) return GoSearch();">
<input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
<input type="hidden" name="seq" value="">
<input type="hidden" name="mode" value="">
<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
  <tr>
    <td align="center" valign="top">
    <table width="1130" height="100%" cellspacing="0" cellpadding="0" >
        <tr>
            <td width="923" align="center" valign="top">
            <table width="1100" border="0" style="margin-top:50px; margin-bottom: 50px;">
              <tr>
                <td class="title3">영업자료</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><table width="48%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td>
                    <select name="search1" id="search1" class="input">
                      <option value="000">제조사별</option>
                     <?php
					foreach ($category  as $val) {
						echo '<option value="'.$val['code'].'"';
						if( $search1 && ( $val['code'] == $search1 ) ) {
							echo ' selected';
						}
						
						echo '>'.$val['code_name'].'</option>';
					}
					?>
                    </select>
                    </td>
                    <td>
                    <select name="search2" id="search2" class="input">
                    <option value="001" <?php if($search2 == "001"){ echo "selected";}?>>제목</option>
                    <option value="002" <?php if($search2 == "002"){ echo "selected";}?>>등록자</option>
                	</select>
                    </td>
                    <td><table width="95%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td><input  type="text" size="25" class="input" name="searchkeyword" placeholder="검색하세요." value="<?php echo str_replace('"', '&uml;', $search_keyword );?>"/></td>
                        <td><input type="image" style='cursor:hand' onClick="return GoSearch();" src="<?php echo $misc;?>img/btn_search.jpg" align="middle" border="0" />
                        </td>
                      </tr>
                    </table></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td colspan="5" height="2" bgcolor="#797c88"></td>
                  </tr>
                  <tr bgcolor="f8f8f9" class="t_top">
                    <td width="10%" height="40" align="center">No.</td>
                    <td width="60%" align="center" class="t_border">제목</td>
                    <td width="10%" align="center" class="t_border">등록자</td>
                    <td width="10%" align="center" class="t_border">날짜</td>
                    <td width="10%" align="center" class="t_border">첨부</td>
                  </tr>
                  <tr>
                    <td colspan="5" height="1" bgcolor="#797c88"></td>
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
                  <tr onMouseOver="this.style.backgroundColor='#FAFAFA'" onMouseOut="this.style.backgroundColor='#fff'">
                    <td width="10%" height="40" align="center"><?php echo $i;?></td>
                    <td width="60%" class="t_border" style="padding-left:10px;"><a href="JavaScript:ViewBoard('<?php echo $item['seq'];?>')"><?php echo $this->common->trim_text(stripslashes($item['subject']), 100);?></a></td>
                    <td width="10%" align="center" class="t_border"><?php echo $item['user_name'];?></td>
                    <td width="10%" align="center" class="t_border"><?php echo substr($item['update_date'], 0, 10);?></td>
                    <td width="10%" align="center" class="t_border"><?php echo $strFile;?></td>
                  </tr>
                  <tr>
                    <td colspan="7" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
			<?php
						$i--;
						$icounter++;
					}
				} else {
			?>
				<tr onMouseOver="this.style.backgroundColor='#FAFAFA'" onMouseOut="this.style.backgroundColor='#fff'">
                    <td width="100%" height="40" align="center" colspan="5">등록된 게시물이 없습니다.</td>
                  </tr>
                  <tr>
                    <td colspan="7" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
			<?php
				}	
			?>
                  <tr>
                    <td colspan="5" height="2" bgcolor="#797c88"></td>
                  </tr>
                </table></td>
              </tr>
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
	document.mform.action = "<?php echo site_url();?>/board/manual_view";
	document.mform.seq.value = seq;
	document.mform.mode.value = "view";

	document.mform.submit();
}
</script>
             <!---------------------------------- 글쓰기 버튼넣기------------------------------>
			 <?php if($lv == 3) {?>
              <tr>
                <td height="10"></td>
              </tr>
              <tr>
                <td align="right"><a href="<?php echo site_url();?>/board/manual_input"><img src="<?php echo $misc;?>img/btn_write.jpg" width="64" height="31" /></td>
              </tr>
			  <?php }?>
              <tr>
                <td height="10"></td>
              </tr>
               <!---------------------------------- 글쓰기 버튼넣기------------------------------>
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
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table>
            
            
            </td>
        </tr>
     </table>
    
    </td>
  </tr>
  <tr>
  	<td align="center" height="100" bgcolor="#CCCCCC"><table width="1130" cellspacing="0" cellpadding="0" >      
      <tr>
        <td width="197" height="100" align="center" background="<?php echo $misc;?>img/customer_f_bg.png"><img src="<?php echo $misc;?>img/f_ci.png"/></td>
        <td><?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?></td>
      </tr>
    </table></td>
  </tr>
</form>
</table>
</body>
</html>
 
