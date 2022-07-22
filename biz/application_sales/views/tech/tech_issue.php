<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/base.php";
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_top.php";
?>
<link rel="stylesheet" href="<?php echo $misc; ?>css/view_page_common.css">
<style>
   .basic_table{
      border-collapse:collapse;
      border:1px solid;
      border-color:#d7d7d7;
   }

   .basic_table td{
      padding:0px 10px 0px 10px;
      border:1px solid;
      border-color:#d7d7d7;
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
</style>
<script language="javascript">
	function GoSearch(){
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
</script>

<body>
<?php
	include $this->input->server('DOCUMENT_ROOT')."/include/sales_header.php";
?>
<div align="center">
<div class="dash1-1">
<table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" class="dash_tbl1-1">
<form name="mform" action="<?php echo site_url();?>/tech/tech_board/tech_issue" method="get" onKeyDown="if(event.keyCode==13) return GoSearch();">
<input type="hidden" name="cur_page" value="<?php echo $cur_page; ?>">
<input type="hidden" name="type" value="<?php echo $type; ?>">
<tbody height="100%">
	<tr height="5%">
		<td class="dash_title">
			<div class="main_title">
				<?php if(isset($_GET['type'])){$type = $_GET['type'];}else{$type="request";} ?>
				<a onclick ="moveList('request')" style='cursor:pointer;margin-right:10px;color:<?php if($type == "request"){echo "#1C1C1C";}else{echo "#DEDEDE;font-weight:normal;";}?>'>요청사항</a>
				<a onclick ="moveList('issue')" style='cursor:pointer;margin-right:10px;color:<?php if($type == "issue"){echo "#1C1C1C";}else{echo "#DEDEDE;font-weight:normal;";}?>'>이슈</a>
				<a onclick ="moveList('bug')" style='cursor:pointer;margin-right:10px;color:<?php if($type == "bug"){echo "#1C1C1C";}else{echo "#DEDEDE;font-weight:normal;";}?>'>버그</a>
				<a onclick ="moveList('incompletion')" style='cursor:pointer;margin-right:10px;color:<?php if($type == "incompletion"){echo "#1C1C1C";}else{echo "#DEDEDE;font-weight:normal;";}?>'>미완료</a>
			</div>
		</td>
	</tr>
<!-- 검색창 -->
<tr height="10%">
	<td align="left" valign="bottom">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:70px;">
		<tr>
			<td>
			<?php if ($type != "incompletion") {?>
				<select name="search1" id="search1" class="select-common select-style1" style="margin-right:10px;">
					<option value="001" <?php if($search1 == "001"){ echo "selected";}?>>고객사</option>
					<option value="002" <?php if($search1 == "002"){ echo "selected";}?>>내용</option>
					<option value="003" <?php if($search1 == "003"){ echo "selected";}?>>등록자</option>
				</select>
			<?php }else{ ?>
				<select name="search1" id="search1" class="select-common select-style1" style="margin-right:10px;" onChange="change();">
					<option value="001" <?php if($search1 == "001"){ echo "selected";}?>>고객사</option>
					<option value="002" <?php if($search1 == "002"){ echo "selected";}?>>작업명</option>
					<option value="003" <?php if($search1 == "003"){ echo "selected";}?>>작성자</option>
					<option value="004" <?php if($search1 == "004"){ echo "selected";}?>>작성일</option>
					<option value="005" <?php if($search1 == "005"){ echo "selected";}?>>결과</option>
					<option value="006" <?php if($search1 == "006"){ echo "selected";}?>>장비명</option>
				</select>
			<?php } ?>
			<span><input  type="text" size="25" class="input-common" name="searchkeyword" placeholder="검색하세요." value="<?php echo str_replace('"', '&uml;', $search_keyword );?>" style="margin-right:10px;"/></span>
			<span>
				<input type="button" class="btn-common btn-style2" value="검색" onClick="return GoSearch();">
			</span>
		</td>
		<?php if ($type!="incompletion"){?>
		<td align="right">
			<input type="button" class="btn-common btn-color2" value="글쓰기" onclick="$('#insert_modal').show();">
		</td>
		<?php }?>
		</tr>
	</table>
</td>
</tr>

<!-- 콘텐트 시작 -->
<tr height="45%">
<td valign="top" style="padding:10px 0px;">
	<table class="content_dash_tbl" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center" valign="top">
              <tr>
                <td>
				<table class="list_tbl" style="margin-top:20px;" width="100%" border="0" cellspacing="0" cellpadding="0">
					<?php if($type != "incompletion"){?>
					<colgroup>
	                  <col width="10%">
	                  <col width="10%">
	                  <col width="10%">
	                  <col width="30%">
	                  <col width="5%">
	                  <col width="5%">
					  <col width="10%">
					  <col width="10%">
	                  <col width="10%">
	                </colgroup>
                  <tr class="t_top row-color1">
					<th></th>
                    <th height="40" align="center">NO</th>
					<th align="center">고객사</th>
                    <th align="center">
					<?php if ($type=="request"){
							echo "요청사항" ;
						}else if($type == "issue"){
							echo "이슈";
						}else if($type == 'bug') {
							echo '버그';
						}
					?>
					</th>
					<th align="center">진행상황</th>
                    <th align="center">등록자</th>
                    <th align="center">등록날짜</th>
					<th align="center"></th>
					<th></th>
				  </tr>
				  <?php }else{?>
					<colgroup>
						<col width="5%">
						<col width="5%">
						<col width="15%">
						<col width="35%">
						<col width="10%">
						<col width="10%">
						<col width="10%">
						<col width="5%">
						<col width="5%">
					</colgroup>

					<tr class="t_top row-color1">
						<th></th>
						<th height="40" align="center">NO</th>
						<th align="center">고객사</th>
						<th align="center">작업명</th>
						<th align="center">작성자</th>
						<th align="center">작성일</th>
						<th align="center">결과</th>
						<th align="center">첨부</th>
						<th></th>
					</tr>
				  <?php } ?>
			<?php
				if ($count > 0) {
					$i = $count - $no_page_list * ( $cur_page - 1 );

					$icounter = $i-$no_page_list;
					if($icounter <= 0){
						$icounter = 0;
					}

					for($i = $i; $i>$icounter; $i--){
						$item = $view_val[$i-1];
			?>
				<?php if ($type != "incompletion"){ ?>
                  <tr onMouseOver="this.style.backgroundColor='#FAFAFA'" onMouseOut="this.style.backgroundColor='#fff'">
						<td></td>
						<td height="40" align="center"><?php echo $i;?></td>
						<td style="padding-left:10px;cursor:pointer;" align="center" onclick="modifyModal(<?php echo $item['seq']; ?>);" ><?php echo $item['customer_companyname'];?></td>
						<td style="padding-left:10px;" align="center">
							<?php echo $item['contents']; ?>
						</td>
						<td style="padding-left:10px;" align="center">
						<?php
						if($item['result'] == "N"){
							echo "미완료";
						}else{
							echo "완료";
						}?>
						</td>
						<td align="center"><?php echo $item['user_name'];?></td>
						<td align="center"><?php echo substr($item['insert_date'], 0, 10);?></td>
						<td align="center" style="cursor:pointer" <?php if($item['tech_doc_seq'] != ""){echo "onclick='ViewBoard({$item['tech_doc_seq']})'";} ?> ><?php if($item['tech_doc_seq'] != ""){echo "기술지원보고서 보기";}else{} ?></td>
						<td></td>
                  </tr>
				<?php }else {
						if($item['file_changename']) {
							$strFile = "<img src='".$misc."img/add.png' width='20' height='20' />";
						} else {
							$strFile = "-";
						}?>
						<tr onMouseOver="this.style.backgroundColor='#EAEAEA'" onMouseOut="this.style.backgroundColor='#fff'">
									<td></td>
									<td height="40" align="center">
										<!-- <input type="checkbox" name="<?php echo $item['customer'];?>" value="<?php echo '/'.$item['seq'].'-'.$item['customer_manager'].':'.$item['manager_mail'];?>*" <?php if($checkSeq <> ""){if(in_array($item['seq'],$checkSeq)){echo "checked";};}?> > -->
										<?php echo $i;?></td>

									<td align="center">
										<a href="JavaScript:ViewBoard('<?php echo $item['seq'];?>')">
											<?php echo $item['customer'];?>
										</a>
									</td>
									<td align="center">
											<?php echo $item['subject'];?>
									</td>
									<td align="center">
											<?php echo $item['writer'];?>
									</td>
									<td align="center">
											<?php echo substr($item['income_time'], 0, 10);?>
									</td>
									<td align="center">
											<?php echo $item['result'];?>
									</td>
									<td align="center">
											<?php echo $strFile;?>
									</td>
									<td></td>
								</tr>
				<?php }?>
			<?php
					}
				} else {
			?>
				<tr onMouseOver="this.style.backgroundColor='#FAFAFA'" onMouseOut="this.style.backgroundColor='#fff'">
                    <td width="100%" height="40" align="center" colspan="7">등록된 게시물이 없습니다.</td>
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
		<!-- 컨텐트 끝 -->

		<!-- 페이징시작 -->
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
									<td width="19"><a href="JavaScript:GoFirstPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_last_left.svg" width="20" height="20"/></a></td>
									<td width="2"></td>
									<td width="19"><a href="JavaScript:GoPrevPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_left.svg" width="20" height="20"/></a></td>
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
						<td width="19"><a href="JavaScript:GoNextPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_right.svg" width="20" height="20"/></a></td>
									<td width="2"></td>
									<td width="19"><a href="JavaScript:GoLastPage()"><img src="<?php echo $misc;?>img/dashboard/btn/btn_last_right.svg" width="20" height="20"/></a></td>
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
						<!-- 페이징 끝 -->

					</td>
				</tr>

<!-- 버튼 tr 시작 -->
			</table>
		</td>
		</tr>
		<!-- 페이징끝 -->
		<!-- 수정 모달 -->
		<tr>
			<td>
				<div id="modify_modal" class="searchModal">
					<div class="search-modal-content" style='height:auto;min-height:300px;overflow: auto;'>
						<h2>보기/수정</h2>
						<div style="margin-top:30px;height:auto;min-height:200px;overflow:auto;">
							<table class="list_tbl" style="width:100%;" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td class="tbl-title">고객사</td>
									<td class="tbl-cell">
										<input type="hidden" id="seq" value=""/>
										<input type="text" class="input-common" id="customer_companyname" >
									</td>
								</tr>
								<tr>
									<td class="tbl-title">요청사항</td>
									<td class="tbl-cell">
										<textarea id="contents" row=3 class="textarea-common" style="width:95%;"></textarea>
									</td>
								</tr>
								<tr>
									<td class="tbl-title">진행상황</td>
									<td class="tbl-cell">
										<select id="result" class="select-common" >
											<option value="N">미완료</option>
											<option value="Y">완료</option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="tbl-title">코멘트</td>
									<td class="tbl-cell">
										<input type="text" id="comment" class="input-common" >
									</td>
								</tr>
							</table>
						</div>
						<div style="float:right;">
							<input type="button" class="btn-common btn-color1" value="취소" onClick="closeModal();">
							<input type="button" class="btn-common btn-color2" value="저장" onClick="save();">
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
						}else if($type=="issue"){
							echo "이슈";
						}else if($type=="bug"){
							echo "버그";
						}?>
						등록</h2>
						<div style="margin-top:30px;height:auto;min-height:200px;">
							<table class="list_tbl" style="width:100%;" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td class="tbl-title">고객사</td>
									<td class="tbl-cell">
										<input type="text" class="input-common" id="insert_customer_companyname" onclick="searchFunction(this.id)" >
										<div id="myDropdown" class="dropdown-content">
											<input type="text" name="0" placeholder="고객사를 입력하세요" id="searchInput" class="searchInput" onkeyup="filterFunction(this)" ;>
											<div id="dropdown_option" style="overflow:scroll; width:277px; height:300px;">
											<?php
											foreach ($customer as $val) {
												if (strtotime(date("Y-m-d")) > strtotime(date($val['maintain_end']))) {
												echo '<a style="color:red;" ';
												echo 'onclick ="clickCustomerName(this,' . strtotime(date($val['maintain_end'])) . ','.$val['maintain_seq'].','.$val['forcasting_seq'].')" >'. $val['customer'].' - '.addslashes($val['project_name']).'</a>';
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
									<td class="tbl-title">요청사항</td><td class="tbl-cell"><textarea id="insert_contents" class="textarea-common" row=3 style="width:95%;"></textarea></td>
								</tr>
								<!-- <tr>
									<td  height=40 bgcolor="f8f8f9" align="center">진행상황</td>
									<td>
										<select id="insert_result" class="input2" >
											<option value="N">미완료</option>
											<option value="Y">완료</option>
										</select>
									</td>
								</tr> -->
								<tr>
									<td class="tbl-title">코멘트</td><td class="tbl-cell"><input type="text" id="insert_comment" class="input-common" ></td>
								</tr>
							</table>
						</div>
						<div style="float:right;">
							<input type="button" class="btn-common btn-color1" value="취소" onClick="closeModal();">
							<input type="button" class="btn-common btn-color2" value="저장" onClick="insert_save();">
						</div>
					</div>
				</div>
			</td>
		</tr>
	</tbody>
</form>
</table>
</div>
</div>
<script>
function moveList(type){
	location.href = "<?php echo site_url();?>/tech/tech_board/tech_issue?type="+type;
}

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

</script>
<?php include $this->input->server('DOCUMENT_ROOT')."/include/sales_bottom.php"; ?>
</body>
</html>
