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
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" /> <!-- 조직도 생성 -->
	<link rel="stylesheet" href="/misc/css/tech_schedule/proton/style.min.css" /> <!-- 조직도 생성 -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
	<?php
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_side.php";
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_header.php";
  ?>
	<form name="mform" action="<?php echo site_url();?>/admin/equipment/car_list" method="get" onkeydown="if(event.keyCode==13) return GoSearch();">
		<input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
		<input type="hidden" name="seq" value="">
		<input type="hidden" name="mode" value="">

    <div class="menu_div">
		 	<a class="menu_list" onclick ="moveList('car_list')" style='color:#0575E6'>차량관리</a>
   		<a class="menu_list" onclick ="moveList('meeting_room_list')" style='color:#B0B0B0'>회의실관리</a>
   	</div>

	<div class="content_list">
		<table class="approval_list_tbl" width="100%" border="0" cellspacing="0" cellpadding="0">
			<colgroup>
				<col width="50%">
				<col width="50%">
			</colgroup>
			<tbody>
<?php foreach ($list_val as $item) { ?>
				<tr onclick="ViewBoard('<?php echo $item['seq'];?>')">
					<td align="left" style="color:#A1A1A1;"><?php echo $item['number']; ?></td>
					<td align="right" style="color:#A1A1A1;"><?php echo substr($item['insert_date'],0,10); ?></td>
				</tr>
				<tr onclick="ViewBoard('<?php echo $item['seq'];?>')">
					<td align="left" style="color:#1C1C1C;font-weight:bold;"><?php echo $item['type']; ?></td>
					<td align="right" style="color:#1C1C1C;font-weight:bold;"><?php echo $item['user_name']; ?></td>
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
		<input class="btn-common btn-color2" type="button" onclick="open_car_input();" value="등록" style="width:100%;">
	<?php } ?>
</div>
<!-- 입력 모달 -->
<div id="car_input" style="display:none; position: absolute; background-color: white; width: 300px; height: 340px; border-radius:5px;">
<!-- <div id="car_input" style="display:none; position: absolute; background-color: white; width: auto; height: auto;"> -->
	<form name="cform" action="<?php echo site_url();?>/admin/equipment/car_input_action" method="post" onSubmit="javascript:chkForm();return false;">
		<table style="margin:10px 30px; border-collapse: separate; border-spacing: 0;">
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
				<td align="left" valign="center" style="font-weight:bold;">차종</td>
			</tr>
			<tr>
				<td align="left">
					<input type="text" class="input-common" name="type" id="type" value="" style="width:100%;">
				</td>
			</tr>
			<tr>
				<td align="left" valign="center" style="font-weight:bold;">차량번호</td>
			</tr>
			<tr>
				<td align="left">
					<input type="text" class="input-common" name="number" id="number" value="" style="width:100%">
				</td>
			</tr>
			<tr>
				<td align="left" valign="center" style="font-weight:bold;">지정</td>
			</tr>
			<tr>
				<td align="left">
					<input type="radio" name="chk_info" value="public" id="public" checked>공용
					<input type="radio" name="chk_info" value="individual" id="individual">개인
				</td>
			</tr>
			<tr class="appointed_tr" style="display:none;">
				<td align="left" valign="center" style="font-weight:bold;">사용자</td>
			</tr>
			<tr class="appointed_tr" style="display:none;">
				<td align="left">
					<input type="text" id="appointed" class="input-common" name="user_name" value="" onclick="$('#searchAddUserpopup').bPopup({follow:[false,false]});" style="width:100%;" autocomplete="off" readonly>
					<input type="hidden" id="appointed_seq" class="input2" name="user_seq" id="user" value="" onclick="$('#searchAddUserpopup').bPopup();" style="width:95%;display:none;">
				</td>
			</tr>
			<tr>
				<td height="20"></td>
			</tr>
			<tr>
				<td align="right">
					<input type="button" class="btn-common btn-color1" style="width:47%;float:left;" value="취소" onclick="$('#car_input').bPopup().close();">
					<input type="button" class="btn-common btn-color2" style="width:47%;float:right" value="등록" onclick="javascript:chkForm();return false;">
				</td>
			</tr>
		</table>
	</form>
</div>

<!-- 지정 사용자 모달 -->
<div id="searchAddUserpopup" style="display:none; background-color: white; width: auto; height: auto;">
	<span id="searchAddUserpopupCloseBtn" class="btn" onclick="searchCloseBtn()" style="margin:0% 0% 0% 96%; color:white;">X</span>
	<div id="search-modal-body">
		<div id="search-modal-grouptree" style="width:300px">
			<div id="search-usertree">
				<ul>
					<li>(주)두리안정보기술
						<ul>
						<?php
						foreach ($parentGroup as $pg){
						?>

						<?php
						if ($pg->childGroupNum==1 && $pg->depth==1){
						?>
							<li>
								<?php echo $pg->parentGroupName;
									foreach ($userInfo as $ui){
											if ($pg->groupName==$ui->user_group){
								?>
								<ul>
									<li id="<?php echo $ui->user_name; ?>"><?php echo $ui->user_name." ".$ui->user_duty.'<div style="display:none;">'.$ui->seq.'</div>'; ?></li>
								</ul>
								<?php
											}
									}
								?>
							</li>
							<?php
							} else if ($pg->childGroupNum>1 && $pg->depth==1){
							?>
							<li>
							<?php echo $pg->parentGroupName;
							foreach ($user_group as $ug) {
								if ($pg->parentGroupName==$ug->parentGroupName){
							?>
								<ul>
									<?php
									foreach ($userDepth as $ud){
											if ($ug->groupName == $ud->groupName){
												echo '<li id="'.$ud->user_name.'">'.$ud->user_name." ".$ud->user_duty.'<div style="display:none;">'.$ud->seq.'</div></li>';
											}
									}
									if ($ug->groupName != $pg->groupName){
										echo "<li>".$ug->groupName;
									}
									?>
										<ul>
										<?php
											foreach($userInfo as $ui) {
												if ($ug->groupName==$ui->user_group){
													echo '<li id="'.$ui->user_name.'">'.$ui->user_name." ".$ui->user_duty.'<div style="display:none;">'.$ui->seq.'</div></li>';
												}
											}
										?>
										</ul>
									</li>
								</ul>
							<?php
								}
							}
							?>
							</li>
							<?php
							}
							?>
						<?php
						}
						?>
						</ul>
					</li>
				</ul>
			</div>
		</div>
		<div id="search-btnDiv" style="float:right;">
			<input type="button" class="btn-common btn-color2" value="등록" width="54" height="25" onclick="addUser(this.id)" id="searchChosenBtn">
		</div>
	</div>
</div>
		<!-- 지정 사용자 모달 -->
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
  	document.mform.action = "<?php echo site_url();?>/admin/equipment/car_view";
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
	<script>
	$("input[name='chk_info']:radio").change(function () {
		if(this.value == "public"){
			$("#car_input").css('height','340px');
			$(".appointed_tr").hide();
			$('#appointed_seq').val('');
			// $("#appointed").hide();
		} else if (this.value == "individual") {
			$("#car_input").css('height','380px');
			$(".appointed_tr").show();
			// $("#appointed").show();
		}
	});

	function open_car_input(){
		$('#car_input').bPopup({follow:[false,false]});
		$("#car_input").css('height','340px');
		$(".appointed_tr").hide();
		$("input:radio[id='public']").prop('checked', true);
		$("#type").val('');
		$("#number").val('');
		$("#appointed").val('');
		$('#appointed_seq').val('');
	}

	function searchAddUserBtn(){
	 // $('#searchAddUserpopup').bPopup({follow:[false,false]});
	 $('#searchAddUserpopup').bPopup({follow:[false,false]});
	}
	// 지정 조직도 트리 생성
	var checked_text_select = [];
	var checked_seq_select = [];
	$(function() {
	  $('#search-usertree').jstree({
	    "checkbox" : {
	      "keep_selected_style" : false
	    },
	    'plugins': ["wholerow", "checkbox"],
	    'core' : {
	      'themes' : {
	        'name': 'proton',
	        'icons' : false
	      }
	    }
	  });
	  $("#search-usertree").bind("changed.jstree", function (e, data) {
	    var reg = /^[가-힣]*$/;
	    checked_text_select.length = 0;
	    checked_seq_select.length = 0;
	    $.each($("#search-usertree").jstree("get_checked",true),function() {
	      if (reg.test(this.id)) {
					var text = this.text.split('<div style="display:none;">');
					text2 = text[0];
					var seq = text[1].replace('</div>','');
	        checked_text_select.push(text2);
	        checked_seq_select.push(seq);
					// console.log(checked_text_select);
					// console.log(checked_seq_select);
	      }
	    })
	  });
	});

	function unique(array) {
	  var result = [];
	  $.each(array, function(index, element) {
	    if ($.inArray(element, result) == -1) {
	      result.push(element);
	    }
	  });
	  return result;
	}

	// 사용자 추가
	function addUser(){
	    var noneOverlapArr = unique(checked_text_select);

	    var searchName ='';
	    var searchNameArr = [];
	    //직급 제거하기
	    $.each(noneOverlapArr,function() {
	      searchName = $(this)[0];
	      searchName = searchName.split(' ')[0];
	      searchNameArr.push(searchName)
	    })
	    var searchAdduser = searchNameArr.join(",");
	    $('#appointed').val('');
	    $('#appointed').val(searchAdduser);
	    $('#appointed_seq').val('');
	    $('#appointed_seq').val(checked_seq_select);
	    $('#searchAddUserpopup').bPopup().close(); //모달 닫기
	}

	function chkForm () {
		var mform = document.cform;

		if (mform.type.value == "") {
			mform.type.focus();
			alert("차종을 입력해 주세요.");
			return false;
		}
		if (mform.number.value == "") {
			mform.number.focus();
			alert("차량번호를 입력해 주세요.");
			return false;
		}
		if($("input:radio[id='public']").is(":checked")==true){
			mform.user_name.value = "공용";
		}
		if($("input:radio[id='individual']").is(":checked")==true && mform.user_name.value == ""){
			alert("사용자를 지정해 주세요.");
			mform.user_name.click();
			return false;
		}

		mform.submit();
		return false;
	}
	</script>
</body>
