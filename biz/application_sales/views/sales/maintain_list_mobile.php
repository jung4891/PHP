<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";

	if($search_keyword != ''){
		$filter = explode(',',str_replace('"', '&uml;',$search_keyword));
	}
	if(isset($_GET['search_mode'])) {
		$search_mode = $_GET['search_mode'];
	} else {
		$search_mode = 'simple';
	}
?>
<body>
	<?php
	  include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	  ?>
	<meta name="viewport" content="width=device-width,height=device-width, initial-scale=1.0">
	<style>
	.menu_div {
		margin-top:10px;
		padding: 10px;
		border-bottom: thin #EFEFEF solid;
		overflow-x: scroll;
		white-space:nowrap;
	}
	.menu_div::-webkit-scrollbar {
		display: none;
	}
	.menu_list {
		cursor:pointer;margin:10px;font-weight:bold;font-size:15px;
	}
	.content_list {
		width:100%;
	 display: inline-block;
	 padding-bottom:20px;
	}
	.approval_list_tbl {
		padding-top: 20px;
		padding-left: 15px;
		padding-right:15px;
		border-spacing: 0 10px;
		table-layout: fixed;
	}
	.approval_list_tbl td {
		overflow:hidden;
		white-space : nowrap;
		text-overflow: ellipsis;
	}
	#paging_tbl {
		margin-top:10px;
		width:100%;
	}
	#paging_tbl a {
		font-size: 18px;
	}
	.input-common, .select-common, .btn-common {
		height: 40px !important;
		border-radius: 3px !important;
		box-sizing : border-box !important;
	}
	.dayBtn {
		background:url(<?php echo $misc; ?>img/mobile/footer_schedule.svg) no-repeat 98% 50% #fff;
		background-size: 20px;
	}
	</style>
	<link rel="stylesheet" href="/misc/css/view_page_common.css">
  <script language="javascript">
	function GoSearch(mode){
		if (mode == 'detail') {
			$("#search_mode").val('detail');
			var searchkeyword = '';
			for (i = 1; i <= $(".filtercolumn").length; i++) {
				if (i == 1) {
					searchkeyword += $("#filter" + i).val().trim();
				} else {
					var filter_val = $("#filter" + i).val().trim();
					if(i == 13 || i == 14){
						filter_val = String(filter_val).replace(/,/g, "");
					}
					searchkeyword += ',' + filter_val;
				}

			}
		} else {
			$("#search_mode").val('simple');
			var searchkeyword = '';
			for (i = 1; i <= $(".filtercolumn2").length; i++) {
				if (i == 1) {
					searchkeyword += $("#filter2_" + i).val().trim();
				} else {
					var filter_val = $("#filter2_" + i).val().trim();
					if(i == 7 || i == 8){
						filter_val = String(filter_val).replace(/,/g, "");
					}
					searchkeyword += ',' + filter_val;
				}

			}
		}

	  $("#searchkeyword").val(searchkeyword);

	  if (searchkeyword.replace(/,/g, "") == "") {
	    alert("???????????? ????????????.");
		location.href="<?php echo site_url();?>/sales/maintain/maintain_list?type=<?php echo $type; ?>";
		return false;
	  }

	  document.mform.action = "<?php echo site_url();?>/sales/maintain/maintain_list";
	  document.mform.cur_page.value = "";
	  document.mform.submit();
	}

	function moveList(page){
		if(page == 'maintain_unissued') {
			location.href="<?php echo site_url();?>/sales/maintain/maintain_unissued";
		} else {
			location.href="<?php echo site_url();?>/sales/maintain/maintain_list?type="+page;
		}
  }
  </script>
	<?php
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_side.php";
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_header.php";
  ?>
		<form name="mform" action="<?php echo site_url();?>/sales/maintain/maintain_list" method="get">
			<input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
			<input type="hidden" name="lpp" value="<?php echo $no_page_list; ?>">
			<input type="hidden" name="seq" value="">
			<input type="hidden" name="mode" value="">
			<input type="hidden" name="type" value="<?php echo $type; ?>">
			<input type="hidden" id="searchkeyword" name="searchkeyword" value="<?php echo str_replace('"', '&uml;', $search_keyword );?>"/>
			<input type="hidden" id="search_mode" name="search_mode" value="<?php echo $search_mode; ?>">

			<div class="menu_div">
			 <a class="menu_list" onclick ="moveList('001')" style='<?php if($type=='001'){echo "color:#0575E6";}else{echo "color:#B0B0B0";} ?>'>????????????</a>
			 <a class="menu_list" onclick ="moveList('002')" style='<?php if($type=='002'){echo "color:#0575E6";}else{echo "color:#B0B0B0";} ?>'>??????????????????</a>
			 <a class="menu_list" onclick ="moveList('maintain_unissued')" style='color:#B0B0B0'>????????? ????????? ??????</a>
			</div>

	<div class="content_list">
		<table class="approval_list_tbl" width="100%" border="0" cellspacing="0" cellpadding="0">
			<colgroup>
				<col width="85%">
				<col width="15%">
			</colgroup>
			<tbody>
<?php foreach ($list_val as $item) {
				if($item['manage_team']=="1"){
					$strstep ="??????1???";
				}else if($item['manage_team']=="2"){
					$strstep ="??????2???";
				}else if($item['manage_team']=="3"){
					$strstep ="??????3???";
				}else{
					$strstep ="??????";
				}
				if($cnum == $item['company_num'] || $sales_lv >= 1) {	?>
				<tr onclick="ViewBoard('<?php echo $item['seq'];?>')">
				<?php } else { ?>
				<tr>
				<?php } ?>
					<td align="left" style="color:#A1A1A1;"><?php echo $item['customer_companyname']; ?></td>
					<td align="right" style="color:#A1A1A1;"><?php echo $strstep;?></td>
				</tr>
	<?php	if($cnum == $item['company_num'] || $sales_lv >= 1) {	?>
				<tr onclick="ViewBoard('<?php echo $item['seq'];?>')">
				<?php } else { ?>
				<tr>
				<?php } ?>
					<td align="left" style="color:#1C1C1C;font-weight:bold;"><?php echo $item['project_name'];?></td>
					<td align="right" style="color:#1C1C1C;font-weight:bold;">
						<?php
							switch($item['maintain_result']){
								case 0:
									echo "?????????";
									break;
								case 1:
									echo "??????";
									break;
								case 2:
									echo "?????????";
									break;
								case 9:
									echo "??????";
									break;
								default:
									echo "?????????";
									break;
							}
							?>
					</td>
				</tr>
				<tr><td height="1" colspan="2" bgcolor="#EFEFEF"></td></tr>
<?php } ?>
<?php if($count == 0) { ?>
				<tr>
					<td colspan="2" align="center" height="40" style="font-weight:bold;">????????? ???????????? ????????????.</td>
				</tr>
<?php } ?>
			</tbody>
		</table>
		<?php
			$total_sales = 0;
			$total_purchase = 0;
			$total_profit = 0;
			foreach ($amount_list_val as $alv) {
				$total_sales = $total_sales + (int)$alv['forcasting_sales'];
				$total_purchase = $total_purchase + (int)$alv['forcasting_purchase'];
				$total_profit = $total_profit + (int)$alv['forcasting_profit'];
			}
		?>
		<table class="approval_list_tbl" style="padding-top:0px;background-color:#F9F9F9;" width="100%" border="0" cellspacing="0" cellpadding="0">
			<colgroup>
				<col width="40%">
				<col width="60%">
			</colgroup>
			<tr>
				<td style="padding-left:10px;">????????????</td>
				<td align="right" style="padding-right:10px;font-weight:bold;">
					<span style="color:#E53737"><?php echo number_format($total_sales); ?></span>???
				</td>
			</tr>
			<tr>
				<td style="padding-left:10px;">????????????</td>
				<td align="right" style="padding-right:10px;font-weight:bold;">
					<span style="color:#007BCB"><?php echo number_format($total_purchase); ?></span>???
				</td>
			</tr>
			<tr>
				<td style="padding-left:10px;">????????????</td>
				<td align="right" style="padding-right:10px;font-weight:bold;">
					<span style="color:#1C1C1C"><?php echo number_format($total_profit); ?></span>???
				</td>
			</tr>
		</table>

		<!-- ????????? -->
		<table id="paging_tbl" cellspacing="0" cellpadding="0">
		  <!-- ??????????????? -->
		  <tr>
		     <td align="center">
		     <?php if ($count > 0) {?>
		           <table border="0" cellspacing="0" cellpadding="0">
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
		  <!-- ?????????????????? -->
		</table>
	</div>

	<!-- ?????? ?????? ?????? -->
  <div id="search_div" style="height:auto;width:100%;background-color:#ffffff; display:none;border-radius:5px;">
    <div class="modal_contain" style="font-size:16px; color:#1C1C1C;font-weight:bold;">
      <table style="width:100%;padding:5%;" cellspacing="0">
				<colgroup>
					<col width="50%">
					<col width="50%">
				</colgroup>
				<tr>
      		<td align="left" colspan="2" height="40">?????????</td>
      	</tr>
				<tr>
					<td colspan="2">
						<select id="filter2_1" class="select-common select-style1 filtercolumn2" style="width:100%;">
							<option value="" >????????? ??????</option>
							<option value="1" <?php if(isset($filter)&&$search_mode=='simple' && $filter[0] == '1'){echo "selected";} ?> >??????1???</option>
							<option value="2" <?php if(isset($filter)&&$search_mode=='simple' && $filter[0] == '2'){echo "selected";} ?> >??????2???</option>
							<option value="3" <?php if(isset($filter)&&$search_mode=='simple' && $filter[0] == '3'){echo "selected";} ?> >??????3???</option>
						</select>
					</td>
				</tr>
				<tr>
      		<td align="left" colspan="2" height="40">????????????</td>
      	</tr>
				<tr>
					<td colspan="2">
						<select id="filter2_2" class="select-common select-style1 filtercolumn2" style="width:100%;">
							<option value="" >???????????? ??????</option>
							<option value="1" <?php if(isset($filter)&&$search_mode=='simple' && $filter[1] == '1'){echo "selected";} ?> >????????????</option>
							<option value="0" <?php if(isset($filter)&&$search_mode=='simple' && $filter[1] == '0'){echo "selected";} ?> >???????????????</option>
							<option value="2" <?php if(isset($filter)&&$search_mode=='simple' && $filter[1] == '2'){echo "selected";} ?> >???????????????</option>
							<option value="9" <?php if(isset($filter)&&$search_mode=='simple' && $filter[1] == '9'){echo "selected";} ?> >??????</option>
							<option value="3" <?php if(isset($filter)&&$search_mode=='simple' && $filter[1] == '3'){echo "selected";} ?> >??????</option>
							<option value="4" <?php if(isset($filter)&&$search_mode=='simple' && $filter[1] == '4'){echo "selected";} ?> >????????? ??????</option>
						</select>
					</td>
				</tr>
				<tr>
      		<td align="left" colspan="2" height="40">???????????????</td>
      	</tr>
				<tr>
					<td colspan="2">
						<select id="filter2_3" class="select-common select-style1 filtercolumn2" style="width:100%;">
							<option value="">????????? ???????????? ??????</option>
							<option value="0" <?php if(isset($filter)&&$search_mode=='simple' && $filter[2] == '0'){echo "selected";} ?>>?????????</option>
							<option value="1" <?php if(isset($filter)&&$search_mode=='simple' && $filter[2] == '1'){echo "selected";} ?>>?????????</option>
							<option value="100" <?php if(isset($filter)&&$search_mode=='simple' && $filter[2] == '100'){echo "selected";} ?>>????????????</option>
						</select>
					</td>
				</tr>
				<tr>
      		<td align="left" colspan="2" height="40">?????????????????????</td>
      	</tr>
				<tr>
					<td colspan="2">
						<select id="filter2_4" class="select-common select-style1 filtercolumn2" style="width:100%;">
							<option value="">???????????? ??????</option>
							<option value="Y" <?php if(isset($filter)&&$search_mode=='simple' && $filter[3] == 'Y'){echo "selected";} ?>>??????</option>
							<option value="N" <?php if(isset($filter)&&$search_mode=='simple' && $filter[3] == 'N'){echo "selected";} ?>>?????????</option>
						</select>
					</td>
				</tr>
				<tr>
      		<td align="left" colspan="2" height="40">???????????? ????????? / ?????????</td>
      	</tr>
				<tr>
					<td>
						<input type="date" id="filter2_5" class="input-common filtercolumn2 dayBtn" value='<?php if(isset($filter)&&$search_mode=='simple'){echo $filter[4];} ?>' style="width:100%;"/>
					</td>
					<td>
						<input type="date" id="filter2_6" class="input-common filtercolumn2 dayBtn" value='<?php if(isset($filter)&&$search_mode=='simple'){echo $filter[5];} ?>' style="width:100%;"/>
					</td>
				</tr>
				<tr>
      		<td align="left" colspan="2" height="40">????????????</td>
      	</tr>
				<tr>
					<td>
						<input type="text" id="filter2_7" class="input-common filtercolumn2" style="text-align:right;margin-right:0;width:100%;" onchange="numberFormat(this)" value='<?php if(isset($filter)&&$search_mode=='simple'){if($filter[6]!=""){echo number_format($filter[6]);}} ?>' placeholder="???"/>
					</td>
					<td>
						<input type="text" id="filter2_8" class="input-common filtercolumn2" style="text-align:right;margin-right:0;width:100%;" onchange="numberFormat(this)" value='<?php if(isset($filter)&&$search_mode=='simple'){if($filter[7]!=""){echo number_format($filter[7]);}} ?>' placeholder="???"/>
					</td>
				</tr>
				<tr>
					<td height="20"></td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="text" id="filter2_9" class="input-common filtercolumn2" value="<?php if(isset($filter)&&$search_mode=='simple'){echo $filter[8];} ?>" style="width:100%;" placeholder="???????????????.">
					</td>
				</tr>
				<tr>
          <td height="20"></td>
        </tr>
				<tr>
					<td>
						<input type="button" class="btn-common btn-color1" style="width:95%" value="??????" onclick="$('#search_div').bPopup().close();">
					</td>
					<td align="right">
						<input type="button" class="btn-common btn-color2" style="width:95%" value="??????" onclick="return GoSearch('simple');">
					</td>
				</tr>
      </table>
    </div>
  </div>
	<!-- ?????? ?????? ??? -->
</form>
	<div style="width:90%;margin:0 auto;margin-bottom:10px;">
    <?php if($tech_lv == 3) { ?>
			<!-- <a href="<?php echo site_url();?>/tech/board/manual_input"> -->
				<!-- <input style="width:100%" type="button" class="btn-common btn-color2" value="?????????"> -->
			<!-- </a> -->
    <?php } ?>
	</div>
	<div style="width:90%;padding-left:10px;padding-bottom:60px;">
		<span style="color:red;margin-right:5px;">*</span><?php echo $title; ?> ?????? ??? ?????? ????????? ?????? ???????????? ???????????????.
	</div>
	<?php include $this->input->server('DOCUMENT_ROOT')."/include/mobile_bottom.php"; ?>
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
		document.mform.action = "<?php echo site_url();?>/sales/maintain/maintain_view";
		document.mform.seq.value = seq;
		document.mform.mode.value = "modify";

		document.mform.submit();
	}

  function open_search() {
  	$('#search_div').bPopup();
  }
  $(window).bind("pageshow", function(event) {
    if (event.originalEvent.persisted) {
        document.location.reload();
    }
  });

	//?????? ????????? ?????? ,
	function numberFormat(obj) {
		// if (obj.value == "") {
		// 	obj.value = 0;
		// }
		var inputText = obj.value.replace(/[^-?0-9]/gi,"") // ????????? - ??????
		var inputNumber = inputText.replace(/,/g, "");
		var fomatnputNumber = inputNumber.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, "$1,");
		obj.value = fomatnputNumber;
	}
  </script>
</body>
