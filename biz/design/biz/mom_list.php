<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<link rel="stylesheet" href="/misc/css/view_page_common.css">
<style>
.tabs {position: relative;margin: 35px auto;width: 600px;}
.tabs_input {position: absolute;z-index: 1000;width: 120px;height: 35px;left: 0px;top: 0px;opacity: 0;-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";filter: alpha(opacity=0);}
.tabs_input:not(:checked) {cursor: pointer;}
.tabs_input:not(:checked) + label {color:#fff;}
.tabs_input:not(:checked) + label {background: #f8f8f9;color:#777;}
.tabs_input:hover + label {background: #abe9ff;color:#fff;}
.tabs_input#tab-2{left: 120px;}
.tabs_input#tab-3{left: 240px;}
.tabs_input#tab-4{left: 360px;}
.tabs_input#tab-5{left: 480px;}
.tabs label {background:#41beeb;;color:#fff;font-size: 14px;line-height: 35px;height: 35px;position: relative;padding: 0 20px;float: left;display: block;width: 80px;letter-spacing: 0px;text-align: center;border-radius: 12px 12px 0 0;box-shadow: 2px 0 2px rgba(0,0,0,0.1), -2px 0 2px rgba(0,0,0,0.1);}
.tabs label:after {content: '';background: #fff;position: absolute;bottom: -2px;left: 0;width: 100%;height: 2px;display: block;}
.tabs label:first-of-type {z-index: 4;box-shadow: 1px 0 3px rgba(0,0,0,0.1);}
</style>
<script language="javascript">

function GoSearch(){
	var searchkeyword = document.mform.searchkeyword.value;
	var searchkeyword = searchkeyword.trim();


	document.mform.action = "<?php echo site_url();?>/biz/meeting_minutes/mom_list";
	document.mform.cur_page.value = "";
	document.mform.submit();
}

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


function register_yn(type){
  location.href="<?php echo site_url();?>/biz/meeting_minutes/mom_list?type="+type;
}

function ViewBoard (seq){
	document.mform.action = "<?php echo site_url();?>/biz/meeting_minutes/mom_view";
	document.mform.seq.value = seq;
	document.mform.mode.value = "view";

	document.mform.submit();

}
</script>
<body>
<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
<div align="center">
<div class="dash1-1">
<table width="95%%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
<form name="mform" action="<?php echo site_url();?>/biz/meeting_minutes/mom_list" method="get" onKeyDown="if(event.keyCode==13) return GoSearch();">
<input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
<input type="hidden" name="seq" value="">
<input type="hidden" name="mode" value="">
<input type="hidden" name="type" value="<?php echo $type; ?>">
<tbody height="100%">
	<tr height="5%">
		<td class="dash_title">
			<span onclick="register_yn('y')" style='cursor:pointer;margin-right:10px;color:<?php if($type == "y"){echo "#1C1C1C";}else{echo "#DEDEDE;font-weight:normal;";}?>'>?????????</span>
			<span onclick="register_yn('n')" style='cursor:pointer;margin-right:10px;color:<?php if($type == "n"){echo "#1C1C1C";}else{echo "#DEDEDE;font-weight:normal;";}?>'>???????????????</span>
		</td>
	</tr>
	<!-- ????????? -->
	<tr>
		<td align="left" valign="bottom">
		<!-- <td width="100%" style="align:left; float:left"> -->
			<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:70px;">
				<tr>
					<td>
						<select name="search1" id="search1" class="select-common select-style1">
							<option value="001" <?php if($search1 == "001"){ echo "selected";}?>>??????</option>
							<option value="002" <?php if($search1 == "002"){ echo "selected";}?>>??????</option>
						</select>
					<input  type="text" size="25" class="input-common" name="searchkeyword" placeholder="???????????????." value="<?php echo str_replace('"', '&uml;', $search_keyword );?>"/>
						<input type="button" class="btn-common btn-color2" value="?????????" onClick="location.href='<?php echo site_url();?>/biz/meeting_minutes/mom_input'" style="float:right;">
					</td>
				</tr>
			</table>
		</td>
	</tr>

<!-- ????????? ?????? -->
<tr height="45%">
<td colspan="2" valign="top" style="padding:10px 0px;">
	<table class="content_dash_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center" valign="top">
              <tr>
                <td><table class="list_tbl" width="100%" border="0" cellspacing="0" cellpadding="0">
									<colgroup>
	                  <col width="10%">
	                  <col width="4%">
	                  <col width="4%">
	                  <col width="9%">
	                  <col width="9%">
	                  <col width="30%">
	                  <col width="9%">
                    <col width="9%">
                    <col width="6%">
                    <col width="10%">
	                </colgroup>
                  <tr class="t_top row-color1">
										<th></th>
                    <th height="40" align="center">No.</th>
                    <th align="center">??????</th>
                    <th align="center">??????</th>
                    <th align="center">??????</th>
                    <th align="center">??????</th>
                    <th align="center">?????????</th>
                    <th align="center">?????????</th>
                    <th align="center">????????????</th>
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
                  <tr onMouseOver="this.style.backgroundColor='#FAFAFA'" onMouseOut="this.style.backgroundColor='#fff'" style="cursor:pointer" onclick="ViewBoard('<?php echo $item['seq'];?>')">
										<td></td>
                    <td height="40" align="center"><?php echo $i;?></a></td>
                    <td style="padding-left:10px;" align="center"><?php echo $item['user_group'];?></td>
                    <td align="center"><?php echo $item['day']." ". substr($item['start_time'],0,-3);?></td>
                    <td align="center"><?php echo $item['place'];?></td>
                    <td align="center"><?php echo $item['title'];?></td>
                    <td align="center"><?php echo $item['user_name'];?></td>
                    <td align="center"><?php echo substr($item['add_date'],0 ,-3);?></td>
										<td align="center"><?php echo $strFile;?></td>
										<td></td>
                  </tr>
			<?php
						$i--;
						$icounter++;
					}
				} else {
			?>
				<tr onMouseOver="this.style.backgroundColor='#FAFAFA'" onMouseOut="this.style.backgroundColor='#fff'">
                    <td width="100%" height="40" align="center" colspan="10">????????? ???????????? ????????????.</td>
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
		<!-- ????????? ??? -->

		<!-- ??????????????? -->
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
						<!-- ????????? ??? -->

					</td>
				</tr>
			</table>
		</td>
		</tr>
		<!-- ???????????? -->
	</tbody>
</form>
</table>
</div>
</div>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
</body>
</html>
