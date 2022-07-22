<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
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
		height: 35px !important;
		border-radius: 3px !important;
	}
	.dayBtn {
		background:url(<?php echo $misc; ?>img/mobile/footer_schedule.svg) no-repeat 98% 50% #fff;
		background-size: 20px;
	}
	</style>
	<link rel="stylesheet" href="/misc/css/view_page_common.css">
	<style media="screen">
	.input-common, .select-common, .textarea-common {
		box-sizing: border-box;
		border-radius: 3px;
		width: 100%;
	}
	</style>
  <script language="javascript">
    function GoSearch(){
    $('#searchkeyword').val($.trim($('#searchkeyword_input').val()));
  	$('#search2').val($('#search_select2').val());

     var searchkeyword = document.mform.searchkeyword.value;
     var searchkeyword = searchkeyword.trim();

  document.mform.action = "<?php echo site_url();?>/admin/company/product_list";
  document.mform.cur_page.value = "";
  //	document.mform.search_keyword.value = searchkeyword;
  document.mform.submit();
  }

  </script>
	<?php
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_side.php";
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_header.php";
  ?>
	<form name="mform" action="<?php echo site_url();?>/admin/company/product_list" method="get" onkeydown="if(event.keyCode==13) return GoSearch();">
	<input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
	<input type="hidden" name="seq" value="">
	<input type="hidden" name="mode" value="">
      <input type="hidden" name="searchkeyword" id="searchkeyword" value="<?php echo str_replace('"', '&uml;',$search_keyword); ?>" />
 	   <input type="hidden" name="search2" id="search2" value="<?php echo $search2; ?>" />

	<div class="content_list">
		<table class="approval_list_tbl" width="100%" border="0" cellspacing="0" cellpadding="0">
			<colgroup>
				<col width="50%">
				<col width="50%">
			</colgroup>
			<tbody>
<?php foreach ($list_val as $item) { ?>
				<tr onclick="ViewBoard('<?php echo $item['seq'];?>')">
					<td align="left" style="color:#A1A1A1;"><?php echo $item['product_company']; ?></td>
					<td align="right" style="color:#A1A1A1;"><?php if(trim($item['product_item']) != ''){echo $item['product_item'];} else {echo '-';} ?></td>
				</tr>
				<tr onclick="ViewBoard('<?php echo $item['seq'];?>')">
					<td align="left" colspan="2" style="color:#1C1C1C;font-weight:bold;"><?php echo $item['product_name']; ?></td>
				</tr>
				<tr><td height="1" colspan="2" bgcolor="#EFEFEF"></td></tr>
<?php } ?>
<?php if($count == 0) { ?>
				<tr>
					<td colspan="2" align="center" height="40" style="font-weight:bold;">등록된 게시물이 없습니다.</td>
				</tr>
<?php } ?>
			</tbody>
		</table>

		<!-- 페이징 -->
		<table id="paging_tbl" cellspacing="0" cellpadding="0">
		  <!-- 페이징처리 -->
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
		  <!-- 페이징처리끝 -->
		</table>
	</div>

	<!-- 검색 모달 시작 -->
  <div id="search_div" style="height:auto;width:100%;background-color:#ffffff; display:none;border-radius:5px;">
    <div class="modal_contain" style="font-size:16px; color:#1C1C1C;font-weight:bold;">
      <table style="width:100%;padding:5%;" cellspacing="0">
				<colgroup>
					<col width="50%">
					<col width="50%">
				</colgroup>
				<tr>
      		<td align="left" height="40">
						<select class="select-common" name="search2" id="search_select2" style="margin-right:10px;color:black;width:92%;">
							<option value="001" <?php if($search2 == "001"){ echo "selected";}?>>제품명</option>
							<option value="002" <?php if($search2 == "002"){ echo "selected";}?>>제조사</option>
							<option value="003" <?php if($search2 == "003"){ echo "selected";}?>>품목</option>
						</select>
					</td>
      	</tr>
				<tr>
					<td colspan="2">
						<input type="text" id="searchkeyword_input" class="input-common" placeholder="검색하세요." value="<?php echo str_replace('"', '&uml;', $search_keyword );?>" style=";width:95%;" />
					</td>
				</tr>
				<tr>
          <td height="20"></td>
        </tr>
				<tr>
					<td>
						<input type="button" class="btn-common btn-color1" style="width:95%" value="취소" onclick="$('#search_div').bPopup().close();">
					</td>
					<td align="right">
						<input type="button" class="btn-common btn-color2" style="width:95%" value="검색" onclick="return GoSearch();">
					</td>
				</tr>
      </table>
    </div>
  </div>
	<!-- 검색 모달 끝 -->
</form>
<!-- 검색 모달 시작 -->
<div id="product_input" style="height:auto;width:100%;background-color:#ffffff; display:none;border-radius:5px;">
	<div class="modal_contain" style="font-size:16px; color:#1C1C1C;font-weight:bold;">
		<form name="cform" id="cform" action="<?php echo site_url();?>/admin/company/product_input_action" method="post" onSubmit="javascript:chkForm();return false;" enctype="multipart/form-data">
			<table style="width:100%;padding:5%;" cellspacing="0">
				<colgroup>
					<col width="50%">
					<col width="50%">
				</colgroup>
				<tr>
					<td align="left" height="40">제품명</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="text" id="product_name" name="product_name" value="" class="input-common">
					</td>
				</tr>
				<tr>
					<td align="left" height="40">하드웨어/소프트웨어</td>
				</tr>
				<tr>
					<td colspan="2">
						<select name="product_type" id="product_type" class="select-common" onChange="changekm();">
							<option value="" selected >하드웨어/소프트웨어</option>
							<option value="hardware">하드웨어</option>
							<option value="software">소프트웨어</option>
							<option value="appliance">어플라이언스</option>
						</select>
					</td>
				</tr>
				<tr>
					<td align="left" height="40">제조사</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="text" name="product_company" id="product_company" class="input-common">
					</td>
				</tr>
				<tr>
					<td align="left" height="40">품목</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="text" name="product_item" id="product_item" class="input-common">
					</td>
				</tr>
				<tr>
					<td align="left" height="40">하드웨어스펙</td>
				</tr>
				<tr>
					<td colspan="2">
						<textarea name="hardware_spec" id="hardware_spec" class="textarea-common" style="height:150px; resize:none;"></textarea>
					</td>
				</tr>
				<tr>
					<td height="20"></td>
				</tr>
				<tr>
					<td>
						<input type="button" class="btn-common btn-color1" style="width:95%" value="취소" onclick="$('#product_input').bPopup().close();">
					</td>
					<td align="right">
						<input type="button" class="btn-common btn-color2" style="width:95%" value="등록" onclick="javascript:chkForm();return false;">
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
<!-- 검색 모달 끝 -->
	<div style="width:90%;margin:0 auto;margin-bottom:10px;">
    <?php if($admin_lv > 0) { ?>
			<input style="width:100%" type="button" class="btn-common btn-color2" onclick="$('#product_input').bPopup();" value="추가">
    <?php } ?>
	</div>
	<div style="width:90%;padding-left:10px;padding-bottom:60px;">
		<span style="color:red;margin-right:5px;">*</span><?php echo $title; ?> 검색 시 우측 하단에 검색 아이콘을 눌러주세요.
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
  	document.mform.action = "<?php echo site_url();?>/admin/company/product_view";
  	document.mform.seq.value = seq;
  	document.mform.mode.value = "view";

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

	function chkForm () {
		var mform = document.cform;

		if (mform.product_name.value == "") {
			mform.product_name.focus();
			alert("제품명을 입력해 주세요.");
			return false;
	  }
	  if (mform.product_name.value.indexOf(',') != -1){
	    alert("제품명에 , 를 입력하실 수 없습니다.");
	    $("#product_name").focus();
	    return false;
	  }
	  if (mform.product_item.value.indexOf(',') != -1){
	    alert("품목에 , 를 입력하실 수 없습니다.");
	    $("#product_item").focus();
	    return false;
	  }
		if (mform.product_company.value == "") {
			mform.product_company.focus();
			alert("제조사를 입력해 주세요.");
			return false;
		}
		if (mform.product_item.value == "") {
			mform.product_item.focus();
			alert("품목을 입력해 주세요.");
			return false;
		}
		if (mform.hardware_spec.value == "") {
			mform.hardware_spec.focus();
			alert("하드웨어 스팩을 입력해 주세요.");
			return false;
		}
	  if (mform.product_type.value == "") {
			mform.hardware_spec.focus();
			alert("하드웨어/소프트웨어를 구분해 주세요.");
			return false;
		}

		mform.submit();
		return false;
	}
  </script>
</body>