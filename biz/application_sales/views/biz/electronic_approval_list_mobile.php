<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
	if($search_keyword != ''){
	$filter = explode(',',str_replace('"', '&uml;',$search_keyword));
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
	<?php if($type != 'admin'){ ?>
	.read_n td {
		font-weight:bold;
	}
	.admin_tr {
		display:none;
	}
	<?php } ?>
	.input-common, .select-common, .btn-common {
		height: 35px !important;
		border-radius: 3px !important;
	}
	.dayBtn {
		background:url(<?php echo $misc; ?>img/mobile/footer_schedule.svg) no-repeat 98% 50% #fff;
		background-size: 20px;
	}
	</style>
	<link rel="stylesheet" href="/misc/css/view_page_common.css">
	<?php
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_side.php";
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_header.php";
	  ?>
	<form name="cform" action="<?php echo site_url(); ?>/biz/approval/electronic_approval_list" method="get" onkeydown="if(event.keyCode==13) return GoSearch();">
	   <input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
	   <input type="hidden" name="lpp" value="<?php echo $no_page_list; ?>">
	   <input type="hidden" name="type" value="<?php echo $type; ?>">
	   <input type="hidden" name="searchkeyword" id="searchkeyword" value="<?php echo str_replace('"', '&uml;',$search_keyword); ?>" />
	</form>
	<div class="menu_div">
<?php if($type != "admin"){
				if($no_read_cnt_s[0]['cnt'] > 5){
					$no_read_cnt_s[0]['cnt'] = '5over';
				}
				if($no_read_cnt_p[0]['cnt'] > 5){
					$no_read_cnt_p[0]['cnt'] = '5over';
				}
				if($no_read_cnt_c[0]['cnt'] > 5){
					$no_read_cnt_c[0]['cnt'] = '5over';
				}
				if($no_read_cnt_b[0]['cnt'] > 5){
					$no_read_cnt_b[0]['cnt'] = '5over';
				}
				if($no_read_cnt_r[0]['cnt'] > 5){
					$no_read_cnt_r[0]['cnt'] = '5over';
				} ?>
		<a class="menu_list" onclick ="moveList('standby')" style='color:<?php if($type == "standby"){echo "#0575E6";}else{echo "#B0B0B0";}?>'>???????????????</a>
		<a class="menu_list" onclick ="moveList('progress')" style='color:<?php if($type == "progress"){echo "#0575E6";}else{echo "#B0B0B0";}?>'>???????????????</a>
		<a class="menu_list" onclick ="moveList('completion')" style='color:<?php if($type == "completion"){echo "#0575E6";}else{echo "#B0B0B0";}?>'>???????????????</a>
		<a class="menu_list" onclick ="moveList('back')" style='color:<?php if($type == "back"){echo "#0575E6";}else{echo "#B0B0B0";}?>'>???????????????</a>
		<a class="menu_list" onclick ="moveList('reference')" style='color:<?php if($type == "reference"){echo "#0575E6";}else{echo "#B0B0B0";}?>'>??????/???????????????</a>
<?php }else if ($type == 'admin'){ ?>
		<a class="menu_list" style='color:#0575E6'>??????????????????</a>
		<!-- <a class="menu_list" onclick ="movePage('electronic_approval_form_list?mode=admin')" style='color:#B0B0B0'>????????????</a> -->
		<a class="menu_list" onclick ="movePage('electronic_approval_format_category')" style='color:#B0B0B0'>???????????????</a>
		<!-- <a class="menu_list" onclick ="movePage('electronic_approver_line_list')" style='color:#B0B0B0'>???????????????</a> -->
<?php } ?>
	</div>

	<div class="content_list">
		<table class="approval_list_tbl" width="100%" border="0" cellspacing="0" cellpadding="0">
			<colgroup>
				<col width="85%">
				<col width="15%">
			</colgroup>
			<tbody>
<?php
if(empty($view_val) != true){
	 $idx = $count-$start_row;
	 for($i = $start_row; $i<$start_row+$end_row; $i++){
			if(!empty( $view_val[$i])){
				 $doc = $view_val[$i];
				 $read_yn = '';
				 $read_seq = substr($_GET['type'],0,1).'_'.$user_seq;
				 if(strpos($doc['read_seq'],$read_seq)===false) {
					 $read_yn = 'read_n';
				 } else {
					 $read_yn = 'read_y';
				 }

				 echo "<tr align='center' class='".$read_yn."' onclick='eletronic_approval_view({$doc['seq']},".'"'.$doc['approval_doc_status'].'"'.")'>";
				 echo "<td align='left' style='color:#A1A1A1'>{$doc['template_name']}</td>";
				 echo "<td align='right' style='color:#A1A1A1'>{$doc['writer_name']}</td>";
				 echo "</tr>";
				 echo "<tr align='center' class='".$read_yn."' onclick='eletronic_approval_view({$doc['seq']},".'"'.$doc['approval_doc_status'].'"'.")'>";
				 if($doc['approval_doc_hold'] == "N"){
						echo "<td align='left' style='color:#1C1C1C;font-weight:bold;'>{$doc['approval_doc_name']}</td>";
				 }else{
						echo "<td align='left' style='color:#1C1C1C;font-weight:bold;'>{$doc['approval_doc_name']} (??????)</td>";
				 }
				 echo "<td align='right' style='color:#1C1C1C;font-weight:bold;'>";
				 if($doc['approval_doc_status'] == "001"){
						echo "?????????";
				 }else if($doc['approval_doc_status'] == "002"){
						echo "??????";
				 }else if($doc['approval_doc_status'] == "003"){
						echo "??????";
				 }else if($doc['approval_doc_status'] == "004"){
						echo "??????";
				 }else if($doc['approval_doc_status'] == "005"){
						echo "????????????";
				 }else if($doc['approval_doc_status'] == "006"){
						echo "??????";
				 }else{
						echo "";
				 }
				 echo "</td>";
				 echo "</tr>";
				 echo '<tr><td height="1" colspan="2" bgcolor="#EFEFEF"></td></tr>';
}
}
}else{
echo "<tr><td align='center' colspan='2' height='40'>?????? ????????? ???????????? ????????????.</td></tr>";
}
?>
			</tbody>
		</table>
<?php if(!empty($delegation)){ ?>
		<div class="menu_div">
			<h2 style="margin:10px;">??????</h2>
		</div>
		<table class="approval_list_tbl" width="100%" border="0" cellspacing="0" cellpadding="0">
			<colgroup>
				<col width="85%">
				<col width="15%">
			</colgroup>
			<tbody>
<?php
	 $idx = $count-$start_row;
	 foreach($delegation as $doc){
				 echo "<tr align='center' onclick='eletronic_approval_view({$doc['seq']})'>";
				 echo "<td align='left' style='color:#A1A1A1'>{$doc['template_name']}</td>";
				 echo "<td align='right' style='color:#A1A1A1'>{$doc['writer_name']}</td>";
				 echo "</tr>";
				 echo "<tr align='center' onclick='eletronic_approval_view({$doc['seq']})'>";
				 if($doc['approval_doc_hold'] == "N"){
						echo "<td align='left' style='color:#1C1C1C;font-weight:bold;'>{$doc['approval_doc_name']}(??????)</td>";
				 }else{
						echo "<td align='left' style='color:#1C1C1C;font-weight:bold;'>{$doc['approval_doc_name']} (??????)</td>";
				 }
				 echo "<td align='right' style='color:#1C1C1C;font-weight:bold;'>";
				 if($doc['approval_doc_status'] == "001"){
						echo "?????????";
				 }else if($doc['approval_doc_status'] == "002"){
						echo "??????";
				 }else if($doc['approval_doc_status'] == "003"){
						echo "??????";
				 }else if($doc['approval_doc_status'] == "004"){
						echo "??????";
				 }else if($doc['approval_doc_status'] == "005"){
						echo "????????????";
				 }else if($doc['approval_doc_status'] == "006"){
						echo "??????";
				 }else{
						echo "";
				 }
				 echo "</td>";
				 echo "</tr>";
				 echo '<tr><td height="1" colspan="2" bgcolor="#EFEFEF"></td></tr>';
				 ?>


<?php
}
?>
		</table>
<?php } ?>

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


	<!-- ???????????? ?????? ?????? -->
  <div id="search_div" style="height:auto;width:100%;background-color:#ffffff; display:none;border-radius:5px;">
    <div class="modal_contain" style="font-size:16px; color:#1C1C1C;font-weight:bold;">
      <table style="width:100%;padding:5%;" cellspacing="0">
				<colgroup>
					<col width="50%">
					<col width="50%">
				</colgroup>
				<tr class="admin_tr">
      		<td align="left" colspan="2" height="40">????????????</td>
      	</tr>
				<tr class="admin_tr">
					<td colspan="2">
						<select id="filter1" class="select-common filtercolumn" onkeydown="if(event.keyCode==13) return GoSearch();" style="width:95%;">
							 <option value="" <?php if(isset($filter)){if($filter[0] == ""){echo "selected";}} ?>>??????????????????</option>
							 <option value="001" <?php if(isset($filter)){if($filter[0] == "001"){echo "selected";}} ?>>?????????</option>
							 <option value="002" <?php if(isset($filter)){if($filter[0] == "002"){echo "selected";}} ?>>??????</option>
							 <option value="003" <?php if(isset($filter)){if($filter[0] == "003"){echo "selected";}} ?>>??????</option>
							 <option value="004" <?php if(isset($filter)){if($filter[0] == "004"){echo "selected";}} ?>>??????</option>
							 <option value="006" <?php if(isset($filter)){if($filter[0] == "006"){echo "selected";}} ?>>??????</option>
						</select>
					</td>
				</tr>
				<tr class="admin_tr">
          <td height="10"></td>
        </tr>
      	<tr>
      		<td align="left" colspan="2" height="40">?????????</td>
      	</tr>
        <tr>
          <td colspan="2">
            <input type="text" id="filter2" class="input-common filtercolumn" value='<?php if(isset($filter)){echo $filter[1];} ?>' onkeydown="if(event.keyCode==13) return GoSearch();" style="width:95%;" onchange="keyword_replace(this);" category="template_name"/>
          </td>
        </tr>
        <tr>
          <td height="10"></td>
        </tr>
      	<tr>
      		<td align="left" colspan="2" height="40">?????????</td>
      	</tr>
        <tr>
          <td colspan="2">
            <input type="text" id="filter3" class="input-common filtercolumn" value='<?php if(isset($filter)){echo $filter[2];} ?>' onkeydown="if(event.keyCode==13) return GoSearch();" style=";width:95%;" />
          </td>
        </tr>
				<tr>
          <td height="20"></td>
        </tr>
				<tr>
					<td align="left" height="40">
						<select class="select-common filtercolumn" id="filter4" style="margin-right:10px;color:black;width:92%;">
							<option value="write_date" <?php if(isset($filter)){if($filter[3] == "write_date"){echo "selected";}} ?>>?????????</option>
							<option value="completion_date" <?php if(isset($filter)){if($filter[3] == "completion_date"){echo "selected";}} ?>>?????????</option>
						</select>
					</td>
					<td></td>
				</tr>
				<tr>
					<td>
						<input type="date" id="filter5" class="input-common filtercolumn dayBtn" value='<?php if(isset($filter)){echo $filter[4];} ?>' onkeydown="if(event.keyCode==13) return GoSearch();" style="width:90%;" />
					</td>
					<td align="right">
						<input type="date" id="filter6" class="input-common filtercolumn dayBtn" value='<?php if(isset($filter)){echo $filter[5];} ?>' onkeydown="if(event.keyCode==13) return GoSearch();" style="width:90%;" />
					</td>
				</tr>
				<tr>
          <td height="20"></td>
        </tr>
				<tr>
					<td align="left" height="40">
						<select class="select-common filtercolumn" id="filter7" style="margin-right:10px;color:black;width:92%">
							<option value="approval_doc_name" <?php if(isset($filter)){if($filter[6] == "approval_doc_name"){echo "selected";}} ?>>????????????</option>
							<option value="contents_html" <?php if(isset($filter)){if($filter[6] == "contents_html"){echo "selected";}} ?>>????????????</option>
						</select>
					</td>
					<td></td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="text" id="filter8" class="input-common filtercolumn" value='<?php if(isset($filter)){echo $filter[7];} ?>' onkeydown="if(event.keyCode==13) return GoSearch();" style="width:95%;" />
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
						<input type="button" class="btn-common btn-color2" style="width:95%" value="??????" onclick="return GoSearch();">
					</td>
				</tr>
      </table>
    </div>
  </div>
	<!-- ???????????? ?????? ??? -->

	<div style="padding-left:10px;padding-bottom:60px;">
		<span style="color:red;margin-right:5px;">*</span>???????????? ?????? ??? ?????? ????????? ?????? ???????????? ???????????????.
	</div>
	<?php include $this->input->server('DOCUMENT_ROOT')."/include/mobile_bottom.php"; ?>

</body>
<script>
   function eletronic_approval_view(seq,status){
      if("<?php echo $type ;?>" == "admin"){
         location.href="<?php echo site_url(); ?>/biz/approval/electronic_approval_doc_view?seq="+seq+"&type=<?php echo $type; ?>&type2="+status;
      }else{
         location.href="<?php echo site_url(); ?>/biz/approval/electronic_approval_doc_view?seq="+seq+"&type=<?php echo $type; ?>";
      }
   }

   function GoFirstPage (){
      document.cform.cur_page.value = 1;
      document.cform.submit();
   }

   function GoPrevPage (){
      var	cur_start_page = <?php echo $cur_page;?>;

      document.cform.cur_page.value = Math.floor( ( cur_start_page - 11 ) / 10 ) * 10 + 1;
      document.cform.submit( );
   }

   function GoPage(nPage){
      document.cform.cur_page.value = nPage;
      document.cform.submit();
   }

   function GoNextPage (){
      var	cur_start_page = <?php echo $cur_page;?>;

      document.cform.cur_page.value = Math.floor( ( cur_start_page + 9 ) / 10 ) * 10 + 1;
      document.cform.submit();
   }

   function GoLastPage (){
      var	total_page = <?php echo $total_page;?>;
      document.cform.cur_page.value = total_page;
      document.cform.submit();
   }

   function moveList(type){
      location.href="<?php echo site_url();?>/biz/approval/electronic_approval_list?type="+type;
   }

	 function movePage(page) {
		 location.href = "<?php echo site_url(); ?>/biz/approval/" + page;
	 }

   //?????????!
   function GoSearch(){
      var searchkeyword = '';
      for ( i = 1; i <= $(".filtercolumn").length; i++) {
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
      $("#searchkeyword").val(searchkeyword);

      if (searchkeyword.replace(/,/g, "") == "") {
         alert("???????????? ????????????.");
         location.href="<?php echo site_url();?>/biz/approval/electronic_approval_list?type=<?php echo $type;?>";
         return false;
      }

      document.cform.action = "<?php echo site_url();?>/biz/approval/electronic_approval_list";
      document.cform.cur_page.value = "1";
      document.cform.submit();
    }

    function change_lpp(){
		var lpp = $("#listPerPage").val();
		document.cform.lpp.value = lpp;
		document.cform.submit();
	}

  function all_read() {
    if (confirm('?????? ?????? ?????? ???????????????????')) {
      $.ajax({
        type: "POST",
        cache: false,
        url: "<?php echo site_url(); ?>/biz/approval/all_read",
        dataType: "json",
        async: false,
        data: {
          type: '<?php echo substr($_GET['type'],0,1); ?>'
        },
        success: function(data) {
          alert('?????????????????????.');
          location.reload();
        }
      })
    }
  }

	function open_search() {
		$('#search_div').bPopup();
	}

	function keyword_replace(el) {
		$.ajax({
			type:'POST',
			cache: false,
			url: "<?php echo site_url(); ?>/biz/approval/keyword_replace",
			dataType: "json",
			async: false,
			data: {
				keyword: $(el).val(),
				category: $(el).attr('category'),
				page: '<?php echo $this->uri->segment(3); ?>'
			},
			success: function(data) {
				if(data) {
					if($(el).attr('category') == 'template_name') {
						var category = '?????????';
					}
					var txt = category + ' ?????? ???????????? ????????????.\n????????? : ' + $(el).val() + '\n?????? ????????? : ' + data.replace_keyword
										+ '\n?????? ???????????? ?????????????????????????';
					if (confirm(txt)) {
						$(el).val(data.replace_keyword);
					}
				}
			}
		})
	}

</script>
