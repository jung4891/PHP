<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<body>
<?php
  include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
<form name="mform" action="<?php echo site_url();?>/admin/company/companynum_list" method="get" onkeydown="if(event.keyCode==13) return GoSearch();">
<input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
<input type="hidden" name="seq" value="">
<input type="hidden" name="mode" value="">
  <tr>
    <td align="center" valign="top">
    <table width="1130" height="100%" cellspacing="0" cellpadding="0" >
        <tr>
            <td width="923" align="center" valign="top">
            <!--내용-->
            <table width="1100" border="0" style="margin-top:50px; margin-bottom: 50px;">
              <!--타이틀-->
              <tr>
                <td class="title3">사업자등록번호</td>
              </tr>
              <!--//타이틀-->
              <tr>
                <td>&nbsp;</td>
              </tr>
             <!--리스트-->
              <tr>
                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <colgroup>
				    <col width="20%" />
                    <col width="20%" />
                    <col width="40%" />
                    <col width="20%" />
                  </colgroup>
                  <tr>
                    <td colspan="4" height="2" bgcolor="#797c88"></td>
                  </tr>
                  <tr bgcolor="f8f8f9" class="t_top">
				    <td height="40" align="center">번호</td>
                    <td height="40" align="center" class="t_border">회사명</td>
                    <td align="center" class="t_border">사업자등록번호</td>
                    <td align="center" class="t_border">등록일</td>
                  </tr>
                  <tr>
                    <td colspan="4" height="1" bgcolor="#797c88"></td>
                  </tr>
			<?php
				if ($count > 0) {
					$i = $count - $no_page_list * ( $cur_page - 1 );
					$icounter = 0;
					
					foreach ( $list_val as $item ) {
			?>
                  <tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'" style="cursor:pointer" onclick="ViewBoard('<?php echo $item['seq'];?>')">
                    <td height="40" align="center"><?php echo $i;?></td>
                    <td align="center" class="t_border"><?php echo $item['company_name'];?></td>
                    <td align="center" class="t_border"><?php echo substr($item['company_num'], 0, 3)."-".substr($item['company_num'], 3, 2)."-".substr($item['company_num'], 5, 5);?></td>
					<td align="center" class="t_border"><?php echo substr($item['insert_date'], 0, 10);?></td>
                  </tr>
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
                  </tr>
             <?php
						$i--;
						$icounter++;
					}
				} else {
			?>
				<tr onmouseover="this.style.backgroundColor='#FAFAFA'" onmouseout="this.style.backgroundColor='#fff'">
                    <td width="100%" height="40" align="center" colspan="4">등록된 게시물이 없습니다.</td>
                  </tr>
                  <tr>
                    <td colspan="4" height="1" bgcolor="#e8e8e8"></td>
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
	document.mform.action = "<?php echo site_url();?>/admin/company/companynum_view";
	document.mform.seq.value = seq;
	document.mform.mode.value = "modify";

	document.mform.submit();
}
</script>
		<?php if($admin_lv == "3") {?>
              <tr>
                <td height="10"></td>
              </tr>
              <!--버튼-->
              <tr>
                <td align="right"><a href="<?php echo site_url();?>/admin/company/companynum_input" title="작성"><img src="<?php echo $misc;?>img/btn_make.jpg" width="64" height="31" /></a></td>
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
</form>
</table>
<!--하단-->
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
<!--//하단-->
</body>
</html>