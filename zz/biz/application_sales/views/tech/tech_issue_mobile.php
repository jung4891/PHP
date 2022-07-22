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
		/* white-space : nowrap; */
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

	/* Dropdown Button */
 .dropbtn {
	 font-size: 13px;
	 border: none;
	 cursor: pointer;
	 border-radius: 5px;
	 background-color: #eee;
	 margin: 0px 0px 0px 0px;
	 width: 50px;
	 display: inline-block;
	 text-align: center;
	 border: 4px solid #eee;
 }

 /* Dropdown button on hover & focus */
 .dropbtn:hover,
 .dropbtn:focus {
	 /* background-color: #3e8e41; */
 }

 /* The search field */
 .searchInput {
	 box-sizing: border-box;
	 background-position: 14px 12px;
	 background-repeat: no-repeat;
	 font-size: 16px;
	 padding: 14px 20px 12px 45px;
	 border: none;
	 border-bottom: 1px solid #ddd;
 }

 /* The search field when it gets focus/clicked on */
 .searchInput:focus {
	 outline: 3px solid #ddd;
 }

 /* The container <div> - needed to position the dropdown content */
 .dropdown {
	 position: relative;
	 display: inline-block;
 }

 /* Dropdown Content (Hidden by Default) */
 .dropdown-content {
	 display: none;
	 position: absolute;
	 background-color: #f6f6f6;
	 min-width: 230px;
	 border: 1px solid #ddd;
	 z-index: 1;
 }

 /* Links inside the dropdown */
 .dropdown-content a {
	 color: black;
	 padding: 12px 16px;
	 text-decoration: none;
	 display: block;
 }

 /* Change color of dropdown links on hover */
 .dropdown-content a:hover {
	 background-color: #f1f1f1
 }
 /* Show the dropdown menu (use JS to add this class to the .dropdown-content container when the user clicks on the dropdown button) */
 .show {
	 display: block;
 }
 /* 모달 css */
 .searchModal {
		display: none; /* Hidden by default */
		position: fixed; /* Stay in place */
		z-index: 10; /* Sit on top */
		left: 0;
		top: 0;
		width: 100%; /* Full width */
		height: 100%; /* Full height */
		overflow: auto; /* Enable scroll if needed */
		background-color: rgb(0,0,0); /* Fallback color */
		background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
		z-index: 1002;
 }
		/* Modal Content/Box */
 .search-modal-content {
		background-color: #fefefe;
		margin: 15% auto; /* 15% from the top and centered */
		padding: 20px;
		border: 1px solid #888;
		border-radius: 3px;
		width: 70%; /* Could be more or less, depending on screen size */
		z-index: 1002;
 }
 .list_tbl td {
	 border: none !important;
 }
	</style>
	<link rel="stylesheet" href="/misc/css/view_page_common.css">
  <script language="javascript">
	function GoSearch(){
		$('#searchkeyword').val($.trim($('#searchkeyword_input').val()));
  	$('#search1').val($('#search_select1').val());

		var searchkeyword = document.mform.searchkeyword.value;
		var searchkeyword = searchkeyword.trim();

		document.mform.action = "<?php echo site_url();?>/tech/tech_board/tech_issue";
		document.mform.cur_page.value = 1;
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
		document.mform.cur_page.value = total_page;
		document.mform.submit();
	}

	function ViewBoard (seq){
		document.mform.action = "<?php echo site_url();?>/biz/board/notice_view";
		document.mform.seq.value = seq;
		document.mform.mode.value = "view";

		document.mform.submit();
	}

	function moveList(page){
     location.href="<?php echo site_url();?>/tech/"+page;
  }

	function movePage(type){
		location.href = "<?php echo site_url();?>/tech/tech_board/tech_issue?type="+type;
	}
  </script>
	<?php
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_side.php";
	  include $this->input->server('DOCUMENT_ROOT')."/include/mobile_header.php";
  ?>
	<form name="mform" action="<?php echo site_url();?>/tech/tech_board/tech_issue" method="get" onKeyDown="if(event.keyCode==13) return GoSearch();">
		<input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
		<input type="hidden" name="type" value="<?php echo $type; ?>">
		<input type="hidden" name="searchkeyword" id="searchkeyword" value="<?php echo str_replace('"', '&uml;',$search_keyword); ?>" />
	 	<input type="hidden" name="search1" id="search1" value="<?php echo $search1; ?>" />

    <div class="menu_div">
   		<a class="menu_list" onclick ="moveList('maintain/maintain_list')" style='color:#B0B0B0'>유지보수</a>
   		<a class="menu_list" onclick ="moveList('board/network_map_list')" style='color:#B0B0B0'>구성도</a>
   		<a class="menu_list" onclick ="moveList('tech_board/tech_doc_list?type=Y')" style='color:#B0B0B0'>기술지원보고서</a>
   		<a class="menu_list" onclick ="moveList('tech_board/request_tech_support_list')" style='color:#B0B0B0'>기술지원요청</a>
   		<a class="menu_list" onclick ="moveList('tech_board/tech_issue')" style='color:#0575E6'>요청/이슈</a>
   	</div>

    <div class="menu_div">
   		<a class="menu_list" onclick ="movePage('request')" style='font-size:20px;color:<?php if($type == "request"){echo "#0575E6";}else{echo "#B0B0B0";}?>'>요청사항</a>
   		<a class="menu_list" onclick ="movePage('issue')" style='font-size:20px;color:<?php if($type == "issue"){echo "#0575E6";}else{echo "#B0B0B0";}?>'>이슈</a>
   		<a class="menu_list" onclick ="movePage('incompletion')" style='font-size:20px;color:<?php if($type == "incompletion"){echo "#0575E6";}else{echo "#B0B0B0";}?>'>미완료</a>
   	</div>

	<div class="content_list">
		<table class="approval_list_tbl" width="100%" border="0" cellspacing="0" cellpadding="0">
			<colgroup>
				<col width="85%">
				<col width="15%">
			</colgroup>
			<tbody>
				<?php
						$i = $count - $no_page_list * ( $cur_page - 1 );

						$icounter = $i-$no_page_list;
						if($icounter <= 0){
							$icounter = 0;
						}

						for($i = $i; $i>$icounter; $i--){
							$item = $view_val[$i-1];
				?>
	<?php if ($type != "incompletion"){ ?>
				<tr onclick="modifyModal(<?php echo $item['seq']; ?>);" >
					<td align="left" style="color:#A1A1A1;"><?php echo $item['customer_companyname'];?></td>
					<td align="right" style="color:#A1A1A1;"><?php echo $item['user_name']; ?></td>
				</tr>
				<tr onclick="modifyModal(<?php echo $item['seq']; ?>);" >
					<td align="left" style="color:#1C1C1C;font-weight:bold;"><?php echo $item['contents']; ?></td>
					<td align="right" style="color:#1C1C1C;font-weight:bold;">
						<?php
						if($item['result'] == "N"){
							echo "미완료";
						}else{
							echo "완료";
						}?>
					</td>
				</tr>
				<tr><td height="1" colspan="2" bgcolor="#EFEFEF"></td></tr>
<?php } else { ?>
				<tr onclick="ViewBoard('<?php echo $item['seq'];?>')">
					<td align="left" style="color:#A1A1A1;"><?php echo $item['customer']; ?></td>
					<td align="right" style="color:#A1A1A1;"><?php echo $item['writer']; ?></td>
				</tr>
				<tr onclick="ViewBoard('<?php echo $item['seq'];?>')">
					<td align="left" colspan="2" style="color:#1C1C1C;font-weight:bold;"><?php echo $this->common->trim_text(stripslashes($item['subject']), 100); ?></td>
				</tr>
				<tr><td height="1" colspan="2" bgcolor="#EFEFEF"></td></tr>
<?php } ?>
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
						<?php if ($type != "incompletion") {?>
						<select class="select-common" name="search1" id="search_select1" style="margin-right:10px;color:black;width:92%;">
							<option value="001" <?php if($search1 == "001"){ echo "selected";}?>>고객사</option>
							<option value="002" <?php if($search1 == "002"){ echo "selected";}?>>내용</option>
							<option value="003" <?php if($search1 == "003"){ echo "selected";}?>>등록자</option>
						</select>
						<?php }else{ ?>
						<select name="search1" id="search_select1" class="select-common" style="margin-right:10px;color:black;width:92%;">
							<option value="001" <?php if($search1 == "001"){ echo "selected";}?>>고객사</option>
							<option value="002" <?php if($search1 == "002"){ echo "selected";}?>>작업명</option>
							<option value="003" <?php if($search1 == "003"){ echo "selected";}?>>작성자</option>
							<option value="004" <?php if($search1 == "004"){ echo "selected";}?>>작성일</option>
							<option value="005" <?php if($search1 == "005"){ echo "selected";}?>>결과</option>
							<option value="006" <?php if($search1 == "006"){ echo "selected";}?>>장비명</option>
						</select>
						<?php } ?>
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
<?php if ($type!="incompletion"){?>
	<div style="width:90%;margin:0 auto;margin-bottom:10px;">
		<input style="width:100%" type="button" class="btn-common btn-color2" value="글쓰기" onclick="$('#insert_modal').show();">
	</div>
<?php } ?>
	<div style="width:90%;padding-left:10px;padding-bottom:60px;">
		<span style="color:red;margin-right:5px;">*</span><?php echo $title; ?> 검색 시 우측 하단에 검색 아이콘을 눌러주세요.
	</div>

	<!-- 수정 모달 -->
	<div id="modify_modal" class="searchModal">
		<div class="search-modal-content" style='height:auto;min-height:300px;overflow: auto;'>
			<h2>보기/수정</h2>
			<div style="margin-top:30px;height:auto;min-height:200px;">
				<table class="list_tbl" style="width:100%;" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td style="font-weight:bold;font-size:14px;">고객사</td>
					</tr>
					<tr>
						<td>
							<input type="hidden" id="seq" value=""/>
							<input type="text" class="input-common" id="customer_companyname" style="width:95%">
						</td>
					</tr>
					<tr>
						<td style="font-weight:bold;font-size:14px;">요청사항</td>
					</tr>
					<tr>
						<td>
							<textarea id="contents" row=3 class="textarea-common" style="width:95%;"></textarea>
						</td>
					</tr>
					<tr>
						<td style="font-weight:bold;font-size:14px;">진행상황</td>
					</tr>
					<tr>
						<td>
							<select id="result" class="select-common" style="width:100%;">
								<option value="N">미완료</option>
								<option value="Y">완료</option>
							</select>
						</td>
					</tr>
					<tr>
						<td style="font-weight:bold;font-size:14px;">코멘트</td>
					</tr>
					<tr>
						<td>
							<input type="text" id="comment" class="input-common" style="width:95%;">
						</td>
					</tr>
					<tr>
						<td style="height:10px;border:none;"></td>
					</tr>
					<tr>
						<td style="border:none;">
							<input style="width:48%; float:left;" type="button" class="btn-common btn-color1" value="취소" onClick="closeModal();">
							<input style="width:48%; float:right;" type="button" class="btn-common btn-color2" value="저장" onClick="save();">
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>

	<!-- 등록모달 -->
	<div id="insert_modal" class="searchModal">
		<div class="search-modal-content" style='height:auto;min-height:300px;overflow: auto;'>
			<h2>
			<?php
			if($type=="request"){
				echo "요청사항";
			}else{
				echo "이슈";
			}?>
			등록</h2>
			<div style="margin-top:30px;height:auto;min-height:200px;">
				<table class="list_tbl" style="width:100%;" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td style="font-weight:bold;font-size:14px;">고객사</td>
					</tr>
					<tr>
						<td>
							<input type="text" class="input-common" id="insert_customer_companyname" onclick="searchFunction(this.id)" style="width:95%">
							<div id="myDropdown" class="dropdown-content">
								<input type="text" name="0" placeholder="고객사를 입력하세요" id="searchInput" class="searchInput" onkeyup="filterFunction(this)" ;>
								<div id="dropdown_option" style="overflow:scroll; width:270px; height:300px;">
								<?php
								foreach ($customer as $val) {
									if (strtotime(date("Y-m-d")) > strtotime(date($val['maintain_end']))) {
									echo '<a style="color:red;" ';
									echo 'onclick ="clickCustomerName(this,' . strtotime(date($val['maintain_end'])) . ','.$val['maintain_seq'].','.$val['forcasting_seq'].')" >' . $val['customer'].' - '.addslashes($val['project_name']).'</a>';
									} else {
									echo '<a ';
									echo 'onclick ="clickCustomerName(this,' . strtotime(date($val['maintain_end'])) . ','.$val['maintain_seq'].','.$val['forcasting_seq'].')" >'. $val['customer'].' - '.addslashes($val['project_name']).'</a>';
									}
								}
								?>
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td style="font-weight:bold;font-size:14px;">요청사항</td>
					</tr>
					<tr>
						<td><textarea id="insert_contents" class="textarea-common" row=3 style="width:95%;"></textarea></td>
					</tr>
					<tr>
						<td style="font-weight:bold;font-size:14px;">코멘트</td>
					</tr>
					<tr>
						<td><input type="text" id="insert_comment" class="input-common" style="width:95%"></td>
					</tr>
					<tr>
						<td style="height:10px;border:none;"></td>
					</tr>
					<tr>
						<td style="border:none;">
							<input style="width:48%; float:left;" type="button" class="btn-common btn-color1" value="취소" onClick="closeModal();">
							<input style="width:48%; float:right;" type="button" class="btn-common btn-color2" value="저장" onClick="insert_save();">
						</td>
					</tr>
				</table>
			</div>
			<div style="width:100%;">
			</div>
		</div>
	</div>
	<?php include $this->input->server('DOCUMENT_ROOT')."/include/mobile_bottom.php"; ?>
  <script language="javascript">
	//모달 띄울 때
	function modifyModal(seq){
				$.ajax({
					 type: "POST",
					 cache: false,
					 url: "<?php echo site_url(); ?>/tech/tech_board/select_tech_issue",
			 dataType: "json",
					 async :false,
					 data: {
							seq:seq,
				type:'<?php echo $type; ?>'
					 },
					 success: function (data) {
							if(data){
					$("#seq").val(data.seq)
					$("#customer_companyname").val(data.customer_companyname);
					$("#contents").val(data.contents);
					$("#result").val(data.result);
					$("#comment").val(data.comment);
					$("#modify_modal").show();
				}
					 }
				});
	}

	//모달닫앙
	function closeModal(){
		$(".searchModal").hide();
	}

	//모달에서 수정한거 저장해
	function save(){
		$.ajax({
			type: "POST",
			cache: false,
			url: "<?php echo site_url(); ?>/tech/tech_board/modify_tech_issue",
			dataType: "json",
			async :false,
			data: {
				type:'<?php echo $type; ?>',
				seq:$("#seq").val(),
				customer_companyname:$("#customer_companyname").val(),
				contents:$("#contents").val(),
				result:$("#result").val(),
				comment:$("#comment").val(),
			},
			success: function (data) {
				if(data){
					alert("수정되었습니다.");
					location.reload();
				}else{
					alert("수정에 실패하였습니다.")
				}
			}
		});
	}

	//등록모달 저장해!!!!
	function insert_save(){
		$.ajax({
			type: "POST",
			cache: false,
			url: "<?php echo site_url(); ?>/tech/tech_board/insert_tech_issue",
			dataType: "json",
			async :false,
			data: {
				type:'<?php echo $type; ?>',
				customer_companyname:$("#insert_customer_companyname").val(),
				contents:$("#insert_contents").val(),
				comment:$("#insert_comment").val(),
			},
			success: function (data) {
				if(data){
					alert("등록되었습니다.");
					location.reload();
				}else{
					alert("등록에 실패하였습니다.")
				}
			}
		});
	}

	// 고객사 검색
	function searchFunction(id) {
		var myDropdown = $("#" + id).parent().find('div').attr('id');
		$("#myDropdown").toggle();
		$(".searchInput").focus();
	}

	//고객사 선택
	function clickCustomerName(customerName, maintainEnd, seq , forcasting_seq) {
			var customerCompanyName = ($(customerName).text()).split(' - ')[0];
			var projectName = ($(customerName).text()).split(' - ')[1];
			$("#insert_customer_companyname").val(customerCompanyName);
			$("#myDropdown").toggle();
	}

	//고객사 입력 검색
	function filterFunction(customerName) {
	  var input, filter, ul, li, a, i;
	  input = document.getElementById(customerName.id);
	  filter = input.value.toUpperCase();
	  myDropDown = $(customerName).parent().attr('id');
	  div = document.getElementById(myDropDown);
	  a = div.getElementsByTagName("a");
	  for (i = 0; i < a.length; i++) {
	    txtValue = a[i].textContent || a[i].innerText;
	    if (txtValue.toUpperCase().indexOf(filter) > -1) {
	      a[i].style.display = "";
	    } else {
	      a[i].style.display = "none";
	    }
	  }
	}

	// 외부영역 클릭 시 팝업 닫기
	$(document).mouseup(function (e){
	var LayerPopup = $("#dropdown");
	if(LayerPopup.has(e.target).length === 0){
		$("#myDropdown").hide();
	}
	});

	function ViewBoard (seq){
		location.href = "<?php echo site_url();?>/tech/tech_board/tech_doc_view?mode=view&type=Y&seq="+seq;
	}

	$('.menu_div').scrollLeft(100);
  </script>
</body>
