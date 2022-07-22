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
  <script language="javascript">

  function moveList(page){
     location.href="<?php echo site_url();?>/admin/equipment/"+page;
  }
  </script>
	<?php
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_side.php";
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_header.php";
  ?>
	<form name="mform" action="<?php echo site_url();?>/admin/equipment/meeting_room_list" method="get" onkeydown="if(event.keyCode==13) return GoSearch();">
		<input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
		<input type="hidden" name="seq" value="">
		<input type="hidden" name="mode" value="">

     <div class="menu_div">
			 <a class="menu_list" onclick ="moveList('car_list')" style='color:#B0B0B0'>차량관리</a>
   		<a class="menu_list" onclick ="moveList('meeting_room_list')" style='color:#0575E6'>회의실관리</a>
   	</div>

	<div class="content_list">
		<table class="approval_list_tbl" width="100%" border="0" cellspacing="0" cellpadding="0">
			<colgroup>
				<col width="80%">
				<col width="20%">
			</colgroup>
			<tbody>
<?php foreach ($list_val as $item) { ?>
				<tr onclick="ViewBoard('<?php echo $item['seq'];?>')">
					<td align="left" style="color:#A1A1A1;"><?php echo $item['location']; ?></td>
					<td align="right" style="color:#A1A1A1;"><?php echo substr($item['insert_date'],0,10); ?></td>
				</tr>
				<tr onclick="ViewBoard('<?php echo $item['seq'];?>')">
					<td align="left" colspan="2" style="color:#1C1C1C;font-weight:bold;"><?php echo $item['room_name']; ?></td>
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
</form>
<div style="width:90%;margin:0 auto;margin-bottom:10px;padding-bottom:60px;">
	<?php if($admin_lv == "3") { ?>
		<input class="btn-common btn-color2" type="button" onclick="$('#meeting_room_input').bPopup({follow:[false,false]});" value="등록" style="width:100%;" >
	<?php } ?>
</div>
<!-- 제품 추가 모달 시작 -->
<div id="meeting_room_input" style="height:auto;width:100%;background-color:#ffffff; display:none;border-radius:5px;">
  <form name="cform" id="cform" action="<?php echo site_url();?>/admin/equipment/meeting_room_input_action" method="post" onSubmit="javascript:chkForm();return false;" enctype="multipart/form-data">
    <table style="width:90%;margin:0 auto;" cellspacing="0">
			<colgroup>
				<col width="100%">
			</colgroup>
			<tr>
				<td height="20"></td>
			</tr>
			<tr>
				<td height="20"></td>
			</tr>
			<tr>
				<td align="left" valign="center" style="font-weight:bold;">회의실 명</td>
			</tr>
      <tr>
				<td align="left">
					<input type="text" id="room_name" name="room_name" value="" class="input-common" style="width:100%;box-sizing:border-box;">
				</td>
      </tr>
			<tr>
				<td align="left" valign="center" style="font-weight:bold;">위치</td>
			</tr>
      <tr>
        <td align="left">
          <input type="text" name="location" id="location" class="input-common" style="width:100%;box-sizing:border-box;">
        </td>
      </tr>
			<tr>
				<td height="20"></td>
			</tr>
      <tr>
				<td>
					<!--지원내용 추가 버튼-->
					<input type="button" class="btn-common btn-color1" style="width:47%;float:left;" value="취소" onclick="$('#meeting_room_input').bPopup().close()">
					<input type="button" class="btn-common btn-color2" style="width:47%;float:right;" value="등록" onclick="javascript:chkForm();return false;">
        </td>
      </tr>
			<tr>
				<td height="20"></td>
			</tr>
    </table>
  </form>
</div>
<!-- 제품 추가 모달 끝  -->
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
  	document.mform.action = "<?php echo site_url();?>/admin/equipment/meeting_room_view";
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
  </script>
	<script type="text/javascript">
	function chkForm () {
		var mform = document.cform;

		if (mform.room_name.value == "") {
			mform.room_name.focus();
			alert("회의실 명을 입력해 주세요.");
			return false;
		}
		if (mform.location.value == "") {
			mform.location.focus();
			alert("위치를 입력해 주세요.");
			return false;
		}

		mform.submit();
		return false;
	}
	</script>
</body>
